<?php

class AnnouncementsController extends WikiaController {

	const WIKI_ID = 'wikiId';
	const PERIOD = 'period';

	private $announcements = null;

	public function __construct() {
		parent::__construct();

		$this->announcements = new Announcements();
	}

	/**
	 * @desc Get list of user ids who created/edited any page on specific wiki in given amount of time
	 *
	 * @return int {Array} list of user IDs
	 *
	 * @throws BadRequestException
	 */
	public function getActiveUsers() {

		$wikiId = $this->request->getInt( self::WIKI_ID );
		$period = $this->request->getInt( self::PERIOD );

		if ( $period == 0 || $wikiId == 0 ) {
			throw new BadRequestException( "You must define both wikiId and period" );
		}

		$userIds = $this->announcements->getActiveUsers($wikiId, $period);

		$this->response->setData($userIds ?: []);
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}
