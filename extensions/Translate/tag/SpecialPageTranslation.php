<?php
/**
 * Contains logic for special page Special:ImportTranslations.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008-2010 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * A special page for marking revisions of pages for translation.
 *
 * This page is the main tool for translation administrators in the wiki.
 * It will list all pages in their various states and provides actions
 * that are suitable for given translatable page.
 *
 * @ingroup SpecialPage PageTranslation
 */
class SpecialPageTranslation extends SpecialPage {
	function __construct() {
		parent::__construct( 'PageTranslation' );
	}

	public function execute( $parameters ) {
		$this->setHeaders();

		global $wgRequest, $wgOut, $wgUser;
		$this->user = $wgUser;

		$target = $wgRequest->getText( 'target', $parameters );
		$revision = $wgRequest->getInt( 'revision', 0 );

		// No specific page or invalid input
		$title = Title::newFromText( $target );
		if ( !$title ) {
			if ( $target !== '' ) {
				$wgOut->addWikiMsg( 'tpt-badtitle' );
			} else {
				$this->listPages();
			}

			return;
		}

		// Check permissions
		if ( !$this->user->isAllowed( 'pagetranslation' ) ) {
			$wgOut->permissionRequired( 'pagetranslation' );

			return;
		}

		// Check permissions
		if ( $wgRequest->wasPosted() && !$this->user->matchEditToken( $wgRequest->getText( 'token' ) ) ) {
			self::superDebug( __METHOD__, "token failure", $this->user );
			$wgOut->permissionRequired( 'pagetranslation' );
			return;
		}

		// We are processing some specific page
		if ( !$title->exists() ) {
			$wgOut->addWikiMsg( 'tpt-nosuchpage', $title->getPrefixedText() );
			return;
		}

		if ( $revision === -1 ) {
			$page = TranslatablePage::newFromTitle( $title );
			$page->removeTags();
			$page->getTitle()->invalidateCache();

			$logger = new LogPage( 'pagetranslation' );
			$params = array( 'user' => $wgUser->getName() );
			$logger->addEntry( 'unmark', $page->getTitle(), null, array( serialize( $params ) ) );
			$wgOut->addWikiMsg( 'tpt-unmarked', $title->getPrefixedText() );
			self::superDebug( __METHOD__, "unmarked page", $this->user, $title );
			return;
		}

		if ( $revision === 0 ) {
			// Get the latest revision
			$revision = intval( $title->getLatestRevID() );
		}

		$page = TranslatablePage::newFromRevision( $title, $revision );
		if ( !$page instanceof TranslatablePage ) {
			$wgOut->addWikiMsg( 'tpt-notsuitable', $title->getPrefixedText(), $revision );

			return;
		}

		if ( $revision !== intval( $title->getLatestRevID() ) ) {
			// We do want to notify the reviewer if the underlying page changes during review
			$wgOut->addWikiMsg( 'tpt-oldrevision', $title->getPrefixedText(), $revision );
			self::superDebug( __METHOD__, "revision mismatch while marking", $this->user, $title, $revision, intval( $title->getLatestRevID() ) );
			return;
		}

		$lastrev = $page->getMarkedTag();
		if ( $lastrev !== false && $lastrev === $revision ) {
			$wgOut->addWikiMsg( 'tpt-already-marked' );
			$this->listPages();

			return;
		}

		// This will modify the sections to include name property
		$error = false;
		$sections = $this->checkInput( $page, $error );

		// Non-fatal error which prevents saving
		if ( $error === false && $wgRequest->wasPosted() ) {
			$err = $this->markForTranslation( $page, $sections );
			if ( $err ) {
				call_user_func_array( array( $wgOut, 'addWikiMsg' ), $err );
			} else {
				$this->showSuccess( $page );
				$this->listPages();
			}

			return;
		}

		self::superDebug( __METHOD__, "marking page", $this->user, $title, $revision );
		$this->showPage( $page, $sections );
	}

	public function showSuccess( TranslatablePage $page ) {
		global $wgOut, $wgLang;

		$titleText = $page->getTitle()->getPrefixedText();
		$num = $wgLang->formatNum( $page->getParse()->countSections() );
		$link = SpecialPage::getTitleFor( 'Translate' )->getFullUrl(
			array( 'group' => $page->getMessageGroupId() ) );

		$wgOut->addWikiMsg( 'tpt-saveok', $titleText, $num, $link );
	}

	public function loadPagesFromDB() {
		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'revtag_type', 'revtag' );
		$vars = array( 'page_id', 'page_title', 'page_namespace', 'page_latest', 'MAX(rt_revision) as rt_revision', 'rtt_name' );
		$conds = array(
			'page_id=rt_page',
			'rt_type=rtt_id',
			'rtt_name' => array( 'tp:mark', 'tp:tag' ),
		);
		$options = array(
			'ORDER BY' => 'page_namespace, page_title',
			'GROUP BY' => 'page_id, rtt_id',
		);
		$res = $dbr->select( $tables, $vars, $conds, __METHOD__, $options );

		return $res;
	}

	public function listPages() {
		global $wgOut;

		$res = $this->loadPagesFromDB();
		if ( !$res->numRows() ) {
			$wgOut->addWikiMsg( 'tpt-list-nopages' );
			return;
		}

		$pages = array();
		foreach ( $res as $r ) {
			if ( !isset( $pages[$r->page_id] ) ) {
				$pages[$r->page_id] = array();
				$title = Title::newFromRow( $r );
				$pages[$r->page_id]['title'] = $title;
				$pages[$r->page_id]['latest'] = intval( $title->getLatestRevID() );
			}

			$pages[$r->page_id][$r->rtt_name] = intval( $r->rt_revision );
		}

		// Pages where mark <= tag
		$items = array();
		foreach ( $pages as $index => $page ) {
			if ( !isset( $page['tp:mark'] ) || !isset( $page['tp:tag'] ) ) {
				continue;
			}

			if ( $page['tp:tag'] !== $page['latest'] ) {
				continue;
			}

			$link = $this->user->getSkin()->link( $page['title'] );
			if ( $page['tp:mark'] !== $page['tp:tag'] ) {
				$link = "<b>$link</b>";
			}
			$acts = $this->actionLinks( $page['title'], $page['tp:mark'], $page['latest'], 'old' );
			$items[] = "<li>$link ($acts) </li>";
			unset( $pages[$index] );
		}

		if ( count( $items ) ) {
			$wgOut->addWikiMsg( 'tpt-old-pages', count( $items ) );
			$wgOut->addHtml( Html::rawElement( 'ol', null, implode( "\n", $items ) ) );
			$wgOut->addHtml( '<hr />' );
		}

		// Pages which are never marked
		$items = array();
		foreach ( $pages as $index => $page ) {
			if ( isset( $page['tp:mark'] ) || !isset( $page['tp:tag'] ) ) {
				continue;
			}

			/* Ignore pages which have had \<translate> at some point, but which
			 * have never been marked. */
			if ( $page['tp:tag'] !== $page['latest'] ) {
				unset( $pages[$index] );
				continue;
			}

			$link = $this->user->getSkin()->link( $page['title'] );
			$acts = $this->actionLinks( $page['title'], $page['tp:tag'], $page['latest'], 'new' );
			$items[] = "<li>$link ($acts) </li>";

			unset( $pages[$index] );
		}

		if ( count( $items ) ) {
			$wgOut->addWikiMsg( 'tpt-new-pages', count( $items ) );
			$wgOut->addHtml( Html::rawElement( 'ol', null, implode( "\n", $items ) ) );
			$wgOut->addHtml( '<hr />' );
		}

		/* Pages which have been marked in the past, but newest version does
		 * not have a tag */
		$items = array();
		foreach ( $pages as $index => $page ) {
			$link = $this->user->getSkin()->link( $page['title'] );
			$acts = $this->actionLinks( $page['title'], $page['tp:tag'], $page['latest'], 'stuck' );
			$items[] = "<li>$link ($acts) </li>";

			unset( $pages[$index] );
		}

		if ( count( $items ) ) {
			$wgOut->addWikiMsg( 'tpt-other-pages', count( $items ) );
			$wgOut->addHtml( Html::rawElement( 'ol', null, implode( "\n", $items ) ) );
			$wgOut->addHtml( '<hr />' );
		}
	}

	protected function actionLinks( $title, $rev, $latest, $old = 'old' ) {
		$actions = array();

		/* For pages that have been marked for translation at some point,
		 * but there has been new changes since then, provide a link to
		 * to view the differences between last marked version and latest
		 * version of the page.
		 */
		if ( $latest !== $rev && $old !== 'new' ) {
			$actions[] = $this->user->getSkin()->link(
				$title,
				htmlspecialchars( wfMsg( 'tpt-rev-old', $rev ) ),
				array(),
				array( 'oldid' => $rev, 'diff' => $title->getLatestRevId() )
			);
		} else {
			$actions[] = wfMsgHtml( 'tpt-rev-latest' );
		}

		if ( $this->user->isAllowed( 'pagetranslation' ) ) {
			$token = $this->user->editToken();

			if (
				( $old === 'new' && $latest === $rev ) ||
				( $old === 'old' && $latest !== $rev )
			) {
				$actions[] = $this->user->getSkin()->link(
					$this->getTitle(),
					wfMsgHtml( 'tpt-rev-mark-new' ),
					array(),
					array(
						'target' => $title->getPrefixedText(),
						'revision' => $title->getLatestRevId(),
						'token' => $token,
					)
				);
			} elseif ( $old === 'stuck' ) {
				$actions[] = $this->user->getSkin()->link(
					$this->getTitle(),
					wfMsgHtml( 'tpt-rev-unmark' ),
					array(),
					array(
						'target' => $title->getPrefixedText(),
						'revision' => -1,
						'token' => $token,
					)
				);
			}
		}

		if ( $old === 'old' && $this->user->isAllowed( 'translate' ) ) {
			$actions[] = $this->user->getSkin()->link(
				SpecialPage::getTitleFor( 'Translate' ),
				wfMsgHtml( 'tpt-translate-this' ),
				array(),
				array( 'group' => TranslatablePage::getMessageGroupIdFromTitle( $title ) )
			);
		}

		global $wgLang;

		return $wgLang->semicolonList( $actions );
	}

	public function checkInput( TranslatablePage $page, &$error = false ) {
		global $wgOut, $wgRequest;

		$parse = $page->getParse();
		$sections = $parse->getSectionsForSave();
		foreach ( $sections as $s ) {
			// We want to preserve $id, because it is the only thing we can use
			// to link the new names to current sections. Name will become
			// the new id only after it is saved into db and the page.
			// Do not allow changing names for old sections
			$s->name = $s->id;
			if ( $s->type !== 'new' ) {
				continue;
			}

			$name = $wgRequest->getText( 'tpt-sect-' . $s->id, $s->id );

			// Make sure valid title can be constructed
			$sectionTitle = Title::makeTitleSafe(
				NS_TRANSLATIONS,
				$page->getTitle()->getPrefixedText() . '/' . $name . '/foo'
			);

			if ( trim( $name ) === '' || !$sectionTitle ) {
				$wgOut->addWikiMsg( 'tpt-badsect', $name, $s->id );
				$error = true;
			} else {
				// Update the name
				$s->name = $name;
			}
		}

		return $sections;
	}

	/** Displays the sections and changes for the user to review */
	public function showPage( TranslatablePage $page, Array $sections ) {
		global $wgOut;

		$wgOut->setSubtitle( $this->user->getSkin()->link( $page->getTitle() ) );
		TranslateUtils::injectCSS();

		$wgOut->addWikiMsg( 'tpt-showpage-intro' );

		$formParams = array(
			'method' => 'post',
			'action' => $this->getTitle()->getFullURL(),
			'class'  => 'mw-tpt-sp-markform',
		);

		$wgOut->addHTML(
			Xml::openElement( 'form', $formParams ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Html::hidden( 'revision', $page->getRevision() ) .
			Html::hidden( 'target', $page->getTitle()->getPrefixedtext() ) .
			Html::hidden( 'token', $this->user->editToken() )
		);

		$wgOut->wrapWikiMsg( '==$1==', 'tpt-sections-oldnew' );

		foreach ( $sections as $s ) {
			if ( $s->type === 'new' ) {
				$input = Xml::input( 'tpt-sect-' . $s->id, 15, $s->name );
				$name = wfMsgHtml( 'tpt-section-new', $input );
			} else {
				$name = wfMsgHtml( 'tpt-section', htmlspecialchars( $s->name ) );
			}

			if ( $s->type === 'changed' ) {
				$diff = new DifferenceEngine;
				$diff->setText( $s->getOldText(), $s->getText() );
				$text = $diff->getDiff( wfMsgHtml( 'tpt-diff-old' ), wfMsgHtml( 'tpt-diff-new' ) );
				$diff->showDiffStyle();
				$diff->setReducedLineNumbers();

				$id = "tpt-sect-{$s->id}-action-nofuzzy";
				$text = Xml::checkLabel( wfMsg( 'tpt-action-nofuzzy' ), $id, $id, false ) . $text;
			} else {
				$text = TranslateUtils::convertWhiteSpaceToHTML( $s->getText() );
			}

			$wgOut->addHTML( MessageWebImporter::makeSectionElement( $name, $s->type, $text ) );
		}

		$deletedSections = $page->getParse()->getDeletedSections();
		if ( count( $deletedSections ) ) {
			$wgOut->wrapWikiMsg( '==$1==', 'tpt-sections-deleted' );

			foreach ( $deletedSections as $s ) {
				$name = wfMsgHtml( 'tpt-section-deleted', htmlspecialchars( $s->id ) );
				$text = TranslateUtils::convertWhiteSpaceToHTML( $s->getText() );
				$wgOut->addHTML( MessageWebImporter::makeSectionElement( $name, $s->type, $text ) );
			}
		}

		// Display template changes if applicable
		if ( $page->getMarkedTag() !== false ) {
			$newTemplate = $page->getParse()->getTemplatePretty();
			$oldPage = TranslatablePage::newFromRevision( $page->getTitle(), $page->getMarkedTag() );
			$oldTemplate = $oldPage->getParse()->getTemplatePretty();

			if ( $oldTemplate !== $newTemplate ) {
				$wgOut->wrapWikiMsg( '==$1==', 'tpt-sections-template' );

				$diff = new DifferenceEngine;
				$diff->setText( $oldTemplate, $newTemplate );
				$text = $diff->getDiff( wfMsgHtml( 'tpt-diff-old' ), wfMsgHtml( 'tpt-diff-new' ) );
				$diff->showDiffStyle();
				$diff->setReducedLineNumbers();

				$contentParams = array( 'class' => 'mw-tpt-sp-content' );
				$wgOut->addHTML( Xml::tags( 'div', $contentParams, $text ) );
			}
		}

		$wgOut->addHTML(
			Xml::submitButton( wfMsg( 'tpt-submit' ) ) .
			Xml::closeElement( 'form' )
		);
	}

	/**
	 * This function does the heavy duty of marking a page.
	 * - Updates the source page with section markers.
	 * - Updates translate_sections table
	 * - Updates revtags table
	 * - Setups renderjobs to update the translation pages
	 * - Invalidates caches
	 */
	public function markForTranslation( TranslatablePage $page, Array $sections ) {
		global $wgRequest;

		// Add the section markers to the source page
		$article = new Article( $page->getTitle(), 0 );
		$status = $article->doEdit(
			$page->getParse()->getSourcePageText(), // Content
			wfMsgForContent( 'tpt-mark-summary' ),  // Summary
			EDIT_FORCE_BOT | EDIT_UPDATE,           // Flags
			$page->getRevision()                    // Based-on revision
		);

		if ( !$status->isOK() ) {
			self::superDebug( __METHOD__, 'edit-fail', $this->user, $page->getTitle(), $status );
			return array( 'tpt-edit-failed', $status->getWikiText() );
		}

		$newrevision = $status->value['revision'];

		// In theory it is either null or Revision object,
		// never revision object with null id, but who knows
		if ( $newrevision instanceof Revision ) {
			$newrevision = $newrevision->getId();
		}

		if ( $newrevision === null ) {
			// Probably a no-change edit, so no new revision was assigned.
			// Get the latest revision manually
			$newrevision = $page->getTitle()->getLatestRevId();
		}

		self::superDebug( __METHOD__, 'latestrev', $page->getTitle(), $newrevision );

		$inserts = array();
		$changed = array();

		$pageId = $page->getTitle()->getArticleId();
		foreach ( array_values( $sections ) as $index => $s ) {
			if ( $s->type === 'changed' ) {
				// Allow silent changes to avoid fuzzying unnecessary.
				if ( !$wgRequest->getCheck( "tpt-sect-{$s->id}-action-nofuzzy" ) ) {
					$changed[] = $s->name;
				}
			}

			$inserts[] = array(
				'trs_page' => $pageId,
				'trs_key' => $s->name,
				'trs_text' => $s->getText(),
				'trs_order' => $index
			);
		}


		// Don't add stuff if no changes, use the plain null instead for prettiness
		if ( !count( $changed ) ) {
			$changed = null;
		}

		$dbw = wfGetDB( DB_MASTER );
		if ( !$dbw->fieldExists( 'translate_sections', 'trs_order', __METHOD__ ) ) {
			error_log( 'Field trs_order does not exists. Please run update.php.' );
			foreach ( array_keys( $inserts ) as $index ) {
				unset( $inserts[$index]['trs_order'] );
			}
		}
		$dbw->delete( 'translate_sections', array( 'trs_page' => $page->getTitle()->getArticleId() ), __METHOD__ );
		$dbw->insert( 'translate_sections', $inserts, __METHOD__ );

		/* Stores the names of changed sections in the database.
		 * Used for calculating completion percentages for outdated messages */
		$page->addMarkedTag( $newrevision, $changed );
		$this->addFuzzyTags( $page, $changed );

		global $wgUser;
		$logger = new LogPage( 'pagetranslation' );
		$params = array(
			'user' => $wgUser->getName(),
			'revision' => $newrevision,
			'changed' => count( $changed ),
		);
		$logger->addEntry( 'mark', $page->getTitle(), null, array( serialize( $params ) ) );

		$page->getTitle()->invalidateCache();
		$this->setupRenderJobs( $page );

		// Re-generate caches
		$page->getTranslationPercentages( /*re-generate*/ true );
		ArrayMemoryCache::factory( 'groupstats' )->clearGroup( $page->getMessageGroupId() );
		MessageIndexRebuilder::execute();
		return false;
	}

	public function addFuzzyTags( $page, $changed ) {
		if ( !count( $changed ) ) {
			self::superDebug( __METHOD__, 'nochanged', $page->getTitle() );
			return;
		}

		$titles = array();
		$prefix = $page->getTitle()->getPrefixedText();
		$db = wfGetDB( DB_MASTER );

		foreach ( $changed as $c ) {
			$title = Title::makeTitleSafe( NS_TRANSLATIONS, "$prefix/$c" );
			if ( $title ) {
				$titles[] = 'page_title ' . $db->buildLike( $title->getDBkey() . '/', $db->anyString() );
			}
		}

		$titleCond = $db->makeList( $titles, LIST_OR );

		$id = $db->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );

		$fields = array( 'page_id', 'page_latest' );
		$conds = array( 'page_namespace' => NS_TRANSLATIONS, $titleCond );
		$res = $db->select( 'page', $fields, $conds, __METHOD__ );

		$inserts = array();

		foreach ( $res as $r ) {
			$inserts[] = array(
				'rt_page' => $r->page_id,
				'rt_type' => $id,
				'rt_revision' => $r->page_latest,
			);
		}

		if ( count( $inserts ) ) {
			self::superDebug( __METHOD__, 'inserts', $inserts );
			$db->replace( 'revtag', array( 'rt_type_page_revision' ), $inserts, __METHOD__ );
		}
	}

	public function setupRenderJobs( TranslatablePage $page ) {
		$titles = $page->getTranslationPages();
		$jobs = array();

		foreach ( $titles as $t ) {
			self::superDebug( __METHOD__, 'renderjob', $t );
			$jobs[] = RenderJob::newJob( $t );
		}

		if ( count( $jobs ) < 10 ) {
			self::superDebug( __METHOD__, 'renderjob-immediate' );
			foreach ( $jobs as $j ) {
				$j->run();
			}
		} else {
			// Use the job queue
			self::superDebug( __METHOD__, 'renderjob-delayed' );
			Job::batchInsert( $jobs );
		}
	}

	/**
	 * Enhanced version of wfDebug that allows more detailed debugging.
	 * You can pass anything as varags and it will be serialized. Article
	 * and User objects have special handling to only output name and id.
	 * @param $method \string Calling method.
	 * @param $msg \string Debug message.
	 * @todo Move to better place.
	 */
	public static function superDebug( $method, $msg /* varags */ ) {
		$args = func_get_args();
		$args = array_slice( $args, 2 );
		foreach ( $args as &$arg ) {
			if ( $arg instanceof User ) {
				$arg = array( 'user' => $arg->getName(), 'id' => $arg->getId() );
			} elseif ( $arg instanceof Title ) {
				$arg = array( 'title' => $arg->getPrefixedText(), 'aid' => $arg->getArticleID() );
			}
			$arg = serialize( $arg );
		}

		wfDebugLog( 'pagetranslation', "$method: $msg [" . implode( " ", $args ) . "]\n" );
	}
}
