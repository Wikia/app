#include <string.h>
#include <stdlib.h>
#include <ctype.h>
#include <stdbool.h>

#include "scanner.h"

#define CURRENT_CHAR ( state->code[state->pos] )
#define NEXT_CHAR ( state->code[state->pos + 1] )
#define PREV_CHAR ( state->code[state->pos - 1] )
#define CURRENT_VALUE ( state->cur.value )

ws_scanner_state *ws_scanner_init(char* code) {
	ws_scanner_state *state;
	state = malloc( sizeof( ws_scanner_state ) );
	if( !state ) {
		return NULL;
	}

	memset( state, 0, sizeof( ws_scanner_state ) );
	state->lineno = 1;
	state->code = code;

	return state;
}

void ws_scanner_free(ws_scanner_state *state) {
	free( state );
}

ws_token *ws_scanner_current_token(ws_scanner_state *state) {
	state->cur.lineno = state->lineno;
	return &(state->cur);
}

void ws_scanner_free_token(ws_token* token) {
	/* no-op */
}

bool ws_scanner_handle_operator(ws_scanner_state *state);
void ws_scanner_handle_keyword(ws_scanner_state *state);
bool ws_scanner_handle_string(ws_scanner_state *state);
bool ws_scanner_is_long_op(ws_scanner_state *state, int start_pos);

#define SET_TOKEN( _type, _val ) \
	state->cur.type = _type; \
	state->cur.value = _val; \
	state->cur.lineno = state->lineno;
#define SET_TOKEN_SUBSTR( start_pos, end_pos ) \
	state->cur.value_size = end_pos - start_pos + 1; \
	CURRENT_VALUE = (char*)malloc( state->cur.value_size ); \
	if( !CURRENT_VALUE ) { \
		state->errno = WS_SCANNER_MEMORY; \
		return false; \
	} \
	memcpy( CURRENT_VALUE, state->code + start_pos, end_pos - start_pos ); \
	CURRENT_VALUE[end_pos - start_pos] = '\0';

inline bool isidchar( char value ) {
	return isalnum( value ) || value == '_';
}

bool ws_scanner_next(ws_scanner_state *state) {
	int start_pos;

	// If there was a previous token, it must have been copied by whoever needed it
	// Free the memory used by the value of the previous token
	if( state->cur.value ) {
		free( state->cur.value );
		state->cur.value = NULL;
	}

	// Skip whitespace
	while( CURRENT_CHAR && isspace( CURRENT_CHAR ) ) {
		if( CURRENT_CHAR == '\n' )
			state->lineno++;
		state->pos++;
	}

	// Return if EOF
	if( !CURRENT_CHAR ) {
		SET_TOKEN( WS_TOKEN_END, NULL );
		return true;
	}

	// Skip multiline comments
	if( CURRENT_CHAR && NEXT_CHAR && CURRENT_CHAR == '/' && NEXT_CHAR == '*' ) {
		while( CURRENT_CHAR && NEXT_CHAR ) {
			if( CURRENT_CHAR == '*' && NEXT_CHAR == '/' ) {
				break;
			}
			if( CURRENT_CHAR == '\n' )
				state->lineno++;
			state->pos++;
		}

		if( CURRENT_CHAR && NEXT_CHAR ) {
			state->pos += 2;
			return ws_scanner_next( state );
		} else {
			SET_TOKEN( WS_TOKEN_END, NULL );
			return true;
		}
	}

	// Skip singleline comments
	if( CURRENT_CHAR && NEXT_CHAR && CURRENT_CHAR == '/' && NEXT_CHAR == '/' ) {
		while( CURRENT_CHAR ) {
			if( CURRENT_CHAR == '\n' ) {
				break;
			}
			state->pos++;
		}

		if( CURRENT_CHAR ) {
			state->lineno++;
			state->pos += 1;
			return ws_scanner_next( state );
		} else {
			SET_TOKEN( WS_TOKEN_END, NULL );
			return true;
		}
	}

	// String literals
	if( CURRENT_CHAR == '"' || CURRENT_CHAR == '\'' ) {
		char type = CURRENT_CHAR;
		state->pos++;
		start_pos = state->pos;

		while( CURRENT_CHAR && CURRENT_CHAR != type ) {
			if( CURRENT_CHAR == '\\' && NEXT_CHAR ) {
				switch( NEXT_CHAR ) {
					case 'x':
						state->pos += 2;
						if( CURRENT_CHAR && NEXT_CHAR ) {
							state->pos += 2;
						} else {
							state->errno = WS_SCANNER_UNCLOSED_STR;
							return false;
						}
						break;
					case '"':
					case '\'':
					case 'n':
					case 'r':
					case 't':
					case '\\':
					default:
						state->pos += 2;
						break;
				}
			} else {
				state->pos++;
			}
		}

		if( !CURRENT_CHAR ) {
			state->errno = WS_SCANNER_UNCLOSED_STR;
			return false;
		}

		SET_TOKEN_SUBSTR( start_pos, state->pos );
		state->pos++;
		state->cur.type = WS_TOKEN_STRING;

		return ws_scanner_handle_string( state );
	}

	// Handle operators
	if( ispunct( CURRENT_CHAR ) && CURRENT_CHAR != '_' ) {
		start_pos = state->pos;
		while( CURRENT_CHAR && ispunct( CURRENT_CHAR ) && ws_scanner_is_long_op( state, start_pos ) )
			state->pos++;
		SET_TOKEN_SUBSTR( start_pos, state->pos );
		return ws_scanner_handle_operator( state );
	}

	// Lazy number handling
	// Note that number is stored as string. Interpretation is interpreter's problem
	if( isdigit( CURRENT_CHAR ) ) {
		start_pos = state->pos;

		state->cur.type = WS_TOKEN_INT;
		if( CURRENT_CHAR == '0' && NEXT_CHAR && NEXT_CHAR == 'x' ) {
			// Hex
			state->pos += 2;
			while( CURRENT_CHAR && isxdigit( CURRENT_CHAR ) )
				state->pos++;
		} else {
			// Dec or oct
			while( CURRENT_CHAR && isdigit( CURRENT_CHAR ) )
				state->pos++;
			if( CURRENT_CHAR && NEXT_CHAR && CURRENT_CHAR == '.' && isdigit( NEXT_CHAR ) ) {
				state->cur.type = WS_TOKEN_FLOAT;
				state->pos++;
				while( CURRENT_CHAR && isdigit( CURRENT_CHAR ) )
					state->pos++;
			}
		}

		SET_TOKEN_SUBSTR( start_pos, state->pos );
		return true;
	}

	// Handle IDs and keywords
	if( isidchar( CURRENT_CHAR ) ) {
		start_pos = state->pos;
		while( CURRENT_CHAR && isidchar( CURRENT_CHAR ) )
			state->pos++;
		SET_TOKEN_SUBSTR( start_pos, state->pos );
		state->cur.type = WS_TOKEN_ID;

		ws_scanner_handle_keyword( state );

		return true;
	}

	state->errno = WS_SCANNER_UNKNOWN_TOK;
	return false;
}

/**
 * Determines if the current symbol may belong to a multi-char operator.
 */
bool ws_scanner_is_long_op(ws_scanner_state *state, int start_pos) {
	if( state->pos == start_pos ) {
		return true;
	}

	// 2 characters
	if( state->pos == start_pos + 1 ) {
		return (
			(CURRENT_CHAR == '=' &&
				(PREV_CHAR == '+' ||	// +=
				 PREV_CHAR == '-' ||	// -=
				 PREV_CHAR == '*' ||	// *=
				 PREV_CHAR == '/' ||	// /=
				 PREV_CHAR == '=' ||	// ==
				 PREV_CHAR == '!' ||	// !=
				 PREV_CHAR == '>' ||	// >=
				 PREV_CHAR == '<')  	// <=
			) ||
			(CURRENT_CHAR == '*' && PREV_CHAR == '*') ||
			(CURRENT_CHAR == ':' && PREV_CHAR == ':')
		);
	}

	if( state->pos == start_pos + 2 ) {
		return CURRENT_CHAR == '=' && PREV_CHAR == '=' &&
			(state->code[state->pos - 2] == '=' ||	// ===
			 state->code[state->pos - 2] == '!'); 	// !==
	}

	// 4+ characters
	return false;
}

#define HANDLE_OPERATOR( op, optype ) \
	if( !strcmp( CURRENT_VALUE, op ) ) { \
		state->cur.type = optype; \
		return true; \
	}

bool ws_scanner_handle_operator(ws_scanner_state *state) {
	HANDLE_OPERATOR( "::", WS_TOKEN_DOUBLECOLON );
	HANDLE_OPERATOR( ":", WS_TOKEN_COLON );
	HANDLE_OPERATOR( ",", WS_TOKEN_COMMA );
	HANDLE_OPERATOR( ">", WS_TOKEN_COMPAREOP );
	HANDLE_OPERATOR( "<", WS_TOKEN_COMPAREOP );
	HANDLE_OPERATOR( ">=", WS_TOKEN_COMPAREOP );
	HANDLE_OPERATOR( "<=", WS_TOKEN_COMPAREOP );
	HANDLE_OPERATOR( "==", WS_TOKEN_EQUALSTO );
	HANDLE_OPERATOR( "!=", WS_TOKEN_EQUALSTO );
	HANDLE_OPERATOR( "===", WS_TOKEN_EQUALSTO );
	HANDLE_OPERATOR( "!==", WS_TOKEN_EQUALSTO );
	HANDLE_OPERATOR( "!", WS_TOKEN_INVERT );
	HANDLE_OPERATOR( "(", WS_TOKEN_LEFTBRACKET );
	HANDLE_OPERATOR( "{", WS_TOKEN_LEFTCURLY );
	HANDLE_OPERATOR( "[", WS_TOKEN_LEFTSQUARE );
	HANDLE_OPERATOR( "&", WS_TOKEN_LOGICOP );
	HANDLE_OPERATOR( "|", WS_TOKEN_LOGICOP );
	HANDLE_OPERATOR( "^", WS_TOKEN_LOGICOP );
	HANDLE_OPERATOR( "*", WS_TOKEN_MUL );
	HANDLE_OPERATOR( "/", WS_TOKEN_MUL );
	HANDLE_OPERATOR( "%", WS_TOKEN_MUL );
	HANDLE_OPERATOR( "**", WS_TOKEN_POW );
	HANDLE_OPERATOR( ")", WS_TOKEN_RIGHTBRACKET );
	HANDLE_OPERATOR( "}", WS_TOKEN_RIGHTCURLY );
	HANDLE_OPERATOR( "]", WS_TOKEN_RIGHTSQUARE );
	HANDLE_OPERATOR( ";", WS_TOKEN_SEMICOLON );
	HANDLE_OPERATOR( "=", WS_TOKEN_SETTO );
	HANDLE_OPERATOR( "+=", WS_TOKEN_SETTO );
	HANDLE_OPERATOR( "-=", WS_TOKEN_SETTO );
	HANDLE_OPERATOR( "*=", WS_TOKEN_SETTO );
	HANDLE_OPERATOR( "/=", WS_TOKEN_SETTO );
	HANDLE_OPERATOR( "+", WS_TOKEN_SUM );
	HANDLE_OPERATOR( "-", WS_TOKEN_SUM );
	HANDLE_OPERATOR( "?", WS_TOKEN_TRINARY );

	state->errno = WS_SCANNER_UNKNOWN_OP;
	return false;
}

#define HANDLE_KEYWORD( keyword, val ) \
	if( !strcmp( CURRENT_VALUE, keyword ) ) \
		state->cur.type = val;

void ws_scanner_handle_keyword(ws_scanner_state *state) {
	HANDLE_KEYWORD( "append", WS_TOKEN_APPEND );
	HANDLE_KEYWORD( "break", WS_TOKEN_BREAK );
	HANDLE_KEYWORD( "catch", WS_TOKEN_CATCH );
	HANDLE_KEYWORD( "contains", WS_TOKEN_CONTAINS );
	HANDLE_KEYWORD( "continue", WS_TOKEN_CONTINUE );
	HANDLE_KEYWORD( "delete", WS_TOKEN_DELETE );
	HANDLE_KEYWORD( "else", WS_TOKEN_ELSE );
	HANDLE_KEYWORD( "false", WS_TOKEN_FALSE );
	HANDLE_KEYWORD( "for", WS_TOKEN_FOR );
	HANDLE_KEYWORD( "function", WS_TOKEN_FUNCTION );
	HANDLE_KEYWORD( "if", WS_TOKEN_IF );
	HANDLE_KEYWORD( "in", WS_TOKEN_IN );
	HANDLE_KEYWORD( "isset", WS_TOKEN_ISSET );
	HANDLE_KEYWORD( "null", WS_TOKEN_NULL );
	HANDLE_KEYWORD( "return", WS_TOKEN_RETURN );
	HANDLE_KEYWORD( "self", WS_TOKEN_SELF );
	HANDLE_KEYWORD( "true", WS_TOKEN_TRUE );
	HANDLE_KEYWORD( "try", WS_TOKEN_TRY );
	HANDLE_KEYWORD( "yield", WS_TOKEN_YIELD );
}

#define HANDLE_ESCAPE_SEQUENCE( seq, sym ) \
	case seq: \
		newstr[newpos] = sym; \
		newpos++; \
		break;

bool ws_scanner_handle_string(ws_scanner_state *state) {
	char* oldstr = CURRENT_VALUE;
	char* newstr = malloc( state->cur.value_size );
	int oldpos, newpos;

	if( !newstr ) {
		state->errno = WS_SCANNER_MEMORY;
		return false;
	}

	for( oldpos = newpos = 0; oldstr[oldpos]; oldpos++ ) {
		if( oldstr[oldpos] == '\\' && oldstr[oldpos + 1] ) {
			oldpos++;

			switch( oldstr[oldpos] ) {
				HANDLE_ESCAPE_SEQUENCE( '"', '"' )
				HANDLE_ESCAPE_SEQUENCE( '\'', '\'' )
				HANDLE_ESCAPE_SEQUENCE( 'n', '\n' )
				HANDLE_ESCAPE_SEQUENCE( 'r', '\r' )
				HANDLE_ESCAPE_SEQUENCE( 't', '\t' )
				HANDLE_ESCAPE_SEQUENCE( '\\', '\\' )
				case 'x':
					// Handle if both are hex digits and the character is not \0, otherwise stay as is
					if( isxdigit( oldstr[oldpos+1] ) && isxdigit( oldstr[oldpos+2] ) && !( oldstr[oldpos+1] == '0' && oldstr[oldpos+2] == '0' ) ) {
						char symbol;
						char digits[3] = { oldstr[oldpos + 1], oldstr[oldpos + 2], '\0' };

						symbol = (char)strtol( digits, NULL, 16 );

						newstr[newpos] = symbol;
						newpos++;
						oldpos += 2;
						break;
					} else {
						// Same as default
					}
				default:
					newstr[newpos] = '\\';
					newstr[newpos+1] = oldstr[oldpos];
					newpos += 2;
					break;
			}
		} else {
			newstr[newpos] = oldstr[oldpos];
			newpos++;
		}
	}

	newstr[newpos] = '\0';

	if( oldpos != newpos )
		newstr = realloc( newstr, newpos + 1 );
	free( oldstr );
	CURRENT_VALUE = newstr;

	return true;
}
