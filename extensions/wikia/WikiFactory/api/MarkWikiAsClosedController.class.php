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

		if ( !is_numeric( $wikiId ) || empty( $reason ) || !is_numeric( $userId ) ) {
			// No wikiId, userId or reason given: Bad Request
			$this->response->setCode( 400 );
			$this->info( 'no wikiId or reason parameter in request' );

			return;
		}

		if ( !empty( $fandomCreatorCommunityId ) ) {
			if ( !static::isValidFandomCreatorCommunityId( $fandomCreatorCommunityId, $wikiId )) {
				$this->response->setCode( 400 );

				$this->info(
					'invalid fandomCreatorCommunityId parameter in request',
					[ 'fandom_creator_community_id' => $fandomCreatorCommunityId ]
				);

				return;
			}

			if ( !static::removeProtectionFromFandomCreatorCommunityWiki( $wikiId, $reason ) ) {
				$this->response->setCode( 500 );

				$this->info(
					'could not remove protected flag on wiki with id',
					[ 'wiki_id' => $wikiId ]
				);

				return;
			}
		}

		$user = User::newFromId( $userId );

		if ( !static::closeWiki( $wikiId, $user, $reason ) ) {
			$this->response->setCode( 500 );

			$this->info(
				'could not close wiki with id',
				[ 'wiki_id' => $wikiId ]
			);

			return;
		}

		WikiFactory::setFlags(
			$wikiId,
			WikiFactory::FLAG_FREE_WIKI_URL |
			WikiFactory::FLAG_CREATE_DB_DUMP |
			WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE,
			false,
			null,
			$user
		);

		WikiFactory::clearCache( $wikiId );
		$this->response->setCode( 200 );

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

	static private function closeWiki( $wikiId, $user, $reason ) {
		$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason, $user );
		return ($res === WikiFactory::CLOSE_ACTION);
	}

	static private function removeProtectionFromFandomCreatorCommunityWiki( $wikiId, $reason ) {
		return WikiFactory::resetFlags(
			$wikiId,
			WikiFactory::FLAG_PROTECTED,
			false,
			'fandom creator community soft deletion: ' . $reason
		);
	}

	static private function isValidFandomCreatorCommunityId( $fandomCreatorCommunityId, $wikiId ) {
		if (!is_numeric( $fandomCreatorCommunityId )) {
			return false;
		}

		$wikiFandomCreatorCommunityId = WikiFactory::getVarValueByName( CommunitySetup::WF_VAR_FC_COMMUNITY_ID, $wikiId );

		return ($fandomCreatorCommunityId == $wikiFandomCreatorCommunityId);
	}
}
