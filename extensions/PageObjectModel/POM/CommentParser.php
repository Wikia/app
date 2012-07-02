<?php
#
# Comment parser looks for comments and puts them in their own elements
#

class POMCommentParser implements POMParser {
	#
	# This function will parse all POMTextNodes in the page and add POMComment nodes if comments are found
	#
	static function Parse( POMPage $page ) {
		// this array holds shortcuts to templates
		$page->c['comments'] = array();

		// this array will hold updated version of the tree end will replace original one if it was updated
		$newchildren = array();

		// we'll set it to true if tree was updated
		$replaceoldchildrenwithnew = false;

		for ( $n = 0; $n < sizeof( $page->children ); $n++ ) {
			if ( is_a( $page->children[$n], 'POMTextNode' ) ) {
				$nodetext = $page->children[$n]->asString();

				while ( ( $open = strpos( $nodetext, '<!--' ) ) !== FALSE )
				{
					$position = $open;

					$close = strpos( $nodetext, '-->', $position + 4 );

					// we didn't find end of comment but still in this loop - skipping to next chunk
					if ( $close === FALSE ) {
						$brokenchunk = TRUE;
						continue 2; // get to next item in for loop
					} else {
						$position = $close;
					}

					// part before the template becomes text node
					$newchildren[] = new POMTextNode( substr( $nodetext, 0, $open ) );

					// part between opening <!-- and closing --> becomes comment
					$comment = new POMComment( substr( $nodetext, $open, $position + 3 - $open ) );
					$newchildren[] = $comment;
					$page->c['comments'][] = $comment;

					// the rest of it should be processed for more comments
					$nodetext = substr( $nodetext, $position + 3 );

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
		if ( $replaceoldchildrenwithnew ) {
			$page->children = $newchildren;
		}
	}
}
