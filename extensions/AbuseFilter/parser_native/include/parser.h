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

#ifndef EXPRESSOR_H
#define EXPRESSOR_H

#include	<string>
#include	<vector>
#include	<stdexcept>
#include	<iostream>

#include	<boost/noncopyable.hpp>
#include	<boost/function.hpp>
#include	<boost/spirit/symbols.hpp>

#include	<unicode/uchar.h>

#include	"aftypes.h"
#include	"afstring.h"
#include	"affunctions.h"
#include	"fray.h"
#include	"parserdefs.h"

namespace afp {

struct parser_grammar;

struct expressor : boost::noncopyable {
	typedef boost::function<u32datum (std::vector<u32datum>)> func_t;

	expressor();
	~expressor();

	u32datum evaluate(u32fray const &expr) const;
	void print_xml(std::ostream &strm, u32fray const &expr) const;

	void add_variable(u32fray const &name, u32datum const &value);
	void add_function(u32fray const &name, func_t value);

	void clear();
	void clear_functions();
	void clear_variables();

private:
	parser_state state_;
	parser_grammar *grammar_;
};

} // namespace afp

#endif	/* !EXPRESSOR_H */
