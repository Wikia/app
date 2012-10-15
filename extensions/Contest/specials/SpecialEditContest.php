<?php

/**
 * Contest editing interface for contest admins.
 *
 * @since 0.1
 *
 * @file SpecialEditContest.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialEditContest extends FormSpecialPage {

	protected $contest = false;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'EditContest', 'contestadmin', false );
	}

	/**
	 * @see SpecialPage::getDescription
	 *
	 * @since 0.1
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}

	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 *
	 * @since 0.1
	 */
	public function setHeaders() {
		$out = $this->getOutput();
		$out->setArticleRelated( false );
		$out->setRobotPolicy( 'noindex,nofollow' );
		$out->setPageTitle( $this->getDescription() );
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

		$this->setParameter( $subPage );
		$this->setHeaders();
		$this->outputHeader();

		// This will throw exceptions if there's a problem
		$this->checkExecutePermissions( $this->getUser() );

		if ( $this->getRequest()->wasPosted() && $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) ) {
			$this->showForm();
		}
		else {
			$this->showContent( $subPage );
		}
	}

	/**
	 * Show the form.
	 *
	 * @since 0.1
	 */
	protected function showForm() {
		$form = $this->getForm();

		if ( $form->show() ) {
			$this->onSuccess();
		}
	}

	/**
	 * Attempt to get the contest to be edited or create the one to be added.
	 * If this works, show the form, if not, redirect to special:contests.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	protected function showContent( $subPage ) {
		$isNew = $this->getRequest()->wasPosted() && $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'newEditToken' ) );

		$this->getOutput()->addScript(
			Skin::makeVariablesScript(
				array(
					'ContestDeletionEnabled' => ContestSettings::get( 'contestDeletionEnabled' ),
				)
			)
		);
		if ( $isNew ) {
			$data = array( 'name' => $this->getRequest()->getVal( 'newcontest' ) );

			$contest = Contest::s()->selectRow( null, $data );

			if ( $contest === false ) {
				$contest = new Contest( $data, true );
			}
			else {
				$this->showWarning( 'contest-edit-exists-already' );
			}
		}
		else {
			$contest = Contest::s()->selectRow( null, array( 'name' => $subPage ) );
		}

		if ( $contest === false ) {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'Contests' )->getLocalURL() );
		}
		else {
			if ( !$isNew ) {
				$this->getOutput()->addHTML(
					SpecialContestPage::getNavigation( $contest->getField( 'name' ), $this->getUser(), $this->getLanguage(), $this->getName() )
				);
			}

			$this->contest = $contest;
			$this->showForm();
			$this->getOutput()->addModules( 'contest.special.editcontest' );
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getForm()
	 * @return HTMLForm|null
	 */
	protected function getForm() {
		$form = parent::getForm();

		$form->addButton(
			'cancelEdit',
			wfMsg( 'cancel' ),
			'cancelEdit',
			array(
				'target-url' => SpecialPage::getTitleFor( 'Contests' )->getFullURL()
			)
		);

//		$form->addButton(
//			'deleteEdit',
//			wfMsg( 'delete' ),
//			'deleteEdit'
//		);

		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {

		/**
		 * @var $contest Contest
		 */
		$contest = $this->contest;

		$fields = array();

		$fields['id'] = array ( 'type' => 'hidden' );

		$fields['name'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-name',
			'id' => 'contest-name-field',
		);

		$fields['status'] = array (
			'type' => 'radio',
			'label-message' => 'contest-edit-status',
			'options' => Contest::getStatusMessages( true )
		);

		$fields['intro'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-intro',
		);

		$fields['opportunities'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-opportunities',
		);

		$fields['rules_page'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-rulespage',
		);

		$fields['help'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-help',
		);

		$fields['signup_email'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-signup',
		);

		$fields['reminder_email'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-reminder',
		);

		$fields['end'] = array (
			'type' => 'text',
			'label-message' => 'contest-edit-end',
			'id' => 'contest-edit-end',
			'size' => 15
		);

		if ( $contest !== false ) {
			foreach ( $fields as $name => $data ) {
				$default = $contest->getField( $name );

				if ( $name == 'end' ) {
					$default = wfTimestamp( TS_DB, $default );
				}

				$fields[$name]['default'] = $default;
			}
		}

		$mappedFields = array();

		foreach ( $fields as $name => $field ) {
			$mappedFields['contest-' . $name] = $field;
		}

		if ( $contest !== false ) {
			foreach ( $contest->getChallenges() as /* ContestChallenge */ $challenge ) {
				$mappedFields[] = array(
					'class' => 'ContestChallengeField',
					'options' => $challenge->toArray()
				);
			}
		}

		$mappedFields['delete-challenges'] = array ( 'type' => 'hidden', 'id' => 'delete-challenges' );

		return $mappedFields;
	}

	/**
	 * Process the form.  At this point we know that the user passes all the criteria in
	 * userCanExecute(), and if the data array contains 'Username', etc, then Username
	 * resets are allowed.
	 *
	 * @param array $data
	 *
	 * @return Bool|Array
	 */
	public function onSubmit( array $data ) {
		$fields = array();

		foreach ( $data as $name => $value ) {
			$matches = array();

			if ( preg_match( '/contest-(.+)/', $name, $matches ) ) {
				if ( $matches[1] == 'end' ) {
					$value = wfTimestamp( TS_MW, strtotime( $value ) );
				}

				$fields[$matches[1]] = $value;
			}
		}

		// If no ID is set, this means it's a new contest, so set the ID to null for an insert.
		// However, the user can have hot the back button after creation of a new contest,
		// re-submitting the form. In this case, get the ID of the already existing item for an update.
		if ( !array_key_exists( 'id', $fields ) || $fields['id'] === '' ) {
			$contest = Contest::s()->selectRow( 'id', array( 'name' => $fields['name'] ) );
			$fields['id'] = $contest === false ? null : $contest->getField( 'id' );
		}

		$contest = new Contest( $fields, is_null( $fields['id'] ) );

		$contest->setChallenges( $this->getSubmittedChallenges() );
		$success = $contest->writeAllToDB();

		$success = $this->removeDeletedChallenges( $data['delete-challenges'] ) && $success;

		if ( $success ) {
			return true;
		}
		else {
			return array(); // TODO
		}
	}

	/**
	 * The UI keeps track of 'removed' challenges by storing them into a
	 * hidden HTML input, pipe-separated. On submission, this method
	 * takes this string and actually deletes them.
	 *
	 * @since 0.1
	 *
	 * @param string $idString
	 *
	 * @return boolean Success indicator
	 */
	protected function removeDeletedChallenges( $idString ) {
		if ( $idString == '' ) {
			return true;
		}
		
		if ( !ContestSettings::get( 'contestDeletionEnabled' ) ) {
			// Shouldn't get here (UI should prevent it)
			throw new MWException( 'Contest deletion is disabled', 'contestdeletiondisabled' );
		}
		
		return ContestChallenge::s()->delete( array( 'id' => explode( '|', $idString ) ) );
	}

	/**
	 * Finds the submitted challanges and returns them as a list of
	 * ContestChallenge objects.
	 *
	 * @since 0.1
	 *
	 * @return array of ContestChallenge
	 */
	protected function getSubmittedChallenges() {
		$challenges = array();

		foreach ( $this->getrequest()->getValues() as $name => $value ) {
			$matches = array();

			if ( preg_match( '/contest-challenge-(\d+)/', $name, $matches ) ) {
				$challenges[] = $this->getSubmittedChallenge( $matches[1] );
			} elseif ( preg_match( '/contest-challenge-new-(\d+)/', $name, $matches ) ) {
				$challenges[] = $this->getSubmittedChallenge( $matches[1], true );
			}
		}

		return $challenges;
	}

	/**
	 * Create and return a contest challenge object from the submitted data.
	 *
	 * @since 0.1
	 *
	 * @param integer|null $challengeId
	 * @param boolean $isNewChallenge
	 *
	 * @return ContestChallenge
	 */
	protected function getSubmittedChallenge( $challengeId, $isNewChallenge = false ) {
		if ( $isNewChallenge ) {
			$challengeDbId = null;
			$challengeId = "new-$challengeId";
		} else {
			$challengeDbId = $challengeId;
		}

		$request = $this->getRequest();

		return new ContestChallenge( array(
			'id' => $challengeDbId,
			'text' => $request->getText( "challenge-text-$challengeId" ),
			'title' => $request->getText( "contest-challenge-$challengeId" ),
			'oneline' => $request->getText( "challenge-oneline-$challengeId" ),
		) );
	}

	public function onSuccess() {
		$this->getOutput()->redirect( SpecialPage::getTitleFor( 'Contests' )->getLocalURL() );
	}

	/**
	 * Show a message in a warning box.
	 *
	 * @since 0.1
	 *
	 * @param string $message
	 */
	protected function showWarning( $message ) {
		$this->getOutput()->addHTML(
			'<p class="visualClear warningbox">' . wfMsgExt( $message, 'parseinline' ) . '</p>'
			. '<hr style="display: block; clear: both; visibility: hidden;" />'
		);
	}
	
	/**
	 * Get the Language being used for this instance.
	 * getLang was deprecated in 1.19, getLanguage was introduces in the same version.
	 *
	 * @since 0.2
	 *
	 * @return Language
	 */
	public function getLanguage() {
		return method_exists( get_parent_class(), 'getLanguage' ) ? parent::getLanguage() : $this->getLang();
	}

}

class ContestChallengeField extends HTMLFormField {

	public function getInputHTML( $value ) {
		$attribs = array(
			'class' => 'contest-challenge'
		);

		foreach ( $this->mParams['options'] as $name => $value ) {
			$attribs['data-challenge-' . $name] = $value;
		}

		return Html::element(
			'div',
			$attribs
		);
	}

}
