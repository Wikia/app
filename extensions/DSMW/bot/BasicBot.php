<?php
/*
		**********************
		BasicBot	v1.22	c2007
		**********************


Adam's bot template. Use this to create your own PHP-based bots for MediaWiki sites.

Before beginning, you should DEFINITELY read this, even if your bot will be on a wiki other than Wikipedia:
	* http://en.wikipedia.org/wiki/Wikipedia:Creating_a_bot

Reading this will help you understand some of the code in the class below:
	* http://www.mediawiki.org/wiki/Manual:Parameters_to_index.php

You will also need the following:
	* PHP 5. If not, check my tutorial for a small patch that should make this work in PHP 4 (from what folks tell me, anyway)
	* Snoopy. Snoopy is a PHP class that makes it MUCH easier to submit forms (like MediaWiki edit forms, for example) via PHP.
		You can download Snoopy here:		http://snoopy.sourceforge.net/
		You should probably take a quick look at Snoopy's readme before trying to understand my code. My code simply extends the snoopy class.

What you'll find below is a template for building your own PHP-based bots to do automated tasks on sites powered by MediaWiki. I don't care what tasks you have in mind,
this template should help you out. I've put quite a bit of commenting into this file to make your life easier. However, you should probably read my tutorial first,
which gives a nice clear explanation of what this file does and how to use it. In fact, if you read the tutorial, you probably won't even need to look at this file in order to use it, at least
for relatively basic bots.
	* My tutorial:	http://wikisum.com/w/User:Adam/Creating_MediaWiki_bots_in_PHP

Recommended usage: Don't edit this file. Just include it into another file, then extend the class or define new callbacks as needed. That way, you can use
this file for as many bots as you want without making the file unwieldy and huge. This file should have come with a companion file, ChangeCategory.php, that
should give you an idea of what I mean.

IMPORTANT: Be sure to check the settings below before getting started.

TROUBLESHOOTING
Please note that I developed this code for my own use. I haven't tested it on any wiki other than wikisummary.com, and I haven't tested it in any environment
other than the one I run my wiki on (PHP 5, Linux). I share this code in hopes that it will be helpful to you--when I wrote this, I was unable to find anything comparable
out there. But I'm sure you'll come across bugs as you try to use this, since I really haven't tested it for anything other than what I use it for. You are especially
likely to have problems with my link harvesting functions, since some of them require CSS classes or IDs that my wiki's custom template uses but your wiki probably doesn't use.
 You're mainly on your own when it comes to solving bugs--I don't really have the time. But here are a few suggestions that might help:
	* Start by double checking all the settings below.
	* Make sure your cache and temp directories exist on the server and are writable.
	* If you're getting an error message, search this file for that message to see what caused it.
	* For help writing callback functions, look at the very end of this file. See also the companion file, which is a demo of a fully functional bot.
	* My code assumes that your wiki requires logging in to edit, not to read. If you must log in to read, search this file for "read" and uncomment the relevant parts.
If you do find and fix a bug, please send me a patch so that others can benefit. Thanks.

HOW TO SAY THANKS:
	* I appreciate links to one or more of these:
		My wiki: 		http://wikisum.com (could really use some inbound links...)
		My site: 		http://adambrown.info
		This script:		http://wikisum.com/w/User:Adam/Creating_MediaWiki_bots_in_PHP
	* If you fix a bug, send me a note. You'll find my contact info at http://adambrown.info/p/about
*/

######################################################### #
######################################################### #
//		SETTINGS
######################################################### #
######################################################### #

// we'll detect our absolute path. You can override this is you want.
$abspath = dirname( __FILE__ );

// adjust as necessary
define( 'SITECHARSET', 'UTF-8' );
define( 'SERVER', '' );
define( 'PREFIX', '' ); // no trailing slash. The prefix you use for index.php?title= links (e.g. editing links). Set to '' if you use no prefix other than what's in SERVER.
define( 'ALTPREFIX', '/w' ); // no trailing slash. The prefix on valid links that visitors usually see. Might be the same as PREFIX if you don't use "pretty" links.
define( 'CACHE', $abspath . '/cache/' ); // a path where we can store cache files to. SHOULD EXIST and be writeable by the server. Stored for longer than files in TEMP.
define( 'TEMP', $abspath . '/temp/' ); // a path where we can store temp files to. SHOULD EXIST and be writeable by the server. Can be the same as CACHE if you want.
define( 'COOKIETIME', 3600 ); // how many seconds should we hold our login cookies before refreshing them? Defaults to 3600 seconds = 1 hour.
define( 'DELAY', 5 ); // default number of seconds that bots wait between requests to the wiki. Check your wiki's policies. Set to at least 30 if you aren't sure.

// if you want, you can put your default userid, username, and password into a separate file. I do it just so I don't accidentally upload a copy of this with my username and password inside :)
if ( file_exists( 'username.php' ) )
	require_once( 'username.php' );
// ELSE you need to fill out the next few settings.
if ( !defined( 'USERID' ) ) {	define( 'USERID', '1' ); } // find it at Special:Preferences
if ( !defined( 'USERNAME' ) ) {	define( 'USERNAME', 'WikiSysop' ); }
if ( !defined( 'PASSWORD' ) ) {	define( 'PASSWORD', 'admin' ); } // password in plain text. No md5 or anything.


######################################################### #
######################################################### #
// DONE WITH SETTINGS.
######################################################### #
######################################################### #

require_once( 'Snoopy.class.php' ); // you can change this if snoopy is someplace else, obviously

if ( is_array( $_GET ) ) {
	foreach ( $_GET as $GETkey => $GETval )
		if ( !is_array( $GETval ) ) { $_GET[$GETkey] = stripslashes( $GETval ); }
}

############################################################# #
############# # you probably don't need to edit this ##########
############# # look at the end of this file for more help ####
############################################################# #
class BasicBot extends Snoopy {
	var $wikiUserID = USERID;
	var $wikiUser = USERNAME;
	var $wikiPass = PASSWORD;
	var $wikiServer = SERVER;
	var $wikiCookies; // will hold the file name where our cookies are stored.
	var $wikiConnected = false;
	var $wikiTitle; // holds the title that wikiFilter has just called from. Makes it easy to know where we are when doing a FilterAll function.

	/***************************************
	FUNCTIONS THAT YOU ARE LIKELY TO INTERACT WITH START HERE
	****************************************/

	// wikiFilter is a single-use filter. You'll probably call this directly only when you are testing a new filtering callback. Otherwise, try wikiFilterAll() instead.
	// You don't need to edit this function to change filter behavior. Instead, create a new CALLBACK function (see the end of this file for examples).
	// grabs the content of $title, then passes it to $callback, which returns the new content. If the new content is different from the old content, this function edits the wiki with the new content.
	function wikiFilter( $title, $callback, $summary = '', $callbackParams = array() ) {
		if ( !$this->wikiConnect() )
			die ( "Unable to connect." );
		// $this->fetchform doesn't work for us because it strips out the content of the <textarea>. So use $this->fetch instead first:
		$this->wikiTitle = $title; // for use by callbacks in our various bots, if needed. E.g. see FindRelatedLinksBot
		if ( !$this->fetch( $this->wikiServer . PREFIX . '/index.php?title=' . $title . '&action=edit' ) )
			return false;

		// in order to save changes, you'll need to submit a few hidden vars. See http://www.mediawiki.org/wiki/Manual:Parameters_to_index.php#Parameters_that_are_needed_to_save
		// you'll need the edit token. Usually looks something like this: <input type='hidden' value="cb6843e700be730a715813304648ff20" name="wpEditToken" />
		// in later versions of MW, you might also see an edit token of "\+" (if not logged in) or a token like my example but with \ at the end. So we look for 0-9, a-z, \, and +:
		# if (1!=preg_match("|<input[^>]*value=['\"]([0-9a-z]*)['\"] name=['\"]wpEditToken['\"]|Ui",$this->results,$editToken)) // for older versions.
		if ( 1 != preg_match( "|<input[^>]*value=['\"]([0-9a-z\\\+]*)['\"] name=['\"]wpEditToken['\"]|Ui", $this->results, $editToken ) )
			return false;
		$post_vars['wpEditToken'] = $editToken[1];

		// you'll also need wpStarttime and wpEdittime
		if ( 1 != preg_match( "|<input[^>]*value=['\"]([0-9a-z]*)['\"] name=['\"]wpStarttime['\"]|Ui", $this->results, $startTime ) )
			return false;
		$post_vars['wpStartime'] = $startTime[1];
		if ( 1 != preg_match( "|<input[^>]*value=['\"]([0-9a-z]*)['\"] name=['\"]wpEdittime['\"]|Ui", $this->results, $editTime ) )
			return false;
		$post_vars['wpEdittime'] = $editTime[1];

		// a couple other vars we'll need to post.
		$post_vars['wpSummary'] = $summary; // let's leave an edit summary
		$post_vars['wpSave'] = 'Save page'; // we want to save, not preview, not see diffs.

		// now let's grab the current content and run it through our filter
		if ( 1 != preg_match( "|<textarea[^>]*name=['\"]wpTextbox1['\"][^>]*>(.*)</textarea>|Usi", $this->results, $content ) )
			return false;
		$content = htmlspecialchars_decode( $content[1] ); // turn all the &quot; back into ", else MediaWiki will turn the &quot; into &amp;quot;
		$post_vars['wpTextbox1'] = call_user_func( $callback, $content, $callbackParams );
		if ( false === $post_vars['wpTextbox1'] )
			die( 'Callback returns an error.' );
		if ( $content == $post_vars['wpTextbox1'] ) // no editing necessary; our callback made no changes
			return true;

		// all done. Let's submit the form.
		$this->maxredirs = 0; // we don't want to redirect from edit from back to article, or else we won't be able to sniff response codes to check for success.
		if ( $this->submit( $this->wikiServer . PREFIX . '/index.php?title=' . $title . '&action=submit', $post_vars ) ) {
			// Now we need to check whether our edit was accepted. If it was, we'll get a 302 redirecting us to the article. If it wasn't (e.g. because of an edit conflict), we'll get a 200.
			$code = substr( $this->response_code, 9, 3 ); // shorten 'HTTP 1.1 200 OK' to just '200'
			if ( '200' == $code )
				return false;
			elseif ( '302' == $code )
				return true;
			else
				return false; // if you get this, it's time to debug.
		} else {
			// we failed to submit the form.
			return false;
		}
	}

	// 	if you're doing something (like editing) that requires being logged in, start your function with a condition like this:	if ($this->wikiConnect())
	function wikiConnect() {
		$this->wikiCookies = CACHE . 'cookies_' . $this->wikiUser . '.php';
		if ( $this->wikiConnected ) 		// no need to repeat all this if it's already been done.
			return true;
		if ( file_exists( $this->wikiCookies ) && ( filemtime( $this->wikiCookies ) > ( time() - COOKIETIME ) ) ) { // check cookie freshness
			include_once( $this->wikiCookies ); 	// load cookies from cache
			$this->cookies = $cookiesCache;
			$this->wikiConnected = true;
			return $this->wikiConnected; // we have the cookies, proceed with whatever you want to do.
		} else {
			return $this->wikiLogin(); 	// if true, we have the cookies, proceed with whatever you want to do.
		}
	}

	// harvests all internal links from a $source article and stores them in temp directory. (If $source is Special, use SpecialFilterAll instead.)
	// on each subsequent load, picks the next link from the list and runs it through $this->wikiFilter using the supplied callback.
	// $metaReload is number of seconds it waits between edits. Just open in a window and let it run in the background. Or you could use a cron if you want, but function assumes you don't.
	// ignores category links in the $source article by default; harvests only true internal links. Set $stripCats to false to change this.
	// it will write an edit summary using $summary.
	function wikiFilterAll( $source, $callback, $summary = '', $callbackParams = array(), $metaReload = DELAY, $stripCats = true ) {
		// don't change these next four lines; other __FilterAll() methods (e.g. SpecialFilterAll()) assume they'll look just like this.
		if ( !$_GET['cache'] )	// the <meta> reload will append ?cache= to the current URL. If it's there, then we know we've already harvested the links. If not, start by harvesting.
			$cache = $this->wikiHarvestLinks( $source, $stripCats );	// harvest the links from $source and store them to $cache
		else
			$cache = $_GET['cache'];
		// again, don't change the preceding four lines.
		$links = $this->LoadLinksCache( $cache );
		$link = $links[0];	// use the link at the top of the cache array.
		if ( $this->wikiFilter( $link, $callback, $summary, $callbackParams ) ) {
			array_shift( $links );	// remove the first link from the array.
			if ( 0 == count( $links ) ) {	// if TRUE, then we're all done.
				unlink( $cache );		// delete the cache file.
				echo( 'All done!' );
				if ( '' != $_GET['nuFile'] ) // used by one of my bots (the RecentChangesBot). You can delete this if you want.
					echo '<br /><br />Needs update: <a href="RecentChangesLinkBot.php?nuFile=' . $_GET['nuFile'] . '">' . $_GET['nuFile'] . '</a>.';
				die;
			}
			$this->UpdateLinksCache( $cache, $links );
			$success = true;
		} else {
			$success = false;
			$usualReload = $metaReload;
			$metaReload = '300'; // when we fail to edit successfully, make sure we wait five minutes in case we're setting off flood alarms and that's why we're failing.
		}
		$getstring = '?cache=' . $cache;
		if ( 1 < count( $_GET ) ) {	// some form-based bots may create additional GET vars that we need to preserve (besides just "cache", which we've already got)
			foreach ( $_GET as $getvar => $getvalue ) {
				if ( $getvar != 'cache' )	// already took care of cache
					$getstring .= '&amp;' . $getvar . '=' . $getvalue;
			}
		}
		$out = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html>
			<head>
				<title>' . $callback . '</title>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<meta http-equiv="refresh" content="' . $metaReload . ';url=' . $getstring . '" />
				<meta name="robots" content="noindex, nofollow" />
			</head>
			<body>
				<h2>' . $callback . '</h2>
				<p>Cache: ' . $cache . '</p>
				<p>Source: ' . $source . '</p>
				<p>Current: <a href="' . $this->wikiServer . PREFIX . '/index.php?title=' . $link . '">' . $link . '</a></p>
				<p>Remaining: ' . count( $links ) . ' articles.</p>

		';
		if ( $success ) {
			$out .= '<p style="color:#00f;"><strong>Successfully filtered.</strong> Waiting ' . $metaReload . ' seconds...</p>';
			$out .= '<p>If status code below is "200," then the callback function made no changes. If status code is "302", then changes were successfully made.</p>';
		} else {
			$out .= '<p style="color:#f00;"><strong>Filtering failed.</strong> Will wait ' . $metaReload . ' seconds until the next attempt instead of the usual ' . $usualReload . ', just in case the failure happened due to moving too fast. You can obviously just hit "reload" if you want to proceed immediately.</p>';
			$out .= '<p>If status code below is "200," then we probably encountered an editing error from the wiki. Append "&showall=1" to this page\'s URL (then reload) to see more information.</p>';
		}
		$out .= $this->failureInfo();
		$out .= '
			</body>
			</html>
		';
		echo $out;
	}

	// analagous to wikiFilterAll(), but for special pages as $source.
	function SpecialFilterAll( $source, $callback, $summary = '', $callbackParams = array(), $metaReload = DELAY ) {
		$_GET['cache'] = $this->SpecialLinksCache( $source ); // load up the harvested links from the cache.
		$this->wikiFilterAll( $source, $callback, $summary, $callbackParams, $metaReload );
	}

	// analogous to wikiFilterAll(), but uses a user-defined array of links to process instead of harvesting the links from an existing page in the wiki
	function ArrayFilterAll( $links, $callback, $summary = '', $callbackParams = array(), $metaReload = DELAY ) {
		$_GET['cache'] = $this->ArrayLinksCache( $links );
		$this->wikiFilterAll( 'User-provided array', $callback, $summary, $callbackParams, $metaReload );
	}

	// analagous to wikiFilterAll(), but harvests links from a Category. You'll need to edit mediawiki/includes/CategoryPage.php and wrap
	// the list of category links in <div class="categoryItems">...</div> for this to work for you. Sorry.
	function CategoryFilterAll( $source, $callback, $summary = '', $callbackParams = array(), $metaReload = DELAY ) {
		$_GET['cache'] = $this->CategoryLinksCache( $source ); // load up the harvested links from the cache.
		$this->wikiFilterAll( $source, $callback, $summary, $callbackParams, $metaReload );
	}

	/* How FilterRecentChanges works:
	* 	Checks for previously harvested links.
	*	If there are no previously harvested links:
		* 	Checks for $file, which will contain a timestamp ($cacheTime) indicating the last time that we harvested
			  from Special:RecentChanges. It will also contain the name of the temp file ($cache) where we stored links after our last harvest.
			  For clarity, we call the harvested links file $cache and the temp data file $file
		* 	If no $file exists, then this is probably our first use of this bot. So we grab all changes from last 7 days to start with and harvest links from them into $cache.
		* 	Harvests article titles from Special:RecentChanges, removing duplicates (i.e. articles edited more than once since last we checked).
		* 	Examines only MAIN namespace (ns=0) by default. To do all, set $namespace=FALSE.
		* 	Caches the harvested links into $cache, just like other filtering functions do.
	* 	With harvested links: Runs them all through a callback, just like wikiFilterAll does. When it's done, it deletes the temp file with the harvested links. So on next call, there won't be
		previously harvested links, and we start all over again.
	*/
	function FilterRecentChanges( $callback, $editSummary = '', $params = array(), $delay = DELAY, $namespace = 0 ) {
		$ns_plug = ( false === $namespace ) ? 'ALL' : $namespace;
		$file = CACHE . 'RCPatrol_' . $ns_plug . '_' . $callback . '.php'; // filename where we store some data we need
		$notFirstTime = $this->RecentChangesData( $file ); // true if file exists, false if file is created, die if false and file cannot be created
		require( $file ); // we now have $cacheTime and $cache
		if ( $notFirstTime ) {
			if ( file_exists( $cache ) ) {	// if TRUE, we're continuing a job (i.e. we have a previously cached link harvest to work on)
				$_GET['cache'] = $cache;
			} else {	// we need a new link harvest
				$lastTime = $cacheTime; // copy $cacheTime before we overwrite it
				$this->RecentChangesData( $file, true ); // update $cache to reflect our new harvest
				require( $file ); // grab our new $cache (and $cacheTime)
				$_GET['cache'] = $this->HarvestRecentChanges( $lastTime, $cache, $namespace );
			}
		} else {	// apparently this is the first time we've used this bot. On first use, let's get the last 7 days worth of data.
			$cacheTime = date( "YmdHis", mktime( gmdate( "H" ), gmdate( "i" ), gmdate( "s" ), gmdate( "m" ), gmdate( "d" ) -7, gmdate( "Y" ) ) );
			$_GET['cache'] = $this->HarvestRecentChanges( $cacheTime, $cache, $namespace );
		}
		$this->wikiFilterAll( 'Recent Changes Patrol', $callback, $editSummary, $params, $delay );
	}


	/***************************************
	THIS IS THE END OF FUNCTIONS THAT YOU ARE LIKELY TO INTERACT WITH

	THE REST OF THE CLASS IS  UTILITY FUNCTIONS THAT YOU PROBABLY WON'T INTERACT WITH
	****************************************/
	// You shouldn't ever need to call this. Call wikiConnect instead if you need to do something that requires a log in.
	// in fact, you can't call it first; wikiConnect needs to define $this->wikiCookies before this will work right.
	function wikiLogin() {
		unset( $this->cookies );
		$vars['wpName'] = $this->wikiUser;
		$vars['wpPassword'] = $this->wikiPass;
		$vars['wpRemember'] = 1;
		$vars['wpLoginattempt'] = "Log+in";
		$loginUrl = $this->wikiServer . PREFIX . '/index.php?title=Special:Userlogin&amp;action=submitlogin&amp;type=login';
		if ( $this->submit( $loginUrl, $vars ) ) {
			/* 	okay, our 4 cookies will be now be in $this->cookies as an array. They look something like this (don't try hacking my site; I changed these):
				    [wikisum__session] => gb6b4s4u6aj9prifqla73pn096
				    [wikisum_UserID] => 2
				    [wikisum_UserName] => Botusername
				    [wikisum_Token] => efd9573b9255c93bcfee1d8a990de617
				Now we need to store this information somewhere.
			*/
			if ( is_array( $this->cookies ) ) {
				$cookiesCache = '<?php $cookiesCache = array( '; // yeah, I know, I could have just used "serialize". Sue me.
				foreach ( $this->cookies as $name => $value )
					$cookiesCache .= "'$name' => '$value',";
				$cookiesCache .= '); ?>';
				if ( file_put_contents( $this->wikiCookies, $cookiesCache ) )
					$this->wikiConnected = true; // we have the cookies and we've cached them successfully. Proceed.
			}
		}
		return $this->wikiConnected; // We've got 3 IFs up there, and if any one fails, this will be true.
	}

	function failureInfo() {
		$out .= '<ul>';
		$out .= '<li>' . $this->response_code . '</li>';
		$out .= '</ul>';
		if ( $_GET['showall'] )
			$out .= $this->results;
		return $out;
	}

	// you probably want wikiLinks(), not wikiAllLinks(). This is just here as an example.
	// returns an array of all the links that a particular article has. Ignores links in the sidebar; only includes links in the actual article.
	// WILL include external links and links from the table of contents and from any included templates. If you don't want this, use $this->wikiLinks() instead.
	function wikiAllLinks( $title ) {
		$this->fetchlinks( $this->wikiServer . PREFIX . '/index.php?title=' . $title . '&action=render' );
		var_dump( $this->results );
	}

	// you probably won't ever need to call this directly. Try wikiFilterAll() instead.
	// Fetches $source; sends the results to wikiLinks(), which returns an array of all internal links (excluding category links by default).
	// Prettifies the returned array, then stores to cache. Returns the cache filename.
	// doesn't work if $source is a special page. Use HarvestSpecialLinks() instead.
	function wikiHarvestLinks( $source, $stripCats = true ) {
		// if (!$this->wikiConnect())	// uncomment these two lines if logging in is required to READ (not edit) the page you're trying to scrape.
		//	die( "Unable to connect." );
		if ( !$this->fetch( $this->wikiServer . PREFIX . '/index.php?title=' . $source . '&action=raw' ) )
			return false;
		$links = $this->wikiLinks( $this->results, $stripCats );
		if ( !is_array( $links ) )
			die( 'Cannot harvest links from an article that has no links.' );
		foreach ( $links as $key => $link )
			$links[$key] = $link[1]; // remember that we're dealing with the ugly array in wikiLinks(). Let's simplify it a bit.
		$cache = TEMP . 'harvest_' . gmdate( "Ymd_his" ) . '.php';
		$this->UpdateLinksCache( $cache, $links );
		return $cache; // return the file path we used
	}

	// analogous to wikiHarvestLinks, but for special pages. Special pages don't accept the ?action=raw trick we use in wikiHarvestLinks, so we use this method instead.
	// like wikiHarvestLinks, stores the harvested links to cache and returns the cache filename. Doesn't work on all types of special pages (must use <ol class="special">...</ol>)
	function HarvestSpecialLinks( $title ) {
		if ( !$this->fetch( $this->wikiServer . PREFIX . '/index.php?title=' . $title ) )
			return false;
		// we want only the links in here:	<ol start='1' class='special'> ... </ol>
		preg_match( "|<ol[^>]*class=['\"]special['\"][^>]*>(.*)</ol[^>]*>|Usi", $this->results, $specialLinks );
		if ( !is_array( $specialLinks ) )
			return false;
		$specialLinks = $specialLinks[0]; // the whole thing from <ol... to </ol>
		$specialLinks = $this->_striplinks( $specialLinks );
		// Special pages use relative (not absolute) links. E.g. if ALTPREFIX is '/w', then you'll have things like '/w/Article_Title' in the special page's links.
		// we want to reduce that to just the title--i.e. strip off the '/w/' part.
		if ( '' != ALTPREFIX ) { 	$strlen = strlen( ALTPREFIX ) + 1; }  		// the "+1" is for the slash after ALTPREFIX
		else {					$strlen = 1; }						 	// for the slash
		foreach ( $specialLinks as $key => $link )
			$specialLinks[$key] = substr( $link, $strlen );
		// now let's prepare to write the links to a temporary location
		$cache = TEMP . 'harvest_' . gmdate( "Ymd_his" ) . '.php';
		$this->UpdateLinksCache( $cache, $specialLinks );
		return $cache; // we're returning the file path
	}

	// you get the idea by now. Analogous to the last couple. Note that you'll need to edit theme files to use this.
	function HarvestCategoryLinks( $title ) {
		if ( !$this->fetch( $this->wikiServer . PREFIX . '/index.php?title=' . $title  ) )
			return false;
		// you'll need to edit mediawiki/includes/CategoryPage.php and wrap all the category links in <div class="categoryItems"> .... </div> so that we can find them.
		preg_match( "|<div[^>]*class=['\"]categoryItems['\"][^>]*>(.*)</div[^>]*>|Us", $this->results, $catLinks );
		if ( !is_array( $catLinks ) )
			return false;
		$catLinks = $catLinks[0]; // the whole thing from <div... to </div>
		$catLinks = $this->_striplinks( $catLinks );
		// Category pages use relative links. E.g. if ALTPREFIX is '/w', then you'll have things like '/w/Article_Title' in the special page's links.
		// we want to reduce that to just the title--i.e. strip off the '/w/' part.
		if ( '' != ALTPREFIX ) { 	$strlen = strlen( ALTPREFIX ) + 1; }  		// the "+1" is for the slash after ALTPREFIX
		else {					$strlen = 1; }						 	// for the slash
		foreach ( $catLinks as $key => $link )
			$catLinks[$key] = substr( $link, $strlen );
		// now let's prepare to write the links to a temporary location
		$cache = TEMP . 'harvest_' . gmdate( "Ymd_his" ) . '.php';
		$this->UpdateLinksCache( $cache, $catLinks );
		return $cache; // we're returning the file path
	}

	// pass wikiLinks() raw wiki code (not HTML). It will find all the internal links and return them as a big ugly array. See the comments in the function for details.
	// does not work if $title isn't editable (e.g. special pages). Try HarvestSpecialLinks instead.
	// USED BY OTHER BOTS, SO DON'T MODIFY. (e.g. used by RecentChangesBot) (that's a note to myself; you can edit it if you want, of course)
	function wikiLinks( $content, $stripCats = false ) {	// set $stripCats to TRUE if you don't want categories returned.
		// we need to find the following patterns:	[[article title|link text]] 		or 		[[article title]]
		preg_match_all( "~(?<!\[)(?:\[{2})(?!\[)([^|\]]+)\|?([^\]]*)\]{2}(?!])~", $content, $internal, PREG_SET_ORDER );
		/* 	(?<!\[)(?:\[{2})(?!\[)		ensure we have two (and only two) [[ at the beginning
			([^|\]]+)			match anything up until a | or ]. This will grab the title that we're linking to.
			\|?				allows for a | (which separates article title from link text)
			([^\]]*)			match anything other than ] (this is the link text)
			\]{2}(?!])			ensure that we close with two (and only two) ]]

			Suppose the article contains these links: 	blah blah [[Link 1|link text]] blah blah blah [[Link 2]] blah blah
			$internal will look something like this. Note that each array element is a separate link that we found.
			    [0] => Array
			            [0] => [[Link 1|link text]]			the link exactly as it was written in the article
			            [1] => Link 1				the title being linked to
			            [2] => link text				the link text, if any
			    [1] => Array
			            [0] => [[Link 2]]
			            [1] => Link 2
			            [2] => 					this is empty, since link 2 doesn't have link text.
		*/
		if ( ( !is_array( $internal ) ) || ( 0 == count( $internal ) ) )
			return false;
		if ( $stripCats ) {	// strip out all category links. These always start with [[Category: so they are easy to find.
			foreach ( $internal as $key => $link )
				if ( 2 == strpos( $link[0], 'Category:' ) ) { unset( $internal[$key] ); }
			if ( 0 < count( $internal ) )
				$internal = array_values( $internal ); // renumber the keys, just for kicks.
			else
				return false;
		}
		// make sure we replace all spaces with underscores in link targets. (This is something I did for myself to make one of my bots work smoother. You can delete if you want.)
		foreach ( $internal as $key => $link ) {
			$internal[$key][1] = str_replace( ' ', '_', $link[1] ); // don't change, used by recentchangesBot (note to self)
		}
		return $internal; // will be an array with at least one element.
	}

	// if you wish to provide an array of (internal) links rather than harvesting links, send them here. It will cache them and return the cache path.
	// you don't really need to call this, though; it gets called by ArrayFilterAll() automatically.
	function ArrayLinksCache( $links ) {
		if ( !$_GET['cache'] ) { // okay, this is our first load.
			$_GET['cache'] = TEMP . 'linkarray_' . gmdate( "Ymd_his" ) . '.php';
			if ( !is_array( $links ) )
				die ( 'You need to provide a valid link array.' );
			$this->UpdateLinksCache( $_GET['cache'], $links );
		}
		return $_GET['cache'];
	}

	// takes an array full of links and stores them to a flat file cache. Returns TRUE on success, dies on failure.
	function UpdateLinksCache( $cache, $links ) {
		if ( !is_array( $links ) )
			die( 'You are trying to update the links cache, but you passed no links.' );
		$filebody = '<?php $links = array( ';	 // i know, i know, i should have used serialize()
		foreach ( $links as $link )
			$filebody .= "\n\t'" . addslashes( $link ) . "', ";
		$filebody .= '); ?>';
		if ( file_put_contents( $cache, $filebody ) )
			return true;
		die ( 'Unable to write to temporary directory.' );
	}

	// loads up an array of links from a flat file cache created by UpdateLinksCache(). Returns links as an array.
	function LoadLinksCache( $cache ) {
		require_once( $cache );
		$links = stripslashes_array( $links );
		if ( !is_array( $links ) )
			die( 'There should be an array called "links" in the cache, but it is not there.' );
		return $links;
	}

	// a utility function. You probably want SpecialFilterAll, not this.
	// figures out where we should be getting our cached links from. Run this function's return value through $this->LoadLinksCache(), then the links will be returned as an array.
	function SpecialLinksCache( $source ) {
		if ( !$_GET['cache'] )	// the <meta> reload will append ?cache= to the current URL. If it's there, then we know we've already harvested the links. If not, start by harvesting.
			$cache = $this->HarvestSpecialLinks( $source );	// harvest the links from $source and store them to $cache
		else
			$cache = $_GET['cache'];
		if ( $cache )
			return $cache; // returns the filename we should use.
		else
			die( 'Unable to harvest links.' );
	}

	// like SpecialLinksCache(), but for category pages. You'll need to edit includes/CategoryPage.php for this to work. Sorry.
	function CategoryLinksCache( $source ) {
		if ( !$_GET['cache'] )
			$cache = $this->HarvestCategoryLinks( $source );
		else
			$cache = $_GET['cache'];
		if ( $cache )
			return $cache; // returns the filename we should use.
		else
			die( 'Unable to harvest links.' );
	}

	// returns TRUE if $filename exists, FALSE if it doesn't and we successfully create it, DIES if we false and we cannot create it.
	function RecentChangesData( $filename, $force = false ) {
		if ( !$force && file_exists( $filename ) )
			return true;
		$cacheTime = gmdate( "YmdHis" ); // e.g. 20070801231902 for Aug 1, 2007, 23:19:02 (GMT)
		$cache = TEMP . 'harvest_' . gmdate( "Ymd_His" ) . '.php'; // where we'll store harvested links
		$filebody = '<?php $cacheTime = "' . $cacheTime . '";' . "\n" . '$cache = "' . $cache . '"; ?>';
		if ( file_put_contents( $filename, $filebody ) )
			return false;
		die ( 'Unable to store Recent Changes data' );
	}

	function HarvestRecentChanges( $from, $cache, $ns = false ) {
		$title = 'Special:Recentchanges&from=' . $from . '&hidemyself=1&hidepatrolled=0&limit=5000';
		if ( false !== $ns ) // use FALSE with ===, since $ns might be 0 (for main namespace)
			$title .= '&namespace=' . $ns;
		if ( !$this->fetch( $this->wikiServer . PREFIX . '/index.php?title=' . $title ) )
			return false;
		// we want only the links enclosed in one of the '<ul class="special"' tags. The <ul> starts over for each date displayed in recent changes
		preg_match_all( "~<ul[^>]*class=['\"][^'\"]*special[^'\"]*['\"][^>]*>(.*)</ul[^>]*>~Usi", $this->results, $linklist );
		/* gives us something like this:
			[0]
				[0] most recent day's recent changes (as an HTML list wrapped in the <ul class="special">...</ul> tags used in the preg_match_all)
				[1] previous day's recent changes
				[2] etc
			[1]	same thing as [0], but now each element lacks the <ul class="special">wrap</ul>
		*/
		if ( !is_array( $linklist[1] ) )
			return false;
		if ( 1 == count( $linklist[1] ) ) // we have only 1 day's data
			$links = $linklist[1][0]; // convert to string.
		else
			foreach ( $linklist[1] as $day ) { $links .= $day; } // convert to a string. We use $linklist[1] b/c we don't want the <ul> wrappers.
		unset( $linklist ); // done with it.
		// now the trick is extracting all the article titles from $links. Each entry in recent changes has several links: Diff, Hist, article, User, User talk.
		// Perhaps the easiest place to get the page title is from each entry's "history" link.
		preg_match_all( '~<a href="' . PREFIX . '/index\.php\?title=([^&"]*)[^"]*action=history[^>]*>~', $links, $links );
		/*	About the regex:
				([^&"]*)	// ensures we grab only the title, not additional URL parameters (like &curid=
				[^"]*		// here we allow for additional parameters between the title and the "action=history" bit.
			gives us something like this:
			[0]
				[1]  <a href="/wiki/index.php?title=Fowler:_Habitual_voting&amp;curid=2010&amp;action=history" title="Fowler: Habitual voting">hist</a>
				[2] additional links
			[1]
				[1] Fowler:_Habitual_voting
				[2] additional titles
		*/
		if ( !is_array( $links[1] ) )
			return false;
		if ( 0 == count( $links[1] ) )
			die ( 'I tried to harvest links from "Recent Changes," but it looks like nothing has been changed since last I checked.' );
		$links = array_unique( $links[1] ); // we want only the titles, not the links. And we don't want duplicates.
		$links = array_reverse( $links ); // now the most recently changed article is at the end of the array. We want to process from oldest to newest.
		// if there are pages that you never want "recent changes" bots to fiddle with, add them to this array:
		$hands_off = array( 'Main_Page' );
		$links = array_diff( $links, $hands_off );
		if ( 0 == count( $links ) )
			die ( 'I tried to harvest links from "Recent Changes," but it looks like nothing has been changed since last I checked.' );
		// alright, we've got our links array. Let's write it to $cache.
		$this->UpdateLinksCache( $cache, $links );
		return $cache;
	}
}
///////////////////// / END OF THE CLASS ////////////////////////




// a couple utility functions to make life easier.
function print_debug( $v ) {
	echo '<pre>';
	if ( is_array( $v ) )
		print_r( $v );
	elseif ( is_string( $v ) )
		print htmlspecialchars( $v );
	else
		var_dump( $v );
	echo '</pre>';
}
function inString( $haystack, $needle, $insensitive = false ) { // php should really have a function like this built in...
	if ( $insensitive ) { // case-insensitive check
		if ( false !== stripos( $haystack, $needle ) )
			return true;
	} else {
		if ( false !== strpos( $haystack, $needle ) )
			return true;
	}
	return false;
}
function stripslashes_array( $arr ) {
	if ( !is_array( $arr ) )
		die ( 'You think you passed stripslashes_array an array, but you did not.' );
	$out = array();
	foreach ( $arr as $key => $el ) // guess I could have just used array_map() instead...
		$out[$key] = stripslashes( $el );
	return $out;
}
// Checks for wikification. Looks only for basic formatting: Headings, bold, italics, and links (if requested). TRUE if found, FALSE otherwise.
function isWikified( $content, $checkLinks = false ) {
	if ( preg_match( "|\n==([^=]+)==|U", $content ) )
		return true;
	if ( preg_match( "|\n===([^=]+)===|U", $content ) )
		return true;
	if ( preg_match( "|''([^']+)''|U", $content ) ) // will find both bold and italic
		return true;
	// some articles will contain links but no other formatting. We check for links as evidence of wikfication only if requested.
	if ( $checkLinks ) {	// THESE TWO REGULAR EXPRESSIONS ARE NOT TESTED YET
		if ( preg_match( "|\[{2}([^\[\]]+)\]{2}|", $content ) ) // internal links
			return true;
		if ( preg_match( "|\[http://([^\[\]]+)\]|", $content ) ) // external links
			return true;
	}
	return false;
}
function checkBadWords( $content, $badwords = false ) { // returns TRUE if we detect bad words, FALSE otherwise.
	// if $content contains ANY of the strings in $bad, we return true. Searching is case-insensitive. Note that partial strings will also match.
	// if you put "hell" in your bad list, "Michelle" will set it off. To avoid this, use spaces around the word: " hell "
	// $bad can be overridden by $badwords.
	$bad = array( ' fuck ', ' shit ', ' pussy ', ' bitch ', ' asshole ', ' fucker ' );
	$bad = $badwords ? $badwords : $bad;
	foreach ( $bad as $b ) {
		if ( inString( $content, $b, true ) )
			return true;
	}
	return false;
}




/**************************
SAMPLE CALLBACK FUNCTIONS
**************************/
/*	callback "addTemplate" receives $content from wikiFilter(). You can set the following parameters by passing an array to $args:
*	$args['template'] = '{{name of template}}';	// actually, the value can be anything you want to insert, like a category or something. It doesn't have to be a template. Templates need {{braces}}.
*	$args['toBottom'] = true;		// if TRUE, the template will be inserted at the end. Otherwise, will be inserted at the beginning. 		*/
function addTemplate( $content, $args ) {
	if ( !is_array( $args ) )
		return $content; // do nothing.
	extract( $args ); // $args should be an array( 'template' => '{{name of template}}' )
	if ( '' == $template )
		die ( 'You didn\'t pass enough arguments to "addTemplate()"' );
	if ( inString( $content, $template ) ) // don't add the template twice
		return $content;
	if ( $toBottom )
		$content .= "\n\n" . $template; // template at bottom of page
	else
		$content = $template . "\n\n" . $content; // template at top of page
	return $content;
}
/* 	callback addCategory is almost identical to addTemplate. Pass it an array with this arg:
	$args['cat'] = 'Category_Name';	// you don't need to put brackets around the category name. And don't precede it with "Category:" either. Just the name, please.		*/
function addCategory( $content, $args ) {
	if ( !is_array( $args ) )
		return $content; // do nothing
	extract( $args );
	if ( '' == $cat )
		die( "You didn't pass valid parameters to 'addCategory()'" );
	$cat = '[[Category:' . $cat . ']]';
	if ( inString( $content, $cat ) )	// don't add the category twice
		return $content;
	$content = trim( $content );
	if ( '' == $content ) // this probably means that we're adding a category to a category page without any text at the top
		$content = $cat;
	elseif ( inString( $content, '[[Category:' ) )
		$content .= " $cat"; // if there are already cats, they're probably at the end. Let's just tack one on.
	else
		$content .= "\n\n$cat"; // if there aren't already cats, let's be neat and put this on a new line at the end.
	return $content;
}






############################################################ #
#################### # DEMOS #################################
############################################################ #

// A sample callback for use with wikiFilter() (see also the sample callbacks above). This is completely useless other than to demonstrate adding and removing categories.
// It will toggle whether a page has the "robots" category:
function dumbFilter( $content ) {
	if ( inString( $content, '[[Category:Robots]]' ) )		// if the article already has the category...
		$content = str_replace( '[[Category:Robots]]', '', $content ); // remove it.
	else 				// otherwise...
		$content .= ' [[Category:Robots]]';	// add it.
	return $content;	// CRUCIAL. Return the edited content back to wikiFilter().
}

// another sample filter. This one adds any text we specify to the end of the summary.
// $params needs to be passed as an array that looks like this:		array( 'newtext' => 'Add me to the end of the article.' );
function dumbFilter2( $content, $params ) {
	extract( $params ); // produces $newtext
	$content .= $newtext;	// add $newtext to the end of the article
	return $content;		// CRUCIAL. Return the edited content back to wikiFilter().
}

########################################################### #
########################################################### #
/* 	SAMPLE USAGE

	Initiate our class:
		$myBot = new BasicBot();

	DEMO 1: Filtering a single article using a callback that takes no additional parameters:
		Run the content of 'Project:Sandbox' through function dumbFilter(). Leave edit summary 'Testing a bot.'
			$myBot->wikiFilter( 'Project:Sandbox', 'dumbFilter', 'Testing a bot.' );

	DEMO 2: Filtering a single article using a callback that does take additional parameters (must pass params as an array):
		Run the content of 'Project:Sandbox' through function dumbFilter2(). Send parameter $newtext="Wuzzup?". Leave edit summary 'Testing another bot.'
			$myBot->wikiFilter( 'Project:Sandbox', 'dumbFilter2', 'Testing another bot.', array('newtext'=>'Wuzzup?') );

	DEMO 3: Applying a filter to a whole bunch of articles is just as easy.
		Run the content of all articles linked to by 'Project:Sandbox' through dumbFilter(), leaving edit summary 'Testing a bot on lots of pages' on each affected article:
			$myBot->wikiFilterAll( 'Project:Sandbox', 'dumbFilter', 'Testing a bot on lots of pages' );

	DEMO 4: It's just as easy if we're using a callback that accepts parameters. Let's repeat the preceding example, but now we'll use dumbFilter2 and pass $newtext='Wuzzup?'
		$myBot->wikiFilterAll( 'Project:Sandbox', 'dumbFilter2', 'Testing a bot on lots of pages', array('newtext'=>'Wuzzup?') );

	And that's that.

	Note that wikiFilter() and wikiFilterAll() take a couple additional arguments if you want. Look at the function definitions and you can figure it out.
	Also note that you don't have to scrape 'Project:Sandbox' for links. Look in the class for SpecialFilterAll() and ArrayFilterAll().
*/
########################################################### #
########################################################### #
?>
