#ifndef MYSTRING_H
#define MYSTRING_H
typedef struct mystring {
  int size, pos;
  unsigned char *ptr;
} MyString;

MyString *newMyString(int size);
int myStringAppend(MyString *ms, const unsigned char *str, int len, int mode);
void *deleteMyString(MyString *ms);
#endif
