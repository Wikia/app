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

require_once 'lw_cache.php';
require_once 'extras.php';

class SendToAFriend extends SpecialPage
{
	function __construct()
	{
		parent::__construct("SendToAFriend");
	}

	function validateEmailAddress( $addr )
	{
		return ( 0 != preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+[a-zA-Z]{2,6}$/", $addr ) );
	}

	function getMessageBody( $request )
	{
		global $wgPlainTextEmails;

		// get the message template
		$body = wfMsg( "staf-body" );
		#$body = wfMsg( "staf-body", $this->getPageName($request), trim($request->getText("msg")) );
		$pagename = $this->getPageName($request);
		$body = str_replace(
			Array("$1","$2"),
			Array( "[{{fullurl:".$pagename."}} ".str_replace("_", " ", urldecode($pagename))."]", trim($request->getText("msg")) ),
			$body );

		// expand wikitext
		$body = sandboxParse($body);

		// remove paragraph tags
		$body = str_replace(Array("<p>","</p>"),Array("","\n"),$body);

		// fix line endings
		$body = str_replace(Array("<br>","<br/>","<br />"),"\n",$body);
		$body = str_replace("\r\n", "\n", $body); // set all versions to \n to avoid making double-breaks (would end up as \r\r\n if we didn't do this).
		$body = preg_replace("/\n\n+/","\n\n",$body);

		// replace headings with == for plain text Emails
		if( $wgPlainTextEmails )
		{
			$body = preg_replace("/<h[0-9].*?>/","==",$body);
			$body = preg_replace("/<\/h[0-9].*?>/"," ==",$body);

			// Remove the anchor tag for the heading
			$body = preg_replace("/<a name=['\"].*?['\"]><\/a>/", "", $body);

			// Remove the extra sections from the link and change to single-quotes (these might cause gmail to expand the tag instead of making it a link... unsure how their algorithm works).
			$body = preg_replace("/<a href=\"([^\"]*)\" [^>]*>/", "<a href='$1'>", $body);
		};

		// PAGE wasn't getting replalced on it's own (there's probably another way to fix this).
		$body = str_replace("/PAGE\"", "/".$this->getPageName($request)."\"",$body);
		$body = str_replace("/PAGE'", "/".$this->getPageName($request)."'",$body);
		$body = str_replace("/PAGE<", "/".$this->getPageName($request)."<", $body);
		$body = str_replace("%3A", ":", $body); // make colons visible

		// Tidy up spacing
		$body = trim(preg_replace("/  +/"," ",$body));

		// for debugging
		// $body = str_replace(Array("<",">"),Array("&lt;","&gt;"),$body);
		//*/

		return $body;
	}

	function sendEmail( $to, $from, $subject, $body )
	{
		global $wgNoMailFunc;
		$wgNoMailFunc = true;
		// these fields should not contain any of these characters
		$to = str_replace(Array("\n","\r","\t")," ",$to);
		$from = str_replace(Array("\n","\r","\t")," ",$from);
		$subject = str_replace(Array("\n","\r","\t")," ",$subject);

		// Normalize line-endings.
		$body = str_replace("\r\n", "\n", $body); // set all versions to \n to avoid making double-breaks (would end up as \r\r\n if we didn't do this).
		$body = str_replace("\n", "<br/>\r\n", $body);

		if($wgNoMailFunc === false)
		{
			$mailheaders = "From: $fromName <$from>\r\n";
			$mailheaders .= "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
			if(mail($to, $subject, $body, $mailheaders))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$path_to_sendmail = "/usr/sbin/sendmail";
			$fp = popen("$path_to_sendmail -t", "w");
			$num = fwrite($fp, "To: $to\n");
			$num += fwrite($fp, "From: $from\n");
			//$num += fwrite($fp, "MIME-Version: 1.0\n");
			$num += fwrite($fp, "Content-type: text/html; charset=iso-8859-1\n");
			$num += fwrite($fp, "Subject: $subject\n\n");
			$num += fwrite($fp, "$body");
			$exitValue = pclose($fp);
			if(($num > 0) && ($exitValue==0))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function previewPage( $request, $wgOut )
	{
		// make sure there is a page specified
		if( $this->getPageName($request) == "" )
		{
			$wgOut->addHTML("<div style='background-color:#ff8080'>".wfMsg("staf-nopage")."</div>");
			$this->showForm( $request, $wgOut );
			return;
		};

		$body = $this->getMessageBody( $request );
		$wgOut->addHTML("<pre>".$body."</pre>");
		$this->showForm($request,$wgOut);
	}

	function sendPage( $request, $wgOut )
	{
		$SERVER_NAME = $_SERVER['SERVER_NAME']; // for compatibility with servers with register-globals off.

		// make sure there is a page specified
		if( $this->getPageName($request) == "" )
		{
			$wgOut->addHTML("<div style='background-color:#ff8080'>".wfMsg("staf-nopage")."</div>");
			$this->showForm( $request, $wgOut );
			return;
		};

		// validate target email address
		$addr = $request->getText("addr");
		if( $addr == "" or !$this->validateEmailAddress($addr) )
		{
			$wgOut->addHTML("<span style='background-color:#ff8080'>".wfMsg("staf-invalidfriendemail")."</span><br/>");
			$this->showForm( $request, $wgOut );
			return;
		};
		$myAddr = $request->getText("myAddr");

		// validate sender address
		$from = "grapevine@$SERVER_NAME";
		$myAddr = $request->getText("myAddr");
		if( $this->validateEmailAddress($myAddr) )
		{
			$from = $myAddr;
		};

		// prevent exploiting headers to send spam
		$subject = $request->getText("subj");
		$subject = ( ( $subject == "" ) ? wfMsg("staf-defaultsubject") : $subject );
		$subject = str_replace( "@", " at ", $subject );

		// make the email body
		$body = $this->getMessageBody( $request );

		if($this->isSpam($body) || (0 < preg_match("/http:/si", $request->getText("msg")))){
			//logEvent("Potential spam from IP ".$_SERVER['REMOTE_ADDR'].": \"$msg\"");
			$wgOut->addHTML("<div 	style='background-color:#ff8080'>".wfMsg("staf-spamnotice")."</div><br/>");
			$this->showForm( $request, $wgOut );
		} else {
			if( $this->sendEmail( $addr, $from, $subject, $body ) )
			{
				// log usage data
				$cache = new DurableCache();
				$key = $request->getText("jsForm") ? "SEND_LYRICS_JS" : "SEND_LYRICS_NON_JS";
				$res = $cache->fetch($key);
				$res = ( !$res or $res == "") ? 1 : intval($res) + 1;
				$cache->store($key, $res );

				$pagename = $this->getPageName($request);
				$body = wfMsg("staf-emailsent", "[[".str_replace("_", " ", $pagename)."]]");
				$wgOut->addHTML(sandboxParse($body)); // sandboxParse will convert the wiki-format link above into html
				return;
			}
			else
			{
				$wgOut->addHTML("<span style='background-color:#ff8080'>".wfMsg("staf-emailfail")."</span><br/>");
				$this->showForm( $request, $wgOut );
			}
		}
	}

	function getPageName( $request )
	{
		# extract th
		$page	= $request->getRequestURL( 'dir' );
		$page	= preg_replace("/^.*Special:.*\//",'',$page);
		if( strpos($page,"Special:SendToAFriend") !== FALSE )
		{
			return "";
		}
		$page = trim(str_replace(" ","_",$page));
		$page = trim(str_replace("%20","_",$page));
		return $page;
	}

	function showForm( $request, $wgOut )
	{
		$page	= $this->getPageName($request);
		$addr	= $request->getText("addr");
		$myAddr	= $request->getText("myAddr");
		$subj 	= $request->getText("subj");
		$msg	= $request->getText("msg");

		$wgOut->addHTML("<small>We will not spam you (or your friend), or sell/give-away your email addresses.  <strong>We do not record these email addresses.</strong></small><br/>");
		$wgOut->addHTML("<form method='post' action='' />");
			$wgOut->addHTML("<input type='hidden' name='formName' value='emailLyrics'/>");
			$wgOut->addHTML("<input type='hidden' name='jsForm' value='false'/>");

			$wgOut->addHTML("<table>");
				$wgOut->addHTML("<tr>");
					$wgOut->addHTML("<td>".wfMsg("staf-friendemail").": </td>");
					$wgOut->addHTML("<td><input type='text' name='addr' value='".htmlentities($addr, ENT_QUOTES)."'/></td>");
				$wgOut->addHTML("</tr>");
				$wgOut->addHTML("<tr>");
					$wgOut->addHTML("<td>".wfMsg("staf-youremail").": </td>");
					$wgOut->addHTML("<td>");
						$wgOut->addHTML("<input type='text' name='myAddr' value='".htmlentities($myAddr, ENT_QUOTES)."'/><br/>");
						$wgOut->addHTML("<small>(for the \"From\" field in the email so that they know it's from you).</small>");
					$wgOut->addHTML("</td>");
				$wgOut->addHTML("</tr>");
				$wgOut->addHTML("<tr>");
					$wgOut->addHTML("<td>".wfMsg("staf-subject").": </td>");
					$wgOut->addHTML("<td>");
						$wgOut->addHTML("<input type='text' name='subj' value='".htmlentities($subj, ENT_QUOTES)."'/>");
					$wgOut->addHTML("</td>");
				$wgOut->addHTML("</tr>");
				$wgOut->addHTML("<tr>");
					$wgOut->addHTML("<td>".wfMsg("staf-message").":</td>");
					$wgOut->addHTML("<td><textarea name='msg'>$msg</textarea></td>");
				$wgOut->addHTML("</tr>");
				$wgOut->addHTML("<tr>");
					$wgOut->addHTML("<td> </td>");
					$wgOut->addHTML("<td>");
						$wgOut->addHTML("<input id='wpSend' name='wpSend' type='submit' value='".wfMsg("staf-emailsend")."' accesskey='".wfMsg("staf-accesskey-send")."' title='".wfMsg("staf-emailpage")." [".wfMsg("staf-accesskey-send")."]' />");
						$wgOut->addHTML("<input id='wpPreview' name='wpPreview' type='submit' value='".wfMsg("staf-preview")."' accesskey='".wfMsg("staf-accesskey-preview")."' title='".wfMsg("staf-preview")." [".wfMsg("staf-accesskey-preview")."]' />");
					$wgOut->addHTML("</td>");
				$wgOut->addHTML("</tr>");
			$wgOut->addHTML("</table>");
		$wgOut->addHTML("</form>");
	}

	function execute( $par )
	{
		global $wgRequest, $wgOut;

		$this->setHeaders();
		if( $wgRequest->getVal("wpPreview") )
		{
			$this->previewPage( $wgRequest, $wgOut );
		}
		else if( $wgRequest->getVal("wpSend") )
		{
			$this->sendPage( $wgRequest, $wgOut );
		}
		else
		{
			$this->showForm( $wgRequest, $wgOut );
		}
	}

	////
	// Returns true if the message is likely to be spam.
	////
	function isSpam($msg){
		$retVal = false;
		if(0 < preg_match("/buy	[a-z]* drug/si", $msg)){
			$retVal = true;
		} else if((0 < preg_match("/\nTo: [^\n]*@[^\n]*@/si", $msg)) ||
				(0 < preg_match("/bcc: [^\n]*@[a-z0-9_-]*\.[a-z0-9_-]{2,3}/si", $msg))){
			$retVal = true;
		} else if((0 < preg_match("/(nexium|cialis|viagra|lipitor|laptop batteries|hydrocodone|slot machines|doctorad|phentermine|\bbad credit\b|tramadol|carisoprodol|\bsoma\b|ambien|v iagra|xanax|celebrex|valium|medications|ringtones|activam|lorazepam|lowest medication costs|phone cards|all of your medications|\bmeds\b|Subject: RE: your health|Subject: Low prices |Subject: Important|Subject: still there|Subject: you still there|Subject: you there|best prescript prices|Subject: are you there|Subject: are you around|pay.per.click)/si", $msg))
			||  (0 < preg_match("/(Human[ \.\s\n]*growth[ \.\s\n]*hormo|\sHGH\s|H[^a-z0-9]G[^a-z0-9]H|G r o w t h)/si", $msg))
			||  ((0 < preg_match("/(drug|prescrip|precrip|medicine)/si", $msg)) && (0 < preg_match("/discreet/si", $msg))) # discreet shipping/packaging of various drugs
			||  (0 < preg_match("/Subject: [^\n]*\n--[0-9a-z\.]*\/pedlfaster.pedlr.com--/si", $msg)) # subjects with no messages
			||  (0 < preg_match("/\b(t|that6036)@lyricwiki.org/si", $msg)) # not even a real address
		){
			$retVal = true;
		} else if(0 < preg_match("/To: [a-zA-Z]+[0-9]+@lyricwiki.org/i", $msg)){
			$retVal = true;
		} else if(0 < preg_match("/To:\s*([^\n]*@lyricwiki.org)/si", $msg)){ # there must be special unicode in here since normal regex didn't catch them all
			$retVal = true;
		} else if(0 < preg_match("/\[URL=http/si", $msg)){
			$retVal = true;
		}
		return $retVal;
	} // end isSpam()

}
