<?php

/**
 * Contest interface for judges.
 *
 * @since 0.1
 *
 * @file SpecialContest.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialContestant extends SpecialContestPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Contestant', 'contestjudge', false );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		if ( !parent::execute( $subPage ) ) {
			return;
		}

		/**
		 * @var $contestant ContestContestant
		 */
		$contestant = ContestContestant::s()->selectRow( 'id', array( 'id' => (int)$subPage ) );

		if ( $contestant === false ) {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'Contests' )->getLocalURL() );
		}
		else {
			if ( $this->getRequest()->wasPosted()
				&& $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) )
			{
				$this->handleSubmission( $contestant->getId() );
			}

			if ( $this->getRequest()->wasPosted() ) {
				ContestContestant::s()->setReadDb( DB_MASTER );
			}
			
			$contestant->loadFields();
			ContestContestant::s()->setReadDb( DB_SLAVE );
			
			$this->showPage( $contestant );
		}
	}

	/**
	 * Handle a submission by inserting/updating the vote
	 * and (optionally) adding the comment.
	 *
	 * @since 0.1
	 *
	 * @param integer $contestantId
	 *
	 * @return boolean Success indicator
	 */
	protected function handleSubmission( $contestantId ) {
		$success = true;

		if ( trim( $this->getRequest()->getText( 'new-comment-text' ) ) !== '' ) {
			$comment = new ContestComment( array(
				'user_id' => $this->getUser()->getId(),
				'contestant_id' => $contestantId,

				'text' => $this->getRequest()->getText( 'new-comment-text' ),
				'time' => wfTimestampNow()
			) );

			$success = $comment->writeToDB();

			if ( $success ) {
				ContestContestant::s()->addToField( 'comments', 1 );
			}
		}

		if ( $success && !is_null( $this->getRequest()->getVal( 'contestant-rating' ) ) ) {
			$attribs = array(
				'value' => $this->getRequest()->getInt( 'contestant-rating' ),
				'contestant_id' => $contestantId,
				'user_id' => $this->getUser()->getId()
			);

			if ( !is_null( $this->getRequest()->getVal( 'contestant-vote-id' ) ) ) {
				$attribs['id'] = $this->getRequest()->getInt( 'contestant-vote-id' );
			}

			$vote = new ContestVote( $attribs );
			$success = $vote->writeToDB() && $success;
		}

		return $success;
	}

	/**
	 * Show the actual page, conisting of the navigation, the summary and
	 * the rating and voting controls.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 */
	protected function showPage( ContestContestant $contestant ) {
		$out = $this->getOutput();

		$out->setPageTitle( wfMsgExt(
			'contest-contestant-title',
			'parseinline',
			$contestant->getField( 'id' ),
			$contestant->getContest()->getField( 'name' )
		) );

		$this->displayNavigation( str_replace( ' ', '_', $contestant->getContest()->getField( 'name' ) ) );

		$this->showGeneralInfo( $contestant );

		$action = SpecialPage::getTitleFor( 'Contestant', $contestant->getField( 'id' )  );
		$out->addHTML( '<form method="post" action="' . $action->getLocalURL() . '">' );
		$out->addHTML( Html::hidden( 'title', $this->getTitle( $this->subPage )->getPrefixedDBkey() ) );
		$out->addHTML( Html::hidden( 'wpEditToken', $this->getUser()->editToken() ) );

		$this->showRating( $contestant );
		$this->showComments( $contestant );

		$out->addHTML( '</form>' );

		$out->addModules( 'contest.special.contestant' );
	}

	/**
	 * Display the general contestant info.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 */
	protected function showGeneralInfo( ContestContestant $contestant ) {
		$out = $this->getOutput();

		$out->addHTML( Html::openElement( 'table', array( 'class' => 'wikitable contestant-summary' ) ) );

		foreach ( $this->getSummaryData( $contestant ) as $stat => $value ) {
			$out->addHTML( '<tr>' );

			$out->addHTML( Html::element(
				'th',
				array( 'class' => 'contestant-summary-name' ),
				wfMsg( 'contest-contestant-header-' . $stat )
			) );

			$out->addHTML( Html::rawElement(
				'td',
				array( 'class' => 'contestant-summary-value' ),
				$value
			) );

			$out->addHTML( '</tr>' );
		}

		$out->addHTML( Html::closeElement( 'table' ) );
	}

	/**
	 * Gets the summary data.
	 * Values are escaped.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 *
	 * @return array
	 */
	protected function getSummaryData( ContestContestant $contestant ) {
		$stats = array();

		$stats['id'] = htmlspecialchars( $contestant->getField( 'id' ) );
		$stats['contest'] = htmlspecialchars( $contestant->getContest()->getField( 'name' ) );

		$challengeTitles = ContestChallenge::getTitlesForIds( $contestant->getField( 'challenge_id' ) );
		$stats['challenge'] = htmlspecialchars( $challengeTitles[$contestant->getField( 'challenge_id' )] );

		if ( $contestant->getField( 'submission' ) === '' ) {
			$stats['submission'] = htmlspecialchars( wfMsg( 'contest-contestant-notsubmitted' ) );
		}
		else {
			$stats['submission'] = Html::element(
				'a',
				array( 'href' => $contestant->getField( 'submission'  ) ),
				$contestant->getField( 'submission'  )
			);
		}

		$countries = ContestContestant::getCountries();
		$stats['country'] = htmlspecialchars( $countries[$contestant->getField( 'country' )] );

		$stats['wmf'] = htmlspecialchars( wfMsg( 'contest-contestant-' . ( $contestant->getField( 'wmf' ) ? 'yes' : 'no' ) ) );
		$stats['volunteer'] = htmlspecialchars( wfMsg( 'contest-contestant-' . ( $contestant->getField( 'volunteer' ) ? 'yes' : 'no' ) ) );

		$stats['rating'] = htmlspecialchars( wfMsgExt(
			'contest-contestant-rating',
			'parsemag',
			$this->getLanguage()->formatNum( $contestant->getField( 'rating' ) / 100 ),
			$this->getLanguage()->formatNum( $contestant->getField( 'rating_count' ) )
		) );

		$stats['comments'] = htmlspecialchars( $this->getLanguage()->formatNum( $contestant->getField( 'comments' ) ) );

		return $stats;
	}

	/**
	 * Display the current rating the judge gave if any and a control to
	 * (re)-rate.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 */
	protected function showRating( ContestContestant $contestant ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'contest-contestant-rate' ) ) );

		$vote = ContestVote::s()->selectRow(
			array( 'value', 'id' ),
			array( 'user_id' => $this->getUser()->getId(), 'contestant_id' => $contestant->getId() )
		);

		if ( $vote === false ) {
			$message = wfMsg( 'contest-contestant-not-voted' );
		}
		else {
			$message = wfMsgExt(
				'contest-contestant-voted',
				'parsemag',
				$this->getLanguage()->formatNum( $vote->getField( 'value' ) )
			);

			$out->addHTML( Html::hidden( 'contestant-vote-id', $vote->getId() ) );
		}

		$out->addHTML( Html::element( 'p', array(), $message ) );

		foreach ( ContestSettings::get( 'voteValues' ) as $value ) {
			$attribs = array(
				'type' => 'radio',
				'value' => $value,
				'name' => 'contestant-rating',
				'id' => 'contestant-rating-' . $value
			);

			if ( $vote !== false && $value == $vote->getField( 'value' ) ) {
				$attribs['checked'] = 'checked';
			}

			$out->addHTML(
				Html::element(
					'input',
					$attribs
				) .
				Html::element(
					'label',
					array( 'for' => 'contestant-rating-' . $value ),
					$this->getLanguage()->formatNum( $value )
				)
			);
		}

	}

	/**
	 * Show the comments and a control to add additional ones.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 */
	protected function showComments( ContestContestant $contestant ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'contest-contestant-comments' ) ) );

		$out->addHTML( '<div class="contestant-comments">' );

		if ( $this->getRequest()->wasPosted() ) {
			ContestComment::s()->setReadDb( DB_MASTER );
		}
		
		$comments = $contestant->getComments();
		ContestComment::s()->setReadDb( DB_SLAVE );
		
		foreach ( $comments as /* ContestComment */ $comment ) {
			$out->addHTML( $this->getCommentHTML( $comment ) );
		}

		$out->addHTML( '</div>' );

		$out->addHTML(
			'<div class="contestant-new-comment">
				<textarea cols="40" rows="10" name="new-comment-text"></textarea>
			</div>'
		);

		$out->addHTML( Html::input( 'submitChanges', wfMsg( 'contest-contestant-submit' ), 'submit' ) );
	}

	/**
	 * Get the HTML for a single comment.
	 *
	 * @since 0.1
	 *
	 * @param ContestComment $comment
	 *
	 * @return string
	 */
	protected function getCommentHTML( ContestComment $comment ) {
		$user = User::newFromId( $comment->getField( 'user_id' ) );

		$htmlId = 'c' . $comment->getId();

		$html = Html::rawElement(
			'div',
			array( 'class' => 'contestant-comment-meta' ),
			Html::element(
				'a',
				array(
					'href' => $this->getTitle( $this->subPage )->getLocalURL() . "#$htmlId",
					'title' => wfMsg( 'contest-contestant-permalink' )
				),
				'#'
			) .
			wfMsgHtml(
				'contest-contestant-comment-by',
				Linker::userLink( $comment->getField( 'user_id' ), $user->getName() ) .
					Linker::userToolLinks( $comment->getField( 'user_id' ), $user->getName() )
			) . '&#160;&#160;&#160;' . htmlspecialchars( $this->getLanguage()->timeanddate( $comment->getField( 'time' ), true ) )
		);

		$html .= Html::rawElement(
			'div',
			array( 'class' => 'contestant-comment-text mw-content-' . $this->getLanguage()->getDir() . '' ),
			$this->getOutput()->parse( $comment->getField( 'text' ) )
		);

		return Html::rawElement(
			'div',
			array(
				'class' => 'contestant-comment',
				'id' => $htmlId
			),
			$html
		);
	}

}
