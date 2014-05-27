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
class SpecialContest extends SpecialContestPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Contest', 'contestjudge', false );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		$subPage = str_replace( '_', ' ', $subPage );

		$subPage = explode( '/', $subPage, 2 );
		$challengeTitle = count( $subPage ) > 1 ? $subPage[1] : false;

		$subPage = $subPage[0];

		if ( !parent::execute( $subPage ) ) {
			return;
		}

		$out = $this->getOutput();

		/**
		 * @var $contest Contest
		 */
		$contest = Contest::s()->selectRow( null, array( 'name' => $subPage ) );

		if ( $contest === false ) {
			$out->redirect( SpecialPage::getTitleFor( 'Contests' )->getLocalURL() );
		}
		else {
			$out->setPageTitle( wfMsgExt( 'contest-contest-title', 'parseinline', $contest->getField( 'name' ) ) );

			$this->displayNavigation();
			$this->showGeneralInfo( $contest );

			if ( $this->getUser()->isAllowed( 'contestadmin' ) ) {
				$this->showMailFunctionality( $contest );
			}

			$out->addHTML( Html::element( 'h3', array(), wfMsg( 'contest-contest-contestants' ) ) );

			$this->addFilterOptionsToSession();
			$this->showFilterControl( $contest, $challengeTitle );
			$this->showContestants( $contest, $challengeTitle );

			$out->addModules( 'contest.special.contest' );
		}
	}

	/**
	 * Display the general contest info.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showGeneralInfo( Contest $contest ) {
		$out = $this->getOutput();

		$out->addHTML( Html::openElement( 'table', array( 'class' => 'wikitable contest-summary' ) ) );

		foreach ( $this->getSummaryData( $contest ) as $stat => $value ) {
			$out->addHTML( '<tr>' );

			$out->addHTML( Html::element(
				'th',
				array( 'class' => 'contest-summary-name' ),
				wfMsg( 'contest-contest-' . $stat )
			) );

			$out->addHTML( Html::element(
				'td',
				array( 'class' => 'contest-summary-value' ),
				$value
			) );

			$out->addHTML( '</tr>' );
		}

		$out->addHTML( Html::closeElement( 'table' ) );
	}

	/**
	 * Gets the summary data.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 *
	 * @return array
	 */
	protected function getSummaryData( Contest $contest ) {
		$stats = array();

		$stats['name'] = $contest->getField( 'name' );
		$stats['status'] = Contest::getStatusMessage( $contest->getStatus() );
		$stats['submissioncount'] = $this->getLanguage()->formatNum( $contest->getField( 'submission_count' ) );

		$stats['end'] = wfMsgExt(
			$contest->getDaysLeft() < 0 ? 'contest-contest-days-ago' : 'contest-contest-days-left',
			'parsemag',
			$this->getLanguage()->timeanddate( $contest->getField( 'end' ), true ),
			$this->getLanguage()->formatNum( abs( $contest->getDaysLeft() ) )
		);

		return $stats;
	}

	/**
	 *
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showMailFunctionality( Contest $contest ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h3', array(), wfMsg( 'contest-contest-reminder-mail' ) ) );

		$out->addWikiMsg( 'contest-contest-reminder-page', $contest->getField( 'reminder_email' ) );

		$out->addHTML( Html::element(
			'button',
			array(
				'id' => 'send-reminder',
				'data-token' => $this->getUser()->editToken(),
				'data-contest-id' => $contest->getId(),

				// Note: this is a copy of the message in ContestContestant::sendReminderEmail.
				// If it's changed or modified by a hook, this message might not be accurate.
				'data-reminder-subject' => wfMsgExt( 'contest-email-reminder-title', 'parsemag', $contest->getDaysLeft() )
			),
			wfMsg( 'contest-contest-send-reminder' )
		) );

		$out->addHTML( Html::rawElement(
			'div',
			array(
				'id' => 'reminder-content',
				'style' => 'display:none'
			),
			ContestUtils::getParsedArticleContent( $contest->getField( 'reminder_email' ) )
		) );
	}

	/**
	 * Show a paged list of the contestants foe this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 * @param string|false $challengeTitle
	 */
	protected function showContestants( Contest $contest, $challengeTitle ) {
		$out = $this->getOutput();

		$out->addWikiMsg( 'contest-contest-contestants-text' );

		$conds = array(
			'contestant_contest_id' => $contest->getId()
		);

		$this->addRequestConditions( $conds );

		$pager = new ContestantPager( $this, $conds );

		if ( $pager->getNumRows() ) {
			$out->addHTML(
				$pager->getNavigationBar() .
				$pager->getBody() .
				$pager->getNavigationBar()
			);
		}
		else {
			$out->addWikiMsg( 'contest-contest-no-results' );
		}
	}

	/**
	 * Add the filter options to the session, so they get retained
	 * when the user does navigation such as going to the next
	 * set of results using the pager.
	 *
	 * @since 0.2
	 */
	protected function addFilterOptionsToSession() {
		$fields = array(
			'volunteer',
			'wmf',
			'comments',
			'rating_count',
			'challenge',
			'submission'
		);

		$req = $this->getRequest();

		foreach ( $fields as $field ) {
			if ( $req->getCheck( $field ) ) {
				$req->setSessionData( 'contestant-' . $field, $req->getVal( $field ) );
			}
		}
	}

	/**
	 * Add the needed conditions to the provided array depending
	 * on the filter options set.
	 *
	 * @since 0.2
	 *
	 * @param array $conds
	 */
	protected function addRequestConditions( &$conds ) {
		$req = $this->getRequest();

		foreach ( array( 'volunteer', 'wmf' ) as $field ) {
			if ( in_array( $req->getSessionData( 'contestant-' . $field ), array( 'yes', 'no' ) ) ) {
				$conds['contestant_' . $field] = $req->getSessionData( 'contestant-' . $field ) == 'yes' ? 1 : 0;
			}
		}

		foreach ( array( 'comments', 'rating_count' ) as $field ) {
			if ( in_array( $req->getSessionData( 'contestant-' . $field ), array( 'some', 'none' ) ) ) {
				if ( $req->getSessionData( 'contestant-' . $field ) == 'none' ) {
					$conds['contestant_' . $field] = 0;
				}
				else {
					$conds[] = 'contestant_' . $field . ' > 0';
				}
			}
		}

		if ( $req->getSessionData( 'contestant-challenge' ) ) {
			$challenge = ContestChallenge::s()->selectRow( 'id', array( 'title' => $req->getSessionData( 'contestant-challenge' ) ) );

			if ( $challenge !== false ) {
				$conds['contestant_challenge_id'] = $challenge->getField( 'id' );
				unset( $conds['contestant_contest_id'] ); // Not needed because the challenge implies the context
			}
		}

		if ( in_array( $req->getSessionData( 'contestant-submission' ), array( 'some', 'none' ) ) ) {
			if ( $req->getSessionData( 'contestant-submission' ) == 'none' ) {
				$conds['contestant_submission'] = '';
			}
			else {
				$conds[] = 'contestant_submission <> ""';
			}
		}
	}

	/**
	 * Create the filter control and add it to the output.
	 *
	 * @since 0.2
	 *
	 * @param Contest $contest
	 */
	protected function showFilterControl( Contest $contest ) {
		$challenges = array();

		foreach ( $contest->getChallenges() as /* ContestChallenge */ $challenge ) {
			$challenges[$challenge->getField( 'title' )] = $challenge->getField( 'title' );
		}

		$yesNo = array(
			'yes' => wfMsg( 'contest-contest-yes' ),
			'no' => wfMsg( 'contest-contest-no' )
		);

		$noneSome = array(
			'none' => wfMsg( 'contest-contest-none' ),
			'some' => wfMsg( 'contest-contest-some' ),
		);

		$title = $this->getTitle( $this->subPage )->getFullText();

		$this->getOutput()->addHTML(
			'<fieldset>' .
				'<legend>' . wfMsgHtml( 'contest-contest-showonly' ) . '</legend>' .
				'<form method="post" action="' . htmlspecialchars( wfAppendQuery( $GLOBALS['wgScript'], array( 'title' => $title ) ) ) . '">' .
					Html::hidden( 'title', $title ) .
					$this->getDropdownHTML(
						'challenge',
						$challenges
					) .
					$this->getDropdownHTML(
						'volunteer',
						$yesNo
					) .
					$this->getDropdownHTML(
						'wmf',
						$yesNo
					) .
					$this->getDropdownHTML(
						'comments',
						$noneSome
					) .
					$this->getDropdownHTML(
						'rating_count',
						$noneSome
					) .
					$this->getDropdownHTML(
						'submission',
						$noneSome
					) .
					'<input type="submit" value="' . wfMsgHtml( 'contest-contest-go' ) . '">' .
					'&#160;<button class="contest-pager-clear">' . wfMsgHtml( 'contest-contest-clear' ) . '</button>' .
				'</form>' .
			'</fieldset>'
		);
	}

	/**
	 * Get the HTML for a filter option dropdown menu.
	 *
	 * @since 0.2
	 *
	 * @param string $name
	 * @param array $options
	 * @param string|null $message
	 * @param mixed $value
	 *
	 * @return string
	 */
	protected function getDropdownHTML( $name, array $options, $message = null, $value = null ) {
		$opts = array();
		$options = array_merge( array( '' => ' ' ), $options );

		if ( is_null( $value ) ) {
			$value = $this->getRequest()->getSessionData( 'contestant-' . $name );
		}

		if ( is_null( $message ) ) {
			$message = 'contest-contest-filter-' . $name;
		}

		foreach ( $options as $val => $label ) {
			$attribs = array( 'value' => $val );

			if ( $val == $value || ( $val === ' ' && !array_key_exists( $val, $options ) ) ) {
				$attribs['selected'] = 'selected';
			}

			$opts[] = Html::element( 'option', $attribs, $label );
		}

		return Html::element( 'label', array( 'for' => $name ), wfMsg( $message ) ) . '&#160;' .
			Html::rawElement( 'select', array( 'name' => $name, 'id' => $name ), implode( "\n", $opts ) ) . '&#160;';
	}

}
