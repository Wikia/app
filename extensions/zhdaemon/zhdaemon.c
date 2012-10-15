#include "include.h"
#include "ttree.h"
#include "dict.h"
#include "segment.h"
#include "convert.h"
#include "zhdaemon.h"

/* list of connections implemented as array */
connection *clist;
int usedc, freec;

/* the dictionaries.
*/
Tnode *dictSeg=NULL; //for word segmentation
Tnode *dictToCN=NULL; //conversion to zh-cn
Tnode *dictToTW=NULL; //zh-tw
Tnode *dictToHK=NULL; //zh-hk
Tnode *dictToSG=NULL; //zh-sg

/* command line options */
char *optConfFile="./zhdaemon.conf";
int optSilent=0, optWarning=1;

void usage() {
  exit(0);
}

void processArg(int argc, char *argv[]) {

}


/* configuration options */
int confServerPort;
char *confDictSeg, *confDictToCN, *confDictToTW, *confDictToHK, *confDictToSG;
int confInputLimit;
int confMaxConnections;

void loadConf(char *conffile) {
  cfg_opt_t opts[] =
    {
      CFG_STR("dictSeg",  "/usr/local/share/zhdaemons/wordlist", CFGF_NONE),
      CFG_STR("dictToCN", "/usr/local/share/zhdaemons/tocn.dict", CFGF_NONE),
      CFG_STR("dictToTW", "/usr/local/share/zhdaemons/totw.dict", CFGF_NONE),
      CFG_STR("dictToHK", "/usr/local/share/zhdaemons/tohk.dict", CFGF_NONE),
      CFG_STR("dictToSG", "/usr/local/share/zhdaemons/tosg.dict", CFGF_NONE),
      CFG_INT("serverPort", 2004, CFGF_NONE),
      CFG_INT("inputLimit", 1048576, CFGF_NONE),
      CFG_INT("maxConnections", FD_SETSIZE, CFGF_NONE),
      CFG_END()
    };
  cfg_t *cfg;
  
  cfg = cfg_init(opts, CFGF_NONE);
  if(cfg_parse(cfg, conffile) == CFG_PARSE_ERROR) {
    exit(-1);
  }
  confServerPort = cfg_getint(cfg, "serverPort");
  confInputLimit = cfg_getint(cfg, "inputLimit");
  confMaxConnections = cfg_getint(cfg, "maxConnections");
  if(confMaxConnections > FD_SETSIZE) {
    confMaxConnections = FD_SETSIZE;
    fprintf(stderr, "Warning: maxConnection too large; resetting to %d\n", FD_SETSIZE);
  }
  confDictSeg = cfg_getstr(cfg, "dictSeg");
  confDictToCN = cfg_getstr(cfg, "dictToCN");
  confDictToTW = cfg_getstr(cfg, "dictToTW");
  confDictToHK = cfg_getstr(cfg, "dictToHK");
  confDictToSG = cfg_getstr(cfg, "dictToSG");

  printf("\nConfiguration:\n");
  printf("serverPort = %d\n", confServerPort);
  printf("inputLimit = %d\n", confInputLimit);
  printf("maxConnections = %d\n", confMaxConnections);
  printf("dictSeg = %s\n", confDictSeg);
  printf("dictToCN = %s\n", confDictToCN);
  printf("dictToTW = %s\n", confDictToTW);
  printf("dictToHK = %s\n", confDictToHK);
  printf("dictToSG = %s\n\n", confDictToSG);
}

/* load all dictionaries */
void loadDict() {
  printf("Loading segmentation dictionary from %s...\n",
	 confDictSeg); fflush(0);
  dictSeg = loadSegmentationDictionary(confDictSeg);
  if(!dictSeg) {
    exit(-1);
  }

  printf("Loading conversion dictionary %s...", confDictToCN);fflush(0);
  dictToCN = loadConversionDictionary(confDictToCN);
  if(!dictToCN) 
    exit(-1);
  
  printf("Loading conversion dictionary %s...", confDictToTW);fflush(0);
  dictToTW = loadConversionDictionary(confDictToTW);
  if(!dictToTW)
    exit(-1);
  
  printf("Loading conversion dictionary %s (as the basis for toHK)...\n", confDictToTW);fflush(0);
  dictToHK = loadConversionDictionary(confDictToTW);
  if(!dictToHK) {
    exit(-1);
  }
  printf("Loading conversion dictionary %s...\n", confDictToHK);fflush(0);
  dictToHK = loadAdditionalConversionDictionary(dictToHK, confDictToHK);
  if(!dictToHK) {
    exit(-1);
  }
  
  printf("Loading conversion dictionary %s (as the basis for toSG)...", confDictToCN); fflush(0);
  dictToSG = loadConversionDictionary(confDictToCN);
  if(!dictToSG) {
    exit(-1);
  }
  printf("Loading conversion dictionary %s...\n", confDictToSG);fflush(0);
  dictToSG = loadAdditionalConversionDictionary(dictToSG, confDictToSG);
  if(!dictToSG) {
    exit(-1);
  }
  printf("\n\n");

}

void setnonblocking(int sock) {
  int opts;
  
  opts = fcntl(sock,F_GETFL);
  if (opts < 0) {
    fprintf(stderr, "fcntl failed GETFL.\n");
    exit(-1);
  }
  opts = (opts | O_NONBLOCK);
  if (fcntl(sock,F_SETFL,opts) < 0) {
    fprintf(stderr, "fcntl failed SETFL.\n");
    exit(-1);
  }
}

/* reset a connection struct */
void initConnection(connection *c, int fd) {
  c->clientSocket = fd;
  c->state = ZHSTATE_READCMD;
  c->nextstate = -1;
  if(c->input) {
    free(c->input);
    c->input = NULL;
  }
  if(c->output) {
    free(c->output);
    c->output = NULL;
  }
  c->ipos = c->opos = c->cpos = c->isize = c->osize = 0;
}

void newconnection(int serverSocket) {
  int clientSocket;
  int n;
  clientSocket = accept(serverSocket, NULL, NULL);
  if(clientSocket < 0) {
    fprintf(stderr, "accept() failed.\n");
    return;
  }
  setnonblocking(clientSocket);

  if(freec==-1) { // no more connection slot left
    char c[100];
    sprintf(c, "ERROR %d\r\n", ZHERR_S_BUSY);
    write(clientSocket, c, strlen(c));
    close(clientSocket);
    return;
  }

  /* remove from freec and add to usedc */
  n = freec;
  freec = clist[freec].next;
  clist[n].next = usedc;
  usedc = n;

  initConnection(clist+n, clientSocket);
  printf("New connection %d\n", clientSocket);
  return;
}

/* determine if we should close the connection */
int shouldclose(int s) {
  if(s<0) {
    if(errno == EINTR || errno == EAGAIN || errno==EWOULDBLOCK)
      return 0;
    fprintf(stderr, "read error: %s\n", strerror(errno));
    return 1;
  }
  if(s==0) {
    printf("client closing connection.\n" );
    return 1;
  }
  return 0;
}

void uppercase(char *s, int len) {
  int i;
  for(i=0;i<len && s[i];i++) {
    if(s[i]>='a' && s[i]<='z')
      s[i] -= 'a'-'A';
  }
}

void formerror(connection *c, int code) {
  printf("returning error %d\n", code);
  sprintf(c->cmdline, "ERROR %d\r\n", code);
  c->csize = strlen(c->cmdline);
  c->cpos = 0;
  c->state = ZHSTATE_WRITEERROR;
}


void processcmd(connection *c) {
  char cmd[512], arg[512];
  int size;
  uppercase(c->cmdline, strlen(c->cmdline));
  printf("Got cmdline=%s!\n", c->cmdline);
  c->nextstate = -1;
  if(sscanf(c->cmdline, "%s", cmd)!=1) {
    formerror(c, ZHERR_C_CMD);
    return;
  }
  if(strcmp(cmd, "SEG")==0) {
    if(sscanf(c->cmdline, "%s %d", cmd, &size)!=2) {
      formerror(c, ZHERR_C_INPUTSIZE);
      c->nextstate = ZHSTATE_CLOSING;
      return;
    }
  }
  else if(strcmp(cmd, "CONV") == 0) {
    if(sscanf(c->cmdline, "%s %s %d", cmd, arg, &size) !=3) {
      formerror(c, ZHERR_C_CMD);
      c->nextstate = ZHSTATE_CLOSING;
      return;
    }
    if(strcmp(arg, "ALL") != 0 &&
       strcmp(arg, "ZH-CN")!=0 &&
       strcmp(arg, "ZH-TW")!=0 &&
       strcmp(arg, "ZH-HK")!=0 &&
       strcmp(arg, "ZH-SG")!=0) {
      formerror(c, ZHERR_C_LANGCODE);
      c->nextstate = ZHSTATE_CLOSING;
      return;
    }
  }
  else {
    formerror(c, ZHERR_C_CMD);
    c->nextstate = ZHSTATE_CLOSING;
    return;
  }
  
  if(size > confInputLimit) {
    formerror(c, ZHERR_C_INPUTSIZE);
    c->nextstate = ZHSTATE_EATDATA;
    return;
  }
  c->isize = size;
  c->ipos = 0;
  c->input = (unsigned char *)malloc(sizeof(unsigned char) * (size+1));
  if(!c->input) {
    formerror(c, ZHERR_S_MEM);
    c->nextstate = ZHSTATE_EATDATA;
    return;
  }
  printf("get request: %sparsed data size %d\n", c->cmdline, size);
  c->state = ZHSTATE_READDATA;
  return;
}

void processdata(connection *c) {
  char cmd[512], arg[512];
  char *result;
  Tnode *dict;

  sscanf(c->cmdline, "%s", cmd);
  if(strcmp(cmd, "SEG")==0) {
    result = doSegment(c->input, c->isize);
  }
  else if(strcmp(cmd, "CONV") == 0) {
    sscanf(c->cmdline, "%s %s", cmd, arg);
    if(strcmp(arg, "ALL") == 0)
      dict = NULL;
    else if(strcmp(arg, "ZH-CN") == 0)
      dict = dictToCN;
    else if(strcmp(arg, "ZH-TW") == 0)
      dict = dictToTW;
    else if(strcmp(arg, "ZH-HK") == 0)
      dict = dictToHK;
    else if(strcmp(arg, "ZH-SG") == 0)
      dict = dictToSG;
    else {
      fprintf(stderr, "Fatal: unknown language code %s shouldn't appear here...\n", arg);
      exit(-1);
    }
    if(dict)
      result = doConvert(c->input, c->isize, dict);
    else { // want to get all variants
      char info[1024];//holds result info
      char *rcn, *rtw, *rhk, *rsg;
      int lcn, ltw, lhk, lsg;
      rcn = doConvert(c->input, c->isize, dictToCN);
      rtw = doConvert(c->input, c->isize, dictToTW);
      rhk = doConvert(c->input, c->isize, dictToHK);
      rsg = doConvert(c->input, c->isize, dictToSG);
      if(!rcn || !rtw || !rhk || !rsg) {
	formerror(c, ZHERR_S_WORK);
	return;
      }
      lcn = strlen(rcn);
      ltw = strlen(rtw);
      lhk = strlen(rhk);
      lsg = strlen(rsg);
      sprintf(info, "ZH-CN %d;ZH-TW %d;ZH-HK %d;ZH-SG %d|",
	      lcn, ltw, lhk, lsg);
      result = (unsigned char *)malloc(sizeof(unsigned char) * 
				       (lcn + ltw + lhk + lsg + strlen(info)+1));
      printf("Calculated length=%d\n",
	     (lcn + ltw + lhk + lsg + strlen(info)+1));
      if(!result) {
	formerror(c, ZHERR_S_MEM);
	free(rcn);
	free(rtw);
	free(rhk);
	free(rsg);
	return;
      }
      sprintf(result, "%s%s%s%s%s",
	      info, rcn, rtw, rhk, rsg);
      printf("actual length=%d\n",
	     strlen(result));
      printf("ALL: %s\n", result);
    }
  }
  else {
    fprintf(stderr, "Fatal: unknown command %s shouldn't appear here...\n", cmd);
    exit(-1);
  }
  if(!result) {
    formerror(c, ZHERR_S_WORK);
    return;
  }

  c->output = result;
  c->osize = strlen(result);
  sprintf(c->cmdline, "OK %d\r\n", c->osize);
  printf("Sending cmd: %s", c->cmdline);
  c->csize = strlen(c->cmdline);
  c->cpos = 0;
  c->state = ZHSTATE_WRITECMD;
}

void closeconnection(connection *c) {
  close(c->clientSocket);
  initConnection(c, 0);
}

size_t readlinefd(char *ptr, size_t len, int fd) {
  size_t n, r;
  char c;
  
  for(n=0;n < len-1; n++) {
    r = read(fd, &c, 1);
    if(r==0) {// eof
      ptr[n]='\0';
      break;
    }
    else if(r<0) {
      if(errno == EINTR || errno == EAGAIN || errno == EWOULDBLOCK)
	break;
      else
	return -1;//error
    }
    ptr[n] = c;
    if(c == '\n') {
      n++;
      ptr[n]='\0';
      break;
    }
  }
  return n;
}

void connectionRead(connection *c) {
  int s;
  char buf[1024];
  switch(c->state) {
  case ZHSTATE_READCMD:
    s = readlinefd(c->cmdline+c->cpos, sizeof(c->cmdline)-c->cpos, c->clientSocket);
    if(shouldclose(s))
      closeconnection(c);
    else {
      c->cpos+=s;
      if(c->cmdline[c->cpos-1]=='\n')
	processcmd(c); // perform memory allocation, etc
    }
    break;
  case ZHSTATE_READDATA:
    printf("Reading data...\n");
    s = read(c->clientSocket, c->input+c->ipos, c->isize - c->ipos);
    printf("Status = %d\n", s);

    if(shouldclose(s))
      closeconnection(c);
    else if(s>0) {
      c->ipos+=s;
      if(c->ipos == c->isize) {// got all data
        //terminate with \0
        c->input[c->ipos]='\0';
	processdata(c); // perform conversion, etc. also update state
      }
    }
    break;
  case ZHSTATE_EATDATA:
    while(1) {
      s = read(c->clientSocket, buf, sizeof(buf));
      if(shouldclose(s)) 
	closeconnection(c);
      else if(s>0){
	c->ipos += s;
	if(c->ipos == c->isize) {
	  c->state = ZHSTATE_READCMD;
	  break;
	}
      }
      else
	break;
    }
    break;
  }
}

void connectionWrite(connection *c) {
  int s;
  switch (c->state) {
  case ZHSTATE_WRITEERROR:
    printf("WRITEERROR\n");
    s = write(c->clientSocket, c->cmdline + c->cpos, c->csize - c->cpos);
    if(shouldclose(s))
      closeconnection(c);
    else if(s>0) {
      c->cpos += s;
      if(c->cpos == c->csize) {
	c->state = c->nextstate;
	c->nextstate = -1;
	if(c->state == ZHSTATE_CLOSING) {
	  closeconnection(c);
	  break;
	}
	else if(c->state == -1) {
	  c->state=ZHSTATE_READCMD;
	}
	initConnection(c, c->clientSocket);
      }
    }
    break;
  case ZHSTATE_WRITECMD:
    printf("WRITECMD %s, csize=%d, cpos=%d\n", c->cmdline, c->csize, c->cpos);
    s = write(c->clientSocket, c->cmdline + c->cpos, c->csize - c->cpos);
    if(shouldclose(s))
      closeconnection(c);
    else if(s>0) {
      c->cpos += s;
      if(c->cpos == c->csize)
	c->state=ZHSTATE_WRITEDATA;
    }
    break;
  case ZHSTATE_WRITEDATA:
    printf("WRITEDATA\n");
    s = write(c->clientSocket, c->output + c->opos, c->osize - c->opos);
    if(shouldclose(s))
      closeconnection(c);
    else if(s>0) {
      c->opos += s;
      if(c->opos == c->osize) {
	c->state=ZHSTATE_READCMD;
	initConnection(c, c->clientSocket);
      }
    }
    break;
  }
}

int main(int argc, char *argv[])
{
  int serverSocket;
  struct sockaddr_in serverAddress;
  int status;
  int count=0;
  int reuseport=1;
  int highfd;
  int i, nactive;
  struct sigaction sa;

  fd_set readset, writeset;

  processArg(argc, argv);
  loadConf(optConfFile);

  loadDict();

  clist = (connection*)malloc(sizeof(connection) * confMaxConnections);
  if(!clist) {
    fprintf(stderr, "Out of memory allocating clist\n");
    exit(-1);
  }

  usedc = -1;
  freec = 0;
  for(i=0;i<confMaxConnections;i++) {
    initConnection(clist+i, 0);
    if(i==confMaxConnections-1)
      clist[i].next = -1;
    else
      clist[i].next = i+1;
  }

  // ignore SIGPIPE
  sa.sa_handler = SIG_IGN;
  sa.sa_flags = 0;
  if(sigemptyset(&sa.sa_mask) == -1) {
    fprintf(stderr, "sigemptyset() failed.\n");
    exit(-1);
  }
  if(sigaction(SIGPIPE, &sa, 0) == -1) {
    fprintf(stderr, "sigaction() failed on SIGPIPE\n");
    exit(-1); 
  }
    

  /* open server socket */  
  serverSocket = socket(PF_INET,SOCK_STREAM,0);
  if (serverSocket <= 0) {
    fprintf(stderr, "server: Failed creating socket.\n");
    exit(-1);
  }

  /* avoid "port in use"... */
  setsockopt(serverSocket, SOL_SOCKET, SO_REUSEADDR, &reuseport,
	     sizeof(reuseport));

  setnonblocking(serverSocket);

  serverAddress.sin_family=AF_INET;
  serverAddress.sin_addr.s_addr = INADDR_ANY;
  serverAddress.sin_port  = htons(confServerPort);
  
  status = bind(serverSocket,
		(struct sockaddr*) &serverAddress, 
		sizeof(serverAddress));
  
  if (status != 0) {
    fprintf(stderr, "error: bind() failed.\n");
    exit(-1);
  }

  if(listen(serverSocket, confMaxConnections) == -1) {
    fprintf(stderr, "error: listen() failed.\n");
    exit(-1);
  }

  while(1) {
    /* reset fdsets */
    FD_ZERO(&readset);
    FD_ZERO(&writeset);

    /* listening socket */
    FD_SET(serverSocket, &readset);

    highfd = serverSocket;

    /* move closed clients to freec */
    for(i=usedc; i!=-1 && clist[i].clientSocket == 0;) {
      int next = clist[i].next;
      clist[i].next = freec;
      freec = i;
      i = usedc = next;
    }
    for(i=usedc;i!=-1;i=clist[i].next) {
      int next = clist[i].next;
      if(next!=-1) {
	if(clist[next].clientSocket == 0) {
	  clist[i].next = clist[next].next;
	  clist[next].next = freec;
	  freec = next;
	}
      }
    }

    for(i=usedc;i!=-1;i=clist[i].next) {
      FD_SET(clist[i].clientSocket, &readset);
      if(clist[i].state == ZHSTATE_WRITEERROR ||
	 clist[i].state == ZHSTATE_WRITECMD ||
	 clist[i].state == ZHSTATE_WRITEDATA)
	FD_SET(clist[i].clientSocket, &writeset);
      if(clist[i].clientSocket > highfd)
	highfd = clist[i].clientSocket;
    }

    nactive = select(highfd+1, &readset, &writeset, NULL, NULL);
    
    if(nactive <= 0) {
      fprintf(stderr, "select() failed!\n");
      exit(-1);
    }

    for(i=usedc;i!=-1;i=clist[i].next) {
      if( FD_ISSET(clist[i].clientSocket, &readset)) {
	printf("%d read\n", i);
	connectionRead(clist+i);
      }
      if( FD_ISSET(clist[i].clientSocket, &writeset)) {
	printf("%d write\n", i);
	connectionWrite(clist+i);
      }
      fflush(0);
    }

    if(FD_ISSET(serverSocket, &readset)) {
      newconnection(serverSocket);
      printf("------------------------------- accepting client %d\n", count++);
    }
  }
  return 1;
}
