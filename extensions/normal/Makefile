INSTALL_TARGET?=`php-config --extension-dir`
PRODUCT=utfnormal
VERSION=0.0.1

DESTDIR?=

CXX?=g++
CFLAGS?=-O2 -fPIC

# For Linux
SHARED = -shared

# For Mac OS X
#SHARED = -bundle -flat_namespace -undefined suppress

DEBFILES=\
debian/changelog\
debian/compat\
debian/control\
debian/copyright\
debian/dirs\
debian/docs\
debian/README.Debian\
debian/rules

DISTDIRS=\
debian

TMPDIST=$(PRODUCT)-$(VERSION)
TARBALL=$(TMPDIST).tar.gz

DISTFILES=Makefile \
  $(PRODUCT).spec \
  $(PRODUCT).cpp $(PRODUCT).i \
  $(PRODUCT)_wrap.cpp php_$(PRODUCT).h \
  test.php \
  $(DEBFILES)


php_$(PRODUCT).so : $(PRODUCT).cpp $(PRODUCT)_wrap.cpp
	$(CXX) $(CFLAGS) `php-config --includes --ldflags --libs` \
	-licuuc -licudata \
	$(SHARED) -o php_$(PRODUCT).so $(PRODUCT).cpp $(PRODUCT)_wrap.cpp

$(PRODUCT)_wrap.cpp : $(PRODUCT).i
	swig -Wall -php5 -c++ $(PRODUCT).i

install : php_$(PRODUCT).so
	install -d "$(DESTDIR)$(INSTALL_TARGET)"
	install -m 0755 php_$(PRODUCT).so "$(DESTDIR)$(INSTALL_TARGET)"

uninstall :
	rm -f "$(DESTDIR)$(INSTALL_TARGET)"

clean :
	rm -f php_$(PRODUCT).so
	rm -f $(PRODUCT)_wrap.cpp
	rm -f $(PRODUCT).php
	rm -f php_$(PRODUCT).h

test : php_$(PRODUCT).so
	php test.php

distclean : clean
	rm -rf $(TMPDIST)
	rm -f $(TMPDIST).tar.gz
	rm -rf debbuild

dist : $(TARBALL)

$(TARBALL) : $(DISTFILES)
	rm -rf $(TMPDIST)
	mkdir $(TMPDIST)
	for x in $(DISTDIRS); do mkdir $(TMPDIST)/$$x; done
	for x in $(DISTFILES); do cp -p $$x $(TMPDIST)/$$x; done
	tar zcvf $(TMPDIST).tar.gz $(TMPDIST)

rpm : $(TARBALL)
	cp $(TARBALL) /usr/src/redhat/SOURCES
	cp $(PRODUCT).spec /usr/src/redhat/SPECS/$(PRODUCT)-$(VERSION).spec
	cd /usr/src/redhat/SPECS && rpmbuild -ba $(PRODUCT)-$(VERSION).spec

deb : $(TARBALL)
	rm -rf debbuild
	mkdir debbuild
	cd debbuild && tar zxvf ../$(TARBALL)
	cd debbuild/$(TMPDIST) && dpkg-buildpackage -rfakeroot
	#rm -rf debbuild/$(TMPDIST)

