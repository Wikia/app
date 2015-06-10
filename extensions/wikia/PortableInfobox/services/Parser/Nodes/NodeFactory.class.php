<?php
/**
 * Created by IntelliJ IDEA.
 * User: adamr
 * Date: 10/06/15
 * Time: 09:48
 */

namespace Wikia\PortableInfobox\Parser\Nodes;


class NodeFactory {

	public static function newFromSimpleXml( \SimpleXMLElement $xmlNode, array $data = [] ) {
		wfProfileIn(__METHOD__);
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\PortableInfobox\\Parser\\Nodes\\' . 'Node' . ucfirst( strtolower( $tagType ) );
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