ZHDAEMON_OBJS = convert.o dict.o segment.o ttree.o zhdaemon.o utf8.o mystring.o
COUNT_OBJS = ttree.o utf8.o count.o
all: zhdaemon count

zhdaemon: $(ZHDAEMON_OBJS)
	gcc -o zhdaemon $(ZHDAEMON_OBJS) -lconfuse

count: $(COUNT_OBJS)
	gcc -o count $(COUNT_OBJS) -lm

%.o: %.c
	gcc -Wall -g -c $<

clean:
	rm -f zhdaemon *.o *~ core core.*
