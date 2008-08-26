// File "Misc.h"
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

#ifndef BLAHTEX_MISC_H
#define BLAHTEX_MISC_H


#include <set>
#include <vector>
#include <string>


// I use wishful_hash_set/map wherever I really want to use hash_set/map.
// Unfortunately hash_set/map is not quite standard enough yet, so for now
// it just gets mapped to set/map.
#define  wishful_hash_map  std::map
#define  wishful_hash_set  std::set


// The macro END_ARRAY is used in several places to simplify code that
// constructs an STL container from an array of data.
// (Yes, I hate macros too. Sorry.)
#define END_ARRAY(zzz_array) \
    ((zzz_array) + sizeof(zzz_array)/sizeof((zzz_array)[0]))


namespace blahtex
{


// Stores colours in 0x00rrggbb format.
// Better be 32 bits wide!
typedef unsigned RGBColour;


// The blahtex core throws an Exception object when it detects the input is
// invalid in some way. This doesn't include more serious things like debug
// assertions (these are thrown as std::logic_error).
//
// Each exception consists of an identifying string (mCode) plus zero or
// more arguments (mArgs). This scheme is designed to facilitate
// localisation of error messages. A complete list of corresponding
// messages in English is provided in Messages.cpp (not part of the
// blahtex core).
class Exception
{
private:
    std::wstring mCode;
    std::vector<std::wstring> mArgs;

public:
    Exception()
    {
    }

    Exception(
        const std::wstring& code,
        const std::wstring& arg1 = L"",
        const std::wstring& arg2 = L"",
        const std::wstring& arg3 = L""
    ) :
        mCode(code)
    {
        if (!arg1.empty())
            mArgs.push_back(arg1);
        if (!arg2.empty())
            mArgs.push_back(arg2);
        if (!arg3.empty())
            mArgs.push_back(arg3);
    }
    
    const std::wstring& GetCode() const
    {
        return mCode;
    }

    const std::vector<std::wstring>& GetArgs() const
    {
        return mArgs;
    }
};


// EncodingOptions describes output character encoding options.
struct EncodingOptions
{
    // mMathmlEncoding tells what to do with non-ASCII MathML characters.
    // It corresponds to the "--mathml-encoding" option on the command line.
    enum MathmlEncoding
    {
        cMathmlEncodingRaw,         // directly in unicode
        cMathmlEncodingNumeric,     // use e.g. "&#x2329;"
        cMathmlEncodingShort,       // use e.g. "&lang;"
        cMathmlEncodingLong         // use e.g. "&LeftAngleBracket;"
    }
    mMathmlEncoding;

    // mOtherEncodingRaw tells what to do with non-ASCII, non-MathML
    // characters:
    // * true means use unicode directly
    // * false means use e.g. "&#x1234;"
    bool mOtherEncodingRaw;

    // mAllowPlane1 tells whether to allow unicode plane-1 characters.
    // (This facility is included because some browsers don't have decent
    // support for plane 1 characters.)
    //
    // If this flag is NOT set, then blahtex will never output things like
    // "&#x1d504;", even when mMathmlEncoding is set to cMathmlEncodingRaw
    // or cMathmlEncodingNumeric. Instead it will fall back on something
    // like "&Afr;".
    //
    // (This flag is also present in struct MathmlOptions.)
    bool mAllowPlane1;

    EncodingOptions() :
        mMathmlEncoding(cMathmlEncodingNumeric),
        mOtherEncodingRaw(false),
        mAllowPlane1(true)
    { }
};


// MathmlOptions stores options that affect the MathML output.
struct MathmlOptions
{
    // mSpacingControl controls blahtex's MathML spacing markup output. It
    // corresponds to the command line "--spacing" option.
    //
    // Blahtex always uses TeX's rules (or an approximation thereof) to
    // determine spacing, but the SpacingControl values describe how much of
    // the time it actually outputs markup (<mspace>, lspace, rspace) to
    // implement its spacing decisions.
    //
    // cSpacingControlStrict:
    //     Blahtex outputs spacing commands everywhere possible, doesn't
    //     leave any choice to the MathML renderer.
    //
    // cSpacingControlModerate:
    //     Blahtex outputs spacing commands where it thinks a typical MathML
    //     renderer is likely to do something visually unsatisfactory
    //     without additional help. The aim is to get good agreement with
    //     TeX without overly bloated MathML markup. (It's very difficult
    //     to get this right, so I expect it to be under continual review.)
    //
    // cSpacingControlRelaxed:
    //     Blahtex only outputs spacing commands when the user specifically
    //     asks for them, using TeX commands like "\," or "\quad".
    enum SpacingControl
    {
        cSpacingControlStrict,
        cSpacingControlModerate,
        cSpacingControlRelaxed
    }
    mSpacingControl;

    // If mUseVersion1FontAttributes is set, blahtex will use MathML version
    // 1 font attributes (fontstyle, fontweight, fontfamily) instead of
    // mathvariant, and it will handle the fancier fonts (script,
    // bold-script, fraktur, bold-fraktur, double-struck) by explicitly
    // using appropriate MathML entities (e.g. "&Afr;").
    bool mUseVersion1FontAttributes;

    // Discussed at struct EncodingOptions.
    bool mAllowPlane1;

    MathmlOptions() :
        mSpacingControl(cSpacingControlStrict),
        mUseVersion1FontAttributes(false),
        mAllowPlane1(true)
    { }
};


// This class contains options to control how blahtex generates
// "purified Tex", that is, the .tex file which is sent to LaTeX to
// generate PNG output.
struct PurifiedTexOptions
{
    // Blahtex may use "\usepackage[utf8x]{inputenc}" (which also requires
    // the "ucs" package)
    bool mAllowUcs;
    
    // Blahtex may use "\usepackage{CJK}"
    bool mAllowCJK;
    
    // Blahtex may use the "preview" package.
    bool mAllowPreview;
    
    // The font name (e.g. "ipam") which gets passed to "\begin{CJK}..."
    // for handling japanese, or blank if no font is available.
    std::wstring mJapaneseFont;

    PurifiedTexOptions() :
        mAllowUcs(false),
        mAllowCJK(false),
        mAllowPreview(false)
    { }
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
