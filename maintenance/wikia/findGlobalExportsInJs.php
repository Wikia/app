<?php
$optionsWithArgs = array(
	'single',
	'source',
	'dump',
);
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

if ( @$options['source'] ) {
	$names = file_get_contents(@$options['source']);
	if ( empty( $names ) ) {
		die('No files specified');
	}
} else if ( @$options['single'] ) {
	$names = $options['single'];
}

$names = preg_split("/[\r\n]+/",$names);
foreach ($names as $name) {
	if ( $name === '' ) continue;
	$tree = false;
	$decls = process_file($name,$tree);
	if ( @$options['dump'] ) {
		ob_start();
		print_r($tree);
		file_put_contents($options['dump'],ob_get_clean());
	}
	if ( $decls === false ) {
		echo sprintf("%s: %s",
			$name,
			"ERROR: Could not parse file");
	} else {
		foreach ($decls as $decl) {
			echo sprintf("%s:%d: %s %s\n",$name,$decl[0],$decl[1],$decl[2]);
		}
	}
}
//$name = "/usr/wikia/source/wiki/extensions/wikia/WikiaMiniUpload/js/WMU.js";

function debug_print( $string ) {
	fprintf(STDERR,$string."\n");
	fflush(STDERR);
}

function is_var_or_window( $node ) {
	$orNode = @$node->initializer;
	if ( !($orNode instanceof JSNode)
		|| $orNode->type != '||'
	) {
//		debug_print("is_var_or_window: failed 1");
		return false;
	}
	$dotNode = @$orNode->treeNodes[0];
	if ( !($dotNode instanceof JSNode)
		|| $dotNode->type != '.'
		|| $dotNode->value != $node->name
	) {
//		debug_print("is_var_or_window: failed 2");
		return false;
	}
	$windowNode = @$dotNode->treeNodes[0];
	if ( !$windowNode instanceof JSNode
		|| $windowNode->type != 3
		|| $windowNode->value != 'window'
	) {
//		debug_print("is_var_or_window: failed 3");
		return false;
	}
	return true;
}

function into( JSNode $node, &$decls = array() ) {
	switch ($node->type) {
		case 'function':
			if ($node->name) {
				$decls[] = array( $node->lineno, 'function', $node->name );
			}
			return;
		case 'var':
			foreach ($node->treeNodes as $subnode) {
				if ( !is_var_or_window($subnode) ) {
					$decls[] = array( $subnode->lineno, 'var', $subnode->name );
				}
			}
	}
	$keys = array(
		'treeNodes',
		'body',
		'thenPart',
		'elsePart',
		'cases',
		'statements',
		'setup',
		'condition',
		'update',
		'varDecl',
		'iterator',
		'tryBlock',
		'catchClauses',
		'varName',
		'guard',
		'block',
		'value',
		'object',
		'initializer',
		'expression',
		'statement',
	);
	foreach ($keys as $key) {
		$nodes = $node->$key;
		if ($nodes instanceof JSNode) {
			into($nodes,$decls);
		} elseif ( is_array($nodes) ) {
			foreach ($nodes as $subnode) {
				into($subnode,$decls);
			}
		}
	}
}

function process_file( $name, &$tree = null ) {
	$contents = file_get_contents($name);

	$parser = new JSParser();
	try {
		$tree = $parser->parse( $contents, $name, 1 );
	} catch (Exception $e) {
		// We'll save this to cache to avoid having to validate broken JS over and over...
		$err = $e->getMessage();
		$result = "throw new Error(" . Xml::encodeJsVar("JavaScript parse error: $err") . ");";
		return false;
	}

	//ob_start();
	//print_r($tree);
	//file_put_contents('/tmp/tree.txt',ob_get_clean());

	$decls = array();
	into($tree,$decls);
	return $decls;
}
