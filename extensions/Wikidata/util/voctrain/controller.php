<?php
require_once("model.php");
require_once("view.php");
require_once("settings.php");
require_once("util.php");

require_once("Auth.php");



/** ~MVC  Accept user input and coordinate model and view. */
class Controller {
	
	public $view;
	public $model;

	private $auth;

	public function __construct() {
		# set up authentication.
		global $dsn;
		$options=array (
			'dsn' => $dsn
		);
		$auth=new Auth("DB", $options, "_displayLogin");
		$this->auth=$auth;
	}

	/** Entry point. Examine $_REQUEST and decide what to do 
	 * Urk, bit confuzzeled on the $_REQUEST, should tidy!
	 */
	public function execute() {
		$logged_out_actions=array("hello","vocview");

		$action=$_REQUEST["action"];

		# do not require login for things that don't require it
		if (isset($_REQUEST['new_user'])) {
			$this->new_user();
			exit;
		}

		if (!in_array($action, $logged_out_actions)) {
			$this->login();
		}
		$logged_in=$this->auth->checkAuth();
		
		if ($logged_in) {
			$username=$this->auth->getUsername();
			if ($_REQUEST["userLanguage"]) {
				$this->model->setUserLanguage($username,$_REQUEST["userLanguage"]);
			}
		}
		$this->setLanguage();
		if ($action=="logout")
			$logged_in=false;
		
		$this->view->header($logged_in);

		/* all users */
		
		$logged_in=$this->auth->checkAuth();
		if ($logged_in) {
			#var_dump($_REQUEST);
			/* actions available to logged in users */
			if (in_array($action,array(
				"hello",
				"logout",
				"create_exercise",
				"run_exercise",
				"complete_exercise",
				"vocview"
				))){

				$this->$action();
			} elseif ($action===null) {
				$this->default_action();
			}else {
				$this->view->actionUnknown($action);
			}
		} else {
			/* actions available to all users */
			if (in_array($action, $logged_out_actions)){
				$this->$action();
			}elseif ($action===null) {
				$this->default_loggedout_action();
			}else {
				$this->view->actionUnknown($action);
			}
		}

		$this->view->footer();
	}

	/** print a friendly message for testers. */
	public function hello() {
		$this->view->hello();
	}

	/** What to do when we don't know what to do */
	public function default_action() {
		$this->run_exercise(true);
	}

	/** What to do when we don't know what to do when we're logged out*/
	public function default_loggedout_action() {
		/* do nothing */
	}

	/** vocabulary viewer mode (when invoked extrenally) */
	public function vocview() {
		$questionLanguages=null;
		$answerLanguages=null;

		if (!isset($_REQUEST['dmid'])) 
			throw new Exception("vocview requested, but no dmid provided");

		if (isset($_REQUEST['questionLanguages'])) {
			$questionLanguages=Util::array_trim(explode(",",$_REQUEST['questionLanguages']));
		}

		if (isset($_REQUEST['answerLanguages'])) {
			$answerLanguages=Util::array_trim(explode(",",$_REQUEST['answerLanguages']));
		}

		$dmid=(int) $_REQUEST['dmid'];
		
		#TODO This may be subvertible. Language class should provide a validation
		# service for untrusted language codes.
		if (isset($_REQUEST['language_code'])) {
			$language_code=$_REQUEST['language_code']; 
			$this->view->setLanguage_byCode($language_code);
		}

		$question=$this->model->vocview_getQuestion($dmid, $questionLanguages, $answerLanguages);
		$this->view->vocview($question);
	}

	/** sets the ui language 
	 * Future: tidy a little bit, allow login to startup with
	 * any language.
	 */
	public function setLanguage() {
		$username=$this->auth->getUsername();
		$userLanguage=$this->model->getUserLanguage($username);
		$this->view->setLanguage_byCode($userLanguage);
	}

	/**create a new exercise using $this->view->exercise_setup();
	 * This function sort of grew over time. TODO Cleanup. */
	public function create_exercise() {
		$questionLanguages=null;
		$answerLanguages=null;
		$defaultCollection=null;

		$user=$this->auth->getUsername();

		if (isset($_REQUEST['questionLanguages'])) {
			$questionLanguages=Util::array_trim(explode(",",$_REQUEST['questionLanguages']));
		}

		if (isset($_REQUEST['answerLanguages'])) {
			$answerLanguages=Util::array_trim(explode(",",$_REQUEST['answerLanguages']));
		}
		
		$hide=array();
		if (isset($_REQUEST['hide_definition']))
			$hide[]="definition";

		if (isset($_REQUEST['hide_words']))
			$hide[]="words";

		if (isset($_REQUEST["defaultCollection"]))
			$defaultCollection=(int) $_REQUEST["defaultCollection"];
		
		if (isset($_REQUEST['exercise_size']) ) {
			return $this->model->createExercise(
					$user,
					(int) $_REQUEST['exercise_size'],
					(int) $_REQUEST['collection'],
					$questionLanguages,
					$answerLanguages,
					$hide
				);
		} elseif (isset($_REQUEST['exercise_size_other']) && is_int($_REQUEST['exercise_size_other']) ) {
			return $this->model->createExercise(
					$user,
					(int) $_REQUEST['exercise_size_other'],
					(int) $_REQUEST['collection'],
					$questionLanguages,
					$answerLanguages,
					$hide
				);
		} else {
			$collectionList=$this->model->collectionList();
			$this->view->exercise_setup($collectionList, $defaultCollection);
			$this->view->footer();
			exit;
		}
	}

	/** Most used part of the program. Performs the actual excercise
	 * question and answer session, until exercise is complete()-d . */
	public function run_exercise($continue=false) {
		$peek=false;
		$question=null;

		# obtain an exercise
		$userName=$this->auth->getUsername();
		$exercise=$this->model->getExercise($userName);
		if ($exercise===null) {
			$exercise=$this->create_exercise();
			#$continue=true;
		}

		# deal with unhides
		$unhides=array();
		if (isset($_REQUEST['unhide_words'])) {
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");
			if ($_REQUEST['questionDmid']==$_REQUEST['unhide_words'])
				$unhides["words"]=(int) $_REQUEST['questionDmid'];
		}

		if (isset($_REQUEST['unhide_definition'])) {
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");

			if ($_REQUEST['questionDmid']==$_REQUEST['unhide_definition'])
				$unhides["definition"]=(int) $_REQUEST['questionDmid'];
		}

		# deal with buttons.

		if (isset($_REQUEST['submitAnswer'])) { #User submitted answer
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");
			$question=$exercise->getQuestion((int) $_REQUEST['questionDmid']);

			if (!isset($_REQUEST['userAnswer']))
				throw new Exception("Answer submitted, but no userAnswer string supplied");
			$userAnswer=$_REQUEST['userAnswer'];

			$correct=$question->submitAnswer($userAnswer);
			$this->model->saveExercise($exercise,$userName);
			$this->view->answer($question, $correct);

		} elseif (isset($_REQUEST['peek'])) { # user peeks at answer, with no consequences
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");
			$question=$exercise->getQuestion((int) $_REQUEST['questionDmid']);
			#$question=$exercise->getQuestion((int) $_REQUEST['questionDmid']);
			#$this->view->answer($question, null);
			#$this->model->saveExercise($exercise,$userName);
			$peek=true;
			$continue=true;
		} elseif (isset($_REQUEST['unhide_words_button'])) { # unhide words
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");
			$question=$exercise->getQuestion((int) $_REQUEST['questionDmid']);
			$unhides["words"]=(int) $_REQUEST['questionDmid'];
			$continue=true;

		} elseif (isset($_REQUEST['unhide_definition_button'])) { # unhide definitions
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Answer submitted, but no dmid integer supplied");
			$question=$exercise->getQuestion((int) $_REQUEST['questionDmid']);
			$unhides["definition"]=(int) $_REQUEST['questionDmid'];
			$continue=true;

		} elseif (isset($_REQUEST['skip'])) {# Skip this question for now
			$continue=true;

		} elseif (isset($_REQUEST['abort'])) {# end the exercise now.
			$this->abort($exercise);

		} elseif (isset($_REQUEST['continue'])) { # continue after viewing answer(s) $this->view->answer() or ...->list()
			$continue=true;

		} elseif (isset($_REQUEST['list_answers'])) { # list all answers. can be slow.

			# Exercise objects implement caching and lazy lookup.  When we list _everything_, we need
			# to look up everything ANYWAY,  so we might as well cache it all too. :-P

			#iterating is currently a destructive operation (oops), so save and restore exercise state...
			$state=$exercise->getCurrentSubset();
			$this->view->listAnswers($exercise); # <- uses iterator (ouw)
			$exercise->setCurrentSubset($state);

			#...so we can take advantage of that local caching ;-)
			$this->model->saveExercise($exercise,$userName);
		} elseif (isset($_REQUEST['hide'])) { # don't ask again this session
			if (!isset($_REQUEST['questionDmid']))
				throw new Exception("Hide requested, but no dmid integer supplied");
			$exercise->hideQuestion_byDMID($_REQUEST['questionDmid']);
			$this->model->saveExercise($exercise,$userName);
			$continue=true;
				
		} elseif (isset($_REQUEST['never_ask'])) { # blacklist permanently
			#to be done
			echo "never ask not yet implemented";
			$continue=true;
		}

		if ($continue) { # Let's go ahead and ask the next question
			try {
				$this->view->ask($exercise, $peek, $question, $unhides);
			} catch (NoMoreQuestionsException $We_Are_Done) {
				$this->complete($exercise);
			}
		}
	}
	
	/** We are done with the exercise.  Let's tidy up.*/	
	public function complete($exercise) {
		$this->view->complete($exercise);
		$this->model->complete($exercise);
	}

	/** Similar to complete() above, except user terminated exercise.*/	
	public function abort($exercise) {
		$this->view->aborted();
		$this->model->complete($exercise);
	}

	/** Create a new user */
	public function new_user() {
		global $dsn;
		$options=array (
			'dsn' => $dsn
		);
		$auth=new Auth("DB", $options, "_displayLogin");
		$username=$_REQUEST["username"];
		$password=$_REQUEST["password"];
		#to be implemented
		#if ($username="") {
		#	$this->view->provideUsername();
		#	$this->view->footer();
		#	exit;
		#}
		$success=$auth->addUser($username, $password);
		if ($success===true) {
			$this->auth->setAuth($username);
			$this->model->setUserLanguage($username,$_REQUEST["userLanguage"]);
			$this->setLanguage();
			$this->view->header(true);
			$this->view->userAdded($username);
			$this->view->footer();
			exit;
		} else {
			$this->view->header(false);
			$this->view->failed_new_user();
			$this->view->footer();
			exit;
		}
	}

	/** performs authentication. This is what calls the _displayLogin
	 * function if the user isn't logged in yet. */
	public function login() {
		$this->auth->start();
		if (!$this->auth->checkAuth()) {
			return false;
			#exit;
		}
		return true;
	}

	/** allow user to log out, and display log-in screen again 
	 *  See also: login, _displayLogin */
	public function logout() {
		if (!$this->auth->checkAuth()) {
			$this->view->permissionDenied();
			#exit;
			return false;
		}
		$this->auth->logout();
		$this->auth->start();
	}

}
?>
