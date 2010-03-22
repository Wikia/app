<?php

abstract class FounderEmailsEvent {

	private $id = 0;
	protected $mType = null;
	protected $mData = array();
	protected $mConfig = null;

	protected function __construct($type) {
		global $wgFounderEmailsExtensionConfig;

		$this->mConfig = $wgFounderEmailsExtensionConfig['events'][$type];
		$this->mType = $type;
	}

	static public function newFromType( $eventType ) {
		global $wgFounderEmailsExtensionConfig;

		wfProfileIn( __METHOD__ );

		$sClassName = $wgFounderEmailsExtensionConfig['events'][$eventType]['className'];

		$oEvent = new $sClassName();

		wfProfileIn( __METHOD__ );
		return $oEvent;
	}

	static public function getConfig( $eventType = null ) {
		global $wgFounderEmailsExtensionConfig;

		return is_null($eventType) ? $wgFounderEmailsExtensionConfig['events'] : ( isset( $wgFounderEmailsExtensionConfig['events'][$eventType] ) ? $wgFounderEmailsExtensionConfig['events'][$eventType] : array() );
	}

	public function getID() {
		return $this->id;
	}

	public function setID($value) {
		$this->id = $value;
	}

	public function getType() {
		return $this->mType;
	}

	public function getData() {
		return $this->mData;
	}

	public function setData( Array $data ) {
		$this->mData = $data;
	}

	abstract public function process(Array $events);

	public static function register() {
		return true;
	}

	protected function isThresholdMet( $testValue ) {
		if(isset($this->mConfig['threshold'])) {
			return ( $testValue >= $this->mConfig['threshold'] ) ? true : false;
		}
		else {
			return true;
		}
	}

	public function create() {
		global $wgWikicitiesReadOnly, $wgExternalSharedDB, $wgCityId;

		wfProfileIn( __METHOD__ );
		if(!$wgWikicitiesReadOnly) {
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			$dbw->insert(
				"founder_emails_event",
				array(
					"feev_wiki_id" => $wgCityId,
					"feev_timestamp" => wfTimestampNow(),
					"feev_type" => $this->getType(),
					"feev_data" => serialize( $this->getData() )
				),
				__METHOD__
			);
			$this->id = $dbw->insertId();
		} else {
			$this->id = 0;
		}
		wfProfileOut( __METHOD__ );

		return $this->id;
	}

	protected function getLocalizedMsgBody($sMsgKey, $sLangCode, $params = array()) {
		$sBody = null;

		if(($sLangCode != 'en') && !empty($sLangCode)) {
			// custom lang translation
			$sBody = wfMsgExt($sMsgKey, array( 'language' => $sLangCode ) );
		}

		if($sBody == null) {
			$sBody = wfMsg( $sMsgKey );
		}

		return strtr( $sBody, $params );
	}

}
