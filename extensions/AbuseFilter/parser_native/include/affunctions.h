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

#ifndef AFFUNCTIONS_H
#define AFFUNCTIONS_H

#include	<map>
#include	<vector>
#include	<algorithm>
#include	<fstream>
#include	<sstream>
#include	<ios>
#include	<iostream>

#include	<unicode/uchar.h>

#include	<boost/format.hpp>
#include	<boost/regex.hpp>
#include	<boost/regex/icu.hpp>

#include	"aftypes.h"
#include	"equiv.h"

namespace afp {

template<typename charT>
int match(charT const *, charT const *);

template<typename charT>
basic_datum<charT> 
af_length (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_ccnorm (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_rmdoubles (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_specialratio (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_rmspecials (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_norm (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_datum<charT> 
af_count (std::vector<basic_datum<charT> > const &args);

template<typename charT> 
basic_fray<charT> 
confusable_character_normalise(basic_fray<charT> const &orig);

template<typename charT> 
basic_fray<charT> 
rmdoubles(basic_fray<charT> const &orig);

template<typename charT> 
basic_fray<charT> 
rmspecials(basic_fray<charT> const &orig);

struct too_many_arguments_exception : afp::exception {
	too_many_arguments_exception(char const *what) 
		: afp::exception(what) {}
};

struct too_few_arguments_exception : afp::exception {
	too_few_arguments_exception(char const *what) 
		: afp::exception(what) {}
};

namespace {

void
check_args(std::string const &fname, int args, int min, int max = 0)
{
	if (max == 0)
		max = min;
	if (args < min) {
		std::string s = str(boost::format(
			"too few arguments for function %s (got %d, expected %d)")
				% fname % args % min);
		throw too_few_arguments_exception(s.c_str());
	} else if (args > max) {
		std::string s = str(boost::format(
			"too many arguments for function %s (got %d, expected %d)")
				% fname % args % min);
		throw too_many_arguments_exception(s.c_str());
	}
}

} // anonymous namespace

template<typename charT>
basic_datum<charT> 
af_count(std::vector<basic_datum<charT> > const &args) {
	check_args("count", args.size(), 1, 2);
	
	basic_fray<charT> needle, haystack;
	
	if (args.size() < 2) {
		needle = make_astring<charT, char>(",");
		haystack = args[0].toString();
	} else {
		needle = args[0].toString();
		haystack = args[1].toString();
	}
	
	size_t last_pos = 0;
	unsigned int count = 0;
	
	while (last_pos != haystack.npos) {
		count++;
		last_pos = haystack.find(needle, last_pos + needle.size());
	}
	
	// One extra was added, but one extra is needed if only one arg was supplied.
	if (args.size() >= 2)
		count--;
	
	return basic_datum<charT>::from_int((long int)count);
}

template<typename charT>
basic_datum<charT>
af_norm(std::vector<basic_datum<charT> > const &args) {
	check_args("norm", args.size(), 1);
	
	basic_fray<charT> orig = args[0].toString();
	
	int lastchr = 0;
	equiv_set const &equivs = equiv_set::instance();
	std::vector<charT> result;
	result.reserve(orig.size());
	
	for (std::size_t i = 0; i < orig.size(); ++i) {
		int chr = equivs.get(orig[i]);
		
		if (chr != lastchr && u_isalnum(chr))
			result.push_back(chr);
		
		lastchr = chr;
	}
	
	return basic_datum<charT>::from_string(basic_fray<charT>(&result[0], result.size()));
}

template<typename charT>
basic_fray<charT>
rmdoubles(basic_fray<charT> const &orig) {
	int lastchr = 0;
	std::vector<charT> result;
	result.reserve(orig.size());
	
	for (std::size_t i = 0; i < orig.size(); ++i) {
		if (orig[i] != lastchr)
			result.push_back(orig[i]);
		
		lastchr = orig[i];
	}
	
	return basic_fray<charT>(&result[0], result.size());
}

template<typename charT>
basic_datum<charT>
af_specialratio(std::vector<basic_datum<charT> > const &args) {
	check_args("specialratio", args.size(), 1);
	
	basic_fray<charT> orig = args[0].toString();
	int len = 0;
	int specialcount = 0;
	
	for (std::size_t i = 0; i < orig.size(); ++i) {
		len++;
		if (!u_isalnum(orig[i]))
			specialcount++;
	}
	
	double ratio = (float)specialcount / len;
		
	return basic_datum<charT>::from_double(ratio);
}

template<typename charT>
basic_datum<charT>
af_rmspecials(std::vector<basic_datum<charT> > const &args) {
	check_args("rmspecials", args.size(), 1);
	return basic_datum<charT>::from_string(rmspecials(args[0].toString()));
}

template<typename charT>
basic_fray<charT> 
rmspecials(basic_fray<charT> const &orig) {
	std::vector<charT> result;
	result.reserve(orig.size());
	
	for (std::size_t i = 0; i < orig.size(); ++i) {
		if (u_isalnum(orig[i]))
			result.push_back(orig[i]);
	}
	
	return basic_fray<charT>(&result[0], result.size());
}

template<typename charT>
basic_datum<charT>
af_ccnorm(std::vector<basic_datum<charT> > const &args) {
	check_args("ccnorm", args.size(), 1);
	return basic_datum<charT>::from_string(confusable_character_normalise(args[0].toString()));
}

template<typename charT>
basic_datum<charT> 
af_rmdoubles(std::vector<basic_datum<charT> > const &args) {
	check_args("ccnorm", args.size(), 1);
	return basic_datum<charT>::from_string(rmdoubles(args[0].toString()));
}

template<typename charT>
basic_datum<charT>
af_length(std::vector<basic_datum<charT> > const &args) {
	check_args("ccnorm", args.size(), 1);
	return basic_datum<charT>::from_int(args[0].toString().size());
}

template<typename charT>
basic_datum<charT>
af_lcase(std::vector<basic_datum<charT> > const &args) {
	check_args("ccnorm", args.size(), 1);
	std::vector<charT> result;
	basic_fray<charT> const orig = args[0].toString();
	result.reserve(orig.size());

	for (std::size_t i = 0; i < orig.size(); ++i)
		result.push_back(u_tolower(orig[i]));

	return basic_datum<charT>::from_string(basic_fray<charT>(&result[0], result.size()));
}

template<typename charT>
basic_fray<charT> 
confusable_character_normalise(basic_fray<charT> const &orig) {
	equiv_set const &equivs = equiv_set::instance();
	std::vector<charT> result;
	result.reserve(orig.size());
	
	for (std::size_t i = 0; i < orig.size(); ++i)
		result.push_back(equivs.get(orig[i]));
	
	return basic_fray<charT>(&result[0], result.size());
}

template<typename charT>
basic_datum<charT>
f_in(basic_datum<charT> const &a, basic_datum<charT> const &b)
{
	basic_fray<charT> sa = a.toString(), sb = b.toString();
	return basic_datum<charT>::from_int(std::search(sb.begin(), sb.end(), sa.begin(), sa.end()) != sb.end());
}

template<typename charT>
basic_datum<charT>
f_like(basic_datum<charT> const &str, basic_datum<charT> const &pattern)
{
	return basic_datum<charT>::from_int(match(pattern.toString().c_str(), str.toString().c_str()));
}

template<typename charT>
basic_datum<charT>
f_regex(basic_datum<charT> const &str, basic_datum<charT> const &pattern)
{
	basic_fray<charT> f = pattern.toString();
	boost::u32regex r = boost::make_u32regex(f.begin(), f.end(),
				boost::regex_constants::perl);
	basic_fray<charT> s = str.toString();
	return basic_datum<charT>::from_int(boost::u32regex_match(
				s.begin(), s.end(), r));
}

template<typename charT>
basic_datum<charT>
f_int(std::vector<basic_datum<charT> > const &args)
{
	check_args("int", args.size(), 1);
	return basic_datum<charT>::from_int(args[0].toInt());
}

template<typename charT>
basic_datum<charT>
f_string(std::vector<basic_datum<charT> > const &args)
{
	check_args("string", args.size(), 1);
	return basic_datum<charT>::from_string(args[0].toString());
}

template<typename charT>
basic_datum<charT>
f_float(std::vector<basic_datum<charT> > const &args)
{
	check_args("float", args.size(), 1);
	return basic_datum<charT>::from_double(args[0].toFloat());
}

/*	$NetBSD: fnmatch.c,v 1.21 2005/12/24 21:11:16 perry Exp $	*/

/*
 * Copyright (c) 1989, 1993, 1994
 *	The Regents of the University of California.  All rights reserved.
 *
 * This code is derived from software contributed to Berkeley by
 * Guido van Rossum.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of the University nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 */

/*
 * Function fnmatch() as specified in POSIX 1003.2-1992, section B.6.
 * Compares a filename or pathname to a pattern.
 */

#include <ctype.h>
#include <string.h>

#define	EOS	'\0'

template<typename charT>
const charT *rangematch(const charT *, int);

template<typename charT>
int
match(charT const *pattern, charT const *string)
{
	const charT *stringstart;
	charT c, test;

	for (stringstart = string;;)
		switch (c = *pattern++) {
		case EOS:
			return (*string == EOS ? 1 : 0);
		case '?':
			if (*string == EOS)
				return (0);
			++string;
			break;
		case '*':
			c = *pattern;
			/* Collapse multiple stars. */
			while (c == '*')
				c = *++pattern;

			/* Optimize for pattern with * at end or before /. */
			if (c == EOS) {
				return (1);
			}

			/* General case, use recursion. */
			while ((test = *string) != EOS) {
				if (match(pattern, string))
					return (1);
				++string;
			}
			return (0);
		case '[':
			if (*string == EOS)
				return (0);
			if ((pattern =
			    rangematch(pattern, *string)) == NULL)
				return (0);
			++string;
			break;
		case '\\':
			if ((c = *pattern++) == EOS) {
				c = '\\';
				--pattern;
			}
			/* FALLTHROUGH */
		default:
			if (c != *string++)
				return (0);
			break;
		}
	/* NOTREACHED */
}

template<typename charT>
const charT *
rangematch(charT const *pattern, int test)
{
	int negate, ok;
	charT c, c2;

	/*
	 * A bracket expression starting with an unquoted circumflex
	 * character produces unspecified results (IEEE 1003.2-1992,
	 * 3.13.2).  This implementation treats it like '!', for
	 * consistency with the regular expression syntax.
	 * J.T. Conklin (conklin@ngai.kaleida.com)
	 */
	if ((negate = (*pattern == '!' || *pattern == '^')) != 0)
		++pattern;
	
	for (ok = 0; (c = *pattern++) != ']';) {
		if (c == '\\')
			c = *pattern++;
		if (c == EOS)
			return (NULL);
		if (*pattern == '-' 
		    && (c2 = (*(pattern+1))) != EOS &&
		        c2 != ']') {
			pattern += 2;
			if (c2 == '\\')
				c2 = *pattern++;
			if (c2 == EOS)
				return (NULL);
			if (c <= test && test <= c2)
				ok = 1;
		} else if (c == test)
			ok = 1;
	}
	return (ok == negate ? NULL : pattern);
}

} // namespace afp

#endif	/* !AFFUNCTIONS_H */
