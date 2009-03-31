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

#ifndef FILTER_EVALUATOR_H
#define FILTER_EVALUATOR_H

#include	<string>
#include	<map>

#include	<unicode/uchar.h>

#include	"aftypes.h"
#include	"parser.h"
#include	"affunctions.h"

namespace afp {

struct filter_evaluator {
	filter_evaluator();

	bool evaluate(u32fray const &filter) const;

	void add_variable(
		u32fray const &key, 
		u32datum const &value);

	void clear_variables();

private:
	expressor e;
};


} // namespace afp

#endif	/* !FILTER_EVALUATOR_H */
