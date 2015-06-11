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
	protected $children;
	protected $data = null;

	/* @var $externalParser ExternalParser */
	protected $externalParser;

	public function __construct( \SimpleXMLElement $xmlNode, $infoboxData ) {
		$this->xmlNode = $xmlNode;
		$this->infoboxData = $infoboxData;
	}

	public function getSource() {
		$source = $this->getXmlAttribute( $this->xmlNode, self::DATA_SRC_ATTR_NAME );
		if ( $this->xmlNode->{self::DEFAULT_TAG_NAME} ) {
			preg_match_all( '/{{{(.*)}}}/sU', (string)$this->xmlNode->{self::DEFAULT_TAG_NAME}, $sources );


			return $source ? array_unique( $sources[ 1 ] + [ $source ] ) : array_unique( $sources[ 1 ] );
		}

		return $source ? [ $source ] : [ ];
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
	 * @param ExternalParser|null $externalParser
	 *
	 * @return $this
	 */
	public function setExternalParser( $externalParser ) {
		// we can pass anything, and ignore it if not ExternalParser instance
		if ( $externalParser instanceof ExternalParser ) {
			$this->externalParser = $externalParser;
		}

		return $this;
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

	public function isType( $type ) {
		return strcmp( $this->getType(), strtolower( $type ) ) == 0;
	}

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => (string)$this->xmlNode ];
		}

		return $this->data;
	}

	public function getRenderData() {
		return [
			'type' => $this->getType(),
			'data' => $this->getData(),
			'isEmpty' => $this->isEmpty(),
			'source' => $this->getSource()
		];
	}

	/**
	 * @desc Check if node is empty.
	 * Note that a '0' value cannot be treated like a null
	 */
	public function isEmpty() {
		$data = $this->getData()[ 'value' ];

		return !( isset( $data ) ) || ( empty( $data ) && $data != '0' );
	}

	protected function getChildNodes() {
		if ( !isset( $this->children ) ) {
			$this->children = [ ];
			foreach ( $this->xmlNode as $child ) {
				$this->children[ ] = NodeFactory::newFromSimpleXml( $child, $this->infoboxData )
					->setExternalParser( $this->externalParser );
			}
		}

		return $this->children;
	}

	protected function getDataForChildren() {
		return array_map( function ( Node $item ) {
			return [
				'type' => $item->getType(),
				'data' => $item->getData(),
				'isEmpty' => $item->isEmpty(),
				'source' => $item->getSource()
			];
		}, $this->getChildNodes() );
	}

	protected function getRenderDataForChildren() {
		return array_map( function ( Node $item ) {
			return $item->getRenderData();
		}, array_filter( $this->getChildNodes(), function ( Node $item ) {
			return !$item->isEmpty();
		} ) );
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
				$value = SimpleXmlUtil::getInstance()->getInnerXML(
					$xmlNode->{self::DEFAULT_TAG_NAME}
				);
				$value = $this->getExternalParser()->parseRecursive( $value );
			}
		}

		return $value;
	}

	protected function getRawValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$source = $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME );
		$value = null;
		if ( !empty( $source ) ) {
			$value = $this->getRawInfoboxData( $source );
		}
		if ( !$value ) {
			if ( $xmlNode->{self::DEFAULT_TAG_NAME} ) {
				$value = (string)$xmlNode->{self::DEFAULT_TAG_NAME};
				$value = $this->getExternalParser()->replaceVariables( $value );
			}
		}

		return $value;
	}

	protected function getXmlAttribute( \SimpleXMLElement $xmlNode, $attribute ) {
		if ( isset( $xmlNode[ $attribute ] ) ) {
			return (string)$xmlNode[ $attribute ];
		}

		return null;
	}

	protected function getRawInfoboxData( $key ) {
		$data = isset( $this->infoboxData[ $key ] ) ? $this->infoboxData[ $key ] : null;

		return $data;
	}

	protected function getInfoboxData( $key ) {
		return $this->getExternalParser()->parseRecursive( $this->getRawInfoboxData( $key ) );
	}
}
