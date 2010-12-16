<?
/**
 * Global functions and constants for Metavid MediaWiki.
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 */
define( 'MV_VERSION', '1.0r47961' );

if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

/**
 * Switch on Metavid MediaWiki. This function must be called in LocalSettings.php
 *  its separated out to allow for overwriting semantic wiki hooks and functions
 * if semantic wiki is enabled for this wiki.
 */

// add language:
$wgExtensionMessagesFiles['MetavidWiki'] = $mvgIP . '/languages/MV_Messages.php';
require_once( $mvgIP . '/languages/MV_Language.php' );

// Register special page aliases file
$wgExtensionAliasesFiles['MetavidWiki'] = $mvgIP . '/languages/MV_Aliases.php';

$markerList = array();
$mvGlobalJSVariables = array();
// override special search page:
$wgSpecialPages['Search'] = 'MV_SpecialSearch';
$wgAutoloadClasses['MV_SpecialSearch'] = dirname( __FILE__ ) . '/specials/MV_SpecialMediaSearch.php';

/**********************************************/
/***** register autoLoad javascript Classes:  */
/**********************************************/
$mv_jspath =  'extensions/MetavidWiki/skins/';

$wgJSAutoloadClasses['mv_allpages']			= $mv_jspath . 'mv_allpages.js';
$wgJSAutoloadClasses['mv_search']			= $mv_jspath . 'mv_search.js';
$wgJSAutoloadClasses['mv_stream']			= $mv_jspath . 'mv_stream.js';


function enableMetavid() {
	global $wgExtensionFunctions, $smwgNamespacesWithSemanticLinks;
	$wgExtensionFunctions[] = 'mvSetupExtension';
	// add in metavid namespace to semanticLinks array:
	$smwgNamespacesWithSemanticLinks[MV_NS_STREAM] = true;
	$smwgNamespacesWithSemanticLinks[MV_NS_STREAM_TALK] = false;
	$smwgNamespacesWithSemanticLinks[MV_NS_SEQUENCE] = true;
	$smwgNamespacesWithSemanticLinks[MV_NS_SEQUENCE_TALK] = false;
	$smwgNamespacesWithSemanticLinks[MV_NS_MVD] = true;
	$smwgNamespacesWithSemanticLinks[MV_NS_MVD_TALK] = false;

	return true;
}
function mvSetupExtension() {
	global $mvVersion, $mvNamespace, $mvgIP, $wgHooks, $wgExtensionCredits, $mvMasterStore,
	$wgParser, $mvArticlePath, $mvgScriptPath, $wgServer, $wgExtensionFunctions, $markerList,$wgVersion,
	$wgAjaxExportList, $mvEnableAutoComplete, $mvEnableJSMVDrewrite,
	$wgAutoloadClasses, $wgSpecialPages, $wgMediaHandlers, $wgJSAutoloadClasses,
	$wgAPIModules;


	mvfInitMessages();
	//add the ALL page header
	mvfAutoAllPageHeader();

	/********************************
 	* Ajax Hooks
 	*********************************/
	$wgAjaxExportList[] = 'mv_auto_complete_all';
	$wgAjaxExportList[] = 'mv_auto_complete_person';


	$wgAjaxExportList[] = 'mv_auto_complete_stream_name';
	$wgAjaxExportList[] = 'mv_helpers_auto_complete';

	$wgAjaxExportList[] = 'mv_disp_mvd';

	$wgAjaxExportList[] = 'mv_add_disp';
	$wgAjaxExportList[] = 'mv_remove_mvd';
	$wgAjaxExportList[] = 'mv_disp_remove_mvd';

	$wgAjaxExportList[] = 'mv_edit_disp';
	$wgAjaxExportList[] = 'mv_edit_preview';
	$wgAjaxExportList[] = 'mv_edit_submit';

	//$wgAjaxExportList[] = 'mv_history_disp';
	$wgAjaxExportList[] = 'mv_adjust_disp';
	$wgAjaxExportList[] = 'mv_adjust_submit';

	//sequence interface exported functions
	$wgAjaxExportList[] = 'mv_edit_sequence_submit';
	$wgAjaxExportList[] = 'mv_seqtool_disp';
	$wgAjaxExportList[] = 'mv_seqtool_clipboard';


	// search interface exported functions:
	$wgAjaxExportList[] = 'mv_expand_wt';
	$wgAjaxExportList[] = 'mv_pl_wt';
	$wgAjaxExportList[] = 'mv_submit_remove';
	$wgAjaxExportList[] = 'mv_tool_disp';
	$wgAjaxExportList[] = 'mv_date_obj';


	// media serving
	$wgAjaxExportList[] = 'mv_frame_server';


	/**********************************************/
	/***** register autoLoad Classes:		  *****/
	/**********************************************/
	// setup autoload classes:
	$wgAutoloadClasses['MV_Overlay'] 			= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_Overlay.php';
	$wgAutoloadClasses['MV_Component'] 			= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_Component.php';

	$wgAutoloadClasses['MV_MetavidInterface']	= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_MetavidInterface.php';

	$wgAutoloadClasses['MV_SequencePlayer']		= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_SequencePlayer.php';
	$wgAutoloadClasses['MV_SequenceTools']		= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_SequenceTools.php';
	$wgAutoloadClasses['MV_EditSequencePage']	= dirname( __FILE__ )  . '/MV_EditSequencePage.php';

	$wgAutoloadClasses['MV_VideoPlayer']		= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_VideoPlayer.php';
	$wgAutoloadClasses['MV_Tools']				= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_Tools.php';
	$wgAutoloadClasses['MV_Navigator']			= dirname( __FILE__ )	 . '/MV_MetavidInterface/MV_Navigator.php';
	$wgAutoloadClasses['MV_EditPageAjax'] 		= dirname( __FILE__ )  . '/MV_MetavidInterface/MV_EditPageAjax.php';

	$wgAutoloadClasses['MV_CategoryPage']		= dirname( __FILE__ )  . '/articlepages/MV_CategoryPage.php';
	$wgAutoloadClasses['MV_SequencePage'] 		=  dirname( __FILE__ )  . '/articlepages/MV_SequencePage.php';
	$wgAutoloadClasses['MV_StreamPage'] 		= dirname( __FILE__ )  . '/articlepages/MV_StreamPage.php';
	$wgAutoloadClasses['MV_EditDataPage']		= $wgAutoloadClasses['MV_DataPage'] =  dirname( __FILE__ ) . '/articlepages/MV_DataPage.php';
	$wgAutoloadClasses['MV_EditStreamPage']		= dirname( __FILE__ )  . '/MV_EditStreamPage.php';


	$wgAutoloadClasses['MV_Title'] 				= dirname( __FILE__ )  . '/MV_Title.php';
	$wgAutoloadClasses['MV_Index'] 				= dirname( __FILE__ )  . '/MV_Index.php';
	$wgAutoloadClasses['MV_ImageGallery']		= dirname( __FILE__ ) . '/MV_ImageGallery.php';
	$wgAutoloadClasses['MV_Image'] 				= dirname( __FILE__ )  . '/MV_Image.php';
	$wgAutoloadClasses['MV_Stream'] 			= dirname( __FILE__ )  . '/MV_Stream.php';
	$wgAutoloadClasses['MV_StreamFile']			= dirname( __FILE__ )  . '/MV_StreamFile.php';

	$wgAutoloadClasses['MV_StreamImage'] 		= dirname( __FILE__ )  . '/MV_StreamImage.php';
	$wgAutoloadClasses['MV_ParserCache'] 		= dirname( __FILE__ ) . '/MV_ParserCache.php';
	$wgAutoloadClasses['MV_MagicWords'] 		= dirname( __FILE__ ) . '/MV_MagicWords.php';

	/**********************************************/
	/***** register special pages hooks       *****/
	/**********************************************/
	$wgAutoloadClasses['MV_SpecialCRUDStream'] 	= dirname( __FILE__ ) . '/specials/MV_SpecialCRUDStream.php';
	$wgSpecialPages['Mv_Add_Stream']		   	=  array( 'MV_SpecialCRUDStream' );

	$wgAutoloadClasses['MV_SpecialListStreams']	= dirname( __FILE__ ) . '/specials/MV_SpecialListStreams.php';
	$wgSpecialPages['Mv_List_Streams']		   	= array( 'MV_SpecialListStreams' );

	/* special export views */
	$wgAutoloadClasses['MV_SpecialExport']		= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';

	$wgAutoloadClasses['MvVideoFeed']			= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';
	$wgAutoloadClasses['MvExportStream']		= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';
	$wgAutoloadClasses['MvExportSequence']		= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';
	$wgAutoloadClasses['MvExportSearch']		= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';
	$wgAutoloadClasses['MvExportAsk']			= dirname( __FILE__ ) . '/specials/MV_SpecialExport.php';

	$wgSpecialPages['MvVideoFeed']				= array( 'MvVideoFeed' );
	$wgSpecialPages['MvExportStream']			= array( 'MvExportStream' );
	$wgSpecialPages['MvExportSequence']			= array( 'MvExportSequence' );
	$wgSpecialPages['MvExportSearch']			= array( 'MvExportSearch' );
	$wgSpecialPages['MvExportAsk']				= array( 'MvExportAsk' );

	$wgAutoloadClasses['MV_SpecialMediaSearch']	= dirname( __FILE__ ) . '/specials/MV_SpecialMediaSearch.php';
	$wgSpecialPages['Mv_List_Streams']		   	= array( 'MV_SpecialListStreams' );

	$wgAutoloadClasses['MediaSearch'] =			 dirname( __FILE__ ) . '/specials/MV_SpecialMediaSearch.php';
	$wgSpecialPages['MediaSearch']				= array( 'MediaSearch' );
	$wgSpecialPages['MV_SpecialSearch']			= array( 'MV_SpecialSearch' );

	$wgAutoloadClasses['MVAdmin']				= dirname( __FILE__ ) . '/specials/MV_SpecialMVAdmin.php';
	$wgSpecialPages['MVAdmin']					= array( 'MVAdmin' );
	// require_once( dirname(__FILE__) . '/specials/MV_SpecialCRUDStream.php');
	// require_once( dirname(__FILE__) . '/specials/MV_SpecialListStreams.php');
	// require_once( dirname(__FILE__) . '/specials/MV_SpecialExport.php');
	// require_once( dirname(__FILE__) . '/specials/MV_SpecialMediaSearch.php');
	// require_once( dirname(__FILE__) . '/specials/MV_SpecialMVAdmin.php');

	/**********************************************/
	/***** register hooks                     *****/
	/**********************************************/
	require_once( $mvgIP . '/includes/MV_Hooks.php' );
	// $wgHooks['ArticleSave'][] = 'mvSaveHook';
	$wgHooks['ArticleSaveComplete'][] 		= 'mvSaveHook';
	$wgHooks['ArticleDelete'][] 			= 'mvDeleteHook';
	$wgHooks['ArticleFromTitle'][] 			= 'mvDoMvPage';
	$wgHooks['TitleMoveComplete'][]			= 'mvMoveHook';
	$wgHooks['LinkEnd'][] 					= 'mvLinkEnd';
	$wgHooks['LinkBegin'][] 				= 'mvLinkBegin';

	$wgHooks['MakeGlobalVariablesScript'][]	= 'mvGlobalJSVariables';

	//our move function handles calling SMW hook
	foreach($wgHooks['TitleMoveComplete'] as $k=>$f){
 		if($f=='smwfMoveHook'){
 			unset($wgHooks['TitleMoveComplete'][$k]);
 		}
	}

	if (version_compare($wgVersion,'1.13','>=')) {
		$wgHooks['SkinTemplateToolboxEnd'][] = 'mvAddToolBoxLinks'; // introduced only in 1.13
	} else {
		$wgHooks['MonoBookTemplateToolboxEnd'][] = 'mvAddToolBoxLinks';
	}


	// @@NOTE this hook is not avaliable by default in medaiwiki
	// to use this hook you should add this function to moveTo()
	// right after the local check in Title.php:
 	/*
 	 $err = wfRunHooks('TitleisValidMove', array( &$this, &$nt, &$wgUser, $auth));
		 if( is_string( $err ) ) {
			return $err;
		 }
	*/
	$wgHooks['TitleisValidMove'][]			= 'mvisValidMoveOperation';

	$wgHooks['ParserAfterTidy'][]			= 'mvParserAfterTidy';

	$wgHooks['CustomEditor'][] = 'mvCustomEditor';
	$wgParser->setHook( SEQUENCE_TAG, 'mvSeqTag' );

	$wgParser->setFunctionHook( 'mvData', 'mvMagicParserFunction_Render' );


	/*
	* OggHandler extension overrides
	* if the OggHandler is included remap the object for compatibility with metavid
	* MV_OggHandler.php handles all the re-mapping
	*/
	if(isset($wgMediaHandlers['application/ogg'])){
		if($wgMediaHandlers['application/ogg'] == 'OggHandler'){
			$wgAutoloadClasses['mvOggHandler']			= dirname( __FILE__ )  . '/MV_OggHandler.php';
			$wgMediaHandlers['application/ogg']='mvOggHandler';
			$wgParserOutputHooks['OggHandler'] = array( 'mvOggHandler', 'outputHook' );
			foreach($wgHooks['LanguageGetMagic'] as & $hook_function){
				if($hook_function=='OggHandler::registerMagicWords'){
					$hook_function='mvOggHandler::registerMagicWords';
				}
			}
			foreach($wgExtensionCredits as & $ext){
				 if(isset($ext['name'])){
					 if($ext['name']=='OggHandler'){
					 	$ext['description'].=' Integrated with the <b>MetaVidWiki Extension</b>';
					 }
				 }
			}
		}
	}


	 /************************************
	 *  API extension (this may be integrated into semantic wiki at some point)
	 **************************************/




	// $wgHooks['BeforePageDisplay'][] = 'mvDoSpecialPage';
	// $wgHooks['ArticleViewHeader'][] = 'mvArticleViewOpts';
	/**********************************************/
	/***** credits (see "Special:Version")    *****/
	/**********************************************/
	$wgExtensionCredits['other'][] = array(
		'name' => 'MetaVidWiki',
		'author' => 'Michael Dale',
		'version' => MV_VERSION,
		'url' => 'http://metavid.org/wiki/MetaVidWiki_Software',
		'description' => 'Video Metadata Editor & Media Search<br />' .
			'[http://metavid.org/wiki/MetaVidWiki_Software More about MetaVidWiki Software]',
		'descriptionmsg' => 'mv-desc',
	);
}
# Define a setup function
# Add a hook to initialize the magic word
$wgHooks['LanguageGetMagic'][]       = 'mvMagicParserFunction_Magic';

function mvMagicParserFunction_Magic( &$magicWords, $langCode ) {
        $magicWords['mvData'] = array( 0, 'mvData' );
        $magicWords['mvEmbed'] = array( 0, 'mvEmbed' );
        return true;
}

function mvMagicParserFunction_Render( &$parser ) {
		// gennerate arg_list array without parser param
		$arg_list = array_slice( func_get_args(), 1 );
		$mvMagicWords = new MV_MagicWords( $arg_list );
        return array( $mvMagicWords->renderMagic(), 'noparse' => true, 'isHTML' => true );
}

/**********************************************/
/***** Header modifications               *****/
/**********************************************/
	/**
	 * header script to be added to all pages:
	 * enables linkback and autocomplete for search
	 */
function mvfAutoAllPageHeader() {
	global $mvgScriptPath, $wgJsMimeType, $wgOut, $mvExtraHeader, $wgTitle;
	global $mvgJSDebug, $wgEnableScriptLoader, $wgRequest;

	$mvgScriptPath = htmlspecialchars( $mvgScriptPath );
	$wgJsMimeType = htmlspecialchars( $wgJsMimeType ) ;
	//set the unquie request value
	if( $mvgJSDebug ){
		$unique_req_param = time();
	}else{
		//@@todo should read form svn version file info
		$unique_req_param = MV_VERSION;
	}

	$wgOut->addScriptClass( "mv_allpages" );
	$wgOut->addScriptClass( "mv_search" );


	$mvCssUrl = $mvgScriptPath . '/skins/mv_custom.css';
	$wgOut->addLink( array(
			'rel'   => 'stylesheet',
			'type'  => 'text/css',
			'media' => 'all',
			'href'  => $mvCssUrl
	) );

	$wgOut->addScript( $mvExtraHeader );
}
function mvAddPerNamespaceJS( &$title ){
	global $mvgScriptPath, $wgJsMimeType, $wgOut;
	if( $title->getNamespace() == MV_NS_STREAM )
		$wgOut->addScriptFile( "{$mvgScriptPath}/skins/mv_stream.js" );
}
function mvAddGlobalJSVariables( $values ){
	global $mvGlobalJSVariables;
	$mvGlobalJSVariables = array_merge($mvGlobalJSVariables, $values); ;
}
function mvGlobalJSVariables( $vars ){
	global $mvGlobalJSVariables;
	$vars = array_merge($vars, $mvGlobalJSVariables);
	return true;
}
/**
 * Init the additional namepsaces used by Metavid MediaWiki. The
 * parameter denotes the least unused even namespace ID that is
 * greater or equal to 100.
 */
function mvInitNamespaces() {
	global $mvNamespaceIndex, $wgExtraNamespaces, $wgNamespacesWithSubpages, $wgLanguageCode, $mvgContLang,
		$mvLastNamespaceIndex;

	if ( !isset( $mvNamespaceIndex ) ) {
			$mvNamespaceIndex = 100;
	}

	// register the namespace:MVD & Metavid
	define( 'MV_NS_STREAM',			$mvNamespaceIndex );
	define( 'MV_NS_STREAM_TALK',		$mvNamespaceIndex + 1 );
	define( 'MV_NS_SEQUENCE',		$mvNamespaceIndex + 2 );
	define( 'MV_NS_SEQUENCE_TALK',	$mvNamespaceIndex + 3 );
	define( 'MV_NS_MVD', 			$mvNamespaceIndex + 4 );
	define( 'MV_NS_MVD_TALK', 		$mvNamespaceIndex + 5 );

	mvfInitContentLanguage( $wgLanguageCode );

	// print_r($mvgContLang);
	// print_r($mvgContLang->getNamespaces());
	// Register namespace identifiers
	if ( !is_array( $wgExtraNamespaces ) ) { $wgExtraNamespaces = array(); }
	$wgExtraNamespaces = $wgExtraNamespaces + $mvgContLang->getNamespaces();
	// update the mvLastNamespaceIndex for however many name spaces are established above:
	$mvLastNamespaceIndex =  $mvNamespaceIndex + 6;
}

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialize a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialized much later when they are actually needed.
 */
function mvfInitContentLanguage( $langcode ) {
	global $mvgIP, $mvgContLang;

	if ( !empty( $mvgContLang ) ) { return; }

	$mvContLangClass = 'MV_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $mvgIP . '/languages/' . $mvContLangClass . '.php' ) ) {
		include_once( $mvgIP . '/languages/' . $mvContLangClass . '.php' );
		// print "included: " . $mvgIP . '/languages/'. $mvContLangClass . '.php';
	}

	// fallback if language not supported
	if ( !class_exists( $mvContLangClass ) ) {
		include_once( $mvgIP . '/languages/MV_LanguageEn.php' );
		$mvContLangClass = 'MV_LanguageEn';
	}

	$mvgContLang = new $mvContLangClass();
}

/**
 * Initialize the global language object for user language. This
 * must happen after the content language was initialized, since
 * this language is used as a fallback.
 */
function mvfInitUserLanguage( $langcode ) {
	global $mvgIP, $mvgLang;

	if ( !empty( $mvgLang ) ) { return; }

	$mvLangClass = 'MV_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $mvgIP . '/languages/' . $mvLangClass . '.php' ) ) {
		include_once( $mvgIP . '/languages/' . $mvLangClass . '.php' );
	}
	// fallback if language not supported
	if ( !class_exists( $mvLangClass ) ) {
		global $mvgContLang;
		$mvgLang = $mvgContLang;
	} else {
		$mvgLang = new $mvLangClass();
	}
}
/**
 * Initialize messages - these settings must be applied later on, since
 * the MessageCache does not exist yet when the settings are loaded in
 * LocalSettings.php.
 * Function based on version in ContributionScores extension
 */
function mvfInitMessages() {
	global $wgVersion, $wgExtensionFunctions;
	if ( version_compare( $wgVersion, '1.11', '>=' ) ) {
		wfLoadExtensionMessages( 'MetavidWiki' );
	} else {
		$wgExtensionFunctions[] = 'sffLoadMessagesManually';
	}
}

/**
 * Setting of message cache for versions of MediaWiki that do not support
 * wgExtensionFunctions - based on ceContributionScores() in
 * ContributionScores extension
 */
function sffLoadMessagesManually() {
	global $mvgIP, $wgMessageCache;

	# add messages
	require( $mvgIP . '/languages/MV_Messages.php' );
	global $messages;
	foreach ( $messages as $key => $value ) {
		$wgMessageCache->addMessages( $messages[$key], $key );
	}
}

/*
 * Utility functions:
 */
function mvOutputJSON( & $data ) {
	$fname = 'Mv_output_json_data';
	wfProfileIn( $fname );

	global $wgRequest;

	// get callback index and wrap function:
	$callback_index = $wgRequest->getVal( 'cb_inx' );
	$wrap_function = $wgRequest->getVal( 'cb' );

	header( 'Content-Type: text/javascript' );
	if($callback_index!='' && $wrap_function!=''){
		$output =  htmlspecialchars( $wrap_function ) . '(' . PhpArrayToJsObject_Recurse(
		array(	'cb_inx' => htmlspecialchars( $callback_index ),
				'content-type' => 'text/xml',
				'pay_load' => $data
			)
		) . ');';
	}else{
		//just produce a results var:
		$output = php2jsObj( array('pay_load'=>$data) );
	}
	wfProfileOut( $fname );
	//if all is well return true:
	return $output;
}
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
 /*
  * Check if time is NTP based: hh:mm:ss.ms(fraction of a second)
  */
function mvIsNtpTime( $time ) {
	// could alternatively do preg match: (too strict)
	// preg_match('/[0-9]+:[0-9][0-9]:[0-9][0-9]/', $this->start_time, $matches);
 	// if(count($matches)==0)
	$tp = split( ':', $time );
	if ( count( $tp ) >= 4 || count( $tp ) <= 2 )return false;
	list( $hours, $min, $sec ) = $tp;
	// min/sec should be no larger than 60
	if ( $min >= 60 || $sec >= 60 )return false;
	// @@TODO min & hour should not be a floating point number
	if ( is_numeric( $hours ) && is_numeric( $min ) && is_numeric( $sec ) )
		return true;
	return false;
}
/*
 * simple array increment (supports up two 2 dim deep)
 * should be a cleaner way to write this... hmm...
 */
 function assoc_array_increment( &$ary ) {
 	$numargs = func_num_args();
 	switch( $numargs ) {
 		case '2':
 			if ( !isset( $ary[func_get_arg( 1 )] ) ) {
 				$ary[func_get_arg( 1 )] = 1;
 			} else {
 				$ary[func_get_arg( 1 )]++;
 			}
 		break;
 		case '3':
 			if ( !isset( $ary[func_get_arg( 1 )] ) ) {
 				$ary[func_get_arg( 1 )] = array();
 			}
 			if ( !isset( $ary[func_get_arg( 1 )][func_get_arg( 2 )] ) ) {
 				$ary[func_get_arg( 1 )][func_get_arg( 2 )] = 1;
 			} else {
 				$ary[func_get_arg( 1 )][func_get_arg( 2 )]++;
 			}
 		break;
 	}
 }

/*
 * takes ntp time of format hh:mm:ss and converts to seconds
 */
function npt2seconds( $str_time ) {
	$time_ary = explode( ':', $str_time );
	$hours = $min = $sec = 0;
	if ( count( $time_ary ) == 3 ) {
		$hours 	= (int) $time_ary[0];
		$min 	= (int) $time_ary[1];
		$sec 	= (float) $time_ary[2];
	} else if ( count( $time_ary ) == 2 ) {
		$min 	= (int) $time_ary[0];
		$sec 	= (float) $time_ary[1];
	} else if ( count( $time_ary ) == 1 ) {
		$sec 	= (float) $time_ary[0];
	}
	return ( $hours * 3600 ) + ( $min * 60 ) + $sec;
}
/*
 * takes seconds duration and return hh:mm:ss time
 */
function seconds2npt( $seconds, $short = false ) {
	$dur = time_duration_2array( $seconds );
	if( ! $dur )
		return null;
	// be sure to output leading zeros (for min,sec):
	if ( $dur['hours'] == 0 && $short == true ) {
		return sprintf( "%2d:%02d", $dur['minutes'], $dur['seconds'] );
	} else {
		return sprintf( "%d:%02d:%02d", $dur['hours'], $dur['minutes'], $dur['seconds'] );
	}
}
function seconds2Description( $seconds, $short=false, $singular=false){
	$dur = time_duration_2array( $seconds , array('days'=> '86400', 'hours'=> 3600,'minutes'   => 60,'seconds'   => 1));
	$o='';
	if( $dur['days']!=0){
		if( $singular ) {
			$o.= wfMsg( 'mv_days_singular' );
		} else {
			$o.= wfMsg( 'mv_days', intval( $dur['days'] ) );
		}
	}
	if( $dur['hours'] != 0  ){
		if( $singular ) {
			$o.= wfMsg( 'mv_hours_singular' );
		} else {
			$o.= wfMsg( 'mv_hours', intval( $dur['hours'] ) );
		}
	}
	if( $dur['minutes'] != 0  ){
		$o.=($o!='')?' ':'';
		if( $singular ) {
			$o.= wfMsg( 'mv_minutes_singular' );
		} else {
			$o.= wfMsg( 'mv_minutes', intval( $dur['minutes'] ) );
		}
	}
	if( ( $short == false || $o == '' ) && $dur['seconds'] ){
		$o.=($o!='')?' ':'';
		if( $singular ) {
			$o.= wfMsg( 'mv_seconds_singular' );
		} else {
			$o.= wfMsg( 'mv_seconds', intval( $dur['seconds'] ) );
		}
	}
	return $o;
}
/*
 * converts seconds to time unit array
 */
function time_duration_2array ( $seconds, $periods = null ) {
	// Define time periods
	if ( !is_array( $periods ) ) {
		$periods = array (
			'years'     => 31556926,
			'months'    => 2629743,
			'weeks'     => 604800,
			'days'      => 86400,
			'hours'     => 3600,
			'minutes'   => 60,
			'seconds'   => 1
			);
	}

	// Loop
	$seconds = (float) $seconds;
	foreach ( $periods as $period => $value ) {
		$count = floor( $seconds / $value );
		if ( $count == 0 ) {
			// must include hours minutes and seconds even if they are 0
			if ( $period == 'hours' || $period == 'minutes' || $period == 'seconds' ) {
				$values[$period] = 0;
			}
			continue;
		}
		$values[$period] = sprintf( "%02d", $count );
		$seconds = $seconds % $value;
	}
	// Return
	if ( empty( $values ) ) {
		$values = null;
	}
	return $values;
}
/*
 * direct output for quick creation of non editable pages (errors, stream access etc)
 */
function mvOutputSpecialPage( $title, & $page ) {
	global $wgOut, $wgTitle;

	// $wgTitle = SpecialPage::getTitleFor($title);
	$wgTitle->mNamespace = NS_SPECIAL;

	$wgOut->setPageTitle( $title );
	$wgOut->setHTMLTitle( $title );
	$wgOut->setArticleRelated( false );
	$wgOut->enableClientCache( true );

	$wgOut->addHTML( $page );
	$wgOut->returnToMain( false );

	$wgOut->output();

	exit();
}
function mvDoMetavidStreamPage( &$title, &$article ) {
	$mvTitle = new MV_Title( $title->mDbkeyform );
	if ( $mvTitle->doesStreamExist() ) {
		// @@TODO check if we have /name corresponding to a view or
		// /ss:ss:ss or /ss:ss:ss/ee:ee:ee corresponding to a time request
		// force metavid to be special
		// (@@todo clean up skin.php to enable better tab controls)
		// $title->mNamespace= NS_SPECIAL;

		// add a hit to the digest if enabled:
		// @@todo (maybe in the future use javascript to confirm they acutally "watched" the clip)
		global $mvEnableClipViewDigest, $wgRequest;
		// don't log views without end times (default stream view)
		if ( $mvEnableClipViewDigest && $mvTitle->end_time != null && $wgRequest->getVal( 'tl' ) != '1' ) {
			$dbw = wfGetDB( DB_WRITE );
			$dbw->insert( 'mv_clipview_digest', array(
					'stream_id'	=> $mvTitle->getStreamId(),
					'start_time' => $mvTitle->getStartTimeSeconds(),
					'end_time'	=> $mvTitle->getEndTimeSeconds(),
					'query_key' => $mvTitle->getStreamId() . $mvTitle->getStartTimeSeconds() . $mvTitle->getEndTimeSeconds(),
					'view_date'	=> time()
				)
			);
			// compensate for $mvDefaultClipRange around clips
			global $mvDefaultClipRange;
			$start_time = ( $mvTitle->getStartTimeSeconds() + $mvDefaultClipRange < 0 ) ? 0:
							( $mvTitle->getStartTimeSeconds() + $mvDefaultClipRange );

			$end_time = ( $mvTitle->getEndTimeSeconds() - $mvDefaultClipRange > $mvTitle->getDuration() ) ? 0:
							( $mvTitle->getEndTimeSeconds() - $mvDefaultClipRange );
			// also increment the mvd_page if we find a match:
			$dbw->update( 'mv_mvd_index', array( '`view_count`=`view_count`+1' ),
							array(	'stream_id' => $mvTitle->getStreamId(),
									'start_time' => $start_time,
									'end_time'	=> $end_time
							) );
			// print $dbw->lastQuery();
			// also update the mvd_page if directly requested:
			$dbw->update( 'mv_mvd_index', array( '`view_count`=`view_count`+1' ),
							array(	'stream_id' => $mvTitle->getStreamId(),
									'start_time' => $mvTitle->getStartTimeSeconds(),
									'end_time'	=> $mvTitle->getEndTimeSeconds()
							) );
			// print $dbw->lastQuery();
		}
		// @@todo check if the requested title is already just the stream name:
		$streamTitle = Title::newFromText( $mvTitle->getStreamName(), MV_NS_STREAM );
		// print " new title: " . $streamTitle . "\n";
		$article = new MV_StreamPage( $streamTitle, $mvTitle );
	} else {
		mvMissingStreamPage( $mvTitle->stream_name );
	}
}

/*
 * global MV_Stream server
 * @@todo cache this function
 */
function mvGetMVStream( $stream_init ) {
	global $MVStreams;
	// wfDebug('mv get stream: ' .$stream_name . "\n");
	if ( is_object( $stream_init ) ) {
		$stream_init = get_object_vars( $stream_init );
	} else if ( is_string( $stream_init ) ) {
		// if a string is passed in assume its the stream name:
		$stream_init = array( 'name' => $stream_init );
	}
	if ( isset( $stream_init['name'] ) ) {
		$stream_name = $stream_init['name'];
	} else if ( isset( $stream_init['id'] ) ) {
		$stream_name = MV_Stream::getStreamNameFromId( $stream_init['id'] );
	} else {
		die('missing stream id or name'. $stream_init);
	}
	// @@todo cache in memcache)
	if ( !isset( $MVStreams[$stream_name] ) ) {
		$MVStreams[$stream_name] = new MV_Stream( $stream_init );
		$MVStreams[$stream_name]->db_load_stream();
	}
	return $MVStreams[$stream_name];
}

function mvGetMVTitle() {

}
function mv_get_person_img( $person_name ) {
	$imgTitle = Title::makeTitle( NS_IMAGE, $person_name . '.jpg' );
	if ( $imgTitle->exists() ) {
		$img = wfFindFile( $imgTitle );
		if ( !$img ) {
			$img = wfLocalFile( $imgTitle );
		}
	} else {
		// @@todo add Missing person.jpg to install scripts
		$imgTitle =  Title::makeTitle( NS_IMAGE, MV_MISSING_PERSON_IMG );
		$img = wfFindFile( $imgTitle );
		if ( !$img ) {
			$img = wfLocalFile( $imgTitle );
		}
	}
	return $img;
}
function mvViewPrevNext( $offset, $limit, $link, $query = '', $atend = false ) {
	global $wgLang;
	$fmtLimit = $wgLang->formatNum( $limit );
	$prev = wfMsg( 'prevn', $fmtLimit );
	$next = wfMsg( 'nextn', $fmtLimit );

	if ( is_object( $link ) ) {
		$title =& $link;
	} else {
		$title = Title::newFromText( $link );
		if ( is_null( $title ) ) {
			return false;
		}
	}

	if ( 0 != $offset ) {
		$po = $offset - $limit;
		if ( $po < 0 ) { $po = 0; }
		$q = "limit={$limit}&offset={$po}";
		if ( '' != $query ) { $q .= '&' . $query; }
		$plink = '<a href="' . $title->escapeLocalUrl( $q ) . "\" class=\"mw-prevlink\">{$prev}</a>";
	} else {
		// $plink = $prev;
		$plink = '';
	}

	$no = $offset + $limit;
	$q = 'limit=' . $limit . '&offset=' . $no;
	if ( '' != $query ) { $q .= '&' . $query; }

	if ( $atend ) {
		$nlink = $next;
	} else {
		$nlink = '<a href="' . $title->escapeLocalUrl( $q ) . "\" class=\"mw-nextlink\">{$next}</a>";
	}
	// If ever re-enabled, remember to use pipe-separator / Language::pipeList
	/*$nums = wfNumLink( $offset, 20, $title, $query ) . ' | ' .
	  wfNumLink( $offset, 50, $title, $query ) . ' | ' .
	  wfNumLink( $offset, 100, $title, $query ) ;
	  */
	// hide option to set number of results
	$nums = '';
	if ( $plink == '' ) {
		return wfMsg( 'mv_viewnext', $nlink );
	} else {
		return wfMsg( 'mv_viewprevnext', $plink, $nlink );
	}
}
