#include <stdlib.h>
#include <memory.h>

#include "parser.h"
#include "config.h"

ws_parser_tree* ws_parser_tree_init_sized(int nodes, bool finalized);

ws_parser_tree* ws_parser_tree_init() {
	return ws_parser_tree_init_sized( WS_TREE_SIZE_INIT, false );
}

/**
 * Internal function that allocates memory for tree of given size.
 */
ws_parser_tree* ws_parser_tree_init_sized(int nodes, bool finalized) {
	ws_parser_tree* tree;
	int links;

	tree = malloc( sizeof( ws_parser_tree ) );
	if( !tree ) {
		return NULL;
	}
	memset( tree, '\0', sizeof( ws_parser_tree ) );

	tree->nodes = malloc( nodes * sizeof( ws_parser_node ) );
	tree->allocated = nodes;
	if( !tree->nodes ) {
		ws_parser_tree_free( tree );
		return NULL;
	}

	links = finalized ? nodes - 1 : nodes;
	tree->links = malloc( links * sizeof( ws_parser_node_link ) );
	if( !tree->links ) {
		ws_parser_tree_free( tree );
		return NULL;
	}
	// Since 0 may be a valid link ID, we fill it with ~0
	memset( tree->links, UCHAR_MAX, links * sizeof( ws_parser_node_link ) );

	tree->symbols = malloc( nodes * sizeof( char* ) );
	if( !tree->symbols ) {
		ws_parser_tree_free( tree );
		return NULL;
	}

	if( !finalized ) {
		tree->singleprods = malloc( nodes * sizeof( ws_parser_node_id ) );
		if( !tree->singleprods ) {
			ws_parser_tree_free( tree );
			return NULL;
		}
	}

	tree->finalized = finalized;

	return tree;
}

ws_parser_node_id ws_parser_tree_add(ws_parser_tree* tree, ws_parser_node node, char* symbol) {
	if( tree->finalized )
		return false;
	if( tree->allocated == tree->count ) {
		ws_parser_node_id newcount = tree->allocated + WS_TREE_SIZE_STEP;

		ws_parser_node* nodes;
		nodes = realloc( tree->nodes, newcount * sizeof( ws_parser_node ) );
		if( !nodes ) {
			return WS_NODE_ID_INVALID;
		}
		tree->nodes = nodes;

		ws_parser_node_link* links;
		links = realloc( tree->links, newcount * sizeof( ws_parser_node_link ) );
		if( !links ) {
			return WS_NODE_ID_INVALID;
		}
		tree->links = links;
		memset( tree->links + tree->count, UCHAR_MAX, WS_TREE_SIZE_STEP * sizeof( ws_parser_node_link ) );

		char** symbols;
		symbols = realloc( tree->symbols, newcount * sizeof( char* ) );
		if( !symbols ) {
			return WS_NODE_ID_INVALID;
		}
		tree->symbols = symbols;

		ws_parser_node_id* singleprods;
		singleprods = realloc( tree->singleprods, newcount * sizeof( ws_parser_node_id ) );
		if( !singleprods ) {
			return WS_NODE_ID_INVALID;
		}
		tree->singleprods = singleprods;

		tree->allocated += WS_TREE_SIZE_STEP;
	}

	ws_parser_node_id id = tree->count;
	tree->nodes[id] = node;
	if( symbol ) {
		tree->symbols[id] = malloc( strlen( symbol ) + 1 );
		if( !tree->symbols[id] ) {
			return WS_NODE_ID_INVALID;
		}
		strcpy( tree->symbols[id], symbol );	// Could be unsafe, but here we allocate memory based on strlen()
	} else {
		tree->symbols[id] = NULL;
	}
	tree->count++;
	return id;
}

bool ws_parser_tree_link(ws_parser_tree* tree, ws_parser_node_id parent, ws_parser_node_id child, uint8_t number) {
	if( tree->finalized || parent >= tree->count || child >= tree->count )
		return false;

	tree->links[child].parent = parent;
	tree->links[child].child = child;
	tree->links[child].number = number;
	return true;
}

void ws_parser_tree_set_root(ws_parser_tree* tree, ws_parser_node_id root) {
	tree->root = root;
}

int ws_parser_tree_compare_links(const void *link1_p, const void *link2_p) {
	ws_parser_node_link* link1 = (ws_parser_node_link*) link1_p;
	ws_parser_node_link* link2 = (ws_parser_node_link*) link2_p;
	if( link1->parent == link2->parent ) {
		return link1->number - link2->number;
	} else {
		return link1->parent - link2->parent;
	}
}

// ws_parser_tree_finalize has subfunctions for the sake of the architecture and profiling
void ws_parser_tree_finalize_relocate(ws_parser_tree* tree);
void ws_parser_tree_finalize_index(ws_parser_tree* tree);

bool ws_parser_tree_finalize(ws_parser_tree* tree) {
#ifdef WS_USE_COMPLETE_OPTIMIZATION
	// Remove orphan nodes and move the node at the end to the place of the removed ones
	ws_parser_tree_finalize_relocate( tree );
#endif /* WS_USE_COMPLETE_OPTIMIZATION */

	// We no longer need this
	free( tree->singleprods );
	tree->singleprods = NULL;

	// Remove the empty link for the root node...
	tree->links[tree->root] = tree->links[tree->count - 1];
	// ...and sort them!
	qsort( tree->links, tree->count - 1, sizeof( ws_parser_node_link ), ws_parser_tree_compare_links );

	// Reallocate memory
	tree->nodes = realloc( tree->nodes, tree->count * sizeof( ws_parser_node ) );
	tree->links = realloc( tree->links, ( tree->count - 1 ) * sizeof( ws_parser_node_link ) );
	tree->symbols = realloc( tree->symbols, tree->count * sizeof( char* ) );

	// Fill the firstlink fields
	ws_parser_tree_finalize_index( tree );

	// We are done
	tree->finalized = true;

	return true;
}

/**
 * Remove orphan nodes and move the node at the end to the place of the removed ones.
 */
void ws_parser_tree_finalize_relocate(ws_parser_tree* tree) {
	ws_parser_node_id i, j;
	for( i = 0; i < tree->count; i++ ) {
		if( tree->links[i].parent == WS_NODE_ID_INVALID && i != tree->root ) {
			ws_parser_node_id oldid = tree->count - 1;

			if( i == oldid ) {
				// It is a node at the end. Just discard it.
				tree->count--;
			} else {
				// Move it
				tree->nodes[i] = tree->nodes[oldid];
				tree->links[i] = tree->links[oldid];
				tree->symbols[i] = tree->symbols[oldid];

				// Update references
				tree->links[i].child = i;
				// FIXME: can this be optimized?
				for( j = 0; j < tree->count - 1; j++ ) {
					if( tree->links[j].parent == oldid )
						tree->links[j].parent = i;
				}
				if( oldid == tree->root ) {
					tree->root = i;
				}

				// Decrease counters and repeat step
				tree->count--;
				i--;
			}
		}
	}
}

/**
 * Fills the node.firstlink fields, allowing faster access to the tree.
 */
void ws_parser_tree_finalize_index(ws_parser_tree* tree) {
	uint32_t i;
	for( i = 0; i < tree->count - 1; i++ ) {
		if( tree->links[i].number == 0 ) {
			tree->nodes[ tree->links[i].parent ].firstlink = i;
		}
	}
}

ws_parser_tree_children ws_parser_tree_search_children(ws_parser_tree* tree, ws_parser_node_id node) {
	ws_parser_tree_children result;
	uint32_t i;

	result.count = 0;

	if( !tree->finalized || node >= tree->count ) {
		result.links = NULL;
		return result;
	}

	if( tree->nodes[node].firstlink == WS_NODE_ID_INVALID ) {
		result.links = NULL;
	} else {
		result.links = tree->links + tree->nodes[node].firstlink;
		for( i = 0; i < tree->nodes[node].firstlink - node; i++ ) {
			if( result.links[i].parent == node )
				result.count++;
			else
				break;
		}
	}

	return result;
}

ws_parser_node* ws_parser_tree_get_child(ws_parser_tree* tree, ws_parser_tree_children children, uint8_t number) {
	if( number >= children.count ) {
		return NULL;
	}

	return tree->nodes + children.links[number].child;
}

int ws_parser_tree_serialize_length(ws_parser_tree* tree) {
	int i, symbols_length;
	symbols_length = sizeof( uint32_t ) * tree->count;
	for( i = 0; i < tree->count; i++ ) {
		if( tree->symbols[i] )
			symbols_length += strlen( tree->symbols[i] );
	}

	return
		sizeof( ws_parser_tree_header ) +
		tree->count * sizeof( ws_parser_node ) +
		( tree->count - 1 ) * sizeof( ws_parser_node_link ) +
		symbols_length;
}

void ws_parser_tree_serialize(ws_parser_tree* tree, void* buffer) {
	ws_parser_tree_header header;
	int i;
	size_t size;

	header.root = tree->root;
	header.count = tree->count;
	strcpy( header.version, WS_PARSER_VERSION );

	size = sizeof( ws_parser_tree_header );
	memcpy( buffer, &header, size );
	buffer += size;

	size = sizeof( ws_parser_node ) * tree->count;
	memcpy( buffer, tree->nodes, size );
	buffer += size;

	size = sizeof( ws_parser_node_link ) * ( tree->count - 1 );
	memcpy( buffer, tree->links, size );
	buffer += size;

	for( i = 0; i < tree->count; i++ ) {
		uint32_t length;
		length = tree->symbols[i] ?
			strlen( tree->symbols[i] ) :
			((uint32_t)0);
		*((uint32_t*)buffer) = length;
		
		buffer += sizeof( uint32_t );

		memcpy( buffer, tree->symbols[i], length );
		buffer += length;
	}
}

ws_parser_tree* ws_parser_tree_unserialize(void* buffer) {
	ws_parser_tree* tree;
	ws_parser_tree_header* header;
	uint32_t i;
	size_t size;

	header = buffer;
	tree = ws_parser_tree_init_sized( header->count, true );
	if( !tree ) {
		return NULL;
	}
	if( strcmp( header->version, WS_PARSER_VERSION ) ) {
		return NULL;
	}
	tree->root = header->root;
	tree->count = header->count;
	buffer += sizeof( ws_parser_tree_header );

	size = sizeof( ws_parser_node ) * tree->count;
	memcpy( tree->nodes, buffer, size );
	buffer += size;

	size = sizeof( ws_parser_node_link ) * ( tree->count - 1 );
	memcpy( tree->links, buffer, size );
	buffer += size;

	for( i = 0; i < tree->count; i++ ) {
		uint32_t length = *((uint32_t*)buffer);
		buffer += sizeof( uint32_t );
		if( length ) {
			tree->symbols[i] = malloc( length + 1 );
			memcpy( tree->symbols[i], buffer, length );
			tree->symbols[i][length] = '\0';
			buffer += length;
		} else {
			tree->symbols[i] = NULL;
		}
	}

	return tree;
}

void ws_parser_tree_free(ws_parser_tree* tree) {
	if( tree ) {
		if( tree->nodes )
			free( tree->nodes );

		if( tree->links )
			free( tree->links );

		if( tree->symbols ) {
			int i;

			for( i = 0; i < tree->count; i++ ) {
				if( tree->symbols[i] ) 
					free( tree->symbols[i] );
			}
			free( tree->symbols );
		}

		if( tree->singleprods ) {
			free( tree->singleprods );
		}

		free( tree );
	}
}
