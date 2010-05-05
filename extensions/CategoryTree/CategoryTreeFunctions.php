<?php

/**
 * Core functions for the CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006-2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class CategoryTree {
	var $mIsAjaxRequest = false;
	var $mOptions = array();

	function __construct( $options, $ajax = false ) {
		global $wgCategoryTreeDefaultOptions;

		$this->mIsAjaxRequest = $ajax;

		#ensure default values and order of options. Order may become important, it may influence the cache key!
		foreach ( $wgCategoryTreeDefaultOptions as $option => $default ) {
			if ( isset( $options[$option] ) && !is_null( $options[$option] ) ) $this->mOptions[$option] = $options[$option];
			else $this->mOptions[$option] = $default;
		}

		$this->mOptions['mode'] = self::decodeMode( $this->mOptions['mode'] );

		if ( $this->mOptions['mode'] == CT_MODE_PARENTS ) {
			 $this->mOptions['namespaces'] = false; #namespace filter makes no sense with CT_MODE_PARENTS
		}

		$this->mOptions['hideprefix'] = self::decodeHidePrefix( $this->mOptions['hideprefix'] );
		$this->mOptions['showcount']  = self::decodeBoolean( $this->mOptions['showcount'] );
		$this->mOptions['namespaces']  = self::decodeNamespaces( $this->mOptions['namespaces'] );

		if ( $this->mOptions['namespaces'] ) {
			# automatically adjust mode to match namespace filter
			if ( sizeof( $this->mOptions['namespaces'] ) === 1  
				&& $this->mOptions['namespaces'][0] == NS_CATEGORY ) {
				$this->mOptions['mode'] = CT_MODE_CATEGORIES;
			} else if ( !in_array( NS_IMAGE, $this->mOptions['namespaces'] ) ) {
				$this->mOptions['mode'] = CT_MODE_PAGES;
			} else {
				$this->mOptions['mode'] = CT_MODE_ALL;
			}
		}
	}

	function getOption( $name ) {
		return $this->mOptions[$name];
	}

	function isInverse( ) {
		return $this->getOption('mode') == CT_MODE_PARENTS;
	}

	static function decodeNamespaces( $nn ) {
		global $wgContLang;

		if ( !$nn )
			return false;

		if ( !is_array($nn) ) 
			$nn = preg_split( '![\s#:|]+!', $nn );

		$namespaces = array();

		foreach ( $nn as $n ) {
			if ( is_int( $n ) ) {
				$ns = $n;
			}
			else {
				$n = trim( $n );
				if ( $n === '' ) continue;
	
				$lower = strtolower( $n );
	
				if ( is_numeric($n) )  $ns = (int)$n;
				elseif ( $n == '-' || $n == '_' || $n == '*' || $lower == 'main' ) $ns = NS_MAIN;
				else $ns = $wgContLang->getNsIndex( $n );
			}

			if ( is_int( $ns ) ) {
				$namespaces[] = $ns;
			}
		}

		sort( $namespaces ); # get elements into canonical order
		return $namespaces;
	}

	static function decodeMode( $mode ) {
		global $wgCategoryTreeDefaultOptions;

		if ( is_null( $mode ) ) return $wgCategoryTreeDefaultOptions['mode'];
		if ( is_int( $mode ) ) return $mode;

		$mode = trim( strtolower( $mode ) );

		if ( is_numeric( $mode ) ) return (int)$mode;

		if ( $mode == 'all' ) $mode = CT_MODE_ALL;
		else if ( $mode == 'pages' ) $mode = CT_MODE_PAGES;
		else if ( $mode == 'categories' || $mode == 'sub' ) $mode = CT_MODE_CATEGORIES;
		else if ( $mode == 'parents' || $mode == 'super' || $mode == 'inverse' ) $mode = CT_MODE_PARENTS;
		else if ( $mode == 'default' ) $mode = $wgCategoryTreeDefaultOptions['mode'];

		return (int)$mode;
	}

	/**
	* Helper function to convert a string to a boolean value.
	* Perhaps make this a global function in MediaWiki proper
	*/
	static function decodeBoolean( $value ) {
		if ( is_null( $value ) ) return NULL;
		if ( is_bool( $value ) ) return $value;
		if ( is_int( $value ) ) return ( $value > 0 );

		$value = trim( strtolower( $value ) );
		if ( is_numeric( $value ) ) return ( (int)$value > 0 );

		if ( $value == 'yes' || $value == 'y' || $value == 'true' || $value == 't' || $value == 'on' ) return true;
		else if ( $value == 'no' || $value == 'n' || $value == 'false' || $value == 'f' || $value == 'off' ) return false;
		else if ( $value == 'null' || $value == 'default' || $value == 'none' || $value == 'x' ) return NULL;
		else return false;
	}

	static function decodeHidePrefix( $value ) {
		global $wgCategoryTreeDefaultOptions;

		if ( is_null( $value ) ) return $wgCategoryTreeDefaultOptions['hideprefix'];
		if ( is_int( $value ) ) return $value;
		if ( $value === true ) return CT_HIDEPREFIX_ALWAYS;
		if ( $value === false ) return CT_HIDEPREFIX_NEVER;

		$value = trim( strtolower( $value ) );

		if ( $value == 'yes' || $value == 'y' || $value == 'true' || $value == 't' || $value == 'on' ) return CT_HIDEPREFIX_ALWAYS;
		else if ( $value == 'no' || $value == 'n' || $value == 'false' || $value == 'f' || $value == 'off' ) return CT_HIDEPREFIX_NEVER;
		//else if ( $value == 'null' || $value == 'default' || $value == 'none' || $value == 'x' ) return $wgCategoryTreeDefaultOptions['hideprefix'];
		else if ( $value == 'always' ) return CT_HIDEPREFIX_ALWAYS;
		else if ( $value == 'never' ) return CT_HIDEPREFIX_NEVER;
		else if ( $value == 'auto' ) return CT_HIDEPREFIX_AUTO;
		else if ( $value == 'categories' || $value == 'category' || $value == 'smart' ) return CT_HIDEPREFIX_CATEGORIES;
		else return $wgCategoryTreeDefaultOptions['hideprefix'];
	}

	/**
	 * Set the script tags in an OutputPage object
	 * @param OutputPage $outputPage
	 */
	static function setHeaders( &$outputPage ) {
		global $wgJsMimeType, $wgScriptPath, $wgContLang;
		global $wgCategoryTreeHijackPageCategories, $wgCategoryTreeExtPath, $wgCategoryTreeVersion;
		self::init();

		# Register css file for CategoryTree
		$outputPage->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => "{$wgCategoryTreeExtPath}/CategoryTree.css?{$wgCategoryTreeVersion}",
			)
		);

		if ( $wgCategoryTreeHijackPageCategories ) {
			# Register MSIE quirks
			$outputPage->addScript(
				"<!--[if IE]><link rel=\"stylesheet\" type=\"text/css\" src=\"{$wgCategoryTreeExtPath}/CategoryTreeIE.css?{$wgCategoryTreeVersion}\"/><![endif]-->
	\n"
			);
		}

		# Register css RTL file for CategoryTree
		if( $wgContLang->isRTL() ) {
			$outputPage->addLink(
				array(
					'rel' => 'stylesheet',
					'type' => 'text/css',
					'href' => "{$wgCategoryTreeExtPath}/CategoryTree.rtl.css?{$wgCategoryTreeVersion}"
				)
			);
		}

		# Register main js file for CategoryTree
		$outputPage->addScript(
			"<script type=\"{$wgJsMimeType}\" src=\"{$wgCategoryTreeExtPath}/CategoryTree.js?{$wgCategoryTreeVersion}\">" .
			"</script>\n"
		);

		# Add messages
		$outputPage->addScript(
		"	<script type=\"{$wgJsMimeType}\">
			var categoryTreeCollapseMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-collapse'))."\";
			var categoryTreeExpandMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-expand'))."\";
			var categoryTreeCollapseBulletMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-collapse-bullet'))."\";
			var categoryTreeExpandBulletMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-expand-bullet'))."\";
			var categoryTreeLoadMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-load'))."\";
			var categoryTreeLoadingMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-loading'))."\";
			var categoryTreeNothingFoundMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-nothing-found'))."\";
			var categoryTreeNoSubcategoriesMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-no-subcategories'))."\";
			var categoryTreeNoParentCategoriesMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-no-parent-categories'))."\";
			var categoryTreeNoPagesMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-no-pages'))."\";
			var categoryTreeErrorMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-error'))."\";
			var categoryTreeRetryMsg = \"".Xml::escapeJsString(wfMsgNoTrans('categorytree-retry'))."\";
			</script>\n"
		);
	}

	static function getJsonCodec() {
		static $json = NULL;

		if (!$json) {
			$json = new Services_JSON(); #recycle API's JSON codec implementation
		}

		return $json;
	}

	static function encodeOptions( $options, $enc ) {
		if ( $enc == 'mode' || $enc == '' ) {
			$opt =$options['mode'];
		} elseif ( $enc == 'json' ) {
			$json = self::getJsonCodec(); //XXX: this may be a bit heavy...
			$opt = $json->encode( $options );
		} else {
			throw new MWException( 'Unknown encoding for CategoryTree options: ' . $enc );
		}

		return $opt;
	}

	static function decodeOptions( $options, $enc ) {
		if ( $enc == 'mode' || $enc == '' ) {
			$opt = array( "mode" => $options );
		} elseif ( $enc == 'json' ) {
			$json = self::getJsonCodec(); //XXX: this may be a bit heavy...
			$opt = $json->decode( $options );
			$opt = get_object_vars( $opt );
		} /* elseif () {
			foreach ( $oo as $o ) {
				if ($o === "") continue;
		
				if ( preg_match( '!^(.*?)=(.*)$!', $o, $m ) {
					$n = $m[1];
					$opt[$n] = $m[2];
				} else {
					$opt[$o] = true;
				}
			}
		} */ else {
			throw new MWException( 'Unknown encoding for CategoryTree options: ' . $enc );
		}

		return $opt;
	}

	function getOptionsAsCacheKey( $depth = NULL ) {
		$key = "";

		foreach ( $this->mOptions as $k => $v ) {
			if ( is_array( $v ) ) $v = implode( '|', $v );
			$key .= $k . ':' . $v . ';';
		}

		if ( !is_null( $depth ) ) $key .= ";depth=" . $depth;
		return $key;
	}

	function getOptionsAsJsStructure( $depth = NULL ) {
		if ( !is_null( $depth ) ) {
			$opt = $this->mOptions;
			$opt['depth'] = $depth;
			$s = self::encodeOptions( $opt, 'json' );
		} else {
			$s = self::encodeOptions( $this->mOptions, 'json' );
		}

		return $s;
	}

	function getOptionsAsJsString( $depth = NULL ) {
		return Xml::escapeJsString( $s );
	}

	function getOptionsAsUrlParameters() {
		$u = '';

		foreach ( $this->mOptions as $k => $v ) {
			if ( $u != '' ) $u .= '&';
			$u .= $k . '=' . urlencode($v) ;
		}

		return $u;
	}

	/**
	* Ajax call. This is called by efCategoryTreeAjaxWrapper, which is used to
	* load CategoryTreeFunctions.php on demand.
	*/
	function ajax( $category, $depth = 1 ) {
		global $wgDBname;
		$title = self::makeTitle( $category );

		if ( ! $title ) return false; #TODO: error message?

		# Retrieve page_touched for the category
		$dbkey = $title->getDBkey();
		$dbr =& wfGetDB( DB_SLAVE );
		$touched = $dbr->selectField( 'page', 'page_touched',
			array(
				'page_namespace' => NS_CATEGORY,
				'page_title' => $dbkey,
			), __METHOD__ );

		$mckey = "$wgDBname:categorytree(" . $this->getOptionsAsCacheKey( $depth ) . "):$dbkey"; 

		$response = new AjaxResponse();

		if ( $response->checkLastModified( $touched ) ) {
			return $response;
		}

		if ( $response->loadFromMemcached( $mckey, $touched ) ) {
			return $response;
		}

		$html = $this->renderChildren( $title, $depth ); 

		if ( $html == '' ) $html = ' ';   #HACK: Safari doesn't like empty responses.
						  #see Bug 7219 and http://bugzilla.opendarwin.org/show_bug.cgi?id=10716

		$response->addText( $html );

		$response->storeInMemcached( $mckey, 86400 );

		return $response;
	}

	/**
	* Custom tag implementation. This is called by efCategoryTreeParserHook, which is used to
	* load CategoryTreeFunctions.php on demand.
	*/
	function getTag( $parser, $category, $hideroot = false, $attr, $depth=1, $allowMissing = false ) {
		global $wgCategoryTreeDisableCache, $wgCategoryTreeDynamicTag;
		static $uniq = 0;

		$category = trim( $category );
		if ( $category === '' ) {
			return false;
		}
		if ( $parser && $wgCategoryTreeDisableCache && !$wgCategoryTreeDynamicTag ) {
			$parser->disableCache();
		}
		$title = self::makeTitle( $category );

		if ( $title === false || $title === NULL ) return false;

		if ( isset( $attr['class'] ) ) $attr['class'] .= ' CategoryTreeTag';
		else $attr['class'] = ' CategoryTreeTag';

		$this->init();

		$html = '';
		$html .= Xml::openElement( 'div', $attr );

		if ( !$allowMissing && !$title->getArticleID() ) {
			$html .= Xml::openElement( 'span', array( 'class' => 'CategoryTreeNotice' ) );
			$html .= wfMsgExt( 'categorytree-not-found', 'parseinline', htmlspecialchars( $category ) );
			$html .= Xml::closeElement( 'span' );
			}
		else {
			if ( !$hideroot ) $html .= CategoryTree::renderNode( $title, $depth, $wgCategoryTreeDynamicTag );
			else if ( !$wgCategoryTreeDynamicTag ) $html .= $this->renderChildren( $title, $depth );
			else { 
				$uniq += 1;
				$load = 'ct-' . $uniq . '-' . mt_rand( 1, 100000 );

				$html .= Xml::openElement( 'script', array( 'type' => 'text/javascript', 'id' => $load ) );
				$html .= 'categoryTreeLoadChildren("' . Xml::escapeJsString( $title->getDBkey() ) . '", ' . $this->getOptionsAsJsStructure( $depth ) . ', document.getElementById("' . $load . '").parentNode);';
				$html .= Xml::closeElement( 'script' );
			}
		}

		$html .= Xml::closeElement( 'div' );
		$html .= "\n\t\t";

		return $html;
	}

	/**
	* Returns a string with an HTML representation of the children of the given category.
	* $title must be a Title object
	*/
	function renderChildren( &$title, $depth=1 ) {
		global $wgCategoryTreeMaxChildren, $wgCategoryTreeUseCategoryTable;

		if( $title->getNamespace() != NS_CATEGORY ) {
			// Non-categories can't have children. :)
			return '';
		}

		$dbr =& wfGetDB( DB_SLAVE );

		$inverse = $this->isInverse();
		$mode = $this->getOption('mode');
		$namespaces = $this->getOption('namespaces');

		if ( $inverse ) {
			$ctJoinCond = ' cl_to = cat.page_title AND cat.page_namespace = ' . NS_CATEGORY;
			$ctWhere = ' cl_from = ' . $title->getArticleId();
			$ctJoin = ' RIGHT JOIN ';
			$nsmatch = '';
		}
		else {
			$ctJoinCond = ' cl_from = cat.page_id ';
			$ctWhere = ' cl_to = ' . $dbr->addQuotes( $title->getDBkey() );
			$ctJoin = ' JOIN ';

			#namespace filter. 
			if ( $namespaces ) {
				#NOTE: we assume that the $namespaces array contains only integers! decodeNamepsaces makes it so.
				if ( sizeof( $namespaces ) === 1 ) $nsmatch = ' AND cat.page_namespace = ' . $namespaces[0] . ' ';
				else $nsmatch = ' AND cat.page_namespace IN ( ' . implode( ', ', $namespaces ) . ') ';
			}
			else {
				if ( $mode == CT_MODE_ALL ) $nsmatch = '';
				else if ( $mode == CT_MODE_PAGES ) $nsmatch = ' AND cat.page_namespace != ' . NS_IMAGE;
				else $nsmatch = ' AND cat.page_namespace = ' . NS_CATEGORY;
			}
		}

		#additional stuff to be used if "transaltion" by interwiki-links is desired
		$transFields = '';
		$transJoin = '';
		$transWhere = '';

		# fetch member count if possible
		$doCount = !$inverse && $wgCategoryTreeUseCategoryTable;

		$countFields = '';
		$countJoin = '';

		if ( $doCount ) {
			$cat = $dbr->tableName( 'category' );
			$countJoin = " LEFT JOIN $cat ON cat_title = page_title AND page_namespace = " . NS_CATEGORY;
			$countFields = ', cat_id, cat_title, cat_subcats, cat_pages, cat_files';
		}

		$page = $dbr->tableName( 'page' );
		$categorylinks = $dbr->tableName( 'categorylinks' );

		$sql = "SELECT cat.page_namespace, cat.page_title,
				cl_to, cl_from
					  $transFields
					  $countFields
				FROM $page as cat
				$ctJoin $categorylinks ON $ctJoinCond
				$transJoin
				$countJoin
				WHERE $ctWhere
				$nsmatch
				"./*AND cat.page_is_redirect = 0*/"
				$transWhere
				ORDER BY cl_sortkey
				LIMIT " . (int)$wgCategoryTreeMaxChildren;

		$res = $dbr->query( $sql, __METHOD__ );

		#collect categories separately from other pages
		$categories= '';
		$other= '';

		while ( $row = $dbr->fetchObject( $res ) ) {
			#NOTE: in inverse mode, the page record may be null, because we use a right join.
			#      happens for categories with no category page (red cat links)
			if ( $inverse && $row->page_title === NULL ) {
				$t = Title::makeTitle( NS_CATEGORY, $row->cl_to );
			}
			else {
				#TODO: translation support; ideally added to Title object
				$t = Title::newFromRow( $row );
			}

			$cat = NULL;

			if ( $doCount && $row->page_namespace == NS_CATEGORY ) {
				$cat = Category::newFromRow( $row, $t );
			}

			$s = $this->renderNodeInfo( $t, $cat, $depth-1, false );
			$s .= "\n\t\t";

			if ($row->page_namespace == NS_CATEGORY) $categories .= $s;
			else $other .= $s;
		}

		$dbr->freeResult( $res );

		return $categories . $other;
	}

	/**
	* Returns a string with an HTML representation of the parents of the given category.
	* $title must be a Title object
	*/
	function renderParents( &$title ) {
		global $wgCategoryTreeMaxChildren;

		$dbr =& wfGetDB( DB_SLAVE );

		#additional stuff to be used if "transaltion" by interwiki-links is desired
		$transFields = '';
		$transJoin = '';
		$transWhere = '';

		$categorylinks = $dbr->tableName( 'categorylinks' );

		$sql = "SELECT " . NS_CATEGORY . " as page_namespace, cl_to as page_title $transFields
				FROM $categorylinks
				$transJoin
				WHERE cl_from = " . $title->getArticleID() . "
				$transWhere
				ORDER BY cl_to
				LIMIT " . (int)$wgCategoryTreeMaxChildren;

		$res = $dbr->query( $sql, __METHOD__ );

		$special = Title::makeTitle( NS_SPECIAL, 'CategoryTree' );

		$s= '';

		while ( $row = $dbr->fetchObject( $res ) ) {
			#TODO: translation support; ideally added to Title object
			$t = Title::newFromRow( $row );

			#$trans = $title->getLocalizedText();
			$trans = ''; #place holder for when translated titles are available

			$label = htmlspecialchars( $t->getText() );
			if ( $trans && $trans!=$label ) $label.= ' ' . Xml::element( 'i', array( 'class' => 'translation'), $trans );

			$wikiLink = $special->getLocalURL( 'target=' . $t->getPartialURL() . '&' . $this->getOptionsAsUrlParameters() );

			if ( $s !== '' ) $s .= wfMsgExt( 'pipe-separator' , 'escapenoentities' );

			$s .= Xml::openElement( 'span', array( 'class' => 'CategoryTreeItem' ) );
			$s .= Xml::openElement( 'a', array( 'class' => 'CategoryTreeLabel', 'href' => $wikiLink ) ) . $label . Xml::closeElement( 'a' );
			$s .= Xml::closeElement( 'span' );

			$s .= "\n\t\t";
		}

		$dbr->freeResult( $res );

		return $s;
	}

	/**
	* Returns a string with a HTML represenation of the given page.
	* $title must be a Title object
	*/
	function renderNode( $title, $children = 0, $loadchildren = false ) {
		global $wgCategoryTreeUseCategoryTable;

		if ( $wgCategoryTreeUseCategoryTable && $title->getNamespace() == NS_CATEGORY && !$this->isInverse() ) {
			$cat = Category::newFromTitle( $title );
		}
		else $cat = NULL;

		return $this->renderNodeInfo( $title, $cat, $children, $loadchildren );
	}

	/**
	* Returns a string with a HTML represenation of the given page.
	* $info must be an associative array, containing at least a Title object under the 'title' key.
	*/
	function renderNodeInfo( $title, $cat, $children = 0, $loadchildren = false ) {
		static $uniq = 0;

		$this->init(); # initialize messages

		$mode = $this->getOption('mode');
		$load = false;

		if ( $children > 0 && $loadchildren ) {
			$uniq += 1;

			$load = 'ct-' . $uniq . '-' . mt_rand( 1, 100000 );
		}

		$ns = $title->getNamespace();
		$key = $title->getDBkey();

		#$trans = $title->getLocalizedText();
		$trans = ''; #place holder for when translated titles are available

		$hideprefix = $this->getOption('hideprefix');

		if ( $hideprefix == CT_HIDEPREFIX_ALWAYS ) $hideprefix = true;
		else if ( $hideprefix == CT_HIDEPREFIX_AUTO ) $hideprefix = ($mode == CT_MODE_CATEGORIES);
		else if ( $hideprefix == CT_HIDEPREFIX_CATEGORIES ) $hideprefix = ($ns == NS_CATEGORY);
		else $hideprefix = true;

		#when showing only categories, omit namespace in label unless we explicitely defined the configuration setting
		#patch contributed by Manuel Schneider <manuel.schneider@wikimedia.ch>, Bug 8011
		if ( $hideprefix ) $label = htmlspecialchars( $title->getText() );
		else $label = htmlspecialchars( $title->getPrefixedText() );

		if ( $trans && $trans!=$label ) $label.= ' ' . Xml::element( 'i', array( 'class' => 'translation'), $trans );

		$labelClass = 'CategoryTreeLabel ' . ' CategoryTreeLabelNs' . $ns;

		if ( !$title->getArticleId() ) {
			$labelClass .= ' new';
			$wikiLink = $title->getLocalURL( 'action=edit&redlink=1' );
		} else {
			$wikiLink = $title->getLocalURL();
		}

		if ( $ns == NS_CATEGORY ) {
			$labelClass .= ' CategoryTreeLabelCategory';
		} else {
			$labelClass .= ' CategoryTreeLabelPage';
		}

		if ( ( $ns % 2 ) > 0 ) $labelClass .= ' CategoryTreeLabelTalk';

		$count = false;
		$s = '';

		#NOTE: things in CategoryTree.js rely on the exact order of tags!
		#      Specifically, the CategoryTreeChildren div must be the first
		#      sibling with nodeName = DIV of the grandparent of the expland link.

		$s .= Xml::openElement( 'div', array( 'class' => 'CategoryTreeSection' ) );
		$s .= Xml::openElement( 'div', array( 'class' => 'CategoryTreeItem' ) );

		$attr = array( 'class' => 'CategoryTreeBullet' );
		$s .= Xml::openElement( 'span', $attr );

		if ( $ns == NS_CATEGORY ) {
			if ( $cat ) {
				if ( $mode == CT_MODE_CATEGORIES ) $count = $cat->getSubcatCount();
				else if ( $mode == CT_MODE_PAGES ) $count = $cat->getPageCount() - $cat->getFileCount();
				else $count = $cat->getPageCount();
			}
	
			$linkattr= array( );
			if ( $load ) $linkattr[ 'id' ] = $load;

			$linkattr[ 'class' ] = "CategoryTreeToggle";
			$linkattr['style'] = 'display: true;'; // Unhidden by JS

			/*if ( $count === 0 ) {
				$tag = 'span';
				$txt = wfMsgNoTrans( 'categorytree-empty-bullet' );
			}
			else*/ 
			if ( $children == 0 || $loadchildren ) {
				$tag = 'span';
				if ( $count === 0 ) $txt = wfMsgNoTrans( 'categorytree-empty-bullet' );
				else $txt = wfMsgNoTrans( 'categorytree-expand-bullet' );
				$linkattr[ 'onclick' ] = "if (this.href) this.href='javascript:void(0)'; categoryTreeExpandNode('".Xml::escapeJsString($key)."',".$this->getOptionsAsJsStructure().",this);";
				# Don't load this message for ajax requests, so that we don't have to initialise $wgLang
				$linkattr[ 'title' ] = $this->mIsAjaxRequest ? '##LOAD##' : wfMsgNoTrans('categorytree-expand');
			}
			else {
				$tag = 'span';
				$txt = wfMsgNoTrans( 'categorytree-collapse-bullet' );
				$linkattr[ 'onclick' ] = "if (this.href) this.href='javascript:void(0)'; categoryTreeCollapseNode('".Xml::escapeJsString($key)."',".$this->getOptionsAsJsStructure().",this);";
				$linkattr[ 'title' ] = wfMsgNoTrans('categorytree-collapse');
				$linkattr[ 'class' ] .= ' CategoryTreeLoaded';
			}

			if ( $tag == 'a' ) $linkattr[ 'href' ] = $wikiLink;
			$s .= Xml::openElement( $tag, $linkattr ) . $txt . Xml::closeElement( $tag ) . ' ';
		} else {
			$s .= wfMsgNoTrans( 'categorytree-page-bullet' );
		}

		$s .= Xml::closeElement( 'span' );

		$s .= Xml::openElement( 'a', array( 'class' => $labelClass, 'href' => $wikiLink ) ) . $label . Xml::closeElement( 'a' );

		if ( $count !== false && $this->getOption( 'showcount' ) ) {
			$pages = $cat->getPageCount() - $cat->getSubcatCount() - $cat->getFileCount();

			$attr = array(
				'title' => wfMsgExt( 'categorytree-member-counts', 'parsemag', $cat->getSubcatCount(), $pages , $cat->getFileCount(), $cat->getPageCount(), $count )
			);

			if ($count) {
				$s .= ' ';
				global $wgLang;
				$s .= Xml::tags( 'span', $attr,
					wfMsgExt( 'categorytree-member-num',
						array( 'parsemag', 'escapenoentities' ),
						$cat->getSubcatCount(),
						$pages,
						$cat->getFileCount(),
						$cat->getPageCount(),
						$wgLang->formatNum( $count ) ) );
			}
		}

		$s .= Xml::closeElement( 'div' );
		$s .= "\n\t\t";
		$s .= Xml::openElement( 'div', array( 'class' => 'CategoryTreeChildren', 'style' => $children > 0 ? "display:block" : "display:none" ) );
		
		if ( $ns == NS_CATEGORY && $children > 0 && !$loadchildren) {
			$children = $this->renderChildren( $title, $children );
			if ( $children == '' ) {
				$s .= Xml::openElement( 'i', array( 'class' => 'CategoryTreeNotice' ) );
				if ( $mode == CT_MODE_CATEGORIES ) $s .= wfMsgExt( 'categorytree-no-subcategories', 'parsemag');
				else if ( $mode == CT_MODE_PAGES ) $s .= wfMsgExt( 'categorytree-no-pages', 'parsemag');
				else if ( $mode == CT_MODE_PARENTS ) $s .= wfMsgExt( 'categorytree-no-parent-categories', 'parsemag');
				else $s .= wfMsgExt( 'categorytree-nothing-found', 'parsemag');
				$s .= Xml::closeElement( 'i' );
			} else {
				$s .= $children;
			}
		}

		$s .= Xml::closeElement( 'div' );
		$s .= Xml::closeElement( 'div' );

		if ( $load ) {
			$s .= "\n\t\t";
			$s .= Xml::openElement( 'script', array( 'type' => 'text/javascript' ) );
			$s .= 'categoryTreeExpandNode("'.Xml::escapeJsString($key).'", '.$this->getOptionsAsJsStructure($children).', document.getElementById("'.$load.'"));';
			$s .= Xml::closeElement( 'script' );
		}

		$s .= "\n\t\t";

		return $s;
	}

	/**
	* Creates a Title object from a user provided (and thus unsafe) string
	*/
	static function makeTitle( $title ) {
		global $wgContLang;

		$title = trim($title);

		if ( $title === NULL || $title === '' || $title === false ) {
			return NULL;
		}

		# The title must be in the category namespace
		# Ignore a leading Category: if there is one
		$t = Title::newFromText( $title, NS_CATEGORY );
		if ( $t && ( $t->getNamespace() != NS_CATEGORY || $t->getInterWiki() != '' ) ) {
			$title = "Category:$title";
			$t = Title::newFromText( $title );
		}
		return $t;
	}

	/**
	 * Initialize. Load messages, if not ajax request.
	 */
	static function init( ) {
		static $initialized = false;
		if ( $initialized ) return;
		$initialized = true;

		#NOTE: don't load messages for ajax requests. Ajax requests are cachable and language-neutral.
		#      Messages used in JS are defined by setHeaders
		if ( !isset( $this ) || !$this->mIsAjaxRequest ) 
			wfLoadExtensionMessages( 'CategoryTree' );
	}
}
