<?php
/**
 *
 */
class UserProfileMessages {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part

	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		$this->user_name = $username;
		$this->user_id = User::idFromName($this->user_name);
		
	}
	
	public function addMessage($user_to,$type,$message){
		$user_id_to = User::idFromName($user_to);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'user_profile_message::addToDatabase';
		$dbr->insert( '`user_profile_message`',
		array(
			'pm_user_id' => $this->user_id,
			'pm_user_name' => $this->user_name,
			'pm_type' => $type,
			'pm_message' => $message
			), $fname
		);
	}
	
	public function removeMessage(){}
	
	
}
	
?>
