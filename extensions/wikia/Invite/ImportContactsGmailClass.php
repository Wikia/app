<?php

class ImportContactsGmail extends ImportContacts{
	
	var $refering_site = "http://mail.google.com/mail/";
	var $browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";

	function __construct($email,$password) {
		parent::__construct($email,$password);
	}
	
}
?>