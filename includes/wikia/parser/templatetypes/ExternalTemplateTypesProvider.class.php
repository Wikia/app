<?php

use Swagger\Client\ApiException;

class ExternalTemplateTypesProvider {
	const ERROR_MESSAGE = 'ExternalTemplateTypesProviderError';

	private static $instance;
	private $tcs = null;
	private $cachedTypes = [];

	/**
	 * @return ExternalTemplateTypesProvider
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * @return TemplateClassificationService
	 * @throws Exception
	 */
	public function getTCS() {
		if ( $this->tcs === null ) {
			throw new TCSNotSetException('TCS not set');
		}

		return $this->tcs;
	}

	/**
	 * @param TemplateClassificationService $tcs
	 * @returns ExternalTemplateTypesProvider
	 */
	public function setTCS( $tcs ) {
		$this->tcs = $tcs;

		return $this;
	}

	/**
	 * @desc gets template type from Template title object
	 *
	 * @param int $wikiId
	 * @param Title $title
	 *
	 * @return string - template type
	 */
	public function getTemplateTypeFromTitle( $wikiId, $title ) {
		return $title ? $this->getTemplateType( $wikiId, $title->getArticleID() ) :
			TemplateClassificationService::TEMPLATE_UNCLASSIFIED;
	}

	/**
	 * @desc gets template type from template ID
	 *
	 * @param $wikiId
	 * @param $templateId
	 *
	 * @return string - template type
	 */
	public function getTemplateType( $wikiId, $templateId ) {
		if ( !isset( $this->cachedTypes[ $templateId ] ) ) {
			$this->cachedTypes[ $templateId ] = $this->getExternalTemplateType( $wikiId, $templateId );
		}

		return $this->cachedTypes[ $templateId ];
	}

	/**
	 * @desc gets template type from template ID from TCS
	 *
	 * @param $wikiId
	 * @param $templateId
	 *
	 * @return string - template type
	 */
	private function getExternalTemplateType( $wikiId, $templateId ) {
		$type = TemplateClassificationService::TEMPLATE_UNCLASSIFIED;

		try {
			$type = $this->getTCS()->getType( $wikiId, $templateId );
		} catch ( ApiException $exception ) {
			$context = [ 'TCSApiException' => $exception ];
			$this->handleException( $context );
		}

		return $type;
	}

	/**
	 * @desc handle exceptions
	 *
	 * @param array $context
	 */
	private function handleException( $context ) {
		\Wikia\Logger\WikiaLogger::instance()->error( self::ERROR_MESSAGE, $context );
	}
}

class TCSNotSetException extends \Exception {
}
