<?php

/*
CREATE TABLE todolist (
todo_id INT AUTO_INCREMENT,
todo_owner INT,
todo_queue CHAR(32) BINARY,
todo_timestamp CHAR(14) BINARY,
todo_status ENUM('open', 'closed'),

todo_title BLOB,
todo_comment BLOB,
todo_email BLOB,

PRIMARY KEY (todo_id),
INDEX owner_status_queue_timestamp(todo_owner,todo_status,todo_queue,todo_timestamp)
);
*/

$wgExtensionCredits['other'][] = array(
	'name' => 'Todo',
	'version' => '0.2',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Todo',
	'description' => 'Experimental personal todo list extension',
	'author' => 'Brion Vibber, Bertrand Grondin',
	'descriptionmsg' => 'todo-desc',
);

$wgExtensionFunctions[] = 'todoSetup';
$wgHooks['SkinTemplateTabs'][] = 'todoAddTab';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['todoAddTab'] = $dir . 'SpecialTodo.i18n.php';

// Creates a group of users who can have todo lists
$wgGroupPermissions['todo']['todo'] = true;

// Can restrict who can submit new items as well
$wgGroupPermissions['*']['todosubmit'] = true;
$wgGroupPermissions['user']['todosubmit'] = true;
$wgGroupPermissions['sysop']['todosubmit'] = true;
$wgAvailableRights[] = 'todo';
$wgAvailableRights[] = 'todosubmit';

function todoSetup() {
	wfLoadExtensionMessages( 'todoAddTab' );
	SpecialPage::addPage( new SpecialPage( 'Todo' ) );
}

/**
 * Add a 'todo' tab on user pages
 * @param SkinTemplate $skin
 * @param array $actions
 * @return bool true to continue running hooks, false to abort operation
 */
function todoAddTab( &$skin, &$actions ) {
	global $wgTitle;
	if( $wgTitle->getNamespace() == NS_USER || $wgTitle->getNamespace() == NS_USER_TALK ) {
		$title = Title::makeTitle( NS_SPECIAL, 'Todo/' . $wgTitle->getText() );
		$actions['todo'] = array(
			'text' => wfMsg('todo-tab'),
			'href' => $title->getLocalUrl() );
	}
	return true;
}

/**
 * Entry-point function for Special:Todo
 * @param mixed $par Will contain username to view on
 */
function wfSpecialTodo( $par=null ) {
	if( is_null( $par ) || $par == '' ) {
		global $wgUser;
		$user = $wgUser;
	} else {
		$user = User::newFromName( $par );
	}
	if( is_null( $user ) || !$user->isAllowed( 'todo' ) ) {
		global $wgOut;
		$wgOut->fatalError( wfMsgHtml('todo-user-invalide') );
	} else {
		global $wgRequest;
		$todo = new TodoForm( $user );
		if( $wgRequest->wasPosted() ) {
			$todo->submit( $wgRequest );
		} else {
			$todo->show();
		}
	}
}

class TodoForm {
	function TodoForm( $user ) {
		$this->target = $user;
		$this->self = Title::makeTitle( NS_SPECIAL, 'Todo/' . $user->getName() );
	}

	function submit( $request ) {
		if( $request->getVal( 'wpNewItem' ) ) {
			$this->submitNew( $request );
		} elseif( $request->getVal( 'wpUpdateField' ) ) {
			$this->submitUpdate( $request );
		}
		$this->showError( $result );
		$this->show();
	}

	function submitNew( $request ) {
		$result = TodoItem::add(
			$this->target,
			$request->getText( 'wpSummary' ),
			$request->getText( 'wpComment' ),
			$request->getVal( 'wpEmail' ) );
		return $result;
	}

	function submitUpdate( $request ) {
		$id = $request->getInt( 'wpItem' );
		$item = TodoItem::loadFromId( $id );
		if( is_null( $item ) ) {
			return new WikiError( wfMsgHtml('todo-invalid-item') );
		}

		global $wgUser;
		if( $item->owner != $wgUser->getId() ) {
			return new WikiError( wfMsgHtml('todo-update-else-item') );
		}

		switch( $request->getVal( 'wpUpdateField' ) ) {
		case 'queue':
			return $item->setQueue( $request->getText( 'wpQueue' ) );
			break;
		case 'comment':
			return $item->setComment( $request->getText( 'wpComment' ) );
			break;
		case 'title':
			return $item->setTitle( $request->getText( 'wpTitle' ) );
			break;
		default:
			return new WikiError( "Unrecognized type" );
		}
	}

	function show() {
		global $wgOut, $IP, $wgUser, $wgScriptPath;
		$wgOut->setPageTitle( wfmsgHtml('todo-list-for') ." ". $this->target->getName() );


		$wgOut->addWikiText( "== ".wfMsg('todo-new-item')." ==\n" );

		require_once ('TodoForm.php');
		$form = new TodoTemplate();
		$form->set( 'action', $this->self->getLocalUrl( 'action=submit' ) );
		$form->set( 'script', "$wgScriptPath/extensions/Todo/todo.js" );
		$wgOut->addTemplate( $form );

		if( $wgUser->getName() == $this->target->getName() ) {
			$wgOut->addWikiText( "== ". wfMsg('todo-item-list') ." ==\n" );
			$list = new TodoList( $this->target );
			$list->show();
		}
	}

	function showError( $result ) {
		global $wgOut;
		if( WikiError::isError( $result ) ) {
			$wgOut->addHTML( '<p class="error">' .
				htmlspecialcahrs( $result->getMessage() ) .
				"</p>\n" );
		}
	}

}

class TodoList {
	/**
	 * Load a user's open todo items into a list.
	 * Open items should remain a relatively small working set, since things
	 * should get closed one way or another!
	 */
	function TodoList( $user ) {
		$this->owner = $user->getId();
		$dbr =& wfGetDB( DB_SLAVE );

		$result = $dbr->select( 'todolist', '*', array(
			'todo_owner' => $this->owner,
			'todo_status' => 'open' ),
			'TodoList::TodoList',
			array( 'ORDER BY' => 'todo_owner,todo_status,todo_queue,todo_timestamp DESC' ) );

		$this->items = array();
		while( $row = $dbr->fetchObject( $result ) ) {
			$item = new TodoItem( $row );
			$this->items[$item->queue][] = $item;
		}
		$dbr->freeResult( $result );
	}

	function show() {
		global $wgOut;

		$queues = array_keys( $this->items );
		usort( $queues, array( 'TodoList', 'queueSort' ) );

		if( count( $queues ) == 0 ) {
			$wgOut->addWikiText( wfMsg('todo-no-item'));
			return;
		}

		$wgOut->addHtml( "<table>\n<tr>" );
		foreach( $queues as $queue ) {
			$wgOut->addHtml( wfElement( 'th', null, $queue ) );
		}
		$wgOut->addHtml( "</tr>\n<tr>\n" );

		foreach( $queues as $queue ) {
			$wgOut->addHtml( "<td valign='top'>\n<table border='1'>\n" );
			$this->showQueue( $queue, $queues );
			$wgOut->addHtml( "</table>\n</td>\n" );
		}

		$wgOut->addHtml( "</tr>\n</table>\n" );
	}

	/**
	 * Sort callback to force the 'new' queue to the front
	 * @param string $a
	 * @param string $b
	 * @return int
	 */
	function queueSort( $a, $b ) {
		$new = wfMsgForContent( 'todo-new-queue' );
		if( $a == $b ) {
			return 0;
		}
		if( $a == $new ) {
			return -1;
		}
		if( $b == $new ) {
			return 1;
		}
		return strcmp( $a, $b );
	}

	function showQueue( $queue, $queues ) {
		global $wgOut;
		foreach( $this->items[$queue] as $item ) {
			$wgOut->addHtml( "<tr><td><div>" );
			$item->show( $queues );
			$wgOut->addHtml( "</div></td></tr>\n" );
		}
	}
}

class TodoItem {
	function TodoItem( $row ) {
		$this->id = $row->todo_id;
		$this->owner = $row->todo_owner;
		$this->queue = $row->todo_queue;
		$this->timestamp = wfTimestamp( TS_MW, $row->todo_timestamp );
		$this->status = $row->todo_status;
		$this->title = $row->todo_title;
		$this->comment = $row->todo_comment;
		$this->email = $row->todo_email;
	}

	/**
	 * @param int $id
	 * @static
	 */
	function loadFromId( $id ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'todolist',
			'*',
			array( 'todo_id' => intval( $id ) ),
			'TodoForm::loadFromId' );
		if( $row ) {
			return new TodoItem( $row );
		} else {
			return null;
		}
	}

	/**
	 * @param User $owner
	 * @param string $summary
	 * @param string $comment
	 * @param string $email
	 * @static
	 */
	function add( $owner, $summary, $comment, $email ) {
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->insert( 'todolist',
			array(
				'todo_owner' => $owner->getId(),
				'todo_queue' => 'new',
				'todo_timestamp' => $dbw->timestamp(),
				'todo_status' => 'open',
				'todo_title' => $summary,
				'todo_comment' => $comment,
				'todo_email' => $email ),
			'TodoItem::add' );
		return true;
	}


	function show( $queues ) {
		global $wgOut, $wgUser, $wgLang;
		$id = $this->id;

		$wgOut->addHtml( wfElement( 'div', array(
			'class' => 'mwTodoTitle',
			'id' => "mwTodoTitle$id",
			'ondblclick' => "todoEditTitle($id,true)" ) ) .
			htmlspecialchars( $this->title ) .
			"&nbsp;</div>\n" );

		$wgOut->addHtml( $this->buildHiddenForm( 'title', $this->title, 1 ) );

		$wgOut->addHtml( "<div class='mwTodoTimestamp'>" . $wgLang->timeanddate( $this->timestamp ) . "</div>\n" );

		$wgOut->addHtml( wfOpenElement( 'div', array(
			'class' => 'mwTodoComment',
			'id' => "mwTodoComment$id",
			'ondblclick' => "todoEditComment($id,true)" ) ) );
		$wgOut->addWikiText( $this->comment );
		$wgOut->addHtml( "&nbsp;</div>" );

		$wgOut->addHtml( $this->buildHiddenForm( 'comment', $this->comment, 6 ) );

		$wgOut->addHtml( $this->buildQueueForm( $queues ) );
	}

	function buildHiddenForm( $field, $val, $rows ) {
		global $wgUser;
		$capField = ucfirst( $field );
		$id = $this->id;
		$todo = Title::makeTitle( NS_SPECIAL, 'Todo' );

		return wfOpenElement( 'div', array(
				'id' => "mwTodo{$capField}Update$id",
				'style' => 'display:none' ) ) .
			wfOpenElement( 'form', array(
				'action' => $todo->getLocalUrl(),
				'method' => 'post' ) ) .
			wfElement( 'input', array(
				'name' => 'wpItem', 'type' => 'hidden', 'value' => $this->id ) ) .
			wfElement( 'input', array(
				'name' => 'wpEditToken', 'type' => 'hidden', 'value' => $wgUser->editToken() ) ) .
			wfElement( 'input', array(
				'name' => 'wpUpdateField', 'type' => 'hidden', 'value' => $field ) ) .
			( ( $rows == 1 )
				? wfElement( 'input', array(
					'name' => "wp{$capField}", 'size' => '20', 'value' => $val ) )
				: wfElement( 'textarea', array(
					'name' => "wp{$capField}", 'cols' => '20', 'rows' => '10' ),
					$val . "\n" ) ) .
			"<br />\n" .
			wfElement( 'input', array(
				'type' => 'submit',
				'value' => wfMsg('todo-list-change') ) ) .
			" " .
			wfElement( 'input', array(
				'type' => 'button',
				'value' => wfMsg('todo-list-cancel'),
				'onclick' => "todoEdit{$capField}($id,false)" ) ) .
			"</form></div>\n";
	}

	function buildQueueForm( $queues ) {
		global $wgUser;
		$id = $this->id;
		$todo = Title::makeTitle( NS_SPECIAL, 'Todo' );
		return wfOpenElement( 'form', array(
				'action' => $todo->getLocalUrl(),
				'method' => 'post',
				'id' => 'mwTodoQueueUpdate' . $this->id ) ) .
			wfElement( 'input', array(
				'name' => 'wpItem', 'type' => 'hidden', 'value' => $this->id ) ) .
			wfElement( 'input', array(
				'name' => 'wpEditToken', 'type' => 'hidden', 'value' => $wgUser->editToken() ) ) .
			wfElement( 'input', array(
				'name' => 'wpUpdateField', 'type' => 'hidden', 'value' => 'queue' ) ) .
			$this->buildMoveSelector( $queues ) .
			"</form>\n";
	}

	function buildMoveSelector( $queues ) {
		$out = "<select name='wpQueue' id='mwTodoQueue" . $this->id . "' onchange='todoMoveQueue(" . $this->id . ")'>";
		foreach( $queues as $queue ) {
			if( $queue == $this->queue ) {
				$out .= wfElement( 'option',
					array( 'value' => '', 'selected' => 'selected' ),
					wfMsgHtml('todo-move-queue') );
			} else {
				$out .= wfElement( 'option',
					array( 'value' => $queue ),
					$queue );
			}
		}
		$out .= "<option value='+' />".wfMsgHtml('todo-add-queue')."</option>\n";
		$out .= "</select>";
		return $out;
	}

	/**
	 * @param string $queue
	 */
	function setQueue( $queue ) {
		$this->queue = $queue;
		return $this->updateRecord( array( 'todo_queue' => $queue ) );
	}

	/**
	 * @param string $comment
	 */
	function setComment( $comment ) {
		$this->comment = $comment;
		return $this->updateRecord( array( 'todo_comment' => rtrim( $comment ) ) );
	}

	/**
	 * @param string $title
	 */
	function setTitle( $title ) {
		$this->title = $title;
		return $this->updateRecord( array( 'todo_title' => trim( $title ) ) );
	}

	/**
	 * @param string $comment
	 * @param bool $sendMail false to supppress sending of email to submitter
	 */
	function close( $comment, $sendMail ) {
		$this->status = 'closed';
		$this->updateRecord( array( 'todo_status' => 'closed' ) );
		if( $sendMail && $this->email ) {
			$this->sendConfirmationMail( $comment );
		}
	}

	/**
	 * @param string $closeComment
	 * @return mixed true on success, WikiError on failure
	 */
	function sendConfirmationMail( $closeComment ) {
		require_once 'includes/UserMailer.php';
		global $wgContLang;

		$owner = User::newFromId( $this->owner );
		if( is_null( $owner ) ) {
			return new WikiError( wfMsgHtml('todo-invalid-owner') );
		}

		$sender = new MailAddress( $owner );
		$recipient = new MailAddress( $this->email );
		return userMailer( $recipient, $sender,
			wfMsgForContent( 'todo-mail-subject', $owner->getName() ),
			wordwrap( wfMsgForContent( 'todo-mail-body',
				$owner->getName(),
				$wgContLang->timeanddate( $this->timestamp ),
				$this->title,
				$closeComment ) ) );
	}

	/**
	 * @param array $changes Fields to change in the record
	 * @access private
	 */
	function updateRecord( $changes ) {
		$dbw =& wfGetDB( DB_MASTER );
		return $dbw->update( 'todolist',
			$changes,
			array( 'todo_id' => $this->id ),
			'TodoItem::updateRecord' );
	}
}
