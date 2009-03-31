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

#ifndef FUNCTORS_H
#define FUNCTORS_H

#include	<boost/format.hpp>

#include	"return_type.h"
#include	"type_name.h"

/*
 * Various functors used for datums.  Unlike the standard functor, these are
 * templated on two types, so we can use them on types which are not
 * convertible.
 *
 * For types where an operation cannot be performed, invalid_unary_operator or
 * invalid_binary_operator is used to throw an exception at runtime.
 */

namespace afp { namespace functor {

namespace impl {
	/*
	 * These metafunctions determine is an operation can be applied to two
	 * types.  We do this with a set of very generic template operators,
	 * which always have lower priority than a real operator defined for a
	 * type.  If one of those matches (which we determine by checking its
	 * return type), the operation is deemed invalid.
	 */
	struct fail_type {
		char data[1582];
	};

	template<typename T, typename U> fail_type operator+(T, U);
	template<typename T, typename U> fail_type operator-(T, U);
	template<typename T, typename U> fail_type operator*(T, U);
	template<typename T, typename U> fail_type operator/(T, U);
	template<typename T, typename U> fail_type operator%(T, U);
	template<typename T, typename U> fail_type operator==(T, U);
	template<typename T, typename U> fail_type operator!=(T, U);
	template<typename T, typename U> fail_type operator<(T, U);
	template<typename T> fail_type operator-(T);
	template<typename T> fail_type operator!(T);

	template<typename T, typename U>
	struct is_addable { static const bool value = (sizeof(T() + U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_subtractable { static const bool value = (sizeof(T() - U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_multipliable { static const bool value = (sizeof(T() * U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_dividable { static const bool value = (sizeof(T() / U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_modulusable { static const bool value = (sizeof(T() % U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_equality_comparable { static const bool value = (sizeof(T() == U()) != sizeof(fail_type)); };

	template<typename T, typename U>
	struct is_less_than_comparable { static const bool value = (sizeof(T() < U()) < sizeof(fail_type)); };

	template<typename T>
	struct is_invertible { static const bool value = (sizeof(!T())) != sizeof(fail_type); };

	template<typename T>
	struct is_negatable { static const bool value = (sizeof(-T())) != sizeof(fail_type); };
}

template<typename T, typename U, typename R = typename return_type<T, U>::type>
struct invalid_binary_operator {
	char const *opname_;

	invalid_binary_operator(char const *opname) : opname_(opname) {}

	R
	operator() (T, U) const {
		std::string s(str(boost::format(
			"operator %s cannot be applied to the types ('%s', '%s')")
			% opname_ % type_name<T>::name() % type_name<U>::name()));

		throw type_error(s);
	}
};

template<typename T>
struct invalid_unary_operator {
	char const *opname_;

	invalid_unary_operator(char const *opname) : opname_(opname) {}

	T operator() (T) const {
		std::string s(str(boost::format(
			"operator %s cannot be applied to the type '%s'")
			% opname_ % type_name<T>::name()));

		throw type_error(s);
	}
};

template<typename T, typename U, typename Enable = void>
struct plus : invalid_binary_operator<T, U> {
	plus() : invalid_binary_operator<T, U>("+") {}
};

template<typename T, typename U>
struct plus<T, U, typename boost::enable_if<impl::is_addable<T, U> >::type> {
	typename return_type<T, U>::type
	operator() (T const &a, U const &b) const {
		return a + b;
	}
};

template<>
struct plus<boost::posix_time::time_duration, boost::posix_time::time_duration> {
	boost::posix_time::time_duration
	operator() (boost::posix_time::time_duration const &a, boost::posix_time::time_duration const &b) const {
		return a + b;
	}
};

template<>
struct plus<boost::posix_time::ptime, boost::posix_time::time_duration> {
	boost::posix_time::ptime
	operator() (boost::posix_time::ptime const &a, boost::posix_time::time_duration const &b) const {
		return a + b;
	}
};

template<typename T, typename U, typename Enable = void>
struct minus : invalid_binary_operator<T, U> {
	minus() : invalid_binary_operator<T, U>("-") {}
};

template<typename T, typename U>
struct minus<T, U, typename boost::enable_if<impl::is_subtractable<T, U> >::type> {
	typename return_type<T, U>::type
	operator() (T const &a, U const &b) const {
		return a - b;
	}
};

template<>
struct minus<boost::posix_time::ptime, boost::posix_time::ptime> {
	boost::posix_time::time_duration
	operator() (boost::posix_time::ptime const &a, boost::posix_time::ptime const &b) const {
		return a - b;
	}
};

template<typename T, typename U, typename Enable = void>
struct multiply : invalid_binary_operator<T, U> {
	multiply() : invalid_binary_operator<T, U>("*") {}
};

template<typename T, typename U>
struct multiply<T, U, typename boost::enable_if<impl::is_multipliable<T, U> >::type> {
	typename return_type<T, U>::type
	operator() (T const &a, U const &b) const {
		return a * b;
	}
};
template<typename T, typename U, typename Enable = void>
struct divide : invalid_binary_operator<T, U> {
	divide() : invalid_binary_operator<T, U>("/") {}
};

template<typename T, typename U>
struct divide<T, U, typename boost::enable_if<impl::is_dividable<T, U> >::type> {
	typename return_type<T, U>::type
	operator() (T const &a, U const &b) const {
		return a / b;
	}
};
template<typename T, typename U, typename Enable = void>
struct modulus : invalid_binary_operator<T, U> {
	modulus() : invalid_binary_operator<T, U>("%") {}
};

template<typename T, typename U>
struct modulus<T, U, typename boost::enable_if<impl::is_modulusable<T, U> >::type> {
	typename return_type<T, U>::type
	operator() (T const &a, U const &b) const {
		return a % b;
	}
};

template<>
struct modulus<mpf_class, mpf_class> {
	mpf_class operator() (mpf_class const &a, mpf_class const &b) const {
		return std::fmod(a.get_d(), b.get_d());
	}
};

template<>
struct modulus<mpf_class, mpz_class> {
	mpf_class operator() (mpf_class const &a, mpz_class const &b) const {
		return std::fmod(a.get_d(), b.get_si());
	}
};

template<>
struct modulus<mpz_class, mpf_class> {
	mpf_class operator() (mpz_class const &a, mpf_class const &b) const {
		return std::fmod(a.get_d(), b.get_si());
	}
};

template<typename T, typename U, typename Enable = void>
struct less : invalid_binary_operator<T, U, bool> {
	less() : invalid_binary_operator<T, U, bool>("<") {}
};

template<typename T, typename U>
struct less<T, U, typename boost::enable_if<impl::is_less_than_comparable<T, U> >::type> {
	bool
	operator() (T const &a, U const &b) const {
		return a < b;
	}
};

template<>
struct less<boost::posix_time::ptime, boost::posix_time::ptime> {
	bool operator() (boost::posix_time::ptime const &a, boost::posix_time::ptime const &b) {
		return a < b;
	}
};

template<typename T, typename U, typename Enable = void>
struct equal : invalid_binary_operator<T, U, bool> {
	equal() : invalid_binary_operator<T, U, bool>("==") {}
};

template<typename T, typename U>
struct equal<T, U, typename boost::enable_if<impl::is_equality_comparable<T, U> >::type> {
	bool
	operator() (T const &a, U const &b) const {
		return a == b;
	}
};

template<>
struct equal<boost::posix_time::ptime, boost::posix_time::ptime> {
	bool operator() (boost::posix_time::ptime const &a, boost::posix_time::ptime const &b) {
		return a == b;
	}
};

template<typename T, typename Enable = void>
struct negate : invalid_unary_operator<T> {
	negate() : invalid_unary_operator<T>("-") {}
};

template<typename T>
struct negate<T, typename boost::enable_if<impl::is_negatable<T> >::type>
{
	T operator() (T const &v) const {
		return -v;
	}
};

} // namespace functor
} // namespace afp

#endif	/* !FUNCTORS_H */
