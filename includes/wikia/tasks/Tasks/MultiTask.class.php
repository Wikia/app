<?php
/**
 * MultiTask
 *
 * dummy math class for testing puposes
 *
 * @author Piotr Molski <moli@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

class MultiTask extends BaseTask {
	private $params = [];
	private $main_params = [];
	private $username;
	private $page;
	private $action = '';
	private $result = [];
	
	/**
	 * add/change text of page on Wikis
	 *
	 * @param int $uid - User ID
	 * @param string $article - Article name (with namespace if needed)
	 * @param string $text - Text to add to comtent
	 * @param string $summary - Summary of edit
	 * @param string $wikis - Comma separated list of Wikis (database names)
	 * @param string $lang - Edit pages only on language-base Wikis
	 * @param string $cat - Edit pages only on category-base Wikis
	 * @param string $params - Comma separated list of edit params: <ul><li>m: minor edit,</li><li>b: bot (hidden) edit,</li><li>a: enable autosummary,</li><li>no-rc: do not show the change in recent changes,</li><li>newonly: skip existing articles</li></ul>
	 * 
	 * @return double
	 */
	public function edit( $uid, $article = '', $text = '', $summary = '', $wikis = '', $lang = '', $cat = '', $params = '' ) {
		# set username
		$oUser = \User::newFromId( $uid );
		if ( $oUser instanceof \User ) {
			$oUser->load();
			$this->username = $oUser->getName();
		} else {
			$this->username = '';
		}
		
		if ( empty( $this->username ) ) {
			$error = 'Username cannot be empty';
			throw new \Exception( $error . ': ' . __METHOD__  );
			return $error;
		}
		
		# check params
		if ( !empty( $params ) ) {
			foreach ( explode( ',', $params ) as $param ) {
				$this->params[] = trim( $param );
			}
		}

		# check page title
		$this->page = \Title::newFromText( $article );
		if ( !is_object( $this->page ) ) {
			$error = 'Invalid article (' . $article . ')';
			throw new \Exception( $error . ': ' . __METHOD__ );
			return $error;
		}

		# parse text options 
		$this->main_params = [
			'u' => $this->username,
			't' => str_replace( ' ', '_', $this->page->getText() ),
			'n' => $this->page->getNamespace(),
			'x' => $text,
			's' => $summary
		];
		
		# check wikis
		$task_wikis = [];
		if ( !empty( $wikis ) ) {
			$task_wikis = explode( ",", $wikis );
		}
		
		$this->action = 'edit';
		$result = $this->runOnWikis( $task_wikis, $lang, $cat );
		
		return $result;
	}
	
	/**
	 * go with each supplied wiki and delete the supplied article
	 *
	 * @param int $uid - Remove page as User
	 * @param string $article - Article name (with namespace if needed)
	 * @param string $text - Text to add to comtent
	 * @param string $wikis - Comma separated list of Wikis (database names)
	 * @param string $reason - Reason of removing
	 * @param string $params - Comma separated list of delete params: <ul><li>s: bitfields to further suppress the content (Revision::DELETED_TEXT, Revision::DELETED_COMMENT, Revision::DELETED_USER, Revision::DELETED_RESTRICTED),</li></ul>
	 * 
	 * @return double
	 */
	public function delete( $uid, $article = '', $wikis = '', $lang = '', $cat = '', $reason = '', $params = '' ) {
		# set username
		$oUser = \User::newFromId( $uid );
		if ( $oUser instanceof \User ) {
			$oUser->load();
			$this->username = $oUser->getName();
		} else {
			$this->username = '';
		}
		
		if ( empty( $this->username ) ) {
			$error = 'Username cannot be empty';
			throw new \Exception( $error . ': ' . __METHOD__  );
			return $error;
		}
		
		# check params
		if ( !empty( $params ) ) {
			foreach ( explode( ',', $params ) as $param ) {
				$this->params[] = trim( $param );
			}
		}

		# check page title
		$this->page = \Title::newFromText( $article );
		if ( !is_object($this->page) ) {
			$error = 'Invalid article (' . $article . ')';
			throw new \Exception( $error . ': ' . __METHOD__ );
			return $error;
		}

		# parse text options 
		$this->main_params = [
			't' => str_replace( ' ', '_', $this->page->getText() ),
			'u' => $this->username,
			'r' => $reason,
		];
		
		# check wikis
		$task_wikis = [];
		if ( !empty( $wikis ) ) {
			$task_wikis = explode( ",", $wikis );
		}		

		$this->action = 'delete';
		$result = $this->runOnWikis( $task_wikis, $lang, $cat );

		return $result;
	}

	/**
	 * move page to another page on Wikis
	 *
	 * @param int $uid - User ID
	 * @param string $article - Article name (with namespace if needed)
	 * @param string $text - Text to add to comtent
	 * @param string $summary - Summary of edit
	 * @param string $wikis - Comma separated list of Wikis (database names)
	 * @param string $params - Comma separated list of edit params: <ul><li>m: minor edit,</li><li>b: bot (hidden) edit,</li><li>a: enable autosummary,</li><li>no-rc: do not show the change in recent changes,</li><li>newonly: skip existing articles</li></ul>
	 * 
	 * @return double
	 */
	public function move( $uid, $article = '', $summary = '', $wikis = '', $lang = '', $cat = '', $params = '' ) {
	}
	
	private function runOnWikis( $wikis=[], $lang = '', $cat = '' ) {
		global $wgExternalSharedDB ;
		$db = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);
		
		// Get a count of articles in a category.  Give at least a very small cache TTL
		$query = (new \WikiaSQL())->cache( 60 )
			->SELECT( 'city_list.city_id' )
				->FIELD('city_dbname')
				->FIELD('city_url')
			->FROM( 'city_list' )
			->WHERE( 'city_public' )->EQUAL_TO( 1 );

		$count = 0;
		# check conditions
		if ( !empty( $lang ) ) 
			$query->AND_( 'city_lang' )->EQUAL_TO( $lang );
			
		if ( !empty( $cat ) )
			$query->AND_( 'cat_id' )->EQUAL_TO( $cat );

		if ( !empty( $wikis ) && count( $wikis ) == 1 ) {
			$query->AND_( 'city_dbname' )->EQUAL_TO( reset( $wikis ) );
		} elseif ( !empty( $wikis ) ) {
			$query->AND_( 'city_domain' )->IN( $wikis );
		}
		
		if ( empty( $wikis ) && !empty( $cat) ) {
			$join = [
				'table' => 'city_cat_mapping',
				'on'	=> 'city_cat_mapping.city_id = city_list.city_id'
			];
		} elseif ( !empty( $wikis ) ) {
			$join = [
				'table' => 'city_domains',
				'on'	=> 'city_list.city_id = city_domains.city_id'
			];
		}
		
		$query->JOIN( $join['table'] )->ON( $join['on'] );
		// Run the query we've built

		$count = 0;
		$result = $query->runLoop( $db, function( &$result, $row ) use ( &$count ) {
			$res = $this->callback( $count, $row );
			$result[ $row->city_dbname ] = ( $res == false ) ? 0 : 1 ;
		} );

		return $result;
	}
	
	private function makeCommand( $row ) {
		global $IP, $wgWikiaLocalSettingsPath;

		$row->city_server = \WikiFactory::getVarValueByName( "wgServer", $row->city_id );
		$row->city_script = \WikiFactory::getVarValueByName( "wgScript", $row->city_id );
		
		$sCommand = "SERVER_ID=". $row->city_id ." php $IP/maintenance/wikia/{$this->action}On.php ";

		# check text params
		foreach ( $this->main_params as $opt => $value ) {
			if ( !is_null( $value ) ) {
				$sCommand .= sprintf( "-%s %s ", $opt, escapeshellarg( $value ) );
			}
		}

		# check params 
		if ( !empty( $this->params ) ) {
			foreach ( $this->params as $param ) { 
				if ( !is_null( $param ) ) {
					$sCommand .= sprintf( "-%s ", $param );
				}
			}
		} 

		$sCommand .= "--conf $wgWikiaLocalSettingsPath";
		
		return $sCommand;
	}
	
	private function callback( &$count, $row ) {
		$command = $this->makeCommand( $row );
		$response = wfShellExec( $command, $result );
	
		if ( $result ) {
			$res = false;
			$this->log( 'Multi task (' . $this->action . ') error! (' . $row->city_server . '). Error code returned: ' .  $result . ' Error was: ' . $response );
		}
		else {
			$res = true;
			$this->log( $this->action . ' done: <a href="' . $row->city_server . $row->city_script . '?title=' . wfEscapeWikiText( $response ) . '">' .$row->city_server . $row->city_script . '?title=' . $response . '</a>');
			$count++;
		}
		
		return $res;
	} 
}
