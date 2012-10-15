#ifndef SERVER_H
#define SERVER_H

typedef struct connection {
  int clientSocket;
  int state, nextstate;
  char cmdline[512];
  unsigned char *input, *output;
  int isize, osize, csize;
  int cpos, ipos, opos;
  int next;
} connection;

extern Tnode *dictSeg; //for word segmentation
extern Tnode *dictToCN; //conversion to zh-cn
extern Tnode *dictToTW; //zh-tw
extern Tnode *dictToHK; //zh-hk
extern Tnode *dictToSG; //zh-sg
extern int optSilent, optWarning;

/* connection status */
#define ZHSTATE_READCMD 10
#define ZHSTATE_READDATA 20
#define ZHSTATE_EATDATA 30
#define ZHSTATE_WRITEERROR 40
#define ZHSTATE_WRITECMD 50
#define ZHSTATE_WRITEDATA 60
#define ZHSTATE_CLOSING 70

/* error codes */
#define ZHERR_C_INPUTSIZE 100
#define ZHERR_C_LANGCODE  200
#define ZHERR_C_CMD       250
#define ZHERR_S_WORK      300
#define ZHERR_S_MEM       400
#define ZHERR_S_READ      500
#define ZHERR_S_BUSY      600

#endif
