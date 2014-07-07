<?php
/**
 * Reject confirmation review form UI
 */
class RejectConfirmationFormUI {
	protected $form, $oldRev, $newRev;

	public function __construct( RevisionReviewForm $form ) {
		$this->form = $form;
		$this->newRev = Revision::newFromTitle( $form->getPage(), $form->getOldId() );
		$this->oldRev = Revision::newFromTitle( $form->getPage(), $form->getRefId() );
	}

	/**
	 * Get the "are you sure you want to reject these changes?" form
	 * @return array (html string, error string or true)
	 */
	public function getHtml() {
		global $wgLang, $wgContLang;
		$status = $this->form->checkTarget();
		if ( $status !== true ) {
			return array( '', $status ); // not a reviewable existing page
		}
		$oldRev = $this->oldRev; // convenience
		$newRev = $this->newRev; // convenience
		# Do not mess with archived/deleted revisions
		if ( !$oldRev || $newRev->isDeleted( Revision::DELETED_TEXT ) ) {
			return array( '', 'review_bad_oldid' );
		} elseif ( !$newRev || $newRev->isDeleted( Revision::DELETED_TEXT ) ) {
			return array( '', 'review_bad_oldid' );
		}

		$form = '<div class="plainlinks">';

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'revision',
			Revision::selectFields(),
			array(
				'rev_page' => $oldRev->getPage(),
				'rev_timestamp > ' . $dbr->addQuotes(
					$dbr->timestamp( $oldRev->getTimestamp() ) ),
				'rev_timestamp <= ' . $dbr->addQuotes(
					$dbr->timestamp( $newRev->getTimestamp() ) )
			),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 251 ) // sanity check
		);
		if ( !$dbr->numRows( $res ) ) {
			return array( '', 'review_bad_oldid' );
		} elseif ( $dbr->numRows( $res ) > 250 ) {
			return array( '', 'review_reject_excessive' );
		}

		$contribs = SpecialPage::getTitleFor( 'Contributions' )->getPrefixedText();

		$lastTextId = 0;
		$rejectIds = $rejectAuthors = array();
		foreach ( $res as $row ) {
			$rev = new Revision( $row );
			if ( $rev->getTextId() != $lastTextId ) { // skip null edits
				$rejectIds[] = $rev->getId();
				$rejectAuthors[] = $rev->isDeleted( Revision::DELETED_USER )
					? wfMsg( 'rev-deleted-user' )
					: "[[{$contribs}/{$rev->getUserText()}|{$rev->getUserText()}]]";
			}
			$lastTextId = $rev->getTextId();
		}
		$rejectAuthors = array_values( array_unique( $rejectAuthors ) );

		if ( !$rejectIds ) { // all null edits? (this shouldn't happen)
			return array( '', 'review_reject_nulledits' );
		}

		// List of revisions being undone...
		$form .= wfMsgExt( 'revreview-reject-text-list', 'parseinline',
			$wgLang->formatNum( count( $rejectIds ) ), $oldRev->getTitle()->getPrefixedText() );
		$form .= '<ul>';

		$list = new RevisionList( RequestContext::getMain(), $oldRev->getTitle() );
		$list->filterByIds( $rejectIds );

		for ( $list->reset(); $list->current(); $list->next() ) {
			$item = $list->current();
			if ( $item->canView() ) {
				$form .= $item->getHTML();
			}
		}
		$form .= '</ul>';
		if ( $newRev->isCurrent() ) {
			// Revision this will revert to (when reverting the top X revs)...
			$form .= wfMsgExt( 'revreview-reject-text-revto', 'parseinline',
				$oldRev->getTitle()->getPrefixedDBKey(), $oldRev->getId(),
				$wgLang->timeanddate( $oldRev->getTimestamp(), true )
			);
		}

		$comment = $this->form->getComment(); // convenience
		// Determine the default edit summary...
		$oldRevAuthor = $oldRev->isDeleted( Revision::DELETED_USER )
			? wfMsg( 'rev-deleted-user' )
			: $oldRev->getUserText();
		// NOTE: *-cur msg wording not safe for (unlikely) edit auto-merge
		$msg = $newRev->isCurrent()
			? 'revreview-reject-summary-cur' 
			: 'revreview-reject-summary-old';
		$defaultSummary = wfMsgExt( $msg, array( 'parsemag', 'content' ),
			$wgContLang->formatNum( count( $rejectIds ) ),
			$wgContLang->listToText( $rejectAuthors ),
			$oldRev->getId(),
			$oldRevAuthor );
		// If the message is too big, then fallback to the shorter one
		$colonSeparator = wfMsgForContent( 'colon-separator' );
		$maxLen = 255 - count( $colonSeparator ) - count( $comment );
		if ( strlen( $defaultSummary ) > $maxLen ) {
			$msg = $newRev->isCurrent()
				? 'revreview-reject-summary-cur-short' 
				: 'revreview-reject-summary-old-short';
			$defaultSummary = wfMsgExt( $msg, array( 'parsemag', 'content' ),
				$wgContLang->formatNum( count( $rejectIds ) ),
				$oldRev->getId(),
				$oldRevAuthor );
		}
		// Append any review comment...
		if ( $comment != '' ) {
			if ( $defaultSummary != '' ) {
				$defaultSummary .= $colonSeparator;
			}
			$defaultSummary .= $comment;
		}

		$form .= '</div>';

		$skin = $this->form->getUser()->getSkin();
		$reviewTitle = SpecialPage::getTitleFor( 'RevisionReview' );
		$form .= Xml::openElement( 'form',
			array( 'method' => 'POST', 'action' => $reviewTitle->getFullUrl() ) );
		$form .= Html::hidden( 'action', 'reject' );
		$form .= Html::hidden( 'wpReject', 1 );
		$form .= Html::hidden( 'wpRejectConfirm', 1 );
		$form .= Html::hidden( 'oldid', $this->form->getOldId() );
		$form .= Html::hidden( 'refid', $this->form->getRefId() );
		$form .= Html::hidden( 'target', $oldRev->getTitle()->getPrefixedDBKey() );
		$form .= Html::hidden( 'wpEditToken', $this->form->getUser()->editToken() );
		$form .= Html::hidden( 'changetime', $newRev->getTimestamp() );
		$form .= Xml::inputLabel( wfMsg( 'revreview-reject-summary' ), 'wpReason',
			'wpReason', 120, $defaultSummary, array( 'maxlength' => 200 ) ) . "<br />";
		$form .= Html::input( 'wpSubmit', wfMsg( 'revreview-reject-confirm' ), 'submit' );
		$form .= ' ';
		$form .= $skin->link( $this->form->getPage(), wfMsg( 'revreview-reject-cancel' ),
			array( 'onClick' => 'history.back(); return history.length <= 1;' ),
			array( 'oldid' => $this->form->getRefId(), 'diff' => $this->form->getOldId() ) );
		$form .= Xml::closeElement( 'form' );

		return array( $form, true );
	}
}
