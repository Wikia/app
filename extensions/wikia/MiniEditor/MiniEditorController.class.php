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

	// Load MiniEditor css and js dependencies
	public function loadAssets() {
		global $wgTitle;

		// FIXME: load JSMessages for VET and WMU extensions here too
		// FIXME: must refactor VTE and WMU to use JSMessages first
		F::build('JSMessages')->enqueuePackage('EditPageLayout', JSMessages::EXTERNAL);

		$this->response->addAsset('extensions/wikia/RTE/css/RTE.scss'); 
		$this->response->addAsset('extensions/wikia/MiniEditor/js/MiniEditor.js');
		$this->response->addAsset('extensions/wikia/MiniEditor/css/MiniEditor.scss');

		// Load additional assets if any were provided
		$additionalAssets = $this->request->getVal('additionalAssets', array());
		foreach($additionalAssets as $asset) {
			$this->response->addAsset($asset);
		}
		
		// if LinkSuggest ext is enabled, add that JS too
		if (function_exists('AddLinkSuggest')) {
			//AddLinkSuggest(0, 0, 0, '');
		}
		
		// No visible output from this module for now so we don't need a template for this function
		$this->skipRendering();
	}
	
	// Helper function to initialize RTE global variables needed by MiniEditor
	public function makeGlobalVariables() {
		$vars = array();

		$vars['wgIsArticle'] = false;

		// Need to call RTE::init to get Disabled reason (if any, usually preferences)
		$ep = new EditPage(new Article(new Title())); 
		RTE::init($ep);
		RTE::makeGlobalVariablesScript(&$vars);

		// If RTE is disabled, fall back to the mediawiki editor
		if (isset($vars['RTEDisabledReason'])) {
			$assetList = AssetsManager::getInstance()->getGroupCommonURL('mini_editor_js', array(), true, false); 
		} else {
			// JS/CSS assets for MiniEditor are loaded on demand via js which looks at this assetList variable
			if ($this->wg->DevelEnvironment) {
				$assetList = AssetsManager::getInstance()->getGroupCommonURL('mini_editor_rte_js', array(), true, false); 
			} else {
				$assetList = AssetsManager::getInstance()->getGroupCommonURL('mini_editor_rte_js'); 			
			}
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