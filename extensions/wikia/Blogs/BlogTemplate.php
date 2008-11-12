<?php

/* register as a parser function {{BLOGTPL_TAG}} and a tag <BLOGTPL_TAG> */ 
$wgExtensionFunctions[] = array("BlogTemplateClass", "setup");
$wgHooks['LanguageGetMagic'][] = "BlogTemplateClass::setMagicWord";

define ("BLOGS_TIMESTAMP", "20071101000000");
define ("BLOGS_XML_REGEX", "/\<(.*?)\>(.*?)\<\/(.*?)\>/si");
define ("GROUP_CONCAT", "64000");

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
				'date' 	=> 'page_touched',
				'title' => 'page_title',
				'author'=> 'rev_user_text'
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
			'max'		=> 10 
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
		 * default: 200
		 */
		'summarylength' 	=> array (
			'type' 		=> 'number',
			'default' 	=> '200', 
			'pattern' 	=> '/^\d*$/'
		),

		/*
		 * default=box, other option is "plain". box is the 300px width both in style of image shown.
		 * Plain is just the box content, no styling - so users can do what they want with it.
		 * style = box | plain
		 *
		 * type: 	number,
		 * default: 200
		 */
		'style' 	=> array (
			'type' 		=> 'list',
			'default' 	=> 'box',
			'pattern'	=> array( 'box', 'plain' )
		)
	);

	private static $aTables		= array( );
	private static $aWhere 		= array( );
	private static $aOptions	= array( );
	
	private static $dbr 		= null;
	
	public static function setup() {
		global $wgParser, $wgMessageCache;
		global $wgOut, $wgScriptPath, $wgMergeStyleVersionJS;
		wfProfileIn( __METHOD__ );
		// variant as a parser tag: <BLOGTPL_TAG>
		$wgParser->setHook( BLOGTPL_TAG, array( __CLASS__, "parseTag" ) );
		// set empty value 
		error_log ("************** setup ******************* \n", 3, "/tmp/moli.log");
		$rand = $wgMergeStyleVersionJS;
		$wgOut->addHTML( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgScriptPath}/extensions/wikia/Blogs/css/BlogTemplate.css\" />" );
		// language file 
		require_once( "BlogArticle.i18n.php" );
		foreach( $wgBlogArticleMessages as $sLang => $aMsgs ) {
			$wgMessageCache->addMessages( $aMsgs, $sLang );
		}
		wfProfileOut( __METHOD__ );
	}
	
	public static function setMagicWord( &$magicWords, $langCode ) {
		wfProfileIn( __METHOD__ );
		/* add the magic word */
		$magicWords[BLOGTPL_TAG] = array( 0, BLOGTPL_TAG );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function parseTag( $input, $params, &$parser ) {
		wfProfileIn( __METHOD__ );

		error_log ("parseTag: input : ".$input."\n", 3, "/tmp/moli.log");
		error_log ("parseTag: params : ".print_r($params, true)."\n", 3, "/tmp/moli.log");
		/* parse input parameters */
		$matches = array();
		$start = self::__getmicrotime();
		$aParams = self::__parseXMLTag($input);
		wfDebugLog( __METHOD__, "parse input parameters\n" );
		/* parse all and return result */
		$res = self::__parse($aParams, $params, $parser);
		$end = self::__getmicrotime();
		error_log("parse: ".($end - $start). " s", 3, "/tmp/moli.log");
		wfProfileOut( __METHOD__ );
		return $res;
	}
	
	public static function parseTagFunction(&$parser) {
		wfProfileIn( __METHOD__ );
		error_log ("parseTagFunction: parser : ".print_r($parser, true)."\n", 3, "/tmp/moli.log");
		wfProfileOut( __METHOD__ );
		return "parseTagFunction";
	}
	
	public static function getUserNameRecord($username) {
		wfProfileIn( __METHOD__ );
		$aResult = array();
		if (!empty($username)) {
			$oUser = User::newFromName($username); 
			if ( $oUser instanceof User ) {
				$sk = $oUser->getSkin();
				$aResult = array(
					"userpage" => $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),//"<a href=\"".$oUser->getUserPage()->getLocalURL()."\">{$oUser->getName()}</a>",
					"talkpage" => $sk->makeLinkObj($oUser->getTalkPage(), wfMsg('talkpagelinktext')),//"<a href=\"".$oUser->getTalkPage()->getLocalURL()."\">".wfMsg('talk')."</a>",
					"contribs" => $sk->userLink($oUser->getId(), wfMsg('contribslink')),//"<a href=\"".Skin::makeSpecialUrlSubpage('Contributions', $oUser->getName())."\">".wfMsg('contrib')."</a>",
				);
				error_log ("result: ".print_r($aResult, true)."\n", 3, "/tmp/moli.log");
			} 
		}
		wfProfileOut( __METHOD__ );
		return $aResult;
	}

	/*
	 * private method 
	 */
	
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
		/* default options */
		/* order */
		if ( !isset(self::$aOptions['order']) ) {
			self::__makeOrder('order', self::$aBlogParams['order']['pattern'][self::$aBlogParams['order']['default']]);
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
		/* style */
		if ( !isset(self::$aOptions['style']) ) {
			self::__makeListOption('style', self::$aBlogParams['style']['default']);
		}
		/* title */
		if ( !isset(self::$aOptions['title']) ) {
			self::__makeStringOption('title', wfMsg('blog_defaulttitle'));
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeOrder($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeOrder: ".$sParamName.",".$sParamValue."\n" );
		error_log ("__makeOrder: ".$sParamName.",".$sParamValue."\n", 3, "/tmp/moli.log");
    	if ( !empty($sParamValue) ) {
			if ( in_array( $sParamValue, array_keys( self::$aBlogParams[$sParamName]['pattern'] ) ) ) {
				if ( $sParamValue == 'author' ) {
					self::__addRevisionTable();
				}
				self::$aOptions['order'] = self::$aBlogParams[$sParamName]['pattern'][$sParamValue];
			}
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeListOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeListOption: ".$sParamName.",".$sParamValue."\n" );
		error_log ("__makeListOption: ".$sParamName.",".$sParamValue."\n", 3, "/tmp/moli.log");
		if ( in_array( $sParamValue, self::$aBlogParams[$sParamName]['pattern'] ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
    	wfProfileOut( __METHOD__ );
	}
	
	private static function __makeBoolOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeBoolOption: ".$sParamName.",".$sParamValue."\n" );
		error_log ("__makeBoolOption: ".$sParamName.",".$sParamValue."\n", 3, "/tmp/moli.log");
		if ( in_array($sParamValue, array("true", "false") ) ) {
			self::$aOptions[$sParamName] = $sParamValue;
		}
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeStringOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeStringOption: ".$sParamName.",".$sParamValue."\n" );
		error_log ("__makeStringOption: ".$sParamName.",".$sParamValue."\n", 3, "/tmp/moli.log");
		self::$aOptions[$sParamName] = $sParamValue;
    	wfProfileOut( __METHOD__ );
	}

	private static function __makeIntOption($sParamName, $sParamValue) {
    	wfProfileIn( __METHOD__ );
    	wfDebugLog( __METHOD__, "__makeIntOption: ".$sParamName.",".$sParamValue."\n" );
    	error_log ("__makeIntOption: ".$sParamName.",".$sParamValue."\n", 3, "/tmp/moli.log");
		$m = array(); if (preg_match(self::$aBlogParams[$sParamName]['pattern'], $sParamValue, $m) !== FALSE) {
			/* check max value of int param */
			if ( array_key_exists('max', self::$aOptions[$sParamName]) && ($sParamValue > self::$aOptions[$sParamName]['max']) ) {
				$sParamValue = $aOptions[$sParamName]['max'];
			}
			self::$aOptions[$sParamName] = $sParamValue;
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

	private static function __getCategories ($aParamValues) {
    	wfProfileIn( __METHOD__ );
		$aPages = array();
    	if ( !empty($aParamValues) ) {
			$sql = "select cl_to, GROUP_CONCAT(DISTINCT cl_from SEPARATOR ',') AS cl_page from categorylinks, page  ";
			$sql .= "where page_id = cl_from and cl_to in (".self::$dbr->makeList( $aParamValues ).") ";
			$sql .= "and page_namespace = " . NS_BLOG_ARTICLE . " and page_touched >= ".self::$dbr->addQuotes(BLOGS_TIMESTAMP)." group by cl_to";

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
	
	private static function __getRevisionText($iRev) {
		global $wgLang;
		wfProfileIn( __METHOD__ );
		$sResult = "";
		/* parse summary */
		if ( (!empty($iRev)) && (!empty(self::$aOptions['summary'])) ) {
			$oRev = Revision::newFromId($iRev);
			$iTruncate = (self::$aOptions['summarylength'] < 0) ? self::$aOptions['summarylength'] : (self::$aOptions['summarylength'] * -1);
			$sBlogText = $oRev->revText();
			/* Clear revision. */
			//$sBlogText = preg_replace('/^\s*=+\s*(.*?)\s*=+\s*$/', '$1', $sBlogText);
			/* Remove possible unfinished links */
			//$sBlogText = preg_replace( '/\[\[([^\]]*)\]?$/', '$1', $sBlogText );
			/* parse truncated text */			
			$localParser = new Parser();
			#$sResult = $localParser->stripSectionName($sBlogText);
			$parserOutput = $localParser->parse($sBlogText, Title::newFromId($oRow->page_id), ParserOptions::newFromUser($wgUser));

			$tmp = preg_replace('/<table[^>]*>.*<\/table>/siU', '', $parserOutput->getText());
			$tmp = preg_replace('/<div[^>]*>.*<\/div>/siU', '', $tmp);
			$tmp = preg_replace('/<style[^>]*>.*<\/style>/siU', '', $tmp);
			$tmp = preg_replace('/<script[^>]*>.*<\/script>/siU', '', $tmp);
			$tmp = preg_replace('/\n|\t/', ' ', $tmp);
			$tmp = strip_tags($tmp, '<p>');
		
			$matches = null;
			preg_match_all('/<p>(.*)<\/p>/siU', $tmp, $matches);
			error_log ("matches = ".print_r($matches, true)."\n", 3, "/tmp/moli.log");
			if (count($matches)) {
				$paragraphs = $matches[1];
				foreach ( $paragraphs as $paragraph ) {
					$paragraph = trim($paragraph);
					if (!empty($paragraph)) {
						$sResult .= $paragraph;
						if (strlen($sResult) >= self::$aOptions['summarylength']) {
							break;
						}
					}
				}
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
    	$aFields = array( 'distinct(page_id) as page_id', 'page_namespace', 'page_title', 'page_touched', 'unix_timestamp(page_touched) as timestamp', 'page_latest as rev_id' );
    	if ( in_array('revision', self::$aTables) ) {
    		$aFields[] = 'rev_user_text as username';
		}
		$res = self::$dbr->select(
			array_map(array(self::$dbr, 'tableName'), self::$aTables),  
			$aFields, 
			self::$aWhere, 
			__METHOD__, 
			self::__makeDBOrder() 
		);
		while ( $oRow = self::$dbr->fetchObject( $res ) ) {
			$aResult[$oRow->page_id] = array(
				"page" 			=> $oRow->page_id,
				"namespace" 	=> $oRow->page_namespace,
				"title" 		=> $oRow->page_title,
				"page_touched" 	=> $oRow->page_touched,
				"timestamp" 	=> $oRow->timestamp,
				"username"		=> (isset($oRow->username)) ? $oRow->username : "",
				"text"			=> self::__getRevisionText($oRow->rev_id),
				"revision"		=> $oRow->rev_id,
			);
		}
		self::$dbr->freeResult( $res );
    	wfProfileOut( __METHOD__ );
    	return $aResult;
	}
							
    private static function __parse( $aInput, $aParams, &$parser ) {
    	global $wgLang, $wgUser, $wgCityId, $wgParser;
    	
    	wfProfileIn( __METHOD__ );
    	$sResult = "";

		self::$aTables = self::$aWhere = self::$aOptions = array();
		self::$dbr = null;
		/* default settings for query */
    	self::__setDefault();
        try {
			/* database connect */
			self::$dbr = wfGetDB( DB_SLAVE, 'dpl' );
			/* parse parameters as XML tags */
			wfDebugLog( __METHOD__, "parse ".count($aInput)." parameters (XML tags)\n" );
			error_log ("aInput: ".print_r($aInput, true)."\n", 3, "/tmp/moli.log");
			foreach ($aInput as $sParamName => $aParamValues) {
				/* ignore empty lines */
				if ( empty($aParamValues) ) {
					wfDebugLog( __METHOD__, "ignore empty param: ".$sParamName." \n" );
					continue;
				}
				/* invalid name of parameter or empty name */
				if ( !in_array($sParamName, array_keys(self::$aBlogParams)) ) {
					throw new Exception( wfMsg('blog_invalidparam', $sParamName, implode(", ", array_keys(self::$aBlogParams))) );
				} elseif ( trim($sParamName) == '' ) {
					throw new Exception(wfMsg('blog_emptyparam'));						
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
							$aPages = self::__getCategories ($aParamValues);
							if ( !empty($aPages) ) {
								self::$aWhere[] = "page_id in (" . implode(",", $aPages) . ")";
							}
							error_log ( "category: " . implode(",", $aPages) . "\n", 3, "/tmp/moli.log" );
						}
						break;
					case 'author'		:
						if ( !empty($aParamValues) ) {
							$aParamValues = array_slice($aParamValues, 0, self::$aBlogParams[$sParamName]['count']);
							self::__addRevisionTable();
							self::$aWhere[] = "rev_user_text in (" . self::$dbr->makeList( $aParamValues ) . ")";
							error_log ( "author: " . print_r($aParamValues, true) . "\n", 3, "/tmp/moli.log" );
						}
						break;
					case 'order'		:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeOrder($sParamName, $sParamValue);
						}
						break;
					case 'ordertype'	:
					case 'style'		:
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
							self::__addRevisionTable();
							self::__makeBoolOption($sParamName, $sParamValue);
						}
						break;
					case 'title'	:
						if ( !empty($aParamValues) && is_array($aParamValues) ) {
							list ($sParamValue) = $aParamValues;
							self::__makeStringOption($sParamName, $sParamValue);
						}
						break;
				}
			}

			/* parse parameters */
			error_log ("aParams: ".print_r($aParams, true)."\n", 3, "/tmp/moli.log");
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
					case 'style'	:
						self::__makeListOption($sParamName, $sParamValue);
						break;
					case 'count'		:
					case 'offset'		:
					case 'summarylength':
						self::__makeIntOption($sParamName, $sParamValue);
						break;
					case 'timestamp'	:
					case 'summary'		:
						self::__addRevisionTable();
						self::__makeBoolOption($sParamName, $sParamValue);
						break;
					case 'title' 		:	
						self::__makeStringOption($sParamName, $sParamValue);
						break;
				}
			}

			/* build query */
			$aResult = self::__getResults();
			error_log ("aResult: " . print_r($aResult, true) . "\n", 3, "/tmp/moli.log");

			/* run template */
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"wgUser"		=> $wgUser,
				"cityId"		=> $wgCityId,
				"wgLang"		=> $wgLang,
				"aRows"			=> $aResult,
				"aOptions"		=> self::$aOptions,
				"wgParser"		=> $wgParser,
				"comments"		=> 0, // todo
			));

			#---
			$sResult = $oTmpl->execute("blog-page");

        }
		catch (Exception $e) {
			wfDebugLog( __METHOD__, "parse error: ".$e->getMessage()."\n" );
			error_log ("exception: ".$e->getMessage()."\n", 3, "/tmp/moli.log");
			return $e->getMessage();
		}

		error_log ("tables: " . print_r(self::$aTables, true) . "\n", 3, "/tmp/moli.log");
		error_log ("where: " . print_r(self::$aWhere, true) . "\n", 3, "/tmp/moli.log");
		error_log ("options: " . print_r(self::$aOptions, true) . "\n\n\n\n\n\n", 3, "/tmp/moli.log" );

    	wfProfileOut( __METHOD__ );
    	return $sResult;
	}

}
