#include "include.h"
#include "mystring.h"

MyString *newMyString(int size) {
  MyString *ms = (MyString *)malloc(sizeof(MyString));
  if(!ms)
    return NULL;
  ms->size = size;
  ms->pos = 0;
  ms->ptr = (unsigned char*)malloc(sizeof(unsigned char) * size);
  if(!ms->ptr) {
    free(ms);
    return NULL;
  }
  ms->ptr[0]='\0';
  return ms;
}

/* 
   ! The string is assumed to be in utf8 and each character is 3 bytes long !
   mode 0 : append the string as a single word
   mode 1 : append the string, separated as single characters
*/
int myStringAppend(MyString *ms, const unsigned char *str, int len, int mode) {
  int i;
  int extra=0;
  if(!ms || !str) {
    fprintf(stderr, "Fatal: called myStringAppend() with NULL pointer(s)\n");
    exit(-1);
  }
  /*
  printf("appendword: len=%d, size=%d, pos=%d\n",
	 len, ms->size, ms->pos);
  */
  if(mode == 1)
    extra = len/3;
  if(ms->pos+len+extra >= ms->size-2) {
    int newsize=ms->size*2;
    unsigned char *ptr;
    while(newsize-2 < ms->pos+len)
      newsize *=2;
    ptr = (unsigned char*)realloc(ms->ptr, sizeof(unsigned char) * newsize);
    if(!ptr) {
      fprintf(stderr, "myStringAppend(): Out of memory.\n");
      return -1;
    }
    ms->ptr = ptr;
    ms->size = newsize;
  }
  if(ms->pos)
    ms->ptr[ms->pos++] = ' ';
  for(i=0;i<len;i++) {
    if(i>0 && mode == 1 && i%3==0)
      ms->ptr[ms->pos++] = ' ';
    ms->ptr[ms->pos++] = str[i];
  }

  ms->ptr[ms->pos] = '\0';
  return 0;
}
