<?php

/**
 * Contest landing page for participants.
 *
 * @since 0.1
 *
 * @file SpecialContestWelcome.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialContestWelcome extends SpecialContestPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'ContestWelcome' );
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

		if ( !parent::execute( $subPage ) ) {
			return;
		}

		$out = $this->getOutput();

		/**
		 * @var $contest Contest
		 */
		$contest = Contest::s()->selectRow( null, array( 'name' => $subPage ) );

		if ( $contest === false ) {
			$this->showNoSuchContest( $subPage );
		}
		elseif ( ( $contest->getStatus() == Contest::STATUS_FINISHED ) ||
			( $contest->getStatus() == Contest::STATUS_EXPIRED ) ) {
			$this->showWarning( 'contest-signup-finished' );
			$out->returnToMain();
		} elseif ( $contest->getStatus() == Contest::STATUS_DRAFT ) {
			$this->showWarning( 'contest-signup-draft' );
			$out->returnToMain();
		}
		else {
			$this->showEnabledPage( $contest );
		}
	}

	/**
	 * Handle requests for non-existing contests, or requests with no contest specified.
	 * If the contest does not exist, an error is shown, unless there is only one existing
	 * contest, in which case the user is redirected to it, which also happens when no contest
	 * is specified. If there are multiple active contests, a list is shown.
	 *
	 * @since 0.2
	 *
	 * @param string $subPage
	 */
	protected function showNoSuchContest( $subPage ) {
		$out = $this->getOutput();

		$c = Contest::s()->select( array( 'name', 'status', 'end' ), array( 'status' => Contest::STATUS_ACTIVE ) );
		$contests = array();

		// It can also be expired, but this is stored as active in the db, so matches the selection.
		// It'd be better to get rid of this special behaviour so this kind of code is not needed.
		foreach ( $c as /* Contest */ $contest ) {
			if ( $contest->getStatus() == Contest::STATUS_ACTIVE ) {
				$contests[] = $contest;
			}
		}

		if ( count( $contests ) == 1 ) {
			$out->redirect( $this->getTitle( $contests[0]->getField( 'name' ) )->getLocalURL() );
		}
		else {
			if ( !is_null( $subPage ) && trim( $subPage ) !== '' ) {
				$this->showError( 'contest-welcome-unknown' );
			}

			if ( count( $contests ) == 0 ) {
				$out->addWikiMsg( 'contest-welcome-no-contests-active' );
			}
			else {
				$items = array();

				foreach ( $contests as /* Contest */ $contest ) {
					$items[] = '<li>' . Html::element(
						'a',
						array(
							'href' => $this->getTitle( $contest->getField( 'name' ) )->getLocalURL()
						),
						$contest->getField( 'name' )
					) . '</li>';
				}

				$out->addWikiMsg( 'contest-welcome-active-contests' );

				$out->addHTML( Html::rawElement( 'ul', array(), implode( "\n", $items ) ) );
			}
		}

		$out->returnToMain();
	}

	protected function showEnabledPage( Contest $contest ) {
		$out = $this->getOutput();

		$alreadySignedup = $this->getUser()->isLoggedIn();

		if ( $alreadySignedup ) {
			// Check if the user is already a contestant in this contest.
			// If he is, reirect to submission page, else show signup form.
			$alreadySignedup = ContestContestant::s()->selectRow(
				'id',
				array(
					'contest_id' => $contest->getId(),
					'user_id' => $this->getUser()->getId()
				)
			) !== false;
		}

		if ( $alreadySignedup ) {
			$out->redirect( SpecialPage::getTitleFor( 'MyContests', $contest->getField( 'name' ) )->getLocalURL() );
		}
		else {
			$out->setPageTitle( $contest->getField( 'name' ) );

			$this->showIntro( $contest );
			$this->showChallenges( $contest );
			$this->showOpportunities( $contest );
			$this->showRules( $contest );

			$out->addModules( 'contest.special.welcome' );
		}
	}

	/**
	 * Show the intro text for this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showIntro( Contest $contest ) {
		$this->getOutput()->addWikiText( ContestUtils::getArticleContent( $contest->getField( 'intro' ) ) );
	}

	/**
	 * Show a list of the challenges part of this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showChallenges( Contest $contest ) {
		$this->showNoJSFallback( $contest );

		$this->getOutput()->addHTML( '<div id="contest-challenges"></div><div style="clear:both"></div>' );

		$this->addContestJS( $contest );
	}

	/**
	 * Output the needed JS data.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function addContestJS( Contest $contest ) {
		$challenges = array();

		$output = $this->getOutput();
		/**
		 * @var $challenge ContestChallenge
		 */
		foreach ( $contest->getChallenges() as /* ContestChallenge */ $challenge ) {
			$data = $challenge->toArray();
			$data['target'] = $this->getSignupLink( $contest->getField( 'name' ), $challenge->getId() );
			$data['text'] = $output->parse( $data['text'] );
			$challenges[] = $data;
		}

		$output->addScript(
			Skin::makeVariablesScript(
				array(
					'ContestChallenges' => $challenges,
					'ContestConfig' => array(),
				)
			)
		);
	}

	/**
	 * Output fallback code for people that have JS disabled or have a crappy browser.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showNoJSFallback( Contest $contest ) {
		$out = $this->getOutput();

		$out->addHTML( '<noscript>' );
		$out->addHTML( '<p class="errorbox">' . htmlspecialchars( wfMsg( 'contest-welcome-js-off' ) ) . '</p>' );
		// TODO?
		$out->addHTML( '</noscript>' );
	}

	/**
	 * Show the opportunities for this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showOpportunities( Contest $contest ) {
		$this->getOutput()->addWikiText( ContestUtils::getArticleContent( $contest->getField( 'opportunities' ) ) );
	}

	/**
	 * Show the rules for this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function showRules( Contest $contest ) {
		// TODO: we might want to have a pop-up with the content here, instead of a link to the page.
		$this->getOutput()->addWikiMsgArray( 'contest-welcome-rules', $contest->getField( 'rules_page' ) );
	}

	/**
	 * Gets the URL for the signup links.
	 * When the user has to login, this will be to the login page,
	 * with a retunrto to the signup page.
	 *
	 * @since 0.1
	 *
	 * @param string $contestName
	 * @param integer|false $challengeId
	 *
	 * @return string
	 */
	protected function getSignupLink( $contestName, $challengeId = false ) {
		if ( $challengeId !== false ) {
			$contestName .= '/' . $challengeId;
		}

		$signupTitle = SpecialPage::getTitleFor( 'ContestSignup', $contestName );

		if ( $this->getUser()->isLoggedIn() ) {
			return $signupTitle->getLocalURL();
		}
		else {
			return SpecialPage::getTitleFor( 'Userlogin' )->getLocalURL( array(
				//'type' => 'signup',
				'returnto' => $signupTitle->getFullText(),
				'campaign' => 'contests'
			) );
		}
	}

}
