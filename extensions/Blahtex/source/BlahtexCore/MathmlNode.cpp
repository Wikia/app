// File "MathmlNode.cpp"
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

#include <iomanip>
#include <sstream>
#include <stdexcept>
#include "MathmlNode.h"
#include "XmlEncode.h"

using namespace std;

namespace blahtex
{

// Strings for each MathML "mathvariant" value.
wstring gMathmlFontStrings[] =
{
    L"normal",
    L"bold",
    L"italic",
    L"bold-italic",
    L"double-struck",
    L"bold-fraktur",
    L"script",
    L"bold-script",
    L"fraktur",
    L"sans-serif",
    L"bold-sans-serif",
    L"sans-serif-italic",
    L"sans-serif-bold-italic",
    L"monospace"
};


MathmlNode::~MathmlNode()
{
    for (list<MathmlNode*>::iterator
        p = mChildren.begin(); p != mChildren.end(); p++
    )
        delete *p;
}


void MathmlNode::AddFontAttributes(
    MathmlFont desiredFont,
    const MathmlOptions& options
)
{
    if (options.mUseVersion1FontAttributes)
    {
        // MathML version 1.x fonts requested.
        
        if (
            desiredFont == cMathmlFontDoubleStruck ||
            desiredFont == cMathmlFontBoldFraktur ||
            desiredFont == cMathmlFontScript ||
            desiredFont == cMathmlFontBoldScript ||
            desiredFont == cMathmlFontFraktur
        )
        {
            // The only way we can end up here is with a fraktur <mn>.
            // TeX has decent fraktur digits, but unicode doesn't seem to
            // list them. (FIX: this might be changing in an upcoming
            // revision of unicode. I thought I saw the stix fonts website
            // mention something.) Therefore we can't access them with
            // version 1 font attributes, so let's just map it to bold
            // instead.
            if (mType == cTypeMn &&
                (
                    desiredFont == cMathmlFontFraktur ||
                    desiredFont == cMathmlFontBoldFraktur
                )
            )
                mAttributes[cAttributeFontweight] = L"bold";
            else
                throw logic_error(
                    "Unexpected font/symbol combination "
                    "in MathmlNode::AddFontAttributes"
                );
        }
        else
        {
            
            bool defaultItalic = (mType == cTypeMi && mText.size() == 1);

            bool desiredItalic = (
                desiredFont == cMathmlFontItalic ||
                desiredFont == cMathmlFontBoldItalic ||
                desiredFont == cMathmlFontSansSerifItalic ||
                desiredFont == cMathmlFontSansSerifBoldItalic
            );
            
            if (defaultItalic != desiredItalic)
                mAttributes[cAttributeFontstyle] =
                    desiredItalic ? L"italic" : L"normal";
            
            if (
                desiredFont == cMathmlFontBold ||
                desiredFont == cMathmlFontBoldItalic ||
                desiredFont == cMathmlFontBoldSansSerif ||
                desiredFont == cMathmlFontSansSerifBoldItalic
            )
                mAttributes[cAttributeFontweight] = L"bold";

            if (
                desiredFont == cMathmlFontSansSerif ||
                desiredFont == cMathmlFontBoldSansSerif ||
                desiredFont == cMathmlFontSansSerifItalic ||
                desiredFont == cMathmlFontSansSerifBoldItalic
            )
                mAttributes[cAttributeFontfamily] = L"sans-serif";

            else if (desiredFont == cMathmlFontMonospace)
                mAttributes[cAttributeFontfamily] = L"monospace";
        }
    }
    else
    {
        // MathML version 2.0 fonts requested.
        
        MathmlFont defaultFont =
            (mType == cTypeMi && mText.size() == 1)
            ? cMathmlFontItalic : cMathmlFontNormal;
        
        if (desiredFont != defaultFont)
            mAttributes[cAttributeMathvariant] =
                gMathmlFontStrings[desiredFont];
    }
}


void WriteIndent(
    wostream& os,
    int depth
)
{
    for (int i = 0; i < depth; i++)
        os << L"  ";
}

void MathmlNode::PrintType(wostream& os) const
{
    static wstring gTypeArray[] =
    {
        L"mi",
        L"mo",
        L"mn",
        L"mspace",
        L"mtext",
        L"mrow",
        L"mstyle",
        L"msub",
        L"msup",
        L"msubsup",
        L"munder",
        L"mover",
        L"munderover",
        L"mfrac",
        L"msqrt",
        L"mroot",
        L"mtable",
        L"mtr",
        L"mtd",
        L"mpadded"
    };
    
    if (mType < 0 || mType >= sizeof(gTypeArray))
        throw logic_error("Illegal node type in MathmlNode::PrintType");
    
    os << gTypeArray[mType];
}

void MathmlNode::PrintAttributes(wostream& os) const
{
    static wstring gAttributeArray[] =
    {
        L"displaystyle",
        L"scriptlevel",
        L"mathvariant",
        L"mathcolor",
        L"lspace",
        L"rspace",
        L"width",
        L"stretchy",
        L"minsize",
        L"maxsize",
        L"accent",
        L"movablelimits",
        L"linethickness",
        L"columnalign",
        L"columnspacing",
        L"rowspacing",
        L"fontfamily",
        L"fontstyle",
        L"fontweight"
    };
    
    for (map<Attribute, wstring>::const_iterator
        attribute = mAttributes.begin();
        attribute != mAttributes.end();
        attribute++
    )
    {
        if (
            attribute->first < 0 ||
            attribute->first >= sizeof(gAttributeArray)
        )
            throw logic_error(
                "Illegal attribute in MathmlNode::PrintAttributes"
            );

        os << L" " << gAttributeArray[attribute->first] << L"=\""
            << attribute->second << L"\"";
    }
}

void MathmlNode::Print(
    wostream& os,
    const EncodingOptions& options,
    bool indent,
    int depth
) const
{
    if (indent)
        WriteIndent(os, depth);
    
    os << L"<";
    PrintType(os);
    PrintAttributes(os);
    if (mText.empty() && mChildren.empty())
        os << L"/>";
    else
    {
        if (!mText.empty())
        {
            // is a leaf node with text
            os << L">" << XmlEncode(mText, options);
        }
        else
        {
            // is a internal node with at least one child
            os << L">";
            if (indent)
                os << endl;
            
            for (list<MathmlNode*>::const_iterator
                child = mChildren.begin(); child != mChildren.end(); child++
            )
                (*child)->Print(os, options, indent, depth + 1);

            if (indent)
                WriteIndent(os, depth);
        }

        os << L"</";
        PrintType(os);
        os << L">";
    }
    
    if (indent)
        os << endl;
}

}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
