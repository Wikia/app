CFLAGS+=-g

all: icpagent

icpagent: metrics_linux.o icpagent.o 

test: test.o metrics_linux.o

clean:
	rm -f -- icpagent *~ *.o test
