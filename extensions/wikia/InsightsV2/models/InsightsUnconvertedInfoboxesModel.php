<?php
/**
 * Class InsightsNonportableInfoboxesModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUnconvertedInfoboxesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'nonportableinfoboxes';

	private static $insightConfig = [
		InsightsConfig::WHATLINKSHERE => true
	];

	public function __construct() {
		self::$insightConfig[InsightsConfig::ACTION] = class_exists( 'TemplateConverter' );
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new UnconvertedInfoboxesPage();
	}

	/**
	 * Get a type of a subpage only, we want a user to be directed to view.
	 * @return array
	 */
	public function getUrlParams() {
		return $this->getInsightParam();
	}

	public function getAction( Title $title ) {
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
		return !empty( PortableInfoboxDataService::newFromTitle( $title )->getData() );
	}
}
