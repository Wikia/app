<?php
/**********************************************************************************
Copyright (C) 2007-08 Sean Colombo (sean@lyricwiki.org)
Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1, 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

Please refer to sendToAFriend.php for full version description

**********************************************************************************/

$messages = array();
$messages['en'] = array(
	'sendtoafriend' => "Send To A Friend",

	'staf-title' => "Send $1 to a Friend",

	'staf-preview' => "Preview",
	'staf-emailsend' => "Send",
	'staf-emailpage' => "Email the page link.",
	'staf-emailsent' => "<div style='background-color:#80ff80'>The email has been sent.</div><p>Return to <strong>$1</strong> or go to a '''[[Special:Random|random page]]'''.</p>",
	'staf-emailfail' => "<span style='background-color:#ff8080'>Mail could not be sent.  Please try again later.  Sorry :(</span>",

	'staf-accesskey-send' => 's',
	'staf-accesskey-preview' => 'p',
	
	'staf-page' => "Page",
	'staf-friendemail' => "Your friend's email address",
	'staf-youremail' => "Your email address",
	'staf-subject' => "Subject line",
	'staf-message' => "Brief message",
	
	'staf-nopage' => "You haven't specified a page to send.  Browse to the page you wish to send and click the 'Send to a Friend' link.",
	'staf-invalidfriendemail' => "The email address you entered for your friend is not a valid email address.  Please fix any typos and try again.",
	
	'staf-spamnotice' => "
		We're sorry, but due to spammers trying to use our form to send out frequent spam, 
		we've begun filtering messages that appear to be spam.<br/>
		<strong>Please try again with a different message.</strong><br/>
		Sorry for the inconvenience!",

	'staf-defaultsubject' => "Check out these cool lyrics!",
// TODO: Get this to work correctly in FireFox (the box has a gap between the link and the rest of the div which makes the div too tall even though there aren't any margins, paddings, or offsets that should be causing that).  Probably inhereting something from the 'site-notice' div.
	'staf-box' => <<<DOC
<div style='float:right;border:1px #aaa solid;background-color:#ffff80;font-weight:bold;padding:5px !important;margin:3px 0 0 0;'>
	<a href='$1' style='float:left;line-height:16px;margin:0px !important;padding:0px !important;font-size:12px;'>
	<img src='/extensions/LyricWiki/sendToFriend.png' alt='->' title='Spread the word!' style='float:left;margin: 0 3px 0 0 !important;padding:0px;' width='16' height='16'/>
	Send to a friend
	</a>
</div>
DOC
,
	'staf-body' => <<<DOC
__NOEDITSECTION__ __NOTOC__
Hi,
You should check out $1 at {{SITENAME}}

{{fullurl:PAGE}}
$2

==About LyricWiki.org==
LyricWiki.org is a free site with lyrics to over 250,000 songs and doesn't have any annoying banners or popups.
Built on the same software as Wikipedia, anyone can add lyrics or fix mistakes.

Thanks to LyricWiki's SOAP webservice, the community has created free music player plugins and applications to
automatically grab lyrics for the song currently playing. Supports many popular music players: WinAmp,
Windows Media Player, Amarok, MusicCube, foobar2000 and more!
DOC
,
	);
