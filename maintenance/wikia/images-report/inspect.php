<?php

class Csv implements IteratorAggregate {
	public $data = array();
	public $mapping = array();
	public function __construct( $fileName ) {
		$this->fileName = $fileName;
		$this->load();
	}
	public function load() {
		$mapping = $this->mapping;
		$data = array();
		$f = fopen($this->fileName,"r");
		while ( $rawRow = fgetcsv($f,10000) ) {
			$row = array();
			foreach ($mapping as $k => $v) {
				$row[$v] = $rawRow[$k];
			}
			$data[] = $row;
		}
		fclose($f);
		$this->data = $data;
	}
	public function getIterator() {
		return new ArrayIterator($this->data);
	}
}

class ImagesCsv extends Csv {
	public $mapping = array( 'id', 'dbname', 'url', 'cluster', 'image_path', 'db_size', 'fs_size' );
}

function print_wiki( $wiki ) {
	echo implode(',',$wiki) . PHP_EOL;
}

$csv = new ImagesCsv('full-list.csv');

switch ($argv[1]) {
case '--missing-dirs':
	foreach ($csv as $wiki) {
		if ( empty($wiki['fs_size']) && $wiki['db_size'] > 100000 )
			print_wiki($wiki);
	}
	break;
case '--vanished':
	foreach ($csv as $wiki) {
		if ( $wiki['db_size'] > 10000000 && $wiki['fs_size'] < $wiki['db_size'] / 3 && $wiki['fs_size'] > 0 )
			print_wiki($wiki);
	}
	break;
}
