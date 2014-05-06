<?php

/**
 * List of contests for a user.
 *
 * @since 0.1
 *
 * @file SpecialMyContests.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialMyContests extends SpecialContestPage {

	protected $submissionState = null;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'MyContests', 'contestant' );
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

		if ( $this->getRequest()->wasPosted() ) {
			$contestant = ContestContestant::s()->selectRow( null, array( 'id' => $this->getRequest()->getInt( 'wpcontestant-id' ) ) );
			$this->showSubmissionPage( $contestant );
		}
		else {
			if ( $subPage == '' ) {
				$this->displayContestsOverview();
			}
			else {
				$this->handleSubmissionView( $subPage );
			}
		}
	}

	/**
	 * On regular page view, ie no submission and no sub-page,
	 * display a list of all contests the user is participating in,
	 * or in case there is only one, redirect them to the submission
	 * UI of it.
	 *
	 * @since 0.1
	 */
	protected function displayContestsOverview() {
		$contestants = ContestContestant::s()->select(
			array( 'id', 'contest_id', 'challenge_id' ),
			array( 'user_id' => $this->getUser()->getId() )
		);

		$contestantCount = count( $contestants );

		if ( $contestantCount == 0 ) {
			$this->getOutput()->addWikiMsg( 'contest-mycontests-no-contests' );
		}
		elseif ( $contestantCount == 1 ) {

			/**
			 * @var $contest Contest
			 */
			$contest = $contestants[0]->getContest( array( 'status', 'name' ) );

			if ( $contest->getField( 'status' ) == Contest::STATUS_ACTIVE ) {
				$this->getOutput()->redirect( $this->getTitle( $contest->getField( 'name' ) )->getLocalURL() );
			}
			else {
				$this->displayContestsTable( $contestants );
			}
		}
		else {
			$this->displayContestsTable( $contestants );
		}
	}

	/**
	 * Displays a list of contests the user participates or participated in,
	 * together with their user specific choices such as the contest challenge.
	 *
	 * @since 0.1
	 *
	 * @param array $contestants
	 */
	protected function displayContestsTable( array /* of ContestContestant */ $contestants ) {
		$running = array();
		$passed = array();
		$contests = array();

		foreach ( $contestants as $contestant ) {
			/**
			 * @var $contest Contest
			 */
			$contest = $contestant->getContest();

			if ( $contest->getField( 'status' ) == Contest::STATUS_ACTIVE ) {
				$running[] = $contestant;
			}
			elseif ( $contest->getField( 'status' ) == Contest::STATUS_FINISHED ) {
				$passed[] = $contestant;
			}

			$contests[$contest->getId()] = $contest;
		}

		if ( count( $running ) > 0 ) {
			$this->displayRunningContests( $running, $contests );
		}

		if ( count( $passed ) > 0 ) {
			//$this->displayPassedContests( $passed, $contests );
		}
	}

	/**
	 * Display a table with the running (active) contests for this user.
	 *
	 * @since 0.1
	 *
	 * @param array $contestants
	 * @param array $contests
	 */
	protected function displayRunningContests( array /* of ContestContestant */ $contestants, array /* Contest */ $contests ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'contest-mycontests-active-header' ) ) );
		$out->addHTML( Html::element( 'p', array(), wfMsg( 'contest-mycontests-active-text' ) ) );

		$out->addHTML( Xml::openElement(
			'table',
			array( 'class' => 'wikitable sortable' )
		) );

		$headers = array(
			Html::element( 'th', array(), wfMsg( 'contest-mycontests-header-contest' ) ),
			Html::element( 'th', array(), wfMsg( 'contest-mycontests-header-challenge' ) ),
		);

		$out->addHTML( '<thead><tr>' . implode( '', $headers ) . '</tr></thead>' );

		$out->addHTML( '<tbody>' );

		foreach ( $contestants as $contestant ) {

			/**
			 * @var $contestant ContestContestant
			 */

			/**
			 * @var $contest Contest
			 */
			$contest = $contests[$contestant->getField( 'contest_id' )];

			$challengeTitle = ContestChallenge::s()->selectRow(
				'title',
				array( 'id' => $contestant->getField( 'challenge_id' ) )
			)->getField( 'title' );

			$fields = array();

			$fields[] = Html::rawElement( 'td', array( 'data-sort-value' => $contest->getField( 'name' ) ), Html::rawElement(
				'a',
				array(
					'href' => SpecialPage::getTitleFor( 'MyContests', $contest->getField( 'name' ) )->getLocalURL()
				),
				htmlspecialchars( $contest->getField( 'name' ) )
			) );

			$fields[] = Html::element( 'td', array(), $challengeTitle );

			$out->addHTML( '<tr>' . implode( '', $fields ) . '</tr>' );
		}

		$out->addHTML( '</tbody>' );
		$out->addHTML( '</table>' );
	}

	/**
	 * Display a table with the passed (finished) contests for this user.
	 *
	 * @since 0.1
	 *
	 * @param array $contestants
	 * @param array $contests
	 */
	protected function displayPassedContests( array /* of ContestContestant */ $contestants, array /* Contest */ $contests ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'contest-mycontests-finished-header' ) ) );
		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'contest-mycontests-finished-text' ) ) );

		// TODO
	}

	/**
	 * Handle view requests for the page.
	 *
	 * @since 0.1
	 *
	 * @param string $contestName
	 */
	protected function handleSubmissionView( $contestName ) {
		$out = $this->getOutput();

		$contest = Contest::s()->selectRow( null, array( 'name' => $contestName ) );

		if ( $contest === false ) {
			$this->showError( 'contest-submission-unknown' );
			$out->returnToMain();
		}
		else {
			switch ( $contest->getStatus() ) {
				case Contest::STATUS_ACTIVE:
					$this->handleEnabledPage( $contest );
					break;
				case Contest::STATUS_FINISHED:
				case Contest::STATUS_EXPIRED:
					$this->showWarning( 'contest-submission-finished' );
					$out->returnToMain();
					break;
			}
		}
	}

	/**
	 * Handle page request when the contest is enabled.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function handleEnabledPage( Contest $contest ) {
		// Check if the user is already a contestant in this contest.
		// If he is, redirect to submission page, else show signup form.
		$contestant = ContestContestant::s()->selectRow(
			null,
			array(
				'contest_id' => $contest->getId(),
				'user_id' => $this->getUser()->getId()
			)
		);

		if ( $contestant === false ) {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'ContestSignup', $contest->getField( 'name' ) )->getLocalURL() );
		}
		else {
			$contestant->setContest( $contest );
			$this->showSubmissionPage( $contestant );
		}
	}

	/**
	 * Show the page content.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 */
	protected function showSubmissionPage( ContestContestant $contestant ) {
		$request = $this->getRequest();
		$contest = $contestant->getContest();
		if ( $request->getCheck( 'new' ) ) {
			$this->showSuccess( 'contest-mycontests-signup-success', $contest->getField( 'name' ) );
		}
		elseif ( $request->getCheck( 'added' ) ) {
			$this->showSuccess( 'contest-mycontests-addition-success' );
		}
		elseif ( $request->getCheck( 'updated' ) ) {
			$this->showSuccess( 'contest-mycontests-updated-success' );
		}
		elseif ( $request->wasPosted()
			&& !$this->getUser()->matchEditToken( $request->getVal( 'wpEditToken' ) ) ) {
			$this->showError( 'contest-mycontests-sessionfail' );
		}

		$output = $this->getOutput();
		$output->setPageTitle( $contest->getField( 'name' ) );

		$output->addHTML('<div style="clear:both;"></div>');
		$output->addWikiMsg( 'contest-submission-header', $contest->getField( 'name' ) );

		$form = new HTMLForm( $this->getFormFields( $contestant ), $this->getContext() );

		$form->setSubmitCallback( array( $this, 'handleSubmission' ) );
		$form->setSubmitText( wfMsg( 'contest-submission-submit' ) );

		/**
		 * @var $challenge ContestChallenge
		 */
		$challenge = ContestChallenge::s()->selectRow(
			array( 'title', 'text' ),
			array( 'id' => $contestant->getField( 'challenge_id' ) )
		);

		if ( $challenge !== false ) {
			$challengeName = $challenge->getField( 'title' );
			$challengeDescription = $challenge->getField( 'text' );

			$output->addWikiMsg( 'contest-submission-challenge', $challengeName );
			$output->addWikiMsg( 'contest-submission-challenge-description', $challengeName, $challengeDescription );
		}

		if( $form->show() ) {
			$query = is_null( $this->submissionState ) ? '' : $this->submissionState;
			$output->redirect( $this->getTitle( $contest->getField( 'name' ) )->getLocalURL( $query ) );
		}
		else {
			$output->addModules( 'contest.special.submission' );
		}
	}

	/**
	 * Handle form submission.
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 *
	 * @return true|array
	 */
	public function handleSubmission( array $data ) {
		$user = $this->getUser();

		$oldEmail = $user->getEmail();

		if ( $oldEmail !== $data['contestant-email'] ) {
			$user->setEmail( $data['contestant-email'] );
			$user->invalidateEmail();
			$user->sendConfirmationMail( $oldEmail == '' ? 'set' : 'changed' );
		}

		$user->setRealName( $data['contestant-realname'] );
		$user->saveSettings();

		$contestant = new ContestContestant( array(
			'id' => $data['contestant-id'],
			'challenge_id' => $data['contestant-challengeid'],

			'full_name' => $data['contestant-realname'],
			'email' => $data['contestant-email'],

			'country' => $data['contestant-country'],
			'volunteer' => $data['contestant-volunteer'],
			'wmf' => $data['contestant-wmf'],
			'cv' => $data['contestant-cv'],

			'submission' => trim( $data['contestant-submission'] ),
		) );

		$success = $contestant->writeToDB();

		if ( $success ) {
			if ( trim( $data['contestant-previous-submission'] ) === '' && trim( $data['contestant-submission'] ) !== '' ) {
				$this->submissionState = 'added';
			}
			else {
				$this->submissionState = 'updated';
			}
		}

		return $success;
	}

	/**
	 * Gets the field definitions for the form.
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contest
	 *
	 * @return array
	 */
	protected function getFormFields( ContestContestant $contestant ) {
		$fields = array();

		$user = $this->getUser();

		$fields['contestant-id'] = array(
			'type' => 'hidden',
			'default' => $contestant->getId(),
			'id' => 'contest-id',
		);

		$fields['contestant-previous-submission'] = array(
			'type' => 'hidden',
			'default' => $contestant->getField( 'submission' ),
		);

		$fields['contestant-submission'] = array(
			'class' => 'ContestSubmissionField',
			'label-message' => 'contest-submission-submission',
			'validation-callback' => array( __CLASS__, 'validateSubmissionField' ),
			'options' => array(
				'domains' => implode( '|', ContestSettings::get( 'submissionDomains' ) ),
				'value' => $contestant->getField( 'submission' )
			)
		);

		$fields['contestant-realname'] = array(
			'type' => 'text',
			'default' => $user->getRealName(),
			'label-message' => 'contest-signup-realname',
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateNameField' )
		);

		$fields['contestant-email'] = array(
			'type' => 'email',
			'default' => $user->getEmail(),
			'label-message' => 'contest-signup-email',
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateEmailField' ),
		);

		$fields['contestant-country'] = array(
			'type' => 'select',
			'default' => $contestant->getField( 'country' ),
			'label-message' => 'contest-signup-country',
			'required' => true,
			'options' => ContestContestant::getCountriesForInput()
		);

		$fields['contestant-challengeid'] = array(
			'type' => 'radio',
			'label-message' => 'contest-signup-challenge',
			'options' => $this->getChallengesList( $contestant ),
			'default' => $contestant->getField( 'challenge_id' ),
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateChallengeField' )
		);

		$fields['contestant-volunteer'] = array(
			'type' => 'check',
			'default' => $contestant->getField( 'volunteer' ),
			'label-message' => 'contest-signup-volunteer',
		);

		$fields['contestant-wmf'] = array(
			'type' => 'check',
			'default' => $contestant->getField( 'wmf' ),
			'label-message' => 'contest-signup-wmf',
		);

		$hasWMF = $contestant->hasField( 'wmf' );

		$fields['contestant-cv'] = array(
			'type' => $hasWMF && $contestant->getField( 'wmf' ) ? 'text' : 'hidden',
			'default' => $hasWMF ? $contestant->getField( 'cv' ) : '',
			'label-message' => 'contest-signup-cv',
			'validation-callback' => array( __CLASS__, 'validateCVField' ),
		);

		return $fields;
	}

	/**
	 * Gets a list of contests that can be fed directly to the options field of
	 * an HTMLForm radio input.
	 * challenge title => challenge id
	 *
	 * @since 0.1
	 *
	 * @param ContestContestant $contestant
	 *
	 * @return array
	 */
	protected function getChallengesList( ContestContestant $contestant ) {
		$list = array();

		$challenges = ContestChallenge::s()->select(
			array( 'id', 'title' ),
			array( 'contest_id' => $contestant->getField( 'contest_id' ) )
		);

		foreach ( $challenges as /* ContestChallenge */ $challenge ) {
			$list[$challenge->getField( 'title' )] = $challenge->getId();
		}

		return $list;
	}

	/**
	 * HTMLForm field validation-callback for name field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateNameField( $value, $alldata = null ) {
		if ( strlen( $value ) < 2 ) {
			return wfMsg( 'contest-signup-invalid-name' );
		}

		return true;
	}

	/**
	 * HTMLForm field validation-callback for email field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateEmailField( $value, $alldata = null ) {
		if ( !Sanitizer::validateEmail( $value ) ) {
			return wfMsg( 'contest-signup-invalid-email' );
		}

		return true;
	}

	/**
	 * HTMLForm field validation-callback for cv field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateCVField( $value, $alldata = null ) {
		if ( trim( $value ) !== '' && filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
			return wfMsg( 'contest-signup-invalid-cv' );
		}

		return true;
	}

	/**
	 * HTMLForm field validation-callback for the submission field.
	 * Warning: regexes used! o_O
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateSubmissionField( $value, $alldata = null  ) {
		$value = trim( $value );

		if ( $value == '' ) {
			return true;
		}

		$allowedPatterns = array(
			// GitHub URLs such as https://github.com/JeroenDeDauw/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b
			// '@^https://github\.com/[a-zA-Z0-9-]+/[a-zA-Z0-9_-]+/tree/[a-zA-Z0-9]{40}$@i'
		);

		foreach ( ContestSettings::get( 'submissionDomains' ) as $domain ) {
			$allowedPatterns[] = '@^https?://(([a-z0-9]+)\.)?' . str_replace( '.', '\.', $domain ) . '/.*$@i';
		}

		foreach ( $allowedPatterns as $pattern ) {
			if ( preg_match( $pattern, $value ) ) {
				return true;
			}
		}

		return wfMsg( 'contest-submission-invalid-url' );
	}

	/**
	 * HTMLForm field validation-callback for challenge field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateChallengeField( $value, $alldata = null ) {
		if ( is_null( $value ) ) {
			return wfMsg( 'contest-signup-require-challenge' );
		}

		return true;
	}

}

class ContestSubmissionField extends HTMLFormField {

	public function getInputHTML( $value ) {
		$attribs = array(
			'class' => 'contest-submission',
			'data-name' => $this->mName
		);

		foreach ( $this->mParams['options'] as $name => $value ) {
			$attribs['data-' . $name] = $value;
		}

		return Html::element(
			'div',
			$attribs
		);
	}

}
