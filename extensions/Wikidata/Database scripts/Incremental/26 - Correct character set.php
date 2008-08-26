<?php
	define('MEDIAWIKI',true);
	require_once('../../../../LocalSettings.php');
	require_once('ProfilerStub.php');
	require_once('Setup.php');

	ob_end_flush();

	global $wgCommandLineMode;
	$wgCommandLineMode = true;

	$dbr =& wfGetDB(DB_MASTER);

	/* Fetch the name of the database. */
	$sql = 'SELECT DATABASE()';
	$db_res = $dbr->query($sql);
	$db_row = $dbr->fetchRow($db_res);

	$sql = 'ALTER TABLE categorylinks DROP INDEX cl_sortkey, ADD INDEX cl_sortkey (cl_to(247),cl_sortkey)';
	$dbr->query($sql);
	/* Get the list of tables to change. */
	$sql = 'SHOW TABLES';
	$table_res = $dbr->query($sql);
	while ($table_row = $dbr->fetchRow($table_res)) {
		/* Get a list of columns. */
		$sql = 'DESCRIBE ' . $table_row[0];
		$col_res = $dbr->query($sql);
		while ($col_row = $dbr->fetchObject($col_res)) {
			/* Check if the column is a type that specifies a character set. */
			if (substr($col_row->Type,0,7) == 'varchar') {
				/* Check to see if the column uses a _bin collation. */
				$sql = 'SELECT COLLATION_NAME FROM information_schema.COLUMNS' .
						' WHERE TABLE_SCHEMA LIKE "' . $db_row[0] . '"' .
						' AND TABLE_NAME LIKE "' . $table_row[0] . '"' .
						' AND COLUMN_NAME LIKE "' . $col_row->Field . '"';
				$collation_res = $dbr->query($sql);
				$collation_row = $dbr->fetchObject($collation_res);
				if (substr($collation_row->COLLATION_NAME,-3) == "bin")
					$collate = ' COLLATE utf8_bin';
				else
					$collate = '';

				$sql = 'ALTER TABLE `' . $table_row[0] . '`' .
						' MODIFY `' . $col_row->Field . '`' .
						' ' . $col_row->Type . ' CHARACTER SET utf8' . $collate;
				$dbr->query($sql);
			}
		}
		$sql = 'ALTER TABLE `' . $table_row[0] . '` CHARACTER SET utf8';
		$dbr->query($sql);
	}

	/* Change the character set of the database. */
	$sql = 'ALTER DATABASE ' . $db_row[0] . ' CHARACTER SET utf8';
	$dbr->query($sql);

	$dbr->query('INSERT INTO script_log (time, script_name) ' .
				'VALUES ('. wfTimestampNow() . ',' . $dbr->addQuotes('26 - Correct character set.php') . ')');

