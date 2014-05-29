<?php
namespace FluentSql;

class Autoloader {
	static $classes = [
		'core' => [
			'location' => 'sql',
			'type' => 'class',
			'list' => [
				'Breakdown',
				'SQL',
				'StaticSQL',
			],
		],
		'traits' => [
			'location' => 'trait',
			'type' => 'trait',
			'list' => [
				'AsAble',
				'IntervalAble',
			],
		],
		'clauses' => [
			'location' => 'sql/clause',
			'type' => 'class',
			'list' => [
				'Cases',
				'Clause',
				'Condition',
				'Distinct',
				'DistinctOn',
				'Except',
				'Field',
				'From',
				'Functions',
				'GroupBy',
				'Having',
				'In',
				'Intersect',
				'Into',
				'Join',
				'Limit',
				'Offset',
				'On',
				'OrderBy',
				'Set',
				'Type',
				'Union',
				'Update',
				'Using',
				'Values',
				'Where',
				'With',
			],
		],
		'functions' => [
			'location' => 'sql/functions',
			'type' => 'class',
			'list' => [
				'CurDate',
				'Now',
			],
		],
		'cache' => [
			'location' => 'cache',
			'type' => 'class',
			'list' => [
				'Cache',
				'ProcessCache',
			],
		],
	];

	public static function load($class) {
		if (strpos($class, "FluentSql\\") !== 0) {
			return;
		}

		require_once(__DIR__.'/sql/clause/ClauseBuild.interface.php');
		$class = substr($class, strlen("FluentSql\\"));

		foreach (self::$classes as $typeData) {
			if (in_array($class, $typeData['list'])) {
				require_once(__DIR__."/{$typeData['location']}/{$class}.{$typeData['type']}.php");
			}
		}
	}
}

spl_autoload_register(["FluentSql\\Autoloader", 'load']);