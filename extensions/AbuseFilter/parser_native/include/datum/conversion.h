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

#ifndef DATUM_CONVERSION_H
#define DATUM_CONVERSION_H

#include	"datum/visitors.h"

namespace afp {

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_string_convert(typename basic_datum<charT>::string_t const &var)
{
	// Try integer	
	try {
		return basic_datum<charT>(u32lexical_cast<charT, integer_t>(var));
	} catch (bad_u32lexical_cast &e) {
		try {
			return basic_datum<charT>(u32lexical_cast<charT, float_t>(var));
		} catch (bad_u32lexical_cast &e) {
			/* If it's nothing else, it's a string */
			return basic_datum<charT>(var);
		}
	}
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_string(typename basic_datum<charT>::string_t const &v)
{
	return basic_datum<charT>(v);
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_int(typename basic_datum<charT>::integer_t const &v)
{
	return basic_datum<charT>(v);
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_double(typename basic_datum<charT>::float_t const &v)
{
	return basic_datum<charT>(v);
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_date(typename basic_datum<charT>::datetime_t const &v)
{
	return basic_datum<charT>(v);
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::from_interval(typename basic_datum<charT>::interval_t const &v)
{
	return basic_datum<charT>(v);
}

template<typename charT>
typename basic_datum<charT>::string_t
basic_datum<charT>::toString() const {
	return boost::apply_visitor(datum_impl::to_string_visitor<charT>(), value_);
}

template<typename charT>
typename basic_datum<charT>::integer_t
basic_datum<charT>::toInt() const {
	return boost::apply_visitor(datum_impl::to_int_visitor<charT>(), value_);
}

template<typename charT>
typename basic_datum<charT>::float_t
basic_datum<charT>::toFloat() const {
	return boost::apply_visitor(datum_impl::to_double_visitor<charT>(), value_);
}

} // namespace afp

#endif	/* !DATUM_CONVERSION_H */
