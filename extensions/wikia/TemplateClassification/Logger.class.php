<?php

namespace Wikia\TemplateClassification;

use Swagger\Client\ApiException;
use Wikia\Logger\Loggable;

class Logger extends \ContextSource {

	use Loggable;

	/**
	 * Messages generated using following constants
	 * logentry-templateclassification-tc-added
	 * logentry-templateclassification-tc-changed
	 */
	const TC_LOG_TYPE = 'templateclassification';
	const TC_LOG_ADDED = 'tc-added';
	const TC_LOG_CHANGED = 'tc-changed';

	const EXCEPTION_MESSAGE = 'TemplateClassification client exception';

	/**
	 * Saves logs from Template Classification related operations to Special:Log
	 *
	 * @param $pageId
	 * @param $newType
	 * @param string $oldType
	 * @return bool
	 */
	public function logClassificationChange( $pageId, $newType, $oldType = '' ) {
		$log = new \LogPage( self::TC_LOG_TYPE, false );
		$title = \Title::newFromID( $pageId );

		if ( !$title instanceof \Title ) {
			return false;
		}

		$newType = wfMessage( "template-classification-type-{$newType}" )->inContentLanguage()->escaped();
		$params = [ $newType ];
		if ( \RecognizedTemplatesProvider::isUnrecognized( $oldType ) ) {
			$action = self::TC_LOG_ADDED;
		} else {
			$action = self::TC_LOG_CHANGED;
			$params[] = wfMessage( "template-classification-type-{$oldType}" )->inContentLanguage()->escaped();
		}

		return $log->addEntry( $action, $title, '', $params, $this->getUser() );
	}

	/**
	 * Log exceptions thrown by TemplateClassification service
	 * @param  $e
	 */
	public function exception( ApiException $e ) {
		$context = [
			'tcExcptnMessage' => $e->getMessage(),
			'tcExcptnCode' => $e->getCode(),
			'tcExcptnBcktrc' => $e->getTraceAsString(),
		];

		$this->error( self::EXCEPTION_MESSAGE, $context );
	}
}
