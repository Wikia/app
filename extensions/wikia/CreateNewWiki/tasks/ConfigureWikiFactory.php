<?php

namespace Wikia\CreateNewWiki\Tasks;

use WikiFactory;

class ConfigureWikiFactory implements Task
{

	const DEFAULT_WIKI_LOGO = '$wgUploadPath/b/bc/Wiki.png';
	const SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH = 55;
	const IMGROOT = "/images/";
	const IMAGEURL = "http://images.wikia.com/";

	private $taskContext;
	private $imagesURL;
	private $imagesDir;

	public function __construct(TaskContext $taskContext)
	{
		$this->taskContext = $taskContext;
	}

	public function prepare()
	{
		$language = $this->taskContext->getLanguage();

		$this->imagesURL = $this->prepareDirValue($this->taskContext->getWikiName(), $language);
		$this->imagesDir = sprintf("%s/%s", strtolower(substr($this->taskContext->getWikiName(), 0, 1)), $this->imagesURL);

		if (isset($language) && $language !== "en") {
			$this->imagesURL .= "/" . strtolower($language);
			$this->imagesDir .= "/" . strtolower($language);
		}

		$this->imagesDir = self::IMGROOT . $this->imagesDir . "/images";
		$this->imagesURL = self::IMAGEURL . $this->imagesURL . "/images";
	}

	public function check() {
	}

	public function run() {
		$this->setVariables();
	}

	private function setVariables() {
		wfDebugLog( "createwiki", "Tasks/ConfigureWikiFactory: Populating city_variables\n", true );
		$siteName = $this->taskContext->getSiteName();

		$wikiFactoryVariables = [
			'wgSitename' => $siteName,
			'wgLogo' => self::DEFAULT_WIKI_LOGO,
			'wgUploadPath' => $this->imagesURL,
			'wgUploadDirectory' => $this->imagesDir,
			'wgDBname' => $this->taskContext->getDbName(),
			'wgLocalInterwiki' => $this->taskContext->getSiteName(),
			'wgLanguageCode' => $this->taskContext->getLanguage(),
			'wgServer' => rtrim($this->taskContext->getURL(), "/"),
			'wgEnableSectionEdit' => true,
			'wgEnableSwiftFileBackend' => true,
			'wgOasisLoadCommonCSS' => true,
			'wgEnablePortableInfoboxEuropaTheme' => true
		];

		// rt#60223: colon allowed in sitename, breaks project namespace
		// Set wgMetaNamespace
		if (mb_strpos($siteName, ':') !== false) {
			$wikiFactoryVariables['wgMetaNamespace'] = str_replace([':', ' '], ['', '_'], $siteName);
		}

		// Set wgDBcluster
		if (TaskContext::ACTIVE_CLUSTER) {
			wfGetLBFactory()->sectionsByDB[$this->taskContext->getDbName()] = $wikiFactoryVariables['wgDBcluster'] = TaskContext::ACTIVE_CLUSTER;
		}

		$sharedDBW = $this->taskContext->getSharedDBW();

		$oRes = $sharedDBW->select(
			"city_variables_pool",
			["cv_id, cv_name"],
			["cv_name in ('" . implode("', '", array_keys($wikiFactoryVariables)) . "')"],
			__METHOD__
		);

		$wikiFactoryVarsFromDB = [];

		while ($oRow = $sharedDBW->fetchObject($oRes)) {
			$wikiFactoryVarsFromDB[$oRow->cv_name] = $oRow->cv_id;
		}
		$sharedDBW->freeResult($oRes);

		foreach ($wikiFactoryVariables as $variable => $value) {
			/**
			 * first, get id of variable
			 */
			$cv_id = 0;
			if (isset($wikiFactoryVarsFromDB[$variable])) {
				$cv_id = $wikiFactoryVarsFromDB[$variable];
			}

			/**
			 * then, insert value for wikia
			 */
			if (!empty($cv_id)) {
				$sharedDBW->insert(
					"city_variables",
					array(
						"cv_value" => serialize($value),
						"cv_city_id" => $this->taskContext->getCityId(),
						"cv_variable_id" => $cv_id
					),
					__METHOD__
				);
			}
		}

		$sharedDBW->commit( __METHOD__ ); // commit shared DB changes
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
	 * @return string
	 */
	private function prepareDirValue($name, $language) {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": Checking {$name} folder");

		$isExist = false;
		$suffix = "";
		$dir_base = self::sanitizeS3BucketName($name);
		$prefix = strtolower(substr($dir_base, 0, 1));
		$dir_lang = (isset($language) && $language !== "en")
			? "/" . strtolower($language)
			: "";

		while ($isExist == false) {
			$dirName = self::IMGROOT . $prefix . "/" . $dir_base . $suffix . $dir_lang . "/images";

			if (self::wgUploadDirectoryExists($dirName)) {
				$suffix = rand(1, 9999);
			} else {
				$dir_base = $dir_base . $suffix;
				$isExist = true;
			}
		}

		wfDebug(__METHOD__ . ": Returning '{$dir_base}'\n");
		wfProfileOut(__METHOD__);
		return $dir_base;
	}

	public static function wgUploadDirectoryExists($sDirectoryName) {
		wfProfileIn(__METHOD__);
		$iVarId = WikiFactory::getVarIdByName('wgUploadDirectory');

		// Crash immediately if $iVarId is not a positive integer!
		\Wikia\Util\Assert::true($iVarId);

		$aCityIds = WikiFactory::getCityIDsFromVarValue($iVarId, $sDirectoryName, '=');
		wfProfileOut(__METHOD__);
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
	private static function sanitizeS3BucketName($name) {
		if ($name == 'admin') {
			$name .= 'x';
		}

		$RE_VALID = "/^[a-z0-9](?:[-_a-z0-9]{0,53}[a-z0-9])?(?:[a-z0-9](?:\\.[-_a-z0-9]{0,53}[a-z0-9])?)*\$/";
		# check if it's already valid
		$name = mb_strtolower($name);
		if (preg_match($RE_VALID, $name) && strlen($name) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH) {
			return $name;
		}

		# try fixing the simplest and most popular cases
		$check_name = str_replace(['.', ' ', '(', ')'], '_', $name);
		if (in_array(substr($check_name, -1), ['-', '_'])) {
			$check_name .= '0';
		}
		if (preg_match($RE_VALID, $check_name) && strlen($check_name) <= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH) {
			return $check_name;
		}

		# replace invalid ASCII characters with their hex values
		$s = '';
		for ($i = 0; $i < strlen($name); $i++) {
			$c = $name[$i];
			if ($c >= 'a' && $c <= 'z' || $c >= '0' && $c <= '9') {
				$s .= $c;
			} else {
				$s .= bin2hex($c);
			}
			if (strlen($s) >= self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH) {
				break;
			}
		}
		$name = substr($s, 0, self::SANITIZED_BUCKET_NAME_MAXIMUM_LENGTH);

		return $name;
	}
}
