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

#ifndef EQUIV_H
#define EQUIV_H

#include	<map>

#include	<boost/noncopyable.hpp>

namespace afp {

struct equiv_set : boost::noncopyable {
	static equiv_set const &instance();

	int get(int) const;

private:
	equiv_set();

	std::map<int, int> equivs_;
};

} // namespace afp

#endif	/* !EQUIV_H */
