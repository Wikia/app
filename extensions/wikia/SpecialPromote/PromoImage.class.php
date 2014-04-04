<?php

/**
 * Helper class for handling images used for promotion
 *
 *
 */

class PromoImage extends WikiaObject {
	const __MAIN_IMAGE_BASE_NAME = 'Wikia-Visualization-Main';
	const __ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const __IMAGES_EXT = '.png';

	const INVALID = -1;
	const MAIN = 0;
	const ADDITIONAL_1 = 1;
	const ADDITIONAL_2 = 2;
	const ADDITIONAL_3 = 3;
	const ADDITIONAL_4 = 4;
	const ADDITIONAL_5 = 5;
	const ADDITIONAL_6 = 6;
	const ADDITIONAL_7 = 7;
	const ADDITIONAL_8 = 8;
	const ADDITIONAL_9 = 9;

	static public function listAllAdditionalTypes() {
		return array(1, 2, 3, 4, 5, 6, 7, 8, 9); //ADDITIONAL_1 to ADDITIONAL_9
	}

	static public function fromPathname($pathString){
		$type = self::inferType($pathString, $dbName);
		return new PromoImage($type, $dbName);
	}

	static public function makePathname($type, $dbName = null) {
		$obj = new self($type, $dbName);
		return $obj->pathname();
	}

	public function __construct($type, $dbName = null) {
		parent::__construct();
		$this->dbName = $dbName;
		$this->type = $type;
		$this->fileChanged = false;
	}

	public function isType($type){
		return $this->type === $type;
	}
	public function getType(){
		return $this->type;
	}

	public function setDBName($dbName) {
		$this->dbName = $dbName;
		return $this;
	}

	public function setCityId($cityId) {
		$this->dbName = WikiFactory::IDtoDB( $cityId );
		return $this;
	}

	protected function pathnameHelper($withDbName = true, $withExtension = true){
		if ($this->isType(self::MAIN)){
			$path = self::__MAIN_IMAGE_BASE_NAME;
		} else {
			$path = self::__ADDITIONAL_IMAGES_BASE_NAME . "-" . $this->type;
		}
		if (!empty($this->dbName) and $withDbName) {
			$path .= ',' . $this->dbName;
		}
		if ($withExtension) {
			$path .= self::__IMAGES_EXT;
		}
		return $path;
	}

	public function pathname(){
		return $this->pathnameHelper(true, true);
	}

	public function corporateFileByLang($lang){
		$wiki_id = (new WikiaCorporateModel())->getCorporateWikiIdByLang($lang);
		return GlobalFile::newFromText($this->pathname(), $wiki_id);
	}

	public function isFileChanged(){
		return !empty($this->fileChanged);
	}

	public function processUploadedFile($srcFileName) {
		// uploaded fileName that matches through infer type, means that
		// file was not really uploaded, and was already present in DB
		// FIXME: this mechanism is hacky, it should be more durable than string matching
		if ($this->inferType($srcFileName) == self::INVALID) {
			$this->fileChanged = true;

			$dst_file_title = Title::newFromText($this->pathname(), NS_FILE);

			$temp_file = RepoGroup::singleton()->getLocalRepo()->getUploadStash()->getFile($srcFileName);
			$file = new LocalFile($dst_file_title, RepoGroup::singleton()->getLocalRepo());

			$file->upload($temp_file->getPath(), '', '');
			$temp_file->remove();
		}
		return $this;
	}

	protected function deleteImageHelper($imageName) {
		$title = Title::newFromText($imageName, NS_FILE);
		$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());

		$visualization = new CityVisualization();
		$visualization->removeImageFromReview($this->wg->cityId, $title->getArticleId(), $this->wg->contLang->getCode());

		if ($file->exists()) {
			$file->delete('no longer needed');
		}
	}

	protected function removalTaskHelper($imageName) {

		if( !empty($deletedFiles) ) {
			$visualization = new CityVisualization();

			$content_lang = $this->wg->contLang->getCode();

			//create task only for languages which have corporate wiki
			if ($visualization->isCorporateLang($content_lang)) {
				if (!empty($taskDeletionList) && class_exists('PromoteImageReviewTask')) {
					$task = new PromoteImageReviewTask();
					$deletion_list = array(
						$content_lang => array(
							$this->wg->cityId => array($imageName)
						)
					);

					$task->createTask(
						array(
							'deletion_list' => $deletion_list
						),
						TASK_QUEUED
					);
				}
			}
		}
	}

	public function purgeImage() {
		$this->deleteImage();
		$this->removalTaskHelper($this->pathname());
		//for legacy compatibility attempt to remove older image path format
		$this->removalTaskHelper($this->pathnameHelper(false,true));
	}

	public function deleteImage() {
		$this->deleteImageHelper($this->pathname());

		//for legacy compatibility attempt to remove older image path format
		$this->deleteImageHelper($this->pathnameHelper(false,true));
	}

	protected function inferType($fileName, &$dbName = null){
		$pattern = "/^(".self::__MAIN_IMAGE_BASE_NAME.")?(".self::__ADDITIONAL_IMAGES_BASE_NAME."-(\d)?)?,?([^.]{1,})?\.?(.*)$/i";

		$type = self::INVALID;

		if (preg_match($pattern, $fileName, $matches)){
			if (!empty($matches[1])) {
				$type = self::MAIN;
			} elseif (!empty($matches[2]) and !empty($matches[3])) { // matches additional images and has a number designation
				$val = intval($matches[3]);
				if ($val >= self::ADDITIONAL_1 and $val <= self::ADDITIONAL_9){
					$type = $val;
				}
			}

			$dbName = $matches[4];
		}
		return $type;
	}

}