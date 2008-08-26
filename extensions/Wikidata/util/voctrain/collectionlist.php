<?php

require_once("functions.php");

class CollectionList {
	private $list;
	private $fetcher=null;
	public function __construct($fetcher) {
		$this->fetcher=$fetcher;
		$this->fetch();	
	}

	public function fetch() {
		if ($this->fetcher===null) 
			throw new Exception("not initialized");
		
		$xmlString=$this->fetcher->getCollectionListXML_asString();
		$xml=simpleXML_load_string($xmlString);
		$this->list=$xml->xpath("//collection");
	}

	/** returns a list of collections... in simplexml format
	 * This list is currently unchecked. 
	 * items are id, name (and name->dmid), and count
	 */
	public function getList() {
		return $this->list;
	}

}



?>
