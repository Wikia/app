<?php
/*
 * Base module, all the Mobile API modules must extend this class
 * 
 * @author Federico "Lox" Lucignano
 */
class EzApiModuleBase {
	private $mResponseContent = null;
	private $mContentType = EzApiContentTypes::HTML;
	private $mCharset = EzApiCharsets::UTF8;
	private $mResponseStatusCode = EzApiStatusCodes::OK;
	private $mRequest = null;
	
	function __construct( WebRequest $request ){
		$this->mRequest = $request;
	}
	
	public function getResponseContent(){
		return $this->mResponseContent;
	}
	
	protected function setResponseContent( $text ){
		$this->mResponseContent = $text;
	}
	
	public function getResponseContentType(){
		return "{$this->mContentType}; charset={$this->mCharset}";
	}
	
	protected function getContentType(){
		return $this->mContentType;
	}
	
	protected function setContentType( $type ){
		$this->mContentType = $type;
	}
	
	protected function getCharset(){
		return $this->mCharset;
	}
	
	protected function setCharset( $charset ){
			$this->mCharset = $charset;
	}
	
	public function getResponseStatusCode(){
		return $this->mResponseStatusCode;
	}
	
	protected function setResponseStatusCode( $code ){
		$this->mResponseStatusCode = $code;
	}
	
	protected function getRequest(){
		return $this->mRequest;
	}
	
	protected function requiresPost(){
		if( !$this->getRequest()->wasPosted() ) {
			throw new EzApiRequestNotPostedException();
		}
	}
}