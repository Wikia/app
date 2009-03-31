/* Copyright (C) 2006-2008 River Tarnell <river@wikimedia.org>.	*/
/*
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */

/* @(#) $Id$ */

#include <cassert>
#include <boost/functional/hash/hash.hpp>
#include "fray.h"

template<typename ch, typename tr, typename alloc>
typename alloc::template rebind<fray_impl::fray_root<ch, tr, alloc> >::other basic_fray<ch, tr, alloc>::_alloc;
template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::size_type const basic_fray<ch, tr, alloc>::npos;

namespace fray_impl { 

template<typename ch, typename tr, typename alloc>
alloc fray_root<ch, tr, alloc>::_alloc;

template<typename ch, typename tr, typename alloc>
fray_root<ch, tr, alloc>::fray_root(ch const *begin, size_type len)
	: _refs(1)
{
	_string = _alloc.allocate(len + sizeof(ch));
	tr::copy(_string, begin, len);
	_string[len] = '\0';
	_end = _string + len;
}

template<typename ch, typename tr, typename alloc>
fray_root<ch, tr, alloc>::fray_root(size_type len)
	: _refs(1)
	, _string(0)
	, _end(0)
{
	_string = _alloc.allocate(len + sizeof(ch));
	_string[len] = '\0';
	_end = _string + len;
}

template<typename ch, typename tr, typename alloc>
fray_root<ch, tr, alloc>::~fray_root() {
	assert(_refs == 0);
	_alloc.deallocate(_string, (_end - _string) + sizeof(ch));
}

template<typename ch, typename tr, typename alloc>
int
fray_root<ch, tr, alloc>::ref(void)
{
	assert(_refs > 0);
	return ++_refs;
}

template<typename ch, typename tr, typename alloc>
int
fray_root<ch, tr, alloc>::deref(void)
{
	assert(_refs > 0);
	return --_refs;
}

} // namespace fray_impl


template<typename ch, typename tr, typename alloc>
bool
operator!= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b)
{
	return !(a == b);
}

template<typename ch, typename tr, typename alloc>
bool
operator> (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b)
{
	return !(a < b) && !(a == b);
}

template<typename ch, typename tr, typename alloc>
bool
operator<= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b)
{
	return (a < b) || (a == b);
}

template<typename ch, typename tr, typename alloc>
bool
operator>= (fray_iterator<ch, tr, alloc> const &a, fray_iterator<ch, tr, alloc> const &b)
{
	return (b < a) || (a == b);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray() 
{
	ch empty[1] = { 0 };
	_root = _alloc.allocate(1);
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(empty, 0);
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray(ch const *cstring, size_type len)
{
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(cstring, len);
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray(ch const *cstring)
{
int	len = tr::length(cstring);
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(cstring, len);
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
template<typename bstraits, typename bsalloc>
basic_fray<ch, tr, alloc>::basic_fray(std::basic_string<ch, bstraits, bsalloc> const &s)
{
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(s.data(), s.size());
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray(
	typename basic_fray<ch, tr, alloc>::size_type n,
	ch c)
{
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(n);
	_begin = _root->_string;
	_end = _root->_end;
	tr::assign(_root->_string, n, c);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray(basic_fray<ch> const &other)
	: _root(other._root)
	, _begin(other._begin)
	, _end(other._end)
{
	_root->ref();
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::basic_fray(fray_impl::fray_root<ch, tr, alloc> *root)
	: _root(root)
	, _begin(root->_string)
	, _end(root->_end)
{
}

template<typename ch, typename tr, typename alloc>
template<typename InputIterator>
basic_fray<ch, tr, alloc>::basic_fray(InputIterator first, InputIterator last)
{
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(last - first);
	_begin = _root->_string;
	_end = _root->_end;

	ch *s = _root->_string;
	std::copy(first, last, s);
}


template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::assign (basic_fray<ch, tr, alloc> const &other)
{
	_deref_root();
	_root = other._root;
	_root->ref();
	_begin = other._begin;
	_end = other._end;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc> &
basic_fray<ch, tr, alloc>::operator= (basic_fray<ch, tr, alloc> const &other)
{
	if (this == &other)
		return *this;
	assign(other);
	return *this;
}

template<typename ch, typename tr, typename alloc>
template<typename bstraits, typename bsalloc>
basic_fray<ch, tr, alloc> &
basic_fray<ch, tr, alloc>::operator= (std::basic_string<ch, bstraits, bsalloc> const &other)
{
	assign(other);
	return *this;
}

template<typename ch, typename tr, typename alloc>
template<typename bstraits, typename bsalloc>
void
basic_fray<ch, tr, alloc>::assign (std::basic_string<ch, bstraits, bsalloc> const &s)
{
	_deref_root();
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(s.data(), s.size());
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc> &
basic_fray<ch, tr, alloc>::operator= (ch const *cstring)
{
	assign(cstring);
	return *this;
}

template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::assign (ch const *cstring)
{
	assign(cstring, tr::length(cstring));
}

template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::assign (ch const *cstring, size_type len)
{
	_deref_root();
	_root = new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(cstring, len);
	_begin = _root->_string;
	_end = _root->_end;
}

template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::assign(
	typename basic_fray<ch, tr, alloc>::iterator begin,
	typename basic_fray<ch, tr, alloc>::iterator end)
{
	assign(begin._pos, end._pos - begin._pos);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::substr(
	typename basic_fray<ch, tr, alloc>::size_type off,
	typename basic_fray<ch, tr, alloc>::size_type count) const
{
	if ((count == npos) || count + off > length())
		count = length() - off;
	return basic_fray(_begin + off, count);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>::~basic_fray() {
	_deref_root();
}

template<typename ch, typename tr, typename alloc>
template<typename ostr>
void
basic_fray<ch, tr, alloc>::print(std::basic_ostream<ch, ostr> &strm) const {
	strm << std::basic_string<ch, tr>(_begin, _end);
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::size_type
basic_fray<ch, tr, alloc>::length(void) const {
	return _end - _begin;
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::size_type
basic_fray<ch, tr, alloc>::size(void) const {
	return length();
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::iterator
basic_fray<ch, tr, alloc>::begin(void) const {
	return iterator(_begin);
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::iterator
basic_fray<ch, tr, alloc>::end(void) const {
	return iterator(_end);
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::size_type
basic_fray<ch, tr, alloc>::find(ch c, typename basic_fray<ch, tr, alloc>::size_type pos) const
{
ch const	*found, *b = _begin + pos;
	found = tr::find(b, _end - b, c);
	if (found == NULL)
		return npos;

	return found - _begin;
}

template<typename ch, typename tr, typename alloc>
typename basic_fray<ch, tr, alloc>::size_type
basic_fray<ch, tr, alloc>::find(
		basic_fray<ch, tr, alloc> const &s, 
		typename basic_fray<ch, tr, alloc>::size_type pos) const
{
ch const	*found, *b = _begin + pos;
	found = std::search(b, _end, s.begin(), s.end());
	if (found == _end)
		return npos;

	return found - _begin;
}

template<typename ch, typename tr, typename alloc>
ch const *
basic_fray<ch, tr, alloc>::c_str(void) const
{
	/*
	 * If this fray ends with the end of the root, c_str simply returns _begin,
	 * because the fray root is always nul terminated.  Otherwise, we
	 * re-root this fray to a root containing only the contents of this
	 * fray.
	 *
	 * This design saves copying in the common case of c_str() on a full
	 * fray, and the degenerate case requires copying with any implementation,
	 * because the nul terminator has to be inserted somewhere.
	 */
	if (_end == _root->_end)
		return _begin;

fray_impl::fray_root<ch, tr, alloc> *newroot
	= new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(_begin, length());
	_deref_root();
	_root = newroot;
	return _begin;
}

template<typename ch, typename tr, typename alloc>
std::basic_string<ch, tr, alloc>
basic_fray<ch, tr, alloc>::str(void) const
{
	return std::basic_string<ch, tr, alloc>(_begin, _end);
}

template<typename ch, typename tr, typename alloc>
ch const *
basic_fray<ch, tr, alloc>::data(void) const
{
	return _begin;
}

template<typename ch, typename tr, typename alloc>
ch
basic_fray<ch, tr, alloc>::operator[] (typename basic_fray<ch, tr, alloc>::size_type n) const
{
	return *(begin() + n);
}

template<typename ch, typename tr, typename alloc>
bool
basic_fray<ch, tr, alloc>::empty(void) const
{
	return length() == 0;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::append(basic_fray<ch, tr, alloc> const &other) const
{
	return append(other._begin, other._end);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::append(ch const *cstring) const
{
	return append(cstring, cstring + tr::length(cstring));
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::append(ch c) const
{
ch	s[2] = {c, 0};
	return append(s, s + 1);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::append(ch const *b, ch const *e) const
{
size_type	alen = (e - b), newlen = length() + alen;
fray_impl::fray_root<ch, tr, alloc> *newroot = 
	new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(newlen);

	tr::copy(newroot->_string, _begin, length());
	tr::copy(newroot->_string + length(), b, alen);
	newroot->_end = newroot->_string + newlen;
	return basic_fray<ch, tr, alloc>(newroot);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::prepend(basic_fray<ch, tr, alloc> const &other) const
{
	return prepend(other._begin, other._end);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::prepend(ch const *cstring) const
{
	return prepend(cstring, cstring + tr::length(cstring));
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::prepend(ch c) const
{
ch	s[2] = {c, 0};
	return prepend(s, s + 1);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
basic_fray<ch, tr, alloc>::prepend(ch const *b, ch const *e) const
{
size_type	alen = (e - b), newlen = length() + alen;
fray_impl::fray_root<ch, tr, alloc> *newroot = 
	new (_alloc.allocate(1)) fray_impl::fray_root<ch, tr, alloc>(newlen);

	tr::copy(newroot->_string, b, alen);
	tr::copy(newroot->_string + alen, _begin, length());
	newroot->_end = newroot->_string + newlen;
	return basic_fray<ch, tr, alloc>(newroot);
}

template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::swap(basic_fray<ch, tr, alloc> &other)
{
	std::swap(_root, other._root);
	std::swap(_begin, other._begin);
	std::swap(_end, other._end);
}

template<typename ch, typename tr, typename alloc>
void
basic_fray<ch, tr, alloc>::_deref_root(void) const
{
	if (!_root)
		return;

	if (_root->deref() == 0) {
		_alloc.destroy(_root);
		_alloc.deallocate(_root, 1);
	}
}

template<typename ch, typename tr, typename alloc>
template<typename tr_>
int
basic_fray<ch, tr, alloc>::compare(basic_fray<ch, tr, alloc> const &other) const
{
int	i, alen = length(), blen = other.length();
	i = tr_::compare(_begin, other._begin, std::min(alen, blen));
	if (i == 0)
		return alen - blen;	/* shorter string is lesser */

	return i;
}
	
template<typename ch, typename tr, typename alloc, typename ostr>
std::basic_ostream<ch, ostr> &
operator<< (std::basic_ostream<ch, ostr> &strm, basic_fray<ch, tr, alloc> const &s)
{
	s.print(strm);
	return strm;
}

template<typename ch, typename tr, typename alloc, typename ostr>
std::basic_istream<ch, ostr> &
operator>> (std::basic_istream<ch, ostr> &strm, basic_fray<ch, tr, alloc> &s)
{
	std::basic_string<ch, tr> st;
	strm >> st;
	if (strm)
		s = st;
	return strm;
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b)
{
	return a.append(b);
}

template<typename ch, typename tr, typename alloc, typename tr_, typename alloc_>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, std::basic_string<ch, tr_, alloc_> const &b)
{
	return a.append(b.data(), b.data() + b.size());
}

template<typename ch, typename tr, typename alloc, typename tr_, typename alloc_>
basic_fray<ch, tr, alloc>
operator+ (std::basic_string<ch, tr_, alloc_> const &a, basic_fray<ch, tr, alloc> const &b)
{
	return b.prepend(a.begin(), a.end());
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &a, ch const *cstring)
{
	return a.append(cstring);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (ch const *cstring, basic_fray<ch, tr, alloc> const &a)
{
	return a.prepend(cstring);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (basic_fray<ch, tr, alloc> const &s, ch c)
{
	return s.append(c);
}

template<typename ch, typename tr, typename alloc>
basic_fray<ch, tr, alloc>
operator+ (ch c, basic_fray<ch, tr, alloc> const &s)
{
	return s.prepend(c);
}

namespace std {
	template<typename ch, typename tr, typename alloc>
	void swap(basic_fray<ch, tr, alloc> &a, basic_fray<ch, tr, alloc> &b)
	{
		a.swap(b);
	}
}

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return a.template compare<traits>(b);
}

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return a.template compare<traits>(basic_fray<ch, tr, alloc>(b));
}

template<typename traits, typename ch, typename tr, typename alloc>
int trcompare(ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return -b.template compare<traits>(basic_fray<ch, tr, alloc>(a));
}

template<typename traits, typename ch>
int trcompare(ch const *a, ch const *b)
{
int	i, alen = traits::length(a), blen = traits::length(b);
	i = traits::compare(a, b, std::min(alen, blen));
	if (i == 0)
		return alen - blen;	/* shorter string is lesser */

	return i;
}

template<typename ch, typename tr, typename alloc>
int compare(basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return trcompare<tr>(a, b);
}

template<typename ch, typename tr, typename alloc>
int compare(basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return trcompare<tr>(a, b);
}

template<typename ch, typename tr, typename alloc>
int compare(ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return trcompare<tr>(a, b);
}

template<typename ch>
int compare(ch const *a, ch const *b) {
	return trcompare<std::char_traits<ch> >(a, b);
}

template<typename ch, typename tr, typename alloc>
bool operator< (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return compare(a, b) < 0;
}

template<typename ch, typename tr, typename alloc>
bool operator< (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return compare(a, b) < 0;
}

template<typename ch, typename tr, typename alloc>
bool operator< (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return compare(a, b) < 0;
}

template<typename ch, typename tr, typename alloc>
bool
operator== (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b)
{
	return compare(a, b) == 0;
}

template<typename ch, typename tr, typename alloc>
bool operator== (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return compare(a, b) == 0;
}

template<typename ch, typename tr, typename alloc>
bool operator== (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return compare(a, b) == 0;
}

template<typename ch, typename tr, typename alloc>
bool operator!= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return !(a == b);
}

template<typename ch, typename tr, typename alloc>
bool operator!= (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return !(a == b);
}

template<typename ch, typename tr, typename alloc>
bool operator!= (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return !(a == b);
}

template<typename ch, typename tr, typename alloc>
bool operator> (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return compare(a, b) > 0;
}

template<typename ch, typename tr, typename alloc>
bool operator> (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return compare(a, b) > 0;
}

template<typename ch, typename tr, typename alloc>
bool operator> (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return compare(a, b) > 0;
}

template<typename ch, typename tr, typename alloc>
bool operator<= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return !(a > b);
}

template<typename ch, typename tr, typename alloc>
bool operator<= (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return !(a > b);
}

template<typename ch, typename tr, typename alloc>
bool operator<= (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return !(a > b);
}

template<typename ch, typename tr, typename alloc>
bool operator>= (basic_fray<ch, tr, alloc> const &a, basic_fray<ch, tr, alloc> const &b) {
	return !(a < b);
}

template<typename ch, typename tr, typename alloc>
bool operator>= (basic_fray<ch, tr, alloc> const &a, ch const *b) {
	return !(a < b);
}

template<typename ch, typename tr, typename alloc>
bool operator>= (ch const *a, basic_fray<ch, tr, alloc> const &b) {
	return !(a < b);
}

/*
 * For boost.hash.
 */
template<typename ch, typename tr, typename alloc>
std::size_t
hash_value(basic_fray<ch, tr, alloc> const &s)
{
	return boost::hash_range(s.begin(), s.end());
}

template<typename ch, typename tr, typename alloc>
std::istream &
getline(std::basic_istream<ch, tr> &strm, basic_fray<ch, tr, alloc> &s)
{
std::basic_string<ch, tr, alloc> str;
	getline(strm, str);
	if (strm)
		s = str;
	return strm;
}
