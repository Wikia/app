#include <stdio.h>
#include <string.h>
#include <math.h>
#include "stats.h"


struct stats stats;

#define COMMAND(item) + sizeof(#item) + 2 + MAX_COUNT_LEN
static char stats_buffer[
	sizeof("Uptime: 100000 days, 23h 59m 59s") + 2 + 700
	#include "stats.list"
];
#undef COMMAND

static size_t strtimeval(char* dst, size_t max, const char* title, const struct timeval* tv, count_t divisor);

const char* provide_stats(const char* type)
{
	int seconds = time(NULL) - stats.start;
	int minutes = seconds / 60;
	seconds %= 60;
	int hours = minutes / 60;
	minutes %= 60;
	unsigned int days = hours / 24;
	
	int n;
	n = sprintf( stats_buffer, "uptime: %u days, %dh %dm %ds\n", days, hours, minutes, seconds );
	
	if ( !strcasecmp( type, "FULL" ) ) {
		n += strtimeval( stats_buffer + n, 100, "total processing time", &stats.processing_time, 0 );
		n += strtimeval( stats_buffer + n, 100, "average processing time", &stats.processing_time, stats.processed_count );
		n += strtimeval( stats_buffer + n, 100, "gained time", &stats.gained_time, 0 );
		n += strtimeval( stats_buffer + n, 100, "waiting time", &stats.waiting_time, 0 );
		n += strtimeval( stats_buffer + n, 100, "waiting time for me", &stats.waiting_time_for_me, 0 );
		n += strtimeval( stats_buffer + n, 100, "waiting time for anyone", &stats.waiting_time_for_anyone, 0 );
		n += strtimeval( stats_buffer + n, 100, "waiting time for good", &stats.waiting_time_for_good, 0 );
		n += strtimeval( stats_buffer + n, 100, "wasted timeout time", &stats.wasted_timeout_time, 0 );
		
		#define COMMAND(item) n += sprintf( stats_buffer + n, #item ": %" PRcount "\n", stats.item );
		#include "stats.list"
		#undef COMMAND
		strcpy( stats_buffer + n, "\n" );
	} else if ( strcasecmp( type, "UPTIME" ) ) {
		#define COMMAND(item) if ( !strcasecmp( type, #item ) ) sprintf( stats_buffer, #item ": %" PRcount "\n", stats.item ); else
		#include "stats.list"
		#undef COMMAND
		
		strcpy( stats_buffer, "ERROR WRONG_STAT" );
	}
	return stats_buffer;
}

/**
 * Writes a timeval into the string.
 * It is expected to get inlined.
 * @return amount of bytes written
 */
static size_t strtimeval(char* dst, size_t max, const char* title, const struct timeval* tv, count_t divisor) {
	int n;
	n = snprintf( dst, max, "%s: ", title );
	if ( max < n ) return 0;
		
	float seconds = tv->tv_sec + tv->tv_usec * 1.0e-6f;
	if ( divisor ) {
		/* We could use 1 as default value and skipt this branch. But 
		 * counters can be 0, and I don't want to deal with dividing by 
		 * zero. They are floats, but statistics shouldn't be NaN.
		 */
		seconds = seconds / divisor;
	}
	
	if ( seconds >= 60 ) {
		int minutes = seconds / 60;
		seconds = fmodf( seconds, 60 );
		
		if ( minutes >= 60 ) {
			int hours = minutes / 60;
			minutes %= 60;
			
			if ( hours >= 24 ) {
				unsigned int days = hours / 24;
				hours %= 24;
				
				n += snprintf( dst + n, max - n, "%u days ", days );
				if ( max < n ) return 0;
			}
			n += snprintf( dst + n, max - n, "%dh ", hours );
			if ( max < n ) return 0;
		}
		n += snprintf( dst + n, max - n, "%dm ", minutes );
		if ( max < n ) return 0;
	}
	n += snprintf( dst + n, max - n, "%fs\n", seconds );
	if ( max < n ) return 0;
	
	return n;
}
