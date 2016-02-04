<?php

class SanitizerBuilder {

	/**
	 * @desc provide sanitizer for a given node type
	 *
	 * @param $type
	 * @return NodeSanitizer
	 */
	static public function createFromType( $type ) {
		switch ( $type ) {
			case 'data':
				return new NodeDataSanitizer();
			case 'horizontal-group-content':
				return new NodeHorizontalGroupSanitizer();
			case 'title':
				return new NodeTitleSanitizer();
			case 'image':
				return new NodeImageSanitizer();
			case 'hero-mobile':
				return new NodeHeroImageSanitizer();
			default:
				return new PassThroughSanitizer();
		}
	}
}
