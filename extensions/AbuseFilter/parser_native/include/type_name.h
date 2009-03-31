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

#ifndef TYPE_NAME_H
#define TYPE_NAME_H

#include	<boost/date_time.hpp>
#include	<gmpxx.h>

#include	"fray.h"

/*
 * A helper class to provide nicer names for types than the compiler-generated
 * ones, which look like 10__gmp_exprIA1_12__mpz_structS1_E.
 */
namespace afp {

template<typename T>
struct type_name {
	static std::string name() {
		return typeid(T).name();
	}
};

template<>
struct type_name<mpf_class> {
	static std::string name() {
		return "float";
	}
};

template<>
struct type_name<mpz_class> {
	static std::string name() {
		return "integer";
	}
};

template<>
struct type_name<boost::posix_time::ptime> {
	static std::string name() {
		return "datetime";
	}
};

template<>
struct type_name<boost::posix_time::time_duration> {
	static std::string name() {
		return "time_duration";
	}
};

template<>
struct type_name<u32fray> {
	static std::string name() {
		return "string";
	}
};

} // namespace afp

#endif	/* !TYPE_NAME_H */
