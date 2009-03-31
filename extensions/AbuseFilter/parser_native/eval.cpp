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

#include <cstdlib>
#include <iostream>
#include <string>

#include "filter_evaluator.h"
#include "request.h"

int main(int argc, char** argv)
{
	afp::request r;	
	std::string result;
	
	try {
		if (!r.load(std::cin))
			return 1;
			
		result = r.evaluate();
	} catch (afp::exception &excep) {
		std::cout << "EXCEPTION: " << excep.what() << std::endl;
		std::cerr << "EXCEPTION: " << excep.what() << std::endl;
	}
	
	std::cout << result << "\0";
}
