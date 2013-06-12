<?php

class GWTSiteSyncStatus {
	private $url;
	private $verified;
	private $pageVerificationCode;

	function __construct($url = null, $verified = null) {
		$this->url = $url;
		$this->verified = $verified;
	}

	private static function parseBoolean($value) {
		if ($value && strtolower($value) !== "false") {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * Parse xml content of google response.
	 * @param xml - xml content of google response ( DOMNode ).
	 * @return - GWTSiteSyncStatus.
	 */
	public static function fromDomElement( DOMNode $domNode ) {
		$status = new GWTSiteSyncStatus();
		$xpath = new DOMXPath($domNode->ownerDocument);

		$contentSrc = $xpath->query($domNode->getNodePath() . "//*[local-name()='content']/@src");
		$verified = $xpath->query($domNode->getNodePath() ."//*[local-name()='verified']");
		$verificationMethod = $xpath->query($domNode->getNodePath() ."//*[local-name()='verification-method']");

		for( $i=0; $i<$verificationMethod->length; $i++) {
			$node = $verificationMethod->item($i);
			if (preg_match('/google([a-f0-9]+)\.html/', $node->nodeValue, $matches)) {
				$status->setPageVerificationCode( $matches[1] );
			}
		}
		if( $contentSrc->length > 0  ) {
			$status->setUrl($contentSrc->item(0)->nodeValue);
		}
		if( $verified->length > 0 ) {
			$status->setVerified( self::parseBoolean($verified->item(0)->nodeValue) );
		}
		return $status;
	}

	/*
	 * Parse xml content of google response with many entries.
	 * @param xml - xml content of google response ( DOMNode ).
	 * @return - array of GWTSiteSyncStatus.
	 */
	public static function arrayFromDomDocument ( DOMDocument $document ) {
		$xpath = new DOMXPath($document);
		$nodeList = $xpath->query("//*[local-name()='entry']");
		$sites = array();
		for($j =0; $j<$nodeList->length; $j++) {
			$nodeList->item($j);
			$siteStatus = self::fromDomElement( $nodeList->item($j)  );
			if( $siteStatus != null ) {
				$sites[] = $siteStatus;
			}
		}
		return $sites;
	}

	public function setUrl($url) {
		$this->url = $url;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setVerified($verified) {
		$this->verified = $verified;
	}

	public function getVerified() {
		return $this->verified;
	}

	public function setPageVerificationCode($pageVerificationCode) {
		$this->pageVerificationCode = $pageVerificationCode;
	}

	public function getPageVerificationCode() {
		return $this->pageVerificationCode;
	}
}
