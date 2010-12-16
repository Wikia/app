<?php

//constants for message type
define("NEWTASK", 0);
define("UPDATE", 1);
define("ASSIGNED", 2);

/**
 * This class handles the creation and sending of notification emails.
 */
class SemanticTasksMailer {
	private static $class_assignees;

	function findOldValues( &$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags ) {
		$title = $article->getTitle();
		$title_text = $title->getText();

		$assignees = self::getAssignees( 'Assigned to', $title_text, $user );

		self::printDebug( "Old assignees: ", $assignees );

		self::$class_assignees = $assignees;

		return true;
	}


	function mailAssigneesUpdatedTask( $article, $current_user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision ) {
		if ( !$minoredit ) {
			// Get the revision count to determine if new article
			$rev = $article->estimateRevisionCount();

			if ( $rev == 1 ) {
				$title = $article->getTitle();
				if ( $title->isTalkPage() ) {
					$status = UPDATE;
				} else {
					$status = NEWTASK;
				}
			} else {
				$status = UPDATE;
			}
			self::mailAssignees( $article, $text, $current_user, $status );
		}
		return true;
	}

	function mailAssignees( $article, $text, $user, $status ) {
		self::printDebug( "Saved assignees:", self::$class_assignees );

		$title = $article->getTitle();
		$title_text = $title->getText();

		$assignees_to_task = array();
		$current_assignees = self::getAssignees( 'Assigned to', $title_text, $user );

		self::printDebug( "Previous assignees: ", self::$class_assignees );
		self::printDebug( "New assignees: ", $current_assignees );

		foreach ( $current_assignees as $assignee ) {
			if ( !in_array( $assignee, self::$class_assignees ) ) {
				array_push( $assignees_to_task, $assignee );
			}
		}

		self::printDebug( "Assignees to task: ", $assignees_to_task );

		// Send notification of an assigned task to assignees
		// Treat task as new
		$assignees_to_task = self::getAssigneeAddresses( $assignees_to_task );
		self::mailNotification( $assignees_to_task, $text, $title, $user, ASSIGNED );

		// Only send group notifications on new tasks
		if ( $status == NEWTASK ) {
			$groups = self::getGroupAssignees( 'Assigned to group', $title_text, $user );
		} else {
			$groups = array();
		}

		$copies = self::getAssignees( 'Carbon copy', $title_text, $user );

		$mailto = array_merge( $current_assignees, $copies, $groups );
		$mailto = array_unique( $mailto );
		$mailto = self::getAssigneeAddresses( $mailto );

		// Send notifications to assignees, ccs, and groups
		self::mailNotification( $mailto, $text, $title, $user, $status );

		return true;
	}

	/**
	* Returns an array of assignees based on $query_word
	* @param $query_word String: the property that designate the users to notify.
	*/
	function getAssignees( $query_word, $title_text, $user ) {
		// Array of assignees to return
		$assignee_arr = array();

		// get the result of the query "[[$title]][[$query_word::+]]"
		$properties_to_display = array();
		$properties_to_display[0] = $query_word;
		$results = self::getQueryResults( "[[$title_text]][[$query_word::+]]", $properties_to_display, false );

		// In theory, there is only one row
		while ( $row = $results->getNext() ) {
			$task_assignees = $row[0];
		}

		// If not any row, do nothing
		if ( !empty( $task_assignees ) ) {
			while ( $task_assignee = $task_assignees->getNextObject() ) {
				$assignee_name = $task_assignee->getTitle();
				$assignee_name = $assignee_name->getText();
				$assignee_name = explode( ":", $assignee_name );
				$assignee_name = $assignee_name[0];

				array_push( $assignee_arr, $assignee_name );
			}
		}

		return $assignee_arr;
	}

	/**
	* Returns an array of assignees based on $query_word
	* @param $query_word String: the property that designate the users to notify.
	*/
	function getGroupAssignees( $query_word, $title_text, $user ) {
		// Array of assignees to return
		$assignee_arr = array();

		// get the result of the query "[[$title]][[$query_word::+]]"
		$properties_to_display = array();
		$properties_to_display[0] = $query_word;
		$results = self::getQueryResults( "[[$title_text]][[$query_word::+]]", $properties_to_display, false );

		// In theory, there is only one row
		while ( $row = $results->getNext() ) {
			$group_assignees = $row[0];
		}

		// If not any row, do nothing
		if ( !empty( $group_assignees ) ) {
			while ( $group_assignee = $group_assignees->getNextObject() ) {
				$group_assignee = $group_assignee->getTitle();
				$group_name = $group_assignee->getText();
				$query_word = "Has assignee";
				$properties_to_display = array();
				$properties_to_display[0] = $query_word;
				self::printDebug( $group_name );
				$results = self::getQueryResults( "[[$group_name]][[$query_word::+]]", $properties_to_display, false );

				// In theory, there is only one row
				while ( $row = $results->getNext() ) {
					$task_assignees = $row[0];
				}

				if ( !empty( $task_assignees ) ) {
					while ( $task_assignee = $task_assignees->getNextObject() ) {
						$assignee_name = $task_assignee->getTitle();
						$assignee_name = $assignee_name->getText();
						$assignee_name = explode( ":", $assignee_name );
						$assignee_name = $assignee_name[0];

						self::printDebug( "Groupadd: " . $assignee_name );
						array_push( $assignee_arr, $assignee_name );
					}
				}
			}
		}

		return $assignee_arr;
	}

	function getAssigneeAddresses( $assignees ) {
		$assignee_arr = array();
		foreach ( $assignees as $assignee_name ) {
			$assignee = User::newFromName( $assignee_name );
			$assignee_mail = new MailAddress( $assignee->getEmail(), $assignee_name );
			array_push( $assignee_arr, $assignee_mail );
			self::printDebug( $assignee_name );
		}

		return $assignee_arr;
	}

	/**
	* Sends mail notifications
	*/
	function mailNotification( $assignees, $text, $title, $user, $status ) {
		global $wgSitename;

		if ( !empty( $assignees ) ) {
			// i18n
			wfLoadExtensionMessages( 'SemanticTasks' );

			$title_text = $title->getText();
			$from = new MailAddress( $user->getEmail(), $user->getName() );
			$link = $title->escapeFullURL();

			if ( $status == NEWTASK ) {
				$subject = '[' . $wgSitename . '] ' . wfMsg( 'semantictasks-newtask' ) . ' ' . $title_text;
				$message = 'semantictasks-newtask-msg';
				$body = wfMsg( $message , $title_text ) . " " . $link;
				$body .= "\n \n" . wfMsg( 'semantictasks-text-message' ) . "\n" . $text;
			} else if ( $status == UPDATE ) {
				$subject = '[' . $wgSitename . '] ' . wfMsg( 'semantictasks-taskupdated' ) . ' ' . $title_text;
				$message = 'semantictasks-updatedtoyou-msg2';
				$body = wfMsg( $message , $title_text ) . " " . $link;
				$body .= "\n \n" . wfMsg( 'semantictasks-diff-message' ) . "\n" . self::generateDiffBodyTxt( $title );
			} else {
				//status == ASSIGNED
				$subject = '[' . $wgSitename . '] ' . wfMsg( 'semantictasks-taskassigned' ) . ' ' . $title_text;
				$message = 'semantictasks-assignedtoyou-msg2';
				$body = wfMsg( $message , $title_text ) . " " . $link;
				$body .= "\n \n" . wfMsg( 'semantictasks-text-message' ) . "\n" . $text;
			}

			$user_mailer = new UserMailer();

			$user_mailer->send( $assignees, $from, $subject, $body );
		}
	}

	/**
	* Generates a diff txt
	* @param Title $title
	* @return string
	*/
	function generateDiffBodyTxt( $title ) {
		$revision = Revision::newFromTitle( $title, 0 );
		$diff = new DifferenceEngine( $title, $revision->getId(), 'prev' );
		// The getDiffBody() method generates html, so let's generate the txt diff manualy:
		global $wgContLang;
		$diff->loadText();
		$otext = str_replace( "\r\n", "\n", $diff->mOldtext );
		$ntext = str_replace( "\r\n", "\n", $diff->mNewtext );
		$ota = explode( "\n", $wgContLang->segmentForDiff( $otext ) );
		$nta = explode( "\n", $wgContLang->segmentForDiff( $ntext ) );
		// We use here the php diff engine included in MediaWiki
		$diffs = new Diff( $ota, $nta );
		// And we ask for a txt formatted diff
		$formatter = new UnifiedDiffFormatter();
		$diff_text = $wgContLang->unsegmentForDiff( $formatter->format( $diffs ) );
		return $diff_text;
	}

	/**
	* This function returns to results of a certain query
	* Thank you Yaron Koren for advices concerning this code
	* @param $query_string String : the query
	* @param $properties_to_display array(String): array of property names to display
	* @param $display_title Boolean : add the page title in the result
	* @return TODO
*/
	function getQueryResults( $query_string, $properties_to_display, $display_title ) {
		// i18n
		wfLoadExtensionMessages( 'SemanticTasks' );

		// We use the Semantic MediaWiki Processor
		global $smwgIP;
		include_once( $smwgIP . "/includes/SMW_QueryProcessor.php" );

		$params = array();
		$inline = true;
		$format = 'auto';
		$printlabel = "";
		$printouts = array();

		// add the page name to the printouts
		if ( $display_title ) {
			$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_THIS, $printlabel );
			array_push( $printouts, $to_push );
		}

		// Push the properties to display in the printout array.
		foreach ( $properties_to_display as $property ) {
			if ( class_exists( 'SMWPropertyValue' ) ) { // SMW 1.4
				$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $printlabel, SMWPropertyValue::makeProperty( $property ) );
			} else {
				$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $printlabel, Title::newFromText( $property, SMW_NS_PROPERTY ) );
			}
			array_push( $printouts, $to_push );
		}

		$query = SMWQueryProcessor::createQuery( $query_string, $params, $inline, $format, $printouts );
		$results = smwfGetStore()->getQueryResult( $query );

		return $results;
	}

	function remindAssignees( $wiki_url ) {
		global $wgSitename, $wgServer;

		$user_mailer = new UserMailer();

		$t = getdate();
		$today = date( 'F d Y', $t[0] );

		$query_string = "[[Reminder at::+]][[Status::New||In Progress]][[Target date::> $today]]";
		$properties_to_display = array( 'Reminder at', 'Assigned to', 'Target date' );

		$results = self::getQueryResults( $query_string, $properties_to_display, true );
		if ( empty( $results ) ) {
			return FALSE;
		}

		$sender = new MailAddress( "no-reply@$wgServerName", "$wgSitename" );

		while ( $row = $results->getNext() ) {
			$task_name = $row[0]->getNextObject()->getTitle();
			$subject = '[' . $wgSitename . '] ' . wfMsg( 'semantictasks-reminder' ) . $task_name;
			// The following doesn't work, maybe because we use a cron job.
			// $link = $task_name->escapeFullURL();
			// So let's do it manually
			$link = $wiki_url . $task_name->getPartialURL();

			$target_date = $row[3]->getNextObject();
			$tg_date = new DateTime( $target_date->getShortHTMLText() );

			while ( $reminder = $row[1]->getNextObject() ) {
				$remind_me_in = $reminder->getShortHTMLText();
				$date = new DateTime( $today );
				$date->modify( "+$remind_me_in day" );

				if ( $tg_date-> format( 'F d Y' ) == $date-> format( 'F d Y' ) ) {
					global $wgLang;
					while ( $task_assignee = $row[2]->getNextObject() ) {
						$assignee_username = $task_assignee->getTitle();
						$assignee_user_name = explode( ":", $assignee_username );
						$assignee_name = $assignee_user_name[1];

						$assignee = User::newFromName( $assignee_name );
						$assignee_mail = new MailAddress( $assignee->getEmail(), $assignee_name );
						$body = wfMsgExt( 'semantictasks-reminder-message2', 'parsemag', $task_name, $wgLang->formatNum( $remind_me_in ), $link );
						$user_mailer->send( $assignee_mail, $sender, $subject, $body );
					}
				}
			}
		}
		return TRUE;
	}

	/**
	 * Prints debugging information. $debugText is what you want to print, $debugVal
	 * is the level at which you want to print the information.
	 *
	 * @param string $debugText
	 * @param string $debugVal
	 * @access private
	 */
	function printDebug( $debugText, $debugArr = null ) {
		global $wgSemanticTasksDebug;
               
		if ( $wgSemanticTasksDebug ) { 
			if ( isset( $debugArr ) ) {
				$text = $debugText . " " . implode( "::", $debugArr );
				wfDebugLog( 'semantic-tasks', $text, false );
			} else {
				wfDebugLog( 'semantic-tasks', $debugText, false );
			}
		}
	}
}
