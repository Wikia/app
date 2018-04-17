<?php

class WikiFactoryVariableParseException extends Exception {
	const ERROR_VARIABLE_NOT_INTEGER = 'Syntax error: value is not integer. Variable not saved.';
	const ERROR_VARIABLE_NOT_BOOLEAN = 'Syntax error: value is not boolean. Variable not saved.';
	const ERROR_VARIABLE_NOT_ARRAY = 'Syntax error, value is not valid array. Variable not saved.';
}
