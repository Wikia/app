<?php

if ( !defined( 'MEDIAWIKI' ) ) die( 'This is an extension to the MediaWiki software and cannot be used standalone.' );

/**
 * MediaWiki Advanced Meta extension
 * Add meta data to individual pages or entire namespaces
 * @version 2.0.1
 * @author Stephan Muller <mail@litso.com> (Main author)
 * @author Bart van Heukelom <b@rtvh.nl> (Objectification)
 * @author Zayoo <zayoo@126.com> (Revise & TitleAlias, refer to Extension:Add HTML Meta and Title & Extension:TitleAlias)
 */

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Advanced Meta',
	'author' => array( '[http://www.stephanmuller.nl Stephan Muller]', 'Bart van Heukelom, Zayoo' ),
	'descriptionmsg' => 'ameta-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Advanced_Meta',
	'version' => '2.0.1'
);

$wgExtensionMessagesFiles['MWAdvancedMeta'] = dirname( __FILE__ ) . '/MWAdvancedMeta.i18n.php';
MWAdvancedMeta::setup();

$wgHooks['LoadExtensionSchemaUpdates'][] = 'efAdvancedMetaSchemaUpdates';

/**
 * @param $updater DatabaseUpdater
 * @return bool
 */
function efAdvancedMetaSchemaUpdates( $updater ) {
	$base = dirname( __FILE__ );
	switch ( $updater->getDB()->getType() ) {
		case 'mysql':
			$updater->addExtensionUpdate( array( 'addTable', 'ext_meta',
				"$base/AdvancedMeta.sql", true ) ); // Initially install tables
			break;
		default:
			print"\n".
				"There are no table structures for the AdvancedMeta\n".
				"extension for your data base type at the moment.\n\n";
	}
	return True;
}

class MWAdvancedMeta {

	private static $instance = null;

	/**
	 * Initialise the advanced meta plugin.
	 * @return MWAdvancedMeta the plugin object, which you can use to set settings.
	 */
	public static function setup() {
		// create plugin
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private $indexedPages = array( NS_MAIN, NS_PROJECT );
	private $allowedUsers = array();
	private $allowedUsergroups = array( 'sysop', 'bureaucrat' );
	private $savedMeta = null;

	public function __construct() {

		/*********
		 * Hooks *
		 *********/

		global $wgHooks;

		// Inserts HTML for meta input fields into the edit page.
		$wgHooks['ParserBeforeTidy'][] = $this;

		// Before the updated text and properties of an article are saved to the database
		// the new meta info is saved too
		$wgHooks['ArticleSave'][] = $this;

		// If a new article is created the meta is temporarily saved as article ID '0'
		// Move it to the newly created article now
		$wgHooks['ArticleInsertComplete'][] = $this;

		// Insert meta into article
		$wgHooks['OutputPageBeforeHTML'][] = $this;

		// Title Alias
		$wgHooks['BeforePageDisplay'][] = $this;
	}

	/**
	 * All namespaces get a robots setting of "noindex, nofollow" by default.
	 * Use this method to specify namespaces with interesting content, pages in which should be indexed.
	 * Default is NS_MAIN and NS_PROJECT.
	 * @param $indexedPages Array of namespace names.
	 */
	public function setIndexedPages( array $indexedPages ) {
		$this->indexedPages = $indexedPages;
	}

	/**
	 * Specify keywords that should be added to every page.
	 * @param $keywords The keywords in an array.
	 */
	public function setGlobalKeywords( $keywords ) {
		$this->globalKeywords = $keywords;
	}

	/**
	 * SEO can be a delicate issue. Define here who is allowed to edit the meta tags
	 * allow users individually, by username. Warning: Case sensitive!
	 */
	public function setAllowedUsers( $users ) {
		$this->allowedUsers = $users;
	}

	/**
	 * allow users by mediawiki's own usergroups
	 * or the special groups 'loggedin' and 'all' ('all' allowing even anonymous edits)
	 */
	public function setAllowedUsergroups( $usergroups ) {
		$this->allowedUsergroups = $usergroups;
	}

	/**
	 * Hook 1: in /includes/parser/Parser.php
	 * Loops through the different sections of the page being parsed
	 * and adds html for the meta input forms into the article edit pages
	 *
	 * @param object $parser The parser object
	 * @param string $text
	 *
	 * @global indexedpages defined in the global config section above
	 * @global alloweusers defined in the global config section above
	 *
	 * @return true
	 *
	 */
	public function onParserBeforeTidy( &$parser, &$text ) {

		global $wgTitle, $wgUser, $wgRequest;

		// only run this hook for edit forms
		if ( !$wgRequest->getVal( 'action' ) == ( 'edit' || 'submit' ) ) return false;

		// can this user edit meta for this page?
		if ( !$this->canEditMeta() ) return false;

		// handle submit (preview)
		if ( $wgRequest->wasPosted() ) {
				// it's probably a preview, so show the newly submitted meta too, otherwise we'll lose 'em
				$meta = array(
						'rindex' => ( isset( $_POST['wpIndex'] ) ) ? '1' : '0',
						'rfollow' => ( isset( $_POST['wpFollow'] ) ) ? '1' : '0',
						'titlealias' => $_POST['wpTitleAlias'],
						'keywords' => $_POST['wpKeywords'],
						'description' => $_POST['wpDescription']
				);
		} else {
				// else just get the meta from the db
				$meta = $this->getMetaByArticleID( $wgTitle->getArticleID() );

				// no meta or creating a new article? make default values
				if ( empty( $meta ) || $wgTitle->getArticleID() == '0' ) {
						$meta = array(
								'rindex' => '1',
								'rfollow' => '1',
								'titlealias' => '',
								'keywords' => '',
								'description' => ''
						);
				}
		}

		// prepare checkboxes
		$checkindex  = ( $meta['rindex']  == '1' ) ? 'checked="checked"' : '' ;
		$checkfollow = ( $meta['rfollow'] == '1' ) ? 'checked="checked"' : '' ;

		// some mediawiki preference variables
		$cols   = $wgUser->getIntOption( 'cols' );
		$ew     = $wgUser->getOption( 'editwidth' );

		$addedkeywords = wfMsg( 'globalkeywords' ) == '&lt;globalkeywords&gt;' ? '(none)' : wfMsg( 'globalkeywords' );

		// define replacements
		$replaceFrom[] = '<div id="editpage-copywarn">';
		$replaceWith[] =
				"<h2>" . wfMsg( 'ameta-metasettings' ) . "</h2>
				<strong>Robots:</strong>
						<label><input tabindex='2' id='wpIndex' type='checkbox' name='wpIndex' value='1' {$checkindex} accesskey='/'>
						Index</label>
						<label><input tabindex='3' id='wpFollow' type='checkbox' name='wpFollow' value='1' {$checkfollow} >
						Follow</label>

				<br /><strong>" . wfMsg( 'ameta-titlealias' ) . "</strong><br />
				<input type='text' name='wpTitleAlias' id='wpTitleAlias' value='{$meta['titlealias']}' size='64'>

				<br /><strong>Keywords:</strong> <small>" . wfMessage( 'ameta-keywordsadd', count( $addedkeywords ) )->text() . "<a href='javascript:;' title='" . wfMsg( 'ameta-keywordsmodify' ) . "'>" . htmlspecialchars( str_replace( "$1", $wgTitle, $addedkeywords ) ) . "</a>
				</small><br />
				<textarea tabindex='4' name='wpKeywords' id='wpKeywords' rows='1'
				cols='{$cols}'{$ew}>{$meta['keywords']}</textarea>

				<br /><strong>Description:</strong><br />
				<textarea tabindex='4' name='wpDescription' id='wpDescription' rows='2'
				cols='{$cols}'{$ew}>{$meta['description']}</textarea>

				<div id=\"editpage-copywarn\">";

		// apply replacements
		$text = str_replace( $replaceFrom, $replaceWith, $text );

		return true;
	}

	/**
	 * Hook 2: Called during function doEdit() in /includes/Article.php
	 * Adds the new meta information to the database when an article is saved
	 *
	 * @param object $article The entire article and it's properties
	 * @param object $user  The user updating the article
	 * @return true
	 *
	 * @global indexedpages, array of namespaces that should be indexed
	 *
	 */
	public function onArticleSave( &$article, &$user ) {
		$id = $article->mTitle->getArticleID();

		// can this user edit meta for this page?
		if ( !$this->canEditMeta() ) {
			return true; // return false gives edit conflicts
		}

		// get meta from the posted forms
		$metaData = array(
				'rindex' => isset( $_POST['wpIndex'] ) ? '1' : '0',
				'rfollow' => isset( $_POST['wpFollow'] ) ? '1' : '0',
				'titlealias' => htmlspecialchars( $_POST['wpTitleAlias'] ),
				'keywords' => htmlspecialchars( $_POST['wpKeywords'] ),
				'description' => htmlspecialchars( $_POST['wpDescription'] )
		);

		if ( $id == 0 ) {
			// if this is an insert, we need to store the meta until we know the page id
			$this->savedMeta = $metaData;
		} else {
			// write new metadata to the database
			$this->writeMeta( $id, $metaData );
		}

		// empty cache for the page
		$dbw = wfGetDB( DB_MASTER );
		$timestamp = $dbw->timestamp();
		$dbw->update( 'page',
				array( 'page_touched' => $timestamp ),
				array(
						'page_id'     => $id ),
				__METHOD__ );

		return true;
	}

	/**
	 * Hook 3: Called during function doEdit() in /includes/Article.php
	 * Move the new meta information from a temporary id='0' to the new article's id
	 *
	 * @param object $article: the article (object) saved
	 * @param object $user: the user (object) who saved the article
	 * @param string $text: the new article content
	 * @param string $summary: the article summary (comment)
	 * @param bool $minoredit: minor edit flag
	 * @param bool $watchthis: not used as of 1.8 (automatically set to "null")
	 * @param bool $sectionanchor: not used as of 1.8 (automatically set to "null")
	 * @param unknown $flags: bitfield, see source code for details; passed to Article::doedit()
	 * @param object $revision: The newly inserted revision object (as of 1.11.0)

	 * @return true
	 *
	 * @global indexedpages, array of namespaces that should be indexed
	 *
	 */
	function onArticleInsertComplete( &$article, &$user, $text, $summary, $minoredit,
		$watchthis, $sectionanchor, &$flags, $revision ) {

		// if we have saved metadata, insert it
		if ( $this->savedMeta !== null ) {
			// write new metadata to the database
			$this->writeMeta( $article->getID(), $this->savedMeta );
			$this->savedMeta = null;
		}

		return true;

	}

	/**
	 * Hook 4: Called during function view() in /includes/OutputPage.php
	 * Adds the proper meta tags to the article when a page is viewed
	 *
	 * @param object $out The outputted page
	 * @param string $text The file description
	 * @return true
	 */
	function onOutputPageBeforeHTML( &$out, &$text ) {
		global $wgTitle, $wgArticleRobotPolicies, $wgDefaultRobotPolicy;

		$articleid = $wgTitle->getPrefixedText();
		$addedkeywords = wfMsg( 'globalkeywords' ) == '&lt;globalkeywords&gt;' ? '' : wfMsg( 'globalkeywords' , $wgTitle );
		$meta = $this->getMetaByArticleID( $wgTitle->getArticleID() );

		/* robots policies */

		// fallback policy
		$policy = $wgDefaultRobotPolicy;

		// fallback policy for pages that are not in the indexed namespaces and have no db info
		if ( !in_array( $wgTitle->getnamespace(), $this->indexedPages ) ) {
		   $policy = 'noindex,follow';
		}

		// policies in the database overwrite any fallbacks
		if ( !empty( $meta ) ) {
				$index  = ( $meta['rindex'] == '1' )  ? 'index'  : 'noindex';
				$follow = ( $meta['rfollow'] == '1' ) ? 'follow' : 'nofollow';
				$policy = "$index,$follow";
		}

		/* keywords */

		// fallback keywords
		$keywords = array_merge( explode( ',', $addedkeywords ), $out->mKeywords );    // Global keywords should be shown even no meta data

		// only overwrite keywords if any were provided (else the ones generated by mediawiki are used)
		if ( !empty( $meta['keywords'] ) )
						$keywords = array_merge( explode( ',', $addedkeywords ), explode( ',', $meta['keywords'] ) );


		/* output all new meta values */
		$out->mKeywords = $keywords;
		$out->setRobotPolicy( $policy );

		$wgArticleRobotPolicies[$articleid] = $policy;


		if ( !empty( $meta['description'] ) )
			$out->addMeta( "description", $meta['description'] );

		return true;
	}

	/**
	 * Hook 5: Called during function output() in /includes/OutputPage.php
	 * Allows last minute changes to the output page, e.g. adding of CSS or Javascript by extensions
	 *
	 * @param object $out The OutputPage object
	 * @param string $sk Skin object that will be used to generate the page
	 * @return true
	 */
	function onBeforePageDisplay( &$out, &$text ) {

		global $wgTitle;

		$meta = $this->getMetaByArticleID( $wgTitle->getArticleID() );

		if ( empty( $meta ) ) {
			return true;
		}

		if ( !empty( $meta['titlealias'] ) ) {
			$out->mHTMLtitle = wfMsg( 'pagetitle', $meta['titlealias'] );
		}
		return true;
	}

	private function getMetaByArticleID( $id ) {

		// get metadata from database
		$dbr = wfGetDB( DB_MASTER );
		$data = $dbr->select( 'ext_meta',
					array(  'rindex', 'rfollow', 'titlealias', 'keywords', 'description' ),
					array( 'pageid' => $id ),
					__METHOD__
				);
		$meta = $dbr->fetchRow( $data );
		$dbr->freeResult( $data );

		return $meta;
	}

	private function writeMeta( $id, $metaData ) {
		$fname = 'MWAdvancedMeta::writeMeta';
		$dbw = wfGetDB( DB_MASTER );
		if ( $metaData['rindex'] == '1' && $metaData['rfollow'] == '1'
			 && empty( $metaData['titlealias'] ) && empty( $metaData['keywords'] )
			 && empty( $metaData['description'] ) ) {

			$dbw->delete( 'ext_meta', array( 'pageid' => $id ), __METHOD__ );    // delete meta with normal robot policies and without titlealias, keywords & description to save space
		} else {
			$dbw->replace(
					'ext_meta',
					array(  'pageid' => $id ),
					array_merge( $metaData, array( 'pageid' => $id ) ),
					$fname
			);
		}
	}

	private function canEditMeta() {

		global $wgUser, $wgTitle;

		//$ns = $wgTitle->getNamespace();

		// redirect pages don't need metadata
		// TODO: make work in MediaWiki < 1.13
		//        if ($wgTitle->isRedirect()) {
		//            return false;
		//        }

		// does the user have permission?
		return ( in_array( $wgUser->getName(), $this->allowedUsers )
					|| in_array( 'all', $this->allowedUsergroups )
					|| ( in_array( 'loggedin', $this->allowedUsergroups ) && $wgUser->isLoggedIn() )
					|| count(array_intersect($wgUser->getGroups(), $this->allowedUsergroups)) !== 0
					);
	}
}
