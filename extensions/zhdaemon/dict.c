#include "include.h"
#include "ttree.h"
#include "dict.h"

WordCount *newWordCount(double v) {
  WordCount *w = (WordCount*)malloc(sizeof(WordCount));
  if(w)
    w->c = v;
  return w;
}

Tnode *loadSegmentationDictionary(const char *fname) {
  FILE *fp;
  unsigned char buf[1024], key[1024];
  double count;
  Tnode *tree=NULL;
  int i;
  WordCount *w;

  fp = fopen(fname, "r");
  if(!fp) {
    fprintf(stderr, "Cannot open dictionary %s\n", fname);
    return NULL;
  }
  while(fgets(buf, 1024, fp)) {
    if(buf[0]=='\n')
      continue;
    buf[strlen(buf)-1]='\0';
    i = sscanf(buf, "%s %lf", key, &count);
    if(i<1)
      continue;
    if(i==1)
      count = 1;
    w = newWordCount(count);
    if(!w) {
      fprintf(stderr, "Out of memory loading dictionary.\n");
      exit(-1);
    }
    tree = insert(tree, key, (void*)w);
  }
  fclose(fp);
  return tree; 
}

/* parse a line in the conversion table. fill in the
   FROM field and return the TO field
*/
unsigned char *parseConversionLine(unsigned char *line, unsigned char *from) {
  unsigned char *to;
  int i, s, e;
  for(s=0; line[s]!='"'; s++);
  for(e=s+1; line[e]!='"'; e++);
  for(i=0;i<e-s-1;i++)
    from[i] = line[s+i+1];
  from[i]='\0';
  
  for(s=e+1; line[s]!='"'; s++);
  for(e=s+1; line[e]!='"'; e++);
  to=(unsigned char*)malloc(sizeof(unsigned char) * (e-s+1));
  for(i=0;i<e-s-1;i++)
    to[i]=line[s+i+1];
  to[i]='\0';
  return to;
}

Tnode *loadConversionDictionary(const char *fname) {
  FILE *fp;
  unsigned char buf[1024], from[512], *to;
  Tnode *tree=NULL;
  fp = fopen(fname, "r");
  if(!fp) {
    fprintf(stderr, "Cannot open dictionary %s\n", fname);
    return NULL;
  }

  while(fgets(buf, 1024, fp)) {
    if(buf[0]=='\n')
      continue;
    to = parseConversionLine(buf, from);
    //printf("%s=>%s\n", from, to);
    tree = insert(tree, from, (void*)to);
  }
  fclose(fp);
  return tree;
}

Tnode *loadAdditionalConversionDictionary(Tnode *tree, const char *fname) {
  FILE *fp;
  unsigned char buf[1024], from[512], *to;

  fp = fopen(fname, "r");
  if(!fp) {
    fprintf(stderr, "Cannot open additional dictionary %s\n", fname);
    return NULL;
  }
  while(fgets(buf, 1024, fp)) {
    if(buf[0]=='\n')
      continue;
    to = parseConversionLine(buf, from);
    //printf("%s=>%s\n", from, to);
    tree = insertWithFree(tree, from, (void*)to);
  }
  fclose(fp);
  return tree;
}
