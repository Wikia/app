<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;
use WikiFactory;

class ConfigureWikiFactory extends Task {
	use Loggable;

	const DEFAULT_WIKI_LOGO = '$wgUploadPath/b/bc/Wiki.png';
	const SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH = 55;
	const IMGROOT = "/images/";
	const IMAGEURL = "http://images.wikia.com/";

	public $imagesURL;
	public $imagesDir;

	public function prepare() {
		$language = $this->taskContext->getLanguage();
		$wikiName = $this->taskContext->getWikiName();
		$wgUploadDirectoryVarId = $this->getWgUploadDirectoryVarId();

		if ( empty($wgUploadDirectoryVarId) ) {
			return TaskResult::createForError(
				"wgUploadDirectory variable is not a positive integer, wgUploadDirectory: {$wgUploadDirectoryVarId}"
			);
		}

		$this->imagesURL = $this->prepareDirValue( $wikiName, $language, $wgUploadDirectoryVarId );
		$this->imagesDir = sprintf( "%s/%s", strtolower( substr( $wikiName, 0, 1 ) ), $this->imagesURL );

		if ( isset($language) && $language !== "en" ) {
			$this->imagesURL .= "/" . strtolower( $language );
			$this->imagesDir .= "/" . strtolower( $language );
		}

		$this->imagesDir = self::IMGROOT . $this->imagesDir . "/images";
		$this->imagesURL = self::IMAGEURL . $this->imagesURL . "/images";

		return TaskResult::createForSuccess();
	}

	public function run() {
		$siteName = $this->taskContext->getSiteName();
		$dbName = $this->taskContext->getDbName();
		$language = $this->taskContext->getLanguage();
		$sharedDBW = $this->taskContext->getSharedDBW();
		$cityId = $this->taskContext->getCityId();
		$url = $this->taskContext->getURL();

		$staticWikiFactoryVariables = $this->getStaticVariables(
			$siteName, $this->imagesURL, $this->imagesDir, $dbName, $language, $url
		);
		$wikiFactoryVariablesFromDB = $this->getVariablesFromDB( $sharedDBW, $staticWikiFactoryVariables );

		$this->setVariables( $sharedDBW, $cityId, $wikiFactoryVariablesFromDB, $staticWikiFactoryVariables );

		return TaskResult::createForSuccess();
	}

	public function getStaticVariables( $siteName, $imagesURL, $imagesDir, $dbName, $language, $url ) {
		global $wgCreateDatabaseActiveCluster;
		$wikiFactoryVariables = [
			'wgSitename' => $siteName,
			'wgLogo' => self::DEFAULT_WIKI_LOGO,
			'wgUploadPath' => $imagesURL,
			'wgUploadDirectory' => $imagesDir,
			'wgDBname' => $dbName,
			'wgLocalInterwiki' => $siteName,
			'wgLanguageCode' => $language,
			'wgServer' => rtrim( $url, "/" ),
			'wgEnableSectionEdit' => true,
			'wgEnableSwiftFileBackend' => true,
			'wgOasisLoadCommonCSS' => true,
			'wgEnablePortableInfoboxEuropaTheme' => true
		];

		// rt#60223: colon allowed in sitename, breaks project namespace
		// Set wgMetaNamespace
		if ( mb_strpos( $siteName, ':' ) !== false ) {
			$wikiFactoryVariables['wgMetaNamespace'] = str_replace( [ ':', ' ' ], [ '', '_' ], $siteName );
		}

		wfGetLBFactory()->sectionsByDB[$dbName] = $wikiFactoryVariables['wgDBcluster'] = $wgCreateDatabaseActiveCluster;

		return $wikiFactoryVariables;
	}

	public function getVariablesFromDB( $sharedDBW, $wikiFactoryVariables ) {
		wfProfileIn( __METHOD__ );

		$oRes = $sharedDBW->select(
			"city_variables_pool",
			[ "cv_id, cv_name" ],
			[ "cv_name in ('" . implode( "', '", array_keys( $wikiFactoryVariables ) ) . "')" ],
			__METHOD__
		);

		$wikiFactoryVarsFromDB = [ ];

		while ( $oRow = $sharedDBW->fetchObject( $oRes ) ) {
			$wikiFactoryVarsFromDB[$oRow->cv_name] = $oRow->cv_id;
		}
		$sharedDBW->freeResult( $oRes );

		wfProfileOut( __METHOD__ );

		return $wikiFactoryVarsFromDB;
	}

	private function setVariables( $sharedDBW, $cityId, $wikiFactoryVariablesFromDB, $wikiFactoryVariables ) {
		wfProfileIn( __METHOD__ );
		foreach ( $wikiFactoryVariables as $variable => $value ) {
			/**
			 * first, get id of variable
			 */
			$cvId = 0;
			if ( isset($wikiFactoryVariablesFromDB[$variable]) ) {
				$cvId = $wikiFactoryVariablesFromDB[$variable];
			}

			/**
			 * then, insert value for wikia
			 */
			if ( !empty($cvId) ) {
				$sharedDBW->insert(
					"city_variables",
					[
						"cv_value" => serialize( $value ),
						"cv_city_id" => $cityId,
						"cv_variable_id" => $cvId
					],
					__METHOD__
				);
			}
		}

		$sharedDBW->commit( __METHOD__ ); // commit shared DB changes
		wfProfileOut( __METHOD__ );
	}

	/**
	 * "calculates" the value for wgUploadDirectory
	 *
	 * @access private
	 * @author Piotr Molski (Moli)
	 *
	 * @param $name string base name of the directory
	 * @param $language string language in which wiki will be created
	 *
	 * @param $wgUploadDirectoryVarId
	 * @return string
	 */
	public function prepareDirValue( $name, $language, $wgUploadDirectoryVarId ) {
		wfProfileIn( __METHOD__ );

		$this->debug( implode( ":", [ __METHOD__ . "Checking {$name} folder" ] ) );

		$isExist = false;
		$suffix = "";
		$dirBase = self::sanitizeS3BucketName( $name );
		$prefix = strtolower( substr( $dirBase, 0, 1 ) );
		$dirLang = (isset($language) && $language !== "en")
			? "/" . strtolower( $language )
			: "";

		while ( $isExist == false ) {
			$dirName = self::IMGROOT . $prefix . "/" . $dirBase . $suffix . $dirLang . "/images";

			if ( $this->wgUploadDirectoryExists( $dirName, $wgUploadDirectoryVarId ) ) {
				$suffix = rand( 1, 9999 );
			} else {
				$dirBase = $dirBase . $suffix;
				$isExist = true;
			}
		}

		$this->debug( implode( ":", [ __METHOD__, "Returning '{$dirBase}'" ] ) );

		wfProfileOut( __METHOD__ );
		return $dirBase;
	}

	public function wgUploadDirectoryExists( $sDirectoryName, $varId ) {
		wfProfileIn( __METHOD__ );

		$aCityIds = WikiFactory::getCityIDsFromVarValue( $varId, $sDirectoryName, '=' );

		wfProfileOut( __METHOD__ );
		return !empty($aCityIds);
	}

	/**
	 * Sanitizes a name to be a valid S3 bucket name. It means it can contain only letters and numbers
	 * and optionally hyphens in the middle. Maximum length is 63 characters, we're trimming it to 55
	 * characters here as some random suffix may be added to solve duplicates.
	 *
	 * Note that different arguments may lead to the same results so the conflicts need to be solved
	 * at a later stage of processing.
	 *
	 * @see http://docs.aws.amazon.com/AmazonS3/latest/dev/BucketRestrictions.html
	 *      Wikia change: We accept underscores wherever hyphens are allowed.
	 *
	 * @param $name string Directory name
	 * @return string Sanitized name
	 */
	private static function sanitizeS3BucketName( $name ) {
		if ( $name == 'admin' ) {
			$name .= 'x';
		}

		$RE_VALID = "/^[a-z0-9](?:[-_a-z0-9]{0,53}[a-z0-9])?(?:[a-z0-9](?:\\.[-_a-z0-9]{0,53}[a-z0-9])?)*\$/";
		# check if it's already valid
		$name = mb_strtolower( $name );
		if ( preg_match( $RE_VALID, $name ) && strlen( $name ) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
			return $name;
		}

		# try fixing the simplest and most popular cases
		$checkName = str_replace( [ '.', ' ', '(', ')' ], '_', $name );
		if ( in_array( substr( $checkName, -1 ), [ '-', '_' ] ) ) {
			$checkName .= '0';
		}
		if ( preg_match( $RE_VALID, $checkName ) && strlen( $checkName ) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
			return $checkName;
		}

		# replace invalid ASCII characters with their hex values
		$s = '';
		for ( $i = 0; $i < strlen( $name ); $i++ ) {
			$c = $name[$i];
			if ( $c >= 'a' && $c <= 'z' || $c >= '0' && $c <= '9' ) {
				$s .= $c;
			} else {
				$s .= bin2hex( $c );
			}
			if ( strlen( $s ) >= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH ) {
				break;
			}
		}
		$name = substr( $s, 0, self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH );

		return $name;
	}

	public function getWgUploadDirectoryVarId() {
		return WikiFactory::getVarIdByName( 'wgUploadDirectory' );
	}
}
