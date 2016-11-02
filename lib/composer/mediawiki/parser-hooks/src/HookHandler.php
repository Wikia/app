<?php

namespace ParserHooks;

use ParamProcessor\ProcessingResult;
use Parser;

/**
 * Interface for objects that can handle a parser hook call of
 * which the parameters have already been processed.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface HookHandler {

	/**
	 * Handle the parser hook call.
	 *
	 * @since 1.0
	 *
	 * @param Parser $parser
	 * @param ProcessingResult $result
	 *
	 * @return mixed
	 */
	public function handle( Parser $parser, ProcessingResult $result );

}
