<?php

class PortableInfoboxBuilderService extends WikiaService {

	/**
	 * @param $builderData
	 *
	 * @return string
	 *
	 * @see PortableInfoboxBuilderServiceTest:: translationsDataProvider
	 */
	public function translate( $builderData ) {
		$out = "";
		$infobox = json_decode( $builderData );

		if ( $infobox ) {
			$xml = new SimpleXMLElement( '<' . PortableInfoboxParserTagController::PARSER_TAG_NAME . '/>' );
			foreach ( $infobox as $key => $value ) {
				if ( $key !== 'data' ) {
					$xml->addAttribute( $key, $value );
				}
			}
			$this->addGroupNode( $infobox->data, $xml );

			// save to xml, import to dom, to remove xml header
			$dom = dom_import_simplexml( $xml );
			$out = $dom->ownerDocument->saveXML( $dom->ownerDocument->documentElement );
			// ignore errors, we only load it to remove header
			libxml_clear_errors();
		}

		return $out;
	}

	protected function addGroupNode( $data, SimpleXMLElement $xml ) {
		foreach ( $data as $item ) {
			$type = strcasecmp( $item->type, 'row' ) == 0 ? 'data' : $item->type;
			$child = $xml->addChild( $type, is_string( $item->data ) ? (string)$item->data : null );
			if ( is_array( $item->data ) ) {
				$this->addGroupNode( $item->data, $child );
			} else {
				$this->addNode( $item, $child );
			}
		}
	}

	protected function addNode( $node, SimpleXMLElement $xml ) {
		if ( $node->source ) {
			$xml->addAttribute( 'source', $node->source );
		}
		foreach ( $node->data as $key => $value ) {
			// map defaultValue to default, as its js reserved key word
			$key = strcasecmp( $key, 'defaultValue' ) == 0 ? 'default' : $key;
			if ( is_object( $value ) ) {
				$this->addNode( $value, $xml->addChild( $key ) );
			} else {
				$xml->addChild( $key, $value );
			}
		}
	}
}
