#ifndef PHP_CPP_ALLOCATOR_H
#define PHP_CPP_ALLOCATOR_H

#include <memory>
#include "php.h"

/**
 * Allocation class which allows various C++ standard library functions
 * to allocate and free memory using PHP's emalloc/efree facilities.
 */
template <class T>
class PhpAllocator : public std::allocator<T> 
{
	public:
		// Make some typedefs to avoid having to use "typename" everywhere
		typedef typename std::allocator<T>::pointer pointer;
		typedef typename std::allocator<T>::size_type size_type;

		// The rebind member allows callers to get allocators for other types, 
		// given a specialised allocator
		template <class U> struct rebind { typedef PhpAllocator<U> other; };

		// Various constructors that do nothing
		PhpAllocator() throw() {}
		PhpAllocator(const PhpAllocator& other) throw() {}
		template <class U> PhpAllocator(const PhpAllocator<U>&) throw() {}

		// Allocate some memory from the PHP request pool
		pointer allocate(size_type size, typename std::allocator<void>::const_pointer hint = 0) {
			return (pointer)safe_emalloc(size, sizeof(T), 0);
		}

		// Free memory
		void deallocate(pointer p, size_type n) {
			return efree(p);
		}
};

#endif
