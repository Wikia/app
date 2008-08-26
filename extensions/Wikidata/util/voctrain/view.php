<?php

require_once("settings.php");
require_once("i18n/language.php");

$header_printed=false;

/** This shouldn't be here at all but PEAR:Auth hates me.
 * see also: Controller::__construct() , Controller::login() , Controller::logout()
 */
function _displayLogin($username = null, $status = null, &$auth = null) {
	global $header_printed;
	if (!$header_printed) {
		$view=new View();
		$view->header(false);
	}
	# I shouldn't be dealing with $_REQUEST here neither... but this function
	# breaks all the other rules anyways :-P
	
	$language=new Language('Default');

	$language->i18nprint("<h1><|Log in|>. <|Omegawiki vocabulary trainer|></h1>");
	if (isset($_REQUEST["defaultCollection"])) {
		$defaultCollection=(int) $_REQUEST["defaultCollection"];
		echo "<form method=\"post\" action=\"trainer.php?defaultCollection=$defaultCollection\">";
	} else {
		echo "<form method=\"post\" action=\"trainer.php\">";
	}
	$language->i18nprint('
	 <fieldset class="settings">
	<div class="datarow"><label><|User name|>: </label><input type="text" name="username" /></div><br/>
	<div class="datarow"><label><|Password|>: </label><input type="password" name="password" /></div><br/>
	<div class="datarow"><label><|Language|>: </label>'._langSelect().'</div><br/>
	</fieldset>
	<fieldset class="settings">
	<div class="datarow">
		<input type="submit" value="<|Login|>"/> 
		<input type="submit" value="<|Create new user|>" name="new_user">
		<!--<input type="submit" value="<|Switch language|>" name="switch_language">-->
	</div>
	</fieldset>
	</form>');
}

function _langSelect($default="eng") {
	$names=Language::getI18NLanguageNames();
	asort($names);
	$select="<select name='userLanguage'>\n";
	foreach ($names as $iso639_3=>$name){
		$select .= "	
			<option
				value='$iso639_3' "; 

		if ($iso639_3 == $default) { # check-mark default language
			$select.= "
				selected";
		}

		$select.= "
			> 
				".$name." 
			</option>
			";
	}
	$select.= "</select>\n";
	return $select;

}



/** ~MVC:  Generate html for user interface */
class View {

	public $model;
	public $language;

	public function __construct($language_code="Default") {
		$this->setLanguage_byCode($language_code);
	}

	public function setLanguage_byCode($code) {
		$this->language=new Language($code);
	}
	/** print everyones favorite friendly message! */
	public function hello() {
		$this->language->i18nprint("<h1><|Hello World|></h1>");
	}
	
	/** @deprecated */
	public function permissionDenied() {
		$this->language->i18nprint("<h1><|Permission Denied|></h1>");
		$this->language->i18nprint("<a href='trainer.php'><|try again?|></a>");
	}

	/** an action was provided, but we've never heard of it 
	    "?action=UnintelligibleGibberish" */
	public function actionUnknown($action){
		$this->language->i18nprint("<h1><|Action unknown|></h1>");
		$this->language->i18nprint("<|I don't know what to do with '%action'.|>", array("action"=>$action));
		$this->language->i18nprint("<a href='trainer.php'><|try_again?|></a>");
	}

	/** say hello to the new user */
	public function userAdded($username) {

		$this->language->i18nprint("<h1><|User added|></h1>");
		$this->language->i18nprint("<p><|Hello, %username, welcome to the omega language trainer|></p>",array("username"=>$username));
		$this->language->i18nprint("<p><a href='trainer.php'><|continue|></a></p>");
	}

	/** Big form, allows user to set parameters for their next exercise */
	public function exercise_setup($collectionList, $defaultCollection=null) {
		$this->language->i18nprint("
		<h1><|Set up your exercise|></h1>
		<form method='post' action='?'>
		<h2><|collection|></h2>
		<fieldset class=settings>
		<div class='datarow'>
		".$this->collectionSelect($collectionList, $defaultCollection)."
		</div>
		</fieldset>
		<h2><|Number of questions|></h2>
		<fieldset class='settings'>
		<div class='datarow'><input type='radio' value='10' name='exercise_size' /><label>10</label></div><br/>
		<div class='datarow'><input type='radio' value='25' name='exercise_size' checked /><label>25</label></div><br/>
		<div class='datarow'><input type='radio' value='50' name='exercise_size' /><label>50</label></div><br/>
		<div class='datarow'><input type='radio' value='75' name='exercise_size' /><label>75</label></div><br/>
		<div class='datarow'><input type='text' size='4' value='' name='exercise_size_other'>other</div><br/>
		</fieldset>
		</p>
		<h2><|hiding|></h2>
		<fieldset class='settings'>
		<div class='datarow'><input type='checkbox' value='hide_definition' name='hide_definition' /><label><|hide definitions in question language|></label></div><br/>
		<div class='datarow'><input type='checkbox' value='hide_words' name='hide_words' /><label><|hide words in question language|></label></div><br/>
		</fieldset>
		</p>
		</fieldset>
		<h2><|Languages|></h2>
		<fieldset class='settings'>
		<!-- should be a dropdown, perhaps -->
		<|Please specify the languages you want to test in|> <a href='http://www.sil.org/ISO639-3/codes.asp'><|ISO-639-3 format|></a>. <|(eg, eng for English, deu for Deutch (German)).|> <|Depending on your test set, some combinations might work better than others.|> <|Separate values by commas to use multiple languages.|>
		<div class='datarow'><label><|Questions|>:</label> <input type='text' value='eng' name='questionLanguages'/></div><br/>
		<div class='datarow'><label><|Answers|>: </label><input type='text' value='deu' name='answerLanguages'/></li></div><br/>
		<hr/>
		</p>
		<input type='submit' value='<|start exercise|>'/> 
		</form>
		");
	}

	public function collectionSelect($collectionList, $defaultCollection=null) {
		
		if ($defaultCollection===null) {
			global $default_collection; # can be set in settings.php
			$defaultCollection=$default_collection;
		}
		
		$select="<select name='collection'>\n";
		foreach ($collectionList as $collection) {
			$select .= "	<option
						value='".$collection["id"]."' "; 

			if ((int) $collection["id"] == $defaultCollection) { # check-mark default collection
				$select.= "
							selected";
			}

			$select.= "
						> 
					".$collection->name." 
					(".$collection->count.")
				</option>
			";
		}
		$select.= "</select>\n";
		return $select;
	}

	/** ask a question  (or peek at it)*/
	public function ask($exercise, $peek=false, $question=null, $unhides=array()) { #throws NoMoreQuestionsException
		if ($question===null) {
			$question=$exercise->nextQuestion();
		}
		$definitions=implode(",<br/>",$question->getQuestionDefinitions());
		$words=implode(", ",$question->getQuestionWords());
		$questionDmid=$question->getDmid();
		$questions_remaining=$exercise->countQuestionsRemaining();
		$questions_total=$exercise->countQuestionsTotal();
		$answers=implode(", ",$question->getAnswers());
		$hides=$exercise->getHide();

		$this->language->i18nprint(
			"<form method='post' action='?action=run_exercise'>
			<|There are %questions_remaining questions remaining, out of a total of %questions_total.|>
			<h1><|Question|></h1>
			<hr>", 
			array(
				"questions_remaining"=>$questions_remaining,
				"questions_total"=>$questions_total
			)
		);

		if (in_array("words",$hides) 
			&& !(array_key_exists("words",$unhides) 
			&& $unhides["words"]==$questionDmid)) {
			$this->language->i18nprint("
				<input type='submit' value='<|unhide words|>' name='unhide_words_button' />
			");
		} else {
			$this->language->i18nprint("
				<input type='hidden' name='unhide_words' value='$questionDmid'/>
				<h2><|Word|></h2>
				<p class='result'>
				<i><|The word to translate|>:</i><br/>
				$words
				</p>
			");
		}
		if (in_array("definition",$hides) 
			&& !(array_key_exists("definition",$unhides) 
			&& $unhides["definition"]==$questionDmid)) {
			$this->language->i18nprint("
				<input type='submit' value='<|unhide definition|>' name='unhide_definition_button' />
			");
		} else {
			$this->language->i18nprint("
				
				<input type='hidden' name='unhide_definition' value='$questionDmid'/>
				<h2><|Definition|></h2>
				<p class='result'>
				<i><|Dictionary definition to help you|>:</i><br/>
				$definitions 
				</p>
			");
		}
		$this->language->i18nprint("
			<input type='hidden' name='questionDmid' value='$questionDmid'/>
			<h2><|Answer|></h2>
			<fieldset class='settings'>");

		if ($peek) {
			$this->language->i18nprint("
				<i><|peek|>:</i>$answers<br/>");
		} else {
			$this->language->i18nprint("
				<input type='submit' value='(<|peek|>)' name='peek' /><br/>
			");
		}

		$this->language->i18nprint("
			<i><|Please type your answer here|></i><br/>

			<input type='text' value='' name='userAnswer' />
			<input type='submit' value='<|submit answer|>' name='submitAnswer' />
			</fieldset>
			<fieldset class='settings'>
			<input type='submit' value='<|skip|> ->' name='skip' />
			<input type='submit' value='<|I know it/do not ask again|>' name='hide' />
			".
			#<input type='submit' value='never ask again' name='never_ask' />
			"
			<input type='submit' value='<|abort exercise|>' name='abort' />
			<input type='submit' value='<|list answers|>' name='list_answers' />
			</fieldset>
			</form>
		");
	}

	/** Show the answer to a question */
	public function answer($question, $correct) {
		$definitions=implode(",<br/>",$question->getQuestionDefinitions());
		$words=implode(", ",$question->getQuestionWords());
		$answers=implode(", ",$question->getAnswers());

		#we should make a nice css for this
		$result="";
		if ($correct===true) {
			$result="<span style='color:#00DD00'>CORRECT</span>";
		} elseif ($correct===false) {
			$result="<span style='color:#DD0000'>WRONG</span>";
		} else {
			throw new Exception("unexpected outcome from question");
		}

		$this->language->i18nprint("<form method='post' action='?action=run_exercise'>
			<h2>$result</h2>
			<|Definitions|>: $definitions 
			<hr>
			<|Question|>: $words
			<hr>
			<|Answer|> (<|one of|>): $answers
			<hr>
			<input type='hidden' name='questionDmid' value='$questionDmid'/>
			<input type='submit' value='continue ->' name='continue' />
			</form>
		");
	}


	public function vocview($question) {
		#we only use questions and questionlanguages, we haven't set answerlanguages.
		$definitions=implode(",<br/>",$question->getQuestionDefinitions());
		$words=implode(", ",$question->getQuestionWords());
		$questionDmid=$question->getDmid();
		$answers=implode(", ",$question->getAnswers());

		$this->language->i18nprint(
			"
			<h1><|Vocview|></h1>
			<hr>
			<h2><|Word|></h2>
			<p class='result'>
			<i><|word|>:</i><br/>
			$words
			</p>
			<hr>
			<h2><|Definition|></h2>
			<p class='result'>
			<i><|Dictionary definitions|>:</i><br/>
			$definitions 
			</p>
			<hr>
			<h2><|Translation|></h2>
			<p class='result'>
			$answers
			</p>
			<hr>
		");
	}

	/** show a nice final table on completion of the exercise */
	public function complete($exercise) {
		
		$this->language->i18nprint("<h1> <|Exercise complete|> </h1>");
		$this->allQuestionsTable($exercise);
		$this->language->i18nprint("<a href='?action=create_exercise'><|Start a new exercise|></a>");
	}

	public function listAnswers($exercise) {
		$this->language->i18nprint("<h1> <|list of questions and answers|> </h1>");
		$this->allQuestionsTable($exercise);
		print"<fieldset class='settings'>";
		print"<form method='post' action='?action=run_exercise'>";
		print "<div style='float:right;'>";
		$this->language->i18nprint("<input type='submit' value='<|continue|> ->' name='continue' />");
		print"</div>";
		print"</fieldset>";
		print"</form>";
	}

	/** prints all questions out in a table.
	 * using a flush() between each item.
	 * this might not work out right... possibly needs heavy duty css :-/
	 */
	public function allQuestionsTable($exercise) {
		print "<table>";
		$this->language->i18nprint("<tr><th><|Definition|></th><th><|Question|></th><th><|Answer(s)|></th></tr>");
		try {
			$exercise->rewind();
			foreach ($exercise as $question) {
				print "<tr>";
				print "<td>".implode(",<br/>",$question->getQuestionDefinitions())."</td>";
				print "<td>".implode(", ",$question->getQuestionWords())."</td>";
				print "<td>".implode(", ",$question->getAnswers())."</td>";
				print "</tr>";
				flush();
			}
		} catch (NoMoreQuestionsException $ignored) {/*If this happens here, it's no problem*/}	
		print "</table>";
	}


	/** Aborted the exercise. We don't show the nice table like in
	 * complete(), because the lazy fetcher might take a long time to get
	 * all the untouched questions 
	*/
	public function aborted() {
		$this->language->i18nprint("<h1> <|Exercise terminated|> </h1>\n");
		$this->language->i18nprint("<a href='?action=create_exercise'><|Start a new exercise|></a>");
	}

	public function failed_new_user() {
		$this->language->i18nprint("<h1> <|Could not create new user|> </h1>\n");
		$this->language->i18nprint("<|Type a username and optional password, (or try a different username)|><br/>\n");
		$this->language->i18nprint("<a href='?'><|try again?|></a>\n");
	}

	/** fugly function to print HTML header */
	public function header($showlogout=true) {
		$lang=$this->language->getCode();
		if ($lang="Default") {
			$lang="en";
		}
		$direction=$this->language->getDirection();

		print'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		print"<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$lang' lang='$lang' dir='$direction'> ";
		# << de-indent so our layout matches html layout
print'
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
                <link rel="stylesheet" type="text/css" media="screen, projection" href="../ow/styles.css" />
                <link rel="stylesheet" type="text/css" media="screen, projection" href="http://www.omegawiki.org/extensions/Wikidata/OmegaWiki/tables.css" />
                <link rel="shortcut icon" href="http://www.omegawiki.org/favicon.ico" />
                <title>OmegaWiki gateway</title>
                <style type="text/css" media="screen,projection">/*<![CDATA[*/ @import "http://www.omegawiki.org/skins/monobook/main.css?55"; /*]]>*/</style>
                <link rel="stylesheet" type="text/css" media="print" href="http://www.omegawiki.org/skins/common/commonPrint.css?55" />
                <link rel="stylesheet" type="text/css" media="handheld" href="http://www.omegawiki.org/skins/monobook/handheld.css?55" />
                <link rel="stylesheet" type="text/css" media="screen" href="css/training.css" />

</head>
<body>
<div id="container">
';
		if ($showlogout) {
			$this->language->i18nprint('<a href="?action=logout"><|logout|></a>');
		}
		global $header_printed;
		$header_printed=true;
	}

	/** fugly function to print HTML footer */
	public function footer() {
	# << de-indent so our layout matches html layout
	$this->language->i18nprint('
<p class="footer"><|Powered by|> <a href="http://www.omegawiki.org/"><|Omegawiki|></a></p>
</div>
</body>
</html>
');
	}


}

?>
