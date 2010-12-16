<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
  echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/DonationInterface/activemq_stomp/activemq_stomp.php" );
EOT;
  exit( 1 );
}
 
$wgExtensionCredits['other'][] = array(
	     'name' => 'ActiveMQ - PHP STOMP',
	     'author' => 'Four Kitchens',
	     'url' => '',
	     'description' => 'Interface to send donation data to ActiveMQ server',
	     'descriptionmsg' => 'activemq_stomp-desc',
	     'version' => '1.0.0',
);


$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['activemq_stomp'] = $dir . 'activemq_stomp.php'; # Tell MediaWiki to load the extension body.

//default variables that should be set in LocalSettings
$wgStompServer = "";

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	     $wgHooks['ParserFirstCallInit'][] = 'efStompSetup';
} else { // Otherwise do things the old fashioned way
	     $wgExtensionFunctions[] = 'efStompSetup';
}


/*
* Create <donate /> tag to include landing page donation form
*/
function efStompSetup(&$parser) {
	     global $wgParser, $wgOut;
	     
	     $parser->disableCache();
	     			
	     $wgParser->setHook( 'stomp', 'efStompTest' );
       
       return true;
}

function efStompTest($input, $args, &$parser) {
  
        $parser->disableCache();
        
        $output = "STOMP Test page";
        
        wfRunHooks('gwStomp', array(&$transaction));
        
        return $output;
}

/** 
* Hook to get user provided and order data
*
*/
$wgHooks['gwStomp'][] = 'sendSTOMP';
$wgHooks['gwPendingStomp'][] = 'sendPendingSTOMP';


/*
* Hook to send transaction information to ActiveMQ server
*/
function sendSTOMP($transaction) {
        global $wgOut;
        global $wgStompServer, $wgStompQueueName;
        
        $queueName = isset ( $wgStompQueueName ) ? $wgStompQueueName : 'test';
        
        // include a library
        require_once("Stomp.php");
          
        $message = json_encode(createQueueMessage($transaction));
        
        // make a connection
        $con = new Stomp($wgStompServer);
        
        // connect
        $con->connect();
        
        // send a message to the queue
        $result = $con->send("/queue/$queueName", $message, array('persistent' => 'true'));
        
        if (!$result) {
                wfDebugLog('activemq_stomp', 'Send to Q failed for this message: ' . $message);
}
        
        $con->disconnect();
        
        return true;
}

/*
* Hook to send transaction information to ActiveMQ server
*/
function sendPendingSTOMP($transaction) {
        global $wgOut;
        global $wgStompServer, $wgPendingStompQueueName;
        
        $queueName = isset ( $wgStompQueueName ) ? $wgStompQueueName : 'pending';
        
        // include a library
        require_once("Stomp.php");
          
        $message = json_encode(createQueueMessage($transaction));
        
        // make a connection
        $con = new Stomp($wgStompServer);
        
        // connect
        $con->connect();
        
        // send a message to the queue
        $result = $con->send("/queue/$queueName", $message, array('persistent' => 'true'));
        
        if (!$result) {
                wfDebugLog('activemq_stomp', 'Send to Pending Q failed for this message: ' . $message);
}
        
        $con->disconnect();
        
        return true;
}

/**
 * Assign correct values to the array of data to be sent to the ActiveMQ server
 * TODO: include optout and comments option in the donation page
 * NOTES: includes middle name
 * Currency in receiving module has currency set to USD, should take passed variable for these
 * PAssed both ISO and country code, no need to look up
 * 'gateway' = payflowpro (is this correct?)
 * 'date' is sent as $date("r") so it can be translated with strtotime like Paypal transactions (correct?)
 * 'gross', 'original_gross', and 'net' are all set to amount, no fees are included in these transactions
 * Payflows ID sent in the transaction response is assigned to 'gateway_txn_id' (PNREF)
 * Order ID (generated with transaction) is assigned to 'contribution_tracking_id'?
 * Response from Payflow is assigned to 'response'
 */
function createQueueMessage($transaction) {
        $message = array();
  
        $timestamp = strtotime($transaction['date']);
        
        // specifically designed to match the CiviCRM API that will handle it
        // edit this array to include/ignore transaction data sent to the server
        $message = array( 
                'contribution_tracking_id' => $transaction['contribution_tracking_id'],
                'optout'                 => $transaction['optout'],
                'anonymous'              => $transaction['anonymous'],
                'comment'                => $transaction['comment'],
                'utm_source'             => $transaction['utm_source'],
                'utm_medium'             => $transaction['utm_medium'],
                'utm_campaign'           => $transaction['utm_campaign'],
                'language'               => $transaction['language'],
                'referrer'               => $transaction['referrer'],
                'email'                  => $transaction['email'],
                'first_name'             => $transaction['fname'],
                'middle_name'            => $transaction['mname'],
                'last_name'              => $transaction['lname'],
                'street_address'         => $transaction['street'],
                'supplemental_address_1' => '',
                'city'                   => $transaction['city'],
                'state_province'         => $transaction['state'],
                'country'                => $transaction['country_name'],
                'countryID'              => $transaction['country_code'],
                'postal_code'            => $transaction['zip'],
                'gateway'                => 'payflowpro',
                'gateway_txn_id'         => $transaction['PNREF'],
                'response'               => $transaction['RESPMSG'],
                'currency'               => $transaction['currency'],
                'original_currency'      => $transaction['currency'],
                'original_gross'         => $transaction['amount'],
                'fee'                    => '0',
                'gross'                  => $transaction['amount'],
                'net'                    => $transaction['amount'],
                'date'                   => $transaction['date'],
  
        );
 
        return $message;
}
