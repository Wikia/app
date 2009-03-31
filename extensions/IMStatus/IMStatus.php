<?php
// Check to make sure we're actually in MediaWiki.
if (!defined('MEDIAWIKI')) die('This file is part of MediaWiki. It is not a valid entry point.');

/*********************************************************************
* IM Status - A MediaWiki extension which add tags for status buttons
* for various IM programs (AIM, Google Talk, ICQ, Skype, Xfire, Yahoo)
* Copyright (C)2008 PatheticCockroach - http://www.patheticcockroach.com
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*********************************************************************/

/*********************
* Special thanks to:
* - Jeffrey Phillips Freeman for his AIM extension (http://www.mediawiki.org/wiki/Extension:AIM),
*   licensed in the Public domain and on which I based this extention.
* - Guy Taylor ("TheBigGuy"), who did a lot of work on various IM extensions (ICQ, Skype, also some work on AIM),
*   which helped me to find out some style and action options... it's a pity I had to rewrite these codes from the AIM one
*   because of a lack of license details, though
* - Other MediaWiki contributors, who improved the above-mentioned extensions - more details on extensions history pages:
*   #http://www.mediawiki.org/wiki/Extension:AIM
*   #http://www.mediawiki.org/wiki/Extension:ICQ
*   #http://www.mediawiki.org/wiki/Extension:Skype
*   #http://www.mediawiki.org/wiki/Extension:Yahoo
**********************/

$wgExtensionMessagesFiles['IMStatus'] = dirname( __FILE__ ) . "/IMStatus.i18n.php";

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'IM Status',
	'version' => '1.3',
	'author' => array( 'PatheticCockroach', 'various MediaWiki contributors' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:IM_Status',
	'description' => 'Adds tags to show various IM online status (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'descriptionmsg' => 'imstatus-desc'
);

//*********** MANDATORY parameters - start
//You'll have to go to http://developer.aim.com/manageKeys.jsp to get your developper key.
$wgAimKey_presence = "fr1GkAasYuJG7QM3"; 	// get a Presence key for this
$wgAimKey_api = "re1DoqFLUFKW4_YE";		// get a Web AIM key for this
//*********** MANDATORY parameters - end

//Tag creation
$wgExtensionFunctions[] = "wfIMStatusPCR";
function wfIMStatusPCR()
{
	global $wgParser;
	$wgParser->setHook( "aim", "RenderAIM" );
	$wgParser->setHook( "gtalk", "RenderGTalk" );
	$wgParser->setHook( "icq", "RenderICQ" );
	$wgParser->setHook( "livemessenger", "RenderLiveMessenger" );
	$wgParser->setHook( "skype", "RenderSkype" );
	$wgParser->setHook( "xfire", "RenderXfire" );
	$wgParser->setHook( "yahoo", "RenderYahoo" );
}

//NB: a nice list of styles and actions: http://cubicpath.syncleus.com/wiki/index.php/Cubicpath:Add-ons

/**********************************************
* the function that reacts to "<aim>"
***********************************************/
function RenderAIM( $input, $argv )
{
	// set your defaults for the style (presence or api)
	$style_default = "presence";
	// the variables are: <aim style="$argv['style']">$input</aim>
	// to get help as a user, use <aim help/>

	// sanitize input
    $input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
    if( isset( $argv['style'] ) )
	{
		$style = $argv['style'];
		if( !in_array( $style, array("presence", "api") ) ) $style = $style_default;
	}
	else $style = $style_default;

	// prepares output
	if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;aim style="[style]"&gt;['. wfMsg("imstatus_your_name", "AIM") .']&lt;/aim&gt;</span>';
		$output .= '<ul><li>style: '. wfMsg("imstatus_style") .'. '. wfMsg("imstatus_possible_val") .': "presence" '. wfMsg("imstatus_or") .' "api". '. wfMsg("imstatus_default") .': '.$style_default.'.';
		$output .= '<ul><li>'. wfMsg("imstatus_aim_presence", "&#34;presence&#34;") .'</li>';
		$output .='<li>'. wfMsg("imstatus_aim_api", "&#34;api&#34;") .'</li></ul></li></ul>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;aim style="api"&gt;PatheticCockroach&lt;/aim&gt;</span></div>';
	}
	else
	{
		global $wgAimKey_api;
		global $wgAimKey_presence;
		switch($style)
		{
			case "api":
				$output = '<script type="text/javascript" src="http://o.aolcdn.com/aim/web-aim/aimapi.js"></script>';
				$output .= '<div id="AIMBuddyListContainer" wim_key="'.$wgAimKey_api.'"></div>';
				$output .= '<a href="nojavascript.html" onclick="AIM.widgets.IMMe.launch(\''.$input.'\'); return false;">';
				$output .= '<img src="http://api.oscar.aol.com/presence/icon?k='.$wgAimKey_presence.'&t='.$input.'" border="0"/>Send me an IM</a>';
			break;

			default:
			case "presence":
				$output = '<a href="aim:GoIM?screenname='.$input.'"><img src="http://api.oscar.aol.com/presence/icon?k='.$wgAimKey_presence.'&t='.$input.'" border="0"/></a>';
			break;
		}
	}
	// sends output
    return $output;
}

/**********************************************
 * the function that reacts to "<gtalk>"
 **********************************************/
function RenderGTalk( $input, $argv )
{
	// set default, min and max width and height (Google Talk default: w=200, h=60) - options crawled from http://www.google.com/talk/service/badge/New
	$width_default = 200;
	$width_min = 200;
	$width_max = 400;
	$height_default = 60;
	$height_min = 60;
	$height_max = 60;
	// the varibles are: <gtalk width="$argv['width']" height="$argv['height']">$input</aim>
	// to get help as a user, use <gtalk help/>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);

	// get custom parameters
	if(isset($argv['width']))
	{
		$width = intval($argv['width']);
		if($width>$width_max || $width<$width_min) $width = $width_default;
	}
	else $width = $width_default;

	if(isset($argv['height']))
	{
		$height = intval($argv['height']);
		if($height>$height_max || $height<$height_min) $height = $height_default;
	}
	else $height = $height_default;

	// prepares output
	if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;gtalk width="[width]" height="[height]"&gt;['. wfMsg("imstatus_gtalk_code") .']&lt;/gtalk&gt;</span>';
		$output .= '<ul><li>width: '. wfMsg("imstatus_gtalk_width") .' '. wfMsg("imstatus_default") .':'.$width_default.'; '. wfMsg("imstatus_min") .':'.$width_min.'; '. wfMsg("imstatus_max") .':'.$width_max.'.</li>';
		$output .='<li>height: '. wfMsg("imstatus_gtalk_height") .' '. wfMsg("imstatus_default") .':'.$height_default.'; '. wfMsg("imstatus_min") .':'.$height_min.'; '. wfMsg("imstatus_max") .':'.$height_max.'.</li>';
		$output .= '<li>'. wfMsg("imstatus_gtalk_get_code", '<a href="http://www.google.com/talk/service/badge/New">Google Talk chatback badge</a>') .'</li></ul>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;gtalk width="200" height="60"&gt;55gsrf9c1avkt0pub15rkiv9vs&lt;/gtalk&gt;</span></div>';
	}
	else $output = '<iframe src="http://www.google.com/talk/service/badge/Show?tk='.$input.'&amp;w='.$width.'&amp;h='.$height.'" frameborder="0" allowtransparency="true" width="'.$width.'" height="'.$height.'"></iframe>';
	// sends output
	return $output;
}

/**********************************************
* the function that reacts to "<icq>"
 ***********************************************/
function RenderICQ( $input, $argv )
{
	// set your defaults for the style and action (0 to 26) (add) - NB: action is useless ATM (only one option...)
	$style_default = 26;
	$action_default = "add";
	// the varibles are: <icq style="$argv['style']" action="$argv['action']">$input</icq>
	// to get help as a user, use <icq help/>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
	if(isset($argv['style']))
	{
		$style = intval($argv['style']);
		if($style<0 || $style>26) $style = $style_default;
	}
	else $style = $style_default;

	if(isset($argv['action']))
	{
		$action = $argv['action'];
		if( $action != "add" ) $action = $action_default;
	}
	else $action = $action_default;

	// prepares outupt
	if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;icq style="[style]"&gt;['. wfMsg("imstatus_icq_id") .']&lt;/icq&gt;</span>';
		$output .= '<ul><li>style: '. wfMsg("imstatus_icq_style") .' '. wfMsg("imstatus_default") .': '.$style_default.'.</li></ul>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;icq style="2"&gt;984231&lt;/icq&gt;</span></div>';
	}
	else $output = '<a href="http://www.icq.com/people/about_me.php?uin='.$input.'&action='.$action.'"><img src="http://status.icq.com/online.gif?icq='.$input.'&img='.$style.'" alt="ICQ status"/></a>';
	// sends output
	return $output;
}


/**********************************************
* the function that reacts to "<livemessenger>"
***********************************************/
function RenderLiveMessenger( $input, $argv )
{
	// set your defaults for the style (button, icon or window) NB: the icon doesn't work properly on Firefox 3 beta 5 - reference: http://msdn2.microsoft.com/en-us/library/bb936691.aspx
	$style_default = "icon";
	// the variables are: <livemessenger style="$argv['style']">$input</livemessenger>
	// to get help as a user, use <livemessenger help/>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
	if(isset($argv['style']))
	{
		$style = $argv['style'];
		if(!in_array($style,array("button","icon","window"))) $style = $style_default;
	}
	else $style = $style_default;

	// prepares output
	if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;livemessenger style="[style]"&gt;['. wfMsg("imstatus_live_code") .']&lt;/livemessenger&gt;</span>';
		$output .= '<ul><li>style: "button", "icon" '. wfMsg("imstatus_or") .' "window". '. wfMsg("imstatus_default") .': '.$style_default.'.</li>';
		$output .= '<li>'. wfMsg("imstatus_live_get_code", "http://settings.messenger.live.com/applications/CreateHtml.aspx", "invitee=", "@apps.messenger") .'</li></ul>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;livemessenger style="button"&gt;8ebac9521f6e99e2&lt;/livemessenger&gt;</span></div>';
	}
	else
	{
		switch($style)
		{
			case "window":
				$output = '<iframe src="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee='.$input;
				$output .= '@apps.messenger.live.com&mkt=en-US" style="border:solid 1px black; width:300px; height:300px;" frameborder="0"></iframe>';
			break;
			case "button":
				$output = '<script type="text/javascript" src="http://settings.messenger.live.com/controls/1.0/PresenceButton.js"></script>';
				$output .= '<div id="Microsoft_Live_Messenger_PresenceButton_'.$input.'" msgr:width="100" msgr:backColor="#D7E8EC" msgr:altBackColor="#FFFFFF"';
				$output .= 'msgr:foreColor="#424542" msgr:conversationUrl="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee='.$input.'@apps.messenger.live.com&mkt=en-US"></div>';
				$output .= '<script type="text/javascript" src="http://messenger.services.live.com/users/'.$input.'@apps.messenger.live.com/presence?mkt=en-US&cb=Microsoft_Live_Messenger_PresenceButton_onPresence"></script>';
			break;

			case "icon":
			default:
				$output = '<a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee='.$input.'@apps.messenger.live.com&mkt=en-US">';
				$output .= '<img style="border-style: none;" src="http://messenger.services.live.com/users/'.$input.'@apps.messenger.live.com/presenceimage?mkt=en-US" width="16" height="16"/></a>';
			break;
		}
	}
	// sends output
    return $output;
}


/**********************************************
 * the function that reacts to "<skype>"
 ***********************************************/
function RenderSkype( $input, $argv )
{
	// set your defaults for the style and action (add, call, chat, sendfile, userinfo orvoicemail) (same + ballon, bigclassic smallclassic, smallicon or mediumicon)  - options crawled from http://www.skype.com/share/buttons/
	$style_default = "smallclassic";
	$action_default = "chat";
	// the varibles are: <skype style="$argv['style']" action="$argv['action']">$input</skpye>
	// to get help as a user, use <skype help/>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
	if(isset($argv['style']))
	{
		$style = $argv['style'];
		if (!in_array($style, array("add","chat","call","sendfile","userinfo","voicemail","balloon","bigclassic","smallclassic","smallicon","mediumicon")))
		{
			$style = $style_default;
		}
	}
	else $style = $style_default;

	// if style is an action style, action should match it!
	if(in_array($style, array("add","chat","call","sendfile","userinfo","voicemail"))) $action = $style;
	else if(isset($argv['action']))
	{
		$action = $argv['action'];
		if (!in_array($action, array("add","chat","call","sendfile","userinfo","voicemail"))) $action = $action_default;
	}
	else $action = $action_default;

	// creates image code
	switch($style)
	{
		case "add":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/add_blue_transparent_118x23.png" style="border: none;" width="118" height="23" alt="Add me to Skype"/>';
		break;

		case "chat":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/chat_blue_transparent_97x23.png" style="border: none;" width="97" height="23" alt="Chat with me"/>';
		break;

		case "call":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_70x23.png" style="border: none;" width="70" height="23" alt="Skype Me"/>';
		break;

		case "sendfile":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/sendfile_blue_transparent_98x23.png" style="border: none;" width="98" height="23" alt="Send me a file"/>';
		break;

		case "userinfo":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/userinfo_blue_transparent_108x23.png" style="border: none;" width="108" height="23" alt="View my profile"/>';
		break;

		case "voicemail":
				$image = '<img src="http://download.skype.com/share/skypebuttons/buttons/voicemail_blue_transparent_129x23.png" style="border: none;" width="129" height="23" alt="Leave me voicemail"/>';
		break;

		case "balloon":
				$image = '<img src="http://mystatus.skype.com/balloon/'.$input.'" style="border: none;" width="150" height="60" alt="My status"/>';
		break;

		case "bigclassic":
				$image = '<img src="http://mystatus.skype.com/bigclassic/'.$input.'" style="border: none;" width="182" height="44" alt="My status"/>';
		break;

		case "smallclassic":
				$image = '<img src="http://mystatus.skype.com/smallclassic/'.$input.'" style="border: none;" width="114" height="20" alt="My status"/>';
		break;

		case "smallicon":
				$image = '<img src="http://mystatus.skype.com/smallicon/'.$input.'" style="border: none;" width="16" height="16" alt="My status"/>';
		break;

		case "mediumicon":
		default:
				$image = '<img src="http://mystatus.skype.com/mediumicon/'.$input.'" style="border: none;" width="26" height="26"  alt="My status"/>';
		break;
	}

	// prepares outupt
    if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;skype style="[style]" action="[action]"&gt;['. wfMsg("imstatus_your_name", "Skype") .']&lt;/skype&gt;</span>';
		$output .= '<ul><li>style: '. wfMsg("imstatus_style") .'. '. wfMsg("imstatus_default") .': '.$style_default.'. '. wfMsg("imstatus_possible_val") .': "add","chat","call","sendfile","userinfo","voicemail","balloon","bigclassic","smallclassic","smallicon","mediumicon".</li>';
		$output .= '<li>action: '. wfMsg("imstatus_action") .'. '. wfMsg("imstatus_default") .': '.$action_default.'. '. wfMsg("imstatus_possible_val") .': "add","chat","call","sendfile","userinfo","voicemail".</li></ul>';
		$output .= wfMsg("imstatus_details_saa", '<a href="http://www.skype.com/share/buttons/wizard.html">Skype button wizard</a>'). '<br/>';
		$output .= wfMsg("imstatus_skype_nbstyle") .'<br/>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;skype style="mediumicon" action="chat"&gt;PatheticCockroach&lt;/skype&gt;</span></div>';
	}
	else
	{
		$output = '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
	    $output .= '<a href="skype:'.$input.'?'.$action.'">'.$image.'</a>';
	}
	// sends output
    return $output;
}


/**********************************************
 * the function that reacts to "<xfire>"
 **********************************************/
function RenderXfire( $input, $argv )
{
	// set your defaults for the size, style and action (from biggest to smallest: 0 to 4) (bg, sh, co, sf, os, wow) (add, profile) - options crawled from http://www.xfire.com/miniprofile/
	$size_default = 3;
	$style_default = "bg";
	$action_default = "add";
	// the variables are: <xfire size="$argv['size']" style="$argv['style']" action="$argv['action']">$input</xfire>
	// to get help as a user, use <xfire help/>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
	if(isset($argv['size']))
	{
		$size = intval($argv['size']);
		if ($size<0 || $size>4) $size = $size_default;
	}
	else $size = $size_default;

	if(isset($argv['style']))
	{
		$style = $argv['style'];
		if (!in_array($style, array("bg","sh","co","sf","os","wow"))) $style = $style_default;
	}
	else $style = $style_default;

	if(isset($argv['action']))
	{
		$action = $argv['action'];
		if (!in_array($action, array("add","profile"))) $action = $action_default;
	}
	else $action = $action_default;

	// set alt text of the image
	switch($action)
	{
		case "profile":
				$alt_txt = "View my Xfire profile";
				$link_url = "http://profile.xfire.com/".$input;
		break;

		case "add":
		default:
				$alt_txt = "Add me to Xfire";
				$link_url = "xfire:add_friend?user=".$input;
		break;
	}

	// set size and style of the image
	switch($size)
	{
		case 0:
				$image = '<img src="http://miniprofile.xfire.com/bg/'.$style.'/type/0/'.$input.'.png" style="border: none;" width="440" height="111" alt="'.$alt_txt.'"/>';
		break;
		case 1:
				$image = '<img src="http://miniprofile.xfire.com/bg/'.$style.'/type/1/'.$input.'.png" style="border: none;" width="277" height="63" alt="'.$alt_txt.'"/>';
		break;
		case 2:
				$image = '<img src="http://miniprofile.xfire.com/bg/'.$style.'/type/2/'.$input.'.png" style="border: none;" width="450" height="34" alt="'.$alt_txt.'"/>';
		break;
		case 3:
				$image = '<img src="http://miniprofile.xfire.com/bg/'.$style.'/type/3/'.$input.'.png" style="border: none;" width="149" height="29" alt="'.$alt_txt.'"/>';
		break;

		case 4:
		default:
				$image = '<img src="http://miniprofile.xfire.com/bg/'.$style.'/type/4/'.$input.'.png" style="border: none;" width="16" height="16" alt="'.$alt_txt.'"/>';
		break;
	}

	// prepares outupt
    if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;xfire size="[size]" style="[style]" action="[action]"&gt;['. wfMsg("imstatus_your_name", "Xfire") .']&lt;/xfire&gt;</span>';
		$output .= '<ul><li>size: '. wfMsg("imstatus_xfire_size", "0", "4") .' '. wfMsg("imstatus_default") .': '.$size_default.'.</li>';
		$output .= '<li>style: '. wfMsg("imstatus_style") .'. '. wfMsg("imstatus_default") .': '.$style_default.'. '. wfMsg("imstatus_possible_val") .': "bg","sh","co","sf","os","wow".</li>';
		$output .= '<li>action: '. wfMsg("imstatus_action") .'. '. wfMsg("imstatus_default") .': '.$action_default.'. '. wfMsg("imstatus_possible_val") .': "add","profile".</li></ul>';
		$output .= wfMsg("imstatus_details_saa", '<a href="http://www.xfire.com/miniprofile/">Xfire - Miniprofile Instructions</a>') .'<br/>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;xfire size="3" style="bg" action="add"&gt;PatheticCockroach&lt;/xfire&gt;</span></div>';
	}
	else $output = '<a href="'.$link_url.'">'.$image.'</a>';
	// sends output
    return $output;
}


/**********************************************
* the function that reacts to "<yahoo>"
 ***********************************************/
function RenderYahoo( $input, $argv )
{
	// set your defaults for the action and style (addfriend, call or sendim) (0, 1, 2, 3 and 4) - options crawled from http://geocities.yahoo.com/v/ao/pre.html
	$style_default = 2;
	$action_default = "sendim";		// DO NOT enter an invalid value, since this value may be used as is in the final output -> TODO: use a switch to sanitize this one
	// the variables are: <yahoo style="$argv['style']" action="$argv['action']">$input</yahoo>

	// sanitize input
	$input = htmlspecialchars($input,ENT_QUOTES);
	// get custom parameters
	if(isset($argv['style']))
	{
		$style = intval($argv['style']);
		if($style<0 || $style>5) $style = $style_default;
	}
	else $style = $style_default;

	if(isset($argv['action']))
	{
		$action = $argv['action'];
		if(!in_array($action, array("addfriend","call","sendim"))) $action = $action_default;
	}
	else $action = $action_default;

	// set alt text of the image
	switch($action)
	{
		case "addfriend":
				$alt_txt = "Add me";
		break;
		case "call":
				$alt_txt = "Call me";
		break;

		case "sendim":
		default:
				$alt_txt = "Send me an IM";
		break;
	}
	// set image style
	switch( $style )
	{
		case 0:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=0" style="border: none; width: 12px; height: 12px;" alt="'.$alt_txt.'" />';
		break;

		case 1:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=1" style="border: none; width: 64px; height: 16px;" alt="'.$alt_txt.'" />';
		break;

		case 2:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=2" style="border: none; width: 125px; height: 25px;" alt="'.$alt_txt.'" />';
		break;

		case 3:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=3" style="border: none; width: 86px; height: 16px;" alt="'.$alt_txt.'" />';
		break;

		case 4:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=4" style="border: none; width: 12px; height: 12px;" alt="'.$alt_txt.'" />';
		break;

		case 5:
		default:
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=5" style="border: none; width: 12px; height: 12px;" alt="'.$alt_txt.'" />';
		break;
	}

	// prepares outupt
    if(isset($argv['help']))
	{
		wfLoadExtensionMessages('IMStatus');

		$output = '<div><span style="color:blue;">'. wfMsg("imstatus_syntax") .': &lt;yahoo style="[style]" action="[action]"&gt;['. wfMsg("imstatus_your_name", "Yahoo") .']&lt;/xfire&gt;</span>';
		$output .= '<ul><li>style: '. wfMsg("imstatus_yahoo_style", "0", "2", "3", "4") .' '. wfMsg("imstatus_default") .': '.$style_default.'.</li>';
		$output .= '<li>action: '. wfMsg("imstatus_action") .'. '. wfMsg("imstatus_default") .': '.$action_default.'. '. wfMsg("imstatus_possible_val") .': "addfriend","call","sendim".</li></ul>';
		$output .= wfMsg("imstatus_details_saa", '<a href="http://geocities.yahoo.com/v/ao/pre.html">Yahoo! Presence</a>') .'<br/>';
		$output .= '<span style="color:green;">'. wfMsg("imstatus_example") .': &lt;yahoo style="2" action="sendim"&gt;PatheticCockroach&lt;/yahoo&gt;</span></div>';
	}
	else $output = '<a href="ymsgr:'.$action.'?'.$input.'">'.$image.'</a>';
	// sends output
	return $output;
}
