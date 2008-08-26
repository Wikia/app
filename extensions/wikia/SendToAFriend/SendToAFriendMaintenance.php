<?php

/**
 * @package MediaWiki
 * @subpackage SendToAFriend
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @author Maciej Brencz <macbre@wikia.com> for Wikia.com
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2007-2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


/**
 * @name SendToAFriendMaintenance
 *
 * class used by maintenance/background script
 */
class SendToAFriendMaintenance {

    /**
     * __construct
     *
     * constructor
     *
     */
    public function __construct()
    {
        #--- init stuffs here
    }


    /**
     * execute
     *
     * Main entry point, only public function
     *
     * @author eloy@wikia
     * @access public
     *
     * @return status of operations
     */
    public function execute()
    {
        global $wgMemc, $wgSharedDB ;

        wfProfileIn( __METHOD__ );
        #--- get emails to send
        $aQueue = $this->getQueue();;
        if( is_array( $aQueue ) ) {
            wfDebug('Will now try to send '.count($aQueue)." email(s)...\n");
            #---
            $dbw = wfGetDB( DB_MASTER );
            foreach( $aQueue as $oEmail ) {
                //print_r( $oEmail );
                $oEmailUser = User::newFromName($oEmail->que_user);
                if ( is_object($oEmailUser) ) {
                    $result = $oEmailUser->isBlocked();
                    if ($result) {
                        wfDebug( "User ".$oEmail->que_user." (que_user) is blocked\n" );
                        $this->setMsgBlocked($dbw, $oEmail->que_id, $oEmailUser);
                        continue;
                    }
                }

                $oEmailUserName = User::newFromName($oEmail->que_name);
                if ( is_object($oEmailUserName) ) {
                    $result = $oEmailUserName->isBlocked();
                    if ($result) {
                        wfDebug( "User ".$oEmail->que_name." (que_name) is blocked\n" );
                        $this->setMsgBlocked($dbw, $oEmail->que_id, $oEmailUserName);
                        continue;
                    }
                }

                $oEmailUserFrom = User::newFromName($oEmail->que_from);
                if ( is_object($oEmailUserFrom) ) {
                    $result = $oEmailUserFrom->isBlocked();
                    if ($result) {
                        wfDebug( "User ".$oEmail->que_from." (que_from) is blocked\n" );
                        $this->setMsgBlocked($dbw, $oEmail->que_id, $oEmailUserFrom);
                        continue;
                    }
                }

                $oEmailUserIP = User::newFromName($oEmail->que_ip, false);
                if ( is_object($oEmailUserIP) ) {
                    $result = $oEmailUserIP->isBlocked();
                    if ($result) {
                        wfDebug( "User ".$oEmail->que_ip." (que_ip) is blocked\n" );
                        $this->setMsgBlocked($dbw, $oEmail->que_id, $oEmailUserIP);
                        continue;
                    }
                }

                // create address objects
                $to       = array();
                $from     = new MailAddress("friends@wikia.com",  "Wikia Friends");
                $reply_to = new MailAddress($oEmail->que_from);

                // send emails
                $addresses = explode( ",", $oEmail->que_to );
            
                foreach ( $addresses as $address ) {
                    $to[] = new MailAddress(trim($address));
                }
                
                $success = UserMailer::send($to, $from, $oEmail->que_subject, $oEmail->que_body, $reply_to);
                
                if ( empty($success) || $success === true ) {
                    $dbw->update( wfSharedTable('send_queue'), array('que_sent' => 1), array('que_id' => $oEmail->que_id), __METHOD__);
                } else {
                	if (class_exists("WikiError") && WikiError::isError($success)) {
                		wfDebug('Message could not be sent. Mailer Error: ' . $success->getMessage() . "\n\n");
					} else {
                    	wfDebug('Message could not be sent. Mailer Error: ' . $success . "\n\n");
					}
                }
            } // \foreach
    	} // \if
    	else {
    		wfDebug("No emails to send!\n");
    	}
    	wfDebug("\n\n -- Finished!\n");
    	
        wfProfileOut( __METHOD__ );
    	return true;
    }

    /**
     * getQueue
     *
     * get emails for sending
     *
     * @access private
     * @author eloy@wikia
     *
     * @return array of DatabaseRow
     */
    private function getQueue()
    {
        wfProfileIn( __METHOD__ );

        $aEmails = array();
        $dbr = wfGetDB( DB_MASTER );

        $oRes = $dbr->select(
            wfSharedTable( "send_queue" ),
            array( "*" ),
            array( "que_sent" => 0 ),
            __METHOD__
        );

        while ( $oRow = $dbr->fetchObject( $oRes ) ) {
            $aEmails[] = $oRow;
        }

        $dbr->freeResult( $oRes );
        wfProfileOut( __METHOD__ );

        return $aEmails;
    }
    
    /**
     * setMsgBlocked
     * set blocked reason
     */
    private function setMsgBlocked($dbw, $que_id, $user) {
        $blocker = User::newFromId($user->mBlockedby);
        $blck_name = $user->mBlockedby;
        if (is_object($blocker)) {
            $blck_name = $blocker->getName();    
        }
        
        $newbody = "This message has been stopped due to block set by ".str_replace( "'", "", $blck_name );
        $newbody .= ", because of:\n" . str_replace( "'", "", $user->mBlockreason ) . "\n";
    
        wfDebug($newbody);
    
        $dbw->update( wfSharedTable('send_queue'), array('que_sent' => 2, 'que_body' => $newbody), array('que_id' => $que_id), __METHOD__);
    }

}
