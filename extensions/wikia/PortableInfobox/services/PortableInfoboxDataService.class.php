<?php

class PortableInfoboxDataService {

	const IMAGE_FIELD_TYPE = 'image';

	public function getInfoboxDataByTitle( $title ) {
		$data = [];
		if ( $title && $title->exists() ) {
			$data = Article::newFromTitle( $title, RequestContext::getMain() )
				//on empty parser cache this should be regenerated, see WikiPage.php:2996
				->getParserOutput()
				->getProperty( PortableInfoboxParserTagController::INFOBOXES_PROPERTY_NAME );
		}
		return $data;
	}

	/**
	 * Get image list from infobox data
	 * @param $data array in format returned by PortableInfoboxDataService::getInfoboxDataByTitle which is
	 * an array of arrays returned by Wikia\PortableInfobox\Parser\XmlParser::getDataFromXmlString
	 * @return array
	 */
	public function getImageListFromInfoboxesData( $data ) {
		$images = [];

		if ( is_array( $data ) ) {
			foreach ( $data as $infobox ) {
				foreach ( $infobox as $field ) {
					if ( $field['type'] == self::IMAGE_FIELD_TYPE && isset( $field['data'] ) && !empty( $field['data']['key'] ) ) {
						$images[ $field['data']['key'] ] = true;
					}
				}
			}
		}
		return array_keys( $images );
	}
}
