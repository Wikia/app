<?php
class SimpleWikiaSearchEngine {

	var $word;

	var $only;

	var $offset = 0;

	var $rows = 10;

	var $exclude = array("staff", "internal");

	var $query;

	var $error;

	var $xml;

	var $result;


	/* public */
	function setOffset($offset) {
		$this->offset = $offset;
	}

	/* public */
	function setRows($rows) {
		$this->rows = $rows;
	}

	/* public */
	function setWord($word) {
		$this->word = $word;
	}

	/* public */
	function setOnly($only) {
		if($only == 0) {
			$this->only = true;
		}
	}


	/* public */
	function getResultsArray($forTitle = true, $forContent = true) {

		if($this->buildFullQuery($forTitle, $forContent) == false) {
			return false;
		}

		if($this->fetchXML() == false) {
			return false;
		}

		if($this->parseXML() == false) {
			return false;
		}

		return $this->result;
	}

	/* private */
	function buildFullQuery($forTitle, $forContent) {

		if(strlen($this->word) < 1) {
			return false;
		}

		$retrieveContent = false;

		if($forTitle == true && $forContent == false) {
			$query = sprintf("(title:\"%s\")", str_replace(" ", " AND ",$this->word));
			$retrieveContent = true;
		} else if($forTitle == false && $forContent == true) {
			$query = sprintf("(content:\"%s\")", str_replace(" ", " AND ",$this->word));
		} else {
			$query = sprintf("((title:\"%s\") OR (content:\"%s\"))", str_replace(" ", " AND ",$this->word), str_replace(" ", " AND ",$this->word));
		}

		if ( $this->only == true ) {
			global $wgDBname, $wgWikiaSearchDB;
			if( ! isset ( $wgWikiaSearchDB ) ) {
				$wgWikiaSearchDB = $wgDBname;
			}

			$query .= " AND (dbname:{$wgWikiaSearchDB})";
		}

		if ( count( $this->exclude ) > 0 ) {
			foreach($this->exclude as $key => $val) {
				$query .= " AND -(dbname:{$val})";
			}
		}
		
		$query_temp = "?q=%s&version=2.2&start=%s&rows=%s&indent=on&fl=user,url,title,size,namespace,dbname,date".(($retrieveContent == true) ? ",content" : "")."&hl=true&hl.fl=content&hl.requireFieldMatch=true&hl.fragsize=250&hl.simple.pre=<b>&hl.simple.post=</b>";
		$this->query = sprintf($query_temp, urlencode($query), $this->offset, $this->rows);
		
		return true;
	}


	/* private */
	function fetchXML() {
		global $wgWikiaSearchURL;
		
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $wgWikiaSearchURL.$this->query);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);
			$this->error = curl_error($ch);
			$this->xml =  $result;
			curl_close($ch);
		} catch (Exception $e) {
			$this->error = $e;
		}
		
		if($this->error) {
			return false;
		} else {
			return true;
		}
	}

	/* private */
	function parseXML() {
		try {
			$doc = new DOMDocument();

			if( ! @$doc->loadXML($this->xml) ) {
				throw new Exception("Bad xml");
			}

			$xpath = new DOMXPath($doc);

			$responseHeader = array();

			$query = '/response/lst/int';
			$entries = $xpath->query($query);
			$responseHeader['status'] = $entries->item(0)->nodeValue;
			$responseHeader['QTime'] = $entries->item(1)->nodeValue;

			$query = '/response/result';
			$entries = $xpath->query($query);
			$responseHeader['numFound'] = $entries->item(0)->getAttribute("numFound");

			$results = array();

			$query = '/response/result/doc';
			$entries = $xpath->query($query);
			foreach ($entries as $entry) {
				$result = array();
				$param = $entry->getElementsByTagName("str");
				foreach ($param as $one_param) {
					$result[$one_param->getAttribute("name")] = $one_param->nodeValue;

				}
				$param = $entry->getElementsByTagName("int");
				foreach ($param as $one_param) {
					$result[$one_param->getAttribute("name")] = $one_param->nodeValue;
				}
				$results[] = $result;
			}

			$query = '/response/lst[@name="highlighting"]/lst/arr/str';
			$entries = $xpath->query($query);
			for($i = 0; $i < $entries->length; $i++) {
				$results[$i]['highlighted'] = str_replace("\n", " ", $entries->item($i)->nodeValue);
			}

			$this->result = array('responseHeader' => $responseHeader, 'results' => $results);
		} catch (Exception $e) {
			$this->error = $e;
			return false;
		}
		return true;
	}
}
?>
