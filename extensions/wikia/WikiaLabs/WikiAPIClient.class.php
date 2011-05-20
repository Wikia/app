<?php 

class WikiAPIClient {
	public $cookie = array();
	
	function __construct($city_id) {
		
	}
	
	private function queryByPost($attr) {
		$attr['format'] = 'json'; 
		$options = array( 'postData' => $attr);
		$options['method'] = strtoupper( 'post' );
		
		if ( !isset( $options['timeout'] ) ) {
			$options['timeout'] = 'default';
		}
		
		$req = HttpRequest::factory( $this->getExternalDataUrl(), $options );
			
		if(!empty($this->cookie) ) {
			$req->setCookieJar($this->cookie);
		}
		
		$status = $req->execute();

		if ( $status->isOK() ) {
			$this->cookie = $req->getCookieJar();
			return json_decode($req->getContent());
		} else {
			return false;
		}
	} 
	
	public function login($name, $password, $token = null) {
			
		$attr = array(
			'action' => 'login',
			'lgname'	=>	$name,
			'lgpassword'	=>	$password
		);
		
		if(!empty($token)) {
			$attr['lgtoken'] = $token;
		}
		
		$result = $this->queryByPost($attr);

		if(!empty($result->login) && $result->login->result == 'NeedToken') {
			$this->login($name, $password, $result->login->token);
		} else {
			return ;
		}
	} 
	
	public function edit($title, $content) {
		$attr = array(
				'action' => 'query',
				'prop'	=>	'info',
				'intoken'	=>	'edit',
				'titles' => $title
		);
	
		$result = $this->queryByPost($attr);
		if(count($result->query->pages) == 1) {
			$page = current($result->query->pages );
			$edittoken = $page->edittoken;
		}
		
		$attr = array(
			'action' => 'edit',
			'title' => $title,
			'section' => 0,
			'text' => $content,
			'token' => $edittoken,
		);
		
		$result = $this->queryByPost($attr);
		//TODO: error handling
	}
	
	
	public function getExternalDataUrl() {		
		return 'http://messaging.tomek.wikia-dev.com/api.php?';
	}
}