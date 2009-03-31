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

#ifndef REQUEST_H
#define REQUEST_H

#include	<string>
#include	<istream>

#include	"filter_evaluator.h"
#include	"afstring.h"

namespace afp {

struct request {
	bool load(std::istream &);
	bool evaluate(void);

private:
	filter_evaluator f;
	u32fray filter;
};

} // namespace afp

#endif	/* !REQUEST_H */
