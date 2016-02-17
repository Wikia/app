<?php

namespace Wikia\PortableInfoboxBuilder\Validators;

use Wikia\PortableInfobox\Parser\Nodes\Node;
use Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException;

class ValidatorBuilder {

	/**
	 * @desc provide validator for a given node type
	 *
	 * @param $node Node
	 * @return NodeValidator
	 */
	static public function createFromNode( $node ) {
		switch ( $node->getName() ) {
			case 'data':
				return new NodeDataValidator( $node );
			case 'title':
				return new NodeTitleValidator( $node );
			case 'infobox':
				return new NodeInfoboxValidator( $node );
			case 'image':
				return new NodeImageValidator( $node );
			case 'default':
				return new NodeDefaultValidator( $node );
			case 'caption':
				return new NodeCaptionValidator( $node );
			case 'label':
				return new NodeLabelValidator( $node );
			default:
				throw new UnimplementedNodeException();
		}
	}
}
