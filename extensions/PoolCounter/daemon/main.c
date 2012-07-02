#define _GNU_SOURCE
#include <sys/socket.h>
#include <arpa/inet.h>
#include <sys/stat.h>
#include <stdlib.h>
#include <unistd.h>
#include <signal.h>
#include <stdio.h>
#include <event.h>
#include <fcntl.h>

#include "client_data.h"
#include "prototypes.h"
#include "locks.h"
#include "stats.h"

static int open_sockets = 1; /* Program will automatically close when this reaches 0 */

static struct event listener_ev;
static char** global_argv;

int main(int argc, char** argv) {
	struct event_base *base;
	struct stat st;
	int listener;

	if ( argc >= 1 ) {
		global_argv = argv;
	}

	if ( fstat( 0, &st ) || ! S_ISSOCK( st.st_mode ) ) {
		close( 0 ); /* Place the listener socket in fd 0 */
		listener = listensocket( PORT );
	} else {
		/* We have been given the listening socket in stdin */
		listener = 0;
	}
	
	setup_signals();
	
	hashtable_init();
	base = event_init();
	if (!base) {
		fprintf( stderr, "Error in libevent initialization\n" );
		return 1;
	}
	
	stats.start = time( NULL );
	
	event_set( &listener_ev, listener, EV_READ | EV_PERSIST, on_connect, NULL );
	
	event_add( &listener_ev, NULL );
	
	event_dispatch();
	
	event_del( &listener_ev );
	
	event_base_free( base );
	
	return 0;
}

int listensocket(short int port) /* prototype */
{
    int s;
    struct sockaddr_in addr;

    if ( ( s = socket( AF_INET, SOCK_STREAM, 0 ) ) == -1 ) {
       perror("Couldn't create TCP socket");
       exit(1);
    }

    addr.sin_family = AF_INET;
    addr.sin_port = htons(port);
    addr.sin_addr.s_addr = INADDR_ANY;

    if ( bind( s, (struct sockaddr *)&addr, sizeof( struct sockaddr ) ) == -1 ) {
       perror("Couldn't bind");
       close( s );
       exit( 1 );
    }

    if (listen( s, BACKLOG ) == -1) {
       perror("Couldn't listen");
       close( s );
       exit( 1 );
    }

    return s;
}

void on_connect(int listener, short type, void* arg) /* prototype */
{
	struct client_data* cli;
	int fd;
#if HAVE_ACCEPT4
	fd = accept4( listener, NULL, NULL, SOCK_CLOEXEC | SOCK_NONBLOCK );
#else
	fd = accept( listener, NULL, NULL );
#endif
	
	if ( fd == -1 ) {
		incr_stats( connect_errors );
		perror( "Error accepting" );
		return;
	}
	
	if ( !HAVE_ACCEPT4 ) {
		int flags = fcntl( fd, F_GETFL );
		if ( flags != -1 ) {
			fcntl( fd, F_SETFD, flags | FD_CLOEXEC | O_NONBLOCK );
		}
	}
	
	cli = new_client_data( fd );
	if ( !cli ) {
		incr_stats( connect_errors );
		perror( "Couldn't allocate the client data! :(" );
		close( fd );
		return;
	}
	open_sockets++;
		
	event_set( &cli->ev, fd, EV_READ, on_client, cli );
	event_add( &cli->ev, NULL ); /* First query comes from client */
}

void on_client(int fd, short type, void* arg) /* prototype */
{
	int n;
	char *line;
	struct client_data* cli_data = arg;
	
	if ( type == EV_TIMEOUT ) {
		process_timeout( &cli_data->client_locks );
		event_add( &cli_data->ev, NULL );
		return;
	}
	
	n = read_client_line( fd, cli_data, &line );
	
	if ( n < 0 ) {
		/* Client disconnected */
		event_del( &cli_data->ev);
		free_client_data( cli_data );
		close( fd );
		open_sockets--;
		if ( !open_sockets ) {
			end( 0 );
		}
	} else {
		while ( line ) {
			send_client( &cli_data->client_locks, process_line(cli_data, line, n) );
			n = recover_client_buffer(cli_data, n, &line);
		}
	}
}

static void end(int signal) /* prototype */
{
	close( 0 );
	/* TODO: Close gracefully all connections */
	event_loopbreak();
}

static void graceful(int signal)
{
	pid_t p = fork();
	if ( p == -1 ) {
		perror( "Can't fork" );
		return;
	}
	
	if ( p ) {
		/* Stop listening connections */
		close( 0 );
		event_del( &listener_ev );
		open_sockets--;
		if ( !open_sockets ) {
			/* We have no clients attached. Exit here.
			 * Note: There is a race condition here.
			 */
			end( 0 );
		}
	} else {
		if ( global_argv ) {
			execvp( global_argv[0], global_argv );
		} else {
			execl( "/proc/self/exe", "poolcounterd", NULL );
		}
		exit( 1 );
	}
}

void setup_signals() /* prototype */
{
	struct sigaction sa;
	sa.sa_flags = SA_RESTART;
	sigfillset( &sa.sa_mask );

	sa.sa_handler = SIG_IGN;
	sigaction( SIGPIPE, &sa, NULL );
	sigaction( SIGCHLD, &sa, NULL );
	
	sa.sa_handler = end;
	sigaction( SIGINT, &sa, NULL );	
	sigaction( SIGTERM, &sa, NULL );	

	sa.sa_handler = graceful;
	sigaction( SIGUSR1, &sa, NULL );
	
	/* Reset the process mask. It seems affected after one fork + execv in the signal handler */
	sigemptyset( &sa.sa_mask );
	sigprocmask( SIG_SETMASK, &sa.sa_mask, NULL );
}
