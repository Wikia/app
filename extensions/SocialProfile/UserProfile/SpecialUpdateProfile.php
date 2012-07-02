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

	/**
	 * Initialize the user_profile records for a given user (either $wgUser
	 * or someone else; only Special:EditProfile sets the $user parameter).
	 *
	 * @param $user Object: User object; null by default (=$wgUser)
	 */
	function initProfile( $user = null ) {
		global $wgUser;

		if ( is_null( $user ) ) {
			$user = $wgUser;
		}

		$dbw = wfGetDB( DB_MASTER );
		$s = $dbw->selectRow(
			'user_profile',
			array( 'up_user_id' ),
			array( 'up_user_id' => $user->getID() ),
			__METHOD__
		);
		if ( $s === false ) {
			$dbw->insert(
				'user_profile',
				array( 'up_user_id' => $user->getID() ),
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

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'edit-profile-title' ) ) );

		// This feature is only available for logged-in users.
		if ( !$wgUser->isLoggedIn() ) {
			$wgOut->setPageTitle( wfMsg( 'user-profile-update-notloggedin-title' ) );
			$wgOut->addWikiMsg( 'user-profile-update-notloggedin-text' );
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
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleScripts( 'ext.userProfile.updateProfile' );
		} else {
			$wgOut->addScriptFile( $wgUserProfileScripts . '/UpdateProfile.js' );
		}

		if ( $wgRequest->wasPosted() ) {
			if ( !$section ) {
				$section = 'basic';
			}
			switch( $section ) {
				case 'basic':
					$this->saveProfileBasic( $wgUser );
					$this->saveSettings_basic( $wgUser );
					break;
				case 'personal':
					$this->saveProfilePersonal( $wgUser );
					break;
				case 'custom':
					$this->saveProfileCustom( $wgUser );
					break;
				case 'preferences':
					$this->saveSettings_pref();
					break;
			}

			UserProfile::clearCache( $wgUser->getID() );

			$log = new LogPage( 'profile' );
			if ( !$wgUpdateProfileInRecentChanges ) {
				$log->updateRecentChanges = false;
			}
			$log->addEntry(
				'profile',
				$wgUser->getUserPage(),
				wfMsgForContent( 'user-profile-update-log-section' ) .
					" '{$section}'"
			);
			$wgOut->addHTML(
				'<span class="profile-on">' .
				wfMsg( 'user-profile-update-saved' ) .
				'</span><br /><br />'
			);

			// create the user page if it doesn't exist yet
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
				$wgOut->addHTML( $this->displayBasicForm( $wgUser ) );
				break;
			case 'personal':
				$wgOut->addHTML( $this->displayPersonalForm( $wgUser ) );
				break;
			case 'custom':
				$wgOut->addHTML( $this->displayCustomForm( $wgUser ) );
				break;
			case 'preferences':
				$wgOut->addHTML( $this->displayPreferencesForm() );
				break;
		}
	}

	/**
	 * Save basic settings about the user (real name, e-mail address) into the
	 * database.
	 *
	 * @param $user Object: this parameter is unused but required to stop
	 *                      E_STRICT bitching because Special:EditProfile
	 *                      extends this class to reduce the amount of code
	 *                      duplication
	 */
	function saveSettings_basic( $user ) {
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

	/**
	 * Save social preferences into the database.
	 */
	function saveSettings_pref() {
		global $wgUser, $wgRequest;

		$notify_friend = $wgRequest->getVal( 'notify_friend' );
		$notify_gift = $wgRequest->getVal( 'notify_gift' );
		$notify_challenge = $wgRequest->getVal( 'notify_challenge' );
		$notify_honorifics = $wgRequest->getVal( 'notify_honorifics' );
		$notify_message = $wgRequest->getVal( 'notify_message' );
		$show_year_of_birth = $wgRequest->getVal( 'show_year_of_birth', 0 );
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
		$wgUser->setOption( 'showyearofbirth', $show_year_of_birth );
		$wgUser->saveSettings();

		// Allow extensions like UserMailingList do their magic here
		wfRunHooks( 'SpecialUpdateProfile::saveSettings_pref', array( $this, $wgRequest ) );
	}

	public static function formatBirthdayDB( $birthday ) {
		$dob = explode( '/', $birthday );
		if ( count( $dob ) == 2 || count( $dob ) == 3 ) {
			$year = isset( $dob[2] ) ? $dob[2] : 2007;
			$month = $dob[0];
			$day = $dob[1];
			$birthday_date = $year . '-' . $month . '-' . $day;
		} else {
			$birthday_date = '';
		}
		return ( $birthday_date );
	}

	public static function formatBirthday( $birthday, $showYOB = false ) {
		$dob = explode( '-', $birthday );
		if ( count( $dob ) == 3 ) {
			$month = $dob[1];
			$day = $dob[2];
			$birthday_date = $month . '/' . $day;
			if ( $showYOB ) {
				$year = $dob[0];
				$birthday_date .= '/' . $year;
			}
		} else {
			$birthday_date = '';
		}
		return $birthday_date;
	}

	/**
	 * Save the basic user profile info fields into the database.
	 * The $user parameter is only passed by Special:EditProfile.
	 *
	 * @param $user Object: User object, null by default (=$wgUser)
	 */
	function saveProfileBasic( $user = null ) {
		global $wgUser, $wgMemc, $wgRequest, $wgSitename;

		if ( is_null( $user ) ) {
			$user = $wgUser;
		}

		$this->initProfile( $user );
		$dbw = wfGetDB( DB_MASTER );
		$basicProfileData = array(
			'up_location_city' => $wgRequest->getVal( 'location_city' ),
			'up_location_state' => $wgRequest->getVal( 'location_state' ),
			'up_location_country' => $wgRequest->getVal( 'location_country' ),

			'up_hometown_city' => $wgRequest->getVal( 'hometown_city' ),
			'up_hometown_state' => $wgRequest->getVal( 'hometown_state' ),
			'up_hometown_country' => $wgRequest->getVal( 'hometown_country' ),

			'up_birthday' => self::formatBirthdayDB( $wgRequest->getVal( 'birthday' ) ),
			'up_about' => $wgRequest->getVal( 'about' ),
			'up_occupation' => $wgRequest->getVal( 'occupation' ),
			'up_schools' => $wgRequest->getVal( 'schools' ),
			'up_places_lived' => $wgRequest->getVal( 'places' ),
			'up_websites' => $wgRequest->getVal( 'websites' ),
			'up_relationship' => $wgRequest->getVal( 'relationship' )
		);
		$dbw->update(
			'user_profile',
			/* SET */$basicProfileData,
			/* WHERE */array( 'up_user_id' => $user->getID() ),
			__METHOD__
		);
		// BasicProfileChanged hook
		$basicProfileData['up_name'] = $wgRequest->getVal( 'real_name' );
		$basicProfileData['up_email'] = $wgRequest->getVal( 'email' );
		wfRunHooks( 'BasicProfileChanged', array( $user, $basicProfileData ) );
		// end of the hook
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $user->getID() ) );
	}

	/**
	 * Save the four custom (site-specific) user profile fields into the
	 * database.
	 * The $user parameter is only passed by Special:EditProfile.
	 *
	 * @param $user Object: User object, null by default (=$wgUser)
	 */
	function saveProfileCustom( $user = null ) {
		global $wgUser, $wgMemc, $wgRequest;

		if ( is_null( $user ) ) {
			$user = $wgUser;
		}

		$this->initProfile( $user );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_profile',
			/* SET */array(
				'up_custom_1' => $wgRequest->getVal( 'custom1' ),
				'up_custom_2' => $wgRequest->getVal( 'custom2' ),
				'up_custom_3' => $wgRequest->getVal( 'custom3' ),
				'up_custom_4' => $wgRequest->getVal( 'custom4' )
			),
			/* WHERE */array( 'up_user_id' => $user->getID() ),
			__METHOD__
		);
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $user->getID() ) );
	}

	/**
	 * Save the user's personal info (interests, such as favorite music or
	 * TV programs or video games, etc.) into the database.
	 * The $user parameter is only passed by Special:EditProfile.
	 *
	 * @param $user Object: User object, null by default (=$wgUser)
	 */
	function saveProfilePersonal( $user = null ) {
		global $wgUser, $wgMemc, $wgRequest;

		if ( is_null( $user ) ) {
			$user = $wgUser;
		}

		$this->initProfile( $user );
		$dbw = wfGetDB( DB_MASTER );
		$interestsData = array(
			'up_companies' => $wgRequest->getVal( 'companies' ),
			'up_movies' => $wgRequest->getVal( 'movies' ),
			'up_music' => $wgRequest->getVal( 'music' ),
			'up_tv' => $wgRequest->getVal( 'tv' ),
			'up_books' => $wgRequest->getVal( 'books' ),
			'up_magazines' => $wgRequest->getVal( 'magazines' ),
			'up_video_games' => $wgRequest->getVal( 'videogames' ),
			'up_snacks' => $wgRequest->getVal( 'snacks' ),
			'up_drinks' => $wgRequest->getVal( 'drinks' )
		);
		$dbw->update(
			'user_profile',
			/* SET */$interestsData,
			/* WHERE */array( 'up_user_id' => $user->getID() ),
			__METHOD__
		);
		// PersonalInterestsChanged hook
		wfRunHooks( 'PersonalInterestsChanged', array( $user, $interestsData ) );
		// end of the hook
		$wgMemc->delete( wfMemcKey( 'user', 'profile', 'info', $user->getID() ) );
	}

	/**
	 * @param $user Object: this parameter is unused but required to stop
	 *                      E_STRICT bitching because Special:EditProfile
	 *                      extends this class to reduce the amount of code
	 *                      duplication
	 */
	function displayBasicForm( $user ) {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_SLAVE );
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

		$showYOB = true;
		if ( $s !== false ) {
			$location_city = $s->up_location_city;
			$location_state = $s->up_location_state;
			$location_country = $s->up_location_country;
			$about = $s->up_about;
			$occupation = $s->up_occupation;
			$hometown_city = $s->up_hometown_city;
			$hometown_state = $s->up_hometown_state;
			$hometown_country = $s->up_hometown_country;
			$showYOB = $wgUser->getIntOption( 'showyearofbirth', !isset( $s->up_birthday ) ) == 1;
			$birthday = self::formatBirthday( $s->up_birthday, $showYOB );
			$schools = $s->up_schools;
			$places = $s->up_places_lived;
			$websites = $s->up_websites;
		}

		if ( !isset( $location_country ) ) {
			$location_country = wfMsgForContent( 'user-profile-default-country' );
		}
		if ( !isset( $hometown_country ) ) {
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
			<p class="profile-update-unit"><input type="text" size="25" name="location_city" id="location_city" value="' . ( isset( $location_city ) ? $location_city : '' ) . '" /></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="location_state_label">' . wfMsg( 'user-profile-personal-country' ) . '</p>';
		$form .= '<p class="profile-update-unit">';
		$form .= '<span id="location_state_form">';
		$form .= "</span>
				<script type=\"text/javascript\">
					displaySection(\"location_state\",\"" . $location_country . "\",\"" . ( isset( $location_state ) ? $location_state : '' ) . "\");
				</script>";
		$form .= "<select name=\"location_country\" id=\"location_country\" onchange=\"displaySection('location_state',this.value,'')\"><option></option>";

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
			<p class="profile-update-unit"><input type="text" size="25" name="hometown_city" id="hometown_city" value="' . ( isset( $hometown_city ) ? $hometown_city : '' ) . '" /></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="hometown_state_label">' . wfMsg( 'user-profile-personal-country' ) . '</p>
			<p class="profile-update-unit">';
		$form .= '<span id="hometown_state_form">';
		$form .= "</span>
			<script type=\"text/javascript\">
				displaySection(\"hometown_state\",\"" . $hometown_country . "\",\"" . ( isset( $hometown_state ) ? $hometown_state : '' ) . "\");
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
			<p class="profile-update-unit-left" id="birthday-format">' .
				wfMsg( $showYOB ? 'user-profile-personal-birthdate-with-year' : 'user-profile-personal-birthdate' ) .
			'</p>
			<p class="profile-update-unit"><input type="text"' .
			( $showYOB ? ' class="long-birthday"' : null ) .
			' size="25" name="birthday" id="birthday" value="' .
			( isset( $birthday ) ? $birthday : '' ) . '" /></p>
			<div class="cleared"></div>
		</div><div class="cleared"></div>';

		$form .= '<div class="profile-update" id="profile-update-personal-aboutme">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-aboutme' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-aboutme' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="about" id="about" rows="3" cols="75">' . ( isset( $about ) ? $about : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-work">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-work' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-occupation' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="occupation" id="occupation" rows="2" cols="75">' . ( isset( $occupation ) ? $occupation : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-education">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-education' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-schools' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="schools" id="schools" rows="2" cols="75">' . ( isset( $schools ) ? $schools : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-places">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-places' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-placeslived' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="places" id="places" rows="3" cols="75">' . ( isset( $places ) ? $places : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>

		<div class="profile-update" id="profile-update-personal-web">
			<p class="profile-update-title">' . wfMsg( 'user-profile-personal-web' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-personal-websites' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="websites" id="websites" rows="2" cols="75">' . ( isset( $websites ) ? $websites : '' ) . '</textarea>
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

	/**
	 * @param $user Object: this parameter is unused but required to stop
	 *                      E_STRICT bitching because Special:EditProfile
	 *                      extends this class to reduce the amount of code
	 *                      duplication
	 */
	function displayPersonalForm( $user ) {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_profile',
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

		$wgOut->setPageTitle( wfMsg( 'user-profile-section-interests' ) );
		$form = UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-interests' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">
			<div class="profile-info clearfix">
			<div class="profile-update">
			<p class="profile-update-title">' . wfMsg( 'user-profile-interests-entertainment' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-movies' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="movies" id="movies" rows="3" cols="75">' . ( isset( $movies ) ? $movies : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-tv' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="tv" id="tv" rows="3" cols="75">' . ( isset( $tv ) ? $tv : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-music' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="music" id="music" rows="3" cols="75">' . ( isset( $music ) ? $music : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-books' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="books" id="books" rows="3" cols="75">' . ( isset( $books ) ? $books : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-magazines' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="magazines" id="magazines" rows="3" cols="75">' . ( isset( $magazines ) ? $magazines : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-videogames' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="videogames" id="videogames" rows="3" cols="75">' . ( isset( $videogames ) ? $videogames : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			</div>
			<div class="profile-info clearfix">
			<p class="profile-update-title">' . wfMsg( 'user-profile-interests-eats' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-foodsnacks' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="snacks" id="snacks" rows="3" cols="75">' . ( isset( $snacks ) ? $snacks : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsg( 'user-profile-interests-drinks' ) . '</p>
			<p class="profile-update-unit">
				<textarea name="drinks" id="drinks" rows="3" cols="75">' . ( isset( $drinks ) ? $drinks : '' ) . '</textarea>
			</p>
			<div class="cleared"></div>
			</div>
			<input type="button" class="site-button" value="' . wfMsg( 'user-profile-update-button' ) . '" size="20" onclick="document.profile.submit()" />
			</div>
		</form>';

		return $form;
	}

	/**
	 * Displays the form for toggling notifications related to social tools
	 * (e-mail me when someone friends/foes me, send me a gift, etc.)
	 *
	 * @return HTML
	 */
	function displayPreferencesForm() {
		global $wgRequest, $wgUser, $wgOut;

		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_profile',
			array( 'up_birthday' ),
			array( 'up_user_id' => $wgUser->getID() ),
			__METHOD__
		);

		$showYOB = isset( $s, $s->up_birthday ) ? false : true;

		// @todo If the checkboxes are in front of the option, this would look more like Special:Preferences
		$wgOut->setPageTitle( wfMsg( 'user-profile-section-preferences' ) );
		$form = UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-preferences' ) );
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="profile">';
		$form .= '<div class="profile-info clearfix">
			<div class="profile-update">
				<p class="profile-update-title">' . wfMsg( 'user-profile-preferences-emails' ) . '</p>
				<p class="profile-update-row">'
					. wfMsg( 'user-profile-preferences-emails-personalmessage' ) .
					' <input type="checkbox" size="25" name="notify_message" id="notify_message" value="1"' . ( ( $wgUser->getIntOption( 'notifymessage', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>
				<p class="profile-update-row">'
					. wfMsg( 'user-profile-preferences-emails-friendfoe' ) .
					' <input type="checkbox" size="25" class="createbox" name="notify_friend" id="notify_friend" value="1" ' . ( ( $wgUser->getIntOption( 'notifyfriendrequest', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>
				<p class="profile-update-row">'
					. wfMsg( 'user-profile-preferences-emails-gift' ) .
					' <input type="checkbox" size="25" name="notify_gift" id="notify_gift" value="1" ' . ( ( $wgUser->getIntOption( 'notifygift', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>

				<p class="profile-update-row">'
					. wfMsg( 'user-profile-preferences-emails-level' ) .
					' <input type="checkbox" size="25" name="notify_honorifics" id="notify_honorifics" value="1"' . ( ( $wgUser->getIntOption( 'notifyhonorifics', 1 ) == 1 ) ? 'checked' : '' ) . '/>
				</p>';

		$form .= '<p class="profile-update-title">' .
			wfMsg( 'user-profile-preferences-miscellaneous' ) .
			'</p>
			<p class="profile-update-row">' .
				wfMsg( 'user-profile-preferences-miscellaneous-show-year-of-birth' ) .
				' <input type="checkbox" size="25" name="show_year_of_birth" id="show_year_of_birth" value="1"' . ( ( $wgUser->getIntOption( 'showyearofbirth', $showYOB ) == 1 ) ? 'checked' : '' ) . '/>
			</p>';

		// Allow extensions (like UserMailingList) to add new checkboxes
		wfRunHooks( 'SpecialUpdateProfile::displayPreferencesForm', array( $this, &$form ) );

		$form .= '</div>
			<div class="cleared"></div>';
		$form .= '<input type="button" class="site-button" value="' . wfMsg( 'user-profile-update-button' ) . '" size="20" onclick="document.profile.submit()" />
			</form>';
		$form .= '</div>';

		return $form;
	}

	/**
	 * Displays the form for editing custom (site-specific) information.
	 *
	 * @param $user Object: this parameter is unused but required to stop
	 *                      E_STRICT bitching because Special:EditProfile
	 *                      extends this class to reduce the amount of code
	 *                      duplication
	 * @return $form Mixed: HTML output
	 */
	function displayCustomForm( $user ) {
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
						<textarea name="custom1" id="fav_moment" rows="3" cols="75">' . ( isset( $custom1 ) ? $custom1 : '' ) . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom2">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field2' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom2" id="least_moment" rows="3" cols="75">' . ( isset( $custom2 ) ? $custom2 : '' ) . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom3">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field3' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom3" id="fav_athlete" rows="3" cols="75">' . ( isset( $custom3 ) ? $custom3 : '' ) . '</textarea>
					</p>
					</div>
					<div class="cleared"></div>
					<div id="profile-update-custom4">
					<p class="profile-update-unit-left">' . wfMsgForContent( 'custom-info-field4' ) . '</p>
					<p class="profile-update-unit">
						<textarea name="custom4" id="least_fav_athlete" rows="3" cols="75">' . ( isset( $custom4 ) ? $custom4 : '' ) . '</textarea>
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
