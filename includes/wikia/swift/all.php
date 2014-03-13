<?php

foreach (array(
	'Logger',
	'Entity',
	'Http',
	'Net',
	'Operation',
	'OperationList',
	'S3',
	'Wiki',
	'Status',
	'Process',
	'File',
		 ) as $baseName ) {
	require_once __DIR__ . "/{$baseName}.php";
}
