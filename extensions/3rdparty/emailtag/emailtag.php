<?php

/**
 * Copyright (C) 2005-2006 Tino Reichardt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License Version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Tino Reichardt <milky dash emailtag at mcmilk dot de>
 * @copyright © 2006 Tino Reichardt
 */

if (!defined('MEDIAWIKI')) die();

$wgEmailImage['size']=4;       /* 1..5 */
$wgEmailImage['ugly']='*#$*��%!'; /* some character or string */

/* image creation */
$wgExtensionFunctions[] = "wfEmailSpecialpage";
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Email-Image',
	'author' => 'Tino Reichardt',
	'url' => 'http://www.mcmilk.de/wiki/Category:Wiki-EmailTag'
);

/* email tag */
$wgExtensionFunctions[] = 'wfEmailTag';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'EmailTag',
	'author' => 'Tino Reichardt',
	'url' => 'http://www.mcmilk.de/wiki/Category:Wiki-EmailTag'
);

function wfEmailTag() {
  global $wgParser;
  $wgParser->setHook( "email", "wfEmailTagDoit" );
}

function wfEmailTagDoit($string="") {
  global $wgScript, $wgEmailImage;

  /* we need latin1 characters */
  $string = utf8_decode($string);

  /* add some random like stuff (which is known to the image creation) */
  for ($i=0,$s=""; $i < strlen($string); $i++) {
    $s.=$string[$i]; $s.=$wgEmailImage['ugly'];
  }
  $string = base64_encode($string);
  $string = str_rot13($string);
  $string = rawurlencode($string);

  $text  = "<img src=\"$wgScript";
  $text .= "?title=Special:Email&amp;img=";
  $text .= $string;
  $text .= "\" alt=\"some mail\" />";

  return $text;
}

/* show some email image */
function wfEmailSpecialpage() {

  class Email extends SpecialPage {

    function Email() {
      SpecialPage::SpecialPage( 'Email' );
      $this->includable(true);
      $this->listed(false);
    }

    function execute() {
      global $wgOut, $wgRequest, $wgEmailImage;
      $size=4;

      $text = $wgRequest->getText('img');

      /* decode this rubbish */
      $text = rawurldecode($text);
      $text = str_rot13($text);
      $text = base64_decode($text);
      $text = str_replace($wgEmailImage['ugly'], "", $text);

      $fontwidth = imagefontwidth($size);
      $fontheight = imagefontheight($size);
      $width = strlen($text) * $fontwidth + 4;
      $height = $fontheight + 2;
      $im = @imagecreatetruecolor ($width, $height) or exit;
      $trans = imagecolorallocate ($im, 0,0,0); /* must be black! */
      $color = imagecolorallocate ($im, 1,1,1); /* nearly black ;) */
      imagecolortransparent($im, $trans); /* seems to work only with black! */
      imagestring($im, $size, 2, 0, $text, $color);
      //header ("Content-Type: image/png"); imagepng($im); => IE is just so bad!
      header ("Content-Type: image/gif"); imagegif($im);
      exit;
    }
  } /* class */

  SpecialPage::addPage( new Email );
}
