#include <stdlib.h>
#include <string.h>
#include <memory.h>
#include "parser.h"
#include "stack.h"
#include "scanner.h"

#define DO_CLEANUP() \
	if( token ) \
		ws_scanner_free_token( token ); \
	if( tree ) \
		ws_parser_tree_free( tree ); \
	if( stack ) \
		ws_parser_stack_free( stack ); \
	if( scanner ) \
		ws_scanner_free( scanner );
		

ws_parser_output ws_parse(char* code) {
	ws_parser_stack* stack = NULL;
	ws_scanner_state* scanner = NULL;
	ws_parser_tree* tree = NULL;
	ws_token* token = NULL;
	ws_parser_output output;
	bool finish = false;

	stack = ws_parser_stack_init();
	if( !stack ) {
		output.errno = WS_PARSER_MEMORY;
		return output;
	}

	ws_parser_stack_entry top = { 0, 0 };
	ws_parser_stack_push( stack, top );

	tree = ws_parser_tree_init();
	if( !tree ) {
		DO_CLEANUP();
		output.errno = WS_PARSER_MEMORY;
		return output;
	}

	scanner = ws_scanner_init( code );
	if( !scanner ) {
		DO_CLEANUP();
		output.errno = WS_PARSER_MEMORY;
		return output;
	}
	if( !ws_scanner_next( scanner ) ) {
		DO_CLEANUP();
		output.errno = WS_PARSER_SCANNER_ERROR;
		output.errarg = scanner->errno;
		return output;
	}

	while( !finish ) {
		ws_parser_stack_entry top;
		ws_parser_action_entry act;
		ws_parser_node node;
		ws_parser_stack_entry newstack;

		token = ws_scanner_current_token( scanner );
		top = ws_parser_stack_top( stack );

		act = ws_parser_table_action[top.state][token->type];
		switch( act.action ) {
			int i;
			ws_parser_node_id nodeid;
			int prodlen;
			uint8_t nonterm;

			case WS_PARSER_ERROR:
				DO_CLEANUP();
				output.errno = WS_PARSER_SYNTAX_ERROR;
				output.errarg = act.action;	// So we can give some meaningful error message
				output.errline = token->lineno;
				return output;
			case WS_PARSER_SHIFT:
				node.type = WS_PARSER_TERM;
				node.value = token->type;
				node.firstlink = WS_NODE_ID_INVALID;
				nodeid = ws_parser_tree_add( tree, node, token->value );
				tree->singleprods[nodeid] = WS_NODE_ID_INVALID;

				if( nodeid == WS_NODE_ID_INVALID ) {
					DO_CLEANUP();
					output.errno = WS_PARSER_MEMORY;
					return output;
				}

				newstack.node = nodeid;
				newstack.state = act.arg;
				if( !ws_parser_stack_push( stack, newstack ) ) {
					DO_CLEANUP();
					output.errno = WS_PARSER_MEMORY;
					return output;
				}

				if( !ws_scanner_next( scanner ) ) {
					DO_CLEANUP();
					output.errno = WS_PARSER_SCANNER_ERROR;
					output.errarg = scanner->errno;
					return output;
				}

				break;
			case WS_PARSER_REDUCE:
				prodlen = ws_parser_productions[act.arg].length;
				nonterm = ws_parser_productions[act.arg].nonterminal;

				node.type = WS_PARSER_NONTERM;
				node.value = nonterm;
				node.firstlink = WS_NODE_ID_INVALID;
				nodeid = WS_NODE_ID_INVALID;

				// Tree optimization part
				// Looks for patterns like A -> exprA -> exprB (where exprA has only exprB as a child)
				// and replaces them with A -> exprB. We are currently at node A and exprA is somewhere in stack
				for( i = 0; i < prodlen; i++ ) {
					ws_parser_stack_entry* entry = stack->content + (stack->count - i - 1);
					ws_parser_node *opt_parent, *opt_child;	// parent is exprA and child is exprB
					ws_parser_node_id id_parent, id_child;
					id_parent = entry->node;
					opt_parent = tree->nodes + id_parent;
					if( 
						tree->singleprods[id_parent] != WS_NODE_ID_INVALID &&	// has single child; also implies it's a non-terminal
						strstr( ws_parser_nonterminal_names[opt_parent->value], "expr" )	// is an "expr"
					) {
						// Maybe can be optimized. Let's look at the child
						id_child = tree->singleprods[entry->node];
						opt_child = tree->nodes + id_child;
						if(
							opt_child->type == WS_PARSER_NONTERM &&
							strstr( ws_parser_nonterminal_names[opt_child->value], "expr" )
						) {
							if( nodeid == WS_NODE_ID_INVALID ) {
								// Replace old node (exprA) with our current one (A)
								tree->nodes[id_parent] = node;
								nodeid = id_parent;
								memset( tree->links + nodeid, UCHAR_MAX, sizeof( ws_parser_node_link ) );

								// Replace exprA with exprB in stack (so it will be linked as a child)
								entry->node = id_child;

								// Reset singleprods record and go on
								tree->singleprods[entry->node] = WS_NODE_ID_INVALID;
							} else {
								// Make exprA orphan to effectively remove it from the tree
								memset( tree->links + entry->node, UCHAR_MAX, sizeof( ws_parser_node_link ) );

								// Replace exprA with exprB in stack (so it will be linked as a child)
								entry->node = tree->singleprods[entry->node];

								// Reset singleprods record and go on
								tree->singleprods[entry->node] = WS_NODE_ID_INVALID;
							}
						}
					}
				}

				if( nodeid == WS_NODE_ID_INVALID ) {
					nodeid = ws_parser_tree_add( tree, node, NULL );

					if( nodeid == WS_NODE_ID_INVALID ) {
						DO_CLEANUP();
						output.errno = WS_PARSER_MEMORY;
						return output;
					}
				}

				if( prodlen != 1 ) {
					tree->singleprods[nodeid] = WS_NODE_ID_INVALID;
				}

				// Add prodlen nodes from the stack in the reverse order to the tree
				for( i = 0; i < prodlen; i++ ) {
					top = ws_parser_stack_top( stack );
					ws_parser_tree_link( tree, nodeid, top.node, prodlen - i - 1 );

					// If it is a single-child production, track for optimization purposes
					if( prodlen == 1 ) {
						tree->singleprods[nodeid] = top.node;
					}

					if( !ws_parser_stack_pop( stack ) ) {
						DO_CLEANUP();
						output.errno = WS_PARSER_INTERNAL_ERROR;
						return output;
					}
				}

				top = ws_parser_stack_top( stack );

				if( ws_parser_table_goto[top.state][nonterm] != 0xFF ) {
					newstack.state = ws_parser_table_goto[top.state][nonterm];
					newstack.node = nodeid;
					ws_parser_stack_push( stack, newstack );
				} else {
					DO_CLEANUP();
					output.errno = WS_PARSER_INTERNAL_ERROR;
					return output;
				}

				break;
			case WS_PARSER_ACCEPT:
				finish = true;
		}

		ws_scanner_free_token( token );
	}

	top = ws_parser_stack_top( stack );
	ws_parser_tree_set_root( tree, top.node );

	ws_parser_tree_finalize( tree );

	ws_parser_stack_free( stack );
	ws_scanner_free( scanner );

	output.tree = tree;
	output.errno = 0;
	return output;
}
