<?php

# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

/*
 todo :
 - check unicity of the index page : when index is saved too
*/

class ProofreadPage {

	/* Parser object for index pages */
	private static $index_parser = null;

	/**
	 * Returns id of Page namespace.
	 *
	 * @return integer namespace id
	 */
	public static function getPageNamespaceId() {
		static $namespace = null;
		if ( $namespace !== null ) {
			return $namespace;
		}
		$namespaceText = strtolower( str_replace( ' ', '_', wfMsgForContent( 'proofreadpage_namespace' ) ) );
		$namespace = MWNamespace::getCanonicalIndex( $namespaceText );
		return $namespace;
	}

	/**
	 * Returns id of Index namespace.
	 *
	 * @return integer namespace id
	 */
	public static function getIndexNamespaceId() {
		static $namespace = null;
		if ( $namespace !== null ) {
			return $namespace;
		}
		$namespaceText = strtolower( str_replace( ' ', '_', wfMsgForContent( 'proofreadpage_index_namespace' ) ) );
		$namespace = MWNamespace::getCanonicalIndex( $namespaceText );
		return $namespace;
	}

	/** @deprecated */
	private static function getPageAndIndexNamespace() {
		static $res = null;
		if ( $res === null ) {
			$res = array(
				preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' ),
				preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' ),
			);
		}
		return $res;
	}

	public static function onwgQueryPages( &$queryPages ) {
		$queryPages[] = array( 'ProofreadPages', 'IndexPages' );
		$queryPages[] = array( 'PagesWithoutScans', 'PagesWithoutScans' );
		return true;
	}

	/**
	 * Set up our custom parser hooks when initializing parser.
	 *
	 * @param Parser $parser
	 * @return boolean hook return value
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'pagelist', array( __CLASS__, 'renderPageList' ) );
		$parser->setHook( 'pages', array( __CLASS__, 'renderPages' ) );
		$parser->setHook( 'pagequality', array( __CLASS__, 'pageQuality' ) );
		return true;
	}

	/**
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		$base = dirname( __FILE__ );
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'pr_index', "$base/ProofreadPage.sql" );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'pr_index',
				"$base/ProofreadPage.sql", true ) );
		}
		return true;
	}

	/**
	 * Query the database to find if the current page is referred in an Index page.
	 */
	private static function load_index( $title ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();

		$title->pr_index_title = null;
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'page', 'pagelinks' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'pl_namespace' => $title->getNamespace(),
				'pl_title' => $title->getDBkey(),
				'pl_from=page_id'
			),
			__METHOD__
		);

		foreach ( $result as $x ) {
			$ref_title = Title::makeTitle( $x->page_namespace, $x->page_title );
			if ( preg_match( "/^$index_namespace:(.*)$/", $ref_title->getPrefixedText() ) ) {
				$title->pr_index_title = $ref_title->getPrefixedText();
				break;
			}
		}

		if ( $title->pr_index_title ) {
			return;
		}

		/* check if we are a page of a multipage file */
		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $title->getPrefixedText(), $m ) ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		}
		if ( !$imageTitle ) {
			return;
		}

		$image = wfFindFile( $imageTitle );

		// if it is multipage, we use the page order of the file
		if ( $image && $image->exists() && $image->isMultipage() ) {
			$name = $image->getTitle()->getText();
			$index_name = "$index_namespace:$name";

			if ( !$title->pr_index_title ) {
				// there is no index, or the page is not listed in the index : use canonical index
				$title->pr_index_title = $index_name;
			}
		}
	}

	/**
	 * return the URLs of the index, previous and next pages.
	 */
	private static function navigation( $title ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$default_header = wfMsgForContentNoTrans( 'proofreadpage_default_header' );
		$default_footer = wfMsgForContentNoTrans( 'proofreadpage_default_footer' );

		$err = array( '', '', '', '', '', '', '' );
		$index_title = Title::newFromText( $title->pr_index_title );
		if ( !$index_title ) {
			return $err;
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index_title->getText() );
		$image = wfFindFile( $imageTitle );
		// if multipage, we use the page order, but we should read pagenum from the index
		if ( $image && $image->exists() && $image->isMultipage() ) {
			$pagenr = 1;
			$parts = explode( '/', $title->getText() );
			if ( count( $parts ) > 1 ) {
				$pagenr = intval( array_pop( $parts ) );
			}
			$count = $image->pageCount();
			if ( $pagenr < 1 || $pagenr > $count || $count <= 1 ) {
				return $err;
			}
			$name = $image->getTitle()->getText();
			$prev_name = "$page_namespace:$name/" . ( $pagenr - 1 );
			$next_name = "$page_namespace:$name/" . ( $pagenr + 1 );
			$prev_title = ( $pagenr == 1 ) ? null : Title::newFromText( $prev_name );
			$next_title = ( $pagenr == $count ) ? null : Title::newFromText( $next_name );

		} else {
			$prev_title = null;
			$next_title = null;
		}

		if ( !$index_title->exists() ) {
			return array( $index_title, $prev_title, $next_title,  $default_header, $default_footer, '', '' );
		}

		// if the index page exists, find current page number, previous and next pages
		list( $links, $params, $attributes ) = self::parse_index( $index_title );

		if( $links == null ) {
			list( $pagenum, $links, $mode ) = self::pageNumber( $pagenr, $params );
			$attributes['pagenum'] = $pagenum;
		} else {
			for( $i = 0; $i < count( $links[1] ); $i++ ) {
				$a_title = Title::newFromText( $page_namespace . ':' . $links[1][$i] );
				if( !$a_title ) {
					continue;
				}
				if( $a_title->getPrefixedText() == $title->getPrefixedText() ) {
					$attributes['pagenum'] = $links[3][$i];
					break;
				}
			}
			if( ( $i > 0 ) && ( $i < count( $links[1] ) ) ) {
				$prev_title = Title::newFromText( $page_namespace . ':' . $links[1][$i - 1] );
			}
			if( ( $i >= 0 ) && ( $i + 1 < count( $links[1] ) ) ) {
				$next_title = Title::newFromText( $page_namespace . ':' . $links[1][$i + 1] );
			}
		}

		// Header and Footer
		// use a js dictionary for style, width, header footer
		$header = isset( $attributes['header'] ) ? $attributes['header'] : $default_header;
		$footer = isset( $attributes['footer'] ) ? $attributes['footer'] : $default_footer;
		foreach ( $attributes as $key => $val ) {
			$header = str_replace( "{{{{$key}}}}", $val, $header );
			$footer = str_replace( "{{{{$key}}}}", $val, $footer );
		}
		$css = isset( $attributes['css'] ) ? $attributes['css'] : '';
		$edit_width = isset( $attributes['width'] ) ? $attributes['width'] : '';

		return array( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width );
	}

	/**
	 * Read metadata from an index page.
	 * Depending on whether the index uses pagelist,
	 * it will return either a list of links or a list
	 * of parameters to pagelist, and a list of attributes.
	 */
	private static function parse_index( $index_title ) {
		$err = array( false, false, array() );
		if ( !$index_title ) {
			return $err;
		}
		if ( !$index_title->exists() ) {
			return $err;
		}

		$rev = Revision::newFromTitle( $index_title );
		$text = $rev->getText();
		return self::parse_index_text( $text );
	}

	private static function parse_index_text( $text ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		//check if it is using pagelist
		preg_match_all( "/<pagelist([^<]*?)\/>/is", $text, $m, PREG_PATTERN_ORDER );
		if( $m[1] ) {
			$params_s = '';
			for( $k = 0; $k < count( $m[1] ); $k++ ) {
				$params_s = $params_s . $m[1][$k];
			}
			$params = Sanitizer::decodeTagAttributes( $params_s );
			$links = null;
		} else {
			$params = null;
			$tag_pattern = "/\[\[$page_namespace:(.*?)(\|(.*?)|)\]\]/i";
			preg_match_all( $tag_pattern, $text, $links, PREG_PATTERN_ORDER );
		}

		// read attributes
		$attributes = array();
		$var_names = explode( ' ', wfMsgForContent( 'proofreadpage_js_attributes' ) );
		for( $i = 0; $i < count( $var_names ); $i++ ) {
			$tag_pattern = "/\n\|" . $var_names[$i] . "=(.*?)\n(\||\}\})/is";
			//$var = 'proofreadPage' . $var_names[$i];
			$var = strtolower( $var_names[$i] );
			if( preg_match( $tag_pattern, $text, $matches ) ) {
				$attributes[$var] = $matches[1];
			} else {
				$attributes[$var] = '';
			}
		}
		return array( $links, $params, $attributes );

	}

	/**
	 * Return the ordered list of links to ns-0 from an index page
	 */
	private static function parse_index_links( $index_title ) {
		// Instanciate a new parser object to avoid side effects of $parser->replaceVariables
		if( is_null( self::$index_parser ) ) {
			self::$index_parser = new Parser;
		}
		$rev = Revision::newFromTitle( $index_title );
		$text =	$rev->getText();
		$options = new ParserOptions();
		$rtext = self::$index_parser->preprocess( $text, $index_title, $options );
		$text_links_pattern = "/\[\[\s*([^:\|]*?)\s*(\|(.*?)|)\]\]/i";
		preg_match_all( $text_links_pattern, $rtext, $text_links, PREG_PATTERN_ORDER );
		return $text_links;
	}

	/**
	 * Append javascript variables and code to the page.
	 */
	public static function onBeforePageDisplay( $out ) {
		global $wgRequest;

		$action = $wgRequest->getVal( 'action' );
		$isEdit = ( $action == 'submit' || $action == 'edit' ) ? 1 : 0;
		if ( ( !$out->isArticle() && !$isEdit ) || isset( $out->proofreadPageDone ) ) {
			return true;
		}
		$out->proofreadPageDone = true;

		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();

		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $out->getTitle()->getPrefixedText(), $m ) ) {
			self::preparePage( $out, $m, $isEdit );
			return true;
		}

		if ( $isEdit && ( preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $out->getTitle()->getPrefixedText(), $m ) ) ) {
			self::prepareIndex( $out );
			return true;
		}

		if( $out->getTitle()->getNamespace() == NS_MAIN ) {
			self::prepareArticle( $out );
			return true;
		}

		return true;
	}

	private static function prepareIndex( $out ) {
		$out->addModules( 'ext.proofreadpage.index' );
		$out->addInlineScript("
var prp_index_attributes = \"" . Xml::escapeJsString( wfMsgForContent( 'proofreadpage_index_attributes' ) ) . "\";
var prp_default_header = \"" . Xml::escapeJsString( wfMsgForContentNoTrans( 'proofreadpage_default_header' ) ) . "\";
var prp_default_footer = \"" . Xml::escapeJsString( wfMsgForContentNoTrans( 'proofreadpage_default_footer' ) ) . "\";" );
	}

	private static function preparePage( $out, $m, $isEdit ) {
		global $wgUser, $wgExtensionAssetsPath;

		if ( !isset( $out->getTitle()->pr_index_title ) ) {
			self::load_index( $out->getTitle() );
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		if ( !$imageTitle ) {
			return true;
		}

		$image = wfFindFile( $imageTitle );
		if ( $image && $image->exists() ) {
			$width = $image->getWidth();
			$height = $image->getHeight();
			if ( $m[2] ) {
				$thumbName = $image->thumbName( array( 'width' => '##WIDTH##', 'page' => $m[3] ) );
				$thumbURL = $image->getThumbUrl( $thumbName );
				$thumbURL = str_replace( '%23', '#', $thumbURL );
				$fullURL = str_replace( '##WIDTH##', "$width", $thumbURL );
			} else {
				$thumbName = $image->thumbName( array( 'width' => '##WIDTH##' ) );
				$thumbURL = $image->getThumbUrl( $thumbName );
				$thumbURL = str_replace( '%23', '#', $thumbURL );
				$fullURL = $image->getURL();
			}
			$scan_link = Html::element( 'a',
						    array( 'href' => $fullURL,
							   'title' =>  wfMsg( 'proofreadpage_image' ) ),
						    wfMsg( 'proofreadpage_image' ) );
		} else {
			$width = 0;
			$height = 0;
			$thumbURL = '';
			$fullURL = '';
			$scan_link = '';
		}

		list( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width ) = self::navigation( $out->getTitle() );

		$sk = $wgUser->getSkin();
		$path = $wgExtensionAssetsPath . '/ProofreadPage';

		$next_link = $next_title ? $sk->link( $next_title,
			Html::element( 'img', array( 'src' => $path . '/rightarrow.png',
				'alt' => wfMsg( 'proofreadpage_nextpage' ), 'width' => 15, 'height' => 15 ) ),
			array( 'title' => wfMsg( 'proofreadpage_nextpage' ) ) ) : '';

		$prev_link = $prev_title ? $sk->link( $prev_title,
			Html::element( 'img', array( 'src' => $path . '/leftarrow.png',
				'alt' =>  wfMsg( 'proofreadpage_prevpage' ), 'width' => 15, 'height' => 15 ) ),
			array( 'title' => wfMsg( 'proofreadpage_prevpage' ) ) ): '';

		$index_link = $index_title ? $sk->link( $index_title,
			Html::element( 'img', array(	'src' => $path . '/uparrow.png',
				'alt' => wfMsg( 'proofreadpage_index' ), 'width' => 15, 'height' => 15 ) ),
			array( 'title' => wfMsg( 'proofreadpage_index' ) ) ) : '';

		$jsVars = array(
			'proofreadPageWidth' => intval( $width ),
			'proofreadPageHeight' => intval( $height ),
			'proofreadPageEditWidth' => $edit_width,
			'proofreadPageThumbURL' => $thumbURL,
			'proofreadPageURL' => $fullURL,
			'proofreadPageIsEdit' => intval( $isEdit ),
			'proofreadPageIndexLink' => $index_link,
			'proofreadPageNextLink' => $next_link,
			'proofreadPagePrevLink' => $prev_link,
			'proofreadPageScanLink' => $scan_link,
			'proofreadPageHeader' => $header,
			'proofreadPageFooter' => $footer,
			'proofreadPageAddButtons' => $wgUser->isAllowed( 'pagequality' ),
			'proofreadPageUserName' => $wgUser->getName(),
			'proofreadPageCss' => $css,
		);
		$out->addInlineScript( ResourceLoader::makeConfigSetScript( $jsVars ) );

		$out->addModules( 'ext.proofreadpage.page' );

		return true;
	}

	/**
	 * Hook function
	 */
	public static function onGetLinkColours( $page_ids, &$colours ) {
		global $wgTitle;
		if ( !isset( $wgTitle ) ) {
			return true;
		}
		// abort if we are not an index page
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		if ( !preg_match( "/^$index_namespace:(.*?)$/", $wgTitle->getPrefixedText(), $m ) ) {
			#return true;
		}
		self::getLinkColours( $page_ids, $colours );
		return true;
	}

	/**
	 * Return the quality colour codes to pages linked from an index page
	 */
	private static function getLinkColours( $page_ids, &$colours ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$dbr = wfGetDB( DB_SLAVE );
		$catlinks = $dbr->tableName( 'categorylinks' );

		$values = array();
		foreach ( $page_ids as $id => $pdbk ) {
			// consider only link in page namespace
			if ( preg_match( "/^$page_namespace:(.*?)$/", $pdbk ) ) {
				$colours[$pdbk] = 'quality1';
				$values[] = intval( $id );
			}
		}

		// Get the names of the quality categories.  Replaces earlier
		// code which called wfMsgForContent() 5 times for each page.
		// ISSUE: Should the number of quality levels be adjustable?
		// ISSUE 2: Should this array be saved as a member variable?
		// How often is this code called anyway?
		$qualityCategories = array();
		for ( $i = 0; $i < 5; $i++ ) {
			$cat = Title::makeTitleSafe( NS_CATEGORY, wfMsgForContent( "proofreadpage_quality{$i}_category" ) );
			if ( $cat ) {
				$qualityCategories[$cat->getDBkey()] = "quality$i";
			}
		}

		if ( count( $values ) ) {
			$query = "SELECT cl_from, cl_to FROM $catlinks WHERE cl_from IN(" . implode( ",", $values ) . ")";
			$res = $dbr->query( $query, __METHOD__ );

			foreach ( $res as $x ) {
				$pdbk = $page_ids[$x->cl_from];
				if ( array_key_exists( $x->cl_to, $qualityCategories ) ) {
					$colours[$pdbk] = $qualityCategories[$x->cl_to];
				}
			}
		}
	}

	/**
	 * @param  $imgpage ImagePage:
	 * @param  $out OutputPage:
	 * @return bool
	 */
	public static function onImageOpenShowImageInlineBefore( &$imgpage, &$out ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$image = $imgpage->getFile();
		if ( !$image->isMultipage() ) {
			return true;
		}
		$name = $image->getTitle()->getText();
		$title = Title::newFromText("$index_namespace:$name");
		$link = Linker::link( $title, wfMsg( 'proofreadpage_image_message' ), array(), array(), 'known' );
		$out->addHTML( "{$link}" );
		return true;
	}

	// credit : http://www.mediawiki.org/wiki/Extension:RomanNumbers
	private static function toRoman( $num ) {
		if ( $num < 0 || $num > 9999 ) {
			return - 1;
		}
		$romanOnes = array(
			1 => 'I',
			2 => 'II',
			3 => 'III',
			4 => 'IV',
			5 => 'V',
			6 => 'VI',
			7 => 'VII',
			8 => 'VIII',
			9 => 'IX'
		);
		$romanTens = array(
			1 => 'X',
			2 => 'XX',
			3 => 'XXX',
			4 => 'XL',
			5 => 'L',
			6 => 'LX',
			7 => 'LXX',
			8 => 'LXXX',
			9 => 'XC'
		);
		$romanHund = array(
			1 => 'C',
			2 => 'CC',
			3 => 'CCC',
			4 => 'CD',
			5 => 'D',
			6 => 'DC',
			7 => 'DCC',
			8 => 'DCCC',
			9 => 'CM'
		);
		$romanThou = array(
			1 => 'M',
			2 => 'MM',
			3 => 'MMM',
			4 => 'MMMM',
			5 => 'MMMMM',
			6 => 'MMMMMM',
			7 => 'MMMMMMM',
			8 => 'MMMMMMMM',
			9 => 'MMMMMMMMM'
		);

		$ones = $num % 10;
		$tens = ( $num - $ones ) % 100;
		$hund = ( $num - $tens - $ones ) % 1000;
		$thou = ( $num - $hund - $tens - $ones ) % 10000;

		$tens = $tens / 10;
		$hund = $hund / 100;
		$thou = $thou / 1000;

		$romanNum = '';
		if ( $thou ) {
			$romanNum .= $romanThou[$thou];
		}
		if ( $hund ) {
			$romanNum .= $romanHund[$hund];
		}
		if ( $tens ) {
			$romanNum .= $romanTens[$tens];
		}
		if ( $ones ) {
			$romanNum .= $romanOnes[$ones];
		}

		return $romanNum;
	}

	private static function pageNumber( $i, $args ) {
		$mode = 'normal'; // default
		$offset = 0;
		$links = true;
		foreach ( $args as $num => $param ) {
			if ( ( preg_match( "/^([0-9]*)to([0-9]*)$/", $num, $m ) && ( $i >= $m[1] && $i <= $m[2] ) )
			     || ( is_numeric( $num ) && ( $i == $num ) ) ) {
				$params = explode( ';', $param );
				foreach ( $params as $iparam ) {
					switch( $iparam ) {
					case 'roman':
						$mode = 'roman';
						break;
					case 'highroman':
						$mode = 'highroman';
						break;
					case 'empty':
						$links = false;
						break;
					default:
						if ( !is_numeric( $iparam ) ) {
							$mode = $iparam;
						}
					}
				}
			}

			if ( is_numeric( $num ) && ( $i >= $num ) )  {
				$params = explode( ';', $param );
				foreach ( $params as $iparam ) {
					if ( is_numeric( $iparam ) ) {
						$offset = $num - $iparam;
					}
				}
			}

		}
		$view = ( $i - $offset );
		switch( $mode ) {
		case 'highroman':
			$view = self::toRoman( $view );
			break;
		case 'roman':
			$view = strtolower( self::toRoman( $view ) );
			break;
		case 'normal':
			$view = '' . $view;
			break;
		case 'empty':
			$view = '' . $view;
			break;
		default:
			$view = $mode;
		}
		return array( $view, $links, $mode );
	}

	/**
	 * Add the pagequality category.
	 * @todo FIXME: display whether page has been proofread by the user or by someone else
	 */
	public static function pageQuality( $input, $args, $parser ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		if ( !preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}

		$q = $args['level'];
		if( !in_array( $q, array( '0', '1', '2', '3', '4' ) ) ) {
			return '';
		}
		$message = "<div id=\"pagequality\" width=100% class=quality$q>" .
			wfMsgForContent( "proofreadpage_quality{$q}_message" ) . '</div>';
		$out = '__NOEDITSECTION__[[Category:' .
			wfMsgForContent( "proofreadpage_quality{$q}_category" ) . ']]';
		return $parser->recursiveTagParse( $out . $message );
	}

	/**
	 * Parser hook for index pages
	 * Display a list of coloured links to pages
	 */
	public static function renderPageList( $input, $args, $parser ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		if ( !preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText(), $m ) ) {
			return '';
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		if ( !$imageTitle ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
		}

		$image = wfFindFile( $imageTitle );
		if ( !( $image && $image->isMultipage() && $image->pageCount() ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
		}

		$return = '';

		$name = $imageTitle->getDBkey();
		$count = $image->pageCount();

		$from = array_key_exists( 'from', $args ) ? $args['from'] : 1;
		$to = array_key_exists( 'to', $args ) ? $args['to'] : $count;

		if( !is_numeric( $from ) || !is_numeric( $to ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_number_expected' ) . '</strong>';
		}
		if( ( $from > $to ) || ( $from < 1 ) || ( $to < 1 ) || ( $to > $count ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_invalid_interval' ) . '</strong>';
		}

		for ( $i = $from; $i < $to + 1; $i++ ) {
			$pdbk = "$page_namespace:$name" . '/' . $i ;
			list( $view, $links, $mode ) = self::pageNumber( $i, $args );

			if ( $mode == 'highroman' || $mode == 'roman' ) {
				$view = '&#160;' . $view;
			}

			$n = strlen( $count ) - strlen( $view );
			if ( $n && ( $mode == 'normal' || $mode == 'empty' ) ) {
				$txt = '<span style="visibility:hidden;">';
				for ( $j = 0; $j < $n; $j++ ) {
					$txt = $txt . '0';
				}
				$view = $txt . '</span>' . $view;
			}
			$title = Title::newFromText( $pdbk );

			if ( $links == false ) {
				$return .= $view . ' ';
			} else {
				$return .= '[[' . $title->getPrefixedText() . "|$view]] ";
			}
		}
		$return = $parser->recursiveTagParse( $return );
		return $return;
	}

	/**
	 * Parser hook that includes a list of pages.
	 *  parameters : index, from, to, header
	 */
	public static function renderPages( $input, $args, $parser ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();

		$index = array_key_exists( 'index', $args ) ? $args['index'] : null;
		$from = array_key_exists( 'from', $args ) ? $args['from'] : null;
		$to = array_key_exists( 'to', $args ) ? $args['to'] : null;
		$header = array_key_exists( 'header', $args ) ? $args['header'] : null;
		$tosection = array_key_exists( 'tosection', $args ) ? $args['tosection'] : null;
		$fromsection = array_key_exists( 'fromsection', $args ) ? $args['fromsection'] : null;

		// abort if the tag is on an index page
		if ( preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}
		// abort too if the tag is in the page namespace
		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}
		if( !$index ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_index_expected' ) . '</strong>';
		}
		$index_title = Title::newFromText( "$index_namespace:$index" );
		if( !$index_title || !$index_title->exists() ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_index' ) . '</strong>';
		}

		$parser->getOutput()->addTemplate( $index_title, $index_title->getArticleID(), $index_title->getLatestRevID() );

		$out = '';

		list( $links, $params, $attributes ) = self::parse_index( $index_title );

		if( $from || $to ) {
			$pages = array();
			if( $links == null ) {
				$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index );
				if ( !$imageTitle ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
				}
				$image = wfFindFile( $imageTitle );
				if ( !( $image && $image->isMultipage() && $image->pageCount() ) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
				}
				$count = $image->pageCount();

				if( !$from ) {
					$from = 1;
				}
				if( !$to ) {
					$to = $count;
				}

				if( !is_numeric( $from ) || !is_numeric( $to ) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_number_expected' ) . '</strong>';
				}
				if( ($from > $to) || ($from < 1) || ($to < 1 ) || ($to > $count) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_invalid_interval' ) . '</strong>';
				}
				if( $to - $from > 1000 ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_interval_too_large' ) . '</strong>';
				}

				for( $i = $from; $i <= $to; $i++ ) {
					list( $pagenum, $links, $mode ) = self::pageNumber( $i, $params );
					$page = str_replace( ' ' , '_', "$index/" . $i );
					if( $i == $from ) {
						$from_page = $page;
						$from_pagenum = $pagenum;
					}
					if( $i == $to ) {
						$to_page = $page;
						$to_pagenum = $pagenum;
					}
					$pages[] = array( $page, $pagenum );
				}
			} else {
				if( $from ) {
					$adding = false;
				} else {
					$adding = true;
					$from_pagenum = $links[3][0];
				}
				for( $i = 0; $i < count( $links[1] ); $i++ ) {
					$text = $links[1][$i];
					$pagenum = $links[3][$i];
					if( $text == $from ) {
						$adding = true;
						$from_page = $from;
						$from_pagenum = $pagenum;
					}
					if( $adding ) {
						$pages[] = array( $text, $pagenum );
					}
					if( $text == $to ) {
						$adding = false;
						$to_page = $to;
						$to_pagenum = $pagenum;
					}
				}
				if( !$to ) {
					$to_pagenum = $links[3][count( $links[1] ) - 1];
				}
			}
			// find which pages have quality0
			$q0_pages = array();
			if( !empty( $pages ) ) {
				$pp = array();
				foreach( $pages as $item ) {
					list( $page, $pagenum ) = $item;
					$pp[] = $page;
				}
				$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( str_replace( ' ', '_', $page_namespace ) ) );
				$dbr = wfGetDB( DB_SLAVE );
				$cat = str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality0_category' ) );
				$res = $dbr->select(
						    array( 'page', 'categorylinks' ),
						    array( 'page_title' ),
						    array(
							  'page_title' => $pp,
							  'cl_to' => $cat,
							  'page_namespace' => $page_ns_index
							  ),
						    __METHOD__,
						    null,
						    array( 'categorylinks' => array( 'LEFT JOIN', 'cl_from=page_id' ) )
						    );

				if( $res ) {
					foreach ( $res as $o ) {
						array_push( $q0_pages, $o->page_title );
					}
				}
			}

			// write the output
			foreach( $pages as $item ) {
				list( $page, $pagenum ) = $item;
				if( in_array( $page, $q0_pages ) ) {
					$is_q0 = true;
				} else {
					$is_q0 = false;
				}
				$text = "$page_namespace:$page";
				if( !$is_q0 ) {
					$out .= '<span>{{:MediaWiki:Proofreadpage_pagenum_template|page=' . $text . "|num=$pagenum}}</span>";
				}
				if( $page == $from_page && $fromsection !== null ) {
					$ts = '';
					// Check if it is single page transclusion
					if ( $page == $to_page && $tosection !== null ) {
						$ts = $tosection;
					}
					$out .= '{{#lst:' . $text . '|' . $fromsection . '|' . $ts .'}}';
				} elseif( $page == $to_page && $tosection !== null ) {
					$out .= '{{#lst:' . $text . '||' . $tosection . '}}';
				} else {
					$out .= '{{:' . $text . '}}';
				}
				if( !$is_q0 ) {
					$out.= "&#32;";
				}
			}
		} else {
			/* table of Contents */
			$header = 'toc';
			if( $links == null ) {
				$firstpage = str_replace( ' ' , '_', "$index/1" );
			} else {
				$firstpage = $links[1][0];
			}
			$firstpage_title = Title::newFromText( "$page_namespace:$firstpage" );
			if ( $firstpage_title ) {
				$parser->getOutput()->addTemplate(
					$firstpage_title,
					$firstpage_title->getArticleID(),
					$firstpage_title->getLatestRevID()
				);
			}
		}

		if( $header ) {
			if( $header == 'toc') {
				$parser->getOutput()->is_toc = true;
			}
			$text_links = self::parse_index_links( $index_title );
			$h_out = '{{:MediaWiki:Proofreadpage_header_template';
			$h_out .= "|value=$header";
			// find next and previous pages in list
			for( $i = 1; $i < count( $text_links[1] ); $i++ ) {
				if( $text_links[1][$i] == $parser->Title()->getPrefixedText() ) {
					$current = $text_links[0][$i];
					break;
				}
			}
			if( ( $i > 1 ) && ( $i < count( $text_links[1] ) ) ) {
				$prev = $text_links[0][$i - 1];
			}
			if( ( $i >= 1 ) && ( $i + 1 < count( $text_links[1] ) ) ) {
				$next = $text_links[0][$i + 1];
			}
			if( isset( $args['current'] ) ) {
				$current = $args['current'];
			}
			if( isset( $args['prev'] ) ) {
				$prev = $args['prev'];
			}
			if( isset( $args['next'] ) ) {
				$next = $args['next'];
			}
			if( isset( $current ) ) {
				$h_out .= "|current=$current";
			}
			if( isset( $prev ) ) {
				$h_out .= "|prev=$prev";
			}
			if( isset( $next ) ) {
				$h_out .= "|next=$next";
			}
			if( isset( $from_pagenum ) ) {
				$h_out .= "|from=$from_pagenum";
			}
			if( isset( $to_pagenum ) ) {
				$h_out .= "|to=$to_pagenum";
			}
			foreach ( $attributes as $key => $val ) {
				if( array_key_exists( $key, $args ) ) {
					$val = $args[$key];
				}
				$h_out .= "|$key=$val";
			}
			$h_out .= '}}';
			$out = $h_out . $out ;
		}

		// wrap the output in a div, to prevent the parser from inserting pararaphs
		$out = "<div>\n$out\n</div>";
		$out = $parser->recursiveTagParse( $out );
		return $out;
	}

	/**
	 * Set is_toc flag (true if page is a table of contents)
	 */
	public static function onOutputPageParserOutput( $outputPage, $parserOutput ) {
		if( isset( $parserOutput->is_toc ) ) {
			$outputPage->is_toc = $parserOutput->is_toc;
		} else {
			$outputPage->is_toc = false;
		}
		return true;
	}

	/**
	 * Try to parse a page.
	 * Return quality status of the page and username of the proofreader
	 * Return -1 if the page cannot be parsed
	 */
	private static function parse_page( $text, $title ) {
		global $wgUser;

		$username = $wgUser->getName();
		$page_regexp = "/^<noinclude>(.*?)<\/noinclude>(.*?)<noinclude>(.*?)<\/noinclude>$/s";
		if( !preg_match( $page_regexp, $text, $m ) ) {
			self::load_index( $title );
			list( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width ) = self::navigation( $title );
			$new_text = "<noinclude><pagequality level=\"1\" user=\"$username\" /><div class=\"pagetext\">"
				."$header\n\n\n</noinclude>$text<noinclude>\n$footer</div></noinclude>";
			return array( -1, null, $new_text );
		}

		$header = $m[1];
		$body = $m[2];
		$footer = $m[3];

		$header_regexp = "/^<pagequality level=\"(0|1|2|3|4)\" user=\"(.*?)\" \/>/";
		if( preg_match( $header_regexp, $header, $m2 ) ) {
			return array( intval($m2[1]), $m2[2], null );
		}

		$old_header_regexp = "/^\{\{PageQuality\|(0|1|2|3|4)(|\|(.*?))\}\}/is";
		if( preg_match( $old_header_regexp, $header, $m3 ) ) {
			return array( intval($m3[1]), $m3[3], null );
		}

		$new_text = "<noinclude><pagequality level=\"1\" user=\"$username\" />"
			. "$header\n\n\n</noinclude>$body<noinclude>\n$footer</noinclude>";
		return array( -1, null, $new_text );
	}

	public static function onEditPageImportFormData( $editpage, $request ) {
		$title = $editpage->mTitle;
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		// abort if we are not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			return true;
		}
		if ( !$request->wasPosted() ) {
			return true;
		}
		$editpage->quality = $request->getVal( 'quality' );
		$editpage->username = $editpage->safeUnicodeInput( $request, 'wpProofreader' );
		$editpage->header = $editpage->safeUnicodeInput( $request, 'wpHeaderTextbox' );
		$editpage->footer = $editpage->safeUnicodeInput( $request, 'wpFooterTextbox' );

		// we want to keep ordinary spaces at the end of the main textbox
		$text = rtrim( $request->getText( 'wpTextbox1' ), "\t\n\r\0\x0B" );
		$editpage->textbox1 = $request->getBool( 'safemode' )
			? $editpage->unmakesafe( $text )
			: $text;

		if( in_array( $editpage->quality, array( '0', '1', '2', '3', '4' ) ) ) {
			// format the page
			$text = '<noinclude><pagequality level="' . $editpage->quality . '" user="' . $editpage->username . '" />' .
				'<div class="pagetext">' . $editpage->header."\n\n\n</noinclude>" .
				$editpage->textbox1 .
				"<noinclude>" . $editpage->footer . '</div></noinclude>';
			$editpage->textbox1 = $text;
		} else {
			// replace deprecated template
			$text = $editpage->textbox1;
			$text = preg_replace(
				"/\{\{PageQuality\|(0|1|2|3|4)(|\|(.*?))\}\}/is",
				"<pagequality level=\"\\1\" user=\"\\3\" />",
				$text
			);
			$editpage->textbox1 = $text;
		}
		return true;
	}

	/**
	 * Check the format of pages in "Page" namespace.
	 *
	 * @param $editpage Object: EditPage object
	 * @return Boolean
	 */
	public static function onEditPageAttemptSave( $editpage ) {
		global $wgOut, $wgUser;

		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$title = $editpage->mTitle;

		// check that pages listed on an index are unique.
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$text = $editpage->textbox1;
			list( $links, $params, $attributes ) = self::parse_index_text( $text );
			if( $links != null && count( $links[1] ) != count( array_unique( $links[1] ) ) ) {
				$wgOut->showErrorPage( 'proofreadpage_indexdupe', 'proofreadpage_indexdupetext' );
				return false;
			};
			return true;
		}

		// abort if we are not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			return true;
		}

		$text = $editpage->textbox1;
		// parse the page
		list( $q, $username, $ptext ) = self::parse_page( $text, $title );
		if( $q == -1 ) {
			$editpage->textbox1 = $ptext;
			$q = 1;
		}

		// read previous revision, so that I know how much I need to add to pr_index
		$rev = Revision::newFromTitle( $title );
		if( $rev ) {
			$old_text = $rev->getText();
			list( $old_q, $old_username, $old_ptext ) = self::parse_page( $old_text, $title );
			if( $old_q != -1 ) {
				// check usernames
				if( ( $old_q != $q ) && !$wgUser->isAllowed( 'pagequality' ) ) {
					$wgOut->showErrorPage( 'proofreadpage_nologin', 'proofreadpage_nologintext' );
					return false;
				}
				if ( ( ( $old_username != $username ) || ( $old_q != $q ) ) && ( $wgUser->getName() != $username ) ) {
					$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
					return false;
				}
				if( ( ( $q == 4 ) && ( $old_q < 3 ) ) || ( ( $q == 4 ) && ( $old_q == 3 ) && ( $old_username == $username ) ) ) {
					$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
					return false;
				}
			} else {
				$old_q = 1;
			}
		} else {
			if( $q == 4 ) {
				$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
				return false;
			}
			$old_q = -1;
		}

		$editpage->mArticle->new_q = $q;
		$editpage->mArticle->old_q = $old_q;

		return true;
	}

	/**
	 * if I delete a page, I need to update the index table
	 * if I delete an index page too...
	 *
	 * @param $article Object: Article object
	 * @return Boolean: true
	 */
	public static function onArticleDelete( $article ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$title = $article->getTitle();

		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$id = $article->getID();
			$dbw = wfGetDB( DB_MASTER );
			$pr_index = $dbw->tableName( 'pr_index' );
			$dbw->query( "DELETE FROM $pr_index WHERE pr_page_id=$id", __METHOD__ );
			$dbw->commit();
			return true;
		}

		if ( preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			self::load_index( $title );
			if( $title->pr_index_title ) {
				$index_title = Title::newFromText( $title->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					self::update_pr_index( $index, $title->getDBKey() );
				}
			}
			return true;
		}

		return true;
	}

	public static function onArticleSaveComplete( $article ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$title = $article->mTitle;

		// if it's an index, update pr_index table
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText(), $m ) ) {
			self::update_pr_index( $article );
			return true;
		}

		// return if it is not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			return true;
		}

		$dbw = wfGetDB( DB_MASTER );

		/* check if there is an index */
		if ( !isset( $title->pr_index_title ) ) {
			self::load_index( $title );
		}
		if( ! $title->pr_index_title ) {
			return true;
		}

		/**
		 * invalidate the cache of the index page
		 */
		if ( $title->pr_index_title ) {
			$index_title = Title::newFromText( $title->pr_index_title );
			$index_title->invalidateCache();
		}

		/**
		 * update pr_index iteratively
		 */
		$index = new Article( $index_title );
		$index_id = $index->getID();
		$dbr = wfGetDB( DB_SLAVE );
		$pr_index = $dbr->tableName( 'pr_index' );
		$query = "SELECT * FROM $pr_index WHERE pr_page_id=" . $index_id;
		$res = $dbr->query( $query, __METHOD__ );
		$x = $dbr->fetchObject( $res );
		if( $x ) {
			$n  = $x->pr_count;
			$n0 = $x->pr_q0;
			$n1 = $x->pr_q1;
			$n2 = $x->pr_q2;
			$n3 = $x->pr_q3;
			$n4 = $x->pr_q4;

			switch( $article->new_q ) {
				case 0:
					$n0 = $n0 + 1;
					break;
				case 1:
					$n1 = $n1 + 1;
					break;
				case 2:
					$n2 = $n2 + 1;
					break;
				case 3:
					$n3 = $n3 + 1;
					break;
				case 4:
					$n4 = $n4 + 1;
					break;
			}

			switch( $article->old_q ) {
				case 0:
					$n0 = $n0 - 1;
					break;
				case 1:
					$n1 = $n1 - 1;
					break;
				case 2:
					$n2 = $n2 - 1;
					break;
				case 3:
					$n3 = $n3 - 1;
					break;
				case 4:
					$n4 = $n4 - 1;
					break;
			}

			$query = "REPLACE INTO $pr_index (pr_page_id, pr_count, pr_q0, pr_q1, pr_q2, pr_q3, pr_q4) VALUES ({$index_id},$n,$n0,$n1,$n2,$n3,$n4)";
			$dbw->query( $query, __METHOD__ );
			$dbw->commit();

		}

		return true;
	}

	/* Preload text layer from multipage formats */
	public static function onEditFormPreloadText( $textbox1, $mTitle ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		if ( preg_match( "/^$page_namespace:(.*?)\/([0-9]*)$/", $mTitle->getPrefixedText(), $m ) ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
			if ( !$imageTitle ) {
				return true;
			}

			$image = wfFindFile( $imageTitle );
			if ( $image && $image->exists() ) {
				$text = $image->getHandler()->getPageText( $image, $m[2] );
				if ( $text ) {
					$text = preg_replace( "/(\\\\n)/", "\n", $text );
					$text = preg_replace( "/(\\\\\d*)/", '', $text );
					$textbox1 = $text;
				}
			}
		}
		return true;
	}

	public static function onSpecialMovepageAfterMove( $form, $ot, $nt ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		if ( preg_match( "/^$page_namespace:(.*)$/", $ot->getPrefixedText() ) ) {
			self::load_index( $ot );
			if( $ot->pr_index_title ) {
				$index_title = Title::newFromText( $ot->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					self::update_pr_index( $index );
				}
			}
			return true;
		}

		if ( preg_match( "/^$page_namespace:(.*)$/", $nt->getPrefixedText() ) ) {
			self::load_index( $nt );
			if( $nt->pr_index_title && ( $nt->pr_index_title != $ot->pr_index_title ) ) {
				$index_title = Title::newFromText( $nt->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					self::update_pr_index( $index );
				}
			}
			return true;
		}
		return true;
	}

	/**
	 * When an index page is created or purged, recompute pr_index values
	 */
	public static function onArticlePurge( $article ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$title = $article->getTitle();
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			self::update_pr_index( $article );
			return true;
		}
		return true;
	}

	/**
	 * @param  $dbr DatabaseBase
	 * @param  $query
	 * @param  $cat
	 * @return int
	 */
	private static function query_count( $dbr, $query, $cat ) {
		$query['conds']['cl_to'] = str_replace( ' ' , '_' , wfMsgForContent( $cat ) );
		$res = $dbr->select( $query['tables'], $query['fields'], $query['conds'], __METHOD__, array(), $query['joins'] );

		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$n = $row->count;
			return $n;
		}
		return 0;
	}

	/**
	 * Update the pr_index entry of an article
	 */
	private static function update_pr_index( $index, $deletedpage = null ) {
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( str_replace( ' ', '_', $page_namespace ) ) );
		if ( $page_ns_index == null ) {
			return;
		}

		$index_title = $index->mTitle;
		$index_id = $index->getID();
		$dbr = wfGetDB( DB_SLAVE );

		$n = 0;

		// read the list of pages
		$pages = array();
		list( $links, $params, $attributes ) = self::parse_index( $index_title );
		if( $links == null ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index_title->getText() );
			if ( $imageTitle ) {
				$image = wfFindFile( $imageTitle );
				if ( $image && $image->isMultipage() && $image->pageCount() ) {
					$n = $image->pageCount();
					for ( $i = 1; $i <= $n; $i++ ) {
						$page = $dbr->strencode( $index_title->getDBKey() . '/' . $i );
						if( $page != $deletedpage ) {
							array_push( $pages, $page );
						}
					}
				}
			}
		} else {
			$n = count( $links[1] );
			for ( $i = 0; $i < $n; $i++ ) {
				$page = $dbr->strencode( str_replace( ' ' , '_' , $links[1][$i] ) );
				if( $page != $deletedpage ) {
					array_push( $pages, $page );
				}
			}
		}

		if( $n == 0 ) {
			return;
		}

		$res = $dbr->select(
			array( 'page' ),
			array( 'COUNT(page_id) AS count'),
			array( 'page_namespace' => $page_ns_index, 'page_title' => $pages ),
			__METHOD__
		);

		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$total = $row->count;
		} else {
			return;
		}

		// proofreading status of pages
		$queryArr = array(
			'tables' => array( 'page', 'categorylinks' ),
			'fields' => array( 'COUNT(page_id) AS count' ),
			'conds' => array( 'cl_to' => '', 'page_namespace' => $page_ns_index, 'page_title' => $pages ),
			'joins' => array( 'categorylinks' => array( 'LEFT JOIN', 'cl_from=page_id' ) )
		);

		$n0 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality0_category' );
		$n2 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality2_category' );
		$n3 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality3_category' );
		$n4 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality4_category' );
		$n1 = $total - $n0 - $n2 - $n3 - $n4;

		$dbw = wfGetDB( DB_MASTER );
		$pr_index = $dbw->tableName( 'pr_index' );
		$query = "REPLACE INTO $pr_index (pr_page_id, pr_count, pr_q0, pr_q1, pr_q2, pr_q3, pr_q4) VALUES ({$index_id},$n,$n0,$n1,$n2,$n3,$n4)";
		$dbw->query( $query, __METHOD__ );
		$dbw->commit();
	}

	/**
	 * In main namespace, display the proofreading status of transcluded pages.
	 *
	 * @param $out Object: OutputPage object
	 */
	private static function prepareArticle( $out ) {
		global $wgUser;

		$id = $out->getTitle()->mArticleID;
		if( $id == -1 ) {
			return true;
		}
		list( $page_namespace, $index_namespace ) = self::getPageAndIndexNamespace();
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( str_replace( ' ', '_', $page_namespace ) ) );
		$index_ns_index = MWNamespace::getCanonicalIndex( strtolower( str_replace( ' ', '_', $index_namespace ) ) );
		if( $page_ns_index == null || $index_ns_index == null ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE );

		// find the index page
		$indextitle = null;
		$res = $dbr->select(
			array( 'templatelinks' ),
			array( 'tl_title AS title' ),
			array( 'tl_from' => $id, 'tl_namespace' => $page_ns_index ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$res2 = $dbr->select(
				array( 'pagelinks', 'page' ),
				array( 'page_title AS title' ),
				array(
					'pl_title' => $row->title,
					'pl_namespace' => $page_ns_index,
					'page_namespace' => $index_ns_index
				),
				__METHOD__,
				array( 'LIMIT' => 1 ),
				array( 'page' => array( 'LEFT JOIN', 'page_id=pl_from' ) )
			);
			if( $res2 && $dbr->numRows( $res2 ) > 0 ) {
				$row = $dbr->fetchObject( $res2 );
				$indextitle = $row->title;
			}
		}

		if( isset( $out->is_toc ) && $out->is_toc ) {
			if ( $indextitle ) {
				$res = $dbr->select(
					array( 'pr_index', 'page' ),
					array( 'pr_count', 'pr_q0', 'pr_q1', 'pr_q2', 'pr_q3', 'pr_q4' ),
					array( 'page_title' => $indextitle, 'page_namespace' => $index_ns_index ),
					__METHOD__,
					null,
					array( 'page' => array( 'LEFT JOIN', 'page_id=pr_page_id' ) )
				);
				$row = $dbr->fetchObject( $res );
				if( $row ) {
					$n0 = $row->pr_q0;
					$n1 = $row->pr_q1;
					$n2 = $row->pr_q2;
					$n3 = $row->pr_q3;
					$n4 = $row->pr_q4;
					$n = $row->pr_count;
					$ne = $n - ( $n0 + $n1 + $n2 + $n3 + $n4 );
				}
			}
		} else {
			// count transclusions from page namespace
			$res = $dbr->select(
				array( 'templatelinks', 'page' ),
				array( 'COUNT(page_id) AS count' ),
				array( 'tl_from' => $id, 'tl_namespace' => $page_ns_index ),
				__METHOD__,
				null,
				array( 'page' => array( 'LEFT JOIN', 'page_title=tl_title AND page_namespace=tl_namespace' ) )
			);
			if( $res && $dbr->numRows( $res ) > 0 ) {
				$row = $dbr->fetchObject( $res );
				$n = $row->count;
			}

			// find the proofreading status of transclusions
			$queryArr = array(
				'tables' => array( 'templatelinks', 'page', 'categorylinks' ),
				'fields' => array( 'COUNT(page_id) AS count' ),
				'conds' => array( 'tl_from' => $id, 'tl_namespace' => $page_ns_index, 'cl_to' => '' ),
				'joins' => array(
					'page' => array( 'LEFT JOIN', 'page_title=tl_title AND page_namespace=tl_namespace' ),
					'categorylinks' => array( 'LEFT JOIN', 'cl_from=page_id' ),
				)
			);

			$n0 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality0_category' );
			$n2 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality2_category' );
			$n3 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality3_category' );
			$n4 = self::query_count( $dbr, $queryArr, 'proofreadpage_quality4_category' );
			// quality1 is the default value
			$n1 = $n - $n0 - $n2 - $n3 - $n4;
			$ne = 0;
		}

		if( $n == 0 ) {
			return true;
		}

		if( $indextitle ) {
			$sk = $wgUser->getSkin();
			$nt = Title::makeTitleSafe( $index_ns_index, $indextitle );
			$indexlink = $sk->link( $nt, wfMsg( 'proofreadpage_source' ),
						array( 'title' => wfMsg( 'proofreadpage_source_message' ) ) );
			$out->addInlineScript( ResourceLoader::makeConfigSetScript( array( 'proofreadpage_source_href' => $indexlink ) ) );
			$out->addModules( 'ext.proofreadpage.article' );
		}

		$q0 = $n0 * 100 / $n;
		$q1 = $n1 * 100 / $n;
		$q2 = $n2 * 100 / $n;
		$q3 = $n3 * 100 / $n;
		$q4 = $n4 * 100 / $n;
		$qe = $ne * 100 / $n;
		$void_cell = $ne ? "<td align=center style='border-style:dotted;border-width:1px;' width=\"{$qe}\"></td>" : '';
		$output = "<table class=\"pr_quality\" style=\"line-height:40%;\" border=0 cellpadding=0 cellspacing=0 ><tr>
<td align=center >&#160;</td>
<td align=center class='quality4' width=\"$q4\"></td>
<td align=center class='quality3' width=\"$q3\"></td>
<td align=center class='quality2' width=\"$q2\"></td>
<td align=center class='quality1' width=\"$q1\"></td>
<td align=center class='quality0' width=\"$q0\"></td>
$void_cell
</tr></table>";
		$out->setSubtitle( $out->getSubtitle() . $output );
		return true;
	}

}
