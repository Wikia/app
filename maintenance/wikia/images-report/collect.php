<?php

require "/usr/wikia/slot1/code/maintenance/commandLine.inc";

class DBPool {
	static $pool = array();
	static public function get( $cluster, $dbname ) {
		if ( empty(self::$pool[$cluster]) ) {
			$dbr = wfGetDB(DB_SLAVE,null,$dbname);
			self::$pool[$cluster] = $dbr;
		} else {
			$dbr = self::$pool[$cluster];
			$dbr->selectDB($dbname);
		}
		return $dbr;
	}
}

class Lock {
	public function __construct( $id ) {
		$this->id = $id;
	}
	public function acquire() {
		$lockFile = "locks/{$this->id}.lock";
		$this->f = @fopen($lockFile,"w");
		$lockStatus = @flock($this->f,LOCK_EX|LOCK_NB);
		if ( !$this->f || !$lockStatus ) {
			if ( $this->f ) {
				fclose($this->f);
				unlink($lockFile);
				$this->f = null;
			}
			return false;
		}
		$this->lockFile = $lockFile;
		return true;
	}
	public function release() {
		fclose($this->f);
		unlink($this->lockFile);
	}
	static public function acquire_return( $id ) {
		$lock = new self($id);
		if ( $lock->acquire() ) {
			return $lock;
		}
		return false;
	}
}

class Worker {
	const RAID_PATH = '/raid/images/by_id';
	public function __construct( $id, $meta ) {
		$this->id = $id;
		$this->meta = $meta;
		$this->lock = new Lock($id);
	}
	public function getActualSize() {
		$meta = $this->meta;
		$imagePath = $meta['imagePath'];
		$imagePath = preg_replace("#^/images#",self::RAID_PATH,$imagePath);
		$cwd = getcwd();
		chdir($imagePath);
		$size = `du -bsc 0 1 2 3 4 5 6 7 8 9 a b c d e 2>/dev/null|tail -n 1|grep total`;
		chdir($cwd);
		if ( !preg_match("/^(\d+)\s+total/",$size,$m) ) {
			return false;
		}
		$size = intval($m[1]);
		return $size;
	}
	public function getDesiredSize() {
		$meta = $this->meta;
		$dbr = DBPool::get($meta['cluster'],$meta['dbname']);
		try {
			$res = $dbr->select(
				'image',
				'sum(img_size) as total');
		} catch (DBQueryError $e) {
			return false;
		}
		foreach ($res as $row) {
			$total = $row->total;
			if ($total === null) $total = false;
			else $total = intval($total);
			return $total;
		}
		return false;
	}
	public function run() {
		if ( !$this->lock->acquire() ) {
			return false;
		}
		$this->actual = $this->getActualSize();
		$this->desired = $this->getDesiredSize();
		$this->lock->release();
		return true;
	}
	public function get() {
		return array(
			'desired' => $this->desired,
			'actual' => $this->actual,
		);
	}
}

class CityIterator {
	private $db;
	public $meta = array();
	public function loadIndex() {
		$res = $this->db->select(
			'city_list',
			array( 'city_id', 'city_dbname', 'city_url', 'city_cluster' )
		);
		foreach ($res as $row) {
			$cityId = intval($row->city_id);
			$dbname = $row->city_dbname;
			$url = $row->city_url;
			$cluster = $row->city_cluster;
			if ( empty($cluster) ) $cluster = 'c1';
			$this->meta[$cityId] = array(
				'id' => $cityId,
				'dbname' => $dbname,
				'url' => $url,
				'cluster' => $cluster,
			);
		}
	}
	public function loadImagePaths() {
		$res = $this->db->select(
			'city_variables',
			array( 'cv_city_id', 'cv_value' ),
			array(
				'cv_variable_id' => 17,
			)
		);
		foreach ($res as $row) {
			$cityId = intval($row->cv_city_id);
			$value = unserialize($row->cv_value);
			if ( isset( $this->meta[$cityId] ) ) {
				$this->meta[$cityId]['imagePath'] = $value;
			}
		}
	}
	public function dataFileName( $id ) {
		return "data/$id";
	}
	public function save( $id, $data ) {
		$f = fopen($this->dataFileName($id),"w");
		if ( fputcsv($f,$data) === false ) {
			echo "$id: could not write result data\n";
		}
		fclose($f);
	}
	public function dataExists( $id ) {
		$name = $this->dataFileName($id);
		return file_exists($name) && filesize($name) > 0;
	}
	public function run() {
		$count = 0;
		echo "Loading initial data...\n";
		$this->db = wfGetDB( DB_SLAVE, null, 'wikicities' );
		$this->loadIndex();
		$this->loadImagePaths();
		echo "Processing...\n";
		foreach ($this->meta as $city) {
			echo " {$city['dbname']} "; flush();
			if ( $this->dataExists( $city['dbname'] ) ) {
				echo "skipped (data already exists)\n";
				continue;
			}
			$lock = Lock::acquire_return('iter-'.$city['id']);
			if ( !$lock ) {
				echo "skipped (lock taken)\n";
				continue;
			}
			$worker = new Worker($city['dbname'],$city);
			if ( $worker->run() ) {
				$city = array_merge($city,$worker->get());
				$this->save($city['dbname'],$city);
			}
			$lock->release();
			echo "done\n";
		}
	}
}


$i = new CityIterator();
$i->run();
