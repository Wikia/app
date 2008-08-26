<?php

require_once ("persist.php");
require_once ("DBTools.php");
require_once ("settings.php");
require_once ("functions.php");
require_once ("collectionlist.php");
require_once ("vocview.php");

/** provide access to the actual back-end persistent classes. 
 * also does some minor database-wonkery*/
class Model {

public $view;



	public function addExercise($size) {

	}

	public function removeExercise($exercise_id){

	}

	/** obtain a list of exercises for a particular user */
	public function getExercisesForUser($username) {
		global $mysql_info;
		DBTools::connect($mysql_info);

		$user=mysql_real_escape_string($username);

		$rows=DBTools::doMultiRowQuery("SELECT id FROM exercises where username=\"$username\" AND (completion<100 OR completion IS NULL) LIMIT 1");
		$exercises=array();
		foreach ($rows as $row) {
			$exercises[]=(int) $row["id"];
		}
		return $exercises;

	}

	/** mark exercise as completed */
	public function complete($exercise) {
				
		$id=mysql_real_escape_string($exercise->getId());
		$empty=DBTools::doQuery("UPDATE exercises SET completion=100 WHERE id='$id'");
	}


	public function setUserLanguage($username, $language) {
		global $mysql_info;
		DBTools::connect($mysql_info);

		$language=mysql_real_escape_string($language);
		$empty=DBTools::doQuery("UPDATE auth SET uiLanguage=\"$language\"");
	}

	public function getUserLanguage($username) {
		global $mysql_info;
		DBTools::connect($mysql_info);

		$username=mysql_real_escape_string($username);
		$row=DBTools::doQuery("SELECT uiLanguage from auth where username=\"$username\"");
		return $row["uiLanguage"];
	}

	/** retrieve the exercice we're using for this session */
	public function getExercise($username) {

		# we currently assume one exercise per user, and no master...
		# this will change and this needs refactoring
		#for now we can cheat
		$exercises=$this->getExercisesForUser($username);
		if (count($exercises)<1) 
			return null;

		#the cheat
		$exercise_id=$exercises[0];

		#carrying on, whisteling innocently
		$exercise=loadExercise($exercise_id);
		$exercise->setFetcher(new OWFetcher());
		return $exercise;
	}

	/** save Exercice back to db*/
	public function saveExercise($exercise, $userName) {
		# this calls the global method saveExercise 
		# from persist.php . The name happens to be the same.
		saveExercise($exercise, $userName);
	}

	/** create a new Exercise from scratch.
	# */
	public function createExercise($userName, $size, $collection_id, $questionLanguages, $answerLanguages, $hide) {

		#this can be simplified for now...
		# first get a master exercise...
		$fetcher=new OWFetcher();
		$fullSetXML=$fetcher->getFullSetXML_asString($collection_id, array_merge($questionLanguages, $answerLanguages));
		$fullSet=new DOMDocument();
		$success=$fullSet->loadXML($fullSetXML);
		if (!$success) {
			throw new Exception("Failed to load category XML from server");
		}

		$exercise=new Exercise($fetcher,$fullSet);
		$exercise->setQuestionLanguages($questionLanguages);
		$exercise->setAnswerLanguages($answerLanguages);
		$exercise->setHide($hide);

		# This is the master exercise... which we should now store and 
		# worship. That's for mark II though. 
		# Today we toss it in the trash and just snarf a
		# subset instead. Mean huh?
		
		$subExercise=$exercise->randSubExercise($size);
		$this->saveExercise($subExercise,$userName);
		return $subExercise;
	}

	/** return a new list of collections */
	public function collectionList() {
		$fetcher=new OWFetcher();
		$lister=new CollectionList($fetcher); #meh, almost doesn't need a class
		return $lister->getList();
	}

	/** another call to single function class... I need to think of ways to tidy up*/
	public function vocview_getQuestion($dmid, $questionLanguages, $answerLanguages) {
		$v=new VocView();
		return $v->getQuestion($dmid, $questionLanguages, $answerLanguages);
	}

}


?>
