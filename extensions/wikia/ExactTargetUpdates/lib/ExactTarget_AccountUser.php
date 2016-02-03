<?php
class ExactTarget_AccountUser {
	public $AccountUserID; // int
	public $UserID; // string
	public $Password; // string
	public $Name; // string
	public $Email; // string
	public $MustChangePassword; // boolean
	public $ActiveFlag; // boolean
	public $ChallengePhrase; // string
	public $ChallengeAnswer; // string
	public $UserPermissions; // ExactTarget_UserAccess
	public $Delete; // int
	public $LastSuccessfulLogin; // dateTime
	public $IsAPIUser; // boolean
	public $NotificationEmailAddress; // string
	public $IsLocked; // boolean
	public $Unlock; // boolean
	public $BusinessUnit; // int
	public $DefaultBusinessUnit; // int
}
