<?
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

# ##
# This is the path to your installation of Metavid Wiki as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# #
$mvgScriptPath = $wgScriptPath . '/extensions/MetavidWiki';

# ##
# This is the path to your installation of Semantic MediaWiki as
# seen on your local file system. Used for PHP file includes
# #
$mvgIP = $IP . '/extensions/MetavidWiki';

define( 'SEQUENCE_TAG', 'sequence_hlrd' );

// include the global functions & register the extension
include_once( 'MV_GlobalFunctions.php' );


//greatly affects site performance (turn to false to avoid costly parent lookups on all search results) :
$mvGetParentMeta = true;


//script loader settings:


// if the search portlet should autoComplete
// (causes the inclution of jquery into every page.. can slow things down a bit)
$mvEnableAutoComplete = true;



// if you want mvd links to be rewritten client side as inline movie clips and link to the stream page
$mvEnableJSMVDrewrite = true;

# #########################
# semanticWiki integration options
# #########################
// @@todo we should clean this up!... into a semantic maping array or object
// if you want to include spoken by relation in search results:

// enable dissable varius digest data collection
$mvEnableSearchDigest = true;
$mvEnableClipViewDigest = true;
// keeps track of popular pages in given categories over time
$mvDigestCategories = array( 'Interst_Group', 'Bill', 'Person' );

// metadata helpers for annotative layer (anno_en)
// 'property'=>category for auto_complete (ALL LOWER CASE)
$mvMetaDataHelpers = array( 'anno_en' => array( 'speech_by' => 'person', 'bill' => 'bill' ) );

// by default categories are handled differently enable or disable below:
$mvMetaCategoryHelper = true;


$mvSpokenByInSearchResult = true;
// if you want to include category lookup in search results:
$mvCategoryInSearchResult = true;
// if you want to include bill lookup in search results:
$mvBillInSearchResult = true;


# ########################
# metavid paths
# @@todo clean up with internal handlers for annodex and images
# use the mediaWiki defaults for storage of media
# #########################

// define the image location:
// $mvImageWebLoc ='http://metavid.org/image_media/';

// if we should load images from an external server:
$mvExternalImages = false;
// path to metavidWiki install that is serving images:
$mvExternalImgServerPath = 'http://metavid.org/w/index.php';

$mvWebImgLoc = $mvgScriptPath . '/stream_images';
// full local path for images (if hosted locally)
$mvLocalImgLoc = $mvgIP . '/stream_images';

// if mediaWiki should serve up redirects to image file path or have php send the image via GD
// if served directly its one less round trip to the server but may tax the server
// a bit more than having apache serving the file
$mvServeImageRedirect = false;

// the time in seconds of between image frames generated from movie clips.
// (set pretty high for the metavid context where we load the images via scripts
// (early on we did less frequent image grabs)
// normally you would want a lower value like 5 seconds or so
$mvImageGranularityRate = '600';
// the ffmpeg command to generate thumbnail (to disable generating images set to '')
$mvShellOggFrameGrab = '';

# define the video media locations based on path/server names
$mvVideoArchivePaths['cap1'] = 'http://metavidstorage01.ucsc.edu/media/';
$mvVideoArchivePaths['mvbox2'] = 'http://mvbox2.cse.ucsc.edu/media/';

// stream msgKeys that support ?t=start_time/end_time temporal url media serving:
$mvDefaultVideoQualityKey 	= 'mv_ogg_low_quality';
$mvDefaultFlashQualityKey 	= 'mv_flash_low_quality';
$mvDefaultVideoHighQualityKey = 'mv_ogg_high_quality';
$mvDefaultMP4QualityKey 	= 'mv_archive_org_mp4';

$mvVidQualityMsgKeyType['mv_ogg_low_quality'] = $mvVidQualityMsgKeyType['mv_ogg_high_quality']='video/ogg';
$mvVidQualityMsgKeyType['mv_flash_low_quality']='video/x-flv';

# local path to video archive (if hosted locally)
$mvLocalVideoLoc = '/metavid/video_archive';

# default clip length
$mvDefaultClipLength = 30;
$mvDefaultClipRange = 10;

/*how many seconds to display of the video in the default Metavid:stream_name page */
$mvDefaultStreamViewLength = 60 * 20; // 20 min

// default aspect ratio (should be derived from media resolution once we integrate with oggHandler)
$mvDefaultAspectRatio = .75;

// limit for media search results:
$mvMediaSearchResultsLimit = 100;

# define how offten (in seconds) clients do http pull requests
# to get new info when watching live broadcasts
$mvLiveUpdateInterval = 5;

// should be the same resolution as webstream encode.
$mvDefaultVideoPlaybackRes = '400x300';
$mvDefaultSearchVideoPlaybackRes = '320x240';
$mvDefaultVideoIconSize = '80x60';

//if to display the ROE resource link
$mvDispROEicon=false;

//The text Embed a metavid Stream inline in the wiki
$mvEmbedKey = 'Embed';

//wars people of archive inacuracys (given its a wiki and the source is close caption feed)
$mvEnableStreamNotice = false;

/*
 * All Available meta data layers
 * these type keys are used to allow multiple layers of metadata per stream.
 * These values key into template_names, msg_descriptions, and application logic )
 * Different languages should be in different tracks and documentation should be clear
 * to insure data goes into its associative layer.
 */
$mvMVDTypeAllAvailable = array( 'ht_en', 'anno_en', 'thomas_en' );

/*
 * the default display set of layers (must be a subset of $mvMVDTypeAllAvaliable)
 * note: this is equivalent to ?mvd_tracks=ht_en,anno_en  in the url for the stream page.
 * this also dictates the default search layers
*/
$mvMVDTypeDefaultDisp = array( 'ht_en', 'anno_en' );

//if we should show the layer controls:
$mvgShowLayerControls = false;

# ##################
# Special Pages with Interface functions
# ##################
// the wiki image page/image for missing person thumbnail:
define( 'MV_MISSING_PERSON_IMG', 'Missing person.jpg' );


// whether to count found results (can take lots of time on big result sets)
$mvDo_SQL_CALC_FOUND_ROWS = true;

# ########
# Stream Types & User Rights
# @@todo should really integrate "streams" with "media"
# here you can control what rights 'sysop', 'bot', 'user', 'anonymous',  have in
# adding streams
# note: all streams are treated equally once added to the system
# (this only control import types)
#
# type: 	[metavid_file] -- used for pointing to an existing file on the server
#			[metavid_live] -- used for the setting up the scripts for a live stream.
#			[upload_file]	-- used video file uploads
#			[external_file] -- used to add external files via http urls (such as a file from archive.org)
$mvStreamTypePermission['metavid_file'] = array( 'sysop', 'bot' );
$mvStreamTypePermission['metavid_live'] = array();
$mvStreamTypePermission['upload_file'] = array();
$mvStreamTypePermission['external_file'] = array();

$wgGroupPermissions['user']['mv_delete_mvd'] = true;
$wgGroupPermissions['sysop']['mv_edit_stream'] = true;
$wgGroupPermissions['bot']['mv_edit_stream'] = true;

$wgAvailableRights[] = 'mv_delete_mvd';
$wgAvailableRights[] = 'mv_edit_stream';

$mvMsgContentTypeLookup = array(
 		'ao_file_256Kb_MPEG4'	=> 'video/mp4',
 		'ao_file_64Kb_MPEG4'	=> 'video/mp4',
 		'ao_file_flash_flv'		=> 'video/x-flv',
 		'ao_file_MPEG1'			=> 'video/mpeg',
 		'ao_file_MPEG2'			=> 'video/mpeg-2',

		'mv_archive_org_mp4'	=> 'video/h264',
 		'mv_flash_low_quality'	=> 'video/x-flv',
 		'mv_ogg_high_quality'	=> 'video/ogg',
 		'mv_ogg_low_quality'	=> 'video/ogg'
 	);

# ##
# If you already have custom namespaces on your site, insert
# $mvNamespaceIndex = ???; in your config before including the settings
# should be larger than 100 and if you put in a default value
# if your using semantic wiki just init the semantic wiki namespace
# and metavid will take subsequent NS values accordingly.
# #
if ( !isset( $mvNamespaceIndex ) ) {
	mvInitNamespaces( 100 );
} else {
	mvInitNamespaces();
}
