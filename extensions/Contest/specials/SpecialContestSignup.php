<?php

/**
 * Contest signup interface for participants.
 *
 * @since 0.1
 *
 * @file SpecialContestSignup.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialContestSignup extends SpecialContestPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'ContestSignup' );
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

		if ( $this->getRequest()->wasPosted() && $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) ) {
			$this->showSignupForm( Contest::s()->selectRow( null, array( 'id' => $this->getRequest()->getInt( 'wpcontest-id' ) ) ) );
		}
		else {
			$this->showPage( $subPage );
		}
	}

	/**
	 * This page is unlisted because the only way to access it is though a contest
	 * landing page.
	 *
	 * @return false|boolean
	 */
	public function isListed() {
		return false;
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
			'contest_id' => $data['contest-id'],
			'user_id' => $user->getId(),
			'challenge_id' => $data['contestant-challengeid'],

			'full_name' => $data['contestant-realname'],
			'user_name' => $user->getName(),
			'email' => $data['contestant-email'],

			'country' => $data['contestant-country'],
			'volunteer' => $data['contestant-volunteer'],
			'wmf' => $data['contestant-wmf'],
		) );

		return $contestant->writeToDB();
	}

	/**
	 * Show the page.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	protected function showPage( $subPage ) {
		$out = $this->getOutput();

		$subPage = explode( '/', $subPage );
		$contestName = $subPage[0];
		$challengeId = count( $subPage ) > 1 ? $subPage[1] : false;

		$contest = Contest::s()->selectRow( null, array( 'name' => $contestName ) );

		if ( $contest === false ) {
			$this->showError( 'contest-signup-unknown' );
			$out->returnToMain();
			return;
		}
		switch ( $contest->getStatus() ) {
			case Contest::STATUS_ACTIVE:
				$this->showEnabledPage( $contest, $challengeId );
				break;
			case Contest::STATUS_DRAFT:
				$this->showWarning( 'contest-signup-draft' );
				$out->returnToMain();
				break;
			case Contest::STATUS_FINISHED:
			case Contest::STATUS_EXPIRED:
				$this->showWarning( 'contest-signup-finished' );
				$out->returnToMain();
				break;
		}
	}

	/**
	 * Handle page request when the contest is enabled.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 * @param integer|false $challengeId
	 */
	protected function showEnabledPage( Contest $contest, $challengeId ) {
		$out = $this->getOutput();

		// Check if the user is already a contestant in this contest.
		// If he is, reirect to submission page, else show signup form.
		$contestant = ContestContestant::s()->selectRow(
			'id',
			array(
				'contest_id' => $contest->getId(),
				'user_id' => $this->getUser()->getId()
			)
		);

		if ( $contestant === false ) {
			$out->setPageTitle( $contest->getField( 'name' ) );
			$out->addWikiMsg( 'contest-signup-header', $contest->getField( 'name' ) );

			$this->showSignupForm( $contest, $challengeId );
		}
		else {
			$out->redirect( SpecialPage::getTitleFor( 'MyContests', $contest->getField( 'name' ) )->getLocalURL() );
		}
	}

	/**
	 * Display the signup form for this contest.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 * @param integer|false $challengeId
	 */
	protected function showSignupForm( Contest $contest, $challengeId = false ) {
		$form = new HTMLForm( $this->getFormFields( $contest, $challengeId ), $this->getContext() );

		$form->setSubmitCallback( array( $this, 'handleSubmission' ) );
		$form->setSubmitText( wfMsg( 'contest-signup-submit' ) );

		if( $form->show() ) {
			$this->onSuccess( $contest );
		}
		else {
			$this->getOutput()->addModules( 'contest.special.signup' );
		}

		$this->getOutput()->addScript(
			Skin::makeVariablesScript(
				array(
					'ContestConfig' => array( 'rules_page' => ContestUtils::getParsedArticleContent( $contest->getField( 'rules_page' ) ) )
				)
			)
		);
	}

	/**
	 * Redirect the user to the contest page and add the "new" argument to the URL
	 * so they get a success message.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	protected function onSuccess( Contest $contest ) {
		$url = SpecialPage::getTitleFor( 'MyContests', $contest->getField( 'name' ) )->getLocalURL( 'new' );
		$this->getOutput()->redirect( $url );
	}

	/**
	 * Gets the field definitions for the form.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 * @param integer|false $challengeId
	 * @return array
	 */
	protected function getFormFields( Contest $contest, $challengeId ) {
		$fields = array();

		$user = $this->getUser();

		$fields['contest-id'] = array(
			'type' => 'hidden',
			'default' => $contest->getId(),
			'id' => 'contest-id',
		);

		$fields['contestant-realname'] = array(
			'type' => 'text',
			'default' => $user->getRealName(),
			'label-message' => 'contest-signup-realname',
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateNameField' )
		);

		$fields['contestant-email'] = array(
			'type' => 'text',
			'default' => $user->getEmail(),
			'label-message' => 'contest-signup-email',
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateEmailField' )
		);

		$fields['contestant-country'] = array(
			'type' => 'select',
			'label-message' => 'contest-signup-country',
			'required' => true,
			'options' => ContestContestant::getCountriesForInput( true ),
			'validation-callback' => array( __CLASS__, 'validateCountryField' )
		);

		$fields['contestant-challengeid'] = array(
			'type' => 'radio',
			'label-message' => 'contest-signup-challenge',
			'options' => $this->getChallengesList( $contest ),
			'required' => true,
			'validation-callback' => array( __CLASS__, 'validateChallengeField' )
		);

		if ( $challengeId !== false ) {
			$fields['contestant-challengeid']['default'] = $challengeId;
		}

		$fields['contestant-volunteer'] = array(
			'type' => 'check',
			'default' => '0',
			'label-message' => 'contest-signup-volunteer',
		);

		$fields['contestant-wmf'] = array(
			'type' => 'check',
			'default' => '0',
			'label-message' => 'contest-signup-wmf',
		);

		$fields['contestant-readrules'] = array(
			'type' => 'check',
			'default' => '0',
			'label-message' => array( 'contest-signup-readrules', $contest->getField( 'rules_page' ) ),
			'validation-callback' => array( __CLASS__, 'validateRulesField' ),
			'id' => 'contest-rules',
			'data-foo' => 'bar'
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
	 * @param Contest $contest
	 *
	 * @return array
	 */
	protected function getChallengesList( Contest $contest ) {
		$list = array();

		foreach ( $contest->getChallenges() as /* ContestChallenge */ $challenge ) {
			$list[$challenge->getField( 'title' )] = $challenge->getId();
		}

		return $list;
	}

	/**
	 * HTMLForm field validation-callback for name field.
	 * 1
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
	 * HTMLForm field validation-callback for country field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateCountryField( $value, $alldata = null ) {
		if ( $value === '' ) {
			return wfMsg( 'contest-signup-require-country' );
		}

		return true;
	}

	/**
	 * HTMLForm field validation-callback for rules field.
	 *
	 * @since 0.1
	 *
	 * @param $value String
	 * @param $alldata Array
	 *
	 * @return true|string
	 */
	public static function validateRulesField( $value, $alldata = null ) {
		if ( !$value ) {
			return wfMsg( 'contest-signup-require-rules' );
		}

		return true;
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
