// File "Interface.h"
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

#ifndef BLAHTEX_INTERFACE_H
#define BLAHTEX_INTERFACE_H

#include <string>
#include <memory>
#include "Misc.h"
#include "Manager.h"
#include "XmlEncode.h"

namespace blahtex
{

// If you want to use blahtex in your own code, using an Interface object
// is probably the easiest way to do it. It's essentially a wrapper for
// the Manager class, putting all the options and methods in one convenient
// place.
//
// To use it:
// (1) Declare an Interface object
// (2) Set the various public members to control options
//     (the data types are explained in Misc.h)
// (3) Call ProcessInput() on your input
// (4) Call GetMathml() to get the MathML output
// (5) Call GetPurifiedTex() to get a complete TeX file that could be sent
//     to latex to generate graphical output

class Interface
{
private:
    std::auto_ptr<Manager> mManager;

public:
    MathmlOptions mMathmlOptions;
    EncodingOptions mEncodingOptions;
    PurifiedTexOptions mPurifiedTexOptions;
    bool mTexvcCompatibility;
    bool mIndented;

    Interface() :
        mTexvcCompatibility(false),
        mIndented(false)
    {
    }

    const Manager* GetManager() const
    {
        return mManager.get();
    }

    void ProcessInput(const std::wstring& input);
    std::wstring GetMathml();
    std::wstring GetPurifiedTex();
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
