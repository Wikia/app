<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();
class WikiTweetFunctions {
	public static function sendWithPear($mailer, $dest, $headers, $body)
	{
		$mailResult = $mailer->send($dest, $headers, $body);
		if( PEAR::isError( $mailResult ) ) {
			return $mailResult->getMessage();
		} else {
			return true;
		}
	}
	public static function send( $to, $from, $subject, $body, $replyto=null )
	{
		//if(!$wgWikiTweet['email']){return false;}
		$wgOutputEncoding = 'UTF-8';
		$wgEnotifImpersonal = false;
		$wgErrorString = '';
		$wgEnotifMaxRecips = 500;
		include('WikiTweet.config.php');
		if (is_array( $wgWikiTweet )) {
			require_once( 'Mail.php' );
			$msgid = str_replace(" ", "_", microtime());
			if (function_exists('posix_getpid'))
				$msgid .= '.' . posix_getpid();
			if (is_array($to)) {
				$dest = array();
				foreach ($to as $u)
					$dest[] = $u;
			} else
				$dest = $to;
			$headers['From'] = $from;
			if ($wgEnotifImpersonal)
				$headers['To'] = 'undisclosed-recipients:;';
			else
				$headers['To'] = $to;
			if ( $replyto ) {
				$headers['Reply-To'] = $replyto->toString();
			}
			$headers['Subject'] = $subject;
			$headers['Date'] = date( 'r' );
			$headers['MIME-Version'] = '1.0';
			$headers['Content-type'] = 'text/plain; charset='.$wgOutputEncoding;
			$headers['Content-transfer-encoding'] = '8bit';
			$headers['Message-ID'] = "<$msgid@" . $wgWikiTweet['SMTP']['IDHost'] . '>'; // FIXME
			$headers['X-Mailer'] = 'MediaWiki mailer';
			// Create the mail object using the Mail::factory method
			$mail_object =& Mail::factory('smtp', $wgWikiTweet['SMTP']);
			if( PEAR::isError( $mail_object ) ) {
				wfDebug( "PEAR::Mail factory failed: " . $mail_object->getMessage() . "\n" );
				return new WikiError( $mail_object->getMessage() );
			}
			$chunks = array_chunk( (array)$dest, $wgEnotifMaxRecips );
			foreach ($chunks as $chunk) {
				$e = WikiTweetFunctions::sendWithPear($mail_object, $chunk, $headers, $body);
				if( $e != true)
					return $e;
			}
		} 
	}
	
	public static function str_global_replace( $i__string, $i__array )
	{
		$o__string = $i__string ;
		foreach($i__array as $l__key => $l__item)
		{
			$o__string = str_replace($l__key, $l__value, $o__string );
		}
		return $o__string;
	}
	public static function Convert_Date ( $i__old_date )
	{
		// function to convert a date in a countdown
		$l__nber_seconds = 0 ;
		$l__nber_minutes = 0 ;
		$l__nber_hours   = 0 ;
		$l__diff_date    = 0 ;
		
		
		$l__diff_date = time() - $i__old_date ;
		if ( $l__diff_date < 0 )
		{
			// theorically impossible
			$result = wfMsg ( 'wikitweet-inthefuture' ) ;
		}
		elseif ( $l__diff_date < 10 )
		{
			// less than 10 seconds is "few"
			$result = wfMsg ( 'wikitweet-fewsecondsago' ) ;
		}
		else
		{
			$languageobject = new Language();
			$date_to_display = $languageobject->formatTimePeriod(time()-strtotime($dateSrc));
			$result = wfMsgExt( 'wikitweet-timeago', 'parse', $date_to_display );
		}
	return $result ;
	}
	
	public static function getParentsRoomsString($i__room,$i__array)
	{
		$o__string = '>> ';
		foreach(WikiTweetFunctions::_getParentsRoom($i__room,$i__array) as $l__room)
		{
			$o__string .= $l__room . '--';
		}
		return $o__string;
	}
	public static function _getParentsRoom($i__room,$i__array)
	{
		$o__room_parents = array();
		foreach($i__array as $l__room_key=>$l__room_childs)
		{
			foreach($l__room_childs as $l__room_child)
			{
				if($l__room_child == $i__room)
				{
					$o__room_parents[] = $l__room_key;
					$o__room_parents = array_merge($o__room_parents,WikiTweetFunctions::_getParentsRoom($l__room_key,$i__array));
					break;
				}
			}
		}
		return $o__room_parents;
	}
}
