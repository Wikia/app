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

#include	<cstdlib>
#include	<string>
#include	<sstream>
#include	<iostream>

#include	"filter_evaluator.h"

int main(int argc, char** argv)
{
	std::stringbuf ss( std::ios::in | std::ios::out );
	
	// Fill the stringstream
	std::cin.get(ss,'\x04');
	
	fray filter(ss.str());
	
	try {
		afp::filter_evaluator f;
		f.evaluate(make_u32fray(filter));
	} catch (afp::exception &excep) {
		std::cout << "PARSERR: " << excep.what() << std::endl;
		std::exit(0);
	}
	
	std::cout << "SUCCESS" << std::endl;
}
