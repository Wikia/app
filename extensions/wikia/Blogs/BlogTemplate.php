<?php

$wgAjaxExportList[] = "BlogTemplateClass::axShowCurrentPage";
$wgHooks['LanguageGetMagic'][] = "BlogTemplateClass::setMagicWord";
/* register as a parser function {{BLOGTPL_TAG}} and a tag <BLOGTPL_TAG> */
$wgHooks['ParserFirstCallInit'][] = "BlogTemplateClass::setParserHook";

define ("BLOGS_TIMESTAMP", "20081101000000");
define ("BLOGS_XML_REGEX", "/\<(.*?)\>(.*?)\<\/(.*?)\>/si");
define ("GROUP_CONCAT", "64000");
define ("BLOGS_DEFAULT_LENGTH", "400");
define ("BLOGS_HTML_PARSE", "/(<.+?>)?([^<>]*)/s");
define ("BLOGS_ENTITIES_PARSE", "/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i");
define ("BLOGS_CLOSED_TAGS", "/^<\s*\/([^\s]+?)\s*>$/s");
define ("BLOGS_OPENED_TAGS", "/^<\s*([^\s>!]+).*?>$/s");

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
         * order = date (or title or author)
		 *
		 * type: 	element of predefined list (date, title, author)
         * default: timestamp
         */
		'order' 		=> array (
			'type' 		=> 'list',
			'default' 	=> 'date',
			'pattern'	=> array(
				'date' 	=> 'rev_timestamp',
				'author'=> 'page_title'
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
			'pattern'	=> array('desc', 'asc')
		),

		/*
		 * max of results to display.
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
		 * show date of blog creation
		 * timestamp = false (or true)
		 *
		 * type: 	boolean,
		 * default: false
		 */
		'timestamp' => array (
			'type' 		=> 'boolean',
			'default' 	=> false
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
		 * number of characters in summary
		 * summarylength = /^\d*$/
		 *
		 * type: 	number,
		 * default: 100  (changed for oasis)
		 */
		'summarylength' 	=> array (
			'type' 		=> 'number',
			'default' 	=> array('box' => '100', 'plain' => '750'),
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
		 * Additional CSS styles
		 *
		 * type: 	string,
		 * default: ""
		 */
		'style' => array (
			'type' 		=> 'string',
			'default' 	=> 'float:right;clear:left;',
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
		)
	);

	private static $aTables		= array( );
	private static $aWhere 		= array( );
	private static $aOptions	= array( );
	private static $aCategoryNames = array( );

	private static $dbr 		= null;
	private static $catparser	= null;

	private static $search 		= array (
		//'/<table[^>]*>.*<\/table>/siU',
        '/(<table[^>]*>|<\/table>)/i',
        '/(<tr[^>]*>|<\/tr>)/i',
        '/<td[^>]*>(.*?)<\/td>/i',
        '/<th[^>]*>(.*?)<\/th>/ie',
		'/<div[^>]*>.*<\/div>/siU',
		'/<style[^>]*>.*<\/style>/siU',
		'/<script[^>]*>.*<\/script>/siU',
		'/<h\d>.*<\/h\d>/siU',
		'/[\n]{2,}/siU',
		'/[\t]+/siU',
	);

	private static $replace		= array (
		//'/<table[^>]*>.*<\/table>/siU',
        '', //table
        '', //tr
        '', //td
        '', //th
		'', //div
		'', //style
		'', //script
		'', //<h\d>
		'<br/>', //\n
        '&nbsp;', //\t
	);

	private static $skipStrinBeforeParse	= "<p><div><a><b><del><i><ins><u><font><big><small><sub><sup><cite><code><em><s><strike><strong><tt><var><center><blockquote><ol><ul><dl><u><q><abbr><acronym><li><dt><dd><span>";
	private static $skipStrinAfterParse		= "<p><b><del><i><ins><u><font><big><small><sub><sup><cite><code><em><s><strike><strong><tt><var><center><blockquote><ol><ul><dl><u><q><abbr><acronym><li><dt><dd><span>";
	private static $parseTagTruncateText	= "/<(p|a(.*))>(.*)<\/(p|a)>/siU";

	private static $pageOffsetName 			= "page";
	private static $oTitle 					= null;

	private static $blogWIKITEXT = array(
		"/\[\[Video\:(.*)\]\]\s/iU",
		"/\[\[Image\:(.*)\]\]/siU",
		"/\[\[File\:(.*)\]\]/siU",
		"/\[\[(.*)\:((.+\.[a-z]{3,4})(\|)(.*))*\]\](.*)/i", #images [[Image:Test.png|(.*)]]
		"/\[\[(.*)\:((.+\.[a-z]{3,4}))\]\]/i", #images [[Image:Test.png]]
	);

	private static $blogTAGS = array(
		"/\{\{#dpl(.*)\}\}/siU",
		"/\{\{#dplchapter(.*)\}\}/siU",
		"/<(dpl|dynamicpagelist)(.*)>(.*)<\/(dpl|dynamicpagelist)>/siU",
		"/<(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)(.*)>(.*)<\/(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)>/siU",
		"/<(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet)(.*)>(.*)<\/(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet)>/siU",
	);

	public static function setMagicWord( &$magicWords, $langCode ) {
		wfProfileIn( __METHOD__ );
		wfLoadExtensionMessages("Blogs");
		/* add the magic word */
		$magicWords[ BLOGTPL_TAG ] = array( 0, BLOGTPL_TAG );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function setParserHook( &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( BLOGTPL_TAG, array( __CLASS__, "parseTag" ) );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function parseTag( $input, $params, &$parser ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );
		wfLoadExtensionMessages("Blogs");
		/* parse input parameters */
		if (is_null(self::$oTitle)) {
			self::$oTitle = ( is_null($wgTitle) ) ? $parser->getTitle() : $wgTitle;
		}

		$aParams = self::__parseXMLTag($input);
		wfDebugLog( __METHOD__, "parse input parameters\n" );
		/* parse all and return result */
		$res = self::__parse($aParams, $params, $parser);
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public static function parseTagWithTitle($input, $params, &$parser, $oTitle) {
		self::$oTitle = $oTitle;
		return self::parseTag( $input, $params, $parser );
	}

	public static function getUserNameRecord($username, $nofollow = false) {
		wfProfileIn( __METHOD__ );
		$aResult = array();

		// RT #18653
		if (!empty($nofollow)) {
			$attribs = array('rel' => 'nofollow');
		}
		else {
			$attribs = array();
		}

		if (!empty($username)) {
			$oUser = User::newFromName($username);
			if ( $oUser instanceof User ) {
				global $wgUser;
				$sk = $wgUser->getSkin();
				$oUserPage = $oUser->getUserPage();
				$oUserTalkPage = $oUser->getTalkPage();
				$aResult = array(
					"userpage" => ($oUserPage instanceof Title) ? $sk->link($oUserPage, $oUser->getName(), $attribs) : "",
					"talkpage" => ($oUserTalkPage instanceof Title) ? $sk->link($oUserTalkPage, wfMsg( 'sp-contributions-talk' ), $attribs) : "",
					"contribs" => $sk->link(
						SpecialPage::getTitleFor( 'Contributions' ),
						wfMsg( 'contribslink' ),
						$attribs,
						array( 'target' => $oUser->getName() )
					),
				);
			}
		}
		wfProfileOut( __METHOD__ );
		return $aResult;
	}

	/*
	 * private method
	 */

	private static function __getCategory($sPageName, $iPage) {
		wfProfileIn( __METHOD__ );
		$aCategories = array();

		$oFauxRequest = new FauxRequest(
			array(
				"action"	=> "query",
				"prop"		=> "categories",
				"titles"	=> $sPageName,
			)
		);
		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult =& $oApi->GetResultData();

		if ( count($aResult['query']['pages']) > 0 ) {
			if (!empty($aResult['query']['pages'][$iPage]['categories'])) {
				foreach ($aResult['query']['pages'][$iPage]['categories'] as $id => $aCategory) {
					$oCatTitle = Title::newFromText($aCategory['title'], $aCategory['ns']);
					if ($oCatTitle instanceof Title) {
						$aCategories[] = $oCatTitle->getFullURL();
					}
				}
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $aCategories;
	}

	public static function __getVoteCode($iPage) {
		global $wgUser;

		wfProfileIn( __METHOD__ );
		if( get_class( $wgUser->getSkin() ) == 'SkinMonaco' ) {

			$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $iPage, "wkuservote" => true ));
			$oApi = new ApiMain($oFauxRequest);
			$oApi->execute();
			$aResult =& $oApi->GetResultData();

			if(count($aResult['query']['wkvoteart']) > 0) {
				if (!empty($aResult['query']['wkvoteart'][$iPage]['uservote'])) {
					$voted = true;
				} else {
					$voted = false;
				}
				$rating = $aResult['query']['wkvoteart'][$iPage]['votesavg'];
			} else {
				$voted = false;
				$rating = 0;
			}
			$sHiddenStar = $voted ? ' style="display: none;"' : '';
			$iRating = round($rating * 2)/2;
			$iRatingPx = round($rating * 17);

			/* run template */
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"ratingPx"		=> $iRatingPx,
				"rating"		=> $iRating,
				"hidden_star"	=> $sHiddenStar,
			));
			$return = $oTmpl->execute("blog-page-voting");
		}
		else {
			$return = "";
		}
		wfProfileOut( __METHOD__ );
		return $return;
	}

	private static function __parseXMLTag($string) {
		wfProfileIn( __METHOD__ );
		$aResult = array();
		$aRes = $aTags = array();
		if (preg_match_all(BLOGS_XML_REGEX, $string, $aTags)) {
			list (, $sStartTags, $sTexts, $sEndTags) = $aTags;
			wfDebugLog( __METHOD__, "found ".count($sStartTags)." tags\n" );
			foreach ($sStartTags as $id => $sStartTag) {
				/* allow this tag? */
				if ( in_array($sStartTag, array_keys(self::$aBlogParams)) ) {
					/* <TAG> = </TAG> */
					$sStartTag = trim($sStartTag);
					$sEndTags[$id] = trim($sEndTags[$id]);
					if ($sStartTag == $sEndTags[$id]) {
						$aRes[$sStartTag][] = trim($sTexts[$id]);
					}
				}
			}
			wfDebugLog( __METHOD__, "allowed tags : ".count($aRes)."\n" );
			if ( !empty($aRes) )  {
				$string = "";
				foreach ($aRes as $sParamName => $aParamValues) {
					if ( !empty($aParamValues) ) {
						foreach ($aParamValues as $id => $sParamValue) {
							if ( strpos( $sParamValue, "\n" ) !== FALSE ) {
								$aResult[$sParamName] = array_merge( (array)$aResult[$sParamName], array_map( 'trim', explode( "\n", $sParamValue) ) );
							} else {
								$aResult[$sParamName][] = $sParamValue;
							}
						}
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $aResult;
	}

	private static function __getmicrotime(){
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
    }

	private static function __setDefault() {
		/* set default options */
    	wfProfileIn( __METHOD__ );
		/* default tables */
		if ( !in_array( "page", self::$aTables) ) {
			self::$aTables[] = "page";
		}
		/* default conditions */
		if ( !in_array("page_namespace", array_keys( self::$aWhere )) ) {
			self::$aWhere["page_namespace"] = NS_BLOG_ARTICLE;
		}
		if ( !in_array("page_is_redirect", array_keys( self::$aWhere )) ) {
			self::$aWhere["page_is_redirect"] = 0;
		}
		self::$aWhere[] = "page_title like '%/%'";
		/* default options */
		/* order */
		if ( !isset(self::$aOptions['order']) ) {
			self::__makeOrder('order', self::$aBlogParams['order']['default']);
		}
		/* ordertype */
		if ( !isset(self::$aOptions['ordertype']) ) {
			self::__makeListOption('ordertype', self::$aBlogParams['ordertype']['default']);
		}
		/* count */
		if ( !isset(self::$aOptions['count']) ) {
			self::__makeIntOption('count', self::$aBlogParams['count']['default']);
		}
		/* offset */
		if ( !isset(self::$aOptions['offset']) ) {
			self::__makeIntOption('offset', self::$aBlogParams['offset']['default']);
		}
		/* type */
		if ( !isset(self::$aOptions['type']) ) {
			self::__makeListOption('type', self::$aBlogParams['type']['default']);
		}
		/* title */
		if ( !isset(self::$aOptions['title']) ) {
			self::__makeStringOption('title', wfMsg('blog-defaulttitle'));
		}
		/* style */
		if ( !isset(self::$aOptions['style']) ) {
			if (self::$aOptions['type'] == 'box') {
				self::__makeStringOption('style', self::$aBlogParams['style']['default']);
			}
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeOrder($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeOrder: ".$sParamName.",".$sParamValue."\n" );
    	if ( !empty($sParamValue) ) {
			if ( in_array( $sParamValue, array_keys( self::$aBlogParams[$sParamName]['pattern'] ) ) ) {
				self::$aOptions['order'] = self::$aBlogParams[$sParamName]['pattern'][$sParamValue];
			}
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeListOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeListOption: ".$sParamName.",".$sParamValue."\n" );
		if ( in_array( $sParamValue, self::$aBlogParams[$sParamName]['pattern'] ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeBoolOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeBoolOption: ".$sParamName.",".$sParamValue."\n" );
		if ( in_array($sParamValue, array("true", "false", 0, 1) ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeStringOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeStringOption: ".$sParamName.",".$sParamValue."\n" );
		self::$aOptions[$sParamName] = $sParamValue;
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeIntOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeIntOption: ".$sParamName.",".$sParamValue."\n" );
		$m = array();
		if ( array_key_exists($sParamName, self::$aBlogParams) ) {
			if (preg_match(self::$aBlogParams[$sParamName]['pattern'], $sParamValue, $m) !== FALSE) {
				/* check max value of int param */
				if ( isset(self::$aBlogParams[$sParamName]) &&
					array_key_exists('max', self::$aBlogParams[$sParamName]) &&
					($sParamValue > self::$aBlogParams[$sParamName]['max'])
				) {
					$sParamValue = self::$aBlogParams[$sParamName]['max'];
				}
				self::$aOptions[$sParamName] = $sParamValue;
			}
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __addRevisionTable() {
    	wfProfileIn( __METHOD__ );
		$sRevisionTable = 'revision';
		if ( !in_array($sRevisionTable, self::$aTables) ) {
			self::$aWhere[] = "rev_page = page_id";
			self::$aTables[] = $sRevisionTable;
			if ( BLOGS_TIMESTAMP ) {
				self::$aWhere[] = "rev_timestamp >= '".BLOGS_TIMESTAMP."'";
			}
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeDBOrder() {
    	wfProfileIn( __METHOD__ );
    	$dbOption = array();
    	/* ORDER BY */
    	if ( isset(self::$aOptions['order']) ) {
    		$dbOption['ORDER BY'] = self::$aOptions['order'];
    		if ( isset(self::$aOptions['ordertype']) ) {
    			$dbOption['ORDER BY'] .= " " . self::$aOptions['ordertype'];
			}
		}
		/* GROUP BY */
		$dbOption['GROUP BY'] = "page_id";
    	/* LIMIT  */
    	if ( isset(self::$aOptions['count']) ) {
    		$dbOption['LIMIT'] = intval(self::$aOptions['count']);
		} else {
    		$dbOption['LIMIT'] = intval(self::$aOptions['count']['default']);
		}
    	/* OFFSET  */
    	if ( isset(self::$aOptions['offset']) ) {
    		$dbOption['OFFSET'] = intval(self::$aOptions['offset']);
		} else {
    		$dbOption['OFFSET'] = intval(self::$aOptions['offset']['default']);
		}
    	wfProfileOut( __METHOD__ );
    	return $dbOption;
	}

	private static function __parseCategories($text, $parser) {
		if ( is_object($parser) ) {
			$pOptions = $parser->getOptions();
			if ( is_null($pOptions) ) {
				$parser->startExternalParse( $wgTitle, new ParserOptions(), OT_PREPROCESS );
			}
			$text = $parser->replaceVariables($text);
		}
		return $text;
	}

	private static function __getCategories ($aParamValues, &$parser) {
    	wfProfileIn( __METHOD__ );
		self::$aCategoryNames = $aParamValues;
		$aPages = array();
    	if ( !empty($aParamValues) ) {
    		#RT 26917
    		$aParamValues = array_map( "strip_tags",
    			array_map(
    				array("self","__parseCategories"),
    				$aParamValues,
    				array($parser)
    			)
    		);
			/* set max length of group concat query */
			self::$dbr->query( 'SET group_concat_max_len = '.GROUP_CONCAT, __METHOD__ );
			/* run query */
			$res = self::$dbr->select(
				array( self::$dbr->tableName( 'page' ), self::$dbr->tableName( 'categorylinks' ) ),
				array( "cl_to", "GROUP_CONCAT(DISTINCT cl_from SEPARATOR ',') AS cl_page" ),
				array(
					"page_namespace" => NS_BLOG_ARTICLE,
					"page_id = cl_from",
					"cl_to in (".self::$dbr->makeList( $aParamValues ).")",
					"page_touched >= ".self::$dbr->addQuotes(BLOGS_TIMESTAMP)
				),
				__METHOD__,
				array( 'GROUP BY' => 'cl_to' )
			);
			while ( $oRow = self::$dbr->fetchObject( $res ) ) {
				$aPages[] = $oRow->cl_page;
			}
			self::$dbr->freeResult( $res );
		}
    	wfProfileOut( __METHOD__ );
    	return $aPages;
	}

	private static function __truncateText( $sText, $iLength = BLOGS_DEFAULT_LENGTH, $sEnding ) {
		global $wgLang;

		wfProfileIn( __METHOD__ );

		$sResult = "";
		if ( empty($iLength) ) {
			if (!empty(self::$aOptions['summarylength'])) {
				$iLength = self::$aOptions['summarylength'];
			} else {
				if (self::$aOptions['type'] == 'box') {
					$iLength = intval(self::$aBlogParams['summarylength']['default']['box']);
				} else {
					$iLength = intval(self::$aBlogParams['summarylength']['default']['plain']);
				}
			}
		}

		if (mb_strlen(strip_tags($sText)) <= $iLength) {
			/* if text without HTML is shorter than the maximum length, return text */
			$sResult = $sText;
		} else {
			/* splits all self::$skipSplitAfterParse to lines */
			$aLines = array();
			if (preg_match_all(BLOGS_HTML_PARSE, $sText, $aLines, PREG_SET_ORDER) !== false) {
				$iTotalLength = mb_strlen($sEnding);
				$aTags = array();

				foreach ($aLines as $aLine) {
					/* HTML-tag exists */
					$currentTag = "";
					if ( !empty($aLine[1]) ) {
						$aTag = array();
						if ( preg_match(BLOGS_CLOSED_TAGS, $aLine[1], $aTag) ) {
							$__find = array_search(strtolower(trim($aTag[1])), $aTags);
							/* closed tags </p|a> - unset from opened-tags list */
							if ( $__find !== false ) {
								unset($aTags[$__find]);
							}
							$currentTag = strtolower(trim($aTag[1]));
							#$sResult .= ($currentTag == "a") ? $aLine[1] . " " : $aLine[1];
							$sResult .= $aLine[1];
						} else if (preg_match(BLOGS_OPENED_TAGS, $aLine[1], $aTag)) {
							/* opened tags <p|a> - add to opened-tags list */
							$currentTag = strtolower(trim($aTag[1]));
							array_unshift( $aTags, $currentTag );
							$sResult .= $aLine[1];
						}
					}

					/* calculate special entites */
					$iEntLength = mb_strlen(preg_replace(BLOGS_ENTITIES_PARSE, ' ', trim($aLine[2])));
					if ( ($iTotalLength + $iEntLength) > $iLength) {
						$iMaxLength = $iLength - $iTotalLength;
						$iEntLength = 0;
						$aEntities = array();
						if (preg_match_all(BLOGS_ENTITIES_PARSE, $aLine[2], $aEntities, PREG_OFFSET_CAPTURE)) {
							foreach ($aEntities[0] as $aEntity) {
								if ( ($aEntity[1] - $iEntLength + 1) <= $iMaxLength) {
									$iEntLength += mb_strlen( $aEntity[0] );
									$iMaxLength--;
								} else {
									break;
								}
							}
						}
						$sResult .= mb_substr($aLine[2], 0, $iMaxLength + $iEntLength);
						break;
					} else {
						$sResult .= $aLine[2];
						$iTotalLength += $iEntLength;
					}
					if($iTotalLength >= $iLength) {
						break;
					}
				}

				/* close all opened tags */
				if ( !empty($sEnding) ) {
					$sResult .= $sEnding;
				}
				foreach ($aTags as $sTag) {
					$sResult .= "</{$sTag}>";
				}
			} else {
				$sResult = $wgLang->truncate( $sText, $iLength, $sEnding );
			}

			$aMatches = array();
		}

		$sResult = preg_replace('/[\r\n]{2,}/siU', '<br />', trim($sResult));
		return $sResult;
	}


	private static function __getRevisionText($iPage, $oRev) {
		global $wgLang, $wgUser;
		wfProfileIn( __METHOD__ );
		$sResult = "";
		/* parse summary */
		if ( (!empty($oRev)) && (!empty(self::$aOptions['summary'])) ) {
			$sBlogText = $oRev->revText();
			/* parse or not parse - this is a good question */
			$localParser = new Parser();
			if ( !in_array(self::$aOptions['type'], array('array', 'noparse')) ) {
				/* skip HTML tags */
				if (!empty(self::$blogTAGS)) {
					/* skip some special tags  */
					foreach (self::$blogTAGS as $id => $tag) {
						$sBlogText = preg_replace($tag, '', $sBlogText);
					}
				}
				$sBlogText = strip_tags($sBlogText, self::$skipStrinBeforeParse);
				/* skip invalid Wiki-text  */
				$sBlogText = preg_replace('/\{\{\/(.*?)\}\}/si', '', $sBlogText);
				$sBlogText = preg_replace('/\{\{(.*?)\}\}/si', '', $sBlogText);
				if (!empty(self::$blogWIKITEXT)) {
					/* skip some wiki-text */
					foreach (self::$blogWIKITEXT as $id => $tag) {
						$sBlogText = preg_replace($tag, '', $sBlogText);
					}
				}
				/* parse truncated text */
				$parserOutput = $localParser->parse($sBlogText, Title::newFromId($iPage), ParserOptions::newFromUser($wgUser));
				/* replace unused HTML tags */
				$sBlogText = preg_replace(self::$search, self::$replace, $parserOutput->getText());
				/* skip HTML tags */
				$sBlogText = strip_tags($sBlogText, self::$skipStrinAfterParse);
				/* truncate text */
				$cutSign = wfMsg( "blug-cut-sign" );
				$sResult = self::__truncateText($sBlogText, isset(self::$aOptions['summarylength']) ? intval(self::$aOptions['summarylength']) : BLOGS_DEFAULT_LENGTH, $cutSign );
			} else {
				/* parse revision text */
				$parserOutput = $localParser->parse($sBlogText, Title::newFromId($iPage), ParserOptions::newFromUser($wgUser));
				$sResult = $parserOutput->getText();
			}
		}
		wfProfileOut( __METHOD__ );
		return $sResult;
	}

	private static function __getResults() {
		global $wgLang;
    	wfProfileIn( __METHOD__ );
    	/* main query */
    	$aResult = array();
    	$aFields = array( '/* BLOGS */ rev_page as page_id','page_namespace','page_title','unix_timestamp(rev_timestamp) as timestamp','rev_timestamp','min(rev_id) as rev_id','rev_user' );
		$res = self::$dbr->select(
			array_map(array(self::$dbr, 'tableName'), self::$aTables),
			$aFields,
			self::$aWhere,
			__METHOD__,
			self::__makeDBOrder()
		);
		while ( $oRow = self::$dbr->fetchObject( $res ) ) {
			if (class_exists('ArticleCommentList')) {
				$oComments = ArticleCommentList::newFromText( $oRow->page_title, $oRow->page_namespace );
				$iCount = $oComments ? $oComments->getCountAllNested() : 0;
			} else {
				$iCount = 0;
			}

			/* username */
			$oTitle = Title::newFromText($oRow->page_title, $oRow->page_namespace);
			$sUsername = "";
			if (! $oTitle instanceof Title) continue;
			$username = BlogArticle::getOwner( $oTitle );
			$oRevision = Revision::newFromTitle($oTitle);

			$aResult[$oRow->page_id] = array(
				"page" 			=> $oRow->page_id,
				"namespace" 	=> $oRow->page_namespace,
				"title" 		=> $oRow->page_title,
				"page_touched" 	=> (!is_null($oRevision)) ? $oRevision->getTimestamp() : $oTitle->getTouched(),
				"rev_timestamp"	=> $oRow->rev_timestamp,
				"timestamp" 	=> $oRow->timestamp,
				"username"		=> (isset($username)) ? $username : "",
				"text"			=> self::__getRevisionText($oRow->page_id, $oRevision),
				"revision"		=> $oRow->rev_id,
				"comments"		=> $iCount,
				"votes"			=> self::__getVoteCode($oRow->page_id),
				"props"			=> BlogArticle::getProps($oRow->page_id),
			);
		}

		// macbre: change for Oasis to add avatars and comments / likes data
		wfRunHooks('BlogTemplateGetResults', array(&$aResult));

		self::$dbr->freeResult( $res );
    	wfProfileOut( __METHOD__ );
    	return $aResult;
	}

	public static function getOptions() {
		return self::$aOptions;
	}

	public static function getCategoryNames() {
		return self::$aCategoryNames;
	}

	public static function getResultsCount() {
		global $wgLang;
    	wfProfileIn( __METHOD__ );
    	/* main query */
    	$aResult = array();
    	$aFields = array( 'distinct(page_id) as page_id' );
		$res = self::$dbr->select(
			array_map(array(self::$dbr, 'tableName'), self::$aTables),
			$aFields,
			self::$aWhere,
			__METHOD__
		);
    	wfProfileOut( __METHOD__ );
		return self::$dbr->numRows( $res );
	}

	private static function __makeRssOutput($aInput) {
		wfProfileIn( __METHOD__ );
		$aOutput = array();
		if (!empty($aInput)) {
			foreach ($aInput as $iPage => $aRow) {
				$oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
				if ($oTitle instanceof Title) {
					$aOutput[$iPage] = array(
						"title" 		=> $aRow['title'],
						"url"			=> $oTitle->getFullURL(),
						"description"	=> $aRow['text'],
						"author"		=> $aRow['username'],
						"category"		=> self::__getCategory($oTitle->getFullText(), $iPage),
						"timestamp"		=> $aRow['timestamp'],
						"namespace"		=> $aRow['namespace'],
					);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $aOutput;
	}

	private static function __parse( $aInput, $aParams, &$parser ) {
		global $wgLang, $wgUser, $wgCityId, $wgParser, $wgTitle;
		global $wgExtensionsPath, $wgStylePath, $wgRequest;

		wfProfileIn( __METHOD__ );
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
			wfDebugLog( __METHOD__, "parse ".count($aInput)." parameters (XML tags)\n" );

			$relationArray = array();

			foreach ($aInput as $sParamName => $aParamValues) {
				/* ignore empty lines */
				if ( empty($aParamValues) ) {
					wfDebugLog( __METHOD__, "ignore empty param: ".$sParamName." \n" );
					continue;
				}
				/* invalid name of parameter or empty name */
				if ( !in_array($sParamName, array_keys(self::$aBlogParams)) ) {
					throw new Exception( wfMsg('blog-invalidparam', $sParamName, implode(", ", array_keys(self::$aBlogParams))) );
				} elseif ( trim($sParamName) == '' ) {
					throw new Exception(wfMsg('blog-emptyparam'));
				}

				/* ignore comment lines */
				if ($sParamName[0] == '#') {
					wfDebugLog( __METHOD__, "ignore comment line: ".$iKey." \n" );
					continue;
				}

				/* parse value of parameter */
				switch ($sParamName) {
					case 'category'		:
						if ( !empty($aParamValues) ) {
							$aParamValues = array_slice($aParamValues, 0, self::$aBlogParams[$sParamName]['count']);
							$aParamValues = str_replace (" ", "_", $aParamValues);
							if ( !empty($aParamValues) && is_array( $aParamValues ) ) {
								$relationArray[$sParamName] = $aParamValues;
							}
							$aPages = self::__getCategories($aParamValues, $parser);
							if ( !empty($aPages) ) {
								self::$aWhere[] = "page_id in (" . implode(",", $aPages) . ")";
							} else {
								self::$aWhere[] = "page_id = 0";
							}
						}
						break;
					case 'pages'		:
						if ( !empty($aParamValues) ) {
							$showOnlyPage = $aParamValues ;
						}
						break;
					case 'author'		:
						if ( !empty($aParamValues) ) {
							$aParamValues = array_slice($aParamValues, 0, self::$aBlogParams[$sParamName]['count']);
							if ( !empty($aParamValues) && is_array( $aParamValues ) ) {
								$relationArray[$sParamName] = $aParamValues;
								$aTmpWhere = array();
								foreach ( $aParamValues as $id => $sParamValue ) {
									$sParamValue = str_replace(" ", "_", $sParamValue);
									$aTmpWhere[] = "page_title like '".addslashes($sParamValue)."/%'";
								}
								if ( !empty($aTmpWhere) ) {
									self::$aWhere[] = implode(" OR ", $aTmpWhere);
								}
							}
						}
						break;
					case 'order'		:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeOrder($sParamName, $sParamValue);
						}
						break;
					case 'ordertype'	:
					case 'type'		:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeListOption($sParamName, $sParamValue);
						}
						break;
					case 'count'		:
					case 'offset'		:
					case 'summarylength':
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeIntOption($sParamName, $sParamValue);
						}
						break;
					case 'timestamp':
					case 'summary'	:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeBoolOption($sParamName, $sParamValue);
						}
						break;
					case 'title'	:
					case 'style'	:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeStringOption($sParamName, $sParamValue);
						}
						break;
				}
			}

			wfRunHooks( 'BlogListAfterParse', array( self::$oTitle, $relationArray ) );

			/* */
			if ( !empty($showOnlyPage) ) {
				self::$aWhere = array("page_id in (" . self::$dbr->makeList($showOnlyPage) . ")");
			}

			/* parse parameters */
			foreach ($aParams as $sParamName => $sParamValue) {
				/* ignore empty lines */
				if ( empty($sParamValue) ) {
					wfDebugLog( __METHOD__, "ignore empty param: ".$sParamName." \n" );
					continue;
				}
				/* invalid name of parameter or empty name */
				if ( !in_array($sParamName, array_keys(self::$aBlogParams)) ) {
					throw new Exception( wfMsg('blog_invalidparam', $sParamName, implode(", ", array_keys(self::$aBlogParams))) );
				}

				/* parse value of parameter */
				switch ($sParamName) {
					case 'order'		:
						self::__makeOrder($sParamName, $sParamValue);
						break;
					case 'ordertype'	:
					case 'type'	:
						self::__makeListOption($sParamName, $sParamValue);
						break;
					case 'count'		:
					case 'offset'		:
					case 'summarylength':
						self::__makeIntOption($sParamName, $sParamValue);
						break;
					case 'timestamp'	:
					case 'summary'		:
						self::__makeBoolOption($sParamName, $sParamValue);
						break;
					case 'title' 		:
					case 'style'		:
						self::__makeStringOption($sParamName, $sParamValue);
						break;
				}
			}

			$__pageVal = $wgRequest->getVal('page');
			if ( isset($__pageVal) && (!empty($__pageVal)) ) {
				$count = intval(self::$aOptions['count']);
				self::__makeIntOption('offset', $count * $__pageVal);
			}

			# use revision table to get results
			self::__addRevisionTable();

			/* build query */
			if ( self::$aOptions['type'] == 'count' ) {
				/* get results count */
				$result = self::getResultsCount();
			} else {
				$aResult = self::__getResults();
				/* set output */
				if (!empty($aResult)) {
					if ( self::$aOptions['type'] != 'array' ) {
						$sPager = "";
						if (self::$aOptions['type'] == 'plain') {
							$iCount = self::getResultsCount();
							$sPager = self::__setPager($iCount, intval(self::$aOptions['offset']));
						}
						/* run template */
						$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
						$oTmpl->set_vars( array(
							"wgUser"		=> $wgUser,
							"cityId"		=> $wgCityId,
							"wgLang"		=> $wgLang,
							"aRows"			=> $aResult,
							"aOptions"		=> self::$aOptions,
							"wgParser"		=> $wgParser,
							"skin"			=> $wgUser->getSkin(),
							"wgExtensionsPath" 	=> $wgExtensionsPath,
							"wgStylePath" 		=> $wgStylePath,
							"sPager"		=> $sPager,
							"wgTitle"		=> self::$oTitle,
						) );
						#---
						if ( self::$aOptions['type'] == 'box' ) {
							$result = $oTmpl->execute("blog-page");
						} else {
							$page = $oTmpl->execute("blog-post-page");
							$oTmpl->set_vars( array(
								"page" => $page
							) );
							$result = $oTmpl->execute("blog-article-page");
						}
						// macbre: let Oasis add HTML
						wfRunHooks('BlogsRenderBlogArticlePage', array(&$result, $aResult, self::$aOptions));
					} else {
						unset($result);
						$result = self::__makeRssOutput($aResult);
					}
				} else {
					if( !empty( self::$oTitle ) && self::$oTitle->getNamespace() == NS_BLOG_ARTICLE) {
						$result = wfMsgExt('blog-empty-user-blog', array('parse'));
					}
					else {
						if ( self::$aOptions['type'] != 'array' ) {
							$sk = $wgUser->getSkin();
							$result = wfMsg('blog-nopostfound') . " " . $sk->makeLinkObj(Title::newFromText('CreateBlogPage', NS_SPECIAL), wfMsg('blog-writeone' ) );
						}
						else {
							$result = "";
						}
					}
				}
			}
        }
		catch (Exception $e) {
			wfDebugLog( __METHOD__, "parse error: ".$e->getMessage()."\n" );
			return $e->getMessage();
		}

    	wfProfileOut( __METHOD__ );
    	return $result;
	}

	private static function __setPager($iTotal, $iPage) {
		global $wgUser;
		global $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );

		$sPager = "";
		if ($iTotal<=0 || empty($iTotal)) {
			wfDebugLog( __METHOD__, "cannot make pager - no results found: ".$iTotal."\n" );
		} else {
			$iPageCount = ceil( $iTotal / self::$aOptions['count'] );
			$iPage = (isset(self::$aOptions['count']) && self::$aOptions['count'] > 0) ? ceil($iPage/intval(self::$aOptions['count'])) : 0;
			#---
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"iPageCount"		=> $iPageCount,
				"iPage"			=> $iPage,
				"iTotal"		=> $iTotal,
				"wgTitle"		=> self::$oTitle,
				"pageOffsetName"	=> self::$pageOffsetName,
				"wgExtensionsPath" 	=> $wgExtensionsPath,
				"wgStyleVersion"	=> $wgStyleVersion,
			) );
			#---
			$sPager = ( NS_BLOG_LISTING == self::$oTitle->getNamespace() ) ? $oTmpl->execute("blog-pager-ajax") :
						( ( NS_BLOG_ARTICLE == self::$oTitle->getNamespace() ) ? $oTmpl->execute("blog-pager") : "" );
		}

		wfProfileOut( __METHOD__ );
		return $sPager;
	}

	public static function getSubpageText(Title $Title) {
		if ( !$Title instanceof Title ) {
			return "";
		}
		$parts = explode( '/', $Title->getText() );
		$res = ""; $cnt = count( $parts );
		if ( $cnt == 2 ) {
			$res = $parts[ $cnt - 1 ];
		} else {
			array_shift($parts);
			$res = implode( '/', $parts );
		}
		return $res;
	}

	public static function axShowCurrentPage ($articleId, $namespace, $offset) {
		global $wgParser;
		wfProfileIn( __METHOD__ );
		$result = "";
		$offset = intval($offset);
		if ($offset >= 0) {
			$oTitle = Title::newFromID($articleId);
			if ( !empty($oTitle) && ($oTitle instanceof Title) ) {
				self::$oTitle = $oTitle;
				$oRevision = Revision::newFromTitle($oTitle);
				$sText = $oRevision->getText();
				$id = Parser::extractTagsAndParams( array(BLOGTPL_TAG), $oRevision->getText(), $matches, md5(BLOGTPL_TAG . $articleId . $namespace . $offset));
				if (!empty($matches)) {
					list ($sKey, $aValues) = each ($matches);
					list (, $input, $params, ) = $matches[$sKey];
					$input = trim($input);
					if ( !empty($input) && (!empty($params)) ) {
						$aTags = array();
						$count = 0;
						/* try to find count */
						if (preg_match_all(BLOGS_XML_REGEX, $input, $aTags)) {
							if ( !empty($aTags) && (!empty($aTags[1])) ) {
								if (in_array('count', array_values($aTags[1]))) {
									foreach ($aTags[1] as $id => $key) {
										if ($key == 'count') {
											$count = intval($aTags[2][$id]);
											break;
										}
									}
								}
							}
						}
						if (!empty($params) && (array_key_exists('count', $params))) {
							$count = intval($params['count']);
						}
						if (empty($count)) {
							$count = int(self::$aBlogParams['count']['default']);
						}
						$offset = $count * $offset;
						/* set new value of offset */
						$params['offset'] = $offset;
						/* run parser */
						$result = self::parseTag( $input, $params, $wgParser );
					}
				}
			} else {
				wfDebugLog( __METHOD__, "Invalid parameters - $articleId, $namespace, $offset \n" );
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}
}
