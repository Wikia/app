// File "Interface.cpp"
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

#include <sstream>
#include "Interface.h"
#include "MathmlNode.h"

using namespace std;

namespace blahtex
{

void Interface::ProcessInput(const wstring& input)
{
    mManager.reset(new Manager);
    mManager->ProcessInput(input, mTexvcCompatibility);
}

wstring Interface::GetMathml()
{
    wostringstream output;
    auto_ptr<MathmlNode> root = mManager->GenerateMathml(mMathmlOptions);
    root->Print(output, mEncodingOptions, mIndented);
    return output.str();
}

wstring Interface::GetPurifiedTex()
{
    return mManager->GeneratePurifiedTex(mPurifiedTexOptions);
}

}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
