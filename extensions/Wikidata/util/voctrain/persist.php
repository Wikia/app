<?php

# may or may not move these into relevant classes.
#require_once("connect.php");
require_once("settings.php");
require_once("DBTools.php");
require_once("exercise.php");

function loadExercise($exercise_id) {
	if (!is_int($exercise_id)) 
		throw new Exception("persist; loadExercise exercise_id is not an integer");


	global $mysql_info;
	DBTools::connect($mysql_info);
	$exercise_id=mysql_real_escape_string($exercise_id);
	$row=DBTools::doQuery("select * from exercises where id=\"$exercise_id\"");
	$exercise=new Exercise();
	$exercise->setId($exercise_id);
	$exercise->loadXML($row["exercise"]);
	$exercise->setQuestionLanguages(explode(",",$row["questionLanguages"]));
	$exercise->setAnswerLanguages(explode(",",$row["answerLanguages"]));
	return $exercise;
}

function saveExercise($exercise, $userName=null) {
	global $mysql_info;
	DBTools::connect($mysql_info);
	$id=mysql_real_escape_string($exercise->getId());
	#if (id==0) throw new Exception ("new exercise?");
	$row=array();
	$row["id"]=$id;
	$row["username"]=$userName;
	$row["exercise"]=$exercise->saveXML();
	$row["questionLanguages"]=mysql_real_escape_string(implode(",",$exercise->getQuestionLanguages()));
	$row["answerLanguages"]=mysql_real_escape_string(implode(",",$exercise->getAnswerLanguages()));

	DBTools::unsafe_insert_assoc("exercises","id", $id, $row);
	$exercise->setId(mysql_insert_id()); #might be useful to prevent repeats
	}


?>
