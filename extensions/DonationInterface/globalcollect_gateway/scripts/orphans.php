<?php
//actually, as a maintenance script, this totally is a valid entry point. 

//If you want to use this script, you will have to add the following line to LocalSettings.php:
//$wgAutoloadClasses['GlobalCollectOrphanAdapter'] = $IP . '/extensions/DonationInterface/globalcollect_gateway/scripts/orphan_adapter.php';

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( _FILE_ ) . '/../../../..';
}

//If you get errors on this next line, set (and export) your MW_INSTALL_PATH var. 
require_once( "$IP/maintenance/Maintenance.php" );

class GlobalCollectOrphanRectifier extends Maintenance {
	
	protected $killfiles = array();
	protected $order_ids = array();
	protected $max_per_execute = 500; //only really used if you're going by-file.
	protected $target_execute_time = 30; //(seconds) - only used by the stomp option.
	protected $adapter;
	
	function execute(){
		$func = 'parse_files';
		if ( !empty( $_SERVER['argv'][1] ) ){
			if ( $_SERVER['argv'][1] === 'stomp' ){
				$func = 'orphan_stomp';
				if ( !empty( $_SERVER['argv'][2] ) && is_numeric( $_SERVER['argv'][2] ) ){
					$this->target_execute_time = $_SERVER['argv'][2];
				}
			} elseif ( is_numeric( $_SERVER['argv'][1] ) ){
				$this->max_per_execute = $_SERVER['argv'][1];
			}
		}
		
		$data = array(
			'wheeee' => 'yes'			
		);
		$this->adapter = new GlobalCollectOrphanAdapter(array('external_data' => $data));
		
		//Now, actually do the processing. 
		if ( method_exists( $this, $func ) ) {
			$this->{$func}();
		} else {
			echo "There's no $func in Orphan Rectifying!\n";
			die();
		}
	}
	
	function orphan_stomp(){
		echo "Orphan Stomp\n";
		$this->removed_message_count = 0;
		$this->now = time(); //time at start, thanks very much. 
		
		//I want to be clear on the problem I hope to prevent with this. 
		//Say, for instance, we pull a legit orphan, and for whatever reason, can't completely rectify it. 
		//Then, we go back and pull more... and that same one is in the list again. We should stop after one try per message per execute.
		//We should also be smart enough to not process things we believe we just deleted. 
		$this->handled_ids = array();
		
		//first, we need to... clean up the limbo queue. 
		
		//building in some redundancy here.
		$collider_keepGoing = true;
		$am_called_count = 0;
		while ( $collider_keepGoing ){
			$antimessageCount = $this->handleStompAntiMessages();
			$am_called_count += 1;
			if ( $antimessageCount < 10 ){
				$collider_keepGoing = false;
			} else {
				sleep(2); //two seconds. 
			}
		}
		$this->adapter->log( 'Removed ' . $this->removed_message_count . ' messages and antimessages.' );
		
		if ( $this->keepGoing() ){
			//Pull a batch of CC orphans, keeping in mind that Things May Have Happened in the small slice of time since we handled the antimessages. 
			$orphans = $this->getStompOrphans();
			while ( count( $orphans ) && $this->keepGoing() ){
				//..do stuff. 
				foreach ( $orphans as $correlation_id => $orphan ) {
					//process
					if ( $this->keepGoing() ){
						if ( $this->rectifyOrphan( $orphan ) ){
							$this->addStompCorrelationIDToAckBucket( $correlation_id );
							$this->handled_ids[$correlation_id] = 'rectified';
						} else {
							$this->handled_ids[$correlation_id] = 'error';
						}
					}
				}
				$this->addStompCorrelationIDToAckBucket( false, true ); //ack all outstanding. 
				if ( $this->keepGoing() ){
					$orphans = $this->getStompOrphans();
				}
			}
		}
		
		$this->addStompCorrelationIDToAckBucket( false, true ); //ack all outstanding.

		//TODO: Make stats squirt out all over the place.  
		$am = 0;
		$rec = 0;
		$err = 0;
		foreach( $this->handled_ids as $id=>$whathappened ){
			switch ( $whathappened ){
				case 'antimessage' : 
					$am += 1;
					break;
				case 'rectified' : 
					$rec += 1;
					break;
				case 'error' :
					$err += 1;
					break;
			}
		}
		$final = "\nDone! Final results: \n";
		$final .= " $am destroyed via antimessage (called $am_called_count times) \n";
		$final .= " $rec rectified orphans \n";
		$final .= " $err errored out \n";
		if ( isset( $this->adapter->orphanstats ) ){
			foreach ( $this->adapter->orphanstats as $status => $count ) {
				$final .= "   Status $status = $count\n";
			}
		}
		$this->adapter->log($final);
		echo $final;
	}
	
	function keepGoing(){
		$elapsed = time() - $this->now;
		if ( $elapsed < $this->target_execute_time ){
			return true;
		} else {
			return false;
		}
	}
	
	function addStompCorrelationIDToAckBucket( $correlation_id, $ackNow = false ){
		static $bucket = array();
		$count = 50; //sure. Why not?
		if ( $correlation_id ) {
			$bucket[$correlation_id] = "'$correlation_id'"; //avoiding duplicates.
			$this->handled_ids[$correlation_id] = 'antimessage';
		}
		if ( count( $bucket ) && ( count( $bucket ) >= $count || $ackNow ) ){
			//ack now.
			echo 'Acking ' . count( $bucket ) . " bucket messages.\n";
			$selector = 'JMSCorrelationID IN (' . implode( ", ", $bucket ) . ')';
			$ackMe = stompFetchMessages( 'cc-limbo', $selector, $count * 100 ); //This is outrageously high, but I just want to be reasonably sure we get all the matches. 
			$retrieved_count = count( $ackMe );
			if ( $retrieved_count ){
				stompAckMessages( $ackMe );
				$this->removed_message_count += $retrieved_count;
				echo "Done acking $retrieved_count messages. \n";
			} else {
				echo "Oh noes! No messages retrieved for $selector...\n";
			}
			$bucket = array();
		}
		
	}
	
	function handleStompAntiMessages(){
		$selector = "antimessage = 'true'";
		$antimessages = stompFetchMessages( 'cc-limbo', $selector, 1000 );
		$count = 0;
		while ( count( $antimessages ) > 10 && $this->keepGoing() ){ //if there's an antimessage, we can ack 'em all right now. 
			$count += count( $antimessages );
			foreach ( $antimessages as $message ){
				//add the correlation ID to the ack bucket. 
				if (array_key_exists('correlation-id', $message->headers)) {
					$this->addStompCorrelationIDToAckBucket( $message->headers['correlation-id'] );
				} else {
					echo 'The STOMP message ' . $message->headers['message-id'] . " has no correlation ID!\n";
				}
			}
			$this->addStompCorrelationIDToAckBucket( false, true ); //ack all outstanding.
			$antimessages = stompFetchMessages( 'cc-limbo', $selector, 1000 );
		}
		$this->addStompCorrelationIDToAckBucket( false, true ); //this just acks everything that's waiting for it.
		$this->adapter->log("Found $count antimessages.");
		return $count;
	}
	
	/**
	 * Returns an array of **at most** 300 decoded orphans that we don't think we've rectified yet. 
	 * @return array keys are the correlation_id, and the values are the decoded stomp message body. 
	 */
	function getStompOrphans(){
		$time_buffer = 60*20; //20 minutes? Sure. Why not? 
		$selector = "payment_method = 'cc'";
		$messages = stompFetchMessages( 'cc-limbo', $selector, 300 );
		$orphans = array();
		foreach ( $messages as $message ){
			if ( !array_key_exists('antimessage', $message->headers )
				&& !array_key_exists( $message->headers['correlation-id'], $this->handled_ids ) ) {
				//check the timestamp to see if it's old enough. 
				$decoded = json_decode($message->body, true);
				if ( array_key_exists( 'date', $decoded ) ){
					$elapsed = $this->now - $decoded['date'];
					if ( $elapsed > $time_buffer ){
						//we got ourselves an orphan! 
						$correlation_id = $message->headers['correlation-id'];
						$order_id = explode('-', $correlation_id);
						$order_id = $order_id[1];
						$decoded['order_id'] = $order_id;
						$decoded['i_order_id'] = $order_id;
						$decoded = unCreateQueueMessage($decoded);
						$decoded['card_num'] = '';
						$orphans[$correlation_id] = $decoded;
						echo "Found an orphan! $correlation_id \n";
					}
				}
			}
		}
		return $orphans;
	}
	
	function parse_files(){
		//all the old stuff goes here. 
		$order_ids = file( 'orphanlogs/order_ids.txt', FILE_SKIP_EMPTY_LINES );
		foreach ( $order_ids as $key=>$val ){
			$order_ids[$key] = trim( $val );
		}
		foreach ( $order_ids as $id ){
			$this->order_ids[$id] = $id; //easier to unset this way. 
		}
		$outstanding_count = count( $this->order_ids );
		echo "Order ID count: $outstanding_count \n";
		
		$files = $this->getAllLogFileNames();
		$payments = array();
		foreach ( $files as $file ){
			if ( count( $payments ) < $this->max_per_execute ){
				$file_array = $this->getLogfileLines( $file );
				$payments = array_merge( $this->findTransactionLines( $file_array ), $payments );
				if ( count( $payments ) === 0 ){
					$this->killfiles[] = $file;
					echo print_r( $this->killfiles, true );
				}
			}
		}
		
		$this->adapter->setCurrentTransaction('INSERT_ORDERWITHPAYMENT');
		$xml = new DomDocument;
		
		//fields that have generated notices if they're not there. 
		$additional_fields = array(
			'card_num',
			'comment',
			'size',
			'utm_medium',
			'utm_campaign',
			'referrer',
			'mname',
			'fname2',
			'lname2',
			'street2',
			'city2',
			'state2',
			'country2',
			'zip2',			
		);
		
		foreach ($payments as $key => $payment_data){
			$xml->loadXML($payment_data['xml']);
			$parsed = $this->adapter->getResponseData($xml);
			$payments[$key]['parsed'] = $parsed;
			$payments[$key]['unstaged'] = $this->adapter->unstage_data($parsed);
			$payments[$key]['unstaged']['contribution_tracking_id'] = $payments[$key]['contribution_tracking_id'];
			$payments[$key]['unstaged']['i_order_id'] = $payments[$key]['unstaged']['order_id'];
			foreach ($additional_fields as $val){
				if (!array_key_exists($val, $payments[$key]['unstaged'])){
					$payments[$key]['unstaged'][$val] = null;
				}
			}
		}
		
		// ADDITIONAL: log out what you did here, to... somewhere. 
		// Preferably *before* you rewrite the Order ID file. 

		//we may need to unset some hooks out here. Like... recaptcha. Makes no sense.
		$i = 0;
		foreach($payments as $payment_data){
			if ($i < $this->max_per_execute){
				++$i;
				if ( $this->rectifyOrphan( $payment_data['unstaged'] ) ) {
					unset( $this->order_ids[$payment_data['unstaged']['order_id']] );
				}
			}
		}
		
		if ($outstanding_count != count($this->order_ids)){
			$this->rewriteOrderIds();
		}
	}
	
	/**
	 * Uses the Orphan Adapter to rectify a single orphan. Returns a boolean letting the caller know if
	 * the orphan has been fully rectified or not. 
	 * @param array $data Some set of orphan data. 
	 * @param boolean $query_contribution_tracking A flag specifying if we should query the contribution_tracking table or not.
	 * @return boolean True if the orphan has been rectified, false if not. 
	 */
	function rectifyOrphan( $data, $query_contribution_tracking = true ){
		echo 'Rectifying Orphan ' . $data['order_id'] . "\n";
		$rectified = false;
		
		$this->adapter->loadDataAndReInit( $data, $query_contribution_tracking );
		$results = $this->adapter->do_transaction( 'Confirm_CreditCard' );
		if ($results['status']){
			$this->adapter->log( $data['contribution_tracking_id'] . ": FINAL: " . $results['action'] );
			$rectified = true;
		} else {
			$this->adapter->log( $data['contribution_tracking_id'] . ": ERROR: " . $results['message'] );
			if ( strpos( $results['message'], "GET_ORDERSTATUS reports that the payment is already complete." ) ){
				$rectified = true;
			}
		}
		echo $results['message'] . "\n";
		
		return $rectified;
	}
	
	function getAllLogFileNames(){
		$files = array();
		if ($handle = opendir(dirname(__FILE__) . '/orphanlogs/')){
			while ( ($file = readdir($handle)) !== false ){
				if (trim($file, '.') != '' && $file != 'order_ids.txt' && $file != '.svn'){
					$files[] = dirname(__FILE__) . '/orphanlogs/' . $file;
				}
			}
		}
		closedir($handle);
		return $files;
	}
	
	function findTransactionLines($file){
		$lines = array();
		$orders = array();
		$contrib_id_finder = array();
		foreach ($file as $line_no=>$line_data){
			if (strpos($line_data, '<XML><REQUEST><ACTION>INSERT_ORDERWITHPAYMENT') === 0){
				$lines[$line_no] = $line_data;
			} elseif (strpos($line_data, 'Raw XML Response')){
				$contrib_id_finder[] = $line_data;
			} elseif (strpos(trim($line_data), '<ORDERID>') === 0){
				$contrib_id_finder[] = trim($line_data);
			}
		}
		
		$order_ids = $this->order_ids;
		foreach ($lines as $line_no=>$line_data){
			if (count($orders) < $this->max_per_execute){
				$pos1 = strpos($line_data, '<ORDERID>') + 9;
				$pos2 = strpos($line_data, '</ORDERID>');
				if ($pos2 > $pos1){
					$tmp = substr($line_data, $pos1, $pos2-$pos1);
					if (isset($order_ids[$tmp])){
						$orders[$tmp] = trim($line_data);
						unset($order_ids[$tmp]);
					}
				}
			}
		}
		
		//reverse the array, so we find the last instance first.
		$contrib_id_finder = array_reverse($contrib_id_finder);
		foreach ($orders as $order_id => $xml){
			$contribution_tracking_id = '';
			$finder = array_search("<ORDERID>$order_id</ORDERID>", $contrib_id_finder);
			
			//now search forward (which is actually backward) to the "Raw XML" line, so we can get the contribution_tracking_id
			//TODO: Some kind of (in)sanity check for this. Just because we've found it one step backward doesn't mean...
			//...but it's kind of good. For now. 
			$explode_me = false;
			while (!$explode_me){
				++$finder;
				if (strpos($contrib_id_finder[$finder], "Raw XML Response")){
					$explode_me = $contrib_id_finder[$finder];
				}
			}
			if (strlen($explode_me)){
				$explode_me = explode(': ', $explode_me);
				$contribution_tracking_id = trim($explode_me[1]);
				$orders[$order_id] = array(
					'xml' => $xml,
					'contribution_tracking_id' => $contribution_tracking_id,
				);
			}
		}
		
		return $orders;
	}
	
	function rewriteOrderIds() {
		$file = fopen('orphanlogs/order_ids.txt', 'w');
		$outstanding_orders = implode("\n", $this->order_ids);		
		fwrite($file, $outstanding_orders);
		fclose($file);
	}
	
	function getLogfileLines( $file ){
		$array = array(); //surprise! 
		$array = file($file, FILE_SKIP_EMPTY_LINES);
		//now, check about 50 lines to make sure we're not seeing any of that #012, #015 crap.
		$checkcount = 50;
		if (count($array) < $checkcount){
			$checkcount = count($array);
		}
		$convert = false;
		for ($i=0; $i<$checkcount; ++$i){
			if( strpos($array[$i], '#012') || strpos($array[$i], '#015') ){
				$convert = true;
				break;
			}
		}
		if ($convert) {
			$array2 = array(); 
			foreach ($array as $line){
				if (strpos($line, '#012')){
					$line = str_replace('#012', "\n", $line);
				}
				if (strpos($line, '#015') ){
					$line = str_replace('#015', "\r", $line);	
				}
				$array2[] = $line;
			}
			$newfile = implode("\n", $array2);
			
			$handle = fopen($file, 'w');
			fwrite($handle, $newfile);
			fclose($handle);
			$array = file($file, FILE_SKIP_EMPTY_LINES);
		}
		
		return $array;
	}
	
}

$maintClass = "GlobalCollectOrphanRectifier";
require_once( "$IP/maintenance/doMaintenance.php" );


