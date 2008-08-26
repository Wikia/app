/* ICP Reply agent */
/* $Id: icpagent.c 584 2008-07-29 13:59:13Z emil $ */
/* vim: tabstop=8 number
   */
#include <sys/types.h>
#include <sys/socket.h>
#include "queue.h"
#include <sys/time.h>
#include <sys/resource.h>
#include <netinet/in.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>

struct icpheader {
    unsigned char opcode;	/* opcode */
    unsigned char version;	/* version number */
    unsigned short length;	/* total length (bytes) */
    u_int32_t reqnum;		/* req number (req'd for UDP) */
    u_int32_t flags;
    u_int32_t pad;
    u_int32_t shostid;		/* sender host id */
};

struct {
	time_t loadcheck;
	time_t idlecheck;
	time_t swapcheck;
	int swap;
	int load;
	int idle;
} stats;


typedef enum {
    ICP_INVALID,
    ICP_QUERY,
    ICP_HIT,
    ICP_MISS,
    ICP_ERR,
    ICP_SEND,
    ICP_SENDA,
    ICP_DATABEG,
    ICP_DATA,
    ICP_DATAEND,
    ICP_SECHO,
    ICP_DECHO,
    ICP_NOTIFY,
    ICP_INVALIDATE,
    ICP_DELETE,
    ICP_UNUSED15,
    ICP_UNUSED16,
    ICP_UNUSED17,
    ICP_UNUSED18,
    ICP_UNUSED19,
    ICP_UNUSED20,
    ICP_MISS_NOFETCH,
    ICP_DENIED,
    ICP_HIT_OBJ,
    ICP_END
} icp_opcode;

typedef enum {
    AGENT_REPLY,
    AGENT_SLEEP,
    AGENT_TESTLOAD,
    AGENT_TESTIDLE,
    AGENT_TESTSWAP,
    AGENT_END
} agent_opcode;

int s;				/* Global UDP socket */

TAILQ_HEAD(tailhead, entry) head = TAILQ_HEAD_INITIALIZER(head);
struct tailhead *headp;
struct entry {
    unsigned char operation;
    unsigned char opcode;
    struct sockaddr_in them;
    char *url;
    unsigned long reqnum;
    struct timeval tv;
    TAILQ_ENTRY(entry) entries;
} *np;

void freeentry(struct entry *);
void sendreply(struct entry *);
void insertentry(struct entry *);

void freeentry(struct entry *e)
{
    if (e) {
	if (e->url)
	    free(e->url);
	free(e);
    }
}

void sendreply(struct entry *e)
{
    char msgbuf[16384];
    int slen, length;
    struct icpheader *header;

    length = sizeof(struct icpheader) + strlen(e->url);
    header = (struct icpheader *) msgbuf;
    bzero(header, sizeof(struct icpheader));
    header->opcode = e->opcode;
    header->length = htons(length);
    header->version = 2;
    header->reqnum = htonl(e->reqnum);
    strncpy(msgbuf + sizeof(struct icpheader), e->url, 2048);
    slen =
	sendto(s, msgbuf, length, 0, (struct sockaddr *) &e->them,
	       sizeof(e->them));

}

void queuereply(struct sockaddr_in them, unsigned char opcode, char *url,
		unsigned long reqnum, int delay)
{
    /* This function takes requestor IP address, 
       operation code, optional url,reqnum and delay 
       in miliseconds and queues an entry or  
       passes it for immediate processing */
    if (delay==-1) return;
    struct entry *e;

    e = malloc(sizeof(struct entry));
    if (url)
	e->url = strdup(url);
    e->opcode = opcode;
    memcpy(&e->them, &them, sizeof(them));
    e->reqnum = reqnum;
    if (delay == 0) {
	sendreply(e);
	freeentry(e);
	return;
    } else {
	gettimeofday(&e->tv, NULL);
	e->tv.tv_sec += delay / 1000;
	e->tv.tv_usec += (delay % 1000) * 1000;
	insertentry(e);
    }
}

void insertentry(struct entry *e)
{
    struct timeval tv;

    TAILQ_FOREACH_REVERSE(np, &head, tailhead, entries) {
	if (e->tv.tv_sec < np->tv.tv_sec)
	    continue;
	if ((e->tv.tv_sec == np->tv.tv_sec) &&
	    (e->tv.tv_usec <= np->tv.tv_sec))
	    continue;
	TAILQ_INSERT_AFTER(&head, np, e, entries);
	return;
    }
    TAILQ_INSERT_HEAD(&head, e, entries);
}

void processqueue()
{
    /* Check event queue if there are any events for current or past time */
    struct timeval tv;
    struct entry *e = NULL;

    gettimeofday(&tv, NULL);
    TAILQ_FOREACH(np, &head, entries) {
	if (e) {
	    TAILQ_REMOVE(&head, e, entries);
	    freeentry(e);
	}
	if (np->tv.tv_sec > tv.tv_sec)
	    return;
	if (np->tv.tv_sec == tv.tv_sec && np->tv.tv_usec > tv.tv_usec)
	    return;
	e = np;
	sendreply(e);
    }
    if (e) {
	TAILQ_REMOVE(&head, e, entries);
	freeentry(e);
    }

}

main(int ac, char **av)
{
    int rsize, rlen;
    struct sockaddr_in me, them;
    char msgbuf[16384];
    struct icpheader header;
    char *url;
    struct timeval wait;
    fd_set readfds;
    int port=3130;
    int nice=10;
    int remotemanage=0;
    int c;
    icp_opcode opcode=ICP_HIT;
    float t=5.0;
    int t_int, t_adjust, frac;
    // only answer the nth query
    int replynth = 1;
    // the loop counter
    int maincount = 0, step = 0, stepsum = 0;
    struct rlimit rlim;

    bzero(&me, sizeof(me));

    /* Work with command line options */
    while ((c = getopt(ac,av,"dmr:t:p:h:cn:")) != -1) {
        switch (c) {
            case 'h':
                /* IP to bind at */
                inet_aton(optarg,&me.sin_addr);
                break;
            case 'p':
                /* Port to bind at */
                port=atoi(optarg);
                break;
            case 'm':
                /* Enable remote management */
                remotemanage=1;
                break;
            case 'c':
                /* Allow core dump creation */     
                rlim.rlim_cur=(1024*1024*10);
                rlim.rlim_max=(1024*1024*10);
                setrlimit(RLIMIT_CORE,&rlim); 
            case 'd':
                /* Daemonize, don't change dir - does use files only on coredumps */
                daemon(1,0);
                break;
            case 't':
                /* Predefined timeout value */
                t=atof(optarg);
                break;
            case 'r':
                /* only reply to every nth query, for high request rates */
                replynth=atoi(optarg);
                break;
            case 'n':
                /* Predefined nice value */
                nice=atoi(optarg);
                break;
            default:
                fprintf(stderr, "Usage: icpagent [-d] [-t delay time] [-p port] [-n nice] [-r reply to every rth query] -m\n");
                exit(-1);
        }
    }

    /* Initialize event queue */
    TAILQ_INIT(&head);

    /* Renice */
    setpriority(PRIO_PROCESS,getpid(),nice);

    /* Initialize server socket */
    s = socket(PF_INET, SOCK_DGRAM, 0);
    me.sin_family = AF_INET;
    me.sin_port = htons(port);

    if (bind(s, (struct sockaddr *) &me, sizeof(me)) < 0) {
	printf("Unable to bind a socket");
	exit(-1);
    }

    /* Static delays */
    t_int = (int)t;
    frac = 100000*(t - t_int + 0.0000001);
    if(frac > 0)
        step = 100000.0 / (float)frac;
    // printf("frac: %d, step: %f\n",frac,step);
    for (;;) {
	bzero(&them, sizeof(them));
	rsize = sizeof(them);
	processqueue();
	FD_ZERO(&readfds);
	FD_SET(s,&readfds);
        wait.tv_sec = 0;
        wait.tv_usec = 1000;
	select(s+1,&readfds,NULL,NULL,(TAILQ_EMPTY(&head)?NULL:&wait));
	if (FD_ISSET(s,&readfds)) {
	rlen =
	    recvfrom(s, msgbuf, sizeof(msgbuf), 0,
			 (struct sockaddr *) &them, &rsize);
	    memcpy(&header, msgbuf, sizeof(header));
	    header.length = ntohs(header.length);
	    header.reqnum = ntohl(header.reqnum);
	    header.flags = ntohl(header.flags);
	    header.pad = ntohl(header.pad);
	    url = msgbuf + sizeof(header) + 4;
            msgbuf[rlen]='\0';
	    if (rlen != header.length)
		continue;

            /* enable or disable agent hit responses on management requests
             * -m should be enabled for that 
             */
            if (remotemanage && !strcmp(url,"agent://enable"))
                opcode=ICP_HIT;
            else if (remotemanage && !strcmp(url,"agent://disable"))
                opcode=ICP_MISS;
	    if (t<0) 
		    queuereply(them,ICP_MISS, url, header.reqnum,0);
            else {
                if(maincount == (int)stepsum || maincount == 999999 ) {
                    t_adjust = 1;
                    stepsum += step;
                } else {
                    t_adjust = 0;
                }

                if(maincount % replynth == 0)
                    queuereply(them, opcode, url, header.reqnum, t_int+t_adjust);
            }
            
            if(maincount == 999999) {
                maincount = 0;
                stepsum=0;
            } else {
                ++maincount;
            }
        }
    }
}
