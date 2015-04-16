<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class Node {

	const DATA_SRC_ATTR_NAME = "source";
	const DEFAULT_TAG_NAME = "default";
	const VALUE_TAG_NAME = "value";
	const LABEL_TAG_NAME = "label";

	protected $xmlNode;

	public function __construct( \SimpleXMLElement $xmlNode, $infoboxData ) {
		$this->xmlNode = $xmlNode;
		$this->infoboxData = $infoboxData;
	}

	public function getType() {
		return $this->xmlNode->getName();
	}

	public function getData() {
		return (string) $this->xmlNode;
	}

	protected function getValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$source = $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME );
		$value = null;
		if ( !empty( $source ) ) {
			$value = $this->getInfoboxData( $source );
		}
		if ( !$value ) {
			if ( $xmlNode->{self::DEFAULT_TAG_NAME} ) {
				return (string) $xmlNode->{self::DEFAULT_TAG_NAME};
			}
		}
		return $value;
	}

	protected function getXmlAttribute( \SimpleXMLElement $xmlNode, $attribute )	{
		if( isset( $xmlNode[ $attribute ] ) )
			return (string) $xmlNode[ $attribute ];
		return null;
	}

	protected function getInfoboxData( $key ) {
		return isset( $this->infoboxData[ $key ] ) ? $this->infoboxData[ $key ] : null;
	}
}
