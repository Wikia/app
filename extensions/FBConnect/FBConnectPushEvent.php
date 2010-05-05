<?php
/**
 * @author Sean Colombo
 *
 * This class is an extendable superclass for events to push to a facebook news-feed.
 *
 * To create a push event, override this class, then add it to config.php in the way
 * defined in config.sample.php.
 */

$wgExtensionFunctions[] = 'FBConnectPushEvent::initExtension';

// PreferencesExtension is needed up until 1.16, then the needed functionality is built in.
if (version_compare($wgVersion, '1.16', '>=')) {
	$wgHooks['GetPreferences'][] = 'FBConnectPushEvent::addPreferencesToggles';
}

class FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = ''; // implementing classes MUST override this with their own value.

	// This must correspond to the name of the message for the text on the tab itself.
	static protected $PREFERENCES_TAB_NAME = "fbconnect-prefstext";

	/**
	 * Accessor for the user preference to which (if set to 1) allows this type of event
	 * to be used.
	 */
	public function getUserPreferenceName(){
		return $this->isAllowedUserPreferenceName;
	}

	/**
	 * Initialize the extension itself.  This includes creating the user-preferences for
	 * the push events.
	 */
	static public function initExtension(){
		wfProfileIn(__METHOD__);

		// The push feature of the extension requires the publish_stream extended permission.
		global $fbExtendedPermissions;
		$PERMISSION_TO_PUBLISH = 'publish_stream';
		if(empty($fbExtendedPermissions) || !is_array($fbExtendedPermissions)){
			$fbExtendedPermissions = array($PERMISSION_TO_PUBLISH);
		} else if(!in_array($PERMISSION_TO_PUBLISH, $fbExtendedPermissions)){
			$fbExtendedPermissions[] = $PERMISSION_TO_PUBLISH;
		}

		// Make sure that all of the push events were configured correctly.
		self::initAll();

		// TODO: This initialization should only be run if the user is fb-connected.  Otherwise, the same Connect form as Special:Connect should be shown.
		// TODO: This initialization should only be run if the user is fb-connected.  Otherwise, the same Connect form as Special:Connect should be shown.

		// TODO: Can we detect if this is Special:Preferences and only add the checkboxes if that is the case?  Can't think of anything else that would break.
		// TODO: Can we detect if this is Special:Preferences and only add the checkboxes if that is the case?  Can't think of anything else that would break.


		// Only add the preferences using PreferencesExtension for versions prior to 1.16.
		// The code for 1.16+ will be done in FBConnectPushEvent::addPreferencesToggles
		global $wgVersion;
		if (version_compare($wgVersion, '1.16', '<')) {
			global $fbPushEventClasses;
			if(!empty($fbPushEventClasses)){
 				foreach($fbPushEventClasses as $pushEventClassName){
					$pushObj = new $pushEventClassName;
					$className = get_class();
					$prefName = $pushObj->getUserPreferenceName();

					// Adds the user-preferences (making use of the "PreferencesExtension" extension).
					wfAddPreferences(array(
						array(
							"name" => $prefName,
							"section" => self::$PREFERENCES_TAB_NAME,
							"type" => PREF_TOGGLE_T,
							//"size" => "", // Not relevant to this type.
							//"html" => "",
							//"min" => "",
							//"max" => "",
							//"validate" => "",
							//"save" => "",
							//"load" => "",
							"default" => "1",
						)
					));
				}
			}
		}

		wfProfileOut(__METHOD__);
	} // end initExtension()

	/**
	 * Adds enable/disable toggles to the Preferences form for controlling all push events.
	 *
	 * NOTE: This is only for v1.16+ of MW.  For prior versions, the toggles are added in initExtension().
	 */
	static public function addPreferencesToggles( $user, &$preferences ){
		global $fbPushEventClasses;
		if(!empty($fbPushEventClasses)){
			foreach($fbPushEventClasses as $pushEventClassName){
				$pushObj = new $pushEventClassName;
				$className = get_class();
				$prefName = $pushObj->getUserPreferenceName();

				$preferences[$prefName] = array(
					'type' => 'toggle',
					'label-message' => $prefName,
					'section' => self::$PREFERENCES_TAB_NAME,
				);
			}
		}

		return true;
	} // end addPreferencesToggles()
	
	/**
	 * This function returns HTML which contains toggles (in a list) for setting the push
	 * Preferences.  It is designed to be used inside of a form (such as on Special:Connect).
	 *
	 * This is not used by the code which adds the form to Special:Preferences.
	 *
	 * If firstTime is set to true, the checkboxes will default to being checked, otherwise
	 * they will default to the current user-option setting for the user.
	 */
	static public function createPreferencesToggles($firstTime = false){
		global $wgUser, $wgLang;
		global $fbPushEventClasses;
		wfProfileIn(__METHOD__);

		$html = "";
		if(!empty($fbPushEventClasses)){
			foreach($fbPushEventClasses as $pushEventClassName){
				$pushObj = new $pushEventClassName;
				$className = get_class();
				$prefName = $pushObj->getUserPreferenceName();

				$prefText = $wgLang->getUserToggle( $prefName );
				if($firstTime){
					$checked = ' checked="checked"';
				} else {
					$checked = $wgUser->getOption( $prefName ) == 1 ? ' checked="checked"' : '';
				}
				$html .= "<div class='toggle'>";
				$html .= "<input type='checkbox' value='1' id=\"$prefName\" name=\"$prefName\"$checked />";
				$html .= " <span class='toggletext'><label for=\"$prefName\">$prefText</label></span>";
				$html .= "</div>\n";
			}
		}

		wfProfileOut(__METHOD__);
		return $html;
	} // end createPreferencesToggles()

	/**
	 * This static function is called by the FBConnect extension if push events are enabled.  It checks
	 * to make sure that the configured push-events are valid and then gives them each a chance to initialize.
	 */
	static public function initAll(){
		global $fbPushEventClasses;
		wfProfileIn(__METHOD__);

		if(!empty($fbPushEventClasses)){
			// Fail fast (and hard) if a push event was coded incorrectly.
			foreach($fbPushEventClasses as $pushEventClassName){
				$pushObj = new $pushEventClassName;
				$className = get_class();
				$prefName = $pushObj->getUserPreferenceName();
				if(empty($prefName)){
					$dirName = dir( __FILE__ );
					$msg = "FATAL ERROR: The push event class <strong>\"$pushEventClassName\"</strong> does not return a valid user preference name! ";
					$msg.= " It was probably written incorrectly.  Either fix the class or remove it from being used in <strong>$dirName/config.php</strong>";
					die($msg);
				} else if(!is_subclass_of($pushObj, $className)){
					$msg = "FATAL ERROR: The push event class <strong>\"$pushEventClassName\"</strong> is not a subclass of <strong>$className</strong>! ";
					$msg.= " It was probably written incorrectly.  Either fix the class or remove it from being used in <strong>$dirName/config.php</strong>";
					die($msg);
				}

				// The push event is valid, let it initialize itself if needed.
				$pushObj->init();
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Overridable function to do any initialization needed by the push event.
	 *
	 * This is only called if this particular push-event is enabled in config.php
	 * and the getUserPreferenceName() call checks out (the result must be non-empty).
	 */
	public function init(){}


} // end FBConnectPushEvent class
