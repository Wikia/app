C++ = g++
FTFLAGS = `freetype-config --cflags`

mapniktile: mapniktile.cc
	$(C++) -O2 -o mapniktile mapniktile.cc $(FTFLAGS) -lmapnik

.cc.o:
	$(C++) -O2 -c $<

