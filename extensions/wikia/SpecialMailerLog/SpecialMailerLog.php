<?php

/**
 * Show a formatted view of the wikia_mailer table
 */


$wgSpecialPages[ "MailerLog" ] = "SpecialMailerLog";

class SpecialMailerLog extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'MailerLog' );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgMessageCache;

		wfProfileIn( __METHOD__ );

		if( !$wgUser->isAllowed( "staff" ) ) {
			$this->displayRestrictionError();
			return;
		}

		$dbr = wfGetDb(DB_SLAVE, array(), 'wikia_mailer');
		$res = $dbr->select( 'mail',
							 array( 'id', 'created', 'city_id', 'dst', 'hdr', 'locked', 'transmitted', 'is_error', 'error_status', 'error_msg', 'opened'),
							 array(),
							 '',
							 array('ORDER BY' => 'id DESC',
							       'LIMIT'    => 50)
						   );
						   
		$mail_records = array();
		while ($row = $dbr->fetchObject($res)) {

			preg_match('/Subject: (.+)/', $row->hdr, $matches);
			$mail_records[] = array('id'           => $row->id,
									'created'      => $row->created,
									'city_id'      => $row->city_id,
									'wiki_name'    => Wikifactory::IdtoDB( $row->city_id ),
									'to'           => $row->dst,
									'subject'      => $matches[1],
									'attempted'    => $row->locked,
									'transmitted'  => $row->transmitted,
									'is_error'     => $row->is_error,
									'error_status' => $row->error_status,
									'error_msg'    => $row->error_msg,
									'opened'       => $row->opened,
								   );
		}

    	// Create a template object and give it all the data it needs
    	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
    	$oTmpl->set_vars(array('wgUser'  => $wgUser,
    						   'records' => $mail_records,
   						));
	    $wgOut->addHtml($oTmpl->execute("wikia-mailer-log"));

		wfProfileOut( __METHOD__ );
	}
}
