/**
 * Implementation of the parser tree stack.
 */

#include <stdbool.h>
#include "parser.h"
#include "tree.h"

#ifndef _WS_STACK_H
#define _WS_STACK_H

/**
 * The entry of the parser stack. Contains the state and the node bound to that state.
 */
typedef struct {
	ws_parser_node_id node;
	ws_parser_lr_state state;
} ws_parser_stack_entry;

/**
 * Parser stack.
 */
typedef struct {
	int count;
	int allocated;
	ws_parser_stack_entry* content;
} ws_parser_stack;

/**
 * Returns either initialized parser stack or NULL if it failed.
 */
ws_parser_stack* ws_parser_stack_init();

/**
 * Pushes an entry into the stack. Returns whether the operation was successful.
 */
bool ws_parser_stack_push(ws_parser_stack* stack, ws_parser_stack_entry entry);

/**
 * Removes an entry from the top of the stack. Returns whether the operation was successful.
 */
bool ws_parser_stack_pop(ws_parser_stack* stack);

/**
 * Retuns the entry on the top of a stack.
 */
ws_parser_stack_entry ws_parser_stack_top(ws_parser_stack* stack);

/**
 * Releases all memory allocated for stack.
 */
void ws_parser_stack_free(ws_parser_stack* stack);

#endif /* _WS_STACK_H */
