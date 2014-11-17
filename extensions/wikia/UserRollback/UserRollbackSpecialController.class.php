<?php

/**
 * UserRollback special page controller
 *
 * @author wladek
 *
 */
class UserRollbackSpecialController extends WikiaSpecialPageController {

	const MANAGER_RIGHT = 'userrollback';

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'UserRollback', self::MANAGER_RIGHT, false );
	}

	// Controllers can all have an optional init method
	public function init() {
		$this->user = $this->app->wg->user;
		$this->extensionsPath = $this->app->wg->extensionPath;

		$this->rollbackRequest = (new UserRollbackRequest);
	}

	/**
	 * @brief this is default method, which in this example just redirects to Hello method
	 * @details No parameters
	 *
	 */
	public function index() {
		$this->wg->Out->setPageTitle( wfMsg( 'userrollback-specialpage-title' ) );

		if ( !$this->user->isAllowed( self::MANAGER_RIGHT )  ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return;
		}

		$errors = array( 'users' => array(), 'time' => array() );
		$status = false;
		$statusClass = '';
		if ($this->request->wasPosted()) {
			$this->rollbackRequest->readRequest( $this->request );
			$errors = $this->validate($this->rollbackRequest);

			if ( empty($errors) && !$this->getVal( 'back', false ) ) {
				if ( !$this->getVal( 'confirm', false ) ) {
					//$this->response->getView()->setTemplate( 'UserRollbackSpecial', 'Confirm' );
					$this->setVal( 'confirmationRequired', true );
				} else {
					if ( $this->addTask($this->rollbackRequest) ) {
						$status = wfMsg( 'userrollback-task-added' );
						$statusClass = 'successbox';
						$this->rollbackRequest->clear();
					} else {
						$status = wfMsg( 'userrollback-task-add-error' );
						$statusClass = 'errorbox';
					}
				}
			}
		}

		$this->response->addAsset( 'extensions/wikia/UserRollback/css/UserRollback_Oasis.scss' );
		$this->setVal( 'request', $this->rollbackRequest );
		$this->setVal( 'errors', $errors );
		$this->setVal( 'status', $status );
		$this->setVal( 'statusClass', $statusClass );
	}

	/**
	 * Validates data coming from the form
	 *
	 * @param $request UserRollbackRequest User rollback request
	 * @return array Errors
	 */
	protected function validate( UserRollbackRequest $request ) {
		$errors = array();

		// validating users
		$users = $request->getUserDetails();
		foreach ($users as $user) {
			if ( $user['id'] <= 0 && empty($user['ip']) ) {
				$errors['users'][] = wfMsg( 'userrollback-user-not-found', $user['name'] );
			}
		}
		if (empty($users)) {
			$errors['users'][] = wfMsg( 'userrollback-no-user-specified' );
		}

		// validating starting time
		$time = $request->getTime();
		$timeOk = false;
		if ($time != 0) {
			$time = wfTimestamp( TS_UNIX, $request->getTime() );
			if ( $time ) { // 0 = fallback in wfTimestamp
				$timeOk = true;
			}
		}
		if ( !$timeOk ) {
			$errors['time'][] = wfMsg( 'userrollback-invalid-time' );
		}

		return $errors;
	}

	/**
	 * @details Adds UserRollback task into the queue
	 *
	 * @param $request UserRollbackRequest UserRollback task data
	 * @return bool Operation status
	 */
	protected function addTask( UserRollbackRequest $request ) {
		global $wgCityId;

		$params = $request->getTaskArguments();

		$userNames = $this->processUsers( $request );
		$timestamp = $params['time'];
		$queue = \Wikia\Tasks\Queues\Queue::NAME;
		if ( $params['priority'] > 1 ) {
			$queue = \Wikia\Tasks\Queues\PriorityQueue::NAME;
		}

		$task = ( new UserRollbackTask() )
			->wikiId( $wgCityId )
			->setPriority( $queue );
		$task->call( 'enqueueRollback', $userNames, $timestamp, $queue );

		return $task->queue();
	}

	public function displayErrors() {
		$errors = $this->getVal( 'errors' );
		$name = $this->getVal( 'name' );
		$this->setVal( 'errors', isset($errors[$name]) ? $errors[$name] : false );
	}

	protected function processUsers( UserRollbackRequest $request ) {
		// split on newlines
		$userNames = preg_split('/[\r\n]+/', $request->getUsers());
		// trim all usernames
		$userNames = array_map('trim', $userNames);
		// filter empty names
		$userNames = array_filter($userNames);
		// reindex
		return array_values($userNames);
	}
}
