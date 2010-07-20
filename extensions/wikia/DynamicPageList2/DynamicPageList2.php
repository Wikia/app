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
 *          allow ¦ as an alias for |
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
 * @version 1.2.1
 *			added missing $dbr->addQuotes() on SQL arguments
 *			titlemaxlength now also works with mode=userformat
 * @version 1.2.2
 *			added variable CATNAMES (i.e. category list without links)
 *          changed code to allow multiple selection conditions on revisions
 * @version 1.2.3
 *          accept %0 for transclusion of text before the first chapter
 *			added experimental feature for graph generation
 * @version 1.2.4
 *          error corrected: ordermethod "sortkey" did not work because of missing break in case statement
 *			removed experimental feature for graph generation
 *          repair error with wrong counting of selected articles
 * @version 1.2.5
 *          added includenotmatch
 * @version 1.2.6
 *          added 'distinct' option
 *          added '%PAGESEL%' variable
 *			linksto, linksfrom etc. no longer complain about empty parameters
 *          changed SQL query basics to allow duplicate use of page table;
 *          linksto and linksfrom may cause SQL syntax trouble if something was missed
 * @version 1.2.7
 *          bugfix with %PAGES% and multicolumn output
 *          bugfix with undefined variable sPageTable near #2257
 * @version 1.2.8
 *          syntax - allow 'format' as an alias for 'listseparators'
 *          syntax - if 'format' or 'listseparators' is set, 'mode=userformat' will be automatically assumed
 *			internal - empty parameters are silently ignored
 * @version 1.2.9
 *          resultsfooter
 *			\n and Para will be replaced by linefeed in resultsheader and -footer
 *		    parameter recognition in 'include={template}:nameOrNumber' improved; nested template calls are now handled correctly
 * @version 1.3.0
 *          accept 'yes' and 'no' as synonyms for 'true' and 'false' at all boolean parameters
 * @version 1.3.1
 *          minor modification: resultsheader and resultsfooter do no longer automatically write a newline
 * @version 1.3.2
 *          the warning caused by missing selection criteria will now only be issued if no DEBUG level was set
 *          %NAMESPACE% added
 *			headingmode now works with multiple columns (space for 1 heading == 2 entries)
 *			bugfix: parameter syntax errors were not shown in some cases
 *			new parameter: reset (clears references of a DPL page to templates, images, categories, other pages
 *          to be used with care as ALL links are cleared, regardless where they come from
 *			bugfix: ambiguous 'page_name' in SQL statement fixed (appeared when namespace= and linksfrom= were used together)
 *			modification: includematch: uses always preg instead of ereg - patterns must have delimiters! Before #patterns
 *			had been matched using ereg
 *          ?? includematch should be checked to be a valid preg_match argument
 *			added oneresultheader
 * @version 1.3.3
 *          bugfix: parameter checking fixed at 'ordermethod'; multiple parameters were not checked correctly
 * @version 1.3.4
 *          column size calculation changed at multi column output
 *			ambiguity of page_id at linksfrom+...(e.g. uses) eliminated.
 *			subcategory expansion: replace ' ' by '_' in query
 * @version 1.3.5
 *          bug at ordermethod=category,sortkey resolved
 * @version 1.3.6
 *          special page for DPL deleted
 *          allow individual collations for sorting, this makes case insensitive sorting possible
 *			hardwired collation change: for sorting the club suit symbol's sort value is changed
 *          so that the club suit will always appear AFTER the diamond suit
 *			bugfix: %PAGES% did not work in mode=category
 *			added a switch to include/exclude subpages
 * @version 1.3.7
 *			allow 0 and 1 for boolean parameters, and on / off
 *			bugfix: in release 1.3.6 using odermethod=sortkey led to a SQL syntax error
 * @version 1.3.8
 *			bugfix at template parameter etxraction: balance of square brackets is now checked when extracting a single parameter
 * @version 1.3.9
 *			added pagesel as sortkey in ordermethod
 *			added noresultsfooter, oneresultfooter
 *			added 'table' parameter -- needs a {xyz}.dpl construct as first include parameter
 * @version 1.4.0
 *			added option 'strict' to 'distinct'
 * @version 1.4.1
 *			minor bugfix at option 'strict' of 'distinct'
 *			behaviour of DEBUG changed
 * @version 1.4.2
 *			bug fix SQL error in 'group by' clause (with table prefix)
 *			bugfix: ordermethod sortkey now implies ordermethod category
 *			bugfix: SQL error in some constellations using addpagecounter, addpagesize or add...date
 *		    allow multiple parameters of a template to be returned directly as table columns
 *			design change: reset is handled differently now; no need for a separate DPL statement
 *			new parameter 'eliminate'
 *			debug=5 added
 *			added 'tablerow'
 *			added 'ignorecase' (for (not)linksto, (not)uses, (not)titlematch, (not)titleregexp, title,
 * @version 1.4.3
 *			allow regular expression for heading match at include
 * @version 1.4.4
 * 			bugfix: handling of numeric template parameters
 * @version 1.4.5
 * 			bugfix: make Call extension aware of browser differences in session variable handling
 * @version 1.4.6
 * 			added: recent contributions per page/user
 * @version 1.4.7
 * 			added: skipthispage
 * @version 1.4.8
 * 			nothing changed in DPL, but there were changes in Call and Wgraph
 * @version 1.4.9
 * 			improved error handling: parameters without "=" were silently ignored and now raise a warning
 *									 parameters starting with '=' lead to a runtime error and now are caught
 * @version 1.5.0
 * 			changed algorithm of parameter recognition in the Call extension (nothing changed in DPL)
 * @version 1.5.1
 * 			bugfix at addcontributions:; table name prefix led to invalid SQL statement
 *			check for 0 results after titlematch was applied
 * @version 1.5.2
 * 			includematch now understands parameter limits like {abc}:x[10]:y[20]
 *			bug fix in parameter limits (limit of 1 led to 2 characters being shown)
 *			offset and count are now implemented directly in SQL
 * @version 1.5.3
 * 			when using title= together with include=* there was a false warning about empty result set
 * 			new parser function {{#dplchapter:text|heading|limit|page|linktext}}
 * 			articlecategory added
 *			added provision fpr pre and nowiki in wiki text truncation fuction
 *			support %DATE% and %USER% within phantom templates
 *			added randomseed
 * @version 1.6.0
 *			internal changes in the code; (no more globals etc ...)
 * @version 1.6.1
 *			ordermethod= sortkey & categories decoupled, see line 2011
 *			hooks changed back to global functions due to problems with older MW installations
 *			Escaping of "/" improved. In some cases a slash in a page name or in a template parameter could lead to php errors at INCLUDE
 * @version 1.6.2
 *			Template matching in include improved. "abc" must not match "abc def" but did so previously.
 * @version 1.6.3
 *			Changed section matching to allow wildcards.
 * @version 1.6.4
 *			Made internationalization messages use wfLoadExtensionMessages instead of adding messages to the message cache on every pageload. - Sean Colombo
 *
 *		! when making changes here you must update the VERSION constant at the beginning of class ExtSynamicPageList2 !
 */

/**
 * Register the extension with MediaWiki
 */
// register as a parser function {{#dpl:}} and a tag <dpl>
$wgExtensionFunctions[]        = array( 'ExtDynamicPageList2', 'setup' );
                                 // this does not work using
                                 // array( 'ExtDynamicPageList2', 'languageGetMagic' )

// changed back to global function due to trouble with older MW installations, g.s.
//$wgHooks['LanguageGetMagic'][] = 'ExtDynamicPageList2::languageGetMagic';
$wgHooks['LanguageGetMagic'][] = 'ExtDynamicPageList2__languageGetMagic';
$wgExtensionMessagesFiles['DynamicPageList2'] = dirname(__FILE__).'/DynamicPageList2.i18n.php';


$wgExtensionCredits['parserhook'][] = array(
	'name' => 'DynamicPageList2',
	'author' =>  '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson], [http://en.wikinews.org/wiki/User:Amgine Amgine],'
				.'[http://de.wikipedia.org/wiki/Benutzer:Unendlich Unendlich], [http://meta.wikimedia.org/wiki/User:Dangerman Cyril Dangerville],'
				.'[http://de.wikipedia.org/wiki/Benutzer:Algorithmix Algorithmix]',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DynamicPageList',
	'description' => 'based on [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList], featuring many improvements',
  	'version' => ExtDynamicPageList2::VERSION
  );

// changed back to global functions due to trouble with older MW installations, g.s.
function ExtDynamicPageList2__languageGetMagic( &$magicWords, $langCode ) 	{
	return ExtDynamicPageList2::languageGetMagic( $magicWords, $langCode );
}
function ExtDynamicPageList2__endReset( &$parser, $text ) 					{
	return ExtDynamicPageList2::endReset( $parser, $text );
}
function ExtDynamicPageList2__endEliminate( &$parser, $text )			 	{
	return ExtDynamicPageList2::endEliminate( $parser, $text );
}

class ExtDynamicPageList2
{
    const VERSION = '1.6.4';               // current version

    /**
     * Extension options
     */
    public  static $maxCategoryCount         = 4;     // Maximum number of categories allowed in the Query
    public  static $minCategoryCount         = 0;     // Minimum number of categories needed in the Query
    public  static $maxResultCount           = 500;   // Maximum number of results to allow
    public  static $categoryStyleListCutoff  = 6;     // Max length to format a list of articles chunked by letter as bullet list, if list bigger, columnar format user (same as cutoff arg for CategoryPage::formatList())
    public  static $allowUnlimitedCategories = true;  // Allow unlimited categories in the Query
    public  static $allowUnlimitedResults    = false; // Allow unlimited results to be shown
    private static $allowedNamespaces        = NULL;  // to be initialized at first use of DPL2, array of all namespaces except Media and Special, because we cannot use the DB for these to generate dynamic page lists.
										              // Cannot be customized. Use ExtDynamicPageList2::$options['namespace'] or ExtDynamicPageList2::$options['notnamespace'] for customization.

    /**
     * Map parameters to possible values.
     * A 'default' key indicates the default value for the parameter.
     * A 'pattern' key indicates a pattern for regular expressions (that the value must match).
     * For some options (e.g. 'namespace'), possible values are not yet defined but will be if necessary (for debugging)
     */
    public static $options = array(
        'addcategories'        => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagecounter'       => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagesize'          => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addeditdate'          => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addfirstcategorydate' => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagetoucheddate'   => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'adduser'              => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addauthor'            => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addcontribution'      => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addlasteditor'        => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'allowcachedresults'   => array('default' => 'true', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
		'userdateformat'       => array('default' => ''),
		'goal'                 => array('default' => 'pages', 'pages', 'categories'),
        /**
         * search for a page with the same title in another namespace (this is normally the article to a talk page)
         */
        'articlecategory'    => NULL,

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
        'categorymatch'        => NULL,
        'categoryregexp'       => NULL,
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
          * Seed to be used when calling random.
          */
        'randomseed'           => array('default' => '', 'pattern' => '/^\d*$/'),
        /**
         * Max number of results to display, selection is based on random.
         */
        'randomcount'          => array('default' => '', 'pattern' => '/^\d*$/'),
        /**
         * shall the result set be distinct (=default) or not?
         */
        'distinct'             => array('default' => 'true', 'strict', 'false', 'no', 'yes', '0', '1', 'off', 'on'),
        /**
         * number of columns for output, default is 1
         */
        'columns'              => array('default' => '', 'pattern' => '/^\d+$/'),

        /**
         * debug=...
         * - 0: displays no debug message;
         * - 1: displays fatal errors only;
         * - 2: fatal errors + warnings only;
         * - 3: every debug message.
         * - 4: The SQL statement as an echo before execution.
         */
        'debug'                => array( 'default' => '1', '0', '1', '2', '3', '4', '5'),

        /**
         * eliminate=.. avoid creating unnecessary backreferences which point to to DPL results.
         *				it is expensive (in terms of performance) but more precise than "reset"
         * categories: eliminate all category links which result from a DPL call (by transcluded contents)
         * templates:  the same with templates
         * images:	   the same with images
         * links:  	   the same with internal and external links
         * all		   all of the above
         */
        'eliminate'                => array( 'default' => '', 'categories', 'templates', 'links', 'images', 'all'),
        /**
         * Mode at the heading level with ordermethod on multiple components, e.g. category heading with ordermethod=category,...:
         * html headings (H2, H3, H4), definition list, no heading (none), ordered, unordered.
         */

        'format'       		   => NULL,

        'goal'                 => array('default' => 'pages', 'pages', 'categories'),

        'headingmode'          => array( 'default' => 'none', 'H2', 'H3', 'H4', 'definition', 'none', 'ordered', 'unordered'),
        /**
         * we can display the number of articles within a heading group
         */
        'headingcount'         => array( 'default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
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
         * make comparisons (linksto, linksfrom ) case insensitive
         */
        'ignorecase'		   => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'include'          	   => NULL,
        /**
         * includesubpages    default is TRUE
         */
        'includesubpages'      => array('default' => 'true', 'false', 'no', 'yes', '0', '1', 'off', 'on'),
        /**
         * includematch=..,..    allows to specify regular expressions which must match the included contents
         */
        'includematch'       => array('default' => ''),
        /**
         * includenotmatch=..,..    allows to specify regular expressions which must NOT match the included contents
         */
        'includenotmatch'    => array('default' => ''),
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
         *   '\n' or '¶'  in the input will be interpreted as a newline character.
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
         * this parameter restricts the output to articles which cannot be reached via a link from the specified pages.
         * Examples:   notlinksfrom=my article|your article
         */
        'notlinksfrom'         => array('default' => ''),
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
        'escapelinks'          => array('default' => 'true','false', 'no', 'yes', '0', '1', 'off', 'on'),
        /**
         * by default the oage containingthe query will not be part of the result set.
         * This can be changed via 'skipthispage=no'. This should be used with care as it may lead to
         * problems which are hard to track down, esp. in combination with contents transclusion.
         */
        'skipthispage'         => array('default' => 'true','false', 'no', 'yes', '0', '1', 'off', 'on'),
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
         * @todo define 'notcategory' options (retrieve list of categories from 'categorylinks' table?)
         */
        'notcategory'          => NULL,
        'notcategorymatch'     => NULL,
        'notcategoryregexp'    => NULL,
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
        'titleregexp'          => NULL,
        /**
         * nottitlematch is a (SQL-LIKE-expression) pattern
         * which excludes pages matching that pattern from the result
        */
        'userdateformat'       => array('default' => ''),

        'nottitlematch'        => NULL,
        'nottitleregexp'       => NULL,
        'order' => array('default' => 'ascending', 'ascending', 'descending'),
        /**
         * we can specify something like "latin1_swedish_ci" for case insensitive sorting
        */
        'ordercollation' => array('default' => ''),
        /**
         * 'ordermethod=param1,param2' means ordered by param1 first, then by param2.
         * @todo: add 'ordermethod=category,categoryadd' (for each category CAT, pages ordered by date when page was added to CAT).
         */
        'ordermethod'          => array('default' => 'title', 'counter', 'size', 'category', 'sortkey',
                                        'category,firstedit',  'category,lastedit', 'category,pagetouched', 'category,sortkey',
                                        'categoryadd', 'firstedit', 'lastedit', 'pagetouched', 'pagesel',
                                        'title', 'titlewithoutnamespace', 'user', 'user,firstedit', 'user,lastedit'),
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
         * noresultsheader / footer is some wiki text which will be output (instead of a warning message)
         * if the result set is empty; setting 'noresultsheader' to something like ' ' will suppress
         * the warning about empty result set.
         */
        'noresultsheader'      => array('default' => ''),
        'noresultsfooter'      => array('default' => ''),
        /**
         * oneresultsheader / footer is some wiki text which will be output
         * if the result set contains exactly one entry.
         */
        'oneresultheader'      => array('default' => ''),
        'oneresultfooter'      => array('default' => ''),
        /**
         * openreferences =...
         * - no: excludes pages which do not exist (=default)
         * - yes: includes pages which do not exist -- this conflicts with some other options
         * - only: show only non existing pages [ not implemented so far ]
         */
        'openreferences'       => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        /**
         * redirects =...
         * - exclude: excludes redirect pages from lists (page_is_redirect = 0 only)
         * - include: allows redirect pages to appear in lists
         * - only: lists only redirect pages in lists (page_is_redirect = 1 only)
         */
        'redirects'            => array('default' => 'exclude', 'exclude', 'include', 'only'),
        /**
         * resultsheader / footer is some wiki text which will be output before / after the result list
         * (if there is at least one result); if 'oneresultheader / footer' is specified it will only be
         * used if there are at least TWO results
         */
        'resultsheader'        => array('default' => ''),
        'resultsfooter'        => array('default' => ''),
        /**
         * reset=..
         * categories: remove all category links which have been defined before the dpl call,
         * 			   typically resulting from template calls or transcluded contents
         * templates:  the same with templates
         * images:	   the same with images
         * links:  	   the same with internal and external links, throws away ALL links, not only DPL generated links!
         * all		   all of the above
         */
        'reset'                => array( 'default' => '', 'categories', 'templates', 'links', 'images', 'all'),
        /**
         * number of rows for output, default is 1
         * note: a "row" is a group of lines for which the heading tags defined in listseparators/format will be repeated
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
        'shownamespace'        => array('default' => 'true', 'false', 'no', 'yes', '0', '1', 'off', 'on'),
        /**
         * replaceintitle applies a regex replacement to %TITLE%
         */
        'replaceintitle'       => array('default' => ''),
        /**
         * table is a short hand for combined values of listseparators, colseparators and mulicolseparators
         */
        'table'			       => array('default' => ''),
        /**
         * tablerow allows to define individual formats for table columns
         */
        'tablerow'		       => array('default' => ''),
        /**
         * Max # characters of page title to display.
         * Empty value (default) means no limit.
         * Not applicable to mode=category.
         */
        'titlemaxlength'       => array('default' => '', 'pattern' => '/^\d*$/'),
        /*
         *
         */
        'suppresserrors'	=> array('default' => 'false')
    );

    public static $debugMinLevels = array();
    public static $createdLinks; // the links created by DPL are collected here;
                                 // they can be removed during the final ouput
                                 // phase of the MediaWiki parser

    public static function setup() {
        // Page Transclusion, adopted from Steve Sanbeg´s LabeledSectionTransclusion
        require_once( 'DynamicPageList2Include.php' );

        global $wgParser, $wgMessageCache;

        // register the callback for the user tag <dpl>
        $wgParser->setHook( "DPL", array( __CLASS__, "dplTag" ) );
        $wgParser->setHook( "DynamicPageList", array( __CLASS__, "dplTag" ) );
        $wgParser->setHook( 'section', array( __CLASS__, 'removeSectionMarkers' ) );
        //------------------------------ parser #function  #dplchapter:
        $wgParser->setFunctionHook( 'dplchapter', array( __CLASS__, 'dplChapterParserFunction' ) );
        //------------------------------ variant as a parser #function
        $wgParser->setFunctionHook( 'dpl', array( __CLASS__, 'dplParserFunction' ) );

		// Error and warning codes.
		require_once( dirname(__FILE__).'/DynamicPageList2.codes.php' );

        // Internationalization messages
		wfLoadExtensionMessages('DynamicPageList2');

        /**
         *  Define codes and map debug message to min debug level above which message can be displayed
         */
        $debugCodes = array(
            // FATAL
            1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
            // WARN
            2, 2, 2, 2, 2, 2, 2, 2,
            // DEBUG
            3
        );

        foreach ($debugCodes as $i => $minlevel )
        {
            self::$debugMinLevels[$i] = $minlevel;
        }

        if (!isset(self::$createdLinks)) {
            self::$createdLinks=array(
                'resetLinks'=> false, 'resetTemplates' => false,
                'resetCategories' => false, 'resetImages' => false, 'resetdone' => false );
        }
    }

    // no longer called; changed back to global function due to troubles, g.s.
    public static function languageGetMagic( &$magicWords, $langCode ) {
            # Add the magic word
            # The first array element is case sensitivity, in this case it is not case sensitive
            # All remaining elements are synonyms for our parser function
            $magicWords['dpl'] = array( 0, 'dpl' );
            $magicWords['dplchapter'] = array( 0, 'dplchapter' );
            # unless we return true, other parser functions extensions won't get loaded.
            return true;
    }

    private static function argBoolean($arg) {
        return ($arg=='true' || $arg=='yes' || $arg=='1' || $arg=='on');
    }

    //------------------------------------------------------------------------------------- ENTRY parser TAG
    // The callback function wrapper for converting the input text to HTML output
    public static function dplTag( $input, $params, &$parser ) {
        // entry point for user tag <dpl>
        // create list and do a recursive parse of the output

        // $dump1   = self::dumpParsedRefs($parser,"before DPL tag");
        $text    = self::dynamicPageList($input, $params, $parser, $reset, 'tag');
        // $dump2   = self::dumpParsedRefs($parser,"after DPL tag");
        if ($reset[1]) {	// we can remove the templates by save/restore
            $saveTemplates = $parser->mOutput->mTemplates;
        }
        if ($reset[2]) {	// we can remove the categories by save/restore
            $saveCategories = $parser->mOutput->mCategories;
        }
        if ($reset[3]) {	// we can remove the images by save/restore
            $saveImages = $parser->mOutput->mImages;
        }
        $parsedDPL = $parser->recursiveTagParse($text);
        if ($reset[1]) {	// TEMPLATES
            $parser->mOutput->mTemplates =$saveTemplates;
        }
        if ($reset[2]) {	// CATEGORIES
            $parser->mOutput->mCategories =$saveCategories;
        }
        if ($reset[3]) {	// IMAGES
            $parser->mOutput->mImages =$saveImages;
        }
        // $dump3   = self::dumpParsedRefs($parser,"after tag parse");
        // return $dump1.$parsedDPL.$dump2.$dump3;
        return $parsedDPL;
    }

    public static function dplParserFunction(&$parser)
    {
        // callback for the parser function {{#dpl:
        $params = array();
        $input="";

        $numargs = func_num_args();
        if ($numargs < 2) {
          $input = "#dpl: no arguments specified";
          return str_replace('§','<','§pre>§nowiki>'.$input.'§/nowiki>§/pre>');
        }

        // fetch all user-provided arguments (skipping $parser)
        $arg_list = func_get_args();
        for ($i = 1; $i < $numargs; $i++) {
          $p1 = $arg_list[$i];
          $input .= str_replace("\n","",$p1) ."\n";
        }
        // for debugging you may want to uncomment the following statement
        // return str_replace('§','<','§pre>§nowiki>'.$input.'§/nowiki>§/pre>');


        // $dump1   = self::dumpParsedRefs($parser,"before DPL func");
        // $text    = self::dynamicPageList($input, $params, $parser, $reset, 'func');
        // $dump2   = self::dumpParsedRefs($parser,"after DPL func");
        // return $dump1.$text.$dump2;

        return self::dynamicPageList($input, $params, $parser, $reset, 'func');
    }

    public static function dplChapterParserFunction(&$parser, $text='', $heading=' ', $maxLength = -1, $page = '?page?', $link = 'default' ) {
        $arg_list = func_get_args();
        $output = DPL2Include::extractHeadingFromText($parser, $page, '?title?', $text, $heading, '', $sectionHeading, true, $maxLength, $link);
        return $output[0];
    }

    private static function dumpParsedRefs($parser,$label) {
        if (!preg_match("/Query Q/",$parser->mTitle->getText())) return '';
        $text="\n<pre>$label:\n";
    /*
        $text.="  control:";
        foreach (self::$createdLinks as $key => $val) {
            if (is_array($val)) continue;
            $text.=  "$val($key),";
        }
        $text.="\n";
    */
        $text.="  categories:";
        foreach ($parser->mOutput->mCategories as $key => $val ) {
            $text .= "$val($key),";
        }
        $text.="\n";
        if (array_key_exists(2,self::$createdLinks)) {
            $text.="  CATEGORIES:";
            foreach (self::$createdLinks[2] as $val ) {
                $text .= "$val,";
            }
            $text.="\n";
        }
        $text.="  links:";
        foreach ($parser->mOutput->mLinks as $lkey => $lval ) {
            $text .= "$lval($lkey)={";
            foreach ($lval as $key => $val ) {
                $text .= "$val($key),";
            }
            $text .= "},";
        }
        $text.="\n";
        if (array_key_exists(0,self::$createdLinks)) {
            $text.="  LINKS:";
            foreach (self::$createdLinks[0] as $val ) {
                $text .= "$val,";
            }
            $text.="\n";
        }
        $text.="  templates:";
        foreach ($parser->mOutput->mTemplates as $tkey => $tval ) {
            $text .= "$tval($tkey)={";
            foreach ($tval as $key => $val ) {
                $text .= "$val($key),";
            }
            $text .= "},";
        }
        $text.="\n";
        if (array_key_exists(1,self::$createdLinks)) {
            $text.="  TEMPLATES:";
            foreach (self::$createdLinks[1] as $val ) {
                $text .= "$val,";
            }
            $text.="\n";
        }
        $text.="  images:";
        foreach ($parser->mOutput->mImages as $key => $val ) {
            $text .= "$val($key),";
        }
        $text.="\n";
        if (array_key_exists(3,self::$createdLinks)) {
            $text.="  IMAGES:";
            foreach (self::$createdLinks[3] as $val ) {
                $text .= "$val,";
            }
            $text.="\n";
        }
        $text.="</pre>\n";
        return $text;
    }

    //remove section markers in case the LabeledSectionTransclusion extension is not installed.
    public static function removeSectionMarkers( $in, $assocArgs=array(), $parser=null ) {
        return '';
    }

    // The real callback function for converting the input text to HTML output
    private static function dynamicPageList( $input, $params, &$parser, &$bReset, $calledInMode ) {

        error_reporting(E_ALL);

        global $wgUser, $wgContLang;
        global $wgTitle, $wgNonincludableNamespaces;

        //logger (display of debug messages)
        $logger = new DPL2Logger();

        //check that we are not in an infinite transclusion loop
        if ( isset( $parser->mTemplatePath[$parser->mTitle->getPrefixedText()] ) ) {
            return $logger->escapeMsg(DPL2_i18n::WARN_TRANSCLUSIONLOOP, $parser->mTitle->getPrefixedText());
        }

        /**
         * Initialization
         */
         // Local parser created. See http://meta.wikimedia.org/wiki/MediaWiki_extensions_FAQ#How_do_I_render_wikitext_in_my_extension.3F
        $localParser = new Parser();
        $pOptions = $parser->mOptions;
        $pTitle = $parser->mTitle;

        // get database access
        $dbr = wfGetDB( DB_SLAVE, 'dpl' );
        $sPageTable = $dbr->tableName( 'page' );
        $sCategorylinksTable = $dbr->tableName( 'categorylinks' );

        // Extension variables
        // Allowed namespaces for DPL2: all namespaces except the first 2: Media (-2) and Special (-1), because we cannot use the DB for these to generate dynamic page lists.
        if( !is_array(self::$allowedNamespaces) ) { // Initialization
            $aNs = $wgContLang->getNamespaces();
            // namespaces which are nonicludable will maybe somewhen ignored
            // if (isset($wgNonincludableNamespaces)) {
            //	foreach ($wgNonincludableNamespaces as $nonInc) unset ($aNs[$nonInc]);
            // }

            self::$allowedNamespaces = array_slice($aNs, 2, count($aNs), true);
            if( !is_array(self::$options['namespace']) )
                self::$options['namespace'] = self::$allowedNamespaces;
            else // Make sure user namespace options are allowed.
                self::$options['namespace'] = array_intersect(self::$options['namespace'], self::$allowedNamespaces);
            if( !isset(self::$options['namespace']['default']) )
                self::$options['namespace']['default'] = NULL;
            if( !is_array(self::$options['notnamespace']) )
                self::$options['notnamespace'] = self::$allowedNamespaces;
            else
                self::$options['notnamespace'] = array_intersect(self::$options['notnamespace'], self::$allowedNamespaces);
            if( !isset(self::$options['notnamespace']['default']) )
                self::$options['notnamespace']['default'] = NULL;
        }

        // Options

        $sGoal = self::$options['goal']['default'];

        $bSelectionCriteriaFound=false;
        $bConflictsWithOpenReferences=false;
        // array for LINK / TEMPLATE / CATGEORY / IMAGE  by RESET / ELIMINATE
        $bReset = array ( false, false, false, false, false, false, false, false );

        // we allow " like " or "="
        $sCategoryComparisonMode    = '=';
        $sNotCategoryComparisonMode = '=';
        $sTitleMatchMode            = ' LIKE ';
        $sNotTitleMatchMode         = ' LIKE ';

        $aOrderMethods = explode(',', self::$options['ordermethod']['default']);
        $sOrder = self::$options['order']['default'];
        $sOrderCollation = self::$options['ordercollation']['default'];

        $sPageListMode = self::$options['mode']['default'];

        $sHListMode = self::$options['headingmode']['default'];
        $bHeadingCount = self::argBoolean(self::$options['headingcount']['default']);

        $bEscapeLinks = self::$options['escapelinks']['default'];
        $bSkipThisPage= self::$options['skipthispage']['default'];

        $sMinorEdits = NULL;
        $acceptOpenReferences = self::argBoolean(self::$options['openreferences']['default']);

        $sLastRevisionBefore = self::$options['lastrevisionbefore']['default'];
        $sAllRevisionsBefore = self::$options['allrevisionsbefore']['default'];
        $sFirstRevisionSince = self::$options['firstrevisionsince']['default'];
        $sAllRevisionsSince  = self::$options['allrevisionssince']['default'];

        $sRedirects = self::$options['redirects']['default'];

        $sResultsHeader   = self::$options['resultsheader']['default'];
        $sResultsFooter   = self::$options['resultsfooter']['default'];
        $sNoResultsHeader = self::$options['noresultsheader']['default'];
        $sNoResultsFooter = self::$options['noresultsfooter']['default'];
        $sOneResultHeader = self::$options['oneresultheader']['default'];
        $sOneResultFooter = self::$options['oneresultfooter']['default'];

        $aListSeparators = array();
        $sTable = self::$options['table']['default'];
        $aTableRow = array();

        $sInlTxt = self::$options['inlinetext']['default'];

        $bShowNamespace = self::argBoolean(self::$options['shownamespace']['default']);

        $bAddFirstCategoryDate = self::argBoolean(self::$options['addfirstcategorydate']['default']);

        $bAddPageCounter = self::argBoolean(self::$options['addpagecounter']['default']);

        $bAddPageSize = self::argBoolean(self::$options['addpagesize']['default']);

        $bAddPageTouchedDate = self::argBoolean(self::$options['addpagetoucheddate']['default']);

        $bAddEditDate = self::argBoolean(self::$options['addeditdate']['default']);

        $bAddUser         = self::argBoolean(self::$options['adduser']['default']);
        $bAddAuthor       = self::argBoolean(self::$options['addauthor']['default']);
        $bAddContribution = self::argBoolean(self::$options['addcontribution']['default']);
        $bAddLastEditor   = self::argBoolean(self::$options['addlasteditor']['default']);

        $bAllowCachedResults = self::argBoolean(self::$options['allowcachedresults']['default']);

        $sUserDateFormat = self::$options['userdateformat']['default'];

        $bAddCategories = self::argBoolean(self::$options['addcategories']['default']);

        $bIncludeSubpages = self::argBoolean(self::$options['includesubpages']['default']);

        $bIgnoreCase = self::argBoolean(self::$options['ignorecase']['default']);

        $_incpage = self::$options['includepage']['default'];
        $bIncPage =  is_string($_incpage) && $_incpage !== '';

        $aSecLabels = array();
        if($bIncPage && $_incpage != '*') $aSecLabels = explode(',', $_incpage);
        $aSecLabelsMatch 	= array();
        $aSecLabelsNotMatch = array();

        $aSecSeparators = array();
        $aSecSeparators      = explode(',', self::$options['secseparators']['default']);
        $aMultiSecSeparators = explode(',', self::$options['multisecseparators']['default']);
        $iDominantSection = self::$options['dominantsection']['default'];

        $_sOffset = self::$options['offset']['default'];
        $iOffset  = ($_sOffset == '') ? 0: intval($_sOffset);

        $_sCount = self::$options['count']['default'];
        $iCount = ($_sCount == '') ? NULL: intval($_sCount);

        $_sColumns = self::$options['columns']['default'];
        $iColumns  = ($_sColumns == '') ? 1: intval($_sColumns);

        $_sRows    = self::$options['rows']['default'];
        $iRows     = ($_sRows == '') ? 1: intval($_sRows);

        $_sRowSize = self::$options['rowsize']['default'];
        $iRowSize  = ($_sRowSize == '') ? 0: intval($_sRowSize);

        $sRowColFormat= self::$options['rowcolformat']['default'];

        $_sRandomSeed = self::$options['randomseed']['default'];
        $iRandomSeed = ($_sRandomSeed == '') ? NULL: intval($_sRandomSeed);

        $_sRandomCount = self::$options['randomcount']['default'];
        $iRandomCount = ($_sRandomCount == '') ? NULL: intval($_sRandomCount);

        $sDistinctResultSet = 'true';

        $sListHtmlAttr = self::$options['listattr']['default'];
        $sItemHtmlAttr = self::$options['itemattr']['default'];

        $sHListHtmlAttr = self::$options['hlistattr']['default'];
        $sHItemHtmlAttr = self::$options['hitemattr']['default'];

        $_sTitleMaxLen = self::$options['titlemaxlength']['default'];
        $iTitleMaxLen = ($_sTitleMaxLen == '') ? NULL: intval($_sTitleMaxLen);

        $aReplaceInTitle[0] = '';
        $aReplaceInTitle[1] = '';

        $_sCatMinMax  = self::$options['categoriesminmax']['default'];
        $aCatMinMax   = ($_sCatMinMax == '') ? NULL: explode(',',$_sCatMinMax);

        $_sIncludeMaxLen = self::$options['includemaxlength']['default'];
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

        $sArticleCategory = null;

        // Output
        $output = '';


    // ###### PARSE PARAMETERS ######

        // we replace double angle brackets by < > ; thus we avoid premature tag expansion in the input
        $input = str_replace('Â»','>',$input);
        $input = str_replace('Â«','<',$input);

        // use the ¦ as a general alias for |
        $input = str_replace('Â¦','|',$input); // the symbol is utf8-escaped

        // the combination '²{' and '}²'will be translated to double curly braces; this allows postponed template execution
        // which is crucial for DPL queries which call other DPL queries
        $input = str_replace('Â²{','{{',$input);
        $input = str_replace('}Â²','}}',$input);

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
                if (trim($aParam[0])!='') $output .= $logger->escapeMsg(DPL2_i18n::WARN_UNKNOWNPARAM, $aParam[0]. " [missing '=']", implode(', ', array_keys(self::$options)));
                continue;
            }
            $sType = trim($aParam[0]);
            $sArg = trim($aParam[1]);

            if( $sType=='') {
                $output .= $logger->escapeMsg(DPL2_i18n::WARN_UNKNOWNPARAM, '[empty string]', implode(', ', array_keys(self::$options)));
                continue;
            }

            // ignore comment lines
            if ($sType[0] == '#') continue;

            // ignore parameter settings without argument (except namespace and category)
            if ($sArg=='') {
                if ($sType!='namespace' && $sType!='notnamespace' && $sType != 'category' && array_key_exists($sType,self::$options)) continue;
            }
            // check if parameter is known
            if (!array_key_exists($sType,self::$options)) {
                $output .= $logger->escapeMsg(DPL2_i18n::WARN_UNKNOWNPARAM, $sType, implode(', ', array_keys(self::$options)));
                continue;
            }

            switch ($sType) {

                /**
                 * GOAL
                 */
                case 'goal':
                    if( in_array($sArg, self::$options['goal']) ) {
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
                                $sParamList = explode('|',self::getSubcategories(substr($sParam,1),$sPageTable));
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
                        if( !in_array($sNs, self::$options['namespace']) )
                            return $logger->msgWrongParam('namespace', $sParam);
                        $aNamespaces[] = $wgContLang->getNsIndex($sNs);
                        $bSelectionCriteriaFound=true;
                    }
                    break;

                case 'notnamespace':
                    $sArg=trim($sArg);
                    $sNs = $localParser->transformMsg($sArg, $pOptions);
                    if( !in_array($sNs, self::$options['notnamespace']) )
                        return $logger->msgWrongParam('notnamespace', $sArg);
                    $aExcludeNamespaces[] = $wgContLang->getNsIndex($sNs);
                    $bSelectionCriteriaFound=true;
                    break;

                case 'linksto':
                    $pages = explode('|', trim($sArg));
                    $n=0;
                    foreach($pages as $page) {
                        if (trim($page)=='') continue;
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
                        if (trim($page)=='') continue;
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
                        if (trim($page)=='') continue;
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
                        if (trim($page)=='') continue;
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
                    if( in_array($sArg, self::$options['minoredits']) ) {
                        $sMinorEdits = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else { //wrong param val, using default
                        $sMinorEdits = self::$options['minoredits']['default'];
                        $output .= $logger->msgWrongParam('minoredits', $sArg);
                    }
                    break;

                case 'includesubpages':
                    if( in_array($sArg, self::$options['includesubpages'])) {
                        $bIncludeSubpages = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('includesubpages', $sArg);
                    break;

                case 'ignorecase':
                    if( in_array($sArg, self::$options['ignorecase'])) {
                        $bIgnoreCase = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('ignorecase', $sArg);
                    break;

                case 'lastrevisionbefore':
                case 'allrevisionsbefore':
                case 'firstrevisionsince':
                case 'allrevisionssince':
                    if( preg_match(self::$options[$sType]['pattern'], $sArg) ) {
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
                    if( in_array($sArg, self::$options['openreferences']) )
                        $acceptOpenReferences = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('openreferences', $sArg);
                    break;

                case 'redirects':
                    if( in_array($sArg, self::$options['redirects']) ) {
                        $sRedirects = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('redirects', $sArg);
                    break;

                case 'offset':
                    //ensure that $iOffset is a number
                    if( preg_match(self::$options['offset']['pattern'], $sArg) )
                        $iOffset = ($sArg == '') ? 0: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('offset', $sArg);
                    break;

                case 'count':
                    //ensure that $iCount is a number or no count limit;
                    if( preg_match(self::$options['count']['pattern'], $sArg) )
                        $iCount = ($sArg == '') ? NULL: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('count', $sArg);
                    break;

                case 'randomseed':
                    //ensure that $iRandomSeed is a number;
                        if( preg_match(self::$options['randomseed']['pattern'], $sArg) )
                        $iRandomSeed = ($sArg == '') ? NULL: intval($sArg);
                        else // wrong value
                        $output .= $logger->msgWrongParam('randomseed', $sArg);
                    break;

                case 'randomcount':
                    //ensure that $iRandomCount is a number;
                    if( preg_match(self::$options['randomcount']['pattern'], $sArg) )
                        $iRandomCount = ($sArg == '') ? NULL: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('randomcount', $sArg);
                    break;

                case 'distinct':
                    if( in_array($sArg, self::$options['distinct'])) {
                        if ($sArg=='strict') 			$sDistinctResultSet = 'strict';
                        else if (self::argBoolean($sArg)) 	$sDistinctResultSet = 'true';
                        else 							$sDistinctResultSet = 'false';
                    }
                    else
                        $output .= $logger->msgWrongParam('distinct', $sArg);
                    break;

                case 'categoriesminmax':
                    if( preg_match(self::$options['categoriesminmax']['pattern'], $sArg) )
                        $aCatMinMax = ($sArg == '') ? NULL: explode(',',$sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('categoriesminmax', $sArg);
                    break;

                case 'skipthispage':
                    if( in_array($sArg, self::$options['skipthispage']))
                        $bSkipThisPage = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('skipthispage', $sArg);
                    break;

                case 'articlecategory':
                    $sArticleCategory = $sArg;
                    break;

                /**
                 * CONTENT PARAMETERS
                 */
                case 'addcategories':
                    if( in_array($sArg, self::$options['addcategories'])) {
                        $bAddCategories = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addcategories', $sArg);
                    break;

                case 'addeditdate':
                    if( in_array($sArg, self::$options['addeditdate'])) {
                        $bAddEditDate = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addeditdate', $sArg);
                    break;

                case 'addfirstcategorydate':
                    if( in_array($sArg, self::$options['addfirstcategorydate'])) {
                        $bAddFirstCategoryDate = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addfirstcategorydate', $sArg);
                    break;

                case 'addpagecounter':
                    if( in_array($sArg, self::$options['addpagecounter'])) {
                        $bAddPageCounter = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addpagecounter', $sArg);
                    break;

                case 'addpagesize':
                    if( in_array($sArg, self::$options['addpagesize'])) {
                        $bAddPageSize = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addpagesize', $sArg);
                    break;

                case 'addpagetoucheddate':
                    if( in_array($sArg, self::$options['addpagetoucheddate'])) {
                        $bAddPageTouchedDate = self::argBoolean($sArg);
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

                case 'includenotmatch':
                    $aSecLabelsNotMatch= explode(',', $sArg);
                    break;

                case 'adduser':
                    if( in_array($sArg, self::$options['adduser'])) {
                        $bAddUser = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('adduser', $sArg);
                    break;

                case 'addauthor':
                    if( in_array($sArg, self::$options['addauthor'])) {
                        $bAddAuthor = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addauthor', $sArg);
                    break;

                case 'addcontribution':
                    if( in_array($sArg, self::$options['addcontribution'])) {
                        $bAddContribution = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addcontribution', $sArg);
                    break;

                case 'addlasteditor':
                    if( in_array($sArg, self::$options['addlasteditor'])) {
                        $bAddLastEditor = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('addlasteditor', $sArg);
                    break;

                /**
                 * ORDER PARAMETERS
                 */
                case 'ordermethod':
                    $methods = explode(',', $sArg);
                    $breakaway = false;
                    foreach ( $methods as $method ) {
                        if( !in_array($method, self::$options['ordermethod']) ) {
                            $output .= $logger->msgWrongParam('ordermethod', $method);
                            $breakaway = true;
                        }
                    }
                    if ( !$breakaway ) {
                        $aOrderMethods = $methods;
                        $bConflictsWithOpenReferences=true;
                    }
                    break;

                case 'order':
                    if( in_array($sArg, self::$options['order']) )
                        $sOrder = $sArg;
                    else
                        $output .= $logger->msgWrongParam('order', $sArg);
                    break;

                case 'ordercollation':
                    if($sArg!='') $sOrderCollation= "COLLATE $sArg";
                    break;

                /**
                 * FORMAT/HTML PARAMETERS
                 * @todo allow addpagetoucheddate, addeditdate, adduser, addcategories to have effect with 'mode=category'
                 */

                case 'columns':
                    //ensure that $iColumns is a number
                    if( preg_match(self::$options['columns']['pattern'], $sArg) )
                        $iColumns = ($sArg == '') ? 1: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('columns', $sArg);
                    break;

                case 'rows':
                    //ensure that $iRows is a number
                    if( preg_match(self::$options['rows']['pattern'], $sArg) )
                        $iRows = ($sArg == '') ? 1: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('rows', $sArg);
                    break;

                case 'rowsize':
                    //ensure that $iRowSize is a number
                    if( preg_match(self::$options['rowsize']['pattern'], $sArg) )
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
                    if( in_array($sArg, self::$options['headingmode']) ) {
                        $sHListMode = $sArg;
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('headingmode', $sArg);
                    break;

                case 'headingcount':
                    if( in_array($sArg, self::$options['headingcount'])) {
                        $bHeadingCount = self::argBoolean($sArg);
                        $bConflictsWithOpenReferences=true;
                    }
                    else
                        $output .= $logger->msgWrongParam('headingcount', $sArg);
                    break;

                case 'mode':
                    if( in_array($sArg, self::$options['mode']) )
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
                    if( in_array($sArg, self::$options['escapelinks']))
                        $bEscapeLinks = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('escapelinks', $sArg);
                    break;

                case 'inlinetext':
                    $sInlTxt = $sArg;
                    break;

                case 'format':
                case 'listseparators':
                    // parsing of wikitext will happen at the end of the output phase
                    // we replace '\n' in the input by linefeed because wiki syntax depends on linefeeds
                    $sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "Â¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aListSeparators = explode (',', $sArg, 4);
                    // mode=userformat will be automatically assumed
                    $sPageListMode='userformat';
                    $sInlTxt = '';
                    break;

                case 'secseparators':
                    // we replace '\n' by newline to support wiki syntax within the section separators
                    $sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "Â¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aSecSeparators = explode (',',$sArg);
                    break;

                case 'multisecseparators':
                    // we replace '\n' by newline to support wiki syntax within the section separators
                    $sArg = str_replace( '\n', "\n", $sArg );
                    $sArg = str_replace( "Â¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    $aMultiSecSeparators = explode (',',$sArg);
                    break;

                case 'table':
                    $sArg   = str_replace( '\n', "\n", $sArg );
                    $sTable = str_replace( "Â¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    break;

                case 'tablerow':
                    $sArg   = str_replace( '\n', "\n", $sArg );
                    $sArg   = str_replace( "Â¶", "\n", $sArg ); // the paragraph delimiter is utf8-escaped
                    if (trim($sArg)=='') 	$aTableRow = array();
                    else					$aTableRow = explode (',',$sArg);
                    break;

                case 'dominantsection':
                    if( preg_match(self::$options['dominantsection']['pattern'], $sArg) )
                        $iDominantSection = ($sArg == '') ? NULL: intval($sArg);
                    else // wrong value
                        $output .= $logger->msgWrongParam('dominantsection', $sArg);
                    break;

                case 'shownamespace':
                    if( in_array($sArg, self::$options['shownamespace']))
                        $bShowNamespace = self::argBoolean($sArg);
                    else
                        $output .= $logger->msgWrongParam('shownamespace', $sArg);
                    break;

                case 'titlemaxlength':
                    //processed like 'count' param
                    if( preg_match(self::$options['titlemaxlength']['pattern'], $sArg) )
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
                    if( preg_match(self::$options['includemaxlength']['pattern'], $sArg) )
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
                case 'resultsfooter':
                    $sResultsFooter = $sArg;
                    break;
                case 'noresultsheader':
                    $sNoResultsHeader = $sArg;
                    break;
                case 'noresultsfooter':
                    $sNoResultsFooter = $sArg;
                    break;
                case 'oneresultheader':
                    $sOneResultHeader = $sArg;
                    break;
                case 'oneresultfooter':
                    $sOneResultFooter = $sArg;
                    break;

                /**
                 * DEBUG, RESET and CACHE PARAMETER
                 */

                case 'allowcachedresults':
                    if( in_array($sArg, self::$options['allowcachedresults'])) {
                        $bAllowCachedResults = self::argBoolean($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('allowcachedresults', $sArg);
                    break;

                case 'reset':
                    foreach (preg_split('/[;,]/',$sArg) as $arg) {
                        $arg=trim($arg);
                        if ($arg=='') continue;
                        if( !in_array($arg, self::$options['reset'])) {
                            $output .= $logger->msgWrongParam('reset', $arg);
                        }
                        else if ($arg=='links')  	$bReset[0]=true;
                        else if ($arg=='templates') $bReset[1]=true;
                        else if ($arg=='categories')$bReset[2]=true;
                        else if ($arg=='images')	$bReset[3]=true;
                        else if ($arg=='all')  {
                            $bReset[0]=true; $bReset[1]=true; $bReset[2]=true; $bReset[3]=true;
                        }
                    }
                    break;

                case 'eliminate':
                    foreach (preg_split('/[;,]/',$sArg) as $arg) {
                        $arg=trim($arg);
                        if ($arg=='') continue;
                        if( !in_array($arg, self::$options['eliminate'])) {
                            $output .= $logger->msgWrongParam('eliminate', $arg);
                        }
                        else if ($arg=='links')  	$bReset[4]=true;
                        else if ($arg=='templates') $bReset[5]=true;
                        else if ($arg=='categories')$bReset[6]=true;
                        else if ($arg=='images')	$bReset[7]=true;
                        else if ($arg=='all')  {
                            $bReset[4]=true; $bReset[5]=true; $bReset[6]=true; $bReset[7]=true;
                        }
                    }
                    break;

                case 'debug':
                    if( in_array($sArg, self::$options['debug']) ) {
                        if($iParam > 1)
                            $output .= $logger->escapeMsg(DPL2_i18n::WARN_DEBUGPARAMNOTFIRST, $sArg );
                        $logger->iDebugLevel = intval($sArg);
                    }
                    else
                        $output .= $logger->msgWrongParam('debug', $sArg);
                    break;

                case 'suppresserrors':
                    if( in_array($sArg, self::$options['suppresserrors']) ) {
                        $logger->setSuppressErrors('true');
                    } else {
                        $logger->setSuppressErrors('false');
					}
                    break;

                /**
                 * UNKNOWN PARAMETER
                 */
                default:
                    $output .= $logger->escapeMsg(DPL2_i18n::WARN_UNKNOWNPARAM, $sType, implode(', ', array_keys(self::$options)));
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
        // foreach ($aTableRow as $key => $val) $output .= "TableRow($key)=$val;<br>";

        $iIncludeCatCount = count($aIncludeCategories);
        $iTotalIncludeCatCount = count($aIncludeCategories, COUNT_RECURSIVE) - $iIncludeCatCount;
        $iExcludeCatCount = count($aExcludeCategories);
        $iTotalCatCount = $iTotalIncludeCatCount + $iExcludeCatCount;

        // disable parser cache
        if ( !$bAllowCachedResults) $parser->disableCache();

        if ($calledInMode=='tag') {
            // in tag mode 'eliminate' is the same as 'reset' for tpl,cat,img
            if ($bReset[5]) { $bReset[1] = true; $bReset[5] = false; }
            if ($bReset[6]) { $bReset[2] = true; $bReset[6] = false; }
            if ($bReset[7]) { $bReset[3] = true; $bReset[7] = false; }
        }
        else {
            if ($bReset[1]) self::$createdLinks['resetTemplates'] 	= true;
            if ($bReset[2]) self::$createdLinks['resetCategories']	= true;
            if ($bReset[3]) self::$createdLinks['resetImages'] 	= true;
        }
        if (($calledInMode=='tag' && $bReset[0]) || $calledInMode=='func') {
            if ($bReset[0]) self::$createdLinks['resetLinks'] = true;
            // register a hook to reset links which were produced during parsing DPL output
            global $wgHooks;
            if (!isset($wgHooks['ParserAfterTidy']) ||
                !( in_array( __CLASS__ . '::endReset',$wgHooks['ParserAfterTidy']) ||
                   in_array( array(__CLASS__, 'endReset' ),$wgHooks['ParserAfterTidy']) ) ) {
	            // changed back to globals, gs
                //$wgHooks['ParserAfterTidy'][]   = __CLASS__ . '::endReset';
                $wgHooks['ParserAfterTidy'][]   = __CLASS__ . '__endReset';
            }
        }


    // ###### CHECKS ON PARAMETERS ######
        // too many categories!!
        if ( ($iTotalCatCount > self::$maxCategoryCount) && (!self::$allowUnlimitedCategories) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_TOOMANYCATS, self::$maxCategoryCount);

        // too few categories!!
        if ($iTotalCatCount < self::$minCategoryCount)
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_TOOFEWCATS, self::$minCategoryCount);

        // no selection criteria!! Warn only if no debug level is set
        if ($iTotalCatCount == 0 && $bSelectionCriteriaFound==false) {
            if ($logger->iDebugLevel >= 1) return $output;
            else return $output . $logger->escapeMsg(DPL2_i18n::FATAL_NOSELECTION);
        }

        // ordermethod=sortkey requires ordermethod=category
        // delayed to the construction of the SQL query, see near line 2211, gs
		//if (in_array('sortkey',$aOrderMethods) && ! in_array('category',$aOrderMethods)) $aOrderMethods[] = 'category';

        // no included categories but ordermethod=categoryadd or addfirstcategorydate=true!!
        if ($iTotalIncludeCatCount == 0 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_CATDATEBUTNOINCLUDEDCATS);

        // more than one included category but ordermethod=categoryadd or addfirstcategorydate=true!!
        // we ALLOW this parameter combination, risking ambiguous results
        //if ($iTotalIncludeCatCount > 1 && ($aOrderMethods[0] == 'categoryadd' || $bAddFirstCategoryDate == true) )
        //	return $output . $logger->escapeMsg(DPL2_i18n::FATAL_CATDATEBUTMORETHAN1CAT);

        // no more than one type of date at a time!!
        if($bAddPageTouchedDate + $bAddFirstCategoryDate + $bAddEditDate > 1)
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_MORETHAN1TYPEOFDATE);

        // the dominant section must be one of the sections mentioned in includepage
        if($iDominantSection>0 && count($aSecLabels)<$iDominantSection)
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_DOMINANTSECTIONRANGE, count($aSecLabels));

        // category-style output requested with not compatible order method
        if ($sPageListMode == 'category' && !array_intersect($aOrderMethods, array('sortkey', 'title','titlewithoutnamespace')) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_WRONGORDERMETHOD,  'mode=category', 'sortkey | title | titlewithoutnamespace' );

        // addpagetoucheddate=true with unappropriate order methods
        if( $bAddPageTouchedDate && !array_intersect($aOrderMethods, array('pagetouched', 'title')) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_WRONGORDERMETHOD,  'addpagetoucheddate=true', 'pagetouched | title' );

        // addeditdate=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
        //firstedit (resp. lastedit) -> add date of first (resp. last) revision
        if( $bAddEditDate && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_WRONGORDERMETHOD, 'addeditdate=true', 'firstedit | lastedit' );

        // adduser=true but not (ordermethod=...,firstedit or ordermethod=...,lastedit)
        /**
         * @todo allow to add user for other order methods.
         * The fact is a page may be edited by multiple users. Which user(s) should we show? all? the first or the last one?
         * Ideally, we could use values such as 'all', 'first' or 'last' for the adduser parameter.
        */
        if( $bAddUser && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_WRONGORDERMETHOD, 'adduser=true', 'firstedit | lastedit' );

        if( isset($sMinorEdits) && !array_intersect($aOrderMethods, array('firstedit', 'lastedit')) )
            return $output . $logger->escapeMsg(DPL2_i18n::FATAL_WRONGORDERMETHOD, 'minoredits', 'firstedit | lastedit' );

        /**
         * If we include the Uncategorized, we need the 'dpl_clview': VIEW of the categorylinks table where we have cl_to='' (empty string) for all uncategorized pages. This VIEW must have been created by the administrator of the mediawiki DB at installation. See the documentation.
         */
        $sDplClView = '';
        if($bIncludeUncat) {
            $sDplClView = $dbr->tableName( 'dpl_clview' );
            // If the view is not there, we can't perform logical operations on the Uncategorized.
            if ( !$dbr->tableExists( 'dpl_clview' ) ) {
                $sSqlCreate_dpl_clview = 'CREATE VIEW ' . $sDplClView . " AS SELECT IFNULL(cl_from, page_id) AS cl_from, IFNULL(cl_to, '') AS cl_to, cl_sortkey FROM " . $sPageTable . ' LEFT OUTER JOIN ' . $sCategorylinksTable . ' ON '.$sPageTable.'.page_id=cl_from';
                $output .= $logger->escapeMsg(DPL2_i18n::FATAL_NOCLVIEW, $sDplClView, $sSqlCreate_dpl_clview);
                return $output;
            }
        }

        //add*** parameters have no effect with 'mode=category' (only namespace/title can be viewed in this mode)
        if( $sPageListMode == 'category' && ($bAddCategories || $bAddEditDate || $bAddFirstCategoryDate || $bAddPageTouchedDate
                                            || $bIncPage || $bAddUser || $bAddAuthor || $bAddContribution || $bAddLastEditor ) )
            $output .= $logger->escapeMsg(DPL2_i18n::WARN_CATOUTPUTBUTWRONGPARAMS);

        //headingmode has effects with ordermethod on multiple components only
        if( $sHListMode != 'none' && count($aOrderMethods) < 2 ) {
            $output .= $logger->escapeMsg(DPL2_i18n::WARN_HEADINGBUTSIMPLEORDERMETHOD, $sHListMode, 'none');
            $sHListMode = 'none';
        }

        // openreferences is incompatible with many other options
        if( $acceptOpenReferences && $bConflictsWithOpenReferences ) {
            $output .= $logger->escapeMsg(DPL2_i18n::FATAL_OPENREFERENCES);
            $acceptOpenReferences=false;
        }

        // justify limits;
        if ( isset($iCount) ) {
            if($iCount > self::$maxResultCount)	 $iCount = self::$maxResultCount;
        } else {
            if(self::$allowUnlimitedResults) 	$iCount = 99999999;
            else								$iCount = self::$maxResultCount;
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
                    if ($aSecLabels[$i][0]=='#') 	$aMultiSecSeparators[$i] = "\n----\n";
                    else							$aMultiSecSeparators[$i] = "<br/>\n";
                }
            }
        }

    // ###### BUILD SQL QUERY ######
        $sSqlPage_counter = '';
        $sSqlPage_size = '';
        $sSqlPage_touched = '';
        if ($sDistinctResultSet == 'false') $sSqlDistinct = '';
        else								$sSqlDistinct = 'DISTINCT';
        $sSqlGroupBy = '';
        if ($sDistinctResultSet == 'strict'
           && (count($aLinksTo)+count($aNotLinksTo)+count($aLinksFrom)+count($aNotLinksFrom))>0 ) $sSqlGroupBy = 'page_title';
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
        $sTemplateLinksTable = $dbr->tableName( 'templatelinks' );
        $sSqlPageLinksTable = '';
        $sSqlCond_page_pl = '';
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
                    $sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
                    break;
                case 'lastedit':
                    $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
                    $sSqlRev_timestamp = ', rev_timestamp';
                    $sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
                    break;
                case 'sortkey':
                    // We need the namespaces with strictly positive indices (DPL2 allowed namespaces, except the first one: Main).
                    $aStrictNs = array_slice(self::$allowedNamespaces, 1, count(self::$allowedNamespaces), true);
                    // map ns index to name
                    $sSqlNsIdToText = 'CASE '.$sPageTable.'.page_namespace';
                    foreach($aStrictNs as $iNs => $sNs)
                        $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs );
                    $sSqlNsIdToText .= ' END';
                    // If cl_sortkey is null (uncategorized page), generate a sortkey in the usual way (full page name, underscores replaced with spaces).
                    // UTF-8 created problems with non-utf-8 MySQL databases
					//see line 2011 (order method sortkey requires category
					if (in_array('category',$aOrderMethods)) {
						$sSqlSortkey = ", IFNULL(cl_head.cl_sortkey, REPLACE(REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' '),'â™£','â££')) ".$sOrderCollation." as sortkey";
					}
					else {
						$sSqlSortkey = ", IFNULL(cl0.cl_sortkey, REPLACE(REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' '),'â™£','â££')) ".$sOrderCollation." as sortkey";
					}
                    break;
                case 'titlewithoutnamespace':
                    $sSqlSortkey = ", REPLACE(page_title,'â™£','â££') ".$sOrderCollation." as sortkey";
                    break;
                case 'pagesel':
                    $sSqlSortkey = ", CONCAT(pl.pl_namespace,pl.pl_title) ".$sOrderCollation." as sortkey";
                    break;
                case 'title':
                    $aStrictNs = array_slice(self::$allowedNamespaces, 1, count(self::$allowedNamespaces), true);
                    // map ns index to name
                    if ($acceptOpenReferences) {
                        $sSqlNsIdToText = 'CASE pl_namespace';
                        foreach($aStrictNs as $iNs => $sNs)
                            $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
                        $sSqlNsIdToText .= ' END';
                        $sSqlSortkey = ", REPLACE(REPLACE(CONCAT( IF(pl_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), pl_title), '_', ' '),'â™£','â££') ".$sOrderCollation." as sortkey";
                    }
                    else {
                        $sSqlNsIdToText = 'CASE '.$sPageTable.'.page_namespace';
                        foreach($aStrictNs as $iNs => $sNs)
                            $sSqlNsIdToText .= ' WHEN ' . intval( $iNs ) . " THEN " . $dbr->addQuotes( $sNs ) ;
                        $sSqlNsIdToText .= ' END';
                        // Generate sortkey like for category links. UTF-8 created problems with non-utf-8 MySQL databases
                        $sSqlSortkey = ", REPLACE(REPLACE(CONCAT( IF(".$sPageTable.".page_namespace=0, '', CONCAT(" . $sSqlNsIdToText . ", ':')), ".$sPageTable.".page_title), '_', ' '),'â™£','â££') ".$sOrderCollation." as sortkey";
                    }
                    break;
                case 'user':
                    $sSqlRevisionTable = $sRevisionTable . ', ';
                    $sSqlRev_user = ', rev_user, rev_user_text';
                    break;
            }
        }

        // linksto
        if ( count($aLinksTo)>0 ) {
            $sSqlPageLinksTable .= $sPageLinksTable . ' as pl, ';
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id=pl.pl_from AND (';
            $sSqlSelPage = ', pl.pl_title as sel_title, pl.pl_namespace as sel_ns';
            $n=0;
            foreach ($aLinksTo as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '(pl.pl_namespace=' . intval( $link->getNamespace() );
                if ($bIgnoreCase) 	$sSqlCond_page_pl .= " AND UPPER(pl.pl_title)=UPPER(" . $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= " AND pl.pl_title=" . $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ')';
        }

        // notlinksto
        if ( count($aNotLinksTo)>0 ) {
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id not in (select '.$sPageLinksTable.'.pl_from from '.$sPageLinksTable.' where (';
            $n=0;
            foreach ($aNotLinksTo as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '('.$sPageLinksTable.'.pl_namespace=' . intval($link->getNamespace());
                if ($bIgnoreCase) 	$sSqlCond_page_pl .= ' AND UPPER('.$sPageLinksTable.'.pl_title)=UPPER(' . $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= ' AND       '.$sPageLinksTable.'.pl_title='        . $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ') )';
        }

        // linksfrom
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
                $sSqlPageLinksTable .= $sPageLinksTable . ' as plf, '. $sPageTable . 'as pagesrc, ';
                $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_namespace = plf.pl_namespace AND '.$sPageTable.'.page_title = plf.pl_title  AND pagesrc.page_id=plf.pl_from AND (';
                $sSqlSelPage = ', pagesrc.page_title as sel_title, pagesrc.page_namespace as sel_ns';
                $n=0;
                foreach ($aLinksFrom as $link) {
                    if ($n>0) $sSqlCond_page_pl .= ' OR ';
                    $sSqlCond_page_pl .= '(plf.pl_from=' . $link->getArticleID().')';
                    $n++;
                }
                $sSqlCond_page_pl .= ')';
            }
        }

        // notlinksfrom
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

        // uses
        if ( count($aUses)>0 ) {
            $sSqlPageLinksTable .= ' '.$sTemplateLinksTable . ' as tl, ';
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id=tl.tl_from  AND (';
            $n=0;
            foreach ($aUses as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '(tl.tl_namespace=' . intval( $link->getNamespace() );
                if ($bIgnoreCase)	$sSqlCond_page_pl .= " AND UPPER(tl.tl_title)=UPPER(" . $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= " AND       tl.tl_title="        . $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ')';
        }

        // notuses
        if ( count($aNotUses)>0 ) {
            $sSqlCond_page_pl .= ' AND '.$sPageTable.'.page_id not in (select '.$sTemplateLinksTable.'.tl_from from '.$sTemplateLinksTable.' where (';
            $n=0;
            foreach ($aNotUses as $link) {
                if ($n>0) $sSqlCond_page_pl .= ' OR ';
                $sSqlCond_page_pl .= '('.$sTemplateLinksTable.'.tl_namespace=' . intval($link->getNamespace());
                if ($bIgnoreCase)	$sSqlCond_page_pl .= ' AND UPPER('.$sTemplateLinksTable.'.tl_title)=UPPER(' . $dbr->addQuotes( $link->getDbKey() ).'))';
                else				$sSqlCond_page_pl .= ' AND '.$sTemplateLinksTable.'.tl_title=' . $dbr->addQuotes( $link->getDbKey() ).')';
                $n++;
            }
            $sSqlCond_page_pl .= ') )';
        }

        // recent changes  =============================

        if ( $bAddContribution ) {
            $sSqlRCTable = $sRCTable . ' AS rc, ';
            $sSqlSelPage .= ', SUM( ABS( rc.rc_new_len - rc.rc_old_len ) ) AS contribution, rc.rc_user_text as contributor';
            $sSqlWhere   .= ' AND page.page_id=rc.rc_cur_id';
            if ($sSqlGroupBy != '') $sSqlGroupBy .= ', ';
            $sSqlGroupBy .= 'rc.rc_cur_id';
        }

        // Revisions ==================================
        if ( $sCreatedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sCreatedBy) . ' = (select rev_user_text from '.$sRevisionTable
                                .' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp ASC limit 1)';
        }
        if ( $sNotCreatedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotCreatedBy) . ' != (select rev_user_text from '.$sRevisionTable
                                .' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp ASC limit 1)';
        }
        if ( $sModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sModifiedBy) . ' in (select rev_user_text from '.$sRevisionTable
                                .' where '.$sRevisionTable.'.rev_page=page_id)';
        }
        if ( $sNotModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotModifiedBy) . ' not in (select rev_user_text from '.$sRevisionTable.' where '.$sRevisionTable.'.rev_page=page_id)';
        }
        if ( $sLastModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sLastModifiedBy) . ' = (select rev_user_text from '.$sRevisionTable
                                .' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp DESC limit 1)';
        }
        if ( $sNotLastModifiedBy != "" ) {
            $sSqlCond_page_rev .= ' AND ' . $dbr->addQuotes($sNotLastModifiedBy) . ' != (select rev_user_text from '.$sRevisionTable
                                .' where '.$sRevisionTable.'.rev_page=page_id order by '.$sRevisionTable.'.rev_timestamp DESC limit 1)';
        }

        if ($bAddAuthor && $sSqlRevisionTable =='') {
            $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
            $sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
        }
        if ($bAddLastEditor && $sSqlRevisionTable =='') {
            $sSqlRevisionTable = $sRevisionTable . ' AS rev, ';
            $sSqlCond_page_rev = ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page )';
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
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MAX(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page AND rev_aux.rev_timestamp < '.$sLastRevisionBefore.')';
            }
            if  ($sAllRevisionsBefore!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp < '.$sAllRevisionsBefore;
            }
            if ($sFirstRevisionSince!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp=( SELECT MIN(rev_aux.rev_timestamp) FROM ' . $sRevisionTable . ' AS rev_aux WHERE rev_aux.rev_page=rev.rev_page AND rev_aux.rev_timestamp >= '.$sFirstRevisionSince.')';
            }
            if ($sAllRevisionsSince!='') {
                $sSqlCond_page_rev .= ' AND '.$sPageTable.'.page_id=rev.rev_page AND rev.rev_timestamp >= '.$sAllRevisionsSince;
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
            $sSqlPage_counter = ", $sPageTable.page_counter as page_counter";
        if ($bAddPageSize)
            $sSqlPage_size = ", $sPageTable.page_len as page_len";
        if ($bAddPageTouchedDate)
            $sSqlPage_touched = ", $sPageTable.page_touched as page_touched";
        if ($bAddUser || $bAddAuthor || $bAddLastEditor || $sSqlRevisionTable != '')
            $sSqlRev_user = ', rev_user, rev_user_text';
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
            $sSqlSelectFrom = "SELECT $sSqlDistinct " . $sSqlCl_to . 'pl_namespace, pl_title' . $sSqlSelPage . $sSqlSortkey . ' FROM ' . $sPageLinksTable;
        else
            $sSqlSelectFrom = "SELECT $sSqlDistinct " . $sSqlCl_to . $sPageTable.'.page_namespace as page_namespace,'.
            					$sPageTable.'.page_title as page_title' . $sSqlSelPage . $sSqlSortkey . $sSqlPage_counter .
                                $sSqlPage_size . $sSqlPage_touched . $sSqlRev_user .
                                $sSqlRev_timestamp . $sSqlRev_id . $sSqlCats . $sSqlCl_timestamp .
                                ' FROM ' . $sSqlRevisionTable . $sSqlRCTable . $sSqlPageLinksTable . $sPageTable;

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
                               ' AS cl' . $iClTable . ' ON '.$sPageTable.'.page_id=cl' . $iClTable . '.cl_from AND (cl' . $iClTable . '.cl_to'.
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
                ' ON '.$sPageTable.'.page_id=cl' . $iClTable . '.cl_from' .
                ' AND cl' . $iClTable . '.cl_to'. $sNotCategoryComparisonMode . $dbr->addQuotes($aExcludeCategories[$i]);
            $sSqlWhere .= ' AND cl' . $iClTable . '.cl_to IS NULL';
            $iClTable++;
        }

        // WHERE... (actually finish the WHERE clause we may have started if we excluded categories - see above)
        // Namespace IS ...
        if ( !empty($aNamespaces)) {
            if ($acceptOpenReferences)
                $sSqlWhere .= ' AND '.$sPageTable.'.pl_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
            else
                $sSqlWhere .= ' AND '.$sPageTable.'.page_namespace IN (' . $dbr->makeList( $aNamespaces) . ')';
        }
        // Namespace IS NOT ...
        if ( !empty($aExcludeNamespaces)) {
            if ($acceptOpenReferences)
                $sSqlWhere .= ' AND '.$sPageTable.'.pl_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
            else
                $sSqlWhere .= ' AND '.$sPageTable.'.page_namespace NOT IN (' . $dbr->makeList( $aExcludeNamespaces ) . ')';
        }

        // TitleIs
        if ( $sTitleIs != '' ) {
            if ($bIgnoreCase) 	$sSqlWhere .= ' AND UPPER('.$sPageTable.'.page_title) = UPPER(' . $dbr->addQuotes($sTitleIs) .')' ;
            else			 	$sSqlWhere .= ' AND '.$sPageTable.'.page_title = ' . $dbr->addQuotes($sTitleIs) ;
        }

        // TitleMatch ...
        if ( count($aTitleMatch)>0 ) {
            $sSqlWhere .= ' AND (';
            $n=0;
            foreach ($aTitleMatch as $link) {
                if ($n>0) $sSqlWhere .= ' OR ';
                if ($acceptOpenReferences) {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'UPPER(pl_title)' . $sTitleMatchMode . 'UPPER('. $dbr->addQuotes($link) . ')' ;
                    else				$sSqlWhere .= 'pl_title'        . $sTitleMatchMode .           $dbr->addQuotes($link) ;
                } else {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'UPPER(' . $sPageTable.'.page_title)' . $sTitleMatchMode . 'UPPER('. $dbr->addQuotes($link) .')' ;
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
                    if ($bIgnoreCase) 	$sSqlWhere .= 'UPPER(pl_title)' . $sNotTitleMatchMode . 'UPPER(' . $dbr->addQuotes($link) . ')';
                    else				$sSqlWhere .= 'pl_title' . $sNotTitleMatchMode . $dbr->addQuotes($link);
                } else {
                    if ($bIgnoreCase) 	$sSqlWhere .= 'UPPER('.$sPageTable.'.page_title)' . $sNotTitleMatchMode . 'UPPER(' . $dbr->addQuotes($link) .')';
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

        // count(all categories) <= max no of categories
        $sSqlWhere .= $sSqlCond_MaxCat;

        // page_id=pl.pl_from (if pagelinks table required)
        $sSqlWhere .= $sSqlCond_page_pl;

        if ( isset($sArticleCategory) && $sArticleCategory !== null ) {
            $sSqlWhere .= " AND $sPageTable.page_title IN (
                select p2.page_title
                from $sPageTable p2
                inner join $sCategorylinksTable clstc ON (clstc.cl_from = p2.page_id AND clstc.cl_to = ".$dbr->addQuotes($sArticleCategory)." )
                where p2.page_namespace = 0
                ) ";
        }

        // GROUP BY ...
        if ($sSqlGroupBy!='') {
            $sSqlWhere .= ' GROUP BY '.$sSqlGroupBy . ' ';
        }

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
                    case 'pagesel':
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
    		$sSqlWhere .= " LIMIT $iOffset, " . intval( $iCount );

        // when we go for a list of categories as result we transform the output of the normal query into a subquery
        // of a selection on the categorylinks

        if ($sGoal=='categories') {
            $sSqlSelectFrom = 'select distinct cl3.cl_to from '.$sCategorylinksTable.' as cl3 where cl3.cl_from in ( ' .
                                preg_replace('/SELECT DISTINCT .* FROM /','SELECT DISTINCT '.$sPageTable.'.page_id FROM ',$sSqlSelectFrom);
            if ($sOrder == 'descending')	$sSqlWhere .= ' ) order by cl3.cl_to DESC';
            else							$sSqlWhere .= ' ) order by cl3.cl_to ASC';
        }

    // ###### PROCESS SQL QUERY ######
        if ($logger->iDebugLevel >=3) {
            //DEBUG: output SQL query
            $output .= "DPL debug -- Query=<br>\n<tt>".$sSqlSelectFrom . $sSqlWhere."</tt>\n\n";
        }

		global $wgMessageCache, $wgMemc;
		$__cacheKey = sha1($sSqlSelectFrom . $sSqlWhere);
       	$wgMessageCache->lock($__cacheKey);
		$mem_key = wfMemcKey( 'dpl', 'query', $__cacheKey );
		$mem_key_counter = wfMemcKey( 'dpl', 'counter' );
		$data = $wgMemc->get( $mem_key );
		if ( empty($data) ) {
			try {
				$res = $dbr->query($sSqlSelectFrom . $sSqlWhere, "DPL");
			}
			catch (Exception $e) {
				$result = '';
				if (!$logger->getSuppressErrors()) {
					$result = "The DPL extension (version ".self::VERSION.") produced a SQL statement which lead to a Database error.<br>\n"
							."The reason may be an internal error of DPL or an error which you made,<br>\n"
							."especially when using DPL options like titleregexp.<br>\n"
							."Query text is:<br>\n<tt>".$sSqlSelectFrom . $sSqlWhere."</tt>\n\n"
							."Error message is:<br>\n<tt>".$dbr->lastError()."</tt>\n\n";
				}
				return $result;
			}

			if ($dbr->numRows( $res ) <= 0) {
				if ($sNoResultsHeader != '')	$output .= 	str_replace( '\n', "\n", str_replace( "Â¶", "\n", $sNoResultsHeader));
				if ($sNoResultsFooter != '')	$output .= 	str_replace( '\n', "\n", str_replace( "Â¶", "\n", $sNoResultsFooter));
				if ($sNoResultsHeader == '' && $sNoResultsFooter == '')	$output .= $logger->escapeMsg(DPL2_i18n::WARN_NORESULTS);
				$dbr->freeResult( $res );
				return $output;
			}

			$sk =& $wgUser->getSkin();
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


			$iArticle = 0;

			while( $row = $dbr->fetchObject ( $res ) ) {
				$iArticle++;

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

				// if subpages are to be excluded: skip them
				if (!$bIncludeSubpages && (!(strpos($pageTitle,'/')===false))) continue;

				// maybe we will somewhen support namespace protections
				// do not allow access to protected Namespaces
				// if (count($wgNonincludableNamespaces)>0 && in_array($pageNamespace,$wgNonincludableNamespaces) ) continue;
				// we should produce an error message if debug >= 3

				$title = Title::makeTitle($pageNamespace, $pageTitle);

				if ( !($title instanceof Title) || !($wgTitle instanceof Title) ) {
					continue;
				}

				// block recursion: avoid to show the page which contains the DPL statement as part of the result
				if ($bSkipThisPage && ($title->getNamespace() == $wgTitle->getNamespace() &&
					$title->getText() == $wgTitle->getText())) {
					// $output.= 'BLOCKED '.$wgTitle->getText().' DUE TO RECURSION'."\n";
					continue;
				}

				$dplArticle = new DPL2Article( $title, $pageNamespace );
				//PAGE LINK
				$sTitleText = $title->getText();
				if (is_array($aReplaceInTitle) && ($aReplaceInTitle[0]!='')) $sTitleText = preg_replace($aReplaceInTitle[0],(!empty($aReplaceInTitle[1])) ? $aReplaceInTitle[1] : "",$sTitleText);

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
					}

					//CATEGORY LINKS FROM CURRENT PAGE
					if($bAddCategories && $bGoalIsPages && ($row->cats != '')) {
						$artCatNames = explode(' | ', $row->cats);
						foreach($artCatNames as $iArtCat => $artCatName) {
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

		// ###### SHOW OUTPUT ######

			$listMode = new DPL2ListMode($sPageListMode, $aSecSeparators, $aMultiSecSeparators, $sInlTxt, $sListHtmlAttr,
										 $sItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);

			$hListMode = new DPL2ListMode($sHListMode, $aSecSeparators, $aMultiSecSeparators, '', $sHListHtmlAttr,
										  $sHItemHtmlAttr, $aListSeparators, $iOffset, $iDominantSection);

			$dpl = new DPL2($aHeadings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $aArticles,
							$aOrderMethods[0], $hListMode, $listMode, $bEscapeLinks, $bIncPage, $iIncludeMaxLen,
							$aSecLabels, $aSecLabelsMatch, $aSecLabelsNotMatch, $parser, $logger, $aReplaceInTitle,
							$iTitleMaxLen, $defaultTemplateSuffix, $aTableRow);

			$dpl2result = $dpl->getText();
			$header='';
			if ($sOneResultHeader != '' && $dpl->getRowCount()==1) {
				$header = str_replace('%PAGES%',1,$sOneResultHeader);
			} else if ($dpl->getRowCount()==0) {
				if ($sNoResultsHeader != '')	$output .= 	str_replace( '\n', "\n", str_replace( "Â¶", "\n", $sNoResultsHeader));
				if ($sNoResultsFooter != '')	$output .= 	str_replace( '\n', "\n", str_replace( "Â¶", "\n", $sNoResultsFooter));
				if ($sNoResultsHeader == '' && $sNoResultsFooter == '')	$output .= $logger->escapeMsg(DPL2_i18n::WARN_NORESULTS);
			}
			else {
				if ($sResultsHeader != '')	$header = str_replace('%PAGES%',$dpl->getRowCount(),$sResultsHeader);
			}
			$header = str_replace( '\n', "\n", str_replace( "Â¶", "\n", $header ));
			$footer='';
			if ($sOneResultFooter != '' && $dpl->getRowCount()==1) {
				$footer = str_replace('%PAGES%',1,$sOneResultFooter);
			} else {
				if ($sResultsFooter != '')	$footer = str_replace('%PAGES%',$dpl->getRowCount(),$sResultsFooter);
			}
			$footer = str_replace( '\n', "\n", str_replace( "Â¶", "\n", $footer ));

			$output .= $header . $dpl2result . $footer;

			// The following requires an extra parser step which may consume some time
			// we parse the DPL output and save all referenced found in that output in a global list
			// in a final user exit after the whole document processing we eliminate all these links
			// we use a local parser to avoid interference with the main parser

			if ($bReset[4] || $bReset[5] || $bReset[6] || $bReset[7] ) {
				// register a hook to reset links which were produced during parsing DPL output
				global $wgHooks;
				if (!isset($wgHooks['ParserAfterTidy']) ||
					!(in_array(__CLASS__ . '::endEliminate',$wgHooks['ParserAfterTidy']) ||
					  in_array( array( __CLASS__, 'endEliminate'),$wgHooks['ParserAfterTidy']))) {
					// changed back to globals, gs
					// $wgHooks['ParserAfterTidy'][]   = __CLASS__ . '::endEliminate';
					$wgHooks['ParserAfterTidy'][]   = __CLASS__ . '__endEliminate';
				}
				$parserOutput= $localParser->parse($output,$parser->mTitle,$parser->mOptions);
			}
			if ($bReset[4]) {	// LINKS
				// we trigger the mediawiki parser to find links, images, categories etc. which are contained in the DPL output
				// this allows us to remove these links from the link list later
				// If the article containing the DPL statement itself uses one of these links they will be thrown away!!
				foreach ($parserOutput->getLinks() as $link) {
					foreach ($link as $key => $val) {
						self::$createdLinks[0][$key]=$val;
						// $output.= "storing link $val($key).";
					}
				}
			}
			if ($bReset[5]) {	// TEMPLATES
				foreach ($parserOutput->getTemplates() as $tpl) {
					foreach ($tpl as $key => $val) {
						self::$createdLinks[1][$key]=$val;
						// $output.= "storing use of template $val($key).";
					}
				}
			}
			if ($bReset[6]) {	// CATEGORIES
				foreach ($parserOutput->mCategories as $catname => $catkey) {
					self::$createdLinks[2][$catname] = $catname;
				}
			}
			if ($bReset[7]) {	// IMAGES
				foreach ($parserOutput->mImages as $imgid => $dummy) {
					self::$createdLinks[3][$imgid] = $imgid;
				}
			}

		} else {
			$wgMemc->incr( $mem_key_counter, 1 );
			$output = $mem_key;
		}

		$wgMessageCache->unlock($__cacheKey);

        return $output;

    }

    // create keys for TableRow which representg the structure of the "include=" arguments
    private static function updateTableRowKeys(&$aTableRow,$aSecLabels) {
        $tableRow = $aTableRow;
        $aTableRow=array();
        $groupNr=-1;
        $t= -1;
        foreach ($aSecLabels as $colgroup => $label) {
            $t++;
            $groupNr++;
            $cols = explode('}:',$label);
            if (count($cols)<=1) {
                if (array_key_exists($t,$tableRow)) $aTableRow[$groupNr]=$tableRow[$t];
            }
            else {
                $n=count(explode(':',$cols[1]));
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

    private static function getSubcategories($cat,$sPageTable) {
        $dbr = wfGetDB( DB_SLAVE, 'dpl' );
        $cats=$cat;
        $res = $dbr->query("select distinct page_title from ".$dbr->tableName('page')." inner join "
                .$dbr->tableName('categorylinks')." as cl0 on ".$sPageTable.".page_id = cl0.cl_from and cl0.cl_to='"
               .str_replace(' ','_',$cat)."'"." where page_namespace='14'");
        while( $row = $dbr->fetchObject ( $res ) ) {
            $cats .= '|'.$row->page_title;
        }
        $dbr->freeResult( $res );
        return $cats;
    }

    public static function endReset( &$parser, $text ) {
        if (!self::$createdLinks['resetdone']) {
            self::$createdLinks['resetdone'] = true;
            // $text .= self::dumpParsedRefs($parser,"before final reset");
            if (self::$createdLinks['resetLinks'])			$parser->mOutput->mLinks = array();
            if (self::$createdLinks['resetCategories'])	$parser->mOutput->mCategories = array();
            if (self::$createdLinks['resetTemplates'])		$parser->mOutput->mTemplates = array();
            if (self::$createdLinks['resetImages'])		$parser->mOutput->mImages = array();
            // $text .= self::dumpParsedRefs($parser,"after final reset");
        }
        return true;
    }

    public static function endEliminate( &$parser, &$text ) {
        // called during the final output phase; removes links created by DPL
        if (isset(self::$createdLinks) || !self::$createdLinks['elimdone']) {
            self::$createdLinks['elimdone'] = true;
            // $text .= self::dumpParsedRefs($parser,"before final eliminate");
            if (isset(self::$createdLinks) && array_key_exists(0,self::$createdLinks)) {
                foreach ($parser->mOutput->getLinks() as $linkKey => $link) {
                    foreach ($link as $key => $val) {
                        if (array_key_exists($key,self::$createdLinks[0])) {
                            unset($parser->mOutput->mLinks[$linkKey][$key]);
                            // $text .= "removing link: $val($key);";
                        }
                    }
                    if (count($parser->mOutput->mLinks[$linkKey])==0) {
                        unset ($parser->mOutput->mLinks[$linkKey]);
                    }
                }
            }
            if (isset(self::$createdLinks) && array_key_exists(1,self::$createdLinks)) {
                foreach ($parser->mOutput->getTemplates() as $tplKey => $tpl) {
                    foreach ($tpl as $key => $val) {
                        if (in_array($val,self::$createdLinks[1])) {
                            unset($parser->mOutput->mTemplates[$tplKey][$key]);
                            // $text .= "removing use of template: $val($key);";
                        }
                    }
                    if (count($parser->mOutput->mTemplates[$tplKey])==0) {
                        unset ($parser->mOutput->mTemplates[$tplKey]);
                    }
                }
            }
            if (isset(self::$createdLinks) && array_key_exists(2,self::$createdLinks)) {
                foreach (self::$createdLinks[2] as $cat) {
                    unset($parser->mOutput->mCategories[$cat]);
                    // $text .= "removing cat: $cat;";
                }
            }
            if (isset(self::$createdLinks) && array_key_exists(3,self::$createdLinks)) {
                foreach (self::$createdLinks[3] as $img) {
                    unset($parser->mOutput->mImages[$img]);
                    // $text .= "removing img: $img;";
                }
            }
            // $text .= self::dumpParsedRefs($parser,"after final eliminate".$parser->mTitle->getText());
        }
        unset(self::$createdLinks);
        return true;
    }

}

// Simple Article/Page class with properties used in the DPL
class DPL2Article {
	var $mTitle = ''; 		// title
	var $mNamespace = -1;	// namespace (number)
	var $mSelTitle = '';    // selected title of initial page
	var $mSelNamespace = -1;// selected namespace (number) of initial page
	var $mLink = ''; 		// html link to page
	var $mStartChar = ''; 	// page title first char
	var $mParentHLink = ''; // heading (link to the associated page) that page belongs to in the list (default '' means no heading)
	var $mCategoryLinks = array(); // category links in the page
	var $mCategoryTexts = array(); // category names (without link) in the page
	var $mCounter = ''; 	// Number of times this page has been viewed
	var $mSize = ''; 		// Article length in bytes of wiki text
	var $mDate = ''; 		// timestamp depending on the user's request (can be first/last edit, page_touched, ...)
	var $myDate = ''; 		// the same, based on user format definition
	var $mRevision = '';    // the revision number if specified
	var $mUserLink = ''; 	// link to editor (first/last, depending on user's request) 's page or contributions if not registered
	var $mUser = ''; 		// name of editor (first/last, depending on user's request) or contributions if not registered
	var $mContribution= ''; // number of bytes changed
	var $mContrib= '';      // short string indicating the size of a contribution
	var $mContributor= '';  // user who made the changes

	function DPL2Article($title, $namespace) {
		$this->mTitle     = $title;
		$this->mNamespace = $namespace;
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
	var $mIncSecLabels         = array(); // array of labels of sections to transclude
	var $mIncSecLabelsMatch    = array(); // array of match patterns for sections to transclude
	var $mIncSecLabelsNotMatch = array(); // array of NOT match patterns for sections to transclude
	var $mParser;
	var $mParserOptions;
	var $mParserTitle;
	var $mLogger; 		// DPL2Logger
	var $mOutput;
	var $mReplaceInTitle;
 	var $filteredCount = 0;	// number of (filtered) row count
	var $nameSpaces;
	var $mTableRow;	// formatting rules for table fields

	function DPL2($headings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $articles, $headingtype, $hlistmode,
				  $listmode, $bescapelinks, $includepage, $includemaxlen, $includeseclabels, $includeseclabelsmatch,
				  $includeseclabelsnotmatch, &$parser, $logger, $replaceInTitle, $iTitleMaxLen, $defaultTemplateSuffix, $aTableRow ) {
	   	global $wgContLang;
		$this->nameSpaces = $wgContLang->getNamespaces();
		$this->mArticles = $articles;
		$this->mListMode = $listmode;
		$this->mEscapeLinks = $bescapelinks;
		$this->mIncPage = $includepage;
		if($includepage) {
			$this->mIncSecLabels         = $includeseclabels;
			$this->mIncSecLabelsMatch    = $includeseclabelsmatch;
			$this->mIncSecLabelsNotMatch = $includeseclabelsnotmatch;
		}

		if (isset($includemaxlen)) $this->mIncMaxLen = $includemaxlen + 1;
		else					   $this->mIncMaxLen = 0;
		$this->mParser = $parser;
		$this->mParserOptions = $parser->mOptions;
		$this->mParserTitle = $parser->mTitle;
		$this->mLogger = $logger;
		$this->mReplaceInTitle = $replaceInTitle;
		$this->mTableRow = $aTableRow;

		if(!empty($headings)) {
			if ($iColumns!=1 || $iRows!=1) {
				$hspace = 2; // the extra space for headings
				// repeat outer tags for each of the specified columns / rows in the output
				// we assume that a heading roughly takes the space of two articles
				$count   = count($articles) + $hspace * count($headings);
				if ($iColumns != 1) $iGroup = $iColumns;
				else				$iGroup = $iRows;
				$nsize   = floor($count / $iGroup);
				$rest    = $count - (floor($nsize) * floor($iGroup));
				if ($rest>0) $nsize += 1;
				$this->mOutput .= "{|".$sRowColFormat."\n|\n";
				if ($nsize<$hspace+1) $nsize=$hspace+1; // correction for result sets with one entry
				$this->mHeadingType = $headingtype;
				$this->mHListMode = $hlistmode;
				$this->mOutput .= $hlistmode->sListStart;
				$nstart  = 0;
				$greml = $nsize; // remaining lines in current group
				$g=0;
				$offset=0;
				foreach($headings as $heading => $headingCount) {
					$headingLink = $articles[$nstart-$offset]->mParentHLink;
					$this->mOutput .= $hlistmode->sItemStart;
					$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
					if ($bHeadingCount) $this->mOutput .= $this->formatCount($headingCount);
					$offset+=$hspace;
					$nstart+=$hspace;
					$portion= $headingCount;
					$greml-=$hspace;
					do {
						$greml -= $portion;
						// $this->mOutput .= "nsize=$nsize, portion=$portion, greml=$greml";
						if ($greml>0) {
							$this->mOutput .= $this->formatList($nstart-$offset, $portion, $iTitleMaxLen, $defaultTemplateSuffix);
							$nstart += $portion;
							$portion=0;
							break;
						}
						else {
							$this->mOutput .= $this->formatList($nstart-$offset, $portion+$greml, $iTitleMaxLen, $defaultTemplateSuffix);
							$nstart += ($portion+$greml);
							$portion = (-$greml);
							if ($iColumns!=1) 	$this->mOutput .= "\n|valign=top|\n";
							else				$this->mOutput .= "\n|-\n|\n";
							++$g;
							// if ($rest != 0 && $g==$rest) $nsize -= 1;
							if ($nstart+$nsize > $count) $nsize = $count - $nstart;
							$greml=$nsize;
							if ($greml<=0) break;
						}
					} while ($portion>0);
					$this->mOutput .= $hlistmode->sItemEnd;
				}
				$this->mOutput .= $hlistmode->sListEnd;
				$this->mOutput .= "\n|}\n";
			}
			else {
				$this->mHeadingType = $headingtype;
				$this->mHListMode = $hlistmode;
				$this->mOutput .= $hlistmode->sListStart;
				$headingStart = 0;
				foreach($headings as $heading => $headingCount) {
					$headingLink = $articles[$headingStart]->mParentHLink;
					$this->mOutput .= $hlistmode->sItemStart;
					$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
					if ($bHeadingCount) $this->mOutput .= $this->formatCount($headingCount);
					$this->mOutput .= $this->formatList($headingStart, $headingCount, $iTitleMaxLen, $defaultTemplateSuffix);
					$this->mOutput .= $hlistmode->sItemEnd;
					$headingStart += $headingCount;
				}
				$this->mOutput .= $hlistmode->sListEnd;
			}
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
				$this->mOutput .= $this->formatList($nstart, $nsize, $iTitleMaxLen, $defaultTemplateSuffix);
				if ($iColumns!=1) 	$this->mOutput .= "\n|valign=top|\n";
				else				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				// if ($rest != 0 && $g+1==$rest) $nsize -= 1;
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
				$this->mOutput .= $this->formatList($nstart, $nsize, $iTitleMaxLen, $defaultTemplateSuffix);
				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				if ($nstart >= $count) break;
			} while (true);
			$this->mOutput .= "\n|}\n";
		} else {
			$this->mOutput .= $this->formatList(0, count($articles), $iTitleMaxLen, $defaultTemplateSuffix);
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
	function substTagParm($tag, $pagename, $article, $nr, $titleMaxLength) {
		global $wgLang;
		if (strchr($tag,'%')<0) return $tag;
		$sTag = str_replace('%PAGE%',$pagename,$tag);
		$sTag = str_replace('%NAMESPACE%',$this->nameSpaces[$article->mNamespace],$sTag);

		$title = $article->mTitle->getText();
		if (strpos($title,'%TITLE')>=0) {
			if (is_array($this->mReplaceInTitle) && count($this->mReplaceInTitle)>1)
			{
				if ($this->mReplaceInTitle[0]!='') $title = preg_replace($this->mReplaceInTitle[0],$this->mReplaceInTitle[1],$title);
			}
			if( isset($titleMaxLength) && (strlen($title) > $titleMaxLength)) $title = substr($title, 0, $titleMaxLength) . '...';
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
    	if ($article->mContribution!=''){
	    	$sTag = str_replace('%CONTRIBUTION%',$article->mContribution,$sTag);
	    	$sTag = str_replace('%CONTRIB%',$article->mContrib,$sTag);
    	   	$sTag = str_replace('%CONTRIBUTOR%',$article->mContributor,$sTag);
		}
		if ($article->mUserLink != '')	$sTag = str_replace('%USER%',$article->mUser,$sTag);
    	if ($article->mSelTitle!= '')	{
	    	if ($article->mSelNamespace==0)	$sTag = str_replace('%PAGESEL%',str_replace('_',' ',$article->mSelTitle),$sTag);
	    	else	{
		    	$sTag = str_replace('%PAGESEL%',$this->nameSpaces[$article->mSelNamespace].':'.str_replace('_',' ',$article->mSelTitle),$sTag);
	    	}
    	}
	    if (!empty($article->mCategoryLinks) ) {
		    $sTag = str_replace('%'.'CATLIST%',implode(', ', $article->mCategoryLinks),$sTag);
		    $sTag = str_replace('%'.'CATNAMES%',implode(', ', $article->mCategoryTexts),$sTag);
	    }
	    else {
		    $sTag = str_replace('%'.'CATLIST%','',$sTag);
		    $sTag = str_replace('%'.'CATNAMES%','',$sTag);
	    }
		return $sTag;
	}

	function formatList($iStart, $iCount, $iTitleMaxLen, $defaultTemplateSuffix) {
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
		// the following statement caused a problem with multiple columns:  $this->filteredCount = 0;
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
				if(empty($this->mIncSecLabels)) {        					// include whole article
					$title = $article->mTitle->getPrefixedText();
					if ($mode->name == 'userformat') $incwiki = '';
					else							 $incwiki = '<br/>';
					$text = $this->mParser->fetchTemplate(Title::newFromText($title));
					if( $this->mIncMaxLen > 0 && (strlen($text) > $this->mIncMaxLen) ) {
						$text = DPL2Include::limitTranscludedText($text, $this->mIncMaxLen, ' [['.$title.'|..&rarr;]]');
					}
					$incwiki .= $text;
					$this->filteredCount = $this->filteredCount + 1;

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
 						// if sections are identified by number we have a % at the beginning
 						if ($sSecLabel[0] == '%') $sSecLabel = '#'.$sSecLabel;

						$maxlen=-1;
						if($sSecLabel[0] != '{') {
							$limpos = strpos($sSecLabel,'[');
							$cutLink='default';
							if ($limpos>0 && $sSecLabel[strlen($sSecLabel)-1]==']') {
								$cutInfo=explode(" ",substr($sSecLabel,$limpos+1,strlen($sSecLabel)-$limpos-2),2);
								$sSecLabel=substr($sSecLabel,0,$limpos);
								$maxlen=intval($cutInfo[0]);
								if (isset($cutInfo[1])) $cutLink=$cutInfo[1];
							}
							if ($maxlen<0) $maxlen = -1;  // without valid limit include whole section
						}

						// find out if the user specified an includematch / includenotmatch condition
						if (count($this->mIncSecLabelsMatch)>$s && $this->mIncSecLabelsMatch[$s] != '')
								$mustMatch = $this->mIncSecLabelsMatch[$s];
						else	$mustMatch = '';
						if (count($this->mIncSecLabelsNotMatch)>$s && $this->mIncSecLabelsNotMatch[$s] != '')
								$mustNotMatch = $this->mIncSecLabelsNotMatch[$s];
						else	$mustNotMatch = '';

						// if chapters are selected by number we get the heading from DPL2Include::includeHeading
						$sectionHeading='';
						if($sSecLabel[0] == '#') {
							$sectionHeading=substr($sSecLabel,1);
							// Uses DPL2Include::includeHeading() from LabeledSectionTransclusion extension to include headings from the page
							$secPieces = DPL2Include::includeHeading($this->mParser, $article->mTitle->getPrefixedText(), substr($sSecLabel, 1),'',
																$sectionHeading,false,$maxlen,$cutLink);
							if ($mustMatch!='' || $mustNotMatch!='') {
								$secPiecesTmp = $secPieces;
								$offset=0;
								foreach($secPiecesTmp as $nr => $onePiece ) {
									if (($mustMatch    !='' && preg_match($mustMatch   ,$onePiece)==false) ||
									    ($mustNotMatch !='' &&  preg_match($mustNotMatch,$onePiece)!=false) ) {
										array_splice($secPieces,$nr-$offset,1);
										$offset++;
									}
								}
							}
							$this->formatSingleItems($secPieces,$s);
							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])?
								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article,
													$this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if (($mustMatch!='' || $mustNotMatch!='') && count($secPieces)<=0) {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}

						} else if($sSecLabel[0] == '{') {
							// Uses DPL2Include::includeTemplate() from LabeledSectionTransclusion extension to include templates from the page
 							$template1 = substr($sSecLabel,1,strpos($sSecLabel,'}')-1);
 							$template2 = str_replace('}','',substr($sSecLabel,1));
							$secPieces = DPL2Include::includeTemplate($this->mParser, $this, $s, $article, $template1, $template2, $template2.$defaultTemplateSuffix,$mustMatch,$mustNotMatch);
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])?
 								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if (($mustMatch!='' || $mustNotMatch!='') && count($secPieces)<=1 && $secPieces[0]=='') {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}
						} else {
							// Uses DPL2Include::includeSection() from LabeledSectionTransclusion extension to include labeled sections from the page
							$secPieces = DPL2Include::includeSection($this->mParser, $article->mTitle->getPrefixedText(), $sSecLabel,'', false);
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])?
 								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if ( ($mustMatch    !='' && preg_match($mustMatch   ,$secPiece[$s])==false) ||
								 ($mustNotMatch !='' && preg_match($mustNotMatch,$secPiece[$s])!=false) ) {
								$matchFailed=true;
								break;
							}
						}

						// separator tags
						if (count($mode->sSectionTags)==1) {
							// If there is only one separator tag use it always
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[0], $pagename, $article, $this->filteredCount, $iTitleMaxLen));
						}
						else if (isset($mode->sSectionTags[$s*2])) {
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[$s*2], $pagename, $article,  $this->filteredCount, $iTitleMaxLen));
						}
						else $septag[$s*2] = '';
						if (isset($mode->sSectionTags[$s*2+1])) {
							$septag[$s*2+1] = str_replace('%SECTION%',$sectionHeading,$this->substTagParm($mode->sSectionTags[$s*2+1], $pagename, $article,  $this->filteredCount, $iTitleMaxLen));
						}
						else $septag[$s*2+1]='';

					}

					// if there was a match condition on included contents which failed we skip the whole page
					if ($matchFailed) continue;
					$this->filteredCount = $this->filteredCount + 1;

					// assemble parts with separators
					$incwiki='';
					if ($dominantPieces!=false) {
						foreach ($dominantPieces as $dominantPiece) {
							foreach ($secPiece as $s => $piece) {
								if ($s==$mode->iDominantSection) $incwiki.= $this->formatItem($dominantPiece,$septag[$s*2],$septag[$s*2+1]);
								else							 $incwiki.= $this->formatItem($piece        ,$septag[$s*2],$septag[$s*2+1]);
							}
						}
					}
					else {
						foreach ($secPiece as $s => $piece) {
							$incwiki.= $this->formatItem($piece,$septag[$s*2],$septag[$s*2+1]);
						}
					}
				}
			}
			else {
				$this->filteredCount = $this->filteredCount + 1;
			}

			if($i > $iStart) $r .= $mode->sInline; //If mode is not 'inline', sInline attribute is empty, so does nothing

			// symbolic substitution of %PAGE% by the current article's name
			if ($mode->name == 'userformat') {
				$r .= $this->substTagParm($mode->sItemStart, $pagename, $article,$this->filteredCount, $iTitleMaxLen);
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
				if($article->mContributor != '')$r .= ' . . [[User:' . $article->mContributor .'|'.$article->mContributor." $article->mContrib]]";

				if( !empty($article->mCategoryLinks) )	$r .= ' . . <SMALL>' . wfMsg('categories') . ': ' . implode(' | ', $article->mCategoryLinks) . '</SMALL>';
			}

			// add included contents

			if ($this->mIncPage) {
				DPL2Include::open($this->mParser, $this->mParserTitle->getPrefixedText());
				$r .= $incwiki;
				DPL2Include::close($this->mParser, $this->mParserTitle->getPrefixedText());
			}

			if ($mode->name == 'userformat') {
				$r .= $this->substTagParm($mode->sItemEnd, $pagename, $article, $this->filteredCount, $iTitleMaxLen);
			}
			else
				$r .= $mode->sItemEnd;
		}
		$r .= $mode->sListEnd;

		return $r;
	}

	//format one item of an entry in the output list (i.e. the collection of occurences of one item from the include parameter)
	function formatItem($piece, $tagStart, $tagEnd) {
		return $tagStart.$piece.$tagEnd;
 	}

	//format one single item of an entry in the output list (i.e. one occurence of one item from the include parameter)
	function formatSingleItems(&$pieces, $s) {
		$firstCall=true;
		foreach ($pieces as $key => $val) {
			if (array_key_exists($s,$this->mTableRow)) {
				if ($s==0 || $firstCall) {
					$pieces[$key] = str_replace('%%',$val,$this->mTableRow[$s]);
				}
				else {
					$n=strpos($this->mTableRow[$s],'|');
					if ($n===false 	|| !(strpos(substr($this->mTableRow[$s],0,$n),'{')===false)
									|| !(strpos(substr($this->mTableRow[$s],0,$n),'[')===false)) {
						$pieces[$key] = str_replace('%%',$val,$this->mTableRow[$s]);
					}
					else {
						$pieces[$key] = str_replace('%%',$val,substr($this->mTableRow[$s],$n+1));
					}
				}
			}
			$firstCall=false;
		}
 	}

	//format one single template argument of one occurence of one item from the include parameter
	// is called via a backlink from DPL2Include::includeTemplate()
	function formatTemplateArg($arg, $s, $argNr, $firstCall, $maxlen) {
		// we could try to format fields differently within the first call of a template
		// currently we do not make such a difference
		if (array_key_exists("$s.$argNr",$this->mTableRow)) {
			if ($s>=1 && $argNr==0 && !$firstCall) {
				$n=strpos($this->mTableRow["$s.$argNr"],'|');
				if ($n===false 	|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'{')===false)
								|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'[')===false)) {
					return $this->cutAt($maxlen,str_replace('%%',$arg,$this->mTableRow["$s.$argNr"]));
				}
				else {
					return $this->cutAt($maxlen,str_replace('%%',$arg,substr($this->mTableRow["$s.$argNr"],$n+1)));
				}
			}
			else {
				return $this->cutAt($maxlen,str_replace('%%',$arg,$this->mTableRow["$s.$argNr"]));
			}
		}
		return $this->cutAt($maxlen,$arg);
 	}

	//return the total number of rows (filtered)
	function getRowCount() {
 		return $this->filteredCount;
 	}

	//cut wiki text around lim
	function cutAt($lim,$text) {
		if ($lim<0) return $text;
 		return DPL2Include::limitTranscludedText($text, $lim);
 	}

	//slightly different from CategoryViewer::formatList() (no need to instantiate a CategoryViewer object)
	function formatCategoryList($iStart, $iCount) {
		for($i = $iStart; $i < $iStart + $iCount; $i++) {
			$aArticles[] = $this->mArticles[$i]->mLink;
			$aArticles_start_char[] = $this->mArticles[$i]->mStartChar;
			$this->filteredCount = $this->filteredCount + 1;
		}
		require_once ('CategoryPage.php');
		if ( count ( $aArticles ) > ExtDynamicPageList2::$categoryStyleListCutoff ) {
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
	#--- moli
	var $iSuppressErrors;

	function DPL2Logger() {
		$this->iDebugLevel = ExtDynamicPageList2::$options['debug']['default'];
		$this->iSuppressErrors = ExtDynamicPageList2::$options['suppresserrors']['default'];
	}

	public function setSuppressErrors($val) {
		$this->iSuppressErrors = $val;
	}

	public function getSuppressErrors() {
		return $this->iSuppressErrors;
	}

	/**
	 * Get a message, with optional parameters
	 * Parameters from user input must be escaped for HTML *before* passing to this function
	 */
	function msg($msgid) {
		if (($this->iDebugLevel >= ExtDynamicPageList2::$debugMinLevels[$msgid]) && (!$this->iSuppressErrors)) {
			$args = func_get_args();
			array_shift( $args );
			/**
			 * @todo add a DPL id to identify the DPL tag that generates the message, in case of multiple DPLs in the page
			 */
			return '<p>%DPL-' . ExtDynamicPageList2::VERSION . '-' .  wfMsg('dpl2_log_' . $msgid, $args) . '</p>';
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
		global $wgContLang;
		$msgid = DPL2_i18n::WARN_WRONGPARAM;
		switch($paramvar) {
			case 'namespace':
			case 'notnamespace':
				$msgid = DPL2_i18n::FATAL_WRONGNS;

				break;
			case 'linksto':
			case 'notlinksto':
			case 'linksfrom':
				$msgid = DPL2_i18n::FATAL_WRONGLINKSTO;
				break;
			case 'count':
			case 'titlemaxlength':
				$msgid = DPL2_i18n::WARN_WRONGPARAM_INT;
			case 'includemaxlength':
				$msgid = DPL2_i18n::WARN_WRONGPARAM_INT;
				break;
		}
		$paramoptions = array_unique(ExtDynamicPageList2::$options[$paramvar]);
		sort($paramoptions);
		return $this->escapeMsg( $msgid, $paramvar, htmlspecialchars( $val ), ExtDynamicPageList2::$options[$paramvar]['default'], implode(' | ', $paramoptions ));
	}

}

?>
