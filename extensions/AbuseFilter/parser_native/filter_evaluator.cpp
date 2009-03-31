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

#include	"filter_evaluator.h"

namespace afp {

filter_evaluator::filter_evaluator()
{
	e.add_function(make_astring<UChar32, char>("length"), af_length<UChar32>);
	e.add_function(make_astring<UChar32, char>("lcase"), af_lcase<UChar32>);
	e.add_function(make_astring<UChar32, char>("ccnorm"), af_ccnorm<UChar32>);
	e.add_function(make_astring<UChar32, char>("rmdoubles"), af_rmdoubles<UChar32>);
	e.add_function(make_astring<UChar32, char>("specialratio"), af_specialratio<UChar32>);
	e.add_function(make_astring<UChar32, char>("rmspecials"), af_rmspecials<UChar32>);
	e.add_function(make_astring<UChar32, char>("norm"), af_norm<UChar32>);
	e.add_function(make_astring<UChar32, char>("count"), af_count<UChar32>);
}

void
filter_evaluator::clear_variables()
{
	e.clear_variables();
}

bool
filter_evaluator::evaluate(u32fray const &filter) const
{
	try {
		return e.evaluate(filter).toBool();
	} catch (std::exception &e) {
		std::cerr << "can't evaluate filter: " << e.what() << '\n';
		return false;
	}
}

void
filter_evaluator::add_variable(
		u32fray const &key,
		u32datum const &value)
{
	e.add_variable(key, value);
}

} // namespace afp
