<?
class WikiaValidatorFileTitle extends WikiaValidator {
	protected $titleClass = 'Title';

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'wrong-file', 'wikia-validator-wrong-file' );
	}

	public function isValidInternal($value = null) {
		$titleClass = $this->getTitleClass();

		$title = $titleClass::newFromText($value);

		if ($title instanceof Title && $title->exists() && $title->getNamespace() == NS_FILE) {
			return true;
		} else {
			$this->createError( 'wrong-file' );
			return false;
		}
	}

	public function getTitleClass() {
		return $this->titleClass;
	}

	public function  setTitleClass($titleClass) {
		$this->titleClass = $titleClass;
	}
}