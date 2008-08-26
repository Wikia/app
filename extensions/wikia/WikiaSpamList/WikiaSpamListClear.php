<?php

/**
 * Parse title-black-list regex
 * use 
 * 	- $wgBlackTitleListFiles - to define files with addresses
 * 	- $wgBlackListCacheTime - to define memcache expiry time 
 *
 * @author Piotr Molski <moli@wikia.com>
 */


if ( defined( 'MEDIAWIKI' ) ) {

	global $wgFilterCallback, $wgPrevListFilterCallback;
	#--- config file for black-list of titles
	global $wgBlackTitleListFiles;
	#--- config file for white-list of links
	global $wgWhitelistFiles;
	#--- config file for white-list of images
	global $wgExtImagesWhitelistFiles;
	
	#----
	if ( $wgFilterCallback ) {
		$wgPrevListFilterCallback = $wgFilterCallback;
	} else {
		$wgPrevListFilterCallback = false;
	}

	#---
	$wgFilterCallback = 'wfSpamConfigFileCheckCallback';

	function wfSpamConfigFileCheckCallback( &$title, $text, $section ) 
	{
		global $IP, $wgDBname, $messageMemc, $wgMemc;
		global $wgPrevListFilterCallback;

		$fname = 'clearWhiteListMemCache';
		wfProfileIn( $fname );
		#---
		#--- config file for black-list of titles
		global $wgBlackTitleListFiles;
		#--- config file for white-list of links
		global $wgWhitelistFiles;
		#--- config file for white-list of images
		global $wgExtImagesWhitelistFiles;
		
		if (!function_exists('clearListMemCache'))
		{
			function clearListMemCache($title, $settings)
			{
				global $messageMemc, $wgMemc, $wgDBname;
				
				$files = $settings['files'];
				foreach ( $files as $fileName ) 
				{
					$fullUrl = $title->getFullURL('action=raw');
					wfDebug( "Checking filename " . $fileName . " and compare with " . $fullUrl . "\n" );
					if (strpos($fullUrl,$fileName) !== false)
					{
						wfDebug( "Match! \n" );
						$wgMemc->delete($settings['memcache_regexes']);
						wfDebug( "Clear cache - " . $settings['memcache_regexes'] . "\n" );
						$key = $settings['memcache_file'].":".$fileName;
						$warningKey = "$wgDBname:spamfilewarning:$fileName";
						wfDebug( "Clear cache - " . $key . "\n" );
						$httpText = $messageMemc->delete( $key );
						wfDebug( "Clear cache - " . $warningKey . "\n" );
						$warning = $messageMemc->delete( $warningKey );
					}
				}
			}
		}

		if ( $wgPrevListFilterCallback )
		{
			if (function_exists($wgPrevListFilterCallback))
			{
				if ( $wgPrevListFilterCallback( $title, $text, $section ) ) 
				{
					wfProfileOut( $fname );
					return true;
				}				
			}
		}

		#--- check external image whitelist
		if (file_exists("{$IP}/extensions/wikia/WikiaWhiteList/WikiaExternalImageList.php"))
		{
			require_once ("{$IP}/extensions/wikia/WikiaWhiteList/WikiaExternalImageList.php");
			#---
			$files = (is_array($wgExtImagesWhitelistFiles)) ? $wgExtImagesWhitelistFiles : ((!empty($wgExtImagesWhitelistFiles)) ? array($wgExtImagesWhitelistFiles) : null);
			$imagelist = new WikiaExtImagesWhitelist(array("files" => $files));
			if ($imagelist) 
			{
				$imageListSettings = $imagelist->getSettings();
				if (!empty($imageListSettings))
				{
					clearListMemCache($title, $imageListSettings);
				}
			}
		}
		
		#--- check external link whitelist
		if (file_exists("{$IP}/extensions/wikia/WikiaWhiteList/WikiaWhiteList.php"))
		{
			require_once ("{$IP}/extensions/wikia/WikiaWhiteList/WikiaWhiteList.php");
			#---
			$files = (is_array($wgWhitelistFiles)) ? $wgWhitelistFiles : ((!empty($wgWhitelistFiles)) ? array($wgWhitelistFiles) : null);
			error_log("new WikiaWhitelist -> $wgDBname !!!!!!!!");
			$linklist = new WikiaWhitelist(array("files" => $files));
			if ($linklist) 
			{
				$linkListSettings = $linklist->getSettings();
				if (!empty($linkListSettings))
				{
					clearListMemCache($title, $linkListSettings);
				}
			}
		}

		#--- check title blacklist
		if (file_exists("{$IP}/extensions/wikia/WikiaTitleBlackList/WikiaTitleBlackList_body.php"))
		{
			require_once ("{$IP}/extensions/wikia/WikiaTitleBlackList/WikiaTitleBlackList_body.php");
			#---
			$files = (is_array($wgBlackTitleListFiles)) ? $wgBlackTitleListFiles : ((!empty($wgBlackTitleListFiles)) ? array($wgBlackTitleListFiles) : null);
			$titleBlackList = new WikiaTitleBlackList(array("files" => $files));
			if ($titleBlackList) 
			{
				$titleListSettings = $titleBlackList->getSettings();
				if (!empty($titleListSettings))
				{
					clearListMemCache($title, $titleListSettings);
				}
			}
		}
		
		#---
		wfProfileOut( $fname );
		return false;	
	}

} # End invocation guard
?>
