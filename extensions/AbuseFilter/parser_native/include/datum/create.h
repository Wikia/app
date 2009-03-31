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

#ifndef DATUM_CREATE_H
#define DATUM_CREATE_H

namespace afp {

template<typename charT, typename T>
struct create_datum;

template<typename charT>
struct create_datum<charT, typename basic_datum<charT>::integer_t> {
	static basic_datum<charT> create(typename basic_datum<charT>::integer_t const &v) {
		return basic_datum<charT>::from_int(v);
	}
};

template<typename charT>
struct create_datum<charT, typename basic_datum<charT>::float_t> {
	static basic_datum<charT> create(typename basic_datum<charT>::float_t const &v) {
		return basic_datum<charT>::from_double(v);
	}
};

template<typename charT>
struct create_datum<charT, std::string> {
	static basic_datum<charT> create(std::basic_string<charT> const &v) {
		return basic_datum<charT>::from_string(v);
	}
};

template<typename charT>
struct create_datum<charT, basic_fray<charT> > {
	static basic_datum<charT> create(basic_fray<charT> const &v) {
		return basic_datum<charT>::from_string(v);
	}
};

template<typename charT>
struct create_datum<charT, typename basic_datum<charT>::datetime_t> {
	static basic_datum<charT> create(typename basic_datum<charT>::datetime_t const &v) {
		return basic_datum<charT>::from_date(v);
	}
};

template<typename charT>
struct create_datum<charT, typename basic_datum<charT>::interval_t> {
	static basic_datum<charT> create(typename basic_datum<charT>::interval_t const &v) {
		return basic_datum<charT>::from_interval(v);
	}
};

}

#endif	/* !DATUM_CREATE_H */
