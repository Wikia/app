<?php

/**
 * Counts namespaces usage across all Wikia pages
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek, Piotr Molski
 */

ini_set( "include_path", dirname(__FILE__)."/../../maintenance/" );

$optionsWithArgs = array( 'city' );

require_once( "commandLine.inc" );

class CountNamespacesPerWikia {

	const UNKNOWN_NAME_REGEX = "/^Namespace-(.*)\$/";

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
	}

	public function execute() {
		global $wgExternalSharedDB, $wgContentNamespaces;

		if ( $this->options['city'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res2 = $dbr->select(
				'page',
				array( 'page_namespace', 'count(page_namespace) as cnt' ),
				array(),
				__METHOD__,
				array( 'GROUP BY' => 1 )
			);

			$data = array();
			while ( $row2 = $dbr->fetchObject( $res2 ) ) {
				$name = $data[ $row2->page_namespace ]['ns_name'];
				if ( empty( $name ) ) {
					$name = $this->resolveNamespace( $row2->page_namespace );
				}
				$data[ $row2->page_namespace ] = array(
					'ns_name' => $name,
					'cnt' => $data[ $row2->page_namespace ] + $row2->cnt,
					'content' => intval( in_array( $row2->page_namespace, $wgContentNamespaces ) ),
					'no_content' => intval( !in_array( $row2->page_namespace, $wgContentNamespaces ) )
				);
			}
			$dbr->freeResult($res2);
		} else {
			$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$res = $db->select(
				'city_list',
				array( 'city_id', 'city_dbname' ),
				array( 'city_public' => 1),
				__METHOD__,
				array(
					'ORDER BY' => 'city_id',
				)
			);

			$data = array();
			while ($row = $db->fetchObject($res)) {
				echo "count " . $row->city_dbname . " #".$row->city_id . "\n";
				$dir = dirname(__FILE__);
				$cmd = "SERVER_ID={$row->city_id} php {$dir}/count_namespaces_per_wikia.php ";
				$cmd .="--conf {$this->options['conf']} ";
				$cmd .="--city {$row->city_id}";
				$output = array();
				$records = exec($cmd,$output);

				if ( !empty( $records ) ) {
					$x = split( "\n", $records );
					foreach ( $x as $id => $val ) {
						$y = split(";", $val);
						$data[ $y[0] ] = array(
							'ns_name' => $y[1], 
							'cnt' => $y[2] + $data[ $y[0] ]['cnt'],
							'content' => $data[ $y[0] ]['content'] + $y[3],
							'no_content' => $data[ $y[0] ]['content'] + $y[4],
						);
					}
				}
			}
			$db->freeResult($res);
		}

		foreach ( $data as $ns => $cnt ) {
			echo $ns. ";" . $cnt['ns_name'] . ";" . $cnt['cnt'] . ";" . $cnt['content'] . ";" . $cnt['no_content'] . "\n";
		}

		return $data;
	}

	public function stderr() {
		static $fp;
		if (!$fp) {
			$fp = fopen("php://stderr","w");
		}
		$args = func_get_args();
		foreach ($args as $v) {
			fwrite($fp,(string)$v);
		}
	}

	public function getNamespaceName( $ns ) {
		$ns = intval($ns);
		if (!$ns) {
			$name = "Main";
		} else {
			$name = MWNamespace::getCanonicalName($ns);
			if ( empty($name) ) {
				$name = "Namespace-{$ns}";
			}
		}
		return $name;
	}

	public function isUnknown( $name, &$ns = null ) {
		if (preg_match(self::UNKNOWN_NAME_REGEX,$name,$matches)) {
			$ns = intval($matches[1]);
			return true;
		}
		return false;
	}

	public function resolveNamespace( $ns ) {
		$name = $this->getNamespaceName($ns);
		if ($this->isUnknown($name)) {
			global $wgExternalDatawareDB;
			$db = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );

			$this->stderr("finding wiki with edits in namespace $ns\n");
			$row = $db->selectRow(
				'pages',
				'page_wikia_id',
				array(
					'page_namespace' => $ns,
				),
				__METHOD__,
				array(
					'LIMIT' => 1,
				)
			);

			if ($row) {
				$wikiId = $row->page_wikia_id;
				$this->stderr("executing script to fetch namespace name from wiki $wikiId\n");
				$dir = dirname(__FILE__);
				$conf = $this->options['conf'];
				$cmd = "SERVER_ID={$wikiId} php {$dir}/count_namespaces.php --conf {$conf} --namespace $ns";

				$output = array();
				$name = exec($cmd,$output);
				$this->stderr("found namespace $ns to be called \"$name\"\n");
			}
		}
		return $name;
	}
}

/**
 * used options:
 */
$maintenance = new CountNamespacesPerWikia( $options );
$maintenance->execute();
