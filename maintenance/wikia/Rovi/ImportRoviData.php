<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 03.04.14
 * Time: 14:22
 */


class ImportRoviData extends Maintenance {
	const CSV_SEPARATOR = '|';
	const CSV_MAX_LINE = 2048;
	const SHARED_DB = "wikicities";
	protected $filesOptions = [
		'seriesFile' => 'A csv file from Rovi containing series data (mostly Series.txt)',
		'episodesFile' => 'A csv file from Rovi containing episodes data (mostly Episode_Sequence.txt)'
	];

	protected $fileHeaderLength = [
		'seriesFile' => 4
	];

	protected $files;


	public function __construct(){
		parent::__construct();
		foreach($this->filesOptions as $option => $desc ){
			$this->addOption($option, $desc);
		}
		$this->setBatchSize(200);

	}
	public function execute(){
		$this->checkFiles();
		$this->loadSeriesData('seriesFile' );

	}


	protected function loadSeriesData( $optionName ){
		$csv = $this->openCsvFile($optionName);
		if(!$csv){
			return;
		}
		if(!$this->checkFileHeader($csv, $optionName)){
			return;
		}
		global $wgSharedDb;
		var_dump($wgSharedDb);
		$db = wfGetDb(DB_MASTER, array(), self::SHARED_DB);
		$db->begin();
		var_dump($this->getOption('batch-size'));
		/*while (($data = fgetcsv($csv, self::CSV_MAX_LINE, self::CSV_SEPARATOR)) !== FALSE) {
			$data[0]  = trim($data[0]);
			if(!preg_match('~^\d+$~', $data[0])){
				echo "ERR:".$data[0]."\n";
				continue;
			}
			switch($data[3]){
				case 'INS':
						$res = $db->insert('rovi_series', [
							'series_id'=>  $data[0],
							'full_title' => $data[1],
							'synopsis' => $data[2]
						]) ? 'OK' : "FAIL";
						echo("INS: ".$data[0]."($res)".str_repeat(" ", 10).chr(13));
					break;
			}
		}*/
		$db->commit();

	}

	protected function openCsvFile( $optionName){
		if(empty($this->files[$optionName])){
			return false;
		}
		$fileName = $this->files[$optionName];
		$csv = fopen($fileName,'r');
		if(!$csv){
			$this->error("Unable to load file for --$optionName ($fileName)");
			return false;
		}
		return $csv;
	}


	protected function checkFileHeader($csv, $optionName){
		$data = fgetcsv($csv, self::CSV_MAX_LINE, self::CSV_SEPARATOR);
		$requiredLength = $this->fileHeaderLength[$optionName];
		if(!is_array($data) || count($data) !== $requiredLength){
			$this->error("Header for file in --$optionName must have exactly $requiredLength columns");
			return false;
		}
		return true;
	}

	protected function checkFiles( ){
		foreach(array_keys($this->filesOptions) as $optionName){
			if($this->hasOption($optionName)){
				$fileName = $this->getOption($optionName);
				if(!file_exists($fileName) || !is_readable($fileName)){
					$this->error("Unable to load file for --$optionName ($fileName)", true);
				}
				$this->files[$optionName] = $fileName;
			}
			if(empty($this->files)){
				$this->error("No input files", true);
			}
		}

	}

}


$maintClass = 'ImportRoviData';
require( RUN_MAINTENANCE_IF_MAIN );
