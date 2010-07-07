<?php
/*******************************************************************************************/
// TODO
//
// retrieve ads from cache or database for display ads (set into cache if retrieving from db)
//     (join to payments table so only paid up ads show)
// form to submit ad (with preview button?) 
//    (what validation level is normal in mediawiki?  just try to stick in in the db? need research)
//    form workflow: link url, link text, body, preview; edit or submit
// Paypal IPN listener page, posts payments to payments table
// page for moderation - list of ads, form to approve, edit, or reject ad
//	  update database and purge page (so ad shows) upon approval
//
/*******************************************************************************************/


/**
 * Special page for handling advertisements
 *
 */
class SpecialSponsor extends SpecialPage {
	
	public function __construct() {
		parent::__construct( 'Sponsor' );
	}
	
	public function execute( $par ) {
		global $wgOut, $wgUser,$wgRequest, $wgMessageCache;
		global $wgDisableCounters, $wgMiserMode;
		$wgMessageCache->loadAllMessages();
		
		$this->setHeaders();
		
		$wgOut->setPagetitle("Sponsor");

		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getText('token'), 'sponsor' )) {
			$submitType = $wgRequest->getText('submit');
			switch($submitType){
				case "preview":
					$ad = new Advertisement();
					$ad->LoadFromPost();
					$this->loadAdPrices($ad);
					$check = $ad->validate();
					if($check === true){
						$wgOut->addWikiMsg('sponsor-preview-prompt');
						$wgOut->addHTML($ad->OutPutHTML());
						$wgOut->addHTML($this->makeHiddenForm($ad));
					}else{
						$wgOut->addHTML('<div>');
						$wgOut->addWikiMsg('sponsor-preview-errors');
						if(count($check) > 0){
							foreach($check as $err){
								$wgOut->addHTML('<p>'.$err.'</p>');
							}
						}
						$wgOut->addHTML('</div>');
						$wgOut->addHTML( $this->makeInputForm());
					}
					break;
				case "save":
					$ad = new Advertisement();
					$ad->LoadFromPost();
					$this->loadAdPrices($ad);
					$check = $ad->validate();
					if($check === true){
						$ad->Save();
						$wgOut->addHTML($this->makePayPalForm($ad));
					}else{
						$wgOut->addHTML('<div>');
						$wgOut->addWikiMsg('sponsor-preview-errors');
						if(count($check) > 0){
							foreach($check as $err){
								$wgOut->addHTML('<p>'.$err.'</p>');
							}
						}
						$wgOut->addHTML('</div>');
						$wgOut->addHTML( $this->makeInputForm());
					}
					break;
				case "edit":
					$ad = new Advertisement();
					$ad->LoadFromPost();
					$wgOut->addHTML($ad->OutPutHTML());
					$wgOut->addHTML( $this->makeInputForm());
				default:
					//nothing
			}
			//$wgOut->addHTML("<pre>".print_r($ad,1)."</pre>");
		}else{
			$wgOut->addHTML( $this->makeInputForm());
		}
	}
	
	private function makeHiddenForm(){
		$form = "";
		global $wgRequest;
		if($wgRequest->wasPosted() && count($_POST)){
			$self = $this->getTitle();
			global $wgUser;
			$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
			$form .= Xml::hidden( 'token', $wgUser->editToken( 'sponsor' ) );
			foreach($_POST as $key=>$value){
				if($key != "submit"){
					$form.='<input type="hidden" name="'.$key.'" value="'.htmlentities($value).'" />';
				}
			}
			$form .="\n".'<input type="submit" name="submit" value="edit" />
				<input type="submit" name="submit" value="save" />';
			$form .= Xml::closeElement( 'form' );
		}
		return $form;
	}
	
	//WORKFLOW:  Create Ad, press Save (POSTs)
	//						Ad preview is shown with SUBCSCRIBE and EDIT buttons
	//						EDIT takes you back, SUBSCRIBE takes you to PayPal
	private function makeInputForm() {
		global $wgUser, $wgRequest, $wgSponsorshipPrices;

		$self = $this->getTitle();
		$ad = new Advertisement();
		$pageName = "";
		$token = $wgRequest->getText( 'token' );
		$pageclass = "";
		//see if hte form was posted
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $token, 'sponsor' ) ) {
			$ad->LoadFromPost();
		}
		if($ad->user_email==''){
			$ad->user_email=$wgUser->getEmail();
		}
		$pageName=$wgRequest->getText('page_name');
		$pageTitle = Title::newFromText($pageName);
		if($pageTitle == null || !$pageTitle->getArticleID()>0){
			$pageclass = 'style="color:red;"';
		}
		$price_duration = $wgRequest->getText('price_duration');
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::hidden( 'token', $wgUser->editToken( 'sponsor' ) );
		$form .= '<table>
			<tr><td>' . wfMsg('sponsor-form-url') . '</td>
				<td><input type="text" name="ad_link_url" size="30" value="'.htmlentities($ad->ad_link_url).'" /></td></tr>
			<tr><td>' . wfMsg('sponsor-form-linktext') . '</td>
				<td><input type="text" name="ad_link_text" size="30" value="'.htmlentities($ad->ad_link_text).'" /></td></tr>
			
			<tr><td>' . wfMsg('sponsor-form-additionaltext') . '</td>
				<td><textarea name="ad_text" cols="30">'.htmlentities($ad->ad_text).'</textarea></td></tr>
			<tr><td>' . wfMsg('sponsor-form-page') . '</td>
				<td><input type="text" name="page_name"'.$pageclass.' size="30" value="'.htmlentities($pageName).'" /></td></tr>
			<tr><td>' . wfMsg('sponsor-form-price') . '</td>
				<td><select name="price_duration"/>'."\n";

		global $wgSponsorshipYearDiscount, $wgSponsorshipYearDiscountTiers, $wgDBname;

		foreach($wgSponsorshipPrices as $key=>$opt){
			$selected = false;

			if ( $key == 'yr' && !empty( $wgSponsorshipYearDiscount ) ) {
				// FIXME: this is BAD. But we don't have any other way to get the full number per page :(
				$adsOnPage = empty( $ad->page_id ) ? 0 : count( Advertisement::FlushAdCache( $wgDBname, $ad->page_id ) );

				for ( $i = 1; $i <= $wgSponsorshipYearDiscountTiers; $i++ ) {
					$selected = false;
					$attribs = array( 'disabled' => 'disabled' );
					$price = $opt['price'] - ( $wgSponsorshipYearDiscountTiers - $i ) * $wgSponsorshipYearDiscount;
					$value = $price . 'yr';
					if ( $adsOnPage + 1 == $i ) {
						$attribs = array();
					}
					if( ( $price . $key ) == $price_duration ){
						$selected = true;
					}
					$form .= Xml::option( wfMsg( $opt['text'], $price, $i ), $value, $selected, $attribs );
				}
			} else {
				$selected = ( ( $opt['price'] . $key ) == $price_duration ) ? true : false;

				$form .= Xml::option( wfMsg( $opt['text'], $opt['price'] ), $opt['price'], $selected );
			}
		}
				$form .= '</select>
				
				(USD)</td></tr>
			<tr><td>' . wfMsg('sponsor-form-email') . '</td><td><input type="text" name="user_email" value="'.htmlentities($ad->user_email).'" /></td></tr>
			<tr><td></td><td><input type="submit" name="submit" value="preview" /></td></tr>
				</table>'."\n";
		$form .= Xml::closeElement( 'form' );
		return $form;
	}
	
	private function loadAdPrices($ad){
		global $wgRequest, $wgDBname, $wgSponsorshipPrices, $wgSponsorshipYearDiscount, $wgSponsorshipYearDiscountTiers;

		if($wgRequest->wasPosted() ){
			$pricedur = $wgRequest->getText('price_duration');
			$dur = substr( $pricedur, -2 );
			if(isset($wgSponsorshipPrices[$dur])){
				if ( $dur == 'yr' && !empty( $wgSponsorshipYearDiscount ) ) {
					// FIXME: for whatever reason, FlushAdCache returns mixed, should return empty array instead
					$adsOnPage = empty( $ad->page_id ) ? array() : Advertisement::FlushAdCache( $wgDBname, $ad->page_id );
					$adsOnPage = empty( $adsOnPage ) ? 0 : count( $adsOnPage );
					$ad->ad_price = $wgSponsorshipPrices[$dur]['price'] - ( ( $wgSponsorshipYearDiscountTiers - $adsOnPage - 1 ) * $wgSponsorshipYearDiscount );
				} else {
					$ad->ad_price = $wgSponsorshipPrices[$dur]['price'];
				}
				$ad->ad_months = $wgSponsorshipPrices[$dur]['months'];
			}
		}
	}
	
	private function makePayPalForm($ad){
		$business_email = "paypal@wikia.com";//email address for account
		$return_url = $ad->page_original_url;//return page
		$item_number = $ad->ad_id;
		$item_name = "Wikia Sponsorship for ". $ad->page_original_url;
		$price = $ad->ad_price;
		$duration = $ad->ad_months;
		$form = '<p>' . wfMsg('sponsor-form-thanks') . '</p>
		<form name="paypalform" id="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"><br />
			
			<input type="hidden" name="cmd" value="_xclick-subscriptions">
			<input type="hidden" name="business" value="'.$business_email .'">
			<input type="hidden" name="item_name" value="'.htmlentities($item_name).'">
			<input type="hidden" name="item_number" value="'.$item_number.'">
			<input type="hidden" name="return" value="'.htmlentities($return_url).'">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="email" value="'.htmlentities($ad->user_email).'">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="bn" value="PP-SubscriptionsBF">
			<input type="hidden" name="a3" value="'.$price.'">
			<input type="hidden" name="p3" value="'.$duration.'">
			<input type="hidden" name="t3" value="M">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1"><br />
			</form>
			<script type="text/javascript">
			  document.forms["paypalform"].submit();
			</script> 
			';
		return $form;
	}
	
}
