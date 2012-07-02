<?php

class FCKeditorSkin {
	private $skin;

	/**
	 * Create image link in MediaWiki 1.10
	 *
	 * @param Title $nt
	 * @param string $label label text
	 * @param string $alt alt text
	 * @param string $align horizontal alignment: none, left, center, right)
	 * @param array $params Parameters to be passed to the media handler
	 * @param boolean $framed shows image in original size in a frame
	 * @param boolean $thumb shows image as thumbnail in a frame
	 * @param string $manual_thumb image name for the manual thumbnail
	 * @param string $valign vertical alignment: baseline, sub, super, top, text-top, middle, bottom, text-bottom
	 * @return string     *
	 */
	function makeImageLinkObj( $nt, $label, $alt, $align = '', $params = array(), $framed = false,
	$thumb = false, $manual_thumb = '', $valign = '' ) {
		$orginal = $nt->getText();
		$img = wfFindFile( $nt );
		$found = $img->getURL();

		if( !is_null( $alt ) && ( $alt == 'RTENOTITLE' ) ) { // 2223
			$alt = '';
		}

		if( $found ) {
			// trick to get real URL for image:
			$frameParams = array(
				'alt' => $alt,
				'caption' => $label,
				'align' => $align,
				'framed' => $framed,
				'thumbnail' => $thumb,
				'manualthumb' => $manual_thumb,
				'valign' => $valign
			);

			$originalLink = strip_tags( Linker::makeImageLink2( $nt, $img, $frameParams, $params ), '<img>' );
			$srcPart = substr( $originalLink, strpos( $originalLink, "src=" ) + 5 );
			$url = strtok( $srcPart, '"' );
		}

		$ret = '<img ';

		if( $found ) {
			$ret .= "src=\"{$url}\" ";
		} else {
			$ret .= "_fck_mw_valid=\"false"."\" ";
		}
		$ret .= "_fck_mw_filename=\"{$orginal}\" ";

		if( $align ) {
			$ret .= "_fck_mw_location=\"" . strtolower( $align ) . "\" ";
		}
		if( !empty( $params ) ) {
			if( isset( $params['width'] ) ) {
				$ret .= "_fck_mw_width=\"" . $params['width'] . "\" ";
			}
			if( isset( $params['height'] ) ) {
				$ret .= "_fck_mw_height=\"" . $params['height'] . "\" ";
			}
		}
		$class = '';
		if( $thumb ) {
			$ret .= "_fck_mw_type=\"thumb"."\" ";
			$class .= "fck_mw_frame";
		} elseif( $framed ) {
			$ret .= "_fck_mw_type=\"frame"."\" ";
			$class .= "fck_mw_frame";
		}

		if( $align == 'right' ) {
			$class .= ( $class ? ' ' : '' ) . 'fck_mw_right';
		} elseif( $align == 'center' ) {
			$class .= ( $class ? ' ' : '' ) . 'fck_mw_center';
		} elseif( $align == 'left' ) {
			$class .= ( $class ? ' ' : '' ) . 'fck_mw_left';
		} elseif( $framed || $thumb ) {
			$class .= ( $class ? ' ' : '' ) . 'fck_mw_right';
		}

		if( !$found ) {
			$class .= ( $class ? ' ' : '' ) . 'fck_mw_notfound';
		}

		if( !is_null( $alt ) && !empty( $alt ) && false !== strpos( FCKeditorParser::$fkc_mw_makeImage_options, $alt ) && $alt != 'Image:' . $orginal ) {
			$ret .= "alt=\"" . htmlspecialchars( $alt ) . "\" ";
		} else {
			$ret .= "alt=\"\" ";
		}

		if( $class ) {
			$ret .= "class=\"$class\" ";
		}

		$ret .= '/>';

		return $ret;
	}

	function makeLinkObj( $nt, $text= '', $query = '', $trail = '', $prefix = '' ) {
		wfProfileIn( __METHOD__ );
		if ( $nt->isExternal() ) {
			$args = '';
			$u = $nt->getFullURL();
			$link = $nt->getPrefixedURL();
			if ( '' == $text ) {
				$text = $nt->getPrefixedText();
			}
			$style = $this->getInterwikiLinkAttributes( $link, $text, 'extiw' );

			$inside = '';
			if ( '' != $trail ) {
				$m = array();
				if ( preg_match( '/^([a-z]+)(.*)$$/sD', $trail, $m ) ) {
					$inside = $m[1];
					$trail = $m[2];
				}
			}
			if( $text == 'RTENOTITLE' ) { // 2223
				$text = $u = $link;
				$args .= '_fcknotitle="true" ';
			}
			$t = "<a {$args}href=\"{$u}\"{$style}>{$text}{$inside}</a>";

			wfProfileOut( __METHOD__ );
			return $t;
		}

		return Linker::makeLinkObj( $nt, $text, $query, $trail, $prefix );
	}

	function makeColouredLinkObj( $nt, $colour, $text = '', $query = '', $trail = '', $prefix = '' ) {
		if( $colour != '' ){
			$style = $this->getInternalLinkAttributesObj( $nt, $text, $colour );
		} else $style = '';
		return $this->makeKnownLinkObj( $nt, $text, $query, $trail, $prefix, '', $style );
	}

	function makeKnownLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' , $aprops = '', $style = '' ) {
		wfProfileIn( __METHOD__ );

		$args = '';
		if ( !is_object( $nt ) ) {
			wfProfileOut( __METHOD__ );
			return $text;
		}

		$u = $nt->getFullText();
		//#Updating links tables -> #Updating_links_tables
		$u = str_replace( "#" . $nt->getFragment(), $nt->getFragmentForURL(), $u );

		if ( $nt->getFragment() != '' ) {
			if( $nt->getPrefixedDBkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}

			/**
			 * See tickets 1386 and 1690 before changing anything
			 */
			if( $nt->getPartialUrl() == '' ) {
				$u .= $nt->getFragmentForURL();
			}
		}
		if ( $text == '' ) {
			$text = htmlspecialchars( $nt->getPrefixedText() );
		}

		if( $nt->getNamespace() == NS_CATEGORY ) {
			$u = ':' . $u;
		}

		list( $inside, $trail ) = Linker::splitTrail( $trail );
		$title = "{$prefix}{$text}{$inside}";

		$u = preg_replace( "/^RTECOLON/", ":", $u ); // change 'RTECOLON' => ':'
		if( substr( $text, 0, 10 ) == 'RTENOTITLE' ){ // starts with RTENOTITLE
			$args .= '_fcknotitle="true" ';
			$title = $u;
			$trail = substr( $text, 10 ) . $trail;
		}

		$r = "<a {$args}href=\"{$u}\">{$title}</a>{$trail}";
		wfProfileOut( __METHOD__ );
		return $r;
	}

	function makeBrokenLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' ) {
		# Fail gracefully
		if ( !isset( $nt ) ) {
			# throw new MWException();
			return "<!-- ERROR -->{$prefix}{$text}{$trail}";
		}
		$args = '';

		wfProfileIn( __METHOD__ );

		$u = $nt->getFullText();
		//#Updating links tables -> #Updating_links_tables
		$u = str_replace( "#" . $nt->getFragment(), $nt->getFragmentForURL(), $u );

		if ( '' == $text ) {
			$text = htmlspecialchars( $nt->getPrefixedText() );
		}
		if( $nt->getNamespace() == NS_CATEGORY ) {
			$u = ':' . $u;
		}

		list( $inside, $trail ) = Linker::splitTrail( $trail );
		$title = "{$prefix}{$text}{$inside}";

		$u = preg_replace( "/^RTECOLON/", ":", $u ); // change 'RTECOLON' => ':'
		if( substr( $text, 0, 10 ) == 'RTENOTITLE' ){	// starts with RTENOTITLE
			$args .= '_fcknotitle="true" ';
			$title = $u;
			$trail = substr( $text, 10 ) . $trail;
		}
		$s = "<a {$args}href=\"{$u}\">{$title}</a>{$trail}";

		wfProfileOut( __METHOD__ );
		return $s;
	}

	function makeSelfLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' ) {
		$args = '';
		if ( '' == $text ) {
			$text = $nt->mDbkeyform;
		}
		list( $inside, $trail ) = Linker::splitTrail( $trail );
		$title = "{$prefix}{$text}";
		if( $text == 'RTENOTITLE' ){ // 2223
			$args .= '_fcknotitle="true" ';
			$title = $nt->mDbkeyform;
		}
		return "<a {$args}href=\"".$nt->mDbkeyform."\" class=\"selflink\">{$title}</a>{$inside}{$trail}";
	}

	/**
	 * Create a direct link to a given uploaded file.
	 *
	 * @param $title Title object.
	 * @param $text  String: pre-sanitized HTML
	 * @return string HTML
	 *
	 * @todo Handle invalid or missing images better.
	 */
	public function makeMediaLinkObj( $title, $text = '' ) {
		if( is_null( $title ) ) {
			### HOTFIX. Instead of breaking, return empty string.
			return $text;
		} else {
			$args = '';
			$orginal = $title->getPartialURL();
			$img = wfFindFile( $title );
			if( $img ) {
				$url  = $img->getURL();
				$class = 'internal';
			} else {
				$upload = SpecialPage::getTitleFor( 'Upload' );
				$url = $upload->getLocalUrl( 'wpDestFile=' . urlencode( $title->getDBkey() ) );
				$class = 'new';
			}
			$alt = htmlspecialchars( $title->getText() );
			if( $text == '' ) {
				$text = $alt;
			}
			$orginal = preg_replace( "/^RTECOLON/", ":", $orginal ); // change 'RTECOLON' => ':'
			if( $text == 'RTENOTITLE' ){ // 2223
				$args .= '_fcknotitle="true" ';
				$text = $orginal;
				$alt = $orginal;
			}
			return "<a href=\"{$orginal}\" class=\"$class\" {$args} _fck_mw_filename=\"{$orginal}\" _fck_mw_type=\"media\" title=\"{$alt}\">{$text}</a>";
		}
	}

	function makeExternalLink( $url, $text, $escape = true, $linktype = '', $ns = null ) {
		$url = htmlspecialchars( $url );
		if( $escape ) {
			$text = htmlspecialchars( $text );
		}
		$url = preg_replace( "/^RTECOLON/", ":", $url ); // change 'RTECOLON' => ':'
		if( $linktype == 'autonumber' ) {
			return '<a href="' . $url . '">[n]</a>';
		}
		$args = '';
		if( $text == 'RTENOTITLE' ){ // 2223
			$args .= '_fcknotitle="true" ';
			$text = $url;
		}
		return '<a ' . $args . 'href="' . $url . '">' . $text . '</a>';
	}

	function __call( $m, $a ) {
		return call_user_func_array( array( $this->skin, $m ), $a );
	}

	function __construct( $skin ) {
		$this->skin = $skin;
	}
}
