<?php


/**
 * Special page for moderating advertisements
 *
 */
class SpecialAdminAds extends SpecialPage {
	
	private $adlimit = 10;//number of ads to show on page
	private $ispaypal;
	
	public function __construct() {
		if($this->HandlePayPal()){
			$this->ispaypal = 1;
			parent::__construct( 'AdminAds');
			return;
		}else{
			//restrict to only those with edit interface rights
			$this->ispaypal = 0;
			parent::__construct( 'AdminAds', 'editinterface'  );
		}
	}
	
	public function execute( $par ) {
		if($this->ispaypal == 1) return;
		global $wgOut, $wgRequest, $wgMessageCache;
		global $wgUser;

		//check permissions
		if ( !$this->userCanExecute($wgUser) ) {
			$this->displayRestrictionError();
			return;
		}
		$wgMessageCache->loadAllMessages();
		$this->setHeaders();
		$wgOut->setPagetitle("AdminAds");
		$text = "Here is where you moderate advertisements";
		$token = $wgRequest->getText( 'token' );
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $token, 'moderate' ) ) {
			//handle actions
			//edit
			if($wgRequest->getText('edit') > 0){
				$wgOut->addHTML($this->makeEditAddForm($wgRequest->getText('edit')));
			}else if($wgRequest->getText('save') == 'save' && $wgRequest->getText('ad_id') > 0){
				//save
				$ad = new Advertisement();
				if($ad->LoadFromDB($wgRequest->getText('ad_id'))){
					$ad->ad_link_url = $wgRequest->getText('ad_link_url');
					$ad->ad_link_text = $wgRequest->getText('ad_link_text');
					$ad->ad_text = $wgRequest->getText('ad_text');
					$ad->Save();
					$wgOut->addHTML('<p>Saved updated ad</p>');
				}else{
					$wgOut->addHTML('<p>Could not load ad:'.$wgRequest->getText('ad_id').'</p>');
				}
			}else if($wgRequest->getText('approve') > 0){
				//approve
				$ad = new Advertisement();
				if($ad->LoadFromDB($wgRequest->getText('approve'))){
					$ad->ad_status = 1;
					$ad->Save();
				}else{
					$wgOut->addHTML('<p>Could not load ad:'.$wgRequest->getText('approve').'</p>');
				}
			}
		}
		$wgOut->addHTML($this->ModerationForm());
	}
	
	private function ModerationForm(){
		global $wgUser, $wgRequest;
		$self = $this->getTitle();
		$form = "";
		$adlimit = 10;
		$startlimit = 0;
		$selectParams = array('ad_status'=>'0');
		$ads = Advertisement::LoadAdsFromDB($selectParams,$adlimit+1,$startlimit);
		if(is_array($ads)){
			$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
			$form .= Xml::hidden( 'token', $wgUser->editToken( 'moderate' ) );
			$form .=  '<table border="1">';
			$form .= '<tr><th>Wiki</th><th>Original Page</th><th>Sponsor URL</th><th>Sponsor Link</th><th>Sponsor HTML</th><th>Last Payment</th><th>Moderate</th></tr>';
			$pagesize = $adlimit;
			$nextpage = false;
			if(count($ads) < $adlimit){
				$pagesize = count($ads);
			}else{
				$nextpage = true;
			}
			for($i = 0; $i<$pagesize; $i++){
				$form .= '<tr><td>'.$ads[$i]->wiki_db;
				$form .= '</td><td><a href="'.$ads[$i]->page_original_url.'">'.$ads[$i]->page_original_url.'</a>';
				$form .= '</td><td>'.$ads[$i]->ad_link_url;
				$form .= '</td><td>'.$ads[$i]->ad_link_text;
				$form .= '</td><td>'.$ads[$i]->ad_text;
				$form .= '</td><td>'.$ads[$i]->last_pay_date;
				$form .= '</td><td><button type="submit" name="edit" value="'.$ads[$i]->ad_id.'">edit</button>';
				$form .= '<button type="submit" name="approve" value="'.$ads[$i]->ad_id.'">approve</button>';
				$form .= '</td></tr>';
			}
			$form .= '</table>';
			$form .= Xml::closeElement( 'form' );
		}
		return $form;
	}
	
	//returns true if it appears to be paypal
	//use the full URL, fully expanded with index.php?title=Special:AdminAds 
	//when registering with Paypal
	private function HandlePayPal(){
		global $wgRequest;
		global $wgEmergencyContact;
		//address to send error messages to 			
		$defaultemail = $wgEmergencyContact;
		//NOTE: sending to https may require further configuration
		//an empty $result variable may be an indicator of this problem
		//may need to do other stuff to enable https
		//$url = "http://www.sandbox.paypal.com/cgi-bin/webscr";
		$url = "http://www.paypal.com/cgi-bin/webscr";

		if(is_array($_POST) && isset($_POST['payment_status'])!=''){
			if(get_magic_quotes_gpc()) {
				foreach($_POST as $key=>$value){
					$_POST[$key]=$value;
				}
			}
			// Read the post from PayPal and add 'cmd' 
			$req = 'cmd=_notify-validate'; 
			foreach ($_POST as $key => $value){ 
				$pcode = urlencode($value); 
				$req .= "&$key=$pcode";   
			}
			$ch = curl_init();    // Starts the curl handler
			curl_setopt($ch, CURLOPT_URL,$url); // Sets the paypal address for curl
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // Returns result to a variable instead of echoing
			curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Sets a time limit for curl in seconds (do not set too low)
			curl_setopt($ch, CURLOPT_POST, 1); // Set curl to send data using post
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req); // Add the request parameters to the post
			$result = curl_exec($ch); // run the curl process (and return the result to $result
			curl_close($ch); 

			if (strcmp ($result, "VERIFIED") == 0) { 
				// TODO: 
				// Check the payment_status is Completed 
				// Check that txn_id has not been previously processed (necessary?)
				// Check that receiver_email is your Primary PayPal email 

				//mail($defaultemail, "Live-VERIFIED IPN x", print_r($_POST,1) . "\n\n" . $req); 
				//post the payment info to the database - should be local database
				global $wgDBname;
				$dbw = wfGetDB( DB_MASTER, array(), $wgDBname );
				$adID = $wgRequest->getText('item_number');
				$email = $wgRequest->getText('payer_email');
				$amt = $wgRequest->getText('payment_gross');
				$type = $wgRequest->getText('txn_type');
				$status = $wgRequest->getText('payment_status');
				$saveAry = array('ad_id'=>$adID,
					'payer_email'=>$email,
					'pay_amt'=>$amt,
					'pay_type'=>$type,
					'pay_status'=>$status,
					'pay_conf_msg'=>$result."\n\n".print_r($_POST,1));
				$dbw->Insert('advert_pmts',$saveAry);
				//check the payment amount and currency
				//TODO:  Check that the pay_status is "Completed"
				if($wgRequest->getText('payment_status') == 'Completed'){
					$ad = new Advertisement();
					$ad->LoadFromDB($adID);
					if($wgRequest->getText('mc_currency') == 'USD' && $amt == $ad->ad_price){
						$ad->last_pay_date = date('Y-m-d');
						$ad->Save();
					}else{
						mail($defaultemail, "Invalid Payment Amount or Currency", print_r($_POST,1) . "\n\n" . $req);
					}
				}
				//we could trap for some other statuses here... worry about that later
			} else if (strcmp ($result, "INVALID") == 0) { 
			// If 'INVALID', send an email. TODO: Log for manual investigation. 
				mail($defaultemail, "Invalid PayPal Payment IPN Verfication", print_r($_POST,1) . "\n\n" . $req); 
			} else {
				mail($defaultemail,"Error in IPN", "result=".$result."\n\n".print_r($_POST,1)."\n\n".$req);
			}
			return true;
		}
		return false;
	}
	
	private function makeEditAddForm($adID) {
		global $wgUser, $wgRequest;
		$self = $this->getTitle();
		$ad = new Advertisement();
			if($ad->LoadFromDB($adID)){
			$token = $wgRequest->getText( 'token' );
			$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
			$form .= Xml::hidden( 'token', $wgUser->editToken( 'moderate' ) );
			$form .= Xml::hidden( 'ad_id',$ad->ad_id);
			$form .= '<table>
				<tr><td>URL of sponsoring website (your website): </td>
					<td><input type="text" name="ad_link_url" size="30" value="'.htmlentities($ad->ad_link_url).'" /></td></tr>
				<tr><td>Text displayed in the link:</td>
					<td><input type="text" name="ad_link_text" size="30" value="'.htmlentities($ad->ad_link_text).'" /></td></tr>
				<tr><td>HTML to be displayed:</td>
					<td><textarea name="ad_text" cols="30">'.htmlentities($ad->ad_text).'</textarea></td></tr>
				<tr><td><input type="submit" name="save" value="save" /></td></tr>
					</table>'."\n";
			$form .= Xml::closeElement( 'form' );
		} else {
			$form = "Invalid Ad ID";
		}
		return $form;
	}

	
	
}