<?php
/**
 * Curse Inc.
 * Hydralytics
 * Analytics Special Page
 *
 * @author		Alexia E. Smith, Cameron Chunn
 * @copyright	(c) 2018 Curse Inc.
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
 * @link		https://gitlab.com/hydrawiki
 *
 **/

namespace Hydralytics;

use DynamicSettings\Environment;

class SpecialAnalytics extends \SpecialPage {
	/**
	 * Output HTML
	 *
	 * @var		string
	 */
	private $content;

	/**
	 * Main Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct() {
		parent::__construct('Analytics', 'analytics');
	}

	/**
	 * Main Executor
	 *
	 * @access	public
	 * @param	string	Sub page passed in the URL.
	 * @return	void	[Outputs to screen]
	 */
	public function execute($subpage) {
		/*if (!$this->getUser()->isAllowed($this->getRestriction())) {
			throw new \PermissionsError($this->getRestriction());
		}*/

		$this->getOutput()->addModuleStyles(['ext.hydralytics.styles']);
		$this->getOutput()->addModules(['ext.hydralytics.scripts']);
		$this->setHeaders();

		if ($subpage == "usage") {
			$this->usagePage();
		} else {
			$this->analyticsPage();
		}

		$this->getOutput()->addHTML($this->content);
	}

	/**
	 * Display the analytics page.
	 *
	 * @access	private
	 * @return	void	[Outputs to screen]
	 */
	private function analyticsPage() {
		global $dsSiteKey;

		$wgCommunityManager = 'TODO Community Manager';

		$redisKey = $dsSiteKey.':analytics:output';

		$startTimestamp = time() - 2592000;
		$endTimestamp = time();

		$sections = [
			'top_viewed_pages' => '',
			'number_of_pageviews' => '',
			'number_of_visitors' => '',
			'top_editors' => '',
			'geolocation' => '',
			'most_visited_files' => '',
			'staff_contact' => '',
			'desktop_vs_mobile' => '',
			'browser_breakdown' => '',
			'active_editors' => '',
			'edits_per_day' => '',
			'logged_in_out' => '',
			'top_search_terms' => ''
		];

		$sectionsData = [];

		$redis = false; // TODO \RedisCache::getClient('cache');
		$recache = true;
		$ttl = 0;
		if ($redis !== false && !$this->getRequest()->getBool('debug')) {
			try {
				$_sections = unserialize($redis->get($redisKey), ['allowed_classes' => false]);
				if (is_array($_sections) && array_keys($_sections) === array_keys($sections)) {
					$sections = $_sections;
					$recache = false;
				}
			} catch (RedisException $e) {
				wfDebug(__METHOD__.' Caught RedisException - '.$e->getMessage());
			}
		}

		if ($recache) {
			try {
				/**
				 *  Browser Breakdown + Desktop vs Mobile
				 */
				$deviceBreakdown = Information::getDeviceBreakdown($startTimestamp, $endTimestamp);
				$sections['browser_breakdown'] = TemplateAnalytics::wrapSectionData('browser_breakdown', $deviceBreakdown['browser']);
				$sections['desktop_vs_mobile'] = TemplateAnalytics::wrapSectionData('desktop_vs_mobile', $deviceBreakdown['deviceCategory']);

				$monthlyTotals = Information::getMonthlyTotals($startTimestamp, $endTimestamp);
				$sections['number_of_visitors'] = TemplateAnalytics::wrapSectionData(
					'number_of_visitors',
					[
						'users' => $monthlyTotals['users'],
						'newUsers' => $monthlyTotals['newUsers'],
						'returningUsers' => ($monthlyTotals['users'] - $monthlyTotals['newUsers']),
						'total'	=> $this->getLanguage()->formatNum($monthlyTotals['users'])
					]
				);

				/**
				 *  Number Of Pageviews
				 */
				$dailyTotals = Information::getDailyTotals($startTimestamp, $endTimestamp);
				$totalViews = 0;
				$numberOfPageviews = [];
				if (isset($dailyTotals['pageviews'])) {
					foreach ($dailyTotals['pageviews'] as $date => $views) {
						$totalViews += $views;
						$numberOfPageviews[strtotime($date)] = $views;
					}
				}

				$sections['number_of_pageviews'] = TemplateAnalytics::wrapSectionData(
					'number_of_pageviews',
					[
						'per_day' => $numberOfPageviews,
						'total' => $this->getLanguage()->formatNum($totalViews)
					]
				);

				/**
				 *  Edit Per Day
				 */
				$dailyEdits = Information::getEditsPerDay();
				$sections['edits_per_day'] = TemplateAnalytics::wrapSectionData('edits_per_day', $dailyEdits);

				/**
				 *  Logged in vs Logged out Edits
				 */
				$loggedInOutEdits = Information::getEditsLoggedInOut();
				$sections['logged_in_out'] = TemplateAnalytics::wrapSectionData('logged_in_out', $loggedInOutEdits);

				/**
				 * Geolocation
				 */
				$geolocation = Information::getGeolocation($startTimestamp, $endTimestamp);
				$sections['geolocation'] = TemplateAnalytics::wrapSectionData('geolocation',$geolocation);
				arsort($geolocation['sessions']);
				if (isset($geolocation['sessions'])) {
					$sections['geolocation'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('location')->escaped()."</th>
								<th>".wfMessage('sessions')->escaped()."</th>
							</tr>
						</thead>
						<tbody>
						";
					foreach ($geolocation['sessions'] as $location => $sessions) {
						$sections['geolocation'] .= "
							<tr>
								<td>".$location."</td>
								<td>".$this->getLanguage()->formatNum($sessions)."</a></td>
							</tr>";
					}
					$sections['geolocation'] .= "
						</tbody>
					</table>";
				}

				/**
				 *  Top Viewed Pages
				 */
				$topPages = Information::getTopViewedPages($startTimestamp, $endTimestamp);
				if (isset($topPages['pageviews'])) {
					$sections['top_viewed_pages'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('views')->escaped()."</th>
								<th>".wfMessage('page')->escaped()."</th>
							</tr>
						</thead>
						<tbody>
						";
					foreach ($topPages['pageviews'] as $uri => $views) {
						$newUri = $this->normalizeUri($uri);
						$sections['top_viewed_pages'] .= "
							<tr>
								<td>".$this->getLanguage()->formatNum($views)."</td>
								<td><a href='".wfExpandUrl($newUri)."'>".substr(urldecode($newUri), 1)."</a></td>
							</tr>";
					}
					$sections['top_viewed_pages'] .= "
						</tbody>
					</table>";
				}

				/**
				 * Top Editors
				 */
				$topEditorsAllTime = Information::getTopEditors();
				if (count($topEditorsAllTime)) {
					$sections['top_editors'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('points')->escaped()."</th>
								<th>".wfMessage('user')->escaped()."</th>
							</tr>
						</thead>
						<tbody>
					";
					foreach ($topEditorsAllTime as $data) {
						$sections['top_editors'] .= "<tr><td>".$this->getLanguage()->formatNum($data['points'])."</td><td>".\Linker::link($data['user']['user-page'])."</td></tr>";
					}
					$sections['top_editors'] .= "
						</tbody>
					</table>".\Linker::link($this->getTitleFor('WikiPoints'), wfMessage('view_more')->escaped());
				}

				$topEditorsActive = Information::getTopEditors(true);
				if (count($topEditorsActive)) {
					$lastMonth = strtotime(date('Y-m-d', strtotime('First day of last month')).'T00:00:00+00:00');
					$sections['active_editors'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('points')->escaped()."</th>
								<th>".wfMessage('user')->escaped()."</th>
								<th>".wfMessage('active_month')->escaped()."</th>
							</tr>
						</thead>
						<tbody>";
					foreach ($topEditorsActive as $data) {
						if ($data['month'] >= $lastMonth) {
							$sections['active_editors'] .= "<tr><td>".$this->getLanguage()->formatNum($data['points'])."</td><td>".\Linker::link($data['user']->getUserPage())."</td><td>".gmdate('F Y', $data['month'])."</td></tr>";
						}
					}
					$sections['active_editors'] .= "
						</tbody>
					</table>".\Linker::link($this->getTitleFor('WikiPoints/monthly'), wfMessage('view_more')->escaped());
				}

				/**
				 * Top Files
				 */
				$topFiles = Information::getTopViewedFiles($startTimestamp, $endTimestamp);
				if (isset($topFiles['pageviews'])) {
					$sections['most_visited_files'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('views')->escaped()."</th>
								<th>".wfMessage('file')->escaped()."</th>
							</tr>
						</thead>
						<tbody>
						";
					foreach ($topFiles['pageviews'] as $uri => $views) {
						$newUri = $this->normalizeUri($uri);
						$uriText = explode("%3A", $newUri);
						array_shift($uriText);
						$uriText = implode(":", $uriText);
						$sections['most_visited_files'] .= "
							<tr>
								<td>".$this->getLanguage()->formatNum($views)."</td>
								<td> <a href='".wfExpandUrl($newUri)."'>".urldecode($uriText)."</a></td>
							</tr>";
					}
					$sections['most_visited_files'] .= "
						</tbody>
					</table>";
				}

				/**
				 *  Staff Contact / Help Links
				 */
				$managers = Information::getWikiManagers();
				$sections['staff_contact'] = "
				<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage("wiki_manager")->text()."</th>
							</tr>
						</thead>
						<tbody>";
				foreach ($managers as $manager) {
					$title = \Title::newFromText('User:'.$manager);
					$sections['staff_contact'] .= "<tr><td>".\Linker::link($title, $manager)."</td></tr>";
				}
				$sections['staff_contact'] .= "
				</table>";

				if ($wgCommunityManager) {
					$sections['staff_contact'] .= "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage("community_manager")->text()."</th>
							</tr>
						</thead>
						<tbody>
							<tr><td>".\Linker::link(\Title::newFromText("User:".$wgCommunityManager), $wgCommunityManager)."</td></tr>
						</tbody>
					</table>";
				}
				$sections['staff_contact'] .= "
				<table class=\"analytics_table\">
					<thead>
						<tr>
							<th>".wfMessage("help_links")->text()."</th>
						</tr>
					</thead>
					<tbody>
						<tr><td>".Information::getFaqLink()."</td></tr>
						<tr><td>".Information::getFeedbackLink()."</td></tr>
						<tr><td>".Information::getSlackLink()."</td></tr>
					</tbody>
				</table>";

				/**
				 * Top Search Terms
				 */

				$terms = Information::getTopSearchTerms();
				$sections['top_search_terms'] = "
				<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('rank')->escaped()."</th>
								<th>".wfMessage('search_term')->escaped()."</th>
							</tr>
						</thead>
						<tbody>";
				foreach ($terms as $term) {
					$sections['top_search_terms'] .= "<tr><td>".$this->getLanguage()->formatNum($term[0])."</td><td>".$term[1]."</td></tr>";
				}
				$sections['top_search_terms'] .= "
					</tbody>
				</table>".\Linker::link($this->getTitleFor('SearchLog'), wfMessage('view_more')->escaped());
			} catch (\MWException $e) {
				throw new \ErrorPageError(
					'error_analytics_title',
					'error_analytics_text',
					[$e->getMessage()]
				);
			}

			try {
				// $redis->setEx($redisKey, 86400, serialize($sections)); TODO memcache
			} catch (RedisException $e) {
				wfDebug(__METHOD__.' Caught RedisException - '.$e->getMessage());
			}
		}

		try {
			// $ttl = $redis->ttl($redisKey); TODO memcache
		} catch (RedisException $e) {
			wfDebug(__METHOD__.' Caught RedisException - '.$e->getMessage());
		}

		$generatedAt = wfMessage('analytics_report_generated', 'one day ago TODO')->escaped();

		if ($this->getRequest()->getBool('debug')) {
			// append property ID inside HTML during debug
			$propID = Information::getProperty();
			$generatedAt = $generatedAt . "<script type='text/javascript'>var GAPropID = '{$propID}';</script>";
		}

		$this->getOutput()->setPageTitle(wfMessage('analyticsdashboard')->escaped());
		$this->content = TemplateAnalytics::analyticsPage($sections, $generatedAt);
	}

	/**
	 * Display the usage page.
	 *
	 * @access	private
	 * @return	void	[Outputs to screen]
	 */
	private function usagePage() {
		if (!Environment::isMasterWiki()) {
			throw new \ErrorPageError(
				'error_analytics_title',
				'error_analytics_usage_master'
			);
		}
		$this->getOutput()->setPageTitle(wfMessage('analyticsdashboardusage')->escaped());
		if (!class_exists('AdminMinder\AdminList')) {
			throw new \ErrorPageError(
				'error_analytics_title',
				'error_analytics_text',
				["Please enable AdminMinder extension to use this page."]
			);
		}

		$adminList =  new \AdminMinder\AdminList;
		$adminCount = $adminList::getCachedAdminsCount();

		$stats = \Cheevos\Cheevos::getStatProgress(
			[
				'stat' => 'analytics_dashboard_hit',
				'global' => true,
				'limit' => 0,
				'start_time' => time() - 2592000,
				'sort_direction' => 'desc'
			]
		);

		$lookup = \CentralIdLookup::factory();
		$uniques = 0;
		foreach ($stats as $stat) {
			if ($stat->getUser_Id() > 0) {
				$uniques++;
				$user = $lookup->localUserFromCentralId($stat->getUser_Id());
				if ($user) {
					$views[] = [
						'views'	=> $stat->getCount(),
						'user'	=> $user
					];
				}
			}
		}

		if ($adminCount < $uniques) {
			$adminCount = $uniques;
			// Lets assume cheevos at least knows better than AdminMinder.
			// (mainly for development purposes!)
		}

		$sections = [
			"admin_count" => "<div class='grid_box_largetext'>{$adminCount}</div>",
			"active_admin_count" => "<div class='grid_box_largetext'>{$uniques}</div>",
			"admin_count_graph" => TemplateAnalytics::wrapSectionData(
				'admin_count_graph',
				[
					"admin_count" => $adminCount,
					"active_admin_count" => $uniques
				]
			)
		];

		if (count($views)) {
			$sections['admin_views'] = "
			<table class='analytics_table'>
				<thead>
					<tr>
						<th>".wfMessage('views')->escaped()."</th>
						<th>".wfMessage('user')->escaped()."</th>
					</tr>
				</thead>
				<tbody>";
			foreach ($views as $data) {
				$sections['admin_views'] .= "<tr><td>".$this->getLanguage()->formatNum($data['views'])."</td><td>".\Linker::link($data['user']->getUserPage())."</td></tr>";
			}
			$sections['admin_views'] .= "
				</tbody>
			</table>";
		}

		$this->content = TemplateAnalytics::analyticsPage($sections, "", "usage_grid");
	}

	/**
	 * Normalize URIs coming from Google Analytics.
	 *
	 * @param string $uri
	 * @return string
	 */
	private function normalizeUri($uri) {
		$parts = explode('/', $uri);
		array_shift($parts);

		foreach ($parts as $i => $part) {
			$parts[$i] = urlencode($part);
		}

		return '/'.implode('/', $parts);
	}

	/**
	 * Returns the name that goes in the \<h1\> in the special page itself, and
	 * also the name that will be listed in Special:Specialpages
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->msg('analytics_dashboard')->text();
	}
}
