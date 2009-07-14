<?php
/**
 * Poll_body - Body for the Special Page Special:Poll
 *
 * @ingroup Extensions
 * @author Jan Luca <jan@toolserver.org>
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported or later
 */


class Poll extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Poll' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;

		wfLoadExtensionMessages( 'Poll' );

		$this->setHeaders();

		# Get request data. Default the action to list if none given
		$action = htmlentities( $wgRequest->getText( 'action', 'list' ) );
		$id = htmlentities( $wgRequest->getText( 'id' ) );

		# Blocked users can't use this except to list
		if( $wgUser->isBlocked() && $action != 'list' ) {
			$wgOut->addWikiMsg( 'poll-create-block-error' );
			$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
			return;
		}

		# Handle the action
		switch( $action ) {
			case 'create':
				$this->create();
				break;
			case 'vote':
			case 'score':
			case 'change':
			case 'delete':
			case 'submit':
				$this->$action( $id );
				break;
			case 'list':
			default:
				$this->make_list();
		}
	}

	// This function create a list with all polls that are in the DB
	public function make_list() {
		global $wgOut;
		$wgOut->setPagetitle( wfMsg( 'poll' ) );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, dis, id' );

		$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=create').'">'.wfMsg( 'poll-create-link' ).'</a>' );

		$wgOut->addWikiMsg( 'poll-list-current' );
		$wgOut->addHtml( Xml::openElement( 'table' ) );
		$wgOut->addHtml( '<tr><th>'.wfMsg( 'poll-question' ).'</th><th>'.wfMsg( 'poll-dis' ).'</th><th>&nbsp;</th></tr>' );

		while( $row = $dbr->fetchObject( $query ) ) {
			$wgOut->addHtml( '<tr><td><a href="'.$this->getTitle()->getFullURL( 'action=vote&id='.$row->id ).'">'.htmlentities( $row->question, ENT_QUOTES, "UTF-8" ).'</a></td>' );
			$wgOut->addHtml( '<td>'.$row->dis.'</td>' );
			$wgOut->addHtml( '<td><a href="'.$this->getTitle()->getFullURL( 'action=score&id='.$row->id ).'">'.wfMsg( 'poll-title-score' ).'</a></td></tr>' );
		}

		$wgOut->addHtml( Xml::closeElement( 'table' ) );

	}

	// This function create a interface for create new polls
	public function create() {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( 'poll-title-create' ) );

		if ( !$wgUser->isAllowed( 'poll-create' ) ) {
			$wgOut->addWikiMsg( 'poll-create-right-error' );
			$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		}
		else {
			$wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $this->getTitle()->getFullURL('action=submit') ) ) );

			$wgOut->addHtml( Xml::openElement( 'table' ) );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-question' ).':</td><td>'.Xml::input('question').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 1:</td><td>'.Xml::input('poll_alternative_1').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 2:</td><td>'.Xml::input('poll_alternative_2').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 3:</td><td>'.Xml::input('poll_alternative_3').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 4:</td><td>'.Xml::input('poll_alternative_4').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 5:</td><td>'.Xml::input('poll_alternative_5').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 6:</td><td>'.Xml::input('poll_alternative_6').'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-dis' ).':</td><td>'.Xml::textarea('dis', '').'</td></tr>' );
			$wgOut->addHtml( Xml::closeElement( 'table' ) );
			$wgOut->addHtml( Xml::check('allow_more').' '.wfMsg( 'poll-create-allow-more' ).'<br />' );
			$wgOut->addHtml( Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'create') );
			$wgOut->addHtml( Xml::closeElement( 'form' ) );
		}
	}

	// This function create a interface for voting
	public function vote( $vid ) {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( 'poll-title-vote' ) );

		if ( !$wgUser->isAllowed( 'poll-vote' ) ) {
			$wgOut->addWikiMsg( 'poll-vote-right-error' );
			$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		}
		else {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, multi', array( 'id' => $vid ) );

			while( $row = $dbr->fetchObject( $query ) ) {
				$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
				$alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8'  );
				$alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8'  );
				$alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8'  );
				$alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8'  );
				$alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8'  );
				$alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8'  );
				$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8'  );
				$multi = $row->multi;
			}
			$wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $this->getTitle()->getFullURL('action=submit&id='.$vid) ) ) );
			$wgOut->addHtml( Xml::openElement( 'table' ) );
			$wgOut->addHtml( '<tr><th>'.$question.'</th></tr>' );
			if( $multi != 1 ) {
				$wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '1').' '.$alternative_1.'</td></tr>' );
				$wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '2').' '.$alternative_2.'</td></tr>' );
				if($alternative_3 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '3').' '.$alternative_3.'</td></tr>' ); }
				if($alternative_4 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '4').' '.$alternative_4.'</td></tr>' ); }
				if($alternative_5 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '5').' '.$alternative_5.'</td></tr>' ); }
				if($alternative_6 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '6').' '.$alternative_6.'</td></tr>' ); }
				$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-vote-other' ).'</td><td>'.Xml::input('vote_other').'</td></tr>' );
			}
			if( $multi == 1 ) {
				$wgOut->addHtml( '<tr><td>'.Xml::check('vote_1').' '.$alternative_1.'</td></tr>' );
				$wgOut->addHtml( '<tr><td>'.Xml::check('vote_2').' '.$alternative_2.'</td></tr>' );
				if($alternative_3 != "") { $wgOut->addHtml( '<tr><td>'.Xml::check('vote_3').' '.$alternative_3.'</td></tr>' ); }
				if($alternative_4 != "") { $wgOut->addHtml( '<tr><td>'.Xml::check('vote_4').' '.$alternative_4.'</td></tr>' ); }
				if($alternative_5 != "") { $wgOut->addHtml( '<tr><td>'.Xml::check('vote_5').' '.$alternative_5.'</td></tr>' ); }
				if($alternative_6 != "") { $wgOut->addHtml( '<tr><td>'.Xml::check('vote_6').' '.$alternative_6.'</td></tr>' ); }			
			}
			$wgOut->addHtml( '<tr><td>'.Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'vote').''.Xml::hidden('multi', $multi).'</td><td><a href="'.$this->getTitle()->getFullURL( 'action=score&id='.$vid ).'">'.wfMsg( 'poll-title-score' ).'</a></td></tr>' );
			$wgOut->addHtml( '<tr><td>' );
			$wgOut->addWikiText( '<small>'.wfMsg( 'poll-score-created', $creater ).'</small>' );
			$wgOut->addHtml( '</td></tr>' );
			$wgOut->addHtml( Xml::closeElement( 'table' ) );
			if( $wgUser->isAllowed( 'poll-admin' ) || ($creater == $wgUser->getName()) ) {
				$wgOut->addHtml( wfMsg('poll-administration').' <a href="'.$this->getTitle()->getFullURL('action=change&id='.$vid).'">'.wfMsg('poll-change').'</a> · <a href="'.$this->getTitle()->getFullURL('action=delete&id='.$vid).'">'.wfMsg('poll-delete').'</a>' );
			}
			$wgOut->addHtml( Xml::closeElement( 'form' ) );
		}
	}

	// This function create a score for the polls
	public function score( $sid ) {
		global $wgOut;

		$wgOut->setPagetitle( wfMsg( 'poll-title-score' ) );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, multi', array( 'id' => $sid ) );

		while( $row = $dbr->fetchObject( $query ) ) {
			$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
			$alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8'  );
			$alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8'  );
			$alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8'  );
			$alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8'  );
			$alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8'  );
			$alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8'  );
			$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8'  );
			$multi = $row->multi;
		}
		
		if($multi != 1) {
			$query_1 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '1', 'pid' => $sid ) );
			$query_2 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '2', 'pid' => $sid ) );
			$query_3 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '3', 'pid' => $sid ) );
			$query_4 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '4', 'pid' => $sid ) );
			$query_5 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '5', 'pid' => $sid ) );
			$query_6 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '6', 'pid' => $sid ) );

			$query_num_1 = $dbr->numRows( $query_1 );
			$query_num_2 = $dbr->numRows( $query_2 );
			$query_num_3 = $dbr->numRows( $query_3 );
			$query_num_4 = $dbr->numRows( $query_4 );
			$query_num_5 = $dbr->numRows( $query_5 );
			$query_num_6 = $dbr->numRows( $query_6 );
		}
		
		if($multi == 1) {
			$query_num_1 = 0;
			$query_num_2 = 0;
			$query_num_3 = 0;
			$query_num_4 = 0;
			$query_num_5 = 0;
			$query_num_6 = 0;
			
			$query_multi = $dbr->select( 'poll_answer', 'vote', array( 'pid' => $sid ) );
			while( $row = $dbr->fetchObject( $query_multi ) ) {
				$vote = $row->vote;
				$vote = explode("|", $vote);
				
				if($vote[0] == "1") { $query_num_1++; }
				if($vote[1] == "1") { $query_num_2++; }
				if($vote[2] == "1") { $query_num_3++; }
				if($vote[3] == "1") { $query_num_4++; }
				if($vote[4] == "1") { $query_num_5++; }
				if($vote[5] == "1") { $query_num_6++; }
			}
		}
		
		$query_other = $dbr->select( 'poll_answer', 'vote_other', array( 'pid' => $sid, 'isset_vote_other' => 1 ) );
		$score_other = array( );
		while( $row = $dbr->fetchObject( $query_other ) ) {
			if( !isset($score_other[$row->vote_other]['first']) ) {
				$score_other[$row->vote_other]['first'] = 0;
				$score_other[$row->vote_other]['number'] = 1;
				continue;
			}
			$score_other[$row->vote_other]['number']++;
		}
		$score_other_out = "";
		foreach($score_other as $name => $value) {
			$score_other_out .= '<tr><td>'.$name.'</td><td>'.$value['number'].'</td></tr>';
		}

		$wgOut->addHtml( Xml::openElement( 'table' ) );
		$wgOut->addHtml( '<tr><th><center>'.$question.'</center></th></tr>' );;
		$wgOut->addHtml( '<tr><td>'.$alternative_1.'</td><td>'.$query_num_1.'</td></tr>' );
		$wgOut->addHtml( '<tr><td>'.$alternative_2.'</td><td>'.$query_num_2.'</td></tr>' );
		if($alternative_3 != "") { $wgOut->addHtml( '<tr><td>'.$alternative_3.'</td><td>'.$query_num_3.'</td></tr>' ); }
		if($alternative_4 != "") { $wgOut->addHtml( '<tr><td>'.$alternative_4.'</td><td>'.$query_num_4.'</td></tr>' ); }
		if($alternative_5 != "") { $wgOut->addHtml( '<tr><td>'.$alternative_5.'</td><td>'.$query_num_5.'</td></tr>' ); }
		if($alternative_6 != "") { $wgOut->addHtml( '<tr><td>'.$alternative_6.'</td><td>'.$query_num_6.'</td></tr>' ); }
		if($score_other_out != "") { $wgOut->addHtml( '<tr><td colspan="2">'.wfMsg( 'poll-vote-other' ).'</td></tr>'. $score_other_out ); }
		$wgOut->addHtml( '<tr><td>' );
		$wgOut->addWikiText( '<small>'.wfMsg( 'poll-score-created', $creater ).'</small>' );
		$wgOut->addHtml( '</td></tr>' );
		$wgOut->addHtml( Xml::closeElement( 'table' ) );
		$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
	}

	// This function create a interfache for deleting polls
	public function delete( $did ) {
		global $wgOut;
		$wgOut->setPagetitle( wfMsg( 'poll-title-delete' ) );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question', array( 'id' => $did ) );

		while( $row = $dbr->fetchObject( $query ) ) {
			$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
		}

		if( $question ) {
			$wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $this->getTitle()->getFullURL('action=submit&id='.$did) ) ) );
			$wgOut->addHtml( Xml::check( 'controll_delete' ).' '.wfMsg('poll-delete-question', $question).'<br />' );
			$wgOut->addHtml( Xml::submitButton(wfMsg( 'poll-submit' )).' <a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>'.Xml::hidden('type', 'delete') );
			$wgOut->addHtml( Xml::closeElement( 'form' ) );
		} else {
			$wgOut->addWikiMsg( 'poll-invalid-id' );
		}
	}

	// This function create a interfache for changing polls
	public function change($cid) {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( 'poll-title-change' ) );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, dis', array( 'id' => $cid ) );

		while( $row = $dbr->fetchObject( $query ) ) {
			$question = $row->question;
			$alternative_1 = $row->alternative_1;
			$alternative_2 = $row->alternative_2;
			$alternative_3 = $row->alternative_3;
			$alternative_4 = $row->alternative_4;
			$alternative_5 = $row->alternative_5;
			$alternative_6 = $row->alternative_6;
			$creater = $row->creater;
			$dis = $row->dis;
		}

		if ( $wgUser->getName() != $creater ) {
			$wgOut->addWikiMsg( 'poll-change-right-error' );
			$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		}
		else {
			$wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $this->getTitle()->getFullURL('action=submit&id='.$cid) ) ) );
			$wgOut->addHtml( Xml::openElement( 'table' ) );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-question' ).':</td><td>'.Xml::input('question', false, $question).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 1:</td><td>'.Xml::input('poll_alternative_1', false, $alternative_1).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 2:</td><td>'.Xml::input('poll_alternative_2', false, $alternative_2).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 3:</td><td>'.Xml::input('poll_alternative_3', false, $alternative_3).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 4:</td><td>'.Xml::input('poll_alternative_4', false, $alternative_4).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 5:</td><td>'.Xml::input('poll_alternative_5', false, $alternative_5).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 6:</td><td>'.Xml::input('poll_alternative_6', false, $alternative_6).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-dis' ).':</td><td>'.Xml::textarea('dis', $dis).'</td></tr>' );
			$wgOut->addHtml( '<tr><td>'.Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'change').'</td></tr>' );
			$wgOut->addHtml( Xml::closeElement( 'table' ) );
			$wgOut->addHtml( Xml::closeElement( 'form' ) );
		}
	}

	// This fucntion execute the order of the other function
	public function submit( $pid ) {
		global $wgRequest, $wgOut, $wgUser;

		$type = $wgRequest->getVal('type');

		if($type == 'create') {
			if ( !$wgUser->isAllowed( 'poll-create' ) ) {
				$wgOut->addWikiMsg( 'poll-create-right-error' );
				$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
			}
			else {
				$dbw = wfGetDB( DB_MASTER );
				$question = $wgRequest->getVal('question');
				$alternative_1 = $wgRequest->getVal('poll_alternative_1');
				$alternative_2 = $wgRequest->getVal('poll_alternative_2');
				$alternative_3 = ($wgRequest->getVal('poll_alternative_3') != "")? $wgRequest->getVal('poll_alternative_3') : "";
				$alternative_4 = ($wgRequest->getVal('poll_alternative_4') != "")? $wgRequest->getVal('poll_alternative_4') : "";
				$alternative_5 = ($wgRequest->getVal('poll_alternative_5') != "")? $wgRequest->getVal('poll_alternative_5') : "";
				$alternative_6 = ($wgRequest->getVal('poll_alternative_6') != "")? $wgRequest->getVal('poll_alternative_6') : "";
				$dis = ($wgRequest->getVal('dis') != "")? $wgRequest->getVal( 'dis' ) : wfMsg('poll-no-dis');
				$multi = ($wgRequest->getVal( 'allow_more' ) == 1)? 1 : 0;
				$user = $wgUser->getName();

				if($question != "" && $alternative_1 != "" && $alternative_2 != "") {
					$dbw->insert( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
					'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
					'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis, 'multi' => $multi ) );

					$log = new LogPage( "poll" );
					$title = $this->getTitle();
					$log->addEntry( "poll", $title, wfMsg( 'poll-log-create', "[[User:".htmlentities( $user, ENT_QUOTES, 'UTF-8' )."]]", htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ) );

					$wgOut->addWikiMsg( 'poll-create-pass' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
				else {
					$wgOut->addWikiMsg( 'poll-create-fields-error' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
			}
		}

		if($type == 'vote') {
			if ( !$wgUser->isAllowed( 'poll-vote' ) ) {
				$wgOut->addWikiMsg( 'poll-vote-right-error' );
				$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
			}
			else {
				$dbw = wfGetDB( DB_MASTER );
				$multi = $wgRequest->getVal('multi');
				$uid = $wgUser->getId();

				$query = $dbw->select( 'poll_answer', 'uid', array( 'uid' => $uid, 'pid' => $pid ));
				$num = $dbw->numRows( $query );;
				
				if($multi != 1) {
					$vote = $wgRequest->getVal('vote');
					$vote_other = $wgRequest->getVal('vote_other');
					
					if($vote == "" AND $vote_other == "") {
						$vote = "err001";
					}
				}				
				if($multi == 1) {
					$vote_1 = $wgRequest->getVal('vote_1');
					$vote_2 = $wgRequest->getVal('vote_2');
					$vote_3 = $wgRequest->getVal('vote_3');
					$vote_4 = $wgRequest->getVal('vote_4');
					$vote_5 = $wgRequest->getVal('vote_5');
					$vote_6 = $wgRequest->getVal('vote_6');
					$vote_other = ($wgRequest->getVal('vote_other') != "")? $wgRequest->getVal('vote_other') : "";
					
					$vote = "";
					$vote .= ($vote_1 == 1)? "1|" : "0|";
					$vote .= ($vote_2 == 1)? "1|" : "0|";
					$vote .= ($vote_3 == 1)? "1|" : "0|";
					$vote .= ($vote_4 == 1)? "1|" : "0|";
					$vote .= ($vote_5 == 1)? "1|" : "0|";
					$vote .= ($vote_6 == 1)? "1" : "0";
					
					if($vote == "0|0|0|0|0|0" AND $vote_other == "") {
						$vote = "err001";
					}
				}
				
				if($vote == "err001") {
					$wgOut->addWikiMsg( 'poll-vote-empty-error' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
					
					return;
				}
				
				if($vote_other != "") {
					$vote = "";
					$isset_vote_other = 1;
				}
				elseif($vote_other == "") {
					$isset_vote_other = 0;
				}

				if( $num == 0 ) {
					$dbw->insert( 'poll_answer', array( 'pid' => $pid, 'uid' => $uid, 'vote' => $vote, 'user' => $wgUser->getName(), 'isset_vote_other' => $isset_vote_other, 'vote_other' => $vote_other  ) );

					$wgOut->addWikiMsg( 'poll-vote-pass' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
				else {
					$dbw->update( 'poll_answer', array( 'vote' => $vote, 'isset_vote_other' => $isset_vote_other, 'vote_other' => $vote_other ), array( 'uid' => $uid, 'pid' => $pid ) );
					
					$wgOut->addWikiMsg( 'poll-vote-changed' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
			}
		}

		if($type == 'change') {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'creater', array( 'id' => $pid ) );

			while( $row = $dbr->fetchObject( $query ) ) {
				$creater = htmlentities( $row->creater );
			}

			$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );

			if ( ( $creater != $wgUser->getName() ) && !$wgUser->isAllowed( 'poll-admin' ) ) {
				$wgOut->addWikiMsg( 'poll-change-right-error' );
				$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				return;
			}
			if ( ( $creater == $wgUser->getName() ) || $wgUser->isAllowed( 'poll-admin' ) )  {
				$dbw = wfGetDB( DB_MASTER );
				$question = $wgRequest->getVal('question');
				$alternative_1 = $wgRequest->getVal('poll_alternative_1');
				$alternative_2 = $wgRequest->getVal('poll_alternative_2');
				$alternative_3 = ($wgRequest->getVal('poll_alternative_3') != "")? $wgRequest->getVal('poll_alternative_3') : "";
				$alternative_4 = ($wgRequest->getVal('poll_alternative_4') != "")? $wgRequest->getVal('poll_alternative_4') : "";
				$alternative_5 = ($wgRequest->getVal('poll_alternative_5') != "")? $wgRequest->getVal('poll_alternative_5') : "";
				$alternative_6 = ($wgRequest->getVal('poll_alternative_6') != "")? $wgRequest->getVal('poll_alternative_6') : "";
				$dis = ($wgRequest->getVal('dis') != "")? $wgRequest->getVal('dis') : wfMsg('poll-no-dis');
				$user = $wgUser->getName();

				$dbw->update( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
				'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
				'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis ), array( 'id' => $pid ) );

				$log = new LogPage( "poll" );
				$title = $this->getTitle();
				$log->addEntry( "poll", $title, wfMsg( 'poll-log-change', "[[User:".htmlentities( $user, ENT_QUOTES, 'UTF-8' )."]]", htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ) );

				$wgOut->addWikiMsg( 'poll-change-pass' );
				$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
			}
		}

		if($type == 'delete') {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'creater, question', array( 'id' => $pid ) );

			while( $row = $dbr->fetchObject( $query ) ) {
				$creater = htmlentities( $row->creater );
				$question = $row->question;
			}

			if ( ( $creater != $wgUser->getName() ) && !$wgUser->isAllowed( 'poll-admin' ) ) {
				$wgOut->addWikiMsg( 'poll-delete-right-error' );
				$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				return;
			}
			if ( ( $creater == $wgUser->getName() ) || $wgUser->isAllowed( 'poll-admin' ) ) {
				if( $wgRequest->getCheck('controll_delete') && $wgRequest->getVal('controll_delete') == 1 ) {
					$dbw = wfGetDB( DB_MASTER );

					$dbw->delete( 'poll', array( 'id' => $pid ) );
					$dbw->delete( 'poll_answer', array( 'uid' => $pid ) );

					$log = new LogPage( "poll" );
					$title = $this->getTitle();
					$log->addEntry( "poll", $title, wfMsg( 'poll-log-delete', "[[User:".htmlentities( $wgUser->getName(), ENT_QUOTES, 'UTF-8' )."]]", htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ) );

					$wgOut->addWikiMsg( 'poll-delete-pass' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
				else {
					$wgOut->addWikiMsg( 'poll-delete-cancel' );
					$wgOut->addHtml( '<a href="'.$this->getTitle()->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
				}
			}
		}
	}
}
