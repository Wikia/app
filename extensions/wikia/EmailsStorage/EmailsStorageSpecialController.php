<?php

class EmailsStorageSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Emails', 'emailsstorage', false /* $listed */ );
	}

	public function init() {

	}

	public function index() {
		// obey access rights
		if ( !$this->userCanExecute($this->app->wg->User) ) {
			$this->displayRestrictionError();
			return false;
		}

		// handle CSV export (POST requests)
		if( $this->request->wasPosted() ) {
			$this->printEntriesAsCsv($this->app->wg->Request->getInt('type'));
			return false;
		}

		$this->wg->Out->setPageTitle(wfMsg('emailsstorage'));

		$this->buttonAction = $this->app->wg->Title->getLocalUrl();
		$this->typeList = (new EmailsStorage() )->getSourcesId();
	}

	public function printEntriesAsCsv($typeId) {
		$csv = new CsvService();
		// print header
		$csv->printHeaders('game_entries.csv');
		$csv->printRow(array(
			'Game ID',
			'Wiki ID',
			'Email',
			'User ID',
			'Feedback'
		));
		$data = ( new EmailsStorage() )->getAllBySourceId($typeId);
		foreach($data as $row) {
			$csvRow = array(
				$row->getPageId(),
				$row->getCityId(),
				$row->getEmail(),
				$row->getUserId(),
				$row->getFeedback(),
			);
			$csv->printRow($csvRow);
		}
	}
}
