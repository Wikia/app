<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

use Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException;

class NodeBuilder {

	/**
	 * @desc provide  for a given node type
	 *
	 * @param $node Node
	 * @return Node
	 */
	static public function createFromNode( $node ) {
		switch ( $node->getName() ) {
			case 'data':
				return new NodeData( $node );
			case 'title':
				return new NodeTitle( $node );
			case 'infobox':
				return new NodeInfobox( $node );
			case 'image':
				return new NodeImage( $node );
			case 'default':
				return new NodeDefault( $node );
			case 'caption':
				return new NodeCaption( $node );
			case 'label':
				return new NodeLabel( $node );
			default:
				throw new UnimplementedNodeException();
		}
	}
}
