<?php

class AnnouncementsController extends WikiaController {

	const WIKI_ID = 'wikiId';
	const DAYS = 'days';

	private $announcements = null;

	public function __construct() {
		parent::__construct();

		$this->announcements = new Announcements();
	}

	/**
	 * @desc Get list of user ids who created/edited any page on specific wiki in given amount of time
	 *
	 * @throws BadRequestException
	 * @throws DBUnexpectedError
	 */
	public function getActiveUsers() {

		$wikiId = $this->request->getInt( self::WIKI_ID );
		$days = $this->request->getInt( self::DAYS );

		if ( $days == 0 || $wikiId == 0 ) {
			throw new BadRequestException( "You must define both wikiId and days" );
		}

		$userIds = $this->announcements->getActiveUsers($wikiId, $days);

		$this->response->setData($userIds ?: []);
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}
