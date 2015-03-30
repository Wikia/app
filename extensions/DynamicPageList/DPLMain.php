<?php
// this file is UTF-8 encoded and contains some special characters.
// Editing this file with an ASCII editor will potentially destroy it!

class DPLMain {

	/* ============================================================================================================
	/                                      MAIN FUNCTION
	/  ============================================================================================================
	*/

    // The real callback function for converting the input text to wiki text output
    public static function dynamicPageList( $input, $params, $parser, &$bReset, $calledInMode ) {

        // Output
        $output = '';

        error_reporting(E_ALL);

        global $wgUser, $wgLang, $wgContLang, $wgRequest;
        global $wgNonincludableNamespaces;

        //logger (display of debug messages)
        $logger = new DPLLogger();

        //check that we are not in an infinite transclusion loop
        if ( isset( $parser->mTemplatePath[$parser->mTitle->getPrefixedText()] ) ) {
            return $logger->escapeMsg(ExtDynamicPageList::WARN_TRANSCLUSIONLOOP, $parser->mTitle->getPrefixedText());
        }

        /**
         * Initialization
         */

		$dplStartTime= microtime(true);

         // Local parser created. See http://www.mediawiki.org/wiki/Extensions_FAQ#How_do_I_render_wikitext_in_my_extension.3F
        $localParser = new Parser();
        $pOptions = $parser->mOptions;

        // check if DPL shall only be executed from protected pages
        if (array_key_exists('RunFromProtectedPagesOnly',ExtDynamicPageList::$options) &&
        	ExtDynamicPageList::$options['RunFromProtectedPagesOnly']==true && !($parser->mTitle->isProtected('edit'))) {

			// Ideally we would like to allow using a DPL query if the query istelf is coded on a template page
			// which is protected. Then there would be no need for the article to be protected.
			// BUT: How can one find out from which wiki source an extension has been invoked???

	        return (ExtDynamicPageList::$options['RunFromProtectedPagesOnly']);
		}

        // get database access
        $dbr =& wfGetDB( DB_SLAVE );
        $sPageTable = $dbr->tableName( 'page' );
        $sCategorylinksTable = $dbr->tableName( 'categorylinks' );

        // Extension variables
        // Allowed namespaces for DPL: all namespaces except the first 2: Media (-2) and Special (-1), because we cannot use the DB for these to generate dynamic page lists.
        if( !is_array(ExtDynamicPageList::$allowedNamespaces) ) { // Initialization
            $aNs = $wgContLang->getNamespaces();
            ExtDynamicPageList::$allowedNamespaces = array_slice($aNs, 2, count($aNs), true);
            if( !is_array(ExtDynamicPageList::$options['namespace']) )
                ExtDynamicPageList::$options['namespace'] = ExtDynamicPageList::$allowedNamespaces;
            else // Make sure user namespace options are allowed.
                ExtDynamicPageList::$options['namespace'] = array_intersect(ExtDynamicPageList::$options['namespace'], ExtDynamicPageList::$allowedNamespaces);
            if( !isset(ExtDynamicPageList::$options['namespace']['default']) )
                ExtDynamicPageList::$options['namespace']['default'] = null;
            if( !is_array(ExtDynamicPageList::$options['notnamespace']) )
                ExtDynamicPageList::$options['notnamespace'] = ExtDynamicPageList::$allowedNamespaces;
            else
                ExtDynamicPageList::$options['notnamespace'] = array_intersect(ExtDynamicPageList::$options['notnamespace'], ExtDynamicPageList::$allowedNamespaces);
            if( !isset(ExtDynamicPageList::$options['notnamespace']['default']) )
                ExtDynamicPageList::$options['notnamespace']['default'] = null;
        }

		// check parameters which can be set via the URL

		self::getUrlArgs();

		if (strpos($input,'{%DPL_') >= 0) {
			for($i=1;$i<=5;$i++) {
				$input = self::resolveUrlArg($input,'DPL_arg'.$i);
			}
		}

		$_sOffset=$wgRequest->getVal('DPL_offset',ExtDynamicPageList::$options['offset']['default']);
        $iOffset  = ($_sOffset == '') ? 0: intval($_sOffset);

		// commandline parameters like %DPL_offset% are replaced
		$input = self::resolveUrlArg($input,'DPL_offset');
		$input = self::resolveUrlArg($input,'DPL_count');
		$input = self::resolveUrlArg($input,'DPL_fromTitle');
		$input = self::resolveUrlArg($input,'DPL_findTitle');
		$input = self::resolveUrlArg($input,'DPL_toTitle');

		// variables needed for scrolling
		$sCount       = '';
		$sCountScroll = '';
		$sTitleGE     = '';
		$sTitleLE     = '';
		$scrollDir    = '';


		$originalInput = $input;

		$bDPLRefresh = ($wgRequest->getVal('DPL_refresh','')=='yes');


        // Options


        $DPLCache = '';
        $DPLCachePath = '';
        $DPLCacheStorage = ExtDynamicPageList::$options['dplcachestorage']['default'];
        $iDPLCachePeriod = intval(ExtDynamicPageList::$options['dplcacheperiod']['default']);


        $sGoal = ExtDynamicPageList::$options['goal']['default'];

        $bSelectionCriteriaFound=false;
        $bConflictsWithOpenReferences=false;
        // array for LINK / TEMPLATE / CATGEORY / IMAGE  by RESET / ELIMINATE
        if (ExtDynamicPageList::$options['eliminate'] == 'all') $bReset = array ( false, false, false, false, true, true, true, true );
		else											        $bReset = array ( false, false, false, false, false, false, false, false );

        // we allow " like " or "="
        $sCategoryComparisonMode    = '=';
        $sNotCategoryComparisonMode = '=';
        $sTitleMatchMode            = ' LIKE ';
        $sNotTitleMatchMode         = ' LIKE ';


		// execAndExit
        $sExecAndExit= ExtDynamicPageList::$options['execandexit']['default'];

		// ordermethod, order, mode, userdateformat, allowcachedresults:
		// if we have to behave like Extension:Intersection we use different default values for some commands
		if (ExtDynamicPageList::$behavingLikeIntersection) {
			ExtDynamicPageList::$options['ordermethod'] = array('default' => 'categoryadd', 'categoryadd', 'lastedit','none');
			ExtDynamicPageList::$options['order'] = array('default' => 'descending', 'ascending', 'descending');
			ExtDynamicPageList::$options['mode'] = array('default' => 'unordered', 'none', 'ordered', 'unordered');
			ExtDynamicPageList::$options['userdateformat'] = array('default' => 'Y-m-d: ');
			ExtDynamicPageList::$options['allowcachedresults']['default'] = 'true';
		}
		else {
			ExtDynamicPageList::$options['ordermethod'] = array('default' => 'titlewithoutnamespace', 'counter', 'size', 'category', 'sortkey',
                                        'category,firstedit',  'category,lastedit', 'category,pagetouched', 'category,sortkey',
                                        'categoryadd', 'firstedit', 'lastedit', 'pagetouched', 'pagesel',
                                        'title', 'titlewithoutnamespace', 'user', 'user,firstedit', 'user,lastedit','none');
			ExtDynamicPageList::$options['order'] = array('default' => 'ascending', 'ascending', 'descending');
			ExtDynamicPageList::$options['mode'] = array('default' => 'unordered', 'category', 'inline', 'none', 'ordered', 'unordered', 'userformat');
			ExtDynamicPageList::$options['userdateformat'] = array('default' => 'Y-m-d H:i:s');
			ExtDynamicPageList::$options['allowcachedresults']['default'] = ExtDynamicPageList::$respectParserCache;
		}
		$aOrderMethods	 	= array(ExtDynamicPageList::$options['ordermethod']['default']);
        $sOrder 			= ExtDynamicPageList::$options['order']['default'];
		$sOrderCollation 	= ExtDynamicPageList::$options['ordercollation']['default'];
        $sPageListMode 		= ExtDynamicPageList::$options['mode']['default'];
        $sUserDateFormat 	= ExtDynamicPageList::$options['userdateformat']['default'];

        $sHListMode = ExtDynamicPageList::$options['headingmode']['default'];
        $bHeadingCount = self::argBoolean(ExtDynamicPageList::$options['headingcount']['default']);

        $bEscapeLinks = ExtDynamicPageList::$options['escapelinks']['default'];
        $bSkipThisPage= ExtDynamicPageList::$options['skipthispage']['default'];

        $sHiddenCategories = ExtDynamicPageList::$options['hiddencategories']['default'];

        $sMinorEdits = null;
        $acceptOpenReferences = self::argBoolean(ExtDynamicPageList::$options['openreferences']['default']);

        $sLastRevisionBefore = ExtDynamicPageList::$options['lastrevisionbefore']['default'];
        $sAllRevisionsBefore = ExtDynamicPageList::$options['allrevisionsbefore']['default'];
        $sFirstRevisionSince = ExtDynamicPageList::$options['firstrevisionsince']['default'];
        $sAllRevisionsSince  = ExtDynamicPageList::$options['allrevisionssince']['default'];

        $_sMinRevisions = ExtDynamicPageList::$options['minrevisions']['default'];
        $iMinRevisions  = ($_sMinRevisions == '') ? null: intval($_sMinRevisions);
        $_sMaxRevisions = ExtDynamicPageList::$options['maxrevisions']['default'];
        $iMaxRevisions  = ($_sMaxRevisions == '') ? null: intval($_sMaxRevisions);

        $sRedirects = ExtDynamicPageList::$options['redirects']['default'];
        $sQuality   = ExtDynamicPageList::$options['qualitypages']['default'];
        $sStable    = ExtDynamicPageList::$options['stablepages']['default'];

        $bSuppressErrors  = self::argBoolean(ExtDynamicPageList::$options['suppresserrors']['default']);
        $sResultsHeader   = ExtDynamicPageList::$options['resultsheader']['default'];
        $sResultsFooter   = ExtDynamicPageList::$options['resultsfooter']['default'];
        $sNoResultsHeader = ExtDynamicPageList::$options['noresultsheader']['default'];
        $sNoResultsFooter = ExtDynamicPageList::$options['noresultsfooter']['default'];
        $sOneResultHeader = ExtDynamicPageList::$options['oneresultheader']['default'];
        $sOneResultFooter = ExtDynamicPageList::$options['oneresultfooter']['default'];

        $aListSeparators = array();
        $sTable = ExtDynamicPageList::$options['table']['default'];
        $aTableRow = array();
        $iTableSortCol = ExtDynamicPageList::$options['tablesortcol']['default'];

        $sInlTxt = ExtDynamicPageList::$options['inlinetext']['default'];

        $bShowNamespace = self::argBoolean(ExtDynamicPageList::$options['shownamespace']['default']);
        $bShowCurID = self::argBoolean(ExtDynamicPageList::$options['showcurid']['default']);

        $bAddFirstCategoryDate = self::argBoolean(ExtDynamicPageList::$options['addfirstcategorydate']['default']);

        $bAddPageCounter = self::argBoolean(ExtDynamicPageList::$options['addpagecounter']['default']);

        $bAddPageSize = self::argBoolean(ExtDynamicPageList::$options['addpagesize']['default']);

        $bAddPageTouchedDate = self::argBoolean(ExtDynamicPageList::$options['addpagetoucheddate']['default']);

        $bAddEditDate = self::argBoolean(ExtDynamicPageList::$options['addeditdate']['default']);

        $bAddUser         = self::argBoolean(ExtDynamicPageList::$options['adduser']['default']);
        $bAddAuthor       = self::argBoolean(ExtDynamicPageList::$options['addauthor']['default']);
        $bAddContribution = self::argBoolean(ExtDynamicPageList::$options['addcontribution']['default']);
        $bAddLastEditor   = self::argBoolean(ExtDynamicPageList::$options['addlasteditor']['default']);

        $bAddExternalLink = self::argBoolean(ExtDynamicPageList::$options['addexternallink']['default']);

        $bAllowCachedResults = self::argBoolean(ExtDynamicPageList::$options['allowcachedresults']['default']);
        $bWarnCachedResults = false;

        $bAddCategories = self::argBoolean(ExtDynamicPageList::$options['addcategories']['default']);

        $bIncludeSubpages = self::argBoolean(ExtDynamicPageList::$options['includesubpages']['default']);
        $bIncludeTrim = self::argBoolean(ExtDynamicPageList::$options['includetrim']['default']);

        $bIgnoreCase = self::argBoolean(ExtDynamicPageList::$options['ignorecase']['default']);

        $_incpage = ExtDynamicPageList::$options['includepage']['default'];
        $bIncPage =  is_string($_incpage) && $_incpage !== '';


        $aSecLabels = array();
        if($bIncPage) $aSecLabels = explode(',', $_incpage);
        $aSecLabelsMatch 	= array();
        $aSecLabelsNotMatch = array();
        $bIncParsed = false;  // default is to match raw parameters

        $aSecSeparators      = explode(',', ExtDynamicPageList::$options['secseparators']['default']);
        $aMultiSecSeparators = explode(',', ExtDynamicPageList::$options['multisecseparators']['default']);
        $iDominantSection = ExtDynamicPageList::$options['dominantsection']['default'];

        $_sColumns = ExtDynamicPageList::$options['columns']['default'];
        $iColumns  = ($_sColumns == '') ? 1: intval($_sColumns);

        $_sRows    = ExtDynamicPageList::$options['rows']['default'];
        $iRows     = ($_sRows == '') ? 1: intval($_sRows);

        $_sRowSize = ExtDynamicPageList::$options['rowsize']['default'];
        $iRowSize  = ($_sRowSize == '') ? 0: intval($_sRowSize);

        $sRowColFormat= ExtDynamicPageList::$options['rowcolformat']['default'];

        $_sRandomSeed = ExtDynamicPageList::$options['randomseed']['default'];
        $iRandomSeed = ($_sRandomSeed == '') ? null: intval($_sRandomSeed);

        $_sRandomCount = ExtDynamicPageList::$options['randomcount']['default'];
        $iRandomCount = ($_sRandomCount == '') ? null: intval($_sRandomCount);

        $sDistinctResultSet = 'true';

        $sListHtmlAttr = ExtDynamicPageList::$options['listattr']['default'];
        $sItemHtmlAttr = ExtDynamicPageList::$options['itemattr']['default'];

        $sHListHtmlAttr = ExtDynamicPageList::$options['hlistattr']['default'];
        $sHItemHtmlAttr = ExtDynamicPageList::$options['hitemattr']['default'];

        $_sTitleMaxLen = ExtDynamicPageList::$options['titlemaxlength']['default'];
        $iTitleMaxLen = ($_sTitleMaxLen == '') ? null: intval($_sTitleMaxLen);

        $aReplaceInTitle[0] = '';
        $aReplaceInTitle[1] = '';

        $_sCatMinMax  = ExtDynamicPageList::$options['categoriesminmax']['default'];
        $aCatMinMax   = ($_sCatMinMax == '') ? null: explode(',',$_sCatMinMax);

        $_sIncludeMaxLen = ExtDynamicPageList::$options['includemaxlength']['default'];
        $iIncludeMaxLen = ($_sIncludeMaxLen == '') ? null: intval($_sIncludeMaxLen);

        $bScroll = self::argBoolean(ExtDynamicPageList::$options['scroll']['default']);

        $aLinksTo       = array();
        $aNotLinksTo    = array();
        $aLinksFrom     = array();
        $aNotLinksFrom  = array();

        $aLinksToExternal = array();

        $aImageUsed 	= array();
        $aImageContainer= array();

        $aUses       = array();
        $aNotUses    = array();
        $aUsedBy     = array();

        $sCreatedBy = '';
        $sNotCreatedBy = '';
        $sModifiedBy = '';
        $sNotModifiedBy = '';
        $sLastModifiedBy = '';
        $sNotLastModifiedBy = '';

        $aTitleMatch = array();
        $aNotTitleMatch = array();
        $sTitleIs = '';

        $aIncludeCategories = array(); // $aIncludeCategories is a 2-dimensional array: Memberarrays are linked using 'AND'
        $aExcludeCategories = array();

        $aCatHeadings    = array();
        $aCatNotHeadings = array();

        $aNamespaces = array();

        $aExcludeNamespaces  = array();

        $sArticleCategory = null;

        $sUpdateRules = ExtDynamicPageList::$options['updaterules']['default'];
        $sDeleteRules = ExtDynamicPageList::$options['deleterules']['default'];

		$bOrderSuitSymbols = false;

    // ###### PARSE PARAMETERS ######

        // we replace double angle brackets by < > ; thus we avoid premature tag expansion in the input
        $input = str_replace('»','>',$input);
        $input = str_replace('«','<',$input);

        // use the ¦ as a general alias for |
        $input = str_replace('¦','|',$input); // the symbol is utf8-escaped

        // the combination '²{' and '}²'will be translated to double curly braces; this allows postponed template execution
        // which is crucial for DPL queries which call other DPL queries
        $input = str_replace('²{','{{',$input);
        $input = str_replace('}²','}}',$input);

        $aParams = explode("\n", $input);
        $bIncludeUncat = false; // to check if pseudo-category of Uncategorized pages is included

        // version 0.9:
        // we do not parse parameters recursively when reading them in.
        // we rather leave them unchanged, produce the complete output and then finally
        // parse the result recursively. This allows to build complex structures in the output
        // which are only understood by the parser if seen as a whole

        foreach($aParams as $iParam => $sParam) {
            $aParam = explode('=', $sParam, 2);
            if( count( $aParam ) < 2 ) {
                if (trim($aParam[0])!='') $output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $aParam[0]. " [missing '=']", self::validParametersList());
                continue;
            }
            $sType = trim($aParam[0]);
            $sArg = trim($aParam[1]);

            if( $sType=='') {
                $output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, '[empty string]', self::validParametersList());
                continue;
            }

            // ignore comment lines
            if ($sType[0] == '#') continue;

            // ignore parameter settings without argument (except namespace and category)
            if ($sArg=='') {
                if ($sType!='namespace' && $sType!='notnamespace' && $sType != 'category' && array_key_exists($sType,ExtDynamicPageList::$options)) continue;
            }


			// for each level of functionalRichness we have a separate block of options
			// the first block is always active ($functionalRichness>=0)


			//------------------------------------------------------------------------------------------- level 0

			$validOptionFound = true;

            switch ($sType) {

                /**
                 * FILTER PARAMETERS
                 */
                case 'category':
                    // Init array of categories to include
                    $aCategories = array();
                    $bHeading = false;
                    $bNotHeading = false;
                    if($sArg != '' && $sArg[0] == '+') {// categories are headings
                        $bHeading = true;
                        $sArg[0] = '';
                    }
                    if($sArg != '' && $sArg[0] == '-') {// categories are NOT headings
                        $bNotHeading = true;
                        $sArg[0] = '';
                    }
                    $op='OR';
					// we expand html entities because they contain an '& 'which would be interpreted as an AND condition
					$sArg=html_entity_decode($sArg,ENT_QUOTES);
					if (strpos($sArg,'&')!==false) {
						$aParams = explode('&', $sArg);
	                    $op = 'AND';
                    } else {
						$aParams = explode('|', $sArg);
                    }
                    foreach($aParams as $sParam) {
                        $sParam=trim($sParam);
                        if($sParam == '') { // ignore empty line
                        } else if($sParam == '_none_') { // include uncategorized pages (special value: empty string)
							$aParams[$sParam]='';
                            $bIncludeUncat = true;
                            $aCategories[] = '';
                        } else {
                            if ($sParam[0]=='*' && strlen($sParam)>=2) {
								if ($sParam[1]=='*') 	$sParamList = explode('|',self::getSubcategories(substr($sParam,2),$sPageTable,2));
                                else					$sParamList = explode('|',self::getSubcategories(substr($sParam,1),$sPageTable,1));
                                foreach ($sParamList as $sPar) {
                                    // $title = Title::newFromText($localParser->transformMsg($sPar, $pOptions));
                                    $title = Title::newFromText($sPar);
                                    if( !is_null($title) )	$aCategories[] = $title->getDbKey();
                                }
                            }
                            else {
                                // $title = Title::newFromText($localParser->transformMsg($sParam, $pOptions));
                                $title = Title::newFromText($sParam);
                                if( !is_null($title) )	$aCategories[] = $title->getDbKey();
                            }
                        }
                    }
                    if( !empty($aCategories) ) {
                        if ($op=='OR') {
	                        $aIncludeCategories[] = $aCategories;
                    	}
                    	else {
	                    	foreach($aCategories as $aParams) {
		                    	$sParam=array();
		                    	$sParam[] = $aParams;
								$aIncludeCategories[] = $sParam;
							}
						}
                        if($bHeading)		$aCatHeadings 	 = array_unique($aCatHeadings + $aCategories);
                        if($bNotHeading)	$aCatNotHeadings = array_unique($aCatNotHeadings + $aCategories);
                        $bConflictsWithOpenReferences=true;
                    }
                    break;
				case 'hiddencategories':
                    if( in_array($sArg, ExtDynamicPageList::$options['hiddencategories']) ) {
						$sHiddenCategories = $sArg;
                    }
                    else
                        $output .= $logger->msgWrongParam('hiddencategories', $sArg);
                    break;
                case 'notcategory':
                    //$title = Title::newFromText($localParser->transformMsg($sArg, $pOptions));
                    $title = Title::newFromText($sArg);
                    if( !is_null($title) ) {
                        $aExcludeCategories[] = $title->getDbKey();
                        $bConflictsWithOpenReferences=true;
                    }
                    break;

                case 'namespace':
                    $aParams = explode('|', $sArg);
                    foreach($aParams as $sParam) {
                        $sParam=trim($sParam);
                        //$sNs = $localParser->transformMsg($sParam, $pOptions);
                        $sNs = $sParam;
                        if        ( in_array($sNs, ExtDynamicPageList::$options['namespace']) ) {
	                        $aNamespaces[] = $wgContLang->getNsIndex($sNs);
							$bSelectionCriteriaFound=true;
						} else if ( array_key_exists($sNs, array_keys(ExtDynamicPageList::$options['namespace'])) ) {
	                        $aNamespaces[] = $sNs;
							$bSelectionCriteriaFound=true;
						} else {
							return $logger->msgWrongParam('namespace', $sParam);
						}
                    }
                    break;

                case 'redirects':
                    if( in_array($sArg, ExtDynamicPageList::$options['redirects']) ) {
                        $sRedirects = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('redirects', $sArg);
                    break;

				case 'stablepages':
                    if( in_array($sArg, ExtDynamicPageList::$options['stablepages']) ) {
						$sStable = $sArg;
						$bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('stablepages', $sArg);
                    break;

				case 'qualitypages':
                    if( in_array($sArg, ExtDynamicPageList::$options['qualitypages']) ) {
						$sQuality = $sArg;
						$bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('qualitypages', $sArg);
                    break;

                case 'count':
					// setting by URL overwrites other settings, hence we ignore the command
					if ($sCount=='') $sCount=trim($sArg);
                    break;

                /**
                 * CONTENT PARAMETERS
                 */

                case 'addfirstcategorydate':
                    if( in_array($sArg, ExtDynamicPageList::$options['addfirstcategorydate'])) {
                        $bAddFirstCategoryDate = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addfirstcategorydate', $sArg);
                    break;

                /**
                 * ORDER PARAMETERS
                 */
                case 'ordermethod':
                    $methods = explode(',', $sArg);
                    $breakaway = false;
                    foreach ( $methods as $method ) {
                        if( !in_array($method, ExtDynamicPageList::$options['ordermethod']) ) {
                            $output .= $logger->msgWrongParam('ordermethod', $method);
                            $breakaway = true;
                        }
                    }
                    if ( !$breakaway ) {
                        $aOrderMethods = $methods;
                        if ($methods[0]!='none') $bConflictsWithOpenReferences=true;
                    }
                    break;

                case 'order':
                    if( in_array($sArg, ExtDynamicPageList::$options['order']) )
                        $sOrder = $sArg;
                    else
                        $output .= $logger->msgWrongParam('order', $sArg);
                    break;

                /**
                 * FORMAT/HTML PARAMETERS
                 * @todo allow addpagetoucheddate, addeditdate, adduser, addcategories to have effect with 'mode=category'
                 */

                case 'mode':
                    if( in_array($sArg, ExtDynamicPageList::$options['mode']) )
                        //'none' mode is implemented as a specific submode of 'inline' with <br/> as inline text
                        if($sArg == 'none') {
                            $sPageListMode = 'inline';
                            $sInlTxt = '<br/>';
                        } else if ($sArg == 'userformat') {
                            // userformat resets inline text to empty string
                            $sInlTxt = '';
                            $sPageListMode = $sArg;
                        } else {
                            $sPageListMode = $sArg;
                        }
                    else
                        $output .= $logger->msgWrongParam('mode', $sArg);
                    break;

                case 'showcurid':
                    if( in_array($sArg, ExtDynamicPageList::$options['showcurid'])) {
                        $bShowCurID = self::argBoolean($sArg);
						if ($bShowCurID==true) $bConflictsWithOpenReferences=true;
					}
                    else
                        $output .= $logger->msgWrongParam('showcurid', $sArg);
                    break;

                case 'shownamespace':
                    if( in_array($sArg, ExtDynamicPageList::$options['shownamespace']))
                        $bShowNamespace = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('shownamespace', $sArg);
                    break;

                case 'suppresserrors':
                   if( in_array($sArg, ExtDynamicPageList::$options['suppresserrors'])) {
                       $bSuppressErrors = self::argBoolean($sArg);
                       if( $bSuppressErrors )  $sNoResultsHeader = ' ';
                   }
                   else {
                       $output .= $logger->msgWrongParam('suppresserrors', $sArg);
                   }
                   break;

                /**
                 * OTHER PARAMETER
                 */
                case 'execandexit':
                    // we offer a possibility to execute a DPL command without querying the database
					// this is useful if you want to catch the command line parameters DPL_arg1,... etc
					// in this case we prevent the parser cache from being disabled by later statements
					$sExecAndExit = $sArg;
                    break;


                /**
                 * UNKNOWN PARAMETER
                 */
                default:
					$validOptionFound = false;
            }

			if ($validOptionFound) continue;

			// the next blocks are only available if $functionalRichness > 0
            if (ExtDynamicPageList::$functionalRichness <= 0) {
				$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $sType, self::validParametersList());
				continue;
			}

			//------------------------------------------------------------------------------------------- level 1

			$validOptionFound = true;
            switch ($sType) {

                /**
                 * FILTER PARAMETERS
                 */
                case 'notnamespace':
                    $sArg=trim($sArg);
                    // $sNs = $localParser->transformMsg($sArg, $pOptions);
                    $sNs = $sArg;
                    if( !in_array($sNs, ExtDynamicPageList::$options['notnamespace']) )
                        return $logger->msgWrongParam('notnamespace', $sArg);
                    $aExcludeNamespaces[] = $wgContLang->getNsIndex($sNs);
                    $bSelectionCriteriaFound=true;
                    break;

                case 'offset':
                    //ensure that $iOffset is a number
                    if( preg_match(ExtDynamicPageList::$options['offset']['pattern'], $sArg) )
                        $iOffset = ($sArg == '') ? 0: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('offset', $sArg);
                    break;

                case 'randomseed':
                    //ensure that $iRandomSeed is a number;
                        if( preg_match(ExtDynamicPageList::$options['randomseed']['pattern'], $sArg) )
                        $iRandomSeed = ($sArg == '') ? null: intval($sArg);
                        else // wrong value
                        $output .= $logger->msgWrongParam('randomseed', $sArg);
                    break;

                case 'randomcount':
                    //ensure that $iRandomCount is a number;
                    if( preg_match(ExtDynamicPageList::$options['randomcount']['pattern'], $sArg) )
                        $iRandomCount = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('randomcount', $sArg);
                    break;

                case 'distinct':
                    if( in_array($sArg, ExtDynamicPageList::$options['distinct'])) {
                        if ($sArg=='strict') 			$sDistinctResultSet = 'strict';
                        else if (self::argBoolean($sArg)) 	$sDistinctResultSet = 'true';
                        else 							$sDistinctResultSet = 'false';
                    }
                    else
                        $output .= $logger->msgWrongParam('distinct', $sArg);
                    break;

				/*
                 * ORDER PARAMETERS
                 */

                case 'ordercollation':
                    if($sArg=='bridge') $bOrderSuitSymbols = true;
                    else if($sArg!='') $sOrderCollation= "COLLATE $sArg";
                    break;

                /**
                 * FORMAT/HTML PARAMETERS
                 * @todo allow addpagetoucheddate, addeditdate, adduser, addcategories to have effect with 'mode=category'
                 */

                case 'columns':
                    //ensure that $iColumns is a number
                    if( preg_match(ExtDynamicPageList::$options['columns']['pattern'], $sArg) )
                        $iColumns = ($sArg == '') ? 1: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('columns', $sArg);
                    break;

                case 'rows':
                    //ensure that $iRows is a number
                    if( preg_match(ExtDynamicPageList::$options['rows']['pattern'], $sArg) )
                        $iRows = ($sArg == '') ? 1: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('rows', $sArg);
                    break;

                case 'rowsize':
                    //ensure that $iRowSize is a number
                    if( preg_match(ExtDynamicPageList::$options['rowsize']['pattern'], $sArg) )
                        $iRowSize = ($sArg == '') ? 0: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('rowsize', $sArg);
                    break;

                case 'rowcolformat':
                    $sRowColFormat= self::killHtmlTags($sArg);
                    break;

                case 'userdateformat':
                    $sUserDateFormat = self::killHtmlTags($sArg);
                    break;

                case 'escapelinks':
                    if( in_array($sArg, ExtDynamicPageList::$options['escapelinks']))
                        $bEscapeLinks = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('escapelinks', $sArg);
                    break;

                case 'inlinetext':
                    $sInlTxt = self::killHtmlTags($sArg);
                    break;

                case 'format':
                case 'listseparators':
                    // parsing of wikitext will happen at the end of the output phase
                    // we replace '\n' in the input by linefeed because wiki syntax depends on linefeeds
                    $sArg = self::killHtmlTags($sArg);
					$sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aListSeparators = explode (',', $sArg, 4);
                    // mode=userformat will be automatically assumed
                    $sPageListMode='userformat';
                    $sInlTxt = '';
                    break;

                case 'title':
                    // we replace blanks by underscores to meet the internal representation
                    // of page names in the database
                    $title = Title::newFromText($sArg);
                    if ($title) {
                        $sNamespace= $title->getNamespace();
                        $sTitleIs = str_replace(' ','_',$title->getText());
                        $aNamespaces[0] = $sNamespace;
                        $sPageListMode='userformat';
                        $aOrderMethods = explode(',','');
                        $bSelectionCriteriaFound=true;
                        $bConflictsWithOpenReferences=true;
                        $bAllowCachedResults = true;
                    }
                    break;

                case 'title>':
                    // we replace blanks by underscores to meet the internal representation
                    // of page names in the database
                    // $sTitleGE = str_replace(' ','_',$localParser->transformMsg($sArg, $pOptions));
                    $sTitleGE = str_replace(' ','_',$sArg);
                    $bSelectionCriteriaFound=true;
                    break;

                case 'title<':
                    // we replace blanks by underscores to meet the internal representation
                    // of page names in the database
                    // $sTitleLE = str_replace(' ','_',$localParser->transformMsg($sArg, $pOptions));
                    $sTitleLE = str_replace(' ','_',$sArg);
                    $bSelectionCriteriaFound=true;
                    break;

                case 'scroll':
                    if( in_array($sArg, ExtDynamicPageList::$options['scroll'])) {
                        $bScroll = self::argBoolean($sArg);
						// if scrolling is active we adjust the values for certain other parameters
						// based on URL arguments
						if ($bScroll) {
							$sTitleGE  = $wgRequest->getVal('DPL_fromTitle','');
							if (strlen($sTitleGE)>0) $sTitleGE[0] = strtoupper($sTitleGE[0]);
							// findTitle has priority over fromTitle
							$findTitle = $wgRequest->getVal('DPL_findTitle','');
							if (strlen($findTitle)>0) $findTitle[0] = strtoupper($findTitle[0]);
							if ($findTitle !='') $sTitleGE = '=_'.$findTitle;
							$sTitleLE  = $wgRequest->getVal('DPL_toTitle','');
							if (strlen($sTitleLE)>0) $sTitleLE[0] = strtoupper($sTitleLE[0]);
							$sTitleGE = str_replace(' ','_',$sTitleGE);
							$sTitleLE = str_replace(' ','_',$sTitleLE);
							$scrollDir = $wgRequest->getVal('DPL_scrollDir','');
							// also set count limit from URL if not otherwise set
							$sCountScroll = $wgRequest->getVal('DPL_count','');
						}
                    }
                    else
                        $output .= $logger->msgWrongParam('scroll', $sArg);
                    break;

                case 'titlemaxlength':
                    //processed like 'count' param
                    if( preg_match(ExtDynamicPageList::$options['titlemaxlength']['pattern'], $sArg) )
                        $iTitleMaxLen = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('titlemaxlength', $sArg);
                    break;

                case 'replaceintitle':
                    // we offer a possibility to replace some part of the title
                    $aReplaceInTitle = explode (',',$sArg,2);
					if (isset($aReplaceInTitle[1])) {
						$aReplaceInTitle[1] = self::killHtmlTags( $aReplaceInTitle[1] );
					}
                    break;

                case 'resultsheader':
                    $sResultsHeader = self::killHtmlTags( $sArg );
                    break;
                case 'resultsfooter':
                    $sResultsFooter = self::killHtmlTags( $sArg );
                    break;
                case 'noresultsheader':
                    $sNoResultsHeader = self::killHtmlTags( $sArg );
                    break;
                case 'noresultsfooter':
                    $sNoResultsFooter = self::killHtmlTags( $sArg );
                    break;
                case 'oneresultheader':
                    $sOneResultHeader = self::killHtmlTags( $sArg );
                    break;
                case 'oneresultfooter':
                    $sOneResultFooter = self::killHtmlTags( $sArg );
                    break;

                /**
                 * DEBUG, RESET and CACHE PARAMETER
                 */


                case 'debug':
                    if( in_array($sArg, ExtDynamicPageList::$options['debug']) ) {
                        if($iParam > 1)
                            $output .= $logger->escapeMsg(ExtDynamicPageList::WARN_DEBUGPARAMNOTFIRST, $sArg );
                        $logger->iDebugLevel = intval($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('debug', $sArg);
                    break;

                /**
                 * UNKNOWN PARAMETER
                 */
                default:
					$validOptionFound = false;
            }

			if ($validOptionFound) continue;

            if (ExtDynamicPageList::$functionalRichness <= 1) {
				$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $sType, self::validParametersList());
				continue;
			}


			//------------------------------------------------------------------------------------------- level 2

			$validOptionFound = true;
            switch ($sType) {

                /**
                 * FILTER PARAMETERS
                 */

                case 'linksto':
					$problems = self::getPageNameList('linksto', $sArg, $aLinksTo, $bSelectionCriteriaFound, $logger, true);
					if ($problems!='') return $problems;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'notlinksto':
					$problems = self::getPageNameList('notlinksto', $sArg, $aNotLinksTo, $bSelectionCriteriaFound, $logger, true);
					if ($problems!='') return $problems;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'linksfrom':
					$problems = self::getPageNameList('linksfrom', $sArg, $aLinksFrom, $bSelectionCriteriaFound, $logger, true);
					if ($problems!='') return $problems;
                    // $bConflictsWithOpenReferences=true;
                    break;

                case 'notlinksfrom':
					$problems = self::getPageNameList('notlinksfrom', $sArg, $aNotLinksFrom, $bSelectionCriteriaFound, $logger, true);
					if ($problems!='') return $problems;
                    break;

                case 'linkstoexternal':
					$problems = self::getPageNameList('linkstoexternal', $sArg, $aLinksToExternal, $bSelectionCriteriaFound, $logger, false);
					if ($problems!='') return $problems;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'imageused':
                    $pages = explode('|', trim($sArg));
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
                        if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('imageused', $sArg);
                        $aImageUsed[$n++] = $theTitle;
                        $bSelectionCriteriaFound=true;
                    }
                    if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('imageused', $sArg);
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'imagecontainer':
                    $pages = explode('|', trim($sArg));
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
                        if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('imagecontainer', $sArg);
                        $aImageContainer[$n++] = $theTitle;
                        $bSelectionCriteriaFound=true;
                    }
                    if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('imagecontainer', $sArg);
                    break;

                case 'uses':
                    $pages = explode('|', $sArg);
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
                        if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('uses', $sArg);
                        $aUses[$n++] = $theTitle;
                        $bSelectionCriteriaFound=true;
                    }
                    if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('uses', $sArg);
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'notuses':
                    $pages = explode('|', $sArg);
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
                        if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('notuses', $sArg);
                        $aNotUses[$n++] = $theTitle;
                        $bSelectionCriteriaFound=true;
                    }
                    if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('notuses', $sArg);
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'usedby':
                    $pages = explode('|', $sArg);
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
                        if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('usedby', $sArg);
                        $aUsedBy[$n++] = $theTitle;
                        $bSelectionCriteriaFound=true;
                    }
                    if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('usedby', $sArg);
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'createdby':
                    $sCreatedBy = $sArg;
                    if ($sCreatedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'notcreatedby':
                    $sNotCreatedBy = $sArg;
                    if ($sNotCreatedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'modifiedby':
                    $sModifiedBy = $sArg;
                    if ($sModifiedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'notmodifiedby':
                    $sNotModifiedBy = $sArg;
                    if ($sNotModifiedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'lastmodifiedby':
                    $sLastModifiedBy = $sArg;
                    if ($sLastModifiedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'notlastmodifiedby':
                    $sNotLastModifiedBy = $sArg;
                    if ($sNotLastModifiedBy != '') $bSelectionCriteriaFound=true;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'titlematch':
                    // we replace blanks by underscores to meet the internal representation
                    // of page names in the database
                    // $aTitleMatch = explode('|', str_replace(' ','\_',$localParser->transformMsg($sArg, $pOptions)));
                    $aTitleMatch = explode('|', str_replace(' ','\_',$sArg));
                    $bSelectionCriteriaFound=true;
                    break;

                case 'minoredits':
                    if( in_array($sArg, ExtDynamicPageList::$options['minoredits']) ) {
                        $sMinorEdits = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else { //wrong param val, using default
                        $sMinorEdits = ExtDynamicPageList::$options['minoredits']['default'];
                        $output .= $logger->msgWrongParam('minoredits', $sArg);
                    }
                    break;

                case 'includesubpages':
                    if( in_array($sArg, ExtDynamicPageList::$options['includesubpages'])) {
                        $bIncludeSubpages = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('includesubpages', $sArg);
                    break;

                case 'ignorecase':
                    if( in_array($sArg, ExtDynamicPageList::$options['ignorecase'])) {
                        $bIgnoreCase = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('ignorecase', $sArg);
                    break;

                case 'categoriesminmax':
                    if( preg_match(ExtDynamicPageList::$options['categoriesminmax']['pattern'], $sArg) )
                        $aCatMinMax = ($sArg == '') ? null: explode(',',$sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('categoriesminmax', $sArg);
                    break;

                case 'skipthispage':
                    if( in_array($sArg, ExtDynamicPageList::$options['skipthispage']))
                        $bSkipThisPage = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('skipthispage', $sArg);
                    break;

                /**
                 * CONTENT PARAMETERS
                 */
                case 'addcategories':
                    if( in_array($sArg, ExtDynamicPageList::$options['addcategories'])) {
                        $bAddCategories = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addcategories', $sArg);
                    break;

                case 'addeditdate':
                    if( in_array($sArg, ExtDynamicPageList::$options['addeditdate'])) {
                        $bAddEditDate = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addeditdate', $sArg);
                    break;

                case 'addexternallink':
                    if( in_array($sArg, ExtDynamicPageList::$options['addexternallink'])) {
                        $bAddExternalLink = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addexternallink', $sArg);
                    break;

                case 'addpagecounter':
                    if( in_array($sArg, ExtDynamicPageList::$options['addpagecounter'])) {
                        $bAddPageCounter = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addpagecounter', $sArg);
                    break;

                case 'addpagesize':
                    if( in_array($sArg, ExtDynamicPageList::$options['addpagesize'])) {
                        $bAddPageSize = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addpagesize', $sArg);
                    break;

                case 'addpagetoucheddate':
                    if( in_array($sArg, ExtDynamicPageList::$options['addpagetoucheddate'])) {
                        $bAddPageTouchedDate = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addpagetoucheddate', $sArg);
                    break;

                case 'include':
                case 'includepage':
                    $bIncPage =  $sArg !== '';
                    if($bIncPage)
                        $aSecLabels= explode(',', $sArg);
                    break;

                case 'includematchparsed':
                	$bIncParsed=true;
                case 'includematch':
                    $aSecLabelsMatch= explode(',', $sArg);
                    break;

                case 'includenotmatchparsed':
                	$bIncParsed=true;
                case 'includenotmatch':
                    $aSecLabelsNotMatch= explode(',', $sArg);
                    break;

                case 'includetrim':
                    if( in_array($sArg, ExtDynamicPageList::$options['includetrim'])) {
                        $bIncludeTrim = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('includetrim', $sArg);
                    break;

                case 'adduser':
                    if( in_array($sArg, ExtDynamicPageList::$options['adduser'])) {
                        $bAddUser = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('adduser', $sArg);
                    break;

                case 'addauthor':
                    if( in_array($sArg, ExtDynamicPageList::$options['addauthor'])) {
                        $bAddAuthor = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addauthor', $sArg);
                    break;

                case 'addcontribution':
                    if( in_array($sArg, ExtDynamicPageList::$options['addcontribution'])) {
                        $bAddContribution = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addcontribution', $sArg);
                    break;

                case 'addlasteditor':
                    if( in_array($sArg, ExtDynamicPageList::$options['addlasteditor'])) {
                        $bAddLastEditor = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addlasteditor', $sArg);
                    break;

                /**
                 * FORMAT/HTML PARAMETERS
                 * @todo allow addpagetoucheddate, addeditdate, adduser, addcategories to have effect with 'mode=category'
                 */

                case 'headingmode':
                    if( in_array($sArg, ExtDynamicPageList::$options['headingmode']) ) {
                        $sHListMode = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('headingmode', $sArg);
                    break;

                case 'headingcount':
                    if( in_array($sArg, ExtDynamicPageList::$options['headingcount'])) {
                        $bHeadingCount = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('headingcount', $sArg);
                    break;

                case 'secseparators':
                    // we replace '\n' by newline to support wiki syntax within the section separators
                    $sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aSecSeparators = explode (',',$sArg);
                    break;

                case 'multisecseparators':
                    // we replace '\n' by newline to support wiki syntax within the section separators
                    $sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aMultiSecSeparators = explode (',',$sArg);
                    break;

                case 'table':
                    $sArg   = str_replace( '\n', "\n", $sArg );
                    $sTable = str_replace( "¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    break;

                case 'tablerow':
                    $sArg   = str_replace( '\n', "\n", $sArg );
                    $sArg   = str_replace( "¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    if (trim($sArg)=='') 	$aTableRow = array();
                    else					$aTableRow = explode (',',$sArg);
                    break;

                case 'tablesortcol':
                    if( preg_match(ExtDynamicPageList::$options['tablesortcol']['pattern'], $sArg) )
                        $iTableSortCol = ($sArg == '') ? 0 : intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('tablesortcol', $sArg);
                    break;

                case 'dominantsection':
                    if( preg_match(ExtDynamicPageList::$options['dominantsection']['pattern'], $sArg) )
                        $iDominantSection = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('dominantsection', $sArg);
                    break;

				case 'includemaxlength':
                    //processed like 'count' param
                    if( preg_match(ExtDynamicPageList::$options['includemaxlength']['pattern'], $sArg) )
                        $iIncludeMaxLen = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('includemaxlength', $sArg);
                    break;

                case 'listattr':
                    $sListHtmlAttr = $sArg;
                    break;
                case 'itemattr':
                    $sItemHtmlAttr = $sArg;
                    break;
                case 'hlistattr':
                    $sHListHtmlAttr = $sArg;
                    break;
                case 'hitemattr':
                    $sHItemHtmlAttr = $sArg;
                    break;

                /**
                 * DEBUG, RESET and CACHE PARAMETER
                 */

				case 'allowcachedresults':
					// if execAndExit was previously set (i.e. if it is not empty) we will ignore all cache settings
					// which are placed AFTER the execandexit statement
					// thus we make sure that the cache will only become invalid if the query is really executed
					/** Wikia change begin - disable allowcachedresults parameter (CE-1066) **/
					// if ($sExecAndExit=='') {
					// 	if( in_array($sArg, ExtDynamicPageList::$options['allowcachedresults'])) {
					// 		$bAllowCachedResults = self::argBoolean($sArg);
					// 		if ($sArg=='yes+warn') {
					// 			$bAllowCachedResults = true;
					// 			$bWarnCachedResults = true;
					// 		}
					// 	}
					// 	else
					// 		$output .= $logger->msgWrongParam('allowcachedresults', $sArg);
					// }
					/** Wikia change end **/
					break;

                case 'dplcache':
                    if ($sArg!='') {
						$DPLCache = $parser->mTitle->getArticleID() . '_' . str_replace("/","_",$sArg) . '.dplc';
						$DPLCachePath = $parser->mTitle->getArticleID() % 10;
                   }
                    else {
	                    $output .= $logger->msgWrongParam('dplcache', $sArg);
                    }
                    break;

                case 'dplcacheperiod':
                    if( preg_match(ExtDynamicPageList::$options['dplcacheperiod']['pattern'], $sArg) )
                        $iDPLCachePeriod = ($sArg == '') ? ExtDynamicPageList::$options['dplcacheperiod']['default']: intval($sArg);
                    else
                        $output .= $logger->msgWrongParam('dplcacheperiod', $sArg);
                    break;

                case 'fixcategory':
					ExtDynamicPageList::fixCategory($sArg);
                    break;

                case 'reset':
                    foreach (preg_split('/[;,]/',$sArg) as $arg) {
                        $arg=trim($arg);
                        if ($arg=='') continue;
                        if( !in_array($arg, ExtDynamicPageList::$options['reset'])) {
                            $output .= $logger->msgWrongParam('reset', $arg);
                        }
                        else if ($arg=='links')  	$bReset[0]=true;
                        else if ($arg=='templates') $bReset[1]=true;
                        else if ($arg=='categories')$bReset[2]=true;
                        else if ($arg=='images')	$bReset[3]=true;
                        else if ($arg=='all')  {
                            $bReset[0]=true; $bReset[1]=true; $bReset[2]=true; $bReset[3]=true;
                        }
						else if ($arg=='none') ; // do nothing
                    }
                    break;

                case 'eliminate':
                    foreach (preg_split('/[;,]/',$sArg) as $arg) {
                        $arg=trim($arg);
                        if ($arg=='') continue;
                        if( !in_array($arg, ExtDynamicPageList::$options['eliminate'])) {
                            $output .= $logger->msgWrongParam('eliminate', $arg);
                        }
                        else if ($arg=='links')  	$bReset[4]=true;
                        else if ($arg=='templates') $bReset[5]=true;
                        else if ($arg=='categories')$bReset[6]=true;
                        else if ($arg=='images')	$bReset[7]=true;
                        else if ($arg=='all')  {
                            $bReset[4]=true; $bReset[5]=true; $bReset[6]=true; $bReset[7]=true;
                        }
						else if ($arg=='none') {
							$bReset[4]=false;$bReset[5]=false;$bReset[6]=false;$bReset[7]=false;
						}
                    }
                    break;

                /**
                 * UNKNOWN PARAMETER
                 */
                default:
					$validOptionFound = false;
            }

			if ($validOptionFound) continue;

            if (ExtDynamicPageList::$functionalRichness <= 2) {
				$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $sType, self::validParametersList());
				continue;
			}


			//------------------------------------------------------------------------------------------- level 3

			$validOptionFound = true;
            switch ($sType) {

                /**
                 * FILTER PARAMETERS
                 */
                case 'categoryregexp':
                    $sCategoryComparisonMode = ' REGEXP ';
                    $aIncludeCategories[] = array($sArg);
                    $bConflictsWithOpenReferences=true;
                    break;
                case 'categorymatch':
                    $sCategoryComparisonMode = ' LIKE ';
                    $aIncludeCategories[] = explode('|', $sArg);
                    $bConflictsWithOpenReferences=true;
                    break;
                case 'notcategoryregexp':
                    $sNotCategoryComparisonMode = ' REGEXP ';
                    $aExcludeCategories[] = $sArg;
                    $bConflictsWithOpenReferences=true;
                    break;
                case 'notcategorymatch':
                    $sNotCategoryComparisonMode = ' LIKE ';
                    $aExcludeCategories[] = $sArg;
                    $bConflictsWithOpenReferences=true;
                    break;

                case 'titleregexp':
                    $sTitleMatchMode = ' REGEXP ';
                    $aTitleMatch = array($sArg);
                    $bSelectionCriteriaFound=true;
                    break;
                case 'nottitleregexp':
                    $sNotTitleMatchMode = ' REGEXP ';
                    $aNotTitleMatch = array($sArg);
                    $bSelectionCriteriaFound=true;
                    break;
                case 'nottitlematch':
                    // we replace blanks by underscores to meet the internal representation
                    // of page names in the database
                    // $aNotTitleMatch = explode('|', str_replace(' ','_',$localParser->transformMsg($sArg, $pOptions)));
                    $aNotTitleMatch = explode('|', str_replace(' ','_',$sArg));
                    $bSelectionCriteriaFound=true;
                    break;

                case 'lastrevisionbefore':
                case 'allrevisionsbefore':
                case 'firstrevisionsince':
                case 'allrevisionssince':
                    if( preg_match(ExtDynamicPageList::$options[$sType]['pattern'], $sArg) ) {
						$date = str_pad(preg_replace('/[^0-9]/','',$sArg),14,'0');
						$date = $wgLang->userAdjust($date);
                        if (($sType) == 'lastrevisionbefore')	$sLastRevisionBefore = $date;
                        if (($sType) == 'allrevisionsbefore')	$sAllRevisionsBefore = $date;
                        if (($sType) == 'firstrevisionsince')	$sFirstRevisionSince = $date;
                        if (($sType) == 'allrevisionssince')	$sAllRevisionsSince  = $date;
                        $bConflictsWithOpenReferences=true;
                    }
                    else // wrong value
                        $output .= $logger->msgWrongParam($sType, $sArg);
                    break;
                case 'minrevisions':
                    //ensure that $iMinRevisions is a number
                    if( preg_match(ExtDynamicPageList::$options['minrevisions']['pattern'], $sArg) )
                        $iMinRevisions = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('minrevisions', $sArg);
                    break;
                case 'maxrevisions':
                    //ensure that $iMaxRevisions is a number
                    if( preg_match(ExtDynamicPageList::$options['maxrevisions']['pattern'], $sArg) )
                        $iMaxRevisions = ($sArg == '') ? null: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('maxrevisions', $sArg);
                    break;


                case 'openreferences':
                    if( in_array($sArg, ExtDynamicPageList::$options['openreferences']) )
                        $acceptOpenReferences = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('openreferences', $sArg);
                    break;

                case 'articlecategory':
                    $sArticleCategory =  str_replace(' ','_',$sArg);
                    break;

                /**
                 * UNKNOWN PARAMETER
                 */
                default:
					$validOptionFound = false;
            }

			if ($validOptionFound) continue;

            if (ExtDynamicPageList::$functionalRichness <= 3) {
				$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $sType, self::validParametersList());
				continue;
			}


			//------------------------------------------------------------------------------------------- level 4

			$validOptionFound = true;
            switch ($sType) {

                /**
                 * GOAL
                 */
                case 'goal':
                    if( in_array($sArg, ExtDynamicPageList::$options['goal']) ) {
                        $sGoal = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('goal', $sArg);
                    break;

                /**
                 * UPDATERULES
                 */

                case 'updaterules':
                    $sUpdateRules = $sArg;
                    break;

                /**
                 * DELETERULES
                 */

                case 'deleterules':
                    $sDeleteRules = $sArg;
                    break;

                /**
                 * UNKNOWN PARAMETER
                 */
                default:
					$validOptionFound = false;
            }

			if ($validOptionFound) continue;

			$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_UNKNOWNPARAM, $sType, self::validParametersList());

        }

		// set COUNT

		if ($sCount=='') $sCount = $sCountScroll;
		if ($sCount=='') {
			$iCount=-1;
		} else {
			if( preg_match(ExtDynamicPageList::$options['count']['pattern'], $sCount) ) {
				$iCount = intval($sCount);
			} else {
				// wrong value
				$output .= $logger->msgWrongParam('count', "$sCount : not a number!");
				$iCount=1;
			}
		}
		if (!ExtDynamicPageList::$allowUnlimitedResults && ($iCount<0 || $iCount > ExtDynamicPageList::$maxResultCount)) {
			// justify limits;
			$iCount = ExtDynamicPageList::$maxResultCount;
		}


		// disable parser cache	if caching is not allowed (which is default for DPL but not for <DynamicPageList>)
		/** Wikia change begin - never disable parser cache (CE-1066) **/
		// if ( !$bAllowCachedResults) {
		// 	$parser->disableCache();
		// }
		/** Wikia change end **/
        // place cache warning in resultsheader
        if ($bWarnCachedResults) $sResultsHeader = '{{DPL Cache Warning}}' . $sResultsHeader;



        if ($sExecAndExit != '') {
			// the keyword "geturlargs" is used to return the Url arguments and do nothing else.
			if ($sExecAndExit == 'geturlargs') return '';
			// in all other cases we return the value of the argument (which may contain parser function calls)
			return $sExecAndExit;
		}



		// if Caching is desired AND if the cache is up to date: get result from Cache and exit
		global $wgUploadDirectory, $wgRequest, $wgMemc;
		if ( $DPLCache != '' ) {
			$DPLCache .= "-" . md5($originalInput);
			$cacheFile = "$wgUploadDirectory/dplcache/$DPLCachePath/$DPLCache";
			// when the page containing the DPL statement is changed we must recreate the cache as the DPL statement may have changed
			// otherwise we accept the cache if it is not too old
			if ( !$bDPLRefresh ) {
				$cacheFound = false;
				$cacheTimeStamp = null;
				$cacheAge = null;
				$cacheInput = null;
				$cacheOutput = null;
				// load cached data from chosen storage
				switch ( $DPLCacheStorage ) {
					case 'files':
						// check if cache file exists
						if ( file_exists( $cacheFile ) ) {
							// find out if cache is acceptable or too old
							$cacheTimeStamp = filemtime( $cacheFile );
							$cacheAge = time() - $cacheTimeStamp;
							if ( $cacheAge <= $iDPLCachePeriod ) {
								$cacheOutput = file_get_contents( $cacheFile );
								$cacheOutputPos = strpos( $cacheOutput, "+++\n" );
								$cacheInput = substr( $cacheOutput, 0, $cacheOutputPos );
								$cacheOutput = substr( $cacheOutput, $cacheOutputPos + 4 );
								$cacheFound = true;
							}
						}
						break;
					case 'memcache':
						// create the unique cache key (replace spaces with underscores)
						$cacheKey = self::getMemcacheKey( $DPLCache );
						$cacheData = $wgMemc->get( $cacheKey );
						// if data was found in memcache
						if ( $cacheData && is_array( $cacheData ) ) {
							$cacheTimeStamp = $cacheData['timestamp'];
							$cacheAge = time() - $cacheTimeStamp;
							// if cached data isn't too old
							if ( $cacheAge <= $iDPLCachePeriod ) {
								$cacheInput = $cacheData['input'];
								$cacheOutput = $cacheData['output'];
								$cacheFound = true;
							}
						}
						break;
				}
				// when submitting a page we check if the DPL statement has changed
				if (
					$cacheFound &&
					( $wgRequest->getVal( 'action', 'view' ) != 'submit' ||
						( $originalInput == $cacheInput ) )
				) {
					$cacheTimeStamp = self::prettyTimeStamp( date( 'YmdHis', $cacheTimeStamp ) );
					$cachePeriod = self::durationTime( $iDPLCachePeriod );
					$diffTime = self::durationTime( $cacheAge );
					$output .= $cacheOutput;
					if ( $logger->iDebugLevel >= 2 ) {
						$output .= "{{Extension DPL cache|mode=get|page={{FULLPAGENAME}}|cache=$DPLCache|date=$cacheTimeStamp|now=" .
							date( 'H:i:s' ) . "|age=$diffTime|period=$cachePeriod|offset=$iOffset}}";
					}
					// ignore further parameters, stop processing, return cache content
					return $output;
				}
			}
		}

         // debug level 5 puts nowiki tags around the output
        if  ($logger->iDebugLevel==5) {
            $logger->iDebugLevel= 2;
            $sResultsHeader = '<pre><nowiki>'.$sResultsHeader;
            $sResultsFooter .= '</nowiki></pre>';
        }

        // construct internal keys for TableRow according to the structure of "include"
        // this will be needed in the output phase
        self::updateTableRowKeys($aTableRow,$aSecLabels);
        // foreach ($aTableRow as $key => $val) $output .= "TableRow($key)=$val;<br/>";

        $iIncludeCatCount = count($aIncludeCategories);
        $iTotalIncludeCatCount = count($aIncludeCategories, COUNT_RECURSIVE) - $iIncludeCatCount;
        $iExcludeCatCount = count($aExcludeCategories);
        $iTotalCatCount = $iTotalIncludeCatCount + $iExcludeCatCount;

        if ($calledInMode=='tag') {
            // in tag mode 'eliminate' is the same as 'reset' for tpl,cat,img
            if ($bReset[5]) { $bReset[1] = true; $bReset[5] = false; }
            if ($bReset[6]) { $bReset[2] = true; $bReset[6] = false; }
            if ($bReset[7]) { $bReset[3] = true; $bReset[7] = false; }
        }
        else {
            if ($bReset[1]) ExtDynamicPageList::$createdLinks['resetTemplates'] 	= true;
            if ($bReset[2]) ExtDynamicPageList::$createdLinks['resetCategories']	= true;
            if ($bReset[3]) ExtDynamicPageList::$createdLinks['resetImages'] 	= true;
        }
        if (($calledInMode=='tag' && $bReset[0]) || $calledInMode=='func') {
            if ($bReset[0]) ExtDynamicPageList::$createdLinks['resetLinks'] = true;
            // register a hook to reset links which were produced during parsing DPL output
            global $wgHooks;
            if (!isset($wgHooks['ParserAfterTidy']) ||
                !( in_array( 'ExtDynamicPageList::endReset',$wgHooks['ParserAfterTidy']) ||
                   in_array( array('ExtDynamicPageList', 'endReset' ),$wgHooks['ParserAfterTidy'],true) ) ) {
                $wgHooks['ParserAfterTidy'][]   = 'ExtDynamicPageList' . '__endReset';
            }
        }


		// ###### CHECKS ON PARAMETERS ######

        // too many categories!
        if ( ($iTotalCatCount > ExtDynamicPageList::$maxCategoryCount) && (!ExtDynamicPageList::$allowUnlimitedCategories) )
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_TOOMANYCATS, ExtDynamicPageList::$maxCategoryCount);

        // too few categories!
        if ($iTotalCatCount < ExtDynamicPageList::$minCategoryCount)
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_TOOFEWCATS, ExtDynamicPageList::$minCategoryCount);

        // no selection criteria! Warn only if no debug level is set
        if ($iTotalCatCount == 0 && $bSelectionCriteriaFound==false) {
            if ($logger->iDebugLevel <= 1) return $output;
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_NOSELECTION);
        }

        // ordermethod=sortkey requires ordermethod=category
        // delayed to the construction of the SQL query, see near line 2211, gs
		//if (in_array('sortkey',$aOrderMethods) && ! in_array('category',$aOrderMethods)) $aOrderMethods[] = 'category';

        // no included categories but ordermethod=categoryadd or addfirstcategorydate=true!
        if ($iTotalIncludeCatCount == 0 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_CATDATEBUTNOINCLUDEDCATS);

        // more than one included category but ordermethod=categoryadd or addfirstcategorydate=true!
        // we ALLOW this parameter combination, risking ambiguous results
        //if ($iTotalIncludeCatCount > 1 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
        //	return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_CATDATEBUTMORETHAN1CAT);

        // no more than one type of date at a time!
        if($bAddPageTouchedDate + $bAddFirstCategoryDate + $bAddEditDate > 1)
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_MORETHAN1TYPEOFDATE);

        // the dominant section must be one of the sections mentioned in includepage
        if($iDominantSection>0 && count($aSecLabels)<$iDominantSection)
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_DOMINANTSECTIONRANGE, count($aSecLabels));

        // category-style output requested with not compatible order method
        if ($sPageListMode == 'category' && !array_intersect($aOrderMethods, array('sortkey', 'title','titlewithoutnamespace')) )
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_WRONGORDERMETHOD,  'mode=category', 'sortkey | title | titlewithoutnamespace' );

        // addpagetoucheddate=true with unappropriate order methods
        if( $bAddPageTouchedDate && !array_intersect($aOrderMethods, array('pagetouched', 'title')) )
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_WRONGORDERMETHOD,  'addpagetoucheddate=true', 'pagetouched | title' );

        // addeditdate=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
        //firstedit (resp. lastedit) -> add date of first (resp. last) revision
        if( $bAddEditDate && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) & ($sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince == '')) {
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_WRONGORDERMETHOD, 'addeditdate=true', 'firstedit | lastedit' );
        }

        // adduser=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
        /**
         * @todo allow to add user for other order methods.
         * The fact is a page may be edited by multiple users. Which user(s) should we show? all? the first or the last one?
         * Ideally, we could use values such as 'all', 'first' or 'last' for the adduser parameter.
        */
        if( $bAddUser && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) & ($sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince == '')) {
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_WRONGORDERMETHOD, 'adduser=true', 'firstedit | lastedit' );
		}
        if( isset($sMinorEdits) && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
            return $output . $logger->escapeMsg(ExtDynamicPageList::FATAL_WRONGORDERMETHOD, 'minoredits', 'firstedit | lastedit' );

        /**
         * If we include the Uncategorized, we need the 'dpl_clview': VIEW of the categorylinks table where we have cl_to='' (empty string) for all uncategorized pages. This VIEW must have been created by the administrator of the mediawiki DB at installation. See the documentation.
         */
        $sDplClView = '';
        if($bIncludeUncat) {
            $sDplClView = $dbr->tableName( 'dpl_clview' );
            // If the view is not there, we can't perform logical operations on the Uncategorized.
            if ( !$dbr->tableExists( 'dpl_clview' ) ) {
                $sSqlCreate_dpl_clview = 'CREATE VIEW ' . $sDplClView . " AS SELECT IFNULL(cl_from, page_id) AS cl_from, IFNULL(cl_to, '') AS cl_to, cl_sortkey FROM " . $sPageTable . ' LEFT OUTER JOIN ' . $sCategorylinksTable . ' ON '.$sPageTable.'.page_id=cl_from';
                $output .= $logger->escapeMsg(ExtDynamicPageList::FATAL_NOCLVIEW, $sDplClView, $sSqlCreate_dpl_clview);
                return $output;
            }
        }

        //add*** parameters have no effect with 'mode=category' (only namespace/title can be viewed in this mode)
        if( $sPageListMode == 'category' && ($bAddCategories || $bAddEditDate || $bAddFirstCategoryDate || $bAddPageTouchedDate
                                            || $bIncPage || $bAddUser || $bAddAuthor || $bAddContribution || $bAddLastEditor ) )
            $output .= $logger->escapeMsg(ExtDynamicPageList::WARN_CATOUTPUTBUTWRONGPARAMS);

        //headingmode has effects with ordermethod on multiple components only
        if( $sHListMode != 'none' && count($aOrderMethods) < 2 ) {
            $output .= $logger->escapeMsg(ExtDynamicPageList::WARN_HEADINGBUTSIMPLEORDERMETHOD, $sHListMode, 'none');
            $sHListMode = 'none';
        }

        // openreferences is incompatible with many other options
        if( $acceptOpenReferences && $bConflictsWithOpenReferences ) {
            $output .= $logger->escapeMsg(ExtDynamicPageList::FATAL_OPENREFERENCES);
            $acceptOpenReferences=false;
        }


        // if 'table' parameter is set: derive values for listseparators, secseparators and multisecseparators
        $defaultTemplateSuffix='.default';
        if ($sTable!='') {
            $defaultTemplateSuffix='';
            $sPageListMode='userformat';
            $sInlTxt = '';
            $withHLink = "[[%PAGE%|%TITLE%]]\n|";
            foreach (explode(',',$sTable) as $tabnr => $tab) {
                if ($tabnr==0) 	{
                    if ($tab=='') $tab='class=wikitable';
                    $aListSeparators[0]='{|'.$tab;
                }
                else {
                    if ($tabnr==1 && $tab=='-') {
                        $withHLink = '';
                        continue;
                    }
                    if ($tabnr==1 && $tab=='') $tab='Article';
                    $aListSeparators[0].= "\n!$tab";
                }
            }
            $aListSeparators[1] = '';
            // the user may have specified the third parameter of 'format' to add meta attributes of articles to the table
            if (!array_key_exists(2,$aListSeparators)) $aListSeparators[2] = '';
            $aListSeparators[3] = "\n|}";

            for ($i=0;$i<count($aSecLabels);$i++) {
                if ($i==0)	{
                    $aSecSeparators[0]= "\n|-\n|".$withHLink; //."\n";
                    $aSecSeparators[1]='';
                    $aMultiSecSeparators[0]="\n|-\n|".$withHLink; // ."\n";
                }
                else {
                    $aSecSeparators[2*$i] = "\n|"; // ."\n";
                    $aSecSeparators[2*$i+1]='';
                    if (is_array($aSecLabels[$i]) && $aSecLabels[$i][0]=='#') 	$aMultiSecSeparators[$i] = "\n----\n";
                    if ($aSecLabels[$i][0]=='#') 	$aMultiSecSeparators[$i] = "\n----\n";
                    else							$aMultiSecSeparators[$i] = "<br/>\n";
                }
            }
        }

		// backward scrolling: if the user specified titleLE and wants ascending order we reverse the SQL sort order
		if ($sTitleLE != '' && $sTitleGE =='') {
			if      ($sOrder == 'ascending' )  $sOrder='descending';
		}

		$output.='{{Extension DPL}}';



    // ###### BUILD SQL QUERY ######
        $sSqlPage_counter = '';
        $sSqlPage_size = '';
        $sSqlPage_touched = '';
		$sSqlCalcFoundRows = '';
		if ( !ExtDynamicPageList::$allowUnlimitedResults 	&& $sGoal != 'categories'
				&& strpos($sResultsHeader.$sResultsFooter.$sNoResultsHeader,'%TOTALPAGES%')!==false) $sSqlCalcFoundRows = 'SQL_CALC_FOUND_ROWS';
        if ($sDistinctResultSet == 'false') $sSqlDistinct = '';
        else								$sSqlDistinct = 'DISTINCT';
        $sSqlGroupBy = '';
        if ($sDistinctResultSet == 'strict'
           && (count($aLinksTo)+count($aNotLinksTo)+count($aLinksFrom)+count($aNotLinksFrom)+count($aLinksToExternal)+count($aImageUsed))>0 ) $sSqlGroupBy = 'page_title';
        $sSqlSortkey = '';
        $sSqlCl_to = '';
        $sSqlCats = '';
        $sSqlCl_timestamp = '';
        $sSqlClHeadTable = '';
        $sSqlCond_page_cl_head = '';
        $sSqlClTableForGC = '';
        $sSqlCond_page_cl_gc = '';
        $sSqlRCTable = '';    // recent changes
        $sRCTable = $dbr->tableName( 'recentchanges' );
        $sRevisionTable = $dbr->tableName( 'revision' );
        $sSqlRevisionTable = '';
        $sSqlRev_timestamp = '';
        $sSqlRev_id = '';
        $sSqlRev_user = '';
        $sSqlCond_page_rev = '';
        $sPageLinksTable = $dbr->tableName( 'pagelinks' );
        $sExternalLinksTable = $dbr->tableName( 'externallinks' );
        $sImageLinksTable = $dbr->tableName( 'imagelinks' );
        $sTemplateLinksTable = $dbr->tableName( 'templatelinks' );
        $sSqlPageLinksTable = '';
        $sSqlExternalLinksTable = '';
        $sSqlCond_page_pl = '';
        $sSqlCond_page_el = '';
        $sSqlCond_page_tpl = '';
        $sSqlCond_MaxCat = '';
        $sSqlWhere = ' WHERE 1=1 ';
        $sSqlSelPage = ''; // initial page for selection

        // normally we create a result of normal pages, but when goal=categories is set, we create a list of categories
        // as this conflicts with some options we need to avoid producing incoorect SQl code
        $bGoalIsPages = true;
        if ($sGoal == 'categories') {
            $aOrderMethods = explode(',','');
            $bGoalIsPages=false;
        }

        foreach($aOrderMethods as $sOrderMethod) {
            switch ($sOrderMethod) {
                case 'category':
                    $sSqlCl_to = "cl_head.cl_to, "; // Gives category headings in the result
                    $sSqlClHeadTable = ( (in_array('', $aCatHeadings) ||in_array('', $aCatNotHeadings)) ? $sDplClView : $sCategorylinksTable ) . ' AS cl_head'; // use dpl_clview if Uncategorized in headings
                    $sSqlCond_page_cl_head = 'page_id=cl_head.cl_from';
                    if(!empty($aCatHeadings))
                        $sSqlWhere .= " AND cl_head.cl_to IN (" . $dbr->makeList( $aCatHeadings ) . ")";
                    if(!empty($aCatNotHeadings))
                        $sSqlWhere .= " AND NOT (cl_head.cl_to IN (" . $dbr->makeList( $aCatNotHeadings ) . "))";
                    break;
                case 'firstedit':
                    $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
                    $sSqlRev_timestamp = ', rev_timestamp';
                    // deleted because of conflict with revsion-parameters
                    $sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
                    break;
                case 'pagetouched':
						$sSqlPage_touched = ", $sPageTable.page_touched as page_touched";
						break;
                case 'lastedit':
					if (ExtDynamicPageList::$behavingLikeIntersection) {
						$sSqlPage_touched = ", $sPageTable.page_touched as page_touched";
					}
					else {
						$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
						$sSqlRev_timestamp = ', rev_timestamp';
						// deleted because of conflict with revision-parameters
						$sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
					}
                    break;
                case 'sortkey':
                    // We need the namespaces with strictly positive indices (DPL allowed namespaces, except the first one: Main).
                    $aStrictNs = array_slice(ExtDynamicPageList::$allowedNamespaces, 1, count(ExtDynamicPageList::$allowedNamespaces), true);
                    // map ns index to name
                    $sSqlNsIdToText = 'CASE '.$sPageTable.'.page_namespace';
                    foreach($aStrictNs as $iNs => $sNs)
                        $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs );
                    $sSqlNsIdToText .= ' END';
                    // If cl_sortkey is null (uncategorized page), generate a sortkey in the usual way (full page name, underscores replaced with spaces).
                    // UTF-8 created problems with non-utf-8 MySQL databases
					//see line 2011 (order method sortkey requires category
					if (count($aIncludeCategories)+count($aExcludeCategories)>0) {
						if (in_array('category',$aOrderMethods) && (count($aIncludeCategories)+count($aExcludeCategories)>0)) {
							$sSqlSortkey = ", IFNULL(cl_head.cl_sortkey, REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' ')) ".$sOrderCollation." as sortkey";
						}
						else {
							$sSqlSortkey = ", IFNULL(cl0.cl_sortkey, REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' ')) ".$sOrderCollation." as sortkey";
						}
					}
					else {
							$sSqlSortkey = ", REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' ') ".$sOrderCollation." as sortkey";
					}
                    break;
                case 'pagesel':
                    $sSqlSortkey = ', CONCAT(pl.pl_namespace,pl.pl_title) '.$sOrderCollation.' as sortkey';
                    break;
                case 'titlewithoutnamespace':
                    $sSqlSortkey = ", $sPageTable.page_title ".$sOrderCollation." as sortkey";
                    break;
                case 'title':
                    $aStrictNs = array_slice(ExtDynamicPageList::$allowedNamespaces, 1, count(ExtDynamicPageList::$allowedNamespaces), true);
                    // map namespace index to name
                    if ($acceptOpenReferences) {
                        $sSqlNsIdToText = 'CASE pl_namespace';
                        foreach($aStrictNs as $iNs => $sNs)
                            $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
                        $sSqlNsIdToText .= ' END';
							$sSqlSortkey = ", REPLACE(CONCAT( IF(pl_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), pl_title), '_', ' ') ".$sOrderCollation." as sortkey";
                    }
                    else {
                        $sSqlNsIdToText = 'CASE '.$sPageTable.'.page_namespace';
                        foreach($aStrictNs as $iNs => $sNs)
                            $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
                        $sSqlNsIdToText .= ' END';
                        // Generate sortkey like for category links. UTF-8 created problems with non-utf-8 MySQL databases
                        $sSqlSortkey = ", REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' ') ".$sOrderCollation." as sortkey";
                    }
                    break;
                case 'user':
                    $sSqlRevisionTable = $sRevisionTable . ', ';
                    $sSqlRev_user = ', rev_user, rev_user_text, rev_comment';
                    break;
                case 'none':
                    break;
            }
        }

        // linksto

        if ( count($aLinksTo)>0 ) {
            $sSqlPageLinksTable .= $sPageLinksTable . ' AS pl, ';
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id=pl.pl_from AND ';
            $sSqlSelPage = ', pl.pl_title AS sel_title, pl.pl_namespace AS sel_ns';
            $n=0;
            foreach ($aLinksTo as $linkGroup) {
                if (++$n>1) break;
                $sSqlCond_page_pl .= '( ';
				$m=0;
				foreach ($linkGroup as $link) {
					if (++$m>1) $sSqlCond_page_pl .= ' OR ';
					$sSqlCond_page_pl .= '(pl.pl_namespace=' . intval( $link->getNamespace() );
					if (strpos($link->getDbKey(),'%')>=0) $operator = ' LIKE '; else $operator='=';
					if ($bIgnoreCase) 	$sSqlCond_page_pl .= ' AND LOWER(CAST(pl.pl_title AS char))'.$operator.'LOWER(' . $dbr->addQuotes( $link->getDbKey() ).'))';
					else				$sSqlCond_page_pl .= ' AND pl.pl_title'.$operator.$dbr->addQuotes( $link->getDbKey() ).')';
				}
                $sSqlCond_page_pl .= ')';
			}
		}
        if ( count($aLinksTo)>1 ) {
            $n=0;
            foreach ($aLinksTo as $linkGroup) {
                if (++$n == 1) continue;
				$m=0;
				$sSqlCond_page_pl .= ' AND EXISTS(select pl_from FROM '.$sPageLinksTable.' WHERE ('.$sPageLinksTable.'.pl_from=page_id AND (';
				foreach ($linkGroup as $link) {
					if (++$m>1) $sSqlCond_page_pl .= ' OR ';
					$sSqlCond_page_pl.= '('.$sPageLinksTable.'.pl_namespace=' . intval( $link->getNamespace() );
					if (strpos($link->getDbKey(),'%')>=0) $operator = ' LIKE '; else $operator='=';
					if ($bIgnoreCase) 	$sSqlCond_page_pl .= ' AND LOWER(CAST('.$sPageLinksTable.'.pl_title AS char))'.$operator.'LOWER(' . $dbr->addQuotes( $link->getDbKey() ).')';
					else				$sSqlCond_page_pl .= ' AND '.$sPageLinksTable.'.pl_title'.$operator.$dbr->addQuotes( $link->getDbKey() );
					$sSqlCond_page_pl .= ')';
				}
				$sSqlCond_page_pl .= ')))';
            }
        }

        // notlinksto
        if ( count($aNotLinksTo)>0 ) {
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id NOT IN (SELECT '.$sPageLinksTable.'.pl_from FROM '.$sPageLinksTable.' WHERE (';
            $n=0;
            foreach ($aNotLinksTo as $links) {
				foreach ($links as $link) {
					if ($n>0) $sSqlCond_page_pl .= ' OR ';
					$sSqlCond_page_pl .= '('.$sPageLinksTable.'.pl_namespace=' . intval($link->getNamespace());
				if (strpos($link->getDbKey(),'%')>=0) $operator = ' LIKE '; else $operator='=';
					if ($bIgnoreCase) 	$sSqlCond_page_pl .= ' AND LOWER(CAST('.$sPageLinksTable.'.pl_title AS char))'.$operator.'LOWER(' . $dbr->addQuotes( $link->getDbKey() ).'))';
					else				$sSqlCond_page_pl .= ' AND       '.$sPageLinksTable.'.pl_title'.$operator. $dbr->addQuotes( $link->getDbKey() ).')';
					$n++;
				}
			}
            $sSqlCond_page_pl .= ') )';
        }

        // linksfrom
        if ( count($aLinksFrom)>0 ) {
            if ($acceptOpenReferences) {
                $sSqlCond_page_pl .= ' AND (';
                $n=0;
                foreach ($aLinksFrom as $links) {
					foreach ($links as $link) {
						if ($n>0) $sSqlCond_page_pl .= ' OR ';
						$sSqlCond_page_pl .= '(pl_from=' . $link->getArticleID().')';
						$n++;
					}
                }
                $sSqlCond_page_pl .= ')';
            }
            else {
                $sSqlPageLinksTable .= $sPageLinksTable . ' AS plf, '. $sPageTable . 'AS pagesrc, ';
                $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_namespace = plf.pl_namespace AND '.$sPageTable.'.page_title = plf.pl_title  AND pagesrc.page_id=plf.pl_from AND (';
                $sSqlSelPage = ', pagesrc.page_title AS sel_title, pagesrc.page_namespace AS sel_ns';
                $n=0;
                foreach ($aLinksFrom as $links) {
					foreach ($links as $link) {
						if ($n>0) $sSqlCond_page_pl .= ' OR ';
						$sSqlCond_page_pl .= '(plf.pl_from=' . $link->getArticleID().')';
						$n++;
					}
				}
                $sSqlCond_page_pl .= ')';
            }
        }

        // notlinksfrom
        if ( count($aNotLinksFrom)>0 ) {
            if ($acceptOpenReferences) {
                $sSqlCond_page_pl .= ' AND (';
                $n=0;
                foreach ($aNotLinksFrom as $links) {
					foreach ($links as $link) {
						if ($n>0) $sSqlCond_page_pl .= ' AND ';
						$sSqlCond_page_pl .= 'pl_from <> ' . $link->getArticleID(). ' ';
						$n++;
					}
                }
                $sSqlCond_page_pl .= ')';
            }
            else {
                $sSqlCond_page_pl .= ' AND CONCAT(page_namespace,page_title) NOT IN (SELECT CONCAT('.$sPageLinksTable.'.pl_namespace,'
                                    .$sPageLinksTable.'.pl_title) from '.$sPageLinksTable.' WHERE (';
                $n=0;
                foreach ($aNotLinksFrom as $links) {
					foreach ($links as $link) {
						if ($n>0) $sSqlCond_page_pl .= ' OR ';
						$sSqlCond_page_pl .= $sPageLinksTable.'.pl_from=' . $link->getArticleID(). ' ';
						$n++;
					}
                }
                $sSqlCond_page_pl .= '))';
            }
        }

        // linkstoexternal
        if ( count($aLinksToExternal)>0 ) {
            $sSqlExternalLinksTable .= $sExternalLinksTable . ' AS el, ';
            $sSqlCond_page_el .= ' AND '.$sPageTable.'.page_id=el.el_from AND (';
            $sSqlSelPage = ', el.el_to as el_to';
            $n=0;
            foreach ($aLinksToExternal as $linkGroup) {
                if (++$n>1) break;
				$m=0;
				foreach ($linkGroup as $link) {
					if (++$m>1) $sSqlCond_page_el .= ' OR ';
					$sSqlCond_page_el .= '(el.el_to LIKE ' . $dbr->addQuotes( $link ).')';
				}
			}
            $sSqlCond_page_el .= ')';
		}
        if ( count($aLinksToExternal)>1 ) {
            $n=0;
            foreach ($aLinksToExternal as $linkGroup) {
                if (++$n == 1) continue;
				$m=0;
				$sSqlCond_page_el .= ' AND EXISTS(SELECT el_from FROM '.$sExternalLinksTable.' WHERE ('.$sExternalLinksTable.'.el_from=page_id AND (';
				foreach ($linkGroup as $link) {
					if (++$m>1) $sSqlCond_page_el .= ' OR ';
					$sSqlCond_page_el .= '('.$sExternalLinksTable.'.el_to LIKE ' . $dbr->addQuotes( $link ).')';
				}
				$sSqlCond_page_el .= ')))';
            }
        }

        // imageused
        if ( count($aImageUsed)>0 ) {
            $sSqlPageLinksTable .= $sImageLinksTable . ' AS il, ';
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id=il.il_from AND (';
            $sSqlSelPage = ', il.il_to AS image_sel_title';
            $n=0;
            foreach ($aImageUsed as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                if ($bIgnoreCase) 	$sSqlCond_page_pl .= "LOWER(CAST(il.il_to AS char))=LOWER(" . $dbr->addQuotes( $link->getDbKey() ).')';
                else				$sSqlCond_page_pl .= "il.il_to=" . $dbr->addQuotes( $link->getDbKey() );
                $n++;
            }
            $sSqlCond_page_pl .= ')';
        }

        // imagecontainer
        if ( count($aImageContainer)>0 ) {
            $sSqlPageLinksTable .= $sImageLinksTable . ' AS ic, ';
            if ($acceptOpenReferences) {
				$sSqlCond_page_pl .= ' AND (';
            }
            else {
				$sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_namespace=\'6\' AND '.$sPageTable.'.page_title=ic.il_to AND (';
			}
            $n=0;
            foreach ($aImageContainer as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                if ($bIgnoreCase) $sSqlCond_page_pl .= "LOWER(CAST(ic.il_from AS char)=LOWER(" . $dbr->addQuotes( $link->getArticleID() ).')';
                else              $sSqlCond_page_pl .= "ic.il_from=" . $dbr->addQuotes( $link->getArticleID() );
                $n++;
            }
            $sSqlCond_page_pl .= ')';
        }

        // uses
        if ( count($aUses)>0 ) {
            $sSqlPageLinksTable .= ' '.$sTemplateLinksTable . ' as tl, ';
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id=tl.tl_from  AND (';
            $n=0;
            foreach ($aUses as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '(tl.tl_namespace=' . intval( $link->getNamespace() );
                if ($bIgnoreCase)	$sSqlCond_page_pl .= " AND LOWER(CAST(tl.tl_title AS char))=LOWER(" 	. $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= " AND       tl.tl_title="        				. $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ')';
        }

        // notuses
        if ( count($aNotUses)>0 ) {
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id NOT IN (SELECT '.$sTemplateLinksTable.'.tl_from FROM '.$sTemplateLinksTable.' WHERE (';
            $n=0;
            foreach ($aNotUses as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '('.$sTemplateLinksTable.'.tl_namespace=' . intval($link->getNamespace());
                if ($bIgnoreCase)	$sSqlCond_page_pl .= ' AND LOWER(CAST('.$sTemplateLinksTable.'.tl_title AS char))=LOWER(' . $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= ' AND '.$sTemplateLinksTable.'.tl_title=' . $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ') )';
        }

        // usedby
        if ( count($aUsedBy)>0 ) {
            if ($acceptOpenReferences) {
                $sSqlCond_page_tpl .= ' AND (';
                $n=0;
                foreach ($aUsedBy as $link) {
                    if ($n>0) $sSqlCond_page_tpl .= ' OR ';
                    $sSqlCond_page_tpl .= '(tpl_from=' . $link->getArticleID().')';
                    $n++;
                }
                $sSqlCond_page_tpl .= ')';
            }
            else {
                $sSqlPageLinksTable .= $sTemplateLinksTable . ' AS tpl, '. $sPageTable . 'AS tplsrc, ';
                $sSqlCond_page_tpl .= ' AND '.$sPageTable.'.page_title = tpl.tl_title  AND tplsrc.page_id=tpl.tl_from AND (';
                $sSqlSelPage = ', tplsrc.page_title AS tpl_sel_title, tplsrc.page_namespace AS tpl_sel_ns';
                $n=0;
                foreach ($aUsedBy as $link) {
                    if ($n>0) $sSqlCond_page_tpl .= ' OR ';
                    $sSqlCond_page_tpl .= '(tpl.tl_from=' . $link->getArticleID().')';
                    $n++;
                }
                $sSqlCond_page_tpl .= ')';
            }
        }


        // recent changes  =============================

        if ( $bAddContribution ) {
            $sSqlRCTable = $sRCTable . ' AS rc, ';
            $sSqlSelPage .= ', SUM( ABS( rc.rc_new_len - rc.rc_old_len ) ) AS contribution, rc.rc_user_text AS contributor';
            $sSqlWhere   .= ' AND page.page_id=rc.rc_cur_id';
            if ($sSqlGroupBy != '') $sSqlGroupBy .= ', ';
            $sSqlGroupBy .= 'rc.rc_cur_id';
        }

        // Revisions ==================================
        if ( $sCreatedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sCreatedBy) . ' = (SELECT rev_user_text FROM '.$sRevisionTable
                                .' WHERE '.$sRevisionTable.'.rev_page=page_id ORDER BY '.$sRevisionTable.'.rev_timestamp ASC LIMIT 1)';
        }
        if ( $sNotCreatedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotCreatedBy) . ' != (SELECT rev_user_text FROM '.$sRevisionTable
                                .' WHERE '.$sRevisionTable.'.rev_page=page_id ORDER BY '.$sRevisionTable.'.rev_timestamp ASC LIMIT 1)';
        }
        if ( $sModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sModifiedBy) . ' IN (SELECT rev_user_text FROM '.$sRevisionTable
                                .' WHERE '.$sRevisionTable.'.rev_page=page_id)';
        }
        if ( $sNotModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotModifiedBy) . ' NOT IN (SELECT rev_user_text FROM '.$sRevisionTable.' WHERE '.$sRevisionTable.'.rev_page=page_id)';
        }
        if ( $sLastModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sLastModifiedBy) . ' = (SELECT rev_user_text FROM '.$sRevisionTable
                                .' WHERE '.$sRevisionTable.'.rev_page=page_id ORDER BY '.$sRevisionTable.'.rev_timestamp DESC LIMIT 1)';
        }
        if ( $sNotLastModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotLastModifiedBy) . ' != (SELECT rev_user_text FROM '.$sRevisionTable
                                .' WHERE '.$sRevisionTable.'.rev_page=page_id ORDER BY '.$sRevisionTable.'.rev_timestamp DESC LIMIT 1)';
        }

        if ($bAddAuthor && $sSqlRevisionTable =='') {
            $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
            $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux_min.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux_min WHERE rev_aux_min.rev_page=rev.rev_page )';
        }
        if ($bAddLastEditor && $sSqlRevisionTable =='') {
            $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
            $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux_max.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux_max WHERE rev_aux_max.rev_page=rev.rev_page )';
        }

        if ($sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince != '') {
            $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
            $sSqlRev_timestamp = ', rev_timestamp';
            $sSqlRev_id = ', rev_id';
			if ($sLastRevisionBefore!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux_bef.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux_bef WHERE rev_aux_bef.rev_page=rev.rev_page AND rev_aux_bef.rev_timestamp < '.$sLastRevisionBefore.')';
            }
            if  ($sAllRevisionsBefore!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp < '.$sAllRevisionsBefore;
            }
            if ($sFirstRevisionSince!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux_snc.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux_snc WHERE rev_aux_snc.rev_page=rev.rev_page AND rev_aux_snc.rev_timestamp >= '.$sFirstRevisionSince.')';
            }
            if ($sAllRevisionsSince!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp >= '.$sAllRevisionsSince;
            }
        }

        if ( isset($aCatMinMax[0]) && $aCatMinMax[0]!='' ) {
            $sSqlCond_MaxCat .= ' AND ' . $aCatMinMax[0] . ' <= (SELECT count(*) FROM ' . $sCategorylinksTable .
            ' WHERE '.$sCategorylinksTable.'.cl_from=page_id)';
        }
        if ( isset($aCatMinMax[1]) && $aCatMinMax[1]!='') {
            $sSqlCond_MaxCat .= ' AND ' . $aCatMinMax[1] . ' >= (SELECT count(*) FROM ' . $sCategorylinksTable .
            ' WHERE '.$sCategorylinksTable.'.cl_from=page_id)';
        }

        if ($bAddFirstCategoryDate)
            //format cl_timestamp field (type timestamp) to string in same format AS rev_timestamp field
            //to make it compatible with $wgLang->date() function used in function DPLOutputListStyle() to show "firstcategorydate"
            $sSqlCl_timestamp = ", DATE_FORMAT(cl0.cl_timestamp, '%Y%m%d%H%i%s') AS cl_timestamp";
        if ($bAddPageCounter)
            $sSqlPage_counter = ", $sPageTable.page_counter AS page_counter";
        if ($bAddPageSize)
            $sSqlPage_size = ", $sPageTable.page_len AS page_len";
        if ($bAddPageTouchedDate && $sSqlPage_touched=='')
            $sSqlPage_touched = ", $sPageTable.page_touched AS page_touched";
        if ($bAddUser || $bAddAuthor || $bAddLastEditor || $sSqlRevisionTable != '')
            $sSqlRev_user = ', rev_user, rev_user_text, rev_comment';
        if ($bAddCategories) {
            $sSqlCats = ", GROUP_CONCAT(DISTINCT cl_gc.cl_to ORDER BY cl_gc.cl_to ASC SEPARATOR ' | ') AS cats";
            // Gives list of all categories linked from each article, if any.
            $sSqlClTableForGC = $sCategorylinksTable . ' AS cl_gc';
            // Categorylinks table used by the Group Concat (GC) function above
            $sSqlCond_page_cl_gc = 'page_id=cl_gc.cl_from';
            if ($sSqlGroupBy != '') $sSqlGroupBy .= ', ';
            $sSqlGroupBy .= $sSqlCl_to .$sPageTable.'.page_id';
        }

        // SELECT ... FROM
        if ($acceptOpenReferences)
                 // SELECT ... FROM
        	if (count($aImageContainer)>0) {
	        	$sSqlSelectFrom = "SELECT $sSqlCalcFoundRows $sSqlDistinct " . $sSqlCl_to . 'ic.il_to, ' . $sSqlSelPage . "ic.il_to AS sortkey" . ' FROM ' . $sImageLinksTable . ' AS ic';
        	}
        	else {
	        	$sSqlSelectFrom = "SELECT $sSqlCalcFoundRows $sSqlDistinct " . $sSqlCl_to . 'pl_namespace, pl_title' . $sSqlSelPage . $sSqlSortkey . ' FROM ' . $sPageLinksTable;
        	}
        else
			$sSqlSelectFrom = "SELECT $sSqlCalcFoundRows $sSqlDistinct " . $sSqlCl_to . $sPageTable.'.page_namespace AS page_namespace,'.
            					$sPageTable.'.page_title AS page_title,'.$sPageTable.'.page_id AS page_id' . $sSqlSelPage . $sSqlSortkey . $sSqlPage_counter .
                                $sSqlPage_size . $sSqlPage_touched . $sSqlRev_user .
                                $sSqlRev_timestamp . $sSqlRev_id . $sSqlCats . $sSqlCl_timestamp .
                                ' FROM ' . $sSqlRevisionTable . $sSqlRCTable . $sSqlPageLinksTable . $sSqlExternalLinksTable . $sPageTable;

        // JOIN ...
        if($sSqlClHeadTable != '' || $sSqlClTableForGC != '') {
            $b2tables = ($sSqlClHeadTable != '') && ($sSqlClTableForGC != '');
            $sSqlSelectFrom .= ' LEFT OUTER JOIN ' . $sSqlClHeadTable . ($b2tables ? ', ' : '') . $sSqlClTableForGC . ' ON (' . $sSqlCond_page_cl_head . ($b2tables ? ' AND ' : '') . $sSqlCond_page_cl_gc . ')';
        }

        // Include categories...
        $iClTable = 0;
        for ($i = 0; $i < $iIncludeCatCount; $i++) {
            // If we want the Uncategorized
            $sSqlSelectFrom .= ' INNER JOIN ' . ( in_array('', $aIncludeCategories[$i]) ? $sDplClView : $sCategorylinksTable ) .
                               ' AS cl' . $iClTable . ' ON '.$sPageTable.'.page_id=cl' . $iClTable . '.cl_from AND (cl' . $iClTable . '.cl_to'.
                               $sCategoryComparisonMode . $dbr->addQuotes(str_replace(' ','_',$aIncludeCategories[$i][0]));
            for ($j = 1; $j < count($aIncludeCategories[$i]); $j++)
                $sSqlSelectFrom .= ' OR cl' . $iClTable . '.cl_to' . $sCategoryComparisonMode . $dbr->addQuotes(str_replace(' ','_',$aIncludeCategories[$i][$j]));
			$sSqlSelectFrom .= ') ';
            $iClTable++;
        }

        // Exclude categories...
        for ($i = 0; $i < $iExcludeCatCount; $i++) {
            $sSqlSelectFrom .=
                ' LEFT OUTER JOIN ' . $sCategorylinksTable . ' AS cl' . $iClTable .
                ' ON '.$sPageTable.'.page_id=cl' . $iClTable . '.cl_from' .
                ' AND cl' . $iClTable . '.cl_to'. $sNotCategoryComparisonMode . $dbr->addQuotes(str_replace(' ','_',$aExcludeCategories[$i]));
            $sSqlWhere .= ' AND cl' . $iClTable . '.cl_to IS NULL';
            $iClTable++;
        }

        // WHERE... (actually finish the WHERE clause we may have started if we excluded categories - see above)
        // Namespace IS ...
        if ( !empty($aNamespaces)) {
            if ($acceptOpenReferences)
                $sSqlWhere .= ' AND '.$sPageLinksTable.'.pl_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
            else
                $sSqlWhere .= ' AND '.$sPageTable.'.page_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
        }
        // Namespace IS NOT ...
        if ( !empty($aExcludeNamespaces)) {
            if ($acceptOpenReferences)
                $sSqlWhere .= ' AND '.$sPageLinksTable.'.pl_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
            else
                $sSqlWhere .= ' AND '.$sPageTable.'.page_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
        }

        // TitleIs
        if ( $sTitleIs != '' ) {
            if ($bIgnoreCase) 	$sSqlWhere .= ' AND LOWER(CAST('.$sPageTable.'.page_title AS char)) = LOWER(' . $dbr->addQuotes($sTitleIs) .')' ;
            else			 	$sSqlWhere .= ' AND '.$sPageTable.'.page_title = ' . $dbr->addQuotes($sTitleIs) ;
        }

        // TitleGE ...
        if ( $sTitleGE != '' ) {
            $sSqlWhere .= ' AND (';
			if (substr($sTitleGE,0,2)=='=_') {
				if ($acceptOpenReferences) 	$sSqlWhere .= 'pl_title >=' . $dbr->addQuotes(substr($sTitleGE,2)) ;
				else 		                $sSqlWhere .= $sPageTable.'.page_title >=' . $dbr->addQuotes(substr($sTitleGE,2)) ;
			} else {
				if ($acceptOpenReferences) 	$sSqlWhere .= 'pl_title >' . $dbr->addQuotes($sTitleGE) ;
				else 		                $sSqlWhere .= $sPageTable.'.page_title >' . $dbr->addQuotes($sTitleGE) ;
			}
            $sSqlWhere .= ')';
        }

        // TitleLE ...
        if ( $sTitleLE != '' ) {
            $sSqlWhere .= ' AND (';
			if (substr($sTitleLE,0,2)=='=_') {
				if ($acceptOpenReferences) 	$sSqlWhere .= 'pl_title <=' . $dbr->addQuotes(substr($sTitleLE,2)) ;
				else 		                $sSqlWhere .= $sPageTable.'.page_title <=' . $dbr->addQuotes(substr($sTitleLE,2)) ;
			} else {
				if ($acceptOpenReferences) 	$sSqlWhere .= 'pl_title <' . $dbr->addQuotes($sTitleLE) ;
				else 		                $sSqlWhere .= $sPageTable.'.page_title <' . $dbr->addQuotes($sTitleLE) ;
			}
            $sSqlWhere .= ')';
        }

        // TitleMatch ...
        if ( count($aTitleMatch)>0 ) {
            $sSqlWhere .= ' AND (';
            $n=0;
            foreach ($aTitleMatch as $link) {
                if ($n>0) $sSqlWhere .= ' OR ';
                if ($acceptOpenReferences) {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'LOWER(CAST(pl_title AS char))' . $sTitleMatchMode . strtolower($dbr->addQuotes($link)) ;
                    else				$sSqlWhere .= 'pl_title'        . $sTitleMatchMode .           $dbr->addQuotes($link) ;
                } else {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'LOWER(CAST(' . $sPageTable.'.page_title AS char))' . $sTitleMatchMode . strtolower($dbr->addQuotes($link)) ;
                    else				$sSqlWhere .= $sPageTable.'.page_title' . $sTitleMatchMode .  $dbr->addQuotes($link) ;
                }
                $n++;
            }
            $sSqlWhere .= ')';
        }

        // NotTitleMatch ...
        if ( count($aNotTitleMatch)>0 ) {
            $sSqlWhere .= ' AND NOT (';
            $n=0;
            foreach ($aNotTitleMatch as $link) {
                if ($n>0) $sSqlWhere .= ' OR ';
                if ($acceptOpenReferences) {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'LOWER(CAST(pl_title AS char))' . $sNotTitleMatchMode . 'LOWER(' . $dbr->addQuotes($link) . ')';
                    else				$sSqlWhere .= 'pl_title' . $sNotTitleMatchMode . $dbr->addQuotes($link);
                } else {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'LOWER(CAST('.$sPageTable.'.page_title AS char))' . $sNotTitleMatchMode . 'LOWER(' . $dbr->addQuotes($link) .')';
                    else				$sSqlWhere .= $sPageTable.'.page_title' . $sNotTitleMatchMode . $dbr->addQuotes($link);
                }
                $n++;
            }
            $sSqlWhere .= ')';
        }

        // rev_minor_edit IS
        if( isset($sMinorEdits) && $sMinorEdits == 'exclude' )
            $sSqlWhere .= ' AND rev_minor_edit=0';
        // page_is_redirect IS ...
        if (!$acceptOpenReferences) {
            switch ($sRedirects) {
                case 'only':
                    $sSqlWhere .= ' AND '.$sPageTable.'.page_is_redirect=1';
                    break;
                case 'exclude':
                    $sSqlWhere .= ' AND '.$sPageTable.'.page_is_redirect=0';
                    break;
            }
        }

        // page_id=rev_page (if revision table required)
        $sSqlWhere .= $sSqlCond_page_rev;

        if ($iMinRevisions != null) {
			$sSqlWhere .= " and ((SELECT count(rev_aux2.rev_page) FROM revision AS rev_aux2 WHERE rev_aux2.rev_page=page.page_id) >= $iMinRevisions)";
    	}
        if ($iMaxRevisions != null) {
			$sSqlWhere .= " and ((SELECT count(rev_aux3.rev_page) FROM revision AS rev_aux3 WHERE rev_aux3.rev_page=page.page_id) <= $iMaxRevisions)";
    	}

        // count(all categories) <= max no of categories
        $sSqlWhere .= $sSqlCond_MaxCat;

        // check against forbidden namespaces
		if(is_array($wgNonincludableNamespaces) && array_count_values($wgNonincludableNamespaces) > 0
			&& implode(',', $wgNonincludableNamespaces)!='') {
	        $sSqlWhere .= ' AND ' .$sPageTable. '.page_namespace NOT IN (' . implode(',', $wgNonincludableNamespaces) . ')';
        }

        // page_id=pl.pl_from (if pagelinks table required)
        $sSqlWhere .= $sSqlCond_page_pl;

        // page_id=el.el_from (if external links table required)
        $sSqlWhere .= $sSqlCond_page_el;

        // page_id=tpl.tl_from (if templatelinks table required)
        $sSqlWhere .= $sSqlCond_page_tpl;

        if ( isset($sArticleCategory) && $sArticleCategory !== null ) {
            $sSqlWhere .= " AND $sPageTable.page_title IN (
                SELECT p2.page_title
                FROM $sPageTable p2
                INNER JOIN $sCategorylinksTable clstc ON (clstc.cl_from = p2.page_id AND clstc.cl_to = ".$dbr->addQuotes($sArticleCategory)." )
                WHERE p2.page_namespace = 0
                ) ";
        }

		if( function_exists('efLoadFlaggedRevs') ) {
			$filterSet = array('only','exclude');
			# Either involves the same JOIN here...
			if( in_array($sStable,$filterSet) || in_array($sQuality,$filterSet) ) {
				$flaggedpages = $dbr->tableName( 'flaggedpages' );
				$sSqlSelectFrom .= " LEFT JOIN $flaggedpages ON page_id = fp_page_id";
			}
			switch( $sStable )
			{
				case 'only':
					$sSqlWhere .= ' AND fp_stable IS NOT NULL ';
					break;
				case 'exclude':
					$sSqlWhere .= ' AND fp_stable IS NULL ';
					break;
			}
			switch( $sQuality )
			{
				case 'only':
					$sSqlWhere .= ' AND fp_quality >= 1';
					break;
				case 'exclude':
					$sSqlWhere .= ' AND fp_quality = 0';
					break;
			}
		}

        // GROUP BY ...
        if ($sSqlGroupBy!='') {
            $sSqlWhere .= ' GROUP BY '.$sSqlGroupBy . ' ';
        }

        // ORDER BY ...
        if ($aOrderMethods[0]!='' && $aOrderMethods[0]!='none') {
            $sSqlWhere .= ' ORDER BY ';
            foreach($aOrderMethods as $i => $sOrderMethod) {

                if($i > 0) $sSqlWhere .= ', ';

                switch ($sOrderMethod) {
                    case 'category':
                        $sSqlWhere .= 'cl_head.cl_to';
                        break;
                    case 'categoryadd':
                        $sSqlWhere .= 'cl0.cl_timestamp';
                        break;
                    case 'counter':
                        $sSqlWhere .= 'page_counter';
                        break;
                    case 'size':
                        $sSqlWhere .= 'page_len';
                        break;
                    case 'firstedit':
                        $sSqlWhere .= 'rev_timestamp';
                        break;
                    case 'lastedit':
						// extension:intersection used to sort by page_touched although the field is called 'lastedit'
						if (ExtDynamicPageList::$behavingLikeIntersection) 	$sSqlWhere .= 'page_touched';
						else 												$sSqlWhere .= 'rev_timestamp';
                        break;
                    case 'pagetouched':
                        $sSqlWhere .= 'page_touched';
                        break;
                    case 'sortkey':
                    case 'title':
                    case 'pagesel':
                        $sSqlWhere .= 'sortkey';
                        break;
                    case 'titlewithoutnamespace':
						if ($acceptOpenReferences)	$sSqlWhere .= "pl_title";
						else 						$sSqlWhere .= "page_title";
                        break;
                    case 'user':
                        // rev_user_text can discriminate anonymous users (e.g. based on IP), rev_user cannot (=' 0' for all)
                        $sSqlWhere .= 'rev_user_text';
                        break;
					default:
                }
            }
            if ($sOrder == 'descending')  	$sSqlWhere .= ' DESC';
            else			                $sSqlWhere .= ' ASC';
        }

        if ($sAllRevisionsSince!='' || $sAllRevisionsBefore!='') {
			if ($aOrderMethods[0]=='' || $aOrderMethods[0]=='none') $sSqlWhere .= ' ORDER BY ';
			else 													$sSqlWhere .= ', ';
			$sSqlWhere .= 'rev_id DESC';
		}

        // LIMIT ....
        // we must switch off LIMITS when going for categories as output goal (due to mysql limitations)
        if ( (!ExtDynamicPageList::$allowUnlimitedResults || $iCount>=0) && $sGoal != 'categories' ) {
    		$sSqlWhere .= " LIMIT $iOffset, ";
			if ($iCount<0) $iCount=intval(ExtDynamicPageList::$options['count']['default']);
			$sSqlWhere .= $iCount;
		}

        // when we go for a list of categories as result we transform the output of the normal query into a subquery
        // of a selection on the categorylinks

        if ($sGoal=='categories') {
            $sSqlSelectFrom = 'SELECT DISTINCT cl3.cl_to FROM '.$sCategorylinksTable.' AS cl3 WHERE cl3.cl_from IN ( ' .
                                preg_replace('/SELECT +DISTINCT +.* FROM /','SELECT DISTINCT '.$sPageTable.'.page_id FROM ',$sSqlSelectFrom);
            if ($sOrder == 'descending')	$sSqlWhere .= ' ) ORDER BY cl3.cl_to DESC';
            else							$sSqlWhere .= ' ) ORDER BY cl3.cl_to ASC';
        }


    // ###### DUMP SQL QUERY ######
        if ($logger->iDebugLevel >=3) {
            //DEBUG: output SQL query
            $output .= "DPL debug -- Query=<br />\n<tt>".$sSqlSelectFrom . $sSqlWhere."</tt>\n\n";
        }

		// Do NOT proces the SQL command if debug==6; this is useful if the SQL statement contains bad code
        if ($logger->iDebugLevel ==6) {
            return $output;
        }


    // ###### PROCESS SQL QUERY ######

        try {
            $res = $dbr->query($sSqlSelectFrom . $sSqlWhere);
        }
        catch (Exception $e) {
            $result = "The DPL extension (version ".ExtDynamicPageList::$DPLVersion.") produced a SQL statement which lead to a Database error.<br>\n"
                    ."The reason may be an internal error of DPL or an error which you made,<br />\n"
                    ."especially when using DPL options like titleregexp.<br />\n"
                    ."Query text is:<br />\n<tt>".$sSqlSelectFrom . $sSqlWhere."</tt>\n\n"
                    ."Error message is:<br />\n<tt>".$dbr->lastError()."</tt>\n\n";
            return $result;
        }

        // Wikia change - mark transactions that trigger DPL queries (PLATFORM-1074)
        Transaction::setAttribute( Transaction::PARAM_DPL, true );

        if ($dbr->numRows( $res ) <= 0) {
			$header = str_replace('%TOTALPAGES%','0',str_replace('%PAGES%','0',$sNoResultsHeader));
            if ($sNoResultsHeader != '')	$output .= 	str_replace( '\n', "\n", str_replace( "¶", "\n", $header));
			$footer = str_replace('%TOTALPAGES%','0',str_replace('%PAGES%','0',$sNoResultsFooter));
            if ($sNoResultsFooter != '')	$output .= 	str_replace( '\n', "\n", str_replace( "¶", "\n", $footer));
            if ($sNoResultsHeader == '' && $sNoResultsFooter == '')	$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_NORESULTS);
            $dbr->freeResult( $res );
            return $output;
        }

        $sk = $wgUser->getSkin();
        // generate title for Special:Contributions (used if adduser=true)
        $sSpecContribs = '[[:Special:Contributions|Contributions]]';

        $aHeadings = array(); // maps heading to count (# of pages under each heading)
        $aArticles = array();

        // pick some elements by random
        $pick[0]=true;

        if (isset($iRandomCount)) {
            $nResults = $dbr->numRows( $res );
            if (isset($iRandomSeed)) mt_srand($iRandomSeed);
            else mt_srand((float) microtime() * 10000000);
            if ($iRandomCount>$nResults) $iRandomCount = $nResults;
            $r=0;
            while (true) {
                $rnum = mt_rand(1,$nResults);
                if (!isset($pick[$rnum])) {
                    $pick[$rnum] = true;
                    $r++;
                    if ($r>=$iRandomCount) break;
                }
            }
        }
            $thisTitle = $parser->getTitle();

        $iArticle = 0;
		$firstNamespaceFound = '';
		$firstTitleFound = '';
		$lastNamespaceFound = '';
		$lastTitleFound = '';

        foreach ($res as $row) {
            $iArticle++;

            // in random mode skip articles which were not chosen
            if (isset($iRandomCount) && !isset($pick[$iArticle]))  continue;

            if ($sGoal=='categories') {
                $pageNamespace = 14;  // CATEGORY
                $pageTitle     = $row->cl_to;
            } else if ($acceptOpenReferences) {
	            if (count($aImageContainer)>0) {
    	            $pageNamespace = 6;
        	        $pageTitle     = $row->il_to;
	            }
	            else {
	                // maybe non-existing title
    	            $pageNamespace = $row->pl_namespace;
        	        $pageTitle     = $row->pl_title;
    	        }
            }
            else {
	            // existing PAGE TITLE
                $pageNamespace = $row->page_namespace;
                $pageTitle     = $row->page_title;
            }

            // if subpages are to be excluded: skip them
            if (!$bIncludeSubpages && (!(strpos($pageTitle,'/')===false))) continue;

            $title = Title::makeTitle($pageNamespace, $pageTitle);

            // block recursion: avoid to show the page which contains the DPL statement as part of the result
            if ( $bSkipThisPage && $thisTitle->equals( $title ) ) {
                // $output.= 'BLOCKED '.$thisTitle->getText().' DUE TO RECURSION'."\n";
                continue;
            }

            $dplArticle = new DPLArticle( $title, $pageNamespace );
            //PAGE LINK
            $sTitleText = $title->getText();
            if ($bShowNamespace) $sTitleText = $title->getPrefixedText();
            if ($aReplaceInTitle[0]!='') $sTitleText = preg_replace($aReplaceInTitle[0],$aReplaceInTitle[1],$sTitleText);

            //chop off title if "too long"
			if( isset($iTitleMaxLen) && (strlen($sTitleText) > $iTitleMaxLen) )  $sTitleText = substr($sTitleText, 0, $iTitleMaxLen) . '...';
            if ($bShowCurID && isset($row->page_id)) {
				//$articleLink = '<html>'.$sk->makeKnownLinkObj($title, htmlspecialchars($sTitleText),'curid='.$row->page_id).'</html>';
				$articleLink = '[{{fullurl:'.$title->getText().'|curid='.$row->page_id.'}} '.htmlspecialchars($sTitleText).']';
            } else if (!$bEscapeLinks || ($pageNamespace!=14 && $pageNamespace!=6) ) {
                // links to categories or images need an additional ":"
                $articleLink = '[['.$title->getPrefixedText().'|'.$wgContLang->convert( $sTitleText ).']]';
			} else {
				// $articleLink = '<html>'.$sk->makeKnownLinkObj($title, htmlspecialchars($sTitleText)).'</html>';
				$articleLink = '[{{fullurl:'.$title->getText().'}} '.htmlspecialchars($sTitleText).']';
            }

            $dplArticle->mLink = $articleLink;

            //get first char used for category-style output
            if( isset($row->sortkey) ) {
                $dplArticle->mStartChar = $wgContLang->convert($wgContLang->firstChar($row->sortkey));
            }
			if( isset($row->sortkey) ) {
				$dplArticle->mStartChar = $wgContLang->convert($wgContLang->firstChar($row->sortkey));
			} else {
				$dplArticle->mStartChar = $wgContLang->convert($wgContLang->firstChar($pageTitle));
			}

            // page_id
            if (isset($row->page_id)) $dplArticle->mID = $row->page_id;
			else					  $dplArticle->mID = 0;

            // external link
            if (isset($row->el_to))	$dplArticle->mExternalLink = $row->el_to;

            //SHOW PAGE_COUNTER
            if( isset($row->page_counter) )
                $dplArticle->mCounter = $row->page_counter;

            //SHOW PAGE_SIZE
            if( isset($row->page_len) )
                $dplArticle->mSize = $row->page_len;
            //STORE initially selected PAGE
            if ( count($aLinksTo)>0  || count($aLinksFrom)>0 ) {
                if (!isset($row->sel_title)) {
                    $dplArticle->mSelTitle     = 'unknown page';
                    $dplArticle->mSelNamespace = 0;
                } else {
                    $dplArticle->mSelTitle     = $row->sel_title;
                    $dplArticle->mSelNamespace = $row->sel_ns;
                }
            }

			//STORE selected image
            if ( count($aImageUsed)>0 ) {
                if (!isset($row->image_sel_title)) {
                    $dplArticle->mImageSelTitle     = 'unknown image';
                } else {
                    $dplArticle->mImageSelTitle     = $row->image_sel_title;
                }
            }

            if ($bGoalIsPages) {
                //REVISION SPECIFIED
                if( $sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince !='') {
                    $dplArticle->mRevision = $row->rev_id;
                    $dplArticle->mUser = $row->rev_user_text;
                    $dplArticle->mDate = $row->rev_timestamp;
                }

                //SHOW "PAGE_TOUCHED" DATE, "FIRSTCATEGORYDATE" OR (FIRST/LAST) EDIT DATE
                if($bAddPageTouchedDate) 								$dplArticle->mDate = $row->page_touched;
                elseif ($bAddFirstCategoryDate)							$dplArticle->mDate = $row->cl_timestamp;
                elseif ($bAddEditDate && isset($row->rev_timestamp))	$dplArticle->mDate = $row->rev_timestamp;
                elseif ($bAddEditDate && isset($row->page_touched))		$dplArticle->mDate = $row->page_touched;

				// time zone adjustment
                if ($dplArticle->mDate!='') {
					$dplArticle->mDate= $wgLang->userAdjust($dplArticle->mDate);
				}

                if ($dplArticle->mDate!='' && $sUserDateFormat!='') {
					// we apply the userdateformat
					$dplArticle->myDate = gmdate($sUserDateFormat,wfTimeStamp(TS_UNIX,$dplArticle->mDate));
                }
                // CONTRIBUTION, CONTRIBUTOR
                if($bAddContribution) {
                    $dplArticle->mContribution = $row->contribution;
                    $dplArticle->mContributor  = $row->contributor;
                    $dplArticle->mContrib      = substr('*****************',0,round(log($row->contribution)));
                }


                //USER/AUTHOR(S)
                // because we are going to do a recursive parse at the end of the output phase
                // we have to generate wiki syntax for linking to a user´s homepage
                if($bAddUser || $bAddAuthor || $bAddLastEditor || $sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince != '') {
                    $dplArticle->mUserLink  = '[[User:'.$row->rev_user_text.'|'.$row->rev_user_text.']]';
                    $dplArticle->mUser = $row->rev_user_text;
                    $dplArticle->mComment = $row->rev_comment;
                }

                //CATEGORY LINKS FROM CURRENT PAGE
                if($bAddCategories && $bGoalIsPages && ($row->cats != '')) {
                    $artCatNames = explode(' | ', $row->cats);
                    foreach($artCatNames as $artCatName) {
                        $dplArticle->mCategoryLinks[] = '[[:Category:'.$artCatName.'|'.str_replace('_',' ',$artCatName).']]';
                        $dplArticle->mCategoryTexts[] = str_replace('_',' ',$artCatName);
                    }
                }
                // PARENT HEADING (category of the page, editor (user) of the page, etc. Depends on ordermethod param)
                if($sHListMode != 'none') {
                    switch($aOrderMethods[0]) {
                        case 'category':
                            //count one more page in this heading
                            $aHeadings[$row->cl_to] = isset($aHeadings[$row->cl_to]) ? $aHeadings[$row->cl_to] + 1 : 1;
                            if($row->cl_to == '') {
                                //uncategorized page (used if ordermethod=category,...)
                                $dplArticle->mParentHLink = '[[:Special:Uncategorizedpages|'.wfMsg('uncategorizedpages').']]';
                            } else {
                                $dplArticle->mParentHLink = '[[:Category:'.$row->cl_to.'|'.str_replace('_',' ',$row->cl_to).']]';
                            }
                            break;
                        case 'user':
                            $aHeadings[$row->rev_user_text] = isset($aHeadings[$row->rev_user_text]) ? $aHeadings[$row->rev_user_text] + 1 : 1;
                            if($row->rev_user == 0) { //anonymous user
                                $dplArticle->mParentHLink = '[[User:'.$row->rev_user_text.'|'.$row->rev_user_text.']]';

                            } else {
                                $dplArticle->mParentHLink = '[[User:'.$row->rev_user_text.'|'.$row->rev_user_text.']]';
                            }
                            break;
                    }
                }
            }

            $aArticles[] = $dplArticle;
        }
        $dbr->freeResult( $res );
		$rowcount = -1;
		if ( $sSqlCalcFoundRows != '') {
			$res = $dbr->query('SELECT FOUND_ROWS() AS rowcount');
			$row = $dbr->fetchObject ( $res );
			$rowcount = $row->rowcount;
			$dbr->freeResult( $res );
		}

		// backward scrolling: if the user specified titleLE we reverse the output order
		if ($sTitleLE != '' && $sTitleGE =='' && $sOrder=='descending' ) $aArticles = array_reverse($aArticles);

		// special sort for card suits (Bridge)
		if ($bOrderSuitSymbols) self::cardSuitSort($aArticles);


    // ###### SHOW OUTPUT ######

        $listMode = new DPLListMode($sPageListMode, $aSecSeparators, $aMultiSecSeparators, $sInlTxt, $sListHtmlAttr,
                                    $sItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);

        $hListMode = new DPLListMode($sHListMode, $aSecSeparators, $aMultiSecSeparators, '', $sHListHtmlAttr,
                                      $sHItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);

        $dpl = new DPL($aHeadings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $aArticles,
                       $aOrderMethods[0], $hListMode, $listMode, $bEscapeLinks, $bAddExternalLink, $bIncPage, $iIncludeMaxLen,
                       $aSecLabels, $aSecLabelsMatch, $aSecLabelsNotMatch, $bIncParsed, $parser, $logger, $aReplaceInTitle,
                       $iTitleMaxLen, $defaultTemplateSuffix, $aTableRow, $bIncludeTrim, $iTableSortCol, $sUpdateRules, $sDeleteRules);

		if ($rowcount == -1) $rowcount = $dpl->getRowCount();
        $dplResult = $dpl->getText();
        $header='';
        if ($sOneResultHeader != '' && $rowcount==1) {
            $header = str_replace('%TOTALPAGES%',$rowcount,str_replace('%PAGES%',1,$sOneResultHeader));
        } else if ($rowcount==0) {
			$header = str_replace('%TOTALPAGES%',$rowcount,str_replace('%PAGES%',$dpl->getRowCount(),$sNoResultsHeader));
            if ($sNoResultsHeader != '')	$output .= 	str_replace( '\n', "\n", str_replace( "¶", "\n", $header));
			$footer = str_replace('%TOTALPAGES%',$rowcount,str_replace('%PAGES%',$dpl->getRowCount(),$sNoResultsFooter));
            if ($sNoResultsFooter != '')	$output .= 	str_replace( '\n', "\n", str_replace( "¶", "\n", $footer));
            if ($sNoResultsHeader == '' && $sNoResultsFooter == '')	$output .= $logger->escapeMsg(ExtDynamicPageList::WARN_NORESULTS);
        }
        else {
            if ($sResultsHeader != '')	$header = str_replace('%TOTALPAGES%',$rowcount,str_replace('%PAGES%',$dpl->getRowCount(),$sResultsHeader));
        }
        $header = str_replace( '\n', "\n", str_replace( "¶", "\n", $header ));
        $header = str_replace('%VERSION%', ExtDynamicPageList::$DPLVersion,$header);
        $footer='';
        if ($sOneResultFooter != '' && $rowcount==1) {
            $footer = str_replace('%PAGES%',1,$sOneResultFooter);
        } else {
            if ($sResultsFooter != '')	$footer =  str_replace('%TOTALPAGES%',$rowcount,str_replace('%PAGES%',$dpl->getRowCount(),$sResultsFooter));
        }
        $footer = str_replace( '\n', "\n", str_replace( "¶", "\n", $footer ));
        $footer = str_replace('%VERSION%', ExtDynamicPageList::$DPLVersion, $footer);

		// replace %DPLTIME% by execution time and timestamp in header and footer
		$nowTimeStamp = self::prettyTimeStamp(date('YmdHis'));
		$dplElapsedTime= sprintf('%.3f sec.',microtime(true)-$dplStartTime);
        $header = str_replace('%DPLTIME%', "$dplElapsedTime ($nowTimeStamp)", $header);
        $footer = str_replace('%DPLTIME%', "$dplElapsedTime ($nowTimeStamp)", $footer);

		// replace %LASTTITLE% / %LASTNAMESPACE% by the last title found in header and footer
		if (($n=count($aArticles)) > 0) {
			$firstNamespaceFound = str_replace(' ','_',$aArticles[0]->mTitle->getNamespace());
			$firstTitleFound 	 = str_replace(' ','_',$aArticles[0]->mTitle->getText());
			$lastNamespaceFound  = str_replace(' ','_',$aArticles[$n-1]->mTitle->getNamespace());
			$lastTitleFound 	 = str_replace(' ','_',$aArticles[$n-1]->mTitle->getText());
		}
        $header = str_replace('%FIRSTNAMESPACE%', 	$firstNamespaceFound, $header);
        $footer = str_replace('%FIRSTNAMESPACE%', 	$firstNamespaceFound, $footer);
        $header = str_replace('%FIRSTTITLE%', 		$firstTitleFound, $header);
        $footer = str_replace('%FIRSTTITLE%', 		$firstTitleFound, $footer);
        $header = str_replace('%LASTNAMESPACE%', 	$lastNamespaceFound, $header);
        $footer = str_replace('%LASTNAMESPACE%', 	$lastNamespaceFound, $footer);
        $header = str_replace('%LASTTITLE%', 		$lastTitleFound, $header);
        $footer = str_replace('%LASTTITLE%', 		$lastTitleFound, $footer);
        $header = str_replace('%SCROLLDIR%', 		$scrollDir, $header);
        $footer = str_replace('%SCROLLDIR%', 		$scrollDir, $footer);

        $output .= $header . $dplResult . $footer;

		self::defineScrollVariables($firstNamespaceFound,$firstTitleFound,$lastNamespaceFound,$lastTitleFound,
			$scrollDir,$iCount,"$dplElapsedTime ($nowTimeStamp)",$rowcount,$dpl->getRowCount());

		// save generated wiki text to dplcache page if desired
		if ( $DPLCache != '' ) {
			// save data in chosen storage
			switch ($DPLCacheStorage) {
				case 'files':
					if ( !is_writeable( $cacheFile ) ) {
						wfMkdirParents( dirname( $cacheFile ) );
					} elseif ( ( $bDPLRefresh ||
							$wgRequest->getVal( 'action', 'view' ) == 'submit' ) &&
						strpos( $DPLCache, '/' ) > 0 && strpos( $DPLCache, '..' ) === false
					) {
						// if the cache file contains a path and the user requested a refresh (or saved the file) we delete all brothers
						wfRecursiveRemoveDir( dirname( $cacheFile ) );
						wfMkdirParents( dirname( $cacheFile ) );
					}
					$cFile = fopen( $cacheFile, 'w' );
					fwrite( $cFile, $originalInput );
					fwrite( $cFile, "+++\n" );
					fwrite( $cFile, $output );
					fclose( $cFile );
					break;
				case 'memcache':
					// create the unique cache key (replace spaces with underscores)
					$cacheKey = self::getMemcacheKey($DPLCache);
					$cacheData = array(
						'timestamp' => time(),
						'input' => $originalInput,
						'output' => $output,
					);
					$wgMemc->set($cacheKey,$cacheData,$iDPLCachePeriod);
					break;
			}
			$cacheTimeStamp = self::prettyTimeStamp( date( 'YmdHis' ) );
			$dplElapsedTime = time() - $dplStartTime;
			if ( $logger->iDebugLevel >= 2 ) {
				$output .= "{{Extension DPL cache|mode=update|page={{FULLPAGENAME}}|cache=$DPLCache|date=$cacheTimeStamp|age=0|now=" .
					date( 'H:i:s' ) . "|dpltime=$dplElapsedTime|offset=$iOffset}}";
			}
			/** Wikia change begin - never disable parser cache (CE-1066) **/
			// $parser->disableCache();
			/** Wikia change end **/
		}

		// update dependencies to CacheAPI if DPL is to respect the MW ParserCache and the page containing the DPL query is changed

		if (ExtDynamicPageList::$useCacheAPI && $bAllowCachedResults && $wgRequest->getVal('action','view')=='submit') {
/*
			CacheAPI::remDependencies( $parser->mTitle->getArticleID());

			// add category dependencies

			$conditionTypes = array ( CACHETYPE_CATEGORY );
			$conditions = array();
			$conditions[0] = array();
			$categorylist = array();
			foreach ($aIncludeCategories as $categorygroup) {
				$c=0;
				foreach ($categorygroup as $category) {
					if ($c==0) $conditions[0][]= $category;
					$c++;
				}
			}

			// add template dependencies

			// add link dependencies

			// add general dependencies

			// CacheAPI::addDependencies ( $parser->mTitle->getArticleID(), $conditionTypes, $conditions);
*/
		}


        // The following requires an extra parser step which may consume some time
        // we parse the DPL output and save all references found in that output in a global list
        // in a final user exit after the whole document processing we eliminate all these links
        // we use a local parser to avoid interference with the main parser

        if ($bReset[4] || $bReset[5] || $bReset[6] || $bReset[7] ) {
            // register a hook to reset links which were produced during parsing DPL output
            global $wgHooks;
            if (!isset($wgHooks['ParserAfterTidy']) ||
                !(in_array('ExtDynamicPageList::endEliminate',$wgHooks['ParserAfterTidy']) ||
                  in_array( array( 'ExtDynamicPageList', 'endEliminate'),$wgHooks['ParserAfterTidy'],true))) {
   	            $wgHooks['ParserAfterTidy'][]   = 'ExtDynamicPageList' . '__endEliminate';
            }
            $parserOutput= $localParser->parse($output,$parser->mTitle,$parser->mOptions);
        }
        if ($bReset[4]) {	// LINKS
            // we trigger the mediawiki parser to find links, images, categories etc. which are contained in the DPL output
            // this allows us to remove these links from the link list later
            // If the article containing the DPL statement itself uses one of these links they will be thrown away!
            ExtDynamicPageList::$createdLinks[0]=array();
            foreach ($parserOutput->getLinks() as $nsp => $link) {
                ExtDynamicPageList::$createdLinks[0][$nsp]=$link;
            }
        }
        if ($bReset[5]) {	// TEMPLATES
            ExtDynamicPageList::$createdLinks[1]=array();
            foreach ($parserOutput->getTemplates() as $nsp => $tpl) {
                ExtDynamicPageList::$createdLinks[1][$nsp]=$tpl;
            }
        }
        if ($bReset[6]) {	// CATEGORIES
               ExtDynamicPageList::$createdLinks[2] = $parserOutput->mCategories;
        }
        if ($bReset[7]) {	// IMAGES
            ExtDynamicPageList::$createdLinks[3] = $parserOutput->mImages;
        }

        return $output;
    }


	// auxiliary functions ===============================================================================


	// get a list of valid page names; returns true if valid args found
	private static function getPageNameList($cmd, $text, &$aLinks, &$bSelectionCriteriaFound, $logger, $mustExist=true) {
		$theLinks = array();
		$errorMsg='';
		$pages = explode('|', trim($text));
		foreach($pages as $page) {
			if (($page=trim($page))=='') continue;
			// sequences like %1a would be translated to hex chars; we avoid this by escaping the cahr after the %
			$page=str_replace('%','%\\',$page);
			if ($page[strlen($page)-1]=='\\') $page=substr($page,0,strlen($page)-1);
			if ($mustExist) {
				if (!($theTitle = Title::newFromText($page))) {
					$errorMsg .= $logger->msgWrongParam($cmd, $page)."<br/>\n";
					continue;
				}
				$theLinks[] = $theTitle;
			}
			else {
				$theLinks[] = $page;
			}
		}
		if (!empty($theLinks)) {
			$aLinks[] = $theLinks;
			$bSelectionCriteriaFound=true;
		}
		return $errorMsg;
	}

    // create keys for TableRow which represent the structure of the "include=" arguments
    private static function updateTableRowKeys(&$aTableRow,$aSecLabels) {
        $tableRow = $aTableRow;
        $aTableRow=array();
        $groupNr=-1;
        $t= -1;
        foreach ($aSecLabels as $label) {
            $t++;
            $groupNr++;
            $cols = explode('}:',$label);
            if (count($cols)<=1) {
                if (array_key_exists($t,$tableRow)) $aTableRow[$groupNr]=$tableRow[$t];
            }
            else {
                $n=count( explode(':',$cols[1]));
                $colNr=-1;
                $t--;
                for ($i=1;$i<=$n;$i++) {
                    $colNr++;
                    $t++;
                    if (array_key_exists($t,$tableRow)) $aTableRow[$groupNr.'.'.$colNr]=$tableRow[$t];
                }
            }
        }
    }

    private static function validParametersList() {
		$plist='';
		foreach (ExtDynamicPageList::$validParametersForRichnessLevel as $level => $p) {
			$plist .= $p;
			if ($level >= ExtDynamicPageList::$functionalRichness) break;
		}
		return $plist;
	}

    private static function argBoolean($arg) {
        return ($arg=='true' || $arg=='yes' || $arg=='1' || $arg=='on');
    }

    private static function getSubcategories($cat,$sPageTable,$depth) {
        $dbr =& wfGetDB( DB_SLAVE );
        $cats=$cat;
        $res = $dbr->query("SELECT DISTINCT page_title FROM ".$dbr->tableName('page')." INNER JOIN "
                .$dbr->tableName('categorylinks')." AS cl0 ON ".$sPageTable.".page_id = cl0.cl_from AND cl0.cl_to='"
               .str_replace(' ','_',$cat)."'"." WHERE page_namespace='14'");
        foreach ($res as $row) {
			if ($depth>1) {
				$cats .= '|'. self::getSubcategories($row->page_title,$sPageTable,$depth -1) ;
			}
			else {
				$cats .= '|'.$row->page_title;
			}
        }
        $dbr->freeResult( $res );
        return $cats;
    }

    private static function prettyTimeStamp($t) {
	    return substr($t,0,4).'/'.substr($t,4,2).'/'.substr($t,6,2).'  '.substr($t,8,2).':'.substr($t,10,2).':'.substr($t,12,2);
    }

    private static function durationTime($t) {
	    if ($t<60) return "00:00:".str_pad($t,2,"0",STR_PAD_LEFT);
	    if ($t<3600) return "00:".str_pad(floor($t/60),2,"0",STR_PAD_LEFT).':'.str_pad(floor(fmod($t,60)),2,"0",STR_PAD_LEFT);
	    if ($t<86400) return str_pad(floor($t/3600),2,"0",STR_PAD_LEFT).':'.str_pad(floor(fmod(floor($t/60),60)),2,"0",STR_PAD_LEFT).':'.str_pad(fmod($t,60),2,"0",STR_PAD_LEFT);
		if ($t<2*86400) return "1 day";
	    return floor($t/86400). ' days';
    }

	private static function resolveUrlArg($input,$arg) {
		global $wgRequest;
		$dplArg = $wgRequest->getVal($arg,'');
		if ($dplArg=='') {
			$input=preg_replace('/\{%'.$arg.':(.*)%\}/U', '\1'    ,$input);
			return str_replace('{%'.$arg.'%}', 		     ''       ,$input);
		} else {
			$input=preg_replace('/\{%'.$arg.':.*%\}/U  ', $dplArg ,$input);
			return str_replace('{%'.$arg.'%}'           , $dplArg ,$input);
		}
	}

	// this function uses the Variables extension to provide URL-arguments like &DPL_xyz=abc
	// in the form of a variable which can be accessed as {{#var:xyz}} if ExtensionVariables is installed
	private static function getUrlArgs() {
		global $wgRequest, $wgExtVariables;
		$args = $wgRequest->getValues();
		foreach ($args as $argName => $argValue) {
			DPLVariables::setVar(array('','',$argName,$argValue));
		}
		if (!isset($wgExtVariables)) return;
		$args = $wgRequest->getValues();
		$dummy='';
		foreach ($args as $argName => $argValue) {
			$wgExtVariables->vardefine($dummy,$argName,$argValue);
		}
	}

	// this function uses the Variables extension to provide navigation aids like DPL_firstTitle, DPL_lastTitle, DPL_findTitle
	// these variables can be accessed as {{#var:DPL_firstTitle}} etc. if ExtensionVariables is installed
	private static function defineScrollVariables($firstNamespace,$firstTitle,$lastNamespace,$lastTitle,
		$scrollDir,$dplCount,$dplElapsedTime,$totalPages,$pages) {
		global $wgExtVariables;
		DPLVariables::setVar(array('','','DPL_firstNamespace',$firstNamespace));
		DPLVariables::setVar(array('','','DPL_firstTitle',$firstTitle));
		DPLVariables::setVar(array('','','DPL_lastNamespace',$lastNamespace));
		DPLVariables::setVar(array('','','DPL_lastTitle',$lastTitle));
		DPLVariables::setVar(array('','','DPL_scrollDir' ,$scrollDir));
		DPLVariables::setVar(array('','','DPL_time' ,$dplElapsedTime));
		DPLVariables::setVar(array('','','DPL_count' ,$dplCount));
		DPLVariables::setVar(array('','','DPL_totalPages' ,$totalPages));
		DPLVariables::setVar(array('','','DPL_pages' ,$pages));

		if (!isset($wgExtVariables)) return;
		$dummy='';
		$wgExtVariables->vardefine($dummy,'DPL_firstNamespace',$firstNamespace);
		$wgExtVariables->vardefine($dummy,'DPL_firstTitle',$firstTitle);
		$wgExtVariables->vardefine($dummy,'DPL_lastNamespace',$lastNamespace);
		$wgExtVariables->vardefine($dummy,'DPL_lastTitle',$lastTitle);
		$wgExtVariables->vardefine($dummy,'DPL_scrollDir' ,$scrollDir);
		$wgExtVariables->vardefine($dummy,'DPL_time' ,$dplElapsedTime);
		$wgExtVariables->vardefine($dummy,'DPL_count' ,$dplCount);
		$wgExtVariables->vardefine($dummy,'DPL_totalPages' ,$totalPages);
		$wgExtVariables->vardefine($dummy,'DPL_pages' ,$pages);
	}

	/**
        * turn <html> -> &lt;html&gt;
        * older versions of DPL used $wgRawHtml; the current version does NOT use rawHtml,
		* so prevention against <html> is no longer needed. But should not do no harm anyway.
		* So it is left in here.
        * Note, $text should be from user. It should never contain <html> in it unless someone is
        * being naughty.
    */
    private static function killHtmlTags( $text ) {
		//escape <html>
		$text = preg_replace('/<([^>]*[hH][tT][mM][lL][^>]*)>/', '&lt;$1&gt;', $text);
		//if we still have <html>, someone is doing something weird, like double nesting to get
		//around the escaping - just escape it all. <html> should never be here unless someone
		// is being naughty, so it shouldn't cause problems.
		if (preg_match('/<[^>]*[hH][tT][mM][lL][^>]*>/', $text)) {
			$text = htmlspecialchars($text);
		}
		return $text;
    }

	private static function cardSuitSort(&$articles) {
		$skey = array();
		for ($a=0;$a<count($articles);$a++) {
			$title = preg_replace('/.*:/','',$articles[$a]->mTitle);
			$token = preg_split('/ - */',$title);
			$newkey='';
			foreach ($token as $tok) {
				$initial = substr($tok,0,1);
				if ($initial>='1' && $initial<='7') {
					$newkey .= $initial;
					$suit = substr($tok,1);
					if ($suit=='♣')			$newkey .= '1';
					else if ($suit=='♦')	$newkey .= '2';
					else if ($suit=='♥')	$newkey .= '3';
					else if ($suit=='♠')	$newkey .= '4';
					else if ($suit=='sa' || $suit == 'SA' || $suit =='nt' || $suit == 'NT')	$newkey .= '5 ';
					else 					$newkey .= $suit;
				}
				else if ($initial == 'P' || $initial == 'p')	$newkey .= '0 ';
				else if ($initial == 'X' || $initial == 'x')	$newkey .= '8 ';
				else											$newkey .= $tok;
			}
			$skey[$a] = "$newkey#$a";
		}
		for ($a=0;$a<count($articles);$a++) {
			$cArticles[$a] = clone($articles[$a]);
		}
		sort($skey);
		for ($a=0;$a<count($cArticles);$a++) {
			$key=intval(preg_replace('/.*#/','',$skey[$a]));
			$articles[$a] = $cArticles[$key];
		}
	}

	private static function getMemcacheKey( $dplCacheId ) {
		return wfMemcKey( 'dplcache', $dplCacheId );
	}

}
