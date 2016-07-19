<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\ExternalParser;
use Wikia\PortableInfobox\Parser\SimpleParser;

class Node {

	const DATA_SRC_ATTR_NAME = 'source';
	const DEFAULT_TAG_NAME = 'default';
	const FORMAT_TAG_NAME = 'format';
	const LABEL_TAG_NAME = 'label';
	const EXTRACT_SOURCE_REGEX = '/{{{([^\|}]*?)\|?.*}}}/sU';

	protected $xmlNode;
	protected $children;
	protected $data = null;

	/**
	 * @var $externalParser ExternalParser
	 */
	protected $externalParser;

	public function __construct( \SimpleXMLElement $xmlNode, $infoboxData ) {
		$this->xmlNode = $xmlNode;
		$this->infoboxData = $infoboxData;
	}

	public function getSource() {
		return $this->extractSourceFromNode( $this->xmlNode );
	}

	public function getSourceLabel() {
		$sourceLabels = [];
		$sources = $this->extractSourceFromNode( $this->xmlNode );
		$label = \Sanitizer::stripAllTags( $this->getInnerValue( $this->xmlNode->{self::LABEL_TAG_NAME} ) );

		if ( count( $sources ) > 1 ) {
			foreach ( $sources as $source ) {
				if ( !empty( $source ) ) {
					$sourceLabels[$source] = !empty( $label ) ? "{$label} ({$source})" : '';
				}
			}
		} elseif ( !empty( $sources[0] ) ) {
			$sourceLabels[$sources[0]] = $label;
		}

		return $sourceLabels;
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
		// we use builder pattern here, for fluently passing external parser to children nodes,
		// type hinting was removed to prevent catchable fatal error appearing
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
		 * by using mb_strtolower function
		 */
		return mb_strtolower( $this->xmlNode->getName() );
	}

	public function isType( $type ) {
		return strcmp( $this->getType(), mb_strtolower( $type ) ) == 0;
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
		];
	}

	/**
	 * @desc Check if node is empty.
	 * Note that a '0' value cannot be treated like a null
	 *
	 * @return bool
	 */
	public function isEmpty() {
		$data = $this->getData()[ 'value' ];

		return ( empty( $data ) && $data != '0' );
	}

	protected function getChildNodes() {
		if ( !isset( $this->children ) ) {
			$this->children = [ ];
			foreach ( $this->xmlNode as $child ) {
				$this->children[] = NodeFactory::newFromSimpleXml( $child, $this->infoboxData )
					->setExternalParser( $this->externalParser );
			}
		}

		return $this->children;
	}

	protected function getDataForChildren() {
		return array_map(
			function ( Node $item ) {
				return [
					'type' => $item->getType(),
					'data' => $item->getData(),
					'isEmpty' => $item->isEmpty(),
					'source' => $item->getSource()
				];
			},
			$this->getChildNodes()
		);
	}

	protected function getRenderDataForChildren() {
		return array_map( function ( Node $item ) {
			return $item->getRenderData();
		}, array_filter( $this->getChildNodes(), function ( Node $item ) {
			return !$item->isEmpty();
		} ) );
	}

	protected function getSourceForChildren() {
		/** @var Node $item */
		$result = [ ];
		foreach ( $this->getChildNodes() as $item ) {
			$result = array_merge( $result, $item->getSource() );
		}
		$uniqueParams = array_unique( $result );

		return array_values( $uniqueParams );
	}

	protected function getSourceLabelForChildren() {
		/** @var Node $item */
		$result = [ ];
		foreach ( $this->getChildNodes() as $item ) {
			$result = array_merge( $result, $item->getSourceLabel() );
		}

		return $result;
	}

	protected function getValueWithDefault( \SimpleXMLElement $xmlNode ) {
		$value = $this->extractDataFromSource( $xmlNode );
		if ( !$value && $xmlNode->{self::DEFAULT_TAG_NAME} ) {
			return $this->getInnerValue( $xmlNode->{self::DEFAULT_TAG_NAME} );
		}
		if ( ( $value || $value == '0' ) && $xmlNode->{self::FORMAT_TAG_NAME} ) {
			return $this->getInnerValue( $xmlNode->{self::FORMAT_TAG_NAME} );
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
			: $this->getInnerValue( $xmlNode );
	}

	protected function getInnerValue( \SimpleXMLElement $xmlNode ) {
		return $this->getExternalParser()->parseRecursive( (string)$xmlNode );
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

		return ( !empty( $source ) || $source == '0' ) ? $this->getInfoboxData( $source )
			: null;
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 *
	 * @return array
	 *
	 */
	protected function extractSourceFromNode( \SimpleXMLElement $xmlNode ) {
		$source = $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME ) ? [ $this->getXmlAttribute( $xmlNode, self::DATA_SRC_ATTR_NAME ) ] : [ ];

		if ( $xmlNode->{self::FORMAT_TAG_NAME} ) {
			$source = $this->matchVariables( $xmlNode->{self::FORMAT_TAG_NAME}, $source );
		}
		if ( $xmlNode->{self::DEFAULT_TAG_NAME} ) {
			$source = $this->matchVariables( $xmlNode->{self::DEFAULT_TAG_NAME}, $source );
		}

		return $source;
	}

	protected function matchVariables( \SimpleXMLElement $node, array $source ) {
		preg_match_all( self::EXTRACT_SOURCE_REGEX, (string)$node, $sources );

		return array_unique( array_merge( $source, $sources[ 1 ] ) );
	}
}
