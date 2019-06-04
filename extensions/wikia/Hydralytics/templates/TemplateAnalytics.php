<?php
/**
 * Curse Inc.
 * Hydralytics
 * Analytics Special Page Template
 *
 * @author		Alexia E. Smith
 * @copyright	(c) 2018 Curse Inc.
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
 * @link		https://gitlab.com/hydrawiki
 *
 **/

namespace Hydralytics;

class TemplateAnalytics {
	/**
	 * Analytics Page
	 *
	 * @access	public
	 * @param	array	Sections to Display
	 * @param	string	Relative timestamp when this report was generated.
	 * @return	string	Built HTML
	 */
	static public function analyticsPage($sections, $generatedAt, $gridClass = false) {
		$html = "
		<script type='text/javascript'>
			/* Initialize empty array that will be populated by scripts dumped into sections and cached. */
			var sectionsData = [];
		</script>
		<div id='analytics_wrapper'>
			<div id='analytics_confidential_header'>
				<div id='analytics_confidential'>".wfMessage("analytics_confidential")->escaped()."</div>
			</div>
			<div id='analytics_header'>
				".($gridClass != 'usage_grid' /* TODO && Environment::isMasterWiki() */ ? "<div id='analytics_usage'>".\Linker::link(\Title::newFromText('Special:Analytics/usage'), wfMessage('analytics_usage')->escaped())."</div>" : '')."
				<div id='analytics_report_time'>{$generatedAt}</div>
			</div>
			<div id='analytics_grid'".($gridClass ? 'class="'.$gridClass.'"' : '').">";
			foreach ($sections as $title => $content) {
				$html .= self::gridBox($title, $content);
			}
		$html .= "</div>
		</div>";

		return $html;
	}

	/**
	 * Get a standard box for the CSS Grid on the page.
	 *
	 * @access	private
	 * @param	string	Language string for the box.
	 * @return	string	HTML
	 */
	static private function gridBox($title, $content) {
		$html = "
			<div id='{$title}' class='grid_box' style='grid-area: {$title}'>
				<div class='grid_box_header'>".wfMessage($title)->escaped()."</div>
				<div class='grid_box_inner'>
					{$content}
				</div>
			</div>
		";

		return $html;
	}

		/**
	 * Wrap section data in a Javascript tag.
	 *
	 * @access	public
	 * @param	string	Section Name
	 * @param	array	Section data to be JSON encoded.
	 * @return	string	HTML
	 */
	static public function wrapSectionData($name, $data) {
		return "
			<script type='text/javascript'>
				(function(){
					sectionsData['{$name}'] = ".json_encode($data).";
				}());
			</script>
		";
	}
}
