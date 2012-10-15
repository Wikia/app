/**
 * Data structures and functions to support WikiScripts parser.
 */

#ifndef _WS_PARSER_H
#define _WS_PARSER_H

#include "lrtable.h"
#include "tree.h"

#define WS_PARSER_MAX_PRODUCTION_LENGTH 16

/**
 * IDs
 */
typedef uint8_t ws_parser_lr_state;
typedef uint8_t ws_parser_production_id;
typedef uint8_t ws_parser_nonterminal;

/**
 * Node types
 */
#define WS_PARSER_EMPTY 0
#define WS_PARSER_TERM 1
#define WS_PARSER_NONTERM 2

/**
 * Production
 */
typedef struct {
	ws_parser_nonterminal nonterminal;
	uint8_t length;
	ws_parser_node items[WS_PARSER_MAX_PRODUCTION_LENGTH];
} ws_parser_production;

/**
 * Action table.
 */
#define WS_PARSER_ERROR  0
#define WS_PARSER_SHIFT  1
#define WS_PARSER_REDUCE   2
#define WS_PARSER_ACCEPT   3
typedef uint8_t ws_parser_action;
typedef struct {
	ws_parser_action action;
	/* ws_parser_lr_state or ws_parser_production_id */ uint8_t arg;
} ws_parser_action_entry;

/**
 * Output and errors
 */
#define WS_PARSER_OK 0
#define WS_PARSER_MEMORY 1
#define WS_PARSER_SCANNER_ERROR 2
#define WS_PARSER_INTERNAL_ERROR 3
#define WS_PARSER_SYNTAX_ERROR 4

typedef struct {
	ws_parser_tree* tree;
	int errno;
	int errarg;
	int errline;
} ws_parser_output;

/**
 * LR tables
 */
typedef ws_parser_lr_state ws_parser_goto_entry;

// Nonterminal ID -> Name
extern char* ws_parser_nonterminal_names[];

extern ws_parser_production ws_parser_productions[];

// ( State, Token ID ) -> Action
extern ws_parser_action_entry ws_parser_table_action[WS_PARSER_STATE_COUNT][WS_PARSER_TERM_COUNT];

// ( State, Nonterminal ID ) -> Production ID
extern ws_parser_goto_entry ws_parser_table_goto[WS_PARSER_STATE_COUNT][WS_PARSER_NONTERM_COUNT];

/**
 * Parses the code and returns the tree or an error.
 */
ws_parser_output ws_parse(char* code);

#endif /* _WS_PARSER_H */
