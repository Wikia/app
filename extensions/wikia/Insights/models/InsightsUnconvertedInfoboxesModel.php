<?php

/**
 * Class InsightsNonportableInfoboxesModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUnconvertedInfoboxesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'nonportableinfoboxes';

	public $loopNotificationConfig = [
		'displayFixItMessage' => false,
	];

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

	/**
	 * Get a type of a subpage only, we want a user to be directed to view.
	 * @return array
	 */
	public function getUrlParams() {
		return $this->getInsightParam();
	}

	public function hasAltAction() {
		return class_exists( 'TemplateConverter' );
	}

	public function getAltAction( Title $title ) {
		$subpage = Title::newFromText( $title->getText() . "/" . wfMessage('templatedraft-subpage')->escaped() , NS_TEMPLATE );

		if ( !$subpage instanceof Title ) {
			// something went terribly wrong, quit early
			return '';
		}

		if ( $subpage->exists() ) {
			$url = $subpage->getFullUrl();
			$text = wfMessage( 'insights-altaction-seedraft' )->escaped();
			$class = 'secondary';
		} else {
			$url = $subpage->getFullUrl( [
				'action' => 'edit',
				TemplateConverter::CONVERSION_MARKER => 1,
			] );
			$text = wfMessage( 'insights-altaction-convert' )->escaped();
			$class = 'primary';
		}

		return [
			'url' => $url,
			'text' => $text,
			'class' => $class,
		];
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
