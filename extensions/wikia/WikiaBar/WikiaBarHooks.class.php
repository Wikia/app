<?php

class WikiaBarHooks {
	private static $PROHIBITED_DBNAMES = array('answers');

	public static function onWikiFactoryVarChanged($cv_name, $city_id, $value) {
		$app = F::app();

		if (self::isWikiaBarConfig($city_id, $cv_name)) {
			Wikia::log(__METHOD__, '', 'Updating WikiaBar config caches after change');
			foreach ($value as $vertical => $languages) {
				foreach ($languages as $language => $content) {
					$dataMemcKey = wfSharedMemcKey('WikiaBarContents', $vertical, $language, WikiaBarModel::WIKIA_BAR_MCACHE_VERSION);
					Wikia::log(__METHOD__, '', 'Purging ' . $dataMemcKey);
					$app->wg->memc->set($dataMemcKey, null);
				}
			}
		}

		return true;
	}

	public static function onWFAfterErrorDetection($cv_id, $city_id, $cv_name, $cv_value, &$return, &$error) {
		wfProfileIn(__METHOD__);

		if (self::isWikiaBarConfig($city_id, $cv_name)) {
			/* @var $validator WikiaBarMessageDataValidator */
			$validator = new WikiaBarMessageDataValidator();
			$model = new WikiaBarModel();

			$errorCount = 0;
			$errors = array();
			if (is_array($cv_value)) {
				foreach ($cv_value as $vertical => $languages) {
					foreach ($languages as $language => $content) {
						$validator->clearErrors();
						$model->parseBarConfigurationMessage(trim($content), $validator);
						$messageErrorCount = $validator->getErrorCount();
						if ($messageErrorCount) {
							$errorMessages = $validator->getErrors();
							foreach ($errorMessages as &$errorMessage) {
								$errorMessage = Wikia::errormsg('vertical: ' . $vertical . ', language: ' . $language . ' : ' . $errorMessage);
							}
							$errors = array_merge($errors, $errorMessages);
							$errorCount += $messageErrorCount;
						}
					}
				}
			}

			if ($errorCount) {
				$error = $errorCount;
				$return = trim(implode("<br/>", $errors));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public static function onMakeGlobalVariablesScript(Array &$vars) {
		wfProfileIn(__METHOD__);

		$app = F::app();
		if( $app->wg->user->isAnon() ) {
			if (
				RequestContext::getMain()->getSkin()->getSkinName() == 'oasis'
				&& $app->wg->request->getText('action', 'view') == 'view'
				&& array_search($app->wg->dBname, self::$PROHIBITED_DBNAMES) === FALSE
			) {
				$vars['wgEnableWikiaBarExt'] = true;
			}
		} else {
			if(self::isWikiaBarSuppressedByExtensions()) {
				$vars['wgEnableWikiaBarExt'] = false;
			} else {
				$vars['wgEnableWikiaBarExt'] = true;
			}
		}
		$vars['wgEnableWikiaBarAds'] = true;
		$vars['wgWikiaBarMainLanguages'] = $app->wg->WikiaBarMainLanguages;

		wfProfileOut(__METHOD__);
		return true;
	}

	protected static function isWikiaBarConfig($city_id, $cv_name) {
		/* we're interested only in community Wiki */
		return ($city_id == WikiaBarModel::WIKIA_BAR_CONFIG_WIKI_ID && $cv_name == 'wgWikiaBarConfig');
	}

	public static function isWikiaBarSuppressedByExtensions() {
		$suppressed = F::app()->wg->atCreateNewWikiPage;
		return !empty($suppressed);
	}
}
