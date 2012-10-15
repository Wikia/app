// File "UnicodeConverter.cpp"
//
// blahtex (version 0.4.4)
// a TeX to MathML converter designed with MediaWiki in mind
// Copyright (C) 2006, David Harvey
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

#include "UnicodeConverter.h"
#include <iostream>
#include <stdexcept>
#include <cerrno>

using namespace std;

UnicodeConverter::~UnicodeConverter()
{
    if (mIsOpen)
    {
        iconv_close(mInHandle);
        iconv_close(mOutHandle);
    }
}

void UnicodeConverter::Open()
{
    if (mIsOpen)
        throw logic_error(
            "UnicodeConverter::Open called on already open object"
        );

    if (sizeof(wchar_t) != 4)
        throw runtime_error(
            "The wchar_t data type on this system is not four bytes wide"
        );

    // Determine endian-ness of wchar_t.
    // (Really we should be able to just use "WCHAR_T". This unfortunately
    // doesn't seem to available on darwin.)
    wchar_t testChar = L'A';
    const char* UcsString =
        (*(reinterpret_cast<char*>(&testChar)) == 'A')
            ? "UCS-4LE" : "UCS-4BE";

    mInHandle = iconv_open(UcsString, "UTF-8");
    if (mInHandle == (iconv_t)(-1))
    {
        switch (errno)
        {
            case EMFILE:
                throw runtime_error(
                    "iconv_open failed with errno == EMFILE"
                );
            case ENFILE:
                throw runtime_error(
                    "iconv_open failed with errno == ENFILE"
                );
            case ENOMEM:
                throw runtime_error(
                    "iconv_open failed with errno == ENOMEM"
                );
            case EINVAL:
                throw runtime_error(
                    "iconv_open failed with errno == EINVAL"
                );
            default:
                throw runtime_error(
                    "iconv_open failed with unknown error code"
                );
        }
    }

    mOutHandle = iconv_open("UTF-8", UcsString);
    if (mOutHandle == (iconv_t)(-1))
    {
        switch (errno)
        {
            case EMFILE:
                throw runtime_error(
                    "iconv_open failed with errno == EMFILE"
                );
            case ENFILE:
                throw runtime_error(
                    "iconv_open failed with errno == ENFILE"
                );
            case ENOMEM:
                throw runtime_error(
                    "iconv_open failed with errno == ENOMEM"
                );
            case EINVAL:
                throw runtime_error(
                    "iconv_open failed with errno == EINVAL"
                );
            default:
                throw runtime_error(
                    "iconv_open failed with unknown error code"
                );
        }
    }

    mIsOpen = true;
}

wstring UnicodeConverter::ConvertIn(const string& input)
{
    if (!mIsOpen)
        throw logic_error(
            "UnicodeConverter::ConvertIn called "
            "before UnicodeConverter::Open"
        );

    char* inputBuf  = new char[input.size()];
    memcpy(inputBuf, input.c_str(), input.size());

    char* outputBuf = new char[input.size() * 4];

    // The following garbage is needed to handle the unfortunate
    // inconsistency between Linux and BSD definitions for the second
    // parameter of iconv. BSD (including Mac OS X) requires const char*,
    // whereas Linux requires char*, and neither option seems to produce
    // error-free, warning-free compilation on both systems simultaneously.
#ifdef BLAHTEX_ICONV_CONST
    const
#endif
    char* source = inputBuf;
    char* dest = outputBuf;

    size_t  inBytesLeft = input.size();
    size_t outBytesLeft = input.size() * 4;

    if (iconv(
        mInHandle,
        &source,
        &inBytesLeft,
        &dest,
        &outBytesLeft
    ) == -1)
    {
        delete[] inputBuf;
        delete[] outputBuf;
        switch (errno)
        {
            case EILSEQ:
            case EINVAL:    throw UnicodeConverter::Exception();
            default:
                throw logic_error(
                    "Conversion problem in UnicodeConverter::ConvertIn"
                );
        }
    }

    wstring output(
        reinterpret_cast<wchar_t*>(outputBuf),
        input.size() - outBytesLeft / 4
    );
    delete[] inputBuf;
    delete[] outputBuf;
    return output;
}

string UnicodeConverter::ConvertOut(const wstring& input)
{
    if (!mIsOpen)
        throw logic_error(
            "UnicodeConverter::ConvertOut called "
            "before UnicodeConverter::Open"
        );

    wchar_t* inputBuf = new wchar_t[input.size()];
    wmemcpy(inputBuf, input.c_str(), input.size());

    char* outputBuf = new char[input.size() * 4];

#ifdef BLAHTEX_ICONV_CONST
    const
#endif
    char* source = reinterpret_cast<char*>(inputBuf);
    char* dest = outputBuf;

    size_t  inBytesLeft = input.size() * 4;
    size_t outBytesLeft = input.size() * 4;

    if (iconv(
        mOutHandle,
        &source,
        &inBytesLeft,
        &dest,
        &outBytesLeft
    ) == -1)
    {
        delete[] inputBuf;
        delete[] outputBuf;
        switch (errno)
        {
            case EILSEQ:
            case EINVAL:    throw UnicodeConverter::Exception();
            default:
                throw logic_error(
                    "Conversion problem in UnicodeConverter::ConvertIn"
                );
        }
    }

    string output(outputBuf, input.size() * 4 - outBytesLeft);
    delete[] inputBuf;
    delete[] outputBuf;
    return output;
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
