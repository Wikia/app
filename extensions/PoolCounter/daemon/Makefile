CC=gcc
DEFINES=-DENDIAN_BIG=0 -DENDIAN_LITTLE=1 -DHAVE_ACCEPT4=1
CFLAGS=-Wall $(DEFINES)
OBJS=main.o client_data.o locks.o hash.o stats.o
LINK=-levent -lm
HEADERS=prototypes.h client_data.h stats.h stats.list
DESTDIR ?=

poolcounterd: $(OBJS)
	$(CC) $^ $(LINK) -o $@

%.o: %.c $(HEADERS)
	$(CC) -c $(CFLAGS) $< -o $@

prototypes.h: main.c
	sed -n 's/\/\* prototype \*\//;/p' $^ > $@

clean:
	rm -f *.o prototypes.h

install:
	install -d $(DESTDIR)/usr/bin/
	install poolcounterd $(DESTDIR)/usr/bin/
