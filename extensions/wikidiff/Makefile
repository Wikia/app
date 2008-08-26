INSTALL_TARGET?=`php-config --extension-dir`
PRODUCT=wikidiff
VERSION=0.0.1
CXX?=g++

# For Linux
SHARED = -shared -fPIC

# For Mac OS X
# SHARED = -bundle

OUTPUT=php_$(PRODUCT).so

TMPDIST=$(PRODUCT)-$(VERSION)
DISTFILES=Makefile \
  $(PRODUCT).spec \
  $(PRODUCT).cpp $(PRODUCT).i \
  $(PRODUCT)_wrap.cpp php_$(PRODUCT).h \
  test.php memleak.php t1.txt t2.txt

$(OUTPUT) : $(PRODUCT).cpp $(PRODUCT)_wrap.cpp
	$(CXX) -O2 `php-config --includes` $(SHARED) -o $@ $(PRODUCT).cpp $(PRODUCT)_wrap.cpp

# The below _almost_ works. It gets unresolved symbol errors on load looking for _compiler_globals.
#	MACOSX_DEPLOYMENT_TARGET=10.3 g++ -O2 `php-config --includes` $(SHARED) -o php_wikidiff.so wikidiff.cpp wikidiff_wrap.cpp -undefined dynamic_lookup

$(PRODUCT)_wrap.cpp : $(PRODUCT).i
	swig -php4 -c++ $(PRODUCT).i

install : $(OUTPUT)
	install -d "$(INSTALL_TARGET)"
	install -m 0755 $(OUTPUT) "$(INSTALL_TARGET)"

uninstall :
	rm -f "$(INSTALL_TARGET)"/$(OUTPUT)

clean :
	rm -f $(OUTPUT)
	rm -f $(PRODUCT)_wrap.cpp

test : $(OUTPUT)
	php test.php

distclean : clean
	rm -rf $(TMPDIST)
	rm -f $(TMPDIST).tar.gz

dist : $(DISTFILES) Makefile
	rm -rf $(TMPDIST)
	mkdir $(TMPDIST)
	for x in $(DISTFILES); do cp -p $$x $(TMPDIST)/$$x; done
	tar zcvf $(TMPDIST).tar.gz $(TMPDIST)

rpm : dist
	cp $(TMPDIST).tar.gz /usr/src/redhat/SOURCES
	cp $(PRODUCT).spec /usr/src/redhat/SPECS/$(PRODUCT)-$(VERSION).spec
	cd /usr/src/redhat/SPECS && rpmbuild -ba $(PRODUCT)-$(VERSION).spec
