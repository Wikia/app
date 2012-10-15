#ifndef _JUDYHS_CPP_WRAPPER_H
#define _JUDYHS_CPP_WRAPPER_H

/**
  * JudyHS wrapper by Tim Starling. May be reused, modified and redistributed without restriction.
  */


#include <string>
#include <list>
#include <Judy.h>

/**
  * value_type must be the size of a pointer
  */
template <class value_type>
class JudyHSWord
{
public:
	JudyHSWord() : handle(NULL) {}
	~JudyHSWord() { FreeArray(); }
	
	/**
	  * Set the given index to a given value. If it already exists, overwrite it.
	  */
	value_type & Set(const char *index, Word_t length, const value_type & value) 
	{ 
		value_type *p = (value_type*)JudyHSIns(&handle, (void*)index, length, NULL);
		*p = value; 
		return *p;
	}
	value_type & Set(const std::string & s, const value_type & value) { return Set(s.data(), s.length(), value); }

	/**
	  * Add the given array element. If it already exists, leave it unchanged. If not, 
	  * initialise it with the given value.
	  */
	value_type & Add(const char *index, Word_t length, const value_type & value)
	{
		value_type *p = (value_type*)JudyHSIns(&handle, (void*)index, length, NULL);
		if (!*p) {
			*p = value;
		}
		return *p;
	}
	value_type & Add(const char *index, Word_t length) { return Add(index, length, value_type()); }
	value_type & Add(const std::string & s, const value_type & value) { return Add(s.data(), s.size(), value); }
	value_type & Add(const std::string & s) { return Add(s.data(), s.size()); }
	value_type & operator[](const std::string & s) { return Add(s); }
	
	int Delete(const char *index, Word_t length) 
	{ 
		return JudyHSDel(&handle, (void*)index, length, NULL); 
	}
	int Delete(const std::string & s) {	return Delete(s.data(), s.size()); }

	value_type * Get(const char *index, Word_t length) 
	{ 
		return (value_type*)JudyHSGet(handle, (void*)index, length);
	}
	value_type * Get(const std::string & s)	{ return (value_type*)Get(s.data(), s.size());	}

	
	Word_t FreeArray() { return JudyHSFreeArray(&handle, NULL); }
protected:
	Pvoid_t handle;
};

/**
  * set class that's kind of compatible with set<string>, if you use your imagination
  */
class JudySet : public JudyHSWord<int>
{
public:
	void insert(const std::string & s) {
		Add(s, 1);
	}

	bool find(const std::string & s) {
		if (Get(s)) {
			return true;
		} else {
			return false;
		}
	}

	bool end() {
		return false;
	}
};


/*
 * General value storage
 */
template <class value_type>
class JudyHS
{
protected:
	struct List {
		List() : prev(NULL), next(NULL) {}
		List(const value_type & v) : value(v), prev(NULL), next(NULL) {}
		value_type value;
		List * prev;
		List * next;
	};
public:	
	JudyHS() : handle(NULL), storage(NULL) {}
	~JudyHS() {	FreeArray(); }
	
	/**
	  * Set the given index to a given value. If it already exists, overwrite it.
	  */
	value_type & Set(const char *index, Word_t length, const value_type & value) 
	{
		// Add to the list
		List * node = new List(value);
		AddNode(node);
		// Insert into the judy array
		List ** pNode = (List**)JudyHSIns(&handle, (void*)index, length, NULL);
		if (*pNode) {
			DeleteNode(*pNode);
		}
		*pNode = node;
		return node->value;
	}
	
	value_type & Set(const std::string & s, const value_type & value) { return Set(s.data(), s.size(), value); }

	/**
	  * Add the given array element. If it already exists, leave it unchanged. If not, 
	  * initialise it with the given value.
	  */
	value_type & Add(const char *index, Word_t length, const value_type & value)
	{
		List ** pNode = (List**)JudyHSIns(&handle, (void*)index, length, NULL);
		if (!*pNode) {
			// Add to the list
			List * node = new List(value);
			AddNode(node);
			// Register the list in the array
			*pNode = node;
		}
		return (*pNode)->value;
	}
	
	value_type & Add(const char *index, Word_t length) { return Add(index, length, value_type()); }
	value_type & Add(const std::string & s, const value_type & value) { return Add(s.data(), s.size(), value); }
	value_type & Add(const std::string & s) { return Add(s.data(), s.size()); }
	value_type & operator[](const std::string & s) { return Add(s); }

	value_type * Get(const char *index, Word_t length) 
	{ 
		List ** pNode = (List**)JudyHSGet(handle, (void*)index, length);
		if (!pNode) {
			return NULL;
		} else {
			return &((*pNode)->value);
		}
	}

	value_type * Get(const std::string & s)	
	{
		return Get(s.data(), s.size());
	}
	
	int Delete(const char *index, Word_t length) 
	{
		List ** pNode = (List**)JudyHSGet(handle, (void*)index, length);
		if (pNode) {
			// Unlink and delete node
			DeleteNode(*pNode);
			// Remove from array
			return JudyHSDel(&handle, (void*)index, length, NULL);
		} else {
			return 0;
		}
	}

	int Delete(const std::string & s) 
	{
		return Delete(s.data(), s.size());
	}
	
	Word_t FreeArray() {
		// Free all list storage
		List * node = storage;
		List * next;
		while (node) {
			next = node->next;
			delete node;
			node = next;
		}
		// Destroy the judy array
		return JudyHSFreeArray(&handle, NULL); 
	}
protected:
	Pvoid_t handle;
	List * storage;

	void AddNode(List * node) {
		List * oldHead = storage;
		storage = node;
		storage->next = oldHead;
		if (oldHead) oldHead->prev = node;
	}
	
	void DeleteNode(List * node) {
		if (node->prev) node->prev->next = node->next;
		if (node->next) node->next->prev = node->prev;
		if (node == storage) {
			storage = NULL;
		}
		delete node;
	}	
};

#endif
