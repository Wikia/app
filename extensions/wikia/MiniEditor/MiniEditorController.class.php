<?php

class MiniEditorController extends WikiaController {

	// Should be called once for any extension that wants to use MiniEditor
	public function Setup() {
		OasisController::addBodyClass('MiniEditor');
	}

	/**
	 * Load MiniEditor css and js dependencies
	 * extensions can add more assets to be loaded AFTER the MiniEditor assets
	 * this entire bundle of js vars and assets can be loaded in-page or via makeGlobalVariables (below)
	 *
	 * @request type array additionalAssets
	 * @request type boolean loadOnDemand
	 * @request type array loadOnDemandAssets
	 */
	public function loadAssets() {
		$loadStyles = $this->request->getVal('loadStyles', true);
		$loadOnDemand = $this->request->getVal('loadOnDemand', false);
		$additionalAssets = $this->request->getVal('additionalAssets', array());

		// FIXME: load JSMessages for VET and WMU extensions here too
		// FIXME: must refactor VET and WMU to use JSMessages first
		JSMessages::enqueuePackage('EditPageLayout', JSMessages::EXTERNAL);

		// If this function got called, MiniEditor is enabled
		$this->response->setJSVar('wgEnableMiniEditorExt', true);

		// Create a JS variable to let us know if we are loading on demand or not
		$this->response->setJsVar('wgMiniEditorLoadOnDemand', $loadOnDemand);

		// If styles are not loaded here, they must be loaded in JavaScript
		if ($loadStyles) {
			$this->response->addAsset('extensions/wikia/MiniEditor/css/MiniEditor.scss');
		}

		// Loading assets on demand
		if ($loadOnDemand) {

			// Export a list of assets to javascript for future dynamic loading
			$this->response->setJsVar('wgMiniEditorAssets', $this->request->getVal('loadOnDemandAssets', array()));

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

			// Don't include wgMiniEditorAssets in global page vars
			unset($jsvars['wgMiniEditorAssets']);

			// Set the rest of our global JS vars
			foreach ($jsvars as $var => $value) {
				$this->response->setJsVar($var, $value);
			}
		}

		// Additional assets
		foreach($additionalAssets as $asset) {
			$this->response->addAsset($asset);
		}

		// No visible output from this module for now so we don't need a template for this function
		$this->skipRendering();
	}

	// Helper function to initialize RTE global variables needed by MiniEditor
	public function makeGlobalVariables() {
		$app = F::app();
		$vars = array();

		// RTE has been disabled but minieditor is enabled.  probably shouldn't be allowed to happen
		if ( !class_exists('RTE') ) {
			$vars['RTEDisabledReason'] = 'sitedisabled';
		} else {
			// Need to call RTE::init to get Disabled reason (if any, usually preferences)
			$ep = new EditPage(new Article(new Title()));
			RTE::init($ep);
			RTE::makeGlobalVariablesScript($vars);  // pass by reference
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

		// Save our asset list for loading in JavaScript
		$vars['wgMiniEditorAssets'] = $assetList;

		// EditPage needs to know if this is an article page, and it is not.
		$vars['wgIsArticle'] = false;

		// Image uploading can only happen on action=edit pages, make it so.
		$vars['wgAction'] = 'edit';

		// Extensions use hooks to load their setup only on edit pages (VideoEmbedTool, WikiaMiniUploader)
		// To load ONLY the vars we need and not all of them we will call the setup functions directly
		if ($app->wg->EnableVideoToolExt) {
			VETSetupVars($vars);  // pass by reference
		}
		if ($app->wg->EnableWikiaMiniUploadExt) {
			WMUSetupVars($vars);  // pass by reference
		}

		$vars['showAddVideoBtn'] = $app->wg->User->isAllowed('videoupload');

		$this->response->setData($vars);
	}
}
