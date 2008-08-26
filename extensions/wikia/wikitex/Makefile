VERSION = 1.0.3
PRE = cat 
POST = copying.inc.ms | sed "s/\%VERSION\%/${VERSION}/" | groff -t -ms -Tascii - | col -bx >
DOC = README NEWS COPYING MANIFEST THANKS

all: ${DOC}

README: readme.ms
	$(PRE) $? $(POST) $@

NEWS: news.ms
	$(PRE) $? $(POST) $@

COPYING: copying.ms
	$(PRE) $? $(POST) $@

MANIFEST: manifest.ms
	$(PRE) $? $(POST) $@

THANKS: thanks.ms
	$(PRE) $? $(POST) $@

clean:
	rm -f ${DOC}

distclean:
	rm -fr *~ `find . -name '.svn'`
