<?php
/**
 * Class InsightsTemplatesWithoutTypeModel
 * A class specific to a subpage with a list of templates without type.
 */
class InsightsTemplatesWithoutTypeModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'templateswithouttype';

	public $loopNotificationConfig = [
		'displayFixItMessage' => false,
	];

	public function getDataProvider() {
		return new TemplatesWithoutTypePage();
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	/**
	 * Should a number of referring pages be displayed next to each list item?
	 *
	 * @return bool
	 */
	public function isWlhLinkRequired() {
		return true;
	}

	/**
	 * A key of a message that wraps the number of pages referring to each item of the list.
	 *
	 * @return string
	 */
	public function wlhLinkMessage() {
		return 'insights-used-on';
	}

	public function arePageViewsRequired() {
		return false;
	}

	/**
	 * Prevent adding default insight loop param as loop for this insights is not yet defined
	 * @return array
	 */
	public function getUrlParams() {
		return [];
	}

	public function hasAltAction() {
		return false;
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		// @TODO add logic once loop is added for tis insight
		return false;
	}
}
