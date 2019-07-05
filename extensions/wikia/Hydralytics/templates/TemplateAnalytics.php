<?php
/**
 * Analytics Special Page Template
 *
 * @author		Alexia E. Smith and Wikia's Data Eng Team
 * @copyright	(c) 2018 Curse Inc.
 * @copyright	(c) 2019 Wikia Inc..
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
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
		// TODO: "top editors" and "active editors" graphs are now removed
		unset($sections['top_editors']);
		unset($sections['active_editors']);

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
	static public function wrapSectionData(string $name, array $data) {
		return "
			<script type='text/javascript'>
				(function(){
					sectionsData['{$name}'] = ".json_encode($data).";
				}());
			</script>
		";
	}
}
