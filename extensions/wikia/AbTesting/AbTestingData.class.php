<?php

/**
 * Database access layer for AbTesting, no caching applied
 *
 * @author Władysław Bodzek
 */
class AbTestingData extends WikiaObject {

	const TABLE_CONFIG = 'ab_config';
	const TABLE_EXPERIMENTS = 'ab_experiments';
	const TABLE_VERSIONS = 'ab_experiment_versions';
	const TABLE_GROUPS = 'ab_experiment_groups';
	const TABLE_RANGES = 'ab_experiment_group_ranges';

	const MIN = 'min';
	const MAX = 'max';

	protected $useMaster = false;

	protected $blacklistedColumns = array(
		self::TABLE_EXPERIMENTS => array(
			'groups',
			'versions',
		),
		self::TABLE_VERSIONS => array(
			'group_ranges',
		),
	);

	public function getDb( $db_type = DB_SLAVE ) {
		if ( $this->useMaster ) {
			$db_type = DB_MASTER;
		}
		return wfGetDB( $db_type, array(), $this->wg->ExternalDatawareDB );
	}

	public function setUseMaster( $useMaster = true ) {
		$this->useMaster = $useMaster;
	}


	/* READ METHODS */

	public function getModifiedTime() {
		$dbr = $this->getDb();
		$modifiedTime = $dbr->selectField(self::TABLE_CONFIG,'updated',array(
			'id' => 1,
		),__METHOD__);
		return $modifiedTime;
	}

	protected function loadFromRows( ResultWrapper $res ) {
		$ret = array();
		while ( ($row = $res->fetchObject()) ) {
			unset($grp);
			unset($ver);
			// experiment
			$e_id = $row->e_id;
			if ( !isset( $ret[$e_id] ) ) {
				$ret[$e_id] = array(
					'id' => $row->e_id,
					'name' => $row->e_name,
					'description' => $row->e_description,
					'versions' => array(),
					'groups' => array(),
				);
			}
			$exp = &$ret[$e_id];

			// group
			$g_id = $row->g_id;
			if ( $g_id && !isset( $exp['groups'][$g_id] ) ) {
				$exp['groups'][$g_id] = array(
					'experiment_id' => $e_id,
					'id' => $row->g_id,
					'name' => $row->g_name,
					'description' => $row->g_description,
				);
			}
			if ( $g_id ) {
				$grp = &$exp['groups'][$g_id];
			}

			// version
			$v_id = $row->v_id;
			if ( $v_id && !isset( $exp['versions'][$v_id] ) ) {
				$exp['versions'][$v_id] = array(
					'experiment_id' => $e_id,
					'id' => $row->v_id,
					'start_time' => $row->v_start_time,
					'end_time' => $row->v_end_time,
					'ga_slot' => $row->v_ga_slot,
					'flags' => $row->v_flags,
					'group_ranges' => array(),
				);
			}
			if ( $v_id ) {
				$ver = &$exp['versions'][$v_id];
			}

			// group ranges
			if ( $g_id && $v_id && $row->r_group_id) { // row in group_ranges found
				if ( !isset( $ver['group_ranges'][$g_id] ) ) {
					$ver['group_ranges'][$g_id] = array(
						'version_id' => $v_id,
						'group_id' => $g_id,
						'ranges' => $row->r_ranges,
						'styles' => $row->r_styles,
						'scripts' => $row->r_scripts,
					);
				}
			}
		}

		return $ret;
	}

	protected function loadFromDb( $where = array(), $use_master = false ) {
		// Some calls to this method want to load from the master so that they
		// don't race with replication lag
		$db_type = $use_master ? DB_MASTER : DB_SLAVE;

		$dbr = $this->getDb( $db_type );
		$res = $dbr->select(
			array( // tables
				'e' => 'ab_experiments',
				'g' => 'ab_experiment_groups',
				'v' => 'ab_experiment_versions',
				'r' => 'ab_experiment_group_ranges',
			),
			array( // columns
				'e.id as e_id, e.name as e_name, e.description as e_description',
				'g.id as g_id, g.name as g_name, g.description as g_description',
				'v.id as v_id, v.start_time as v_start_time, v.end_time as v_end_time, v.ga_slot as v_ga_slot',
					'v.flags as v_flags',
				'r.ranges as r_ranges, r.group_id as r_group_id, r.styles as r_styles, r.scripts as r_scripts',
			),
			$where, // conditions
			__METHOD__,
			array( // options
				'ORDER' => 'e_id, v_id, g_id',
			),
			array( // join conditions
				'g' => array( 'LEFT JOIN', 'e.id = g.experiment_id' ),
				'v' => array( 'LEFT JOIN', 'e.id = v.experiment_id' ),
				'r' => array( 'LEFT JOIN', 'v.id = r.version_id AND g.id = r.group_id' ),
			)
		);
		return $this->loadFromRows($res);
	}

	public function getCurrent() {
		return $this->loadFromDb(array(
			'v.start_time <= current_timestamp + interval 2 hour', // 2 hours margin
			'v.end_time >= current_timestamp'
		));
	}

	public function getAll() {
		return $this->loadFromDb();
	}

	public function getById( $id, $use_master = false ) {
		$list = $this->loadFromDb(array(
			'e.id' => $id,
		), $use_master);

		return @$list[$id];
	}

	/* WRITE METHODS */

	protected function filterRow( $table, $row ) {
		if ( empty( $this->blacklistedColumns[$table]) ) {
			return $row;
		}
		foreach ($this->blacklistedColumns[$table] as $key) {
			unset($row[$key]);
		}
		return $row;
	}

	protected function saveRow( $table, &$row, $fname ) {
		$dbw = $this->getDb(DB_MASTER);
		$copy = $this->filterRow($table,$row);
		if ( !empty($row['id']) ) {
			$where = array(
				'id' => $row['id'],
			);
			unset($copy['id']);
			$dbw->update($table,$copy,$where,$fname);
		} else {
			unset($row['id']);
			$dbw->insert($table,$copy,$fname);
			$row['id'] = $dbw->insertId();
		}
	}

	protected function deleteRow( $table, &$row, $fname ) {
		$dbw = $this->getDb(DB_MASTER);
		$id = $row['id'];
		if ( $id ) {
			$dbw->delete($table,array(
				'id' => $id
			),$fname);
		}
		unset($row['id']);
	}

	protected function saveAnonRow( $table, $uniqueIndexes, &$row, $fname ) {
		$dbw = $this->getDb(DB_MASTER);
		$copy = $this->filterRow($table,$row);
		$dbw->replace($table,$uniqueIndexes,$copy,$fname);
	}

	protected function deleteAnonRow( $table, $uniqueIndexes, &$row, $fname ) {
		$dbw = $this->getDb(DB_MASTER);
		$copy = $this->filterRow($table,$row);
		$where = array();
		foreach ($uniqueIndexes as $key) {
			$where[$key] = $copy[$key];
		}
		$dbw->delete($table,$where,$fname);
	}

	public function saveExperiment( &$exp ) {
		$this->saveRow(self::TABLE_EXPERIMENTS,$exp,__METHOD__);
	}

	public function deleteExperiment( &$exp ) {
		$this->deleteRow(self::TABLE_EXPERIMENTS,$exp,__METHOD__);
	}

	public function saveGroup( &$grp ) {
		$this->saveRow(self::TABLE_GROUPS,$grp,__METHOD__);
	}

	public function deleteGroup( &$grp ) {
		$this->deleteRow(self::TABLE_GROUPS,$grp,__METHOD__);
	}

	public function saveVersion( &$ver) {
		$this->saveRow(self::TABLE_VERSIONS,$ver,__METHOD__);
	}

	public function deleteVersion( &$ver ) {
		$this->deleteRow(self::TABLE_VERSIONS,$ver,__METHOD__);
	}

	public function saveGroupRange( &$grn ) {
		$this->saveAnonRow(self::TABLE_RANGES,array('group_id','version_id'),$grn,__METHOD__);
	}

	public function deleteGroupRange( &$grn ) {
		$this->deleteAnonRow(self::TABLE_RANGES,array('group_id','version_id'),$grn,__METHOD__);
	}

	public function updateModifiedTime() {
		$dbw = $this->getDb(DB_MASTER);
		$dbw->query("REPLACE INTO ".self::TABLE_CONFIG." (id, updated) VALUES (1, current_timestamp);");
	}

	protected function getEffectiveChangeTime( $aggregate, $startTimeBuffer ) {
		if ( !in_array( $aggregate, array( self::MIN, self::MAX ) ) ) {
			return null;
		}

		$op = $aggregate == self::MIN ? '>' : '<=';
		$startExpr = "start_time - interval {$startTimeBuffer} second";
		$endExpr = "end_time";
		$startConds = array(
			"{$startExpr} {$op} current_timestamp"
		);
		$endConds = array(
			"{$endExpr} {$op} current_timestamp"
		);

		$dbr = $this->getDb(DB_MASTER);
		$val1 = $dbr->selectField(self::TABLE_VERSIONS,"{$aggregate}({$startExpr})",$startConds, __METHOD__);
		$val2 = $dbr->selectField(self::TABLE_VERSIONS,"{$aggregate}({$endExpr})",$endConds, __METHOD__);

		if ( is_null($val1) ) {
			return $val2;
		} else if ( is_null($val2) ) {
			return $val1;
		} else {
			return call_user_func_array($aggregate,array($val1,$val2));
		}
	}

	public function getLastEffectiveChangeTime( $bufferTime ) {
		return $this->getEffectiveChangeTime(self::MAX,$bufferTime);
	}

	public function getNextEffectiveChangeTime( $bufferTime ) {
		return $this->getEffectiveChangeTime(self::MIN,$bufferTime);
	}

	public function newExperiment() {
		return array(
			'id' => 0,
			'name' => '',
			'description' => '',
			'groups' => array(),
			'versions' => array(),
		);
	}

	public function newVersion() {
		return array(
			'id' => 0,
			'experiment_id' => 0,
			'start_time' => '',
			'end_time' => '',
			'ga_slot' => '',
			'flags' => AbTesting::DEFAULT_FLAGS,
			'group_ranges' => array(),
		);
	}

}
