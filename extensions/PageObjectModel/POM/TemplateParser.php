<?php
#
# Template class represents templates
#

class POMTemplateParser implements POMParser
{
	const MAX_TEMPLATE_NESTING_LEVEL = 50;

	#
	# This function will parse all POMTextNodes in the page and add POMTemplate nodes if templates are found
	#
	static function Parse( POMPage $page )
	{
		// this array holds shortcuts to templates
		$page->c['templates'] = array();

		// this array will hold updated version of the tree end will replace original one if it was updated
		$newchildren = array();

		// we'll set it to true if tree was updated
		$replaceoldchildrenwithnew = false;

		for ( $n = 0; $n < sizeof( $page->children ); $n++ )
		{
			if ( is_a( $page->children[$n], 'POMTextNode' ) )
			{
				$nodetext = $page->children[$n]->asString();

				while ( ( $firstopen = strpos( $nodetext, '{{' ) ) !== FALSE )
				{
					$position = $firstopen;

					$balance = 1; // we just found first open, balance moved up

					// by the end of this loop, $position should hold end of template
					do
					{
						$nextopen = strpos( $nodetext, '{{', $position + 2 );
						$nextclose = strpos( $nodetext, '}}', $position + 2 );

						// we didn't find end of template but still in this loop - skipping to next chunk
						if ( $nextclose === FALSE )
						{
							$brokenchunk = TRUE;
							continue 3; // get to next item in for loop
						}

						// next open tag is first, balance goes up
						// position is updated to closest marker
						if ( $nextopen !== FALSE && $nextopen < $nextclose )
						{
							$balance += 1;
							$position = $nextopen;
						}
						else
						{
							$balance -= 1;
							$position = $nextclose;
						}

						// In case something is wrong and we recursed too deep, die.
						if ( $balance > self::MAX_TEMPLATE_NESTING_LEVEL )
						{
							die( '[ERROR] Reached maximum template nesting level of ' . self::MAX_TEMPLATE_NESTING_LEVEL . ". Something is probably wrong with POM, please report this problem to developers.\n" );
						}
					} while ( $balance > 0 ); // we'll be done with the loop only when found matching chunk

					// part before the template becomes text node
					$newchildren[] = new POMTextNode( substr( $nodetext, 0, $firstopen ) );

					// part between opening {{ and closing }} becomes template
					$template = new POMTemplate( substr( $nodetext, $firstopen, $position + 2 - $firstopen ) );
					$newchildren[] = $template;
					$page->c['templates'][$template->getTitle()][] = $template;

					// the rest of it should be processed for more templates
					$nodetext = substr( $nodetext, $position + 2 );

					$replaceoldchildrenwithnew = true;
				}

				if ( strlen( $nodetext ) > 0 )
				{
					$newchildren[] = new POMTextNode( $nodetext );

					$replaceoldchildrenwithnew = true;
				}
			}
			else
			{
				// preserve non-text nodes in the tree
				$newchildren[] = $page->children[$n];
			}
		}

		// if tree was updated, let's replace it in the page
		if ( $replaceoldchildrenwithnew )
		{
			$page->children = $newchildren;
		}
	}
}

