<?PHP

require_once("functions.php");  //testing only.
require_once("question.php");
require_once("util.php");

class NotInitializedException extends Exception {}
class NoMoreQuestionsException extends Exception {}


/** An Exercise consists of a number of questions that
 * are asked in order.
 * 
 * An exercise that is too large to ask in one go can
 * be split into sub-exercises.
 *
 * pseudocode for usage:
 * 
 * - Obtain a full list of questions from the Omegawiki server
 * - Generate a subExercise which has a more human-manageable size.
 * - ask each Question in the subExercise {
 *     The question will report back whether the answerCorrect() or
 *   answerIncorrect()
 * -} continue until no more Question-s left.
 *
 * Note that question content is only retrieved when actually needed,
 * question content is then cached.
 *
 * Iterator interface provided for when you want to see all the questions
 * at once. (as a side effect, iterating through can cache all data,
 * but will destroy the contents of currentSubset. )
 *
 * when asking questions, use the pseudocode above.
 */
class Exercise implements Iterator{

	private $currentSubset;
	private $currentQuestion=null;
	private $fullSet;
	private $fetcher;
	private $languages;
	private $questionLanguages;
	private $answerLanguages;
	private $id;	#exercise id in database
	private $hide=array();

	/**
	 * @param $fetcher class for retrieving xml for questions from some source
	 * @param $fullSet a DOMDocument with all questions
	 * @param $currentSubset: an array of dmids associated with questions (referring to the relevant entries in the $fullSet above)
	 */
	public function __construct($fetcher=null, $fullSet=null, $currentSubset=null) {
		$this->fetcher=$fetcher;
		$this->fullSet=$fullSet;
		if ($currentSubset!==null) {
			$this->currentSubset=$currentSubset;
		} else {
			try {
				$this->currentSubset=$this->getSet();
			} catch (NotInitializedException $ignored) {/*Can still be loaded later*/}
		}
	}

	# == Iterator implementation 
	# (see documentation for php Iterator)
	# used in eg. View->allQuestionsTable

	public function rewind() {
		$this->setCurrentSubset($this->getSet());
	}

	public function current() {
		if ($this->currentQuestion===null)
			return $this->nextQuestion();
		if (count($this->getCurrentSubset())==0) 
			return false;
		return $this->currentQuestion;
	}

	public function key() {
		return count($this->getCurrentSubset());
	}

	public function next() {
		$question= $this->nextQuestion();
		$this->hideQuestion($question);
		return $question;
	}

	public function valid() {
		if (count($this->getCurrentSubset())>0)
			return true;
		return false;
	}

	# == Getters/ Setters
	public function setFullSet($fullset) {
		$this->fullSet=$fullset;
	}

	public function getFullSet() {
		return $this->fullSet;	
	}


	public function getId(){
		return $this->id;
	}

	public function getCurrentSubset() {
		return $this->currentSubset;
	}

	public function setCurrentSubset($subset) {
		 $this->currentSubset=$subset;
	}

	public function setId($id) {
		$this->id= $id;
	}

	public function setQuestionLanguages($questionLanguages) {
		$this->questionLanguages=Util::array_trim($questionLanguages);
	}

	public function getQuestionLanguages(){
		return $this->questionLanguages;
	}

	public function setAnswerLanguages($answerLanguages){
		$this->answerLanguages=Util::array_trim($answerLanguages);
	}

	

	public function getAnswerLanguages(){
		return $this->answerLanguages;
	}

	public function getFetcher() {
		return $this->fetcher;
	}

	public function setFetcher($fetcher) {
		$this->fetcher=$fetcher;
	}

	public function getLanguages() {
		if ($this->languages===null) {
			$q=$this->getQuestionLanguages();
			$a=$this->getAnswerLanguages();
			if (@is_string($q) && @is_string($a)) {
				return array_merge($q, $a);
			}
		} else {
			return $this->languages;
		}
	}
	
	public function setLanguages($languages) {
		$this->languages=$languages;
	}

	public function getQuestionNode($dmid) {
		if (!is_int($dmid)) 
			throw new Exception ("Invalid dmid, must be a valid integer");

		return $this->_getQuestionNode($dmid,$this->fullSet,0);
	}

	public function getHide() {
		return $this->hide;
	}

	public function setHide($hide) {
		$this->hide=$hide;
	}


	# ==  All other methods 

	/**
	 * Initially, we start out with a question set (DOMDocument) with empty
	 * defined-meaning nodes for each question.
	 * as we ask questions, we fill out the DOMDocument with more information about each
	 * defined meaning.
	 * Calling this routine takes care of both of these tasks.
	 * If a question  element is empty, we fill it, and return the filled element.
	 * If the question element is already filled, we can return it right away.
	 * @param $dmid 	the dmid to fetch
	 * @param $targetDOM 	the DOM to work with
	 * @param $_depth  	traps recursion, $_depth may not be larger than 1.
	 * @param $fetch 	
	 */
	private function _getQuestionNode($dmid,$targetDOM,$_depth=0, $fetch=true ) {
		if (!is_int($dmid)) 
			throw new Exception ("Invalid dmid, must be a valid integer");

		if ($targetDOM===null) 
			throw new Exception ("Invalid internal reference to DOM, cannot be null");

		$xpath=new domxpath($targetDOM);
		$nodes=$xpath->query("//defined-meaning[@defined-meaning-id=\"$dmid\"]");

		if ($nodes->length>1)
			throw new Exception("More than one element with same dmid, while trying to parse XML (at depth $_depth)"); #There Can Be Only One!
		if ($nodes->length===0) 
			throw new Exception("dmid $dmid not found at depth $_depth");

		$questionNode=$nodes->item(0); 

		#Is the node empty? Then fill it (provided $fetch says we've been asked to do so).
		if ($fetch && !$questionNode->hasChildNodes()) {
			if ($_depth>0)
				throw new Exception("Failed to obtain full question node");

			$questionNode=$this->_fetchQuestionNode($dmid, $questionNode);
		}
		
		return $questionNode;
	}

	/**
	 * Perform actual fetch for getQuestionMode, and cahce it in $this->full_set as well.
	 * recursively calls back _getQuestionNode ONCE to parse out node
	 * @param dmid	defined meaning id to fetch
	 * @param the old empty node to replace
	 */
	private function _fetchQuestionNode($dmid, $oldNode) {
		$xmlString=$this->fetcher->getDefinedMeaningXML_asString($dmid, $this->getLanguages());
		$dom=new DOMDocument();
		$dom->loadXML($xmlString);

		# we recursively call  _getQuestionNode, because we're
		# lazy coders.
		# Hence we set $_depth=1

		$newNode=$this->_getQuestionNode($dmid, $dom, 1);

		# replace old empty node with new not-so-empty node.
		$newNode=$this->fullSet->importNode($newNode,true);
		$result=$oldNode->parentNode->replaceChild($newNode,$oldNode);

		if ($result===null) {
			throw new Exception ("couldn't update full question set");
		}
		return $newNode;
	}


	/** On the basis of the subset array provided, create new exercise object */
	public function getSubExercize($subset) {
		$dom=new DOMDocument();
		$collection=$dom->createElement("collection");
		$dom->appendChild($collection);
		foreach($subset as $dmid) {
			 #Grab each node from the current full set, $_depth must always start at 0
			 # and ($fetch=false) we just want the current state, 
			 # we can fetch things later at our leisure.
			$questionNode = $this->_getQuestionNode($dmid, $this->fullSet, 0, false);
			$questionNode =$dom->importNode($questionNode,true);
			$collection->appendChild($questionNode);
		}
		$newExercise=new Exercise($this->fetcher, $dom, $subset);
		$newExercise->setQuestionLanguages($this->getQuestionLanguages());
		$newExercise->setAnswerLanguages($this->getAnswerLanguages());
		$newExercise->setHide($this->getHide());

		return $newExercise;
	}

	/** get an array containing the list of dmid's
	 * in this exercise
	 */
	public function getSet() {
		if ($this->fullSet===null)
			throw new NotInitializedException("no fullSet available");
		$set=array();

		$xpath=new domxpath($this->fullSet);
		$nodes=$xpath->query("//defined-meaning");

		foreach ($nodes as $node) {
			$set[]=(int) $node->getAttribute("defined-meaning-id");
		}

		return $set;
	}

	/** Make a basic (unweighted) subexercise, 
	  *  with up to $size questions. 
	  */
	public function randSubExercise($size) {
		$set=$this->getSet();
		shuffle($set);

		if ($size>count($set)) 
			$size=count($set);
		
		$subset=array_slice($set,0,$size);
		return $this->getSubExercize($subset);
	}

	
	/** return question associated with the dmid,
	 * or throws MissingWordsException if words are missing.
	 * (I wish I had compile-time checks like in java )
	 * (you can suppress question consistency checking by setting $selfCheck to false)
	 */
	public function getQuestion($dmid, $selfCheck=true) {
		if (!is_int($dmid)) 
			throw new Exception ("Invalid dmid, must be a valid integer");

		$questionNode=$this->getQuestionNode($dmid);
		$question=new Question($this, $questionNode);
		$question->setQuestionLanguages($this->getQuestionLanguages());
		$question->setAnswerLanguages($this->getAnswerLanguages());

		if ($selfCheck) 
			$question->selfCheck();

		return $question;
	}

	/** select a random question, and return it */
	public function nextQuestion() {
		if (!is_array($this->currentSubset))
			throw new NotInitializedException("no currentSubset available");
		
		if (count($this->currentSubset)==0)
			throw new NoMoreQuestionsException("Done!");

		$next=$this->currentSubset[array_rand($this->currentSubset)];
		try {
			$question=$this->getQuestion($next);
			$this->currentQuestion=$question;
		} catch (MissingWordsException $e) {
			if (count($this->currentSubset)==1)	#1 left? Oh dear, that's this one.
				throw new NoMoreQuestionsException("Last question threw MissingWordsException!");
			$this->hideQuestion_byDMID($next);
			return $this->nextQuestion();
		}
		return $question;
	}

	/** called back from Question, if the question has been answered correctly */
	public function AnswerCorrect($question) {
		if ($this->currentSubset===null)
			throw new NotInitializedException("no fullSet available");
		if (count($this->currentSubset)<=0)
			throw new NoMoreQuestionsException("somehow a question was answered that was never asked.");
		
		$this->hideQuestion($question);

	}

	/** called back from Question, if the question has been answered incorrectly */
	public function AnswerIncorrect($question) {
		/** do something useful here */
	}

	/** A  question is "hidden" by removing it from the list of questions to be asked. (currentSubset) 
		it can still be accessed in other ways*/
	public function hideQuestion($question) {
		$id=(int) $question->getDmid();
		unset($this->currentSubset[array_search($id, $this->currentSubset)]);

	}
	
	public function hideQuestion_byDMID($dmid) {
		unset($this->currentSubset[array_search($dmid, $this->currentSubset)]);

	}



	/** rturns a count of the number of questions remaining to be asked */	
	public function countQuestionsRemaining() {
		return count($this->getCurrentSubset());
	}


	/** returns a count of the number of questions available in this Exercise */	
	public function countQuestionsTotal() {
		$dom=$this->getFullSet();
		$xpath=new domxpath($dom);
		$nodes=$xpath->query("/collection/defined-meaning");
		return $nodes->length;
	}

	/** store subset data in current dom tree */
	private function put_subset_in_dom() {
		if ($this->fullSet===null)
			throw new NotInitializedException("no fullSet available");
		if ($this->currentSubset===null) {
			return;
		}

		$dom=$this->fullSet;
		$subset=$dom->createElement('subset');
		foreach ($this->currentSubset as $dmid) {
			$dmid_element=$dom->createElement('dmid',"$dmid");
			$subset->appendChild($dmid_element);
		}

		$xpath=new domxpath($dom);
		$nodes=$xpath->query("/collection/subset");
		if ($nodes->length>0) {
			$oldSubset=$nodes->item(0);
			$oldSubset->parentNode->replaceChild($subset, $oldSubset);
		} else {
			$collection_s=$dom->getElementsByTagName("collection");
			$collection=$collection_s->item(0);
			$collection->appendChild($subset);
		}
	}

	/** retrieve previously stored subset data from dom tree */
	private function retrieve_subset_from_dom() {
		$dom=$this->fullSet;
		$xpath=new domxpath($dom);
		$nodes=$xpath->query("/collection/subset/dmid");
		if ($nodes->length>0) {
			$subset=array();
			foreach ($nodes as $node) {
				$subset[]=(int) $node->nodeValue;
			}
		} else {
			$exists=$xpath->query("/collection/subset");
			if ($exists->length==0) {
				$subset=$this->getSet(); //if not present, make a new one.
			} else {
				$subset=array(); // if present but empty, we need an empty one
			}
		}

		$this->currentSubset=$subset;
	}

	/** store hides data in current dom tree */
	private function put_hides_in_dom() {
		if ($this->fullSet===null)
			throw new NotInitializedException("no fullSet available");

		$dom=$this->fullSet;
		$hides=$dom->createElement('hides');
		foreach ($this->getHide() as $hide) {
			$hide_element=$dom->createElement('hide',"$hide");
			$hides->appendChild($hide_element);
		}

		$xpath=new domxpath($dom);
		$hides2=$xpath->query("/collection/hides");
		if ($hides2->length>0) {
			$oldHides=$hides2->item(0);
			$oldHides->parentNode->replaceChild($hides, $oldHides);
		} else {
			$collection_s=$dom->getElementsByTagName("collection");
			$collection=$collection_s->item(0);
			$collection->appendChild($hides);
		}
	}

	/** retrieve previously stored hides data from dom tree */
	private function retrieve_hides_from_dom() {
		$dom=$this->fullSet;
		$xpath=new domxpath($dom);
		$nodes=$xpath->query("/collection/hides/hide");
		if ($nodes->length>0) {
			$hides=array();
			foreach ($nodes as $node) {
				$hides[]=$node->nodeValue;
			}
		} else {
			$hides=array(); 
		}

		$this->setHide($hides);
	}



	/** provide an xml dump (this is not sufficient data to fully persist this Exercise) */
	public function saveXML() {
		$this->put_subset_in_dom();
		$this->put_hides_in_dom();
		$this->fullSet->normalizeDocument();
		return $this->fullSet->saveXML();
	}

	/** load previously saved xml */
	public function loadXML($xmlString) {
		if (!is_string($xmlString)) 
			throw new Exception ("Exercise::loadXML input is not a string");
		if ($xmlString==="") 
			throw new Exception ("Exercise::loadXML empty string supplied as input");

		$this->fullSet=new DOMDOcument();
		$this->fullSet->loadXML($xmlString);
		$this->retrieve_subset_from_dom();
		$this->retrieve_hides_from_dom();
	}

}

?>
