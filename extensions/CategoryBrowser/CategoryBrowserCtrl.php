<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

/**
 * browsing class - both for special page and AJAX calls
 */
class CategoryBrowser {

	function __construct() {
		CB_Setup::initUser();
	}

	/**
	 * include stylesheets and scripts; set javascript variables
	 * @param $outputPage - an instance of OutputPage
	 * @param $isRTL - whether the current language is RTL
	 * currently set: cookie prefix;
	 * localAllOp, local1opTemplate, local2opTemplate, localDbFields, localBrackets, localBoolOps, localCmpOps
	 */
	static function headScripts( &$outputPage, $isRTL ) {
		global $wgJsMimeType;
		$outputPage->addLink(
			array( 'rel' => 'stylesheet', 'type' => 'text/css', 'href' => CB_Setup::$ScriptPath . '/category_browser.css?' . CB_Setup::$version )
		);
		if ( $isRTL ) {
			$outputPage->addLink(
				array( 'rel' => 'stylesheet', 'type' => 'text/css', 'href' => CB_Setup::$ScriptPath . '/category_browser_rtl.css?' . CB_Setup::$version )
			);
		}
		$outputPage->addScript(
			'<script type="' . $wgJsMimeType . '" src="' . CB_Setup::$ScriptPath . '/category_browser.js?' . CB_Setup::$version . '"></script>
			<script type="' . $wgJsMimeType . '">
			CB_lib.setCookiePrefix("' . CB_Setup::getJsCookiePrefix() . '");
			CB_ConditionEditor.setLocalNames( ' .
				CategoryBrowser::getJsObject( 'cbLocalMessages', 'apply_button', 'all_op', 'op1_template', 'op2_template', 'ie6_warning' ) . ", \n\t\t\t" .
				CategoryBrowser::getJsObject( 'cbLocalEditHints', 'left', 'right', 'remove', 'copy', 'append', 'clear', 'paste', 'paste_right' ) . ", \n\t\t\t" .
				CategoryBrowser::getJsObject( 'cbLocalDbFields', 's', 'p', 'f' ) . ", \n\t\t\t" .
				CategoryBrowser::getJsObject( 'cbLocalOps', 'lbracket', 'rbracket' ) . ", \n\t\t\t" .
				CategoryBrowser::getJsObject( 'cbLocalOps', 'or', 'and' ) . ", \n\t\t\t" .
				CategoryBrowser::getJsObject( 'cbLocalOps', 'le', 'ge', 'eq' ) .
				' );</script>' . "\n" );
	}

	static function getJsObject( $method_name ) {
		$args = func_get_args();
		array_shift( $args ); // remove $method_name from $args
		$result = '{ ';
		$firstElem = true;
		foreach ( $args as &$arg ) {
			if ( $firstElem ) {
				$firstElem = false;
			} else {
				$result .= ', ';
			}
			$result .= $arg . ': "' . Xml::escapeJsString( call_user_func( array( 'self', $method_name ), $arg ) ) . '"';
		}
		$result .= ' }';
		return $result;
	}

	/**
	 * currently passed to Javascript:
	 * localMessages, localDbFields, localBrackets, localBoolOps, localCmpOps
	 */
	/**
	 * getJsObject callback
	 */
	static private function cbLocalMessages( $arg ) {
		return wfMsg( "cb_${arg}" );
	}

	static private function cbLocalEditHints( $arg ) {
		return wfMsg( "cb_edit_${arg}_hint" );
	}

	/**
	 * getJsObject callback
	 */
	static private function cbLocalOps( $arg ) {
		return wfMsg( "cb_${arg}_op" );
	}

	/**
	 * getJsObject callback
	 */
	static private function cbLocalDbFields( $arg ) {
		return wfMsg( "cb_" . CB_SqlCond::$decoded_fields[ $arg ] );
	}

	/**
	 * generates "complete" ranges
	 * @param $source_ranges source ranges which contain only decoded infix queue
	 * @return "complete" ranges which contain decoded infix queue and encoded polish queue
	 */
	static function generateRanges( array &$source_ranges ) {
		$ranges = array();
		foreach ( $source_ranges as $infix_queue ) {
			$sqlCond = CB_SqlCond::newFromEncodedInfixQueue( $infix_queue );
			$sqlCond->getCond(); // build $sqlCond->infix_tokens
			$ranges[] = (object) array( 'infix_tokens' => $sqlCond->infix_tokens, 'rpn_queue' => $sqlCond->getEncodedQueue( false ) );
		}
		return $ranges;
	}

	/**
	 * add new "complete" range to "complete" ranges list
	 * @param $ranges "complete" ranges list (decoded infix, encoded polish)
	 * @param $sqlCond will be added to $ranges only when no such queue already exists
	 * @modifies $ranges
	 */
	static function addRange( array &$ranges, CB_SqlCond $sqlCond ) {
		$encPolishQueue = $sqlCond->getEncodedQueue( false );
		$queueExists = false;
		foreach ( $ranges as &$range ) {
			if ( $range->rpn_queue == $encPolishQueue ) {
				$queueExists = true;
				break;
			}
		}
		if ( !$queueExists ) {
			$sqlCond->getCond(); // build $sqlCond->infix_tokens array
			$ranges[] = (object) array( 'infix_tokens' => $sqlCond->infix_tokens, 'rpn_queue' => $encPolishQueue );
		}
	}

	/**
	 * generates SQL condition selector html code
	 * @param $ranges - array of "complete" (decode infix/encoded polish) token queues
	 * @param $rootPager - root pager currently used with this selector
	 * @return selector html code
	 */
	static function generateSelector( array &$ranges, CB_RootPager $rootPager ) {
		# {{{ condition form/select template
		$condOptList = array();
		// do not pass current pager's limit because it's meaningless
		// we need MAX (default) possible limit, not the current limit
		// also current limit is being calculated only during the call $pager->getCurrentRows()
		// TODO: implement the field to select pager's default limit
		$js_func_call = 'return CategoryBrowser.setExpr(this,' . CB_PAGING_ROWS . ')';
		// FF doesn't always fire onchange, IE doesn't always fire onmouseup
		$condFormTpl = array (
			array( '__tag' => 'noscript', 'class' => 'cb_noscript', 0 => wfMsg( 'cb_requires_javascript' ) ),
			array( '__tag' => 'form', '__end' => "\n",
				array( '__tag' => 'select', 'id' => 'cb_expr_select', 'onmouseup' => $js_func_call, 'onchange' => $js_func_call, '__end' => "\n", 0 => &$condOptList )
			)
		);
		# }}}
		$queueFound = false;
		$selectedEncPolishQueue = $rootPager->sqlCond->getEncodedQueue( false );
		foreach ( $ranges as &$range ) {
			$condOptList[] = self::generateOption( $range, $selectedEncPolishQueue );
			if ( $range->rpn_queue == $selectedEncPolishQueue ) {
				$queueFound = true;
			}
		}
		if ( !$queueFound ) {
			throw new MWException( 'Either the selected queue was not added to ranges list via CategoryBrowser::addRange(), or wrong ranges list passed to ' . __METHOD__ );
		}
		return CB_XML::toText( $condFormTpl );
	}

	static function generateOption( $range, $selectedValue, $nodeName = 'option' ) {
		# {{{ condition select's option template
		$condOptVal = '';
		$condOptName = '';
		$condOptInfix = '';
		$condOptTpl =
			array( '__tag' => $nodeName, 'value' => &$condOptVal, 'infixexpr' => &$condOptInfix, 0 => &$condOptName, '__end' => "\n" );
		# }}}
		$le = new CB_LocalExpr( $range->infix_tokens );
		$condOptVal = CB_Setup::specialchars( $range->rpn_queue );
		$sqlCond = CB_SqlCond::newFromEncodedPolishQueue( $range->rpn_queue );
		$condOptInfix = CB_Setup::specialchars( $sqlCond->getEncodedQueue( true ) );
		if ( $range->rpn_queue == $selectedValue ) {
			$condOptTpl['selected'] = null;
		}
		$condOptName = CB_Setup::entities( $le->toString() );
		return CB_XML::toText( $condOptTpl );
	}

	/**
	 * called via AJAX to get root list for specitied offset, limit
	 * where condition will be read from the cookie previousely set
	 * @param $args[0] : encoded reverse polish queue
	 * @param $args[1] : category name filter string
	 * @param $args[2] : category name filter case insensitive flag
	 * @param $args[3] : browse only categories which has no parents flag (by default, false)
	 * @param $args[4] : offset (optional)
	 * @param $args[5] : limit (optional)
	 */
	static function getRootOffsetHtml() {
		$args = func_get_args();
		$limit = ( count( $args ) > 5 ) ? abs( intval( $args[5] ) ) : CB_PAGING_ROWS;
		$offset = ( count( $args ) > 4 ) ? abs( intval( $args[4] ) ) : 0;
		$noParentsOnly = ( count( $args ) > 3 ) ? $args[3] == 'true' : false;
		$nameFilterCI = ( count( $args ) > 2 ) ? $args[2] == 'true' : false;
		$nameFilter = ( count( $args ) > 1 ) ? $args[1] : '';
		$encPolishQueue = ( count( $args ) > 0 ) ? $args[0] : 'all';
		$cb = new CategoryBrowser();
		$sqlCond = CB_SqlCond::newFromEncodedPolishQueue( $encPolishQueue );
		$rootPager = CB_RootPager::newFromSqlCond( $sqlCond, $offset, $limit );
		$rootPager->setNoParentsOnly( $noParentsOnly );
		$rootPager->setNameFilter( $nameFilter, $nameFilterCI );
		$rootPager->getCurrentRows();
		$catView = new CB_CategoriesView( $rootPager );
		$catlist = $catView->generateList();
		return CB_XML::toText( $catlist );
	}

	/**
	 * called via AJAX to setup custom edited expression cookie then display category root offset
	 * @param $args[0] : encoded infix expression
	 * @param $args[1] : category name filter string
	 * @param $args[2] : category name filter case insensitive flag
	 * @param $args[3] : browse only categories which has no parents flag (by default, false)
	 * @param $args[4] : 1 - cookie has to be set, 0 - cookie should not be set (expression is pre-defined or already was stored)
	 * @param $args[5] : pager limit (optional)
	 */
	static function applyEncodedQueue() {
		CB_Setup::initUser();
		$args = func_get_args();
		$limit = ( ( count( $args ) > 5 ) ? intval( $args[5] ) : CB_PAGING_ROWS );
		$setCookie = ( ( count( $args ) > 4 ) ? $args[4] != 0 : false );
		$noParentsOnly = ( count( $args ) > 3 ) ? $args[3] == 'true' : false;
		$nameFilterCI = ( count( $args ) > 2 ) ? $args[2] == 'true' : false;
		$nameFilter = ( count( $args ) > 1 ) ? $args[1] : '';
		$encInfixQueue = ( ( count( $args ) > 0 ) ? $args[0] : 'all' );
		$sqlCond = CB_SqlCond::newFromEncodedInfixQueue( $encInfixQueue );
		$encPolishQueue = $sqlCond->getEncodedQueue( false );
		if ( $setCookie ) {
			CB_Setup::setCookie( 'rootcond', $encPolishQueue, time() + 60 * 60 * 24 * 7 );
		}
		return self::getRootOffsetHtml( $encPolishQueue, $nameFilter, $nameFilterCI, $noParentsOnly, 0, $limit );
	}

	/**
	 * called via AJAX to get list of (subcategories,pages,files) for specitied parent category id, offset, limit
	 * @param $args[0] : type of pager ('subcats','pages','files')
	 * @param $args[1] : parent category name
	 * @param $args[2] : offset (optional)
	 * @param $args[3] : limit (optional)
	 */
	static function getSubOffsetHtml() {
		$pager_types = array(
			'subcats' => array(
				'js_nav_func' => "subCatsNav",
				'select_fields' => "cl_sortkey, cat_id, cat_title, cat_subcats, " . CB_AbstractPager::$cat_pages_only . ", cat_files",
				'ns_cond' => "page_namespace = " . NS_CATEGORY,
				'default_limit' => CB_Setup::$categoriesLimit
			),
			'pages' => array(
				'js_nav_func' => "pagesNav",
				'select_fields' => "page_title, page_namespace, page_len, page_is_redirect",
				'ns_cond' => "NOT page_namespace IN (" . NS_FILE . "," . NS_CATEGORY . ")",
				'default_limit' => CB_Setup::$pagesLimit
			),
			'files' => array(
				'js_nav_func' => "filesNav",
				'select_fields' => "page_title, page_namespace, page_len, page_is_redirect",
				'ns_cond' => "page_namespace = " . NS_FILE,
				'default_limit' => CB_Setup::$filesLimit
			),
			'parents' => array(
				'default_limit' => CB_Setup::$parentsLimit
			)
		);
		$args = func_get_args();
		if ( count( $args ) < 2 ) {
			return 'Too few parameters in ' . __METHOD__;
		}
		$pager_type = $args[0];
		if ( !isset( $pager_types[ $pager_type ] ) ) {
			return 'Unknown pager type=' . CB_Setup::specialchars( $pager_type ) . ' in ' . __METHOD__;
		}
		$pager_setup = & $pager_types[ $pager_type ];
		$limit = ( count( $args ) > 3 ) ? abs( intval( $args[3] ) ) : $pager_setup[ 'default_limit' ];
		$offset = ( count( $args ) > 2 ) ? abs( intval( $args[2] ) ) : 0;
		$parentCatName = $args[1];
		$cb = new CategoryBrowser();
		if ( $pager_type == 'parents' ) {
			$pager = new CB_ParentPager( $parentCatName, $offset, $limit );
		} else {
			$pager = new CB_SubPager( $parentCatName, $offset, $limit,
				$pager_setup[ 'js_nav_func' ],
				$pager_setup[ 'select_fields' ],
				$pager_setup[ 'ns_cond' ] );
		}
		$pager->getCurrentRows();
		switch ( $pager_type ) {
		case 'subcats' :
		case 'parents' :
			$view = new CB_CategoriesView( $pager );
			break;
		case 'pages' :
			$view = new CB_PagesView( $pager );
			break;
		case 'files' :
			# respect extension & core settings
			global $wgOut, $wgCategoryMagicGallery;
			// unstub $wgOut, otherwise $wgOut->mNoGallery may be unavailable
			// strange, but calling wfDebug() instead does not unstub $wgOut successfully
			$wgOut->getHeadItems();
			if ( CB_Setup::$imageGalleryPerRow < 1 || !$wgCategoryMagicGallery || $wgOut->mNoGallery ) {
				$view = new CB_PagesView( $pager );
			} else {
				$view = new CB_FilesView( $pager );
			}
			break;
		default :
			return 'Unknown list type in ' . __METHOD__;
		}
		$list = $view->generateList();
		return CB_XML::toText( $list );
	}

	/**
	 * called via AJAX to generate new selected option when the selected rootcond is new (the rootcond cookie was set)
	 * @param $args[0] currently selected expression in encoded infix format
	 */
	static function generateSelectedOption() {
		CB_Setup::initUser();
		$args = func_get_args();
		if ( count( $args ) < 1 ) {
			throw new MWException( 'Argument 0 is missing in ' . __METHOD__ );
		}
		$encInfixQueue = $args[0];
		$sqlCond = CB_SqlCond::newFromEncodedInfixQueue( $encInfixQueue );
		$ranges = array();
		self::addRange( $ranges, $sqlCond );
		# generate div instead of option to avoid innerHTML glitches in IE
		return self::generateOption( $ranges[0], $sqlCond->getEncodedQueue( false ), 'div' );
	}

} /* end of CategoryBrowser class */
