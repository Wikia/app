<?php

use Wikia\Logger\Loggable;
use Wikia\Rabbit\ConnectionBase;

/**
 * @package MediaWiki
 * @subpackage WikiStatusChangePublisher
 *
 */
class WikiStatusChangePublisher {

	use Loggable;

	public function publishWikiStatusChangedToRemoved( int $wikiId, string $reason ) {
		return $this->publishStatusChange( $wikiId, 'removed', $reason );
	}

	public function publishWikiFactoryStatusChange(
		int $wikiId, int $wikiFactoryAction, string $reason
	) {
		$status = $this->mapWikiFactoryActionToStatus( $wikiId, $wikiFactoryAction );

		return $this->publishStatusChange( $wikiId, $status, $reason );
	}

	/**
	 * @param int $wikiId
	 * @param string $status is one of 'closed', 'opened', 'hidden', 'removed'
	 * @param string $reason
	 * @return bool
	 */
	private function publishStatusChange( int $wikiId, string $status, string $reason ) {
		global $wgWikiStatusChangePublisher;

		$connectionBase = new ConnectionBase( $wgWikiStatusChangePublisher );
		$routingKey = 'wiki.' . $wikiId . ".status." . $status;

		$this->info( "Publishing an event that wiki: " . $wikiId . " transitions to " . $status .
		             " status." );

		$connectionBase->publish( $routingKey, [
			'wikiId' => $wikiId,
			'reason' => $reason,
			'status' => $status,
		] );

		return true;
	}

	private function mapWikiFactoryActionToStatus( int $wikiId, int $wikiFactoryAction ) {
		switch ( $wikiFactoryAction ) {
			case WikiFactory::CLOSE_ACTION:
				return "closed";
			case WikiFactory::PUBLIC_WIKI:
				return "opened";
			case WikiFactory::HIDE_ACTION:
				return "hidden";
			default:
				$this->error( "Failed to recognise WikiFactory action: " . $wikiFactoryAction .
				              ", for wiki: " . $wikiId );

				return "unrecognised";
		}
	}
}
