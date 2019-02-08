<?php

use FandomCreator\CommunitySetup;
use Wikia\Logger\Loggable;

class MarkWikiAsClosedController extends WikiaController {

	use Loggable;

	const WIKI_ID = 'wikiId';
	const REASON = 'reason';
	const USER_ID = 'reviewingUserId';
	const FANDOM_CREATOR_COMMUNITY_ID = 'fandomCreatorCommunityId';

	public function init() {
		$this->assertCanAccessController();
	}

	public function markWikiAsClosed() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$wikiId = $request->getVal( self::WIKI_ID );
		$reason = $request->getVal( self::REASON );
		$userId = $request->getVal( self::USER_ID );
		$fandomCreatorCommunityId = $request->getVal( self::FANDOM_CREATOR_COMMUNITY_ID );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !empty( $fandomCreatorCommunityId ) && !is_numeric( $fandomCreatorCommunityId ) ) {
			$this->response->setCode( 400 );
			$this->info('invalid  fandomCreatorCommunityId parameter in request');

			return;
		}

		if ( !is_numeric( $wikiId ) || empty( $reason ) || !is_numeric( $userId ) ) {
			// No wikiId, userId or reason given: Bad Request
			$this->response->setCode( 400 );
			$this->info('no wikiId or reason parameter in request');

			return;
		}

		if ( static::isGoForClose($wikiId, $fandomCreatorCommunityId, $reason) ) {
			$user = User::newFromId($userId);

			WikiFactory::setFlags( $wikiId,
				WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP |
				WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE, false, null,  $user );
			WikiFactory::clearCache( $wikiId );
			$this->response->setCode( 200 );

			return;
		}

		$this->response->setCode( 500 );
		$this->info("could not mark Wiki to be closed in MW. Wiki id: " . $wikiId);

		return;
	}

	/**
	 * Make sure to only allow authorized POST methods.
	 * @throws WikiaHttpException
	 */
	public function assertCanAccessController() {
		if ( !$this->getContext()->getRequest()->isWikiaInternalRequest() ) {
			throw new ForbiddenException( 'Access to this controller is restricted' );
		}
		if ( !$this->getContext()->getRequest()->wasPosted() ) {
			throw new MethodNotAllowedException( 'Only POST allowed' );
		}
	}

	static private function isGoForClose( $wikiId, $fandomCreatorCommunityId, $reason ) {
		$isGoForClose = true;

		if ( !empty( $fandomCreatorCommunityId ) ) {
			$wikiFandomCreatorCommunityId = WikiFactory::getVarByName( CommunitySetup::WF_VAR_FC_COMMUNITY_ID, $wikiId );

			if ( $fandomCreatorCommunityId == $wikiFandomCreatorCommunityId ) {
				$isGoForClose = WikiFactory::resetFlags(
					$wikiId,
					WikiFactory::FLAG_PROTECTED,
					false,
					'fandom creator soft deletion: ' . $reason
				);
			}
		}

		if ( $isGoForClose ) {
			$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason, $user );
			$isGoForClose = ($res === WikiFactory::CLOSE_ACTION);
		}

		return $isGoForClose;
	}
}
