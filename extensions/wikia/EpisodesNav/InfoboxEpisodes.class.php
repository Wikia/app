<?php

class InfoboxEpisodes {

	private $data;

	public function __construct( $infoboxData ) {
		$this->data = $infoboxData;
	}

	public function getNextEpisode() {
		return $this->extractTitle( $this->findLabel( 'next' ) );
	}

	public function getPreviousEpisode() {
		return $this->extractTitle( $this->findLabel( 'previous' ) );
	}

	private function findLabel( $label ) {
		foreach ( $this->data as $infobox ) {
			foreach ( $infobox['data'] as $field ) {
				$result = $this->findLabelElements( $field, $label );
				if ( !empty( $result ) ) {
					return $result;
				}
			}
		}
		return [];
	}

	private function findLabelElements( $field, $label ) {
		if ( $field['type'] === 'group' ) {
			foreach ( $field['data']['value'] as $child ) {
				$found = $this->findLabelElements( $child, $label );
				if ( !empty( $found ) ) {
					return $found;
				}
			}
		}
		if ( $field['type'] === 'data' ) {
			if ( strcasecmp( $field['data']['label'], $label ) === 0 ) {
				return $field;
			}
		}
		return [];
	}

	private function extractTitle( $item ) {
		$value = $item['data']['value'];
		$dom = HtmlHelper::createDOMDocumentFromText( $value );
		$xpath = new DOMXPath( $dom );
		$title = $xpath->query( '//a/@title' );

		if ( $title->length > 0 ) {
			return $title->item( 0 )->nodeValue;
		}
		return '';
	}
}
