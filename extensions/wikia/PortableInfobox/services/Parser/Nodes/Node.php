<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\SimpleXmlUtil;
use Wikia\PortableInfobox\Parser\ExternalParser;
use Wikia\PortableInfobox\Parser\SimpleParser;

class Node {

	const DATA_SRC_ATTR_NAME = 'source';
	const DEFAULT_TAG_NAME = 'default';
	const VALUE_TAG_NAME = 'value';
	const LABEL_TAG_NAME = 'label';

	protected $xmlNode;
	protected $parent = null;

	/**
	 * @var $externalParser ExternalParser
	 */
	protected $externalParser;

	public function __construct( \SimpleXMLElement $xmlNode, $infoboxData ) {
		$this->xmlNode = $xmlNode;
		$this->infoboxData = $infoboxData;
	}

	/**
	 * @return mixed
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param mixed $parent
	 */
	public function setParent( Node $parent ) {
		$this->parent = $parent;
	}

	public function ignoreNodeWhenEmpty() {
		return true;
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
		/*
		 * Node type generation is based on XML tag name.
		 * It's worth to remember that SimpleXMLElement::getName method is
		 * case - sensitive ( "<Data>" != "<data>" ), so we need to sanitize Node Type
		 * by using strtolower function
		 */
		return strtolower( $this->xmlNode->getName() );
	}

	public function getData() {
		return [ 'value' => (string)$this->xmlNode ];
	}

	/**
	 * @desc Check if node is empty.
	 * Note that a '0' value cannot be treated like a null
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function isEmpty( $data ) {
		$value = $data[ 'value' ];

		return !( isset( $value ) ) || ( empty( $value ) && $value != '0' );
	}

	protected function getValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$value = $this->extractDataFromSource( $xmlNode );
		if ( !$value && $xmlNode->{self::DEFAULT_TAG_NAME} ) {
			$value = $this->extractDataFromNode( $xmlNode->{self::DEFAULT_TAG_NAME} );
		}

		return $value;
	}

	protected function getRawValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$value = $this->getRawInfoboxData( $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME ) );
		if ( !$value && $xmlNode->{self::DEFAULT_TAG_NAME} ) {
			$value = $this->getExternalParser()->replaceVariables( (string)$xmlNode->{self::DEFAULT_TAG_NAME} );
		}

		return $value;
	}

	protected function getValueWithData( \SimpleXMLElement $xmlNode ) {
		$value = $this->extractDataFromSource( $xmlNode );

		return $value ? $value
			: $this->extractDataFromNode( $xmlNode );
	}

	protected function getXmlAttribute( \SimpleXMLElement $xmlNode, $attribute ) {
		return ( isset( $xmlNode[ $attribute ] ) ) ? (string)$xmlNode[ $attribute ]
			: null;
	}

	protected function getRawInfoboxData( $key ) {
		return isset( $this->infoboxData[ $key ] ) ? $this->infoboxData[ $key ]
			: null;
	}

	protected function getInfoboxData( $key ) {
		return $this->getExternalParser()->parseRecursive( $this->getRawInfoboxData( $key ) );
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 *
	 * @return mixed
	 */
	protected function extractDataFromSource( \SimpleXMLElement $xmlNode ) {
		$source = $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME );

		return ( !empty( $source ) ) ? $this->getInfoboxData( $source )
			: null;
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 *
	 * @return string
	 */
	protected function extractDataFromNode( \SimpleXMLElement $xmlNode ) {
		/*
		 * <default> tag can contain <ref> or other WikiText parser hooks
		 * We should not parse it's contents as XML but return pure text in order to let MediaWiki Parser
		 * parse it.
		 */
		return $this->getExternalParser()->parseRecursive( SimpleXmlUtil::getInstance()->getInnerXML( $xmlNode ) );
	}
}
