/*
  Implementing ternary search tree

  The implementation here are adapted from example code from
  http://home.od.ua/~relayer/algo/data/tern/lead.htm

*/

#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include "ttree.h"

Tnode *newTnode() {
  Tnode *t = (Tnode*)malloc(sizeof(Tnode));
  t->splitchar='\0';
  t->lokid = t->eqkid = t->hikid = NULL;
  t->data = NULL;
  return t;
}

/* insert a (non-empty!) string with associated data */
Tnode *insert(Tnode *t, const unsigned char *s, void *data)  { 
  /* sanity check... */
  if(s[0]=='\0') {
    printf("ttree.c:insert() called with empty string.\n");
    exit(-1);
  }
  if (t == NULL) { 
    t = newTnode();
    t->splitchar = s[0]; 
  } 
  if (s[0] < t->splitchar) {
    t->lokid = insert(t->lokid, s, data); 
  }
  else if (s[0] == t->splitchar) { 
    if (s[1] != '\0') 
      t->eqkid = insert(t->eqkid, ++s, data); 
    else 
      t->data = data;
  } else {
    t->hikid = insert(t->hikid, s, data); 
  }
  return t; 
}

/* insert a string and replace the existing data, if any
 NOTE: this assumes the existing data was created using *alloc()!!
*/
Tnode *insertWithFree(Tnode *t, const unsigned char *s, void *data)  { 
  /* sanity check... */
  if(s[0]=='\0') {
    printf("ttree.c:insert() called with empty string.\n");
    exit(-1);
  }
  if (t == NULL) { 
    t = newTnode();
    t->splitchar = s[0]; 
  } 
  if (s[0] < t->splitchar) {
    t->lokid = insert(t->lokid, s, data); 
  }
  else if (s[0] == t->splitchar) { 
    if (s[1] != '\0') 
      t->eqkid = insert(t->eqkid, ++s, data); 
    else {
      if(t->data)
	free(t->data);
      t->data = data;
    }
  } else {
    t->hikid = insert(t->hikid, s, data); 
  }
  return t; 
}

/* search for a string and return the associated data if found */
void *search(const Tnode *root, const unsigned char *s) { 
  const Tnode  *p; 
  if(s[0]=='\0')
    return NULL;
  p = root;
  while (p) { 
    if (s[0] < p->splitchar) 
      p = p->lokid; 
    else if (s[0] == p->splitchar) { 
      if (s[1] == 0)  
	return p->data;
      s++;
      p = p->eqkid; 
    } else { 
      p = p->hikid; 
    }
  }
  return NULL; 
} 


/* search for a string of length n 
   and return the associated data if found */
void *searchn(const Tnode *root, const unsigned char *s, int n) { 
  const Tnode  *p; 
  if(s[0]=='\0' || n ==0)
    return NULL;
  p = root;
  while (p) { 
    if (s[0] < p->splitchar) 
      p = p->lokid; 
    else if (s[0] == p->splitchar) {
      n--;
      if (s[1] == 0 || n == 0)  
	return p->data;
      s++;
      p = p->eqkid; 
    } else { 
      p = p->hikid; 
    }
  }
  return NULL; 
} 

/* find the max matching string in the tree. return the 
   associated data, and set LEN to the matching length
*/
void *searchMax(const Tnode *root, const unsigned char *s, int *len) {
  const Tnode  *p; 
  void *data=NULL;
  int maxlen=0, i=0;

  if(s[0]=='\0') {
    *len = 0;
    return NULL;
  }
  p = root;
  while (p) { 
    if (s[0] < p->splitchar) 
      p = p->lokid; 
    else if (s[0] == p->splitchar) { 
      i++;
      if(p->data) {
	data = p->data;
	maxlen = i;
      }
      if (s[1] == 0)  
	break;
      s++;
      p = p->eqkid; 
    } else { 
      p = p->hikid; 
    }
  }
  *len = maxlen;
  return data; 
}


/* 
   find all possible matching string in the tree. store each match
   in lenarray and dataarray, and return the number of matches. 
   the lenarray and dataarray are assumed to be large enough!!
*/
int searchAll(const Tnode *root, const unsigned char *s, int *lenarray, void *dataarray[]) {
  const Tnode  *p; 
  int count=0, i=0;
  if(s[0]=='\0') {
    return 0;
  }
  p = root;
  while (p) { 
    if (s[0] < p->splitchar) 
      p = p->lokid; 
    else if (s[0] == p->splitchar) { 
      i++;
      if(p->data) {
	dataarray[count] = p->data;
	lenarray[count] = i;
	count++;
      }
      if (s[1] == 0)  
	break;
      s++;
      p = p->eqkid; 
    } else { 
      p = p->hikid; 
    }
  }
  return count;
}

void traverseRecur(Tnode *p, unsigned char *buf, int i) {
  if (!p) return; 
  traverseRecur(p->lokid, buf, i); 
  if (p->splitchar) {
    buf[i]=p->splitchar;
    if(p->data) {
      buf[i+1]='\0';
      printf("%s\n", buf);
    }
    traverseRecur(p->eqkid, buf, i+1); 
  }
  traverseRecur(p->hikid, buf, i); 
}
void traverse(Tnode *p)  {
  unsigned char buf[1024];
  traverseRecur(p, buf, 0);
}


// TODO...
void freeTree(Tnode *t) {

}

#ifdef TESTTTREE
void main() {
  FILE *fp;
  unsigned char buf[1024];
  Tnode *tree=NULL;
  fp = fopen("words", "r");
  int i=1, len;
  int m[100];
  void *mp[100];

  while(fgets(buf, 1024, fp)) {
    if(buf[0]=='\n')
      continue;
    buf[strlen(buf)-1]='\0';
    printf("read %s\n", buf);
    tree = insert(tree, buf, (void*)i++);
  }
  fclose(fp);
  traverse(tree);
}
#endif
