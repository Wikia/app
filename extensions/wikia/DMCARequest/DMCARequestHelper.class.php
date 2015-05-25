<?php

/**
 * Helper methods for handling DMCA Requests.
 *
 * @author grunny
 */

namespace DMCARequest;

class DMCARequestHelper {
	const DMCA_SUBMISSION_EMAIL = 'copyright@wikia.com';

	/**
	 * Available values for action taken on the request as defined
	 * in the ChillingEffects API.
	 *
	 * @var array
	 */
	private $availableActions = [
		'Yes',
		'No',
		'Partial',
	];

	private $requestorTypes = [
		1 => 'copyrightholder',
		2 => 'representative',
		3 => 'none',
	];

	private $senderTypes = [
		'organization',
		'individual',
	];

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
	 * Get a list of valid types of DMCA requestors.
	 *
	 * @return array List of valid types of requestor
	 */
	public function getRequestorTypes() {
		return $this->requestorTypes;
	}

	/**
	 * Check if a valid requestor type was provided.
	 *
	 * @param  int     $type The type ot check
	 * @return boolean
	 */
	public function isValidRequestorType( $type ) {
		return in_array( $type, array_keys( $this->requestorTypes ) );
	}

	/**
	 * Get a list of valid actions taken on DMCA requestors.
	 *
	 * @return array List of valid actions
	 */
	public function getActions() {
		return $this->availableActions;
	}

	/**
	 * Check if a given action is valid for the ChillingEffects API.
	 *
	 * @param  string  $action Action text.
	 * @return boolean
	 */
	public function isValidAction( $action ) {
		return in_array( $action, array_keys( $this->availableActions ) );
	}

	/**
	 * Get a list of valid sender types.
	 *
	 * @return array List of valid sender types
	 */
	public function getSenderTypes() {
		return $this->senderTypes;
	}

	/**
	 * Check if a given sender type is valid for the ChillingEffects API.
	 *
	 * @param  string  $action Action text.
	 * @return boolean
	 */
	public function isValidSenderType( $type ) {
		return in_array( $type, array_keys( $this->senderTypes ) );
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
			$this->noticeData['id'] = $dbw->insertId();
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

		$this->setNoticeData( [
			'id' => $notice->dmca_id,
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
			'ce_id' => $notice->dmca_ce_id,
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
	 * Set the ID of the notice on ChillingEffects.
	 *
	 * @param  int     $noticeId   The ID of the notice to update
	 * @param  string  $ceNoticeId The ID on ChillingEffects
	 * @return boolean             Whether the update was successful
	 */
	public function setChillingEffectsNoticeId( $noticeId, $ceNoticeId ) {
		$dbw = $this->getDB( DB_MASTER );

		$result = $dbw->update(
			'dmca_request',
			[
				'dmca_ce_id' => $ceNoticeId,
			],
			[
				'dmca_id' => $noticeId,
			],
			__METHOD__
		);

		if ( $result ) {
			$dbw->commit( __METHOD__ );
			$this->noticeData['ce_id'] = $ceNoticeId;
		}

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
			wfMessage( "dmcarequest-request-type-{$this->requestorTypes[$this->noticeData['type']]}" )
				->inLanguage( 'en' )->useDatabase( false )->plain(),
			$this->noticeData['original_urls'],
			$this->noticeData['infringing_urls'],
			wfMessage( 'dmcarequest-request-good-faith-label' )->inLanguage( 'en' )->useDatabase( false )->plain(),
			wfMessage( 'dmcarequest-request-perjury-label' )->inLanguage( 'en' )->useDatabase( false )->plain(),
			wfMessage( 'dmcarequest-request-wikiarights-label' )->inLanguage( 'en' )->useDatabase( false )->plain(),
			$this->noticeData['comments'],
			$this->noticeData['signature'],
			\GlobalTitle::newFromText( 'DMCARequestManagement/' . $this->noticeData['id'],
				NS_SPECIAL, \Wikia::COMMUNITY_WIKI_ID )->getFullURL(),
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
