<?php

class MissingWordsException extends Exception{};


class Question {

	private $questionNode;
	private $questionDoc;
	private $dmid;
	private $exercise;
	private $questionLanguages;
	private $answerLanguages;

	/**constructor
	* @param $exercise	the exercuse this question is associated with
	*			(for easy callback).
	* $param $questionNode	a raw DOMElement with our defined meaning
	*/
	public function __construct($exercise, $questionNode) {
		$this->exercise=$exercise;
		
		$doc=new DOMDocument;
		$questionNode=$doc->importNode($questionNode,true);
		$doc->appendChild($questionNode);
		$this->questionNode=$questionNode;
		$this->questionDoc=$doc;
		$this->dmid=(int) $questionNode->getAttribute("defined-meaning-id");
	}
	
	/** returns the dmid */
	public function getDmid() {
		return $this->dmid;
	}
	
	public function getQuestionLanguages() {
		return $this->questionLanguages;
	}

	public function setQuestionLanguages($questionLanguages) {
		$this->questionLanguages=$questionLanguages;
	}

	public function getAnswerLanguages() {
		return $this->answerLanguages;
	}

	public function setAnswerLanguages($answerLanguages) {
		$this->answerLanguages=$answerLanguages;
	}

	/** a nice full definition of the word, (big clue) to help beginning students. */
	public function getQuestionDefinitions($languages=null) {
		if ($languages===null) $languages=$this->getQuestionLanguages();
		if ($languages===null) throw new Exception("No language specified");

		$definitions=array(); #_typically_ there's only  one, but this is not enforced anywhere, afaik.
		$xpath=new domxpath($this->questionDoc);
		foreach ($languages as $language) {
			$nodes=$xpath->query("//translated-text-list/translated-text[@language=\"$language\"]");
			foreach ($nodes as $node) {
				$definitions[]=$node->textContent;
			}
		}
		return $definitions;

		
	}

	/** Get just the word */
	public function getQuestionWords($languages=null) {
		if ($languages===null) $languages=$this->getQuestionLanguages();
		if ($languages===null) throw new Exception("No language specified");

		return $this->getWordsForLanguages($languages);
	}

	/** utility function, returns an array of words in the particular language for this question's defined meaning */
	public function getWordsForLanguages($languages=null) {
		if ($languages===null) throw new Exception("No language specified");
		$words=array(); 
		$xpath=new domxpath($this->questionDoc);
		foreach ($languages as $language) {
			$nodes=$xpath->query("//synonyms-translations-list/synonyms-translations/expression[@language=\"$language\"]");
			foreach ($nodes as $node) {
				$words[]=$node->textContent;
			}
		}
		if (count($words)==0)
			throw new MissingWordsException("no words found in this context for languages ".implode(",",$languages));
		return $words;
	}


	/** Self-test.
	 * Try some stuff, throws exceptions if it fails.
	 * currently throws MissingWordsException if something goes wrong with question or answer */
	public function selfCheck() {
		$this->getQuestionWords();
		$this->getAnswers();
	}

	/** return set of synonyms that are all valid answers (a world first?) */
	public function getAnswers($languages=null) {
		if ($languages===null) $languages=$this->getAnswerLanguages();
		if ($languages===null) throw new Exception("No language specified");

		return $this->getWordsForLanguages($languages);

	}
	
	/** just check the answer, returns true if correct, false if answered wrong */
	public function checkAnswer($answer, $languages=null) {
		if ($languages===null) $languages=$this->getAnswerLanguages();
		if ($languages===null) throw new Exception("No language specified");

		$answers=$this->getAnswers($languages);
		$answer=trim($answer); // Hoomons make errors. Need to trim today. Will be made redundant by the robot conquest.
		return in_array($answer, $answers);
	
	}

	/** Your one stop shop. check the answer, and submit it to the excersize node. */
	public function submitAnswer($answer, $languages=null) {
		if ($languages===null) $languages=$this->getAnswerLanguages();
		if ($languages===null) throw new Exception("No language specified");

		$correct=$this->checkAnswer($answer,$languages);
		if ($correct) {
			$this->exercise->AnswerCorrect($this);
		} else {
			$this->exercise->AnswerIncorrect($this);
		}
		return $correct;
	}

}


?>
