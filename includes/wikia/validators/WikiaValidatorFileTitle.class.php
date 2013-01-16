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
		$titleClass = $this->getTitleClass();

		$title = $titleClass::newFromText($value, NS_FILE);

		$file = $this->getApp()->wf->findFile( $title );

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

	public function  setTitleClass($titleClass) {
		$this->titleClass = $titleClass;
	}
}