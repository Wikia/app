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
$wgHooks['GetPreferences'][] = 'FBConnectPushEvent::addPreferencesToggles';

$wgAjaxExportList[] = "FBConnectPushEvent::showImage";

class FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = ''; // implementing classes MUST override this with their own value.

	// This must correspond to the name of the message for the text on the tab itself.
	static private $eventCounter = 0;
	static protected $PREFERENCES_TAB_NAME = "fbconnect-prefstext/fbconnect-event-prefstext";
	static public $PREF_TO_DISABLE_ALL = "fbconnect-push-allow-never";

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

		/**
		 * running this extension in maintenance scripts preventing rebuildCache from running
		 */
		global $wgCommandLineMode;
		if( $wgCommandLineMode == true ) {
			return;
		}
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

		wfProfileOut(__METHOD__);
	} // end initExtension()

	/**
	 * Adds enable/disable toggles to the Preferences form for controlling all push events.
	 *
	 */
	static public function addPreferencesToggles( $user, &$preferences ){
		wfProfileIn(__METHOD__);
		global $fbPushEventClasses, $wgUser;
		$id = FBConnectDB::getFacebookIDs($wgUser);
		if( count($id) > 0 ) {
			if(!empty($fbPushEventClasses)){
				foreach($fbPushEventClasses as $pushEventClassName){
					$pushObj = new $pushEventClassName;
					$className = get_class();
					$prefName = $pushObj->getUserPreferenceName();

					$preferences[$prefName] = array(
						'type' => 'toggle',
						'label-message' => 'tog-'.$prefName,
						'section' => self::$PREFERENCES_TAB_NAME,
					);

					/* < v1.16 */
					if( defined('PREF_TOGGLE_T') ) {
						$preferences[$prefName]['int-type'] = PREF_TOGGLE_T;
						$preferences[$prefName]['name'] = $prefName;
					}
				}
			}
		}
		wfProfileOut(__METHOD__);
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
	 *
	 * There is also an option which will disable all push events.
	 */
	static public function getPreferencesToggles($firstTime = false){
		global $wgUser, $wgLang;
		global $fbPushEventClasses;
		wfProfileIn(__METHOD__);
		$results = array();
		if(!empty($fbPushEventClasses)){
			foreach($fbPushEventClasses as $pushEventClassName){
				$pushObj = new $pushEventClassName;
				$prefName = $pushObj->getUserPreferenceName();

				$prefText = $wgLang->getUserToggle( $prefName );
				$prefTextShort = $wgLang->getUserToggle($prefName.'-short');

				$result = array(
					'id' => $prefName,
					'name' => $prefName,
					'section' => self::$PREFERENCES_TAB_NAME,
					'text' => $prefText,
					'shortText' => $prefTextShort,
					'checked' => true
				);

				$results[] = $result;
			}

			// Create an option to opt out of all current and future push-events.
			$prefName = self::$PREF_TO_DISABLE_ALL;
			$prefText = wfMsg('tog-' . self::$PREF_TO_DISABLE_ALL);

			$result = array(
					'fullLine' => true,
					'id' => $prefName,
					'name' => $prefName,
					'section' => self::$PREFERENCES_TAB_NAME,
					'text' => $prefText,
					'shortText' => $prefText
			);

			$results[] = $result;
		}

		wfProfileOut(__METHOD__);
		return $results;
	} // end createPreferencesToggles()

	/**
	 * This static function is called by the FBConnect extension if push events are enabled.  It checks
	 * to make sure that the configured push-events are valid and then gives them each a chance to initialize.
	 */
	static public function initAll(){
		global $fbPushEventClasses, $wgUser;
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
				if( !$wgUser->getOption(self::$PREF_TO_DISABLE_ALL) ) {
					if( $wgUser->getOption($prefName) ) {
						$pushObj->init();
					}
				}
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



	/**
	 * put facebook message
	 * @author Tomasz Odrobny
	 */

	static public function pushEvent($message, $params, $class){
		global $wgServer, $wgUser;

		$id = FBConnectDB::getFacebookIDs($wgUser);
		if( count($id) < 1 ) {
			return 1001; //status for disconnected
		}
		/* only one event par request */
		if( self::$eventCounter > 0 ) {
			return 1000; //status for out of limit
		}

		self::$eventCounter++ ;

		if( wfRunHooks( 'FBConnect::BeforePushEvent', array( $id, &$message, &$params, &$class ) ) ) {
			$fb = new FBConnectAPI();

			$image = $params['$EVENTIMG'];
			if( strpos( $params['$EVENTIMG'], 'http://' ) === false ) {
				$image = $wgServer.'/index.php?action=ajax&rs=FBConnectPushEvent::showImage&time='.time().'&fb_id='.$wgUser->getId()."&event=".$class.'&img='.$params['$EVENTIMG'];
			}

			$href = $params['$ARTICLE_URL'];
			$description = wfMsg( $message ) ;
			$link = wfMsg( $message.'-link' ) ;
			$short = wfMsg( $message.'-short' ) ;

			$params['$FB_NAME'] = "";
			foreach ($params as $key => $value) {
				if( $value instanceof Article ) {
					continue;
				}

				$description = str_replace($key, $value, $description);
				$link = str_replace($key, $value, $link);
				$short = str_replace($key, $value, $short);
			}

			$status = $fb->publishStream( $href, $description, $short, $link, $image);
			return $status;
		}

		return false;
	}

	/**
	 * short text for blog
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	static public function shortenText($source_text, $char_count = 100)
	{
		$source_text = preg_replace('/(<figure.+?)+(<\/figure>)/i', '', $source_text);

		$source_text = self::stripHtmlTags($source_text);
		$source_text = trim($source_text);
		$source_text_no_endline = str_replace("\n", " ", $source_text);

		if ($source_text == "" ){
			return "";
		}

		if (strlen($source_text) <= $char_count ) {
			return $source_text;
		}

		$source_text_out = substr($source_text, 0, strrpos(substr($source_text_no_endline, 0, $char_count), ' '));

		if ($source_text_out == "" ){
			$source_text_out = substr($source_text, 0, $char_count);
		}

		if ($source_text_out != $source_text) {
			$source_text = $source_text_out.'...';
		}

		return $source_text;
	}

	/**
	 * cleans html tags and content between.
	 *
	 * @author Jakub Kurcek
	 * @access public
	 *
	 */

	static public function stripHtmlTags( $text )
	{
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
			),
			array(
			    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '
			),
			$text
		);
		return strip_tags( $text );
	}

	/**
	 * easy parse of article text
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */
	static public function parseArticle(&$qArticle, $text = null) {
		$articleText = $qArticle->getRawText();
		if ( $text != null ) {
			$articleText = $text;
		}
		$title = $qArticle->getTitle();
		$tmpParserOptions = new ParserOptions();
		$html = ParserPool::parse( $articleText, $title, $tmpParserOptions)->getText();
		return $html;
	}

	/**
	 * ajax function to count number of feed display in fbconnect
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */
	static public function showImage() {
		global $wgStylePath, $wgRequest;
		$redirect = $wgStylePath.'/common/fbconnect/'.$wgRequest->getVal('img', '0');
		header("Location: $redirect");
		exit;
	}

} // end FBConnectPushEvent class
