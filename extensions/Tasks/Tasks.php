<?php
/*
To activate, put something like this in your LocalSettings.php:
	define( 'TASKS_CSS' , 'http://yourhost.com/name/wiki/extensions/Tasks/tasks.css' );
	require_once( "extensions/Tasks/Tasks.php" );
	$wgTasksNamespace = 200;
	$wgExtraNamespaces[$wgTasksNamespace] = "Task";
	$wgExtraNamespaces[$wgTasksNamespace+1] = "Task_Talk";

The TASKS_CSS define is only needed if you use a 'non-standard' extensions
directory.


Also, you need to run the following SQL statement (with respect to your table prefix!):
CREATE TABLE tasks (
  task_id int(8) unsigned NOT NULL auto_increment,
  task_page_id int(8) unsigned NOT NULL default '0',
  task_page_title varchar(255) NOT NULL default '',
  task_user_id int(8) unsigned NOT NULL default '0',
  task_user_text varchar(255) NOT NULL default '',
  task_user_assigned int(8) unsigned NOT NULL default '0',
  task_status int(4) unsigned NOT NULL default '0',
  task_comment mediumtext NOT NULL,
  task_type int(4) unsigned NOT NULL default '0',
  task_timestamp varchar(14) binary NOT NULL default '',
  task_user_close int(8) unsigned NOT NULL default '0',
  task_timestamp_closed varchar(14) NOT NULL default '',
  PRIMARY KEY  (task_id),
  KEY task_page_id (task_page_id,task_status,task_type),
  KEY task_page_title (task_page_title)
) TYPE=InnoDB;


Known bugs:
* sidebar task list for Monobook only?

*/

if( !defined( 'MEDIAWIKI' ) ) die();

require_once ( "categoryfinder.php" ) ;

/** Default path to the stylesheet */
global $wgScriptPath ;
if( !defined( 'TASKS_CSS' ) ) define('TASKS_CSS', $wgScriptPath.'/extensions/Tasks/tasks.css' );

/**@+ Task state constants */
define( 'MW_TASK_INVALID',  0 );
define( 'MW_TASK_OPEN',     1 );
define( 'MW_TASK_ASSIGNED', 2 );
define( 'MW_TASK_CLOSED',   3 );
define( 'MW_TASK_WONTFIX',  4 );
/**@-*/

/**
 * The namespace to use needs to be assigned in $wgExtraNamespaces also.
 * Task discussion pages will go here...
 * and... there's a talk namespace also. :P
 */
$wgTasksNamespace = null;

/**
 * Global variable to cache tasks for a page, so sidebar and header check only have to read them once
*/
$wgTaskExtensionTasksCache = array () ;
$wgTaskExtensionTasksCachedTitle = '' ;


# Integrating into the MediaWiki environment

$wgExtensionCredits['Tasks'][] = array(
        'name' => 'Tasks',
        'description' => 'An extension to manage tasks.',
        'author' => 'Magnus Manske'
);

$wgExtensionFunctions[] = 'wfTasksExtension';

# Misc hooks
$wgHooks['SkinTemplatePreventOtherActiveTabs'][] = 'wfTasksExtensionPreventOtherActiveTabs';
$wgHooks['SkinTemplateTabs'][] = 'wfTasksExtensionTab';
$wgHooks['UnknownAction'][] = 'wfTasksExtensionAction';
$wgHooks['ArticleInsertComplete'][] = 'wfTasksExtensionArticleSaveComplete';
$wgHooks['ArticleDeleteComplete'][] = 'wfTasksExtensionArticleDeleteComplete';
$wgHooks['SpecialMovepageAfterMove'][] = 'wfTasksExtensionAfterMove';
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfTasksExtensionAfterToolbox';
$wgHooks['ArticleViewHeader'][] = 'wfTaskExtensionHeaderHook';
$wgHooks['EditPage::showEditForm:initial'][] = 'wfTaskExtensionEditFormInitialHook';
$wgHooks['ParserTestTables'][] = 'wfTasksTestTables';

# BEGIN logging functions
$wgHooks['LogPageValidTypes'][] = 'wfTasksAddLogType';
$wgHooks['LogPageLogName'][] = 'wfTasksAddLogName';
$wgHooks['LogPageLogHeader'][] = 'wfTasksAddLogHeader';
$wgHooks['LogPageActionText'][] = 'wfTasksAddActionText';

function wfTasksAddLogType( &$types ) { # Checked for HTML and MySQL insertion attacks
	if( !in_array( 'tasks', $types ) ) {
		$types[] = 'tasks';
	}
	return true;
}

function wfTasksAddLogName( &$names ) { # Checked for HTML and MySQL insertion attacks
	$names['tasks'] = 'tasks_logpage';
	return true;
}

function wfTasksAddLogHeader( &$headers ) { # Checked for HTML and MySQL insertion attacks
	$headers['tasks'] = 'tasks_logpagetext';
	return true;
}

function wfTasksAddActionText( &$actions ) { # Checked for HTML and MySQL insertion attacks
	$actions['tasks/tasks'] = 'tasks_logentry';
	return true;
}
# END logging functions


#_______________________________________________________________________________

/**
* Text adding function
*/
function wfTasksAddCache() { # Checked for HTML and MySQL insertion attacks
	global $wgTasksAddCache , $wgUserTogglesEn, $wgDefaultUserOptions;
	if( $wgTasksAddCache ) {
		return;
	}
	$wgTasksAddCache = true;
	$wgUserTogglesEn[] = 'show_task_comments' ;

	// Default language is english
	require_once('language/en.php');

	global $wgLang;
	$filename = 'language/' . addslashes($wgLang->getCode()) . '.php' ;
	// inclusion might fail :p
	include( $filename );
}


#___________________________________________________________________
# Hook functions

/**
 * Display header on 'Task:' pages (dummy hook for edit pages)
 * @param EditPage $editPage
 */
function wfTaskExtensionEditFormInitialHook( &$editPage ) { # Checked for HTML and MySQL insertion attacks
	global $wgArticle;
	return wfTaskExtensionHeaderHook( $wgArticle );
}

/**
 * Display header on 'Task:' pages
 * @param Article $article
 */
function wfTaskExtensionHeaderHook( &$article ) { # Checked for HTML and MySQL insertion attacks
	global $wgTasksNamespace, $wgOut, $wgUser, $wgTitle;
	$title = $article->getTitle();
	$ns = $title->getNamespace();
	if( $ns != $wgTasksNamespace && $ns != $wgTasksNamespace+1 ) {
		// Show sign, if any, then we can leave
		wfTaskExtensionHeaderSign();
		return true;
	}
	
	$subtitle = '';
	
	if( ctype_digit( $title->getText() ) ) {
		// Page title format 'Task:123', suggested by Rowan Collins
		$taskid = intval( $title->getText() );
	} else {
		// Invalid page title; can't extract the task id
		return true;
	}
	
	wfTasksAddCache();
	$st = new SpecialTasks();
	$task = '';
	$page_title = $st->get_title_from_task( $taskid, $task );
	if( $task == '' ) {
		# No such task
		return true;
	}

	$sk =& $wgUser->getSkin();
	$returnto = $wgTitle->getFullURL();
	$link1 = $sk->makeLinkObj( $page_title );
	$link2 = $sk->makeLinkObj( $page_title, wfMsgHTML( 'tasks_here' ), 'action=tasks' );
	$subtitle .= '<div id="task_header">' . wfMsgForContent( 'tasks_discussion_page_for', $link1, $link2 ) . "</div>\n" ;
	$subtitle .= '<table border="1" cellspacing="1" cellpadding="2" id="task_header_table">' . 
				'<tr>' . wfTaskExtensionGetTableHeader( false ) . "</tr>\n";
	$subtitle .= $st->get_task_table_row( $task, $page_title, false, $returnto );
	$subtitle .= "</table>\n";
	
	$subtitle = $wgOut->getSubtitle() . '<br />' . $subtitle;
	$wgOut->setSubtitle( $subtitle );
	return true;
}

/**
 * Display header signs for "notable" tasks
 */
function wfTaskExtensionHeaderSign() {
	global $wgTitle, $wgOut;

	if( $wgTitle->isTalkPage() ) {
		# No talk pages please
		return;
	}
	if( $wgTitle->getNamespace() < 0 ) {
		# No special pages please
		return;
	}

	wfTasksAddCache();
	$st = new SpecialTasks();
	$tasks = $st->get_open_task_list( $wgTitle, true );
	if( count( $tasks ) == 0 ) {
		# No tasks	
		return;
	}
	
	$out = '';
	$max = 0;
	foreach( $tasks as $task ) {
		$ttype = $st->get_task_type( $task->task_type );
		$msg = wfMsgForContent( 'tasks_sign_' . $ttype );
		if( $msg == '' ) {
			# No sign defined for this
			continue;
		}

		$order = $st->get_task_order( $ttype );
		if( $order > $max ) {
			$max = $order;
			$max_type = $ttype;
			$max_task = $task;
			$max_msg = $msg;
		}
	}

	if( $max == 0 ) {
		# Nothing for you to see here, please move along
		return;
	}
	
	// Wiki-safe output
	$out = $wgOut->parse( '<div id="task_sign">' . $max_msg . '</div>' );
	
	$subtitle = $wgOut->getSubtitle() . '<br />' . $out;
	$wgOut->setSubtitle( $subtitle );
}

/**
* Return the header
*/
function wfTaskExtensionGetTableHeader( $with_title = false ) {
	$s = wfMsgHTML( 'tasks_existing_table_header' );
	if( $with_title ) {
		$s = wfMsgHTML( 'tasks_table_header_page' ) . '|' . $s;
	}
	$s = '<th>' . str_replace( '|', '</th><th>', $s ) . '</th>';
	return $s;
}

/**
* Display in sidebar
*/
function wfTasksExtensionAfterToolbox( &$tpl ) { # Checked for HTML and MySQL insertion attacks
	global $wgTitle;
	if( $wgTitle->isTalkPage() ) {
		# No talk pages please
		return;
	}
	if( $wgTitle->getNamespace() < 0 ) {
		# No special pages please
		return;
	}
	
	wfTasksAddCache();
	$st = new SpecialTasks;
	$tasks = $st->get_open_task_list( $wgTitle, true );
	if( count( $tasks ) == 0 ) {
		# No tasks	
		return;
	}

?>

			</ul>
		</div>
	</div>
	<div class="portlet" id="p-tasks">
		<h5><?php $tpl->msg('tasks_sidebar_title') ?></h5>
		<div class="pBody">
			<ul>
<?php
	foreach( $tasks as $task ) {
		$ttype = $st->get_task_type( $task->task_type );
?>
			<li id="task_sidebar_<?php echo $ttype ?>">
			<a href="<?php
				$nt = $st->get_task_discussion_page( $task );
				echo $nt->escapeLocalURL();
				?>"><?php
				echo $st->get_type_html( $ttype );
				?></a><?php
				if( $task->task_user_assigned != 0 ) {
					echo ' ' . wfMsgHTML( 'tasks_task_is_assigned' );
				}
				?></li>
<?php
		
	}
	return true ;
}

/**
* Catch page movement, fix internal task_page_title values
*/
function wfTasksExtensionAfterMove( &$special_page, &$old_title, &$new_title ) { # Checked for HTML and MySQL insertion attacks
	if( $new_title->isTalkPage() ) {
		# No tasks for talk pages, no need to bother the database...
		return false;
	}

	wfTasksAddCache();

	$st = new SpecialTasks;
	$st->rename_tasks_page( $old_title, $new_title );
	return false;
}


/**
* Catch article deletion, remove all tasks
*/
function wfTasksExtensionArticleDeleteComplete( &$article, &$user, $reason ) { # Checked for HTML and MySQL insertion attacks
	# return false ; # Uncomment this line to prevent deletion of tasks upon deletion of article
	wfTasksAddCache();
	$t = $article->getTitle();
	if( $t->isTalkPage() ) {
		# No tasks for talk pages, no need to bother the database...
		return false;
	}

	$st = new SpecialTasks;
	$st->delete_all_tasks( $t );
	return false;
}

/**
 * Catch article creation, to close "create" tasks, and optionally
 * open a default task on new page creation.
 *
 * @param Article $article
 * @param User $user
 * @param string $text
 * @param string $summary
 * @param bool $isminor
 * @param bool $watchthis
 * @param mixed $something WHAT THE HELL IS THIS
 * @return bool true to continue, false to cancel operation <- WHAT THE HELL
 */
function wfTasksExtensionArticleSaveComplete( &$article, &$user, $text, $summary, $isminor, $watchthis, $something ) { # Checked for HTML and MySQL insertion attacks
	global $wgUser;
	wfTasksAddCache();
	$t = $article->getTitle();
	if( $t->isTalkPage() ) {
		# No tasks for talk pages, no need to bother the database...
		return false;
	}
	
	$st = new SpecialTasks;
	$tasks = $st->get_tasks_for_page( $t, true );
	
	# Mark creation tasks as closed
	foreach( $tasks as $task ) {
		if( !$st->is_creation_task( $task->task_type ) ) {
			# Not a "create" task
			continue;
		}
		if( $st->is_closed( $task->task_status ) ) {
			# Not open
			continue;
		}
		$st->change_task_status( $task->task_id, MW_TASK_CLOSED );
		$st->set_new_article_id( $t );
		
		$id = $t->getArticleId();
		# Nothing more to do
		break;
	}
	
	# OPTIONALLY create a new task 
	$on_create = $st->get_task_num( wfMsgForContent( 'tasks_event_on_creation' ) );
	$on_create_anon = $st->get_task_num( wfMsgForContent( 'tasks_event_on_creation_anon' ) );
	$add_task = MW_TASK_INVALID;
	if( $wgUser->isAnon() && $on_create_anon != MW_TASK_INVALID ) {
		$add_task = $on_create_anon;
	} elseif( $wgUser->isLoggedIn() && $on_create != MW_TASK_INVALID ) {
		$add_task = $on_create;
	}
	if( $add_task != MW_TASK_INVALID ) {
		$comment = htmlspecialchars( wfMsgForContent( 'tasks_on_creation_comment' ) );
		$st->add_new_task( $t, $comment, $add_task ) ;
	}
	
	return false;
}

/**
* Prevents other tabs shown as active
*/
function wfTasksExtensionPreventOtherActiveTabs( &$skin, &$prevent_active_tabs ) { # Checked for HTML and MySQL insertion attacks
	global $action;
	$prevent_active_tabs = ( $action == 'tasks' );
	return true;
}

/**
 * Show the tab
 * @param SkinTemplate $skin
 * @param array $content_actions
 * @return bool true to continue running other hooks, false to abort operation
 */
function wfTasksExtensionTab( &$skin, &$content_actions ) { # Checked for HTML and MySQL insertion attacks
	global $wgTitle, $action;
	if( $wgTitle->isTalkPage() ) {
		# No talk pages please
		return true;
	}
	if( $wgTitle->getNamespace() < 0 ) {
		# No special pages please
		return true;
	}

	wfTasksAddCache();
	$content_actions['tasks'] = array(
		'class' => ($action == 'tasks') ? 'selected' : false,
		'text' => wfMsgHTML('tasks_tab'),
		'href' => $wgTitle->getLocalUrl( 'action=tasks' )
	);
	return true;
}

/**
* This is where the action is :-)
*/
function wfTasksExtensionAction( $action, $article ) { # Checked for HTML and MySQL insertion attacks
	if( $action != 'tasks' ) {
		# Not my kind of action!
		return true;
	}
	
	wfTasksAddCache();
	
	$t = new SpecialTasks;
	$t->page_management( $article->getTitle() );
	
	return false;
}

#_____________________________________________________________________________

/**
* The special page
*/
function wfTasksExtension() { # Checked for HTML and MySQL insertion attacks
	global $IP, $wgMessageCache;
	wfTasksAddCache();

	// FIXME : i18n
	$wgMessageCache->addMessage( 'tasks', 'Tasks' );

	require_once $IP.'/includes/SpecialPage.php';

	class SpecialTasks extends SpecialPage {
	
		var $status_types = array(
			MW_TASK_OPEN     => 'open',
			MW_TASK_ASSIGNED => 'assigned',
			MW_TASK_CLOSED   => 'closed',
			MW_TASK_WONTFIX  => 'wontfix'
		);
		var $task_types; # e.g., 0 => 'cleanup'
		var $task_types_text; # e.g., 'cleanup' => 'Clean up'
		var $creation_tasks; # e.g., ( 1, 2, 3 )
		var $task_order = array(); # e.g., 'delete' => 5
		var $pagemode = '' ;
	
		/**
		* Constructor
		*/
		function SpecialTasks() { # Checked for HTML and MySQL insertion attacks
			SpecialPage::SpecialPage( 'Tasks' );
			$this->includable( true );
			$this->update_types();
		}
		
		/**
		 * Returns the order of the type, or 0 if not defined
		 * @param string $type key like 'create' or 'cleanup'
		 * @return int
		 */
		function get_task_order( $type ) { # Checked for HTML and MySQL insertion attacks
			if( isset( $this->task_order[$type] ) ) {
				return $this->task_order[$type];
			} else {
				return 0;
			}
		}
		
		/**
		 * Returns the type constant associated with the text key, or MW_TASK_INVALID
		 * @param string $type text key
		 * @return int
		 */
		function get_task_num( $type ) { # Checked for HTML and MySQL insertion attacks
			$key = array_search( trim( strtolower( $type ) ), $this->task_types );
			if( $key === false ) {
				wfDebug( 'Tasks: get_task_num was passed illegal text key : ' . $type . " (out of range)\n" );
				return MW_TASK_INVALID;
			} else {
				return $key;
			}
		}
		
		/**
		 * Returns the text key for a given task type constant
		 * @param $num numeric key
		 * @return string
		 */
		function get_task_type( $num ) { # Checked for HTML and MySQL insertion attacks
			if( !isset( $this->task_types[$num] ) ) {
				wfDebug( 'Tasks: get_task_type was passed illegal num : ' . $num . " (out of range)\n" );
				return MW_TASK_INVALID;
			}
			return $this->task_types[$num];
		}
		
		/**
		 * Updates task_types and creation_tasks from wfMsg
		 * @fixme Provide localized display names for user's UI language
		 */
		function update_types() { # Checked for HTML and MySQL insertion attacks
			wfTasksAddCache();
			
			# task type numeric key, text key, localized text
			$this->task_types = array();
			$s = wfMsgForContent( 'tasks_task_types' );
			$s = explode( '|', $s );
			foreach( $s as $line ) {
				$bits = explode( ':', $line, 3 );
				if( count( $bits ) != 3 ) {
					# Invalid line
					continue;
				}
				$keyNum = intval( $bits[0] );
				$keyName = trim( $bits[1] );
				$localName = trim( $bits[2] );
				if( $keyNum < 1 ) {
					wfDebug( 'SpecialTasks::update_types: expected positive integer for key, got ' . $keyNum . "\n" );
					continue;
				}
				$this->task_types[$keyNum] = $keyName;
				$this->task_types_text[$keyName] = $localName;
			}
			
			# List of creation-type tasks
			$this->creation_tasks = array();
			$s = wfMsgForContent( 'tasks_creation_tasks' );
			$s = explode( ',', $s );
			foreach( $s as $line ) {
				$keyNum = intval( $line );
				if( $keyNum < 1 ) {
					wfDebug( 'SpecialTasks::update_types: expected positive integer for key in tasks_creation_tasks, got ' . $keyNum . "\n" );
					continue;
				}
				$this->creation_tasks[] = $keyNum;
			}
			
			$this->task_order = array();
			$s = wfMsgForContent( 'tasks_significance_order' );
			$s = explode( '<' , $s );
			$count = 1;
			foreach( $s as $line ) {
				$line = trim( $line );
				if( $line != '' ) {
					$this->task_order[$line] = $count++;
				}
			}
		}
		
		/**
		 * @param string $type_key 'open', 'wontfix', etc
		 * @return string localized name as text: 'Open', 'Nefarinda', etc
		 */
		function get_type_text( $type_key ) { # Checked for HTML and MySQL insertion attacks
			if( !isset( $this->task_types_text[$type_key] ) ) {
				wfDebug( 'Tasks: get_type_text was passed illegal type_key : ' . $type_key . " (out of range)\n" );
				return '';
			}
			return $this->task_types_text[$type_key];
		}
		
		/**
		 * @param string $type_key
		 * @return string HTML-escaped localized name
		 */
		function get_type_html( $type_key ) {
			return htmlspecialchars( $this->get_type_text( $type_key ) );
		}

		/**
		 * @param int $task_type key
		 * @return bool
		 */
		function is_creation_task( $task_type ) { # Checked for HTML and MySQL insertion attacks
			return in_array( $task_type, $this->creation_tasks );
		}
		
		/**
		 * @param int $status key
		 * @return bool
		 */
		function is_open( $status ) { # Checked for HTML and MySQL insertion attacks
			return ( $status == MW_TASK_OPEN || $status == MW_TASK_ASSIGNED );
		}

		/**
		 * @param int $status key
		 * @return bool
		 */
		function is_closed( $status ) { # Checked for HTML and MySQL insertion attacks
			return !$this->is_open( $status );
		}
		
		/**
		 * Takes a title and a list of existing tasks, and decides which new tasks can be created.
		 * There's no point in having a dozen "wikify" tasks for a single article, now is there? :-)
		 * @param Title $title
		 * @param array $tasks out-parameter, will receive the set of existing tasks
		 * @return array set of creatable tasks....?
		 */
		function get_valid_new_tasks( $title, &$tasks ) { # Checked for HTML and MySQL insertion attacks
			$exists = $title->exists();
			$tasks = $this->get_tasks_for_page( $title );
			$new_tasks = array();
			$tg = array();
			
			foreach( $tasks as $t ) {
				# Assemble types; if multiple of one type, assemble open ones
				if( !isset( $tg[$t->task_type] ) || $this->is_open( $t->task_status ) ) {
					$tg[$t->task_type] = $t->task_status;
				}
			}
			
			foreach( array_keys( $this->task_types ) as $a ) {
				if( $exists == $this->is_creation_task( $a ) ) {
					# Creation task and existence exclude each other
					continue;
				}
				if( isset( $tg[$a] ) && $this->is_open( $tg[$a] ) ) {
					# Task exists and is not closed
					continue;
				}
				$new_tasks[$a] = $this->get_task_type( $a );
			}
			return $new_tasks;
		}

		/**
		 * The form for creating a new task from a form ("tasks" tab)
		 * @return string HTML output
		 * @fixme Display error messages on invalid input
		 */
		function create_from_form( $title ) { # Checked for HTML and MySQL insertion attacks
			global $wgRequest, $wgUser;
			if( $wgRequest->getText( 'create_task', '' ) == '' ) {
				# No form
				return '';
			}
			
			$out = '';
			$tasks = array();
			$type = $wgRequest->getInt( 'type' );
			$name = $wgRequest->getText( 'username' );
			
			$comment = $wgRequest->getText( 'text', '' ); # Not evaluated here; stored in database through safe database function
			$new_tasks = $this->get_valid_new_tasks( $title, $tasks );
			if( !isset( $new_tasks[$type] ) ) {
				# Trying to create a task that isn't available
				$out .= '<p>' . wfMsgHtml('tasks_error1') . '</p>';
			} else {
				$this->add_new_task( $title, $comment, $type, $name );
				$out .= '<p>' . wfMsgHtml( 'tasks_ok1' ) . '</p>';
			}
			return $out;
		}
		
		/**
		 * Adds a new task
		 */
		function add_new_task( $title, $comment, $type, $name ) {
			global $wgUser;
			$dbw =& wfGetDB( DB_MASTER );
			$user_id = 0;
			if ( !is_null($name) ) {
			  $user_id = $wgUser->idFromName($name);
			  if ( !ctype_digit($user_id) ) {
			    $user_id = 0; # (int)0 indicates assigned to "no one"
			  }
			}
			$dbw->insert( 'tasks',
				array(
					'task_page_id'       => $title->getArticleID(),
					'task_page_title'    => $title->getPrefixedDBkey(),
					'task_user_id'       => $wgUser->getID(),
					'task_user_text'     => $wgUser->getName(),
					'task_user_assigned' => $user_id,
					'task_status'        => $this->get_status_number( 'open' ),
					'task_comment'       => $comment,
					'task_type'          => $type,
					'task_timestamp'     => $dbw->timestamp()
					) );
		}
		
		/**
		* For a list of tasks, get a single table row
		* This function is heavy on output!
		*/
		function get_task_table_row( &$task, &$title, $show_page = false, $returnto = '' ) { # Checked for HTML and MySQL insertion attacks
			global $wgContLang, $wgUser, $wgTasksNamespace, $wgExtraNamespaces;
			$out = '';
			$sk =& $wgUser->getSkin();
			$ct = $wgContLang->timeanddate( $task->task_timestamp ); # Time object from string of digits
			$cu = Title::makeTitleSafe( NS_USER, $task->task_user_text ); # Safe user name
			$comment = htmlspecialchars( $task->task_comment ); # Safe user comment, no HTML allowed
			$comment = nl2br( $comment ); # display newlines as they were in the edit box
			$status = $task->task_status; # Integer
			$tid = $task->task_id; # Integer
			$encType = $this->get_type_html( $this->get_task_type( $task->task_type ) ); # Will catch illegal types and wfDebug them
			if( $returnto != '' ) {
				$returnto = '&returnto=' . urlencode( $returnto );
			}

			$out .= '<tr>';
			if( $show_page ) {
				$out .= '<td align="left" valign="top">';
				$out .= $sk->makeLinkObj( $title );
				$out .= '<br />';
				$out .= $sk->makeLinkObj( $title, wfMsgHTML('tasks_see_page_tasks'), 'action=tasks' );
				$out .= '</td>';
			}
			$out .= '<td valign="top" align="left" nowrap class="tasks_status_bgcol_' . $this->status_types[$status] . '">';
			$out .= '<b>' . $encType . '</b><br /><i>';
			$out .= wfMsgForContent( 'tasks_status_' . $this->status_types[$status] );
			$out .= '</i><br />' ;
			
			# Additional info
			$help_title = Title::makeTitleSafe( NS_HELP, wfMsgForContent('tasks_help_page') );
			$help_title->mFragment = $encType ;
			$ext1 = $sk->makeLinkObj( $help_title , wfMsgForContent('tasks_help_page_link') );
			$more_title = Title::makeTitleSafe( NS_SPECIAL, 'Tasks'); # This special page
			$ext2 = $sk->makeLinkObj( $more_title , wfMsgForContent('tasks_more_like_it') , 'task_type='.$task->task_type );
			$out .= wfMsgForContent ( 'tasks_help_separator' , $ext1 , $ext2 ) ;
			
			
			$out .= '</td>';
			$out .= '<td align="left" valign="top" nowrap>';
			$out .= wfMsgHTML( 'tasks_created_by', $sk->makeLinkObj( $cu, htmlspecialchars( $task->task_user_text ) ) );
			$out .= '<br />' . $ct ;

			# Closing information
			if( $task->task_user_close != 0 && $this->is_closed( $status ) ) {
				$user_close = new User;
				$user_close->setID( $task->task_user_close );
				$uct = Title::makeTitleSafe( NS_USER, $user_close->getName() ); # Assigned user title
				$out .= '<br />' . wfMsgHTML( 'tasks_closedby', $sk->makeLinkObj( $uct, htmlspecialchars( $user_close->getName() ) ) );
				if( $task->task_timestamp_closed != "" ) {
					$out .= '<br />' . $wgContLang->timeanddate( $task->task_timestamp_closed ); # Time object from string of digits
				}
			}
			$out .= '</td>';

			$out .= '<td align="left" valign="top">' . $comment . '</td>' ; # Comment is HTML-stripped
			$out .= '<td align="left" valign="top">';
			if( $task->task_user_assigned == 0 ) {
				# Noone is assigned this task
				$out .= '<form method="get">' // Added a form in place of old "assign to me" link
				     . wfMsgHTML( 'tasks_assign_to' ) . ' <input type="text" name="username" />'
				     . '<input type="hidden" name="action" value="tasks" />'
				     . '<input type="hidden" name="mode" value="assignto" />'
				     . '<input type="hidden" name="title" value="'.htmlspecialchars($title->getPrefixedText()).'" />'
				     . '<input type="hidden" name="taskid" value="'.$tid.'" />'
				     . '<input type="submit" name="submit" value="' . wfMsgHTML( 'ok' ) . '" />'
				     . '</form>';
			} else {
				# Someone is assigned this task
				$au = new User(); # Assigned user
				$au->setID( $task->task_user_assigned );
				$aut = Title::makeTitleSafe( NS_USER, $au->getName() ); # Assigned user title
				$out .= wfMsgHTML( 'tasks_assignedto', $sk->makeLinkObj( $aut, htmlspecialchars( $au->getName() ) ) );
			}
			if( $wgUser->isLoggedIn() ) {
				$txt = array();
				if( $this->is_open( $status ) ) {
					# Assignment
					if( $wgUser->getID() != $task->task_user_assigned ) {
						# Assign myself
						$txt[] = $sk->makeLinkObj( $title,
							wfMsgHTML( 'tasks_assign_me' ),
							"action=tasks&mode=assignme&taskid={$tid}{$returnto}" ); # tid is integer, returnto is safe
					} else {
						# Unassign myself
						$txt[] = $sk->makeLinkObj( $title,
							wfMsgHTML( 'tasks_unassign_me' ),
							"action=tasks&mode=unassignme&taskid={$tid}{$returnto}" ); # tid is integer, returnto is safe
					}
				}
				if( $this->is_open( $status ) ) {
					# Open or assigned
					$txt[] = $sk->makeLinkObj( $title, wfMsgHTML( 'tasks_close' ), "action=tasks&mode=close&taskid={$tid}{$returnto}" );
					$txt[] = $sk->makeLinkObj( $title, wfMsgHTML( 'tasks_wontfix' ), "action=tasks&mode=wontfix&taskid={$tid}{$returnto}" );
				} else if( $this->get_task_type( $task->task_type ) != 'create' ) {
					# Closed or wontfix, can reopen (maybe)
					$txt[] = $sk->makeLinkObj( $title, wfMsgHTML( 'tasks_reopen' ), "action=tasks&mode=reopen&taskid={$tid}{$returnto}" );
				}
				
				if( $wgUser->isAllowed( 'delete' ) ) {
					$txt[] = $sk->makeLinkObj( $title, wfMsgHTML( 'tasks_delete' ), "action=tasks&mode=delete&taskid={$tid}{$returnto}" );
				}
				
				if( count( $txt ) > 0 ) {
					$out .= '<br />' . implode( ' - ', $txt );
				}

			}
			$tdp = $this->get_task_discussion_page( $task );
			$out .= '<br />' . $sk->makeLinkObj( $tdp, wfMsgHTML('tasks_discussion_page_link') );
			$out .= '</td></tr>' ;
			
			# Transclude comments page, if wanted
			if( $wgUser->getOption( 'show_task_comments' ) ) {
				if( $this->pagemode == 'search' || $this->pagemode == 'tasks_of_page' ) {
					$out .= $this->transclude_comments( $tdp, $show_page ? 5 : 4 ) ;
				}
			}
			return $out;
		}

		/**
		 * Returns the 
		 * @param Title $title of task page to load
		 * @param int $col_compensator Number of table columns to span
		 * @return string HTML table row, or empty string
		 * @access private
		 */
		function transclude_comments( $title, $col_compensator ) {
			if( !$title->exists() ) {
				# Nothing to transclude
				return '';
			}
			
			global $wgOut;
			$art = new Article( $title );
			$ret = $art->getContent( false );
			$ret = $wgOut->parse( $ret );
			return '<tr><td id="task_transcluded_comment" colspan="' . $col_compensator . '">' . $ret . '</td></tr>' ;
		}

		/**
		 * @param Task $task
		 * @return Title
		 */
		function get_task_discussion_page( &$task ) { # Checked for HTML and MySQL insertion attacks
			global $wgTasksNamespace;
			# Format : "Task:123"
			return Title::makeTitle( $wgTasksNamespace, strval( $task->task_id ) );
		}

		/**
		* On the "tasks" tab, show the list of existing tasks for that article
		*/
		function show_existing_tasks( &$title, &$tasks ) { # Checked for HTML and MySQL insertion attacks
			$out = '';
			foreach( $tasks as $task ) {
				$out .= $this->get_task_table_row( $task, $title ); # Assumed safe
			}
			if( $out == '' ) {
				return '';
			}

			$out = "<h2>" . wfMsgHTML( 'tasks_existing_header' ) . "</h2>\n" .
				"<table border='1' cellspacing='1' cellpadding='2'>" . 
				"<tr>" . wfTaskExtensionGetTableHeader() . "</tr>" .
				$out . "</table>";
			return $out;
		}
		
		/**
		 * Checks if there's a "mode" set in the URL of the current page
		 * (performs changes on tasks, like assigning or closing them)
		 * @return HTML output
		 * @fixme There is no output! Should there be? No error output either.
		 */
		function check_mode( $title ) {

			global $wgUser, $wgRequest;

			$mode = trim( $wgRequest->getVal( 'mode' ) );
			$name = trim( $wgRequest->getVal( 'username' ) );
			$taskid = $wgRequest->getInt( 'taskid', 0 );

			if( $mode == '' || $taskid == 0 ) {
				# Simple validation
				return '';
			}
			if( !$wgUser->isLoggedIn() ) {
				# Needs to be logged in
				return '';
			}
			
			$out = '';
			$fname = 'Tasks::check_mode';
			$dbw =& wfGetDB( DB_MASTER );

			switch( $mode ) {

			case 'assignto':
			case 'assignme':
			case 'unassignme':

				// Assign or unassign an existing used to this task
				$conditions = array( 'task_id' => $taskid );
				$user_id = $wgUser->getId() ; # Assign
				if( $mode == 'unassignme' ) {
					# Unassign me; this can be invoked for every user by editing the URL!
					$user_id = 0;
				} else if ( $mode == 'assignto' ) {
				  $user_id = $wgUser->idFromName($name);
				  if ( empty($user_id) ) {
				    break; # break as though "mode" were undefined (no action)
				  }
				}
				$do_set = array( # SET
					'task_user_assigned' => $user_id, # Coming from $wgUser, so assumed safe
					'task_status' => ( $mode == 'assignme' )
						? $this->get_status_number( 'assigned' )
						: $this->get_status_number( 'open' ), # Integer
					);
				$dbw->update( 'tasks',
					$do_set,
					$conditions,
					$fname );

				$title = $this->get_title_from_task( $taskid, $task );
				$act = wfMsgHTML( 'tasks_assigned_myself_log',
					$this->get_type_html( $this->get_task_type( $task->task_type ) ) );
				$log = new LogPage( 'tasks' );
				$log->addEntry( 'tasks', $title, $act );

				break;

			case 'close':
			case 'wontfix':
			case 'reopen':

				# Changing task status
				if( $mode == 'reopen' ) {
					$mode = 'open';
				}
				if( $mode == 'close' ) {
					$mode = 'closed';
				}
				$new_status = $this->get_status_number( $mode );
				$this->change_task_status( $taskid, $new_status );

				break;

			case 'delete':

				# Delete this task; sysops only!
				if( $wgUser->isAllowed( 'delete' ) ) {
					# OK, deleting
					$dbw->delete( 'tasks',
						array( 'task_id' => $taskid ),
						$fname );
					
					# Log task deletion
					$act = wfMsgForContent( 'tasks_action_delete' );
					$log = new LogPage( 'tasks' );
					$log->addEntry( 'tasks', $title, $act );
					$out .= wfMsgHtml( 'tasks_task_was_deleted' );
				} else {
					# No-no!
					global $wgOut;
					$wgOut->setPageTitle( wfMsg( 'tasks_no_task_delete_title' ) );
					$wgOut->addWikiText( wfMsg( 'tasks_no_task_delete_text' ) );
					return '';
				}

				break;

			default:
				# Unknown mode
				return '';
			} // end switch()

			return $out;
		}
		
		/**
		 * Returns the number for the status
		 * @param string $status key
		 * @return int
		 */
		function get_status_number( $status ) { # Checked for HTML and MySQL insertion attacks
			foreach( $this->status_types as $k => $v ) {
				if( $v == $status ) {
					return $k;
				}
			}
			# Invalid status
			return 0;
		}
		
		/**
		 * Changes the status of a task, performs some associated cleanup, and logs the action
		 */
		function change_task_status( $taskid, $new_status ) { # Checked for HTML and MySQL insertion attacks
			global $wgUser;
			$fname = 'Tasks:change_task_status';
			$dbw =& wfGetDB( DB_MASTER );
			
			if( !is_numeric( $new_status ) || !is_numeric( $taskid ) ) {
				# Paranoia
				return;
			}

			# What to change:
			$as = array( 'task_status' => $new_status );
			# Where to change it:
			$aw = array( 'task_id' => $taskid );
			
			if( $this->is_closed( $new_status ) ) {
				# When closing, set closing user ID, and reset assignment
				$as['task_user_close'] = $wgUser->getID();
				$as['task_user_assigned'] = 0;
				$as['task_timestamp_closed'] = $dbw->timestamp(); # Assumed safe
			} elseif( $new_status == $this->get_status_number( 'open' ) ) {
				# Change to "open", no assigned user or closing user
				$as['task_user_assigned'] = 0;
				$as['task_user_close'] = 0;
				$as['task_timestamp_closed'] = '';
			}
			
			$dbw->update( 'tasks',
				$as, # SET
				$aw, # WHERE
				$fname );

			# Logging
			$title = $this->get_title_from_task( $taskid, $task );
			$act = wfMsgHTML( 'tasks_action_' . $this->status_types[$new_status],
				$this->get_type_html( $this->get_task_type( $task->task_type ) ) );
			$log = new LogPage( 'tasks' );
			$log->addEntry( 'tasks', $title, $act );
		}
		
		
		/**
		 * Returns the list of active tasks for this page, for display in the sidebar
		 */
		function get_open_task_list( &$title, $useCache = false ) { # Checked for HTML and MySQL insertion attacks

			global $wgTaskExtensionTasksCachedTitle , $wgTaskExtensionTasksCache ;

			if( $useCache && $wgTaskExtensionTasksCachedTitle == $title->getPrefixedText() ) {
				# Return the cache, thus skip the query and increase shareholder value
				return $wgTaskExtensionTasksCache;
			}

			$tasks = $this->get_tasks_for_page( $title );
			$ret = array();
			foreach( $tasks as $task ) {
				if( $this->is_open( $task->task_status ) ) {
					$ret[$this->get_type_html( $this->get_task_type( $task->task_type ) )] = $task;
				}
			}
			ksort( $ret );
			if( $useCache ) {
				# Store results in cache for further use
				$wgTaskExtensionTasksCache = $ret;
				$wgTaskExtensionTasksCachedTitle = $title->getPrefixedText();
			}
			return $ret;
		}

		/**
		 * Returns the title object for a task, and the task data through reference
		 * If no task can be found, return ''
		 * @param int $task_id
		 * @param Task $task warning: out-param
		 * @return Title
		 */
		function get_title_from_task( $task_id, &$task ) { # Checked for HTML and MySQL insertion attacks
			$task = $this->get_task_from_id( $task_id );

			if( $task == '' ) {
				return '';
			} elseif ( $task->task_page_id == 0 ) { # Non-existing page
				$title = Title::newFromDBkey( $task->task_page_title );
			} else { # Existing page
				$title = Title::newFromID( $task->task_page_id );
			}
			return $title;
		}
		
		/**
		 * Returns a single task by its ID
		 */
		function get_task_from_id( $task_id ) { # Checked for HTML and MySQL insertion attacks
			if( !is_numeric( $task_id ) ) {
				# Paranoia
				return null;
			}
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(
					/* FROM   */ 'tasks',
					/* SELECT */ '*',
					/* WHERE  */ array( 'task_id' => $task_id )
			);
			$task = $dbr->fetchObject( $res );
			$dbr->freeResult( $res );
			return $task;
		}
		
		/**
		 * Sets the article ID (on page creation)
		 */
		function set_new_article_id( &$title ) { # Checked for HTML and MySQL insertion attacks
			$fname = 'Tasks:set_new_article_id';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( 'tasks',
				array( 'task_page_id' => $title->getArticleID() ), # SET
				array( 'task_page_title' => $title->getPrefixedDBkey() ), # WHERE
				$fname );
		}

		/**
		 * Deletes all tasks associated with an article; done on article deletion
		 * @fixme this is only used on page deletion at the moment; will all conditions be used?
		 */
		function delete_all_tasks( $title ) { # Checked for HTML and MySQL insertion attacks
			$fname = 'Tasks:delete_all_tasks';
			if( $title->exists() ) {
				$conds = array( 'task_page_id' => $title->getArticleID() );
			} else {
				$conds = array( 'task_page_title' => $title->getPrefixedDBkey() );
			}
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->delete( 'tasks',
				$conds,
				$fname );
		}
		
		/**
		* Called for page moves
		*/
		function rename_tasks_page( $old_title, $new_title ) { # Checked for HTML and MySQL insertion attacks
			$fname = 'Tasks:rename_tasks_page';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( 'tasks',
				array( 'task_page_title' => $new_title->getPrefixedDBkey() ), # SET
				array( 'task_page_title' => $old_title->getPrefixedDBkey() ), # WHERE
				$fname );			
		}
		
		/**
		* THIS IS THE MAIN FUNCTION FOR THE TAB-BASED INTERFACE
		*/
		function page_management( $title ) { # Checked for HTML and MySQL insertion attacks
			if( $title->isTalkPage() ) {
				# No tasks for talk pages, no need to bother the database...
				return;
			}
			
			global $wgOut, $action, $wgRequest, $wgUser, $wgTitle;
			$out = '';
			$tasks = array();
			$wgOut->addLink(array(
				'rel'	=> 'stylesheet',
				'type'	=> 'text/css',
				'media'	=> 'screen,projection',
				'href'	=> TASKS_CSS,
			));
			$wgOut->setSubtitle( wfMsgHTML( 'tasks_title', $title->getPrefixedText() ) );
			$this->pagemode = 'tasks_of_page' ;
			
			# Create from form
			$out .= $this->create_from_form( $title );
			
			# Check for mode
			$out .= $this->check_mode( $title );
			
			# Get list of tasks that can be created
			$new_tasks = $this->get_valid_new_tasks( $title, $tasks );
			
			# Show task creation form, if tasks can be created
			$out .= $this->generate_form( $new_tasks );
			
			# Existing tasks
			$out .= $this->show_existing_tasks( $title, $tasks );

			# And ... out!
			$returnto = $wgRequest->getVal( 'returnto' );
			if( $this->isValidRedirect( $returnto ) ) {
				# Forward to other page
				$wgOut->redirect( $returnto );
				
				$skin =& $wgUser->getSkin();
				$link = $skin->makeExternalLink( $returnto, wfMsgHTML( 'tasks_here' ) );
				$msg = wfMsgHTML( 'tasks_returnto', $link );
				$wgOut->addHTML( $msg );
			} else {
				$this->setHeaders();
				$wgOut->addHtml( $out );
			}
		}
		
		/**
		 * Confirm that the given redirect page is local to this site
		 * FIXME: this can still pass you anywhere on the domain,
		 * or perhaps be an invalid URL altogether.
		 * @param string $url
		 * @return bool
		 */
		function isValidRedirect( $url ) {
			if( $url == '' ) {
				return false;
			}

			global $wgTitle;
			$url1 = $wgTitle->getFullURL();
			$url1 = explode( '/', $url1 );
			$url1 = $url1[0] . '/' . $url1[1] .'/' . $url1[2];
			$url2 = explode( '/', $url );
			$url2 = $url2[0] . '/' . $url2[1] .'/' . $url2[2];
			
			return ( $url1 == $url2 );
		}

		/**
		 * Generates a form for creating a new task
		 */
		function generate_form( &$new_tasks ) { # Checked for HTML and MySQL insertion attacks
			if( count( $new_tasks ) == 0 ) {
				return '';
			}

			// Heading and table heading
			$out = '<h2>' . wfMsgHTML( 'tasks_create_header' ) . "</h2>\n"
			     . '<form method="post">'
			     . '<table border="0" width="100%"><tr><td valign="top" nowrap><b>'
			     . wfMsgHTML( 'tasks_form_new' )
			     . '</b></td><td width="100%" align="center">'
			     . '<b>' . wfMsgHTML( 'tasks_form_comment' ) . '</b> '
			     . wfMsgHTML( 'tasks_plain_text_only' )
			     . '</td></tr><tr>'
			;

			// Select possible tasks
			$out .= '<td valign="top" nowrap><select name="type" size="7" style="width:100%">';
			$o = array();
			foreach( $new_tasks as $k => $v ) {
				$o[$v] = '<option value="' . $k . '">' . $this->get_type_html( $v ) . '</option>';
			}
			ksort( $o );
			$out .= implode( '', $o );
			$out .= '</select>';

			$out .= '</td><td valign="top">'
			      . '<textarea name="text" rows="4" cols="20" style="width:100%"></textarea><br />'
			      . wfMsgHTML( 'tasks_assign_to' ) . ' <input type="text" name="username" />'
			      . '<input type="submit" name="create_task" value="' . wfMsgHTML( 'ok' ) . '" />'
			      . '</td></tr></table>'
			      . '</form>'
			;
			return $out;
		}
		
		/**
		* Returns the exisiting tasks for a single page
		*/
		function get_tasks_for_page( &$title, $force_dbtitle = false ) { # Checked for HTML and MySQL insertion attacks
			$dbr =& wfGetDB( DB_SLAVE );
			$id = $title->getArticleID();

			if( $id == 0 || $force_dbtitle ) {
				$conds = array( 'task_page_title' => $title->getPrefixedDBkey() );
			} else {
				$conds = array( 'task_page_id' => $id );
			}

			$res = $dbr->select(
					/* FROM   */ 'tasks',
					/* SELECT */ '*',
					/* WHERE  */ $conds
			);
			
			$ret = array();
			while( $line = $dbr->fetchObject( $res ) ) {
				$ret[$line->task_timestamp.':'.$line->task_id] = $line;
			}
			$dbr->freeResult($res);
			krsort( $ret );
			return $ret;
		}
		
		function get_assigned_tasks( $userid ) { # Checked for HTML and MySQL insertion attacks
			if( !is_numeric( $userid ) ) {
				# Paranoia
				return null;
			}
		
			$dbr =& wfGetDB( DB_SLAVE );

			$res = $dbr->select(
					/* FROM   */ 'tasks',
					/* SELECT */ '*',
					/* WHERE  */ array( 'task_user_assigned' => $userid )
			);
			
			$ret = array();
			while( $line = $dbr->fetchObject( $res ) ) {
				$ret[$line->task_timestamp.':'.$line->task_id] = $line;
			}
			$dbr->freeResult( $res );
			krsort( $ret );
			return $ret;
		}
	
		/**
		* Special page main function
		*/
		function execute( $par = null ) { # Checked for HTML and MySQL insertion attacks
			global $wgOut, $wgRequest, $wgUser, $wgTitle;
			$fname = 'Special::Tasks:execute';

			$out = '';
			$mode = trim( $wgRequest->getVal( 'mode' ) );
			$skin =& $wgUser->getSkin();
			$dbr =& wfGetDB( DB_SLAVE );
			
			# Assignments
			if( $wgUser->isLoggedIn() ) {
				if( $mode == 'myassignments' ) {
					# Show my assignments
					$tasks = $this->get_assigned_tasks( $wgUser->getId() );
					if( count( $tasks ) == 0 ) {
						$out .= '<p>' . wfMsgHTML( 'tasks_you_have_no_assignments' ) . '</p>';
					} else {
						$out .= '<h2>' . wfMsgHTML( 'tasks_my_assignments' ) . "</h2>\n"
						      . '<br /><table border="1" cellspacing="1" cellpadding="2">'
						      . '<tr>' . wfTaskExtensionGetTableHeader( true ) . '</tr>'
						;
						foreach( $tasks as $task ) {
							$page_title = $this->get_title_from_task( $task->task_id, $task );
							$returnto = $wgTitle->getFullURL( 'mode=myassignments' );
							$out .= $this->get_task_table_row( $task, $page_title, true, $returnto );
						}
						$out.= '</table>';
					}
				} else { # default
					$res = $dbr->select(
							/* FROM   */ 'tasks',
							/* SELECT */ ' COUNT(task_id) AS num',
							/* WHERE  */ array( 'task_user_assigned' => $wgUser->getId() ),
							/* FNAME */ $fname
					);
					$tasks = array();
					$data = $dbr->fetchObject( $res );
					$dbr->freeResult( $res );
					if( !isset ( $data ) || !isset ( $data->num ) ) {
						# Paranoia dummy
						$data->num = 0;
					}

					$specialTasks = Title::makeTitle( NS_SPECIAL, 'Tasks' );
					$link = $skin->makeLinkObj( $specialTasks,
						wfMsgHTML( 'tasks_link_your_assignments' ), 'mode=myassignments' );
					$out .= '<p>';
					if( $data->num == 0 ) {
						$out .= wfMsgHTML( 'tasks_you_have_no_assignments' ) . '.' ;
					} else {
						$out .= wfMsgHTML( 'tasks_see_your_assignments', $data->num, $link ) ;
					}
					$out .= '</p>';

				}
			}
			
			# Read former form
			$task_type = array();
			$status_type = array( 1 => 1 ) ; # Default : open tasks
			if( isset( $_POST['task_type'] ) ) {
				$task_type = $_POST['task_type'];
			}
			if( isset( $_POST['status_type'] ) ) {
				$status_type = $_POST['status_type'];
			}
			$ascending = $wgRequest->getCheck( 'ascending' );
			
			$get_task_type = $wgRequest->getInt( 'task_type' , 0 ) ;
			if ( count ( $task_type ) == 0 && $get_task_type > 0 ) {
				$task_type = array() ;
				$task_type[$get_task_type] = 1 ;
			}
			
			if( !is_array( $status_type ) ) {
				return;
			}
			if( !is_array( $task_type ) ) {
				return;
			}

			$out .= '<form method="post" action="' . $wgTitle->escapeLocalURL() . '">';

			# Search results
			if( $wgRequest->getVal( 'doit' ) . $wgRequest->getVal( 'prev' ) . $wgRequest->getVal( 'next' ) != "" || $get_task_type > 0 ) {
				$this->pagemode = 'search' ;
				$search_tasks = array_keys( $task_type );
				if( count( $task_type ) == 0 ) {
					# No choice => search all
					$search_tasks = array_keys( $this->task_types );
				}
				$search_status = array_keys( $status_type );
				if( count( $search_status ) == 0 ) {
					# No choice => search all
					$search_status = array_keys( $this->status_types );
				}
					
				$limit = intval( wfMsg( 'tasks_search_limit' ) );
				$offset = $wgRequest->getInt( 'offset', 0 );
				if( $wgRequest->getCheck( 'next' ) ) {
					$offset += $limit;
				}
				if( $wgRequest->getCheck( 'prev' ) && $offset >= $limit ) {
					$offset -= $limit;
				}

				# Search
				$conds = array(
					'task_type' => $search_tasks,
					'task_status' => $search_status,
				);
				$options = array(
					'LIMIT' => $limit,
					'OFFSET' => $offset,
					'ORDER BY' => 'task_timestamp' . ( $ascending == '1' ? ' DESC' : '' ),
				);
				$res = $dbr->select(
						/* FROM   */ 'tasks',
						/* SELECT */ '*',
						/* WHERE  */ $conds,
						/* FNAME */ $fname,
						/* OPTIONS */$options
				);
				$tasks = array();
				while( $line = $dbr->fetchObject( $res ) ) {
					$tasks[] = $line;
				}
				$dbr->freeResult( $res );
				
				if( count( $tasks ) > 0 ) {

					$out .= '<h2>' . wfMsgHTML( 'tasks_search_results' ) . "</h2>\n";

					# Last/next form

					if( $offset >= $limit ) {
						$out .= '<input type="submit" name="prev" value="'
						     . wfMsgHTML('tasks_previous') . '" /> ' ;
					}
					$out .= ($offset + 1) . ' .. ' . ($offset + count( $tasks )) . ' ';

					if( count( $tasks ) >= $limit ) {
						$out .= '<input type="submit" name="next" value="' .
							wfMsgHTML( 'tasks_next' ) . '" />' ;
					}

					$out .= '<input type="hidden" name="offset" value="' . $offset . '" />'
					     . '<br /><table border="1" cellspacing="1" cellpadding="2">'
						 . '<tr>' . wfTaskExtensionGetTableHeader( true ) . '</tr>'
						;

					$returnto = $wgTitle->getFullURL(); # Return to this page

					foreach( $tasks as $task ) {
						$page_title = $this->get_title_from_task( $task->task_id, $task );
						$out .= $this->get_task_table_row( $task, $page_title, true, $returnto );
					}
					$out .= '</table>';
				}
			}

			# Search form
			$out .= '<h2>' . wfMsgHTML( 'tasks_search_form_title' ) . '</h2>'
			      . '<table border="0">'
			      . '<tr><th align="left">' . wfMsgHTML( 'tasks_search_tasks' ) . '</th>'
			      . '<td>'
				;
			foreach( $this->task_types as $k => $v ) {
				$out .= $this->checkbox( "task_type[$k]", isset( $task_type[$k] ) );
				$out .= $this->get_type_html( $v ) . " ";
			}
			$out .= wfMsgHTML( 'tasks_search_no_tasks_chosen_note' );
			$out .= '</td></tr>';

			$out .= '<tr><th align="left">' . wfMsgHTML( 'tasks_search_status' ) . '</th>';
			$out .= '<td>';
			foreach( $this->status_types as $k => $v ) {
				$out .= $this->checkbox( "status_type[$k]", isset( $status_type[$k] ) );
				$out .= wfMsgHTML( 'tasks_status_' . $v ) . " ";
			}
			$out .= "</td></tr>\n<tr><th>";
			$out .= wfMsgHTML('tasks_sort') . "</th><td>";
			$out .= $this->checkbox( 'ascending', $ascending );
			$out .= wfMsgHTML( 'tasks_ascending' );
			$out .= "</td></tr></table>";

			$out .= '<input type="submit" name="doit" value="' . wfMsgHTML( 'search' ) . '" />';
			$out .= '</form>';

			# and ... out!
			$wgOut->addLink(array(
				'rel'	=> 'stylesheet',
				'type'	=> 'text/css',
				'media'	=> 'screen,projection',
				'href'	=> TASKS_CSS,
			));
			$this->setHeaders();
			$wgOut->addHtml( $out );
		}
		
		/**
		 * Format an HTML checkbox
		 * @param string $name
		 * @param bool $checked
		 * @return string
		 * @access private
		 */
		function checkbox( $name, $checked ) {
			$attribs = array(
				'type' => 'checkbox',
				'name' => $name,
				'value' => '1' );
			if( $checked ) {
				$attribs['checked'] = 'checked';
			}
			return wfElement( 'input', $attribs );
		}
	} # end of class

	SpecialPage::addPage( new SpecialTasks );
}

/**
 * Ensure the parser tests don't die; the table must
 * be duplicated to let the save hooks work.
 */
function wfTasksTestTables( &$tables ) {
	$tables[] = 'tasks';
	return true;
}


?>
