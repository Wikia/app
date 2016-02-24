<?php
namespace Wikia\PortableInfobox\Parser\Nodes;


use Wikia\PortableInfobox\Parser\XmlParser;

class NodeFactory {

	public static function newFromXML( $text, array $data = [ ] ) {
		return self::getInstance( XmlParser::parseXmlString( $text ), $data );
	}

	public static function newFromSimpleXml( \SimpleXMLElement $xmlNode, array $data = [ ] ) {
		return self::getInstance( $xmlNode, $data );
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 * @param array $data
	 *
	 * @return Node|NodeUnimplemented
	 */
	protected static function getInstance( \SimpleXMLElement $xmlNode, array $data ) {
		wfProfileIn( __METHOD__ );
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\PortableInfobox\\Parser\\Nodes\\' . 'Node' .
					 mb_convert_case( mb_strtolower( $tagType ), MB_CASE_TITLE );
		if ( class_exists( $className ) ) {
			/* @var $instance \Wikia\PortableInfobox\Parser\Nodes\Node */
			$instance = new $className( $xmlNode, $data );
			wfProfileOut( __METHOD__ );

			return $instance;
		}
		wfProfileOut( __METHOD__ );

		return new NodeUnimplemented( $xmlNode, $data );
	}

}