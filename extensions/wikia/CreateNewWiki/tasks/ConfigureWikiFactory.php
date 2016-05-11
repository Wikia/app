<?php

namespace Wikia\CreateNewWiki\Tasks;

class ConfigureWikiFactory implements Task {

	const DEFAULT_WIKI_LOGO = '$wgUploadPath/b/bc/Wiki.png';

	private $taskContext;

	public function __construct(TaskContext $taskContext) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		$this->mNewWiki->images_url = $this->prepareDirValue( $this->mNewWiki->name, $this->mNewWiki->language );
		$this->mNewWiki->images_dir = sprintf("%s/%s", strtolower( substr( $this->mNewWiki->name, 0, 1 ) ), $this->mNewWiki->images_url );

		if ( isset( $this->mNewWiki->language ) && $this->mNewWiki->language !== "en" ) {
			if ( $this->mLangSubdomain ) {
				$this->mNewWiki->subdomain  = strtolower( $this->mNewWiki->language ) . "." . $this->mNewWiki->name;
				$this->mNewWiki->redirect  = strtolower( $this->mNewWiki->language ) . "." . ucfirst( $this->mNewWiki->name );
			}
			$this->mNewWiki->images_url .= "/" . strtolower( $this->mNewWiki->language );
			$this->mNewWiki->images_dir .= "/" . strtolower( $this->mNewWiki->language );
		}

		$this->mNewWiki->images_dir = self::IMGROOT  . $this->mNewWiki->images_dir . "/images";
		$this->mNewWiki->images_url = self::IMAGEURL . $this->mNewWiki->images_url . "/images";

		//SET imagesURL
		//SET imagesDIR
	}

	public function check() {
	}

	public function run() {
		$this->setVariables();
	}

	private function setVariables() {
		$siteName = $this->taskContext->getSiteName();

		$wikiFactoryVariables = [
			'wgSitename' => $siteName,
			'wgLogo' => self::DEFAULT_WIKI_LOGO,
			'wgUploadPath' => $this->imagesURL,
			'wgUploadDirectory' => $this->imagesDir,
			'wgDBname' => $this->taskContext->getDbName(),
			'wgLocalInterwiki' => $this->taskContext->getSiteName(),
			'wgLanguageCode' => $this->taskContext->getLanguage(),
			'wgServer' => rtrim( $this->taskContext->getURL(), "/" ),
			'wgEnableSectionEdit' => true,
			'wgEnableSwiftFileBackend' => true,
			'wgOasisLoadCommonCSS' => true,
			'wgEnablePortableInfoboxEuropaTheme' => true
		];

		// rt#60223: colon allowed in sitename, breaks project namespace
		// Set wgMetaNamespace
		if( mb_strpos( $siteName, ':' ) !== false ) {
			$wikiFactoryVariables['wgMetaNamespace'] = str_replace( [ ':', ' ' ], [ '', '_' ], $siteName );
		}

		// Set wgDBcluster
		if ( TaskContext::ACTIVE_CLUSTER ) {
			wfGetLBFactory()->sectionsByDB[ $this->taskContext->getDbName() ] = $wikiFactoryVariables['wgDBcluster'] = TaskContext::ACTIVE_CLUSTER;
		}

		$wikiDBW = $this->taskContext->getWikiDBW();

		$oRes = $wikiDBW->select(
			"city_variables_pool",
			[ "cv_id, cv_name" ],
			[ "cv_name in ('" . implode( "', '", array_keys( $wikiFactoryVariables ) ) . "')" ],
			__METHOD__
		);

		$wikiFactoryVarsFromDB = [ ];

		while ( $oRow = $wikiDBW->fetchObject( $oRes ) ) {
			$wikiFactoryVarsFromDB[ $oRow->cv_name ] = $oRow->cv_id;
		}
		$wikiDBW->freeResult( $oRes );

		foreach( $wikiFactoryVariables as $variable => $value ) {
			/**
			 * first, get id of variable
			 */
			$cv_id = 0;
			if ( isset( $wikiFactoryVarsFromDB[$variable] ) ) {
				$cv_id = $wikiFactoryVarsFromDB[$variable];
			}

			/**
			 * then, insert value for wikia
			 */
			if( !empty($cv_id) ) {
				$wikiDBW->insert(
					"city_variables",
					array(
						"cv_value" => serialize( $value ),
						"cv_city_id" => $this->taskContext->getCityId(),
						"cv_variable_id" => $cv_id
					),
					__METHOD__
				);
			}
		}
	}
}
