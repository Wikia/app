// File "ParseTree3.cpp"
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

#include <stdexcept>
#include <set>
#include <iomanip>
#include <sstream>
#include "ParseTree.h"

using namespace std;

namespace blahtex
{

// List of colour names that we know about.
pair<wstring, RGBColour> gColourArray[] =
{
    make_pair(L"GreenYellow",         0xd8ff4f),
    make_pair(L"Yellow",              0xffff00),
    make_pair(L"yellow",              0xffff00),
    make_pair(L"Goldenrod",           0xffe528),
    make_pair(L"Dandelion",           0xffb528),
    make_pair(L"Apricot",             0xffad7a),
    make_pair(L"Peach",               0xff7f4c),
    make_pair(L"Melon",               0xff897f),
    make_pair(L"YellowOrange",        0xff9300),
    make_pair(L"Orange",              0xff6321),
    make_pair(L"BurntOrange",         0xff7c00),
    make_pair(L"Bittersweet",         0xc10200),
    make_pair(L"RedOrange",           0xff3a21),
    make_pair(L"Mahogany",            0xa50000),
    make_pair(L"Maroon",              0xad0000),
    make_pair(L"BrickRed",            0xb70000),
    make_pair(L"Red",                 0xff0000),
    make_pair(L"red",                 0xff0000),
    make_pair(L"OrangeRed",           0xff007f),
    make_pair(L"RubineRed",           0xff00dd),
    make_pair(L"WildStrawberry",      0xff0a9b),
    make_pair(L"Salmon",              0xff779e),
    make_pair(L"CarnationPink",       0xff5eff),
    make_pair(L"Magenta",             0xff00ff),
    make_pair(L"magenta",             0xff00ff),
    make_pair(L"VioletRed",           0xff30ff),
    make_pair(L"Rhodamine",           0xff2dff),
    make_pair(L"Mulberry",            0xa314f9),
    make_pair(L"RedViolet",           0x9600a8),
    make_pair(L"Fuchsia",             0x7202ea),
    make_pair(L"Lavender",            0xff84ff),
    make_pair(L"Thistle",             0xe068ff),
    make_pair(L"Orchid",              0xad5bff),
    make_pair(L"DarkOrchid",          0x9933cc),
    make_pair(L"Purple",              0x8c23ff),
    make_pair(L"Plum",                0x7f00ff),
    make_pair(L"Violet",              0x351eff),
    make_pair(L"RoyalPurple",         0x3f19ff),
    make_pair(L"BlueViolet",          0x190cf4),
    make_pair(L"Periwinkle",          0x6d72ff),
    make_pair(L"CadetBlue",           0x606dc4),
    make_pair(L"CornflowerBlue",      0x59ddff),
    make_pair(L"MidnightBlue",        0x007091),
    make_pair(L"NavyBlue",            0x0f75ff),
    make_pair(L"RoyalBlue",           0x007fff),
    make_pair(L"Blue",                0x0000ff),
    make_pair(L"blue",                0x0000ff),
    make_pair(L"Cerulean",            0x0fe2ff),
    make_pair(L"Cyan",                0x00ffff),
    make_pair(L"cyan",                0x00ffff),
    make_pair(L"ProcessBlue",         0x0affff),
    make_pair(L"SkyBlue",             0x60ffe0),
    make_pair(L"Turquoise",           0x26ffcc),
    make_pair(L"TealBlue",            0x1ef9a3),
    make_pair(L"Aquamarine",          0x2dffb2),
    make_pair(L"BlueGreen",           0x26ffaa),
    make_pair(L"Emerald",             0x00ff7f),
    make_pair(L"JungleGreen",         0x02ff7a),
    make_pair(L"SeaGreen",            0x4fff7f),
    make_pair(L"Green",               0x00ff00),
    make_pair(L"green",               0x00ff00),
    make_pair(L"ForestGreen",         0x00e000),
    make_pair(L"PineGreen",           0x00bf28),
    make_pair(L"LimeGreen",           0x7fff00),
    make_pair(L"YellowGreen",         0x8eff42),
    make_pair(L"SpringGreen",         0xbcff3d),
    make_pair(L"OliveGreen",          0x009900),
    make_pair(L"RawSienna",           0x8c0000),
    make_pair(L"Sepia",               0x4c0000),
    make_pair(L"Brown",               0x660000),
    make_pair(L"Tan",                 0xdb9370),
    make_pair(L"Gray",                0x7f7f7f),
    make_pair(L"Black",               0x000000),
    make_pair(L"black",               0x000000),
    make_pair(L"White",               0xffffff),
    make_pair(L"white",               0xffffff)
};

wishful_hash_map<wstring, RGBColour> gColourTable(
    gColourArray,
    END_ARRAY(gColourArray)
);


MathmlFont TexMathFont::GetMathmlApproximation() const
{
    if (mIsBoldsymbol)
    {
        switch (mFamily)
        {
            case cFamilyRm:    return cMathmlFontBold;
            case cFamilyIt:    return cMathmlFontBoldItalic;
            case cFamilyBf:    return cMathmlFontBold;
            case cFamilyBb:    return cMathmlFontDoubleStruck;
            case cFamilySf:    return cMathmlFontBoldSansSerif;
            case cFamilyCal:   return cMathmlFontBoldScript;
            case cFamilyTt:    return cMathmlFontMonospace;
            case cFamilyFrak:  return cMathmlFontBoldFraktur;
        }
    }
    else
    {
        switch (mFamily)
        {
            case cFamilyRm:    return cMathmlFontNormal;
            case cFamilyIt:    return cMathmlFontItalic;
            case cFamilyBf:    return cMathmlFontBold;
            case cFamilyBb:    return cMathmlFontDoubleStruck;
            case cFamilySf:    return cMathmlFontSansSerif;
            case cFamilyCal:   return cMathmlFontScript;
            case cFamilyTt:    return cMathmlFontMonospace;
            case cFamilyFrak:  return cMathmlFontFraktur;
        }
    }

    throw logic_error("Unexpected TexMathFont data");
}

MathmlFont TexTextFont::GetMathmlApproximation() const
{
    switch (mFamily)
    {
        case cFamilyRm:
            return mIsBold
                ? (mIsItalic ? cMathmlFontBoldItalic : cMathmlFontBold)
                : (mIsItalic ? cMathmlFontItalic     : cMathmlFontNormal);

        case cFamilySf:
            return mIsBold
                ? (
                    mIsItalic
                        ? cMathmlFontSansSerifBoldItalic
                        : cMathmlFontBoldSansSerif
                )
                : (
                    mIsItalic
                        ? cMathmlFontSansSerifItalic
                        : cMathmlFontSansSerif
                );

        case cFamilyTt:   return cMathmlFontMonospace;
    }

    throw logic_error("Unexpected TexTextFont data");
}


namespace ParseTree
{

// A couple of destructors that implement ownership conventions.

MathList::~MathList()
{
    for (vector<MathNode*>::iterator
        p = mChildren.begin(); p != mChildren.end(); p++
    )
        delete *p;
}

MathTableRow::~MathTableRow()
{
    for (vector<MathNode*>::iterator
        p = mEntries.begin(); p != mEntries.end(); p++
    )
        delete *p;
}

MathTable::~MathTable()
{
    for (vector<MathTableRow*>::iterator
        p = mRows.begin(); p != mRows.end(); p++
    )
        delete *p;
}

TextList::~TextList()
{
    for (vector<TextNode*>::iterator
        p = mChildren.begin(); p != mChildren.end(); p++
    )
        delete *p;
}


// =========================================================================
// Implementations of ParseTree::MathStateChange/TextStateChange::Apply


void MathStateChange::Apply(
    TexProcessingState& state
) const
{
    static pair<wstring, LayoutTree::Node::Style> styleCommandArray[] =
    {
        make_pair(L"\\displaystyle",       LayoutTree::Node::cStyleDisplay),
        make_pair(L"\\textstyle",          LayoutTree::Node::cStyleText),
        make_pair(L"\\scriptstyle",        LayoutTree::Node::cStyleScript),
        make_pair(L"\\scriptscriptstyle",  LayoutTree::Node::cStyleScriptScript)
    };
    static wishful_hash_map<wstring, LayoutTree::Node::Style>
        styleCommandTable(
            styleCommandArray,
            END_ARRAY(styleCommandArray)
        );

    wishful_hash_map<wstring, LayoutTree::Node::Style>::const_iterator
        styleCommand = styleCommandTable.find(mCommand);

    if (styleCommand != styleCommandTable.end())
    {
        state.mStyle = styleCommand->second;
        return;
    }

    static pair<wstring, TexMathFont::Family> fontCommandArray[] =
    {
        make_pair(L"\\rm",     TexMathFont::cFamilyRm),
        make_pair(L"\\bf",     TexMathFont::cFamilyBf),
        make_pair(L"\\it",     TexMathFont::cFamilyIt),
        make_pair(L"\\cal",    TexMathFont::cFamilyCal),
        make_pair(L"\\tt",     TexMathFont::cFamilyTt),
        make_pair(L"\\sf",     TexMathFont::cFamilySf)
    };
    static wishful_hash_map<wstring, TexMathFont::Family> fontCommandTable(
        fontCommandArray,
        END_ARRAY(fontCommandArray)
    );

    wishful_hash_map<wstring, TexMathFont::Family>::const_iterator
        fontCommand = fontCommandTable.find(mCommand);

    if (fontCommand != fontCommandTable.end())
    {
        state.mMathFont.mFamily = fontCommand->second;
        return;
    }

    throw logic_error(
        "Unexpected command in MathStateChange::Apply"
    );
}


void TextStateChange::Apply(
    TexProcessingState& state
) const
{
    static pair<wstring, TexTextFont> textCommandArray[] =
    {                                                       //  bold?  italic?
        make_pair(L"\\rm",  TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\it",  TexTextFont(TexTextFont::cFamilyRm, false, true)),
        make_pair(L"\\bf",  TexTextFont(TexTextFont::cFamilyRm, true,  false)),
        make_pair(L"\\sf",  TexTextFont(TexTextFont::cFamilySf, false, false)),
        make_pair(L"\\tt",  TexTextFont(TexTextFont::cFamilyTt, false, false)),
    };
    static wishful_hash_map<wstring, TexTextFont> textCommandTable(
        textCommandArray,
        END_ARRAY(textCommandArray)
    );

    wishful_hash_map<wstring, TexTextFont>::iterator
        textCommand = textCommandTable.find(mCommand);

    if (textCommand == textCommandTable.end())
        throw logic_error(
            "Unexpected command in TextStateChange::Apply"
        );

    state.mTextFont = textCommand->second;
}


void MathColour::Apply(
    TexProcessingState& state
) const
{
    wishful_hash_map<wstring, RGBColour>::const_iterator
        colourLookup = gColourTable.find(mColourName);

    if (colourLookup == gColourTable.end())
        // This shouldn't happen because we checked the colour name during
        // parsing stage
        throw logic_error(
            "Cannot find colour name in MathColour::Apply"
        );

    state.mColour = colourLookup->second;
}


void TextColour::Apply(
    TexProcessingState& state
) const
{
    wishful_hash_map<wstring, RGBColour>::const_iterator
        colourLookup = gColourTable.find(mColourName);

    if (colourLookup == gColourTable.end())
        // This shouldn't happen because we checked the colour name during
        // parsing stage
        throw logic_error(
            "Cannot find colour name in TextColour::Apply"
        );

    state.mColour = colourLookup->second;
}


// =========================================================================
// Implementations of ParseTree::Node::GetPurifiedTex()


void LatexFeatures::Update(const wstring& command)
{
    static wstring gNeedsAmsmathArray[] =
    {
        L"\\text",
        L"\\binom",
        L"\\cfrac",
        L"\\begin{matrix}",
        L"\\begin{pmatrix}",
        L"\\begin{bmatrix}",
        L"\\begin{Bmatrix}",
        L"\\begin{vmatrix}",
        L"\\begin{Vmatrix}",
        L"\\begin{cases}",
        L"\\begin{aligned}",
        L"\\begin{smallmatrix}",
        L"\\overleftrightarrow",
        L"\\boldsymbol",
        L"\\And",
        L"\\iint",
        L"\\iiint",
        L"\\iiiint",
        L"\\varlimsup",
        L"\\varliminf",
        L"\\varinjlim",
        L"\\varprojlim",
        L"\\injlim",
        L"\\projlim",
        L"\\dotsb",
        L"\\operatorname",
        L"\\operatornamewithlimits",
        L"\\lvert",
        L"\\rvert",
        L"\\lVert",
        L"\\rVert",
        L"\\substack",
        L"\\overset",
        L"\\underset",
        L"\\mod",

        // The following commands are all defined in regular latex, but
        // amsmath redefines them to have slightly different properties:
        //
        //  * The text commands are modified so that the font size does not
        //    change if they are used inside a formula.
        //  * The "\dots" command adjusts the height of the dots depending
        //    on the surrounding symbols.
        //  * The "\colon" command gets some spacing adjustments.
        //
        // Therefore for consistency we include amsmath when these commands
        // appear.
        //
        // (FIX: there are probably others that need to be here that I
        // haven't put here yet.)
        L"\\emph",
        L"\\textit",
        L"\\textbf",
        L"\\textrm",
        L"\\texttt",
        L"\\textsf",
        L"\\dots",
        L"\\dotsb",
        L"\\colon"
    };

    static wishful_hash_set<wstring> gNeedsAmsmathTable(
        gNeedsAmsmathArray,
        END_ARRAY(gNeedsAmsmathArray)
    );
        

    static wstring gNeedsAmssymbArray[] =
    {
        L"\\varkappa",
        L"\\digamma",
        L"\\beth",
        L"\\gimel",
        L"\\daleth",
        L"\\Finv",
        L"\\Game",
        L"\\upharpoonright",
        L"\\upharpoonleft",
        L"\\downharpoonright",
        L"\\downharpoonleft",
        L"\\nleftarrow",
        L"\\nrightarrow",
        L"\\sqsupset",
        L"\\sqsubset",
        L"\\supsetneq",
        L"\\subsetneq",
        L"\\Vdash",
        L"\\vDash",
        L"\\lesssim",
        L"\\nless",
        L"\\ngeq",
        L"\\nleq",
        L"\\smallsmile",
        L"\\smallfrown",
        L"\\smallsetminus",
        L"\\varnothing",
        L"\\nmid",
        L"\\square",
        L"\\Box",
        L"\\checkmark",
        L"\\complement",
        L"\\eth",
        L"\\hslash",
        L"\\mho",
        L"\\circledR",
        L"\\yen",
        L"\\maltese",
        L"\\ulcorner",
        L"\\urcorner",
        L"\\llcorner",
        L"\\lrcorner",
        L"\\dashrightarrow",
        L"\\dasharrow",
        L"\\dashleftarrow",
        L"\\backprime",
        L"\\vartriangle",
        L"\\blacktriangle",
        L"\\triangledown",
        L"\\blacktriangledown",
        L"\\blacksquare",
        L"\\lozenge",
        L"\\blacklozenge",
        L"\\circledS",
        L"\\bigstar",
        L"\\sphericalangle",
        L"\\measuredangle",
        L"\\diagup",
        L"\\diagdown",
        L"\\Bbbk",
        L"\\dotplus",
        L"\\ltimes",
        L"\\rtimes",
        L"\\Cap",
        L"\\leftthreetimes",
        L"\\rightthreetimes",
        L"\\Cup",
        L"\\barwedge",
        L"\\curlywedge",
        L"\\veebar",
        L"\\curlyvee",
        L"\\doublebarwedge",
        L"\\boxminus",
        L"\\circleddash",
        L"\\boxtimes",
        L"\\circledast",
        L"\\boxdot",
        L"\\circledcirc",
        L"\\boxplus",
        L"\\centerdot",
        L"\\divideontimes",
        L"\\intercal",
        L"\\leqq",
        L"\\geqq",
        L"\\leqslant",
        L"\\geqslant",
        L"\\eqslantless",
        L"\\eqslantgtr",
        L"\\gtrsim",
        L"\\lessapprox",
        L"\\gtrapprox",
        L"\\approxeq",
        L"\\eqsim",
        L"\\lessdot",
        L"\\gtrdot",
        L"\\lll",
        L"\\ggg",
        L"\\lessgtr",
        L"\\gtrless",
        L"\\lesseqgtr",
        L"\\gtreqless",
        L"\\lesseqqgtr",
        L"\\gtreqqless",
        L"\\doteqdot",
        L"\\eqcirc",
        L"\\risingdotseq",
        L"\\circeq",
        L"\\fallingdotseq",
        L"\\triangleq",
        L"\\backsim",
        L"\\thicksim",
        L"\\backsimeq",
        L"\\thickapprox",
        L"\\subseteqq",
        L"\\supseteqq",
        L"\\Subset",
        L"\\Supset",
        L"\\preccurlyeq",
        L"\\succcurlyeq",
        L"\\curlyeqprec",
        L"\\curlyeqsucc",
        L"\\precsim",
        L"\\succsim",
        L"\\precapprox",
        L"\\succapprox",
        L"\\vartriangleleft",
        L"\\vartriangleright",
        L"\\Vvdash",
        L"\\shortmid",
        L"\\shortparallel",
        L"\\bumpeq",
        L"\\between",
        L"\\Bumpeq",
        L"\\varpropto",
        L"\\backepsilon",
        L"\\blacktriangleleft",
        L"\\blacktriangleright",
        L"\\therefore",
        L"\\because",
        L"\\ngtr",
        L"\\nleqslant",
        L"\\ngeqslant",
        L"\\nleqq",
        L"\\ngeqq",
        L"\\lneqq",
        L"\\gneqq",
        L"\\lvertneqq",
        L"\\gvertneqq",
        L"\\lnsim",
        L"\\gnsim",
        L"\\lnapprox",
        L"\\gnapprox",
        L"\\nprec",
        L"\\nsucc",
        L"\\npreceq",
        L"\\nsucceq",
        L"\\precneqq",
        L"\\succneqq",
        L"\\precnsim",
        L"\\succnsim",
        L"\\precnapprox",
        L"\\succnapprox",
        L"\\nsim",
        L"\\ncong",
        L"\\nshortmid",
        L"\\nshortparallel",
        L"\\nmid",
        L"\\nparallel",
        L"\\nvdash",
        L"\\nvDash",
        L"\\nVdash",
        L"\\nVDash",
        L"\\ntriangleleft",
        L"\\ntriangleright",
        L"\\ntrianglelefteq",
        L"\\ntrianglerighteq",
        L"\\nsubseteq",
        L"\\nsupseteq",
        L"\\nsubseteqq",
        L"\\nsupseteqq",
        L"\\subsetneq",
        L"\\supsetneq",
        L"\\varsubsetneq",
        L"\\varsupsetneq",
        L"\\subsetneqq",
        L"\\supsetneqq",
        L"\\varsubsetneqq",
        L"\\varsupsetneqq",
        L"\\leftleftarrows",
        L"\\rightrightarrows",
        L"\\leftrightarrows",
        L"\\rightleftarrows",
        L"\\Lleftarrow",
        L"\\Rrightarrow",
        L"\\twoheadleftarrow",
        L"\\twoheadrightarrow",
        L"\\leftarrowtail",
        L"\\rightarrowtail",
        L"\\looparrowleft",
        L"\\looparrowright",
        L"\\leftrightharpoons",
        L"\\rightleftharpoons",
        L"\\curvearrowleft",
        L"\\curvearrowright",
        L"\\circlearrowleft",
        L"\\circlearrowright",
        L"\\Lsh",
        L"\\Rsh",
        L"\\upuparrows",
        L"\\downdownarrows",
        L"\\multimap",
        L"\\rightsquigarrow",
        L"\\leftrightsquigarrow",
        L"\\nLeftarrow",
        L"\\nRightarrow",
        L"\\nleftrightarrow",
        L"\\nLeftrightarrow",
        L"\\pitchfork",
        L"\\nexists",
        L"\\lhd",
        L"\\rhd",
        L"\\unlhd",
        L"\\unrhd",
        L"\\Join",
        L"\\leadsto"
    };

    static wishful_hash_set<wstring> gNeedsAmssymbTable(
        gNeedsAmssymbArray,
        END_ARRAY(gNeedsAmssymbArray)
    );
        
    // Note: there might be other commands which imply loading packages
    // which are handled elsewhere (e.g. \color)

    if (command[0] == L'\\')
    {
        if (command == L"\\cyr")
            mNeedsX2 = mNeedsUcs = true;
        if (command == L"\\jap")
            mNeedsCJK = mNeedsJapaneseFont = true;
        
        if (!mNeedsAmsfonts &&
            (command == L"\\mathbb" || command == L"\\mathfrak")
        )
            mNeedsAmsfonts = true;
        
        if (!mNeedsAmsmath && gNeedsAmsmathTable.count(command))
            mNeedsAmsmath = true;

        if (!mNeedsAmssymb && gNeedsAmssymbTable.count(command))
            mNeedsAmssymb = true;
    }
}


void MathSymbol::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    os << L" " << mCommand;
}


void MathCommand1Arg::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    os << mCommand << L"{";
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"}";
}


void MathStateChange::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    os << mCommand << L" ";
}


void MathColour::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.mNeedsColor = true;
    os << L"\\color{" << mColourName << L"}";
}


void MathCommand2Args::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    if (mIsInfix)
    {
        // e.g. "\over"
        os << L"{";
        mChild1->GetPurifiedTex(os, features, fontEncoding);
        os << L"}" << mCommand << L"{";
        mChild2->GetPurifiedTex(os, features, fontEncoding);
        os << L"}";
    }
    else
    {
        if (mCommand == L"\\rootReserved")
        {
            os << L"\\sqrt[{";
            mChild1->GetPurifiedTex(os, features, fontEncoding);
            os << L"}]{";
            mChild2->GetPurifiedTex(os, features, fontEncoding);
            os << L"}";
        }
        else
        {
            os << mCommand << L"{";
            mChild1->GetPurifiedTex(os, features, fontEncoding);
            os << L"}{";
            mChild2->GetPurifiedTex(os, features, fontEncoding);
            os << L"}";
        }
    }
}


void MathGroup::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    os << L"{";
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"}";
}


void MathList::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    for (vector<MathNode*>::const_iterator
        ptr = mChildren.begin();
        ptr != mChildren.end();
        ptr++
    )
        (*ptr)->GetPurifiedTex(os, features, fontEncoding);
}


void MathScripts::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    if (mBase.get())
        mBase->GetPurifiedTex(os, features, fontEncoding);
    if (mUpper.get())
    {
        os << L"^{";
        mUpper->GetPurifiedTex(os, features, fontEncoding);
        os << L"}";
    }
    if (mLower.get())
    {
        os << L"_{";
        mLower->GetPurifiedTex(os, features, fontEncoding);
        os << L"}";
    }
}


void MathLimits::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << mCommand;
}


void MathDelimited::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mLeftDelimiter);
    features.Update(mRightDelimiter);
    
    os << L"\\left" << mLeftDelimiter;
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"\\right" << mRightDelimiter;
}


void MathBig::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    features.Update(mDelimiter);
    
    os << mCommand << mDelimiter;
}


void MathTableRow::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    for (vector<MathNode*>::const_iterator
        ptr = mEntries.begin();
        ptr != mEntries.end();
        ptr++
    )
    {
        if (ptr != mEntries.begin())
            os << L" &";
        (*ptr)->GetPurifiedTex(os, features, fontEncoding);
    }
}


void MathTable::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    for (vector<MathTableRow*>::const_iterator
        ptr = mRows.begin();
        ptr != mRows.end();
        ptr++
    )
    {
        if (ptr != mRows.begin())
            os << L" \\\\";
        (*ptr)->GetPurifiedTex(os, features, fontEncoding);
    }
}


void MathEnvironment::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    wstring beginCommand, endCommand;
    if (mIsShort)
    {
        beginCommand = L"\\" + mName;
        features.Update(beginCommand);
        beginCommand += L"{";
        endCommand = L"}";
    }
    else
    {
        beginCommand = L"\\begin{" + mName + L"}";
        features.Update(beginCommand);
        endCommand = L"\\end{" + mName + L"}";
    }
    
    os << beginCommand;
    mTable->GetPurifiedTex(os, features, fontEncoding);
    os << endCommand;
}


void TextList::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    for (vector<TextNode*>::const_iterator
        ptr = mChildren.begin();
        ptr != mChildren.end();
        ptr++
    )
        (*ptr)->GetPurifiedTex(os, features, fontEncoding);
}


void TextGroup::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    os << L"{";
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"}";
}


wstring FormatCodePoint(unsigned code)
{
    wostringstream s;
    s << L"U+" << hex << setfill(L'0') << uppercase << setw(8) << code;
    return s.str();
}

wstring FontEncodingName[] =
{
    L"default",
    L"cyrillic",
    L"japanese"
};

void TextSymbol::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    // These are all the non-ASCII unicode characters that we will translate
    // directly to \unichar without additional font encoding commands.
    static wchar_t gSimpleUnicodeArray[] =
    {
        161, 163, 167, 169, 172, 174, 176, 181, 182, 191, 192, 193, 194,
        195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207,
        209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221,
        223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235,
        236, 237, 238, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250,
        251, 252, 253, 255, 256, 257, 258, 259, 262, 263, 264, 265, 266,
        267, 268, 269, 270, 271, 274, 275, 276, 277, 278, 279, 282, 283,
        284, 285, 286, 287, 288, 289, 290, 292, 293, 296, 297, 298, 299,
        300, 301, 304, 305, 308, 309, 310, 311, 313, 314, 315, 316, 317,
        318, 321, 322, 323, 324, 325, 326, 327, 328, 332, 333, 334, 335,
        336, 337, 338, 339, 340, 341, 342, 343, 344, 345, 346, 347, 348,
        349, 350, 351, 352, 353, 354, 355, 356, 357, 360, 361, 362, 363,
        364, 365, 366, 367, 368, 369, 372, 373, 374, 375, 376, 377, 378,
        379, 380, 381, 382, 461, 462, 463, 464, 465, 466, 467, 468, 482,
        483, 486, 487, 488, 489, 496, 500, 501, 504, 505, 508, 509, 510,
        511, 536, 537, 538, 539, 542, 543, 550, 551, 552, 553, 558, 559,
        562, 563
    };

    static set<wchar_t> gSimpleUnicodeTable(
        gSimpleUnicodeArray,
        END_ARRAY(gSimpleUnicodeArray)
    );

    if (mCommand.size() > 1 || mCommand[0] <= 0x7F)
    {
        // Plain ASCII character, or something like \textbackslash or \{.
        if (mCommand != L" " && fontEncoding != cFontEncodingDefault)
            throw Exception(
                L"WrongFontEncoding",
                mCommand,
                FontEncodingName[fontEncoding]
            );

        features.Update(mCommand);
        os << mCommand;
    }
    else
    {
        unsigned code = static_cast<unsigned>(mCommand[0]);

        if (gSimpleUnicodeTable.count(code))
        {
            if (fontEncoding != cFontEncodingDefault)
                throw Exception(
                    L"WrongFontEncoding",
                    FormatCodePoint(code),
                    FontEncodingName[fontEncoding]
                );

            features.mNeedsUcs = true;
            os << L"\\unichar{" << code << L"}";
        }
        // Cyrillic:
        else if (code >= 0x400 && code <= 0x45F)
        {
            if (fontEncoding != cFontEncodingCyrillic)
                throw Exception(
                    L"WrongFontEncodingWithHint",
                    FormatCodePoint(code),
                    FontEncodingName[fontEncoding],
                    L"\\cyr"
                );
            
            features.mNeedsUcs = true;
            features.mNeedsX2 = true;
            os << L"\\unichar{" << code << L"}";
        }
        // Japanese:
        // FIX: we're making a very half-hearted attempt to filter out
        // non-Japanese characters here...
        else if (
               (code >= 0x3040 && code <= 0x30FF)   // hiragana + katakana
            || (code >= 0x3400 && code <= 0x9FFF)   // some kanji
            || (code >= 0xF900 && code <= 0xFAE0)   // more kanji
        )
        {
            if (fontEncoding != cFontEncodingJapanese)
                throw Exception(
                    L"WrongFontEncodingWithHint",
                    FormatCodePoint(code),
                    FontEncodingName[fontEncoding],
                    L"\\jap"
                );
            
            features.mNeedsCJK = true;
            features.mNeedsJapaneseFont = true;
            // FIX: find out if CJK package lets us input via code point
            // instead of UTF-8
            os << mCommand[0];
        }
        else
        {
            throw Exception(
                L"PngIncompatibleCharacter",
                FormatCodePoint(code)
            );
        }
    }
}


void TextStateChange::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    os << mCommand << L"{}";
}


void TextColour::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.mNeedsColor = true;
    os << L"\\color{" << mColourName << L"}";
}


// Determines whether the supplied command is a font encoding command
// (like "\cyr" or "\jap"), modifies fontEncoding accordingly, and throws
// an exception if nested encodings occur.
void HandleFontEncodingCommand(
    const wstring& command,
    FontEncoding& fontEncoding
)
{
    FontEncoding newEncoding = cFontEncodingDefault;
    
    if (command == L"\\cyr")
        newEncoding = cFontEncodingCyrillic;
    else if (command == L"\\jap")
        newEncoding = cFontEncodingJapanese;
        
    if (newEncoding != cFontEncodingDefault)
    {
        if (fontEncoding != cFontEncodingDefault)
            throw Exception(L"IllegalNestedFontEncodings");

        fontEncoding = newEncoding;
    }
}

void TextCommand1Arg::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    HandleFontEncodingCommand(mCommand, fontEncoding);

    os << mCommand << L"{";
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"}";
}


void EnterTextMode::GetPurifiedTex(
    wostream& os,
    LatexFeatures& features,
    FontEncoding fontEncoding
) const
{
    features.Update(mCommand);
    HandleFontEncodingCommand(mCommand, fontEncoding);

    os << mCommand << L"{";
    mChild->GetPurifiedTex(os, features, fontEncoding);
    os << L"}";
}

// =========================================================================
// Now all the ParseTree debugging code.

// This function generates the indents used by various debugging Print()
// functions.
wstring indent(int depth)
{
    return wstring(2 * depth, L' ');
}

void MathSymbol::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathSymbol \"" << mCommand << L"\"" << endl;
}

void MathCommand1Arg::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathCommand1Arg \""
        << mCommand << L"\"" << endl;
    mChild->Print(os, depth+1);
}

void MathCommand2Args::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathCommand2Args \""
        << mCommand << L"\"" << endl;
    mChild1->Print(os, depth+1);
    mChild2->Print(os, depth+1);
}

void MathGroup::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathGroup" << endl;
    mChild->Print(os, depth+1);
}

void MathList::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathList" << endl;
    for (vector<MathNode*>::const_iterator
        ptr = mChildren.begin(); ptr != mChildren.end(); ptr++
    )
        (*ptr)->Print(os, depth+1);
}

void MathScripts::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathScripts" << endl;
    if (mBase.get())
    {
        os << indent(depth+1) << L"base" << endl;
        mBase->Print(os, depth+2);
    }
    if (mUpper.get())
    {
        os << indent(depth+1) << L"upper" << endl;
        mUpper->Print(os, depth+2);
    }
    if (mLower.get())
    {
        os << indent(depth+1) << L"lower" << endl;
        mLower->Print(os, depth+2);
    }
}

void MathLimits::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathLimits \"" << mCommand << L"\"" << endl;
    mChild->Print(os, depth+1);
}

void MathStateChange::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathStateChange \""
        << mCommand << L"\"" << endl;
}

void MathColour::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathColour \""
        << mColourName << L"\"" << endl;
}

void MathDelimited::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathDelimited \"" << mLeftDelimiter
        << L"\" \"" << mRightDelimiter << L"\"" << endl;
    mChild->Print(os, depth+1);
}

void MathBig::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathBig \"" << mCommand << L"\" \""
        << mDelimiter << L"\"" << endl;
}

void MathTableRow::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathTableRow" << endl;
    for (vector<MathNode*>::const_iterator
        ptr = mEntries.begin(); ptr != mEntries.end(); ptr++
    )
        (*ptr)->Print(os, depth+1);
}

void MathTable::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathTable" << endl;
    for (vector<MathTableRow*>::const_iterator
        ptr = mRows.begin(); ptr != mRows.end(); ptr++
    )
        (*ptr)->Print(os, depth+1);
}

void MathEnvironment::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"MathEnvironment \"" << mName << L"\"";
    if (mIsShort)
        os << " (short)";
    os << endl;
    mTable->Print(os, depth+1);
}

void EnterTextMode::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"EnterTextMode \"" << mCommand << L"\"" << endl;
    mChild->Print(os, depth+1);
}

void TextList::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextList" << endl;
    for (vector<TextNode*>::const_iterator
        ptr = mChildren.begin(); ptr != mChildren.end(); ptr++
    )
        (*ptr)->Print(os, depth+1);
}

void TextSymbol::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextSymbol \"" << mCommand << L"\"" << endl;
}

void TextCommand1Arg::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextCommand1Arg \""
        << mCommand << L"\"" << endl;
    mChild->Print(os, depth+1);
}

void TextStateChange::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextStateChange \""
        << mCommand << L"\"" << endl;
}

void TextColour::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextColour \""
        << mColourName << L"\"" << endl;
}

void TextGroup::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"TextGroup" << endl;
    mChild->Print(os, depth+1);
}

}
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
