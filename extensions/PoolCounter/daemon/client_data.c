#include <stddef.h>
#include <errno.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <malloc.h>
#include "client_data.h"
#include "locks.h"
#include "stats.h"

struct client_data* new_client_data(int fd) {
	struct client_data* cd;
	cd = malloc( sizeof( *cd ) );
	cd->used_buffer = 0;
	init_lock( &cd->client_locks );
	cd->fd = fd;
	return cd;
}

void free_client_data(struct client_data* cli_data) {
	finish_lock( &cli_data->client_locks );
	free( cli_data );
}

/**
 * Read data from the client
 * If we filled a line, return the line length, and point to it in *line.
 * If a line is not available, *line will point to NULL.
 * Return -1 or -2 if the socket was closed (gracefully / erroneusly)
 * Line separator is \n.
 * Returned lines end in \0 with \n stripped.
 * Incomplete lines are not returned on close.
 */
int read_client_line(int fd, struct client_data* cli_data, char** line) {
	int n, i;
	
	*line = NULL;
	n = recv( fd, cli_data->buffer + cli_data->used_buffer, sizeof( cli_data->buffer ) - cli_data->used_buffer, 0 );
	if ( n == 0 ) {
		return -1;
	}
	if ( n == -1 ) {
		if (errno == EAGAIN) {
			/* This shouldn't happen... */
			return 0;
		} else {
			return -2;
		}
	}
	
	for ( i=cli_data->used_buffer; i < cli_data->used_buffer+n; i++ ) {
		if ( cli_data->buffer[i] == '\n' ) {
			cli_data->buffer[i] = '\0';
			*line = cli_data->buffer;
			return i;
		}
	}
	
	/* Wait for the rest of the line */
	event_add( &cli_data->ev, NULL );
	return 0;
}

/* Recover the space from the buffer which has been read, return another line if available */
int recover_client_buffer(struct client_data* cli_data, int len, char** line) {	
	int i;
	*line = 0;
	if ( len >= cli_data->used_buffer ) {
		/* This is a query-response protocol. This should be *always* the case */
		cli_data->used_buffer = 0;
		return 0;
	}
	
	/* Nonetheless handle the other case */
	memmove(cli_data->buffer, cli_data->buffer + len, cli_data->used_buffer - len);
	cli_data->used_buffer -= len;
	
	for ( i=0; i < cli_data->used_buffer; i++ ) {
		if ( cli_data->buffer[i] == '\n' ) {
			cli_data->buffer[i] = '\0';
			*line = cli_data->buffer;
			return i;
		}
	}
	
	return 0;
}

/* Sends the message msg to the other side, or nothing if msg is NULL
 * Since the message are short, we optimistically consider that they 
 * will always fit and never block (note O_NONBLOCK is set).
 */
void send_client(struct locks* l, const char* msg) {
	struct client_data* cli_data;
	if ( !msg ) return;
	
	cli_data = CLIENT_DATA_FROM_LOCKS(l);
	size_t len = strlen(msg);
	
	if ( send( cli_data->fd, msg, len, 0) != len ) {
		perror( "Something failed sending message" );
		incr_stats( failed_sends );
	}
	/* Wait for answer */
	event_add( &cli_data->ev, NULL );
}
