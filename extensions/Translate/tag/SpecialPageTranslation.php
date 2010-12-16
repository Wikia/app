<?php
/**
 * A special page for marking revisions of pages for translation.
 * There are two modes 1) list of all pages 2) review mode for one page.
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2009-2010 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialPageTranslation extends SpecialPage {
	function __construct() {
		SpecialPage::SpecialPage( 'PageTranslation' );
	}

	public function execute( $parameters ) {
		wfLoadExtensionMessages( 'PageTranslation' );
		$this->setHeaders();

		global $wgRequest, $wgOut, $wgUser;
		$this->user = $wgUser;

		$target = $wgRequest->getText( 'target', $parameters );
		$revision = $wgRequest->getText( 'revision', 0 );

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

		// We are processing some specific page
		if ( $revision === '0' ) {
			// Get the latest revision
			$revision = $title->getLatestRevID();
		} elseif ( $revision !== $title->getLatestRevID() ) {
			// We do want to notify the reviewer if the underlying page changes during review
			$wgOut->addWikiMsg( 'tpt-oldrevision', $title->getPrefixedText(), $revision );
			$this->listPages();
			return;
		}

		$page = TranslatablePage::newFromRevision( $title, $revision );

		if ( !$page instanceof TranslatablePage ) {
			$wgOut->addWikiMsg( 'tpt-notsuitable', $title->getPrefixedText(), $revision );
			$this->listPages();
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
		$this->showPage( $page, $sections );
	}

	public function showSuccess( TranslatablePage $page ) {
		global $wgOut, $wgLang;

		$titleText = $page->getTitle()->getPrefixedText();
		$num = $wgLang->formatNum( $page->getParse()->countSections() );
		$link = SpecialPage::getTitleFor( 'Translate' )->getFullUrl(
			array( 'group' => 'page|' . $page->getTitle()->getPrefixedText() ) );
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

		$old = $new = array();
		foreach ( $res as $r ) {
			if ( $r->rtt_name === 'tp:mark' ) {
				$old[$r->page_id] = array(
					$r->rt_revision,
					Title::newFromRow( $r )
				);
			} elseif ( $r->rtt_name === 'tp:tag' ) {
				$new[$r->page_id] = array(
					$r->rt_revision,
					Title::newFromRow( $r )
				);
			}
		}

		// Pages may have both tags, ignore the transtag if both
		foreach ( array_keys( $old ) as $k ) unset( $new[$k] );

		if ( count( $old ) ) {
			$wgOut->addWikiMsg( 'tpt-old-pages', count( $old ) );
			$wgOut->addHTML( '<ol>' );
			foreach ( $old as $o ) {
				list( $rev, $title ) = $o;
				$link = $this->user->getSkin()->link( $title );
				$acts = $this->actionLinks( $title, $rev, 'old' );
				$wgOut->addHTML( "<li>$link ($acts) </li>" );
			}
			$wgOut->addHTML( '</ol>' );
		}

		if ( count( $new ) ) {
			$wgOut->addWikiMsg( 'tpt-new-pages', count( $new ) );
			$wgOut->addHTML( '<ol>' );
			foreach ( $new as $n ) {
				list( $rev, $title ) = $n;
				$link = $this->user->getSkin()->link( $title );
				$acts = $this->actionLinks( $title, $rev, 'new' );
				$wgOut->addHTML( "<li>$link ($acts) </li>" );
			}
			$wgOut->addHTML( '</ol>' );
		}

	}

	protected function actionLinks( $title, $rev, $old = 'old' ) {
		$actions = array();
		$latest = $title->getLatestRevId();

		if ( $latest !== $rev ) {
			$text = wfMsg( 'tpt-rev-old', $rev );
			$actions[] = $this->user->getSkin()->link(
				$title,
				htmlspecialchars( $text ),
				array(),
				array( 'oldid' => $rev, 'diff' => $title->getLatestRevId() )
			);
		} else {
			$actions[] = wfMsgHtml( 'tpt-rev-latest' );
		}

		if ( $this->user->isAllowed( 'pagetranslation' ) &&
			 ( ( $old === 'new' && $latest === $rev ) ||
		     ( $old === 'old' && $latest !== $rev ) ) ) {
			$actions[] = $this->user->getSkin()->link(
				$this->getTitle(),
				wfMsgHtml( 'tpt-rev-mark-new' ),
				array(),
				array(
					'target' => $title->getPrefixedText(),
					'revision' => $title->getLatestRevId()
				)
			);
		}

		if ( $old === 'old' && $this->user->isAllowed( 'translate' ) ) {
			$actions[] = $this->user->getSkin()->link(
				SpecialPage::getTitleFor( 'Translate' ),
				wfMsgHtml( 'tpt-translate-this' ),
				array(),
				array( 'group' => 'page|' . $title->getPrefixedText() )
			);
		}

		global $wgLang;
		if ( method_exists( $wgLang, 'semicolonList' ) ) {
			// BC for <1.15
			$actionText = $wgLang->semicolonList( $actions );
		} else {
			$actionText = implode( '; ', $actions );
		}
		return $actionText;
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
			if ( $s->type !== 'new' ) continue;

			$name = $wgRequest->getText( 'tpt-sect-' . $s->id, $s->id );

			$sectionTitle = Title::makeTitleSafe(
				NS_TRANSLATIONS,
				$page->getTitle()->getPrefixedText() . '/' . $name . '/qqq'
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
		global $wgOut, $wgScript, $wgLang;

		$wgOut->setSubtitle( $this->user->getSkin()->link( $page->getTitle() ) );
		TranslateUtils::injectCSS();

		$wgOut->addWikiMsg( 'tpt-showpage-intro' );

		$formParams = array(
			'method' => 'post',
			'action' => $this->getTitle()->getFullURL(),
			'class'  => 'mw-tpt-sp-markform'
		);

		$wgOut->addHTML(
			Xml::openElement( 'form', $formParams ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'revision', $page->getRevision() ) .
			Xml::hidden( 'target', $page->getTitle()->getPrefixedtext() )
		);

		$wgOut->wrapWikiMsg( '==$1==', 'tpt-sections-oldnew' );

		foreach ( $sections as $s ) {
			if ( $s->type === 'new' ) {
				$input = Xml::input( 'tpt-sect-' . $s->id, 10, $s->name );
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

		// Add the section markers to the source page
		$article = new Article( $page->getTitle() );
		$status = $article->doEdit(
			$page->getParse()->getSourcePageText(), // Content
			wfMsgForContent( 'tpt-mark-summary' ),  // Summary
			EDIT_FORCE_BOT | EDIT_UPDATE,           // Flags
			$page->getRevision()                    // Based-on revision
		);

		if ( !$status->isOK() ) return array( 'tpt-edit-failed', $status->getWikiText() );

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

		$inserts = array();
		$changed = array();
		foreach ( $sections as $s ) {
			if ( $s->type === 'changed' ) $changed[] = $s->name;
			$inserts[] = array(
				'trs_page' => $page->getTitle()->getArticleId(),
				'trs_key' => $s->name,
				'trs_text' => $s->getText(),
			);
		}

		// Don't add stuff is no changes, use the plain null instead for prettiness
		if ( !count( $changed ) ) $changed = null;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'translate_sections', array( 'trs_page' => $page->getTitle()->getArticleId() ), __METHOD__ );
		$ok = $dbw->insert( 'translate_sections', $inserts, __METHOD__ );

		// Store changed sections in the database for easy access.
		// Used when determinen the up-to-datedness for section translations.
		$page->addMarkedTag( $newrevision, $changed );
		$this->addFuzzyTags( $page, $changed );

		$this->setupRenderJobs( $page );

		// Re-generate caches
		MessageIndexRebuilder::execute();
		$page->getTranslationPercentages( /*re-generate*/ true );

		return false;
	}

	public function addFuzzyTags( $page, $changed ) {
		if ( !count( $changed ) ) return;
		$titles = array();
		$prefix = $page->getTitle()->getPrefixedText();
		$db = wfGetDB( DB_MASTER );
		foreach ( $changed as $c ) {
			$title = Title::makeTitleSafe( NS_TRANSLATIONS, "$prefix/$c" );
			if ( $title ) {
				$titles[] = 'page_title like \'' . $db->escapeLike( $title->getDBkey() ) . '/%\'';
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
			$db->replace( 'revtag', array( 'rt_type_page_revision' ), $inserts, __METHOD__ );
		}
	}

	public function setupRenderJobs( TranslatablePage $page ) {
		$titles = $page->getTranslationPages();
		$jobs = array();
		foreach ( $titles as $t ) {
			$jobs[] = RenderJob::newJob( $t );
		}

		if ( count( $jobs ) < 10 ) {
			foreach ( $jobs as $j ) $j->run();
		} else {
			// Use the job queue
			Job::batchInsert( $jobs );
		}
	}

}
