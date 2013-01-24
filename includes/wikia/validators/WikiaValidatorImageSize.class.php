<?php
class WikiaValidatorImageSize extends WikiaValidatorFileTitle {
	protected $options = array('compare-way' => '', 'width' => '', 'height' => '');
	protected $msgs = array('wrong-size' => '', 'wrong-width' => '', 'wrong-height' => '', 'not-an-image' => '');
	
	const COMPARE_EQUALS = '==';
	const COMPARE_LOWER = '<';
	const COMPARE_GREATER = '>';
	const COMPARE_GTE = '>=';
	const COMPARE_LTE = '<=';
	
	protected $validCompareWays = array(
		self::COMPARE_EQUALS,
		self::COMPARE_LOWER,
		self::COMPARE_GREATER,
		self::COMPARE_GTE,
		self::COMPARE_LTE,
	);
	
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
		
		$compareWay = $this->getOption('compare-way');
		if( !in_array($compareWay, $this->validCompareWays) ) {
			$this->throwException( 'WikiaValidatorImageSize: passed compare-way is invalid' );
		}
		
		if( !in_array($image->getMimeType(), $this->validMimeTypes) ) {
			$this->generateError('not-an-image');
			return false;
		}

		$this->validWidth = intval( $this->getOption('width') );
		$this->validHeight = intval( $this->getOption('height') );
		
		$isValid = false;
		switch($compareWay) {
			case self::COMPARE_EQUALS:
				$isValid = $this->compareSizeAsEqual();
				break;
			case self::COMPARE_LTE:
				$isValid = $this->compareSizeAsLowerOrEqual();
				break;
			case COMPARE_GTE:
				$isValid = $this->compareSizeAsGreaterOrEqual();
				break;
			case COMPARE_LOWER:
				$isValid = $this->compareSizeAsLower();
				break;
			case COMPARE_GREATER:
				$isValid = $this->compareSizeAsGreater();
				break;
		}
		
		return $isValid;
	}
	
	protected function compareSizeAsEqual() {
		if( $this->imageWidth !== $this->validWidth && $this->imageHeight !== $this->validHeight ) {
			$this->createError('wrong-size');
			return false;
		} else if( $this->imageWidth !== $this->validWidth ) {
			$this->createError('wrong-width');
			return false;
		} else if( $this->imageHeight !== $this->validHeight ) {
			$this->createError('wrong-height');
			return false;
		}

		return true;
	}
	
	protected function compareSizeAsLowerOrEqual() {
		if( $this->imageWidth > $this->validWidth && $this->imageHeight > $this->validHeight ) {
			$this->createError('wrong-size');
			return false;
		} else if( $this->imageWidth > $this->validWidth ) {
			$this->createError('wrong-width');
			return false;
		} else if( $this->imageHeight > $this->validHeight ) {
			$this->createError('wrong-height');
			return false;
		} else {
			return true;
		}
	}
	
	protected function compareSizeAsGreaterOrEqual() {
		if( $this->imageWidth < $this->validWidth && $this->imageHeight < $this->validHeight ) {
			$this->createError('wrong-size');
			return false;
		} else if( $this->imageWidth < $this->validWidth ) {
			$this->createError('wrong-width');
			return false;
		} else if( $this->imageHeight < $this->validHeight ) {
			$this->createError('wrong-height');
			return false;
		} else {
			return true;
		}
	}

	protected function compareSizeAsLower() {
		if( $this->imageWidth >= $this->validWidth && $this->imageHeight >= $this->validHeight ) {
			$this->createError('wrong-size');
			return false;
		} else if( $this->imageWidth >= $this->validWidth ) {
			$this->createError('wrong-width');
			return false;
		} else if( $this->imageHeight >= $this->validHeight ) {
			$this->createError('wrong-height');
			return false;
		} else {
			return true;
		}
	}

	protected function compareSizeAsGreater() {
		if( $this->imageWidth <= $this->validWidth && $this->imageHeight <= $this->validHeight ) {
			$this->createError('wrong-size');
			return false;
		} else if( $this->imageWidth <= $this->validWidth ) {
			$this->createError('wrong-width');
			return false;
		} else if( $this->imageHeight <= $this->validHeight ) {
			$this->createError('wrong-height');
			return false;
		} else {
			return true;
		}
	}
}
