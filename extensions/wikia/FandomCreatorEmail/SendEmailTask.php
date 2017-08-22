<?php

namespace FandomCreatorEmail;

use Wikia\Tasks\Tasks\BaseTask;
use WikiaRequest;

class SendEmailTask extends BaseTask {

	public function sendEmails( string $emailController, string $method, array $params, array $targetUserIds ) {
		foreach ( $targetUserIds as $targetUserId ) {
			$emailParams = array_merge( [
					'targetUserId' => $targetUserId,
			], (array) $params );

			\F::app()->sendRequest( $emailController, $method, $emailParams );
		}
	}

	public static function from( WikiaRequest $controller, string $emailController ): SendEmailTask {
		$allParams = $controller->getParams();
		$targetUserIds = $allParams['targetUserIds'];

		unset( $allParams['targetUserIds'] );
		unset( $allParams['controller'] );
		unset( $allParams['method'] );

		$task = new SendEmailTask();
		$task->call( 'sendEmails', $emailController, 'handle', $allParams, $targetUserIds );
		return $task;
	}
}
