<?php
class FliteTagController extends WikiaParserTagController {
	const MIN_SIZE = 1;
	const PARSER_TAG_NAME = 'flite';
	const GUID_PATTERN = '/[a-z0-9]{8,8}\-[a-z0-9]{4,4}\-[a-z0-9]{4,4}\-[a-z0-9]{4,4}\-[a-z0-9]{12,12}/';

	protected $tagAttributes = [ 'guid', 'width', 'height' ];

	public function getTagName() {
		return self::PARSER_TAG_NAME;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$markerId = $this->generateMarkerId( $parser );
		$errorMessages = $this->validateAttributes( $args );

		if( !empty( $errorMessages ) ) {
			$this->addMarkerOutput( $markerId, $this->sendRequest(
				'FliteTagController',
				'fliteTagError',
				[ 'errorMessages' => $errorMessages ]
			) );
		} else {
			$this->addMarkerOutput( $markerId, $this->sendRequest(
				'FliteTagController',
				'fliteAdUnit',
				[
					'guid' => $args['guid'],
					'width' => $args['width'],
					'height' => $args['height'],
				]
			) );
		}

		return $markerId;
	}

	public function onParserAfterTidy( Parser &$parser, &$text ) {
		$text = strtr( $text, $this->getMarkers() );
		return true;
	}

	protected function buildParamValidator( $paramName ) {
		$validator = new WikiaValidatorAlwaysTrue();

		switch( $paramName ) {
			case 'guid':
				$validator = new WikiaValidatorRegex([
					'required' => true,
					'pattern' => self::GUID_PATTERN,
				], [
					'wrong' => 'flite-tag-error-invalid-guid'
				]);
				break;
			case 'width':
				$validator = $this->buildSizeValidator('width');
				break;
			case 'height':
				$validator = $this->buildSizeValidator('width');
				break;
		}

		return $validator;
	}

	private function buildSizeValidator( $dimension ) {
		return new WikiaValidatorNumeric( [
			'required' => true,
			'min' => self::MIN_SIZE
		], [
			// flite-tag-error-invalid-size-width
			// flite-tag-error-invalid-size-height
			// flite-tag-error-min-size-width
			// flite-tag-error-min-size-height
			'not_numeric' => 'flite-tag-error-invalid-size-' . $dimension,
			'too_small' => 'flite-tag-error-min-size-' . $dimension,
		] );
	}

	public function fliteAdUnit() {
		$this->setVal( 'guid', $this->getVal( 'guid' ) );
		$this->setVal( 'width', $this->getVal( 'width' ) );
		$this->setVal( 'height', $this->getVal( 'height' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function fliteTagError() {
		$this->setVal( 'errorMessages', $this->getVal( 'errorMessages', wfMessage( 'flite-tag-error-unknown' )->plain() ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

}
