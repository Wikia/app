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
	'url' => 'http://www.wikia.com' ,
	'descriptionmsg' => 'createpage-desc',
);

define( 'CREATEPAGE_ITEM_WIDTH', 140 );
define( 'CREATEPAGE_MAX_DIALOG_WIDTH', CREATEPAGE_ITEM_WIDTH * 3 );
define( 'CREATEPAGE_MIN_DIALOG_WIDTH', 400 );
define( 'CREATEPAGE_DIALOG_SIDE_PADDING', 10 );

/**
 * messages file
 */
$wgExtensionMessagesFiles['CreatePage'] = dirname( __FILE__ ) . '/CreatePage.i18n.php';

/**
 * Special pages
 */
extAddSpecialPage( dirname( __FILE__ ) . '/SpecialCreatePage.php', 'CreatePage', 'CreatePage' );

$wgSpecialPageGroups['CreatePage'] = 'pagetools';

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfCreatePageInit';

$wgCreatePageOptions = array();
$wgCreatePageDialogWidth = CREATEPAGE_MIN_DIALOG_WIDTH;

// initialize create page extension
function wfCreatePageInit() {
	global $wgUser,
		$wgHooks,
		$wgAjaxExportList,
		$wgOut,
		$wgScriptPath,
		$wgStyleVersion,
		$wgExtensionsPath,
		$wgWikiaEnableNewCreatepageExt,
		$wgCdnStylePath,
		$wgScript,
		$wgCreatePageOptions,
		$wgWikiaCreatePageUseFormatOnly,
		$wgCreatePageDialogWidth;

	// load messages from file
	wfLoadExtensionMessages( 'CreatePage' );

	if ( empty( $wgWikiaEnableNewCreatepageExt ) ) {
		// disable all new features and preserve old Special:CreatePage behavior
		return true;
	}

	/**
	 * hooks
	 */
	$wgHooks['MakeGlobalVariablesScript'][] = 'wfCreatePageSetupVars';
	$wgHooks['EditPage::showEditForm:initial'][] = 'wfCreatePageLoadPreformattedContent';
	$wgHooks['UserToggles'][] = 'wfCreatePageToggleUserPreference';
	$wgHooks['getEditingPreferencesTab'][] = 'wfCreatePageToggleUserPreference';

	$wgAjaxExportList[] = 'wfCreatePageAjaxGetDialog';
	$wgAjaxExportList[] = 'wfCreatePageAjaxCheckTitle';

	if ( empty( $wgWikiaCreatePageUseFormatOnly ) ) {
		$wgCreatePageOptions = array(
			'format'=>array(
				'namespace' => NS_MAIN,
				'label' => 'createpage-dialog-format',
				'icon' => "{$wgCdnStylePath}/extensions/wikia/CreatePage/images/thumbnail_format.png",
				'trackingId' => 'standardlayout',
				'submitUrl' => "{$wgScript}?title=$1&action=edit&useFormat=1"
			),
			'blank'=> array(
				'namespace' => NS_MAIN,
				'label' => 'createpage-dialog-blank',
				'icon' => "{$wgCdnStylePath}/extensions/wikia/CreatePage/images/thumbnail_blank.png",
				'trackingId' => 'blankpage',
				'submitUrl' => "{$wgScript}?title=$1&action=edit"
			)
		);
		
		wfRunHooks( 'CreatePage::FetchOptions', array( &$wgCreatePageOptions ) );

		$optionsCount = count( $wgCreatePageOptions );
		$detectedWidth = ( $optionsCount * CREATEPAGE_ITEM_WIDTH );

		if ( $detectedWidth > CREATEPAGE_MAX_DIALOG_WIDTH ) {
			$detectedWidth = CREATEPAGE_MAX_DIALOG_WIDTH;
		}

		$selectedWidth = ( $detectedWidth > $wgCreatePageDialogWidth ) ? $detectedWidth : $wgCreatePageDialogWidth;

		$maxItemsPerRow = floor( $selectedWidth / CREATEPAGE_ITEM_WIDTH );
		$divider = ( $maxItemsPerRow > $optionsCount ) ? $optionsCount : $maxItemsPerRow;
		$itemWidthPercentage =  round( 100 / $divider );
		
		foreach( $wgCreatePageOptions as $key => $params ) {
			$wgCreatePageOptions[ $key ][ 'width' ] = "{$itemWidthPercentage}%";
		}

		$wgCreatePageDialogWidth = ( $detectedWidth > $wgCreatePageDialogWidth ) ? ( $detectedWidth + ( CREATEPAGE_DIALOG_SIDE_PADDING * 2 ) ) : $wgCreatePageDialogWidth;
	}
}

function wfCreatePageSetupVars( $vars ) {
	global $wgWikiaEnableNewCreatepageExt,
		$wgWikiaDisableDynamicLinkCreatePagePopup,
		$wgContentNamespaces,
		$wgContLang,
		$wgUser,
		$wgCreatePageDialogWidth;

	$contentNamespaces = array();

	foreach ( $wgContentNamespaces as $contentNs ) {
		$contentNamespaces[] = $wgContLang->getNsText( $contentNs );
	}

	$vars['WikiaEnableNewCreatepage'] = $wgUser->getOption( 'createpagepopupdisabled', false ) ? false : $wgWikiaEnableNewCreatepageExt;
	$vars['WikiaDisableDynamicLinkCreatePagePopup'] = !empty( $wgWikiaDisableDynamicLinkCreatePagePopup ) ? true : false;
	$vars['ContentNamespacesText'] = $contentNamespaces;
	$vars[ 'CreatePageDialogWidth' ] = $wgCreatePageDialogWidth;



	return true;
}

function wfCreatePageLoadPreformattedContent( $editpage ) {
	global $wgRequest;

	if ( $wgRequest->getCheck( 'useFormat' ) ) {
		$editpage->textbox1 = wfMsgForContentNoTrans( 'newpagelayout' );
	}
	return true ;
}

function wfCreatePageToggleUserPreference( $toggles, $default_array = false ) {
	if ( is_array( $default_array ) ) {
		$default_array[] = 'createpagedefaultblank';
		$default_array[] = 'createpagepopupdisabled';
	}
	else {
		$toggles[] = 'createpagedefaultblank';
		$toggles[] = 'createpagepopupdisabled';
	}
	return true;
}

function wfCreatePageAjaxGetDialog() {
	global $wgWikiaCreatePageUseFormatOnly, $wgUser,  $wgCreatePageOptions;

	$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$options = $wgCreatePageOptions;

	$defaultLayout = $wgUser->getOption( 'createpagedefaultblank', false ) ?  'blank' : 'format';

	$template->set_vars( array(
			'useFormatOnly' => !empty( $wgWikiaCreatePageUseFormatOnly ) ? true : false,
			'defaultPageLayout' => $defaultLayout,
			'options' => $options
		)
	);

	$body = $template->execute( 'dialog' );
	$response = new AjaxResponse( $body );
	$response->setCacheDuration( 0 ); // no caching

	$response->setContentType( 'text/plain; charset=utf-8' );

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

		if ( !( $oTitle instanceof Title ) ) {
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
				if ( $oTitle->getNamespace() == -1 ) {
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

	$json = Wikia::json_encode( $result );
	$response = new AjaxResponse( $json );
	$response->setCacheDuration( 3600 );

	$response->setContentType( 'application/json; charset=utf-8' );

	return $response;
}

include( dirname( __FILE__ ) . "/SpecialEditPage.php" );
include( dirname( __FILE__ ) . "/SpecialCreatePage.php" );
