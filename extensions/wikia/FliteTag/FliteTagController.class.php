<?php
class FliteTagController extends WikiaParserTagController {
	const MIN_SIZE = 1;
	const PARSER_TAG_NAME = 'flite';
	const GUID_PATTERN = '/^[a-z0-9]{8}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{12}$/';

	protected $tagAttributes = [ 'guid', 'width', 'height' ];

	public function getTagName() {
		return self::PARSER_TAG_NAME;
	}

	protected function getErrorOutput( $errorMessages ) {
		return $this->sendRequest(
			'FliteTagController',
			'fliteTagError',
			[ 'errorMessages' => $errorMessages ]
		);
	}

	protected function getSuccessOutput( $args ) {
		return $this->sendRequest(
			'FliteTagController',
			( new WikiaIFrameTagBuilderHelper() )->isMobileSkin() ? 'fliteAdUnitMobile' : 'fliteAdUnitDesktop',
			[
				'guid' => $args['guid'],
				'width' => $args['width'],
				'height' => $args['height'],
				'widgetType' => self::PARSER_TAG_NAME
			]
		);
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
				$validator = $this->buildSizeValidator('height');
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

	private function setSkinSharedVariables() {
		$this->setVal( 'guid', $this->getVal( 'guid' ) );
		$this->setVal( 'width', $this->getVal( 'width' ) );
		$this->setVal( 'height', $this->getVal( 'height' ) );
	}

	public function fliteAdUnitDesktop() {
		$this->setSkinSharedVariables();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function fliteAdUnitMobile() {
		$this->setSkinSharedVariables();
		$this->setVal( 'widgetType', $this->getVal( 'widgetType' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function fliteTagError() {
		$this->setVal( 'errorMessages', $this->getVal( 'errorMessages', wfMessage( 'flite-tag-error-unknown' )->plain() ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

}
