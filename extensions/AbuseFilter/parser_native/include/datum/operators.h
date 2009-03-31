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

#ifndef DATUM_OPERATORS_H
#define DATUM_OPERATORS_H

#include	"datum/visitors.h"
#include	"functors.h"

namespace afp {

namespace datum_impl {


template<typename T>
struct afpless {
	template<typename U>
	bool operator() (T a, U b) const {
		return a < b;
	}

	bool operator() (T, boost::posix_time::ptime const &) const {
		throw type_error("operator < not applicable to these types");
	}
		
	bool operator() (boost::posix_time::ptime const &, T) const {
		throw type_error("operator < not applicable to these types");
	}

	bool operator() (T, boost::posix_time::time_duration const &) const {
		throw type_error("operator < not applicable to these types");
	}

	bool operator() (boost::posix_time::time_duration const &, T) const {
		throw type_error("operator < not applicable to these types");
	}
};

template<>
struct afpless<boost::posix_time::ptime> {
	template<typename U>
	bool operator() (boost::posix_time::ptime const &, U const &b) const {
		throw type_error("operator < not applicable to these types");
	}

	bool operator() (boost::posix_time::ptime const &a, boost::posix_time::ptime const &b) const {
		return a < b;
	}
};

template<>
struct afpless<boost::posix_time::time_duration> {
	template<typename U>
	bool operator() (boost::posix_time::time_duration const &, U const &b) const {
		throw type_error("operator < not applicable to these types");
	}

	bool operator() (boost::posix_time::time_duration const &a, boost::posix_time::time_duration const &b) const {
		return a < b;
	}
};

} // namespace datum_impl

template<typename charT>
basic_datum<charT> operator+(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
basic_datum<charT> operator-(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
basic_datum<charT> operator*(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
basic_datum<charT> operator/(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
basic_datum<charT> operator%(basic_datum<charT> const &a, basic_datum<charT> const &b);

template<typename charT>
bool operator==(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
bool operator!=(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
bool operator<(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
bool operator>(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
bool operator<=(basic_datum<charT> const &a, basic_datum<charT> const &b);
template<typename charT>
bool operator>=(basic_datum<charT> const &a, basic_datum<charT> const &b);

template<typename charT>
basic_datum<charT> pow(basic_datum<charT> const &a, basic_datum<charT> const &b);

template<typename charT, typename char_type, typename traits>
std::basic_ostream<char_type, traits> &
operator<<(std::basic_ostream<char_type, traits> &s, basic_datum<charT> const &d) {
	d.print_to(s);
	return s;
}

template<typename charT>
basic_datum<charT> & 
basic_datum<charT>::operator= (basic_datum<charT> const &other) {
	value_ = other.value_;
	return *this;
}

template<typename charT>
basic_datum<charT> &
basic_datum<charT>::operator+=(basic_datum<charT> const &other)
{
	/*
	 * If either argument is a string, convert both to string.  After discussion
	 * on #mediawiki, this seems to be the least confusing option.
	 */
	if (value_.which() == 1 || other.value_.which() == 1) {
		value_ = toString() + other.toString();
		return *this;
	}

	basic_datum<charT> result = boost::apply_visitor(
			datum_impl::arith_visitor<charT, functor::plus>(), value_, other.value_);
	*this = result;
	return *this;
}

template<typename charT>
basic_datum<charT> &
basic_datum<charT>::operator-=(basic_datum<charT> const &other)
{
	basic_datum<charT> result = boost::apply_visitor(
			datum_impl::arith_visitor<charT, functor::minus>(), value_, other.value_);
	*this = result;
	return *this;
}

template<typename charT>
basic_datum<charT> &
basic_datum<charT>::operator*=(basic_datum<charT> const &other)
{
	basic_datum<charT> result = boost::apply_visitor(
			datum_impl::arith_visitor<charT, functor::multiply>(), value_, other.value_);
	*this = result;
	return *this;
}
	
template<typename charT>
basic_datum<charT>&
basic_datum<charT>::operator/=(basic_datum<charT> const &other)
{
	basic_datum<charT> result = boost::apply_visitor(
			datum_impl::arith_visitor<charT, functor::divide>(), value_, other.value_);
	*this = result;
	return *this;
}

template<typename charT>
basic_datum<charT>&
basic_datum<charT>::operator%=(basic_datum<charT> const &other)
{
	basic_datum<charT> result = boost::apply_visitor(
			datum_impl::arith_visitor<charT, functor::modulus>(), value_, other.value_);
	*this = result;
	return *this;
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::operator+() const
{
	return *this;
}

template<typename charT>
basic_datum<charT>
basic_datum<charT>::operator-() const
{
	return boost::apply_visitor(datum_impl::unary_arith_visitor<charT, functor::negate>(), value_);
}

template<typename charT>
basic_datum<charT>
operator+(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return basic_datum<charT>(a) += b;
}

template<typename charT>
basic_datum<charT>
operator-(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return basic_datum<charT>(a) -= b;
}

template<typename charT>
basic_datum<charT>
operator*(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return basic_datum<charT>(a) *= b;
}

template<typename charT>
basic_datum<charT>
operator/(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return basic_datum<charT>(a) /= b;
}

template<typename charT>
basic_datum<charT>
operator%(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return basic_datum<charT>(a) %= b;
}

template<typename charT>
basic_datum<charT>
pow(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	mpf_t res;
	mpf_init(res);
	mpf_pow_ui(res, a.toFloat().get_mpf_t(), 
			b.toInt().get_ui());
	basic_datum<charT> result = basic_datum<charT>::from_double(
			mpf_class(res));
	mpf_clear(res);
	return result;
}

template<typename charT>
bool
operator==(basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return a.compare(b);
}

template<typename charT>
bool
operator< (basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return a.less_than(b);
}

template<typename charT>
bool
operator<= (basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return a.less_than(b) || a == b;
}

template<typename charT>
bool
operator> (basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return !(a <= b);
}

template<typename charT>
bool
operator>= (basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return !(a < b);
}

template<typename charT>
bool
operator!= (basic_datum<charT> const &a, basic_datum<charT> const &b) {
	return !(a == b);
}

template<typename charT>
bool
basic_datum<charT>::operator! () const {
	return !toBool();
}

} // namespace afp

#endif	/* !DATUM_OPERATORS_H */
