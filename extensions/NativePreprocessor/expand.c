
#include <string.h>
#include <stdbool.h>

#include "php.h"
#include "ext/standard/php_string.h"

#undef NDEBUG
#include <assert.h>

#include "nodes.h"

/* PPFRAME flags */
#define NO_ARGS 1
#define NO_TEMPLATES 2
#define STRIP_COMMENTS 4
#define NO_IGNORE 8
#define RECOVER_COMMENTS 16

enum ParserOutputTypes {
	OT_HTML,
	OT_WIKI,
	OT_PREPROCESS,
	OT_PLAIN
};

struct PPFrame_Native {
	void* parser;
	enum ParserOutputTypes parserOT;
	bool removeCommentsOption;
	
	/* if this PPFrame is also a PPTemplateFrame */
	void *parent;
};

const struct str_ref empty_str = { NULL, 0, false };

/* Call insertStripItem() in the parser object, and return the given 
 * zval, which shall be a string (or null)
 */
zval* insertStripItem(void* parser, const char* text, int len) {
	/* CODE ME */
}

struct node* unserializeNode(const char* nodeString, struct node* parentNode) {
	struct node* node = alloc_node();
	node->type = nodeString[0];
	node->flags = nodeString[1] - '0';
	node->nextSibling = getNextSibling( nodeString );
	node->contentLength = getContentLength( nodeString );
	node->index = 0;
	node->parent = parentNode;
	
	return node;
}

#define addText(val,len) if ( !expanded.string ) { expanded.string = val; expanded.length = len; } else {  }

int expand(struct PPFrame_Native* frame, const char* nodeString, int nodeStringLen, const char* text, int text_len, int flags) {
	struct node *curNode = NULL;
	struct str_ref expanded = empty_str;
	
	/* TODO: Check the parser nodeCount and expansionDepth */
	
	if ( nodeStringLen % NODE_LEN ) {
		return -1;
	}
	if ( nodeStringLen < NODE_LEN ) {
		return -2;
	}
	
	char const* textPos = text;
	
	for ( ; nodeStringLen > 0; ) {
		curNode = unserializeNode( nodeString, curNode );
		nodeString += NODE_LEN; nodeStringLen -= NODE_LEN;
		
		/* Entering in such node */
		switch (curNode->type) {
			case literal_node:
				addText( textPos, curNode->contentLength );
				textPos += curNode->contentLength;
				break;
				
			case template_node:
				//TODO
				//ParserOT
			
			case tplarg_node:
				//TODO
				break;
				
			case comment_node:
				// HTML-style comment
				// Remove it in HTML, pre+remove and STRIP_COMMENTS modes
				if ( frame->parserOT == OT_HTML
					|| ( frame->parserOT == OT_PREPROCESS && frame->removeCommentsOption )
					|| ( flags & STRIP_COMMENTS ) )
				{
					/* Add nothing */
				}

				// Add a strip marker in PST mode so that pstPass2() can run some old-fashioned regexes on the result
				// Not in RECOVER_COMMENTS mode (extractSections) though
				else if ( frame->parserOT == OT_WIKI && ! ( flags & RECOVER_COMMENTS ) ) {
					zval * stripItem;
					stripItem = insertStripItem( frame->parser, textPos, curNode->contentLength );
					if ( stripItem ) {
						if ( Z_TYPE_P( stripItem ) == IS_STRING )
							addText( Z_STRVAL_P( stripItem ), Z_STRLEN_P( stripItem ) );
						Z_DELREF_P( stripItem );
					}
				}
				// Recover the literal comment in RECOVER_COMMENTS and pre+no-remove
				else {
					addText( textPos, curNode->contentLength );
				}
				textPos += curNode->contentLength;
				break;
			case ignore_node:
				// Output suppression used by <includeonly> etc.
				// OT_WIKI will only respect <ignore> in substed templates.
				// The other output types respect it unless NO_IGNORE is set.
				// extractSections() sets NO_IGNORE and so never respects it.
				if ( ( !frame->parent && frame->parserOT == OT_WIKI ) || ( flags & NO_IGNORE ) ) {
					addText( textPos, curNode->contentLength );
				} else {
					/* Add nothing */
				}
				textPos += curNode->contentLength;
				break;
			case ext_node:
				curNode->ext_data.expanded = expanded;
				expanded = empty_str;
				curNode->ext_data.name = curNode->ext_data.attr = empty_str;
				break;
			case name_node:
				if ( curNode->parent->type == ext_node ) {
					curNode->ext_data.name.string = textPos;
					curNode->ext_data.name.length = curNode->contentLength;
					textPos += curNode->contentLength;
				}
				break;
			case attr_node:
				weak_assert( curNode->parent->type == ext_node );
				weak_assert( !curNode->parent->ext_data.attr.string );
				curNode->parent->ext_data.attr.string = textPos;
				curNode->parent->ext_data.attr.length = curNode->contentLength;
				textPos += curNode->contentLength;
				break;
			case inner_node:
				weak_assert( curNode->parent->type == ext_node );
				weak_assert( !curNode->parent->ext_data.inner.string );
				curNode->parent->ext_data.inner.string = textPos;
				curNode->parent->ext_data.inner.length = curNode->contentLength;
				textPos += curNode->contentLength;
			case close_node:
				weak_assert( curNode->parent->type == ext_node );
				weak_assert( !curNode->parent->ext_data.close.string );
				curNode->parent->ext_data.close.string = textPos;
				curNode->parent->ext_data.close.length = curNode->contentLength;
				textPos += curNode->contentLength;
				break;
				
			
				curNode->nextSibling;
				//TODO
				break;
		}
		curNode->index += NODE_LEN;
		
		while ( curNode && curNode->index >= curNode->nextSibling ) {
			struct node* tmp;
			tmp = curNode->parent;
			
			if ( tmp ) {
				zval* z;
				tmp->index += curNode->index;
				
				/* Run curNode destructor */
				switch ( curNode->type ) {
					case ext_node:
						z = extensionSubstitutionInternal();
						if ( z ) {
							if ( Z_TYPE_P( z ) == IS_STRING )
								addText( Z_STRVAL_P( z ), Z_STRLEN_P( z ) );
							Z_DELREF_P( z );
						}
						break;
					case heading_node:
					case h1_node...h6_node:
						if ( curNode->parent && curNode->parent->type == root_node 
							&& frame->parserOT == OT_WIKI )
						{
							z = getMarker( curNode->flags );
							if ( z ) {
								if ( Z_TYPE_P( z ) == IS_STRING )
									addText( Z_STRVAL_P( z ), Z_STRLEN_P( z ) );
								Z_DELREF_P( z );
							}
						}
				}
			}
			free_node( curNode );
			curNode = tmp;
		}
	}
	
failure:
	;
}
