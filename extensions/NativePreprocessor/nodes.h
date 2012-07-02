
enum nodeTypes {
	root_node = '/',
	literal_node = 'L',
	ignore_node = 'I',
	comment_node = '-',
	
	ext_node = '<', /* Encloses an extension tag */
	name_node = 'N', /* Tag name or part name */
	attr_node = 'a', /* Tag attributes */
	inner_node = '.', /* Tag contents, optional */
	end_name_node = 'e', /* > or /> closing a name node. Missing in Preprocessor_DOM */
	close_node = '>', /* Closing tag, optional */

	heading_node = 'h', /* Used when working with a heading candidate */
	h1_node = 'i',
	h2_node = 'j',
	h3_node = 'k',
	h4_node = 'l',
	h5_node = 'm',
	h6_node = 'n',
	
	brace_node = '{', /* Used when we still don't know its identity (template/tplarg) */
	bracket_node = '[',
	template_node = 't',
	tplarg_node = 'p',
	title_node = 'T',
	part_node = '|',
	value_node = 'v',
	closebrace_node = '}',
};

/* May contain childs: root_node, ext_node, name_node, heading_node (h?_node), template_node, tplarg_node, title_node, part_node, value_node */

struct str_ref {
	char const* string;
	int length;
	bool allocated;
};

extern inline void str_ref_free(struct str_ref* str) {
	if ( str->allocated ) {
		efree( (char*)str->string);
	}
}

struct node {
	enum nodeTypes type;
	char flags;
	int nextSibling;
	int contentLength;
	
	/* Relevant only for nodes with childs */
	int index; /* index inside nodeString (preprocess) / space of children read (expand) */
	struct node* parent;
	
	/* Used for headings */
	int commentEnd;
	int visualEnd; /* Point where the last text ends (ie. without spaces, comments...) */
	
	/* Used for brace and bracket nodes */
	int count;
	
	/* Used for template parts */
	int eqpos; /* Name nodes */
	int argIndex; /* Brace nodes */
	/* Compact me: Move the last three blocks into an union */

	union {
		struct {
			struct str_ref expanded;
			struct str_ref name, attr, inner, close;
		} ext_data;
	};

};

struct literalNode {
	int from;
	int len;
};

#define UNKNOWN_NODE_LEN -1

#define DEFINE_NODE_STRING() char* nodeString = NULL; \
	int nodeStringLen = 0; /* Length used of nodeString. Initialised to 1 for a \0 terminator */ \
	struct literalNode currentLiteral = { 0, 0 }; \
	int storedLength = 0; /* Length of text already stored in the nodes */ \
	struct node* parentNode = NULL; \
	addNodeWithTags(root_node, 0);
	
#define NODE_LEN 16 /* Length of a serialized node */

/**
 * Adds a node of the specified type to the nodeString
 * @param nodeType enum nodeTypes: Type of the node to add.
 * @param txt char*: Text pointer. Must be 'text'
 * @param offset int: Offset from txt to copy from
 * @param length int: Length to copy from 'from'. -1 to copy until the end of the string.
 */
#define addNodeWithText(nodeType,txt,offset,length) \
	do { \
		int mylen = length; \
		assert( txt == text ); \
		if ( currentLiteral.len && nodeType != literal_node ) { \
			storeNodeWithText(literal_node, currentLiteral.from, currentLiteral.len); \
			currentLiteral.len = 0; \
		} \
		if ( -1 == mylen ) { \
			mylen = text_len - offset; \
		} \
		\
		storeNodeWithText(nodeType,offset,mylen); \
	} while (0)

/**
 * Like addNodeWithText() but doesn't commit the literals
 */
#define storeNodeWithText(nodeType,offset,length) \
	do { \
		assert(storedLength == offset); \
		struct node tmpnode; \
		tmpnode.type = nodeType; \
		tmpnode.flags = 0; \
		tmpnode.nextSibling = 0; \
		tmpnode.contentLength = length; \
		\
		ALLOC_NODESTRING(); \
		serializeNode(nodeString + nodeStringLen, &tmpnode); \
		nodeStringLen += NODE_LEN; \
		storedLength += length; \
	} while (0);

/**
 * Records the passed literal inside currentLiteral
 * Adjacent literal nodes are stored inside of a single node.
 */
#define addLiteral(literalText,offset,length) \
	do { \
		int my_len = length; \
		assert( literalText == text ); \
		if ( my_len == -1 ) { \
			my_len = text_len - offset; \
		} \
		if ( currentLiteral.len ) { \
			assert( currentLiteral.from + currentLiteral.len == (offset) ); \
		} else { \
			currentLiteral.from = (offset); \
		} \
		currentLiteral.len += my_len; \
		assert( (length) >= 0 ); \
	} while (0)

/**
 * Adds a node which contains other tags
 * @param nodeType enum nodeTypes: Type of the node.
 * @param charsToSkip int: Number of characters that 'belong' to this node. Used to skip characters
 */
#define addNodeWithTags(nodeType, charsToSkip) \
	do { \
		struct node* tmpnode; \
		if ( currentLiteral.len ) { \
			storeNodeWithText(literal_node, currentLiteral.from, currentLiteral.len); \
			currentLiteral.len = 0; \
		} \
		\
		tmpnode = alloc_node(); \
		tmpnode->type = nodeType; \
		tmpnode->flags = 0; \
		tmpnode->nextSibling = UNKNOWN_NODE_LEN; \
		tmpnode->contentLength = charsToSkip; \
		tmpnode->index = nodeStringLen; \
		tmpnode->count = 0; \
		tmpnode->parent = parentNode; \
		tmpnode->commentEnd = -1; \
		tmpnode->eqpos = -1; \
		parentNode = tmpnode; \
		\
		ALLOC_NODESTRING(); \
		serializeNode(nodeString + nodeStringLen, tmpnode); \
		nodeStringLen += NODE_LEN; \
		storedLength += charsToSkip; \
	} while(0)

#define closeNode(nodeType) \
	do { \
		struct node* tmpnode = parentNode; \
		assert( nodeType == tmpnode->type ); \
		if ( currentLiteral.len ) { \
			storeNodeWithText(literal_node, currentLiteral.from, currentLiteral.len); \
			currentLiteral.len = 0; \
		} \
		tmpnode->nextSibling = nodeStringLen - tmpnode->index - NODE_LEN; \
		serializeNode( nodeString + tmpnode->index, tmpnode ); \
		parentNode = parentNode->parent; \
		free_node( tmpnode ); \
	} while (0)

#define alloc_node() emalloc( sizeof(struct node) )
#define free_node(x) efree(x)

#define ALLOC_NODESTRING() \
	do { \
		nodeString = erealloc(nodeString, nodeStringLen + NODE_LEN + 1); \
		assert( nodeString ); \
	} while(0)

/**
 * Serializes a node into string.
 * The caller must ensure that there are at least NODE_LEN bytes 
 * available from pointer, and NODE_LEN + 1 writable.
 */
static void serializeNode(char* pointer, struct node* node) {
	int c;
	pointer[0] = node->type;
	pointer[1] = '0' + node->flags;
	assert( node->nextSibling < (1 << 24) );
	if ( node->nextSibling == UNKNOWN_NODE_LEN ) {
		pointer[2] = pointer[3] = pointer[4] = pointer[5] = pointer[6] = pointer[7] = '?';
	} else {
		sprintf(&pointer[2], "%06x", node->nextSibling);
	}
	c = pointer[16];
	snprintf(&pointer[8], 9, "%08x", node->contentLength);
	pointer[16] = c;
}

static inline int hex2dec(char val) {
	switch (val) {
		case '0'...'9':
			return val - '0';
		case 'a'...'f':
			return val - 'a' + 10;
	}
	assert(0);
}

/**
 * Get the nextSibling value from a node serialized at pointer.
 * The nextSibling is a hexadecimal value in bytes 2-7, forming a 
 * value in the range [0,0x01000000).
 */
static inline int getNextSibling(const char* pointer) {
	assert( pointer[2] != '?' );
	return ( ( ( ( ( hex2dec(pointer[2]) << 4 ) | hex2dec(pointer[3]) ) << 4 | hex2dec(pointer[4]) ) << 4 | hex2dec(pointer[5]) ) << 4 | hex2dec(pointer[6]) ) << 4 | hex2dec(pointer[7]);
}

/**
 * Get the contentLength value from a node serialized at pointer.
 * The contentLength is a hexadecimal value in bytes 8-15.
 */
static inline int getContentLength(const char* pointer) {
	return ( ( ( ( ( ( ( hex2dec(pointer[8]) << 4 ) | hex2dec(pointer[9]) ) << 4 | hex2dec(pointer[10]) ) << 4 | hex2dec(pointer[11]) ) << 4 | hex2dec(pointer[12]) ) << 4 | hex2dec(pointer[13]) ) << 4 | hex2dec(pointer[14]) ) << 4 | hex2dec(pointer[15]);
}

/**
 * Get the output string that would result if the close is not found.
 * 
 * TODO: Reduce space by collapsing nodes here.
 */
static struct node* breakSyntax( struct node* node, char * const nodeString, int *nodeStringLen ) {
	struct node* parent;
	
	/* Note we cannot coalesce with a previous literal node since it 
	 * may be our nephew, instead of our sister (we could ask our 
	 * parent, though)
	 */

	if ( node->type == bracket_node ) {
		node->type = literal_node;
		node->nextSibling = 0;
		serializeNode( nodeString + node->index, node );
		parent = node->parent;
		free_node( node ); 
		return parent;
	} else if ( node->type == brace_node ) {
		/* Literalize this node and its children (title, part, part\name, part\value) */
		node->type = literal_node;
		node->nextSibling = 0;
		serializeNode( nodeString + node->index, node );
		int writepos = node->index + NODE_LEN;
		int readpos = node->index + NODE_LEN;
		int nextSibling = getNextSibling( nodeString + readpos );
		readpos += NODE_LEN;

		/* Move up the title contents */
		if ( nextSibling ) {
			memmove( nodeString + writepos, nodeString + readpos, nextSibling );
			readpos += nextSibling;
			writepos += nextSibling;
		}
		
		/* Go for part nodes */
		while ( readpos < *nodeStringLen ) {
			assert( nodeString[readpos] == part_node ); /* <part> node */
			assert( !memcmp( nodeString + readpos + 8, "00000001", 8 ) ); /* Part nodes contain exactly one character (the pipe) */
			node->contentLength = 1;
			serializeNode( nodeString + writepos, node );
			readpos += NODE_LEN;
			writepos += NODE_LEN;
			
			assert( readpos < *nodeStringLen ); /* All part nodes contain one name node inside */
			int nameChildren = getNextSibling( nodeString + readpos ); /* <name> */
			readpos += NODE_LEN;
			if ( nameChildren ) {
				memmove( nodeString + writepos, nodeString + readpos, nameChildren );
				readpos += nameChildren;
				writepos += nameChildren;
			}
			if (readpos >= *nodeStringLen) break; /* It may be the case for eg. {{Foo|Bar */
			if ( nodeString[readpos] == literal_node ) { /* if this template had a name, there will be an equal inside a literal node */
				assert( !memcmp( nodeString + readpos, "L000000000000001", NODE_LEN ) );
				memmove( nodeString + writepos, nodeString + readpos, NODE_LEN );
				readpos += NODE_LEN;
				writepos += NODE_LEN;
			}
			
			int valueChildren = getNextSibling( nodeString + readpos ); /* <value> */
			assert( nodeString[readpos] == value_node ); /* <value> node */
			readpos += NODE_LEN;
			if ( valueChildren ) {
				memmove( nodeString + writepos, nodeString + readpos, valueChildren );
				readpos += valueChildren;
				writepos += valueChildren;
			}
		}
		*nodeStringLen = writepos;
		parent = node->parent;
		free_node( node );
		return parent;
	} else {
		assert( 0 );
	}
}
