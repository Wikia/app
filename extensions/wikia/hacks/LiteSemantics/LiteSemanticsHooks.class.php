<?php
class LiteSemanticsHooks extends WikiaObject{

	public function onInternalParseBeforeLinks( $oParser, $sText, $mStripState ){

		//TODO: check if semantics parsing should actually happen (only edits/purges)

		$parser = F::build( 'LiteSemanticsParser' )->parse( $sText );

		$semanticsData = $parser->getData();

		//TODO: do something with the data

		return true;
	}
}
