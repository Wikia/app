#ifndef WORD_H
#define WORD_H

#include <string>
#include <algorithm>
#include "wikidiff2.h"

// a small class to accomodate word-level diffs; basically, a body and an
// optional suffix (the latter consisting of a single whitespace), where
// only the bodies are compared on operator==.
// 
// This class stores iterators pointing to the line string, this is to avoid
// excessive allocation calls. To avoid invalidation, the source string should
// not be changed or destroyed.
class Word {
public:
	typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
	typedef String::const_iterator Iterator;
	
	Iterator bodyStart;
	Iterator bodyEnd;
	Iterator suffixEnd;
	
	/**
	  * The body is the character sequence [bs, be)
	  * The whitespace suffix is the character sequence [be, se)
	  */
	Word(Iterator bs, Iterator be, Iterator se) 
		: bodyStart(bs), bodyEnd(be), suffixEnd(se)
	{}

	bool operator== (const Word &w) const {
		return (bodyEnd - bodyStart == w.bodyEnd - w.bodyStart) 
			&& std::equal(bodyStart, bodyEnd, w.bodyStart);
	}
	bool operator!=(const Word &w) const {
		return !operator==(w);
	}
	bool operator<(const Word &w) const {
		return std::lexicographical_compare(bodyStart, bodyEnd, w.bodyStart, w.bodyEnd);
	}

	// Get the whole word as a string
	String whole() const {
		String w;
		get_whole(w);
		return w;
	}

	// Assign the whole word to a string
	void get_whole(String & w) const {
		// Do it with swap() to avoid a second copy
		String temp(bodyStart, suffixEnd);
		temp.swap(w);
	}

	// Get the body as a string
	operator String() const {
		return String(bodyStart, bodyEnd);
	}
};


#endif
