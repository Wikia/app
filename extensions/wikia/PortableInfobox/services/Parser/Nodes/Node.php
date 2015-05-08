<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\ExternalParser;
use Wikia\PortableInfobox\Parser\SimpleParser;

class Node {

	const DATA_SRC_ATTR_NAME = 'source';
	const DEFAULT_TAG_NAME = 'default';
	const VALUE_TAG_NAME = 'value';
	const LABEL_TAG_NAME = 'label';

	protected $xmlNode;

	/* @var $externalParser ExternalParser */
	protected $externalParser;

	public function __construct( \SimpleXMLElement $xmlNode, $infoboxData ) {
		$this->xmlNode = $xmlNode;
		$this->infoboxData = $infoboxData;
	}

	/**
	 * @return ExternalParser
	 */
	public function getExternalParser() {
		if ( !isset( $this->externalParser ) ) {
			$this->setExternalParser( new SimpleParser() );
		}
		return $this->externalParser;
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
		return [ 'value' => (string)$this->xmlNode ];
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'value' ] ) ) || empty( $data[ 'value' ] );
	}

	protected function getInnerXML( \SimpleXMLElement $node ) {
		$innerXML= '';
		foreach ( dom_import_simplexml( $node )->childNodes as $child ) {
			$innerXML .= $child->ownerDocument->saveXML( $child );
		}
		return $innerXML;
	}

	protected function getValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$source = $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME );
		$value = null;
		if ( !empty( $source ) ) {
			$value = $this->getInfoboxData( $source );
		}
		if ( !$value ) {
			if ( $xmlNode->{self::DEFAULT_TAG_NAME} ) {
				/*
				 * <default> tag can contain <ref> or other WikiText parser hooks
				 * We should not parse it's contents as XML but return pure text in order to let MediaWiki Parser
				 * parse it.
				 */
				$value = $this->getInnerXML( $xmlNode->{self::DEFAULT_TAG_NAME} );
				$value = $this->getExternalParser()->parseRecursive( $value );
			}
		}
		return $value;
	}

	protected function getXmlAttribute( \SimpleXMLElement $xmlNode, $attribute ) {
		if ( isset( $xmlNode[ $attribute ] ) )
			return (string)$xmlNode[ $attribute ];
		return null;
	}

	protected function getInfoboxData( $key ) {
		$data = isset( $this->infoboxData[ $key ] ) ? $this->infoboxData[ $key ] : null;
		return $this->getExternalParser()->parseRecursive( $data );
	}
}
