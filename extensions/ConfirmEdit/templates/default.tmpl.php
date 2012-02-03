<?php
//moved 1:1 from FancyCaptcha.class.php
echo "<p>" .
	Xml::element( 'img', array(
		'src'    => $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) ),
		'width'  => $info['width'],
		'height' => $info['height'],
		'alt'    => '' ) ) .
	"</p>\n" .
	Xml::element( 'input', array(
		'type'  => 'hidden',
		'name'  => 'wpCaptchaId',
		'id'    => 'wpCaptchaId',
		'value' => $index ) ) .
	"<p>" .
	Xml::element( 'input', array(
		'name' => 'wpCaptchaWord',
		'placeholder' => wfMsg('captcha-input-placeholder'),
		'id'   => 'wpCaptchaWord' ) ) .
	"</p>\n";