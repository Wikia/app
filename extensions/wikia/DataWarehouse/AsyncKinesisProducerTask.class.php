<?php

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Metrics\Collector;


class AsyncKinesisProducerTask extends BaseTask {

	public function putRecord( $streamName, $message ) {
		global $wgAWSAccessKey, $wgAWSSecretKey;

		$kinesis = new RetryingKinesisProducer(
			new KinesisProducer($wgAWSAccessKey, $wgAWSSecretKey)
		);
		return $kinesis->putRecord( $streamName, $message );
	}

}
