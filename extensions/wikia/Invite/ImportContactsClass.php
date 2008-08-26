<?php
/**
 *
 */
class ImportContacts {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $email;           	# Text form (spaces not underscores) of the main part
	var $password;			# Text form (spaces not underscores) of the main part
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}
	
	public function getContacts(){
		return $this->contacts;
	}
}


	
?>