#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include "wsparse.h"

#define BUFFERSIZE 4 * 1024 * 1024

void printNodesRec( ws_parser_tree* tree, ws_parser_node_id id, int rec ) {
	int i;
	ws_parser_node* node;

	for( i = 0; i < rec; i++ )
		printf( " " );

	node = tree->nodes + id;
	if( node->type == WS_PARSER_NONTERM ) {
		printf( "Nonterm type: %s;\n", ws_parser_nonterminal_names[node->value] );
		ws_parser_tree_children ch = ws_parser_tree_search_children( tree, id );
		for( i = 0; i < ch.count; i++ ) {
			printNodesRec( tree, (ch.links + i)->child, rec + 1 );
		}
	} else {
		printf( "Term type: %s; ", ws_scanner_token_name( node->value ) );
		if( tree->symbols[id] )
				printf( "Symbol: %s;", tree->symbols[id] );
		printf( "\n" );
	}
}

int main( int argc, char** argv ) {
	long long i, count;
	char* line = malloc( BUFFERSIZE );

	if( argc > 1 ) {
		if( !strcmp( argv[1], "--help" ) ) {
			printf( "Parses the script input at STDIN\n" );
			printf( "Usage:\n" );
			printf( "\twsparsertest [runs]\n" );
			printf( "If number of runs is more than one, no parser tree is output.\n" );
			return EXIT_SUCCESS;
		}
		if( !strcmp( argv[1], "--version" ) ) {
			printf( "libwsparser %i.%i (%s)\n", WS_PARSER_VERSION_MAJOR, WS_PARSER_VERSION_MINOR, WS_PARSER_VERSION );
			return EXIT_SUCCESS;
		}
		count = atoll( argv[1] );
	} else {
		count = 1;
	}

	FILE* file = stdin;

	i = 0;
	while( ( line[i] = fgetc( file ) ) != EOF && i < BUFFERSIZE )
		i++;
	line[i] = '\0';

	for( i = 0; i < count; i++ ) {
		ws_parser_output out;
		ws_parser_tree* tree;
		out = ws_parse( line );
		if( out.errno ) {
			printf( "Error, errno: %i, err arg: %i, err line: %i\n", out.errno, out.errarg, out.errline );
			return EXIT_FAILURE;
		}
		tree = out.tree;

		if( count < 2 )
			printNodesRec( tree, tree->root, 0 );
		ws_parser_tree_free( tree );
	}

	free( line );

	return EXIT_SUCCESS;
}
