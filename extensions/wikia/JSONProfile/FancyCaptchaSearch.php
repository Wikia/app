<?php
if ( defined( 'MEDIAWIKI' ) ) {

class FancyCaptchaSearch extends FancyCaptcha {

function getJSON() {
		$info = $this->pickImage();
		if( !$info ) {
			die( "out of captcha images; this shouldn't happen" );
		}

		// Generate a random key for use of this captcha image in this session.
		// This is needed so multiple edits in separate tabs or windows can
		// go through without extra pain.
		$index = $this->storeCaptcha( $info );

		//wfDebug( "Captcha id $index using hash ${info['hash']}, salt ${info['salt']}.\n" );

		$title = Title::makeTitle( NS_SPECIAL, 'Captcha/image' );

	
		$captcha_stuff = array();
		$captcha_stuff["image"] = array("src"=>$title->getFullUrl( 'wpCaptchaId=' . urlencode( $index ) ),"width"=>$info["width"],"height"=>$info["height"],"alt"=>"");
		$captcha_stuff["hidden"] = array("name"=>"wpCaptchaId","id"=>"wpCaptchaId","value"=>$index);
		
		return $captcha_stuff;
	}

}

}

?>
