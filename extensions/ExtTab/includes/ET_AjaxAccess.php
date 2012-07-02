<?php

global $wgAjaxExportList;

$wgAjaxExportList[] = 'smwf_et_Access';

function smwf_et_Access( $method, $params ) {
	global $smwgQEnabled, $smwgExtTabEnabled;

	$result = "Semantic ExtTab disabled.";
	if ( $method == "internalLoad" ) {
		if ( $smwgExtTabEnabled ) {
			$p = explode( ',', $params, 2 );
			$title = $p[1];
			$html = $title;
			global $wgTitle, $smwgIQRunningNumber;
			// pay attention to $smwgIQRunningNumber
			$smwgIQRunningNumber = intval( $p[0] ) * 10;
			$wgTitle = Title::newFromText( $title );
			$revision = Revision::newFromTitle( $wgTitle );
			if ( $revision !== NULL ) {
				global $wgParser, $wgOut;
				$popts = $wgOut->parserOptions();
				$popts->setTidy( true );
				$popts->enableLimitReport();
				$html = $wgParser->parse( $revision->getText(), $wgTitle, $popts )->getText();
			}
			return $html;
		}
	} else {
		return "Operation failed, please retry later.";
	}
	return $result;
}
?>