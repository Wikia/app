<?php

class PortableInfoboxBuilderService extends WikiaService {

	/**
	 * @param $builderData string jsonencoded data object
	 * @return string
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateDataToMarkup( $builderData ) {
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

	/**
	 * @param $builderData
	 * @return array json_encoded array representing the infobox markup
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateMarkupToData( $infoboxMarkup ) {
		$builderData = [];

		return json_encode($builderData);
	}

	/**
	 * @param $infoboxMarkup: string with infobox markup
	 */
	public function isSupportedMarkup( $infoboxMarkup ) {

		return true;
	}



	/**
	 *
	 * @param $infoboxMarkup
	 * @return string
	 */
	public function getDocumentation( $infoboxMarkup, $title ) {
		$infobox = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $infoboxMarkup );

		return (new Wikia\Template\PHPEngine() )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData(
				[
					'title' => $title->getText(),
					'sources' => $infobox->getSource()
				]
			)
			->render( 'PortableInfoboxBuilderService_getDocumentation.php' );
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
			if ( !$this->isEmptyNodeValue( $value ) ) {
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

	/**
	 * return true if value should be treated as empty
	 *
	 * @param $value
	 * @return bool
	 */
	private function isEmptyNodeValue( $value ) {
		return ( empty( $value ) && $value != '0' );
	}
}
