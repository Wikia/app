<?php

//NOTE the wikiAtHome extension is dependent on oggHandler for defining some things like: $wgffmpeg2theoraPath
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is the WikiAtHome extension. Please see the README file for installation instructions.\n";
	exit( 1 );
}

$exDir = dirname(__FILE__);
//setup autoloader php:
$wgAutoloadClasses[ 'NonFreeVideoHandler' ] 	= "$exDir/NonFreeVideoHandler.php";
$wgAutoloadClasses[ 'MediaQueueTransformOutput']= "$exDir/NonFreeVideoHandler.php";

$wgAutoloadClasses[ 'WahJobManager' ] 			= "$exDir/WahJobManager.php";
$wgAutoloadClasses[ 'ApiWikiAtHome' ]			= "$exDir/ApiWikiAtHome.php";

//setup autoloading javascript:
$wgJSAutoloadLocalClasses[ 'WikiAtHome' ]		= "extensions/WikiAtHome/WikiAtHome.js";

//add a set of video extensions to the $wgFileExtensions set that we support transcoding from
$tmpExt = array('avi', 'mov', 'mp4', 'mp2', 'mpeg', 'mpeg2', 'mpeg4', 'dv', 'wmv' );
foreach($tmpExt as $ext){
	if ( !in_array( $ext, $wgFileExtensions ) ) {
		$wgFileExtensions[] = $ext;
	}
	if( !isset( $wgMediaHandlers['video/'.$ext] )){
		$wgMediaHandlers['video/'.$ext] = 'NonFreeVideoHandler';
	}
}

$wgExtensionMessagesFiles['WikiAtHome'] = "$exDir/WikiAtHome.i18n.php";
$wgExtensionMessagesFiles['WikiAtHomeAlias'] = "$exDir/WikiAtHome.alias.php";

//special pages
$wgAutoloadClasses['SpecialWikiAtHome']		= "$exDir/SpecialWikiAtHome.php";
$wgSpecialPages['SpecialWikiAtHome']		= 'SpecialWikiAtHome';

//add api module for processing jobs
$wgAPIModules['wikiathome'] = 'ApiWikiAtHome';

function wahAddGlobalPageVars(&$vars){
	global $wgClientSearchInterval;
	//only add to the special page:
	if($vars['wgCanonicalSpecialPageName'] == 'SpecialWikiAtHome'){
		$vars['wgClientSearchInterval'] = $wgClientSearchInterval;
	}
	return true;
}
//hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'wahAddGlobalPageVars';


//credits
$wgExtensionCredits['media'][] = array(
	'path'           => __FILE__,
	'name'           => 'Wiki@Home',
	'author'         => 'Michael Dale',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WikiAtHome',
	'descriptionmsg' => 'wah-desc',
);
/******************* CONFIGURATION STARTS HERE **********************/


//the oggCat path enables server side concatenation of encoded "chunks"
$wgOggCat =  '/usr/local/bin/oggCat';

//with oggCat installed then we can do jobs in "chunks"
//and assemble on the server: (this way large encode jobs happen ~fast~)
// $wgChunkDuration is set in seconds: (setting this too low will result in bad encodes)
// $wgChunkDuration is only used if we have a valid $wgOggCat install
$wgJobTypeConfig = array(
	'transcode' => array(
		//set chunk duration to zero to not split the file
		'chunkDuration'=> 0,
		// if the api should assign the job on the Special:WikiAtHome page
		// (or via other external api scripts)
		'assignAtHome' 	=> true,
		'assignInternal'=> true
	),
	'flatten'=> array(
		'chunkDuration'=> 10,
		'assignAtHome' => true,
		'assignInternal' => false
	)
);

//time interval in seconds between clients asking the server for jobs.
$wgClientSearchInterval = 60;

//how long before considering a job ready to be assigned to others
//note first "in" wins & if once time is up we decrement set_c
$wgJobTimeOut = 60*10; //10 min

//this sets how many copies of any given stream we should send out as part of a job
$wgNumberOfClientsPerJobSet = 25;

//what to encode to:
$wgEnabledDerivatives = array(
	WikiAtHome::ENC_SAVE_BANDWITH,
	WikiAtHome::ENC_WEB_STREAM,
	WikiAtHome::ENC_HQ_STREAM
);

//these params are set via firefogg encode options see:
//http://firefogg.org/dev/index.html
//if you want to re-derive things you should change its key above in the WikiAtHome class
$wgDerivativeSettings[ WikiAtHome::ENC_SAVE_BANDWITH ] =
		array(
			'videoBitrate'		=> '128',
			'audioBitrate'		=> '32',
			'samplerate'		=> '22050',
			'framerate'			=> '15',
			'channels'			=> '1',
			'maxSize'			=> '200',
			'noUpscaling'		=> 'true',
			'twopass'			=> 'true',
			'keyframeInterval'	=> '64',
			'bufDelay'			=> '128'
		);
$wgDerivativeSettings[ WikiAtHome::ENC_WEB_STREAM ] =
		array(
			'maxSize'			=> '400',
			'videoBitrate'		=> '512',
			'audioBitrate'		=> '96',
			'noUpscaling'		=> 'true',
			'twopass'			=> 'true',
			'keyframeInterval'	=> '128',
			'bufDelay'			=> '256'
		);

$wgDerivativeSettings[ WikiAtHome::ENC_HQ_STREAM ] =
		array(
			'maxSize' 		=> '1080',
			'videoQuality'	=> 6,
			'audioQuality'	=> 3,
			'noUpscaling'	=> 'true'
		);


/**
 * Main WikiAtHome Class hold some constants and config values
 *
 */
class WikiAtHome {
	const ENC_SAVE_BANDWITH = '256_200kbs';
	const ENC_WEB_STREAM = '400_300kbs';
	const ENC_HQ_STREAM = 'high_quality';

/**
 * the mapping between firefogg api and ffmpeg2theora command line
 * (this way shell command to ffmpeg2theora and firefogg can share a common api)
 * also see: http://firefogg.org/dev/index.html
 */
	var $foggMap = array(
		//video
		'width'				=> "--width",
		'height' 			=> "--height",
		'maxSize' 			=> "--max_size",
	    'noUpscaling'		=> "--no-upscaling",
	  	'videoQuality'		=> "-v",
		'videoBitrate'		=> "-V",
		'twopass'			=> "--two-pass",
		'framerate'			=> "-F",
		'aspect'			=> "--aspect",
		'starttime'			=> "--starttime",
		'endtime'			=> "--endtime",
		'cropTop'			=> "--croptop",
		'cropBottom'		=> "--cropbottom",
		'cropLeft'			=> "--cropleft",
		'cropRight'			=> "--cropright",
		'keyframeInterval'	=> "--key",
		'denoise'			=> array("--pp", "de"),
		'novideo'			=> array("--novideo", "--no-skeleton"),
		'bufDelay'			=> "--buf-delay",

		//audio
		'audioQuality'		=> "-a",
		'audioBitrate'		=> "-A",
	    'samplerate'		=> "-H",
		'channels'			=> "-c",
		'noaudio'			=> "--noaudio",

	    //metadata
	    'artist'			=> "--artist",
	    'title'				=> "--title",
	    'date'				=> "--date",
	    'location'			=> "--location",
	    'organization'		=> "--organization",
	    'copyright'			=> "--copyright",
	    'license'			=> "--license",
	    'contact'			=> "--contact"
	);
	static function getTargetDerivative($targetWidth, $srcFile){
		global $wgEnabledDerivatives, $wgDerivativeSettings;

		$srcWidth = $srcFile->getWidth();
		$srcHeight = $srcFile->getHeight();
		//print get_class( $srcFile->handler);

		//return special key 'notransform' if targetdWidth greater than our source file)
		if( $targetWidth >= $srcWidth && get_class( $srcFile->handler) != 'NonFreeVideoHandler')
			return 'notransform';

		if( count($wgEnabledDerivatives) == 1 )
			return current($wgEnabledDerivatives);

		//if target width > 450 & high quality is on then give them HQ:
		if( $targetWidth > 450 && in_array(WikiAtHome::ENC_HQ_STREAM, $wgEnabledDerivatives) )
			return WikiAtHome::ENC_HQ_STREAM;

		//if target width <= 250 and ENC_SAVE_BANDWITH then send small version
		if( $targetWidth <= 260 && in_array(WikiAtHome::ENC_SAVE_BANDWITH, $wgEnabledDerivatives) )
			return WikiAtHome::ENC_SAVE_BANDWITH;

		//else return the default web stream if on
		if( in_array(WikiAtHome::ENC_WEB_STREAM, $wgEnabledDerivatives) )
			return WikiAtHome::ENC_WEB_STREAM;

		//else return whatever we have
		return $wgDerivativeSettings[ current($wgEnabledDerivatives) ];
	}
}

//GLOBAL FUNCTIONS:
/**
 * wahDoEncode issues an encode command to ffmpeg2theora
 */
function wahDoEncode($source, $target, $encodeSettings ){
	global $wgffmpeg2theoraPath;
	$cmd = wfEscapeShellArg( $wgffmpeg2theoraPath ) . ' ' . wfEscapeShellArg( $source );
	$wah = new WikiAtHome();
	foreach($encodeSettings as $key=>$val){
		if( isset( $wah->foggMap[$key] ) ){
			if( is_array(  $wah->foggMap[$key] ) ){
				$cmd.= ' '. implode(' ', $wah->foggMap[$key] );
			}elseif($val == 'true' || $val===true){
		 		$cmd.= ' '. $wah->foggMap[$key];
			}elseif( $val === false){
				//ignore "false" flags
			}else{
				//normal get/set value
				$cmd.= ' '. $wah->foggMap[$key] . ' ' . wfEscapeShellArg( $val );
			}
		}
	}
	//add the output target:
	$cmd.= ' -o ' . wfEscapeShellArg ( $target );

	wfProfileIn( 'ffmpeg2theora_encode' );
	wfShellExec( $cmd, $retval );
	wfProfileOut( 'ffmpeg2theora_encode' );

	if( $retval ){
		return false;
	}
	return true;
}

/**
 * runs concatenation checks if we get a non zero length output
 */
function wahDoOggCat( $destFile, $oggList ){
	global $wgOggCat;

	$cmd = wfEscapeShellArg( $wgOggCat ). ' ' . wfEscapeShellArg( $destFile );
	foreach($oggList as $oggFile){
		$cmd.= ' ' . wfEscapeShellArg( $oggFile );
	}
	$cmd .= ' 2>&1';
	wfProfileIn( 'oggCat' );
	wfShellExec( $cmd, $retval );
	wfProfileOut( 'oggCat' );
	if( $retval ){
		return false;
	}
	return true;
}
