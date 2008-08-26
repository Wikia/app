<?php

/**
 * Special page class for the Duplicator extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class SpecialDuplicator extends SpecialPage {

	/**
	 * Title of the page we are duplicating
	 */
	private $source = '';
	private $sourceTitle = NULL;

	/**
	 * Title of the page we are saving to
	 */
	private $dest = '';
	private $destTitle = NULL;

	/**
	 * Whether or not we're duplicating the talk page
	 */
	private $talk = true;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Duplicator' );
	}

	/**
	 * Main execution function
	 *
	 * @param $title Title passed to the page
	 */
	public function execute( $title ) {
		global $wgUser, $wgOut, $wgRequest, $wgLang, $wgDuplicatorRevisionLimit;
		wfLoadExtensionMessages( 'Duplicator' );
		$this->setHeaders();

		# Check permissions
		if( !$wgUser->isAllowed( 'duplicate' ) ) {
			$wgOut->permissionRequired( 'duplicate' );
			return;
		}

		# Check for database lock
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->setOptions( $wgRequest, $title );
		$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-header' ) );
		$wgOut->addHtml( $this->buildForm() );

		# If the token doesn't match or the form wasn't POSTed, stop
		if( !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ), 'duplicator' ) )
			return;

		# Check we've got a valid source title
		if( is_object( $this->sourceTitle ) ) {
			# Check the source exists
			if( $this->sourceTitle->exists() ) {
				# Check we've got a valid destination title
				if( is_object( $this->destTitle ) ) {
					# Check the destination *does not* exist
					if( !$this->destTitle->exists() ) {
						# Check there aren't a hideous number of revisions
						$dbr =& wfGetDB( DB_SLAVE );
						$num = $dbr->selectField( 'revision', 'COUNT(*)', array( 'rev_page' => $this->sourceTitle->getArticleId() ), __METHOD__ );
						if( $num <= $wgDuplicatorRevisionLimit ) {
							# Attempt to perform the main duplicate op. first
							if( $this->duplicate( $this->sourceTitle, $this->destTitle ) ) {
								$success  = wfMsgNoTrans( 'duplicator-success', $this->sourceTitle->getPrefixedText(), $this->destTitle->getPrefixedText() ) . "\n\n";
								$success .= '* ' . wfMsgNoTrans( 'duplicator-success-revisions', $wgLang->formatNum( $num ) ) . "\n";
								# If there is a talk page and we've been asked to duplicate it, do so
								if( $this->dealWithTalk() && $this->talk ) {
									if( $this->duplicate( $this->sourceTitle->getTalkPage(), $this->destTitle->getTalkPage() ) ) {
										$success .= '* ' . wfMsgNoTrans( 'duplicator-success-talkcopied' ) . "\n";
									} else {
										$success .= '* ' . wfMsgNoTrans( 'duplicator-success-talknotcopied' ) . "\n";
									}
								}
								# Report success to the user
								$wgOut->addWikiText( $success );
							} else {
								# Something went wrong, abort the entire operation
								$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-failed' ) );
							}
						} else {
							# Revision count exceeds limit
							$limit = $wgLang->formatNum( $wgDuplicatorRevisionLimit );
							$actual = $wgLang->formatNum( $num );
							$message = wfMsgNoTrans( 'duplicator-toomanyrevisions', $this->sourceTitle->getPrefixedText(), $actual, $limit );
							$wgOut->addWikiText( $message );
						}
					} else {
						# Destination exists
						$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-dest-exists', $this->destTitle->getPrefixedText() ) );
					}
				} else {
					# Invalid destination title
					$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-dest-invalid' ) );
				}
			} else {
				# Source doesn't exist
				$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-source-notexist', $this->source ) );
			}
		} else {
			# Invalid source title
			$wgOut->addWikiText( wfMsgNoTrans( 'duplicator-source-invalid' ) );
		}

	}

	/**
	 * Determine various options and attempt initialisation of objects
	 *
	 * @param $request WebRequest we're running off
	 * @param $title Title passed to the page
	 */
	private function setOptions( &$request, $title ) {
		$source = $request->getText( 'source' );
		$this->source = $source ? $source : ( $title ? $title : '' );
		$this->sourceTitle = Title::newFromUrl( $this->source );
		$this->dest = $request->getText( 'dest', '' );
		$this->destTitle = Title::newFromUrl( $this->dest );
		$this->talk = $request->getCheck( 'talk' );
	}

	/**
	 * Should we allow the user to see the talk page option?
	 * Don't bother if there is no talk page, or we're duplicating one
	 *
	 * @return bool
	 */
	private function dealWithTalk() {
		if( is_object( $this->sourceTitle ) ) {
			if( $this->sourceTitle->isTalkPage() )
				return false;
			$talk = $this->sourceTitle->getTalkPage();
			return $talk->exists();
		} else {
			# We can't determine, but it doesn't matter; either the user
			# hasn't hit the submit button, or we'll be throwing up a bad title error
			return true;
		}
	}

	/**
	 * Build a form for entering the source and destination titles
	 *
	 * @return string
	 */
	private function buildForm() {
		global $wgUser;
		$self = SpecialPage::getTitleFor( 'Duplicator' );
		$source = is_object( $this->sourceTitle ) ? $this->sourceTitle->getPrefixedText() : $this->source;
		$dest = is_object( $this->destTitle ) ? $this->destTitle->getPrefixedText() : $this->dest;
		$form  = '<form method="post" action="' . $self->getLocalUrl() . '">';
		$form .= '<fieldset><legend>' . wfMsgHtml( 'duplicator-options' ) . '</legend>';
		$form .= '<table>';
		$form .= '<tr>';
		$form .= '<td><label for="source">' . wfMsgHtml( 'duplicator-source' ) . '</label></td>';
		$form .= '<td>' . Xml::input( 'source', 40, $source, array( 'id' => 'source' ) ) . '</td>';
		$form .= '</tr><tr>';
		$form .= '<td><label for="dest">' . wfMsgHtml( 'duplicator-dest' ) . '</label></td>';
		$form .= '<td>' . Xml::input( 'dest', 40, $dest, array( 'id' => 'dest' ) ) . '</td>';
		$form .= '</tr><tr>';
		$form .= '<td>&nbsp;</td>';
		$form .= '<td>' . Xml::checkLabel( wfMsg( 'duplicator-dotalk' ), 'talk', 'talk', $this->talk ) . '</td>';
		$form .= '</tr><tr>';
		$form .= '<td>&nbsp;</td>';
		$form .= '<td>' . Xml::submitButton( wfMsg( 'duplicator-submit' ) ) . '</td>';
		$form .= '</tr>';
		$form .= '</table>';
		$form .= Xml::hidden( 'token', $wgUser->editToken( 'duplicator' ) );
		$form .= '</fieldset></form>';
		return $form;
	}

	/**
	 * Duplicate one page to another, including full histories
	 * Does some basic error-catching, but not as much as the code above [should]
	 *
	 * @param $source Title to duplicate
	 * @param $dest Title to save to
	 * @return bool
	 */
	private function duplicate( &$source, &$dest ) {
		global $wgUser, $wgBot;
		if( !$source->exists() || $dest->exists() )
			return false; # Source doesn't exist, or destination does
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->begin();
		$sid = $source->getArticleId();
		# Create an article representing the destination page and save it
		$destArticle = new Article( $dest );
		$aid = $destArticle->insertOn( $dbw );
		# Perform the revision duplication
		# An INSERT...SELECT here seems to fuck things up
		$res = $dbw->select( 'revision', '*', array( 'rev_page' => $sid ), __METHOD__ );
		if( $res && $dbw->numRows( $res ) > 0 ) {
			while( $row = $dbw->fetchObject( $res ) ) {
				$values['rev_page'] = $aid;
				$values['rev_text_id'] = $row->rev_text_id;
				$values['rev_comment'] = $row->rev_comment;
				$values['rev_user'] = $row->rev_user;
				$values['rev_user_text'] = $row->rev_user_text;
				$values['rev_timestamp'] = $row->rev_timestamp;
				$values['rev_minor_edit'] = $row->rev_minor_edit;
				$values['rev_deleted'] = $row->rev_deleted;
				$dbw->insert( 'revision', $values, __METHOD__ );
			}
			$dbw->freeResult( $res );
		}
		# Update page record
		$latest = $dbw->selectField( 'revision', 'MAX(rev_id)', array( 'rev_page' => $aid ), __METHOD__ );
		$rev = Revision::newFromId( $latest );
		$destArticle->updateRevisionOn( $dbw, $rev );
		# Commit transaction
		$dbw->commit();
		# Create a null revision with an explanation; do cache clearances, etc.
		$dbw->begin();
		$comment = wfMsgForContent( 'duplicator-summary', $source->getPrefixedText() );
		$nr = Revision::newNullRevision( $dbw, $aid, $comment, true );
		$nid = $nr->insertOn( $dbw );
		$destArticle->updateRevisionOn( $dbw, $nr );
		$destArticle->createUpdates( $nr );
		Article::onArticleCreate( $dest );
		$bot = $wgUser->isAllowed( 'bot' );
		RecentChange::notifyNew( $nr->getTimestamp(), $dest, true, $wgUser, $comment, $bot );
		$dest->invalidateCache();
		$dbw->commit();
		return true;
	}
}
