<?php
/*
 * simple stats output and gather for oggPlay and a "sample page" 
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
        exit( 1 );
}
$psScriptPath = $wgScriptPath . '/extensions/PlayerStatsGrabber';

/*
 * config values
 */

// $psLogEveryPlayRequestPerUser 
// true we log every play request 
// false we only log play request from different users
$psLogEveryPlayRequestPerUser = true;

// allow users to submit the suvey more than once
$psAllowMultipleSurveysPerUser = true;


//a central DB for the ogg Hanndler:
$wgPlayerStatsDB='';
//$psCentralDB = wfGetDB( DB_MASTER, array(), $wgPlayerStatsDB );

// embed code and "weight" (ie weight of 3 is 3x more likely than weight of 1)  
// flash embed code (the raw html that gets outputted to the browsers))
// embed key gets recorded to the database to identify what player was sent to the client in the survey 
// (you need to add it as an ENUM option) 
$flowFLVurl = $psScriptPath .'sample_media/sample_barney.flv';
$flowEmbedCode = <<<EOT
<script type="text/javascript" src="{$psScriptPath}/flow_player/flashembed.min.js"></script>
<script type="text/javascript">
	flashembed("example", 
		{
			src:'{$psScriptPath}/flow_player/FlowPlayerDark.swf',
			width: 400, 
			height: 320,
			id:'myflash_id',
		},
		{
		config: {   
			autoPlay: false,
			id: 'myflash_id',
			autoBuffering: true,
			controlBarBackgroundColor:'0x2e8860',
			initialScale: 'scale',
			videoFile: '{$flowFLVurl}'
		}} 
	);
</script>

<div id="example"></div>


EOT;
$psEmbedAry = array(
	array( 'embed_key' => 'youtube',
		   'name' => 'Sample Youtube Embed',
		   'weight' => 1,
		   'url'	=> 'http://www.youtube.com/v/Ga1kC6oGT9A',
		   'html_code' => '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/Ga1kC6oGT9A&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/Ga1kC6oGT9A&hl=en&fs=1" type="application/x-shockwave-flash" allowfullscreen="true" width="425" height="344"></embed></object>'
	),
	array( 'embed_key' => 'oggHandler',
	  	   'name' => 'Sample oggPlay Embed',
		   'weight' => 1,
		   'wiki_code'	=> '[[Image:Sample_barney.ogg]]'
	),
	array( 'embed_key' => 'flowplayer',
		  'name' => 'Sample oggPlay Embed',
		  'weight' => 1,
		  'url'	=> $flowFLVurl,
		  'html_code' => $flowEmbedCode
	)
);



/*
 * end config
 */
$wgExtensionMessagesFiles['PlayerStatsGrabber'] 	= dirname( __FILE__ ) . '/PlayerStatsGrabber.i18n.php';
$wgAutoloadClasses['SpecialPlayerStatsGrabber'] 	= dirname( __FILE__ ) . '/PlayerStatsGrabber_body.php';
$wgSpecialPages['PlayerStatsGrabber']		   				=  array( 'SpecialPlayerStatsGrabber' );
											 
$wgSpecialPageGroups['PlayerStatsGrabber'] = 'wiki'; // like Special:Statistics

// add ajax hook to accept the status input: 
$wgAjaxExportList[] = 'mw_push_player_stats';

$wgExtensionCredits['media'][] = array(
	'name'           => 'PlayerStats',
	'author'         => 'Michael Dale',
	'svn-date' 		 => '$LastChangedDate: 2008-08-06 07:18:43 -0700 (Wed, 06 Aug 2008) $',
	'svn-revision' 	 => '$LastChangedRevision: 38715 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:PlayerStats',
	'description'    => 'PlayerStats and survey for monitoring theora support relative to flash'
);


/*
 * does a player stats request.. returns the "db key"
 *  (lets people fill out survey after playing clip) 
 *  or 
 *  (ties survey page data to detection) 
 */
function mw_push_player_stats() {
	return SpecialPlayerStatsGrabber::do_submit_player_log();
}

/*
 * @@todo should use API json output wrappers
 */
if ( ! function_exists( 'php2jsObj' ) ) {
	function php2jsObj( $array, $objName = 'mv_result' )
	{
	   return  $objName . ' = ' . phpArrayToJsObject_Recurse( $array ) . ";\n";
	}
}
if ( ! function_exists( 'PhpArrayToJsObject_Recurse' ) ) {
	function PhpArrayToJsObject_Recurse( $array ) {
	   // Base case of recursion: when the passed value is not a PHP array, just output it (in quotes).
	   if ( ! is_array( $array ) && !is_object( $array ) ) {
	       // Handle null specially: otherwise it becomes "".
	       if ( $array === null )
	       {
	           return 'null';
	       }
	       return '"' . javascript_escape( $array ) . '"';
	   }
	   // Open this JS object.
	   $retVal = "{";
	   // Output all key/value pairs as "$key" : $value
	   // * Output a JS object (using recursion), if $value is a PHP array.
	   // * Output the value in quotes, if $value is not an array (see above).
	   $first = true;
	   foreach ( $array as $key => $value ) {
	       // Add a comma before all but the first pair.
	       if ( ! $first ) {
	           $retVal .= ', ';
	       }
	       $first = false;
	       // Quote $key if it's a string.
	       if ( is_string( $key ) ) {
	           $key = '"' . $key . '"';
	       }
	       $retVal .= $key . ' : ' . PhpArrayToJsObject_Recurse( $value );
	   }
	   // Close and return the JS object.
	   return $retVal . "}";
	}
}
if ( ! function_exists( 'javascript_escape' ) ) {
	function javascript_escape( $val ) {
		// first strip /r
		$val = str_replace( "\r", '', $val );
		return str_replace(	array( '"', "\n", '{', '}' ),
							array( '\"', '"' . "+\n" . '"', '\{', '\}' ),
							$val );
	}
}

?>
