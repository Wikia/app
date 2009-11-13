<?php
$factor = 150 / $info['width'];
echo "<div style=\"float:left\">" .
	Xml::element( 'input', array(
		'name' => 'wpCaptchaWord',
		'id'   => 'wpCaptchaWord' ) ) .
	"<br/>\n" .
	Xml::element( 'span', array(
		'id' => 'wpCaptchaInfo' ),
		wfMsg('fancycaptcha-createaccount') ) .
	"</div>\n<div>" .
	Xml::element( 'img', array(
		'src'    => $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) ),
		'width'  => round($info['width'] * $factor),
		'height' => round($info['height'] * $factor),
		'alt'    => 'captcha' ) ) .
	"</div>\n" .
	Xml::element( 'input', array(
		'type'  => 'hidden',
		'name'  => 'wpCaptchaId',
		'id'    => 'wpCaptchaId',
		'value' => $index ) );