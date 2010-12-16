<?php
/**
 * A special page to allow users to update their social profile
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialUpdateProfile extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UpdateProfile' );
	}

	function initProfile() {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$s = $dbw->selectRow(
			'user_profile',
			array( 'up_user_id' ),
			array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);
		if ( $s === false ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert(
				'user_profile',
				array( 'up_user_id' => $wgUser->getID() ),
				__METHOD__
			);
		}
	}

	/**
	 * Show the special page
	 *
	 * @param $section Mixed: parameter passed to the page or null
	 */
	public function execute( $section ) {
		global $wgUser, $wgOut, $wgRequest, $wgUserProfileScripts, $wgUpdateProfileInRecentChanges, $wgSupressPageTitle;
		$wgSupressPageTitle = true;

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'edit-profile-title' ) ) );

		// This feature is only available for logged-in users.
		if ( !$wgUser->isLoggedIn() ) {
			$wgOut->setPageTitle( wfMsgForContent( 'user-profile-update-notloggedin-title' ) );
			$wgOut->addHTML(
				wfMsgForContent( 'user-profile-update-notloggedin-text',
					SpecialPage::getTitleFor( 'Userlogin' )->escapeFullURL(),
					SpecialPage::getTitleFor( 'Userlogin', 'signup' )->escapeFullURL()
				)
			);
			return;
		}

		// No need to allow blocked users to access this page, they could abuse it, y'know.
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Database operations require write mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// Add CSS & JS
		$wgOut->addExtensionStyle( $wgUserProfileScripts . '/UserProfile.css' );
		$wgOut->addScriptFile( $wgUserProfileScripts . '/UpdateProfile.js' );

 		if ( $wgRequest->wasPosted() ) {
			if ( !$section ) {
				$section = 'basic';
			}
			switch( $section ) {
				case 'basic':
					$this->saveProfileBasic();
					$this->saveSettings_basic();
					break;
				case 'personal':
					$this->saveProfilePersonal();
					break;
				case 'custom':
					$this->saveProfileCustom();
					break;
				case 'preferences':
					$this->saveSettings_pref();
					break;
			}

			UserProfile::clearCache( $wgUser->getID() );

			$log = new LogPage( wfMsgForContent( 'user-profile-update-profile' ) );
			if ( !$wgUpdateProfileInRecentChanges ) {
				$log->updateRecentChanges = false;
			}
			$log->addEntry(
				wfMsgForContent( 'user-profile-update-profile' ),
				$wgUser->getUserPage(),
				wfMsgForContent( 'user-profile-update-log-section' ) .
					" '{$section}'"
			);
			$wgOut->addHTML( '<span class="profile-on">' . wfMsg( 'user-profile-update-saved' ) . '</span><br /><br />' );

			// create user page if not exists
			$title = Title::makeTitle( NS_USER, $wgUser->getName() );
			$article = new Article( $title );
			if ( !$article->exists() ) {
				$article->doEdit( '', 'create user page', EDIT_SUPPRESS_RC );
			}
		}

		if ( !$section ) {
			$section = 'basic';
		}
		switch( $section ) {
			case 'basic':
				$wgOut->addHTML( $this->displayBasicForm() );
				break;
			case 'personal':
				$wgOut->addHTML( $this->displayPersonalForm() );
				break;
			case 'custom':
				$wgOut->addHTML( $this->displayCustomForm() );
				break;
			case 'preferences':
				$wgOut->addHTML( $this->displayPreferencesForm() );
				break;
		}
	}

	function saveSettings_basic() {
		global $wgUser, $wgRequest, $wgEmailAuthentication;

		$wgUser->setRealName( $wgRequest->getVal( 'real_name' ) );
		$wgUser->setEmail( $wgRequest->getVal( 'email' ) );

		if ( $wgUser->getEmail() != $wgRequest->getVal( 'email' ) ) {
			$wgUser->mEmailAuthenticated = null; # but flag as "dirty" = unauthenticated
		}

		if ( $wgEmailAuthentication && !$wgUser->isEmailConfirmed() ) {
			# Mail a temporary password to the dirty address.
			# User can come back through the confirmation URL to re-enable email.
			$result = $wgUser->sendConfirmationMail();
			if ( WikiError::isError( $result ) ) {
				$error = wfMsg( 'mailerror', htmlspecialchars( $result->getMessage() ) );
			} else {
				$error = wfMsg( 'eauthentsent', $wgUser->getName() );
			}
		}
		$wgUser->saveSettings();
	}

	function saveSettings_pref() {
		global $wgUser, $wgOut, $wgRequest, $wgSitename;

		$notify_friend = $wgRequest->getVal( 'notify_friend' );
		$notify_gift = $wgRequest->getVal( 'notify_gift' );
		$notify_challenge = $wgRequest->getVal( 'notify_challenge' );
		$notify_honorifics = $wgRequest->getVal( 'notify_honorifics' );
		$notify_message = $wgRequest->getVal( 'notify_message' );
		if ( $notify_friend == '' ) {
			$notify_friend = 0;
		}
		if ( $notify_gift == '' ) {
			$notify_gift = 0;
		}
		if ( $notify_challenge == '' ) {
			$notify_challenge = 0;
		}
		if ( $notify_honorifics == '' ) {
			$notify_honorifics = 0;
		}
		if ( $notify_message == '' ) {
			$notify_message = 0;
		}
		$wgUser->setOption( 'notifygift', $notify_gift );
		$wgUser->setOption( 'notifyfriendrequest', $notify_friend );
		$wgUser->setOption( 'notifychallenge', $notify_challenge );
		$wgUser->setOption( 'notifyhonorifics', $notify_honorifics );
		$wgUser->setOption( 'notifymessage', $notify_message );
		$wgUser->saveSettings();
		// This code is mostly related to ArmchairGM, however can be fixed to be used for others.
		if ( $wgSitename == 'ArmchairGM' ) {
			$dbw = wfGetDB( DB_MASTER );
			// If the user wants a weekly email, we'll put some info about that to the user_mailing_list table
			if ( $wgRequest->getVal( 'weeklyemail' ) == 1 ) {
				$s = $dbw->selectRow(
					'user_mailing_list',
					array( 'um_user_id' ),
					array( 'um_user_id' => $wgUser->getID() ),
					__METHOD__
				);
				if ( $s === false ) {
					$dbw->insert(
						'user_mailing_list',
						array(
							'um_user_id' => $wgUser->getID(),
							'um_user_name' => $wgUser->getName(),
						),
						__METHOD__
					);
				}
			} else {
				// Otherwise, just delete the entry.
				$dbw->delete(
					'user_mailing_list',
					array( 'um_user_id' => $wgUser->getID() ),
					__METHOD__
				);
			}
		}
	}

	function formatBirthdayDB( $birthday ) {
		$dob = explode( '/', $birthday );
		if ( count( $dob ) == 2 ) {
			$year = 2007;
			$month = $dob[0];
			$day = $dob[1];
			$birthday_date = $year . '-' . $month . '-' . $day;
		}
		return ( $birthday_date );
	}

	function formatBirthday( $birthday ) {
		$dob = explode( '-', $birthday );
		if ( count( $dob ) == 3 ) {
			$year = 0000;
			$month = $dob[1];
			$day = $dob[2];
			$birthday_date = $month . '/' . $day; // . '/' . $year;
		}
		return $birthday_date;
	}

	function saveProfileBasic() {
		global $wgUser, $wgMemc, $wgRequest, $wgSitename;

		$this->initProfile();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_profile',
		/* SET */array(
				'up_location_city' => $wgRequest->getVal( 'location_city' ),
				'up_location_state' => $wgRequest->getVal( 'location_state' ),
				'up_location_country' => $wgRequest->getVal( 'location_country' ),

				'up_hometown_city' => $wgRequest->getVal( 'hometown_city' ),
				'up_hometown_state' => $wgRequest->getVal( 'hometown_state' ),
				'up_hometown_country' => $wgRequest->getVal( 'hometown_country' ),

				'up_birthday' => $this->formatBirthdayDB( $wgRequest->getVal( 'birthday' ) ),
				'up_about' => $wgRequest->getVal( 'about' ),
				'up_occupation' => $wgRequest->getVal( 'occupation' ),
				'up_schools' => $wgRequest->getVal( 'schools' ),
				'up_places_lived' => $wgRequest->getVal( 'places' ),
				'up_websites' => $wgRequest->getVal( 'websites' ),
				'up_relationship' => $wgRequest->getVal( 'relationship' )
			),
			/* WHERE */array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $wgUser->getID() ) );
	}

	function saveProfileCustom() {
		global $wgUser, $wgMemc, $wgRequest;

		$this->initProfile();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_profile',
			/* SET */array(
				'up_custom_1' => $wgRequest->getVal( 'custom1' ),
				'up_custom_2' => $wgRequest->getVal( 'custom2' ),
				'up_custom_3' => $wgRequest->getVal( 'custom3' ),
				'up_custom_4' => $wgRequest->getVal( 'custom4' )
			),
			/* WHERE */array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $wgUser->getID() ) );
	}

	function saveProfilePersonal() {
		global $wgUser, $wgMemc, $wgRequest;

		$this->initProfile();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_profile',
			/* SET */array(
				'up_companies' => $wgRequest->getVal( 'companies' ),
				'up_movies' => $wgRequest->getVal( 'movies' ),
				'up_music' => $wgRequest->getVal( 'music' ),
				'up_tv' => $wgRequest->getVal( 'tv' ),
				'up_books' => $wgRequest->getVal( 'books' ),
				'up_magazines' => $wgRequest->getVal( 'magazines' ),
				'up_video_games' => $wgRequest->getVal( 'videogames' ),
				'up_snacks' => $wgRequest->getVal( 'snacks' ),
				'up_drinks' => $wgRequest->getVal( 'drinks' )
			),
			/* WHERE */array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $wgUser->getID() ) );
	}

	function displayBasicForm() {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( 'user_profile',
			array(
				'up_location_city', 'up_location_state', 'up_location_country',
				'up_hometown_city', 'up_hometown_state', 'up_hometown_country',
				'up_birthday', 'up_occupation', 'up_about', 'up_schools',
				'up_places_lived', 'up_websites'
			),
			array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);

		if ( $s !== false ) {
			$location_city = $s->up_location_city;
			$location_state = $s->up_location_state;
			$location_country = $s->up_location_country;
			$about = $s->up_about;
			$occupation = $s->up_occupation;
			$hometown_city = $s->up_hometown_city;
			$hometown_state = $s->up_hometown_state;
			$hometown_country = $s->up_hometown_country;
			$birthday = $this->formatBirthday( $s->up_birthday );
			$schools = $s->up_schools;
			$places = $s->up_places_lived;
			$websites = $s->up_websites;
		}

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		if ( !$location_country ) {
			$location_country = wfMsgForContent( 'user-profile-default-country' );
		}
		if ( !$hometown_country ) {
			$hometown_country = wfMsgForContent( 'user-profile-default-country' );
		}

		$s = $dbr->selectRow(
			'user',
			array( 'user_real_name', 'user_email', 'user_email_authenticated' ),
			array( 'user_id' => $wgUser->getID() ),
			__METHOD__
		);

		if ( $s !== false ) {
			$real_name = $s->user_real_name;
			$email = $s->user_email;
			$old_email = $s->user_email;
			$email_authenticated = $s->user_email_authenticated;
		}

		$countries = explode( "\n*", wfMsgForContent( 'userprofile-country-list' ) );
		array_shift( $countries );

		$wgOut->setPageTitle( wfMsg( 'edit-profile-title' ) );
		$form = UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-personal' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">';
		$form .= '<div class="profile-info clearfix">';
		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-info' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-name' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="real_name" id="real_name" value="' . $real_name . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-email' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="email" id="email" value="' . $email . '"/>';
			if ( !$wgUser->mEmailAuthenticated ) {
				$confirm = SpecialPage::getTitleFor( 'Confirmemail' );
				$form .= " <a href=\"{$confirm->getFullURL()}\">" . wfMsg( 'user-profile-personal-confirmemail' ) . '</a>';
			}
			$form .= '</p>
			<div class="cleared"></div>';
			if ( !$wgUser->mEmailAuthenticated ) {
				$form .= '<p class="profile-update-unit-left"></p>
				<p class="profile-update-unit-small">' . wfMsg( 'user-profile-personal-email-needs-auth' ) . '</p>';
			}
			$form .= '<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';

		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-location' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-city' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="location_city" id="location_city" value="' . $location_city . '" /></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="location_state_label">' . wfMsg( 'user-profile-personal-country' ) . '</p>';
			$form .= '<p class="profile-update-unit">';
			$form .= '<span id="location_state_form">';
		 	$form .= "</span>
		 		<script type=\"text/javascript\">
					displaySection(\"location_state\",\"" . $location_country . "\",\"" . $location_state . "\")
				</script>";
		 	$form .= "<select name=\"location_country\" id=\"location_country\" onhhange=\"displaySection('location_state',this.value,'')\"><option></option>";

		foreach ( $countries as $country ) {
			$form .= "<option value=\"{$country}\"" . ( ( $country == $location_country ) ? ' selected="selected"' : '' ) . ">";
			$form .= $country . "</option>\n";
		}

		$form .= '</select>';
			$form .= '</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';

		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-hometown' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-city' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="hometown_city" id="hometown_city" value="' . $hometown_city . '" /></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="hometown_state_label">' . wfMsg( 'user-profile-personal-country' ) . '</p>
			<p class="profile-update-unit">';
		$form .= '<span id="hometown_state_form">';
		$form .= "</span>
			<script type=\"text/javascript\">
				displaySection(\"hometown_state\",\"" . $hometown_country . "\",\"" . $hometown_state . "\")
			</script>";
		$form .= "<select name=\"hometown_country\" id=\"hometown_country\" onchange=\"displaySection('hometown_state',this.value,'')\"><option></option>";

		foreach ( $countries as $country ) {
			$form .= "<option value=\"{$country}\"" . ( ( $country == $hometown_country ) ? ' selected="selected"' : '' ) . ">";
			$form .= $country . '</option>';
		}

		$form .= '</select>';
		$form .= '</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';

		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-birthday' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-birthdate' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="birthday" id="birthday" value="' . $birthday . '" /></p>
			<div class="cleared"></div>
		</div><div class="cleared"></div>';

		$form .= '<div class="profile-update" id="profile-update-personal-aboutme">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-aboutme' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-aboutme' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="about" id="about" rows="3" cols="75">' . $about . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-work">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-work' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-occupation' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="occupation" id="occupation" rows="2" cols="75">' . $occupation . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-education">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-education' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-schools' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="schools" id="schools" rows="2" cols="75">' . $schools . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-places">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-places' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-placeslived' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="places" id="places" rows="3" cols="75">' . $places . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-web">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-web' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-websites' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="websites" id="websites" rows="2" cols="75">' . $websites . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';

		$form .= '
			<input type="button" class="site-button" value="' . wfMsg( 'user-profile-update-button' ) . '" size="20" onclick="document.profile.submit()" />
			</div>
		</form>';

		return $form;
	}

	function displayPersonalForm() {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( 'user_profile',
			array(
				'up_about', 'up_places_lived', 'up_websites', 'up_relationship',
				'up_occupation', 'up_companies', 'up_schools', 'up_movies',
				'up_tv', 'up_music', 'up_books', 'up_video_games',
				'up_magazines', 'up_snacks', 'up_drinks'
			),
			array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);

		if ( $s !== false ) {
			$places = $s->up_places_lived;
			$websites = $s->up_websites;
			$relationship = $s->up_relationship;
			$companies = $s->up_companies;
			$schools = $s->up_schools;
			$movies = $s->up_movies;
			$tv = $s->up_tv;
			$music = $s->up_music;
			$books = $s->up_books;
			$videogames = $s->up_video_games;
			$magazines = $s->up_magazines;
			$snacks = $s->up_snacks;
			$drinks = $s->up_drinks;
		}

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$wgOut->setPageTitle( wfMsg( 'user-profile-section-interests' ) );
		$form = UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-interests' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">
			<div class="profile-info clearfix">';
		$form .= "<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsg( 'user-profile-interests-entertainment' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-movies' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"movies\" id=\"movies\" rows=\"3\" cols=\"75\">{$movies}</textarea>
			</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-tv' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"tv\" id=\"tv\" rows=\"3\" cols=\"75\">{$tv}</textarea>
				</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-music' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"music\" id=\"music\" rows=\"3\" cols=\"75\">{$music}</textarea>
			</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-books' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"books\" id=\"books\" rows=\"3\" cols=\"75\">{$books}</textarea>
			</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-magazines' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"magazines\" id=\"magazines\" rows=\"3\" cols=\"75\">{$magazines}</textarea>
			</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-videogames' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"videogames\" id=\"videogames\" rows=\"3\" cols=\"75\">{$videogames}</textarea>
			</p>
			<div class=\"cleared\"></div>
			</div>
			<div class=\"profile-info clearfix\">
			<p class=\"profile-update-title\">" . wfMsg( 'user-profile-interests-eats' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-foodsnacks' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"snacks\" id=\"snacks\" rows=\"3\" cols=\"75\">{$snacks}</textarea>
			</p>
			<div class=\"cleared\"></div>
			<p class=\"profile-update-unit-left\">" . wfMsg( 'user-profile-interests-drinks' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"drinks\" id=\"drinks\" rows=\"3\" cols=\"75\">{$drinks}</textarea>
			</p>
			<div class=\"cleared\"></div>
			</div>
			<input type=\"button\" class=\"site-button\" value=" . wfMsg( 'user-profile-update-button' ) . " size=\"20\" onclick=\"document.profile.submit()\" />
			</div>
			</form>";

		return $form;
	}

	function displayPreferencesForm() {
		global $wgUser, $wgOut;

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		// @todo If the checkboxes are in front of the option, this would look more like Special:Preferences
		$wgOut->setPageTitle( wfMsg( 'user-profile-section-preferences' ) );
		$form = UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-preferences' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">';
		$form .= '<div class="profile-info clearfix">
			<div class="profile-update">
				<p class="profile-update-title">' . wfMsg( 'user-profile-preferences-emails' ) . '</p>
				<p class="profile-update-row">
					' . wfMsg( 'user-profile-preferences-emails-personalmessage' ) . '
					<input type="checkbox" size="25" name="notify_message" id="notify_message" value="1"' . ( ( $wgUser->getIntOption( 'notifymessage', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>
				<p class="profile-update-row">
					' . wfMsg( 'user-profile-preferences-emails-friendfoe' ) . '
					<input type="checkbox" size="25" class="createbox" name="notify_friend" id="notify_friend" value="1" ' . ( ( $wgUser->getIntOption( 'notifyfriendrequest', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>
				<p class="profile-update-row">
					' . wfMsg( 'user-profile-preferences-emails-gift' ) . '
					<input type="checkbox" size="25" name="notify_gift" id="notify_gift" value="1" ' . ( ( $wgUser->getIntOption( 'notifygift', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>

				<p class="profile-update-row">
					' . wfMsg( 'user-profile-preferences-emails-level' ) . '
					<input type="checkbox" size="25" name="notify_honorifics" id="notify_honorifics" value="1"' . ( ( $wgUser->getIntOption( 'notifyhonorifics', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>';

		$form .= '</div>
			<div class="cleared"></div>';
		$form .= '<input type="button" class="site-button" value="' . wfMsg( 'user-profile-update-button' ) . '" size="20" onclick="document.profile.submit()" />
			</form>';
		$form .= '</div>';

		return $form;
	}

	/**
	 * Displays the form for editing custom (site-specific) information
	 * @return $form Mixed: HTML output
	 */
	function displayCustomForm() {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow(
			'user_profile',
			array(
				'up_custom_1', 'up_custom_2', 'up_custom_3', 'up_custom_4',
				'up_custom_5'
			),
			array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);

		if ( $s !== false ) {
			$custom1 = $s->up_custom_1;
			$custom2 = $s->up_custom_2;
			$custom3 = $s->up_custom_3;
			$custom4 = $s->up_custom_4;
		}

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'user-profile-tidbits-title' ) ) );
		$form = '<h1>' . wfMsg( 'user-profile-tidbits-title' ) . '</h1>';
		$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-custom' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">
		 	<div class="profile-info clearfix">
				<div class="profile-update">
					<p class="profile-update-title">' . wfMsgForContent( 'user-profile-tidbits-title' ) . '</p>
					<div id="profile-update-custom1">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field1' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom1" id="fav_moment" rows="3" cols="75">' . $custom1 . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom2">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field2' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom2" id="least_moment" rows="3" cols="75">' . $custom2 . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom3">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field3' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom3" id="fav_athlete" rows="3" cols="75">' . $custom3 . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom4">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field4' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom4" id="least_fav_athlete" rows="3" cols="75">' . $custom4 . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
				</div>
			<input type="button" class="site-button" value="' . wfMsg( 'user-profile-update-button' ) . '" size="20" onclick="document.profile.submit()" />
			</div>
		</form>';

		return $form;
	}
}
