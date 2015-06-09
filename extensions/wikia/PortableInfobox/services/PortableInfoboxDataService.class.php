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

	public function getImageListFromInfoboxData( $data ) {
		$images = [];
		foreach ( $data as $infobox ) {
			foreach ( $infobox as $field ) {
				if ( $field['type'] == self::IMAGE_FIELD_TYPE && isset( $field['data'] ) && !empty( $field['data']['key'] ) ) {
					$images[ $field['data']['key'] ] = true;
				}
			}
		}

		return array_keys( $images );
	}
}
