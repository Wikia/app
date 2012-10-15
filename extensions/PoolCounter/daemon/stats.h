#ifndef _BSD_SOURCE
#define _BSD_SOURCE
#endif
#include <sys/time.h>

#include <time.h>
#include <stdint.h>
#include <inttypes.h>

typedef int64_t count_t;
#define PRcount PRIi64
#define MAX_COUNT_LEN sizeof("−9223372036854775808")

struct stats {
	time_t start;
	
	struct timeval processing_time; /* Total processing time */
	struct timeval gained_time; /* Processing time saved by waiting (pairs with waiting_time_for_good)  */
	struct timeval waiting_time; /* Total time waiting until getting the lock (waiting_time_for_me + waiting_time_for_anyone) */
	struct timeval waiting_time_for_me; /* Total time waiting until getting a lock for that item */
	struct timeval waiting_time_for_anyone; /* Total time waiting until getting a lock for anyone */
	struct timeval waiting_time_for_good; /* Total time waiting until another worker did the work for us */
	struct timeval wasted_timeout_time; /* Waiting time of workers which finally hitted its timeout */

#define COMMAND(item) volatile count_t item;
#include "stats.list"
#undef COMMAND

};

extern struct stats stats;
const char* provide_stats(const char* type);

#define incr_stats(item) stats.item++
#define decr_stats(item) stats.item--

#define time_stats(lock,item) \
	do { \
		struct timeval tv; \
		if ( !timerisset( &now ) ) { \
			gettimeofday( &now, NULL ); \
		} \
		timersub( &now, &(lock)->timeval, &tv ); \
		timeradd( &tv, &stats.item, &stats.item ); \
	} while (0)
