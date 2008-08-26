<?php
/* Cache404.php -- an extension for doing 404-handler caching
 * Copyright 2004 Evan Prodromou <evan@wikitravel.org>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @addtogroup Extensions
 */

/* arch-tag: MediaWiki extension file for 404-handler caching */

if (defined('MEDIAWIKI')) {

	require_once("SpecialPage.php");
	require_once("WebRequest.php");
	require_once("User.php");
	require_once("SpecialUserlogin.php");
	require_once("Skin.php");
	require_once("skins/MonoBook.php");
	require_once("SkinPHPTal.php");
	require_once("DatabaseFunctions.php");

	define("CACHE404_VERSION", "0.6");

	/*
	 * Note that these aren't really necessary for 404 caching. They
	 * just make it easier to do skins that don't have dynamic
	 * content in them.
	 */

	function wfSpecialMypage( $par ) {
		global $wgOut, $wgUser;

		if ($wgUser->getID() == 0) {
			$title = Title::makeTitle(NS_SPECIAL, "Userlogin");
		} else {
			$title = Title::makeTitle(NS_USER, $wgUser->getName());
		}
		$wgOut->redirect($title->getFullURL());
	}

	function wfSpecialMytalkpage( $par ) {
		global $wgOut, $wgUser;

		$title = Title::makeTitle(NS_USER_TALK, $wgUser->getName());
		$wgOut->redirect($title->getFullURL());
	}

	function wfSpecialUserloginout( $par ) {
		global $wgOut, $wgUser;

		if ($wgUser->getID() == 0) {
			$title = Title::makeTitle(NS_SPECIAL, "Userlogin");
		} else {
			$title = Title::makeTitle(NS_SPECIAL, "Userlogout");
		}
		$wgOut->redirect($title->getFullURL());
	}

	function wfSpecialMycontributions( $par ) {
		global $wgOut, $wgUser;

		$title = Title::makeTitle(NS_SPECIAL, "Contributions");
		$wgOut->redirect($title->getFullURL('target=' . $wgUser->getName()));
	}

	function wfSpecialWatchUnwatch( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		if ($wgUser->getID() == 0) { # not logged in
			$wgOut->errorpage('watchnologin', 'watchnologintext');
			return false;
		}
		
		$title = $wgRequest->getText('target');
		
		if (strlen($title) == 0) {
			$wgOut->errorpage('notargettitle', 'notargettext');
			return false;
		}
		
		$nt = Title::newFromText($title);
		
		if ($nt->getArticleID() == 0) {
			$wgOut->errorpage('badtitle', 'badtitletext');
			return false;
		}
		
		$action = ($wgUser->isWatched($nt)) ? 'unwatch' : 'watch';

		$wgOut->setPageTitle(wfMsg($action));
		
		$wgOut->addHTML('<p>' . wfMsg($action.'confirm', $nt->getPrefixedText()), '</p>');
		$url = $nt->getLocalUrl();		
		$acturl = $nt->getLocalUrl('action=' . $action);
		$wgOut->addHTML("<form action='javascript:void(0)'>");
		$wgOut->addHTML("<button type='button' "  .
						"onclick='document.location.href=\"$acturl\"; void(0)'" .
						"name='ok'>" . wfMsg('ok') . '</button>');
		$wgOut->addHTML("<button type='button' " .
						"onclick='document.location.href=\"$url\"; void(0)'" .
						"name='cancel'>" . wfMsg('cancel') . '</button>');
		$wgOut->addHTML("</form>");
	}
	
	# We have to override login, since it makes its own user. Yeah, I know.

	class LoginFormInterceptor extends LoginForm {

		function LoginFormInterceptor( &$request ) {
			parent::LoginForm($request);
		}

		function addNewAccountInternal() {
			$u = parent::addNewAccountInternal();
			if ($u) {
				return new UserInterceptor($u);
			} else {
				return $u;
			}
		}

		function processLogin() {
			global $wgUser;
			$retval = parent::processLogin();
			if ($wgUser) {
				$wgUser = new UserInterceptor($wgUser);
			}
			return $retval;
		}
	}

	# We make sure cookies get cleared

	function clearCookie($name) {
		global $wgCookieDomain, $wgCookiePath;
		setcookie($name, "", NULL, $wgCookiePath, $wgCookieDomain);
	}
	
	function wfSpecialUserlogout2( $par ) {
		global $wgDBname;

		wfSpecialUserlogout($par);

		clearCookie("{$wgDBname}UserName");
		clearCookie("{$wgDBname}UserID");
		clearCookie("{$wgDBname}Password");
	}

	function wfSpecialUserlogin2( $par ) {
		global $wgCommandLineMode;
		global $wgRequest;
		if( !$wgCommandLineMode && !isset( $_COOKIE[ini_get("session.name")] )  ) {
			User::SetupSession();
		}

		$form = new LoginFormInterceptor( $wgRequest );
		$form->execute();
	}

	# FIXME: localize

	function ensureCacheDirectory($cachedir) {

		if (!file_exists($cachedir)) {
			wfDebugDieBacktrace("Cache directory '$cachedir' does not exist!");
		}

		if (!is_dir($cachedir)) {
			wfDebugDieBacktrace("Cache directory '$cachedir' does not exist!");
		}

		if (!is_writeable($cachedir)) {
			wfDebugDieBacktrace("Cache directory '$cachedir' is not writeable!");
		}
	}

	function getCache404DirInfo($dir) {
		$files = array();
		$dh = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			# skip hidden files
			if ($filename[0] == '.') {
				continue;
			}
			$fullname = $dir . '/' . $filename;
			if (is_dir($fullname)) {
				$files = array_merge($files, getCache404DirInfo($fullname));
			} else {
				$files[] = array(fileatime($fullname), filesize($fullname), $fullname);
			}
		}
		closedir($dh);
		return $files;
	}

	function makeRoomForCount($dir, &$files, $preferred_count) {
		$actual = count($files);
		if ($actual > $preferred_count) {
			sort($files); # puts lowest (= least recent) atime at beginning
			# take enough off the front to make a small-enough cache
			$to_delete = array_slice($files, 0, $actual - $preferred_count);
			foreach ($to_delete as $item) {
				$fullname = $item[2];
				$atime = date("r", $item[0]);
				if (file_exists($fullname)) {
					unlink($fullname);
					wfDebug("Cache404: removed old file '$fullname' ($atime).\n");
				}
			}
			$files = array_slice($files, $actual - $preferred_count);
		}
	}

	function makeRoomForSize($dir, &$files, $preferred_size) {
		$total_size = array_reduce($files, 'sizeSum');
		sort($files); # sort by LRU
		while ($total_size > $preferred_size and count($files) > 0) {
			$item = array_shift($files);
			$atime = date("r", $item[0]);
			$fsize = $item[1];
			$fullname = $item[2];
			if (file_exists($fullname)) {
				unlink($fullname, $dir);
				wfDebug("Cache404: removed old file '$fullname' for size ($fsize) ($atime).\n");
			}
			$total_size -= $fsize;
		}
	}

	function sizeSum($total, $item) {
		$total += $item[1];
		return $total;
	}

	# Make enough room in $dir for a new file of size $file_size.

	function makeRoomForFile($dir, $file_size) {

		global $wgCache404MaxCount, $wgCache404MaxSize;

		if ((isset($wgCache404MaxCount) and $wgCache404MaxCount > 0) or
			(isset($wgCache404MaxSize) and $wgCache404MaxSize > 0))
		{
			$files = getCache404DirInfo($dir);

			if (isset($wgCache404MaxCount) and $wgCache404MaxCount > 0) {
				makeRoomForCount($dir, $files, $wgCache404MaxCount - 1);
			}

			if (isset($wgCache404MaxSize) and $wgCache404MaxSize > 0) {
				makeRoomForSize($dir, $files, $wgCache404MaxSize - $file_size);
			}
		}
	}

	# write content out to the cache

	function dumpToCache($buffer) {

		global $wgCacheDirectory, $wgTitle, $wgArticle;

		wfDebug("Cache404: output finished; dumping to cache.\n");

		if ($wgTitle->getNamespace() == NS_SPECIAL) {
			wfDebug("Cache404: skipping Special: page.\n");
		} else if (empty($buffer)) {
			wfDebug("Cache404: null output; skipping.\n");
		} else {
			if (!empty($wgArticle->mRedirectedFrom)) {
				$thisTitle = Title::newFromText($wgArticle->mRedirectedFrom);
			} else {
				$thisTitle = $wgTitle;
			}
			if ($wgTitle->getArticleId() == 0) {
				wfDebug("Cache404: not saving non-article title.\n");
			} else if (strchr($wgTitle->getDBkey(), "/")) {
				wfDebug("Cache404: skipping sub-pages; they just cause problems.\n");
			} else {
				wfDebug("Cache404: ensuring cache directory.\n");
				ensureCacheDirectory($wgCacheDirectory);
				wfDebug("Cache404: determining filename.\n");
				$fname = titleToFname($thisTitle);
				wfDebug("Cache404: saving to file $fname.\n");
				$size = strlen($buffer);
				wfDebug("Cache404: shuffling files to accommodate $size bytes.\n");
				makeRoomForFile($wgCacheDirectory, $size);				
				$fullname = $wgCacheDirectory . "/" . $fname;
				wfDebug("Cache404: Full filename is $fullname.\n");				
				if (file_exists($fullname)) {
					wfDebug("Cache404: Deleting $fullname (it already exists).\n");									
					unlink($fullname);
				}
				wfDebug("Cache404: Opening $fullname.\n");													
				$fp = fopen($fullname, "w");
				wfDebug("Cache404: Writing $fullname.\n");																	
				$len = fwrite($fp, $buffer);
				wfDebug("Cache404: Closing $fullname.\n");																					
				fclose($fp);
				wfDebug("Cache404: Setting flags for $fullname to 0666.\n");																					
				chmod($fullname, 0666);
				wfDebug("Cache404: Checking timestamp for article.\n");
				$adate = wfTimestamp(TS_UNIX, $wgArticle->getTimestamp());
				wfDebug("Cache404: Setting $fullname touch date to $adate.\n");				
				touch($fullname, $adate);
				wfDebug("Cache404: dumped $len characters to file '$fullname'.\n");
			}
		}

		return $buffer;
	}

	function titleToFname($title) {
		return strtr($title->getPrefixedDBkey(), "/", "|") . ".html";
	}

	function cacheUrlToTitle($url) {
		global $wgCachePath;
		$base = substr(urldecode($url), strlen($wgCachePath) + 1);
		$fixup = str_replace(".html", "", $base);
		$final = strtr($fixup, "|", "/");
		return $final;
	}

	function getRedirectsTo($title) {
		$redirects = array();
		$sql =
		  "SELECT cur_namespace, cur_title " .
		  "FROM links, cur " .
		  "WHERE l_to=" . $title->getArticleID() . " " .
		  "AND l_from = cur_id " .
		  "AND cur_is_redirect <> 0";
		$res = wfQuery( $sql, DB_READ, 'getRedirectsTo' );
		while ( $row = wfFetchObject( $res ) ) {
			$redirects[] = Title::makeTitle( $row->cur_namespace, $row->cur_title );
		}
		wfFreeResult( $res );
		return $redirects;
	}

	function getTemplatesTo($title) {
		$templates = array();
		$sql =
		  "SELECT cur_namespace, cur_title " .
		  "FROM links, cur " .
		  "WHERE l_to=" . $title->getArticleID() . " " .
		  "AND l_from = cur_id " .
		  "AND (cur_text LIKE '%{{" . $title->getDBkey() . "}}%' OR " .
		  "cur_text LIKE '%{{" . $title->getDBkey() . "|%' OR " .
		  "cur_text LIKE '%{{" . $title->getText() . "}}%' OR " .
		  "cur_text LIKE '%{{" . $title->getText() . "|%')";

		$res = wfQuery( $sql, DB_READ, 'getTemplatesTo' );
		while ( $row = wfFetchObject( $res ) ) {
			$templates[] = Title::makeTitle( $row->cur_namespace, $row->cur_title );
		}
		wfFreeResult( $res );
		return $templates;
	}

	function getTalkPartner($title) {
		if (Namespace::isTalk($title->getNamespace())) {
			return $title->getSubjectPage();
		} else {
			return $title->getTalkPage();
		}
	}

	function invalidateCache($title, $action='edit') {

		invalidateCacheFile($title);

		$others = array();
		switch ($action) {
		 case 'new':
			$others = $title->getBrokenLinksTo();
			array_push($others, getTalkPartner($title));
			break;
		 case 'delete':
			$others = $title->getLinksTo();
			array_push($others, getTalkPartner($title));
		 case 'edit':
		 case 'dependency':
			$others = getRedirectsTo($title);
			if ($title->getNamespace() == NS_TEMPLATE)
			  $others = array_merge($others, getTemplatesTo($title));
			break;
		 default:
			wfDebugDieBacktrace("invalidateCache() called with unexpected action '$action'.\n");
		}

		foreach ($others as $other) {
			invalidateCache($other, 'dependency');
		}
	}

	function invalidateCacheFile($title) {
		global $wgCacheDirectory;

		ensureCacheDirectory($wgCacheDirectory);
		$fname = titleToFname($title);
		$fullname = $wgCacheDirectory . "/" . $fname;
		if (file_exists($fullname)) {
			unlink($fullname);
			wfDebug("Cache404: invalidated file '$fullname'.\n");
		}
	}

	# Yeah, it's cheating. So what? You should see me play Monopoly.

	class WebRequestInterceptor extends WebRequest {

		var $mTitle;

		function WebRequestInterceptor($title) {
			$this->mTitle = $title;
		}

		function getVal($name, $default = NULL) {
			if ($name == 'title') {
				return $this->mTitle;
			} else {
				return parent::getVal($name, $default);
			}
		}
	}

	# It can't be wrong when it feels so right.

	class UserInterceptor extends User {

		function UserInterceptor($user) {
			$this->loadDefaults();
			if ($user) {
				$this->mId = $user->getID();
				$this->mName = $user->getName();
				$this->mEmail = $user->getEmail();
				$this->mRealName = $user->getRealName();
				$this->mNewtalk = $user->getNewtalk();
				$this->mRights = $user->getRights();
				$this->mBlockedby = $user->blockedBy();
				$this->mBlockreason = $user->blockedFor();
				# Internal state -- no accessors.
				$this->mCookiePassword = $user->mCookiePassword;
				$this->mPassword = $user->mPassword;
				$this->mOptions = array();
				foreach ($user->mOptions as $k => $v) {
					$this->mOptions[$k] = $v;
				}
				$this->mDataLoaded = $user->mDataLoaded;
				$this->mNewpassword = $user->mNewpassword;
				$this->mTouched = $user->mTouched;
			}
		}

		# We don't want new talk messages showing up on static pages

		function getNewtalk() {
			return false;
		}

		# We want everyone to have the same display options

		function getOption($oname) {
			global $wgLang;
			# XXX: be more discriminating on what opts we filter out.
			$defaults = $wgLang->getDefaultUserOptions();
			if (array_key_exists($oname, $defaults)) {
				return $defaults[$oname];
			} else {
				$this->loadFromDatabase();
				return parent::getOption($oname);
			}
		}

		function &getSkin() {
			if (!$this->mSkin) {

				$wrapped = parent::getSkin();
				$this->mSkin = new Skinterceptor($wrapped);
			}
			return $this->mSkin;
		}
	}

	# For changing some of the Skin behavior

	class Skinterceptor extends SkinMonoBook {

		var $_skin; # trapped!

		function Skinterceptor($skin) {
			$this->_skin = $skin;
			$this->lastdate = $skin->lastdate;
			$this->lastline = $skin->lastline;
			$this->linktrail = $skin->linktrail;
			$this->rc_cache = $skin->rc_cache;
			$this->rcCacheIndex = $skin->rcCacheIndex;
			$this->rcMoveIndex = $skin->rcMoveIndex;
			$this->skinname = $skin->skinname;
			$this->template = $skin->template;
			$this->mOptions = $skin->mOptions;
		}

		function initPage( &$out ) {
			$skin = $this->_skin;
			$skin->initPage($out);
			$this->skinname = $skin->skinname;
			$this->template = $skin->template;
			$this->stylename = $skin->stylename;
		}

		# build array of urls for personal toolbar
		function buildPersonalUrls() {
			$urls =
			  array('userpage' =>
					array('text' => wfMsg('mypage'),
						  'href' => $this->makeSpecialUrl('Mypage')),
					'mytalk' =>
					array('text' => wfMsg('mytalk'),
						  'href' => $this->makeSpecialUrl('Mytalkpage')),
					'preferences' =>
					array('text' => wfMsg('preferences'),
						  'href' => $this->makeSpecialUrl('Preferences')),
					'watchlist' =>
					array('text' => wfMsg('watchlist'),
						  'href' => $this->makeSpecialUrl('Watchlist')),
					'mycontris' =>
					array('text' => wfMsg('mycontris'),
						  'href' => $this->makeSpecialUrl('Mycontributions')),
					'logout' =>
					array('text' => wfMsg('userlogin'),
						  'href' => $this->makeSpecialUrl('Userloginout')));
			return $urls;
		}

		function buildContentActionUrls () {
			$content_actions = parent::buildContentActionUrls();
			$nocache_actions = array(	'watch', 'unwatch', 'move', 
										'delete', 'protect', 'unprotect' );
			foreach ($nocache_actions as $action) {
				unset( $content_actions[$action] );
			}
			return $content_actions;
		}

		# mostly from SpecialListadmins.php and QueryPage.php

		function getAdminIds() {
			$admins = '';
			$dbr =& wfGetDB( DB_SLAVE );
			$user_rights = $dbr->tableName( 'user_rights' );
			$userspace = Namespace::getUser();
			$sql = "SELECT ur_user " .
				   "FROM {$user_rights} " .
				   "WHERE ur_rights LIKE '%sysop%' ";
		    $res = $dbr->query( $sql );
			$comma = '';
			while ( $res && $row = $dbr->fetchObject( $res ) ) {
				$admins .= $comma . $row->ur_user;
				$comma = ',';
			}
			return $admins;
		}

		function messageMap() {
			static $actions = array('watch', 'move', 'delete', 'protect', 'unprotect');
			$messages = array();
			foreach ($actions as $action) {
				$messages[] = '"' . $action . '" : "' . wfMsg($action) . '"';
			}
			
			return "{ " . implode(", ", $messages) . " }";
		}
		
		function setupUserJs() {
			global $wgStylePath, $wgDBname, $wgLang, $wgTitle, $wgScript;
			$userns = $wgLang->getNsText(NS_USER);
			$usertalkns = $wgLang->getNsText(NS_USER_TALK);
			$specialns = $wgLang->getNsText(NS_SPECIAL);
			$logout = wfMsg('logout');
			$this->userjs = "$wgStylePath/common/username.js";
			$admins = $this->getAdminIds();
			$title = $wgTitle->getPrefixedDBkey();
			$map = $this->messageMap();
			$protected = $wgTitle->isProtected() ? 'true' : 'false';
			$build_urls = ($wgTitle->getNamespace() == NS_SPECIAL)
					? '' : "build_content_action_urls();";
			$this->userjsprev = 
"
function cache404_hook() {
    set_page_title('$title');
    set_script_path('$wgScript');
    set_db_name('$wgDBname');
    set_admins('$admins');
    set_specialns('$specialns');
	set_message_map($map);
    set_protected($protected); // it's a bool, so no quotes
    setup_user_name('$userns', '$usertalkns', '$logout');
    $build_urls
}
if (typeof window.addEventListener != \"undefined\") {
  window.addEventListener('load',cache404_hook,false);
}
else if (typeof window.attachEvent != \"undefined\") {
	window.attachEvent('onload',cache404_hook);
} else {
	window.onload = cache404_hook;
}
";
		}
	}

	function addSpecial($name) {
		SpecialPage::AddPage(new SpecialPage($name, "", false, 'wfSpecial' . $name, false));
	}

	function setupCache404Always() {

		global $wgUsePathInfo, $wgFilterCallback, $wgRequest, $wgUser, $wgOut, $_SERVER;
		global $wgAllowUserJs, $wgAllowUserCss, $wgUseSiteCss, $wgUseSiteJs, $wgCachePages;
		global $wgCache404SavedCallback;
		global $wgLang, $wgLanguageCode, $wgContLang, $wgContLanguageCode, $wgMessageCache, 
		       $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry, $wgDBname;

		# Prevent user options, user new talk

		$wgUser = new UserInterceptor($wgUser);

		# Reset parser options (they're set before extensions setup is called

		$wgOut->setParserOptions( ParserOptions::newFromUser( $wgUser ) );
		$wgOut->enableClientCache( false );
		
		# Just to make sure, we turn these off.

		$wgUsePathInfo = false;
		$wgAllowUserJs = false;
		$wgAllowUserCss = false;
		$wgUseSiteCss = false;
		$wgUseSiteJs = false;
		$wgCachePages = false;

		# This is assigned before we get a chance to intercept, so fix it now.

		$wgLang = $wgContLang;
		$wgLanguageCode = $wgContLanguageCode;
		
		# Special pages for static output

		addSpecial("Mypage");
		addSpecial("Mytalkpage");
		addSpecial("Userloginout");
		addSpecial("Mycontributions");
		addSpecial("Watchunwatch");
		
		# We hijack User login, so our preference-less user class gets used

		SpecialPage::AddPage(new SpecialPage("Userlogin", "", true, 'wfSpecialUserlogin2'));
		SpecialPage::AddPage(new SpecialPage("Userlogout", "", true, 'wfSpecialUserlogout2'));
	}

	function getRedirectUrl($s) {
		global $wgCachePath;
		$fields = array('REDIRECT_URL', 'REDIRECT_SCRIPT_URL', 'REQUEST_URI');
		foreach ($fields as $f) {
			if (array_key_exists($f, $s) &&
				strstr($s[$f], $wgCachePath) &&
				!strstr($s[$f], 'index.php')) {
				return $s[$f];
			}
		}
		return NULL;
	}

	function setupCache404() {

		global $wgRequest, $_SERVER;

		wfDebug("Cache404: setup called.\n");

		# do universal hooks and crooks

		setupCache404Always();

		if ($_SERVER['REDIRECT_STATUS'] == 404) {
			# Ev-ry-thing is sa-tis-fac-tual
			header("HTTP/1.0 200 OK");
			$url = getRedirectUrl($_SERVER);
			if ($url) {
				$title_text = cacheUrlToTitle($url);
				$_GET['title'] = $title_text;
				# Yes, it's really evil. Give me another idea, here, for setting the title.
				$wgRequest = new WebRequestInterceptor($title_text);
				wfDebug("Cache404: It's a 404 redirect; extracted title '$title_text' from url '$url'.\n");
			} else {
				wfDebug("Cache404: Couldn't get url from headers; weird Apache/PHP combo?\n");
			}
		}

		$action = $wgRequest->getText('action', 'view');

		switch ($action) {
		 case 'submit':
			$title_text = $wgRequest->getText('title', wfMsg('mainpage'));
			$title = Title::newFromText($title_text);
			if ($title->getNamespace() == NS_SPECIAL) {
				if ($title->getDBkey() == 'Movepage') {
					invalidateCache(Title::newFromText($wgRequest->getVal('wpOldTitle')), 'edit');
					invalidateCache(Title::newFromText($wgRequest->getVal('wpNewTitle')), 'edit');
				}
			} else {
				invalidateCache($title, $title->getArticleID() == 0 ? 'new' : 'edit');
				wfDebug("Cache404: submit command; invalidating cache.\n");				
			}
			break;
		 case 'view':
			$redirect = $wgRequest->getText('redirect', 'yes');
			$oldid = $wgRequest->getVal('oldid');
			$diff = $wgRequest->getVal('diff');
			if ($redirect != 'no' && !isset($oldid) && !isset($diff)) {
				ob_start('dumpToCache');
				wfDebug("Cache404: view command; starting output buffer.\n");
			}
			break;
		 case 'delete':
			invalidateCache(Title::newFromText($wgRequest->getVal('title')), 'delete');
			wfDebug("Cache404: delete command; invalidating cache.\n");
			break;
		 case 'rollback':
			invalidateCache(Title::newFromText($wgRequest->getVal('title')), 'edit');
			wfDebug("Cache404: rollback command; invalidating cache.\n");
			break;
		}
	}
	
	$wgExtensionFunctions[] = 'setupCache404';
	
	$wgExtensionCredits['other'][] = array(
		'name' => 'Cache404',
		'author' => 'Evan Prodromou',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Cache404',
		'description' => 'An extension for doing 404-handler caching',
		'version' => CACHE404_VERSION
	);
}