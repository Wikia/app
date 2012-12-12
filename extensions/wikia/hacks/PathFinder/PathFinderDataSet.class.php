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
		$this->logger = F::build( 'PathFinderLogger' );
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
			$this->app->wf->profileIn( __METHOD__ );
			
			$this->app->wf->profileOut( __METHOD__ );
		}
	}
	
	private function getFilePath(){
		$this->app->wf->profileIn( __METHOD__ );
		$filePath = '';
		$tokens = explode( '/', $this->name );
		
		if ( !empty( $tokens )  ) {
			$fileName = array_pop( $tokens );
			
			if ( file_exists( $fileName ) ) {
				$this->app->wf->profileOut( __METHOD__ );
				return self::DATA_PATH . '/' . $fileName;
			}
		} else {
			$this->app->wf->profileOut( __METHOD__ );
			throw new PathFinderDataSetInvalidName();
		}
		$this->app->wf->profileOut( __METHOD__ );
	}
}

class PathFinderDataSetInvalidName extends WikiaException {
	function __construct(){
		parent::__construct( 'Invalid name for DataSet' );
	}
}