#include "include.h"
#include "ttree.h"
#include "zhdaemon.h"
#include "utf8.h"
#include "mystring.h"
#include "dict.h"
#include "segment.h"

/* a very simple max matching segmentor */
unsigned char *segmentMaxMatching(const unsigned char *input, int len) {
  int ii, ri, rlen, c;
  unsigned char *r;
  int appendspace, found;
  rlen = len*2;
  r = (unsigned char*)malloc(sizeof(unsigned char) * rlen);
  if(!r) {
    if(optWarning)
      fprintf(stderr, "segmentMaxMatching() out of memory.\n");
    return NULL;
  }
  appendspace = 1;
  ri = ii = 0;
  while( ii < len ) {
    int k, m;
    k = (int)searchMax(dictSeg, input+ii, &m);
    if(m==0) { // not found. copy the content up to the start of
               // the next UTF-8 byte.
      for(m=1; ii+m<len && (input[ii+m]&0xc0)==0x80;m++);
      appendspace = 0;
      found = 0;
    }
    else {
      found = 1;
    }

    if(ri+m+2>=rlen) {
      rlen=rlen*2;
      r = (unsigned char*)realloc(r, sizeof(unsigned char) * rlen);
      if(!r) {
	if(optWarning)
	  fprintf(stderr, "segmentMaxMatching() out of memory.\n");
	return NULL;
      }
    }
    if(found && !appendspace) {
      appendspace = 1;
      r[ri++] = ' ';
    }
    for(c=0;c<m;c++)
      r[ri++] = input[ii+c];
    if(appendspace)
      r[ri++]=' ';
    ii+=m;
  }
  r[ri++]='\0';
  return r;
}


double getwordcount(const unsigned char *s, int len) {
  WordCount *count;
  int i;
  if(len==3)
    return 0;
  
  printf("getcount of:");
  for(i=0;i<len;i++)
    printf("%c", s[i]);
  printf("\n");
  
  count = (WordCount*)searchn(dictSeg, s, len);

  if(count){
    printf("found %e\n", count->c);
    return count->c;
  }
    printf("not found\n");
  return 1;
}

/* 
   segment a sentence using dynamic programming based on word counts

   result is stored in the global array Val and Next, which may or may
   not point to Vmem and Nmem
*/

/* normal length of a sentence */
#define MAXLEN 1000
double Vmem[MAXLEN+1], *Val;
int Nmem[MAXLEN], *Next;
int segmentSentenceDP(const unsigned char *input, int len) {
  int n = len/3;
  int i,j;
  double t;
  WordCount *w;
  if(n<MAXLEN) {
    Val = Vmem;
    Next = Nmem;
  }
  else {
    Val = (double*)malloc(sizeof(double) * (n+1));
    Next = (int *)malloc(sizeof(int) * n);
    if(!Val || !Next) {
      if(optWarning)
	fprintf(stderr, "segmentSentenceDP() out of memory.\n");
      if(Val)
	free(Val);
      if(Next)
	free(Next);
      return -1;
    }
  }

  /* first segment the sentence */
  for(i=0;i<n;i++) {
    Val[i] = 0.0;
    Next[i] = n;
  }
  Val[n] = 0.0;
  for(i=n-1;i>=0;i--) {
    Val[i] = getwordcount(input+3*i, (n-i)*3);
    for(j = i+1; j<n && j-i < 10 ;j++) {
      t = Val[j] + getwordcount(input+3*i, (j-i)*3);
      if(t > Val[i]) {
	Val[i] = t;
	Next[i] = j;
      }
    }
  }

  

  if(Val != Vmem)
    free(Val);
  return 0;
}


/* segment using dynamic programming */
unsigned char *segmentDP(const unsigned char *input, int len) {
  int ii, ri, rlen, c, i;
  int appendspace, found;
  MyString *r;
  unsigned char *ptr;
  int failed = 0;
  r = newMyString(len*2);
  if(!r) {
    if(optWarning)
      fprintf(stderr, "segmentMaxMatching() out of memory.\n");
    return NULL;
  }
  appendspace = 1;
  ri = ii = 0;
  while( ii < len ) {
    int k, m;
    findZhSentence(input+ii, &k, &m);
    if(k==-1) { // nothing more to be done
      if(myStringAppend(r, input+ii, len-ii, 0)) {
	failed = 1;
	break;
      }
      break;
    }
    else {
      /*
      printf("Got sentence:");
      for(i=0;i<m;i++) 
	printf("%c", input[ii+k+i]);
      printf("\n");
      */
      if(k!=0) {
	/*
	printf("Appending before:");
	for(i=0;i<k;i++)
	  printf("%c", input[ii+i]);
	printf("\n");
	*/
	if(myStringAppend(r, input+ii, k, 0)) {
	  failed = 1;
	  break;
	}
	ii+=k;
      }
      if(segmentSentenceDP(input+ii, m)) {
	failed = 1;
	break;
      }

      for(i=0;i<m/3;i=Next[i]) {
	int mode;
	/*
	printf("Append WORD:");
	for(k=i*3;k<Next[i]*3;k++)
	  printf("%c", input[ii+k]);
	printf("\n");
	*/
	mode = (searchn(dictSeg, input+ii+i*3, (Next[i]-i)*3)==NULL);
	if(myStringAppend(r, input+ii+i*3, (Next[i]-i)*3, mode)) {
	  failed = 1;
	  break;
	}
      }
      if(failed)
	break;
      ii += m;
      //      printf("ii=%d, len=%d\n", ii, len);
    }
  }
  if(Next != Nmem)
    free(Next);

  if(failed) {
    free(r->ptr);
    free(r);
    return NULL;
  }
  ptr = r->ptr;
  free(r);
  return ptr;
}

unsigned char *doSegment(const unsigned char *input, int len) {
  return segmentDP(input, len);
}
