<?php

require_once "exercise.php";
require_once "functions.php";
require_once "persist.php";

main();

function main() {
	$fetcher=new OWFetcher();
	echo "\n\n=== presistence test ===\n\n";
	$loadex=loadExercise(4);
	$loadex->setFetcher($fetcher);
	dumpExercise($loadex,10);

}
function dumpExercise($exercise,$questions) {
	for ($i=0;$i<$questions;$i++) {
		$question=$exercise->nextQuestion();
		print $question->getDmid()."\n";
		var_dump($question->getQuestionDefinitions());
		var_dump($question->getQuestionWords());
		var_dump($question->getAnswers());
	}
	
}


#function dumpExercise($exercise,$questions) {
#	for ($i=0;$i<$questions;$i++) {
#		$question=$exercise->nextQuestion();
#		print $question->getDmid()."\n";
#		var_dump($question->getQuestionDefinitions("eng"));
#		var_dump($question->getQuestionWords("eng"));
#		var_dump($question->getQuestionWords("deu"));
#		var_dump($question->getQuestionWords("deu"));
#		var_dump($question->getAnswers("eng"));
#		var_dump($question->getAnswers("deu"));
#	}
#	
#}



/** gets array of dmids from DOMDocument 
* now dupped in Exercise... can we drop it?
*/
function dom2set($set_dom) {
	$set=array();

	$xpath=new domxpath($set_dom);
	$nodes=$xpath->query("//defined-meaning");

	foreach ($nodes as $node) {
		$set[]=(int) $node->getAttribute("defined-meaning-id");
	}

	return $set;
}

?>
