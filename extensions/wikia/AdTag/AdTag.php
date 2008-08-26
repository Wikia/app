<?php

$wgExtensionFunctions[] = 'wfAdTagSetup';

function wfAdTagSetup() {
	global $wgHooks, $wgParser, $wgAdMarkerList;
	$wgAdMarkerList = array();
	$wgParser->setHook( 'ad', 'wfAdParserHook' );
	$wgHooks['ParserAfterTidy'][] = 'wfAdsAfterTidy';
}


function wfAdParserHook( $contents, $attributes, &$parser ) {
	global $wgAdMarkerList, $wgTitle;

	$ret = AdServer::getInstance()->getAd('c_tag');
	if(empty($ret)) {
		//fallback to the hardcoded ad
		$ret = <<<EOD
<script type='text/javascript'><!--//<![CDATA[
 var m3_u = (location.protocol=='https:'?'https://wikia-ads.wikia.com/www/delivery/ajs.php':'http://wikia-ads.wikia.com/www/delivery/ajs.php');
 var m3_r = Math.floor(Math.random()*99999999999);
 if (!document.MAX_used) document.MAX_used = ',';
 document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
 document.write ("?zoneid=485");
 document.write ('&amp;cb=' + m3_r);
 if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
 document.write ("&amp;loc=" + escape(window.location));
 if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
 if (document.context) document.write ("&context=" + escape(document.context));
 if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
 document.write ("'><\/scr"+"ipt>");
//]]>--></script>
EOD;
	}
	$marker = "xx-marker".count($wgAdMarkerList)."-xx";
	$wgAdMarkerList[] = $ret;
	return $marker;
}

function wfAdsAfterTidy( &$parser, &$text ) {
	// find markers in $text
	// replace markers with actual output
	global $wgAdMarkerList;
	for ($i = 0; $i < count( $wgAdMarkerList ); $i++) {
		$text = preg_replace( '/xx-marker' . $i . '-xx/', $wgAdMarkerList[$i], $text );
	}
	return true;
}
