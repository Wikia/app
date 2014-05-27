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
	private $allowed_params = [ 'm', 'b', 'a', 'no-rc', 'newonly' ];
	private $title;
	private $username;
	private $namespace;
	private $text;
	private $summary_text;
	/**
	 * add two numbers together
	 *
	 * @param int $uid - User ID
	 * @param int $article - Article name
	 * @param string $text - Text to add to comtent
	 * @param string $summary - Summary of edit
	 * @param string $wikis - Comma separated list of Wikis
	 * @param string $params - Comma separated list of edit params( m: minor edit, b: bot (hidden) edit, a: enable autosummary, no-rc: do not show the change in recent changes, newonly: skip existing articles)
	 * 
	 * @return double
	 */
	public function edit( $uid, $article = '', $text = '', $summary = '', $wikis = '', $lang = null, $cat = null, $params = '' ) {
		global $IP;
		
		# set username
		$oUser = \User::newFromId( $uid );
		if ( $oUser instanceof \User ) {
			$oUser->load();
			$this->username = $oUser->getName();
		} else {
			$this->username = '';
		}

		if ( !empty( $this->username ) ) {
			throw new \Exception( 'Invalid task result: ' . __METHOD__ );
			return true;
		}
		
		# check params
		if ( !empty( $params ) ) {
			foreach ( explode( ',', $params ) as $param ) {
				$param = trim( $param );
				if ( in_array( $param, $this->allowed_params ) ) {
					$this->params[] = $param;
				}
			}
		}

		# check page title
		$page = \Title::newFromText( $article );
		if ( !is_object($page) ) {
			throw new \Exception( 'Invalid article (' . $article . '): ' . __METHOD__ );
			return true;
		}

		$this->namespace = $page->getNamespace();
		$this->title = str_replace( ' ', '_', $page->getText() );
		$this->text = $text;
		$this->summary_text = $summary;

		# check wikis
		$task_wikis = [];
		if ( !empty( $wikis ) ) {
			$task_wikis = explode( ",", $wikis );
		}
		
		(new \WikiaSQL())
			->SELECT('pp_page')
			->FROM('page_props')
			->WHERE('pp_propname')->EQUAL_TO(BLOGTPL_TAG)
			->runLoop($db, function($unused, $row) {
				$article = \Article::newFromID($row->pp_page);

				if ($article instanceof \Article) {
					$articles[] = $row->pp_page;
					$article->doPurge();
					$article->getTitle()->purgeSquid();
				}
			});
			
		$wikis_to_execute = $this->fetchWikis( $task_wikis, $lang, $cat );

		if ( !empty($wikis_to_execute) ) {
			$this->log("Found " . count($wikis_to_execute) . " Wikis to proceed");
			foreach ( $wikis_to_execute as $id => $oWiki ) {
				$result = "";

				$sCommand = $this->makeCommand( $oWiki );

				$response = wfShellExec( $sCommand, $result );
				if ( $result ) {
					$this->log( 'Article editing error! (' . $oWiki->city_server . '). Error code returned: ' .  $result . ' Error was: ' . $response );
				}
				else {
					$this->log( '<a href="' . $oWiki->city_server . $oWiki->city_script . '?title=' . wfEscapeWikiText($response) . '">' . $oWiki->city_server . $oWiki->city_script . '?title=' . $response . '</a>');
				}
			}
		}
		
		return $username;
	}
	
	private function fetchWikis( $wikis = [], $lang = null, $cat = null ) {
		global $wgExternalSharedDB ;
		$dbr = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

		$where = [ "city_public" => 1 ];
		$count = 0;
		
		# check conditions
		if ( !empty( $lang ) ) 
			$where[ 'city_lang' ] = $lang;
			
		if ( !empty( $cat ) )
			$where[ 'cat_id' ] = $cat;

		if ( !empty( $wikis ) && count( $wikis ) == 1 ) {
			$where[ 'city_list.city_id' ] = reset( $wikis );
			$wikis = [];
		}

		if ( empty( $wikis ) ) {
			$oRes = $dbr->select(
				[ "city_list", "city_cat_mapping" ],
				[ "city_list.city_id, city_dbname, city_url, '' as city_server', '' as city_script" ], 
				[ "city_list join city_cat_mapping on city_cat_mapping.city_id = city_list.city_id" ],
				[ "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ],
				$where,
				__METHOD__
			);
		} else {
			$where[] = " city_list.city_id = city_domains.city_id ";
			$where[] = " city_domain in ('" . implode("','", $wikis) . "') ";

			$oRes = $dbr->select(
				[ "city_list", "city_domains" ],
				[ "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ],
				$where,
				__METHOD__
			);
		}

		$wiki_array = array();
		while ( $oRow = $dbr->fetchObject($oRes) ) {
			$oRow->city_server = \WikiFactory::getVarValueByName( "wgServer", $oRow->city_id );
			$oRow->city_script = \WikiFactory::getVarValueByName( "wgScript", $oRow->city_id );
			array_push($wiki_array, $oRow) ;
		}
		$dbr->freeResult ($oRes) ;

		return $wiki_array;
	}
	
	private function makeCommand( $oWiki ) {
		$sCommand = "SERVER_ID=". $oWiki->city_id ." php $IP/maintenance/wikia/editOn.php ";
		if ( !empty( $this->username ) ) {
			$sCommand .= "-u $username ";
		}

		# parse text options 
		$parse = [
			't' => $this->title,
			'n' => $this->namespace,
			'x' => $this->text,
			's' => $this->summary
		];
		
		foreach ( $parse as $opt => $value ) {
			if ( !empty( $value ) ) {
				$sCommand .= sprintf( "-%s %s ", $opt, $value );
			}
		}

		# check params 
		if ( !empty( $this->params ) ) {
			foreach ( $this->params as $param ) { 
				if ( !empty( $param ) ) {
					$sCommand .= sprintf( "-%s ", $param );
				}
			}
		} 

		$sCommand .= "--conf $wgWikiaLocalSettingsPath";
		
		return $sCommand;
	}
}
