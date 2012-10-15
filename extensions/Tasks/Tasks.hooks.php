<?php

class TasksHooks {

	/**
	 * Display header on 'Task:' pages (dummy hook for edit pages)
	 * @param EditPage $editPage
	 */
	public static function onEditPageShowEditFormInitial( &$editPage ) { # Checked for HTML and MySQL insertion attacks
		return self::onArticleViewHeader( $editPage->getArticle() );
	}

	/**
	 * Display header on 'Task:' pages
	 * @param Article $article
	 */
	public static function onArticleViewHeader( $article ) { # Checked for HTML and MySQL insertion attacks
		global $wgTasksNamespace, $wgOut, $wgUser;

		$title = $article->getTitle();
		$ns = $title->getNamespace();
		if( $ns != $wgTasksNamespace && $ns != $wgTasksNamespace+1 ) {
			// Show sign, if any, then we can leave
			self::headerSign( $title );
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

		$st = new SpecialTasks();
		$task = '';
		$page_title = $st->get_title_from_task( $taskid, $task );
		if( $task == '' ) {
			# No such task
			return true;
		}

		$sk = $wgUser->getSkin();
		$returnto = $title->getFullURL();
		$link1 = $sk->makeLinkObj( $page_title );
		$link2 = $sk->makeLinkObj( $page_title, wfMsgHTML( 'tasks_here' ), 'action=tasks' );
		$subtitle .= '<div id="task_header">' . wfMsgForContent( 'tasks_discussion_page_for', $link1, $link2 ) . "</div>\n" ;
		$subtitle .= '<table border="1" cellspacing="1" cellpadding="2" id="task_header_table">' .
				'<tr>' . SpecialTasks::getTableHeader( false ) . "</tr>\n";
		$subtitle .= $st->get_task_table_row( $task, $page_title, false, $returnto );
		$subtitle .= "</table>\n";

		$subtitle = $wgOut->getSubtitle() . '<br />' . $subtitle;
		$wgOut->setSubtitle( $subtitle );
		return true;
	}

	/**
	 * Display header signs for "notable" tasks
	 */
	private static function headerSign( $title ) {
		global $wgOut;

		if( $title->isTalkPage() ) {
			# No talk pages please
			return true;
		}
		if( $title->getNamespace() < 0 ) {
			# No special pages please
			return true;
		}

		$st = new SpecialTasks();
		$tasks = $st->get_open_task_list( $title, true );
		if( count( $tasks ) == 0 ) {
			# No tasks
			return true;
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
	 * Display in sidebar
	 */
	public static function onSkinTemplateToolboxEnd( &$tpl ) { # Checked for HTML and MySQL insertion attacks
		if ( method_exists( $tpl, 'getSkin' ) ) {
			$title = $tpl->getSkin()->getTitle();
		} else {
			global $wgTitle;
			$title = $wgTitle;
		}

		if( $title->isTalkPage() ) {
			# No talk pages please
			return true;
		}
		if( $title->getNamespace() < 0 ) {
			# No special pages please
			return true;
		}

		$st = new SpecialTasks;
		$tasks = $st->get_open_task_list( $title, true );
		if( count( $tasks ) == 0 ) {
			# No tasks
			return true;
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
		return true;
	}

	/**
	 * Catch page movement, fix internal task_page_title values
	 */
	public static function onSpecialMovepageAfterMove( &$special_page, &$old_title, &$new_title ) { # Checked for HTML and MySQL insertion attacks
		if( $new_title->isTalkPage() ) {
			# No tasks for talk pages, no need to bother the database...
			return false;
		}

		$st = new SpecialTasks;
		$st->rename_tasks_page( $old_title, $new_title );
		return false;
	}


	/**
	 * Catch article deletion, remove all tasks
	 */
	public static function onArticleDeleteComplete( &$article, &$user, $reason ) { # Checked for HTML and MySQL insertion attacks
		# return false ; # Uncomment this line to prevent deletion of tasks upon deletion of article
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
	public static function onArticleInsertComplete( &$article, &$user, $text, $summary, $isminor, $watchthis, $something ) { # Checked for HTML and MySQL insertion attacks
		global $wgUser;
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
			$st->add_new_task( $t, $comment, $add_task, null ) ;
		}

		return false;
	}

	/**
	 * Prevents other tabs shown as active
	 */
	public static function onSkinTemplatePreventOtherActiveTabs( &$skin, &$prevent_active_tabs ) { # Checked for HTML and MySQL insertion attacks
		global $wgRequest;

		$prevent_active_tabs = ( $wgRequest->getVal( 'action', 'view' ) == 'tasks' );
		return true;
	}

	/**
	 * Show the tab
	 * @param SkinTemplate $skin
	 * @param array $content_actions
	 * @return bool true to continue running other hooks, false to abort operation
	 */
	public static function onSkinTemplateNavigation( $skin, &$content_actions ) { # Checked for HTML and MySQL insertion attacks
		global $wgRequest;

		$title = $skin->getTitle();

		if( $title->isTalkPage() ) {
			# No talk pages please
			return true;
		}
		if( $title->getNamespace() < 0 ) {
			# No special pages please
			return true;
		}

		$content_actions['actions']['tasks'] = array(
			'class' => ($wgRequest->getVal( 'action', 'view' ) == 'tasks') ? 'selected' : false,
			'text' => wfMsgHTML('tasks_tab'),
			'href' => $title->getLocalUrl( 'action=tasks' )
		);
		return true;
	}

	/**
	 * This is where the action is :-)
	 */
	public static function onUnknownAction( $action, $article ) { # Checked for HTML and MySQL insertion attacks
		if( $action != 'tasks' ) {
			# Not my kind of action!
			return true;
		}

		$t = new SpecialTasks;
		return $t->page_management( $article->getTitle() );
	}

	/**
	 * Ensure the parser tests don't die; the table must
	 * be duplicated to let the save hooks work.
	 */
	public static function onParserTestTables( &$tables ) {
		$tables[] = 'tasks';
		return true;
	}

	/**
	 * Ensure the parser tests don't die; the table must
	 * be duplicated to let the save hooks work.
	 */
	public static function onLoadExtensionSchemaUpdates( $updater ) {
		$updater->addExtensionTable( 'tasks', dirname( __FILE__ ) . '/tasks.sql' );
		return true;
	}

	/**
	 * Hook for user preferences
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		$preferences['show_task_comments'] =
			array(
				'type' => 'toggle',
				'section' => 'misc',
				'label-message' => 'tasks-pref-showtaskcomments',
			);

		return true;
	}

}
