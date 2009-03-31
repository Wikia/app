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

int main(int argc, char** argv) {
	afp::filter_evaluator f;
	
	if (argc != 2) {
		std::cerr << "usage: " << argv[0] << " <filter>\n";
		return 1;
	}

	try {
		std::cout << f.evaluate(make_u32fray(argv[1])) << '\n';
	} catch (std::exception &e) {
		std::cerr << "exception: " << e.what() << '\n';
	}
}
