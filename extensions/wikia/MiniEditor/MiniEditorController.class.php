<?php

class MiniEditorController extends WikiaController {

	// This method needs to be called once on any page that wants the MiniEditor.  It will:
	// Add the body class MiniEditor
	// Add a fake hidden form needed for RTE
	public function EditorSetup() {
		OasisModule::addBodyClass('MiniEditor');
		// Just a one liner so we cheat and skip the actual template
		$this->wg->Out->addHTML("<form id='RTEFakeForm'></form>\n");
		$this->skipRendering();
	}

	/**
	 * Load MiniEditor css and js dependencies
	 * extensions can add more assets to be loaded AFTER the MiniEditor assets
	 * this entire bundle of js vars and assets can be loaded in-page or via makeGlobalVariables (below)
	 *
	 * @request type array additionalAssets 
	 * @request type boolean loadOnDemand  
	 */
	public function loadAssets() {

		// Params
		$loadOnDemand = $this->request->getVal('loadOnDemand', false);
		$additionalAssets = $this->request->getVal('additionalAssets', array());

		// FIXME: load JSMessages for VET and WMU extensions here too
		// FIXME: must refactor VET and WMU to use JSMessages first
		F::build('JSMessages')->enqueuePackage('EditPageLayout', JSMessages::EXTERNAL);

		// Required CSS assets
		$this->response->addAsset('extensions/wikia/RTE/css/RTE.scss');
		$this->response->addAsset('extensions/wikia/MiniEditor/css/MiniEditor.scss');

		// If this function got called, MiniEditor is enabled
		$this->response->setJSVar('wgEnableMiniEditorExt', true);

		// Create a JS variable to let us know if we are loading on demand or not
		$this->response->setJSVar('wgMiniEditorLoadOnDemand', $loadOnDemand);

		// Loading assets on demand
		if ($loadOnDemand) {

			// Export a list of assets to javascript for future dynamic loading
			$this->response->setJSVar('wgMiniEditorAssets', $additionalAssets);

		} else {

			// Load javascript variables
			$response = $this->sendSelfRequest('makeGlobalVariables');
			$jsvars = $response->getData();

			// Load any required assets
			// TODO: add a "raw_url" = true param to $response->addAsset so we can use that
			foreach ($jsvars['wgMiniEditorAssets'] as $asset) {

				// Load JavaScript files/AssetManager groups
				if (preg_match("/(.js(\?(.*))?$)|(__am\/\d+\/group)/", $asset)) {
					$this->wg->Out->addScript( "<script type=\"{$this->wg->JsMimeType}\" src=\"{$asset}\"></script>" );

				// Load SASS/CSS files
				} else if (preg_match("/.s?css(\?(.*))?$/", $asset)) {
					$this->wg->Out->addStyle( $asset );
				}
			}

			// Load any additional extension assets
			foreach($additionalAssets as $asset) {
				$this->response->addAsset($asset);
			}

			// Don't include wgMiniEditorAssets in global page vars
			unset($jsvars['wgMiniEditorAssets']);		

			// Set the rest of our global JS vars
			foreach ($jsvars as $var => $value) {
				$this->response->setJSVar($var, $value);
			}
		}

		// if LinkSuggest ext is enabled, add that JS too
		/*if (function_exists('AddLinkSuggest')) {
			AddLinkSuggest(0, 0, 0, '');
		}*/

		// Required JS assets (should be loaded last!)
		$this->response->addAsset('extensions/wikia/MiniEditor/js/MiniEditor.js');
		
		// No visible output from this module for now so we don't need a template for this function
		$this->skipRendering();
	}

	// Helper function to initialize RTE global variables needed by MiniEditor
	public function makeGlobalVariables() {
		$vars = array();

		// EditPage needs to know if this is an article page, and it is not
		$vars['wgIsArticle'] = false;
		$vars['wgAction'] = 'edit'; // needed for image uploading

		// RTE has been disabled but minieditor is enabled.  probably shouldn't be allowed to happen
		if ( !class_exists('RTE') ) {
			$vars['RTEDisabledReason'] = 'sitedisabled';
		} else {
			// Need to call RTE::init to get Disabled reason (if any, usually preferences)
			$ep = new EditPage(new Article(new Title())); 
			RTE::init($ep);
			RTE::makeGlobalVariablesScript(&$vars);
		}
		// FIXME: We have to force AssetsManager to combine scripts.
		// MiniEditor will break in loadOnDemand mode because of improper script execution order.
		$minify = empty($this->wg->DevelEnvironment);

		// If RTE is disabled, fall back to the mediawiki editor
		if (isset($vars['RTEDisabledReason'])) {
			$assetList = AssetsManager::getInstance()->getGroupCommonURL('mini_editor_js', array(), true, $minify);

		} else {
			$assetList = AssetsManager::getInstance()->getGroupCommonURL('mini_editor_rte_js', array(), true, $minify);
		}
		
		// Extension CSS
		$assetList[] = AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/VideoEmbedTool/css/VET.scss');
		$assetList[] = AssetsManager::getInstance()->getOneCommonURL('extensions/wikia/WikiaMiniUpload/css/WMU.css');

		$vars['wgMiniEditorAssets'] = $assetList;

		// Extensions use hooks to load their setup only on edit pages (VideoEmbedTool, WikiaMiniUploader)
		// To load ONLY the vars we need and not all of them we will call the setup functions directly
		
		VETSetupVars(&$vars);
		WMUSetupVars(&$vars);

		$this->response->setCacheValidity( 86400, 86400,  array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH,));

		$this->response->setData($vars);
	}	
}