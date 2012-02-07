<?php

interface ParsedVideoData {
	/*
	 * This interface represents the metadata for one video. It should be 
	 * implemented by any video class whose data can be set by an external 
	 * agent -- for example, a video ingestion script that processes a video
	 * feed and creates videos in batch would use the following methods
	 * on an ApiWrapper that implements this interface.
	 */
	
	/* implementing classes should declare 
	 * private $parsedData
	 */
	
	public function getParsedDataField($field);	// should access $this->parsedData
	public function generateCacheData();
	public function loadDataFromCache($cacheData);
}