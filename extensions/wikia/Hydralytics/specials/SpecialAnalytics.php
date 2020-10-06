<?php
/**
 * Wikia
 * Hydralytics
 * Analytics Special Page
 *
 * @author		Alexia E. Smith, Cameron Chunn and Wikia's Data Eng Team
 * @copyright	(c) 2018 Curse Inc.
 * @copyright	(c) 2019 Wikia Inc.
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
 * @link		https://github.com/Wikia/app/blob/master/extensions/wikia/Hydralytics
 *
 **/

namespace Hydralytics;

use Wikia\Logger\WikiaLogger;

class SpecialAnalytics extends \SpecialPage {

	// bump this one to invalidate the Redshift results cache
	const CACHE_VERSION = 4.5;

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
//		$this->checkPermissions();

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
	 * @throws \MWException
	 */
	private function analyticsPage() {
		global $wgLang;

		// use $wgLang to differ the cache based on user language
		$memcKey = wfMemcKey( __CLASS__, self::CACHE_VERSION, $wgLang->getCode() );

		$redshiftError = false;

		try {
			$sections = \WikiaDataAccess::cacheWithLock($memcKey, \WikiaResponse::CACHE_SHORT, function () {
				try {
					global $wgLang;
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
					$edits = Information::getEditsLoggedInOut();

					global $wgDisableAnonymousEditing;
					// hide this section when the wiki does not allow logged out edits
					if (empty($wgDisableAnonymousEditing)) {
						$sections['logged_in_out'] = TemplateAnalytics::wrapSectionData('logged_in_out', $edits);
					} else {
						unset($sections['logged_in_out']);
					}

					/**
					 *  Edit Per Day
					 */
					$dailyEdits = $edits['all'];
					$sections['edits_per_day'] = TemplateAnalytics::wrapSectionData('edits_per_day', $dailyEdits);

					/**
					 * Geolocation
					 */
					$geolocation = Information::getGeolocation();
					$sections['geolocation'] = TemplateAnalytics::wrapSectionData('geolocation', $geolocation);
					$countries = \CountryNames::getNames($wgLang->getCode());
					//arsort($geolocation['sessions']);
					if (isset($geolocation['pageviews'])) {
						$sections['geolocation'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>" . wfMessage('location')->escaped() . "</th>
								<th>" . wfMessage('views')->escaped() . "</th>
							</tr>
						</thead>
						<tbody>
						";
						foreach ($geolocation['pageviews'] as $location => $sessions) {
							$sections['geolocation'] .= "
							<tr>
								<td>" . $countries[$location] . "</td>
								<td>" . $this->getLanguage()->formatNum($sessions) . "</td>
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
								<th>" . wfMessage('page')->escaped() . "</th>
								<th>" . wfMessage('views')->escaped() . "</th>
							</tr>
						</thead>
						<tbody>
						";
						foreach ($topPages['pageviews'] as $uri => $views) {
							$newUri = $this->normalizeUri($uri);

							// remove language url part and "/wiki/" and underscores from page names
							$title = preg_replace('|^(/\w+)?/wiki/|', '', $newUri);
							$title = str_replace('_', ' ', $title);

							$sections['top_viewed_pages'] .= "
							<tr>

								<td><a href='" . \Sanitizer::encodeAttribute(wfExpandUrl($newUri)) . "'>" . htmlspecialchars($title) . "</a></td>
								<td>" . $this->getLanguage()->formatNum($views) . "</td>
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
								<th>" . wfMessage('user')->escaped() . "</th>
								<th>" . wfMessage('points')->escaped() . "</th>
							</tr>
						</thead>
						<tbody>
					";
						foreach ($topEditorsAllTime as $data) {
							$sections['top_editors'] .= "<tr><td>" . $this->getLanguage()->formatNum($data['points']) . "</td><td>" . \Linker::link($data['user']['user-page']) . "</td></tr>";
						}
						$sections['top_editors'] .= "
						</tbody>
					</table>" . \Linker::link($this->getTitleFor('WikiPoints'), wfMessage('view_more')->escaped());
					}

					$topEditorsActive = Information::getTopEditors(true);
					if (count($topEditorsActive)) {
						$lastMonth = strtotime(date('Y-m-d', strtotime('First day of last month')) . 'T00:00:00+00:00');
						$sections['active_editors'] = "
					<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>" . wfMessage('user')->escaped() . "</th>
								<th>" . wfMessage('points')->escaped() . "</th>
								<th>" . wfMessage('active_month')->escaped() . "</th>
							</tr>
						</thead>
						<tbody>";
						foreach ($topEditorsActive as $data) {
							if ($data['month'] >= $lastMonth) {
								$sections['active_editors'] .= "<tr><td>" . $this->getLanguage()->formatNum($data['points']) . "</td><td>" . \Linker::link($data['user']->getUserPage()) . "</td><td>" . gmdate('F Y', $data['month']) . "</td></tr>";
							}
						}
						$sections['active_editors'] .= "
						</tbody>
					</table>" . \Linker::link($this->getTitleFor('WikiPoints/monthly'), wfMessage('view_more')->escaped());
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
								<th>" . wfMessage('file')->escaped() . "</th>
								<th>" . wfMessage('views')->escaped() . "</th>
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
							$uriText = str_replace('_', ' ', $uriText);

							$sections['most_visited_files'] .= "
							<tr>
								<td><a href='" . \Sanitizer::encodeAttribute(wfExpandUrl($newUri)) . "'>" .
								htmlspecialchars($uriText) . "</a></td>
								<td>" . $this->getLanguage()->formatNum($views) . "</td>
							</tr>";
						}
						$sections['most_visited_files'] .= "
						</tbody>
					</table>";
					}

					/**
					 *  Staff Contact / Help Links
					 *
					 * $managers = Information::getWikiManagers();
					 * $sections['staff_contact'] = "
					 * <table class=\"analytics_table\">
					 * <thead>
					 * <tr>
					 * <th>".wfMessage("wiki_manager")->text()."</th>
					 * </tr>
					 * </thead>
					 * <tbody>";
					 * foreach ($managers as $manager) {
					 * $title = \Title::newFromText('User:'.$manager);
					 * $sections['staff_contact'] .= "<tr><td>".\Linker::link($title, $manager)."</td></tr>";
					 * }
					 * $sections['staff_contact'] .= "
					 * </table>";
					 *
					 * if ($wgCommunityManager) {
					 * $sections['staff_contact'] .= "
					 * <table class=\"analytics_table\">
					 * <thead>
					 * <tr>
					 * <th>".wfMessage("community_manager")->text()."</th>
					 * </tr>
					 * </thead>
					 * <tbody>
					 * <tr><td>".\Linker::link(\Title::newFromText("User:".$wgCommunityManager), $wgCommunityManager)."</td></tr>
					 * </tbody>
					 * </table>";
					 * }
					 *
					 * $sections['staff_contact'] = "
					 * <table class=\"analytics_table\">
					 * <thead>
					 * <tr>
					 * <th>".wfMessage("help_links")->text()."</th>
					 * </tr>
					 * </thead>
					 * <tbody>
					 * <tr><td>".Information::getFaqLink()."</td></tr>
					 * <tr><td>".Information::getFeedbackLink()."</td></tr>
					 * <tr><td>".Information::getSlackLink()."</td></tr>
					 * </tbody>
					 * </table>";
					 **/
					/**
					 * Top Search Terms
					 */

					$terms = Information::getTopSearchTerms();
					$sections['top_search_terms'] = "
				<table class=\"analytics_table\">
						<thead>
							<tr>
								<th>" . wfMessage('search_term')->escaped() . "</th>
								<th>" . wfMessage('views')->escaped() . "</th>
							</tr>
						</thead>
						<tbody>";

					// generate URLs like this one: https://elderscrolls.fandom.com/wiki/Special:Search?query=Marriage
					$specialSearch = \SpecialPage::getTitleFor('Search');

					foreach ($terms as $term => $count) {
						$url = $specialSearch->getLocalURL(['query' => $term]);
						$sections['top_search_terms'] .= "
					<tr>
						<td>
							<a href='" . htmlspecialchars($url) . "'>" . htmlspecialchars($term) . "</a>
						</td>
						<td>
							" . $this->getLanguage()->formatNum($count) .
							"</td>
					</tr>
					";
					}

					$sections['top_search_terms'] .= "
					</tbody>
				</table>";

					// $sections['top_search_terms'] .= \Linker::link($this->getTitleFor('SearchLog'), wfMessage('view_more')->escaped());
				} catch (\MWException $e) {
					throw new \ErrorPageError(
						'error_analytics_title',
						'error_analytics_text',
						[$e->getMessage()]
					);
				}

				return $sections;
			});
		} catch ( \PDOException $e ) {
			// Redshift database connection / query issue
			WikiaLogger::instance()->error( 'Redshift backend error', [
				'exception' => $e,
			] );
			$redshiftError = true;
		}

		if ( $redshiftError ) {
			$this->getOutput()->setPageTitle(wfMessage('analytics_dashboard')->escaped());
			$this->content = "
			<div id='analytics_wrapper'>
				<div id='analytics_confidential_header'>
					<div id='analytics_confidential'>
					" . wfMessage( 'db_error' )->escaped() . "
					</div>
				</div>
			</div>
			";
			return;
		}

		$generatedAt = wfMessage('analytics_report_generated', wfMsgExt('timeago-day', array(), 1))->escaped();

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
