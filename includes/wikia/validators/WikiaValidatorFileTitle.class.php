<?
class WikiaValidatorFileTitle extends WikiaValidator {
	protected $titleClass = 'Title';

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'wrong-file', 'wikia-validator-wrong-file' );
	}

	protected function getApp() {
		return F::app();
	}

	public function isValidInternal($value = null) {
		$file = $this->getFileFromName($value);

		if ($file instanceof File && $file->exists()) {
			return true;
		} else {
			$this->createError( 'wrong-file' );
			return false;
		}
	}

	public function getTitleClass() {
		return $this->titleClass;
	}

	public function setTitleClass($titleClass) {
		$this->titleClass = $titleClass;
	}
	
	public function getFileFromName($name) {
		$titleClass = $this->getTitleClass();
		$title = $titleClass::newFromText($name, NS_FILE);
		
		return wfFindFile( $title );
	}
}