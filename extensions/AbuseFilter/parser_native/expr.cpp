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

#include	<iostream>

#include	"parser.h"
#include	"afstring.h"
#include	"affunctions.h"

template<typename charT>
afp::basic_datum<charT> 
f_add(std::vector<afp::basic_datum<charT> > const &args)
{
	return args[0] + args[1];
}

template<typename charT>
afp::basic_datum<charT> 
f_length(std::vector<afp::basic_datum<charT> > const &args)
{
	return afp::basic_datum<charT>::from_int(args[0].toString().size());
}
int
main(int argc, char **argv)
{
	if (argc != 2) {
		std::cerr << boost::format("usage: %s <expr>\n")
				% argv[0];
		return 1;
	}

	afp::expressor e;

	e.add_variable(make_u32fray("ONE"), afp::u32datum::from_int(1));
	e.add_variable(make_u32fray("TWO"), afp::u32datum::from_int(2));
	e.add_variable(make_u32fray("THREE"), afp::u32datum::from_int(3));
	e.add_function(make_u32fray("add"), f_add<UChar32>);
	e.add_function(make_u32fray("norm"), afp::af_norm<UChar32>);
	e.add_function(make_u32fray("count"), afp::af_count<UChar32>);
	e.add_function(make_u32fray("length"), f_length<UChar32>);

	try {
		std::cout << make_u8fray(e.evaluate(make_u32fray(argv[1])).toString()) << '\n';
	} catch (std::exception &e) {
		std::cout << "parsing failed: " << e.what() << '\n';
	}
}
