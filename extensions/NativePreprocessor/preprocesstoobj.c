#include <string.h>
#include <stdbool.h>

#include "php.h"
#include "ext/standard/php_string.h"

#undef NDEBUG
#include <assert.h>

#include "tag_util.h"
#include "nodes.h"

#define PTD_FOR_INCLUSION 1 /* Matches Parser::PTD_FOR_INCLUSION */

static int strpos(const char* haystack, int haystack_len, const char* needle, int needle_len, int offset) {
	int i;
	
	for ( i = offset; i <= haystack_len - needle_len; i++ ) {
		if ( !memcmp( haystack + i, needle, needle_len ) ) {
			return i;
		} 
	}
	
	return -1;
}

#define strsize(x) (sizeof(x)-1)
#define min(x,y) (((x) < (y)) ? (x) : (y))

static enum internalTags getInternalTag(const char* name, int name_len) {
	#define CHECK_INTERNAL_TAG(x) if ((sizeof(#x)-1 == name_len) && !strncasecmp(name, #x, sizeof(#x)-1)) return x;
	if (name[0] == '/') {
		name++;
		name_len--;
	}
	CHECK_INTERNAL_TAG(includeonly);
	CHECK_INTERNAL_TAG(onlyinclude);
	CHECK_INTERNAL_TAG(noinclude);
	return None;
}

#define pipe foundPipe /* Avoid conflicts with pipe(2) */

enum foundTypes {
	lineStart,
	lineEnd,
	pipe = '|',
	equals = '=',
	angle = '<',
	closeBrace = '}',
	closeBracket = ']',
	openBrace = '{',
	openBracket = '[',
};

#define searchReset() strcpy(search, "[{<\n") // $search = $searchBase;
#define addSearch(x) addToSearch(search, sizeof(search), x) // $search .= 'x';
#define MAX_SEARCH_CHARS "[{<\n|=}]"
static void addToSearch(char* search, int search_len, char x) {
	int e;
	assert(strchr(MAX_SEARCH_CHARS, x));
	e = strlen(search);
	assert(e < search_len - 2);
	search[e] = x;
	search[e+1] = '\0';
}

size_t mwpp_strcspn(const char* text, int text_len, const char* search, int offset) {
	/* Optimize me */
	//printf(" mwpp_strcspn(%s, %d, %s, %d)\n", text, text_len, search, offset);
	return php_strcspn( (char*)text + offset, (char*)search, (char*)text + text_len, (char*)search + strlen(search) );
}

/**
 * Counts the number of times the character c appears since start, up to length.
 */
static int chrspn( const char* text, int c, int start, int length ) {
	int i;
	for (i=0; i < length; i++) {
		if ( text[start+i] != c ) {
			break;
		}
	}
	return i;
}

/**
 * Locates an end tag for the given tag name.
 *  Matches the regex "/<\/$name\s*>/i"
 * Doesn't (completely) support tag names which contain '<'
 *
 * @param text String: Text in which to find the tag
 * @param text_len int: Length of text
 * @param from int: Offset from which to begin the search
 * @param name String: lowercase name of the tag to close
 * @param name_len int: length of name
 * @param endTagLen int*: length of the found tag (output value)
 * @return int: The position from text where the end tag begins or -1 if not found
 */
static int findEndTag( const char* text, int text_len, int from, const char* name, int name_len, int* endTagLen ) {
	int i, j;
	for (i = from; i < text_len - 2 - name_len; i++) {
		if ( text[i] == '<' && text[i+1] == '/' ) {
			for (j = 0; j < name_len; j++) {
				if ( name[j] != tolower( text[i+2+j] ) ) {
					i += j;
					break;
				}
			}
			if ( j == name_len ) {
				while ( text[i+2+j] == ' ' ) j++;
				if ( text[i+2+j] == '>' ) {
					*endTagLen = j + strsize("</>");
					return i;
				}
				i += j;
			}
		}
	}
	return -1;
}

/**
 * Returns the number of times the character c appears in text, searching backwards from position start
 */
static int chrrspn( const char* text, int c, int start ) {
	int i = 0;
	while ( ( start-i >= 0 ) && text[start-i] == c ) {
		i++;
	}
	return i;
}

char* preprocessToObj( const char* text, int text_len, int flags, HashTable* parserStripList, int* preprocessed_len ) {
	DEFINE_NODE_STRING()
	
	/* The php preprocessors have an array of rules to use,
	 * Those are hardcoded here. Places relying on it are 
	 * marked with a 'Known rules' comment.
	 */
	#define BraceRuleMin 2
	#define BraceRuleMax 3
	#define BracketRuleMin 2
	#define BracketRuleMax 2
	
	bool forInclusion = flags & PTD_FOR_INCLUSION;
	 
	bool enableOnlyinclude = false;
	enum internalTags ignoredElement; /* Act as this tag isn't there */
	
	/* Instead of $xmlishRegex, we use directly the stripList.
	 * As it is shared with Parser, includeonly/onlyinclude/noinclude are handled separatedly.
	 * Per Parser::set{FunctionTag,}Hook(), the items are all strings and lowercase.
	 */
	int longestTagLen = array_max_strlen( parserStripList );
	if ( longestTagLen == -1 ) {
		*preprocessed_len = 1;
		return NULL;
	}
	if ( longestTagLen < strsize( "onlyinclude" ) ) {
		longestTagLen = strsize( "onlyinclude" );
	}
		
	if ( forInclusion ) {
		/* $ignoredTags = array( 'includeonly', '/includeonly' ); */
		ignoredElement = noinclude;
		if ( strpos( text, text_len, "<onlyinclude>", 13, 0 ) != -1 && strpos( text, text_len, "</onlyinclude>", 14, 0 ) != -1 ) {
			enableOnlyinclude = true;
		}
	} else {
		/* $ignoredTags = array( 'noinclude', '/noinclude', 'onlyinclude', '/onlyinclude' ); */
		ignoredElement = includeonly;
	}
	#define isIgnoredTag(internalTag) (forInclusion ? ((internalTag) == includeonly) : ((internalTag) > includeonly) )	

	int i = 0;
	char * lowername = NULL;
	bool findEquals = false;            // True to find equals signs in arguments
	bool findPipe = false;              // True to take notice of pipe characters
	int headingIndex = 1;
	bool inHeading = false;        // True if $i is inside a possible heading
	bool noMoreGT = false;         // True if there are no more greater-than (>) signs right of $i
	bool findOnlyinclude = enableOnlyinclude; // True to ignore all input up to the next <onlyinclude>
	bool fakeLineStart = true;     // Do a line-start run without outputting an LF character
	bool fakePipeFound = false;
	char currentClosing = '\0';
	int lineStartPos = -1;
	char search[sizeof(MAX_SEARCH_CHARS)];
	
	#define getFlags() \
		inHeading = (parentNode->type == heading_node); \
		findPipe = (parentNode->type != heading_node) && (parentNode->type != bracket_node) && (parentNode->type != root_node); \
		findEquals = findPipe && ( parentNode->nextSibling > 0 ) && ( parentNode->type != value_node );
	
	while ( true ) {
		
		if ( findOnlyinclude ) {
			// Ignore all input up to the next <onlyinclude>
			int startPos = strpos( text, text_len, "<onlyinclude>", 13, i );
			if ( startPos == -1 ) {
				// Ignored section runs to the end
				addNodeWithText(ignore_node, text, i, -1);
				break;
			}
			int tagEndPos = startPos + strsize( "<onlyinclude>" ); // past-the-end
			addNodeWithText(ignore_node, text, i, tagEndPos - i);
			i = tagEndPos;
			findOnlyinclude = false;
		}

		enum foundTypes found = -1;
		if ( fakeLineStart ) {
			found = lineStart;
		} else if ( fakePipeFound ) {
			found = pipe;
		} else {
			// Find next opening brace, closing brace or pipe
			searchReset();
			if ( parentNode->type == root_node ) {
				currentClosing = 0;
			} else {
				/* This is too ugly */
				if ( parentNode->type == heading_node ) {
					currentClosing = '\n';
				} else if ( parentNode->type == '[' ) {
					currentClosing = ']'; /* Known rules */
				} else if ( parentNode->parent && ( parentNode->parent->type == '{' 
					|| ( parentNode->parent->parent && parentNode->parent->parent->type == '{' ) ) ) {
						currentClosing = '}'; /* Known rules */
				 } else {
					 currentClosing = 0;
				 }
				addSearch( currentClosing );
			}
			if ( findPipe ) {
				addSearch( '|' );
			}
			if ( findEquals ) {
				// First equals will be for the template
				addSearch( '=' );
			}

			// Output literal section, advance input counter
			size_t literalLength = mwpp_strcspn( text, text_len, search, i );
			if ( literalLength > 0 ) {
				addLiteral( text, i, (int)literalLength );
				i += literalLength;
			}
			if ( i >= text_len ) {
				if ( currentClosing == '\n' ) {
					// Do a past-the-end run to finish off the heading
					found = lineEnd;
				} else if ( parentNode->type == name_node && parentNode->parent && parentNode->parent->type == part_node && findEquals ) {
					// Convert this part\name into a value and add the name
					fakePipeFound = true;
					found = pipe;
				} else {
					// All done
					break;
				}
			} else {
				switch ( text[i] ) {
					case '|':
					case '=':
					case '<':
						found = text[i];
						break;
					case '\n':
						if ( inHeading ) {
							found = lineEnd;
						} else {
							found = lineStart;
						}
						break;
					case '}': /* Known rules */
					case ']':
						if ( text[i] == currentClosing ) {
							found = currentClosing;
						}
						break;
					case '{': /* Known rules */
					case '[':
						found = text[i];
						break;
					
					default:
						// Some versions of PHP have a strcspn which stops on null characters {{refneeded}}
						// Ignore and continue
						++i;
						continue;
				}
			}
		}

		if ( found == angle ) {
			// Determine which tag is this
			if ( enableOnlyinclude && strncasecmp( text + i, "</onlyinclude>", strsize( "</onlyinclude>" ) ) ) {
				findOnlyinclude = true;
				continue;
			}
			
			// Handle comments
			if ( !strncmp( text + i, "<!--", 4 ) ) {
				// To avoid leaving blank lines, when a comment is both preceded
				// and followed by a newline (ignoring spaces), trim leading and
				// trailing spaces and one of the newlines.

				// Find the end
				int endPos = strpos( text, text_len, "-->", 3, i + 4 );
				if ( endPos == -1 ) {
					// Unclosed comment in input, runs to end
					addNodeWithText(comment_node, text, i, -1);
					i = text_len;
				} else {
					// Search backwards for leading whitespace

					int wsStart;
					for (wsStart = i - 1; wsStart > 0; wsStart--) {
						if ( text[wsStart] != ' ' ) { /* It can't go over wikitext_len because the php string has a \0 terminator, too */
							wsStart++;
							break;
						}
					}

					// Search forwards for trailing whitespace
					// wsEnd will be the position of the last space (or the > if there's none)
					int startPos, wsEnd = endPos + 3; 
					while (text[wsEnd] == ' ') { wsEnd++; }
					wsEnd--; // A bit silly since we will be using wsEnd+1 everywhere, but we want to keep this the same as $wsEnd
					
					// Eat the line if possible
					// This could theoretically be done if $wsStart == 0, i.e. for comments at
					// the overall start. That's not how Sanitizer::removeHTMLcomments() did it, but
					// it's a possible beneficial b/c break.
					if ( wsStart > 0 && text[wsStart - 1] == '\n' && text[wsEnd + 1] == '\n' )
					{
						startPos = wsStart;
						endPos = wsEnd + 1;
						// Remove leading whitespace from the end of the accumulator
						// Sanity check first though
						int wsLength = i - wsStart;
						if ( wsLength > 0 && currentLiteral.len >= wsLength ) {
							if ( strspn( text + currentLiteral.from + currentLiteral.len - wsLength, " " ) != wsLength ) {
								// Can this ever be false?
								assert(0);
							}
							currentLiteral.len -= wsLength;
						}
						// Do a line-start run next time to look for headings after the comment
						fakeLineStart = true;
					} else {
						// No line to eat, just take the comment itself
						startPos = i;
						endPos += 2;
					}

					if ( parentNode ) {
						if ( parentNode->commentEnd != -1 && parentNode->commentEnd == wsStart - 1 ) {
							
						} else {
							parentNode->visualEnd = wsStart - 1;
						}
						// Else comments abutting, no change in visual end
						parentNode->commentEnd = endPos;
					}
					i = endPos + 1;
					addNodeWithText(comment_node, text, startPos, endPos - startPos + 1);
				}
				continue;
			}
			
			if ( noMoreGT ) {
				addLiteral( text, i, 1 );
				++i;
				continue;
			}
			
			/**
			 * The identifyTag() function performs everything the $xmlishRegex would have done.
			 */
			if ( !lowername ) {
				lowername = emalloc( longestTagLen + 2 );
			}
			assert(text[i] == '<');
			enum internalTags internalTag;
			const char* name = text + i + 1;
			int name_len;

			name_len = identifyTag(name, text_len - i - 1, parserStripList, &internalTag, lowername);
			if ( name_len == -1 ) {	/* Does it make sense to allow 0-length tags? */
				addLiteral( text, i, 1 );
				i++;
				continue;
			}
			
			int attrStart = i + name_len + 1;
			
			// Find end of tag
			char* end = memchr(name + name_len, '>', text_len - i - 1);
			int tagEndPos = end ? end - text : -1;

			if ( tagEndPos == -1 ) {
				// Infinite backtrack
				// Disable tag search to prevent worst-case O(N^2) performance
				noMoreGT = true;
				addLiteral( text, i, 1 );
				++i;
				continue;
			}
			assert(text[tagEndPos] == '>');

			// Handle ignored tags
			if ( isIgnoredTag( internalTag ) ) {
				addNodeWithText( ignore_node,  text, i, tagEndPos - i + 1 );
				i = tagEndPos + 1;
				continue;
			}
			
			int tagStartPos, attrEnd, endTagBegin, endTagLen;
			int innerTextBegin, innerTextLen;
			tagStartPos = i; endTagLen = 0;
			innerTextBegin = -1; innerTextLen = -1;
			endTagBegin = 42; /* Disable warning. This variable is only used when endTagLen != 0 */
			
			if ( text[tagEndPos-1] == '/' ) {
				attrEnd = tagEndPos - 1;
				i = tagEndPos + 1;
			} else {
				attrEnd = tagEndPos;
				// Find closing tag
				
				endTagBegin = findEndTag( text, text_len, tagEndPos + 1, lowername, name_len, &endTagLen );
				
				if ( endTagBegin != -1 ) 
				{
					innerTextBegin = tagEndPos + 1;
					innerTextLen = endTagBegin - tagEndPos - 1;
					i = endTagBegin + endTagLen;
				} else {
					// No end tag -- let it run out to the end of the text.
					innerTextBegin = tagEndPos + 1;
					i = text_len;
				}
			}
			
			if ( isIgnoredTag( internalTag ) ) {
				addNodeWithText(ignore_node, text, tagStartPos, i - tagStartPos );
				continue;
			}
			
			addNodeWithTags( ext_node, 1 );	/* The '<' is implicit in Preprocessor_DOM */
			addNodeWithText( name_node, text, tagStartPos + 1, name_len );
			
			// Note that the attr element contains the whitespace between name and attribute,
			// this is necessary for precise reconstruction during pre-save transform.
			assert(attrEnd >= attrStart);
			addNodeWithText( attr_node, text, attrStart, attrEnd - attrStart );
			addNodeWithText( end_name_node, text, attrEnd, tagEndPos - attrEnd + 1 );

			if ( innerTextBegin != -1 ) {
				addNodeWithText( inner_node, text, innerTextBegin, innerTextLen );
			}
			if ( endTagLen ) {
				addNodeWithText( close_node, text, endTagBegin, endTagLen );
			}
			closeNode( ext_node );
		}
		else if ( found == lineStart ) {
			// Is this the start of a heading?
			// Line break belongs before the heading element in any case
			if ( fakeLineStart ) {
				fakeLineStart = false;
			} else {
				addLiteral( text, i, 1 );
				i++;
			}

			int count = chrspn( text, '=', i, 6 );
			if ( count == 1 && findEquals ) {
				// DWIM: This looks kind of like a name/value separator
				// Let's let the equals handler have it and break the potential heading
				// This is heuristic, but AFAICT the methods for completely correct disambiguation are very complex.
			} else if ( count > 0 ) {
				/*
				piece = array(
					'open' => "\n",
					'close' => "\n",
					'parts' => array( new PPDPart( str_repeat( '=', $count ) ) ),
					'startPos' => $i,
					'count' => $count );
				*/
				lineStartPos = i; /* This lived in the stack in php, but there can't be two open header pieces */
				addNodeWithTags(heading_node, count);
				currentClosing = '\n';
				/* extract(  $stack->getFlags(); ) */
				getFlags()
				i += count;
			}
		} else if ( found == lineEnd ) {

			// A heading must be open, otherwise \n wouldn't have been in the search list
			assert( parentNode->type == heading_node );
			assert( lineStartPos != -1 );
			
			// Search back through the input to see if it has a proper close
			// Do this using the reversed string since the other solutions (end anchor, etc.) are inefficient
			int searchStart;
			for (searchStart = i - 1; searchStart > 0; --searchStart) {
				if ( ( text[searchStart] != ' ' ) && ( text[searchStart] != '\t' ) ) {
					break;
				}
			}
			
			if ( parentNode->commentEnd != -1 && searchStart == parentNode->commentEnd ) {
				// Comment found at line end
				// Search for equals signs before the comment
				for (searchStart = parentNode->visualEnd; searchStart > 0; --searchStart) {
					if (text[searchStart] != ' ' && text[searchStart] != '\t')
						break;
				}
			}
			searchStart++;
			
			int count = parentNode->contentLength;
			int equalsLength = chrrspn( text, '=', searchStart - 1 );
			
			if ( equalsLength > 0 ) {
				if ( searchStart - equalsLength == lineStartPos ) {
					// This is just a single string of equals signs on its own line
					// Replicate the doHeadings behaviour /={count}(.+)={count}/
					// First find out how many equals signs there really are (don't stop at 6)
					count = equalsLength;
					if ( count < 3 ) {
						count = 0;
					} else {
						count = min( 6, ( count - 1 ) / 2 );
					}
				} else {
					count = min( equalsLength, count );
				}
				if ( count > 0 ) {
					// Normal match, output <h>
					assert( count < 7 );
					parentNode->type = heading_node + count;
					parentNode->flags = headingIndex;
					headingIndex++;
				} else {
					// Single equals sign on its own line, count=0
					parentNode->type = literal_node;
				}
			} else {
				// No match, no <h>, just pass down the inner text
				parentNode->type = literal_node;
			}
			// Unwind the stack
			closeNode( parentNode->type );
			/* extract(  getFlags() ); */
			getFlags();

			// Note that we do NOT increment the input pointer.
			// This is because the closing linebreak could be the opening linebreak of
			// another heading. Infinite loops are avoided because the next iteration MUST
			// hit the heading open case above, which unconditionally increments the
			// input pointer.
			assert( inHeading == false );
		} else if ( found == openBrace || found == openBracket ) {
			// count opening brace characters
			int count = chrspn( text, text[i], i, text_len - i );

			// we need to add to stack only if opening brace count is enough for one of the rules
			int rulemin = 2; /* Known rules */
			
			if ( count >= rulemin ) {
				// Add it to the stack
				addNodeWithTags( found, count );
				parentNode->flags = (i > 0 && text[i-1] == '\n') /* lineStart boolean */;
				/* close char does not need to be stored per Known rules */
				parentNode->count = count;
				parentNode->argIndex = 0;
				if ( found == openBrace ) {
					addNodeWithTags( title_node, 0 );
				}
				getFlags();
			} else {
				// Add literal brace(s)
				addLiteral( text, i, count );
			}
			i += count;
		} else if ( found == closeBrace || found == closeBracket ) {
			// lets check if there are enough characters for closing brace
			
			assert( ( parentNode->type == found - 2 ) || 
				( parentNode->parent && 
				( ( parentNode->parent->type == found - 2 ) || 
				( ( parentNode->type == value_node || parentNode->type == name_node ) &&
					parentNode->parent->parent && ( parentNode->parent->parent->type == found - 2 ) ) ) ) );
			
			int maxCount;
			if ( found == closeBracket ) {
				maxCount = parentNode->count;
			} else {
				if ( parentNode->type == value_node || parentNode->type == name_node ) {
					/* template\part\value or template\part\name */
					maxCount = parentNode->parent->parent->count;
					assert( parentNode->parent->parent->type == brace_node );
				} else {
					/* template\title */
					assert( parentNode->type == title_node );

					maxCount = parentNode->parent->count;
					assert( parentNode->parent->type == brace_node );
				}
				assert( maxCount );
			}
			int count = chrspn( text, found, i, maxCount );

			// check for maximum matching characters (if there are 5 closing
			// characters, we will probably need only 3 - depending on the rules)
			int ruleMax = ( found == closeBrace ) ? 3 : 2; /* Known rules */
			int matchingCount = 0;
			if ( count > ruleMax ) {
				// The specified maximum exists in the callback array, unless the caller
				// has made an error
				matchingCount = ruleMax;
			} else {
				// Count is less than the maximum
				// Skip any gaps in the callback array to find the true largest match

				/* Known rules: If we have three opening braces but only two closing ones, we want the two.
				 * With less than the minimum, matchingCount = 0.
				 */
				 if ( count >= 2 /* min */ ) { /* Known rules */
					 matchingCount = count;
				 }
			}
			
			if ( matchingCount <= 0 ) {
				// No matching element found in callback array
				// Output a literal closing brace and continue
				assert( count == 1 );
				addLiteral( text, i, count );
				i += count;
				continue;
			}
			
			if ( parentNode->type == name_node ) {
				/* Go to close it */
				fakePipeFound = true;
				continue;
			}
			
			if ( parentNode->type == value_node ) {
				printf("%c in parent %c. Closing\n", found, parentNode->type);
				closeNode( parentNode->type );
				assert( parentNode->type == part_node );
			}

			if ( found == closeBracket ) { /* Known rules */
				// No element, just literal text
				parentNode->count -= matchingCount;

				/* The preprocessor DOM adds a new literal here, then goes 
				 * backwards and readds another node before if there are 
				 * brackets left.
				 * We leave the same bracket node open (with decreasing counts)
				 * until closing time, since we know that all brackets 
				 * will end up being literals.
				 */
				
				if ( parentNode->count < 2 ) { /* Known rules */
					parentNode = breakSyntax( parentNode, nodeString, &nodeStringLen );
				}

				addLiteral( text, i, matchingCount );
				i += matchingCount;
				getFlags();
				continue;
			}
			assert( ( parentNode->parent && ( parentNode->parent->type == brace_node ) ) );
			
			assert( parentNode->type == title_node || parentNode->type == part_node );
			closeNode( parentNode->type );
			
			addNodeWithText( closebrace_node, text, i, matchingCount ); // should be on next line?
			// Advance input pointer
			i += matchingCount;
			
			parentNode->count -= matchingCount;
			
			if ( matchingCount == 2 ) {
				parentNode->type = template_node;
			} else if ( matchingCount == 3 ) {
				parentNode->type = tplarg_node;
			} else {
				assert( 0 );
			}
			parentNode->contentLength = matchingCount;
			
			// Re-add the old stack element if it still has unmatched opening characters remaining
			if ( parentNode->count > 0 ) {
				int oldindex = parentNode->index;
				
				// do we still qualify for any callback with remaining count?
				if ( parentNode->count >= 2 ) { /* Known rules */
					/* Prepend a { and a title node */
					int oldcount = parentNode->count;
					int oldflags = parentNode->flags;
					
					parentNode->flags = 0; /* We don't begin a line since there is markup before us */
					
					closeNode( parentNode->type );
					storedLength -= oldcount;
					
					addNodeWithTags( brace_node, oldcount );
					addNodeWithTags( title_node, 0 );
					
					/* But they must be placed *before* the tag we just closed: */
					
					/* Move all our childs two positions right */
					memmove( nodeString + oldindex + NODE_LEN * 2, nodeString + oldindex, nodeStringLen - oldindex - 2 * NODE_LEN );

					/* And the new tags into the positions left */
					parentNode->index = oldindex + NODE_LEN;
					parentNode->parent->index = oldindex;
					parentNode->parent->flags = oldflags;
					parentNode->parent->count = oldcount;
				} else {
					/* Prepend a literal node with the skipped braces */
					int skippedBraces = 1 /* = parentNode->count */;
					parentNode->flags = 0; /* We are prepending literals, so this can no longer be a lineStart */
					closeNode( parentNode->type );
					
					struct node tmpnode;
					tmpnode.type = literal_node;
					tmpnode.flags = 0;
					tmpnode.nextSibling = 0;
					tmpnode.contentLength = skippedBraces;
					
					ALLOC_NODESTRING();
					memmove( nodeString + oldindex + NODE_LEN, nodeString + oldindex, nodeStringLen - oldindex );
					nodeStringLen += NODE_LEN;

					serializeNode(nodeString + oldindex, &tmpnode);
				}
			} else {
				closeNode( parentNode->type );
			}

			getFlags();
		} else if ( found == pipe ) {
			findEquals = true; // shortcut for getFlags()
			if ( parentNode->type == title_node ) {
				closeNode( title_node );
			} else if ( parentNode->type == name_node ) {
				assert( ( parentNode->parent && ( parentNode->parent->type == part_node ) ) );
				assert( ( parentNode->parent->parent && ( parentNode->parent->parent->type == brace_node ) ) );
				
				/* This was a value node, the name is empty */
				parentNode->type = value_node;
				int len = parentNode->contentLength;
				parentNode->contentLength = 0;
				int oldindex = parentNode->index;
				
				/* Relocate the children one position right */
				ALLOC_NODESTRING();
				memmove( nodeString + oldindex + NODE_LEN * 2, nodeString + oldindex + NODE_LEN, nodeStringLen - oldindex - NODE_LEN ); /* (nodeStringLen - oldindex) will often be 0 */
				nodeStringLen += NODE_LEN;
				/* And the father, too */
				parentNode->index += NODE_LEN;
				
				/* Place the name */
				struct node tmpnode;
				tmpnode.type = name_node;
				tmpnode.flags = parentNode->parent->flags = ++parentNode->parent->parent->argIndex;
				tmpnode.nextSibling = 0;
				tmpnode.contentLength = len;
				assert( len == 0 );
				
				serializeNode(nodeString + oldindex, &tmpnode);
				
				if ( !fakePipeFound ) {
					// In a fake pipe run, we want to keep the value node 
					// open in case there are literals to put inside left.
					// The value node can be closed by the caller if needed.
					closeNode( value_node );
					
					closeNode( part_node );
				}
			} else {
				closeNode( value_node );
				closeNode( part_node );
			}
			if ( fakePipeFound ) {
				fakePipeFound = false;
				continue;
			}
			addNodeWithTags( part_node, 1 );
			addNodeWithTags( name_node, 0 );
			++i;
		} else if ( found == equals ) {
			findEquals = false; // shortcut for getFlags()
			assert( parentNode->type == name_node ); /* If we are searching for an equal we are inside parts\name */
			closeNode( name_node );			
			addLiteral( text, i, 1 );
			addNodeWithTags( value_node, 0 ); /* We could piggyback some literals on value_nodes */
			
			//parentNode->eqpos = i; // we could remove eqpost member
			++i;
		} else {
			assert( 2 + 2 == 5 );
		}
	}
	while ( parentNode ) {
		if ( parentNode->type == brace_node || parentNode->type == bracket_node ) {
			parentNode = breakSyntax( parentNode, nodeString, &nodeStringLen );
		} else {
			closeNode( parentNode->type );
		}
	}
	
	if ( lowername ) { // No reason to TSRMLS_FETCH() if we didn't allocate anything
		efree( lowername );
	}
	
	nodeString[nodeStringLen] = '\0';
	*preprocessed_len = nodeStringLen;
	return nodeString;
}
