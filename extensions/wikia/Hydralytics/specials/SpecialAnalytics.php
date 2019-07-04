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

class SpecialAnalytics extends \SpecialPage {

	// bump this one to invalidate the Redshift results cache
	const CACHE_VERSION = 3.1;

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
	 * @throws \ErrorPageError
	 */
	public function execute($subpage) {
		$this->checkPermissions();

		$this->getOutput()->addModuleStyles(['ext.hydralytics.styles']);
		$this->getOutput()->addModules(['ext.hydralytics.scripts']);
		$this->setHeaders();

		$this->analyticsPage();

		$this->getOutput()->addHTML($this->content);
	}

	/**
	 * Display the analytics page.
	 *
	 * @access	private
	 * @return	void	[Outputs to screen]
	 * @throws \ErrorPageError
	 */
	private function analyticsPage() {
		global $wgMemc;

		$memcKey = wfMemcKey( __CLASS__, self::CACHE_VERSION );
		$sections = $wgMemc->get( $memcKey );

		if ( !is_array( $sections ) ) {
			try {
				$sections = [
					'top_viewed_pages' => '',
					'number_of_pageviews' => '',
					'top_editors' => '',
					'geolocation' => '',
					'most_visited_files' => '',
					'desktop_vs_mobile' => '',
					'browser_breakdown' => '',
					'active_editors' => '',
					'edits_per_day' => '',
					'logged_in_out' => '',
					'top_search_terms' => ''
				];

				/**
				 *  Browser Breakdown + Desktop vs Mobile
				 */
				$deviceBreakdown = Information::getDeviceBreakdown(4);
				$sections['browser_breakdown'] = TemplateAnalytics::wrapSectionData('browser_breakdown', $deviceBreakdown['browser']);
				$sections['desktop_vs_mobile'] = TemplateAnalytics::wrapSectionData('desktop_vs_mobile', $deviceBreakdown['deviceCategory']);

				/**
				 *  Number Of Pageviews
				 */
				$dailyTotals = Information::getDailyTotals();
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
				 *  Logged in vs Logged out Edits
				 */
				$loggedInOutEdits = Information::getEditsLoggedInOut();
				$sections['logged_in_out'] = TemplateAnalytics::wrapSectionData('logged_in_out', $loggedInOutEdits);

				/**
				 *  Edit Per Day
				 */
				$dailyEdits = $loggedInOutEdits['all'];
				$sections['edits_per_day'] = TemplateAnalytics::wrapSectionData('edits_per_day', $dailyEdits);

				/**
				 * Geolocation
				 */
				$geolocation = Information::getGeolocation();
				$sections['geolocation'] = TemplateAnalytics::wrapSectionData('geolocation',$geolocation);
				//arsort($geolocation['sessions']);
				if (isset($geolocation['pageviews'])) {
					$sections['geolocation'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>".wfMessage('location')->escaped()."</th>
								<th>".wfMessage('views')->escaped()."</th>
							</tr>
						</thead>
						<tbody>
						";
					foreach ($geolocation['pageviews'] as $location => $sessions) {
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
				$topPages = Information::getTopViewedPages();
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
				$topFiles = Information::getTopViewedFiles();
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
						// remove NS_FILE namespace prefix
						$uriText = explode(":", $newUri);
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
				 *
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

				$sections['staff_contact'] = "
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
				 **/
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
				foreach ($terms as $term => $count) {
					$sections['top_search_terms'] .= "<tr><td>".$this->getLanguage()->formatNum($count)."</td><td>".$term."</td></tr>";
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
			} catch ( \PDOException $e ) {
				// Redshift database connection / query issue
				throw new \ErrorPageError(
					'error_analytics_title',
					'error_analytics_text',
					['Redshift backend error']
				);
			}

			// cache the statistics for three hours, new data in Redshift arrive every 24h
			$wgMemc->set( $memcKey, $sections,  \WikiaResponse::CACHE_SHORT );
		}

		$generatedAt = wfMessage('analytics_report_generated', 'one day ago')->escaped();

		$this->getOutput()->setPageTitle(wfMessage('analytics_dashboard')->escaped());
		$this->content = TemplateAnalytics::analyticsPage($sections, $generatedAt);
	}

	/**
	 * Normalize URIs coming from Redshift.
	 *
	 * @param string $uri
	 * @return string
	 */
	private function normalizeUri($uri) {
		// e.g. /wiki/Elmo%27s_World_episodes
		return urldecode($uri);
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
