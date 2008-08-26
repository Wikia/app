#include "include.h"
#include "utf8.h"

/* utf8.c

   some utf8 related routins

*/

/*
Unicode                   UTF8
0x00000000 - 0x0000007F: 0xxxxxxx
0x00000080 - 0x000007FF: 110xxxxx 10xxxxxx
0x00000800 - 0x0000FFFF: 1110xxxx 10xxxxxx 10xxxxxx
0x00010000 - 0x001FFFFF: 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
0x00200000 - 0x03FFFFFF: 111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx
0x04000000 - 0x7FFFFFFF: 1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx

0000 0  0100 4    1000 8    1100 C
0001 1  0101 5    1001 9    1101 D
0010 2  0110 6    1010 A    1110 E
0011 3  0111 7    1011 B    1111 F

Unicode blocks for Han characters:

CJK Unified Ideographs:         U+4E00 - U+9FFF
CJK Unified Ideographs Ext. A:  U+3400 - U+4DFF
CJK Unified Ideographs Ext. B:  U+20000 - U+2A6DF
CJK Compatibility Ideographs:   U+F900 - U+FAFF
CJK Compatibility Supplement:   U+2F800 - U+2FA1F
*/


/* find the next legal utf8 character in the string ponited by ptr

   the utf8 character, if found, is pointed by PTR+START, with LENGTH
*/
void findUtf8(const unsigned char *ptr, int *start, int *length) {
  const unsigned char *p;
  int s,i,f;
  p = ptr;
  s = 0;
  while(1) {
    while(p[s]) {
      if((p[s]&0xc0) != 0x80)
	break;
      s++;
    }
    if(!p[s]) {//not found
      *start = -1;
      return;
    }
    *start = s;

    if(p[s]<0xc0) {//ascii
      *length = 1;
      return;
    }

    if((p[s]>0xfd) || ((p[s+1]&0xc0) != 0x80)) {//illegal byte, skip
      s++;
      continue;
    }

    if(p[s]<0xe0) {
      *length = 2;
      return;
    }

    if((p[s+2]&0xc0) != 0x80) {//illegal byte, skip
      s+=2;
      continue;
    }
    if(p[s]<0xf0) {
      *length = 3;
      return;
    }

    if((p[s+3]&0xc0) != 0x80) {//illegal byte, skip
      s+=3;
      continue;
    }
    if(p[s]<0xf8) {
      *length = 4;
      return;
    }

    if((p[s+4]&0xc0) != 0x80) {//illegal byte, skip
      s+=4;
      continue;
    }
    if(p[s]<0xfc) {
      *length = 5;
      return;
    }

    if((p[s+5]&0xc0) != 0x80) {//illegal byte, skip
      s+=5;
      continue;
    }
    // p[s] must be <= 0xfd here
    *length = 6;
    return;
  }
}

/* find the next sentence in the string pointed by ptr

   here "sentence" is not used in its strict linguist sense, but rather 
   just a consequtive sequence of Chinese characters in the CJK unified 
   ideographs block (U+4E00 - U+9FFF) and extension A block 
   (U+3400 - U+4DFF). Together, the unicode range we are looking for is 
   U+3400 to U+9FFF, which translates to utf8 as:

   1110 0011 1001 0000 1000 0000  to
   1110 1001 1011 1111 1011 1111

   or E3 90 80 to E9 BF BF

   All other characters outside this range are treated as sentence 
   boundaries.

*/
#define UGE(p) ((p)[0]>0xe3? 1 : ((p)[0]!=0x3e? 0 : \
              ((p)[1]>0x90? 1 : ((p)[1]!=0x90? 0 : \
              ((p)[2]>0x80? 1 : ((p)[2]!=0x80? 0 : 1) ) ) ) ) )
#define ULE(p) ((p)[0]<0xe9? 1 : ((p)[0]!=0xe9? 0 : \
              ((p)[1]<0xbf? 1 : ((p)[1]!=0xbf? 0 : \
              ((p)[2]<0xbf? 1 : ((p)[2]!=0xbf? 0 : 1) ) ) ) ) )

#define INRANGE(p) (UGE(p) && ULE (p))

void findZhSentence(const unsigned char *ptr, int *start, int *length) {
  int cstart, clen;
  int sstart, slen;
  const unsigned char *p, *t;

  p = ptr;
  sstart = 0;
  /* find start of sentence */

  while(1) {
    findUtf8(p, &cstart, &clen);
    if(cstart == -1) {
      *start = -1;
      return;
    }
    p += cstart+clen;
    sstart += cstart;
    if(clen!=3) {
      sstart += clen;
      continue;
    }
    if(INRANGE(ptr+sstart)) {
      break;
    }
    sstart += clen;
  }

  /* moving forward */
  p = ptr + sstart + 3;
  slen=3;
  while(1) {
    findUtf8(p, &cstart, &clen);
    if(cstart != 0)
      break;
    if(clen != 3)
      break;
    if(!INRANGE(p+cstart))
      break;
    slen+=3;
    p+=3;
  }
  *start = sstart;
  *length = slen;
}
