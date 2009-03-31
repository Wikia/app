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

#ifndef AFTYPES_H
#define AFTYPES_H

#include	<string>
#include	<vector>
#include	<iostream>
#include	<sstream>
#include	<ios>
#include	<iostream>
#include	<cassert>
#include	<algorithm>
#include	<cmath>

#include	<boost/lexical_cast.hpp>
#include	<boost/variant.hpp>
#include	<boost/date_time/posix_time/posix_time.hpp>

#include	<unicode/uchar.h>

#include	<gmpxx.h>

#include	"fray.h"

namespace afp {

/*
 *                ABUSEFILTER VARIABLE STORAGE
 *                ============================
 *
 * datum is the AFP variable type.  It is runtime polymorphic, storing objects
 * of string, integer or floating point type.  It provides the usual operator
 * overloads, except that operator>>(istream, datum) is not provided.
 *
 * A datum automatically converts between types as required, using the
 * following rules:
 *
 *   - arithmetic operations convert arguments to doubles if either argument is
 *     a double, otherwise to ints.
 *   - converting a string to a numeric type attempts to parse the string as an
 *     integer.  if this is not possible, the value 0 is used.
 *   - type-blind compare (operator==, compare()) does a lexical comparison if
 *     both arguments are strings, otherwise an arithmetic comparison.
 *   - type-sensitive compare always returns false if the types are different;
 *     otherwise, it is identical to a type-blind compare.
 *   - ordinal comparisons always convert their arguments to arithmetic types,
 *     even if both are strings.
 *
 * Internally, datum is implemented using a boost:variant object.  This is
 * entirely stack-based, avoiding memory allocation overhead when manipulating
 * datum objects.
 */

struct type_error : std::exception {
	std::string what_;
	type_error(std::string const &what) : what_(what) {}
	~type_error() throw() {}
	char const *what(void) const throw() {
		return what_.c_str();
	}
};

template<typename charT>
struct basic_datum {
	typedef basic_fray<charT> string_t;
	typedef mpz_class integer_t;
	typedef mpf_class float_t;
	typedef boost::posix_time::ptime datetime_t;
	typedef boost::posix_time::time_duration interval_t;

	basic_datum();
	basic_datum(basic_datum<charT> const &oldData);
		
	// Type forcing construction functions
	static basic_datum<charT> from_string(string_t const &v);
	static basic_datum<charT> from_string_convert(string_t const &v);
	static basic_datum<charT> from_int(integer_t const &v);
	static basic_datum<charT> from_double(float_t const &v);
	static basic_datum<charT> from_date(datetime_t const &v);
	static basic_datum<charT> from_interval(interval_t const &v);
	
	// Assignment operator
	basic_datum<charT> &operator= (const basic_datum<charT> & other);
		
	basic_datum<charT> &operator+=(basic_datum<charT> const &other);
	basic_datum<charT> &operator-=(basic_datum<charT> const &other);
	basic_datum<charT> &operator*=(basic_datum<charT> const &other);
	basic_datum<charT> &operator/=(basic_datum<charT> const &other);
	basic_datum<charT> &operator%=(basic_datum<charT> const &other);
	bool operator!() const;
	basic_datum<charT> operator+() const;
	basic_datum<charT> operator-() const;

	bool compare(basic_datum<charT> const &other) const;
	bool compare_with_type(basic_datum<charT> const &other) const;
	bool less_than(basic_datum<charT> const &other) const;

	string_t toString() const;
	integer_t toInt() const;
	float_t toFloat() const;
	bool toBool() const {
		return !!toInt().get_si();
	}
		
	template<typename traits>
	void
	print_to(std::basic_ostream<charT, traits> &s) const {
		s << value_;
	}

protected:
	explicit basic_datum(integer_t const &);
	explicit basic_datum(float_t const &);
	explicit basic_datum(string_t const &);
	explicit basic_datum(datetime_t const &);
	explicit basic_datum(interval_t const &);

	typedef boost::variant<
		integer_t, 
		string_t, 
		float_t, 
		datetime_t,
		interval_t> valuetype;
	valuetype value_;
};

class exception : std::exception {
public:
	exception(std::string const &what) 
		: what_(what) {}
	~exception() throw() {}

	char const *what() const throw() {
		return what_.c_str();
	}

private:
	std::string what_;
};

}

#include	"datum/create.h"
#include	"datum/conversion.h"
#include	"datum/operators.h"

namespace afp {

template<typename charT>
basic_datum<charT>::basic_datum() {
}

template<typename charT>
basic_datum<charT>::basic_datum(basic_datum<charT> const &other)
	: value_(other.value_)
{
}

template<typename charT>
basic_datum<charT>::basic_datum(integer_t const &i)
	: value_(i)
{
}

template<typename charT>
basic_datum<charT>::basic_datum(float_t const &d)
	: value_(d)
{
}

template<typename charT>
basic_datum<charT>::basic_datum(datetime_t const &d)
	: value_(d)
{
}

template<typename charT>
basic_datum<charT>::basic_datum(interval_t const &i)
	: value_(i)
{
}

template<typename charT>
basic_datum<charT>::basic_datum(string_t const &v)
	: value_(v)
{
}

template<typename charT>
bool
basic_datum<charT>::compare(basic_datum<charT> const &other) const {
	return boost::apply_visitor(datum_impl::compare_visitor<charT, functor::equal>(), value_, other.value_);
}

template<typename charT>
bool
basic_datum<charT>::compare_with_type(basic_datum<charT> const &other) const {
	if (value_.which() != other.value_.which())
		return false;

	return boost::apply_visitor(datum_impl::compare_visitor<charT, functor::equal>(), value_, other.value_);
}

template<typename charT>
bool
basic_datum<charT>::less_than(basic_datum<charT> const &other) const {
	return boost::apply_visitor(datum_impl::arith_compare_visitor<charT, functor::less>(), value_, other.value_);
}

typedef basic_datum<char> datum;
typedef basic_datum<UChar32> u32datum;

} // namespace afp

#endif	/* !AFTYPES_H */
