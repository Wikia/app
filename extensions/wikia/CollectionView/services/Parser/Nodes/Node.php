<?php
namespace Wikia\CollectionView\Parser\Nodes;

use Wikia\CollectionView\Parser\ExternalParser;

class Node {

	protected $xmlNode;

	/* @var $externalParser ExternalParser */
	protected $externalParser;

	public function __construct( \SimpleXMLElement $xmlNode ) {
		$this->xmlNode = $xmlNode;
	}

	/**
	 * @param mixed $externalParser
	 */
	public function setExternalParser( ExternalParser $externalParser ) {
		$this->externalParser = $externalParser;
	}

	public function getType() {
		return $this->xmlNode->getName();
	}

	public function getData() {
		return [ 'value' => (string) $this->xmlNode ];
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'value' ] ) ) || empty( $data[ 'value' ] );
	}

	protected function getXmlAttribute( \SimpleXMLElement $xmlNode, $attribute )	{
		if( isset( $xmlNode[ $attribute ] ) )
			return (string) $xmlNode[ $attribute ];
		return null;
	}

	protected function parseWithExternalParser( $data, $recursive = false ) {
		if ( !empty( $data ) && !empty( $this->externalParser ) ) {
			if ( $recursive ) {
				return $this->externalParser->parseRecursive( $data );
			}
			return $this->externalParser->parse( $data );
		}
		return $data;
	}
}
