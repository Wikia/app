// File "UnicodeConverter.h"
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

#ifndef BLAHTEX_UNICODE_CONVERTER_H
#define BLAHTEX_UNICODE_CONVERTER_H

#include <string>
#include <iconv.h>

// UnicodeConverter handles all UTF8 <=> wchar_t conversions. It's
// basically a wrapper for the iconv library in terms of
// - string (assumed to be in UTF-8) and
// - wstring (in internal wchar_t format, which may be big-endian or
// little-endian depending on platform).
class UnicodeConverter
{
    public:
        UnicodeConverter() :
            mIsOpen(false)
        { }

        ~UnicodeConverter();

        // Open() must be called before using this object.
        //
        // It will throw a std::runtime_error object if
        // (1) we are running on a platform with less than 4 bytes
        //     per wchar_t, or
        // (2) an appropriate iconv_t converter object can't be created
        void Open();

        std::wstring ConvertIn(const std::string& input);
        std::string ConvertOut(const std::wstring& input);

        // The above 'ConvertIn' and 'ConvertOut' functions will throw this
        // exception object if their input is invalid (e.g. invalid UTF-8).
        // More serious problems report a std::logic_error.
        class Exception
        {
        };

    private:
        bool mIsOpen;

        // mOutHandle is the iconv object handling wchar_t => UTF-8,
        // mInHandle does the other way.
        iconv_t mOutHandle;
        iconv_t mInHandle;
};

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
