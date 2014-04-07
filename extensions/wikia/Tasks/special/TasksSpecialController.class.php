<?php
/**
 * TasksSpecialController
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class TasksSpecialController extends WikiaSpecialPageController {
	/** @var Tasks */
	private $model;

	public function __construct() {
		parent::__construct('Tasks', '', false);
	}

	public function init() {
		$this->model = F::build('Tasks', ['title' => $this->app->wg->Title]);
	}

	public function index() {
		$this->wg->Out->setPageTitle(wfMsg('tasks-title'));
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
		$this->response->addAsset(__DIR__.'/js/special_tasks.js');
		$this->response->addAsset(__DIR__.'/css/special_tasks.css');


		$this->setVal('header', wfMsg('tasks-title'));
		$this->setVal('pageDescription', wfMsg('tasks-description'));
		$this->setVal('createableTaskList', $this->model->getTaskClasses());
		$this->setVal('flowerUrl', "http://localhost:5555"); // TODO: read from config
		$this->setVal('ajaxLoading', $this->wg->ExtensionsPath.'/wikia/Tasks/special/images/ajax-loader.gif');
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