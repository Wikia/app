#include <stdlib.h>
#include "stack.h"
#include "config.h"

ws_parser_stack* ws_parser_stack_init() {
	ws_parser_stack* stack;
	
	stack = malloc( sizeof( ws_parser_stack ) );
	if( !stack ) {
		return NULL;
	}

	stack->count = 0;
	stack->allocated = WS_STACK_SIZE_INIT;
	stack->content = malloc( WS_STACK_SIZE_INIT * sizeof( ws_parser_stack_entry ) );
	if( !stack->content ) {
		free( stack );
		return NULL;
	}

	return stack;
}

bool ws_parser_stack_push(ws_parser_stack* stack, ws_parser_stack_entry entry) {
	if( stack->allocated == stack->count ) {
		ws_parser_stack_entry* newstack;

		newstack = realloc(
			stack->content,
			( stack->allocated + WS_STACK_SIZE_STEP ) * sizeof( ws_parser_stack_entry )
		);
		if( !newstack ) {
			return false;
		}

		stack->allocated += WS_STACK_SIZE_STEP;
		stack->content = newstack;
	}

	stack->content[stack->count] = entry;
	stack->count++;
	return true;
}

bool ws_parser_stack_pop(ws_parser_stack* stack) {
	if( stack->count ) {
		stack->count--;
		return true;
	} else {
		return false;
	}
}

ws_parser_stack_entry ws_parser_stack_top(ws_parser_stack* stack) {
	return stack->content[stack->count - 1];
}

void ws_parser_stack_free(ws_parser_stack* stack) {
	if( stack ) {
		if( stack->content )
			free( stack->content );

		free( stack );
	}
}
