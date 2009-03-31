/* fray: a refcounted string with cheap substrings				*/
/* Copyright (C) 2006-2008 River Tarnell <river@wikimedia.org>.			*/
/*
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */

/* $Id$ */

#ifndef FRAY_H
#define FRAY_H

#include	<cassert>
#include	<boost/functional/hash/hash.hpp>

/*
 * A fray is a refcounted immutable string providing copy-free (constant time)
 * substrings.  Its interface is the same as std::string where possible;
 * operations which are not possible (e.g. non-const operator[]) are not provided.
 *
 * Although a fray is immutable, a fray object can be rebound to a different
 * fray.  This is not valid:
 *
 *   fray f("test");
 *   f[0] = 'g';
 *
 * But this is:
 *
 *   fray f("test"), g("foo");
 *   f = g;
 *
 * This has the effect of releasing the string held by 'f' and causing it to
 * refer to g instead.
 *
 * Some mutating std::string functions are provided, such as append(); these
 * do NOT modify the fray, but instead return a new fray:
 *
 *    fray foo("foo"), bar("bar");
 *    fray foobar = foo.append(bar);
 *
 * Crude benchmarking suggests that passing a fray by value has no
 * noticable speed penalty compared to passing by const reference.
 */

template<typename ch, typename tr, typename alloc> struct basic_fray;
template<typename ch, typename tr, typename alloc> struct fray_iterator;

namespace fray_impl {

/*
 * A fray is simply a pointer to the fray_root, which stores the original
 * string.  A fray_root is created by a fray constructed from some other
 * string (e.g. an std::string).  The fray_root stores a refcount so the user
 * can delete it when all other users are finished.
 *
 * The string in the fray_root is always nul-terminated, to support c_str()
 * in constant time when the fray refers to the entire root.
 *
 * A fray_root starts with a refcount of 1 (representing the string which
 * created it).
 */
template<typename ch, typename tr, typename allocator>
struct fray_root {
	typedef typename allocator::size_type size_type;

	fray_root(ch const *begin, size_type len);
	fray_root(size_type len);

	~fray_root();

	int ref(void);
	int deref(void);

	int		 _refs;
	ch		*_string, *_end;

	static allocator	 _alloc;
};

} // namespace fray_impl

/*
 * A fray iterator.  Also the const_iterator, since frays are immutable.
 */
template<typename ch, 
	typename traits = std::char_traits<ch>, 
	typename alloc = std::allocator<ch>
>
struct fray_iterator {
	typedef typename alloc::size_type size_type;
	typedef typename alloc::difference_type difference_type;
	typedef ch value_type;
	typedef ch const &reference;
	typedef ch const &const_reference;
	typedef ch const *pointer;
	typedef ch const *const_pointer;
	typedef std::random_access_iterator_tag iterator_category;
	
	fray_iterator()
		: _pos(NULL)
	{
	}

	fray_iterator(ch const *pos) 
		: _pos(pos)
	{
	}

	const_reference operator* (void) const {
		return *_pos;
	}

	fray_iterator &operator++ (void) {
		++_pos;
		return *this;
	}

	fray_iterator operator++ (int) {
	fray_iterator	ret(*this);
		++_pos;
		return ret;
	}

	fray_iterator &operator-- (void) {
		--_pos;
		return *this;
	}

	fray_iterator operator-- (int) {
	fray_iterator	ret(*this);
		--_pos;
		return ret;
	}
	
	bool operator< (fray_iterator const &other) const {
		return _pos < other._pos;
	}

	bool operator== (fray_iterator const &other) const {
		return _pos == other._pos;
	}

	difference_type operator- (fray_iterator const &other) const {
		return _pos - other._pos;
	}

	fray_iterator &operator-= (size_type const &n) {
		_pos -= n;
		return *this;
	}

	fray_iterator operator- (size_type const &n) {
		return fray_iterator(*this) -= n;
	}

	fray_iterator &operator+= (size_type const &n) {
		_pos += n;
		return *this;
	}

	fray_iterator operator+ (size_type const &n) const {
		return fray_iterator(*this) += n;
	}

private:
	ch const *_pos;

	template<typename ch_, typename tr_, typename alloc_>
	fray_iterator(fray_iterator<ch_, tr_, alloc_> const &);	// no impl

	friend struct basic_fray<ch, traits, alloc>;
};

template<typename ch, typename tr, typename alloc>
bool operator!= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);
template<typename ch, typename tr, typename alloc>
bool operator> (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);
template<typename ch, typename tr, typename alloc>
bool operator<= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);
template<typename ch, typename tr, typename alloc>
bool operator>= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator== (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator!= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator> (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator<= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator>= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b);

/*
 * A fray reference.  _root holds the fray_root.  _begin and _end mark the
 * extent of this substring (must be within the bounds of the fray_root).
 */
template<typename ch, 
	typename traits = std::char_traits<ch>, 
	typename alloc = std::allocator<ch>
>
struct basic_fray {
	typedef ch value_type;
	typedef typename alloc::size_type size_type;
	typedef ch const &reference;
	typedef ch const &const_reference;
	typedef fray_iterator<ch, traits, alloc> iterator;
	typedef fray_iterator<ch, traits, alloc> const_iterator;

	static size_type const npos = static_cast<size_type>(-1);

	/*
	 * Create a new, empty fray.
 	 */
	basic_fray();

	/*
	 * Create a new fray from the characters [cstring, cstring + len).
	 */
	basic_fray(ch const *cstring, size_type len);

	/*
	 * Create a new fray from the characters [cstring, cstring + strlen(cstring)).
	 */
	basic_fray(ch const *cstring);

	/*
	 * Create a new fray from the characters [s.begin(), s.end()).
	 */
	template<typename traits_, typename alloc_>
	basic_fray(std::basic_string<ch, traits_, alloc_> const &s);

	/*
	 * Create a new fray from the iterator pair [first, last).
	 */
	template<typename InputIterator>
	basic_fray(InputIterator first, InputIterator last);

	/*
	 * Create a new fray which holds a copy of other.
	 */
	basic_fray(basic_fray<ch> const &other);

	/*
	 * Create a new fray holding n copies of c.
	 */
	basic_fray(size_type n, ch c);

	/*
	 * Release the resources held by this fray.
	 */
	~basic_fray();

	/*
	 * Replace the contents of this fray with a copy of other.
	 */
	basic_fray &operator= (basic_fray<ch, traits, alloc> const &other);
	void assign (basic_fray<ch, traits, alloc> const &other);

	/*
	 * Replace the contents of this fray with [cstring, cstring + strlen(cstring)).
	 */
	basic_fray &operator= (ch const *cstring);
	void assign (ch const *cstring);
	void assign (ch const *cstring, size_type len);

	/*
	 * Replace the contents of this fray with [s.begin(), s.end()).
	 */
	template<typename traits_, typename alloc_>
	basic_fray &operator= (std::basic_string<ch, traits_, alloc_> const &s);
	template<typename traits_, typename alloc_>
	void assign (std::basic_string<ch, traits_, alloc_> const &s);

	/*
	 * Replace the contents of this fray with [begin, end).
	 */
	void assign(iterator begin, iterator end);

	/*
	 * Return a fray holding the bytes [begin + off, begin + off + count).
	 * If the substring would extend past the end of the fray, the copy
	 * will extend until the end.
	 */
	basic_fray substr(size_type off = 0, size_type count = npos) const;

	/*
	 * Output the contents of this fray to the given stream.
	 */
	template<typename ostr>
	void print(std::basic_ostream<ch, ostr> &strm) const;

	/*
	 * Return the number of characters in this fray.
	 */
	size_type length(void) const;
	size_type size(void) const;

	/*
	 * Return an iterator referring to the beginning of this fray.
	 */
	iterator begin(void) const;

	/*
	 * Return an iterator referring to one character past the end of this
	 * fray.
	 */
	iterator end(void) const;

	/*
	 * Returns the position of the first occurance of 'ch' in *this
	 * not before 'pos'.
	 */
	size_type find(ch c, size_type pos = 0) const;

	/*
	 * Returns the position of the first occurance of the string
	 * 's' in *this not before 'pos'.
	 */
	size_type find(basic_fray const &s, size_type pos = 0) const;

	/*
	 * Equivalent to ::trcompare<tr_>(*this, a).
	 */
	template<typename tr_>
	int compare(basic_fray const &other) const;

	/*
	 * Return a C string (nul terminated) with the same contents as
	 * this fray.  Note: because frays are not nul-terminated internally,
	 * this *always* copies the contents.  Avoid it if possible.
	 *
	 * data() is the same but does not copy and is not nul-terminated.
	 */
	ch const *c_str(void) const;
	ch const *data(void) const;

	/*
	 * Return an std::basic_string with the same contents as this fray.
	 */
	std::basic_string<ch, traits, alloc> str(void) const;

	/*
	 * Return (length() == 0);
	 */
	bool empty(void) const;

	/*
	 * Return the character at position n.
	 */
	ch operator[] (size_type) const;

	/*
	 * Swap the contents of *this and other.  Constant time.
	 */
	void swap(basic_fray &other);

	/*
	 * Return a new fray consisting of *this concatenated with other.
	 */
	basic_fray append(basic_fray const &other) const;

	/*
	 * Return append(cstring, cstring + traits::length(cstring)).
	 */
	basic_fray append(ch const *cstring) const;

	/*
	 * Return append(fray(begin, end));
	 */
	basic_fray append(ch const *begin, ch const *end) const;

	/*
	 * Return append(&c, 1);
	 */
	basic_fray append(ch c) const;

	/*
	 * Return a new fray consisting of other concatenated with *this.
	 */
	basic_fray prepend(basic_fray const &other) const;

	/*
	 * Return prepend(cstring, cstring + traits::length(cstring)).
	 */
	basic_fray prepend(ch const *cstring) const;

	/*
	 * Return prepend(fray(begin, end));
	 */
	basic_fray prepend(ch const *begin, ch const *end) const;
	
	/*
	 * Return prepend(&c, 1);
	 */
	basic_fray prepend(ch c) const;

private:
	/*
	 * Construct a new fray from an already extant root.
	 */
	basic_fray (fray_impl::fray_root<ch, traits, alloc> *);

	/*
	 * Decrement the root's refcount and delete it if 0.
	 */
	void _deref_root(void) const;

	mutable fray_impl::fray_root<ch, traits, alloc>	*_root;
	ch const		*_begin, *_end;
	static typename alloc::template rebind<fray_impl::fray_root<ch, traits, alloc> >::other
		_alloc;

	template<typename ch_, typename traits_, typename alloc_>
	basic_fray(basic_fray<ch_, traits_, alloc_> const &other);	// no impl
};

template<typename ch, typename tr, typename alloc, typename ostr>
std::basic_ostream<ch, ostr> &
operator<< (std::basic_ostream<ch, ostr> &strm, basic_fray<ch, tr, alloc> const &s);

template<typename ch, typename tr, typename alloc, typename ostr>
std::basic_istream<ch, ostr> &
operator>> (std::basic_istream<ch, ostr> &strm, basic_fray<ch, tr, alloc> &s);

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc, typename tr_, typename alloc_>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, std::basic_string<ch, tr_, alloc_> const &b);

template<typename ch, typename tr, typename alloc, typename tr_, typename alloc_>
basic_fray<ch, tr, alloc>
operator+ (std::basic_string<ch, tr_, alloc_> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, ch const *cstring);

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (ch const *cstring, basic_fray<ch, tr, alloc> const &a);

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &s, ch c);

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (ch c, basic_fray<ch, tr, alloc> const &s);

namespace std {
	template<typename ch, typename tr, typename alloc>
	void swap(basic_fray<ch, tr, alloc> &a, basic_fray<ch, tr, alloc> &b);
}

typedef basic_fray<char> fray;
typedef basic_fray<wchar_t> wfray;

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename traits, typename ch>
int trcompare(ch const *a, ch const *b);

template<typename ch, typename tr, typename alloc>
int compare(basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
int compare(basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
int compare(ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch>
int compare(ch const *a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator< (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator< (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator< (ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator== (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator== (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator== (ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator!= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator!= (ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator!= (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator> (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator> (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator> (ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator<= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator<= (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator<= (ch const *a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator>= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b);

template<typename ch, typename tr, typename alloc>
bool operator>= (basic_fray<ch, tr, alloc> const &a, ch const *b);

template<typename ch, typename tr, typename alloc>
bool operator>= (ch const *a, basic_fray<ch, tr, alloc> const &b);

/*
 * For boost.hash.
 */
template<typename ch, typename tr, typename alloc>
std::size_t hash_value(basic_fray<ch, tr, alloc> const &s);

template<typename ch, typename tr, typename alloc>
std::istream & getline(std::basic_istream<ch, tr> &strm, basic_fray<ch, tr, alloc> &s);

#include "fray.cc"

#endif	/* !FRAY_H */
