<?php

/**
 * @class InsightsUpdateController
 * MediaWiki special page that allows users with the required permissions to schedule update and cleanup tasks
 * for Insights-related data
 */
class InsightsUpdateController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'InsightsUpdate' /* name */, 'insights-update' /* restriction */ );
	}

	/**
	 * Main entry point
	 */
	public function index() {
		$this->setHeaders();
		$this->checkPermissions();

		$request = $this->getContext()->getRequest();
		if ( $request->wasPosted() ) {
			$request->assertValidWriteRequest( $this->getUser() );
			$this->createInsightsCleanupTasks();
			BannerNotificationsController::addConfirmation( $this->msg( 'insights-update-task-added' ) );
		}

		$this->response->setData( [
			'msg-insights-update-desc' => $this->msg( 'insights-update-desc' )->text(),
			'msg-ok' => $this->msg( 'ok' )->text(),
			'token' => $this->getUser()->getEditToken( null, $this->getRequest() ),
		] );
	}

	/**
	 * Queues the cleanup task
	 */
	private function createInsightsCleanupTasks() {
		$cleanupTask = ( new Wikia\Tasks\Tasks\InsightsCleanupTask() )
			->wikiId( $this->wg->CityId );
		$cleanupTask->call( 'cleanLinksTables' );
		$cleanupTask->queue();

		$updateTask = ( new Wikia\Tasks\Tasks\UpdateSpecialPagesTask() )
			->wikiId( $this->wg->CityId );
		$updateTask->call( 'rebuildLocalizationCache' );
		$updateTask->queue();
	}
}
