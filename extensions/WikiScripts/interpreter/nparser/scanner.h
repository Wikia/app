/**
 * This file contains the definitions specific to WikiScripts parser.
 */

#include <stdlib.h>
#include <stdbool.h>
#include <stdint.h>
#include "tokenids.h"

#ifndef _WS_SCANNER_H
#define _WS_SCANNER_H

#define WS_SCANNER_OK 0
#define WS_SCANNER_UNKNOWN_TOK 1
#define WS_SCANNER_UNCLOSED_STR 2
#define WS_SCANNER_UNKNOWN_OP 3
#define WS_SCANNER_MEMORY 4

typedef uint8_t ws_token_type;

typedef struct {
	ws_token_type type;
	char* value;
	size_t value_size;
	int lineno;
} ws_token;

typedef struct {
	char* code;
	int pos;
	ws_token cur;
	int lineno;
	int errno;
} ws_scanner_state;

ws_scanner_state *ws_scanner_init(char* code);
void ws_scanner_free(ws_scanner_state *state);
bool ws_scanner_next(ws_scanner_state *state);
ws_token *ws_scanner_current_token(ws_scanner_state *state);
void ws_scanner_free_token(ws_token *token);

const char* ws_scanner_token_name(ws_token_type type);

#endif	/* _WS_SCANNER_H */
