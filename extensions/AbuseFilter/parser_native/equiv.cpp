/*
 * Copyright (c) 2008 Andrew Garrett.
 * Copyright (c) 2008 River Tarnell <river@wikimedia.org>
 * Derived from public domain code contributed by Victor Vasiliev.
 *
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or
 * implied warranty.
 */

#include	<fstream>
#include	<string>

#include	<boost/lexical_cast.hpp>

#include	"equiv.h"
#include	"aftypes.h"

#define EQUIVSET_LOC "equivset.txt"

namespace afp {

equiv_set::equiv_set()
{
	// Map of codepoint:codepoint
	
	std::ifstream eqsFile(EQUIVSET_LOC);
		
	if (!eqsFile)
		throw exception( "Unable to open equivalence sets!" );
	
	std::string line;
		
	while (getline(eqsFile, line)) {			
		size_t pos = line.find(':');
			
		if (pos != line.npos) try {
			// We have a codepoint:codepoint thing.
			int actual = boost::lexical_cast<int>(line.substr(0, pos));
			int canonical = boost::lexical_cast<int>(line.substr(pos + 1));
				
			if (actual != 0 && canonical != 0)
				equivs_[actual] = canonical;
		} catch (boost::bad_lexical_cast &) {}
	}
}

int
equiv_set::get(int c) const
{
	std::map<int, int>::const_iterator it;

	if ((it = equivs_.find(c)) == equivs_.end())
		return c;

	return it->second;
}

equiv_set const &
equiv_set::instance()
{
	static equiv_set inst;
	return inst;
}

} // namespace afp

