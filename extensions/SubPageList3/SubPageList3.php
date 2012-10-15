<?php
/**
 * Add a <splist /> tag which produces a linked list of all subpages of the current page
 *
 * @file
 * @ingroup Extensions
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

$wgHooks['ParserFirstCallInit'][] = 'efSubpageList3';
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Subpage List 3',
	'version' => '1.1',
	'descriptionmsg' => 'spl3-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SubPageList3',
	'author' => array(
		'James McCormack',
		'Martin Schallnahs',
		'Rob Church'
	),
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SubPageList3'] = $dir . 'SubPageList3.i18n.php';

/**
 * Hook in function
 *
 * @param $parser Parser
 */
function efSubpageList3( &$parser ) {
	$parser->setHook( 'splist', 'efRenderSubpageList3' );
	return true;
}

/**
 * Function called by the Hook, returns the wiki text
 */
function efRenderSubpageList3( $input, $args, $parser ) {
	$list = new SubpageList3( $parser );
	$list->options( $args );

	# $parser->disableCache();
	return $list->render();
}

/**
 * SubPageList3 class
 */
class SubpageList3 {

	/**
	 * @var Parser
	 */
	private $parser;


	/**
	 * @var Title
	 */
	private $title;

	/**
	 * @var Title
	 */
	private $ptitle;

	/**
	 * @var string
	 */
	private $namespace = '';

	/**
	 * @var string token object
	 */
	private $token = '*';

	/**
	 * @var Language
	 */
	private $language;

	/**
	 * @var int error display on or off
	 * @default 0 hide errors
	 */
	private $debug = 0;

	/**
	 * contain the error messages
	 * @var array contain the errors messages
	 */
	private $errors = array();

	/**
	 * order type
	 * Can be:
	 *  - asc
	 *  - desc
	 * @var string order type
	 */
	private $order = 'asc';

	/**
	 * column thats used as order method
	 * Can be:
	 *  - title: alphabetic order of a page title
	 *  - lastedit: Timestamp numeric order of the last edit of a page
	 * @var string order method
	 * @private
	 */
	private $ordermethod = 'title';

	/**
	 * mode of the output
	 * Can be:
	 *  - unordered: UL list as output
	 *  - ordered: OL list as output
	 *  - bar: uses · as a delimiter producing a horizontal bar menu
	 * @var string mode of output
	 * @default unordered
	 */
	private $mode = 'unordered';

	/**
	 * parent of the listed pages
	 * Can be:
	 *  - -1: the current page title
	 *  - string: title of the specific title
	 * e.g. if you are in Mainpage/ it will list all subpages of Mainpage/
	 * @var mixed parent of listed pages
	 * @default -1 current
	 */
	private $parent = -1;

	/**
	 * style of the path (title)
	 * Can be:
	 *  - full: normal, e.g. Mainpage/Entry/Sub
	 *  - notparent: the path without the $parent item, e.g. Entry/Sub
	 *  - no: no path, only the page title, e.g. Sub
	 * @var string style of the path (title)
	 * @default normal
	 * @see $parent
	 */
	private $showpath = 'no';

	/**
	 * whether to show next sublevel only, or all sublevels
	 * Can be:
	 *  - 0 / no / false
	 *  - 1 / yes / true
	 * @var mixed show one sublevel only
	 * @default 0
	 * @see $parent
	 */
	private $kidsonly = 0;

	/**
	 * whether to show parent as the top item
	 * Can be:
	 *  - 0 / no / false
	 *  - 1 / yes / true
	 * @var mixed show one sublevel only
	 * @default 0
	 * @see $parent
	 */
	private $showparent = 0;

	/**
	 * Constructor function of the class
	 * @param $parser Parser the parser object
	 * @global $wgContLang
	 * @see SubpageList
	 * @private
	 */
	function __construct( $parser ) {
		global $wgContLang;
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
		if ( $this->debug ) {
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
			} elseif( $options['debug'] == 'false' || intval( $options['debug'] ) == 0 ) {
				$this->debug = 0;
			} else {
				$this->error( wfMsg('spl3_debug','debug') );
			}
		}
		if( isset( $options['sort'] ) ) {
			if( strtolower( $options['sort'] ) == 'asc' ) {
				$this->order = 'asc';
			} elseif( strtolower( $options['sort'] ) == 'desc' ) {
				$this->order = 'desc';
			} else {
				$this->error( wfMsg('spl3_debug','sort') );
			}
		}
		if( isset( $options['sortby'] ) ) {
			switch( strtolower( $options['sortby'] ) ) {
				case 'title':
					$this->ordermethod = 'title';
					break;
				case 'lastedit':
					$this->ordermethod = 'lastedit';
					break;
				default:
					$this->error( wfMsg('spl3_debug','sortby') );
			}
		}
		if( isset( $options['liststyle'] ) ) {
			switch( strtolower( $options['liststyle'] ) ) {
				case 'ordered':
					$this->mode = 'ordered';
					$this->token = '#';
					break;
				case 'unordered':
					$this->mode = 'unordered';
					$this->token = '*';
					break;
				case 'bar':
					$this->mode = 'bar';
					$this->token = '&#160;· ';
					break;
				default:
					$this->error( wfMsg('spl3_debug','liststyle') );
			}
		}
		if( isset( $options['parent'] ) ) {
			if( intval( $options['parent'] ) == -1 ) {
				$this->parent = -1;
			} elseif( is_string( $options['parent'] ) ) {
				$this->parent = $options['parent'];
			} else {
				$this->error( wfMsg('spl3_debug','parent') );
			}
		}
		if( isset( $options['showpath'] ) ) {
			switch( strtolower( $options['showpath'] ) ) {
				case 'no':
				case '0':
				case 'false':
					$this->showpath = 'no';
					break;
				case 'notparent':
					$this->showpath = 'notparent';
					break;
				case 'full':
				case 'yes':
				case '1':
				case 'true':
					$this->showpath = 'full';
					break;
				default:
					$this->error( wfMsg('spl3_debug','showpath') );
			}
		}
		if( isset( $options['kidsonly'] ) ) {
			if( $options['kidsonly'] == 'true' || $options['kidsonly'] == 'yes' || intval( $options['kidsonly'] ) == 1 ) {
				$this->kidsonly = 1;
			} elseif( $options['kidsonly'] == 'false' || $options['kidsonly'] == 'no' || intval( $options['kidsonly'] ) == 0 ) {
				$this->kidsonly = 0;
			} else {
				$this->error( wfMsg('spl3_debug','kidsonly') );
			}
		}
		if( isset( $options['showparent'] ) ) {
			if( $options['showparent'] == 'true' || $options['showparent'] == 'yes' || intval( $options['showparent'] ) == 1 ) {
				$this->showparent = 1;
			} elseif( $options['showparent'] == 'false' || $options['showparent'] == 'no' || intval( $options['showparent'] ) == 0 ) {
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
		if( $pages != null && count( $pages ) > 0 ) {
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

		if( $this->ordermethod == 'title' ) {
			$options['ORDER BY'] = 'page_title ' . $order;
		} elseif( $this->ordermethod == 'lastedit' ) {
			$options['ORDER BY'] = 'page_touched ' . $order;
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

		// don't let list cross namespaces
		if ( strlen( $nsi ) > 0 ) {
			$conditions['page_namespace'] = $nsi;
		}
		$conditions['page_is_redirect'] = 0;
		$conditions[] = 'page_title ' . $dbr->buildLike( $parent . '/', $dbr->anyString() );

		$fields = array();
		$fields[] = 'page_title';
		$fields[] = 'page_namespace';
		$res = $dbr->select( 'page', $fields, $conditions, __METHOD__, $options );

		$titles = array();
		foreach ( $res as $row ) {
			$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
			if( $title ) {
				$titles[] = $title;
			}
		}
		wfProfileOut( __METHOD__ );
		return $titles;
	}

	/**
	 * create one list item
	 * cases:
	 *  - full: full, e.g. Mainpage/Entry/Sub
	 *  - notparent: the path without the $parent item, e.g. Entry/Sub
	 *  - no: no path, only the page title, e.g. Sub
	 * @param $title Title the title of a page
	 * @return string the prepared string
	 * @see $showpath
	 */
	function makeListItem( $title ) {
		switch( $this->showpath ) {
			case 'no':
				$linktitle = substr( strrchr( $title->getText(), "/" ), 1 );
				break;
			case 'notparent':
				$linktitle = substr( strstr( $title->getText(), "/" ), 1 );
				break;
			case 'full':
				$linktitle = $title->getText();
		}
		return ' [[' . $title->getPrefixedText() . '|' . $linktitle . ']]';
	}

	/**
	 * create whole list using makeListItem
	 * @param $titles Array all page titles
	 * @param $token string the token symbol:
	 *  - * for ul,
	 *  - # for ol
	 *  - · for horizontal lists
	 * @return string the whole list
	 * @see SubPageList::makeListItem
	 */
	function makeList( $titles ) {
		$c = 0;
		# add parent item
		if ($this->showparent) {
			$pn = '[[' . $this->ptitle->getPrefixedText() .'|'. $this->ptitle->getText() .']]';
			if( $this->mode != 'bar' ) {
				$pn = $this->token . $pn;
			}
			$ss = trim($pn);
			$list[] = $ss;
			$c++; // flag for bar token to be added on next item
		}
		# add descendents
		$parlv = substr_count($this->ptitle->getPrefixedText(), '/');
		$list = array();
		foreach( $titles as $title ) {
			$lv = substr_count($title, '/') - $parlv;
			if ( $this->kidsonly!=1 || $lv < 2 ) {
				if ($this->showparent) {
					$lv++;
				}
				$ss = "";
				if( $this->mode == 'bar' ) {
					if( $c>0) {
						$ss .= $this->token;
					}
				} else {
					for ( $i = 0; $i < $lv; $i++ ) {
						$ss .= $this->token;
					}
				}
				$ss .= $this->makeListItem( $title );
				$ss = trim( $ss );  // make sure we don't get any <pre></pre> tags
				$list[] = $ss;
			}
			$c++;
			if ( $c > 200 ) {
				break;
			}
		}
		$retval = '';
		if( count( $list ) > 0 ) {
			$retval = implode( "\n", $list );
			if ( $this->mode == 'bar' ) {
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
		$output = $this->parser->recursiveTagParse( $text );
		wfProfileOut( __METHOD__ );
		return $output;
	}

}
