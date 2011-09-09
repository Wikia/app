<?php

class FogbugzContainer {
	
	private $caseData = array(); 
	
	private $childrenList = array();
	
	/**
	 * Creates new case object
	 * @param array $casedata : pass here field of array (one case) returned from fogbugz API
	 */
	public function __construct( Array $casedata ) {
		foreach ($casedata as $datakey => $data) {
			$this->setInfo($datakey, $data);
		}
	}
	
	public function addChildren( $casesList ){
		for ( $i = 0; $i < count( $casesList ); $i++ ){
			if ( $casesList[$i]['ixBugParent'] == $this->getInfo( 'ixBug' ) ) {
				$this->addChild($casesList[$i]);
			}
		}
		for ($j = 0; $j < $this->getChildrenCount(); $j++){
			$this->getChild($j)->addChildren( $casesList );
		}
	}
	public function prepareHtml(Array &$results, $index, $counter = 1){
		
		
		
		$ticketBuffer = "";
		$ticketBuffer .= str_repeat("*", $counter);
		
		//TODO: cache it
		// check if there's a Html ready in memcache; it should happens in FogbugzService
		// (proper template should be passed as a parameter to the function getCasesBasicInfo 
		$ticketBuffer .= '{{Template:'.$this->getInfo( 'sStatus' ).'}} '.
							$this->getInfo('sTitle').
							' -- [https://wikia.fogbugz.com/default.asp?'.
							$this->getInfo('ixBug').' #'.
							$this->getInfo('ixBug').']';
		$ticketBuffer .= "\n";
		
		$results[$index][] = $ticketBuffer;
		
		//end
		
		for ($j = 0; $j < $this->getChildrenCount(); $j++){
			$this->getChild($j)->prepareHtml($results, $index, $counter + 1);
		}
		
	}
	
	public function prioritySort(){
		for ($j = 0; $j < $this->getChildrenCount(); $j++){
			$this->getChild($j)->prioritySort();
		}
		
		if ( $this->getChildrenCount() > 0) {
			for ($outerIndex = 1; $outerIndex < $this->getChildrenCount(); $outerIndex++) {
				$buffer = $this->getChild($outerIndex);
				for ($innerIndex = $outerIndex; $innerIndex > 0 
					&& $this->getChildInfo($innerIndex - 1, 'ixPriority') > $buffer->getInfo('ixPriority'); $innerIndex--) 
				{
					$this->swapForInsertSort($innerIndex, $buffer);
				}
			}
		} 
	}
	
	public function setInfo( $name, $value ) {
		$this->caseData[$name] = $value;
	}
	
	public function getInfo( $name ) {
		if ( isset( $this->caseData[$name] ) ) {
			return $this->caseData[$name];
		} else {
			return 'unknown';
		}
	}
	
	public function getChildrenCount() {
		return count($this->childrenList);
	}
	
	public function getChildInfo ($childIndex, $name) {
		if ($childIndex < count($this->childrenList)) {
			return $this->childrenList[$childIndex]->getInfo($name);
		} else {
			return 'unknown child';
		}
	}
	
	public function getChild($childIndex) {
	if ($childIndex < count($this->childrenList)) {
			return $this->childrenList[$childIndex];
		} else {
			return 'unknown child';
		}
	}
	
	//use wisely below function
	public function swapForInsertSort($index, $bufferedChild) {
		$this->childrenList[$index] = $this->childrenList[$index - 1];
		$this->childrenList[$index - 1] = $bufferedChild;
	}
	
	public function addChild(Array $childData) {
		$this->childrenList[] = new FogbugzContainer($childData);
	}
}