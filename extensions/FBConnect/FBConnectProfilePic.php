<?php
/**
 * @author Sean Colombo
 * @date 20100608
 *
 * This file is designed to help pull Facebook profile pictures upon connection for wikis that use some sort
 * of avatar.  Since there aren't avatars in the default version of MediaWiki at the time of this writing, the
 * FBConnect extension may not use these functions, but they're avialable to make it easy to integrate into your
 * own customizations.  For an example of use, see Wikia's code.
 *
 * For documentation on the FQL used to retrieve the profile picture's URL, see:
 * http://developers.facebook.com/docs/reference/fql/profile
 */

define('FB_PIC_SMALL', 'pic_small'); // max 50x150
define('FB_PIC_SQUARE', 'pic_square'); // max 50x50
define('FB_PIC_BIG', 'pic_big'); // max 200x600
define('FB_PIC', 'pic'); // currently equivalent to pic_small according to fb documentation

class FBConnectProfilePic {
	// Using definitions above instead.
	//public static $FB_PIC_SMALL = 'pic_small'; // max 50x150
	//public static $FB_PIC_SQUARE = 'pic_square'; // max 50x50
	//public static $FB_PIC_BIG = 'pic_big'; // max 200x600
	//public static $FB_PIC = 'pic'; // currently equivalent to pic_small according to fb documentation

	private static $FQL_ROOT_URL = "http://api.facebook.com/method/"; // https requires extra work
	private static $FQL_QUERY_PREFIX = "fql.query?query=";
	private static $FBCONNECT_USER_AGENT = "FBConnect Extension for MediaWiki";

	/**
	 * Given a facebook id and optionally a size (from FB_PIC_* definitions), returns the
	 * URL of the profile picture for that size.
	 *
	 * Also includes an optional parameter for what user-agent to send with the request.
	 *
	 * If a profile picture url could not be found, returns an empty string.
	 */
	public static function getImgUrlById($fb_id, $size = "", $userAgent = ""){
		if(empty($size)){
			$size = FB_PIC_BIG; // get the full resolution by default, let custom scaling take care of making an actual limit.
		}
		if(empty($userAgent)){
			$userAgent = self::$FBCONNECT_USER_AGENT;
		}

		$fqlUrl = self::$FQL_ROOT_URL . self::$FQL_QUERY_PREFIX . "SELECT%20$size%20FROM%20profile%20WHERE%20id=$fb_id";
		$page = Http::get(
			$fqlUrl,
			"default", // timeout
			array(
				CURLOPT_USERAGENT      => $userAgent,
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_MAXREDIRS      => 5
			)
		);
		
		$profilePicUrl ="";
		if( $page ) {
			// Parse out the url
			if(0 < preg_match("/<profile[^>]*>.*?(http[s]?:\/\/[^<]*).*?<\/profile>/is", $page, $matches)){
				$profilePicUrl = $matches[1];
			} else {
				wfDebug("FBConnect: Could not find a profile picture for user id \"$fb_id\" using url: \"$fqlUrl\"");
			}
		} else {
			wfDebug("FBConnect: no content found for facebook fql query: \"$fqlUrl\". Make sure outbound requests are working from your MediaWiki install.\n");
		}

		return $profilePicUrl;
	} // end getImgById()

} // end class FBConnectProfilePic
