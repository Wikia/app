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
	/**
	 * @param $uid
	 * @param string $article
	 * @param string $text
	 * @param string $summary
	 * @param string $wikis
	 * @param string $lang
	 * @param string $cat
	 * @param string $params
	 */
	public function edit( $uid, $article = '', $text = '', $summary = '', $wikis = '', $lang = '', $cat = '', $params = '' ) {
	}

	/**
	 * @param $params
	 * @return bool
	 */
	public function delete( $params ) {
		$escapedImpersonatedName = escapeshellarg($params['user']);
		$createdBy = \User::newFromId($this->createdBy());
		$impersonatedUser = \User::newFromName($escapedImpersonatedName);
		$impersonatedUsername = is_object($impersonatedUser) ? $escapedImpersonatedName : '';
		$page = \Title::newFromText($params['page']);

		$this->info('deleting page', [
			'user' => $createdBy->getName(),
			'impersonating' => $impersonatedUsername,
			'title' => $params['page'],
		]);

		if (!is_object($page)) {
			$this->error('page is invalid, terminating task', [
				'title' => $params['page'],
			]);

			return false;
		}

		$commandParams = [
			't' => str_replace(' ', '_', $page->getPrefixedText()),
			'u' => $impersonatedUsername,
		];

		if (isset($params['suppress']) && $params['suppress'] === true) {
			$commandParams['s'] = null;
		}

		if (isset($params['reason'])) {
			$commandParams['r'] = $params['reason'];
		}

		$this->runOnWikis($params['wikis'], $params['lang'], $params['cat'], $params['selwikia'], 'delete', $commandParams);

		return true;
	}

	/**
	 * @param $uid
	 * @param string $article
	 * @param string $newarticle
	 * @param string $reason
	 * @param string $wikis
	 * @param string $lang
	 * @param string $cat
	 * @param string $params
	 * @return bool|mixed|string
	 * @throws \Exception
	 */
	public function move( $uid, $article = '', $newarticle = '', $reason = '', $wikis = '', $lang = '', $cat = '', $params = '' ) {
	}
	
	private function runOnWikis($wikiInputRaw, $lang, $cat, $wikiId, $action, $commandParams) {
		global $wgExternalSharedDB ;
		$db = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

		$wikiDomains = [];
		foreach (explode("\n", $wikiInputRaw) as $wikiLine) {
			foreach (explode(',', $wikiLine) as $wikiLinePart) {
				$wikiLinePart = trim($wikiLinePart);
				if (!empty($wikiLinePart)) {
					$wikiDomains []= $wikiLinePart;
				}
			}
		}
		
		// Get a count of articles in a category.  Give at least a very small cache TTL
		$query = (new \WikiaSQL())->cache( 60 )
			->SELECT( 'city_list.city_id', 'city_list.city_dbname', 'city_list.city_url' )
			->FROM( 'city_list' )
			->WHERE( 'city_public' )->EQUAL_TO( 1 );

		if ( !empty( $lang ) ) {
			$query->AND_( 'city_list.city_lang' )->EQUAL_TO( $lang );
		}

		if (!empty($wikiId)) {
			$query->AND_('city_list.city_id')->EQUAL_TO($wikiId);
		}

		if (!empty($cat)) {
			$query->AND_( 'city_cat_mapping.cat_id' )->EQUAL_TO( $cat )
				->JOIN('city_cat_mapping')->ON('city_cat_mapping.city_id', 'city_list.city_id');
		}

		if (!empty($wikiDomains)) {
			$query->AND_('city_domains.city_domain')->IN($wikiDomains)
				->JOIN('city_domains')->ON('city_domains.city_id', 'city_list.city_id');
		}

		$result = $query->runLoop( $db, function( &$result, $row ) use ( $action, $commandParams ) {
			$row->city_server = \WikiFactory::getVarValueByName( "wgServer", $row->city_id );
			$row->city_script = \WikiFactory::getVarValueByName( "wgScript", $row->city_id );
			$res = $this->runCommand( $row, $action, $commandParams );
			$result[ $row->city_dbname ] = ( $res == false ) ? 0 : 1 ;
		} );

		return $result;
	}
	
	private function makeCommand( $row, $action, $params ) {
		global $IP;

		$command = "SERVER_ID=". $row->city_id ." php $IP/maintenance/wikia/{$action}On.php";

		foreach ( $params as $opt => $value ) {
			$command .= " -{$opt} ";
			if ($value !== null) {
				$command .= escapeshellarg($value);
			}
		}
		
		return $command;
	}

	private function runCommand( $row, $action, $params ) {
		$command = $this->makeCommand( $row, $action, $params );
		$response = wfShellExec( $command, $result );
	
		if ( $result !== 0 ) {
			$res = false;
			$this->error('Multi task error!', [
				'action' => $action,
				'server' => $row->city_server,
				'exitStatus' => $result,
				'error' => $response,
			]);
		}
		else {
			$res = true;
			$this->info('Multi task complete!', [
				'link' => "{$row->city_server}{$row->city_script}?title=".wfEscapeWikiText($response),
			]);
		}
		
		return $res;
	} 
}
