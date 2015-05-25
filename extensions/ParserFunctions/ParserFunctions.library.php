<?php
// wikia change
// VOLDEV-114

class Scribunto_LuaParserFunctionsLibrary extends Scribunto_LuaLibraryBase {
	public function register() {
		$lib = array(
			'expr' => array( $this, 'expr' ),
		);

		$this->getEngine()->registerInterface( __DIR__ . '/mw.ext.ParserFunctions.lua', $lib, array() );
	}

	public function expr( $expression = null ) {
		$this->checkType( 'mw.ext.ParserFunctions.expr', 1, $expression, 'string' );
		try {
			return array( ExtParserFunctions::getExprParser()->doExpression( $expression ) );
		} catch ( ExprError $e ) {
			throw new Scribunto_LuaError( $e->getMessage() );
		}
	}

}
