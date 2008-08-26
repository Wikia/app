#ifndef UTF8_H
#define UTF8_H
void findUtf8(const unsigned char *ptr, int *start, int *length);
void findZhSentence(const unsigned char *ptr, int *start, int *length);
#endif
