<?php
/**
 * Data set abstraction for Path Finder
 * the current implementation uses OneDot's Amazon S3 archive as a back-end
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PathFinderDataSet extends WikiaObject{
	/**
	 * paths
	 */
	const DATA_PATH = "/tmp/PathFinderData/";
	
	private $logger;
	private $name;
	private $isLoaded = false;
	
	function __construct( $name ){
		$this->logger = (new PathFinderLogger);
		$this->name = $name;
	}
	
	function __destruct(){
		//remove the temp directory if empty
		if ( $this->loaded ) {
			unlink( $this->getFilePath() );
		}
	}
	
	public function load() {
		if ( !$this->isLoaded ) {
			wfProfileIn( __METHOD__ );
			
			wfProfileOut( __METHOD__ );
		}
	}
	
	private function getFilePath(){
		wfProfileIn( __METHOD__ );
		$filePath = '';
		$tokens = explode( '/', $this->name );
		
		if ( !empty( $tokens )  ) {
			$fileName = array_pop( $tokens );
			
			if ( file_exists( $fileName ) ) {
				wfProfileOut( __METHOD__ );
				return self::DATA_PATH . '/' . $fileName;
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new PathFinderDataSetInvalidName();
		}
		wfProfileOut( __METHOD__ );
	}
}

class PathFinderDataSetInvalidName extends WikiaException {
	function __construct(){
		parent::__construct( 'Invalid name for DataSet' );
	}
}