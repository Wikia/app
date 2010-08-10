<?php

/* This ad provider is effectively a no-op, just return a comment instead of any real code.
 * The idea is that errors with ads should not prevent the page from loading.
 * Null ad is also used in situations when the ads are not displayed, such
 * as when a user is logged in
 *
 * A message with the reason for not displaying the ad is passed into the constructor,
 * along with an optional argument to log it as an error.
 */

class AdProviderNull implements iAdProvider {

	protected static $instance = false;

	private $reason;

        private $slotsToCall = array();

        public function addSlotToCall($slotname){
                $this->slotsToCall[]=$slotname;
        }

	public function batchCallAllowed(){ return false; }
	public function getSetupHtml(){ return false; }
	public function getBatchCallHtml(){ return false; }


	/* @param reason - a note for why NULL ad is being used.
 	 * @param logError - whether to log this as an error
 	 */
	public function __construct($reason, $logError = false){
		$this->reason = $reason; 
		if ($logError){
			error_log("AdEngine: $reason from {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", E_USER_WARNING);
		}
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderNull();
		}
		return self::$instance;
	}

	// Note that $slotname and $slot may not always be available.
	public function getAd($slotname, $slot, $params = null) {
		$out = '<!-- Null Ad. Reason: ' . htmlspecialchars($this->reason) .
		       ', slotname=' . $slotname . ' -->';
		return $out;
	}

}
