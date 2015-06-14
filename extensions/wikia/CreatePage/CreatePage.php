<?php
/**
 * A special page to create a new article, using wysiwig editor
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Create Page',
	'author' => array( 'Bartek Lapinski', 'Adrian Wieczorek' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CreatePage',
	'descriptionmsg' => 'createpage-desc',
);

define( 'CREATEPAGE_ITEM_WIDTH', 140 );
define( 'CREATEPAGE_MAX_DIALOG_WIDTH', CREATEPAGE_ITEM_WIDTH * 3);
define( 'CREATEPAGE_MIN_DIALOG_WIDTH', 400 );
define( 'CREATEPAGE_DIALOG_SIDE_PADDING', 10 );

/**
 * messages file
 */
$wgExtensionMessagesFiles['CreatePage'] = dirname( __FILE__ ) . '/CreatePage.i18n.php';
/**
 * Aliases
 */
$wgExtensionMessagesFiles['CreatePageAliases'] = __DIR__ . '/CreatePage.aliases.php';

/**
 * Special page
 */
$wgAutoloadClasses['SpecialCreatePage'] = dirname(__FILE__) . '/SpecialCreatePage.class.php';
$wgSpecialPages['CreatePage'] = 'SpecialCreatePage';
$wgSpecialPageGroups['CreatePage'] = 'pagetools';

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfCreatePageInit';

// initialize create page extension
function wfCreatePageInit() {
	global $wgHooks, $wgAjaxExportList;

	/**
	 * hooks
	 */
	$wgHooks['MakeGlobalVariablesScript'][] = 'wfCreatePageSetupVars';
	$wgHooks['EditPage::showEditForm:initial'][] = 'wfCreatePageLoadPreformattedContent';
	$wgHooks['GetPreferences'][] = 'wfCreatePageOnGetPreferences';
	$wgHooks['BeforeInitialize'][] = 'wfCreatePageOnBeforeInitialize';

	$wgAjaxExportList[] = 'wfCreatePageAjaxGetDialog';
	$wgAjaxExportList[] = 'wfCreatePageAjaxGetVEDialog';
	$wgAjaxExportList[] = 'wfCreatePageAjaxCheckTitle';
}

// use different code for Special:CreatePage when using monobook (BugId:6601)
function wfCreatePageOnBeforeInitialize(&$title, &$article, &$output, User &$user, $request, $mediaWiki) {
	global $wgAutoloadClasses;

	// this line causes initialization of the skin
	// title before redirect handling is passed causing BugId:7282 - it will be fixed in "AfterInitialize" hook
	$skinName = get_class($user->getSkin());
	if ($skinName == 'SkinMonoBook') {
		// use different class to handle Special:CreatePage
		$dir = dirname(__FILE__) . '/monobook';

		$wgAutoloadClasses['SpecialCreatePage'] = $dir . '/SpecialCreatePage.class.php';
		$wgAutoloadClasses['SpecialEditPage'] = $dir . '/SpecialEditPage.class.php';
	}

	return true;
}

function wfCreatePageSetupVars(Array &$vars ) {
	global $wgWikiaEnableNewCreatepageExt,
		$wgWikiaDisableDynamicLinkCreatePagePopup,
		$wgContentNamespaces,
		$wgContLang,
		$wgUser;

	$contentNamespaces = array();

	foreach ( $wgContentNamespaces as $contentNs ) {
		$contentNamespaces[] = $wgContLang->getNsText( $contentNs );
	}

	/**
	 * In some cases create page popup may be disabled
	 * This avoids overwriting this variable if it's already set
	 * For example see: InsightsHooks::onMakeGlobalVariablesScript
	 */
	if ( !isset( $vars['WikiaEnableNewCreatepage'] ) ) {
		$vars['WikiaEnableNewCreatepage'] = $wgUser->getOption( 'createpagepopupdisabled', false ) ? false : $wgWikiaEnableNewCreatepageExt;
	}

	if (!empty( $wgWikiaDisableDynamicLinkCreatePagePopup )) {
		$vars['WikiaDisableDynamicLinkCreatePagePopup'] = true;
	}

	$vars['ContentNamespacesText'] = $contentNamespaces;

	if ( RequestContext::getMain()->getTitle()->isSpecial('CreatePage') ) {
		$vars['wgAction'] = RequestContext::getMain()->getRequest()->getVal( 'action', 'edit' );
	}

	return true;
}

function wfCreatePageLoadPreformattedContent( $editpage ) {
	global $wgRequest, $wgEnableVideoToolExt, $wgUser;

	if( !$editpage->textbox1 ) {
		if ( $wgRequest->getCheck( 'useFormat' ) ) {
			// if user has proper permissions, show Create Page with Video panel
			if ( $wgEnableVideoToolExt && $wgUser->isAllowed('videoupload') ) {
					$editpage->textbox1 = wfMsgForContentNoTrans( 'createpage-with-video' );
			} else {
				$editpage->textbox1 = wfMsgForContentNoTrans( 'newpagelayout' );
			}
		} else if ( $msg = $wgRequest->getVal( 'useMessage' ) ) {
			$editpage->textbox1 = wfMsgForContentNoTrans( $msg );
		}
	}
	return true ;
}

function wfCreatePageOnGetPreferences( $user, &$preferences ) {

	$preferences['createpagedefaultblank'] = array(
		'type' => 'toggle',
		'section' => 'editing/starting-an-edit',
		'label-message' => 'tog-createpagedefaultblank',
	);

	$preferences['createpagepopupdisabled'] = array(
		'type' => 'toggle',
		'section' => 'editing/starting-an-edit',
		'label-message' => 'tog-createpagepopupdisabled',
	);

	return true;
}

function wfCreatePageAjaxGetVEDialog() {
	global $wgRequest;

	$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$template->set_vars( array(
			'article' => urldecode( $wgRequest->getVal( 'article' ) )
		)
	);

	$body['html'] = $template->render( 'dialog-ve' );
	$body['title'] = wfMsg( 'createpage-dialog-title' );
	$body['addPageLabel'] = wfMsg( 'button-createpage' );
	$body['cancelLabel'] = wfMsg( 'createpage-button-cancel' );

	$response = new AjaxResponse( json_encode( $body ) );
	$response->setCacheDuration( 0 ); // no caching
	$response->setContentType( 'application/json; charset=utf-8' );

	return $response;
}

function wfCreatePageAjaxGetDialog() {
	global $wgWikiaCreatePageUseFormatOnly, $wgUser,  $wgCreatePageOptions, $wgExtensionsPath, $wgScript,
	$wgEnableVideoToolExt, $wgEnableVisualEditorUI, $wgRequest;

	$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$options = array();
	$standardOptions = array();

	$standardOptions['format'] = array(
		'namespace' => NS_MAIN,
		'label' => wfMsg( 'createpage-dialog-format' ),
		'icon' => $wgEnableVideoToolExt ? "{$wgExtensionsPath}/wikia/CreatePage/images/thumbnail_format_video.png" : "{$wgExtensionsPath}/wikia/CreatePage/images/thumbnail_format.png",
		'trackingId' => 'standardlayout',
		'submitUrl' => "{$wgScript}?title=$1&action=edit&useFormat=1"
	);

	$standardOptions['blank'] = array(
		'namespace' => NS_MAIN,
		'label' => wfMsg( 'createpage-dialog-blank' ),
		'icon' => "{$wgExtensionsPath}/wikia/CreatePage/images/thumbnail_blank.png",
		'trackingId' => 'blankpage',
		'submitUrl' => "{$wgScript}?title=$1&action=edit"
	);

	$listtype = "short";
	wfRunHooks( 'CreatePage::FetchOptions', array(&$standardOptions, &$options, &$listtype ) );

	$options = $options + $standardOptions;
	$optionsCount = count( $options );
	$detectedWidth = ( $optionsCount * CREATEPAGE_ITEM_WIDTH );

	if ( $detectedWidth > CREATEPAGE_MAX_DIALOG_WIDTH ) {
		$detectedWidth = CREATEPAGE_MAX_DIALOG_WIDTH;
	}

	$wgCreatePageDialogWidth = CREATEPAGE_MIN_DIALOG_WIDTH;

	$selectedWidth = ( $detectedWidth > $wgCreatePageDialogWidth ) ? $detectedWidth : $wgCreatePageDialogWidth;

	$maxItemsPerRow = floor( $selectedWidth / CREATEPAGE_ITEM_WIDTH );
	$divider = ( $maxItemsPerRow > $optionsCount ) ? $optionsCount : $maxItemsPerRow;
	$itemWidthPercentage =  round( 100 / $divider );

	foreach( $options as $key => $params ) {
		$options[ $key ][ 'width' ] = "{$itemWidthPercentage}%";
	}

	$wgCreatePageDialogWidth = ( $detectedWidth > $wgCreatePageDialogWidth ) ? ( $detectedWidth + ( CREATEPAGE_DIALOG_SIDE_PADDING * 2 ) ) : $wgCreatePageDialogWidth;

	$defaultLayout = $wgUser->getOption( 'createpagedefaultblank', false ) ?  'blank' : 'format';

	// some extensions (e.g. PLB) can remove "format" option, so fallback to first available option here
	if(!array_key_exists($defaultLayout, $options) ) {
		reset($options);
		$defaultLayout = key($options);
	}

	$template->set_vars( array(
			'useFormatOnly' => !empty( $wgWikiaCreatePageUseFormatOnly ),
			'options' => $options,
			'type' => $listtype
		)
	);

	$body['html'] = $template->render( 'dialog' );
	$body['width'] = $wgCreatePageDialogWidth;
	$body['defaultOption'] = $defaultLayout;
	$body['title'] = wfMsg( 'createpage-dialog-title' );
	$body['addPageLabel'] = wfMsg( 'button-createpage' );
	$body['article'] = $wgRequest->getVal( 'article' );

	$response = new AjaxResponse( json_encode( $body ) );
	$response->setCacheDuration( 0 ); // no caching

	$response->setContentType( 'application/json; charset=utf-8' );

	return $response;
}

function wfCreatePageAjaxCheckTitle() {
	global $wgRequest, $wgUser;

	$result = array( 'result' => 'ok' );
	$sTitle = $wgRequest->getVal( 'title' ) ;
	$nameSpace = $wgRequest->getInt( 'namespace' ) ;

	// perform title validation
	if ( empty( $sTitle ) ) {
		$result['result'] = 'error';
		$result['msg'] = wfMsg( 'createpage-error-empty-title' );
	}
	else {
		$oTitle = Title::newFromText( $sTitle, $nameSpace );

		if ( !( $oTitle instanceof Title ) || strpos( $sTitle, "#" ) !== false ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'createpage-error-invalid-title' );
		}
		else {
			if ( $oTitle->exists() ) {
				$result['result'] = 'error';
				$result['msg'] = wfMsg( 'createpage-error-article-exists', array( $oTitle->getFullUrl(), $oTitle->getText() ) );
			}
			else { // title not exists
				// macbre: use dedicated hook for this check (change related to release of Phalanx)
				if ( !wfRunHooks( 'CreatePageTitleCheck', array( $oTitle ) ) ) {
					$result['result'] = 'error';
					$result['msg'] = wfMsg( 'createpage-error-article-spam' );
				}
				if ( $oTitle->getNamespace() == NS_SPECIAL ) {
					$result['result'] = 'error';
					$result['msg'] = wfMsg( 'createpage-error-invalid-title' );
				}
				if ( $wgUser->isBlockedFrom( $oTitle, false ) ) {
					$result['result'] = 'error';
					$result['msg'] = wfMsg( 'createpage-error-article-blocked' );
				}
			}
		}
	}

	$json = json_encode( $result );
	$response = new AjaxResponse( $json );
	$response->setCacheDuration( 3600 );

	$response->setContentType( 'application/json; charset=utf-8' );

	return $response;
}
