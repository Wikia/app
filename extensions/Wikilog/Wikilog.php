<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * General extension information.
 */
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Wikilog',
	'version'        => '1.2.0',
	'author'         => 'Juliano F. Ravasi',
	'descriptionmsg' => 'wikilog-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Wikilog',
);

/**
 * Constant definitions.
 */
// For source-code readability. This ought to be defined by MediaWiki (and
// there is actually such a definition in DifferenceEngine.php, but it is
// not global). So, it is easier to have our own until MediaWiki provides
// one globally. It also allows us to keep compatibility.
define( 'WL_NBSP', '&#160;' );

/**
 * Dependencies.
 */
require_once( dirname( __FILE__ ) . '/WlFeed.php' );

/**
 * Messages.
 */
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Wikilog'] = $dir . 'Wikilog.i18n.php';
$wgExtensionMessagesFiles['WikilogMagic'] = $dir . 'Wikilog.i18n.magic.php';
$wgExtensionMessagesFiles['WikilogAlias'] = $dir . 'Wikilog.i18n.alias.php';

/**
 * Autoloaded classes.
 */
$wgAutoloadClasses += array(
	// General
	'WikilogHooks'              => $dir . 'WikilogHooks.php',
	'WikilogLinksUpdate'        => $dir . 'WikilogLinksUpdate.php',
	'WikilogUtils'              => $dir . 'WikilogUtils.php',
	'WikilogNavbar'             => $dir . 'WikilogUtils.php',
	'SpecialWikilog'            => $dir . 'SpecialWikilog.php',

	// Objects
	'WikilogItem'               => $dir . 'WikilogItem.php',
	'WikilogComment'            => $dir . 'WikilogComment.php',
	'WikilogCommentFormatter'   => $dir . 'WikilogComment.php',

	// WikilogParser.php
	'WikilogParser'             => $dir . 'WikilogParser.php',
	'WikilogParserOutput'       => $dir . 'WikilogParser.php',

	// WikilogItemPager.php
	'WikilogItemPager'          => $dir . 'WikilogItemPager.php',
	'WikilogSummaryPager'       => $dir . 'WikilogItemPager.php',
	'WikilogTemplatePager'      => $dir . 'WikilogItemPager.php',
	'WikilogArchivesPager'      => $dir . 'WikilogItemPager.php',

	// WikilogCommentPager.php
	'WikilogCommentPager'       => $dir . 'WikilogCommentPager.php',
	'WikilogCommentListPager'   => $dir . 'WikilogCommentPager.php',
	'WikilogCommentThreadPager' => $dir . 'WikilogCommentPager.php',

	// WikilogFeed.php
	'WikilogFeed'               => $dir . 'WikilogFeed.php',
	'WikilogItemFeed'           => $dir . 'WikilogFeed.php',
	'WikilogCommentFeed'        => $dir . 'WikilogFeed.php',

	// WikilogQuery.php
	'WikilogQuery'              => $dir . 'WikilogQuery.php',
	'WikilogItemQuery'          => $dir . 'WikilogQuery.php',
	'WikilogCommentQuery'       => $dir . 'WikilogQuery.php',

	// Namespace pages
	'WikilogMainPage'           => $dir . 'WikilogMainPage.php',
	'WikilogItemPage'           => $dir . 'WikilogItemPage.php',
	'WikilogWikiItemPage'       => $dir . 'WikilogItemPage.php',
	'WikilogCommentsPage'       => $dir . 'WikilogCommentsPage.php',

	// Captcha adapter
	'WlCaptcha'                 => $dir . 'WlCaptchaAdapter.php',
	'WlCaptchaAdapter'          => $dir . 'WlCaptchaAdapter.php',
);

/**
 * Special pages.
 */
$wgSpecialPages['Wikilog'] = 'SpecialWikilog';
$wgSpecialPageGroups['Wikilog'] = 'changes';

/**
 * Hooks.
 */
$wgExtensionFunctions[] = array( 'Wikilog', 'ExtensionInit' );

// Main Wikilog hooks
$wgHooks['ArticleFromTitle'][] = 'Wikilog::ArticleFromTitle';
$wgHooks['ArticleViewHeader'][] = 'Wikilog::ArticleViewHeader';
$wgHooks['BeforePageDisplay'][] = 'Wikilog::BeforePageDisplay';
$wgHooks['LinkBegin'][] = 'Wikilog::LinkBegin';
$wgHooks['SkinTemplateTabAction'][] = 'Wikilog::SkinTemplateTabAction';
$wgHooks['SkinTemplateTabs'][] = 'Wikilog::SkinTemplateTabs';
$wgHooks['SkinTemplateNavigation'][] = 'Wikilog::SkinTemplateNavigation';

// General Wikilog hooks
$wgHooks['ArticleEditUpdates'][] = 'WikilogHooks::ArticleEditUpdates';
$wgHooks['ArticleDeleteComplete'][] = 'WikilogHooks::ArticleDeleteComplete';
$wgHooks['ArticleSave'][] = 'WikilogHooks::ArticleSave';
$wgHooks['TitleMoveComplete'][] = 'WikilogHooks::TitleMoveComplete';
$wgHooks['EditPage::attemptSave'][] = 'WikilogHooks::EditPageAttemptSave';
$wgHooks['EditPage::showEditForm:fields'][] = 'WikilogHooks::EditPageEditFormFields';
$wgHooks['EditPage::importFormData'][] = 'WikilogHooks::EditPageImportFormData';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'WikilogHooks::ExtensionSchemaUpdates';
$wgHooks['UnknownAction'][] = 'WikilogHooks::UnknownAction';

// WikilogLinksUpdate hooks
$wgHooks['LinksUpdate'][] = 'WikilogLinksUpdate::LinksUpdate';

// WikilogParser hooks
$wgHooks['ParserFirstCallInit'][] = 'WikilogParser::FirstCallInit';
$wgHooks['ParserClearState'][] = 'WikilogParser::ClearState';
$wgHooks['ParserBeforeStrip'][] = 'WikilogParser::BeforeStrip';
$wgHooks['ParserAfterTidy'][] = 'WikilogParser::AfterTidy';
$wgHooks['InternalParseBeforeLinks'][] = 'WikilogParser::InternalParseBeforeLinks';
$wgHooks['GetLocalURL'][] = 'WikilogParser::GetLocalURL';
$wgHooks['GetFullURL'][] = 'WikilogParser::GetFullURL';

/**
 * Added rights.
 */
$wgAvailableRights[] = 'wl-postcomment';
$wgAvailableRights[] = 'wl-moderation';
$wgGroupPermissions['user']['wl-postcomment'] = true;
$wgGroupPermissions['sysop']['wl-moderation'] = true;

/**
 * Reserved usernames.
 */
$wgReservedUsernames[] = 'msg:wikilog-auto';

/**
 * Logs.
 */
$wgLogTypes[] = 'wikilog';
$wgLogNames['wikilog'] = 'wikilog-log-pagename';
$wgLogHeaders['wikilog'] = 'wikilog-log-pagetext';
$wgLogActions['wikilog/c-approv'] = 'wikilog-log-cmt-approve';
$wgLogActions['wikilog/c-reject'] = 'wikilog-log-cmt-reject';

/**
 * Default settings.
 */
require_once( dirname( __FILE__ ) . '/WikilogDefaultSettings.php' );


/**
 * Main Wikilog class. Used as a namespace. No instances of this class are
 * intended to exist, all member functions are static.
 */
class Wikilog
{
	# ##
	# #  Setup functions.
	#

	/**
	 * Create a namespace, associating wikilog features to it.
	 *
	 * @param $ns Subject namespace number, must even and greater than 100.
	 * @param $name Subject namespace name.
	 * @param $talk Talk namespace name.
	 */
	static function setupNamespace( $ns, $name, $talk ) {
		global $wgExtraNamespaces, $wgWikilogNamespaces;

		if ( $ns < 100 ) {
			echo "Wikilog setup: custom namespaces should start " .
				 "at 100 to avoid conflict with standard namespaces.\n";
			die( 1 );
		}
		if ( ( $ns % 2 ) != 0 ) {
			echo "Wikilog setup: given namespace ($ns) is not a " .
				 "subject namespace (even number).\n";
			die( 1 );
		}
		if ( is_array( $wgExtraNamespaces ) && isset( $wgExtraNamespaces[$ns] ) ) {
			$nsname = $wgExtraNamespaces[$ns];
			echo "Wikilog setup: given namespace ($ns) is already " .
				 "set to '$nsname'.\n";
			die( 1 );
		}

		$wgExtraNamespaces[$ns  ] = $name;
		$wgExtraNamespaces[$ns ^ 1] = $talk;
		$wgWikilogNamespaces[] = $ns;
	}

	# ##
	# #  MediaWiki hooks.
	#

	/**
	 * Extension setup function.
	 */
	static function ExtensionInit() {
		global $wgWikilogStylePath, $wgWikilogNamespaces;
		global $wgScriptPath, $wgNamespacesWithSubpages;

		# Set default style path, if not set.
		if ( !$wgWikilogStylePath ) {
			$wgWikilogStylePath = "$wgScriptPath/extensions/Wikilog/style";
		}

		# Find assigned namespaces and make sure they have subpages
		foreach ( $wgWikilogNamespaces as $ns ) {
			$wgNamespacesWithSubpages[$ns  ] = true;
			$wgNamespacesWithSubpages[$ns ^ 1] = true;
		}

		# Work around bug in MediaWiki 1.13 when '?action=render'.
		# https://bugzilla.wikimedia.org/show_bug.cgi?id=15512
		global $wgRequest;
		if ( $wgRequest->getVal( 'action' ) == 'render' ) {
			WikilogParser::expandLocalUrls();
		}
	}

	/**
	 * ArticleFromTitle hook handler function.
	 * Detects if the article is a wikilog article (self::getWikilogInfo
	 * returns an instance of WikilogInfo) and returns the proper class
	 * instance for the article.
	 */
	static function ArticleFromTitle( &$title, &$article ) {
		global $wgWikilogEnableComments;

		if ( ( $wi = self::getWikilogInfo( $title ) ) ) {
			if ( $title->isTalkPage() ) {
				if ( $wgWikilogEnableComments && $wi->isItem() ) {
					$article = new WikilogCommentsPage( $title, $wi );
				} else {
					return true;
				}
			} elseif ( $wi->isItem() ) {
				$item = WikilogItem::newFromInfo( $wi );
				$article = new WikilogItemPage( $title, $item );
			} else {
				$article = new WikilogMainPage( $title, $wi );
			}
			return false;	// stop processing
		}
		return true;
	}

	/**
	 * ArticleViewHeader hook handler function.
	 * If viewing a WikilogCommentsPage, and the page doesn't exist in the
	 * database, don't show the "there is no text in this page" message
	 * (msg:noarticletext), since it gives wrong instructions to visitors.
	 * The comment form is self-explaining enough.
	 */
	static function ArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		if ( $article instanceof WikilogCommentsPage && $article->getID() == 0 ) {
			$outputDone = true;
		}
		return true;
	}

	/**
	 * BeforePageDisplay hook handler function.
	 * Adds wikilog CSS to pages displayed.
	 */
	static function BeforePageDisplay( &$output, &$skin ) {
		global $wgWikilogStylePath, $wgWikilogStyleVersion;
		$output->addExtensionStyle( "{$wgWikilogStylePath}/wikilog.css?{$wgWikilogStyleVersion}" );
		return true;
	}

	/**
	 * LinkBegin hook handler function.
	 * Links to wikilog comment pages are always "known" if the corresponding
	 * article page exists.
	 */
	static function LinkBegin( $skin, $target, &$text, &$attribs, &$query,
			&$options, &$ret )
	{
		if ( $target->isTalkPage() && !in_array( 'known', $options ) ) {
			$wi = self::getWikilogInfo( $target );
			if ( $wi && $wi->isItem() && !$wi->getTrailing() && $wi->getItemTitle()->exists() ) {
				if ( ( $i = array_search( 'broken', $options ) ) !== false ) {
					array_splice( $options, $i, 1 );
				}
				$options[] = 'known';
			}
		}
		return true;
	}

	/**
	 * SkinTemplateTabAction hook handler function.
	 * Same as Wikilog::LinkBegin, but for the tab actions.
	 */
	static function SkinTemplateTabAction( &$skin, $title, $message, $selected,
			$checkEdit, &$classes, &$query, &$text, &$result )
	{
		if ( $title->isTalkPage() && !$title->exists() ) {
			$wi = self::getWikilogInfo( $title );
			if ( $wi && $wi->isItem() && $wi->getItemTitle()->exists() ) {
				$query = '';
				if ( ( $i = array_search( 'new', $classes ) ) !== false ) {
					array_splice( $classes, $i, 1 );
				}
			}
		}
		return true;
	}

	/**
	 * SkinTemplateTabs hook handler function.
	 * Adds a wikilog tab to articles in Wikilog namespaces.
	 * Suppresses the "add section" tab in comments pages.
	 */
	static function SkinTemplateTabs( $skin, &$contentActions ) {
		$wi = self::getWikilogInfo( $skin->getTitle() );
		if ( $wi ) {
			self::skinConfigViewsLinks( $wi, $skin, $contentActions );
		}
		return true;
	}

	/**
	 * SkinTemplateNavigation hook handler function.
	 * Adds a wikilog action to articles in Wikilog namespaces.
	 * This is used with newer skins, like Vector.
	 */
	static function SkinTemplateNavigation( $skin, &$links ) {
		$wi = self::getWikilogInfo( $skin->getTitle() );
		if ( $wi ) {
			self::skinConfigViewsLinks( $wi, $skin, $links['views'] );
		}
		return true;
	}

	/**
	 * Configure wikilog views links.
	 * Helper function for SkinTemplateTabs and SkinTemplateNavigation hooks
	 * to configure views links in wikilog pages.
	 */
	private static function skinConfigViewsLinks( WikilogInfo &$wi, $skin, &$views ) {
		global $wgRequest, $wgWikilogEnableComments;

		$action = $wgRequest->getText( 'action' );
		if ( $wi->isMain() && $skin->getTitle()->quickUserCan( 'edit' ) ) {
			$views['wikilog'] = array(
				'class' => ( $action == 'wikilog' ) ? 'selected' : false,
				'text' => wfMsg( 'wikilog-tab' ),
				'href' => $skin->getTitle()->getLocalUrl( 'action=wikilog' )
			);
		}
		if ( $wgWikilogEnableComments && $wi->isTalk() ) {
			if ( isset( $views['addsection'] ) ) {
				unset( $views['addsection'] );
			}
		}
	}

	# ##
	# #  Other global wikilog functions.
	#

	/**
	 * Returns wikilog information for the given title.
	 * This function checks if @a $title is an article title in a wikilog
	 * namespace, and returns an appropriate WikilogInfo instance if so.
	 *
	 * @param $title Article title object.
	 * @return WikilogInfo instance, or NULL.
	 */
	static function getWikilogInfo( $title ) {
		global $wgWikilogNamespaces;

		if ( !$title )
			return null;

		$ns = MWNamespace::getSubject( $title->getNamespace() );
		if ( in_array( $ns, $wgWikilogNamespaces ) ) {
			return new WikilogInfo( $title );
		} else {
			return null;
		}
	}
}

/**
 * Wikilog information class.
 * This class represents relationship information about a wikilog article,
 * given its title. It is used to derive the main wikilog article name or the
 * comments page name from the wikilog post, for example.
 */
class WikilogInfo
{
	public $mWikilogName;		///< Wikilog title (textual string).
	public $mWikilogTitle;		///< Wikilog main article title object.
	public $mItemName;			///< Wikilog post title (textual string).
	public $mItemTitle;			///< Wikilog post title object.
	public $mItemTalkTitle;		///< Wikilog post talk title object.

	public $mIsTalk;			///< Constructed using a talk page title.
	public $mTrailing = null;	///< Trailing subpage title.

	/**
	 * Constructor.
	 * @param $title Title object.
	 */
	function __construct( $title ) {
		$origns = $title->getNamespace();
		$this->mIsTalk = MWNamespace::isTalk( $origns );
		$ns = MWNamespace::getSubject( $origns );
		$tns = MWNamespace::getTalk( $origns );

		if ( strpos( $title->getText(), '/' ) !== false ) {
			# If title contains a '/', treat as a wikilog article title.
			list( $this->mWikilogName, $this->mItemName ) =
				explode( '/', $title->getText(), 2 );

			if ( strpos( $this->mItemName, '/' ) !== false ) {
				list( $this->mItemName, $this->mTrailing ) =
					explode( '/', $this->mItemName, 2 );
			}

			$rawtitle = "{$this->mWikilogName}/{$this->mItemName}";
			$this->mWikilogTitle = Title::makeTitle( $ns, $this->mWikilogName );
			$this->mItemTitle = Title::makeTitle( $ns, $rawtitle );
			$this->mItemTalkTitle = Title::makeTitle( $tns, $rawtitle );
		} else {
			# Title doesn't contain a '/', treat as a wikilog name.
			$this->mWikilogName = $title->getText();
			$this->mWikilogTitle = Title::makeTitle( $ns, $this->mWikilogName );
			$this->mItemName = null;
			$this->mItemTitle = null;
			$this->mItemTalkTitle = null;
		}
	}

	function isMain() { return $this->mItemTitle === null; }
	function isItem() { return $this->mItemTitle !== null; }
	function isTalk() { return $this->mIsTalk; }
	function isSubpage() { return $this->mTrailing !== null; }

	function getName() { return $this->mWikilogName; }
	function getTitle() { return $this->mWikilogTitle; }
	function getItemName() { return $this->mItemName; }
	function getItemTitle() { return $this->mItemTitle; }
	function getItemTalkTitle() { return $this->mItemTitle->getTalkPage(); }

	function getTrailing() { return $this->mTrailing; }
}

/**
 * Interface used by article derived classes that implement the "wikilog"
 * action handler. That is, pages that can be called with ?action=wikilog.
 */
interface WikilogCustomAction
{
	public function wikilog();
}
