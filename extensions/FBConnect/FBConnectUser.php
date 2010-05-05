<?php
/*
 * Copyright © 2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


/**
 * Class FBConnectUser
 * 
 * Extends the User class.
 */
class FBConnectUser extends User {
	/**
	 * Constructor: Create this object from an existing User. Bonus points if
	 * the existing User was created form an ID and has not yet been loaded! 
	 */
	function __construct($user) {
		$this->mId = $user->getId();
		$this->mFrom = 'id';
	}
	
	/**
	 * Update a user's settings with the values retrieved from the current
	 * logged-in Facebook user. Settings are only updated if a different value
	 * is returned from Facebook and the user's settings allow an update on
	 * login.
	 */
	function updateFromFacebook() {
		wfProfileIn(__METHOD__);

		// Keep track of whether any settings were modified
		$mod = false;
		// Connect to the Facebook API and retrieve the user's info 
		$fb = new FBConnectAPI();
		$userinfo = $fb->getUserInfo();
		// Update the following options if the user's settings allow it
		$updateOptions = array('nickname', 'fullname', 'language',
		                       'timecorrection', 'email');
		foreach ($updateOptions as $option) {
			// Translate Facebook parameters into MediaWiki parameters
			$value = self::getOptionFromInfo($option, $userinfo); 
			if ($value && ($this->getOption("fbconnect-update-on-login-$option", "0") == "1")) {
				switch ($option) {
					case 'fullname':
						$this->setRealName($value);
						break;
					default:
						$this->setOption($option, $value);
				}
				$mod = true;
			}
		}
		// Only save the updated settings if something was changed
		if ($mod) {
			$this->saveSettings();
		}
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Helper function for updateFromFacebook(). Takes an array of info from
	 * Facebook, and looks up the corresponding MediaWiki parameter.
	 */
	static function getOptionFromInfo($option, $userinfo) {
		// Lookup table for the names of the settings
		$params = array('nickname'       => 'username',
		                'fullname'       => 'name',
		                'firstname'      => 'first_name',
		                'gender'         => 'sex',
		                'language'       => 'locale',
		                'timecorrection' => 'timezone',
		                'email'          => 'contact_email');
		if (empty($userinfo)) {
			return null;
		}
		$value = array_key_exists($params[$option], $userinfo) ? $userinfo[$params[$option]] : '';
		// Special handling of several settings
		switch ($option) {
			case 'fullname':
			case 'firstname':
				// If real names aren't allowed, then simply ignore the parameter from Facebook
				global $wgAllowRealName;
				if (!$wgAllowRealName) {
					$value = '';
				}
				break;
			case 'gender':
				// Unfortunately, Facebook genders are localized (but this might change)
				if ($value != 'male' || $value != 'female') {
					$value = '';
				}
				break;
			case 'language':
				/**
				 * Convert Facebook's locale into a MediaWiki language code.
				 * For an up-to-date list of Facebook locales, see:
				 * <http://wiki.developers.facebook.com/index.php/Facebook_Locales>.
				 * For an up-to-date list of MediaWiki languages, see:
				 * <http://svn.wikimedia.org/svnroot/mediawiki/trunk/phase3/languages/Names.php>.
				 */
				if ($value == '') {
					break;
				}
				// These regional languages get special treatment
				$locales = array('en_PI' => 'en', # Pirate English
				                 'en_GB' => 'en-gb', # British English
				                 'en_UD' => 'en', # Upside Down English
				                 'fr_CA' => 'fr', # Canadian French
				                 'fb_LT' => 'en', # Leet Speak
				                 'pt_BR' => 'pt-br', # Brazilian Portuguese
				                 'zh_CN' => 'zh-cn', # Simplified Chinese
				                 'es_ES' => 'es', # European Spanish
				                 'zh_HK' => 'zh-hk', # Traditional Chinese (Hong Kong)
				                 'zh_TW' => 'zh-tw'); # Traditional Chinese (Taiwan)
				if (array_key_exists($value, $locales)) {
					$value = $locales[$value];
				} else {
					// No special regional treatment exists in MW; chop it off
					$value = substr($value, 0, 2);
				}
				break;
			case 'timecorrection':
				// Convert the timezone into a local timezone correction
				// TODO: $value = TimezoneToOffset($value);
				$value = '';
				break;
			case 'email':
				// If a contact email isn't available, then use a proxied email
				if ($value == '') {
					// TODO: update the user's email from $userinfo['proxied_email']
					// instead (the address must stay hidden from the user)
					$value = '';
				}
				// TODO: if the user's email is updated from Facebook, then
				// automatically authenticate the email address
				#$user->mEmailAuthenticated = wfTimestampNow();
		}
		// If an appropriate value was found, return it
		return $value == '' ? null : $value;
	}
}
