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

/*
 * Generate a test case for af_parser.
 * Usage: maketest <filter> [VAR=value] [VAR=value...]
 */

#include	<cstring>
#include	<iostream>

#include	<boost/format.hpp>

int
main(int argc, char **argv)
{
	char zero = 0;

	if (argc < 2) {
		std::cerr << boost::format("usage: %s <filter> [VAR=value...]") % argv[0];
		return 1;
	}

	std::cout.write(argv[1], std::strlen(argv[1]));
	std::cout.write(&zero, 1);

	argc -= 2;
	argv += 2;

	while (argc) {
		char *s = std::strchr(*argv, '=');
		if (s == NULL) {
			std::cerr << "error: variable with no value: " << *argv << '\n';
			return 1;
		}

		std::cout.write(*argv, s - *argv);
		std::cout.write(&zero, 1);
		*s++ = '\0';
		std::cout.write(s, std::strlen(s));
		std::cout.write(&zero, 1);

		argc--;
		argv++;
	}
	std::cout.write(&zero, 1);
}
