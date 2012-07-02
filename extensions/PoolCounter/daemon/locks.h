#ifndef LOCKS_H
#define LOCKS_H

#include <stdint.h>
#include <sys/time.h>

/* This application uses several double linked lists.
 * They are circular lists, new items are added on the end (ie. on prev)
 * and popped from next.
 */
struct double_linked_list {
	struct double_linked_list* prev;
	struct double_linked_list* next;
};

struct hashtable_entry {
	struct double_linked_list hashtable_siblings;
	struct hashtable* parent_hashtable;
	uint32_t key_hash;
	char* key;
};

struct PoolCounter {
	struct hashtable_entry htentry;
	
	uint32_t count;
	int processing;
	
	struct double_linked_list working;
	struct double_linked_list for_them;
	struct double_linked_list for_anyone;
};

struct locks {
	struct double_linked_list siblings;
	struct PoolCounter* parent;
	enum lock_state { UNLOCKED, WAITING, WAIT_ANY, PROCESSING } state;
	struct timeval timeval; /* Stores the instante where it started waiting/processing */
};

struct client_data;
void init_lock(struct locks* l);
void finish_lock(struct locks* l);
const char* process_line(struct client_data* cli_data, char* line, int line_len);
void process_timeout(struct locks* l);
void remove_client_lock(struct locks* l, int wakeup_anyones);
void send_client(struct locks* l, const char* msg);


void hashtable_init();
struct hashtable* hashtable_create(int hashpower);
void* hashtable_find(struct hashtable* ht, uint32_t hash_value, const char* key);
void hashtable_insert(struct hashtable* ht, struct hashtable_entry* htentry);
void hashtable_remove(struct hashtable* ht, struct hashtable_entry* htentry);
#endif
