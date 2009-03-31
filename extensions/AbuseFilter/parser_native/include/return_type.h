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

#ifndef RETURN_TYPE_H
#define RETURN_TYPE_H

namespace afp { namespace functor {

template<typename T, typename U>
struct return_type {
	typedef T type;
};

/*
 * mpf_class
 */
template<>
struct return_type<mpf_class, boost::posix_time::time_duration> {
	typedef boost::posix_time::time_duration type;
};

template<>
struct return_type<mpf_class, u32fray> {
	typedef u32fray type;
};

/*
 * mpz_class
 */
template<>
struct return_type<mpz_class, mpf_class> {
	typedef mpf_class type;
};

template<>
struct return_type<mpz_class, boost::posix_time::time_duration> {
	typedef boost::posix_time::time_duration type;
};

template<>
struct return_type<mpz_class, u32fray> {
	typedef u32fray type;
};

/*
 * u32fray
 */
template<>
struct return_type<u32fray, u32fray> {
	typedef u32fray type;
};

template<>
struct return_type<u32fray, mpf_class> {
	typedef u32fray type;
};

template<>
struct return_type<u32fray, mpz_class> {
	typedef u32fray type;
};

/*
 * time_duration
 */
template<>
struct return_type<boost::posix_time::time_duration, boost::posix_time::time_duration> {
	typedef boost::posix_time::time_duration type;
};

template<>
struct return_type<boost::posix_time::time_duration, mpf_class> {
	typedef boost::posix_time::time_duration type;
};

template<>
struct return_type<boost::posix_time::time_duration, mpz_class> {
	typedef boost::posix_time::time_duration type;
};

/*
 * ptime
 */
template<>
struct return_type<boost::posix_time::ptime, boost::posix_time::ptime> {
	typedef boost::posix_time::time_duration type;
};

} // namespace afp
} // namespace functor

#endif	/* !RETURN_TYPE_H */
