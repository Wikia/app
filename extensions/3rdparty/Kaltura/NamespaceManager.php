<?php
/*
This file is part of the Kaltura Collaborative Media Suite which allows users 
to do with audio, video, and animation what Wiki platfroms allow them to do with 
text.

Copyright (C) 2006-2008  Kaltura Inc.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


 /*
*/

$wgExtensionCredits[NamespaceManagers::thisType][] = array(
        'name'                 => NamespaceManagers::thisName, 
        'version'              => NamespaceManagers::getRevisionId( '$Id: NamespaceManager.php 705 2007-08-20 15:16:39Z jeanlou.dupont $'),
        'author'               => 'Jean-Lou Dupont', 
        'description'  =>  'Provides a base class for namespace manager extensions. ',
        'url'                  => NamespaceManagers::getFullUrl(__FILE__),                      
);

require_once($IP.'/includes/Article.php');

/**
 All namespace managers should derive from this class.
 */
abstract class NamespaceManager extends Article
{
	static $hookList = array();

	// the namespace index in which the derived
	// class operates ... shortcut for convenience.
	var $ns;

	public function __construct( &$title , $oldId = null)
	{
		$this->setupHooks();
		parent::__construct( $title );
	}
	/**
	 Automatically sets up the declared hooks.
	 */
	protected function setupHooks()
	{
		global $wgHooks;

		foreach ( self::$hookList as $index => $hookName)
		{
			if ( method_exists( $this, 'h'.$hookName ) )
			{
				$wgHooks[$hookName][] = array( &$this, 'h'.$hookName );
			}
		}

	}
	/**
	 The view method will most probably need to be overriden
	 Handler for the default action i.e. 'action=view'
	 */
	public function view()
	{
		//echo __METHOD__.": must override this method.";
		return parent::view();
	}
	/**
	 Handler for 'action=submit'
	 */
	public function submit()
	{
//		echo __METHOD__.": must override this method.";
//		return parent::submit();
		return true;
	}
	/**
	 Handler for 'action=edit'
	 */
	public function edit()
	{
		//return parent::edit();
	}
	public function delete()
	{
		return parent::delete();
	}
	public function watch()
	{
		return parent::watch();
	}
	public function unwatch()
	{
		return parent::unwatch();
	}
	public function protect()
	{
		return parent::protect();
	}
	public function unprotect()
	{
		return parent::unprotect();
	}
	public function revert()
	{ 
	}
	public function rollback()
	{
		return parent::rollback();
	}
	public function info()
	{
		return parent::info();
	}
	public function markpatrolled()
	{
		return parent::markpatrolled();
	}
	public function render()
	{
		return parent::render();
	}
	public function deletetrackback()
	{
		return parent::deletetrackback();
	}
	/**
	 Catch-all
	 */
	public function __call( $method, $args )
	{
		echo  __FILE__ . "__call( $method, $args )<br>";
		
		global $wgOut;
		$wgOut->showErrorPage( 'nosuchaction', 'nosuchactiontext' );
	}

	protected function doPermissionError(     &$titleObj,
	&$titleMessageId,
	&$messageId,
	&$subtitleMessageId = null )
	{
		global $wgUser, $wgOut;

		$skin = $wgUser->getSkin();
		$wgOut->setPageTitle( wfMsg( $titleMessageId ) );
		if ($subtitleMessageId !== null)
		$wgOut->setSubtitle( wfMsg( $subTitleMessageId, $skin->makeKnownLinkObj( $titleObj ) ) );

		$wgOut->addWikiText( wfMsg( $messageId ) );
	}

} // end class declaration

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

class NamespaceManagers
{
	const thisType = 'other';
	const thisName = 'NamespaceManagers';

	static $list = array();
	static $instanceList = array();

	static $msgList = array();
	static $logList = array();

	/**
	 Only 1 handler can be registered by Namespace.
	 */
	public static function register( $ns, $classe, $classfile )
	{
		
//		echo "register( $ns, $classe, $classfile )";
		
		self::$list[$ns] = array(
                                     'ns'   => $ns,
                                     'class'        => $classe,
                                     'file' => $classfile
		);
	}
	public static function getList()
	{ return self::$list; }
	public static function getMsgList()
	{ return self::$msgList; }
	public static function getLogList()
	{ return self::$logList; }

	/**
	 Called during the initialization phase for extensions.
	 */
	public static function setupLogging( )
	{
		if (empty( self::$logList ))
		return;

		foreach( self::$logList as $logtype => &$actions )
		{
			# Add a new log type
			global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
			$wgLogTypes[]                                                = $logtype;
			$wgLogNames  [$logtype]                             = $logtype.'logpage';
			$wgLogHeaders[$logtype]                             = $logtype.'logpagetext';

			if (!empty( $actions ))
			foreach( $actions as $action )
			$wgLogActions[$logtype.'/'.$action]       = $logtype.'-'.$action.'-entry';
		}
	}
	/**
	 Each registered derived classes add their logging related variables through here.

	 An extension's i18n file would call this function to register
	 any logging functionality related global variables.
	 */
	public static function addLog( $log )
	{ self::$logList = array_merge( self::$logList, $log );     }

	/**
	 Called during the initialization phase for extensions.
	 */
	public static function setupMessages( )
	{
		global $wgMessageCache;

		foreach( self::$msgList as $key => $value )
		$wgMessageCache->addMessages( self::$msgList[$key], $key );
	}

	/**
	 Each registered derived classes add their 'messages'

	 An extension's i18n file would call this function to register any messages
	 */
	public static function addMessages( &$msg )
	{ self::$msgList = array_merge( self::$msgList, $msg );      }

	/**
	 Setup the initialization phase for this extension
	 */
	public static function setup()
	{
		global $wgExtensionFunctions;
		#             $wgExtensionFunctions[] = __CLASS__.'::setup'; // PHP <v5.2.2 issues a warning on this one.
		$wgExtensionFunctions[] = create_function( '', 'return '.__CLASS__.'::init();' );

	}
	public static function init()
	{
		global $wgHooks;
		$wgHooks['ArticleFromTitle'][]                            = 'wfNamespaceManagers_hArticleFromTitle';
		$wgHooks['CustomEditor'][]                                        = 'wfNamespaceManagers_hCustomEditor';
//		$wgHooks['SpecialVersionExtensionTypes'][]        = 'wfNamespaceManagers_hSpecialVersionExtensionTypes';

		global $wgAutoloadClasses;
		if (!empty( self::$list ))
		foreach( self::$list as $index => &$e )
		$wgAutoloadClasses[$e['class']] = $e['file'];

		self::setupMessages();
		self::setupLogging();
	}
	/**
	 Reports the status of this extension in the [[Special:Version]] page.
	 */
	public function hSpecialVersionExtensionTypes( &$sp, &$extensionTypes )
	{
		#self::loadAllRegisteredClasses();

		global $wgExtensionCredits;

		$result = 'There are '.count(self::$list)." namespace managers registered.";

		// Add list of managed extensions

		// add other checks here.

		foreach ( $wgExtensionCredits[self::thisType] as $index => &$el )
		if (isset($el['name']))
		if ($el['name']==self::thisName)
		$el['description'] .= $result;

		return true; // continue hook-chain.
	}
	private static function loadAllRegisteredClasses()
	{
		if (empty(self::$list))
		return;

		foreach( self::$list as &$e )
		{
			$classe = $e['class'];
			self::$instanceList[] = new $classe();
		}
	}

	/**
	 This is the main hook of the extension:
	 it intercepts the process flow right at the article creation phase
	 in order to instantiate a specific class for the namespace in focus.

	 Of course, each namespace must be registered through the 'register'
	 function in order for this hook to function properly.
	 */

	public static function hArticleFromTitle( &$title, &$article )
	{
//		echo __FILE__ . ":" . __METHOD__ . " ( $title, $article )<br>";
		
		$ns = $title->getNamespace();
		// Let MW handle these ones.
		if (NS_MEDIA==$ns || NS_CATEGORY==$ns || NS_IMAGE==$ns)
		return true;

		// Look-up if we have a registered manager for the
		// current requested namespace.
		if (!array_key_exists( $ns, self::$list ))
		return true;

		// At this point, we have concluded we have a registered manager
		$classe = self::$list[$ns]['class'];
		$article = new $classe( $title );
		$article->ns = $ns;

		return true;
	}

	/**
	 We also need to trap this event as our namespace manager
	 will most probably need to provide a special 'edit form'
	 */
	public function hCustomEditor( $article, $user )
	{
		LOGME ( __METHOD__ , $article );
		
//		echo __FILE__ . ":" . __METHOD__ . " (  $article,  )<br>";
		
		// only hook onto the relevant namespaces
		if (!( $article instanceof NamespaceManager ))
		return true;

		global $action;
		
	if ( 'submit' == $action )
		{ return $article->submit();  }

	if ( 'edit' == $action )
		{ return $article->edit();  }
/*		if ( 'submit' == $action )
		{ $article->submit(); return false; }
*/
/*		if ( 'edit' == $action )
		{ $article->edit(); return false; }
*/
		return true;
	}

	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	// GENERIC HELPER FUNCTIONS
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	static function getRevisionId( $svnId=null )
	{
		// fixed annoying warning about undefined offset.
		if ( $svnId === null || $svnId == ('$'.'Id'.'$' /* fool SVN */) )
		return null;

		// e.g. $Id: NamespaceManager.php 705 2007-08-20 15:16:39Z jeanlou.dupont $
		$data = explode( ' ', $svnId );
		return $data[2];
	}
	static function getFullUrl( $filename )
	{ return 'http://www.bizzwiki.org/index.php?title=Filesystem:'.self::getRelativePath( $filename );  }

	static function getRelativePath( $filename )
	{
		global $IP;
		$relPath = str_replace( $IP, '', $filename );
		return str_replace( '\\', '/', $relPath );    // at least windows & *nix agree on this!
	}

} // end class declaration

NamespaceManagers::setup();

// List up-to-date with MW 1.10 SVN 21828
NamespaceManager::$hookList = array(
'ArticlePageDataBefore', 
'ArticlePageDataAfter', 
'ArticleAfterFetchContent',
'ArticleViewRedirect', 
'ArticleViewHeader',
'ArticlePurge',
'ArticleSave',                                         // public function hArticleSave        ( &$article, &$user, &$text, $summary, $minor, $dontcare1, $dontcare2, &$flags ) {}
'ArticleInsertComplete',               
'ArticleSaveComplete',                 // public function hArticleSaveComplete( &$article, &$user, &$text, $summary, $minor, $dontcare1, $dontcare2, &$flags ) {}
'MarkPatrolled', 
'MarkPatrolledComplete', 
'WatchArticle', 
'WatchArticleComplete',
'UnwatchArticle', 
'UnwatchArticleComplete', 
'ArticleProtect', 
'ArticleProtectComplete',
'ArticleDelete', 
'ArticleDeleteComplete', 
'ArticleEditUpdatesDeleteFromRecentchanges',
'ArticleEditUpdateNewTalk',
'DisplayOldSubtitle',
'IsFileCacheable',
'CategoryPageView',
'FetchChangesList',
'DiffViewHeader',
'AlternateEdit', 
'EditFormPreloadText',                         // public function hEditFormPreloadText( &$textbox, &$title ) {}
'EditPage::attemptSave', 
'EditFilter', 
'EditPage::showEditForm:initial',
'EditPage::showEditForm:fields',
'SiteNoticeBefore',
'SiteNoticeAfter',
'FileUpload',
'BadImage', 
'MagicWordMagicWords', 
'MagicWordwgVariableIDs',
'MathAfterTexvc',
'MessagesPreLoad',
'LoadAllMessages',
'OutputPageParserOutput',
'OutputPageBeforeHTML',
'AjaxAddScript', 
'PageHistoryBeforeList',
'PageHistoryLineEnding',
'ParserClearState', 
'ParserBeforeStrip',
'ParserAfterStrip',
'ParserBeforeTidy',
'ParserAfterTidy',                                             // public function hParserAfterTidy( &$parser, &$text ) {}
'ParserBeforeInternalParse',
'InternalParseBeforeLinks', 
'ParserGetVariableValueVarCache',
'ParserGetVariableValueTs', 
'ParserGetVariableValueSwitch',
'IsTrustedProxy',
'wgQueryPages', 
'RawPageViewBeforeOutput', 
'RecentChange_save',
'SearchUpdate', 
'AuthPluginSetup', 
'LogPageValidTypes',
'LogPageLogName', 
'LogPageLogHeader', 
'LogPageActionText',
'SkinTemplateTabs', 
'BeforePageDisplay', 
'SkinTemplateOutputPageBeforeExec', 
'PersonalUrls', 
'SkinTemplatePreventOtherActiveTabs',
'SkinTemplateTabs', 
'SkinTemplateBuildContentActionUrlsAfterSpecialPage',
'SkinTemplateContentActions', 
'SkinTemplateBuildNavUrlsNav_urlsAfterPermalink',
'SkinTemplateSetupPageCss',
'BlockIp', 
'BlockIpComplete', 
'BookInformation', 
'SpecialContributionsBeforeMainOutput',
'EmailUser', 
'EmailUserComplete',
'SpecialMovepageAfterMove',
'SpecialPage_initList',
'SpecialPageExecuteBeforeHeader',
'SpecialPageExecuteBeforePage',
'SpecialPageExecuteAfterPage',
'PreferencesUserInformationPanel',
'SpecialSearchNogomatch',
'ArticleUndelete',
'UndeleteShowRevision',
'UploadForm:BeforeProcessing',
'UploadVerification',
'UploadComplete',
'UploadForm:initial',
'AddNewAccount',
'AbortNewAccount',
'UserLoginComplete',
'UserCreateForm',
'UserLoginForm',
'UserLogout',
'UserLogoutComplete',
'UserRights',
'SpecialVersionExtensionTypes',
'AutoAuthenticate', 
'GetFullURL',
'GetLocalURL',
'GetInternalURL',
'userCan',
'TitleMoveComplete',
'isValidPassword',
'UserToggles',
'GetBlockedStatus',
'PingLimiter',
'UserRetrieveNewTalks',
'UserClearNewTalkNotification',
'PageRenderingHash',
'EmailConfirmed',
'ArticleFromTitle',
'CustomEditor',
'UnknownAction',
'LanguageGetMagic',
'LangugeGetSpecialPageAliases',
'MonoBookTemplateToolboxEnd',
'SkinTemplateSetupPageCss',
'SkinTemplatePreventOtherActiveTabs',
);

function wfNamespaceManagers_hArticleFromTitle(&$title, &$article) { return NamespaceManagers::hArticleFromTitle(&$title, &$article); }
function wfNamespaceManagers_hCustomEditor($article, $user) { return NamespaceManagers::hCustomEditor($article, $user); }
function wfNamespaceManagers_hSpecialVersionExtensionTypes(&$sp, &$extensionTypes) { return NamespaceManagers::hSpecialVersionExtensionTypes(&$sp, &$extensionTypes); }

//
