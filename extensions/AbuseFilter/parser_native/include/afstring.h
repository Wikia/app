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
#ifndef AFSTRING_H
#define AFSTRING_H

#include	<string>

#include	<unicode/uchar.h>

#include	<boost/regex/pending/unicode_iterator.hpp>

#include	"fray.h"

typedef std::basic_string<UChar32> u32string;
typedef std::basic_istream<UChar32> u32istream;
typedef std::basic_ostream<UChar32> u32ostream;
typedef std::basic_iostream<UChar32> u32iostream;
typedef std::basic_istringstream<UChar32> u32istringstream;
typedef std::basic_ostringstream<UChar32> u32ostringstream;
typedef std::basic_stringstream<UChar32> u32stringstream;
typedef basic_fray<UChar32> u32fray;

template<typename iterator, int i> struct u32_conv_type;

template<typename iterator> struct u32_conv_type<iterator, 1> {
	typedef boost::u8_to_u32_iterator<iterator, UChar32> type;
};

template<typename iterator> struct u32_conv_type<iterator, 2> {
	typedef boost::u16_to_u32_iterator<iterator, UChar32> type;
};

template<typename iterator, int i> struct u8_conv_type;

template<typename iterator> struct u8_conv_type<iterator, 4> {
	typedef boost::u32_to_u8_iterator<iterator, char> type;
};

/*
 * Convert UTF-8 or UTF-16 strings to u32frays.
 */
template<typename charT>
u32fray
make_u32fray(basic_fray<charT> const &v) 
{
	std::vector<UChar32> result;
	result.reserve(v.size() / 3);

	typedef typename u32_conv_type<
			typename basic_fray<charT>::iterator,
			sizeof(charT)>::type conv_type;

	std::copy(conv_type(v.begin()), conv_type(v.end()),
			std::back_inserter(result));

	return u32fray(&result[0], result.size());
}

template<typename charT>
u32fray
make_u32fray(charT const *v)
{
	return make_u32fray(basic_fray<charT>(v));
}

template<typename charT>
fray
make_u8fray(basic_fray<charT> const &v) 
{
	std::vector<char> result;
	result.reserve(v.size() * 4);

	typedef typename u8_conv_type<
			typename basic_fray<charT>::iterator,
			sizeof(charT)>::type conv_type;

	std::copy(conv_type(v.begin()), conv_type(v.end()),
			std::back_inserter(result));

	return fray(&result[0], result.size());
}

template<typename charT>
fray
make_u8fray(charT const *v)
{
	return make_u8fray(basic_fray<charT>(v));
}

template<typename fromT, typename toT>
struct ustring_convertor;

template<>
struct ustring_convertor<char, UChar32> {
	static u32fray convert(fray const &from) {
		return make_u32fray(from);
	}
};

template<>
struct ustring_convertor<char, char> {
	static fray convert(fray const &from) {
		return from;
	}
};

template<typename To, typename From>
basic_fray<To>
make_astring(basic_fray<From> const &from)
{
	return ustring_convertor<From, To>::convert(from);
}

template<typename To, typename From>
basic_fray<To>
make_astring(From const *from)
{
	return make_astring<To>(basic_fray<From>(from));
}

struct bad_u32lexical_cast : std::runtime_error {
	bad_u32lexical_cast() : std::runtime_error(
		"bad_u32lexical_cast: source type could not be interpreted as target") {}
};

template<typename T>
struct u32lexical_cast_type_map {
	typedef T to_type;
	typedef T from_type;

	static T map_from(T const &s) {
		return s;
	}

	static T map_to(T const &s) {
		return s;
	}
};

template<>
struct u32lexical_cast_type_map<u32fray> {
	typedef fray from_type;
	typedef u32fray to_type;

	static from_type map_from(u32fray const &s) {
		return make_u8fray(s);
	}

	static to_type map_to(fray const &s) {
		return make_u32fray(s);
	}
};

template<typename charT, typename To, typename From>
To
u32lexical_cast(From const &f) {
	try {
		return 
			u32lexical_cast_type_map<To>::map_to(
				boost::lexical_cast<typename u32lexical_cast_type_map<To>::from_type>(
					u32lexical_cast_type_map<From>::map_from(f)));
	} catch (boost::bad_lexical_cast &e) {
		throw bad_u32lexical_cast();
	}
}

#endif	/* !AFSTRING_H */
