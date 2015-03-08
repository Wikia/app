<?php

/**
 * Helper methods for handling DMCA Requests.
 *
 * @author grunny
 */

namespace DMCARequest;

class DMCARequestHelper {
	const DMCA_SUBMISSION_EMAIL = 'copyright@wikia.com';

	public $requestorTypes = [
		1 => 'copyrightholder',
		2 => 'representative',
		3 => 'none',
	];

	/**
	 * Available values for action taken on the request as defined
	 * in the ChillingEffects API.
	 *
	 * @var array
	 */
	public $availableActions = [
		'Yes',
		'No',
		'Partial',
	];

	private $noticeId;
	private $noticeData = [];

	/**
	 * Get the current notice data set on the object.
	 *
	 * @return array The notice data
	 */
	public function getNoticeData() {
		return $this->noticeData;
	}

	/**
	 * Sets the notice data on the object.
	 *
	 * @param array $noticeData The notice data to set
	 */
	public function setNoticeData( array $noticeData ) {
		$this->noticeData = array_merge( $this->noticeData, $noticeData );
	}

	/**
	 * Save the notice data to the database.
	 *
	 * @return boolean Whether the notice was successfully saved
	 */
	public function saveNotice() {
		$dbw = $this->getDB( DB_MASTER );

		if ( empty( $this->noticeData ) ) {
			return false;
		}

		$row = [
			'dmca_date' => wfTimestamp( TS_DB ),
			'dmca_requestor_type' => $this->noticeData['type'],
			'dmca_fullname' => $this->noticeData['fullname'],
			'dmca_email' => $this->noticeData['email'],
			'dmca_address' => $this->noticeData['address'],
			'dmca_telephone' => $this->noticeData['telephone'],
			'dmca_original_urls' => $this->noticeData['original_urls'],
			'dmca_infringing_urls' => $this->noticeData['infringing_urls'],
			'dmca_comments' => $this->noticeData['comments'],
			'dmca_signature' => $this->noticeData['signature'],
		];

		$result = $dbw->insert(
			'dmca_request',
			$row,
			__METHOD__
		);

		if ( $result ) {
			$this->noticeId = $dbw->insertId();
		}

		return $result;
	}

	/**
	 * Load the notice ID from the database into the object.
	 *
	 * @param  int     $noticeId The ID of the notice to load
	 * @return boolean           Whether or not the notice was loaded
	 */
	public function loadNotice( $noticeId ) {
		$dbr = $this->getDB();

		$notice = $dbr->selectRow(
			'dmca_request',
			[ '*' ],
			[
				'dmca_id' => $noticeId,
			],
			__METHOD__
		);

		if ( !$notice ) {
			return false;
		}

		$this->noticeId = $notice->dmca_id;

		$this->setNoticeData( [
			'type' => $notice->dmca_requestor_type,
			'date' => $notice->dmca_date,
			'fullname' => $notice->dmca_fullname,
			'email' => $notice->dmca_email,
			'address' => $notice->dmca_address,
			'telephone' => $notice->dmca_telephone,
			'original_urls' => $notice->dmca_original_urls,
			'infringing_urls' => $notice->dmca_infringing_urls,
			'comments' => $notice->dmca_comments,
			'signature' => $notice->dmca_signature,
		] );

		return true;
	}

	/**
	 * Send notice to the submission email address.
	 *
	 * @param  array   $attachments Any images attached to attach to the email
	 * @return boolean              The success of sending the email
	 */
	public function sendNoticeEmail() {
		$recipient = new \MailAddress( self::DMCA_SUBMISSION_EMAIL );
		$sender = new \MailAddress( $this->noticeData['email'] );

		// We only want English emails sent to the address, and don't want to allow
		// local on-wikia modifications of the messages
		$subject = wfMessage( 'dmcarequest-email-subject' )->inLanguage( 'en' )->useDatabase( false )->escaped();
		$body = $this->getNoticeText();

		$result = \UserMailer::send( $recipient, $recipient, $subject,
			$body, $sender, null, 'DMCARequest', 0, $this->noticeData['screenshots'] );

		return $result->isOK();
	}

	/**
	 * Update the action taken on the notice.
	 *
	 * @param  int     $noticeId The ID of the notice to update
	 * @param  string  $action   The action taken
	 * @return boolean           Whether the update was successful
	 */
	public function updateAction( $noticeId, $action ) {
		$dbw = $this->getDB( DB_MASTER );

		if ( !in_array( $action, $this->availableActions ) ) {
			return false;
		}

		$result = $dbw->update(
			'dmca_request',
			[
				'dmca_action_taken' => $action,
			],
			[
				'dmca_id' => $noticeId,
			],
			__METHOD__
		);

		return $result;
	}

	/**
	 * Get the text of the notice using a i18n message as a template.
	 *
	 * Used to construct the email sent to staff. We only want the
	 * message in English and we don't want to allow local customisations
	 * by admins, so we make use of ->useDatabase( false ).
	 *
	 * @return string The notice text
	 */
	public function getNoticeText() {
		return wfMessage( 'dmcarequest-email-text', [
			$this->noticeData['fullname'],
			$this->noticeData['address'],
			$this->noticeData['email'],
			$this->noticeData['telephone'],
			// Messages used here:
			// * dmcarequest-request-type-copyrightholder
			// * dmcarequest-request-type-representative
			// * dmcarequest-request-type-none
			wfMessage( "dmcarequest-request-type-{$this->requestorTypes[$this->noticeData['type']]}" )->plain(),
			$this->noticeData['original_urls'],
			$this->noticeData['infringing_urls'],
			wfMessage( 'dmcarequest-request-good-faith-label' )->plain(),
			wfMessage( 'dmcarequest-request-perjury-label' )->plain(),
			wfMessage( 'dmcarequest-request-wikiarights-label' )->plain(),
			$this->noticeData['comments'],
			$this->noticeData['signature'],
			\SpecialPage::getTitleFor( 'DMCARequestManagement', $this->noticeId )->getFullURL(),
		] )->inLanguage( 'en' )->useDatabase( false )->escaped();
	}

	/**
	 * Get the Database object for the storage of DMCA requests.
	 *
	 * @param  int          $mode Index of the connection to get
	 * @return DatabaseBase       The Database object
	 */
	private function getDB( $mode = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $mode, [], $wgExternalSharedDB );
	}
}
