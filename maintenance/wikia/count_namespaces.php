<?php

/**
 * Counts namespaces usage across all Wikia pages
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../maintenance/" );

$optionsWithArgs = array(
);


require_once( "commandLine.inc" );


class CountNamespaces {

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		
	}
	
	public function execute() {
		global $wgExternalDatawareDB;
		$db = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		
		$res = $db->select(
			'pages',
			array( 'page_namespace', 'count(*) as pages_count' ),
			array(),
			__METHOD__,
			array(
				'GROUP BY' => 'page_namespace',
				'ORDER BY' => 'page_namespace',
			)
		);
		
		while ($row = $db->fetchObject($res)) {
			$name = MWNamespace::getCanonicalName($row->page_namespace);
			if (!$name) $name = "Namespace-".$row->page_namespace;
			echo "$name\t{$row->pages_count}\n";
		}
		
	}

}

/**
 * used options:
 */
$maintenance = new CountNamespaces( $options );
$maintenance->execute();
