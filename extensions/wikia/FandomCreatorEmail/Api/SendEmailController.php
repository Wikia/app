<?php

namespace FandomCreatorEmail\Api;

use FandomCreatorEmail\Controller\ContentUpdatedController;
use FandomCreatorEmail\SendEmailTask;
use WikiaApiController;

class SendEmailController extends WikiaApiController {

	public function allowsExternalRequests() {
		return false;
	}

	public function contentUpdated() {
		$task = SendEmailTask::from( $this->request, ContentUpdatedController::class );
		$taskId = $task->queue();
		$this->setResponseData( ['taskId' => $taskId] );
	}
}
