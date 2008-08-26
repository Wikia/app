<?php
/**
 *
 */
class Poll {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		
	}
	
	public function add_poll_question($question,$image,$page_id){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->insert( '`poll_question`',
		array(
			'poll_page_id' => $page_id,
			'poll_user_id' => $wgUser->getID(),
			'poll_user_name' => $wgUser->getName(),
			'poll_text' => strip_tags($question),
			'poll_image' => $image,
			'poll_date' => date("Y-m-d H:i:s"),
			'poll_random' => wfRandom()
			), __METHOD__
		);	
		return $dbr->insertId();
	}
	
	public function add_poll_choice($poll_id,$choice_text,$choice_order){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->insert( '`poll_choice`',
		array(
			'pc_poll_id' => $poll_id,
			'pc_text' => strip_tags($choice_text),
			'pc_order' => $choice_order
			), __METHOD__
		);
	}

	public function add_poll_vote($poll_id,$choice_id){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->insert( '`poll_user_vote`',
		array(
			'pv_poll_id' => $poll_id,
			'pv_pc_id' => $choice_id,
			'pv_user_id' => $wgUser->getID(),
			'pv_user_name' => $wgUser->getName(),
			'pv_date' => date("Y-m-d H:i:s")
			), __METHOD__
		);
		if($choice_id > 0 ){
			$this->inc_poll_vote_count($poll_id);
			$this->inc_choice_vote_count($choice_id);
			$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
			$stats->incStatField("poll_vote");
		}
	}
	
	public function inc_choice_vote_count($choice_id){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'poll_choice',
		array( 'pc_vote_count=pc_vote_count+1'),
		array( 'pc_id' => $choice_id ),
		__METHOD__ );
	}
	
	public function inc_poll_vote_count($poll_id){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'poll_question',
		array( 'poll_vote_count=poll_vote_count+1'),
		array( 'poll_id' => $poll_id ),
		__METHOD__ );
	}
	
	public function get_poll($page_id){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT poll_text, poll_vote_count, poll_id, poll_status,
			poll_user_id, poll_user_name, poll_image, UNIX_TIMESTAMP(poll_date) as timestamp
			FROM poll_question WHERE poll_page_id = {$page_id} LIMIT 0,1";
		
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$poll["question"]= $row->poll_text;
			$poll["image"]= $row->poll_image;
			$poll["user_name"]= $row->poll_user_name;
			$poll["user_id"]= $row->poll_user_id;
			$poll["votes"]= $row->poll_vote_count;	
			$poll["id"]= $row->poll_id;
			$poll["status"]= $row->poll_status;
			$poll["timestamp"] = $row->timestamp;
			$poll["choices"] = $this->get_poll_choices( $row->poll_id,$row->poll_vote_count );
		}
		return $poll;
	}
	
	public function get_poll_choices($poll_id, $poll_vote_count = 0){
		$dbr =& wfGetDB( DB_SLAVE );
		
		$sql = "SELECT pc_id,pc_text,pc_vote_count
			FROM poll_choice 
			WHERE pc_poll_id = {$poll_id}
			ORDER BY pc_order
			";
		
		$choices = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if($poll_vote_count){
				$percent =  str_replace(".0","",number_format( $row->pc_vote_count / $poll_vote_count  * 100 , 1) ) ;
			}else{
				$percent = 0;
			}
			//$percent = round( $row->pc_vote_count / $poll_vote_count  * 100 );

			 $choices[] = array(
				 "id"=>$row->pc_id,"choice"=>$row->pc_text,"votes"=>$row->pc_vote_count ,"percent"=>$percent
				 );
		}
	
		return $choices;
	}
	
	public function user_voted($user_name,$poll_id){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`poll_user_vote`', array( 'pv_id' ), array('pv_poll_id'=>$poll_id, 'pv_user_name' => $user_name ), __METHOD__ );
		if ( $s !== false ) {
			return true;
		}
		return false;
	}
	
	public function does_user_own_poll($user_id,$poll_id){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`poll_question`', array( 'poll_id' ), array('poll_id'=>$poll_id, 'poll_user_id' => $user_id ), __METHOD__ );
		if ( $s !== false ) {
			return true;
		}
		return false;
	}	
	
	public function get_random_poll_url($user_name){
		$poll_id = $this->get_random_poll_id($user_name);
		if($poll_id){
			$poll_page = Title::newFromID($poll_id);
			global $wgContLang;
		  	return $wgContLang->getNsText( NS_POLL ) . ":".$poll_page->getDBKey();
		}else{
			return "error";
		}
	}
	
	public function get_random_poll($user_name){
		$poll_id = $this->get_random_poll_id($user_name);
		$poll = array();
		if($poll_id){
			$poll = $this->get_poll($poll_id);
		}
		return $poll;
	}
	
	public function get_random_poll_id($user_name){
		$dbr =& wfGetDB( DB_MASTER );
		$poll_page_id = 0;
		$use_index = $dbr->useIndexClause( 'poll_random' );
		$randstr = wfRandom();
		$sql = "SELECT poll_page_id FROM poll_question {$use_index} inner join page on page_id=poll_page_id WHERE poll_id NOT IN (select pv_poll_id from poll_user_vote where pv_user_name = '" . addslashes($user_name) . "') and poll_status=1 and poll_random>$randstr ORDER by poll_random LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		//random fallback
		if(!$row){
			$sql = "SELECT poll_page_id FROM poll_question {$use_index} inner join page on page_id=poll_page_id WHERE poll_id NOT IN (select pv_poll_id from poll_user_vote where pv_user_name = '" . addslashes($user_name) . "') and poll_status=1 and poll_random<$randstr ORDER by poll_random LIMIT 0,1";
			wfDebug( $sql );
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );
		} 
		if($row){
			$poll_page_id  = $row->poll_page_id;
		}
		
		return $poll_page_id;
	}
	
	public function update_poll_status($poll_id,$status){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'poll_question',
		array( 'poll_status' => $status),
		array( 'poll_id' => $poll_id ),
		__METHOD__ );
	}
	
	public function getPollList( $count = 3, $order = "poll_id" ){
		global $wgMemc;
		
		//try cache
		$key = wfMemcKey( 'polls', 'order', $order, 'count', $count);
		$data = $wgMemc->get( $key );
		//$wgMemc->delete( $key );
		if( $data ){                   
			wfDebug( "Got polls list ($count) ordered by {$order} from cache\n" );
			$polls = $data;
		}else{
			wfDebug( "Got polls list ($count) ordered by {$order} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$params['LIMIT'] = $count;
			$params['ORDER BY'] = "{$order} desc";
			$res = $dbr->select( '`poll_question`
				INNER JOIN page on page_id=poll_page_id'
				, array('page_title', 'poll_id', 'poll_vote_count', 'poll_image', 'UNIX_TIMESTAMP(poll_date) as poll_date'), 
				/*where*/  array('poll_status' => 1) , __METHOD__, 
					$params
			);
			while( $row = $dbr->fetchObject($res) ) {
				$polls[] = array (
					"title" => $row->page_title,
					"timestamp" => $row->poll_date,
					"image" => $row->poll_image,
					"choices" => self::get_poll_choices( $row->poll_id, $row->poll_vote_count )
				);				
			}
			$wgMemc->set( $key, $polls, 60 * 10 );
		}

		return $polls;		
	}
}
	
?>
