<?php
class WikiaValidatorImageSize extends WikiaValidatorFileTitle {
	protected $options = array(
		'minWidth' => null,
		'maxWidth' => null,
		'minHeight' => null,
		'maxHeight' => null,
	);
	
	protected $msgs = array(
		'min-width' => 'wikia-validator-min-width-error',
		'max-width' => 'wikia-validator-max-width-error',
		'min-height' => 'wikia-validator-min-height-error',
		'max-height' => 'wikia-validator-max-height-error',
		'wrong-size' => 'wikia-validator-max-height-error',
		'not-an-image' => 'wikia-validator-not-an-image-error'
	);
	
	protected $validMimeTypes = array(
		'image/gif', 
		'image/jpeg', 
		'image/pjpeg', 
		'image/png'
	);
	
	protected function isFileNameValid($value) {
		return parent::isValidInternal($value);
	}
	
	public function isValidInternal($value = null) {
		if( !$this->isFileNameValid($value) ) {
			return false;
		}

		$image = $this->getFileFromName($value); /** @var $image File | WikiaLocalFile */
		$this->imageWidth = intval( $image->getWidth() );
		$this->imageHeight = intval( $image->getHeight() );
		
		if( !in_array($image->getMimeType(), $this->validMimeTypes) ) {
			$this->createError('not-an-image');
			return false;
		}

		$this->minWidth = $this->getOption('minWidth');
		$this->maxWidth = $this->getOption('maxWidth');
		$this->minHeight = $this->getOption('minHeight');
		$this->maxHeight = $this->getOption('maxHeight');

		$isValid = true;
		$widthInvalid = false;
		$heightInvalid = false;
		
		if( $this->minWidth !== null && $this->imageWidth < $this->minWidth ) {
			$isValid = false;
			$widthInvalid = true;
			$this->createError('min-width', array($this->minWidth));
		}

		if ($this->maxWidth !== null && $this->maxWidth < $this->imageWidth) {
			$isValid = false;
			$widthInvalid = true;
			$this->createError('max-width');
		}

		if ($this->minHeight !== null && $this->imageHeight < $this->minHeight) {
			$isValid = false;
			$heightInvalid = true;
			$this->createError('min-height');
		}

		if ($this->maxHeight !== null && $this->maxHeight < $this->imageHeight) {
			$isValid = false;
			$heightInvalid = true;
			$this->createError('max-height');
		}
		
		if( $widthInvalid && $heightInvalid ) {
			$isValid = false;
			$this->createError('wrong-size', array());
		}

		return $isValid;
	}
}
