<?php
// this file is UTF-8 encoded and contains some special characters.
// Editing this file with an ASCII editor will potentially destroy it!
/**
 * This file handles the configuration setup for the DynamicPageList extension of MediaWiki.
 * This code is released under the GNU General Public License.
 *
 * 
 * Note: DynamicPageList is downward compatible with Extension:Intersection; 
 *       There once was a version called "DynamicPageList2" which is obsolete
 *
 * Usage:
 * 	require_once("extensions/DynamicPageList/DynamicPageList.php"); in LocalSettings.php
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
 *			Syntax error fixed (self::$createdLinks must not be unset as it is static, near line 3020)
 *			dplmatrix added
 * @version 1.6.5
 *			added include(not)matchparsed
 *          bug fix missing array key , line 2248
 *          bug fix in DPLInclude (call time reference in extractHeadings)
 *          added %VERSION%
 * @version 1.6.6
 *          SQL escaping (protection against injection) added at "revisions"
 *			%TOTALPAGES% added
 * @version 1.6.7
 *			bugfix at goal=categories (due to change in 1.6.6)
 * @version 1.6.8
 *			allow & at category 
 * @version 1.6.9
 *			added check against non-includable namespaces
 *          added includetrim' command
 * @version 1.7.0
 *			bug fix at articlecategory (underscore)
 *          bug fix in installation checking (#2128)
 *          new command 'imageused'
 * @version 1.7.1
 *			allow % within included template parameters
 * @version 1.7.2
 *			experimental sorting of result tables (tablesortcol)
 * @version 1.7.3
 *			%SECTION% can now be used within multiseseparators
 *          preliminary patch for MW 1.12 (recursive template expansion)
 * @version 1.7.4
 *			new command: imagecontainer
 * @version 1.7.5
 *			suppresserrors
 *			changed UPPER to LOWER in all SQL statements which ignore case
 *			added updaterules feature
 *          includematch now also works with include=*; note that it always tries to match the raw text, including template parameters
 *          allowcachedresults accepts now 'yes+warn'
 *          usedby
 *          CATBULLETS variable
 * @version 1.7.6
 *			error correction: non existing array index 0 when trying to includematch content in a non-existing chapter (near #3887) 
 * @version 1.7.7
 *			configuration switch allows to run DPL from protected pages only (ExtDynamicPageList::$options['RunFromProtectedPagesOnly'])
 * @version 1.7.8
 *			allow html/wiki comments within template parameter assignments (include statement, line 540ff of DynamicPageListInclude.php)
 *			accept include=* together with table=
 *			Bugfix: %PAGES% was wrong (showing total pages in some cases
 *			Bugfix: labeled section inclusion did not work because content was automatically truncated to a length of zero
 *			added minrevisions & maxrevisions
 * @version 1.7.9
 *			Bugfix in errorhandling: parameter substitution within error message did not work.
 *			Bugfix in ordermethod=lastedit, firstedit -- led to the effect that too few pages/revisions were shown
 *			new feature: dplcache
 *			bugfix: with include=* a php warning could arise (Call-time pass-by-reference has been deprecated ..)
 *			new variable %IMAGE% contains image path
 *			new variable: %PAGEID%
 *			DPL command line argument: DPL_offset
 * @version 1.8.0
 *			execution time logging
 *			added downward compatibility with Extension:Intersection:
 *				accept "dynamicpagelist" as tag and parser function
 *				new command: showcurid
 *			debug=6 added
 *			source code split into several files
 *			auto-create Template:Extension DPL
 *			changed "isChildObj" to "isLocalObj" near line 1160 (see bugreport 'Call to a memeber function getPrefixedKey() on a non-object')
 *			removal of html-comments within template calls (DPLInclude)
 *			reset/eliminate = none eingeführt
 *			DPL_count, DPL_offset, DPL_refresh eigeführt
 *			New feature: execandexit
 * @version 1.8.1
 *			bugfix: %DATE% was not expanded when addedit=true and ordermethod=lastedit were chosen
 *			bugfix: allrevisionssince delivered wrong results
 * @version 1.8.2
 *			bugfix: ordermethod=lastedit AND minoredits=exclude produced a SQL error

 *			bugfix dplcache
 *			config switch: respectParserCache
 *			date timestamp adapt to user preferences
 * @version 1.8.3
 *			bugfix: URL variable expansion
 * @version 1.8.4
 *			bugfix: title= & allrevisionssince caused SQL error
 *			added ordermethod = none
 *          changed %DPLTIME% to fractions of seconds
 *			titlematch: We now translate a space to an escaped underscore as the native underscore is a special char within SQL LIKE 
 *			new commands: linkstoexternal and addexternallink
 *			changed default for userdateformat to show also seconds DPL only; Intersection will show only the date for compatibility reasons)
 *			bugfix date/time problem 1977
 *			time conditions in query are now also translated according to timezone of server/client
 * @version 1.8.5
 *			changed the php source files to UTF8 encoding (i18n was already utf8)
 *			removed all closing ?> php tags at source file end
 *			added 'path' and changed href to "third-party" in the hook-registration
 *			added a space after showing the date in addeditdate etc.
 *			changed implementation of userdate transformation to wgLang->userAdjust()
 *			include now understands parserFunctions when used with {#xxx}
 *			include now understands tag functions when used with {~xxx}
 *			title< and title> added, 
 *			new URL arg: DPL_fromTitle, DPL_toTitle
 *			new built-in vars: %FIRSTTITLE%, %LASTTITLE%, %FIRSTNAMESPACE%, %LASTNAMESPACE%, %SCROLLDIR% (only in header and footer)
 *			removed replacement of card suit symbols in SQL query due to collation incompatibilities
 *			added special logic to DPL_fromTitle: reversed sort order for backward scrolling
 *			changed default sort in DPL to 'titlewithoutnamespace (as this is more efficient than 'title')
 *			bugfix at ordermethod = titlewithoutnamespace (led to invalid SQL statements)
 * @version 1.8.6
 *
 *
 *		! when making changes here you must update the version field in DynamicPageList.php and DynamicPageListMigration.php !
 */


// changed back to global functions due to trouble with older MW installations, g.s.
function ExtDynamicPageList__languageGetMagic( &$magicWords, $langCode ) 	{ 
	return ExtDynamicPageList::languageGetMagic( $magicWords, $langCode ); 
}
function ExtDynamicPageList__endReset( &$parser, $text ) 					{ 
	return ExtDynamicPageList::endReset( $parser, $text ); 
}
function ExtDynamicPageList__endEliminate( &$parser, $text )			 	{ 
	return ExtDynamicPageList::endEliminate( $parser, $text ); 
}

class ExtDynamicPageList
{

    public static $DPLVersion = '?';               // current version is set by DynamicPageList.php and DynamicPageListMigration.php


    /**
     * Extension options
     */
    public  static $maxCategoryCount         = 4;     // Maximum number of categories allowed in the Query
    public  static $minCategoryCount         = 0;     // Minimum number of categories needed in the Query
    public  static $maxResultCount           = 500;   // Maximum number of results to allow
    public  static $categoryStyleListCutoff  = 6;     // Max length to format a list of articles chunked by letter as bullet list, if list bigger, columnar format user (same as cutoff arg for CategoryPage::formatList())
    public  static $allowUnlimitedCategories = true;  // Allow unlimited categories in the Query
    public  static $allowUnlimitedResults    = false; // Allow unlimited results to be shown
    public  static $allowedNamespaces        = NULL;  // to be initialized at first use of DPL, array of all namespaces except Media and Special, because we cannot use the DB for these to generate dynamic page lists. 
										              // Cannot be customized. Use ExtDynamicPageList::$options['namespace'] or ExtDynamicPageList::$options['notnamespace'] for customization.
	public  static $behavingLikeIntersection = false; // Changes certain default values to comply with Extension:Intersection
	public  static $functionalRichness		 = 0;	  // The amount of functionality of DPL that is accesible for the user;
													  // .. to be set by DynamicPageList.php and DynamicPageListMigration.php
    public  static $respectParserCache		 = false; // false = make page dynamic ; true = execute only when parser cache is refreshed
													  // .. to be changed in LocalSettings.php

    /**
     * Map parameters to possible values.
     * A 'default' key indicates the default value for the parameter.
     * A 'pattern' key indicates a pattern for regular expressions (that the value must match).
     * For some options (e.g. 'namespace'), possible values are not yet defined but will be if necessary (for debugging) 
     */	
    public static $options = array(
        'addauthor'            => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addcategories'        => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addcontribution'      => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addeditdate'          => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addexternallink'      => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addfirstcategorydate' => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addlasteditor'        => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagecounter'       => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagesize'          => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'addpagetoucheddate'   => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
        'adduser'              => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
		
		// default of allowchacheresults depends on behaveasIntersetion and on LopcalSettings ...
        'allowcachedresults'   => array( 'true', 'false', 'no', 'yes', 'yes+warn', '0', '1', 'off', 'on'),
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
		 * perform the command and do not query the database
		 */
        'execandexit'		   => array('default' => ''),
		
        /**
         * number of results which shall be skipped before display starts
         * default is 0
         */
        'offset'               => array('default' => '0', 'pattern' => '/^\d*$/'),
        /**
         * Max of results to display, selection is based on random.
         */
        'count'                => array('default' => '500', 'pattern' => '/^\d*$/'),
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

        'dplcache'		       => array('default' => ''),
        'dplcacheperiod'       => array('default' => '86400', 'pattern' => '/^\d+$/'), // 86400 = # seconds for one day

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
         * - 5: <nowiki> tags around the ouput
		 * - 6: don't execute SQL statement, only show it
         */
        'debug'                => array( 'default' => '1', '0', '1', '2', '3', '4', '5', '6'),

        /**
         * eliminate=.. avoid creating unnecessary backreferences which point to to DPL results.
         *				it is expensive (in terms of performance) but more precise than "reset"
         * categories: eliminate all category links which result from a DPL call (by transcluded contents)
         * templates:  the same with templates
         * images:	   the same with images
         * links:  	   the same with internal and external links
         * all		   all of the above
         */
        'eliminate'                => array( 'default' => '', 'categories', 'templates', 'links', 'images', 'all', 'none'),
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
        'includematchparsed' => array('default' => ''),
        /** 
         * includenotmatch=..,..    allows to specify regular expressions which must NOT match the included contents
         */
        'includenotmatch'       => array('default' => ''),
        'includenotmatchparsed' => array('default' => ''),
        'includetrim'           => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
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
         * listseparators is an array of four tags (in html or wiki syntax) which defines the output of DPL
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
         * this parameter restricts the output to articles which contain an external reference that conatins a certain pattern
         * Examples:   linkstoexternal= www.xyz.com|www.xyz2.com
         */
        'linkstoexternal'      => array('default' => ''),
        /**
         * this parameter restricts the output to articles which use one of the specified images.
         * Examples:   imageused=Image:my image|Image:your image
         */
        'imageused'              => array('default' => ''),
         /**
		 * this parameter restricts the output to images which are used (contained) by one of the specified pages.
		 * Examples:   imagecontainer=my article|your article
		 */
		'imagecontainer'	 => array('default' => ''),
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
         * this parameter restricts the output to the template used by the specified page.
         */
        'usedby'               => array('default' => ''),
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
        'mode'				   => NULL,  // depends on behaveAs... mode
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
        'title<'	           => NULL,
        'title>'	           => NULL,
        'titlematch'           => NULL,
        'titleregexp'          => NULL,
        'userdateformat'	   => NULL,  // depends on behaveAs... mode
        'updaterules'          => array('default' => ''),
        'deleterules'          => array('default' => ''),

        /**
         * nottitlematch is a (SQL-LIKE-expression) pattern
         * which excludes pages matching that pattern from the result
        */
        'nottitlematch'        => NULL,
        'nottitleregexp'       => NULL,
        'order'				   => NULL,  // depends on behaveAs... mode
        /**
         * we can specify something like "latin1_swedish_ci" for case insensitive sorting
        */
        'ordercollation' => array('default' => ''),
        /**
         * 'ordermethod=param1,param2' means ordered by param1 first, then by param2.
         * @todo: add 'ordermethod=category,categoryadd' (for each category CAT, pages ordered by date when page was added to CAT).
         */
        'ordermethod'          => NULL, // depends on behaveAs... mode
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
         * Minimum/Maximum number of revisions required
         */
        'minrevisions'         => array('default' => '', 'pattern' => '/^\d*$/'),
        'maxrevisions'         => array('default' => '', 'pattern' => '/^\d*$/'),
        /**
         * noresultsheader / footer is some wiki text which will be output (instead of a warning message)
         * if the result set is empty; setting 'noresultsheader' to something like ' ' will suppress
         * the warning about empty result set.
         */
        'suppresserrors'       => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'), 
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
         * stablepages =...
         * - exclude: excludes stable pages from lists 
         * - include: allows stable pages to appear in lists
         * - only: lists only stable pages in lists
         */
        'stablepages'          => array('default' => 'include', 'exclude', 'include', 'only'),
        /**
         * qualitypages =...
         * - exclude: excludes quality pages from lists
         * - include: allows quality pages to appear in lists
         * - only: lists only quality pages in lists
         */
        'qualitypages'         => array('default' => 'include', 'exclude', 'include', 'only'),
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
        'reset'                => array( 'default' => '', 'categories', 'templates', 'links', 'images', 'all', 'none'),
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
         * showcurid creates a stable link to the current revision of a page
         */
        'showcurid'        	   => array('default' => 'false', 'true', 'no', 'yes', '0', '1', 'off', 'on'),
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
         * The number (starting with 1) of the column to be used for sorting
         */
        'tablesortcol'	       => array('default' => '0', 'pattern' => '/^-?\d*$/'),
        /**
         * Max # characters of page title to display.
         * Empty value (default) means no limit.
         * Not applicable to mode=category.
         */
        'titlemaxlength'       => array('default' => '', 'pattern' => '/^\d*$/')
    );

    // Note: If you add a line like the following to your LocalSetings.php, DPL will only run from protected pages    
	// ExtDynamicPageList::$options['RunFromProtectedPagesOnly'] = "<small><i>Extension DPL (warning): current configuration allows execution from protected pages only.</i></small>";


	public static $validParametersForRichnessLevel = array(
			0 =>	'
					addfirstcategorydate
					category
					count
					mode
					namespace
					notcategory
					order
					ordermethod
					qualitypages
					redirects
					showcurid
					shownamespace
					stablepages
					suppresserrors
					',
			1 => 	'
					allowcachedresults
					execandexit
					columns
					debug
					distinct
					escapelinks
					format
					inlinetext
					listseparators
					notnamespace
					offset
					oneresultfooter
					oneresultheader
					ordercollation
					noresultsfooter
					noresultsheader
					randomcount
					randomseed	
					replaceintitle
					resultsfooter
					resultsheader
					rowcolformat
					rows
					rowsize
					title
					title<
					title>
					titlemaxlength
					userdateformat
					',
			2 =>	'
					addauthor
					addcategories
					addcontribution
					addeditdate
					addexternallink
					addlasteditor
					addpagecounter
					addpagesize
					addpagetoucheddate
					adduser
					categoriesminmax
					createdby
					dominantsection
					dplcache
					dplcacheperiod
					eliminate
					headingcount
					headingmode
					hitemattr
					hlistattr
					ignorecase
					imagecontainer
					imageused
					include
					includematch
					includematchparsed
					includemaxlength
					includenotmatch
					includenotmatchparsed
					includepage
					includesubpages
					includetrim
					itemattr
					lastmodifiedby
					linksfrom
					linksto
					linkstoexternal
					listattr
					minoredits
					modifiedby
					multisecseparators
					notcreatedby
					notlastmodifiedby
					notlinksfrom
					notlinksto
					notmodifiedby
					notuses
					reset
					secseparators
					skipthispage
					table
					tablerow
					tablesortcol
					titlematch
					usedby
					uses
					',
			3 =>	'
					allrevisionsbefore
					allrevisionssince
					articlecategory
					categorymatch
					categoryregexp
					firstrevisionsince
					lastrevisionbefore
					maxrevisions
					minrevisions
					notcategorymatch
					notcategoryregexp
					nottitlematch
					nottitleregexp
					openreferences
					titleregexp
					',
			4 => 	'
					deleterules
					goal
					updaterules
					',
		);
		


    public static $debugMinLevels = array();
    public static $createdLinks; // the links created by DPL are collected here;
                                 // they can be removed during the final ouput
                                 // phase of the MediaWiki parser

    private static function behaveLikeIntersection($mode) {
		self::$behavingLikeIntersection = $mode;
	}

    public static function setFunctionalRichness($level) {
		self::$functionalRichness = $level;
	}

    public static function setupDPL() {

		global $wgParser;

		self::loadModules();

		// DPL offers the same functionality as Intersection; so we register the <DynamicPageList> tag
		// in case LabeledSection Extension is not installed we need to remove section markers

        $wgParser->setHook( 'section',            array( __CLASS__, 'removeSectionMarkers'     ) );
        $wgParser->setHook( 'DPL',                array( __CLASS__, 'dplTag'                   ) );
		$wgParser->setHook( 'DynamicPageList',    array( __CLASS__, 'intersectionTag'          ) );
		
        $wgParser->setFunctionHook( 'dpl',        array( __CLASS__, 'dplParserFunction'        ) );
        $wgParser->setFunctionHook( 'dplchapter', array( __CLASS__, 'dplChapterParserFunction' ) );
        $wgParser->setFunctionHook( 'dplmatrix',  array( __CLASS__, 'dplMatrixParserFunction'  ) );

		self::commonSetup();
    }
	
    public static function setupMigration() {
		self::loadModules();

		// DPL offers the same functionality as Intersection under the tag name <Intersection>
        global $wgParser;
		$wgParser->setHook( 'Intersection', array( __CLASS__, 'intersectionTag' ) );
		
		self::commonSetup();
    }

	private static function commonSetup() {

		global $wgMessageCache;

        foreach( DPL_i18n::getMessages() as $sLang => $aMsgs )
        {
            $wgMessageCache->addMessages( $aMsgs, $sLang );
        }

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

		// make sure page "Template:Extension DPL" exists
        $title = Title::newFromText('Template:Extension DPL');
		global $wgUser;
		if (!$title->exists() && $wgUser->isAllowed('edit')) {
			$article = new Article($title);
			$article->doEdit( "<noinclude>This page was automatically created. It serves as an anchor page for ".
							  "all '''[[Special:WhatLinksHere/Template:Extension_DPL|invocations]]''' ".
							  "of [http://mediawiki.org/wiki/Extension:DynamicPageList Extension:DynamicPageList (DPL)].</noinclude>",
							  $title, EDIT_NEW | EDIT_FORCE_BOT );
			die(header('Location: '.Title::newFromText('Template:Extension DPL')->getFullURL()));
		}

	}

	private static function loadModules() {
		
        // Page Transclusion, adopted from Steve Sanbeg´s LabeledSectionTransclusion
        require_once( 'DynamicPageListInclude.php' );
        require_once( 'DynamicPageList.i18n.php' );
        require_once( 'DPL.php' );
        require_once( 'DPLMain.php' );
        require_once( 'DPLArticle.php' );
        require_once( 'DPLListMode.php' );
        require_once( 'DPLLogger.php' );
	}
	
    public static function languageGetMagic( &$magicWords, $langCode ) {
            # Add the magic word
            # The first array element is case sensitivity, in this case it is not case sensitive
            # All remaining elements are synonyms for our parser function
            $magicWords['dpl'] = array( 0, 'dpl' );
            $magicWords['dplchapter'] = array( 0, 'dplchapter' );
            $magicWords['dplmatrix'] = array( 0, 'dplmatrix' );
            $magicWords['DynamicPageList'] = array( 0, 'DynamicPageList' );
            # unless we return true, other parser functions extensions won't get loaded.
            return true;
    }

    //------------------------------------------------------------------------------------- ENTRY parser TAG intersection
    public static function intersectionTag( $input, $params, &$parser ) {
		self::behaveLikeIntersection(true);
		return self::executeTag($input, $params, $parser);
	}

    //------------------------------------------------------------------------------------- ENTRY parser TAG dpl
    public static function dplTag( $input, $params, &$parser ) {
		self::behaveLikeIntersection(false);
		return self::executeTag($input, $params, $parser);
	}

    //------------------------------------------------------------------------------------- ENTRY parser TAG
    // The callback function wrapper for converting the input text to HTML output
    private static function executeTag( $input, $params, &$parser ) {

        // entry point for user tag <dpl>  or  <DynamicPageList>
        // create list and do a recursive parse of the output
    
        // $dump1   = self::dumpParsedRefs($parser,"before DPL tag");
        $text    = DPLMain::dynamicPageList($input, $params, $parser, $reset, 'tag');
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



    //------------------------------------------------------------------------------------- ENTRY parser FUNCTION #dpl
    public static function dplParserFunction(&$parser) {

		self::behaveLikeIntersection(false);
		
        // callback for the parser function {{#dpl:   or   {{DynamicPageList::
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
        // $text    = DPLMain::dynamicPageList($input, $params, $parser, $reset, 'func');
        // $dump2   = self::dumpParsedRefs($parser,"after DPL func");
        // return $dump1.$text.$dump2;
        
        $dplresult = DPLMain::dynamicPageList($input, $params, $parser, $reset, 'func');
        global $wgVersion;
        if (version_compare($wgVersion, '1.12.0')<0 || $parser instanceof Parser_OldPP) return $dplresult;
        // old parser does further recursive processing by default
        return array( // normal parser needs to be coaxed to do further recursive processing
	        $parser->getPreprocessor()->preprocessToObj($dplresult, Parser::PTD_FOR_INCLUSION ),
    	    'isLocalObj' => true,
    	    'title' => $parser->getTitle()
        );

    }

    public static function dplChapterParserFunction(&$parser, $text='', $heading=' ', $maxLength = -1, $page = '?page?', $link = 'default', $trim=false ) {
        $arg_list = func_get_args();
        $output = DPLInclude::extractHeadingFromText($parser, $page, '?title?', $text, $heading, '', $sectionHeading, true, $maxLength, $link, $trim);
        return $output[0];
    } 

    public static function dplMatrixParserFunction(&$parser, $name, $yes, $no, $flip, $matrix ) {
        $arg_list = func_get_args();
        $lines = split("\n",$matrix);
        $m = array();
        $sources = array();
        $targets = array();
        $from = '';
        $to = '';
        if ($flip=='' | $flip=='normal') 	$flip=false;
        else								$flip=true;
        if ($name=='') $name='&nbsp;';
        if ($yes=='') $yes= ' x ';
        if ($no=='') $no = '&nbsp;';
        if ($no[0]=='-') $no = " $no ";
        foreach ($lines as $line) {
	        if (strlen($line)<=0) continue;
	        if ($line[0]!=' ') {
		        $from = preg_split(' *\~\~ *',trim($line),2);
		        if (!array_key_exists($from[0],$sources)) {
			        if (count($from)<2 || $from[1]=='') $sources[$from[0]] = $from[0];
			        else								$sources[$from[0]] = $from[1];
			        $m[$from[0]] = array();
		        }
	        }
	        else if (trim($line) != '') {
		        $to = preg_split(' *\~\~ *',trim($line),2);
		        if (count($to)<2 || $to[1]=='') $targets[$to[0]] = $to[0];
		        else							$targets[$to[0]] = $to[1];
		        $m[$from[0]][$to[0]] = true;
	        }
        }
        ksort($targets);

        $header = "\n";
        
        if ($flip) {
	        foreach ($sources as $from => $fromName) {
		        $header .= "![[$from|".$fromName."]]\n";
        	}
	        foreach ($targets as $to => $toName) {
		        $targets[$to] = "[[$to|$toName]]";	        
		        foreach ($sources as $from => $fromName) {
			        if (array_key_exists($to,$m[$from])) {
				        $targets[$to] .= "\n|$yes";
			        }
			        else {
				        $targets[$to] .= "\n|$no";
			        }
		        }
		        $targets[$to].= "\n|--\n";
	        }
	        return "{|class=dplmatrix\n|$name"."\n".$header."|--\n!".join("\n!",$targets)."\n|}";
        }
        else {
	        foreach ($targets as $to => $toName) {
		        $header .= "![[$to|".$toName."]]\n";
        	}
	        foreach ($sources as $from => $fromName) {
		        $sources[$from] = "[[$from|$fromName]]";	        
		        foreach ($targets as $to => $toName) {
			        if (array_key_exists($to,$m[$from])) {
				        $sources[$from] .= "\n|$yes";
			        }
			        else {
				        $sources[$from] .= "\n|$no";
			        }
		        }
		        $sources[$from].= "\n|--\n";
	        }
	        return "{|class=dplmatrix\n|$name"."\n".$header."|--\n!".join("\n!",$sources)."\n|}";
        }
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

    public static function endReset( &$parser, $text ) {
        if (!self::$createdLinks['resetdone']) {
            self::$createdLinks['resetdone'] = true;
            // $text .= self::dumpParsedRefs($parser,"before final reset");
            if (self::$createdLinks['resetLinks'])		$parser->mOutput->mLinks 		= array();
            if (self::$createdLinks['resetCategories'])	$parser->mOutput->mCategories 	= array();
			if (self::$createdLinks['resetTemplates'])  $parser->mOutput->mTemplates 	= array();
            if (self::$createdLinks['resetImages'])		$parser->mOutput->mImages 		= array();
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
        self::$createdLinks=array( 
                'resetLinks'=> false, 'resetTemplates' => false, 
                'resetCategories' => false, 'resetImages' => false, 'resetdone' => false );
        return true;
    }

}
