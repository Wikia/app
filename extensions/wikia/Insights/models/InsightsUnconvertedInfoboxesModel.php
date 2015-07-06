<?php

/**
 * Class InsightsNonportableInfoboxesModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUnconvertedInfoboxesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'nonportableinfoboxes';

	public function getDataProvider() {
		return new UnconvertedInfoboxesPage();
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

	public function hasAltAction() {
		return class_exists( 'TemplateConverter' );
	}

	public function getAltActionUrl( Title $title ) {
		$subpage = Title::newFromText( $title->getText() . "/Draft", NS_TEMPLATE );

		return $subpage->getFullUrl( [ 'action' => 'edit' ] );
	}

	public function altActionLinkMessage() {
		return 'insights-label-altaction-infoboxes';
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		$titleText = $title->getText();
		$contentText = ( new WikiPage( $title ) )->getText();
		return !UnconvertedInfoboxesPage::isTitleWithNonportableInfobox( $titleText, $contentText );
	}
}
