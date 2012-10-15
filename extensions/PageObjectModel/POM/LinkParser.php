<?php
#
# Parsing for internal links and annotations
#

class POMLinkParser implements POMParser {
	#
	# This function will parse all POMTextNodes in the page and add POMLink nodes if links are found
	#
	static function Parse( POMPage $page ) {
		// this array holds shortcuts to templates
		$page->c['links'] = array();

		// this array will hold updated version of the tree end will replace original one if it was updated
		$newchildren = array();

		// we'll set it to true if tree was updated
		$replaceoldchildrenwithnew = false;

		for ( $n = 0; $n < sizeof( $page->children ); $n++ ) {
			if ( is_a( $page->children[$n], 'POMTextNode' ) ) {
				$nodetext = $page->children[$n]->asString();

				while ( ( $open = strpos( $nodetext, '[[' ) ) !== FALSE ) {
					$position = $open;
					
					$nextopen = strpos( $nodetext, '[[', $position + 2 );
					$pipe = strpos( $nodetext, '|', $position + 2 );
					$nextpipe = strpos( $nodetext, '|', $pipe + 1 );
					$close = strpos( $nodetext, ']]', $position + 2 );
					
					if ( FALSE === $close ) break; # some markup confuses this poor parser, and thus it ignores the rest of this node
					if ( !( FALSE === $nextpipe ) && ( $nextpipe < $close ) ) break;
					if ( !( FALSE === $nextopen ) && ( $nextopen < $close ) ) break;
					
					// part before the template becomes text node
					$newchildren[] = new POMTextNode( substr( $nodetext, 0, $open ) );

					// part between opening [[ and closing ]] becomes link
					$link = new POMLink( substr( $nodetext, $open, $close + 2 - $open ) );
					$newchildren[] = $link;
					$page->c['links'][] = $link;
					
					$position = $close + 2;

					// the rest of it should be processed for more templates
					$nodetext = substr( $nodetext, $position );

					$replaceoldchildrenwithnew = true;
				}

				if ( strlen( $nodetext ) > 0 ) {
					$newchildren[] = new POMTextNode( $nodetext );

					$replaceoldchildrenwithnew = true;
				}
			} else {
				// preserve non-text nodes in the tree
				$newchildren[] = $page->children[$n];
			}
		}

		// if tree was updated, let's replace it in the page
		if ( $replaceoldchildrenwithnew ) $page->children = $newchildren;
	}
}
