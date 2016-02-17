<?php

class PortableInfoboxBuilderService extends WikiaService {

	/**
	 * @param $builderData string jsonencoded data object
	 * @return string
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateDataToMarkup( $builderData, $formatted = true ) {
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
			// make the output document human-readable
			$dom->ownerDocument->formatOutput = $formatted;

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
		$jsonObject = [];

		$xmlNode = simplexml_load_string( $infoboxMarkup );
		if($xmlNode) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode($xmlNode);
			$jsonObject = $builderNode->asJson($xmlNode);
		}

		return json_encode( $jsonObject );
	}

	/**
	 * @param $infoboxMarkup string with infobox markup
	 */
	public function isSupportedMarkup( $infoboxMarkup ) {
		$xmlNode = simplexml_load_string( $infoboxMarkup );
		if ( $xmlNode ) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode( $xmlNode );
			return $builderNode->isValid();
		}
		return false;
	}

	/**
	 * Determines whether provided array of infobox markups is supported by the builder
	 *
	 * @param $infoboxes
	 * @return bool
	 */
	public function isValidInfoboxArray( $infoboxes ) {
		return count( $infoboxes ) <= 1 && $this->isSupportedMarkup( $infoboxes[0] );
	}


	/**
	 *
	 * @param $infoboxMarkup
	 * @return string
	 */
	public function getDocumentation( $infoboxMarkup, $title ) {
		$infobox = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $infoboxMarkup );

		return (new Wikia\Template\PHPEngine() )
			->setPrefix( dirname( dirname( __FILE__ ) ) . '/templates' )
			->setData(
				[
					'title' => $title->getText(),
					'sources' => $infobox->getSource()
				]
			)
			->render( 'PortableInfoboxBuilderService_getDocumentation.php' );
	}

	/**
	 * replaces old infobox with new infobox within template content
	 *
	 * @param $oldInfobox
	 * @param $newInfobox
	 * @param $oldContent
	 *
	 * @return string
	 */
	public function updateInfobox($oldInfobox, $newInfobox, $oldContent) {
		return str_replace($oldInfobox, $newInfobox, $oldContent);
	}

	/**
	 * replaces old infobox doc with new infobox doc within template content
	 *
	 * @param $oldDocumentation
	 * @param $newDocumentation
	 * @param $oldContent
	 *
	 * @return string
	 */
	public function updateDocumentation($oldDocumentation, $newDocumentation, $oldContent) {
		return str_replace($oldDocumentation, $newDocumentation, $oldContent);
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
