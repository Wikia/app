<?php

/**
 * Contains list of related resources and hooks which anticipate the use of Resource Loader, whenever that is released
 */
class UploadWizardHooks {

	/* We define scripts here for Resource Loader */

	public static $modules = array(
		// n.b. we tend not to use mediawiki.language functions, they are better implemented in mediawiki.language.parser.
		// however, loading mediawiki.language will a) create the namespace b) load the language files with convertPlural for the current language and all.
		'ext.uploadWizard' => array(
			'dependencies' => array(
				'jquery.autoEllipsis',
				'jquery.ui.core',
				'jquery.ui.dialog',
				'jquery.ui.datepicker',
				'jquery.ui.progressbar',
				'jquery.suggestions',
				'jquery.tipsy',
				'jquery.ui.widget',
				'mediawiki.language',
				'mediawiki.Uri',
				'mediawiki.util',
				'mediawiki.libs.jpegmeta',
				'mediawiki.jqueryMsg',
				'mediawiki.api',
				'mediawiki.api.edit',
				'mediawiki.api.category',
				'mediawiki.api.parse',
				'mediawiki.api.titleblacklist',
				'mediawiki.Title',
				'mediawiki.feedback'
			),
			'scripts' => array(
				// jquery interface helpers
				'resources/jquery/jquery.morphCrossfade.js',
				'resources/jquery/jquery.validate.js', // In trunk as of 1.19
				'resources/jquery/jquery.arrowSteps.js', // In trunk as of 1.19
				'resources/jquery/jquery.autocomplete.js',
				'resources/jquery/jquery.spinner.js', // In trunk as of 1.19
				'resources/jquery/jquery.removeCtrl.js',
				'resources/jquery/jquery.showThumbCtrl.js',
				'resources/jquery/jquery.pubsub.js',

				// common utilities
				'resources/mw.fileApi.js',
				'resources/mw.units.js',
				'resources/mw.canvas.js',
				'resources/mw.Log.js',
				'resources/mw.UtilitiesTime.js',
				'resources/mw.ErrorDialog.js',
				'resources/mw.ConfirmCloseWindow.js',

				// mediawiki-specific interface helper (relies on mediawiki globals)
				'resources/jquery/jquery.mwCoolCats.js',

				// wikimedia-comons specific title checker
				'resources/jquery/jquery.validate.wmCommonsBlacklist.js',

				// language menus
				'resources/mw.LanguageUpWiz.js',

				// workhorse libraries
				'resources/mw.IframeTransport.js',
				'resources/mw.ApiUploadHandler.js',
				'resources/mw.DestinationChecker.js',
				'resources/mw.UploadWizardUtil.js',

				// firefogg support libraries
				'resources/mw.Firefogg.js',
				'resources/mw.FirefoggHandler.js',
				'resources/mw.FirefoggTransport.js',

				//upload using FormData, large files in chunks
				'resources/mw.FormDataTransport.js',
				'resources/mw.ApiUploadFormDataHandler.js',

				// interface libraries
				'resources/mw.GroupProgressBar.js',

				// UploadWizard specific abstractions
				'resources/mw.UploadWizardDeed.js',
				'resources/mw.UploadWizardLicenseInput.js',

				// main library
				'resources/mw.UploadWizard.js',

				// main library components:
				'resources/mw.UploadWizardUpload.js',
				'resources/mw.UploadWizardDeed.js',
				'resources/mw.UploadWizardDescription.js',
				'resources/mw.UploadWizardDetails.js',
				'resources/mw.UploadWizardUploadInterface.js',


				// launcher
				'UploadWizardPage.js'
			),
			'styles' => array(
				'resources/uploadWizard.css',
				'resources/jquery/jquery.arrowSteps.css',
				'resources/jquery/jquery.mwCoolCats.css',
				'resources/jquery/jquery.removeCtrl.css',
				'resources/jquery/jquery.showThumbCtrl.css',
			),
			'messages' => array(
				'uploadwizard',
				'uploadwizard-desc',
				'mwe-upwiz-js-off',
				'mwe-upwiz-code-unknown',
				'mwe-upwiz-step-tutorial',
				'mwe-upwiz-step-file',
				'mwe-upwiz-step-deeds',
				'mwe-upwiz-step-details',
				'mwe-upwiz-step-thanks',
				'api-error-http',
				'api-error-ok-but-empty',
				'api-error-unknown-code',
				'api-error-uploaddisabled',
				'api-error-nomodule',
				'api-error-mustbeposted',
				'api-error-badaccess-groups',
				'api-error-stashfailed',
				'api-error-missingresult',
				'api-error-missingparam',
				'api-error-invalid-file-key',
				'api-error-copyuploaddisabled',
				'api-error-mustbeloggedin',
				'api-error-empty-file',
				'api-error-file-too-large',
				'api-error-filetype-missing',
				'api-error-filetype-banned',
				'api-error-filename-tooshort',
				'api-error-illegal-filename',
				'api-error-verification-error',
				'api-error-hookaborted',
				'api-error-unknown-error',
				'api-error-internal-error',
				'api-error-overwrite',
				'api-error-badtoken',
				'api-error-fetchfileerror',
				'api-error-duplicate',
				'api-error-duplicate-popup-title',
				'api-error-duplicate-archive',
				'api-error-duplicate-archive-popup-title',
				'api-error-unknown-warning',
				'api-error-timeout',
				'api-error-noimageinfo',
				'api-error-fileexists-shared-forbidden',
				'api-error-unclassified',
				'mwe-upwiz-api-warning-was-deleted',
				'mwe-upwiz-api-warning-exists',
				'mwe-upwiz-tutorial-error-localized-file-missing',
				'mwe-upwiz-tutorial-error-file-missing',
				'mwe-upwiz-tutorial-error-cannot-transform',
				'mwe-upwiz-help-desk',
				'mwe-upwiz-add-file-n',
				'mwe-upwiz-add-file-0-free',
				'mwe-upwiz-browse',
				'mwe-upwiz-transport-started',
				'mwe-upwiz-uploading',
				'mwe-upwiz-transported',
				'mwe-upwiz-stashed-upload',
				'mwe-upwiz-getting-metadata',
				'mwe-upwiz-submitting-details',
				'mwe-upwiz-published',
				'mwe-upwiz-failed',
				'mwe-upwiz-remove',
				'mwe-upwiz-remove-upload',
				'mwe-upwiz-remove-description',
				'mwe-upwiz-show-thumb',
				'mwe-upwiz-show-thumb-tip',
				'mwe-upwiz-upload',
				'mwe-upwiz-file-all-ok',
				'mwe-upwiz-file-some-failed',
				'mwe-upwiz-file-retry',
				'mwe-upwiz-next-file-despite-failures',
				'mwe-upwiz-skip-tutorial-future',
				'mwe-upwiz-file-all-failed',
				'mwe-upwiz-upload-count',
				'mwe-upwiz-progressbar-uploading',
				'mwe-upwiz-finished',
				'mwe-upwiz-secs-remaining',
				'mwe-upwiz-mins-secs-remaining',
				'mwe-upwiz-hrs-mins-secs-remaining',
				'mwe-upwiz-deeds-macro-prompt',
				'mwe-upwiz-deeds-custom-prompt',
				'mwe-upwiz-source-ownwork',
				'mwe-upwiz-source-ownwork-assert-any-license',
				'mwe-upwiz-source-ownwork-assert',
				'mwe-upwiz-source-ownwork-assert-custom',
				'mwe-upwiz-source-ownwork-assert-note',
				'mwe-upwiz-source-ownwork-assert-cc-by-sa-3.0',
				'mwe-upwiz-source-ownwork-cc-by-sa-3.0-explain',
				'mwe-upwiz-source-ownwork-assert-cc-by-3.0',
				'mwe-upwiz-source-ownwork-cc-by-3.0-explain',
				'mwe-upwiz-source-ownwork-assert-cc-zero',
				'mwe-upwiz-source-ownwork-cc-zero-explain',
				'mwe-upwiz-source-permission',
				'mwe-upwiz-source-thirdparty',
				'mwe-upwiz-source-thirdparty-intro',
				'mwe-upwiz-source-thirdparty-custom-multiple-intro',
				'mwe-upwiz-source-thirdparty-license',
				'mwe-upwiz-source-thirdparty-cases',
				'mwe-upwiz-source-thirdparty-accept',
				'mwe-upwiz-source-custom',
				'mwe-upwiz-more-options',
				'mwe-upwiz-fewer-options',
				'mwe-upwiz-desc',
				'mwe-upwiz-desc-add-n',
				'mwe-upwiz-desc-add-0',
				'mwe-upwiz-title',
				'mwe-upwiz-categories-intro',
				'mwe-upwiz-categories-another',
				'mwe-upwiz-media-type',
				'mwe-upwiz-date-created',
				'mwe-upwiz-location',
				'mwe-upwiz-location-lat',
				'mwe-upwiz-location-lon',
				'mwe-upwiz-location-alt',
				'mwe-upwiz-copyright-info',
				'mwe-upwiz-author',
				'mwe-upwiz-autoconverted',
				'mwe-upwiz-other',
				'mwe-upwiz-other-prefill',
				'mwe-upwiz-source',
				'mwe-upwiz-thanks-intro',
				'mwe-upwiz-thanks-explain',
				'mwe-upwiz-thanks-wikitext',
				'mwe-upwiz-thanks-url',
				'mwe-upwiz-upload-error-bad-extension-video-firefogg',
				'mwe-upwiz-upload-error-bad-filename-extension',
				'mwe-upwiz-upload-error-bad-filename-no-extension',
				'mwe-upwiz-upload-error-duplicate-filename-error',
				'mwe-upwiz-allowed-filename-extensions',
				'mwe-upwiz-help-allowed-filename-extensions',
				'mwe-upwiz-upload-error-duplicate',
				'mwe-upwiz-upload-error-stashed-anyway',
				'mwe-upwiz-ok',
				'mwe-upwiz-cancel',
				'mwe-upwiz-change',
				'mwe-upwiz-fileexists-replace',
				'mwe-upwiz-fileexists',
				'mwe-upwiz-fileexists-replace-on-page',
				'mwe-upwiz-fileexists-replace-no-link',
				'mwe-upwiz-blacklisted',
				'mwe-upwiz-thumbnail-more',
				'mwe-upwiz-overwrite',
				'mwe-upwiz-next',
				'mwe-upwiz-next-file',
				'mwe-upwiz-next-deeds',
				'mwe-upwiz-next-details',
				'mwe-upwiz-home',
				'mwe-upwiz-upload-another',
				'mwe-prevent-close',
				'mwe-upwiz-prevent-close',
				'mwe-upwiz-files-complete',
				'mwe-upwiz-tooltip-author',
				'mwe-upwiz-tooltip-source',
				'mwe-upwiz-tooltip-sign',
				'mwe-upwiz-tooltip-title',
				'mwe-upwiz-dialog-title',
				'mwe-upwiz-tooltip-description',
				'mwe-upwiz-tooltip-date',
				'mwe-upwiz-tooltip-categories',
				'mwe-upwiz-tooltip-other',
				'mwe-upwiz-tooltip-location',
				'mwe-upwiz-tooltip-more-info',
				'mwe-upwiz-file-need-file',
				'mwe-upwiz-deeds-need-deed',
				'mwe-upwiz-deeds-need-license',
				'mwe-upwiz-license-show-all',
				'mwe-upwiz-license-show-recommended',
				'mwe-upwiz-error-signature-blank',
				'mwe-upwiz-error-latitude',
				'mwe-upwiz-error-longitude',
				'mwe-upwiz-error-altitude',
				'mwe-upwiz-error-signature-too-long',
				'mwe-upwiz-error-signature-too-short',
				'mwe-upwiz-error-signature-bad-chars',
				'mwe-upwiz-error-blank',
				'mwe-upwiz-error-too-long',
				'mwe-upwiz-error-too-short',
				'mwe-upwiz-error-bad-chars',
				'mwe-upwiz-error-date',
				'mwe-upwiz-error-title-blacklisted',
				'mwe-upwiz-error-title-badchars',
				'mwe-upwiz-error-title-senselessimagename',
				'mwe-upwiz-error-title-hosting',
				'mwe-upwiz-error-title-thumbnail',
				'mwe-upwiz-error-title-fileexists-shared-forbidden',
				'mwe-upwiz-error-title-double-apostrophe',
				'mwe-upwiz-error-title-extension',
				'mwe-upwiz-error-license-wikitext-missing',
				'mwe-upwiz-error-license-wikitext-too-short',
				'mwe-upwiz-error-license-wikitext-too-long',
				'mwe-upwiz-error-license-wikitext-invalid',
				'mwe-upwiz-details-error-count',
				'mwe-upwiz-license-cc-by-sa-3.0',
				'mwe-upwiz-license-cc-by-sa-3.0-at',
				'mwe-upwiz-license-cc-by-sa-3.0-de',
				'mwe-upwiz-license-cc-by-sa-3.0-ee',
				'mwe-upwiz-license-cc-by-sa-3.0-es',
				'mwe-upwiz-license-cc-by-sa-3.0-hr',
				'mwe-upwiz-license-cc-by-sa-3.0-lu',
				'mwe-upwiz-license-cc-by-sa-3.0-nl',
				'mwe-upwiz-license-cc-by-sa-3.0-no',
				'mwe-upwiz-license-cc-by-sa-3.0-pl',
				'mwe-upwiz-license-cc-by-sa-3.0-ro',
				'mwe-upwiz-license-cc-by-3.0',
				'mwe-upwiz-license-cc-zero',
				'mwe-upwiz-license-cc-by-sa-2.5',
				'mwe-upwiz-license-cc-by-2.5',
				'mwe-upwiz-license-cc-by-sa-2.0',
				'mwe-upwiz-license-cc-by-2.0',
				'mwe-upwiz-license-custom',
				'mwe-upwiz-license-fal',
				'mwe-upwiz-license-own-pd',
				'mwe-upwiz-license-pd-old-100',
				'mwe-upwiz-license-pd-old',
				'mwe-upwiz-license-pd-art',
				'mwe-upwiz-license-pd-us',
				'mwe-upwiz-license-pd-usgov',
				'mwe-upwiz-license-pd-usgov-nasa',
				'mwe-upwiz-license-pd-usgov-military-navy',
				'mwe-upwiz-license-pd-ineligible',
				'mwe-upwiz-license-pd-ineligible-help',
				'mwe-upwiz-license-pd-textlogo',
				'mwe-upwiz-license-copyrighted-free-use',
				'mwe-upwiz-license-attribution',
				'mwe-upwiz-license-gfdl',
				'mwe-upwiz-license-cc-by-sa-3.0-gfdl',
				'mwe-upwiz-license-cc-by-3.0-gfdl',
				'mwe-upwiz-license-cc-head',
				'mwe-upwiz-license-cc-subhead',
				'mwe-upwiz-license-flickr-head',
				'mwe-upwiz-license-flickr-subhead',
				'mwe-upwiz-license-public-domain-usa-head',
				'mwe-upwiz-license-public-domain-usa-subhead',
				'mwe-upwiz-license-usgov-head',
				'mwe-upwiz-license-misc',
				'mwe-upwiz-license-custom-head',
				'mwe-upwiz-license-custom-subhead',
				'mwe-upwiz-license-custom-preview',
				'mwe-upwiz-license-none',
				'mwe-upwiz-license-none-head',
				'mwe-upwiz-license-confirm-remove',
				'mwe-upwiz-license-confirm-remove-title',
				'mwe-upwiz-license-external',
				'mwe-upwiz-license-external-invalid',
				'mwe-upwiz-categories',
				'mwe-upwiz-categories-add',
				'mwe-upwiz-category-remove',
				'mwe-upwiz-thanks-caption',
				'mwe-upwiz-help-popup',
				'mwe-upwiz-help-popup-title',
				'mwe-upwiz-thumbnail-failed',
				'mwe-upwiz-unparseable-filename',
				'mwe-upwiz-image-preview',
				'mwe-upwiz-subhead-message',
				'mwe-upwiz-subhead-bugs',
				'mwe-upwiz-subhead-translate',
				'mwe-upwiz-subhead-alt-upload',
				'mwe-upwiz-feedback-prompt',
				'mwe-upwiz-feedback-note',
				'mwe-upwiz-feedback-subject',
				'mwe-upwiz-feedback-message',
				'mwe-upwiz-feedback-title',
				'mwe-upwiz-feedback-cancel',
				'mwe-upwiz-feedback-submit',
				'mwe-upwiz-feedback-adding',
				'mwe-upwiz-feedback-error1',
				'mwe-upwiz-feedback-error2',
				'mwe-upwiz-feedback-error3',
				'mwe-upwiz-feedback-blacklist-report-prompt',
				'mwe-upwiz-feedback-blacklist-info-prompt',
				'mwe-upwiz-feedback-blacklist-line-intro',
				'mwe-upwiz-feedback-blacklist-subject',
				'mwe-upwiz-errordialog-title',
				'mwe-upwiz-errordialog-ok',
 				'size-gigabytes',
 				'size-megabytes',
 				'size-kilobytes',
 				'size-bytes',
				'mw-coolcats-confirm-new-title',
				'mw-coolcats-confirm-new',
				'mw-coolcats-confirm-new-ok',
				'mw-coolcats-confirm-new-cancel',
				'wm-license-cc-by-sa-3.0-at-text',
				'wm-license-cc-by-sa-3.0-de-text',
				'wm-license-cc-by-sa-3.0-ee-text',
				'wm-license-cc-by-sa-3.0-es-text',
				'wm-license-cc-by-sa-3.0-hr-text',
				'wm-license-cc-by-sa-3.0-lu-text',
				'wm-license-cc-by-sa-3.0-nl-text',
				'wm-license-cc-by-sa-3.0-no-text',
				'wm-license-cc-by-sa-3.0-pl-text',
				'wm-license-cc-by-sa-3.0-ro-text',
				'mwe-upwiz-too-many-files-ok',
				'mwe-upwiz-too-many-files-text',
				'mwe-upwiz-too-many-files',
			),
			'group' => 'ext.uploadWizard'
		),
		'ext.uploadWizard.tests' => array(
			'scripts' => array(
				'resources/mw.MockUploadHandler.js'
			),
		),
		'ext.uploadWizard.campaigns' => array(
			'scripts' => array(
				'resources/ext.upwiz.campaigns.js'
			),
			'messages' => array(
				'mwe-upwiz-campaigns-delete-failed',
				'mwe-upwiz-campaigns-confirm-delete',
			),
		),
	);

	/**
	 * ResourceLoaderRegisterModules hook
	 *
	 * Adds modules to ResourceLoader
	 */
	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath, $wgUploadWizardDisableResourceLoader;
		if ( $wgUploadWizardDisableResourceLoader ) {
			return true;
		}

		$localpath = dirname( __FILE__ );
		$remotepath = "$wgExtensionAssetsPath/UploadWizard";
		foreach ( self::$modules as $name => $resources ) {
			$resourceLoader->register( $name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath ) );
		}
		return true;
	}

	public static function CanonicalNamespaces( array $namespaces ) {
		global $wgNamespaceAliases;
		// add proper aliases for NS_FILE, otherwise an error is being thrown
		// in combined.min.js when the content language code is not 'en':
		// "unrecognized namespace=File" due to undefiled 'File' key in wgNamespaceIds
		if ( !isset( $wgNamespaceAliases['File'] ) ) {
			$wgNamespaceAliases['File'] = NS_FILE;
		}
		if ( !isset( $wgNamespaceAliases['File_talk'] ) ) {
			$wgNamespaceAliases['File_talk'] = NS_FILE_TALK;
		}
		return true;
	}

	/**
	 * Schema update to set up the needed database tables.
	 *
	 * @since 1.2
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onSchemaUpdate( /* DatabaseUpdater */ $updater = null ) {
		$updater->addExtensionTable( 'uw_campaigns', dirname( __FILE__ ) . '/UploadWizard.sql' );
		$updater->addExtensionUpdate( array(
			'addIndex',
			'uw_campaigns',
			'uw_campaigns_name',
			dirname( __FILE__ ) . '/sql/UW_IndexCampaignsName.sql',
			true
		) );
		$updater->addExtensionUpdate( array(
			'addIndex',
			'uw_campaign_conf',
			'uw_cc_id_property',
			dirname( __FILE__ ) . '/sql/UW_IndexConfIdProp.sql',
			true
		) );
		$updater->addExtensionUpdate( array(
			'addIndex',
			'uw_campaign_conf',
			'uw_cc_property',
			dirname( __FILE__ ) . '/sql/UW_IndexConfProp.sql',
			true
		) );

		return true;
	}
	
	/**
	 * Adds the preferences of UploadWizard to the list of available ones.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/GetPreferences
	 *
	 * @since 1.2
	 *
	 * @param User $user
	 * @param array $preferences
	 *
	 * @return true
	 */
	public static function onGetPreferences( User $user, array &$preferences ) {
		if ( UploadWizardConfig::getSetting( 'enableLicensePreference' ) ) {
			$licenseConfig = UploadWizardConfig::getSetting( 'licenses' );
			
			$licenses = array();

			$ownWork = UploadWizardConfig::getSetting( 'licensesOwnWork' );
			foreach ( $ownWork['licenses'] as $license ) {
				$licenseMessage = self::getLicenseMessage( $license, $licenseConfig );
				$licenses[wfMsgExt( 'mwe-upwiz-prefs-license-own', 'parsemag', $licenseMessage )] = 'ownwork-' . $license;
			}
			
			foreach ( UploadWizardConfig::getThirdPartyLicenses() as $license ) {
				if ( $license !== 'custom' ) {
					$licenseMessage = self::getLicenseMessage( $license, $licenseConfig );
					$licenses[wfMsgExt( 'mwe-upwiz-prefs-license-thirdparty', 'parsemag', $licenseMessage )] = 'thirdparty-' . $license;
				}
			}
			
			$licenses = array_merge( array( wfMsg( 'mwe-upwiz-prefs-def-license-def' ) => 'default' ), $licenses );
			
			$preferences['upwiz_deflicense'] = array(
				'type' => 'radio',
				'label-message' => 'mwe-upwiz-prefs-def-license',
				// Wikia change - begin - @author: wladek
				// Move "Default license" to "Under the Hood" tab (BugId: 34179)
				'section' => 'under-the-hood',
				// Wikia change - end
				'options' => $licenses
			);
		}

		return true;
	}
	
	/**
	 * Helper function to get the message for a license.
	 * 
	 * @since 1.2
	 * 
	 * @param string $licenseName
	 * @param array $licenseConfig
	 * 
	 * @return string
	 */
	public static function getLicenseMessage( $licenseName, array $licenseConfig ) {
		if ( array_key_exists( 'url', $licenseConfig[$licenseName] ) ) {
			return wfMsgExt( $licenseConfig[$licenseName]['msg'], 'parseinline', '', $licenseConfig[$licenseName]['url'] );
		}
		else {
			return wfMsg( $licenseConfig[$licenseName]['msg'] );
		}
	}

}
