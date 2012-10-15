CC = gcc
CFLAGS = -Wall -O2 
LIBTOOL = libtool
SRCS = lrtable.c parser.c scanner.c scanner_names.c stack.c tree.c wsparse.c
OBJS = $(SRCS:.c=.o)
LIBOBJS = $(SRCS:.c=.lo)
HEADERS = lrtable.h parser.h scanner.h tokenids.h tree.h wsparse.h

PREFIX = /usr/local

.SUFFIXES: .c .lo .o

all: libwsparse wsparsertest

lrtable.c:
	php ../buildLRTables.php --ctable

.c.lo: config.h
	$(LIBTOOL) --mode=compile $(CC) $(CFLAGS) -c -o $@ $<

libwsparse: $(LIBOBJS)
	$(LIBTOOL) --mode=link $(CC) $(CFLAGS) $(LIBOBJS) -o libwsparse.la -rpath $(PREFIX)/lib

wsparsertest: test.c libwsparse
	$(CC) $(CFLAGS) test.c -o wsparsertest -L ./.libs -l :libwsparse.a

install: libwsparse
	$(LIBTOOL) --mode=install install -c libwsparse.la $(PREFIX)/lib/libwsparse.la
	if [ ! -e $(PREFIX)/include/libwsparse ]; then mkdir -vm 755 $(PREFIX)/include/libwsparse; fi
	install -c -t $(PREFIX)/include/libwsparse $(HEADERS)

clean:
	rm -vf *.o *.lo *.la wsparsertest lrtable.c
	rm -rvf .libs
