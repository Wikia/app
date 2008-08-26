<?php
/*
 * Author : Egon (egon@wikia.com)
 *
 * Copyright Wikia Inc. 2007
 *
 * Adding BrowserDetect object to JavaScript Varaibles of MediaWiki.
 * 
 * Usage:
 * BrowserDetect.browser = name of browser.
 * BrowserDetect.version = number of browser version
 * BrowserDetect.OS = name of operating system, Can be:
 ** "Windows"
 ** "Mac"
 ** "Linux"
 * 
 * TODO: change as much as it can be from 'UserAgent string search' to 'object detection'.
 */

if (!defined('MEDIAWIKI'))
	exit;

$wgExtensionFunctions [] = 'wfBrowserDetect';

function wfBrowserDetect(){
	global $wgOut;
	$text .= 'var BrowserDetect = {
	init: function () {
		
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				/*alert("dataString="+dataString+"subString="+data[i].subString+"result="+dataString.indexOf(data[i].subString));*/
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		/* for newer Netscapes (6+) */
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		/* for older Netscapes (4-) */
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();';

$text = str_replace("\n", '', $text);
$text = str_replace("\t", '', $text);
$text = preg_replace('!/\*.*?\*/!i', '', $text);

$text = '<script type="text/javascript">'.$text."</script>\n";

	$wgOut->addScript($text);
}
?>
