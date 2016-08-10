<?php

$wgAjaxExportList[] = "BlogTemplateClass::axShowCurrentPage";
/* register as a parser function {{BLOGTPL_TAG}} and a tag <BLOGTPL_TAG> */
$wgHooks['ParserFirstCallInit'][] = "BlogTemplateClass::setParserHook";

define ( "BLOGS_TIMESTAMP", "20081101000000" );
define ( "BLOGS_XML_REGEX", "/\<(.*?)\>(.*?)\<\/(.*?)\>/si" );
define ( "GROUP_CONCAT", "64000" );
define ( "BLOGS_DEFAULT_LENGTH", "400" );
define ( "BLOGS_HTML_PARSE", "/(<.+?>)?([^<>]*)/s" );
define ( "BLOGS_ENTITIES_PARSE", "/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i" );
define ( "BLOGS_CLOSED_TAGS", "/^<\s*\/([^\s]+?)\s*>$/s" );
define ( "BLOGS_OPENED_TAGS", "/^<\s*([^\s>!]+).*?>$/s" );

class BlogTemplateClass {
	/*
	 * Tag options
	 */
	public static $aBlogParams = array(
		/*
		 * <title>Cat11</title>
		 * or
		 * title=TITLE
		 *
		 * type: 	string
		 * default: Blogs
		 */
		'title' 		=> array (
			'type' 		=> 'string',
			'default' 	=> "Blogs",
		),
		/*
		 * <category>Cat11</category>
		 * <category>Cat12</category>
		 * ....
		 *
		 * or
		 *
		 * <category>
		 * Cat11
		 * Cat12
		 * Cat13
		 * ....
		 * </category>
		 *
		 * type: 	string
		 * default: null (all categories)
		 */
		'category' 		=> array (
			'type' 		=> 'string',
			'default' 	=> null,
			'count'		=> 10
		),

        /*
		 * <author>Author1</author>
		 * <author>Author2</author>
		 * ....
		 *
		 * or
		 *
		 * <author>
		 * Author1
		 * Author2
		 * Author3
		 * ....
		 * </author>
		 *
		 * type: 	string
         * default: "" (all authors)
         */
		'author' 		=> array (
			'type' 		=> 'string',
			'default' 	=> '',
			'count'		=> 10
		),

        /*
         * order = date (or comments or author)
		 *
		 * type: 	element of predefined list (date, comments, author)
         * default: date
         */
		'order' 		=> array (
			'type' 		=> 'list',
			'default' 	=> 'date',
			'pattern'	=> array(
				'date' 	=> 'rev_timestamp',
				'author' => 'page_title',
				'comments' => 'page_id'    // ordering by comments is done post-sql
			)
		),

		/*
		 * ordertype = descending (or ascending)
		 *
		 * type: 	predefined list (descending, ascending)
		 * default: descending
		 */
		'ordertype' 	=> array (
			'type' 		=> 'list',
			'default' 	=> 'desc',
			'pattern'	=> array( 'desc', 'asc' )
		),

		/*
		 * max of results to query.
		 * count = /^\d*$/
		 *
		 * type: 	number
		 * default: 5
		 */
		'count' 		=> array (
			'type' 		=> 'number',
			'default' 	=> '5',
			'pattern' 	=> '/^\d*$/',
			'max'		=> 50
		),

		/*
		 * max of results to display.
		 * count = /^\d*$/
		 *
		 * type: 	number
		 * default: 5
		 */
		'displaycount'	=> array (
			'type' 		=> 'number',
			'pattern' 	=> '/^\d*$/',
			'max'		=> 50
		),

		/*
		 * number of results which shall be skipped before display starts.
		 * offset = /^\d*$/
		 *
		 * type: 	number
		 * default: 0
		 */
		'offset' 		=> array (
			'default' 	=> '0',
			'pattern' 	=> '/^\d*$/'
		),

		/*
		 * limit for query date of last blog edit
		 * timestamp = integer date yyyymmddhhmmss
		 *
		 * type: 	number,
		 * default: 20081101000000
		 */
		'timestamp' => array (
			'type' 		=> 'number',
			'default' 	=> '20081101000000',
			'pattern' 	=> '/^\d*$/',
			'min'		=> '20081101000000'
		),

		/*
		 * limit for query date of blog creation
		 * timestamp = integer date yyyymmddhhmmss
		 *
		 * type: 	number,
		 * default: 20081101000000
		 */

		'create_timestamp' => array (
			'type' 		=> 'number',
			'default' 	=> '20081101000000',
			'pattern' 	=> '/^\d*$/',
			'min'		=> '20081101000000'
		),

		/*
		 * show summary
		 * summary = false (or true)
		 *
		 * type: 	boolean,
		 * default: false
		 */
		'summary' 	=> array (
			'type' 		=> 'boolean',
			'default' 	=> false
		),

		/*
		 * perform paging of results based on request params
		 * paging = false (or true)
		 *
		 * type: 	boolean,
		 * default: true
		 */
		'paging' 	=> array (
			'type' 		=> 'boolean',
			'default' 	=> true
		),

		/*
		 * number of characters in summary
		 * summarylength = /^\d*$/
		 *
		 * type: 	number,
		 * default: 100  (changed for oasis)
		 */
		'summarylength' 	=> array (
			'type' 		=> 'number',
			'default' 	=> array( 'box' => '100', 'plain' => '750' ),
			'pattern' 	=> '/^\d*$/'
		),

		/*
		 * default=box, other option is "plain". box is the 300px width both in style of image shown.
		 * Plain is just the box content, no styling - so users can do what they want with it.
		 * type = box | plain
		 *
		 * type: 	number,
		 * default: box
		 */
		'type' 	=> array (
			'type' 		=> 'list',
			'default' 	=> 'box',
			'pattern'	=> array( 'box', 'plain', 'array', 'noparse', 'count' )
		),

		/*
		 * Additional CSS class
		 *
		 * type: 	string,
		 * default: ""
		 */
		'class' => array (
			'type' 		=> 'string',
			'default' 	=> '',
		),

		/*
		 * Get Blog info
		 *
		 * type: 	number,
		 * default: ""
		 */
		'pages' => array(
			'type' 		=> 'number',
			'pattern' 	=> '/^\d*$/'
		),

		'seemore' => array(
			'type' => 'string',
			'default' 	=> '',
		)
	);

	private static $aTables		= array( );
	private static $aWhere 		= array( );
	private static $aHaving 	= array( );

	private static $aOptions	= array( );
	private static $aCategoryNames = array( );

	/** @var DatabaseBase */
	private static $dbr 		= null;

	private static $search 		= array (
		// '/<table[^>]*>.*<\/table>/siU',
        '/(<table[^>]*>|<\/table>)/i',
        '/(<tr[^>]*>|<\/tr>)/i',
        '/<td[^>]*>(.*?)<\/td>/i',
        '/<th[^>]*>(.*?)<\/th>/i',
		'/<div[^>]*>.*<\/div>/siU',
		'/<script[^>]*>.*<\/script>/siU',
		'/<h\d>.*<\/h\d>/siU',
		'/[\n]{2,}/siU',
		'/[\t]+/siU',
	);

	private static $replace		= array (
		// '/<table[^>]*>.*<\/table>/siU',
        '', // table
        '', // tr
        '', // td
        '', // th
		'', // div
		'', // script
		'', // <h\d>
		'<br/>', // \n
        '&nbsp;', // \t
	);

	private static $skipStrinBeforeParse	= "<br><br/><p><div><a><b><del><i><ins><u><font><big><small><sub><sup><cite><code><em><s><strike><strong><tt><var><center><blockquote><ol><ul><dl><u><q><abbr><acronym><li><dt><dd><span>";
	private static $skipStrinAfterParse		= "<br><br/><p><b><del><i><ins><u><font><big><small><sub><sup><cite><code><em><s><strike><strong><tt><var><center><blockquote><ol><ul><dl><u><q><abbr><acronym><li><dt><dd><span>";

	private static $pageOffsetName 			= "page";
	private static $oTitle 					= null;

	private static $blogWIKITEXT = array(
		"/\[\[Video\:(.*)\]\]/siU",
		"/\[\[Image\:(.*)\]\]/siU",
		"/\[\[File\:(.*)\]\]/siU",
		"/\[\[(.*)\:((.+\.[a-z]{3,4})(\|)(.*))*\]\](.*)/iU", # images [[Image:Test.png|(.*)]]
		"/\[\[(.*)\:((.+\.[a-z]{3,4}))\]\]/iU", # images [[Image:Test.png]]
	);

	private static $blogTAGS = array(
		"/\{\{#dpl(.*)\}\}/siU",
		"/\{\{#dplchapter(.*)\}\}/siU",
		"/<(dpl|dynamicpagelist)(.*)>(.*)<\/(dpl|dynamicpagelist)>/siU",
		"/<(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)(.*)>(.*)<\/(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)>/siU",
		"/<(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet|gallery)(.*)>(.*)<\/(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet|gallery)>/siU",
	);

	/**
	 * @static
	 * @param Parser $parser
	 * @return bool
	 */
	public static function setParserHook( $parser ) {
		$parser->setHook( BLOGTPL_TAG, array( __CLASS__, 'parseTagForParser' ) );
		return true;
	}

	/**
	 * This method is used by MW parser to parse blog listing tag
	 *
	 * @author macbre
	 */
	public static function parseTagForParser( $input, $params, $parser, $frame = null, $returnPlainData = false ) {

		$res = self::parseTag( $input, $params, $parser, $frame, $returnPlainData );

		/* Parser in MW1.16 allows to change the way of parsing custom tags */
		/* Do not perform additional parsing of HTML returned by this method */
		$res = array( $res, 'markerType' => 'nowiki' );

		return $res;
	}

	/**
	 * This method can be used by extensions to render blog listing
	 */
	public static function parseTag( $input, $params, &$parser, $frame = null, $returnPlainData = false ) {
		global $wgTitle;

		/* parse input parameters */
		if ( is_null( self::$oTitle ) ) {
			self::$oTitle = ( is_null( $wgTitle ) ) ? $parser->getTitle() : $wgTitle;
		}

		$aParams = self::__parseXMLTag( $input );
		wfDebugLog( __METHOD__, "parse input parameters\n" );
		/* parse all and return result */
		$res = self::__parse( $aParams, $params, $parser, $returnPlainData );

		return $res;
	}

	public static function parseTagWithTitle( $input, $params, &$parser, $oTitle ) {
		self::$oTitle = $oTitle;
		return self::parseTag( $input, $params, $parser );
	}

	public static function getUserNameRecord( $username, $nofollow = false ) {
		$aResult = array();

		// RT #18653
		if ( !empty( $nofollow ) ) {
			$attribs = array( 'rel' => 'nofollow' );
		}
		else {
			$attribs = array();
		}

		if ( !empty( $username ) ) {
			$oUser = User::newFromName( $username );
			if ( $oUser instanceof User ) {
				$oUserPage = $oUser->getUserPage();
				$oUserTalkPage = $oUser->getTalkPage();
				$aResult = array(
					"userpage" => ( $oUserPage instanceof Title ) ? Linker::link( $oUserPage, $oUser->getName(), $attribs ) : "",
					"talkpage" => ( $oUserTalkPage instanceof Title ) ? Linker::link( $oUserTalkPage, wfMsg( 'sp-contributions-talk' ), $attribs ) : "",
					"contribs" => Linker::link(
						SpecialPage::getTitleFor( 'Contributions' ),
						wfMsg( 'contribslink' ),
						$attribs,
						array( 'target' => $oUser->getName() )
					),
				);
			}
		}
		return $aResult;
	}

	/*
	 * private method
	 */

	private static function __getCategory( $sPageName, $iPage ) {
		$aCategories = array();

		$oFauxRequest = new FauxRequest(
			array(
				"action"	=> "query",
				"prop"		=> "categories",
				"titles"	=> $sPageName,
			)
		);
		$oApi = new ApiMain( $oFauxRequest );
		$oApi->execute();
		$aResult =& $oApi->GetResultData();

		if ( count( $aResult['query']['pages'] ) > 0 ) {
			if ( !empty( $aResult['query']['pages'][$iPage]['categories'] ) ) {
				foreach ( $aResult['query']['pages'][$iPage]['categories'] as $id => $aCategory ) {
					$oCatTitle = Title::newFromText( $aCategory['title'], $aCategory['ns'] );
					if ( $oCatTitle instanceof Title ) {
						$aCategories[] = $oCatTitle->getFullURL();
					}
				}
			}
		}

		# ---
		return $aCategories;
	}

	private static function __parseXMLTag( $string ) {
		$aResult = array();
		$aRes = $aTags = array();
		if ( preg_match_all( BLOGS_XML_REGEX, $string, $aTags ) ) {
			list ( , $sStartTags, $sTexts, $sEndTags ) = $aTags;
			wfDebugLog( __METHOD__, "found " . count( $sStartTags ) . " tags\n" );
			foreach ( $sStartTags as $id => $sStartTag ) {
				/* allow this tag? */
				if ( in_array( $sStartTag, array_keys( self::$aBlogParams ) ) ) {
					/* <TAG> = </TAG> */
					$sStartTag = trim( $sStartTag );
					$sEndTags[$id] = trim( $sEndTags[$id] );
					if ( $sStartTag == $sEndTags[$id] ) {
						$aRes[$sStartTag][] = trim( $sTexts[$id] );
					}
				}
			}
			wfDebugLog( __METHOD__, "allowed tags : " . count( $aRes ) . "\n" );
			if ( !empty( $aRes ) )  {
				$string = "";
				foreach ( $aRes as $sParamName => $aParamValues ) {
					if ( !empty( $aParamValues ) ) {
						foreach ( $aParamValues as $id => $sParamValue ) {
							if ( strpos( $sParamValue, "\n" ) !== FALSE ) {
								$aResult[$sParamName] = array_merge( (array)$aResult[$sParamName], array_map( 'trim', explode( "\n", $sParamValue ) ) );
							} else {
								$aResult[$sParamName][] = $sParamValue;
							}
						}
					}
				}
			}
		}
		return $aResult;
	}

	private static function __getmicrotime() {
		list( $usec, $sec ) = explode( " ", microtime() );
		return ( (float)$usec + (float)$sec );
    }

	private static function __setDefault() {
		/* set default options */
		/* default tables */
		if ( !in_array( "page", self::$aTables ) ) {
			self::$aTables[] = "page";
		}
		/* default conditions */
		if ( !in_array( "page_namespace", array_keys( self::$aWhere ) ) ) {
			self::$aWhere["page_namespace"] = NS_BLOG_ARTICLE;
		}
		if ( !in_array( "page_is_redirect", array_keys( self::$aWhere ) ) ) {
			self::$aWhere["page_is_redirect"] = 0;
		}
		self::$aWhere[] = "page_title like '%/%'";
		/* default options */
		/* order */
		if ( !isset( self::$aOptions['order'] ) ) {
			self::__makeOrder( 'order', self::$aBlogParams['order']['default'] );
		}
		/* ordertype */
		if ( !isset( self::$aOptions['ordertype'] ) ) {
			self::__makeListOption( 'ordertype', self::$aBlogParams['ordertype']['default'] );
		}
		/* count */
		if ( !isset( self::$aOptions['count'] ) ) {
			self::__makeIntOption( 'count', self::$aBlogParams['count']['default'] );
		}

		/* displaycount -- optional param deliberately has no default set */

		/* class -- optional param delberately has no default set */

		/* paging */
		if ( !isset( self::$aOptions['paging'] ) ) {
			self::__makeBoolOption( 'paging', self::$aBlogParams['paging']['default'] );
		}

		/* offset */
		if ( !isset( self::$aOptions['offset'] ) ) {
			self::__makeIntOption( 'offset', self::$aBlogParams['offset']['default'] );
		}
		/* type */
		if ( !isset( self::$aOptions['type'] ) ) {
			self::__makeListOption( 'type', self::$aBlogParams['type']['default'] );
		}
		/* timestamp */
		if ( !isset( self::$aOptions['timestamp'] ) ) {
			self::__makeIntOption( 'timestamp', self::$aBlogParams['timestamp']['default'] );
		}
		/* title */
		if ( !isset( self::$aOptions['title'] ) ) {
			self::__makeStringOption( 'title', wfMsg( 'blog-defaulttitle' ) );
		}
		/* see more */
		if ( !isset( self::$aOptions['seemore'] ) ) {
			$recentUrlTitle = Title::newFromText( wfMsgForContent( 'blogs-recent-url' ) );
			$recentUrl = $recentUrlTitle ? $recentUrlTitle->getFullURL() : '';
			self::__makeStringOption( 'seemore', $recentUrl );
		}
	}

	private static function __makeOrder( $sParamName, $sParamValue ) {
    	wfDebugLog( __METHOD__, "__makeOrder: " . $sParamName . "," . $sParamValue . "\n" );
    	if ( !empty( $sParamValue ) ) {
			if ( in_array( $sParamValue, array_keys( self::$aBlogParams[$sParamName]['pattern'] ) ) ) {
				self::$aOptions['order'] = self::$aBlogParams[$sParamName]['pattern'][$sParamValue];
			}
		}
	}

	private static function __makeListOption( $sParamName, $sParamValue ) {
    	wfDebugLog( __METHOD__, "__makeListOption: " . $sParamName . "," . $sParamValue . "\n" );
		if ( in_array( $sParamValue, self::$aBlogParams[$sParamName]['pattern'] ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
	}

	private static function __makeBoolOption( $sParamName, $sParamValue ) {
    	wfDebugLog( __METHOD__, "__makeBoolOption: " . $sParamName . "," . $sParamValue . "\n" );
		if ( in_array( $sParamValue, array( "true", "false", 0, 1 ) ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
	}

	private static function __makeStringOption( $sParamName, $sParamValue ) {
    	wfDebugLog( __METHOD__, "__makeStringOption: " . $sParamName . "," . $sParamValue . "\n" );
		self::$aOptions[$sParamName] = $sParamValue;
	}

	private static function __makeIntOption( $sParamName, $sParamValue ) {
    	wfDebugLog( __METHOD__, "__makeIntOption: " . $sParamName . "," . $sParamValue . "\n" );
		$m = array();
		if ( array_key_exists( $sParamName, self::$aBlogParams ) ) {
			if ( preg_match( self::$aBlogParams[$sParamName]['pattern'], $sParamValue, $m ) != 0 ) {
				/* check max/min value of int param */
				if ( array_key_exists( 'max', self::$aBlogParams[$sParamName] ) ) {
					$sParamValue = min( $sParamValue, self::$aBlogParams[$sParamName]['max'] );
				}
				if ( array_key_exists( 'min', self::$aBlogParams[$sParamName] ) ) {
					$sParamValue = max( $sParamValue, self::$aBlogParams[$sParamName]['min'] );
				}
				self::$aOptions[$sParamName] = $sParamValue;
			}
		}
	}

	private static function __addRevisionTable() {
		$sRevisionTable = 'revision';
		if ( !in_array( $sRevisionTable, self::$aTables ) ) {
			self::$aWhere[] = "rev_page = page_id";
			self::$aTables[] = $sRevisionTable;
			if ( !empty ( self::$aOptions['timestamp'] ) ) {
				self::$aWhere[] = "rev_timestamp >= '" . self::$aOptions['timestamp'] . "'";
			} else {
				self::$aWhere[] = "rev_timestamp >= '" . BLOGS_TIMESTAMP . "'";
			}

			if ( !empty ( self::$aOptions['create_timestamp'] ) ) {
				self::$aHaving[] = "create_timestamp >= '" . self::$aOptions['create_timestamp'] . "'";
			}

		}
	}

	private static function __makeDBOrderGroupByLimitAndOffset() {
    	$dbOption = array();
    	/* ORDER BY */
    	if ( isset( self::$aOptions['order'] ) ) {
    		$dbOption['ORDER BY'] = self::$aOptions['order'];
    		if ( isset( self::$aOptions['ordertype'] ) ) {
    			$dbOption['ORDER BY'] .= " " . self::$aOptions['ordertype'];
			}
		}
		/* GROUP BY */
		$dbOption['GROUP BY'] = "page_id";
    	/* LIMIT  */
    	if ( isset( self::$aOptions['count'] ) ) {
    		$dbOption['LIMIT'] = intval( self::$aOptions['count'] );
		} else {
    		$dbOption['LIMIT'] = intval( self::$aOptions['count']['default'] );
		}
    	/* OFFSET  */
    	if ( isset( self::$aOptions['offset'] ) ) {
    		$dbOption['OFFSET'] = intval( self::$aOptions['offset'] );
		} else {
    		$dbOption['OFFSET'] = intval( self::$aOptions['offset']['default'] );
		}

		if ( !empty( self::$aHaving ) ) {
			$dbOption['HAVING'] = implode( ' AND ', self::$aHaving );
		}

    	return $dbOption;
	}

	private static function __parseCategories( $text, $parser ) {
		global $wgTitle;

		if ( is_object( $parser ) && $wgTitle instanceof Title ) {
			$pOptions = $parser->getOptions();
			if ( is_null( $pOptions ) ) {
				$parser->startExternalParse( $wgTitle, new ParserOptions(), OT_PREPROCESS );
			}
			$text = $parser->replaceVariables( $text );
		}
		return $text;
	}

	private static function __getCategories ( $aParamValues, &$parser ) {
		self::$aCategoryNames = $aParamValues;
		$aPages = array();
    	if ( !empty( $aParamValues ) ) {
    		# RT 26917
    		$aParamValues = array_map( "strip_tags",
    			array_map(
    				array( "self", "__parseCategories" ),
    				$aParamValues,
    				array( $parser )
    			)
    		);
			// set timestamp option, if set
			$timestampLimit = BLOGS_TIMESTAMP;
			if ( !empty( self::$aOptions['timestamp'] ) ) {
				$timestampLimit = self::$aOptions['timestamp'];
			}
			/* set max length of group concat query */
			self::$dbr->query( 'SET group_concat_max_len = ' . GROUP_CONCAT, __METHOD__ );
			/* run query */
			$res = self::$dbr->select(
				array( self::$dbr->tableName( 'page' ), self::$dbr->tableName( 'categorylinks' ) ),
				array( "cl_to", "GROUP_CONCAT(DISTINCT cl_from SEPARATOR ',') AS cl_page" ),
				array(
					"page_namespace" => NS_BLOG_ARTICLE,
					"page_id = cl_from",
					"cl_to in (" . self::$dbr->makeList( $aParamValues ) . ")",
					"page_touched >= " . self::$dbr->addQuotes( $timestampLimit )
				),
				__METHOD__,
				array( 'GROUP BY' => 'cl_to' )
			);
			while ( $oRow = self::$dbr->fetchObject( $res ) ) {
                                // BugId:49408
                                // Since GROUP_CONCAT respects group_concat_max_len arbitrarily,
                                // sometimes we end up with a comma or a truncated item, which
                                // we don't want.
                                if ( GROUP_CONCAT == strlen( $oRow->cl_page ) ) {
                                    $aPages[] = preg_replace( '/,\d+,?$/', '', $oRow->cl_page );
                                } else {
                                    $aPages[] = $oRow->cl_page;
                                }
			}
			self::$dbr->freeResult( $res );
		}
    	return $aPages;
	}

	private static function __truncateText( $sText, $iLength, $sEnding ) {
		global $wgLang;


		$sResult = "";
		if ( empty( $iLength ) ) {
			if ( !empty( self::$aOptions['summarylength'] ) ) {
				$iLength = self::$aOptions['summarylength'];
			} else {
				if ( self::$aOptions['type'] == 'box' ) {
					$iLength = intval( self::$aBlogParams['summarylength']['default']['box'] );
				} else if ( self::$aOptions['type'] == 'plain' ) {
					$iLength = intval( self::$aBlogParams['summarylength']['default']['plain'] );
				} else {
					$iLength = BLOGS_DEFAULT_LENGTH;
				}
			}
		}

		if ( mb_strlen( strip_tags( $sText ) ) <= $iLength ) {
			/* if text without HTML is shorter than the maximum length, return text */
			$sResult = $sText;
		} else {
			/* splits all self::$skipSplitAfterParse to lines */
			$aLines = array();
			if ( preg_match_all( BLOGS_HTML_PARSE, $sText, $aLines, PREG_SET_ORDER ) !== false ) {
				$iTotalLength = mb_strlen( $sEnding );
				$aTags = array();

				foreach ( $aLines as $aLine ) {
					/* HTML-tag exists */
					$currentTag = "";
					if ( !empty( $aLine[1] ) ) {
						$aTag = array();
						if ( preg_match( BLOGS_CLOSED_TAGS, $aLine[1], $aTag ) ) {
							$__find = array_search( strtolower( trim( $aTag[1] ) ), $aTags );
							/* closed tags </p|a> - unset from opened-tags list */
							if ( $__find !== false ) {
								unset( $aTags[$__find] );
							}
							$currentTag = strtolower( trim( $aTag[1] ) );
							# $sResult .= ($currentTag == "a") ? $aLine[1] . " " : $aLine[1];
							$sResult .= $aLine[1];
						} else if ( preg_match( BLOGS_OPENED_TAGS, $aLine[1], $aTag ) ) {
							/* opened tags <p|a> - add to opened-tags list */
							$currentTag = strtolower( trim( $aTag[1] ) );
							array_unshift( $aTags, $currentTag );
							$sResult .= $aLine[1];
						}
					}

					/* calculate special entites */
					$iEntLength = mb_strlen( preg_replace( BLOGS_ENTITIES_PARSE, ' ', trim( $aLine[2] ) ) );
					if ( ( $iTotalLength + $iEntLength ) > $iLength ) {
						$iMaxLength = $iLength - $iTotalLength;
						$iEntLength = 0;
						$aEntities = array();
						if ( preg_match_all( BLOGS_ENTITIES_PARSE, $aLine[2], $aEntities, PREG_OFFSET_CAPTURE ) ) {
							foreach ( $aEntities[0] as $aEntity ) {
								if ( ( $aEntity[1] - $iEntLength + 1 ) <= $iMaxLength ) {
									$iEntLength += mb_strlen( $aEntity[0] );
									$iMaxLength--;
								} else {
									break;
								}
							}
						}
						$sResult .= mb_substr( $aLine[2], 0, $iMaxLength + $iEntLength );
						break;
					} else {
						$sResult .= $aLine[2];
						$iTotalLength += $iEntLength;
					}
					if ( $iTotalLength >= $iLength ) {
						break;
					}
				}

				/* close all opened tags */
				if ( !empty( $sEnding ) ) {
					$sResult .= $sEnding;
				}
				foreach ( $aTags as $sTag ) {
					$sResult .= "</{$sTag}>";
				}
			} else {
				$sResult = $wgLang->truncate( $sText, $iLength, $sEnding );
			}

			$aMatches = array();
		}

		$sResult = preg_replace( '/[\r\n]{2,}/siU', '<br />', trim( $sResult ) );

		return $sResult;
	}

	private static function __getRevisionText( $iPage, $oRev ) {
		global $wgLang, $wgUser;
		$sResult = "";

		$titleObj = Title::newFromId( $iPage );

		/* parse summary */
		if ( ( !empty( $oRev ) ) && ( !empty( $titleObj ) ) && ( !empty( self::$aOptions['summary'] ) ) ) {
			$sBlogText = $oRev->getText( Revision::FOR_THIS_USER );
			/* parse or not parse - this is a good question */
			if ( !in_array( self::$aOptions['type'], array( 'array', 'noparse' ) ) ) {
				/* macbre - remove parser hooks (RT #67074) */
				global $wgParser;
				$hooks = $wgParser->getTags();
				$hooksRegExp = implode( '|', array_map( 'preg_quote', $hooks ) );
				$sBlogText = preg_replace( '#<(' . $hooksRegExp . ')[^>]{0,}>(.*)<\/[^>]+>#s', '', $sBlogText );

				/* skip HTML tags */
				if ( !empty( self::$blogTAGS ) ) {
					/* skip some special tags  */
					foreach ( self::$blogTAGS as $id => $tag ) {
						$sBlogText = preg_replace( $tag, '', $sBlogText );
					}
				}

				$sBlogText = strip_tags( $sBlogText, self::$skipStrinBeforeParse );
				/* skip invalid Wiki-text  */
				$sBlogText = preg_replace( '/\{\{\/(.*?)\}\}/si', '', $sBlogText );
				$sBlogText = preg_replace( '/\{\{(.*?)\}\}/si', '', $sBlogText );
				if ( !empty( self::$blogWIKITEXT ) ) {
					/* skip some wiki-text */
					foreach ( self::$blogWIKITEXT as $id => $tag ) {
						$sBlogText = preg_replace( $tag, '', $sBlogText );
					}
				}
				/* parse truncated text */
				$parserOutput = ParserPool::parse( $sBlogText, $titleObj, ParserOptions::newFromUser( $wgUser ) );
				/* replace unused HTML tags */
				$sBlogText = preg_replace( self::$search, self::$replace, $parserOutput->getText() );
				/* skip HTML tags */
				$sBlogText = strip_tags( $sBlogText, self::$skipStrinAfterParse );
				/* truncate text */
				$cutSign = wfMsg( "blug-cut-sign" );
				$sResult = self::__truncateText( $sBlogText, null, $cutSign );
				/* RT #69661: make sure truncated HTML is valid */
				if ( function_exists( 'tidy_repair_string' ) ) {
					$sResult = tidy_repair_string( $sResult, array(), 'utf8' );
					$idxStart = strpos( $sResult, '<body>' ) + 6;
					$idxEnd = strrpos( $sResult, '</body>' );
					$sResult = substr( $sResult, $idxStart, $idxEnd -$idxStart );
				}
			} else {
				/* parse revision text */
				$parserOutput = ParserPool::parse( $sBlogText, $titleObj, ParserOptions::newFromUser( $wgUser ) );
				$sResult = $parserOutput->getText();
			}
		}
		return $sResult;
	}

	private static function  __sortByCommentCount( $a, $b ) {
		if ( $a['comments'] == $b['comments'] ) {
			return 0;
		}
		return ( $a['comments'] > $b['comments'] ) ? -1 : 1;
	}

	private static function __getResults() {
    	/* main query */
    	$aResult = array();
    	$aFields = array( '/* BLOGS */ rev_page as page_id', 'page_namespace', 'page_title', 'min(rev_timestamp) as create_timestamp', 'unix_timestamp(rev_timestamp) as timestamp', 'rev_timestamp', 'min(rev_id) as rev_id', 'rev_user' );
		$res = self::$dbr->select(
			array_map( array( self::$dbr, 'tableName' ), self::$aTables ),
			$aFields,
			self::$aWhere,
			__METHOD__,
			self::__makeDBOrderGroupByLimitAndOffset()
		);

		while ( $oRow = self::$dbr->fetchObject( $res ) ) {
			if ( class_exists( 'ArticleCommentList' ) ) {
				$oComments = ArticleCommentList::newFromText( $oRow->page_title, $oRow->page_namespace );
				$iCount = $oComments ? $oComments->getCountAllNested() : 0;
			} else {
				$iCount = 0;
			}

			/* username */
			$oTitle = Title::newFromText( $oRow->page_title, $oRow->page_namespace );
			$sUsername = "";
			if ( ! $oTitle instanceof Title ) continue;
			$username = BlogArticle::getOwner( $oTitle );
			$oRevision = Revision::newFromTitle( $oTitle );

			$aResult[$oRow->page_id] = array(
				"page" 			=> $oRow->page_id,
				"namespace" 	=> $oRow->page_namespace,
				"title" 		=> $oRow->page_title,
				"page_touched" 	=> ( !is_null( $oRevision ) ) ? $oRevision->getTimestamp() : $oTitle->getTouched(),
				"rev_timestamp"	=> $oRow->rev_timestamp,
				"timestamp" 	=> $oRow->timestamp,
				"username"		=> ( isset( $username ) ) ? $username : "",
				"text"			=> self::__getRevisionText( $oRow->page_id, $oRevision ),
				"revision"		=> $oRow->rev_id,
				"comments"		=> $iCount,
				"votes"			=> '',
				"props"			=> BlogArticle::getProps( $oRow->page_id ),
			);
			// Sort by comment count for popular blog posts module
			if ( isset( self::$aOptions['order'] ) && self::$aOptions['order'] == 'page_id' ) {
				uasort ( $aResult, array( "BlogTemplateClass", "__sortByCommentCount" ) );
			}
			// We may need to query for 50 results but display 5
			if ( isset( self::$aOptions['displaycount'] ) && ( self::$aOptions['displaycount'] != self::$aOptions['count'] ) ) {
				$aResult = array_slice( $aResult, 0, self::$aOptions['displaycount'] );
			}
		}

		// macbre: change for Oasis to add avatars and comments / likes data
		wfRunHooks( 'BlogTemplateGetResults', array( &$aResult ) );

		self::$dbr->freeResult( $res );
    	return $aResult;
	}

	public static function getOptions() {
		return self::$aOptions;
	}

	public static function getCategoryNames() {
		return self::$aCategoryNames;
	}

	public static function getResultsCount() {
		$row = self::$dbr->selectField(
			array_map( [ self::$dbr, 'tableName' ], self::$aTables ),
			[ 'count(distinct(page_id)) as count' ],
			self::$aWhere,
			__METHOD__
		);

		return $row ? (int)$row : 0;
	}

	private static function __makeRssOutput( $aInput ) {
		$aOutput = array();
		if ( !empty( $aInput ) ) {
			foreach ( $aInput as $iPage => $aRow ) {
				$oTitle = Title::newFromText( $aRow['title'], $aRow['namespace'] );
				if ( $oTitle instanceof Title ) {
					$aOutput[$iPage] = array(
						"title" 		=> $aRow['title'],
						"url"			=> $oTitle->getFullURL(),
						"description"	=> $aRow['text'],
						"author"		=> $aRow['username'],
						"category"		=> self::__getCategory( $oTitle->getFullText(), $iPage ),
						"timestamp"		=> $aRow['timestamp'],
						"namespace"		=> $aRow['namespace'],
					);
				}
			}
		}

		return $aOutput;
	}

	private static function __parse( $aInput, $aParams, &$parser, $returnPlainData = false ) {
		global $wgLang, $wgUser, $wgCityId, $wgParser, $wgOut;
		global $wgExtensionsPath, $wgStylePath, $wgRequest;

		/**
		 * Because this parser tag contains elements of interface we need to
		 * inform parser to vary parser cache key by user lang option
		 */

		/* @var $parser Parser */
		if ( ( $parser instanceof Parser ) && ( $parser->mOutput instanceof ParserOutput ) ) {
			$parser->mOutput->recordOption( 'userlang' );
		}

		$result = "";

		self::$aTables = self::$aWhere = self::$aOptions = array();
		self::$dbr = null;
		/* default settings for query */
		self::__setDefault();
		$showOnlyPage = 0;
		try {
			/* database connect */
			self::$dbr = wfGetDB( DB_SLAVE, 'dpl' );
			/* parse parameters as XML tags */
			wfDebugLog( __METHOD__, "parse " . count( $aInput ) . " parameters (XML tags)\n" );

			$relationArray = array();

			foreach ( $aInput as $sParamName => $aParamValues ) {
				/* ignore empty lines */
				if ( empty( $aParamValues ) ) {
					wfDebugLog( __METHOD__, "ignore empty param: " . $sParamName . " \n" );
					continue;
				}
				/* invalid name of parameter or empty name */
				if ( !in_array( $sParamName, array_keys( self::$aBlogParams ) ) ) {
					throw new Exception( wfMsg( 'blog-invalidparam', $sParamName, implode( ", ", array_keys( self::$aBlogParams ) ) ) );
				} elseif ( trim( $sParamName ) == '' ) {
					throw new Exception( wfMsg( 'blog-emptyparam' ) );
				}

				/* ignore comment lines */
				if ( $sParamName[0] == '#' ) {
					wfDebugLog( __METHOD__, "ignore comment line: " . $sParamName . " \n" );
					continue;
				}

				/* parse value of parameter */
				switch ( $sParamName ) {
					case 'category'		:
						if ( !empty( $aParamValues ) ) {
							$aParamValues = array_slice( $aParamValues, 0, self::$aBlogParams[$sParamName]['count'] );
							$aParamValues = str_replace ( " ", "_", $aParamValues );
							if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
								$relationArray[$sParamName] = $aParamValues;
							}
							$aPages = self::__getCategories( $aParamValues, $parser );
							if ( !empty( $aPages ) ) {
								self::$aWhere[] = "page_id in (" . implode( ",", $aPages ) . ")";
							} else {
								self::$aWhere[] = "page_id = 0";
							}
						}
						break;
					case 'pages'		:
						if ( !empty( $aParamValues ) ) {
							$showOnlyPage = $aParamValues ;
						}
						break;
					case 'author'		:
						if ( !empty( $aParamValues ) ) {
							$aParamValues = array_slice( $aParamValues, 0, self::$aBlogParams[$sParamName]['count'] );
							if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
								$relationArray[$sParamName] = $aParamValues;
								$aTmpWhere = array();
								foreach ( $aParamValues as $id => $sParamValue ) {
									$sParamValue = str_replace( " ", "\\_", $sParamValue );
									$aTmpWhere[] = "page_title like '" . addslashes( $sParamValue ) . "/%'";
								}
								if ( !empty( $aTmpWhere ) ) {
									self::$aWhere[] = implode( " OR ", $aTmpWhere );
								}
							}
						}
						break;
					case 'order'		:
						if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
							list ( $sParamValue ) = $aParamValues;
							self::__makeOrder( $sParamName, $sParamValue );
						}
						break;
					case 'ordertype'	:
					case 'type'		:
						if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
							list ( $sParamValue ) = $aParamValues;
							self::__makeListOption( $sParamName, $sParamValue );
						}
						break;
					case 'count'		:
					case 'displaycount' :
					case 'offset'		:
					case 'summarylength':
					case 'create_timestamp'	:
					case 'timestamp'	:
						if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
							list ( $sParamValue ) = $aParamValues;
							self::__makeIntOption( $sParamName, $sParamValue );
						}
						break;
					case 'summary'	:
					case 'paging'	:
						if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
							list ( $sParamValue ) = $aParamValues;
							self::__makeBoolOption( $sParamName, $sParamValue );
						}
						break;
					case 'seemore'  :
					case 'title'	:
					case 'class'	:
						if ( !empty( $aParamValues ) && is_array( $aParamValues ) ) {
							list ( $sParamValue ) = $aParamValues;

							self::__makeStringOption( $sParamName, $sParamValue );
						}
						break;
				}
			}

			wfRunHooks( 'BlogListAfterParse', array( self::$oTitle, $relationArray ) );

			/* */
			if ( !empty( $showOnlyPage ) ) {
				self::$aWhere = array( "page_id in (" . self::$dbr->makeList( $showOnlyPage ) . ")" );
			}

			// style attribute is deprecated but we cannot afford braking existing bloglist just because
			// they have style attribute - bugID: 68203 https://wikia.fogbugz.com/default.asp?68203
			unset( $aParams['style'] );

			/* parse parameters */
			foreach ( $aParams as $sParamName => $sParamValue ) {
				/* ignore empty lines */
				if ( !isset( $sParamValue ) ) {
					wfDebugLog( __METHOD__, "ignore empty param: " . $sParamName . " \n" );
					continue;
				}
				/* invalid name of parameter or empty name */
				if ( !in_array( $sParamName, array_keys( self::$aBlogParams ) ) ) {
					throw new Exception( wfMsg( 'blog-invalidparam', $sParamName, implode( ", ", array_keys( self::$aBlogParams ) ) ) );
				}
				/* parse value of parameter */
				switch ( $sParamName ) {
					case 'order'		:
						self::__makeOrder( $sParamName, $sParamValue );
						break;
					case 'ordertype'	:
					case 'type'	:
						self::__makeListOption( $sParamName, $sParamValue );
						break;
					case 'count'		:
					case 'displaycount' :
					case 'offset'		:
					case 'create_timestamp'	:
					case 'timestamp'	:
					case 'summarylength':
						self::__makeIntOption( $sParamName, $sParamValue );
						break;
					case 'summary'		:
					case 'paging'		:
						self::__makeBoolOption( $sParamName, $sParamValue );
						break;
					case 'seemore'      :
					case 'title' 		:
					case 'class'		:
						self::__makeStringOption( $sParamName, $sParamValue );
						break;
				}
			}

			// Allows caller to turn off paging of results
			if ( self::$aOptions['paging'] == true ) {
				$__pageVal = $wgRequest->getInt( 'page', 0 );
				if ( $__pageVal > 0 ) {
					$count = intval( self::$aOptions['count'] );
					self::__makeIntOption( 'offset', $count * ( $__pageVal - 1 ) );
				}
			}

			# use revision table to get results
			self::__addRevisionTable();

			/* build query */
			if ( $returnPlainData ) {
				$res = self::__getResults();
				return $res;
			} else {
				if ( !empty( $parser->mOutput ) && $parser->mOutput instanceof ParserOutput ) {
					$parser->mOutput->setProperty( "blogPostCount", self::getResultsCount() );
				}
				if ( self::$aOptions['type'] == 'count' ) {
					/* get results count */
					$result = self::getResultsCount();
				} else {
					$aResult = self::__getResults();
					/* set output */
					if ( !empty( $aResult ) ) {
						if ( self::$aOptions['type'] != 'array' ) {
							$sPager = "";
							if ( self::$aOptions['type'] == 'plain' ) {
								$iCount = self::getResultsCount();
								$aPager = self::__getPager( $iCount, intval( self::$aOptions['offset'] ) );
								$wgOut->addHeadItem( 'Paginator', $aPager['head'] );
								$sPager = $aPager['body'];
							}

							/**
							 * Don't cache the tag if there's pagination.
							 * We rely on Varnish caching for anonymous users and bots.
							 **/
							if ( $sPager &&
								$parser instanceof Parser &&
								$parser->mOutput instanceof ParserOutput
							) {
								$parser->mOutput->updateCacheExpiry( -1 );
							}

							if ( F::app()->checkSkin( 'oasis' ) ) {
								wfRunHooks( 'BlogsRenderBlogArticlePage', array( &$result, $aResult, self::$aOptions, $sPager ) );
							} else {
								/* run template */
								$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
								$oTmpl->set_vars( array(
									"wgUser"		=> $wgUser,
									"cityId"		=> $wgCityId,
									"wgLang"		=> $wgLang,
									"aRows"			=> $aResult,
									"aOptions"		=> self::$aOptions,
									"wgParser"		=> $wgParser,
									"skin"			=> RequestContext::getMain()->getSkin(),
									"wgExtensionsPath" 	=> $wgExtensionsPath,
									"wgStylePath" 		=> $wgStylePath,
									"sPager"		=> $sPager,
									"wgTitle"		=> self::$oTitle,
								) );
								# ---
								if ( self::$aOptions['type'] == 'box' ) {
									$result = $oTmpl->render( "blog-page" );
								} else {
									$page = $oTmpl->render( "blog-post-page" );
									$oTmpl->set_vars( array(
										"page" => $page
									) );
									$result = $oTmpl->render( "blog-article-page" );
								}
							}
						} else {
							unset( $result );
							$result = self::__makeRssOutput( $aResult );
						}
					} else {
						if ( !empty( self::$oTitle ) && self::$oTitle->getNamespace() == NS_BLOG_ARTICLE ) {
							$result = wfMsgExt( 'blog-empty-user-blog', array( 'parse' ) );
						}
						else {
							if ( self::$aOptions['type'] != 'array' ) {
								// $sk = RequestContext::getMain()->getSkin();
								$result = ""; // RT #69906
								// $result = wfMsg('blog-nopostfound') . " " . $sk->makeLinkObj(Title::newFromText('CreateBlogPage', NS_SPECIAL), wfMsg('blog-writeone' ) );
							}
							else {
								$result = "";
							}
						}
					}
				}
			}
        }
		catch ( Exception $e ) {
			wfDebugLog( __METHOD__, "parse error: " . $e->getMessage() . "\n" );

			return $e->getMessage();
		}

    	return $result;
	}

	private static function __getPager( $iTotal, $iOffset ) {
		global $wgExtensionsPath;

		$ns = self::$oTitle->getNamespace();

		if ( $iTotal <= 0 || empty( $iTotal ) || !in_array( $ns, [ NS_BLOG_LISTING, NS_BLOG_ARTICLE ] ) ) {
			return [
				'head' => '',
				'body' => '',
			];
		}

		$iCount = intval( self::$aOptions['count'] );
		$iPage = intval( $iOffset / $iCount ) + 1;

		$pages = new Wikia\Paginator\Paginator( $iTotal, $iCount, self::$oTitle->getLocalURL() );
		$pages->setActivePage( $iPage );

		$script = '';
		if ( NS_BLOG_LISTING == self::$oTitle->getNamespace() ) {
			$scriptUrl = $wgExtensionsPath . '/wikia/Blogs/js/BlogsPager.js';
			$script = '<script type="text/javascript" src="' . $scriptUrl . '"></script>';
		}

		return [
			'head' => $pages->getHeadItem(),
			'body' => $pages->getBarHTML( 'BlogPaginator' ) . $script,
		];
	}

	public static function getSubpageText( Title $Title ) {
		if ( !$Title instanceof Title ) {
			return "";
		}
		$parts = explode( '/', $Title->getText() );
		$res = ""; $cnt = count( $parts );
		if ( $cnt == 2 ) {
			$res = $parts[ $cnt - 1 ];
		} else {
			array_shift( $parts );
			$res = implode( '/', $parts );
		}
		return $res;
	}

	public static function axShowCurrentPage ( $articleId, $namespace, $page0, $skin ) {
		// $page0 is the 0-indexed page number: 0 for first page, 1 for second etc
		global $wgParser;
		$result = "";
		$page0 = intval( $page0 );
		if ( $page0 >= 0 ) {
			$oTitle = Title::newFromID( $articleId );
			if ( !empty( $oTitle ) && ( $oTitle instanceof Title ) ) {
				self::$oTitle = $oTitle;
				$oRevision = Revision::newFromTitle( $oTitle );
				$sText = $oRevision->getText();
				$id = Parser::extractTagsAndParams( array( BLOGTPL_TAG ), $oRevision->getText(), $matches, md5( BLOGTPL_TAG . $articleId . $namespace . $page0 ) );
				if ( !empty( $matches ) ) {
					list ( $sKey, $aValues ) = each ( $matches );
					list ( , $input, $params, ) = $matches[$sKey];
					$input = trim( $input );
					if ( !empty( $input ) && ( !empty( $params ) ) ) {
						$aTags = array();
						$count = 0;
						/* try to find count */
						if ( preg_match_all( BLOGS_XML_REGEX, $input, $aTags ) ) {
							if ( !empty( $aTags ) && ( !empty( $aTags[1] ) ) ) {
								if ( in_array( 'count', array_values( $aTags[1] ) ) ) {
									foreach ( $aTags[1] as $id => $key ) {
										if ( $key == 'count' ) {
											$count = intval( $aTags[2][$id] );
											break;
										}
									}
								}
							}
						}
						if ( !empty( $params ) && ( array_key_exists( 'count', $params ) ) ) {
							$count = intval( $params['count'] );
						}
						if ( empty( $count ) ) {
							$count = intval( self::$aBlogParams['count']['default'] );
						}
						/* set new value of offset */
						$params['offset'] = $count * $page0;

						/* run parser */
						$result = self::parseTag( $input, $params, $wgParser );
					}
				}
			} else {
				wfDebugLog( __METHOD__, "Invalid parameters - $articleId, $namespace, $page0 \n" );
			}
		}
		if ( is_array( $result ) ) {
			return $result[0];
		}
		return $result;
	}

	/**
	 * Retrieve short text from provided article
	 *
	 * This is a way to access a functionality of private __getRevisionText method
	 *
	 * @author Kamil Koterba
	 * @since June 2013
	 *
	 * @param integer $iPage Page id
	 * @param Revision $oRev Revision of article to get text from
	 * @return mixed|string
	 */
	public static function getShortText( $iPage, Revision $oRev ) {
		// backup current value
		$aOptions_bck = self::$aOptions;

		// set options required to retrieve short text
		self::$aOptions = array(
			'type' => 'plain',
			'summary' => 'true'
		);

		// get short text
		$shortText = self::__getRevisionText( $iPage, $oRev );

		// restore options
		self::$aOptions = $aOptions_bck;

		return $shortText;
	}
}
