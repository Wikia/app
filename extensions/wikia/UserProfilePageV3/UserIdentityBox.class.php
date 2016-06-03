<?php

class UserIdentityBox {
	const CACHE_VERSION = 2;

	/**
	 * Prefixes to memc keys etc.
	 */
	const USER_PROPERTIES_PREFIX = 'UserProfilePagesV3_';
	const USER_EDITED_MASTHEAD_PROPERTY = 'UserProfilePagesV3_mastheadEdited_';
	const USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY = 'UserProfilePagesV3_mastheadEditDate_';
	const USER_MASTHEAD_EDITS_WIKIS = 'UserProfilePagesV3_mastheadEditsWikis_';
	const USER_EVER_EDITED_MASTHEAD = 'UserProfilePagesV3_mastheadEditedEver';

	/**
	 * Char limits for user's input fields
	 */
	const USER_NAME_CHAR_LIMIT = 40;
	const USER_LOCATION_CHAR_LIMIT = 200;
	const USER_OCCUPATION_CHAR_LIMIT = 200;
	const USER_GENDER_CHAR_LIMIT = 200;

	const CACHE_TTL = 60 * 60; // 1 hour

	private $user = null;
	private $title = null;
	private $favWikisModel = null;

	public $optionsArray = array(
		'location',
		'bio',
		'occupation',
		'birthday',
		'gender',
		'website',
		'avatar',
		'twitter',
		'fbPage',
		'name',
		'hideEditsWikis',
	);

	/**
	 * @param User $user core user object
	 */
	public function __construct( User $user ) {
		global $wgTitle;

		$this->user = $user;
		$this->title = $wgTitle;
		$this->favWikisModel = $this->getFavoriteWikisModel();

		if ( is_null( $this->title ) ) {
			$this->title = $this->user->getUserPage();
		}
	}

	/**
	 * Creates an array with user's data without some properties
	 * @return array
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getData() {
		wfProfileIn( __METHOD__ );
		$data = $this->getUserData( 'getEmptyData' );
		wfProfileOut( __METHOD__ );
		return $data;

	}

	public function getFullData() {
		wfProfileIn( __METHOD__ );
		$data = $this->getUserData( 'getDefaultData' );
		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function getUserData( $dataType ) {
		wfProfileIn( __METHOD__ );
		global $wgCityId, $wgLang;

		$userName = $this->user->getName();
		$userId = $this->user->getId();

		// this data is always the same -- on each wiki
		$data = $this->getSharedUserData( $userId, $userName );

		if ( $this->user->isAnon() ) {
			// if user doesn't exist
			$data = $this->populateAnonData( $data, $userName );

			$this->getUserTags( $data );
		} else {
			$wikiId = $wgCityId;

			if ( empty( $this->userStats ) ) {
				/** @var $userStatsService UserStatsService */
				$userStatsService = new UserStatsService( $userId );
				$this->userStats = $userStatsService->getStats();
			}

			$iEdits = $this->userStats['edits'];
			$iEdits = $data['edits'] = is_null( $iEdits ) ? 0 : intval( $iEdits );

			// data depends on which wiki it is displayed
			$data['registration'] = $this->userStats['firstContributionTimestamp'];
			$data['userPage'] = $this->user->getUserPage()->getFullURL();

			$data = call_user_func( array( $this, $dataType ), $data );

			if ( !( $iEdits || $this->shouldDisplayFullMasthead() ) ) {
				$data = $this->getEmptyData( $data );
			}

			$data = $this->getInternationalizedRegistrationDate( $wikiId, $data );
			if ( !empty( $data['edits'] ) ) {
				$data['edits'] = $wgLang->formatNum( $data['edits'] );
			}

			// other data operations
			$this->getUserTags( $data );
			$data = $this->extractBirthDate( $data );
			$data['showZeroStates'] = $this->checkIfDisplayZeroStates( $data );
		}

		// Sanitize data to prevent XSS (VE-720)
		$keysToSanitize = [ 'gender', 'location', 'name', 'occupation', 'realName', 'twitter', 'fbPage', 'website' ];
		foreach ( $keysToSanitize as $key ) {
			if ( !empty( $data[ $key ] ) ) {
				$data[ $key ] = htmlspecialchars( strip_tags( $data[ $key ] ), ENT_QUOTES );
			}
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function getInternationalizedRegistrationDate( $wikiId, $data ) {
		wfProfileIn( __METHOD__ );
		$firstMastheadEditDate = $this->user->getGlobalFlag( self::USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY . $wikiId );

		if ( is_null( $data['registration'] ) && !is_null( $firstMastheadEditDate ) ) {
			// if user hasn't edited anything on this wiki before
			// we're getting the first edit masthead date
			$data['registration'] = $firstMastheadEditDate;
		} else {
			if ( !is_null( $data['registration'] ) && !is_null( $firstMastheadEditDate ) ) {
				// if we've got both dates we're getting the lowest (the earliest)
				$data['registration'] = ( intval( $data['registration'] ) < intval( $firstMastheadEditDate ) ) ? $data['registration'] : $firstMastheadEditDate;
			}
		}

		$data = $this->internationalizeRegistrationDate( $data );
		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function internationalizeRegistrationDate( $data ) {
		global $wgLang;
		wfProfileIn( __METHOD__ );

		if ( !empty( $data['registration'] ) ) {
			$data['registration'] = $wgLang->date( $data['registration'] );
		}
		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function extractBirthDate( $data ) {
		wfProfileIn( __METHOD__ );
		$birthdate = isset( $data['birthday'] ) && is_string( $data['birthday'] ) ? $data['birthday'] : '';
		$birthdate = explode( '-', $birthdate );
		if ( !empty( $birthdate[0] ) && !empty( $birthdate[1] ) ) {
			$data['birthday'] = array( 'month' => $birthdate[0], 'day' => ltrim( $birthdate[1], '0' ) );
		} else {
			$data['birthday'] = '';
		}
		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function getSharedUserData( $userId, $userName ) {
		wfProfileIn( __METHOD__ );
		$data = array();
		$data['id'] = $userId;
		$data['name'] = $userName;
		$data['avatar'] = AvatarService::getAvatarUrl( $userName, 150 );
		wfProfileOut( __METHOD__ );
		return $data;
	}

	protected function populateAnonData( $data, $userName ) {
		wfProfileIn( __METHOD__ );
		$this->getEmptyData( $data );
		// -1 edits means it's an anon user/ip where we don't display editcount at all
		$data['edits'] = -1;
		$data['showZeroStates'] = $this->checkIfDisplayZeroStates( $data );
		$data['name'] = $userName;
		$data['realName'] = wfMsg( 'user-identity-box-wikia-contributor' );
		wfProfileOut( __METHOD__ );
		return $data;
	}

	/**
	 * @brief Gets global data from table user_properties
	 * @param array $data array object
	 * @return array $data modified object
	 */
	private function getDefaultData( $data ) {
		global $wgMemc;

		$memcData = $wgMemc->get( $this->getMemcUserIdentityDataKey() );

		if ( empty( $memcData ) ) {
			foreach ( array( 'location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'hideEditsWikis' ) as $key ) {
				if ( $key === 'hideEditsWikis' ) {
					// hideEditsWikis is a preference, everything else is an attribute
					$data[$key] = $this->user->getGlobalPreference( $key );
				} elseif ( $key === 'gender' || $key === 'birthday' ) {
					$data[$key] = $this->user->getGlobalAttribute( self::USER_PROPERTIES_PREFIX . $key );
				} else {
					$data[$key] = $this->user->getGlobalAttribute( $key );
				}
			}
			$this->saveMemcUserIdentityData( $data );
		} else {
			$data = array_merge_recursive( $data, $memcData );
		}

		$data['topWikis'] = $this->getTopWikis();

		// informations which aren't cached in UPPv3 (i.e. real name)
		// fb#19398
		$disabled = $this->user->getGlobalFlag( 'disabled' );
		if ( empty( $disabled ) ) {
			$data['realName'] = $this->user->getRealName();
		} else {
			$data['realName'] = '';
		}
		return $data;
	}

	/**
	 * @brief Returns string with key to memcached; requires $this->user field being instance of User
	 *
	 * @return string
	 */
	private function getMemcUserIdentityDataKey() {
		return wfSharedMemcKey( 'user-identity-box-data0', $this->user->getId(), self::CACHE_VERSION );
	}

	/**
	 * @brief Sets empty data for a particular wiki
	 * @param array $data array object
	 * @return array $data array object
	 */
	private function getEmptyData( $data ) {
		foreach ( array( 'location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'hideEditsWikis' ) as $key ) {
			$data[$key] = "";
		}

		$data['realName'] = "";
		$data['topWikis'] = array();
		return $data;
	}

	/**
	 * @desc Informs if the use rhas ever edited masthead
	 * @return String
	 */
	private function hasUserEverEditedMasthead() {
		return $has = $this->user->getGlobalFlag( self::USER_EVER_EDITED_MASTHEAD, false );
	}

	/**
	 * @param integer $wikiId
	 * @return String
	 */
	protected function hasUserEditedMastheadBefore( $wikiId ) {
		return $this->user->getGlobalFlag( self::USER_EDITED_MASTHEAD_PROPERTY . $wikiId, false );
	}

	/**
	 * Saves user data
	 *
	 * @param object $data an user data
	 *
	 * @return boolean
	 */
	public function saveUserData( $data ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$changed = false;
		if ( is_object( $data ) ) {
			foreach ( $this->optionsArray as $option ) {
				if ( isset( $data->$option ) ) {
					$data->$option = $this->doParserFilter( $data->$option );

					// phalanx filtering; bugId:10233
					// For all options except `name`, if the spam check fails,
					// then empty the option value. `name` is checked below as
					// part of the User object
					if ( $option !== 'name' && !$this->doSpamCheck( $data->$option ) ) {
						// bugId:21358
						$data->$option = '';
					}

					// char limit added; bugId:15593
					if ( in_array( $option, array( 'location', 'occupation', 'gender' ) ) ) {
						switch ( $option ) {
							case 'location':
								$data->$option = mb_substr( $data->$option, 0, self::USER_LOCATION_CHAR_LIMIT );
								break;
							case 'occupation':
								$data->$option = mb_substr( $data->$option, 0, self::USER_OCCUPATION_CHAR_LIMIT );
								break;
							case 'gender':
								$data->$option = mb_substr( $data->$option, 0, self::USER_GENDER_CHAR_LIMIT );
								break;
						}
					}

					if ( $option === 'hideEditsWikis' ) {
						// hideEditsWikis is a preference, everything else is an attribute
						$this->user->setGlobalPreference( $option, $data->$option );
					} elseif ( $option === 'gender' ) {
						$this->user->setGlobalAttribute( self::USER_PROPERTIES_PREFIX . $option, $data->$option );
					} else {
						$this->user->setGlobalAttribute( $option, $data->$option );
					}

					$changed = true;
				}
			}

			if ( isset( $data->month ) && isset( $data->day ) ) {
				if ( checkdate( intval( $data->month ), intval( $data->day ), 2000 ) ) {
					$this->user->setGlobalAttribute( self::USER_PROPERTIES_PREFIX . 'birthday', intval( $data->month ) . '-' . intval( $data->day ) );
					$changed = true;
				} elseif ( $data->month === '0' && $data->day === '0' ) {
					$this->user->setGlobalAttribute( self::USER_PROPERTIES_PREFIX . 'birthday', null );
					$changed = true;
				}
			}

			if ( isset( $data->name ) ) {
				// phalanx filtering; bugId:21358
				$newName = '';
				if ( $this->doSpamCheck( User::newFromName( $data->name ) ) ) {
					// if a would-be user passes the spam check, truncate and
					// use the name given by the user
					// char limit added; bugId:15593
					$newName = mb_substr( $data->name, 0, self::USER_NAME_CHAR_LIMIT );
				}

				$this->user->setRealName( $newName );
				$changed = true;
			}
		}

		if ( !$this->hasUserEditedMastheadBefore( $wgCityId ) ) {
			$this->user->setGlobalFlag( self::USER_EDITED_MASTHEAD_PROPERTY . $wgCityId, true );
			$this->user->setGlobalFlag( self::USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY . $wgCityId, date( 'YmdHis' ) );

			$this->addTopWiki( $wgCityId );
			$changed = true;
		}

		if ( true === $changed ) {
			$this->user->setGlobalFlag( self::USER_EVER_EDITED_MASTHEAD, true );

			$this->user->saveSettings();
			$this->saveMemcUserIdentityData( $data );

			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	/**
	 * @brief Converts wikitext string to HTML
	 *
	 * @param string $text the text to be parsed
	 *
	 * @return string Parsed HTML string
	 */
	public function doParserFilter( $text ) {
		global $wgParser;

		$text = str_replace( '*', '&asterix;', $text );
		$text = $wgParser->parse( $text, $this->user->getUserPage(), new ParserOptions( $this->user ) )->getText();
		$text = str_replace( '&amp;asterix;', '*', $text );
		// Encoding problems in user masthead (CONN-131)
		$text = str_replace( '&#160;', ' ', $text );
		$text = trim( strip_tags( $text ) );

		return $text;
	}

	/**
	 * @brief Run the `SpamFilterCheck` hook over the content
	 *
	 * @param string $text the text to be filtered
	 *
	 * @return boolean if subject passes spam check
	 */
	private function doSpamCheck( $spamSubject ) {
		wfProfileIn( __METHOD__ );

		$_ = array();
		$res = wfRunHooks( 'SpamFilterCheck', array( $spamSubject, null, &$_ ) );

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * @brief Filters given parameter and saves in memcached new array which is returned
	 *
	 * @param object|array $data user identity box data
	 *
	 * @return array
	 */
	private function saveMemcUserIdentityData( $data ) {
		global $wgMemc;

		foreach ( array( 'location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'realName', 'topWikis', 'hideEditsWikis' ) as $property ) {
			if ( is_object( $data ) && isset( $data->$property ) ) {
				$memcData[$property] = $data->$property;
			}

			if ( is_array( $data ) && isset( $data[$property] ) ) {
				$memcData[$property] = $data[$property];
			}
		}

		if ( is_object( $data ) ) {
			if ( isset( $data->month ) && isset( $data->day ) && checkdate( intval( $data->month ), intval( $data->day ), 2000 ) ) {
				$memcData['birthday'] = $data->month . '-' . $data->day;
			}

			if ( isset( $data->birthday ) ) {
				$memcData['birthday'] = $data->birthday;
			}
		}

		if ( is_array( $data ) ) {
			if ( isset( $data['month'] ) && isset( $data['day'] ) ) {
				$memcData['birthday'] = $data['month'] . '-' . $data['day'];
			}

			if ( isset( $data['birthday'] ) ) {
				$memcData['birthday'] = $data['birthday'];
			}
		}

		if ( !isset( $memcData['realName'] ) && is_object( $data ) && isset( $data->name ) ) {
			$memcData['realName'] = $data->name;
		}

		// if any of properties isn't set then set it to null
		foreach ( array( 'location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'realName', 'hideEditsWikis' ) as $property ) {
			if ( !isset( $memcData[$property] ) ) {
				$memcData[$property] = null;
			}
		}

		$wgMemc->set( $this->getMemcUserIdentityDataKey(), $memcData, self::CACHE_TTL );

		return $memcData;
	}

	/**
	 * Gets DB object
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getDb( $type = DB_SLAVE ) {
		global $wgSharedDB;

		return wfGetDB( $type, array(), $wgSharedDB );
	}

	/**
	 * Gets user group and additionaly sets other user's data (blocked, founder)
	 *
	 * @param array $data reference to user data array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 * @author tor
	 */
	protected function getUserTags( &$data ) {
		global $wgEnableTwoTagsInMasthead;
		wfProfileIn( __METHOD__ );

		if ( !empty( $wgEnableTwoTagsInMasthead ) ) {
			/** @var $strategy UserTwoTagsStrategy */
			$strategy = new UserTwoTagsStrategy( $this->user );
		} else {
			/** @var $strategy UserOneTagStrategy */
			$strategy = new UserOneTagStrategy( $this->user );
		}
		$tags = $strategy->getUserTags();

		$data['tags'] = $tags;
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Returns false if any of "important" fields is not empty -- then it means not to display zero states
	 *
	 * @param array $data reference to user data array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @return boolean
	 */
	public function checkIfDisplayZeroStates( $data ) {
		wfProfileIn( __METHOD__ );

		$result = true;

		$fieldsToCheck = [ 'location', 'occupation', 'birthday', 'gender', 'website', 'twitter', 'fbPage', 'topWikis' ];

		foreach ( $data as $property => $value ) {
			if ( in_array( $property, $fieldsToCheck ) && !empty( $value ) ) {
				$result = false;
				break;
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @brief Returns true if full masthead should be displayed
	 * @return bool
	 */
	public function shouldDisplayFullMasthead() {
		global $wgCityId;

		$userId = $this->user->getId();
		if ( empty( $this->userStats ) ) {
			/** @var $userStatsService UserStatsService */
			$userStatsService = new UserStatsService( $userId );
			$this->userStats = $userStatsService->getStats();
		}

		$iEdits = $this->userStats['edits'];
		$iEdits = is_null( $iEdits ) ? 0 : intval( $iEdits );

		$hasUserEverEditedMastheadBefore = $this->hasUserEverEditedMasthead();
		$hasUserEditedMastheadBeforeOnThisWiki = $this->hasUserEditedMastheadBefore( $wgCityId );

		if ( $hasUserEditedMastheadBeforeOnThisWiki || ( $iEdits > 0 && $hasUserEverEditedMastheadBefore ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Blanks user profile data
	 * @author grunny
	 */
	public function resetUserProfile() {
		global $wgMemc;

		foreach ( $this->optionsArray as $option ) {
			if ( $option === 'gender' || $option === 'birthday' ) {
				$option = self::USER_PROPERTIES_PREFIX . $option;
			}
			$this->user->setGlobalAttribute( $option, null );
		}

		Wikia::invalidateUser( $this->user );
		$this->user->saveSettings();
		$wgMemc->delete( $this->getMemcUserIdentityDataKey() );

		// Delete both the avatar from the user's attributes (above),
		// as well as from disk.
		$avatarService = new UserAvatarsService( $this->user->getId() );
		$avatarService->remove();
	}

	/**
	 * @brief Returns list of favorite wikis; delegates getting favorite wikis to the FavoriteWikisModel
	 *
	 * @param bool $refreshHidden
	 * @return array
	 */
	public function getTopWikis( $refreshHidden = false ) {
		return $this->getFavoriteWikisModel()->getTopWikis( $refreshHidden );
	}

	/**
	 * @brief Delegates adding a wiki to favorite to the FavoriteWikisModel
	 *
	 * @param $wikiId
	 */
	public function addTopWiki( $wikiId ) {
		$this->getFavoriteWikisModel()->addTopWiki( $wikiId );
	}

	/**
	 * @brief Delegates hiding a wiki in favorite wikis group to the FavoriteWikisModel
	 *
	 * @param $wikiId
	 *
	 * @return boolean
	 */
	public function hideWiki( $wikiId ) {
		global $wgMemc;

		$result = $this->getFavoriteWikisModel()->hideWiki( $wikiId );

		if ( $result ) {
			$memcData = $wgMemc->get( $this->getMemcUserIdentityDataKey() );
			$memcData['topWikis'] = empty( $memcData['topWikis'] ) ? [] : $memcData['topWikis'];
			$this->saveMemcUserIdentityData( $memcData );
		}

		return $result;
	}

	public function getFavoriteWikisModel() {
		if ( is_null( $this->favWikisModel ) ) {
			$this->favWikisModel = new FavoriteWikisModel( $this->user );
		}

		return $this->favWikisModel;
	}

}
