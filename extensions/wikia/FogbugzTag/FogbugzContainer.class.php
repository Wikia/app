<?php

class FogbugzContainer {
	
	//data:
	/*
	private $ixBug;
	private $sTitle;
	private $sStatus;
	private $ixBugParent = 0;
	private $ixPriority;
	private $sublevel;
	*/
	private $parentReference = null;
	public $childReference = null;
	
	private $caseData = array(); 
	
	private $childrenList = array();
	
	public static $res = 0;
	
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
		$i = 0;
		while ( $i < count( $casesList ) ){
			if ( $casesList[$i]['ixBugParent'] == $this->getInfo( 'ixBug' ) ) {
				$this->addChild($casesList[$i]);
			}
			++$i;
		}
		$j = 0;
		while ($j < $this->getChildrenCount()){
			$this->getChild($j)->addChildren( $casesList );
			++$j;
		}
	}
	public static function prepareHtml($parent, Array &$results, $index){
		static $counter = 0;
		++$counter;
		$j = 0;
		$ticketBuffer = "";
		$ticketBuffer .= str_repeat("*", $counter);
		//TODO: cache it
		$ticketBuffer .= '{{Template:'.$parent->getInfo( 'sStatus' ).'}} '.
							$parent->getInfo('sTitle').
							' -- [https://wikia.fogbugz.com/default.asp?'.
							$parent->getInfo('ixBug').' #'.
							$parent->getInfo('ixBug').']';
		$ticketBuffer .= "\n";
		$results[$index][] = $ticketBuffer;
		while ($j < $parent->getChildrenCount()){
			self::prepareHtml($parent->getChild($j), $results, $index);
			
			++$j;
		}
		--$counter;
		
	}
	
	public static function prioritySort(&$parent){
		$j = 0;
		while ($j < $parent->getChildrenCount()){
			self::prioritySort($parent->getChild($j));
			
			++$j;
		}
		
		if ( $parent->getChildrenCount() > 0) {
			for ($outerIndex = 1; $outerIndex < $parent->getChildrenCount(); $outerIndex++) {
				$buffer = $parent->getChild($outerIndex);
				for ($innerIndex = $outerIndex; $innerIndex > 0 
					&& $parent->getChildInfo($innerIndex - 1, 'ixPriority') > $buffer->getInfo('ixPriority'); $innerIndex--) 
				{
					$parent->swapForInsertSort($innerIndex, $buffer);
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