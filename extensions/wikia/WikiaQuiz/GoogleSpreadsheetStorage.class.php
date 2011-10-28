<?php

/**
 * This class implements GoogleDocs spreadsheet as a storage.
 *
 * No support for reading data!
 *
 * @author macbre
 */

class GoogleSpreadsheetStorage {

	private $login;
	private $pass;
	private $spreadsheetId;
	private $worksheetId;

	private $authToken;

	/**
	 * Gains access to given spreadsheet using provided credentials.
	 */
	function __construct($login, $pass, $spreadsheetId, $worksheetId) {
		$this->login = $login;
		$this->pass = $pass;
		$this->spreadsheetId = $spreadsheetId;
		$this->worksheetId = $worksheetId;
	}

	/**
	 * Performs authentication into Google's API. Sets authorization token.
	 */
	public function authenticate() {
		if (is_null($this->authToken)) {
			wfDebug(__METHOD__ . " - logging in as '{$this->login}'..\n");

			$postFields = array(
				'Email'       => $this->login,
				'Passwd'      => $this->pass,
				'accountType' => 'GOOGLE',
				'source'      => 'WIKIA',
				'service'     => __CLASS__,
			);

			$content = Http::post('https://www.google.com/accounts/ClientLogin', null, array(CURLOPT_POSTFIELDS => $postFields));

			if (preg_match('/Auth=(\S+)/', $content, $matches)) {
	    		$this->authToken = $matches[1];

				wfDebug(__METHOD__ . " - auth token received\n");
	    	}
		}

		return $this->authToken !== null;
	}

	/**
	 * Adds given row to a spreadsheet
	 */
	public function addRow($data) {

	}

	/**
	 * Fetches spreadsheet's meta data
	 */
	public function getMeta() {

	}
}
