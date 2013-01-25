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
		'not-an-image' => 'wikia-validator-not-an-image-error');
	
	protected $validMimeTypes = array(
		'image/gif', 
		'image/jpeg', 
		'image/pjpeg', 
		'image/png'
	);
	
	public function isValidInternal($value = null) {
		if( !parent::isValidInternal($value) ) {
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

		if ($this->minWidth !== null && $this->imageWidth < $this->minWidth) {
			$isValid = false;
			$this->createError('min-width', array($this->minWidth));
		}

		if ($this->maxWidth !== null && $this->maxWidth < $this->imageWidth) {
			$isValid = false;
			$this->createError('max-width');
		}

		if ($this->minHeight !== null && $this->imageWidth < $this->minHeight) {
			$isValid = false;
			$this->createError('min-height');
		}

		if ($this->maxHeight !== null && $this->maxHeight < $this->imageWidth) {
			$isValid = false;
			$this->createError('max-height');
		}

		return $isValid;
	}
}
