<?php
/**
 */

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname( __FILE__ ) . '/../..';

	if ( !file_exists( "$IP/LocalSettings.php" ) ) {
	    $IP = dirname( __FILE__ ) . '/../../phase3';
	}
}
require_once( "$IP/maintenance/Maintenance.php" );

class ImportMAB2 extends Maintenance {
	public function __construct( ) {
		parent::__construct();

		$this->addArg( "name", "name of a transclusion data source, as specified in \$wgDataTransclusionSources", true );
		$this->addArg( "file/dir", "directory containing MAB files, or a single MAB file, or - for stdin", true );

		$this->addArg( "blob_table", "database table for data blobs, without prefix", true );
		$this->addArg( "index_table", "database table for index entries, without prefix", true );

		$this->addOption( "create", "create database tables if they do not exist", false, false );
		$this->addOption( "truncate", "truncate (empty) database tables", false, false );
		$this->addOption( "prefix", "database table prefix. May contain a period (\".\") to reference tables in another database. If not given, the wiki's table prefix will be used", false, true );

		$this->addOption( "recursive", "recurse into subdirectories while importing MAB files", false, false );

		$this->addOption( "noblob", "don't write blob data, import index fields only", false, false );
		$this->addOption( "limit", "max number of files to process", false, true );
		$this->addOption( "debug", "don't write to the database, dump to console instead", false, false );

		$this->addOption( "multi-record", "read multiple records from a single file. Records may be separated by special lines matching --record-separator; if --record-separator is not given, all records are expected to start with filed number 001.", false, false );
		$this->addOption( "record-separator", "regular expression for lines separating records in a multi-record file. Implies --multi-record", false, true );

		$this->addOption( "id-list-field", "id field to compare against the id list.", false, true );
		$this->addOption( "id-list-file", "list of ids to import.", false, true );
	}

	public function createTables( ) {
		$db = wfGetDB( DB_MASTER );

		$this->output( "creating blob table {$this->blob_table}\n" );
		$sql = "CREATE TABLE IF NOT EXISTS " . $this->blob_table . " ( ";
		$sql .= " id INT(12) NOT NULL AUTO_INCREMENT, ";
		$sql .= " data BLOB  NOT NULL, ";
		$sql .= " PRIMARY KEY (id) ";
		$sql .= ") ";
		$db->query( $sql, __METHOD__ );

		$this->output( "creating index table {$this->index_table}\n" );
		$sql = "CREATE TABLE IF NOT EXISTS " . $this->index_table . " ( ";
		$sql .= " field VARCHAR(255) NOT NULL, "; #FIXME: varchar vs varbinary!
		$sql .= " value VARCHAR(255) NOT NULL, "; #FIXME: varchar vs varbinary!
		$sql .= " data_id INT(12) NOT NULL, ";
		$sql .= " PRIMARY KEY (field, value, data_id) "; #NOTE: we don't require (field,value) to be unique!
		$sql .= ") ";
		$db->query( $sql, __METHOD__ );
	}

	public function truncateTables( ) {
		$db = wfGetDB( DB_MASTER );

		$this->output( "truncating blob table {$this->blob_table}\n" );
		$sql = "TRUNCATE TABLE " . $this->blob_table;
		$db->query( $sql, __METHOD__ );

		$this->output( "truncating index table {$this->index_table}\n" );
		$sql = "TRUNCATE TABLE " . $this->index_table;
		$db->query( $sql, __METHOD__ );
	}

	public function execute() {
		global $wgDataTransclusionSources;

		$this->debug = $this->hasOption( 'debug' );
		$this->noblob = $this->hasOption( 'noblob' );
		$recursive = $this->hasOption( 'recursive' );
		$limit = (int)$this->getOption( 'limit' );

		$this->recordSeparator = $this->getOption( 'record-separator' );
		$this->multiRecord = $this->recordSeparator || $this->hasOption( 'multi-record' );

		$this->idListField = $this->getOption( 'id-list-field' );
		$this->idListFile = $this->getOption( 'id-list-file' );
		$this->idList = null;

		$src = $this->mArgs[0];
		$dir = $this->mArgs[1];

		if ( !isset( $wgDataTransclusionSources[ $src ] ) ) {
			throw new MWException( "unknown transclusion data source '$src', not found in \$wgDataTransclusionSources" );
		}

		$this->output( "using settings for data transclusion source \"$src\".\n" );

		$this->source = DataTransclusionHandler::getDataSource( $src );

		if ( !( $this->source instanceof DBDataTransclusionSource ) ) {
			throw new MWException( "bad data source '$src': not compatible with DBDataTransclusionSource" );
		}

		$this->blob_table = $this->mArgs[2];
		$this->index_table = $this->mArgs[3];

		if ( $this->hasOption( 'prefix' ) ) {
			$prefix = $this->getOption( "prefix" );
			$this->blob_table = $prefix . $this->blob_table;
			$this->index_table = $prefix . $this->index_table;
		} else {
			$db = wfGetDB( DB_MASTER ); # we'll need the master anyway later
			$this->blob_table = $db->tableName( $this->blob_table );
			$this->index_table = $db->tableName( $this->index_table );
		}

		if ( !$this->debug ) {
			$this->output( "using tables {$this->blob_table} and {$this->index_table}.\n" );

			if ( $this->hasOption('create') ) {
				$this->output( "creating tables if neccessary.\n" );
				$this->createTables( $this->blob_table, $this->index_table );
			}

			if ( $this->hasOption('truncate') ) {
				$this->output( "truncating tables.\n" );
				$this->truncateTables( $this->blob_table, $this->index_table );
			}
		}

		$this->id_map = array();
		foreach ( $this->source->keyFields as $key ) {
			$this->id_map[ $key ] = MAB2RecordTransformer::getMABFields( $key );
			if ( !$this->id_map[ $key ] ) {
				$this->error( "unknown key field '$key', no MAB fields mapped.\n" );
			}
		}

		if ( $this->idListFile ) {
			$this->output( "loading id list from {$this->idListFile}.\n" );
			$this->idList = $this->loadList( $this->idListFile, $this->idListField );
			if ( $this->idList === false ) {
				$this->error( "failed to load id list from {$this->idListFile}.\n" );
				return;
			}
		}

		if ( $this->idList && $this->idListField ) {
			$this->output( "filtering by {$this->idListField} from {$this->idListFile}.\n" );
		}

		$dir = "php://stdin";

		if ( is_dir( $dir ) ) {
			$this->importDir( $dir, $recursive, $limit );
		} else {
			$this->importMabFile( $dir );
		}
	}

	public function importDir( $dir, $recursive = false, $limit = 0 ) {
		$dir = "$dir/";

		$this->output( "scanning directory $dir\n" );

		$d = opendir( $dir );
		if ( !$d ) {
			$this->error( "unable to open directory $dir!\n" );
			return false;
		}

		while( ( $file = readdir( $d ) ) ) {
			if ( $file == "." or $file == ".." ) {
				continue;
			}

			if ( is_dir( $dir . $file ) && $recursive ) {
				$this->importDir( $dir . $file, $recursive, $limit );
				continue;
			} elseif ( !is_file( $dir . $file ) ) {
				$this->output( "not a file: $dir/$file\n" );
				continue;
			}

			$ok = $this->importMabFile( $dir . $file );

			if ( !$ok ) {
				$this->output( "error processing $file\n" );
			}

			if ( $limit > 0 ) {
				$limit -= 1;
				if ( $limit <= 0 ) break;
			}
		}
		closedir( $d );
	}

	public function getIds( $rec ) {
		$ids = array();
		foreach ( $this->id_map as $field => $items ) {
			if ( !$items ) continue;

			foreach ( $items as $item ) {
				if ( isset( $rec[ $item ] ) ) {
					if ( !isset( $ids[ $field ] ) ) {
						$ids[ $field ] = array();
					}

					if ( is_array( $rec[ $item ] ) ) {
						foreach( $rec[ $item ] as $k => $v ) {
							$v = $this->source->normalize( $field, $v );
							$v = $this->source->convert( $field, $v );

							$ids[ $field ][] = $v;
						}
					} else {
						$v = $rec[ $item ];
						$v = $this->source->normalize( $field, $v );
						$v = $this->source->convert( $field, $v );

						$ids[ $field ][] = $v;
					}
				}
			}
		}

		return $ids;
	}

	public function storeRecord( $rec, $ids ) {
		$db = wfGetDB( DB_MASTER );

		$insert = array( 'data' => serialize($rec) );

		if ( $this->noblob ) {
			$id = 0;
		} else {
			$db->insert( $this->blob_table, $insert, __METHOD__ );
			$id = $db->insertId();
		}

		$insert = array();
		foreach ( $ids as $field => $values ) {
			foreach ( $values as $v ) {
				$insert[] = array(
					  'field' => $field,
					  'value' => $v,
					  'data_id' => $id );
			}
		}

		$db->insert( $this->index_table, $insert, __METHOD__, array( 'IGNORE' ) );
	}

	public function loadList( $file, $field = null ) {
		$f = fopen( $file, 'r' );
		if ( !$f ) return false;

		$list = array();

		while ( true ) {
			$s = fgets( $f );

			if ( $s === "" || $s === false ) {
			    break;
			}

			$s = trim( $s );
			if ( $field ) $s = $this->source->normalize( $field, $s );

			$list[] = $s;
		}

		return $list;
	}

	public function importMabFile( $file ) {
		$f = fopen( $file, 'r' );
		if ( !$f ) return false;

		if ( $this->debug ) {
			print "== $file =======================\n";
		} elseif ( $this->multiRecord ) {
			$this->output( "reading records from $file\n" );
		}

		$eof = false;
		$pushed = false;

		while( !$eof ) {
		    $rec = array();

		    while( !$eof ) {
			if ( $pushed ) {
			    $s = $pushed;
			    $pushed = false;
			} else {
			    $s = fgets( $f );
			}

			if ( $s === "" || $s === false ) {
			    $eof = true;
			    break;
			}

			if ( $rec && $this->recordSeparator && preg_match( $this->recordSeparator, $s ) ) {
			    break; // next record
			}

			if ( preg_match( '/^(\d+[a-z]?)\s*([a-z])?=(.*$)/', $s, $m ) ) {
			    $k = $m[1];
			    $t = $m[2];
			    $v = $m[3];

			    if ( $rec && ($this->multiRecord && !$this->recordSeparator) && $k === "001" ) {
				$pushed = $s;
				# we expect 0001 to be the first thing in every record!
				break; // next record
			    }

			    if ( isset( $rec[$k] ) ) {
				if ( !is_array( $rec[$k] ) ) {
				    $rec[$k] = array( $rec[$k] );
				}

				$rec[$k][] = $v;
			    } else {
				$rec[$k] = $v;
			    }
			}
		    }

		    if ( $rec ) {
			$ids = $this->getIds($rec);

			if ( !$ids ) {
				$this->output( "skipping part of file $file\n" );
				if ( $this->debug ) {
					var_export( $rec );
					print "------------------------------------\n";
				}

				continue;
			}

			$id = false;
			foreach ( $this->source->keyFields as $idf ) {
				if ( !empty( $ids[ $idf ] ) ) {
					$id = "$idf:" . $ids[$idf][0];
				}
			}

			if ( $this->idList && $this->idListField ) {
				$found = false;
				if ( !empty( $ids[ $this->idListField ] ) ) {
					foreach ( $ids[ $this->idListField ] as $v ) {
						if ( in_array( $v, $this->idList ) ) {
							$found = true;
							break;
						}
					}
				}

				if ( !$found ) {
					$this->output( "ignoring record #$id\n" );
					continue;
				}
			}

			if ( $this->debug ) {
				var_export( $ids );
				if ( !$this->noblob ) var_export( $rec );
				print "------------------------------------\n";
			} else {
				$this->output( "importing record $id\n" );
				$this->storeRecord($rec, $ids);
			}
		    }
		}

		fclose( $f );
		return $rec;
	}
}

$maintClass = "ImportMAB2";
require_once( DO_MAINTENANCE );
