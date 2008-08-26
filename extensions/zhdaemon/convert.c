#include "include.h"
#include "ttree.h"
#include "zhdaemon.h"
#include "convert.h"

unsigned char *doConvert(const unsigned char *input, int len,
			 const Tnode *dict) {
  int ii, ri, rlen, c, m;
  unsigned char *r;

  if(!dict) {
    if(optWarning)
      fprintf(stderr, "doConvert() called with NULL dictionary.\n");
    return NULL;
  }

  rlen = len*2;
  r = (unsigned char*)malloc(sizeof(unsigned char) * rlen);
  if(!r) {
    if(optWarning)
      fprintf(stderr, "doConvert() out of memory.\n");
    return NULL;
  }

  ri = ii = 0;
  while( ii < len ) {
    unsigned char *alt = (unsigned char *)searchMax(dict, input+ii, &m);
    if(m==0) { // not found. copy the content up to the start of
               // the next UTF-8 byte.
      for(m=1;(input[ii+m]&0xc0)==0x80;m++);
    }
    if(ri+m+2>=rlen) {
      rlen=rlen*2;
      r = (unsigned char*)realloc(r, sizeof(unsigned char) * rlen);
      if(!r) {
	if(optWarning)
	  fprintf(stderr, "doConvert() out of memory.\n");
	return NULL;
      }
    }
    if(!alt) {
      for(c=0;c<m;c++)
	r[ri++] = input[ii+c];
    }
    else {
      for(c=0;alt[c];c++)
	r[ri++] = alt[c];
    }
    ii+=m;
  }
  r[ri++]='\0';
  return r;
}
