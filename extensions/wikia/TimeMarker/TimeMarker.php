<?php
/**
 * @package MediaWiki
 * @subpackage TimeMarker
 * @author Andrew Yasinsky <andrewy@wikia.com> for Wikia.com
 * @version: $Id$
 * This Extension will include Jiffy code and log performance data on front end
 * 
 * jiffy documentation http://code.google.com/p/jiffy-web/
 * 1. install this extension
 * 2. add outpout of echo skin->timemarker in your template
 * 3. edit TIMEMARKER_SAMPLERATE default 5 will process every 5th request
 * 4. Install Apache Proxy script
 * 		#  Copyright 2008 Whitepages.com, Inc. See License.txt for more information.
 *
 *		###########################################################
 *		# Jiffy additions for httpd.conf
 *		###########################################################
 *		# ENV
 *		SetEnvIf Request_URI "^/rx" JIFFY
 *
 *		# Logging
 *		LogFormat "%h %t \"%q\" %>s \"%{Referer}i\" \"%{User-Agent}i\" \"%{Host}i\"" jiffylog
 *		CustomLog logs/jiffy.log jiffylog env=JIFFY
 *		# Rewrites
 *		# This should point to a zero byte file in your DocRoot.
 * 		RewriteRule ^/rx /static/rx.txt [L,PT]
 * 		###########################################################
 * 
 * 5. basic request, logs DOMReady, Window on load and Load,
 * 6. enchanced request displays adn logs time marks to additiona element _ds by adding ?timemarker=comma,delimited,list,of,elmenet,ids
 * 7. data is logged but also can be viewd in Firefox jiffy extension
 */

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'TimeMarker',
        'author' => 'Andrew Yasinsky',
        'description' => 'This Extension will include Jiffy code and log performance data on front end',
        'version'=>'0.1'
);

DEFINE( 'TIMEMARKER_SAMPLERATE', 1000 ); //samplerate to use 1= every one request to process 
 
$wgHooks['BeforePageDisplay'][] = 'tm_html';

function tm_html( &$out ){	
	global $wgStyleVersion, $wgUser;
	if( !empty( $_REQUEST['timemarker'] ) ){
		$params = explode( ',', $_REQUEST['timemarker'] );
		$r = TimeMarker::tm_extended( &$out, $params );
	}else{
		$samplerate = TIMEMARKER_SAMPLERATE; //this is sample rate var
		$r = TimeMarker::tm_basic( &$out, $samplerate );
	}
   
    //get the skin
	$skin = &$wgUser->getSkin();
	//skin has script holder populate it
	$skin->timemarker = $r;	
    
	return true;
}

class TimeMarker {
    
	function tm_basic( &$out, $samplerate ){	
	 //this is basic timemarker
	   	global $wgStylePath, $wgStyleVersion, $wgUser, $wgExtensionsPath;
		
	//+++++++build the TimeMarkers script for this skin++++//
$txtjs= "" . 
<<<EOT

	<script type="text/javascript">
	/*<![CDATA[*/
	 
	t = (new Date()).getTime();		
			
	if( Math.floor(t/{$samplerate}) == Math.ceil(t/{$samplerate}) ){
	 JiffyOptions = {
						USE_JIFFY: true,
						ISBULKLOAD: false,
						BROWSER_EVENTS: {"load":window,"DOMReady":window},
						SOFT_ERRORS: true
					};
	}
				  
	/*]]>*/
	</script>
EOT;
	//++++++++++++++++++++++++++++++++++++++++++++++++++++//
	
$txtjs = $txtjs . "<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/TimeMarker/js/jiffy.js\"></script>";
	
$txtjs= $txtjs .  
<<<EOT

	<script type="text/javascript">
	/*<![CDATA[*/
	 
  if(window.JiffyOptions != undefined){Jiffy.mark('body');}		
				  
	/*]]>*/
	</script>
EOT;
	//++++++++++++++++++++++++++++++++++++++++++++++++++++//

	return $txtjs;
	}
	 
function tm_extended( &$out, $params ){	
	  	global $wgStylePath, $wgStyleVersion, $wgUser, $wgExtensionsPath;
		//this is markers start, for each element we are tracking we set marker from time 0
		//in reality we need mark before element starts loading
		$mark_start = '';	
		//this is markers end, for each element we are tracking when element and it child become available
		$mark_finish = '';
		
		//generate marker snippet
		foreach( $params as $key => $value ){
		    $mark_start .= 'Jiffy.mark("' . $value . '")' . "\n";
			$mark_finish .= '		e.onContentReady("' . $value . '",this.ocrHandler, "' . $value . '" );' . "\n";
		}
		
	//+++++++build the TimeMarkers script for this skin++++//

$txtjs=  
<<<EOT

	<script type="text/javascript">
	/*<![CDATA[*/
	 
	 JiffyOptions = {
						USE_JIFFY: true,
						ISBULKLOAD: false,
						BROWSER_EVENTS: {"load":window,"DOMReady":window},
						SOFT_ERRORS: true
					};
		
	/*]]>*/
	</script>
EOT;
	//++++++++++++++++++++++++++++++++++++++++++++++++++++//
	
$txtjs = $txtjs . "<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/TimeMarker/js/jiffy.js\"></script>";
$txtjs= $txtjs .  
<<<EOT
	<script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/yahoo-dom-event/yahoo-dom-event.js"></script>
	<script type="text/javascript">
	/*<![CDATA[*/
	 
	{$mark_start}
	
	tm = function() {
		var e = YAHOO.util.Event;
	
		return {
			init: function() {
	{$mark_finish}
			},
			
			ocrHandler: function(message) {
				Jiffy.measure( message + '_done', message );
			},
		}
	
	}();
	
	//initialize the TimeMarker
	tm.init();
	
	/*]]>*/
	</script>
EOT;
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++//
	
		//skin has script holder populate it
		return $txtjs;
	}
	
}
