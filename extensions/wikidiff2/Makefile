PHP_EXT_DIR=`php-config --extension-dir`
PRODUCT=wikidiff2
VERSION=1.0.3
CXX?=g++

# For Linux
SHARED = -shared -fPIC

# For Mac OS X
# SHARED = -bundle

OUTPUT=php_$(PRODUCT).so
STANDALONE=$(PRODUCT)
#LIBDIRS=-L/usr/local/lib
#LIBS=-lJudy
LIBS=
LIBDIRS=

TMPDIST=$(PRODUCT)-$(VERSION)
DISTDIRS=test debian
DISTFILES=Makefile \
  $(PRODUCT).spec compile.sh release.sh \
  DiffEngine.h JudyHS.h Word.h wikidiff2.h \
  judy_test.cpp standalone.cpp \
  $(PRODUCT).cpp $(PRODUCT).i \
  $(PRODUCT)_wrap.cpp php_$(PRODUCT).h wikidiff2.php \
  test/chinese-reverse.zip \
  test/test-a.diff \
  test/test-a1 \
  test/test-a2 \
  test/test-b.diff \
  test/test-b1 \
  test/test-b2 \
  debian/control \
  debian/compat \
  debian/changelog \
  debian/copyright \
  debian/rules

$(OUTPUT) : $(PRODUCT).cpp $(PRODUCT)_wrap.cpp
	$(CXX) -O2 `php-config --includes` $(SHARED) -o $@ $(PRODUCT).cpp $(PRODUCT)_wrap.cpp

.PHONY: standalone
standalone:
	$(CXX) -o $(STANDALONE) -O3 $(PRODUCT).cpp standalone.cpp $(LIBS) $(LIBDIRS)

# The below _almost_ works. It gets unresolved symbol errors on load looking for _compiler_globals.
#	MACOSX_DEPLOYMENT_TARGET=10.3 g++ -O2 `php-config --includes` $(SHARED) -o php_wikidiff2.so wikidiff2.cpp wikidiff2_wrap.cpp -undefined dynamic_lookup

test.php : $(PRODUCT)_wrap.cpp

$(PRODUCT)_wrap.cpp : $(PRODUCT).i
	swig -php4 -c++ $(PRODUCT).i

install : $(OUTPUT)
	install -d "$(INSTALL_TARGET)$(PHP_EXT_DIR)"
	install -m 0755 $(OUTPUT) "$(INSTALL_TARGET)$(PHP_EXT_DIR)"

uninstall :
	rm -f "$(INSTALL_TARGET)$(PHP_EXT_DIR)"/$(OUTPUT)

clean :
	rm -f $(OUTPUT)
	rm -f $(PRODUCT)_wrap.cpp
	rm -f $(PRODUCT).php

test : $(OUTPUT)
	php test.php

distclean : clean
	rm -rf $(TMPDIST)
	rm -f $(TMPDIST).tar.gz

dist : $(DISTFILES) Makefile
	rm -rf $(TMPDIST)
	mkdir $(TMPDIST)
	for x in $(DISTDIRS); do mkdir $(TMPDIST)/$$x; done
	for x in $(DISTFILES); do cp -p $$x $(TMPDIST)/$$x; done
	tar zcvf $(TMPDIST).tar.gz $(TMPDIST)

rpm : dist
	cp $(TMPDIST).tar.gz /usr/src/redhat/SOURCES
	cp $(PRODUCT).spec /usr/src/redhat/SPECS/$(PRODUCT)-$(VERSION).spec
	cd /usr/src/redhat/SPECS && rpmbuild -ba $(PRODUCT)-$(VERSION).spec
