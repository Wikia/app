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
			case 'caption':
				return new NodeCaption( $node );
			case 'data':
				return new NodeData( $node );
			case 'default':
				return new NodeDefault( $node );
			case 'group':
				return new NodeGroup( $node );
			case 'header':
				return new NodeHeader( $node );
			case 'image':
				return new NodeImage( $node );
			case 'infobox':
				return new NodeInfobox( $node );
			case 'label':
				return new NodeLabel( $node );
			case 'title':
				return new NodeTitle( $node );
			default:
				throw new UnimplementedNodeException();
		}
	}
}
