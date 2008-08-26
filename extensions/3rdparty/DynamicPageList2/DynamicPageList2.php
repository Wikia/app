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
 * @package MediaWiki
 * @subpackage Extensions
 * @link http://www.mediawiki.org/wiki/Extension:DynamicPageList   Documentation
 * @author n:en:User:IlyaHaykinson
 * @author n:en:User:Amgine
 * @author w:de:Benutzer:Unendlich
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
 * @author m:User:Algorithmix <gero.scholz@t-online.de>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 0.9.1
 *          problem with adduser solved
 * @version 0.9.2
 *          problem with headlines in headingmode corrected
 *          addcategories: bug fixed
 *          CATLIST variable defined
 * @version 0.9.3
 *          allow � as an alias for |
 *          escapelinks= introduced
 * @version 0.9.4
 *          allow "-" with categories =
 *          disable UTF8 conversion for sortkey
 *          headingcount= added
 * @version 0.9.5
 *          "offset=" added (basic mechanism for scrolling through result lists)
 * @version 0.9.6
 *          when including templates (includepage={xx}yy) spaces between {{ and the template name now will be accepted
 *          syntax and semantics of secseparators changed
 *          multiple template includes allowed (multisecseparators)
 *          multiple chapter inclusions of the same heading allowed (multisecseparators)
 *          single # includes text up to the first heading
 *          userdateformat introduced
 *          changed call-time reference passing to avoid warn message
 *          TITLE var added
 * @version 0.9.7
 *          bug corrected with transclusion of labeled sections
 *          addfirstcategory works with more than one category selected (risking to produce ambiguous results)
 * @version 0.9.8
 *          fixed problem with section inclusion (multipl einclusion of same page did not work wit user tag variant
 *          NOTOC and NOEDITSECTION are automatically placed before mode=category
 *          PAGE and TITLE variables passed to templates
 *          linksto, uses, titlematch and their not-equivalents now understand a set arguments which form an OR-group
 * @version 0.9.9
 *			default template inclusion added
 *          rowcolformat added
 *          multicol tag understands now %PAGE% and other parameters
 * @version 1.0.0
 *			lastrevisionbefore added
 *			allrevisionsbefore added
 *			firstrevisionsince added
 *			allrevisionssince  added
 *			dominantsection added
 *			replaceintitle added
 * @version 1.0.1
 *			include as an alias for pageinclude
 *          title= introduced
 * @version 1.0.2
 *			categorymatch  and notcategorymatch  introduced
 *			categoryregexp and notcategoryregexp introduced
 *          titleregexp and nottitleregexp introduced
 * @version 1.0.3
 *			behaviour of categoryregexp slightly changed
 * @version 1.0.4
 *			added linksfrom
 * @version 1.0.5
 *			added createdby, notcreatedby, modifiedby, notmodifiedby, lastmodifiedby, notlastmodifiedby
 * @version 1.0.6
 *			allow selection criteria based on included contents
 * @version 1.0.7
 *			some improvements of includematch (regarding multiple occurencies of the same section)
 * @version 1.0.8
 *			added notlinksfrom
 *          solved problem with invalid arguments at linksto, linksfrom etc.
 *			includematch now tests template INPUT against the regexp
 *			replaceintitle now also works in standard mode
 * @version 1.0.9
 *			added openreferences
 * @version 1.1.0
 *			changed parser cache disabling
 * @version 1.1.1
 *			experimental support for simple category hierarchies
 * @version 1.1.2
 *			allow to include sections by number
 * @version 1.1.3
 *			bug fix for 1.1.2 (pass by reference warning)
 * @version 1.1.4
 *			technical improvement, more flexible argument parsing at DynamicPageList4()
 *		    easy access at include for one single template parameter
 *			activation of first version of special page (require once)
 *          allow comment syntax with #
 *          date parameters now accept separation characters
 * @version 1.1.5
 *			allow cache control via new parameter
 * @version 1.1.6
 *			bug fix for template inclusion
 * @version 1.1.7
 *			removed path from require_once for special page php source
 * @version 1.1.8
 *			addauthor, addlasteditor, goal=categories
 * @version 1.1.9
 *			ordermethod=titlewithoutnamespace
 * @version 1.2.0
 *			replaced " by ' in SQL statements
 */

/*
 * Current version
 */
define('DPL2_VERSION', '1.2.1');

// register DPL special page
require_once( "DynamicPageListSP.php" );

/**
 * Register the extension with MediaWiki
 */

// register as a function
$wgExtensionFunctions[]        = 'wfDynamicPageList3';
$wgHooks['LanguageGetMagic'][] = 'wfDynamicPageList3_Magic';

// register as a user tag
$wgExtensionFunctions[]        = 'wfDynamicPageList2';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'DynamicPageList2',
	'author' =>  '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson], [http://en.wikinews.org/wiki/User:Amgine Amgine],'
				.'[http://de.wikipedia.org/wiki/Benutzer:Unendlich Unendlich], [http://meta.wikimedia.org/wiki/User:Dangerman Cyril Dangerville],'
				.'[http://de.wikipedia.org/wiki/Benutzer:Algorithmix Algorithmix]',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DynamicPageList',
	'description' => 'based on [http://meta.wikimedia.org/wiki/DynamicPageList DynamicPageList], featuring many improvements (sql injection fixed by Inez Korczynski)',
  	'version' => DPL2_VERSION
  );


/**
 * Extension options
 */
$wgDPL2MaxCategoryCount         = 4;      // Maximum number of categories allowed in the Query
$wgDPL2MinCategoryCount         = 0;      // Minimum number of categories needed in the Query
$wgDPL2MaxResultCount           = 500;    // Maximum number of results to allow
$wgDPL2CategoryStyleListCutoff  = 6;      //Max length to format a list of articles chunked by letter as bullet list, if list bigger, columnar format user (same as cutoff arg for CategoryPage::formatList())
$wgDPL2AllowUnlimitedCategories = true;   // Allow unlimited categories in the Query
$wgDPL2AllowUnlimitedResults    = false;  // Allow unlimited results to be shown
$wgDPL2AllowedNamespaces        = NULL;   // to be initialized at first use of DPL2, array of all namespaces except Media and Special, because we cannot use the DB for these to generate dynamic page lists.
										  // Cannot be customized. Use $wgDPL2Options['namespace'] or $wgDPL2Options['notnamespace'] for customization.

/**
 * Map parameters to possible values.
 * A 'default' key indicates the default value for the parameter.
 * A 'pattern' key indicates a pattern for regular expressions (that the value must match).
 * For some options (e.g. 'namespace'), possible values are not yet defined but will be if necessary (for debugging)
 */
$wgDPL2Options = array(
	'addcategories'        => array('default' => 'false', 'false', 'true'),
	'addpagecounter'       => array('default' => 'false', 'false', 'true'),
	'addpagesize'          => array('default' => 'false', 'false', 'true'),
	'addeditdate'          => array('default' => 'false', 'false', 'true'),
	'addfirstcategorydate' => array('default' => 'false', 'false', 'true'),
	'addpagetoucheddate'   => array('default' => 'false', 'false', 'true'),
	'adduser'              => array('default' => 'false', 'false', 'true'),
	'addauthor'            => array('default' => 'false', 'false', 'true'),
	'addlasteditor'        => array('default' => 'false', 'false', 'true'),
	'allowcachedresults'   => array('default' => 'false', 'false', 'true'),
	'userdateformat'       => array('default' => ''),

	'goal'                 => array('default' => 'pages', 'pages', 'categories'),

	/**
	 * category= Cat11 | Cat12 | ...
	 * category= Cat21 | Cat22 | ...
	 * ...
	 * [Special value] catX='' (empty string without quotes) means pseudo-categoy of Uncategorized pages
	 * Means pages have to be in category (Cat11 OR (inclusive) Cat2 OR...) AND (Cat21 OR Cat22 OR...) AND...
	 * If '+' prefixes the list of categories (e.g. category=+ Cat1 | Cat 2 ...), only these categories can be used as headings in the DPL. See  'headingmode' param.
	 * If '-' prefixes the list of categories (e.g. category=- Cat1 | Cat 2 ...), these categories will not appear as headings in the DPL. See  'headingmode' param.
	 * Magic words allowed.
	 * @todo define 'category' options (retrieve list of categories from 'categorylinks' table?)
	 */
	'category'             => NULL,
	/**
	 * Min and Max of categories allowed for an article
	 */
	'categoriesminmax'     => array('default' => '', 'pattern' => '/^\d*,?\d*$/'),
	/**
	 * number of results which shall be skipped before display starts
	 * default is 0
	 */
	'offset'               => array('default' => '0', 'pattern' => '/^\d*$/'),
	/**
	 * Max of results to display, selection is based on random.
	 */
	'count'                => array('default' => '', 'pattern' => '/^\d*$/'),
	/**
	 * Max number of results to display, selection is based on random.
	 */
	'randomcount'          => array('default' => '', 'pattern' => '/^\d*$/'),
	/**
	 * number of columns for output, default is 1
	 */
	'columns'              => array('default' => '', 'pattern' => '/^\d+$/'),
	/**
	 * number of rows for output, default is 1
	 * note: a "row" is a group of lines for which the heading tags defined in listeseparators will be repeated
	 */
	'rows'                 => array('default' => '', 'pattern' => '/^\d+$/'),
	/**
	 * number of elements in a rows for output, default is "all"
	 * note: a "row" is a group of lines for which the heading tags defined in listeseparators will be repeated
	 */
	'rowsize'              => array('default' => '', 'pattern' => '/^\d+$/'),
	/**
	 * the html tags used for columns and rows
	 */
	'rowcolformat'         => array('default' => ''),
	/**
	 * debug=...
	 * - 0: displays no debug message;
	 * - 1: displays fatal errors only;
	 * - 2: fatal errors + warnings only;
	 * - 3: every debug message.
	 */
	'debug'                => array( 'default' => '1', '0', '1', '2', '3'),
	/**
	 * Mode at the heading level with ordermethod on multiple components, e.g. category heading with ordermethod=category,...:
	 * html headings (H2, H3, H4), definition list, no heading (none), ordered, unordered.
	 */
	'headingmode'          => array( 'default' => 'none', 'H2', 'H3', 'H4', 'definition', 'none', 'ordered', 'unordered'),
	/**
	 * we can display the number of articles within a heading group
	 */
	'headingcount'         => array( 'default' => 'false', 'true', 'false'),
	/**
	 * Attributes for HTML list items (headings) at the heading level, depending on 'headingmode' (e.g. 'li' for ordered/unordered)
	 * Not yet applicable to 'headingmode=none | definition | H2 | H3 | H4'.
	 * @todo Make 'hitemattr' param applicable to  'none', 'definition', 'H2', 'H3', 'H4' headingmodes.
	 * Example: hitemattr= class="topmenuli" style="color: red;"
	 */
	'hitemattr'            => array('default' => ''),
	/**
	 * Attributes for the HTML list element at the heading/top level, depending on 'headingmode' (e.g. 'ol' for ordered, 'ul' for unordered, 'dl' for definition)
	 * Not yet applicable to 'headingmode=none'.
	 * @todo Make 'hlistattr' param applicable to  headingmode=none.
	 * Example: hlistattr= class="topmenul" id="dmenu"
	 */
	'hlistattr'            => array('default' => ''),
	/**
	 * PAGE TRANSCLUSION: includepage=... or include=...
	 * To include the whole page, use a wildcard:
	 * includepage =*
	 * To include sections labeled 'sec1' or 'sec2' or... from the page (see the doc of the LabeledSectionTransclusion extension for more info):
	 * includepage = sec1,sec2,..
	 * To include from the first occurrence of the heading 'heading1' (resp. 'heading2') until the next heading of the same or lower level. Note that this comparison is case insensitive. (See http://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion#Transcluding_visual_headings.) :
	 * includepage = #heading1,#heading2,....
	 * You can combine:
	 * includepage= sec1,#heading1,...
	 * To include nothing from the page (no transclusion), leave empty:
	 * includepage =
	 */
	'includepage'          => array('default' => ''),
	/**
	 * includematch=..,..    allows to specify regular expressions which must match the included contents
	 */
	'includematch'       => array('default' => ''),
	/**
	 * Inline text is some wiki text used to separate list items with 'mode=inline'.
	 */
	'inlinetext'           => array('default' => '&nbsp;-&nbsp;'),
	/**
	 * Max # characters of included page to display.
	 * Empty value (default) means no limit.
	 * If we include setcions the limit will apply to each section.
	 */
	'includemaxlength'     => array('default' => '', 'pattern' => '/^\d*$/'),
	/**
	 * Attributes for HTML list items, depending on 'mode' ('li' for ordered/unordered, 'span' for others).
	 * Not applicable to 'mode=category'.
	 * @todo Make 'itemattr' param applicable to 'mode=category'.
	 * Example: itemattr= class="submenuli" style="color: red;"
	 */
	'itemattr'             => array('default' => ''),
	/**
	 * listseparators is an array of four tags (in html or wiki syntax) which defines the output of DPL2
	 * if mode = 'userformat' was specified.
	 *   '\n' or '�'  in the input will be interpreted as a newline character.
	 *   '%xxx%'      in the input will be replaced by a corresponding value (xxx= PAGE, NR, COUNT etc.)
	 * t1 and t4 are the "outer envelope" for the whole result list,
	 * t2,t3 form an inner envelope around the article name of each entry.
	 * Examples: listseparators={|,,\n#[[%PAGE%]]
	 * Note: use of html tags is discouraged; the first example is better written as:
	 *         : listseparators={|,\n|-\n|[[%PAGE%]],,\n|}
	 */
	'listseparators'       => array('default' => ''),
	/**
	 * sequence of four html tags (separated by ",") to be used together with mode = 'userformat'
	 *              t1 and t4 define an outer frame for the article list
	 *              t2 and t3 build an inner frame for each article name
	 *   example:   listattr=<ul>,<li>,</li>,</ul>
	 */
	'listattr'             => array('default' => ''),
	/**
	 * this parameter restricts the output to articles which can reached via a link from the specified pages.
	 * Examples:   linksfrom=my article|your article
	 */
	'linksfrom'            => array('default' => ''),
	/**
	 * this parameter restricts the output to articles which contain a reference to one of the specified pages.
	 * Examples:   linksto=my article|your article   ,  linksto=Template:my template   ,  linksto = {{FULLPAGENAME}}
	 */
	'linksto'              => array('default' => ''),
	/**
	 * this parameter restricts the output to articles which do not contain a reference to the specified page.
	 */
	'notlinksto'           => array('default' => ''),
	/**
	 * this parameter restricts the output to articles which use the specified template.
	 * Examples:   uses=Template:my template
	 */
	'uses'                 => array('default' => ''),
	/**
	 * this parameter restricts the output to articles which do not use the specified template.
	 * Examples:   notuses=Template:my template
	 */
	'notuses'              => array('default' => ''),
	/**
	 * allows to specify a username who must be the first editor of the pages we select
	 */
	'createdby'            => NULL,
	/**
	 * allows to specify a username who must not be the first editor of the pages we select
	 */
	'notcreatedby'            => NULL,
	/**
	 * allows to specify a username who must be among the editors of the pages we select
	 */
	'modifiedby'           => NULL,
	/**
	 * allows to specify a username who must not be among the editors of the pages we select
	 */
	'notmodifiedby'           => NULL,
	/**
	 * allows to specify a username who must be the last editor of the pages we select
	 */
	'lastmodifiedby'           => NULL,
	/**
	 * allows to specify a username who must not be the last editor of the pages we select
	 */
	'notlastmodifiedby'           => NULL,
	/**
	 * Mode for list of pages (possibly within a heading, see 'headingmode' param).
	 * 'none' mode is implemented as a specific submode of 'inline' with <BR/> as inline text
	 * 'userformat' does not produce any html tags unless 'listseparators' are specified
	 */
	'mode'                 => array('default' => 'unordered', 'category', 'inline', 'none', 'ordered', 'unordered', 'userformat'),
	/**
	 * by default links to articles of type image or category are escaped (i.e. they appear as a link and do not
	 * actually assign the category or show the image; this can be changed.
	 * 'true' default
	 * 'false'  images are shown, categories are assigned to the current document
	 */
	'escapelinks'          => array('default' => 'true','false','true'),
	/**
	 * namespace= Ns1 | Ns2 | ...
	 * [Special value] NsX='' (empty string without quotes) means Main namespace
	 * Means pages have to be in namespace Ns1 OR Ns2 OR...
	 * Magic words allowed.
	 */
	'namespace'            => NULL,
	/**
	 * notcategory= Cat1
	 * notcategory = Cat2
	 * ...
	 * Means pages can be NEITHER in category Cat1 NOR in Cat2 NOR...
	 * Magic words allowed.
	 * @todo define 'notcategory' options (retrieve list of categories from 'categorylinks' table?)
	 */
	'notcategory'          => NULL,
	/**
	 * notnamespace= Ns1
 	 * notnamespace= Ns2
 	 * ...
	 * [Special value] NsX='' (empty string without quotes) means Main namespace
	 * Means pages have to be NEITHER in namespace Ns1 NOR Ns2 NOR...
	 * Magic words allowed.
	*/
	'notnamespace'         => NULL,
	/**
	 * title is the exact name of a page; this is useful if you want to use DPL
	 * just for contents inclusion; mode=userformat is automatically implied with title=
	*/
	'title'		           => NULL,
	/**
	 * titlematch is a (SQL-LIKE-expression) pattern
 	 * which restricts the result to pages matching that pattern
	*/
	'titlematch'           => NULL,
	/**
	 * nottitlematch is a (SQL-LIKE-expression) pattern
 	 * which excludes pages matching that pattern from the result
	*/
	'nottitlematch'        => NULL,
	'order' => array('default' => 'ascending', 'ascending', 'descending'),
	/**
	 * 'ordermethod=param1,param2' means ordered by param1 first, then by param2.
	 * @todo: add 'ordermethod=category,categoryadd' (for each category CAT, pages ordered by date when page was added to CAT).
	 */
	'ordermethod'          => array('default' => 'title', 'counter', 'size',
									'category,firstedit',  'category,lastedit', 'category,pagetouched', 'category,sortkey',
									'categoryadd', 'firstedit', 'lastedit', 'pagetouched',
									'title', 'titlewithoutnamespace', 'user,firstedit', 'user,lastedit'),
	/**
	 * minoredits =... (compatible with ordermethod=...,firstedit | lastedit only)
	 * - exclude: ignore minor edits when sorting the list (rev_minor_edit = 0 only)
	 * - include: include minor edits
	 */
	'minoredits'           => array('default' => 'include', 'exclude', 'include'),
	/**
	 * lastrevisionbefore = select the latest revision which was existent before the specified point in time
	 */
	'lastrevisionbefore'   => array('default' => '', 'pattern' => '#^[-./:0-9]+$#'),
	/**
	 * allrevisionsbefore = select the revisions which were created before the specified point in time
	 */
	'allrevisionsbefore'   => array('default' => '', 'pattern' => '#^[-./:0-9]+$#'),
	/**
	 * firstrevisionsince = select the first revision which was created after the specified point in time
	 */
	'firstrevisionsince'   => array('default' => '', 'pattern' => '#^[-./:0-9]+$#'),
	/**
	 * allrevisionssince = select the latest revisions which were created after the specified point in time
	 */
	'allrevisionssince'    => array('default' => '', 'pattern' => '#^[-./:0-9]+$#'),
	/**
	 * noresultsheader is some wiki text which will be output (instead of a warning message)
	 * if the result set is empty; setting 'noresultsheader' to something like ' ' will suppress
	 * the warning about empty result set.
	 */
	'noresultsheader'      => array('default' => ''),
	/**
	 * openreferences =...
	 * - no: excludes pages which do not exist (=default)
	 * - yes: includes pages which do not exist -- this conflicts with some other options
	 * - only: show only non existing pages [ not implemented so far ]
	 */
	'openreferences'       => array('default' => 'no', 'yes'),
	/**
	 * redirects =...
	 * - exclude: excludes redirect pages from lists (page_is_redirect = 0 only)
	 * - include: allows redirect pages to appear in lists
	 * - only: lists only redirect pages in lists (page_is_redirect = 1 only)
	 */
	'redirects'            => array('default' => 'exclude', 'exclude', 'include', 'only'),
	/**
	 * resultsheader is some wiki text which will be output before the result list
	 * (if there is at least one result)
	 */
	'resultsheader'        => array('default' => ''),
	/**
	 * secseparators  is a sequence of pairs of tags used to separate sections (see "includepage=name1, name2, ..")
	 * each pair corresponds to one entry in the includepage command
	 * if only one tag is given it will be used for all sections as a start tag (end tag will be empty then)
	 */
	'secseparators'        => array('default' => ''),
	/**
	 * multisecseparators is a list of tags (which correspond to the items in includepage)
	 * and which are put between identical sections included from the same file
	 */
	'multisecseparators'   => array('default' => ''),
	/**
	 * dominantSection is the number (starting from 1) of an includepage argument which shall be used
	 * as a dominant value set for the creation of additional output rows (one per value of the
	 * dominant column
	 */
	'dominantsection'      => array('default' => '0', 'pattern' => '/^\d*$/'),
	/**
	 * shownamespace decides whether to show the namespace prefix or not
	 */
	'shownamespace'        => array('default' => 'true', 'false', 'true'),
	/**
	 * replaceintitle applies a regex replacement to %TITLE%
	 */
	'replaceintitle'       => array('default' => ''),
	/**
	 * Max # characters of page title to display.
	 * Empty value (default) means no limit.
	 * Not applicable to mode=category.
	 */
	'titlemaxlength'       => array('default' => '', 'pattern' => '/^\d*$/')
);

/**
 *  Define codes and map debug message to min debug level above which message can be displayed
 */
$wgDPL2DebugCodes = array(
	// (FATAL) ERRORS
	'DPL2_ERR_WRONGNS' 					=> 1,
	'DPL2_ERR_WRONGLINKSTO' 			=> 1,
 	'DPL2_ERR_TOOMANYCATS' 				=> 1,
	'DPL2_ERR_TOOFEWCATS' 				=> 1,
	'DPL2_ERR_NOSELECTION' 				=> 1,
	'DPL2_ERR_CATDATEBUTNOINCLUDEDCATS' => 1,
	'DPL2_ERR_CATDATEBUTMORETHAN1CAT' 	=> 1,
	'DPL2_ERR_MORETHAN1TYPEOFDATE' 		=> 1,
	'DPL2_ERR_WRONGORDERMETHOD' 		=> 1,
	'DPL2_ERR_DOMINANTSECTIONRANGE'		=> 1,
	'DPL2_ERR_NOCLVIEW' 				=> 1,
	'DPL2_ERR_OPENREFERENCES'			=> 1,
	// WARNINGS
	'DPL2_WARN_UNKNOWNPARAM' 			=> 2,
	'DPL2_WARN_WRONGPARAM' 				=> 2,
	'DPL2_WARN_WRONGPARAM_INT' 			=> 2,
	'DPL2_WARN_NORESULTS' 				=> 2,
	'DPL2_WARN_CATOUTPUTBUTWRONGPARAMS' => 2,
	'DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD' => 2,
	'DPL2_WARN_DEBUGPARAMNOTFIRST' 		=> 2,
	'DPL2_WARN_TRANSCLUSIONLOOP' 		=> 2,
	// OTHERS
	'DPL2_QUERY' 						=> 3
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

// Page Transclusion, adopted from Steve Sanbeg�s LabeledSectionTransclusion
require_once( 'DynamicPageList2Include.php' );

function wfDynamicPageList2() {
	global $wgParser, $wgMessageCache, $wgDPL2Messages;
	foreach( $wgDPL2Messages as $sLang => $aMsgs ) {
		$wgMessageCache->addMessages( $aMsgs, $sLang );
	}
	$wgParser->setHook( "DPL", "DynamicPageList2" );
	$wgParser->setHook( "dynamicpagelist", "DynamicPageList2" );
    $wgParser->setHook( 'section', 'removeSectionMarkers' );

}

// The callback function wrapper for converting the input text to HTML output
function DynamicPageList2( $input, $params, &$parser ) {
	// create list and do a recursive parse of the output
	return $parser->recursiveTagParse(DynamicPageList($input, $params, $parser));

}

//remove section markers in case the LabeledSectionTransclusion extension is not installed.
function removeSectionMarkers( $in, $assocArgs=array(), $parser=null ) {
	return '';
}

// The real callback function for converting the input text to HTML output
function DynamicPageList( $input, $params, &$parser ) {

	error_reporting(E_ALL);

	global  $wgUser, $wgContLang, $wgDPL2AllowedNamespaces, $wgDPL2Options, $wgDPL2MaxCategoryCount, $wgDPL2MinCategoryCount, $wgDPL2MaxResultCount, $wgDPL2AllowUnlimitedCategories, $wgDPL2AllowUnlimitedResults;
	global $wgTitle;

	//logger (display of debug messages)
	$logger = new DPL2Logger();

	//check that we are not in an infinite transclusion loop
	if ( isset( $parser->mTemplatePath[$parser->mTitle->getPrefixedText()] ) ) {
		return $logger->escapeMsg(DPL2_WARN_TRANSCLUSIONLOOP, $parser->mTitle->getPrefixedText());
	}

	/**
	 * Initialization
	 */
	 // Local parser created. See http://meta.wikimedia.org/wiki/MediaWiki_extensions_FAQ#How_do_I_render_wikitext_in_my_extension.3F
	$localParser = new Parser();
	$pOptions = $parser->mOptions;
	$pTitle = $parser->mTitle;

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

	$sGoal = $wgDPL2Options['goal']['default'];

	$bSelectionCriteriaFound=false;
	$bConflictsWithOpenReferences=false;

	// we allow " like " or "="
	$sCategoryComparisonMode    = '=';
	$sNotCategoryComparisonMode = '=';
	$sTitleMatchMode            = ' LIKE ';
	$sNotTitleMatchMode         = ' LIKE ';

	$aOrderMethods = explode(',', $wgDPL2Options['ordermethod']['default']);
	$sOrder = $wgDPL2Options['order']['default'];

	$sPageListMode = $wgDPL2Options['mode']['default'];

	$sHListMode = $wgDPL2Options['headingmode']['default'];
	$bHeadingCount = $wgDPL2Options['headingcount']['default'] == 'true';

	$bEscapeLinks = $wgDPL2Options['escapelinks']['default'];

	$sMinorEdits = NULL;
	$acceptOpenReferences = ($wgDPL2Options['openreferences']['default'] != 'no');

	$sLastRevisionBefore = $wgDPL2Options['lastrevisionbefore']['default'];
	$sAllRevisionsBefore = $wgDPL2Options['allrevisionsbefore']['default'];
	$sFirstRevisionSince = $wgDPL2Options['firstrevisionsince']['default'];
	$sAllRevisionsSince  = $wgDPL2Options['allrevisionssince']['default'];

	$sRedirects = $wgDPL2Options['redirects']['default'];

	$sResultsHeader = $wgDPL2Options['resultsheader']['default'];
	$sNoResultsHeader = $wgDPL2Options['noresultsheader']['default'];

	$aListSeparators = array();

	$sInlTxt = $wgDPL2Options['inlinetext']['default'];

	$bShowNamespace = $wgDPL2Options['shownamespace']['default'] == 'true';

	$bAddFirstCategoryDate = $wgDPL2Options['addfirstcategorydate']['default'] == 'true';

	$bAddPageCounter = $wgDPL2Options['addpagecounter']['default'] == 'true';

	$bAddPageSize = $wgDPL2Options['addpagesize']['default'] == 'true';

	$bAddPageTouchedDate = $wgDPL2Options['addpagetoucheddate']['default'] == 'true';

	$bAddEditDate = $wgDPL2Options['addeditdate']['default'] == 'true';

	$bAddUser       = $wgDPL2Options['adduser']['default'] == 'true';
	$bAddAuthor     = $wgDPL2Options['addauthor']['default'] == 'true';
	$bAddLastEditor = $wgDPL2Options['addlasteditor']['default'] == 'true';

	$bAllowCachedResults = $wgDPL2Options['allowcachedresults']['default'] == 'true';

	$sUserDateFormat = $wgDPL2Options['userdateformat']['default'];

	$bAddCategories = $wgDPL2Options['addcategories']['default'] == 'true';

	$_incpage = $wgDPL2Options['includepage']['default'];
	$bIncPage =  is_string($_incpage) && $_incpage !== '';

	$aSecLabels = array();
	if($bIncPage && $_incpage != '*') $aSecLabels = explode(',', $_incpage);
	$aSecLabelsMatch = array();

	$aSecSeparators = array();
    $aSecSeparators      = explode(',', $wgDPL2Options['secseparators']['default']);
	$aMultiSecSeparators = explode(',', $wgDPL2Options['multisecseparators']['default']);
	$iDominantSection = $wgDPL2Options['dominantsection']['default'];

	$_sOffset = $wgDPL2Options['offset']['default'];
	$iOffset  = ($_sOffset == '') ? 0: intval($_sOffset);

	$_sCount = $wgDPL2Options['count']['default'];
	$iCount = ($_sCount == '') ? NULL: intval($_sCount);

	$_sColumns = $wgDPL2Options['columns']['default'];
	$iColumns  = ($_sColumns == '') ? 1: intval($_sColumns);

	$_sRows    = $wgDPL2Options['rows']['default'];
	$iRows     = ($_sRows == '') ? 1: intval($_sRows);

	$_sRowSize = $wgDPL2Options['rowsize']['default'];
	$iRowSize  = ($_sRowSize == '') ? 0: intval($_sRowSize);

	$sRowColFormat= $wgDPL2Options['rowcolformat']['default'];

	$_sRandomCount = $wgDPL2Options['randomcount']['default'];
	$iRandomCount = ($_sRandomCount == '') ? NULL: intval($_sRandomCount);

	$sListHtmlAttr = $wgDPL2Options['listattr']['default'];
	$sItemHtmlAttr = $wgDPL2Options['itemattr']['default'];

	$sHListHtmlAttr = $wgDPL2Options['hlistattr']['default'];
	$sHItemHtmlAttr = $wgDPL2Options['hitemattr']['default'];

	$_sTitleMaxLen = $wgDPL2Options['titlemaxlength']['default'];
	$iTitleMaxLen = ($_sTitleMaxLen == '') ? NULL: intval($_sTitleMaxLen);

	$aReplaceInTitle[0] = '';
	$aReplaceInTitle[1] = '';

	$_sCatMinMax  = $wgDPL2Options['categoriesminmax']['default'];
	$aCatMinMax   = ($_sCatMinMax == '') ? NULL: explode(',',$_sCatMinMax);

	$_sIncludeMaxLen = $wgDPL2Options['includemaxlength']['default'];
	$iIncludeMaxLen = ($_sIncludeMaxLen == '') ? NULL: intval($_sIncludeMaxLen);

	$aLinksTo       = array();
	$aNotLinksTo    = array();
	$aLinksFrom     = array();
	$aNotLinksFrom  = array();

	$aUses       = array();
	$aNotUses    = array();

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

	// Output
	$output = '';

// ###### PARSE PARAMETERS ######

	// we replace double angle brackets by < > ; thus we avoid premature tag expansion in the input
	$input = str_replace('»','>',$input);
	$input = str_replace('«','<',$input);


	// use the � as a general alias for |
	$input = str_replace('¦','|',$input); // the symbol is utf8-escaped

	$aParams = explode("\n", $input);
	$bIncludeUncat = false; // to check if pseudo-category of Uncategorized pages is included

	// version 0.9:
	// we do not parse parameters recursively when reading them in.
	// we rather leave them unchanged, produce the complete output and then finally
	// parse the result recursively. This allows to build complex structures in the output
	// which are only understood by the parser if seen as a whole

	foreach($aParams as $iParam => $sParam) {

		$aParam = explode('=', $sParam, 2);
		if( count( $aParam ) < 2 )
			continue;

		# Security fix  by Inez
		/*
		if(is_string($aParam[1])) {
			$aParam[1] = addslashes($aParam[1]);
		}
		*/

		$sType = trim($aParam[0]);
		$sArg = trim($aParam[1]);

		// ignore comment lines
		if ($sType[0] == '#') continue;

		switch ($sType) {

			/**
			 * GOAL
			 */
			case 'goal':
				if( in_array($sArg, $wgDPL2Options['goal']) ) {
					$sGoal = $sArg;
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('goal', $sArg);
				break;

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
				$aParams = explode('|', $sArg);
				foreach($aParams as $sParam) {
					$sParam=trim($sParam);
					if($sParam == '') { // include uncategorized pages (special value: empty string)
						$bIncludeUncat = true;
						$aCategories[] = '';
					} else {
						if ($sParam[0]=='*') {
							$sParamList = explode('|',getSubcategories(substr($sParam,1)));
							foreach ($sParamList as $sPar) {
								$title = Title::newFromText($localParser->transformMsg($sPar, $pOptions));
								if( !is_null($title) )	$aCategories[] = $title->getDbKey();
							}
						}
						else {
							$title = Title::newFromText($localParser->transformMsg($sParam, $pOptions));
							if( !is_null($title) )	$aCategories[] = $title->getDbKey();
						}
					}
				}
				if( !empty($aCategories) ) {
					$aIncludeCategories[] = $aCategories;
					if($bHeading)		$aCatHeadings 	 = array_unique($aCatHeadings + $aCategories);
					if($bNotHeading)	$aCatNotHeadings = array_unique($aCatNotHeadings + $aCategories);
					$bConflictsWithOpenReferences=true;
				}
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
			case 'notcategory':
				$title = Title::newFromText($localParser->transformMsg($sArg, $pOptions));
				if( !is_null($title) ) {
					$aExcludeCategories[] = $title->getDbKey();
					$bConflictsWithOpenReferences=true;
				}
				break;

			case 'namespace':
				$aParams = explode('|', $sArg);
				foreach($aParams as $sParam) {
					$sParam=trim($sParam);
					$sNs = $localParser->transformMsg($sParam, $pOptions);
					if( !in_array($sNs, $wgDPL2Options['namespace']) )
						return $logger->msgWrongParam('namespace', $sParam);
					$aNamespaces[] = $wgContLang->getNsIndex($sNs);
					$bSelectionCriteriaFound=true;
				}
				break;

			case 'notnamespace':
				$sArg=trim($sArg);
				$sNs = $localParser->transformMsg($sArg, $pOptions);
				if( !in_array($sNs, $wgDPL2Options['notnamespace']) )
					return $logger->msgWrongParam('notnamespace', $sArg);
				$aExcludeNamespaces[] = $wgContLang->getNsIndex($sNs);
				$bSelectionCriteriaFound=true;
				break;

			case 'linksto':
				$pages = explode('|', trim($sArg));
				$n=0;
				foreach($pages as $page) {
					if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('linksto', $sArg);
					$aLinksTo[$n++] = $theTitle;
					$bSelectionCriteriaFound=true;
				}
				if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('linksto', $sArg);
				$bConflictsWithOpenReferences=true;
				break;

			case 'notlinksto':
				$pages = explode('|', trim($sArg));
				$n=0;
				foreach($pages as $page) {
					if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('notlinksto', $sArg);
					$aNotLinksTo[$n++] = $theTitle;
					$bSelectionCriteriaFound=true;
				}
				if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('notlinksto', $sArg);
				$bConflictsWithOpenReferences=true;
				break;

			case 'linksfrom':
				$pages = explode('|', trim($sArg));
				$n=0;
				foreach($pages as $page) {
					if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('linksfrom', $sArg);
					$aLinksFrom[$n++] = $theTitle;
					$bSelectionCriteriaFound=true;
				}
				if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('linksfrom', $sArg);
				break;

			case 'notlinksfrom':
				$pages = explode('|', trim($sArg));
				$n=0;
				foreach($pages as $page) {
					if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('notlinksfrom', $sArg);
					$aNotLinksFrom[$n++] = $theTitle;
					$bSelectionCriteriaFound=true;
				}
				if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('notlinksfrom', $sArg);
				break;

			case 'uses':
				$pages = explode('|', $sArg);
				$n=0;
				foreach($pages as $page) {
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
					if (!($theTitle = Title::newFromText(trim($page)))) return $logger->msgWrongParam('notuses', $sArg);
					$aNotUses[$n++] = $theTitle;
					$bSelectionCriteriaFound=true;
				}
				if(!$bSelectionCriteriaFound) return $logger->msgWrongParam('notuses', $sArg);
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

			case 'titleregexp':
				$sTitleMatchMode = ' REGEXP ';
				$aTitleMatch = array($sArg);
				$bSelectionCriteriaFound=true;
				break;
			case 'titlematch':
				// we replace blanks by underscores to meet the internal representation
				// of page names in the database
				$aTitleMatch = explode('|', str_replace(' ','_',$localParser->transformMsg($sArg, $pOptions)));
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
				$aNotTitleMatch = explode('|', str_replace(' ','_',$localParser->transformMsg($sArg, $pOptions)));
				$bSelectionCriteriaFound=true;
				break;

			case 'minoredits':
				if( in_array($sArg, $wgDPL2Options['minoredits']) ) {
					$sMinorEdits = $sArg;
					$bConflictsWithOpenReferences=true;
				}
				else { //wrong param val, using default
					$sMinorEdits = $wgDPL2Options['minoredits']['default'];
					$output .= $logger->msgWrongParam('minoredits', $sArg);
				}
				break;

			case 'lastrevisionbefore':
			case 'allrevisionsbefore':
			case 'firstrevisionsince':
			case 'allrevisionssince':
				if( preg_match($wgDPL2Options[$sType]['pattern'], $sArg) ) {
					if (($sType) == 'lastrevisionbefore')	$sLastRevisionBefore = str_pad(preg_replace('/[^0-9]/','',$sArg),14,'0');
					if (($sType) == 'allrevisionsbefore')	$sAllRevisionsBefore = str_pad(preg_replace('/[^0-9]/','',$sArg),14,'0');
					if (($sType) == 'firstrevisionsince')	$sFirstRevisionSince = str_pad(preg_replace('/[^0-9]/','',$sArg),14,'0');
					if (($sType) == 'allrevisionssince')	$sAllRevisionsSince  = str_pad(preg_replace('/[^0-9]/','',$sArg),14,'0');
					$bConflictsWithOpenReferences=true;
				}
				else // wrong value
					$output .= $logger->msgWrongParam($sType, $sArg);
				break;

			case 'openreferences':
				if( in_array($sArg, $wgDPL2Options['openreferences']) )
					$acceptOpenReferences = ($sArg != 'no');
				else
					$output .= $logger->msgWrongParam('openreferences', $sArg);
				break;

			case 'redirects':
				if( in_array($sArg, $wgDPL2Options['redirects']) ) {
					$sRedirects = $sArg;
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('redirects', $sArg);
				break;

			case 'offset':
				//ensure that $iOffset is a number
				if( preg_match($wgDPL2Options['offset']['pattern'], $sArg) )
					$iOffset = ($sArg == '') ? 0: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('offset', $sArg);
				break;

			case 'count':
				//ensure that $iCount is a number or no count limit;
				if( preg_match($wgDPL2Options['count']['pattern'], $sArg) )
					$iCount = ($sArg == '') ? NULL: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('count', $sArg);
				break;

			case 'randomcount':
				//ensure that $iRandomCount is a number;
				if( preg_match($wgDPL2Options['randomcount']['pattern'], $sArg) )
					$iRandomCount = ($sArg == '') ? NULL: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('randomcount', $sArg);
				break;

			case 'categoriesminmax':
				if( preg_match($wgDPL2Options['categoriesminmax']['pattern'], $sArg) )
					$aCatMinMax = ($sArg == '') ? NULL: explode(',',$sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('categoriesminmax', $sArg);
				break;

			/**
			 * CONTENT PARAMETERS
			 */
			case 'addcategories':
				if( in_array($sArg, $wgDPL2Options['addcategories'])) {
					$bAddCategories = ($sArg == 'true');
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addcategories', $sArg);
				break;

			case 'addeditdate':
				if( in_array($sArg, $wgDPL2Options['addeditdate'])) {
					$bAddEditDate = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addeditdate', $sArg);
				break;

			case 'addfirstcategorydate':
				if( in_array($sArg, $wgDPL2Options['addfirstcategorydate'])) {
					$bAddFirstCategoryDate = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addfirstcategorydate', $sArg);
				break;

			case 'addpagecounter':
				if( in_array($sArg, $wgDPL2Options['addpagecounter'])) {
					$bAddPageCounter = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addpagecounter', $sArg);
				break;

			case 'addpagesize':
				if( in_array($sArg, $wgDPL2Options['addpagesize'])) {
					$bAddPageSize = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addpagesize', $sArg);
				break;

			case 'addpagetoucheddate':
				if( in_array($sArg, $wgDPL2Options['addpagetoucheddate'])) {
					$bAddPageTouchedDate = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addpagetoucheddate', $sArg);
				break;

			case 'include':
			case 'includepage':
				$bIncPage =  $sArg !== '';
				if($bIncPage && $sArg != '*')
					$aSecLabels= explode(',', $sArg);
				break;

			case 'includematch':
				$aSecLabelsMatch= explode(',', $sArg);
				break;

			case 'adduser':
				if( in_array($sArg, $wgDPL2Options['adduser'])) {
					$bAddUser = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('adduser', $sArg);
				break;

			case 'addauthor':
				if( in_array($sArg, $wgDPL2Options['addauthor'])) {
					$bAddAuthor = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addauthor', $sArg);
				break;

			case 'addlasteditor':
				if( in_array($sArg, $wgDPL2Options['addlasteditor'])) {
					$bAddLastEditor = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('addlasteditor', $sArg);
				break;

			/**
			 * ORDER PARAMETERS
			 */
			case 'ordermethod':
				if( in_array($sArg, $wgDPL2Options['ordermethod']) ) {
					$aOrderMethods = explode(',', $sArg);
					$bConflictsWithOpenReferences=true;
				}
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

			case 'columns':
				//ensure that $iColumns is a number
				if( preg_match($wgDPL2Options['columns']['pattern'], $sArg) )
					$iColumns = ($sArg == '') ? 1: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('columns', $sArg);
				break;

			case 'rows':
				//ensure that $iRows is a number
				if( preg_match($wgDPL2Options['rows']['pattern'], $sArg) )
					$iRows = ($sArg == '') ? 1: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('rows', $sArg);
				break;

			case 'rowsize':
				//ensure that $iRowSize is a number
				if( preg_match($wgDPL2Options['rowsize']['pattern'], $sArg) )
					$iRowSize = ($sArg == '') ? 0: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('rowsize', $sArg);
				break;

			case 'rowcolformat':
				$sRowColFormat= $sArg;
				break;

			case 'userdateformat':
				$sUserDateFormat = $sArg;
				break;

			case 'headingmode':
				if( in_array($sArg, $wgDPL2Options['headingmode']) ) {
					$sHListMode = $sArg;
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('headingmode', $sArg);
				break;

			case 'headingcount':
				if( in_array($sArg, $wgDPL2Options['headingcount'])) {
					$bHeadingCount = $sArg == 'true';
					$bConflictsWithOpenReferences=true;
				}
				else
					$output .= $logger->msgWrongParam('headingcount', $sArg);
				break;

			case 'mode':
				if( in_array($sArg, $wgDPL2Options['mode']) )
					//'none' mode is implemented as a specific submode of 'inline' with <BR/> as inline text
					if($sArg == 'none') {
						$sPageListMode = 'inline';
						$sInlTxt = '<BR/>';
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

			case 'escapelinks':
				if( in_array($sArg, $wgDPL2Options['escapelinks']))
					$bEscapeLinks = $sArg == 'true';
				else
					$output .= $logger->msgWrongParam('escapelinks', $sArg);
				break;

			case 'inlinetext':
				$sInlTxt = $sArg;
				break;

			case 'listseparators':
				// parsing of wikitext will happen at the end of the output phase
				// we replace '\n' in the input by linefeed because wiki syntax depends on linefeeds
				$sArg = str_replace( '\n', "\n", $sArg );
				$sArg = str_replace( "¶", "\n", $sArg ); // the paragraph demlimiter is utf8-escaped
				$aListSeparators = explode (',', $sArg, 4);
				break;

			case 'secseparators':
				// we replace '\n' by newline to support wiki syntax within the section separators
				$sArg = str_replace( '\n', "\n", $sArg );
				$sArg = str_replace( "¶", "\n", $sArg ); // the paragraph demlimiter is utf8-escaped
				$aSecSeparators = explode (',',$sArg);
				break;

			case 'multisecseparators':
				// we replace '\n' by newline to support wiki syntax within the section separators
				$sArg = str_replace( '\n', "\n", $sArg );
				$sArg = str_replace( "¶", "\n", $sArg ); // the paragraph demlimiter is utf8-escaped
				$aMultiSecSeparators = explode (',',$sArg);
				break;

			case 'dominantsection':
				if( preg_match($wgDPL2Options['dominantsection']['pattern'], $sArg) )
					$iDominantSection = ($sArg == '') ? NULL: intval($sArg);
				else // wrong value
					$output .= $logger->msgWrongParam('dominantsection', $sArg);
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

			case 'replaceintitle':
				// we offer a possibility to replace some part of the title
				$aReplaceInTitle = explode (',',$sArg,2);
				break;

			case 'includemaxlength':
				//processed like 'count' param
				if( preg_match($wgDPL2Options['includemaxlength']['pattern'], $sArg) )
					$iIncludeMaxLen = ($sArg == '') ? NULL: intval($sArg);
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
			case 'resultsheader':
				$sResultsHeader = $sArg;
				break;
			case 'noresultsheader':
				$sNoResultsHeader = $sArg;
				break;

			/**
			 * DEBUG and CACHE PARAMETER
			 */

 			case 'allowcachedresults':
				if( in_array($sArg, $wgDPL2Options['allowcachedresults'])) {
					$bAllowCachedResults = $sArg == 'true';
				}
				else
					$output .= $logger->msgWrongParam('allowcachedresults', $sArg);
				break;

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

	// no selection criteria!!
	if ($iTotalCatCount == 0 && $bSelectionCriteriaFound==false)
		return $logger->escapeMsg(DPL2_ERR_NOSELECTION);

	// no included categories but ordermethod=categoryadd or addfirstcategorydate=true!!
	if ($iTotalIncludeCatCount == 0 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
		return $logger->escapeMsg(DPL2_ERR_CATDATEBUTNOINCLUDEDCATS);

	// more than one included category but ordermethod=categoryadd or addfirstcategorydate=true!!
	// we ALLOW this parameter combination, risking ambiguous results
	//if ($iTotalIncludeCatCount > 1 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
	//	return $logger->escapeMsg(DPL2_ERR_CATDATEBUTMORETHAN1CAT);

	// no more than one type of date at a time!!
	if($bAddPageTouchedDate + $bAddFirstCategoryDate + $bAddEditDate > 1)
		return $logger->escapeMsg(DPL2_ERR_MORETHAN1TYPEOFDATE);

	// the dominant section must be one of the sections mentioned in includepage
	if($iDominantSection>0 && count($aSecLabels)<$iDominantSection)
		return $logger->escapeMsg(DPL2_ERR_DOMINANTSECTIONRANGE, count($aSecLabels));

	// category-style output requested with not compatible order method
	if ($sPageListMode == 'category' && !array_intersect($aOrderMethods, array('sortkey', 'title','titlewithoutnamespace')) )
		return $logger->escapeMsg(DPL2_ERR_WRONGORDERMETHOD,  'mode=category', 'sortkey | title | titlewithoutnamespace' );

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
	if( $sPageListMode == 'category' && ($bAddCategories || $bAddEditDate || $bAddFirstCategoryDate || $bAddPageTouchedDate
										|| $bIncPage || $bAddUser || $bAddAuthor || $bAddLastEditor ) )
		$output .= $logger->escapeMsg(DPL2_WARN_CATOUTPUTBUTWRONGPARAMS);

	//headingmode has effects with ordermethod on multiple components only
	if( $sHListMode != 'none' && count($aOrderMethods) < 2 ) {
		$output .= $logger->escapeMsg(DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD, $sHListMode, 'none');
		$sHListMode = 'none';
	}

	// openreferences is incompatible with many other options
	if( $acceptOpenReferences && $bConflictsWithOpenReferences ) {
		$output .= $logger->escapeMsg(DPL2_ERR_OPENREFERENCES);
		$acceptOpenReferences=false;
	}

	// justify limits; if we have an offset and count is specified we increase count by the offset
	if ( isset($iCount) ) {
		if (isset($iOffset)) $iCountWithOffset = $iCount + $iOffset;
		else				 $iCountWithOffset = $iCount;
		if($iCountWithOffset > $wgDPL2MaxResultCount)
			$iCountWithOffset = $wgDPL2MaxResultCount;
	} elseif(!$wgDPL2AllowUnlimitedResults)
		$iCountWithOffset = $iCount = $wgDPL2MaxResultCount;

// disable parser cache
 	if ( !$bAllowCachedResults) $parser->disableCache();


// ###### BUILD SQL QUERY ######
	$sSqlPage_counter = '';
	$sSqlPage_size = '';
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
	$sSqlRev_id = '';
	$sSqlRev_user = '';
	$sSqlCond_page_rev = '';
	$sPageLinksTable = $dbr->tableName( 'pagelinks' );
	$sTemplateLinksTable = $dbr->tableName( 'templatelinks' );
	$sSqlPageLinksTable = '';
	$sSqlCond_page_pl = '';
	$sSqlCond_MaxCat = '';
	$sSqlWhere = ' WHERE 1=1 ';
	$sSqlGroupBy = '';

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
				// UTF-8 created problems with non-utf-8 MySQL databases
				$sSqlSortkey = ", IFNULL(cl_head.cl_sortkey, REPLACE(CONCAT( IF(page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), page_title), '_', ' ')) as sortkey";
			case 'titlewithoutnamespace':
				$sSqlSortkey = ", page_title as sortkey";
				break;
			case 'title':
				$aStrictNs = array_slice($wgDPL2AllowedNamespaces, 1, count($wgDPL2AllowedNamespaces), true);
				// map ns index to name
				if ($acceptOpenReferences) {
					$sSqlNsIdToText = 'CASE pl_namespace';
					foreach($aStrictNs as $iNs => $sNs)
						$sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
					$sSqlNsIdToText .= ' END';
					$sSqlSortkey = ", REPLACE(CONCAT( IF(pl_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), pl_title), '_', ' ') as sortkey";
				}
				else {
					$sSqlNsIdToText = 'CASE page_namespace';
					foreach($aStrictNs as $iNs => $sNs)
						$sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
					$sSqlNsIdToText .= ' END';
					// Generate sortkey like for category links. UTF-8 created problems with non-utf-8 MySQL databases
					$sSqlSortkey = ", REPLACE(CONCAT( IF(page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), page_title), '_', ' ') as sortkey";
				}
				break;
			case 'user':
				$sSqlRevisionTable = $sRevisionTable . ', ';
				$sSqlRev_user = ', rev_user, rev_user_text';
				break;
		}
	}

	if ( count($aLinksTo)>0 ) {
		$sSqlPageLinksTable .= $sPageLinksTable . ' as pl, ';
		$sSqlCond_page_pl .= ' AND page_id=pl.pl_from AND (';
		$n=0;
		foreach ($aLinksTo as $link) {
			if ($n>0) $sSqlCond_page_pl .= ' OR ';
			$sSqlCond_page_pl .= '(pl.pl_namespace=' . intval( $link->getNamespace() ) .
				" AND pl.pl_title=" . $dbr->addQuotes( $link->getDbKey() ).')';
			$n++;
		}
		$sSqlCond_page_pl .= ')';
 	}

 	if ( count($aNotLinksTo)>0 ) {
		$sSqlCond_page_pl .= ' AND page_id not in (select '.$sPageLinksTable.'.pl_from from '.$sPageLinksTable.' where (';
		$n=0;
		foreach ($aNotLinksTo as $link) {
			if ($n>0) $sSqlCond_page_pl .= ' OR ';
			$sSqlCond_page_pl .= '('.$sPageLinksTable.'.pl_namespace=' . intval($link->getNamespace())
				.' AND '.$sPageLinksTable.'.pl_title=' . $dbr->addQuotes( $link->getDbKey() ).')';
			$n++;
		}
		$sSqlCond_page_pl .= ') )';
 	}

	if ( count($aLinksFrom)>0 ) {
		if ($acceptOpenReferences) {
			$sSqlCond_page_pl .= ' AND (';
			$n=0;
			foreach ($aLinksFrom as $link) {
				if ($n>0) $sSqlCond_page_pl .= ' OR ';
				$sSqlCond_page_pl .= '(pl_from=' . $link->getArticleID().')';
				$n++;
			}
			$sSqlCond_page_pl .= ')';
		}
		else {
			$sSqlPageLinksTable .= $sPageLinksTable . ' as plf, ';
			$sSqlCond_page_pl .= ' AND page_namespace = plf.pl_namespace AND page_title = plf.pl_title AND (';
			$n=0;
			foreach ($aLinksFrom as $link) {
				if ($n>0) $sSqlCond_page_pl .= ' OR ';
				$sSqlCond_page_pl .= '(plf.pl_from=' . $link->getArticleID().')';
				$n++;
			}
			$sSqlCond_page_pl .= ')';
		}
 	}

	if ( count($aNotLinksFrom)>0 ) {
		if ($acceptOpenReferences) {
			$sSqlCond_page_pl .= ' AND (';
			$n=0;
			foreach ($aNotLinksFrom as $link) {
				if ($n>0) $sSqlCond_page_pl .= ' AND ';
				$sSqlCond_page_pl .= 'pl_from <> ' . $link->getArticleID(). ' ';
				$n++;
			}
			$sSqlCond_page_pl .= ')';
		}
		else {
			$sSqlCond_page_pl .= ' AND CONCAT(page_namespace,page_title) not in (select CONCAT('.$sPageLinksTable.'.pl_namespace,'
								.$sPageLinksTable.'.pl_title) from '.$sPageLinksTable.' where (';
			$n=0;
			foreach ($aNotLinksFrom as $link) {
				if ($n>0) $sSqlCond_page_pl .= ' OR ';
				$sSqlCond_page_pl .= $sPageLinksTable.'.pl_from=' . $link->getArticleID(). ' ';
				$n++;
			}
			$sSqlCond_page_pl .= '))';
		}
	}

 	if ( count($aUses)>0 ) {
		$sSqlPageLinksTable .= ' '.$sTemplateLinksTable . ' as tl, ';
		$sSqlCond_page_pl .= ' AND page_id=tl.tl_from  AND (';
		$n=0;
		foreach ($aUses as $link) {
			if ($n>0) $sSqlCond_page_pl .= ' OR ';
			$sSqlCond_page_pl .= '(tl.tl_namespace=' . intval( $link->getNamespace() ) .
				" AND tl.tl_title=" . $dbr->addQuotes( $link->getDbKey() ).')';
			$n++;
		}
		$sSqlCond_page_pl .= ')';
 	}

 	if ( count($aNotUses)>0 ) {
		$sSqlCond_page_pl .= ' AND page_id not in (select '.$sTemplateLinksTable.'.tl_from from '.$sTemplateLinksTable.' where (';
		$n=0;
		foreach ($aNotUses as $link) {
			if ($n>0) $sSqlCond_page_pl .= ' OR ';
			$sSqlCond_page_pl .= '('.$sTemplateLinksTable.'.tl_namespace=' . intval($link->getNamespace())
				.' AND '.$sTemplateLinksTable.'.tl_title=' . $dbr->addQuotes( $link->getDbKey() ).')';
			$n++;
		}
		$sSqlCond_page_pl .= ') )';
 	}


 	if ( $sCreatedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sCreatedBy.'\' = (select rev_user_text from '.$sRevisionTable
							.' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp ASC limit 1)';
 	}
	if ( $sNotCreatedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sNotCreatedBy.'\' != (select rev_user_text from '.$sRevisionTable
							.' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp ASC limit 1)';
 	}
 	if ( $sModifiedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sModifiedBy.'\' in (select rev_user_text from '.$sRevisionTable
							.' where '.$sRevisionTable.'.rev_page=page_id)';
 	}
 	if ( $sNotModifiedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sNotModifiedBy.'\' not in (select rev_user_text from '.$sRevisionTable.' where '.$sRevisionTable.'.rev_page=page_id)';
 	}
 	if ( $sLastModifiedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sLastModifiedBy.'\' = (select rev_user_text from '.$sRevisionTable
							.' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp DESC limit 1)';
 	}
	if ( $sNotLastModifiedBy != "" ) {
		$sSqlCond_page_rev .= ' AND \''.$sNotLastModifiedBy.'\' != (select rev_user_text from '.$sRevisionTable
							.' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp DESC limit 1)';
 	}

 	if ($bAddAuthor && $sSqlRevisionTable =='') {
		$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
		$sSqlCond_page_rev = ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
	}
 	if ($bAddLastEditor && $sSqlRevisionTable =='') {
		$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
		$sSqlCond_page_rev = ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
	}


 	if ($sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince != '') {

	 	// later during output we are going to create html links to the revisions, so we must enable RawHtml
	 	// wiki syntax does not support links to revisions as far as I know -- gs
		global $wgRawHtml;
		$wgRawHtml = true;

		$sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
		$sSqlRev_timestamp = ', rev_timestamp';
		$sSqlRev_id = ', rev_id';
	 	if ($sLastRevisionBefore!='') {
			$sSqlCond_page_rev .= ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page AND rev_aux.rev_timestamp < '.$sLastRevisionBefore.')';
		}
		else if  ($sAllRevisionsBefore!='') {
			$sSqlCond_page_rev .= ' AND page_id=rev.rev_page AND rev.rev_timestamp < '.$sAllRevisionsBefore;
		}
	 	else if ($sFirstRevisionSince!='') {
			$sSqlCond_page_rev .= ' AND page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page AND rev_aux.rev_timestamp >= '.$sFirstRevisionSince.')';
		}
		else if ($sAllRevisionsSince!='') {
			$sSqlCond_page_rev .= ' AND page_id=rev.rev_page AND rev.rev_timestamp >= '.$sAllRevisionsSince;
		}
	}

	if ( isset($aCatMinMax[0]) && $aCatMinMax[0]!='' ) {
		$sSqlCond_MaxCat .= ' AND ' . $aCatMinMax[0] . ' <= (select count(*) from ' . $sCategorylinksTable .
		' where '.$sCategorylinksTable.'.cl_from=page_id)';
 	}
	if ( isset($aCatMinMax[1]) && $aCatMinMax[1]!='') {
		$sSqlCond_MaxCat .= ' AND ' . $aCatMinMax[1] . ' >= (select count(*) from ' . $sCategorylinksTable .
		' where '.$sCategorylinksTable.'.cl_from=page_id)';
 	}

	if ($bAddFirstCategoryDate)
		//format cl_timestamp field (type timestamp) to string in same format as rev_timestamp field
		//to make it compatible with $wgLang->date() function used in function DPL2OutputListStyle() to show "firstcategorydate"
		$sSqlCl_timestamp = ", DATE_FORMAT(cl0.cl_timestamp, '%Y%m%d%H%i%s') AS cl_timestamp";
	if ($bAddPageCounter)
		$sSqlPage_counter = ', page_counter';
	if ($bAddPageSize)
		$sSqlPage_size = ', page_len';
	if ($bAddPageTouchedDate)
		$sSqlPage_touched = ', page_touched';
	if ($bAddUser || $bAddAuthor || $bAddLastEditor || $sSqlRevisionTable != '')
		$sSqlRev_user = ', rev_user, rev_user_text';
	if ($bAddCategories) {
		$sSqlCats = ", GROUP_CONCAT(DISTINCT cl_gc.cl_to ORDER BY cl_gc.cl_to ASC SEPARATOR ' | ') AS cats";
		// Gives list of all categories linked from each article, if any.
		$sSqlClTableForGC = $sCategorylinksTable . ' AS cl_gc';
		// Categorylinks table used by the Group Concat (GC) function above
		$sSqlCond_page_cl_gc = 'page_id=cl_gc.cl_from';
		$sSqlGroupBy = ' GROUP BY ' . $sSqlCl_to . 'page_id';
	}

	// SELECT ... FROM
	if ($acceptOpenReferences)
		$sSqlSelectFrom = 'SELECT DISTINCT ' . $sSqlCl_to . 'pl_namespace, pl_title' . $sSqlSortkey . ' FROM ' . $sPageLinksTable;
	else
		$sSqlSelectFrom = 'SELECT DISTINCT ' . $sSqlCl_to . 'page_namespace, page_title' . $sSqlSortkey . $sSqlPage_counter . $sSqlPage_size . $sSqlPage_touched . $sSqlRev_user . $sSqlRev_timestamp . $sSqlRev_id . $sSqlCats . $sSqlCl_timestamp . ' FROM ' . $sSqlRevisionTable . $sSqlPageLinksTable . $sPageTable;

	// JOIN ...
	if($sSqlClHeadTable != '' || $sSqlClTableForGC != '') {
		$b2tables = ($sSqlClHeadTable != '') && ($sSqlClTableForGC != '');
		$sSqlSelectFrom .= ' LEFT OUTER JOIN (' . $sSqlClHeadTable . ($b2tables ? ', ' : '') . $sSqlClTableForGC . ') ON (' . $sSqlCond_page_cl_head . ($b2tables ? ' AND ' : '') . $sSqlCond_page_cl_gc . ')';
	}

	// Include categories...
	$iClTable = 0;
	for ($i = 0; $i < $iIncludeCatCount; $i++) {
		// If we want the Uncategorized
		$sSqlSelectFrom .= ' INNER JOIN ' . ( in_array('', $aIncludeCategories[$i]) ? $sDplClView : $sCategorylinksTable ) .
						   ' AS cl' . $iClTable . ' ON page_id=cl' . $iClTable . '.cl_from AND (cl' . $iClTable . '.cl_to'.
						   $sCategoryComparisonMode . $dbr->addQuotes($aIncludeCategories[$i][0]);
		for ($j = 1; $j < count($aIncludeCategories[$i]); $j++)
			$sSqlSelectFrom .= ' OR cl' . $iClTable . '.cl_to' . $sCategoryComparisonMode . $dbr->addQuotes($aIncludeCategories[$i][$j]);
		$sSqlSelectFrom .= ') ';
		$iClTable++;
	}

	// Exclude categories...
	for ($i = 0; $i < $iExcludeCatCount; $i++) {
		$sSqlSelectFrom .=
			' LEFT OUTER JOIN ' . $sCategorylinksTable . ' AS cl' . $iClTable .
			' ON page_id=cl' . $iClTable . '.cl_from' .
			' AND cl' . $iClTable . '.cl_to'. $sNotCategoryComparisonMode . $dbr->addQuotes($aExcludeCategories[$i]);
		$sSqlWhere .= ' AND cl' . $iClTable . '.cl_to IS NULL';
		$iClTable++;
	}

	// WHERE... (actually finish the WHERE clause we may have started if we excluded categories - see above)
	// Namespace IS ...
	if ( !empty($aNamespaces)) {
		if ($acceptOpenReferences)
			$sSqlWhere .= ' AND pl_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
		else
			$sSqlWhere .= ' AND page_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
	}
	// Namespace IS NOT ...
    if ( !empty($aExcludeNamespaces)) {
		if ($acceptOpenReferences)
	        $sSqlWhere .= ' AND pl_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
		else
	        $sSqlWhere .= ' AND page_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
    }

	// TitleIs
 	if ( $sTitleIs != '' ) {
        $sSqlWhere .= ' AND page_title = ' . $dbr->addQuotes($sTitleIs);
 	}

	// TitleMatch ...
 	if ( count($aTitleMatch)>0 ) {
        $sSqlWhere .= ' AND (';
		$n=0;
		foreach ($aTitleMatch as $link) {
			if ($n>0) $sSqlWhere .= ' OR ';
			if ($acceptOpenReferences)
    	    	$sSqlWhere .= 'pl_title' . $sTitleMatchMode . '\'' . $link .'\'';
   			else
    	    	$sSqlWhere .= 'page_title' . $sTitleMatchMode . '\'' . $link .'\'';
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
			if ($acceptOpenReferences)
	        	$sSqlWhere .= 'pl_title' . $sNotTitleMatchMode . '\'' . $link .'\'';
			else
	        	$sSqlWhere .= 'page_title' . $sNotTitleMatchMode . '\'' . $link .'\'';
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
				$sSqlWhere .= ' AND page_is_redirect=1';
				break;
			case 'exclude':
				$sSqlWhere .= ' AND page_is_redirect=0';
				break;
		}
	}

	// page_id=rev_page (if revision table required)
	$sSqlWhere .= $sSqlCond_page_rev;

	// count(all categories) <= max no of categories
	$sSqlWhere .= $sSqlCond_MaxCat;

	// page_id=pl.pl_from (if pagelinks table required)
	$sSqlWhere .= $sSqlCond_page_pl;

	// GROUP BY ...
	$sSqlWhere .= $sSqlGroupBy;

	// ORDER BY ...
	if ($aOrderMethods[0]!='') {
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
				case 'size':
					$sSqlWhere .= 'page_len';
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
				case 'titlewithoutnamespace':
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
	}

	if ($sAllRevisionsSince!='' || $sAllRevisionsBefore!='') $sSqlWhere .= ', rev_id DESC';

	// LIMIT ....
	// we must switch off LIMITS when going for categories as output goal (due to mysql limitations)
	if ( isset($iCount) && $sGoal != 'categories' )
		$sSqlWhere .= ' LIMIT ' . intval( $iCountWithOffset );

	// when we go for a list of categories as result we transforn the output of the normal query into a subquery
	// of a selection on the categorylinks

	if ($sGoal=='categories') {
		$sSqlSelectFrom = 'select distinct cl3.cl_to from '.$sCategorylinksTable.' as cl3 where cl3.cl_from in ( ' .
							preg_replace('/SELECT DISTINCT .* FROM /','SELECT DISTINCT page_id FROM ',$sSqlSelectFrom);
		if ($sOrder == 'descending')	$sSqlWhere .= ' ) order by cl3.cl_to DESC';
		else							$sSqlWhere .= ' ) order by cl3.cl_to ASC';
	}


// ###### PROCESS SQL QUERY ######
	//DEBUG: output SQL query
	$output .= $logger->escapeMsg(DPL2_QUERY, $sSqlSelectFrom . $sSqlWhere);

	// echo "\n\n\nQUERY: [" . $sSqlSelectFrom . $sSqlWhere . "]<br />";

	$res = $dbr->query($sSqlSelectFrom . $sSqlWhere);
	if ($dbr->numRows( $res ) <= $iOffset) {
		if ($sNoResultsHeader != '')	$output .= $sNoResultsHeader;
		else							$output .= $logger->escapeMsg(DPL2_WARN_NORESULTS);
		return $output;
	}
	if ($sResultsHeader != '')	$output .= str_replace('%PAGES%',$dbr->numRows($res)-$iOffset,$sResultsHeader) . "\n";

	$sk =& $wgUser->getSkin();
	// generate title for Special:Contributions (used if adduser=true)
	$sSpecContribs = '[[:Special:Contributions|Contributions]]';

	$aHeadings = array(); // maps heading to count (# of pages under each heading)
	$aArticles = array();

	// pick some elements by random
	$pick[0]=true;

	if (isset($iRandomCount)) {
		$nResults = $dbr->numRows( $res ) - $iOffset;
		srand((float) microtime() * 10000000);
		if ($iRandomCount>$nResults) $iRandomCount = $nResults;
		$r=0;
		while (true) {
			$rnum = mt_rand(1,$nResults);
			if (!isset($pick[$rnum+$iOffset])) {
				$pick[$rnum+$iOffset] = true;
				$r++;
				if ($r>=$iRandomCount) break;
			}
		}
	}


	$iArticle = 0;

	while( $row = $dbr->fetchObject ( $res ) ) {
		$iArticle++;

		// skip result lines up to the offset
		if ($iArticle <= $iOffset) continue;

		// in random mode skip articles which were not chosen
		if (isset($iRandomCount) && !isset($pick[$iArticle]))  continue;

		if ($sGoal=='categories') {
			$pageNamespace = 14;  // CATEGORY
			$pageTitle     = $row->cl_to;
		} else if ($acceptOpenReferences) {
			// existing PAGE TITLE
			$pageNamespace = $row->pl_namespace;
			$pageTitle     = $row->pl_title;
		}
		else {
			// maybe non-existing title
			$pageNamespace = $row->page_namespace;
			$pageTitle     = $row->page_title;
		}
		$title = Title::makeTitle($pageNamespace, $pageTitle);

		// block recursion: avoid to show the page which contains the DPL statement as part of the result
		if ($title->getNamespace() == $wgTitle->getNamespace() &&
		    $title->getText()     == $wgTitle->getText()) continue;

		$dplArticle = new DPL2Article( $title, $pageNamespace );
		//PAGE LINK
		$sTitleText = $title->getText();
		if ($aReplaceInTitle[0]!='') $sTitleText = preg_replace($aReplaceInTitle[0],$aReplaceInTitle[1],$sTitleText);

		//chop off title if "too long"
		if( isset($iTitleMaxLen) && (strlen($sTitleText) > $iTitleMaxLen) )
			$sTitleText = substr($sTitleText, 0, $iTitleMaxLen) . '...';
		if ($bShowNamespace)
			//Adapted from Title::getPrefixedText()
            $sTitleText = str_replace( '_', ' ', $title->prefix($sTitleText) );
        if ($bEscapeLinks && ($pageNamespace==14 || $pageNamespace==6) ) {
	        // links to categories or images need an additional ":"
			$articleLink = '[[:'.$title->getPrefixedText().'|'.$wgContLang->convert( $sTitleText ).']]';
        } else {
			$articleLink = '[['.$title->getPrefixedText().'|'.$wgContLang->convert( $sTitleText ).']]';
		}
		$dplArticle->mLink = $articleLink;

		//get first char used for category-style output
		if( isset($row->sortkey) ) {
			$dplArticle->mStartChar = $wgContLang->convert($wgContLang->firstChar($row->sortkey));
		}
		//SHOW PAGE_COUNTER
		if( isset($row->page_counter) )
			$dplArticle->mCounter = $row->page_counter;

		//SHOW PAGE_SIZE
		if( isset($row->page_len) )
			$dplArticle->mSize = $row->page_len;

		if ($bGoalIsPages) {
			//REVISION SPECIFIED
			if( $sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince !='') {
				$dplArticle->mRevision = $row->rev_id;
				$dplArticle->mUser = $row->rev_user_text;
				$dplArticle->mDate = $row->rev_timestamp;
			}

			//SHOW "PAGE_TOUCHED" DATE, "FIRSTCATEGORYDATE" OR (FIRST/LAST) EDIT DATE
			if($bAddPageTouchedDate) 		$dplArticle->mDate = $row->page_touched;
			elseif ($bAddFirstCategoryDate)	$dplArticle->mDate = $row->cl_timestamp;
			elseif ($bAddEditDate)			$dplArticle->mDate = $row->rev_timestamp;

			if ($dplArticle->mDate!='' && $sUserDateFormat!='') {
				// we add one space for nicer formatting
			    $dplArticle->myDate = gmdate($sUserDateFormat,wfTimeStamp(TS_UNIX,$dplArticle->mDate)).' ';
			}
			//USER/AUTHOR(S)
			// because we are going to do a recursive parse at the end of the output phase
			// we have to generate wiki syntax for linking to a user�s homepage
			if($bAddUser || $bAddAuthor || $bAddLastEditor || $sLastRevisionBefore.$sAllRevisionsBefore.$sFirstRevisionSince.$sAllRevisionsSince != '') {
				$dplArticle->mUserLink  = '[[User:'.$row->rev_user_text.'|'.$row->rev_user_text.']]';
				$dplArticle->mUser = $row->rev_user_text;
			}

			//CATEGORY LINKS FROM CURRENT PAGE
			if($bAddCategories && $bGoalIsPages && ($row->cats != '')) {
				$artCatNames = explode(' | ', $row->cats);
				foreach($artCatNames as $iArtCat => $artCatName) {
					$dplArticle->mCategoryLinks[] = '[[:Category:'.$artCatName.'|'.str_replace('_',' ',$artCatName).']]';
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

// ###### SHOW OUTPUT ######
	$listMode = new DPL2ListMode($sPageListMode, $aSecSeparators, $aMultiSecSeparators, $sInlTxt, $sListHtmlAttr,
								 $sItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);
	$hListMode = new DPL2ListMode($sHListMode, $aSecSeparators, $aMultiSecSeparators, '', $sHListHtmlAttr,
								  $sHItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);
	$dpl = new DPL2($aHeadings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $aArticles,
					$aOrderMethods[0], $hListMode, $listMode, $bEscapeLinks, $bIncPage, $iIncludeMaxLen,
					$aSecLabels, $aSecLabelsMatch, $parser, $logger, $aReplaceInTitle);
	return $output . $dpl->getText();
}








// Simple Article/Page class with properties used in the DPL
class DPL2Article {
	var $mTitle = ''; 		// title
	var $mNamespace = -1;	// namespace (number)
	var $mLink = ''; 		// html link to page
	var $mStartChar = ''; 	// page title first char
	var $mParentHLink = ''; // heading (link to the associated page) that page belongs to in the list (default '' means no heading)
	var $mCategoryLinks = array(); // category links in the page
	var $mCounter = ''; 	// Number of times this page has been viewed
	var $mSize = ''; 		// Article length in bytes of wiki text
	var $mDate = ''; 		// timestamp depending on the user's request (can be first/last edit, page_touched, ...)
	var $myDate = ''; 		// the same, based on user format definition
	var $mRevision = '';    // the revision number if specified
	var $mUserLink = ''; 	// link to editor (first/last, depending on user's request) 's page or contributions if not registered
	var $mUser = ''; 		// name of editor (first/last, depending on user's request) or contributions if not registered

	function DPL2Article($title, $namespace) {
		$this->mTitle     = $title;
		$this->mNamespace = $namespace;
	}
}

function getSubcategories($cat) {
	$dbr =& wfGetDB( DB_SLAVE );
	$cats=$cat;
	$res = $dbr->query("select distinct page_title from ".$dbr->tableName('page')." inner join "
			.$dbr->tableName('categorylinks')." as cl0 on page_id = cl0.cl_from and cl0.cl_to='"
	       .$cat."'"." where page_namespace='14'");
	while( $row = $dbr->fetchObject ( $res ) ) {
		$cats .= '|'.$row->page_title;
	}
	$dbr->freeResult( $res );
	return $cats;
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
	var $sSectionTags = array();
	var $aMultiSecSeparators = array();
	var $iDominantSection = -1;

	function DPL2ListMode($listmode, $secseparators, $multisecseparators, $inlinetext, $listattr = '', $itemattr = '',
						  $listseparators, $iOffset, $dominantSection) {
		// default for inlinetext (if not in mode=userformat)
		if (($listmode != 'userformat') && ($inlinetext == ''))
			$inlinetext = '&nbsp;-&nbsp;';
		$this->name = $listmode;
		$_listattr = ($listattr == '') ? '' : ' ' . Sanitizer::fixTagAttributes( $listattr, 'ul' );
		$_itemattr = ($itemattr == '') ? '' : ' ' . Sanitizer::fixTagAttributes( $itemattr, 'li' );

		$this->sSectionTags = $secseparators;
		$this->aMultiSecSeparators = $multisecseparators;
		$this->iDominantSection = $dominantSection - 1;  // 0 based index

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
				if ($iOffset==0) $this->sListStart = '<OL' . $_listattr . '>';
				else 			 $this->sListStart = '<OL start=' . ($iOffset+1) . ' ' . $_listattr . '>';
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
			case 'userformat':
				switch(count($listseparators)) {
					case 4:
						$this->sListEnd = $listseparators[3];
					case 3:
						$this->sItemEnd = $listseparators[2];
					case 2:
						$this->sItemStart = $listseparators[1];
					case 1:
						$this->sListStart = $listseparators[0];
				}
				$this->sInline = $inlinetext;
				break;
		}
	}
}


class DPL2 {

	var $mArticles;
	var $mHeadingType; 	// type of heading: category, user, etc. (depends on 'ordermethod' param)
	var $mHListMode; 	// html list mode for headings
	var $mListMode;		// html list mode for pages
	var $mEscapeLinks;	// whether to escape img/cat or not
	var $mIncPage; 		// true only if page transclusion is enabled
	var $mIncMaxLen; 	// limit for text to include
	var $mIncSecLabels      = array(); // array of labels of sections to transclude
	var $mIncSecLabelsMatch = array(); // array of match patterns for sections to transclude
	var $mParser;
	var $mParserOptions;
	var $mParserTitle;
	var $mLogger; 		// DPL2Logger
	var $mOutput;
	var $mReplaceInTitle;

	function DPL2($headings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $articles, $headingtype, $hlistmode,
				  $listmode, $bescapelinks, $includepage, $includemaxlen, $includeseclabels, $includeseclabelsmatch, &$parser, $logger, $replaceInTitle) {
		$this->mArticles = $articles;
		$this->mListMode = $listmode;
		$this->mEscapeLinks = $bescapelinks;
		$this->mIncPage = $includepage;
		if($includepage) {
			$this->mIncSecLabels      = $includeseclabels;
			$this->mIncSecLabelsMatch = $includeseclabelsmatch;
		}

		if (isset($includemaxlen)) $this->mIncMaxLen = $includemaxlen + 1;
		else					   $this->mIncMaxLen = 0;
		$this->mParser = $parser;
		$this->mParserOptions = $parser->mOptions;
		$this->mParserTitle = $parser->mTitle;
		$this->mLogger = $logger;
		$this->mReplaceInTitle = $replaceInTitle;

		if(!empty($headings)) {
			$this->mHeadingType = $headingtype;
			$this->mHListMode = $hlistmode;
			$this->mOutput .= $hlistmode->sListStart;
			$headingStart = 0;
			foreach($headings as $heading => $headingCount) {
				$headingLink = $articles[$headingStart]->mParentHLink;
				$this->mOutput .= $hlistmode->sItemStart;
				$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
				if ($bHeadingCount) $this->mOutput .= $this->formatCount($headingCount);
				$this->mOutput .= $this->formatList($headingStart, $headingCount);
				$this->mOutput .= $hlistmode->sItemEnd;
				$headingStart += $headingCount;
			}
			$this->mOutput .= $hlistmode->sListEnd;
		} else if ($iColumns!=1 || $iRows!=1) {
			// repeat outer tags for each of the specified columns / rows in the output
			$nstart  = 0;
			$count   = count($articles);
			if ($iColumns != 1) $iGroup = $iColumns;
			else				$iGroup = $iRows;
			$nsize   = floor($count / $iGroup);
			$rest    = $count - (floor($nsize) * floor($iGroup));
			if ($rest>0) $nsize += 1;
			$this->mOutput .= "{|".$sRowColFormat."\n|\n";
			for ($g=0;$g<$iGroup;$g++) {
				$this->mOutput .= $this->formatList($nstart, $nsize);
				if ($iColumns!=1) 	$this->mOutput .= "\n|valign=top|\n";
				else				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				if ($rest != 0 && $g+1==$rest) $nsize -= 1;
				if ($nstart+$nsize > $count) $nsize = $count - $nstart;
			}
			$this->mOutput .= "\n|}\n";
		} else if ($iRowSize>0) {
			// repeat row header after n lines of output
			$nstart  = 0;
			$nsize   = $iRowSize;
			$count   = count($articles);
			$this->mOutput .= '{|'.$sRowColFormat."\n|\n";
			do {
				if ($nstart+$nsize > $count) $nsize = $count - $nstart;
				$this->mOutput .= $this->formatList($nstart, $nsize);
				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				if ($nstart >= $count) break;
			} while (true);
			$this->mOutput .= "\n|}\n";
		} else {
			$this->mOutput .= $this->formatList(0, count($articles));
		}

	}

	function formatCount($numart) {
		global $wgLang;
		if($this->mHeadingType == 'category')
			$message = 'categoryarticlecount';
		else
			$message = 'dpl2_articlecount';
		return '<p>' . $this->msgExt( $message, array( 'parse' ), $numart) . '</p>';
	}

	// substitute symbolic names within a user defined format tag
	function substTagParm($tag, $pagename, $article, $nr) {
		global $wgLang;
		if (strchr($tag,'%')<0) return $tag;
		$sTag	 							  = str_replace('%PAGE%',$pagename,$tag);

		$title = $article->mTitle->getText();
		if (strpos($title,'%TITLE')>=0) {
			if ($this->mReplaceInTitle[0]!='') $title = preg_replace($this->mReplaceInTitle[0],$this->mReplaceInTitle[1],$title);
			$sTag = str_replace('%TITLE%',$title,$sTag);
		}

	    $sTag 								  = str_replace('%NR%',$nr,$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNT%',$article->mCounter,$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNTFS%',floor(log($article->mCounter)*0.7),$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNTFS2%',floor(sqrt(log($article->mCounter))),$sTag);
	    if ($article->mSize     != '') 	$sTag = str_replace('%SIZE%',$article->mSize,$sTag);
	    if ($article->mSize     != '') 	$sTag = str_replace('%SIZEFS%',floor(sqrt(log($article->mSize))*2.5-5),$sTag);
	    if ($article->mDate     != '')  {
		    // note: we must avoid literals in the code which could create confusion when transferred via http
		    //       therefore we write '%'.'DA...'
			if ($article->myDate != '') $sTag = str_replace('%'.'DATE%',$article->myDate,$sTag);
			else 		    		    $sTag = str_replace('%'.'DATE%',$wgLang->timeanddate($article->mDate, true),$sTag);
	   	}
	    if ($article->mRevision != '') 	$sTag = str_replace('%REVISION%',$article->mRevision,$sTag);
    	if ($article->mUserLink != '')	$sTag = str_replace('%USER%',$article->mUser,$sTag);
	    if (!empty($article->mCategoryLinks) ) $sTag = str_replace('%'.'CATLIST%',implode(', ', $article->mCategoryLinks),$sTag);
	    else 									$sTag = str_replace('%'.'CATLIST%','',$sTag);
		return $sTag;
	}

	function formatList($iStart, $iCount) {
		global $wgUser, $wgLang, $wgContLang;

		$mode = $this->mListMode;
		//categorypage-style list output mode
		if($mode->name == 'category')
			return $this->formatCategoryList($iStart, $iCount);

		//other list modes
		$sk = & $wgUser->getSkin();

		//process results of query, outputing equivalent of <li>[[Article]]</li> for each result,
		//or something similar if the list uses other startlist/endlist;
		$r = $mode->sListStart;
		for ($i = $iStart; $i < $iStart+$iCount; $i++) {
			$article = $this->mArticles[$i];
			$pagename = $article->mTitle->getPrefixedText();
			if ($this->mEscapeLinks && ($article->mNamespace==14 || $article->mNamespace==6) ) {
	        	// links to categories or images need an additional ":"
				$pagename = ':'.$pagename;
			}

			// Page transclusion: get contents and apply selection criteria based on that contents

			if ($this->mIncPage) {
				$matchFailed=false;
				if(empty($this->mIncSecLabels)) {
					// include whole article
					$title = $article->mTitle->getPrefixedText();
					if ($mode->name == 'userformat') $incwiki = '';
					else							 $incwiki = '<br/>';
					$text = $this->mParser->fetchTemplate(Title::newFromText($title));
					if( $this->mIncMaxLen > 0 && (strlen($text) > $this->mIncMaxLen) ) {
						$text = wfDplLstReduceTextToSize($text, $this->mIncMaxLen, ' [['.$title.'|..&rarr;]]');
					}
					$incwiki .= $text;

				} else {
					// identify section pieces
					$secPiece=array();
					$dominantPieces=false;
					// ONE section can be marked as "dominant"; if this section contains multiple entries
					// we will create a separate output row for each value of the dominant section
					// the values of all other columns will be repeated
					$secArray=array();

					foreach ($this->mIncSecLabels as $s => $sSecLabel) {
						$sSecLabel = trim($sSecLabel);
						if ($sSecLabel == '') break;
 						// is sections are identified by number we have a % at the beginning
 						if ($sSecLabel[0] == '%') $sSecLabel = '#'.$sSecLabel;

						$maxlen=-1;
						$limpos = strpos($sSecLabel,'[');
						$cutLink='default';
						if ($limpos>0 && $sSecLabel[strlen($sSecLabel)-1]==']') {
							$cutInfo=explode(" ",substr($sSecLabel,$limpos+1,strlen($sSecLabel)-$limpos-2),2);
							$sSecLabel=substr($sSecLabel,0,$limpos);
							$maxlen=intval($cutInfo[0]);
							if (isset($cutInfo[1])) $cutLink=$cutInfo[1];
						}
						if ($maxlen<0) $maxlen = -1;  // without valid limit include whole section

						// find out if the user specified an includematch condition
						if (count($this->mIncSecLabelsMatch)>$s && $this->mIncSecLabelsMatch[$s] != '') $mustMatch = $this->mIncSecLabelsMatch[$s];
						else																			$mustMatch = '';

						// if chapters are selected by number we get the heading from wfDplLstIncludeHeading
						$sectionHeading='';
						if($sSecLabel[0] == '#') {
							$sectionHeading=substr($sSecLabel,1);
							// Uses wfDplLstIncludeHeading() from LabeledSectionTransclusion extension to include headings from the page
							$secPieces = wfDplLstIncludeHeading($this->mParser, $article->mTitle->getPrefixedText(), substr($sSecLabel, 1),'',
																$sectionHeading,false,$maxlen,$cutLink);
							if ($mustMatch!='') {
								$secPiecesTmp = $secPieces;
								$offset=0;
								foreach($secPiecesTmp as $nr => $onePiece ) {
									if (!ereg($mustMatch,$onePiece)) {
										array_splice($secPieces,$nr-$offset,1);
										$offset++;
									}
								}
							}
							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])? $this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $i+1):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if ($mustMatch!='' && count($secPieces)<=0) {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}

						} else if($sSecLabel[0] == '{') {
							// Uses wfDplLstIncludetemplate() from LabeledSectionTransclusion extension to include templates from the page
 							$template1 = substr($sSecLabel,1,strpos($sSecLabel,'}')-1);
 							$template2 = str_replace('}','',substr($sSecLabel,1));
 							$secPieces = wfDplLstIncludeTemplate($this->mParser, $article->mTitle->getPrefixedText(), $template1, $template2, $template2.'.default',$mustMatch);
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])? $this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $i+1):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if ($mustMatch!='' && count($secPieces)<=1 && $secPieces[0]=='') {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}
						} else {
							// Uses wfDplLstInclude() from LabeledSectionTransclusion extension to include labeled sections from the page
							$secPiece[$s] = wfDplLstInclude($this->mParser, $article->mTitle->getPrefixedText(), $sSecLabel,'', false);
							if ($mustMatch!='') {
								if (!ereg($mustMatch,$secPiece[$s])) {
									$matchFailed=true;
									break;
								}
							}

						}

						// separator tags
						if (count($mode->sSectionTags)==1) {
							// If there is only one separator tag use it always
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[0], $pagename, $article, $i+1));
						}
						else if (isset($mode->sSectionTags[$s*2])) {
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[$s*2], $pagename, $article, $i+1));
						}
						else $septag[$s*2] = '';
						if (isset($mode->sSectionTags[$s*2+1])) {
							$septag[$s*2+1] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[$s*2+1], $pagename, $article, $i+1));
						}
						else $septag[$s*2+1]='';

					}

					// if there was a match condition on included contents which failed we skip the whole page
					if ($matchFailed) continue;

					// assemble parts with separators
					$incwiki='';
					if ($dominantPieces!=false) {
						foreach ($dominantPieces as $dominantPiece) {
							foreach ($secPiece as $s => $piece) {
								$incwiki.=$septag[$s*2];
								if ($s==$mode->iDominantSection) 	$incwiki.=$dominantPiece;
								else								$incwiki.=$piece;
								$incwiki.=$septag[$s*2+1];
							}
						}
					}
					else {
						foreach ($secPiece as $s => $piece) {
							$incwiki.=$septag[$s*2];
							$incwiki.=$piece;
							$incwiki.=$septag[$s*2+1];
						}
					}
				}
			}

			if($i > $iStart) $r .= $mode->sInline; //If mode is not 'inline', sInline attribute is empty, so does nothing

			// symbolic substitution of %PAGE% by the current article's name
			if ($mode->name == 'userformat') {
				$r .= $this->substTagParm($mode->sItemStart, $pagename, $article, $i+1);
			}
			else {
				$r .= $mode->sItemStart;
				if($article->mDate != '') {
					if ($article->myDate != '') {
						if($article->mRevision != '') 	$r .= ' <html><a href="'.$pagename.'?oldid='.$article->mRevision.'">'
														   .  $article->myDate.'</a></html>';
						else 							$r .= $article->myDate;
					} else {
						if($article->mRevision != '') 	$r .= ' <html><a href="'.$pagename.'?oldid='.$article->mRevision.'">'
														   .  $wgLang->timeanddate($article->mDate, true).'</a></html> : ';
						else 							$r .= $wgLang->timeanddate($article->mDate, true) . ': ';
					}
				}
				// output the link to the article
				$r .= $article->mLink;
				if($article->mSize != '' && $mode->name != 'userformat') {
					if (strlen($article->mSize) > 3)	$r .=  ' [' . substr($article->mSize,0,strlen($article->mSize)-3) . ' kB]';
					else								$r .=  ' [' . $article->mSize . ' B]';
				}
				if($article->mCounter != '' && $mode->name != 'userformat') {
					// Adapted from SpecialPopularPages::formatResult()
					$nv = $this->msgExt( 'nviews', array( 'parsemag', 'escape'), $wgLang->formatNum( $article->mCounter ) );
					$r .=  ' ' . $wgContLang->getDirMark() . '(' . $nv . ')';
				}
				if($article->mUserLink != '')	$r .= ' . . [[User:' . $article->mUser .'|'.$article->mUser.']]';

				if( !empty($article->mCategoryLinks) )	$r .= ' . . <SMALL>' . wfMsg('categories') . ': ' . implode(' | ', $article->mCategoryLinks) . '</SMALL>';
			}

			// add included contents

			if ($this->mIncPage) {
				wfDplLst_open_($this->mParser, $this->mParserTitle->getPrefixedText());
				$r .= $incwiki;
				wfDplLst_close_($this->mParser, $this->mParserTitle->getPrefixedText());
			}

			if ($mode->name == 'userformat') {
				$r .= $this->substTagParm($mode->sItemEnd, $pagename, $article,$i+1);
			}
			else
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
			return "__NOTOC____NOEDITSECTION__".CategoryViewer::columnList( $aArticles, $aArticles_start_char );
		} elseif ( count($aArticles) > 0) {
			// for short lists of articles in categories.
			return "__NOTOC____NOEDITSECTION__".CategoryViewer::shortList( $aArticles, $aArticles_start_char );
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
			return '<p>%DPL-' . DPL2_VERSION . '-' .  wfMsg('dpl2_debug_' . $msgid, $args) . '</p>';
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
		return call_user_func_array( array( $this, 'msg' ), $args );
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
			case 'notlinksto':
			case 'linksfrom':
				$msgid = DPL2_ERR_WRONGLINKSTO;
				break;
			case 'count':
			case 'titlemaxlength':
				$msgid = DPL2_WARN_WRONGPARAM_INT;
			case 'includemaxlength':
				$msgid = DPL2_WARN_WRONGPARAM_INT;
				break;
		}
		$paramoptions = array_unique($wgDPL2Options[$paramvar]);
		sort($paramoptions);
		return $this->escapeMsg( $msgid, $paramvar, htmlspecialchars( $val ), $wgDPL2Options[$paramvar]['default'], implode(' | ', $paramoptions ));
	}

}

//---------------------------------------------------------------------------- variant as a parser #function

function wfDynamicPageList3()
{
  global $wgParser;
  $wgParser->setFunctionHook( 'dpl', 'wfDynamicPageList4' );
}

function wfDynamicPageList3_Magic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitivity, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['dpl'] = array( 0, 'dpl' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

function wfDynamicPageList4(&$parser)
{
	$params = array();
	$input="";

	$numargs = func_num_args();
	if ($numargs < 2) {
	  $input = "#dpl: no arguments specified";
	  return str_replace('�','<','�pre>�nowiki>'.$input.'�/nowiki>�/pre>');
	}

	// fetch all user-provided arguments (skipping $parser)
	$arg_list = func_get_args();
	for ($i = 1; $i < $numargs; $i++) {
	  $p1 = $arg_list[$i];
	  $input .= str_replace("\n","",$p1) ."\n";
	}
	// for debugging you may want to uncomment the following statement
	//return str_replace('�','<','�pre>�nowiki>'.$input.'�/nowiki>�/pre>');
	return DynamicPageList( $input, $params, $parser );
}

?>
