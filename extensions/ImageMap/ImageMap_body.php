<?php

/**
 * Image map extension. 
 *
 * Syntax:
 * <imagemap>
 * Image:Foo.jpg | 100px | picture of a foo
 *
 * rect    0  0  50 50  [[Foo type A]]
 * circle  50 50 20     [[Foo type B]]
 * 
 * desc bottom-left
 * </imagemap>
 *
 * Coordinates are relative to the source image, not the thumbnail
 *
 */

class ImageMap {
	static public $id = 0;

	const TOP_RIGHT = 0;
	const BOTTOM_RIGHT = 1;
	const BOTTOM_LEFT = 2;
	const TOP_LEFT = 3;
	const NONE = 4;

	static function render( $input, $params, $parser ) {
		global $wgScriptPath, $wgUser, $wgUrlProtocols, $wgNoFollowLinks;
		wfLoadExtensionMessages( 'ImageMap' );

		$lines = explode( "\n", $input );

		$first = true;
		$lineNum = 0;
		$mapHTML = '';
		$links = array();

		# Define canonical desc types to allow i18n of 'imagemap_desc_types'
		$descTypesCanonical = 'top-right, bottom-right, bottom-left, top-left, none';
		$descType = self::BOTTOM_RIGHT;
		$defaultLinkAttribs = false;
		$realmap = true;
		foreach ( $lines as $line ) {
			++$lineNum;
			$externLink = false;

			$line = trim( $line );
			if ( $line == '' || $line[0] == '#' ) {
				continue;
			}

			if ( $first ) {
				$first = false;

				# The first line should have an image specification on it
				# Extract it and render the HTML
				$bits = explode( '|', $line, 2 );
				if ( count( $bits ) == 1 ) {
					$image = $bits[0];
					$options = '';
				} else {
					list( $image, $options ) = $bits;
				}
				$imageTitle = Title::newFromText( $image );
				if ( !$imageTitle || $imageTitle->getNamespace() != NS_IMAGE ) {
					return self::error( 'imagemap_no_image' );
				}
				if ( wfIsBadImage( $imageTitle->getDBkey() , $parser->mTitle ) ) {
					return self::error( 'imagemap_bad_image' );
				}
				// Parse the options so we can use links and the like in the caption
				$parsedOptions = $parser->recursiveTagParse( $options );
				$imageHTML = $parser->makeImage( $imageTitle, $parsedOptions );
				$parser->replaceLinkHolders( $imageHTML );
				$imageHTML = $parser->mStripState->unstripBoth( $imageHTML );
				$imageHTML = Sanitizer::normalizeCharReferences( $imageHTML );
				$parser->mOutput->addImage( $imageTitle->getDBkey() );

				$domDoc = new DOMDocument();
				wfSuppressWarnings();
				$ok = $domDoc->loadXML( $imageHTML );
				wfRestoreWarnings();
				if ( !$ok ) {
					return self::error( 'imagemap_invalid_image' );
				}
				$xpath = new DOMXPath( $domDoc );
				$imgs = $xpath->query( '//img' );
				if ( !$imgs->length ) {
					return self::error( 'imagemap_invalid_image' );
				}
				$imageNode = $imgs->item(0);
				$thumbWidth = $imageNode->getAttribute('width');
				$thumbHeight = $imageNode->getAttribute('height');

				if( function_exists( 'wfFindFile' ) ) {
					$imageObj = wfFindFile( $imageTitle );
				} else {
					// Old MW
					$imageObj = Image::newFromTitle( $imageTitle );
				}
				if ( !$imageObj || !$imageObj->exists() ) {
					return self::error( 'imagemap_invalid_image' );
				}
				# Add the linear dimensions to avoid inaccuracy in the scale 
				# factor when one is much larger than the other
				# (sx+sy)/(x+y) = s
				$denominator = $imageObj->getWidth() + $imageObj->getHeight();
				$numerator = $thumbWidth + $thumbHeight;
				if ( $denominator <= 0 || $numerator <= 0 ) {
					return self::error( 'imagemap_invalid_image' );
				}
				$scale = $numerator / $denominator;
				continue;
			}

			# Handle desc spec
			$cmd = strtok( $line, " \t" );
			if ( $cmd == 'desc' ) {
				$typesText = wfMsgForContent( 'imagemap_desc_types' );
				if ( $descTypesCanonical != $typesText ) {
					// i18n desc types exists
					$typesText = $descTypesCanonical . ', ' . $typesText;
				}
				$types = array_map( 'trim', explode( ',', $typesText ) );
				$type = trim( strtok( '' ) );
				$descType = array_search( $type, $types );
				if ( $descType > 4 ) {
					// A localized descType is used. Subtract 5 to reach the canonical desc type.
					$descType = $descType - 5;
				}
				if ( $descType === false || $descType < 0 ) { // <0? In theory never, but paranoia...
					return self::error( 'imagemap_invalid_desc', $typesText );
				}
				continue;
			}

			# Find the link
			$link = trim( strstr( $line, '[' ) );
			if ( preg_match( '/^ \[\[  ([^|]*+)  \|  ([^\]]*+)  \]\] \w* $ /x', $link, $m ) ) {
				$title = Title::newFromText( $m[1] );
				$alt = trim( $m[2] );
			} elseif ( preg_match( '/^ \[\[  ([^\]]*+) \]\] \w* $ /x', $link, $m ) ) {
				$title = Title::newFromText( $m[1] );
				if (is_null($title))
					return self::error('imagemap_invalid_title', $lineNum);
				$alt = $title->getFullText();
			} elseif ( in_array( substr( $link , 1 , strpos($link, '//' )+1 ) , $wgUrlProtocols ) || in_array( substr( $link , 1 , strpos($link, ':' ) ) , $wgUrlProtocols ) ) {
				if ( preg_match( '/^ \[  ([^\s]*+)  \s  ([^\]]*+)  \] \w* $ /x', $link, $m ) ) {
					$title = $m[1];
					$alt = trim( $m[2] );
					$externLink = true;
				} elseif ( preg_match( '/^ \[  ([^\]]*+) \] \w* $ /x', $link, $m ) ) {
					$title = $alt = trim( $m[1] );
					$externLink = true;
				}
			} else {
				return self::error( 'imagemap_no_link', $lineNum );
			}
			if ( !$title ) {
				return self::error( 'imagemap_invalid_title', $lineNum );
			}

			$shapeSpec = substr( $line, 0, -strlen( $link ) );

			# Tokenize shape spec
			$shape = strtok( $shapeSpec, " \t" );
			switch ( $shape ) {
				case 'default':
					$coords = array();
					break;
				case 'rect':
					$coords = self::tokenizeCoords( 4, $lineNum );
					if ( !is_array( $coords ) ) {
						return $coords;
					}
					break;
				case 'circle':
					$coords = self::tokenizeCoords( 3, $lineNum );
					if ( !is_array( $coords ) ) {
						return $coords;
					}
					break;
				case 'poly':
					$coords = array();
					$coord = strtok( " \t" );
					while ( $coord !== false ) {
						$coords[] = $coord;
						$coord = strtok( " \t" );
					}
					if ( !count( $coords ) ) {
						return self::error( 'imagemap_missing_coord', $lineNum );
					}
					if ( count( $coords ) % 2 !== 0 ) {
						return self::error( 'imagemap_poly_odd', $lineNum );
					}
					break;
				default:
					return self::error( 'imagemap_unrecognised_shape', $lineNum );
			}

			# Scale the coords using the size of the source image
			foreach ( $coords as $i => $c ) {
				$coords[$i] = intval( round( $c * $scale ) );
			}

			# Construct the area tag
			$attribs = array();
			if ( $externLink ) {
				$attribs['href'] = $title;
				$attribs['class'] = 'plainlinks';
				if ( $wgNoFollowLinks ) {
					$attribs['rel'] = 'nofollow';
				}
			} else if ( $title->getFragment() != '' && $title->getPrefixedDBkey() == '' ) {
				# XXX: kluge to handle [[#Fragment]] links, should really fix getLocalURL()
				# in Title.php to return an empty string in this case
				$attribs['href'] = $title->getFragmentForURL();
			} else {
				$attribs['href'] = $title->escapeLocalURL() . $title->getFragmentForURL();
			}
			if ( $shape != 'default' ) {
				$attribs['shape'] = $shape;
			}
			if ( $coords ) {
				$attribs['coords'] = implode( ',', $coords );
			}
			if ( $alt != '' ) {
				if ( $shape != 'default' ) {
					$attribs['alt'] = $alt;
				}
				$attribs['title'] = $alt;
			} 
			if ( $shape == 'default' ) {
				$defaultLinkAttribs = $attribs;
			} else {
				$mapHTML .= Xml::element( 'area', $attribs ) . "\n";
			}
			if ( $externLink ) {
				$extLinks[] = $title;
			} else {
				$links[] = $title;
			}
		}

		if ( $first ) {
			return self::error( 'imagemap_no_image' );
		}

		if ( $mapHTML == '' && $defaultLinkAttribs == '' ) {
			return self::error( 'imagemap_no_areas' );
		} elseif ( $mapHTML == '' && $defaultLinkAttribs != '' ) {
			// no areas defined, default only. It's not a real imagemap, so we do not need some tags
			$realmap = false;
		}

		if ( $realmap ) {
			# Construct the map
			$mapName = "ImageMap_" . ++self::$id;
			$mapHTML = "<map name=\"$mapName\">\n$mapHTML</map>\n";

			# Alter the image tag
			$imageNode->setAttribute( 'usemap', "#$mapName" );
		}

		# Add a surrounding div, remove the default link to the description page
		$anchor = $imageNode->parentNode;
		$parent = $anchor->parentNode;
		$div = $parent->insertBefore( new DOMElement( 'div' ), $anchor );
		if ( $defaultLinkAttribs ) {
			$defaultAnchor = $div->appendChild( new DOMElement( 'a' ) );
			foreach ( $defaultLinkAttribs as $name => $value ) {
				$defaultAnchor->setAttribute( $name, $value );
			}
			$imageParent = $defaultAnchor;
		} else {
			$imageParent = $div;
		}

		# Add the map HTML to the div
		# We used to add it before the div, but that made tidy unhappy
		if ( $mapHTML != '' ) {
			$mapDoc = DOMDocument::loadXML( $mapHTML );
			$mapNode = $domDoc->importNode( $mapDoc->documentElement, true );
			$div->appendChild( $mapNode );
		}

		$imageParent->appendChild( $imageNode->cloneNode( true ) );
		$parent->removeChild( $anchor );

		# Determine whether a "magnify" link is present
		$xpath = new DOMXPath( $domDoc );
		$magnify = $xpath->query( '//div[@class="magnify"]' );
		if ( !$magnify->length && $descType != self::NONE ) {
			# Add image description link
			if ( $descType == self::TOP_LEFT || $descType == self::BOTTOM_LEFT ) {
				$marginLeft = 0;
			} else {
				$marginLeft = $thumbWidth - 20;
			}
			if ( $descType == self::TOP_LEFT || $descType == self::TOP_RIGHT ) {
				$marginTop = -$thumbHeight;
				// 1px hack for IE, to stop it poking out the top
				$marginTop += 1;
			} else {
				$marginTop = -20;
			}
			$div->setAttribute( 'style', "height: {$thumbHeight}px; width: {$thumbWidth}px; " );
			$descWrapper = $div->appendChild( new DOMElement( 'div' ) );
			$descWrapper->setAttribute( 'style', 
				"margin-left: {$marginLeft}px; " . 
				"margin-top: {$marginTop}px; " .
				"text-align: left;"
			);

			$descAnchor = $descWrapper->appendChild( new DOMElement( 'a' ) );
			$descAnchor->setAttribute( 'href', $imageTitle->escapeLocalURL() );
			$descAnchor->setAttribute( 'title', wfMsgForContent( 'imagemap_description' ) );
			$descImg = $descAnchor->appendChild( new DOMElement( 'img' ) );
			$descImg->setAttribute( 'alt', wfMsgForContent( 'imagemap_description' ) );
			$descImg->setAttribute( 'src', "$wgScriptPath/extensions/ImageMap/desc-20.png" );
			$descImg->setAttribute( 'style', 'border: none;' );
		}

		# Output the result
		# We use saveXML() not saveHTML() because then we get XHTML-compliant output.
		# The disadvantage is that we have to strip out the DTD
		$output = preg_replace( '/<\?xml[^?]*\?>/', '', $domDoc->saveXML() );

		# Register links
		foreach ( $links as $title ) {
			if( $title->isExternal() || $title->getNamespace() == NS_SPECIAL ) {
				// Don't register special or interwiki links...
			} elseif( $title->getNamespace() == NS_MEDIA ) {
				// Regular Media: links are recorded as image usages
				$parser->mOutput->addImage( $title->getDBkey() );
			} else {
				// Plain ol' link
				$parser->mOutput->addLink( $title );
			}
		}
		if ( isset( $extLinks ) ) {
			foreach ( $extLinks as $title ) {
				$parser->mOutput->addExternalLink( $title );
			}
		}
		# Armour output against broken parser
		$output = str_replace( "\n", '', $output );
		return $output;
	}

	static function tokenizeCoords( $count, $lineNum ) {
		$coords = array();
		for ( $i = 0; $i < $count; $i++ ) {
			$coord = strtok( " \t" );
			if ( $coord === false ) {
				return self::error( 'imagemap_missing_coord', $lineNum );
			}
			if ( !is_numeric( $coord ) || $coord > 1e9 || $coord < 0 ) {
				return self::error( 'imagemap_invalid_coord', $lineNum );
			}
			$coords[$i] = $coord;
		}
		return $coords;
	}

	static function error( $name, $line = false ) {
		return '<p class="error">' . wfMsgForContent( $name, $line ) . '</p>';
	}
}


