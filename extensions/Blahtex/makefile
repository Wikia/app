#
# makefile
#
# blahtex (version 0.4.4)
# a TeX to MathML converter designed with MediaWiki in mind
# Copyright (C) 2006, David Harvey
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#


SOURCES = \
	source/main.cpp \
	source/mainPng.cpp \
	source/md5.c \
	source/md5Wrapper.cpp \
	source/Messages.cpp \
	source/UnicodeConverter.cpp \
	source/BlahtexCore/Interface.cpp \
	source/BlahtexCore/LayoutTree.cpp \
	source/BlahtexCore/MacroProcessor.cpp \
	source/BlahtexCore/Manager.cpp \
	source/BlahtexCore/Parser.cpp \
	source/BlahtexCore/ParseTree1.cpp \
	source/BlahtexCore/ParseTree2.cpp \
	source/BlahtexCore/ParseTree3.cpp \
	source/BlahtexCore/MathmlNode.cpp \
	source/BlahtexCore/XmlEncode.cpp
	
HEADERS = \
	source/mainPng.h \
	source/md5.h \
	source/md5Wrapper.h \
	source/UnicodeConverter.h \
	source/BlahtexCore/Interface.h \
	source/BlahtexCore/LayoutTree.h \
	source/BlahtexCore/MacroProcessor.h \
	source/BlahtexCore/Manager.h \
	source/BlahtexCore/Misc.h \
	source/BlahtexCore/Parser.h \
	source/BlahtexCore/ParseTree.h \
	source/BlahtexCore/MathmlNode.h \
	source/BlahtexCore/XmlEncode.h

OBJECTS = $(patsubst %.c,%.o,$(patsubst %.cpp,%.o,$(SOURCES)))

linux : CFLAGS = -O3
mac : CFLAGS = -O3 -DBLAHTEX_ICONV_CONST

CXXFLAGS = $(CFLAGS)

linux:  $(OBJECTS)  $(HEADERS)
	$(CXX) $(CFLAGS) -o blahtex $(OBJECTS)

mac: $(OBJECTS)  $(HEADERS)
	$(CXX) $(CFLAGS) -o blahtex -liconv $(OBJECTS)

clean:
	rm -f blahtex $(OBJECTS)

########## end of file ##########
