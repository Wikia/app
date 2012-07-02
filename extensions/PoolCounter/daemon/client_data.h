typedef unsigned char u_char; /* needed by event.h */
#include <stddef.h>
#include <event.h>
#include "locks.h"

struct client_data {
	struct event ev;
	int fd;
	size_t used_buffer;
	char buffer[1024];
	
	struct locks client_locks;
};

#define CLIENT_DATA_FROM_LOCKS(cli_lock_pointer)  ((struct client_data*)(((char*)(cli_lock_pointer)) - offsetof(struct client_data,client_locks)))

struct client_data* new_client_data();
void free_client_data(struct client_data* cli_data);
int read_client_line(int fd, struct client_data* cli_data, char** line);
int recover_client_buffer(struct client_data* cli_data, int len, char** line);

#define PORT 7531
#define BACKLOG 20
