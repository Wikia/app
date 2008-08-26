<?php
/**
 * Main include file for the DynamicPageList2 extension of MediaWiki.
 * This code is released under the GNU General Public License.
 *
 *  Purpose:
 * 	outputs a union of articles residing in a selection of categories and namespaces using configurable output- and ordermethods
 * 
 * Note: DynamicPageList2 is based on DynamicPageList.
 *
 * Usage:
 * 	require_once("extensions/DynamicPageList2.php"); in LocalSettings.php
 * 
 * @addtogroup Extensions
 * @link http://www.mediawiki.org/wiki/Extension:DynamicPageList2 Documentation
 * @author n:en:User:IlyaHaykinson 
 * @author n:en:User:Amgine 
 * @author w:de:Benutzer:Unendlich 
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 0.8.1
 */

/*
 * Current version
 */
define('DPL2_VERSION', '0.8.1');

/**
 * Register the extension with MediaWiki
 */
$wgExtensionFunctions[] = "wfDynamicPageList2";
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'DynamicPageList2',
	'author'         => '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson], [http://en.wikinews.org/wiki/User:Amgine Amgine], [http://de.wikipedia.org/wiki/Benutzer:Unendlich Unendlich], [http://meta.wikimedia.org/wiki/User:Dangerman Cyril Dangerville]',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:DynamicPageList2',
	'description'    => 'hack of the original [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] extension featuring many Improvements',
	'descriptionmsg' => 'dpl2-desc',
  	'version'        => DPL2_VERSION
  );

/**
 * Extension settings 
 */

# Maximum number of categories allowed in the Query
$wgDPL2MaxCategoryCount = 4;

# Minimum number of categories needed in the Query
$wgDPL2MinCategoryCount = 0;

# Maximum number of results to allow
$wgDPL2MaxResultCount = 50;

# Max length to format a list of articles chunked by letter as bullet list
# if list is bigger, columnar format user (same as cutoff arg for
# CategoryPage::formatList())
$wgDPL2CategoryStyleListCutoff = 6;

# Allow unlimited categories in the Query
$wgDPL2AllowUnlimitedCategories = true;

# Allow unlimited results to be shown
$wgDPL2AllowUnlimitedResults = true;

# To be initialized at first use of DPL2, array of all namespaces except
# Media and Special, because we cannot use the DB for these to generate
# dynamic page lists. Cannot be customized !
# Use $wgDPL2Options['namespace'] or $wgDPL2Options['notnamespace'] for customization.
$wgDPL2AllowedNamespaces = NULL;

/**
 * Map parameters to possible values.
 * A 'default' key indicates the default value for the parameter.
 * A 'pattern' key indicates a pattern for regular expressions (that the value must match).
 * For some options (e.g. 'namespace'), possible values are not yet defined
 * but will be if necessary (for debugging)
 */
$wgDPL2Options = array(
	'addcategories' => array('default' => 'false', 'false', 'true'),
	'addpagecounter' => array('default' => 'false', 'false', 'true'),
	'addeditdate' => array('default' => 'false', 'false', 'true'),
	'addfirstcategorydate' => array('default' => 'false', 'false', 'true'),
	'addpagetoucheddate' => array('default' => 'false', 'false', 'true'),
	'adduser' => array('default' => 'false', 'false', 'true'),

	/**
	 * category= Cat11 | Cat12 | ...
	 * category= Cat21 | Cat22 | ...
	 * ...
	 * [Special value] catX='' (empty string without quotes) means pseudo-categoy of Uncategorized pages
	 * Means pages have to be in category (Cat11 OR (inclusive) Cat2 OR...) AND (Cat21 OR Cat22 OR...) AND...
	 * If '+' prefixes the list of categories (e.g. category=+ Cat1 | Cat 2 ...), only these categories can be used as headings in the DPL. See  'headingmode' param.
	 * Magic words allowed.
	 * @todo define 'category' options (retrieve list of categories from 'categorylinks' table?)
	 */
	'category' => NULL,

	/**
	 * Maximum number of results to be displayed.
	 * Empty count value (default) indicates no limit.
	 */
	'count' => array(
		'default' => '',
		'pattern' => '/^\d*$/'
	),

	/**
	 * debug=...
	 * - 0: displays no debug message;
	 * - 1: displays fatal errors only; 
	 * - 2: fatal errors + warnings only;
	 * - 3: every debug message.
	 */
	'debug' => array(
		'default' => '2',
		'0', '1', '2', '3'
	),

	/**
	 * Mode at the heading level with ordermethod on multiple components,
	 * e.g. category heading with ordermethod=category,...: 
	 * html headings (H2, H3, H4), definition list, no heading (none), ordered,
	 * unordered.
	 */
	'headingmode' => array(
		'default' => 'none',
		'H2', 'H3', 'H4', 'definition', 'none', 'ordered', 'unordered'
	),

	/**
	 * Attributes for HTML list items (headings) at the heading level,
	 * depending on 'headingmode' (e.g. 'li' for ordered/unordered)
	 * Not yet applicable to 'headingmode=none | definition | H2 | H3 | H4'.
	 * @todo Make 'hitemattr' param applicable to  'none', 'definition', 'H2', 'H3', 'H4' headingmodes.
	 * Example: hitemattr= class="topmenuli" style="color: red;"
	 */
	'hitemattr' => array('default' => ''),

	/**
	 * Attributes for the HTML list element at the heading/top level, depending
	 * on 'headingmode' (e.g. 'ol' for ordered, 'ul' for unordered, 'dl' for definition)
	 * Not yet applicable to 'headingmode=none'.
	 * @todo Make 'hlistattr' param applicable to  headingmode=none.
	 * Example: hlistattr= class="topmenul" id="dmenu"
	 */
	'hlistattr' => array('default' => ''),

	/**
	 * PAGE TRANSCLUSION: includepage=...
	 *
	 * To include the whole page, use a wildcard:
	 *     includepage =*
	 *
	 * To include sections labeled 'sec1' or 'sec2' or... from the page
	 * (see the doc of the LabeledSectionTransclusion extension for more info)
	 *     includepage = sec1,sec2,..
	 *
	 * To include from the first occurrence of the heading 'heading1'
	 * (resp. 'heading2') until the next heading of the same or lower level.
	 * Note that this comparison is case insensitive. (See http://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion#Transcluding_visual_headings.) :
	 *     includepage = #heading1,#heading2,....
	 *
	 * You can combine the above options:
	 *     includepage= sec1,#heading1,...
	 *
	 * To include nothing from the page (no transclusion), leave empty:
	 * includepage =
	 */
    'includepage' => array('default' => ''),

	/** 
	 * Inline text is some wiki text used to separate list items with 'mode=inline'.
	 */
	'inlinetext' => array(
		'default' => '&nbsp;-&nbsp;'
	),

	/**
	 * Attributes for HTML list items, depending on 'mode':
	 *     - 'li' for ordered/unordered
	 *     - 'span' for others).
	 *
	 * Not applicable to 'mode=category'.
	 *
	 * @todo Make 'itemattr' param applicable to 'mode=category'.
	 *
	 * Example:
	 *     itemattr= class="submenuli" style="color: red;"
	 */
	'itemattr' => array('default' => ''),

	/**
	 * Attributes for HTML list elements, depending on 'mode':
	 *    - 'ol' for ordered
	 *    - 'ul' for unordered
	 *    - 'div' for others
     *
	 * Can be used with pseudo 'mode=inline' where 'inlinetext' contains one or more <br />.
	 *
	 * Not applicable to 'mode=category' or 'mode=inline' (with no <br /> in inlinetext).
	 *
	 * @todo Make 'listattr' param applicable to 'mode=category'.
	 *
	 * Example:
	 *     listattr= class="submenul" style="color: red;"
	 */
	'listattr' => array('default' => ''),

	/**
	 * This parameter restricts the output to articles which contain
	 * a reference to the specified page.
	 * Magic words allowed.
	 * Examples:
	 *     linksto=my article
	 *     linksto=Template:my template
	 *     linksto = {{FULLPAGENAME}}
	 */
    'linksto' => array('default' => ''),

	/**
	 * Mode for list of pages (possibly within a heading, see 'headingmode' param).
	 * 'none' mode is implemented as a specific submode of 'inline' with <br /> as inline text
	 */
	'mode' => array('default' => 'unordered', 'category', 'inline', 'none', 'ordered', 'unordered'),

	/**
	 * namespace= Ns1 | Ns2 | ...
	 * [Special value] NsX='' (empty string without quotes) means Main namespace
	 * Means pages have to be in namespace Ns1 OR Ns2 OR...
	 * Magic words allowed.
	 */
	'namespace' => NULL,

	/**
	 * notcategory= Cat1
	 * notcategory = Cat2
	 * ...
	 * Means pages can be NEITHER in category Cat1 NOR in Cat2 NOR...
	 * Magic words allowed.
	 * @todo define 'notcategory' options (retrieve list of categories from 'categorylinks' table?)
	 */
	'notcategory' => NULL,

	/**
	 * notnamespace= Ns1
 	 * notnamespace= Ns2
 	 * ...
	 * [Special value] NsX='' (empty string without quotes) means Main namespace
	 * Means pages have to be NEITHER in namespace Ns1 NOR Ns2 NOR...
	 * Magic words allowed.
	*/
	'notnamespace' => NULL,
	'order' => array(
		'default' => 'ascending',
		'ascending', 'descending'
	),

	/**
	 * 'ordermethod=param1,param2' means ordered by param1 first, then by param2.
	 * @todo: add 'ordermethod=category,categoryadd' (for each category CAT,
	 * pages ordered by date when page was added to CAT).
	 */
	'ordermethod' => array(
		'default' => 'title',
		'counter', 'category,firstedit', 'category,lastedit', 'category,pagetouched',
		'category,sortkey', 'categoryadd', 'firstedit', 'lastedit', 'pagetouched',
		'title', 'user,firstedit', 'user,lastedit'
	),

	/**
	 * minoredits =... (compatible with ordermethod=...,firstedit | lastedit only)
	 * - exclude: ignore minor edits when sorting the list (rev_minor_edit = 0 only)
	 * - include: include minor edits
	 */
	'minoredits' => array(
		'default' => 'include',
		'exclude', 'include'
	),

	/**
	 * redirects =...
	 * - exclude: excludes redirect pages from lists (page_is_redirect = 0 only)
	 * - include: allows redirect pages to appear in lists
	 * - only: lists only redirect pages in lists (page_is_redirect = 1 only)
	 */
	'redirects' => array(
		'default' => 'exclude',
		'exclude', 'include', 'only'
	),

	/**
	 * secseparators  is a sequence of html texts used to separate sections
	*  (see "includepage=name1, name2, .."). There are four items which must
	 * be separated by "," as delimiter :
	 *     - t1 and t4 define an outer frame for sections of an article
	 *     - t2 and t3 build an inner frame for each section
	 * Example:
	 *     secseparators=<table><tr>,<td>,</td>,</tr></table>
	 */
	'secseparators'  => array('default' => ',,,'),
	'shownamespace' => array(
		'default' => 'true',
		'false', 'true'
	),

	/**
	 * Max # characters of page title to display.
	 * Empty value (default) means no limit.
	 * Not applicable to mode=category.
	 */
	'titlemaxlength' => array(
		'default' => '',
		'pattern' => '/^\d*$/'
	),
);

/**
 *  Define codes and map debug message to min debug level above which message can be displayed
 */
$wgDPL2DebugCodes = array(
	// (FATAL) ERRORS
	'DPL2_ERR_WRONGNS' => 1,
	'DPL2_ERR_WRONGLINKSTO' => 1,
 	'DPL2_ERR_TOOMANYCATS' => 1,
	'DPL2_ERR_TOOFEWCATS' => 1,
	'DPL2_ERR_CATDATEBUTNOINCLUDEDCATS' => 1,
	'DPL2_ERR_CATDATEBUTMORETHAN1CAT' => 1,
	'DPL2_ERR_MORETHAN1TYPEOFDATE' => 1,
	'DPL2_ERR_WRONGORDERMETHOD' => 1,
	'DPL2_ERR_NOCLVIEW' => 1,
	// WARNINGS
	'DPL2_WARN_UNKNOWNPARAM' => 2,
	'DPL2_WARN_WRONGPARAM' => 2,
	'DPL2_WARN_WRONGPARAM_INT' => 2,
	'DPL2_WARN_NORESULTS' => 2,
	'DPL2_WARN_CATOUTPUTBUTWRONGPARAMS' => 2,
	'DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD' => 2,
	'DPL2_WARN_DEBUGPARAMNOTFIRST' => 2,
	'DPL2_WARN_TRANSCLUSIONLOOP' => 2,
	// OTHERS
	'DPL2_QUERY' => 3
);

$wgDPL2DebugMinLevels = array();
$i = 0;
foreach ($wgDPL2DebugCodes as $name => $minlevel ) {
	define( $name, $i );
	$wgDPL2DebugMinLevels[$i] = $minlevel;
	$i++;
}

// Internationalization file
require_once( 'DynamicPageList2.i18n.php' );

function wfDynamicPageList2() {
	global $wgParser, $wgMessageCache, $wgDPL2Messages;
	foreach( $wgDPL2Messages as $sLang => $aMsgs ) {
		$wgMessageCache->addMessages( $aMsgs, $sLang );
	}
	$wgParser->setHook( "DPL", "DynamicPageList2" );
}


// The callback function for converting the input text to HTML output
function DynamicPageList2( $input, $params, &$parser ) {

	error_reporting(E_ALL);
	
	global  $wgUser, $wgContLang, $wgDPL2AllowedNamespaces, $wgDPL2Options, $wgDPL2MaxCategoryCount, $wgDPL2MinCategoryCount, $wgDPL2MaxResultCount, $wgDPL2AllowUnlimitedCategories, $wgDPL2AllowUnlimitedResults;
	
	//logger (display of debug messages)
	$logger = new DPL2Logger();
	
	//check that we are not in an infinite transclusion loop
	if ( isset( $parser->mTemplatePath[$parser->getTitle()->getPrefixedText()] ) ) {
		return $logger->escapeMsg(DPL2_WARN_TRANSCLUSIONLOOP, $parser->getTitle()->getPrefixedText());
	}
	
	// INVALIDATE CACHE
	$parser->disableCache();
	
	/**
	 * Initialization
	 */
	 // Local parser created. See http://meta.wikimedia.org/wiki/MediaWiki_extensions_FAQ#How_do_I_render_wikitext_in_my_extension.3F
	$localParser = new Parser();
	$pOptions = $parser->getOptions();
	$pTitle = $parser->getTitle();
	
	// Extension variables
	// Allowed namespaces for DPL2: all namespaces except the first 2: Media (-2) and Special (-1), because we cannot use the DB for these to generate dynamic page lists.
	if( !is_array($wgDPL2AllowedNamespaces) ) { // Initialization
		$aNs = $wgContLang->getNamespaces();
		$wgDPL2AllowedNamespaces = array_slice($aNs, 2, count($aNs), true);
		if( !is_array($wgDPL2Options['namespace']) )
			$wgDPL2Options['namespace'] = $wgDPL2AllowedNamespaces;
		else // Make sure user namespace options are allowed.
			$wgDPL2Options['namespace'] = array_intersect($wgDPL2Options['namespace'], $wgDPL2AllowedNamespaces);
		if( !isset($wgDPL2Options['namespace']['default']) )
			$wgDPL2Options['namespace']['default'] = NULL;
		if( !is_array($wgDPL2Options['notnamespace']) )
			$wgDPL2Options['notnamespace'] = $wgDPL2AllowedNamespaces;
		else
			$wgDPL2Options['notnamespace'] = array_intersect($wgDPL2Options['notnamespace'], $wgDPL2AllowedNamespaces);
		if( !isset($wgDPL2Options['notnamespace']['default']) )
			$wgDPL2Options['notnamespace']['default'] = NULL;
	}
	
	// Options
	$aOrderMethods = explode(',', $wgDPL2Options['ordermethod']['default']);
	$sOrder = $wgDPL2Options['order']['default'];
	$sPageListMode = $wgDPL2Options['mode']['default'];
	$sHListMode = $wgDPL2Options['headingmode']['default'];
	$sMinorEdits = NULL;
	$sRedirects = $wgDPL2Options['redirects']['default'];
	$sInlTxt = $wgDPL2Options['inlinetext']['default'];
	$bShowNamespace = $wgDPL2Options['shownamespace']['default'] == 'true';
	$bAddFirstCategoryDate = $wgDPL2Options['addfirstcategorydate']['default'] == 'true';
	$bAddPageCounter = $wgDPL2Options['addpagecounter']['default'] == 'true';
	$bAddPageTouchedDate = $wgDPL2Options['addpagetoucheddate']['default'] == 'true';
	$bAddEditDate = $wgDPL2Options['addeditdate']['default'] == 'true';
	$bAddUser = $wgDPL2Options['adduser']['default'] == 'true';
	$bAddCategories = $wgDPL2Options['addcategories']['default'] == 'true';
	$_incpage = $wgDPL2Options['includepage']['default'];
	$bIncPage =  is_string($_incpage) && $_incpage !== '';
	$aSecLabels = array();
	if($bIncPage && $_incpage != '*')
		$aSecLabels = explode(',', $_incpage);
	$aSecSeparators = array();
    $aSecSeparators  = explode(',', $wgDPL2Options['secseparators']['default']);
	$_sCount = $wgDPL2Options['count']['default'];
	$iCount = ($_sCount == '') ? NULL: intval($_sCount);
	$sListHtmlAttr = $wgDPL2Options['listattr']['default'];
	$sItemHtmlAttr = $wgDPL2Options['itemattr']['default'];
	$sHListHtmlAttr = $wgDPL2Options['hlistattr']['default'];
	$sHItemHtmlAttr = $wgDPL2Options['hitemattr']['default'];
	$_sTitleMaxLen = $wgDPL2Options['titlemaxlength']['default'];
	$iTitleMaxLen = ($_sTitleMaxLen == '') ? NULL: intval($_sTitleMaxLen);
	$tLinksTo = Title::newFromText($localParser->transformMsg($wgDPL2Options['linksto']['default'], $pOptions));
	
	$aIncludeCategories = array(); // $aIncludeCategories is a 2-dimensional array: Memberarrays are linked using 'AND'
	$aExcludeCategories = array();
	$aCatHeadings = array();
	$aNamespaces = array();
	$aExcludeNamespaces  = array();
	
	// Output
	$output = '';

// ###### PARSE PARAMETERS ######
	$aParams = explode("\n", $input);
	$bIncludeUncat = false; // to check if pseudo-category of Uncategorized pages is included
	
	foreach($aParams as $iParam => $sParam) {
		
		$aParam = explode('=', $sParam, 2);
		if( count( $aParam ) < 2 )
			continue;
		$sType = trim($aParam[0]);
		$sArg = trim($aParam[1]);
		
		switch ($sType) {
			/**
			 * FILTER PARAMETERS
			 */
			case 'category':
				// Init array of categories to include
				$aCategories = array();
				$bHeading = false;
				if($sArg != '' && $sArg[0] == '+') {// categories are headings
					$bHeading = true;
					$sArg[0] = '';
				}
				$aParams = explode('|', $sArg);
				foreach($aParams as $sParam) {
					$sParam=trim($sParam);
					if($sParam == '') { // include uncategorized pages (special value: empty string)
						$bIncludeUncat = true;
						$aCategories[] = '';
					} else {
						$title = Title::newFromText($localParser->transformMsg($sParam, $pOptions));
						if( !is_null($title) )
							$aCategories[] = $title->getDBkey();
					}
				}
				if( !empty($aCategories) ) {
					$aIncludeCategories[] = $aCategories;
					if($bHeading)
						$aCatHeadings = array_unique($aCatHeadings + $aCategories);
				}	
				break;
				
			case 'notcategory':
				$title = Title::newFromText($localParser->transformMsg($sArg, $pOptions));
				if( !is_null($title) )
					$aExcludeCategories[] = $title->getDBkey();
				break;
				
			case 'namespace':
				$aParams = explode('|', $sArg);
				foreach($aParams as $sParam) {
					$sParam=trim($sParam);
					$sNs = $localParser->transformMsg($sParam, $pOptions);
					if( !in_array($sNs, $wgDPL2Options['namespace']) )
						return $logger->msgWrongParam('namespace', $sParam);
					$aNamespaces[] = $wgContLang->getNsIndex($sNs);
				}
				break;
			
			case 'notnamespace':
				$sArg=trim($sArg);
				$sNs = $localParser->transformMsg($sArg, $pOptions);
				if( !in_array($sNs, $wgDPL2Options['notnamespace']) )
					return $logger->msgWrongParam('notnamespace', $sArg);
				$aExcludeNamespaces[] = $wgContLang->getNsIndex($sNs);
				break;
			
			case 'linksto':
				$tLinksTo = Title::newFromText($localParser->transformMsg($sArg, $pOptions));
				if( is_null($tLinksTo) ) // wrong param
					return $logger->msgWrongParam('linksto', $sArg);
				break;
			
			case 'minoredits':
				if( in_array($sArg, $wgDPL2Options['minoredits']) )
					$sMinorEdits = $sArg;
				else { //wrong param val, using default
					$sMinorEdits = $wgDPL2Options['minoredits']['default'];
					$output .= $logger->msgWrongParam('minoredits', $sArg);
				}
				break;
				
			case 'redirects':
				if( in_array($sArg, $wgDPL2Options['redirects']) )
					$sRedirects = $sArg;
				else
					$output .= $logger->msgWrongParam('redirects', $sArg);
				break;
				
			case 'count':
				//ensure that $iCount is a number or no count limit;
				if( preg_match($wgDPL2Options['count']['pattern'], $sArg) )
					$iCount = ($sArg == '') ? NULL: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('count', $sArg);
				break;
			
			/**
			 * CONTENT PARAMETERS
			 */
			case 'addcategories':
				if( in_array($sArg, $wgDPL2Options['addcategories']))
					$bAddCategories = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('addcategories', $sArg);
				break;
			
			case 'addeditdate':
				if( in_array($sArg, $wgDPL2Options['addeditdate']))
					$bAddEditDate = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('addeditdate', $sArg);
				break;
			
			case 'addfirstcategorydate':
				if( in_array($sArg, $wgDPL2Options['addfirstcategorydate']))
					$bAddFirstCategoryDate = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('addfirstcategorydate', $sArg);
				break;
				
			case 'addpagecounter':
				if( in_array($sArg, $wgDPL2Options['addpagecounter']))
					$bAddPageCounter = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('addpagecounter', $sArg);
				break;
				
			case 'addpagetoucheddate':
				if( in_array($sArg, $wgDPL2Options['addpagetoucheddate']))
					$bAddPageTouchedDate = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('addpagetoucheddate', $sArg);
				break;
			
			case 'includepage':
				$bIncPage =  $sArg !== '';
				if($bIncPage && $sArg != '*')
					$aSecLabels= explode(',', $sArg);
				break;

			case 'adduser':
				if( in_array($sArg, $wgDPL2Options['adduser']))
					$bAddUser = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('adduser', $sArg);
				break;
				
			/**
			 * ORDER PARAMETERS
			 */	
			case 'ordermethod':
				if( in_array($sArg, $wgDPL2Options['ordermethod']) )
					$aOrderMethods = explode(',', $sArg);
				else
					$output .= $logger->msgWrongParam('ordermethod', $sArg);
				break;
			
			case 'order':
				if( in_array($sArg, $wgDPL2Options['order']) )
					$sOrder = $sArg;
				else
					$output .= $logger->msgWrongParam('order', $sArg);
				break;
				
			/**
			 * FORMAT/HTML PARAMETERS
			 * @todo allow addpagetoucheddate, addeditdate, adduser, addcategories to have effect with 'mode=category'
			 */
			case 'headingmode':
				if( in_array($sArg, $wgDPL2Options['headingmode']) )
					$sHListMode = $sArg;
				else
					$output .= $logger->msgWrongParam('headingmode', $sArg);
				break;
				
			case 'mode':
				if( in_array($sArg, $wgDPL2Options['mode']) )
					//'none' mode is implemented as a specific submode of 'inline' with <br /> as inline text
					if($sArg == 'none') {
						$sPageListMode = 'inline';
						$sInlTxt = '<br />';
					} else
					$sPageListMode = $sArg;
				else
					$output .= $logger->msgWrongParam('mode', $sArg);
				break;
				
			case 'inlinetext':
				//parse wiki text and get HTML output
				$sInlTxt = $parser->recursiveTagParse($sArg);
				break;
			
			case 'secseparators':
				//parse wiki text and get HTML output
				$aSecSeparators = explode (',', $parser->recursiveTagParse($sArg), 4);
				break;
			
			case 'shownamespace':
				if( in_array($sArg, $wgDPL2Options['shownamespace']))
					$bShowNamespace = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('shownamespace', $sArg);
				break;
			
			case 'titlemaxlength':
				//processed like 'count' param
				if( preg_match($wgDPL2Options['titlemaxlength']['pattern'], $sArg) )
					$iTitleMaxLen = ($sArg == '') ? NULL: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('titlemaxlength', $sArg);
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
			 * DEBUG PARAMETER
			 */
			case 'debug':
				if( in_array($sArg, $wgDPL2Options['debug']) ) {
					if($iParam > 1)
						$output .= $logger->escapeMsg(DPL2_WARN_DEBUGPARAMNOTFIRST, $sArg );
					$logger->iDebugLevel = intval($sArg);
				}
				else
					$output .= $logger->msgWrongParam('debug', $sArg);
				break;
				
			/**
			 * UNKNOWN PARAMETER
			 */
			default:
				$output .= $logger->escapeMsg(DPL2_WARN_UNKNOWNPARAM, $sType, implode(', ', array_keys($wgDPL2Options)));
		}
	}
	
	$iIncludeCatCount = count($aIncludeCategories);
	$iTotalIncludeCatCount = count($aIncludeCategories, COUNT_RECURSIVE) - $iIncludeCatCount;
	$iExcludeCatCount = count($aExcludeCategories);
	$iTotalCatCount = $iTotalIncludeCatCount + $iExcludeCatCount;

// ###### CHECKS ON PARAMETERS ######
	// too many categories!!
	if ( ($iTotalCatCount > $wgDPL2MaxCategoryCount) && (!$wgDPL2AllowUnlimitedCategories) )
		return $logger->escapeMsg(DPL2_ERR_TOOMANYCATS, $wgDPL2MaxCategoryCount);

	// too few categories!!
	if ($iTotalCatCount < $wgDPL2MinCategoryCount)
		return $logger->escapeMsg(DPL2_ERR_TOOFEWCATS, $wgDPL2MinCategoryCount);
		
	// no included categories but ordermethod=categoryadd or addfirstcategorydate=true!!
	if ($iTotalIncludeCatCount == 0 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
		return $logger->escapeMsg(DPL2_ERR_CATDATEBUTNOINCLUDEDCATS);

	// more than one included category but ordermethod=categoryadd or addfirstcategorydate=true!!
	if ($iTotalIncludeCatCount > 1 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
		return $logger->escapeMsg(DPL2_ERR_CATDATEBUTMORETHAN1CAT);
		
	// no more than one type of date at a time!!
	if($bAddPageTouchedDate + $bAddFirstCategoryDate + $bAddEditDate > 1)
		return $logger->escapeMsg(DPL2_ERR_MORETHAN1TYPEOFDATE);

	// category-style output requested with not compatible order method
	if ($sPageListMode == 'category' && !array_intersect($aOrderMethods, array('sortkey', 'title')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD,  'mode=category', 'sortkey | title' );
	
	// addpagetoucheddate=true with unappropriate order methods
	if( $bAddPageTouchedDate && !array_intersect($aOrderMethods, array('pagetouched', 'title')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD,  'addpagetoucheddate=true', 'pagetouched | title' );
	
	// addeditdate=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
	//firstedit (resp. lastedit) -> add date of first (resp. last) revision
	if( $bAddEditDate && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD, 'addeditdate=true', 'firstedit | lastedit' );
	
	// adduser=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
	/**
	 * @todo allow to add user for other order methods.
	 * The fact is a page may be edited by multiple users. Which user(s) should we show? all? the first or the last one?
	 * Ideally, we could use values such as 'all', 'first' or 'last' for the adduser parameter.
	*/
	if( $bAddUser && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD, 'adduser=true', 'firstedit | lastedit' );
	
	if( isset($sMinorEdits) && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD, 'minoredits', 'firstedit | lastedit' );
	
	/**
	 * If we include the Uncategorized, we need the 'dpl_clview': VIEW of the categorylinks table where we have cl_to='' (empty string) for all uncategorized pages. This VIEW must have been created by the administrator of the mediawiki DB at installation. See the documentation.
	 */
	$dbr =& wfGetDB( DB_SLAVE );
	$sPageTable = $dbr->tableName( 'page' );
	$sCategorylinksTable = $dbr->tableName( 'categorylinks' );
	$sDplClView = '';
	if($bIncludeUncat) {
		$sDplClView = $dbr->tableName( 'dpl_clview' );
		// If the view is not there, we can't perform logical operations on the Uncategorized.
		if ( !$dbr->tableExists( 'dpl_clview' ) ) {
			$sSqlCreate_dpl_clview = 'CREATE VIEW ' . $sDplClView . " AS SELECT IFNULL(cl_from, page_id) AS cl_from, IFNULL(cl_to, '') AS cl_to, cl_sortkey FROM " . $sPageTable . ' LEFT OUTER JOIN ' . $sCategorylinksTable . ' ON page_id=cl_from';
			$output .= $logger->escapeMsg(DPL2_ERR_NOCLVIEW, $sDplClView, $sSqlCreate_dpl_clview);
			return $output;
		}
	}
	
	//add*** parameters have no effect with 'mode=category' (only namespace/title can be viewed in this mode)
	if( $sPageListMode == 'category' && ($bAddCategories || $bAddEditDate || $bAddFirstCategoryDate || $bAddPageTouchedDate || $bIncPage || $bAddUser) )
		$output .= $logger->escapeMsg(DPL2_WARN_CATOUTPUTBUTWRONGPARAMS);
		
	//headingmode has effects with ordermethod on multiple components only
	if( $sHListMode != 'none' && count($aOrderMethods) < 2 ) {
		$output .= $logger->escapeMsg(DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD, $sHListMode, 'none');
		$sHListMode = 'none';
	}

	// justify limits
	if ( isset($iCount) ) {
		if($iCount > $wgDPL2MaxResultCount)
			$iCount = $wgDPL2MaxResultCount;
	} elseif(!$wgDPL2AllowUnlimitedResults)
		$iCount = $wgDPL2MaxResultCount;


// ###### BUILD SQL QUERY ######
	$sSqlPage_counter = '';
	$sSqlPage_touched = '';
	$sSqlSortkey = '';
	$sSqlCl_to = '';
	$sSqlCats = '';
	$sSqlCl_timestamp = '';
	$sSqlClHeadTable = '';
	$sSqlCond_page_cl_head = '';
	$sSqlClTableForGC = '';
	$sSqlCond_page_cl_gc = '';
	$sRevisionTable = $dbr->tableName( 'revision' );
	$sSqlRevisionTable = '';
	$sSqlRev_timestamp = '';
	$sSqlRev_user = '';
	$sSqlCond_page_rev = '';
	$sPageLinksTable = $dbr->tableName( 'pagelinks' );
	$sSqlPageLinksTable = '';
	$sSqlCond_page_pl = '';
	$sSqlWhere = ' WHERE 1=1 ';
	$sSqlGroupBy = '';
	
	foreach($aOrderMethods as $sOrderMethod) {
		switch ($sOrderMethod) {
			case 'category':
				$sSqlCl_to = "cl_head.cl_to, "; // Gives category headings in the result
				$sSqlClHeadTable = ( in_array('', $aCatHeadings) ? $sDplClView : $sCategorylinksTable ) . ' AS cl_head'; // use dpl_clview if Uncategorized in headings
				$sSqlCond_page_cl_head = 'page_id=cl_head.cl_from';
				if(!empty($aCatHeadings))
					$sSqlWhere .= " AND cl_head.cl_to IN (" . $dbr->makeList( $aCatHeadings ) . ")";
				break;
			case 'firstedit':
				$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
				$sSqlRev_timestamp = ', rev_timestamp';
				$sSqlCond_page_rev = ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
				break;
			case 'lastedit':
				$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
				$sSqlRev_timestamp = ', rev_timestamp';
				$sSqlCond_page_rev = ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
				break;
			case 'sortkey':
				// We need the namespaces with strictly positive indices (DPL2 allowed namespaces, except the first one: Main).
				$aStrictNs = array_slice($wgDPL2AllowedNamespaces, 1, count($wgDPL2AllowedNamespaces), true);
				// map ns index to name
				$sSqlNsIdToText = 'CASE page_namespace';
				foreach($aStrictNs as $iNs => $sNs)
					$sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs );
				$sSqlNsIdToText .= ' END';
				// If cl_sortkey is null (uncategorized page), generate a sortkey in the usual way (full page name, underscores replaced with spaces).
				$sSqlSortkey = ", IFNULL(cl_head.cl_sortkey, REPLACE(CONCAT( IF(page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), CONVERT(page_title USING utf8)), '_', ' ')) as sortkey";
				break;
			case 'title':
				$aStrictNs = array_slice($wgDPL2AllowedNamespaces, 1, count($wgDPL2AllowedNamespaces), true);
				// map ns index to name
				$sSqlNsIdToText = 'CASE page_namespace';
				foreach($aStrictNs as $iNs => $sNs)
					$sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
				$sSqlNsIdToText .= ' END';
				// Generate sortkey like for category links.
				$sSqlSortkey = ", REPLACE(CONCAT( IF(page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), CONVERT(page_title USING utf8)), '_', ' ') as sortkey";
				break;
			case 'user':
				$sSqlRevisionTable = $sRevisionTable . ', ';
				$sSqlRev_user = ', rev_user, rev_user_text';
				break;
		}
	}
	
	if ( !is_null($tLinksTo) ) {
		$sSqlPageLinksTable = $sPageLinksTable . ' as pl, ';
		$sSqlCond_page_pl = ' AND page_id=pl.pl_from  AND pl.pl_namespace=' . intval( $tLinksTo->getNamespace() ) . 
			" AND pl.pl_title=" . $dbr->addQuotes( $tLinksTo->getDBkey() );
 	}
	
	if ($bAddFirstCategoryDate)
		//format cl_timestamp field (type timestamp) to string in same format as rev_timestamp field
		//to make it compatible with $wgLang->date() function used in function DPL2OutputListStyle() to show "firstcategorydate"
		$sSqlCl_timestamp = ", DATE_FORMAT(cl0.cl_timestamp, '%Y%m%d%H%i%s') AS cl_timestamp";
	if ($bAddPageCounter)
		$sSqlPage_counter = ', page_counter';
	if ($bAddPageTouchedDate)
		$sSqlPage_touched = ', page_touched';
	if ($bAddUser)
		$sSqlRev_user = ', rev_user, rev_user_text';
	if ($bAddCategories) {
		$sSqlCats = ", GROUP_CONCAT(DISTINCT cl_gc.cl_to ORDER BY cl_gc.cl_to ASC SEPARATOR ' | ') AS cats"; // Gives list of all categories linked from each article, if any.
		$sSqlClTableForGC = $sCategorylinksTable . ' AS cl_gc'; // Categorylinks table used by the Group Concat (GC) function above
		$sSqlCond_page_cl_gc = 'page_id=cl_gc.cl_from';
		$sSqlGroupBy = ' GROUP BY ' . $sSqlCl_to . 'page_id';
	}
	
	// SELECT ... FROM
	$sSqlSelectFrom = 'SELECT DISTINCT ' . $sSqlCl_to . 'page_namespace, page_title' . $sSqlSortkey . $sSqlPage_counter . $sSqlPage_touched . $sSqlRev_user . $sSqlRev_timestamp . $sSqlCats . $sSqlCl_timestamp . ' FROM ' . $sSqlRevisionTable . $sSqlPageLinksTable . $sPageTable;
	
	// JOIN ...
	if($sSqlClHeadTable != '' || $sSqlClTableForGC != '') {
		$b2tables = ($sSqlClHeadTable != '') && ($sSqlClTableForGC != '');
		$sSqlSelectFrom .= ' LEFT OUTER JOIN (' . $sSqlClHeadTable . ($b2tables ? ', ' : '') . $sSqlClTableForGC . ') ON (' . $sSqlCond_page_cl_head . ($b2tables ? ' AND ' : '') . $sSqlCond_page_cl_gc . ')';
	}
	
	// Include categories...
	$iClTable = 0;
	for ($i = 0; $i < $iIncludeCatCount; $i++) {
		// If we want the Uncategorized
		$sSqlSelectFrom .= ' INNER JOIN ' . ( in_array('', $aIncludeCategories[$i]) ? $sDplClView : $sCategorylinksTable ) . ' AS cl' . $iClTable . ' ON page_id=cl' . $iClTable . '.cl_from AND (cl' . $iClTable . '.cl_to=' . $dbr->addQuotes($aIncludeCategories[$i][0]);
		for ($j = 1; $j < count($aIncludeCategories[$i]); $j++)
			$sSqlSelectFrom .= ' OR cl' . $iClTable . '.cl_to=' . $dbr->addQuotes($aIncludeCategories[$i][$j]);
		$sSqlSelectFrom .= ') ';
		$iClTable++;
	}
	
	// Exclude categories...
	for ($i = 0; $i < $iExcludeCatCount; $i++) {
		$sSqlSelectFrom .=
			' LEFT OUTER JOIN ' . $sCategorylinksTable . ' AS cl' . $iClTable .
			' ON page_id=cl' . $iClTable . '.cl_from' .
			' AND cl' . $iClTable . '.cl_to=' . $dbr->addQuotes($aExcludeCategories[$i]);
		$sSqlWhere .= ' AND cl' . $iClTable . '.cl_to IS NULL';
		$iClTable++;
	}

	// WHERE... (actually finish the WHERE clause we may have started if we excluded categories - see above)
	// Namespace IS ...
	if ( !empty($aNamespaces)) {
		$sSqlWhere .= ' AND page_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
	}
	// Namespace IS NOT ...
    if ( !empty($aExcludeNamespaces)) {
        $sSqlWhere .= ' AND page_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
    }
    // rev_minor_edit IS
    if( isset($sMinorEdits) && $sMinorEdits == 'exclude' )
		$sSqlWhere .= ' AND rev_minor_edit=0';
	// page_is_redirect IS ...	
	switch ($sRedirects) {
		case 'only':
			$sSqlWhere .= ' AND page_is_redirect=1';
			break;
		case 'exclude':
			$sSqlWhere .= ' AND page_is_redirect=0';
			break;
	}
	
	// page_id=rev_page (if revision table required)
	$sSqlWhere .= $sSqlCond_page_rev;
	// page_id=pl.pl_from (if pagelinks table required)
	$sSqlWhere .= $sSqlCond_page_pl;
	
	// GROUP BY ...
	$sSqlWhere .= $sSqlGroupBy;
	
	// ORDER BY ...
	$sSqlWhere .= ' ORDER BY ';
	foreach($aOrderMethods as $i => $sOrderMethod) {
		if($i > 0)
			$sSqlWhere .= ', ';
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
			case 'firstedit':
			case 'lastedit':
				$sSqlWhere .= 'rev_timestamp';
				break;
			case 'pagetouched':
				$sSqlWhere .= 'page_touched';
				break;
			case 'sortkey':
			case 'title':
				$sSqlWhere .= 'sortkey';
				break;
			case 'user':
				// rev_user_text can discriminate anonymous users (e.g. based on IP), rev_user cannot (=' 0' for all)
				$sSqlWhere .= 'rev_user_text';
				break;
		}
	}
	if ($sOrder == 'descending')
		$sSqlWhere .= ' DESC';
	else
		$sSqlWhere .= ' ASC';

	// LIMIT ....
	if ( isset($iCount) )
		$sSqlWhere .= ' LIMIT ' . intval( $iCount );



// ###### PROCESS SQL QUERY ######
	//DEBUG: output SQL query 
	$output .= $logger->escapeMsg(DPL2_QUERY, $sSqlSelectFrom . $sSqlWhere);
	//echo 'QUERY: [' . $sSqlSelectFrom . $sSqlWhere . "]<br />";

	$res = $dbr->query($sSqlSelectFrom . $sSqlWhere);
	if ($dbr->numRows( $res ) == 0) {
		$output .= $logger->escapeMsg(DPL2_WARN_NORESULTS);
		return $output;
	}
	
	$sk =& $wgUser->getSkin();
	// generate link to Special:Uncategorizedpages (used if ordermethod=category,...)
	$tSpecUncat = Title::makeTitle( NS_SPECIAL, 'Uncategorizedpages' );
	$sSpecUncatLnk = $sk->makeKnownLinkObj( $tSpecUncat, wfMsg('uncategorizedpages') );
	// generate title for Special:Contributions (used if adduser=true)
	$tSpecContribs = Title::makeTitle( NS_SPECIAL, 'Contributions' );
	// linkBatch used to check the existence of titles
	$linkBatch = new LinkBatch();
	$aHeadings = array(); // maps heading to count (# of pages under each heading)
	//heading titles to be checked by $linkBatch for existence
	$aUncheckedHeadingTitles = array();
	$aArticles = array();
	//user titles to be checked by $linkBatch for existence
	$aUncheckedUserTitles = array();
	//category titles to be checked by $linkBatch for existence
	$aUncheckedCatTitles = array();
	
	$iArticle = 0;
	while( $row = $dbr->fetchObject ( $res ) ) {
		//PAGE TITLE
		$title = Title::makeTitle($row->page_namespace, $row->page_title);
		$dplArticle = new DPL2Article( $title );
		//PAGE LINK
		$sTitleText = $title->getText();
		//chop off title if "too long"
		if( isset($iTitleMaxLen) && (strlen($sTitleText) > $iTitleMaxLen) )
			$sTitleText = substr($sTitleText, 0, $iTitleMaxLen) . '...';
		if ($bShowNamespace)
			//Adapted from Title::getPrefixedText()
            $sTitleText = str_replace( '_', ' ', $title->prefix($sTitleText) );
		$articleLink = $sk->makeKnownLinkObj( $title, htmlspecialchars( $wgContLang->convert( $sTitleText ) ) );
		$dplArticle->mLink = $articleLink;
		
		//get first char used for category-style output
		if( isset($row->sortkey) )
			$dplArticle->mStartChar = $wgContLang->convert($wgContLang->firstChar($row->sortkey));
			
		//SHOW PAGE_COUNTER
		if( isset($row->page_counter) )
			$dplArticle->mCounter = $row->page_counter;
		
		//SHOW "PAGE_TOUCHED" DATE, "FIRSTCATEGORYDATE" OR (FIRST/LAST) EDIT DATE
		if($bAddPageTouchedDate)
			$dplArticle->mDate = $row->page_touched;
		elseif ($bAddFirstCategoryDate)
			$dplArticle->mDate = $row->cl_timestamp;
		elseif ($bAddEditDate)
			$dplArticle->mDate = $row->rev_timestamp;
		
		//USER/AUTHOR(S)
		if($bAddUser)
			// Adapted from Linker::userLink()
			if($row->rev_user == 0) { //anonymous user
				$encName = htmlspecialchars( $row->rev_user_text );
				$dplArticle->mUserLink = $sk->makeKnownLinkObj($tSpecContribs,  $encName, 'target=' . urlencode($row->rev_user_text) );
			} else {
				$tUser = Title::makeTitle( NS_USER, $row->rev_user_text );
				//The user title may not exist. Add title to LinkBatch to check that out and to make link accordingly.
				$linkBatch->addObj($tUser);
				$aUncheckedUserTitles[$iArticle] = $tUser;
			}
		
		//CATEGORY LINKS FROM CURRENT PAGE 
		if($bAddCategories && ($row->cats != '')) {
			$artCatNames = explode(' | ', $row->cats);
			foreach($artCatNames as $iArtCat => $artCatName) {
				$tArtCat = Title::makeTitle(NS_CATEGORY, $artCatName);
				//The category title may not exist. Add title to LinkBatch to check that out and to make link accordingly.
				$linkBatch->addObj($tArtCat);
				$aUncheckedCatTitles[$iArticle][$iArtCat] = $tArtCat;
				$dplArticle->mCategoryLinks[] = NULL; //will be set later after link check
			}
		}
		
		// PARENT HEADING (category of the page, editor (user) of the page, etc. Depends on ordermethod param)
		if($sHListMode != 'none') {
			switch($aOrderMethods[0]) {
				case 'category':
					//count one more page in this heading
					$aHeadings[$row->cl_to] = isset($aHeadings[$row->cl_to]) ? $aHeadings[$row->cl_to] + 1 : 1;
					if($row->cl_to == '') //uncategorized page
						$dplArticle->mParentHLink = $sSpecUncatLnk;
					else {
						$tCat = Title::makeTitle(NS_CATEGORY, $row->cl_to);
						//The category title may not exist. Add title to LinkBatch to check that out and to make link accordingly.
						$linkBatch->addObj($tCat);
						$aUncheckedHeadingTitles[$iArticle] = $tCat;
					}
					break;
				case 'user':
					$aHeadings[$row->rev_user_text] = isset($aHeadings[$row->rev_user_text]) ? $aHeadings[$row->rev_user_text] + 1 : 1;
					// Adapted from Linker::userLink()
					if($row->rev_user == 0) { //anonymous user
						$encName = htmlspecialchars( $row->rev_user_text );
						$dplArticle->mParentHLink = $sk->makeKnownLinkObj($tSpecContribs,  $encName, 'target=' . urlencode($row->rev_user_text) );
					} else {
						$tUser = Title::makeTitle( NS_USER, $row->rev_user_text );
						//The user title may not exist. Add title to LinkBatch to check that out and to make link accordingly.
						$linkBatch->addObj($tUser);
						$aUncheckedHeadingTitles[$iArticle] = $tUser;
					}
					break;
			}
		}
		
		$aArticles[] = $dplArticle;
		$iArticle++;
	}
	$dbr->freeResult( $res );
	
	//check titles in $linkBatch and update links accordingly
	$linkCache = new LinkCache();
	$linkBatch->executeInto($linkCache);
	DPL2UpdateArticleMemberLinks($aUncheckedHeadingTitles, $linkCache, $aArticles, 'mParentHLink');
	DPL2UpdateArticleMemberLinks($aUncheckedUserTitles, $linkCache, $aArticles, 'mUserLink');
	DPL2UpdateArticleMemberLinks($aUncheckedCatTitles, $linkCache, $aArticles, 'mCategoryLinks');

// ###### SHOW OUTPUT ######
	$listMode = new DPL2ListMode($sPageListMode, $aSecSeparators, $sInlTxt, $sListHtmlAttr, $sItemHtmlAttr);
	$hListMode = new DPL2ListMode($sHListMode, $aSecSeparators, '', $sHListHtmlAttr, $sHItemHtmlAttr);
	$dpl = new DPL2($aHeadings, $aArticles, $aOrderMethods[0], $hListMode, $listMode, $bIncPage, $aSecLabels, $parser, $logger);
	return $output . $dpl->getText();
}


// Simple Article/Page class with properties used in the DPL
class DPL2Article {
	var $mTitle = ''; // title
	var $mLink = ''; // html link to page
	var $mStartChar = ''; // page title first char
	var $mParentHLink = ''; // heading (link to the associated page) that page belongs to in the list (default '' means no heading)
	var $mCategoryLinks = array(); // category links in the page
	var $mCounter = ''; // Number of times this page has been viewed
	var $mDate = ''; // timestamp depending on the user's request (can be first/last edit, page_touched, ...)
	var $mUserLink = ''; // link to editor (first/last, depending on user's request) 's page or contributions if not registered
	
	function DPL2Article($title) {
		$this->mTitle = $title;
	}
}


// Updates links in the members (parent heading, category links...) of a DPL2Article according to a LinkCache object
function DPL2UpdateArticleMemberLinks($titles, $linkcache, &$articles, $member) {
	global $wgUser, $wgContLang;
	$sk =& $wgUser->getSkin();
	foreach($titles as $tkey => $titleval) {
		if($member == 'mCategoryLinks') { // $titleval is an array
			foreach($titleval as $catKey => $catTitle) {
				$linkText = htmlspecialchars( $wgContLang->convertHtml($catTitle->getText()) );
				$articles[$tkey]->mCategoryLinks[$catKey] = $linkcache->isBadLink($catTitle->getPrefixedDbKey()) ? $sk->makeBrokenLinkObj($catTitle, $linkText) : $sk->makeKnownLinkObj($catTitle, $linkText);
			}
		} else {
				$linkText = htmlspecialchars( $wgContLang->convertHtml($titleval->getText()) );
				$articles[$tkey]->$member = $linkcache->isBadLink($titleval->getPrefixedDbKey()) ? $sk->makeBrokenLinkObj($titleval, $linkText) : $sk->makeKnownLinkObj($titleval, $linkText);
		}
	}
}


class DPL2ListMode {
	var $name;
	var $sListStart = '';
	var $sListEnd = '';
	var $sHeadingStart = '';
	var $sHeadingEnd = '';
	var $sItemStart = '';
	var $sItemEnd = '';
	var $sInline = '';
	var $sSecStartAll = '';
	var $sSecStart = '';
	var $sSecEnd = '';
	var $sSecEndAll = '';
	
	function DPL2ListMode($listmode, $secseparators, $inlinetext = '&nbsp;-&nbsp', $listattr = '', $itemattr = '') {
		$this->name = $listmode;
		$_listattr = ($listattr == '') ? '' : ' ' . Sanitizer::fixTagAttributes( $listattr, 'ul' );
		$_itemattr = ($itemattr == '') ? '' : ' ' . Sanitizer::fixTagAttributes( $itemattr, 'li' );
		
		switch(count($secseparators)) {
			case 4:
				$this->sSecEndAll = $secseparators[3];
			case 3:
				$this->sSecEnd = $secseparators[2];
			case 2:
				$this->sSecStart = $secseparators[1];
			case 1:
				$this->sSecStartAll = $secseparators[0];
		}

		switch ($listmode) {
			case 'inline':
				if( stristr($inlinetext, '<BR />') ) { //one item per line (pseudo-inline)
					$this->sListStart = '<DIV'. $_listattr . '>';
					$this->sListEnd = '</DIV>';
				}
				$this->sItemStart = '<SPAN' . $_itemattr . '>';
				$this->sItemEnd = '</SPAN>';
				$this->sInline = $inlinetext;
				break;
			case 'ordered':
				$this->sListStart = '<OL' . $_listattr . '>';
				$this->sListEnd = '</OL>';
				$this->sItemStart = '<LI'. $_itemattr . '>';
				$this->sItemEnd = '</LI>';
				break;
			case 'unordered':
				$this->sListStart = '<UL' . $_listattr . '>';
				$this->sListEnd = '</UL>';
				$this->sItemStart = '<LI' . $_itemattr . '>';
				$this->sItemEnd = '</LI>';
				break;
			case 'definition':
				$this->sListStart = '<DL' . $_listattr . '>';
				$this->sListEnd = '</DL>';
				// item html attributes on dt element or dd element ?
				$this->sHeadingStart = '<DT>';
				$this->sHeadingEnd = '</DT><DD>';
				$this->sItemEnd = '</DD>';
				break;
			case 'H2':
			case 'H3':
			case 'H4':
				$this->sListStart = '<DIV' . $_listattr . '>';
				$this->sListEnd = '</DIV>';
				$this->sHeadingStart = '<' . $listmode .'>';
				$this->sHeadingEnd = '</' . $listmode . '>';
				break;
		}
	}
}


class DPL2 {
	
	var $mArticles;
	var $mHeadingType; // type of heading: category, user, etc. (depends on 'ordermethod' param)
	var $mHListMode; // html list mode for headings
	var $mListMode; // html list mode for pages
	var $mIncPage; // true only if page transclusion is enabled
	var $mIncSecLabels = array(); // array of labels of sections to transclude
	var $mParser;
	var $mParserOptions;
	var $mParserTitle;
	var $mLogger; // DPL2Logger
	var $mOutput;
	
	function DPL2($headings, $articles, $headingtype, $hlistmode, $listmode, $includepage, $includeseclabels,&$parser, $logger) {
		$this->mArticles = $articles;
		$this->mListMode = $listmode;
		$this->mIncPage = $includepage;
		if($includepage)
			$this->mIncSecLabels = $includeseclabels;
		$this->mParser = $parser;
		$this->mParserOptions = $parser->getOptions();
		$this->mParserTitle = $parser->getTitle();
		$this->mLogger = $logger;
		
		if(!empty($headings)) {
			$this->mHeadingType = $headingtype;
			$this->mHListMode = $hlistmode;
			$this->mOutput .= $hlistmode->sListStart;
			$headingStart = 0;
			foreach($headings as $heading => $headingCount) {
				$headingLink = $articles[$headingStart]->mParentHLink;
				$this->mOutput .= $hlistmode->sItemStart;
				$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
				$this->mOutput .= $this->formatCount($headingCount);
				$this->mOutput .= $this->formatList($headingStart, $headingCount);
				$this->mOutput .= $hlistmode->sItemEnd;
				$headingStart += $headingCount;
			}
			$this->mOutput .= $hlistmode->sListEnd;
		} else
			$this->mOutput .= $this->formatList(0, count($articles));
	}
	
	function formatCount($numart) {
		global $wgLang;
		if($this->mHeadingType == 'category')
			$message = 'categoryarticlecount';
		else 
			$message = 'dpl2_articlecount';
		return '<p>' . $this->msgExt( $message, array( 'parse' ), $numart) . '</p>';
	}
	
	function formatList($iStart, $iCount) {
		global $wgUser, $wgLang, $wgContLang;
		
		$mode = $this->mListMode;
		//categorypage-style list output mode
		if($mode->name == 'category')
			return $this->formatCategoryList($iStart, $iCount);
		
		//other list modes
		$sk = & $wgUser->getSkin();
		// generate link to Special:Categories (used if addcategories=true)
		$tSpecCats = Title::makeTitle( NS_SPECIAL, 'Categories' );
		$sSpecCatsLnk = $sk->makeKnownLinkObj( $tSpecCats, wfMsg('categories'));
		
		//process results of query, outputing equivalent of <li>[[Article]]</li> for each result,
		//or something similar if the list uses other startlist/endlist;
		$r = $mode->sListStart;
		for ($i = $iStart; $i < $iStart+$iCount; $i++) {
			if($i > $iStart)
				$r .= $mode->sInline; //If mode is not 'inline', sInline attribute is empty, so does nothing
			$r .= $mode->sItemStart;
			$article = $this->mArticles[$i];
			if($article->mDate != '')
				$r .=  $wgLang->timeanddate($article->mDate, true) . ': ';
			$r .= $article->mLink;
			if($article->mCounter != '') {
				// Adapted from SpecialPopularPages::formatResult()
				$nv = $this->msgExt( 'nviews', array( 'parsemag', 'escape'), $wgLang->formatNum( $article->mCounter ) );
				$r .=  ' ' . $wgContLang->getDirMark() . '(' . $nv . ')';
			}
			if($article->mUserLink != '')
				$r .= ' . . ' . $article->mUserLink;
			if( !empty($article->mCategoryLinks) )
				$r .= ' . . <SMALL>' . $sSpecCatsLnk . ': ' . implode(' | ', $article->mCategoryLinks) . '</SMALL>';
			
			// Page transclusion or "labeled section transclusion" (see LabeledSectionTransclusion extension for more info)
			if ($this->mIncPage) {
				if(empty($this->mIncSecLabels)) {
					// Uses wfLst_fetch_() from LabeledSectionTransclusion extension to include the whole page
					$incwiki = wfLst_fetch_($this->mParser, $article->mTitle->getPrefixedText());
				} else {
					$incwiki = $mode->sSecStartAll;
					foreach ($this->mIncSecLabels as $sSecLabel) {
						$sSecLabel = trim($sSecLabel);
						if ($sSecLabel == '') break;
						$incwiki .= $mode->sSecStart;
						if($sSecLabel[0] == '#') {
							// Uses wfLstIncludeHeading2() from LabeledSectionTransclusion extension to include headings from the page
							$secPiece = wfLstIncludeHeading2($this->mParser, $article->mTitle->getPrefixedText(), substr($sSecLabel, 1));
						} else {
							// Uses wfLstInclude() from LabeledSectionTransclusion extension to include labeled sections from the page
							$secPiece = wfLstInclude($this->mParser, $article->mTitle->getPrefixedText(), $sSecLabel);
						}
						/**
						* $secPiece can be: 
						* - array($text, 'title'=>$title, 'replaceHeadings'=>true, 'headingOffset'=>$skiphead)
						* - "[[" . $title->getPrefixedText() . "]]<!-- WARNING: LST loop detected -->";
						*/
						$incwiki .= is_array($secPiece) ? $secPiece[0] : $secPiece;
						$incwiki .= $mode->sSecEnd;
					}
					$incwiki .= $mode->sSecEndAll;
				}
				wfLst_open_($this->mParser, $this->mParserTitle->getPrefixedText());
				$r .= '<p>' . $this->mParser->recursiveTagParse($incwiki) . '</p>';
				wfLst_close_($this->mParser, $this->mParserTitle->getPrefixedText());
			}
	
			$r .= $mode->sItemEnd;
		}
		$r .= $mode->sListEnd;
		return $r;
	}
	
	//slightly different from CategoryViewer::formatList() (no need to instantiate a CategoryViewer object)
	function formatCategoryList($iStart, $iCount) {
		global $wgDPL2CategoryStyleListCutoff;
		
		for($i = $iStart; $i < $iStart + $iCount; $i++) {
			$aArticles[] = $this->mArticles[$i]->mLink;
			$aArticles_start_char[] = $this->mArticles[$i]->mStartChar;
		}
		require_once ('CategoryPage.php');
		if ( count ( $aArticles ) > $wgDPL2CategoryStyleListCutoff ) {
			return CategoryViewer::columnList( $aArticles, $aArticles_start_char );
		} elseif ( count($aArticles) > 0) {
			// for short lists of articles in categories.
			return CategoryViewer::shortList( $aArticles, $aArticles_start_char );
		}
		return '';
	}
	
	/**
	* Returns message in the requested format after parsing wikitext to html
	* This is meant to be equivalent to wfMsgExt() with parse, parsemag and escape as available options but using the DPL2 local parser instead of the global one (bugfix).
	*/
	function msgExt( $key, $options ) {
		$args = func_get_args();
		array_shift( $args );
		array_shift( $args );
	
		if( !is_array($options) ) {
			$options = array($options);
		}
	
		$string = wfMsgGetKey( $key, true, false, false );
	
		$string = wfMsgReplaceArgs( $string, $args );
	
		if( in_array('parse', $options) ) {
			$this->mParserOptions->setInterfaceMessage(true);
			$string = $this->mParser->recursiveTagParse( $string );
			$this->mParserOptions->setInterfaceMessage(false);
			//$string = $parserOutput->getText();
		} elseif ( in_array('parsemag', $options) ) {
			$parser = new Parser();
			$parserOptions = new ParserOptions();
			$parserOptions->setInterfaceMessage( true );
			$parser->startExternalParse( $this->mParserTitle, $parserOptions, OT_MSG );
			$string = $parser->transformMsg( $string, $parserOptions );
		}
	
		if ( in_array('escape', $options) ) {
			$string = htmlspecialchars ( $string );
		}
	
		return $string;
	}
	
	function getText() {
		return $this->mOutput;
	}
	
}


class DPL2Logger {
	var $iDebugLevel;
	
	function DPL2Logger() {
		global $wgDPL2Options;
		$this->iDebugLevel = $wgDPL2Options['debug']['default'];
	}

	/**
	 * Get a message, with optional parameters
	 * Parameters from user input must be escaped for HTML *before* passing to this function
	 */
	function msg($msgid) {
		global $wgDPL2DebugMinLevels;
		if($this->iDebugLevel >= $wgDPL2DebugMinLevels[$msgid]) {
			$args = func_get_args();
			array_shift( $args );
			/**
			 * @todo add a DPL id to identify the DPL tag that generates the message, in case of multiple DPLs in the page
			 */
			return '<p>%DPL2-' . DPL2_VERSION . '-' .  wfMsg('dpl2_debug_' . $msgid, $args) . '</p>';
		}
		return '';
	}

	/**
	 * Get a message. 
	 * Parameters may be unescaped, this function will escape them for HTML.
	 */
	function escapeMsg( $msgid /*, ... */ ) {
		$args = func_get_args();
		$args = array_map( 'htmlspecialchars', $args );
		return call_user_func_array( array( &$this, 'msg' ), $args );
	}

	/**
	 * Get a "wrong parameter" message.
	 * @param $paramvar The parameter name
	 * @param $val The unescaped input value
	 * @return HTML error message
	 */
	function msgWrongParam($paramvar, $val) {
		global $wgContLang, $wgDPL2Options;
		$msgid = DPL2_WARN_WRONGPARAM;
		switch($paramvar) {
			case 'namespace':
			case 'notnamespace':
				$msgid = DPL2_ERR_WRONGNS;
				break;
			case 'linksto':
				$msgid = DPL2_ERR_WRONGLINKSTO;
				break;
			case 'count':
			case 'titlemaxlength':
				$msgid = DPL2_WARN_WRONGPARAM_INT;
				break;
		}
		$paramoptions = array_unique($wgDPL2Options[$paramvar]);
		sort($paramoptions);
		return $this->escapeMsg( $msgid, $paramvar, htmlspecialchars( $val ), $wgDPL2Options[$paramvar]['default'], implode(' | ', $paramoptions ));
	}
	
}

