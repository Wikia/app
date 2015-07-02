<?php

class PortableInfoboxDataService {

	const IMAGE_FIELD_TYPE = 'image';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

	/**
	 * @var Title $title
	 */
	protected $title;

	protected function __construct( $title ) {
		$this->title = $title;
	}

	public static function newFromTitle( $title ) {
		return new PortableInfoboxDataService( $title );
	}

	public static function newFromPageID( $pageid ) {
		return new PortableInfoboxDataService( Title::newFromID( $pageid ) );
	}

	/**
	 * Returns infobox data
	 *
	 * @return array in format [ 'data' => [], 'sources' => [] ] or [] will be returned
	 */
	public function getData() {
		if ( $this->title && $this->title->exists() ) {
			$parserOutput = Article::newFromTitle( $this->title, RequestContext::getMain() )
				//on empty parser cache this should be regenerated, see WikiPage.php:2996
				->getParserOutput();
			$data = $parserOutput ?
				$parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME )
				: false;

			//return empty [] to prevent false on non existing infobox data
			return $data ? $data : [ ];
		}

		return [ ];
	}

	/**
	 * Get image list from infobox data
	 *
	 * @return array
	 */
	public function getImages() {
		$images = [ ];

		foreach ( $this->getData() as $infobox ) {
			// ensure data array exists
			$data = is_array( $infobox[ 'data' ] ) ? $infobox[ 'data' ] : [ ];
			foreach ( $data as $field ) {
				if ( $field[ 'type' ] == self::IMAGE_FIELD_TYPE && isset( $field[ 'data' ] ) && !empty( $field[ 'data' ][ 'key' ] ) ) {
					$images[ $field[ 'data' ][ 'key' ] ] = true;
				}
			}
		}

		return array_keys( $images );
	}
}
