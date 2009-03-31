<?php
/**
 * Add a <splist /> tag which produces a linked list of all subpages of the current page
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author James McCormack (email: user "qedoc" at hotmail); preceding version Martin Schallnahs <myself@schaelle.de>, original Rob Church <robchur@gmail.com>
 * @copyright © 2008 James McCormack, preceding version Martin Schallnahs, original Rob Church
 * @licence GNU General Public Licence 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:SubPageList3
 *
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionFunctions[] = 'efSubpageList3';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Subpage List 3',
	'version' => '1.05',
	'description' => 'Automatically creates a list of the subpages of a page.',
	'descriptionmsg' => 'spl3_desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SubPageList3',
	'author' => array('James McCormack', 'Martin Schallnahs', 'Rob Church'),
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SubPageList3'] = $dir . 'SubPageList3.i18n.php';

/**
 * Hook in function
 */
function efSubpageList3() {
	global $wgParser;
	$wgParser->setHook( 'splist', 'efRenderSubpageList3' );
}

/**
 * Function called by the Hook, returns the wiki text
 */
function efRenderSubpageList3( $input, $args, $parser ) {
	$list = new SubpageList3( $parser );
	wfLoadExtensionMessages('SubPageList3');
	$list->options( $args );
	# $parser->disableCache();
	return $list->render();
}

/**
 * SubPageList3 class
 */
class SubpageList3 {

	/**
	 * parser object
	 * @var object parser object
	 * @private
	 */
	var $parser;


	/**
	 * title object
	 * @var object title object
	 * @private
	 */
	var $title;

	/**
	 * ptitle object
	 * @var object ptitle object
	 * @private
	 */
	var $ptitle;

	/**
	 * namespace string
	 * @var string namespace object
	 * @private
	 */
	var $namespace = '';

	/**
	 * token string
	 * @var string token object
	 * @private
	 */
	var $token = '*';

	/**
	 * language object
	 * @var object language object
	 * @private
	 */
	var $language;

	/**
	 * error display on or off
	 * @var mixed error display on or off
	 * @private
	 * @default 0 hide errors
	 */
	var $debug = 0;

	/**
	 * contain the error messages
	 * @var array contain the errors messages
	 * @private
	 */
	var $errors = array();


	/**
	 * order type
	 * Can be:
	 *  - asc
	 *  - desc
	 * @var string order type
	 * @private
	 * @default asc
	 */
	var $order = 'asc';

	/**
	 * column thats used as order method
	 * Can be:
	 *  - title: alphabetic order of a page title
	 *  - lastedit: Timestamp numeric order of the last edit of a page
	 * @var string order method
	 * @private
	 * @default title
	 */
	var $ordermethod = 'title';

	/**
	 * mode of the output
	 * Can be:
	 *  - unordered: UL list as output
	 *  - ordered: OL list as output
	 *  - bar: uses &middot; as a delimiter producing a horizontal bar menu
	 * @var string mode of output
	 * @private
	 * @default unordered
	 */
	var $mode = 'unordered';

	/**
	 * parent of the listed pages
	 * Can be:
	 *  - -1: the current page title
	 *  - string: title of the specific title
	 * e.g. if you are in Mainpage/ it will list all subpages of Mainpage/
	 * @var mixed parent of listed pages
	 * @private
	 * @default -1 current
	 */
	var $parent = -1;

	/**
	 * style of the path (title)
	 * Can be:
	 *  - full: normal, e.g. Mainpage/Entry/Sub
	 *  - notparent: the path without the $parent item, e.g. Entry/Sub
	 *  - no: no path, only the page title, e.g. Sub
	 * @var string style of the path (title)
	 * @private
	 * @default normal
	 * @see $parent
	 */
	var $showpath = 'no';

	/**
	 * whether to show next sublevel only, or all sublevels
	 * Can be:
	 *  - 0 / no / false
	 *  - 1 / yes / true
	 * @var mixed show one sublevel only
	 * @private
	 * @default 0
	 * @see $parent
	 */
	var $kidsonly = 0;

	/**
	 * whether to show parent as the top item
	 * Can be:
	 *  - 0 / no / false
	 *  - 1 / yes / true
	 * @var mixed show one sublevel only
	 * @private
	 * @default 0
	 * @see $parent
	 */
	var $showparent = 0;

	/**
	 * Constructor function of the class
	 * @param object $parser the parser object
	 * @global object $wgContLang
	 * @see SubpageList
	 * @private
	 */
	function SubpageList3( $parser ) {
		global $wgContLang;

		/**
		 * assignment of the object to the classs vars
		 * @see $parser
		 * @see $title
		 * @see $language
		 */
		$this->parser = $parser;
		$this->title = $parser->mTitle;
		$this->language = $wgContLang;
	}

	/**
	 * adds error to the $errors container
	 * but only if $debug is true or 1
	 * @param string $message the errors message
	 * @see $errors
	 * @see $debug
	 * @private
	 */
	function error( $message ) {
		if ( $this->debug /*|| $this->debug == 1*/ ) {
			$this->errors[] = "<strong>Error [Subpage List 3]:</strong> $message";
		}
	}

	/**
	 * returns all errors as a string
	 * @return string all errors separated by a newline
	 * @private
	 */
	function geterrors() {
		return implode( "\n", $this->errors );
	}

	/**
	 * parse the options that the user has entered
	 * a bit long way, but because that it's easy to add alias
	 * @param array $options the options inserts by the user as array
	 * @see $debug
	 * @see $order
	 * @see $ordermethod
	 * @see $mode
	 * @see $parent
	 * @see $showpath
	 * @see $kidsonly
	 * @see $showparent
	 * @private
	 */
	function options( $options ) {
		if( isset( $options['debug'] ) ) {
			if( $options['debug'] == 'true' || intval( $options['debug'] ) == 1 ) {
				$this->debug = 1;
			} else if( $options['debug'] == 'false' || intval( $options['debug'] ) == 0 ) {
				$this->debug = 0;
			} else {
				$this->error( wfMsg('spl3_debug','debug') );
			}
		}
		if( isset( $options['sort'] ) ) {
			if( strtolower( $options['sort'] ) == 'asc' ) {
				$this->order = 'asc';
			} else if( strtolower( $options['sort'] ) == 'desc' ) {
				$this->order = 'desc';
			} else {
				$this->error( wfMsg('spl3_debug','sort') );
			}
		}
		if( isset( $options['sortby'] ) ) {
			switch( strtolower( $options['sortby'] ) ) {
				case 'title': $this->ordermethod = 'title'; break;
				case 'lastedit': $this->ordermethod = 'lastedit'; break;
				default: $this->error( wfMsg('spl3_debug','sortby') );
			}
		}
		if( isset( $options['liststyle'] ) ) {
			switch( strtolower( $options['liststyle'] ) ) {
				case 'ordered': $this->mode = 'ordered'; $this->token = '#'; break;
				case 'unordered': $this->mode = 'unordered'; $this->token = '*'; break;
				case 'bar': $this->mode = 'bar'; $this->token = '&nbsp;&middot; '; break;
				default: $this->error( wfMsg('spl3_debug','liststyle') );
			}
		}
		if( isset( $options['parent'] ) ) {
			if( intval( $options['parent'] ) == -1 ) {
				$this->parent = -1;
			} else if( is_string( $options['parent'] ) ) {
				$this->parent = $options['parent'];
			} else {
				$this->error( wfMsg('spl3_debug','parent') );
			}
		}
		if( isset( $options['showpath'] ) ) {
			switch( strtolower( $options['showpath'] ) ) {
				case 'no': $this->showpath = 'no'; break;
				case '0': $this->showpath = 'no'; break;
				case 'false': $this->showpath = 'no'; break;
				case 'notparent': $this->showpath = 'notparent'; break;
				case 'full': $this->showpath = 'full'; break;
				case 'yes': $this->showpath = 'full'; break;
				case '1': $this->showpath = 'full'; break;
				case 'true': $this->showpath = 'full'; break;
				default: $this->error( wfMsg('spl3_debug','showpath') );
			}
		}
		if( isset( $options['kidsonly'] ) ) {
			if( $options['kidsonly'] == 'true' || $options['kidsonly'] == 'yes' || intval( $options['kidsonly'] ) == 1 ) {
				$this->kidsonly = 1;
			} else if( $options['kidsonly'] == 'false' || $options['kidsonly'] == 'no' || intval( $options['kidsonly'] ) == 0 ) {
				$this->kidsonly = 0;
			} else {
				$this->error( wfMsg('spl3_debug','kidsonly') );
			}
		}
		if( isset( $options['showparent'] ) ) {
			if( $options['showparent'] == 'true' || $options['showparent'] == 'yes' || intval( $options['showparent'] ) == 1 ) {
				$this->showparent = 1;
			} else if( $options['showparent'] == 'false' || $options['showparent'] == 'no' || intval( $options['showparent'] ) == 0 ) {
				$this->showparent = 0;
			} else {
				$this->error( wfMsg('spl3_debug','showparent') );
			}
		}
	}

	/**
	 * produce output using this class
	 * @return string html output
	 * @private
	 */
	function render() {
		wfProfileIn( __METHOD__ );
		$pages = $this->getTitles();
		if($pages!=null && count( $pages ) > 0 ) {
			$list = $this->makeList( $pages );
			$html = $this->parse( $list );
		} else {
			$plink = "[[" . $this->parent . "]]";
			$out = "''" . wfMsg('spl3_nosubpages', $plink) . "''\n";
			$html = $this->parse( $out );
		}
		$html = $this->geterrors() . $html;
		wfProfileOut( __METHOD__ );
		return "<div class=\"subpagelist\">{$html}</div>";
	}

	/**
	 * return the page titles of the subpages in an array
	 * @return array all titles
	 * @private
	 */
	function getTitles() {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );

		$conditions = array();
		$options = array();
		$order = strtoupper( $this->order );
		$parent = '';

		if( $this->ordermethod == 'title' ) {
			$options['ORDER BY'] = '`page_title`' . $order;
		} else if( $this->ordermethod == 'lastedit' ) {
			$options['ORDER BY'] = '`page_touched` ' . $order;
		}
		if( $this->parent !== -1) {
			$this->ptitle = Title::newFromText( $this->parent );
			# note that non-existent pages may nevertheless have valid subpages
			# on the other hand, not checking that the page exists can let input through which causes database errors
			if ( $this->ptitle instanceof Title && $this->ptitle->exists() && $this->ptitle->userCanRead() ) {
				$parent = $this->ptitle->getDBkey();
				$this->parent = $parent;
				$this->namespace = $this->ptitle->getNsText();
				$nsi = $this->ptitle->getNamespace();
			} else {
				$this->error( wfMsg('spl3_debug','parent') );
				return null;
			}
		} else {
			$this->ptitle = $this->title;
			$parent = $this->title->getDBkey();
			$this->parent = $parent;
			$this->namespace = $this->title->getNsText();
			$nsi = $this->title->getNamespace();
		}

		if (strlen($nsi)>0) $conditions['page_namespace'] = $nsi; // don't let list cross namespaces
		$conditions['page_is_redirect'] = 0;
		$conditions[] = '`page_title` LIKE ' . $dbr->addQuotes( $dbr->escapeLike($parent) . '/%' );

		$fields = array();
		$fields[] = 'page_title';
		$fields[] = 'page_namespace';
		$res = $dbr->select( 'page', $fields, $conditions, __METHOD__, $options );

		$titles = array();
		while( $row = $dbr->fetchObject( $res ) ) {
			$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
			if( is_object( $title ) ) {
				$titles[] = $title;
			}
		}
		$dbr->freeResult( $res );
		wfProfileOut( __METHOD__ );
		return $titles;
	}

	/**
	 * create one list item
	 * cases:
	 *  - full: full, e.g. Mainpage/Entry/Sub
	 *  - notparent: the path without the $parent item, e.g. Entry/Sub
	 *  - no: no path, only the page title, e.g. Sub
	 * @param string $title the title of a page
	 * @return string the prepared string
	 * @see $showpath
	 */
	function makeListItem( $title ) {
		switch( $this->showpath ) {
			case 'no': $linktitle = substr( strrchr( $title->getText(), "/" ), 1 ); break;
			case 'notparent': $linktitle = substr( strstr( $title->getText(), "/" ), 1 ); break;
			case 'full': $linktitle = $title->getText();
		}
		return ' [[' . $title->getPrefixedText() . '|' . $linktitle . ']]';
	}

	/**
	 * create whole list using makeListItem
	 * @param string $titles all page titles
	 * @param string $token the token symbol:
	 *  - * for ul,
	 *  - # for ol
	 *  - &middot; for horizontal lists
	 * @return string the whole list
	 * @see SubPageList::makeListItem
	 */
	function makeList( $titles ) {
		$c = 0;
		# add parent item
		if ($this->showparent) {
			$pn = '[[' . $this->ptitle->getPrefixedText() .'|'. $this->ptitle->getText() .']]';
			if( $this->mode != 'bar' ) $pn = $this->token . $pn;
			$ss = trim($pn);
			$list[] = $ss;
			$c++; // flag for bar token to be added on next item
		}
		# add descendents
		$parlv = substr_count($this->ptitle->getPrefixedText(), '/');
		foreach( $titles as $title ) {
			$lv = substr_count($title, '/') - $parlv;	
			if ($this->kidsonly!=1 || $lv<2) {
				if ($this->showparent) $lv++;
				$ss = "";
				if( $this->mode == 'bar' ) {
					if( $c>0) {
						$ss .= $this->token;
					}
				} else {
					for ($i=0; $i<$lv; $i++) {
						$ss .= $this->token;
					}
				}
				$ss .= $this->makeListItem( $title );
				$ss = trim($ss);  // make sure we don't get any <pre></pre> tags
				$list[] = $ss;
			}
			$c++;
			if ($c>200) break; // safety
		}
		if( count( $list ) > 0 ) {
			$retval = implode( "\n", $list );
			if ($this->mode == 'bar') {
				$retval = implode( "", $list );
			}
		}

		return $retval;
	}

	/**
	 * Wrapper function parse, call the other functions
	 * @param string $text the content
	 * @return string the parsed output
	 */
	function parse( $text ) {
		wfProfileIn( __METHOD__ );
		$options = $this->parser->mOptions;
		$output = $this->parser->parse( $text, $this->title, $options, true, false );
		wfProfileOut( __METHOD__ );
		return $output->getText();
	}
}
