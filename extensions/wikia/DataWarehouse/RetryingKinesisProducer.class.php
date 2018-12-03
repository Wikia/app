<?php

use \Wikia\Logger\WikiaLogger;

class RetryingKinesisProducer {
	const MAX_RETRIES = 10;

	function __construct( $kinesisProducer ) {
		$this->kinesisProducer = $kinesisProducer;
	}

	public function putRecord( $streamName, $message, $partitionKey = '0' ) {
		$retryCounter = self::MAX_RETRIES;
		$lastException = null;
		while ( $retryCounter > 0 ) {
			try {
				return $this->kinesisProducer->putRecord( $streamName, $message, $partitionKey );
			} catch ( Exception $e ) {
				// log message
				$retryCounter--;
				WikiaLogger::instance()->warning(
					sprintf( 'Error occured while putting record to Kinesis, %d retries left', $retryCounter ),
					[
						'exception' => $e
					]
				);
				$lastException = $e;
				sleep( pow( 2, self::MAX_RETRIES - $retryCounter - 1 ) ); // 1 sec, 2 secs, ..., 2^MAX_RETRIES secs
			}
		}
		WikiaLogger::instance()->error(
			sprintf('Unable to send event %s to stream %s, no retries left, giving up :-(', $message, $streamName),
			[
				'exception' => $lastException
			]
		);
		throw $lastException;
	}
}
