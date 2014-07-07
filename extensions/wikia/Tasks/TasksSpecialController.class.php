<?php
/**
 * TasksSpecialController
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class TasksSpecialController extends WikiaSpecialPageController {
	use PreventBlockedUsersThrowsError;
	use UserAllowedRequirementThrowsError;

	/** @var TasksModel */
	private $model;

	private $flowerUrl;

	public function __construct() {
		global $wgFlowerUrl;

		parent::__construct('Tasks', '', false);
		$this->flowerUrl = $wgFlowerUrl;
		$this->userAccessRequirementDefault('tasks-user');
	}

	public function init() {
		$this->model = new TasksModel($this->app->wg->Title);
	}

	public function index() {
		$this->wg->Out->setPageTitle(wfMsg('tasks-title'));
		$this->response->addAsset('extensions/wikia/Tasks/js/special_tasks.js');
		$this->response->addAsset('extensions/wikia/Tasks/css/special_tasks.css');

		if ( $this->getPar() ) {
			$this->forward( 'TasksSpecialController', $this->getPar() );
			return;
		}

		$this->setVal('createableTaskList', $this->model->getTaskClasses());
		$this->setVal('flowerUrl', $this->flowerUrl);

		$this->response->setJsVar('wgFlowerUrl', $this->flowerUrl);
		$this->response->setJsVar('wgAjaxLoadingIndicator', $this->wg->ExtensionsPath.'/wikia/Tasks/images/ajax-loader.gif');
	}

	public function log() {
		global $wgFlowerUrl;

		$taskId = $this->request->getVal('id');
		$taskLogs = json_decode( Http::get( "{$wgFlowerUrl}/api/task/get-logs/{$taskId}", 'default', [
			'noProxy' => true,
		] ), true);

		$this->wg->Out->setPageTitle( wfMsg('tasks-log-title') );
		$this->setVal('taskLogs', $taskLogs);
	}

	public function getMethods() {
		$class = $this->request->getVal('class');

		if (empty($class)) {
			$this->response->setException(new Exception('missing class'));
			return;
		}

		$methods = $this->model->getClassMethods($class);

		if (empty($methods)) {
			$this->response->setException(new Exception('no methods found'));
			return;
		}

		$this->response->setFormat(WikiaResponse::FORMAT_JSON);
		$this->response->setBody(json_encode($methods));
	}

	public function createTask() {
		$class = $this->request->getVal('task_class');
		$method = $this->request->getVal('task_method');
		$args = $this->request->getArray('args', []);

		try {
			list($taskId, $methodCall) = $this->model->createTask($class, $method, $args);
		} catch(Exception $e) {
			$this->response->setException($e);
			return;
		}

		$this->response->setFormat(WikiaResponse::FORMAT_JSON);
		$this->response->setBody(json_encode([
			'task_id' => $taskId,
			'method_call' => $methodCall
		]));
	}
}
