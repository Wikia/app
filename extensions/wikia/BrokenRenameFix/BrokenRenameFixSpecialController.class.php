<?php
/**
 * Class BrokenRenameFixSpecialController
 *
 * A special page with an interface to rerun local rename jobs.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package BrokenRenameFix
 */

class BrokenRenameFixSpecialController extends WikiaSpecialPageController {

	const BRF_FORM_SUBMIT = 'submit';

	private
		$notices = [],
		$userId,
		$oldName,
		$newName;

	function __construct() {
		parent::__construct( 'BrokenRenameFix', 'renameuser', true );
	}

	public function index() {
		if ( !$this->getContext()->getUser()->isAllowed( 'renameuser' ) ) {
			throw new PermissionsError( 'renameuser' );
		}

		Wikia::addAssetsToOutput( 'special_broken_rename_fix' );

		$this->getOutput()->setPageTitle( wfMessage( 'brf-title' )->escaped() );

		$this->setMessages();
		$this->setFormData();

		if ( $this->getPar() === self::BRF_FORM_SUBMIT ) {
			$this->submit();
		}

		if ( !empty( $this->notices ) ) {
			$this->formNotices = implode( "\n", $this->notices );
		}
	}

	/**
	 * Creates a prioritized task that reruns the local rename jobs.
	 */
	private function submit() {
		if ( $this->validateForm() ) {
			/**
			 * Prevent sending the data again on refresh.
			 */
			unset( $_POST );


			$task = new BrokenRenameFixTask();
			$task->call( 'rerunRenameScript', $this->userId, $this->oldName, $this->newName );
			$task->prioritize();
			$taskId = $task->queue();

			$this->addNotice( wfMessage( 'brf-success' )->rawParams( $this->getLogsLink( $taskId ) )->escaped(), 'success' );
		} else {
			$this->prefillFormValues();
		}
	}

	/**
	 * Validates the form's input and returns a status of the checks. It also adds notices
	 * on each step if something goes wrong.
	 *
	 * @return bool
	 */
	private function validateForm() {
		$status = true;

		$editToken = $this->request->getVal( 'brf-form-token' );
		if ( !$this->request->wasPosted() || !$this->wg->User->matchEditToken( $editToken ) ) {
			$this->addNotice( wfMessage( 'brf-error-invalid-request' )->escaped() );
			$status = false;
		}

		$this->userId = $this->request->getVal( 'brf-form-user-id' );
		$this->oldName = $this->request->getVal( 'brf-form-old-name' );
		$this->newName = $this->request->getVal( 'brf-form-new-name' );

		if ( empty( $this->userId ) || empty( $this->oldName ) || empty( $this->newName ) ) {
			$this->addNotice( wfMessage( 'brf-error-empty-fields' )->escaped() );
			$status = false;
		}

		$usernameFromId = User::newFromId( $this->userId )->getName();
		if ( $usernameFromId !== $this->newName ) {
			$this->addNotice( wfMessage( 'brf-error-invalid-user' )->escaped() );
			$status = false;
		}

		return $status;
	}

	/**
	 * Sets values used to prefill form if it was submited with errors.
	 */
	private function prefillFormValues() {
		$this->userIdValue = $this->userId;
		$this->oldNameValue = $this->oldName;
		$this->newNameValue = $this->newName;
	}

	/**
	 * Sets edit token and action URL in the form.
	 */
	private function setFormData() {
		$this->editToken = $this->wg->User->getEditToken();
		$this->actionUrl = $this->specialPage->getTitle()->getLocalURL( [
			self::PAR => self::BRF_FORM_SUBMIT
		] );
	}

	/**
	 * Sets all labels and description messages.
	 */
	private function setMessages() {
		$this->description = wfMessage( 'brf-desc' )->escaped();
		$this->userIdLabel = wfMessage( 'brf-label-user-id' )->escaped();
		$this->oldNameLabel = wfMessage( 'brf-label-old-name' )->escaped();
		$this->newNameLabel = wfMessage( 'brf-label-new-name' )->escaped();
		$this->submitText = wfMessage( 'brf-label-submit' )->escaped();
	}

	/**
	 * Adds a notice that are displayed above the form.
	 *
	 * @param $text
	 * @param string $type 'error' or 'success'
	 */
	private function addNotice( $text, $type = 'error' ) {
		$this->notices[] = Html::rawElement( 'p',
			[
				'class' => sprintf( 'brf-form-notice-%s', $type ),
			],
			$text
		);
	}

	/**
	 * Creates a link to logs that will be available after the rename rerun finishes.
	 *
	 * @param  string $taskId The ID of the task.
	 * @return string A HTML <a> element
	 * @throws MWException
	 */
	private function getLogsLink( $taskId ) {
		$taskLink = Linker::linkKnown(
			GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, 177 ),
			'#' . htmlspecialchars( $taskId )
		);

		return $taskLink;
	}
}
