<?php

/**
 * Class representing a single contest contestant.
 * A contestant is a unique user + contest combination.
 *
 * @since 0.1
 *
 * @file ContestContestant.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestContestant extends ContestDBObject {

	protected $contest = null;

	/**
	 * Cached user object, created from the user_id field.
	 *
	 * @since 0.1
	 * @var User
	 */
	protected $user = null;

	/**
	 * Method to get an instance so methods that ought to be static,
	 * but can't be due to PHP 5.2 not having LSB, can be called on
	 * it. This also allows easy identifying of code that needs to
	 * be changed once PHP 5.3 becomes an acceptable requirement.
	 *
	 * @since 0.1
	 *
	 * @return ContestDBObject
	 */
	public static function s() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new self( array() );
		}

		return $instance;
	}

	/**
	 * Get a new instance of the class from an array.
	 * This method ought to be in the basic class and
	 * return a new static(), but this requires LSB/PHP>=5.3.
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 * @param boolean $loadDefaults
	 *
	 * @return ContestDBObject
	 */
	public function newFromArray( array $data, $loadDefaults = false ) {
		return new self( $data, $loadDefaults );
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDBTable() {
		return 'contest_contestants';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFieldPrefix() {
		return 'contestant_';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getFieldTypes() {
		return array(
			'id' => 'id',
			'contest_id' => 'id',
			'challenge_id' => 'id',
			'user_id' => 'id',

			'full_name' => 'str',
			'user_name' => 'str',
			'email' => 'str',

			'country' => 'str',
			'volunteer' => 'bool',
			'wmf' => 'bool',
			'cv' => 'str',

			'submission' => 'str',

			'rating' => 'float',
			'rating_count' => 'int',
			'comments' => 'int',
		);
	}

	/**
	 * @see parent::getDefaults
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getDefaults() {
		return array(
			'full_name' => '',
			'user_name' => '',
			'email' => '',

			'country' => '',
			'volunteer' => false,
			'wmf' => false,
			'cv' => false,

			'submission' => '',

			'rating' => 0,
			'rating_count' => 0,
			'comments' => 0,
		);
	}

	/**
	 * Gets the contest for this participant.
	 *
	 * @since 0.1
	 *
	 * @param array|string|null $fields The fields to load, null for all fields.
	 *
	 * @return Contest
	 */
	public function getContest( $fields = null ) {
		if ( !is_null( $this->contest ) ) {
			return $this->contest;
		}

		$contest = Contest::s()->selectRow( $fields, array( 'id' => $this->getField( 'contest_id' ) ) );

		if ( is_null( $this->contest ) && is_null( $fields ) ) {
			$this->contest = $contest;
		}

		return $contest;
	}

	/**
	 * Sets the contest for this participant.
	 *
	 * @since 0.1
	 *
	 * @param Contest $contest
	 */
	public function setContest( Contest $contest ) {
		$this->contest = $contest;
	}

	/**
	 * Returns a list of countries and their corresponding country
	 * codes that can be fed directly into an HTML input.
	 *
	 * @since 0.1
	 *
	 * @param boolean $addEmptyItem
	 *
	 * @return array
	 */
	public static function getCountriesForInput( $addEmptyItem = false ) {
		$countries = array();

		if ( $addEmptyItem ) {
			$countries[''] = '';
		}

		foreach ( self::getCountries() as $code => $name ) {
			$countries["$code - $name"] = $code;
		}

		return $countries;
	}

	/**
	 * Returns a list of ISO 3166-1-alpha-2 country codes (keys) and their corresponding country (values).
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public static function getCountries() {
		return array(
			'AF' => 'Afghanistan',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua and Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BA' => 'Bosnia and Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'BN' => 'Brunei Darussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CG' => 'Congo',
			'CD' => 'Congo, the Democratic Republic of the',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CI' => "Cote D'Ivoire",
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'GQ' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands (Malvinas)',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard Island and Mcdonald Islands',
			'VA' => 'Holy See (Vatican City State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran, Islamic Republic of',
			'IQ' => 'Iraq',
			'IE' => 'Ireland',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KP' => "Korea, Democratic People's Republic of",
			'KR' => 'Korea, Republic of',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => "Lao People's Democratic Republic",
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libyan Arab Jamahiriya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao',
			'MK' => 'Macedonia, the Former Yugoslav Republic of',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States of',
			'MD' => 'Moldova, Republic of',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestinian Territory, Occupied',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts and Nevis',
			'LC' => 'Saint Lucia',
			'PM' => 'Saint Pierre and Miquelon',
			'VC' => 'Saint Vincent and the Grenadines',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'ST' => 'Sao Tome and Principe',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'CS' => 'Serbia and Montenegro',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			//'GS' => 'South Georgia and the South Sandwich Islands',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard and Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syrian Arab Republic',
			'TW' => 'Taiwan, Province of China',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania, United Republic of',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad and Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks and Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom',
			'US' => 'United States',
			'UM' => 'United States Minor Outlying Islands',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Viet Nam',
			'VG' => 'Virgin Islands, British',
			'VI' => 'Virgin Islands, U.s.',
			'WF' => 'Wallis and Futuna',
			'EH' => 'Western Sahara',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe'
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see ContestDBObject::insertIntoDB()
	 * @return bool
	 */
	protected function insertIntoDB() {
		wfRunHooks( 'ContestBeforeContestantInsert', array( &$this ) );

		$success = parent::insertIntoDB();

		if ( $success ) {
			$this->onUserSignup();
		}

		return $success;
	}

	/**
	 * Handles successful user signup for a contest.
	 *
	 * @since 0.1
	 */
	protected function onUserSignup() {
		$this->getContest( array( 'id' ) )->addToSubmissionCount( 1 );

		$this->getUser()->setOption( 'contest_showtoplink', true );
		$this->getUser()->saveSettings(); // TODO: can't we just save this single option instead of everything?

		$this->sendSignupEmail();

		wfRunHooks( 'ContestAfterContestantInsert', array( &$this ) );
	}

	/**
	 * Send the signup email.
	 *
	 * @since 0.1
	 *
	 * @return Status
	 */
	public function sendSignupEmail() {
		$title = wfMsg( 'contest-email-signup-title' );
		$emailText = ContestUtils::getParsedArticleContent( $this->getContest()->getField( 'signup_email' ) );
		$user = $this->getUser();
		$sender = ContestSettings::get( 'mailSender' );
		$senderName = ContestSettings::get( 'mailSenderName' );

		wfRunHooks( 'ContestBeforeSignupEmail', array( &$this, &$title, &$emailText, &$user, &$sender, &$senderName ) );

		return UserMailer::send(
			new MailAddress( $user ),
			new MailAddress( $sender, $senderName ),
			$title,
			$emailText,
			null,
			'text/html; charset=ISO-8859-1'
		);
	}

	/**
	 * Send a reminder email.
	 *
	 * @since 0.1
	 *
	 * @return Status
	 */
	public function sendReminderEmail( $emailText, array $params = array() ) {
		if ( !array_key_exists( 'daysLeft', $params ) ) {
			$params['daysLeft'] = $this->getContest()->getDaysLeft();
		}

		$title = wfMsgExt( 'contest-email-reminder-title', 'parsemag', $params['daysLeft'] );
		$user = $this->getUser();
		$sender = ContestSettings::get( 'mailSender' );
		$senderName = ContestSettings::get( 'mailSenderName' );

		wfRunHooks( 'ContestBeforeReminderEmail', array( &$this, &$title, &$emailText, &$user, &$sender, &$senderName ) );

		return UserMailer::send(
			new MailAddress( $user ),
			new MailAddress( $sender, $senderName ),
			$title,
			$emailText,
			null,
			'text/html; charset=ISO-8859-1'
		);
	}

	/**
	 * Update the vote count and average vote fields.
	 * This does not write the changes to the database,
	 * if this is required, call writeToDB.
	 *
	 * @since 0.1
	 */
	public function updateVotes() {
		$votes = $this->getVotes();

		$amount = count( $votes );
		$total = 0;

		foreach ( $votes as /* ContestVote */ $vote ) {
			$total += $vote->getField( 'value' );
		}

		$this->setField( 'rating_count', $amount );
		$this->setField( 'rating', $amount > 0 ? $total / $amount * 100 : 0 );
	}

	/**
	 * Returns the user object for this contestant, created
	 * from the user_id field and cached in $this->user.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		if ( is_null( $this->user ) ) {
			if ( !$this->hasField( 'user_id' ) ) {
				if ( is_null( $this->getId() ) ) {
					throw new MWException( 'Can not get an user object when the user_id field is not set.' );
				}
				else {
					$this->loadFields( 'user_id' );
				}
			}

			$this->user = User::newFromId( $this->getField( 'user_id' ) );
		}

		return $this->user;
	}

	/**
	 * Get the votes for this contestant.
	 *
	 * @since 0.1
	 *
	 * @return array of ContestVote
	 */
	public function getVotes() {
		return ContestVote::s()->select( null, array( 'contestant_id' => $this->getId() ) );
	}

	/**
	 * Get the comments for this contestant.
	 *
	 * @since 0.1
	 *
	 * @return array of ContestComment
	 */
	public function getComments() {
		return ContestComment::s()->select( null, array( 'contestant_id' => $this->getId() ) );
	}

}
