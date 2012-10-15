// File "MathmlNode.h"
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

#ifndef BLAHTEX_MATHMLNODE_H
#define BLAHTEX_MATHMLNODE_H

#include <string>
#include <iostream>
#include <map>
#include <list>
#include "Misc.h"

namespace blahtex
{

// MathmlFont lists all possible MathML "mathvariant" values. Blahtex
// uses these to record fonts in the layout tree; they get converted to
// MathML 1.x font attributes if needed.
enum MathmlFont
{
    cMathmlFontNormal,
    cMathmlFontBold,
    cMathmlFontItalic,
    cMathmlFontBoldItalic,
    cMathmlFontDoubleStruck,
    cMathmlFontBoldFraktur,
    cMathmlFontScript,
    cMathmlFontBoldScript,
    cMathmlFontFraktur,
    cMathmlFontSansSerif,
    cMathmlFontBoldSansSerif,
    cMathmlFontSansSerifItalic,
    cMathmlFontSansSerifBoldItalic,
    cMathmlFontMonospace
};

// String versions of the MathML mathvariant fonts.
// (See enum MathmlFont in LayoutTree.h.)
extern std::wstring gMathmlFontStrings[];


// Represents a node in an MathML tree.
struct MathmlNode
{
    enum Type
    {
        // Leaf nodes types ("token elements" in MathML documentation):
        cTypeMi,
        cTypeMo,
        cTypeMn,
        cTypeMspace,
        cTypeMtext,
        
        // Internal nodes types:
        cTypeMrow,
        cTypeMstyle,
        cTypeMsub,
        cTypeMsup,
        cTypeMsubsup,
        cTypeMunder,
        cTypeMover,
        cTypeMunderover,
        cTypeMfrac,
        cTypeMsqrt,
        cTypeMroot,
        cTypeMtable,
        cTypeMtr,
        cTypeMtd,
        cTypeMpadded
    }
    mType;

    enum Attribute
    {
        cAttributeDisplaystyle,
        cAttributeScriptlevel,
        cAttributeMathvariant,
        cAttributeMathcolor,
        cAttributeLspace,
        cAttributeRspace,
        cAttributeWidth,
        cAttributeStretchy,
        cAttributeMinsize,
        cAttributeMaxsize,
        cAttributeAccent,
        cAttributeMovablelimits,
        cAttributeLinethickness,
        cAttributeColumnalign,
        cAttributeColumnspacing,
        cAttributeRowspacing,
        cAttributeFontfamily,
        cAttributeFontstyle,
        cAttributeFontweight
    };

    std::map<Attribute, std::wstring> mAttributes;

    // mText is only used for leaf nodes: it holds the text that is
    // displayed between the opening and closing tags
    std::wstring mText;
    
    // mChildren is only used for internal nodes
    std::list<MathmlNode*> mChildren;
    
    MathmlNode(Type type, const std::wstring& text = L"") :
        mType(type),
        mText(text)
    { }
    
    ~MathmlNode();
    
    // This function adds mathvariant (for MathML 2.0) or fontstyle/
    // fontweight/fontfamily (for MathML 1.x) as appropriate to this node
    // to obtain the desired font. It knows about MathML defaults (like the
    // annoying automatic italic for single character <mi> nodes).
    void AddFontAttributes(
        MathmlFont desiredFont,
        const MathmlOptions& options
    );
    
    
    // Print() recursively prints the tree rooted at this node to the
    // given output stream.
    //
    // XML entities translated according to EncodingOptions.
    //
    // If "indent" is true, it will print each tag pair on a new line, and
    // add appropriate indenting.
    void Print(
        std::wostream& os,
        const EncodingOptions& options,
        bool indent,
        int depth = 0
    ) const;

    // Used internally by Print:
    void PrintType(std::wostream& os) const;
    void PrintAttributes(std::wostream& os) const;
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
