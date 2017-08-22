<?php

abstract class AbstractInvokableParserHook {
	final public function __invoke( ...$args ) {
		return call_user_func_array( [ $this, 'parse' ], $args );
	}

	abstract public function parse( $content, array $attributes, Parser $parser, PPFrame $frame ): string;
}
