<?php

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'PHP Trace Viewer',
	'author'         => array( 'Władysław Bodzek' ),
	'version'        => '0.1',
//	'descriptionmsg' => 'titleblacklist-desc',
);

$wgHooks['BeforePageDisplay'][] = 'efTraceViewerBeforePageDisplay';

$wgResourceModules['wikia.ext.traceviewer'] = array(
	'scripts' => 'extensions/wikia/TraceViewer/TraceViewer.js',
	'styles' => 'extensions/wikia/TraceViewer/TraceViewer.css',
);

$wgResourceModules['wikia.ext.traceviewer.init'] = array(
	'scripts' => 'extensions/wikia/TraceViewer/TraceViewerInit.js',
);

function efTraceViewerBeforePageDisplay( $out, $skin ) {
	$out->addModules('wikia.ext.traceviewer.init');
	return true;
}
