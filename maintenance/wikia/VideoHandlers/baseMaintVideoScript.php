<?php

abstract class BaseMaintVideoScript {

	const BATCH_LIMIT_DEFAULT = 50000;
	const PAGE_SIZE_DEFAULT = 100;

	protected $skipped;
	protected $failed;
	public $dryRun;

	function __construct() {
		$this->skipped = 0;
		$this->failed = 0;
		$this->dryRun = true;
	}

	public abstract function run();

	public function incSkipped() {
		++$this->skipped;
	}

	public function incFailed() {
		++$this->failed;
	}

	public function isDryRun() {
		return $this->dryRun;
	}

	/**
	 * @todo Implement fancier output, such as using Ncurses functions
	 * @param string $message
	 */
	public function outputMessage($message) {
		echo $message . "\n";
	}

	/**
	 * Output error message
	 * @param string $error
	 * @param string|null $pre
	 */
	public function outputError($error, $pre=null) {
		echo $pre . 'Error: ' . $error . "\n";
	}

	/**
	 * Compare metadata - For debugging purposes
	 * @param array $oldMeta
	 * @param array $newMeta
	 */
	protected function compareMetadata( $oldMeta, $newMeta ) {
		$fields = array_unique( array_merge( array_keys( $newMeta ), array_keys( $oldMeta ) ) );
		foreach ( $fields as $field ) {
			if ( ( !isset( $newMeta[$field] ) || is_null( $newMeta[$field] ) ) && isset( $oldMeta[$field] ) ) {
				$this->outputMessage( "\t\t[DELETED] $field: ".$oldMeta[$field] );
			} elseif ( isset( $newMeta[$field] ) && !isset( $oldMeta[$field] ) ) {
				$this->outputMessage( "\t\t[NEW] $field: $newMeta[$field]" );
			} elseif ( strcasecmp( $oldMeta[$field], $newMeta[$field] ) == 0 ) {
				$this->outputMessage( "\t\t$field: $newMeta[$field]" );
			} else {
				$this->outputMessage( "\t\t[UPDATED]$field: {$newMeta[$field]} (Old value: {$oldMeta[$field]})" );
			}
		}
	}

	protected function getCurrentTimestamp() {
		$timeFormat = 'm.d.Y g:i:s a e';
		return date($timeFormat);
	}
}