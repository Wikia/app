<?php

require_once "exercise.php";
require_once "functions.php";
require_once "persist.php";

main();

function main() {
	$collection_id=376317; #olpc dictionary.... WAY too big

	$fetcher=new OWFetcher();
	echo "fullset...\n";
	$fullSetXML=$fetcher->getFullSetXML_asString($collection_id);

	$fullSet=new DOMDocument();
	$success=$fullSet->loadXML($fullSetXML);
	if (!$success) {
		throw new Exception("Failed to load category XML from server");
	}

	$maxSubSet=dom2set($fullSet);
	#sort($maxSubSet); foreach ($maxSubSet as $dmid) {print "$dmid,";}


	#var_dump($fullSet->saveXML());
	$exercise=new Exercise($fetcher,$fullSet,$maxSubSet); # pwease, not the max!
	#$exercise->setLanguages(array("eng","fra","deu"));
	$exercise->setQuestionLanguages(array("deu"));
	$exercise->setAnswerLanguages(array("eng"));

	#$question_dmid=$maxSubSet[array_rand($maxSubSet)];
	echo "question...\n";
	#$questionNode=$exercise->getQuestionNode($question_dmid);

	#dumpNode($questionNode);
	$runex=$exercise->randSubExercise(10);
	dumpExercise($runex,5);

	echo "\n\n=== presistence test ===\n\n";
	saveExercise($runex);
	$exid=mysql_insert_id();
	$loadex=loadExercise($exid);
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
