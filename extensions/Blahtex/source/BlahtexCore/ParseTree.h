// File "ParseTree.h"
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

#ifndef BLAHTEX_PARSETREE_H
#define BLAHTEX_PARSETREE_H

// Everything here is implemented variously in ParseTree1.cpp,
// ParseTree2.cpp and ParseTree3.cpp.

#include <memory>
#include "LayoutTree.h"

// The ParseTree namespace contains all classes representing nodes in the
// parse tree. This is essentially a tree representation of the input
// TeX expression, with as little additional processing done as possible.
// The idea is that the "purified TeX" should be easily reconstructible
// from the parse tree.

namespace blahtex
{

// This struct describes (approximately) a TeX font during math mode.
struct TexMathFont
{
    enum Family
    {
        cFamilyDefault,  // indicates default font
                         // (e.g. "x" gets italics, "1" gets roman)
        cFamilyRm,       // roman
        cFamilyBf,       // bold
        cFamilyIt,       // italics
        cFamilySf,       // sans serif
        cFamilyTt,       // typewriter
        cFamilyBb,       // blackboard bold
        cFamilyCal,      // calligraphic
        cFamilyFrak      // fraktur
    }
    mFamily;

    // Whether or not we are in "\boldsymbol" mode (from AMS packages).
    // This seems to be mostly orthogonal to the family. (I haven't
    // studied carefully how this is implemented in TeX.)
    bool mIsBoldsymbol;

    TexMathFont(
        Family family = cFamilyDefault,
        bool isBoldsymbol = false
    ) :
        mFamily(family),
        mIsBoldsymbol(isBoldsymbol)
    { }

    // This function finds the closest MathML font (i.e. value of
    // mathvariant) which matches this TeX font.
    MathmlFont GetMathmlApproximation() const;
};

// This struct describes (approximately) a TeX font during text mode.
struct TexTextFont
{
    enum Family
    {
        cFamilyRm,       // roman
        cFamilySf,       // sans serif
        cFamilyTt        // typewriter
    }
    mFamily;

    bool mIsBold;
    bool mIsItalic;

    TexTextFont(
        Family family = cFamilyRm,
        bool isBold = false,
        bool isItalic = false
    ) :
        mFamily(family),
        mIsBold(isBold),
        mIsItalic(isItalic)
    { }

    // This function finds the closest MathML font (i.e. value of
    // mathvariant) which matches this TeX font.
    MathmlFont GetMathmlApproximation() const;
};


// This struct represents some state information during the parse tree =>
// layout tree building phase (i.e. while within BuildLayoutTree).
struct TexProcessingState
{
    TexMathFont mMathFont;
    TexTextFont mTextFont;
    LayoutTree::Node::Style mStyle;
    RGBColour mColour;
};


// This struct keeps track of the packages, encodings etc, that LaTeX will
// need to be able to handle the given input.
struct LatexFeatures
{
    // Requires amsmath, amsfonts, amssymb packages
    bool mNeedsAmsmath;
    bool mNeedsAmsfonts;
    bool mNeedsAmssymb;

    // Requires "\usepackage[utf8x]{inputenc}".
    bool mNeedsUcs;
    
    // Requires the "color" package.
    bool mNeedsColor;
    
    // Requires "X2" font encoding (for cyrillic).
    bool mNeedsX2;
    
    // Requires the "CJK" package.
    bool mNeedsCJK;
    
    // Needs a japanese font to be installed.
    bool mNeedsJapaneseFont;
    
    LatexFeatures() :
        mNeedsAmsmath(false),
        mNeedsAmsfonts(false),
        mNeedsAmssymb(false),
        mNeedsUcs(false),
        mNeedsColor(false),
        mNeedsX2(false),
        mNeedsCJK(false),
        mNeedsJapaneseFont(false)
    { }

    // Given the LaTeX command "command", checks to see if any of the above
    // flags need to be switched on for that command to work.
    void Update(const std::wstring& command);
};


// While preparing the purified TeX, blahtex keeps track of something
// approximating the current font encoding. E.g. while in X2 encoding, only
// cyrillic characters and whitespace are allowed.
enum FontEncoding
{
    cFontEncodingDefault,
    cFontEncodingCyrillic,
    cFontEncodingJapanese
};


namespace ParseTree
{
    // Base class for nodes in the parse tree.
    struct Node
    {
        virtual ~Node()
        { };

        // This function converts the parse tree under this node into a
        // layout tree. This is where most of blahtex's hard work is done.
        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const = 0;

        // This function converts the parse tree under this node to
        // "purified TeX"; that is, TeX markup that can get sent to LaTeX
        // for PNG generation. Output gets written to the supplied stream.
        //
        // This (obviously) does not include the file header and footer;
        // see Manager::GeneratePurifiedTex for that.
        //
        // The "features" object is used to store a list of e.g. LaTeX
        // packages that will be required to handle the given output.
        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const = 0;

        // Print() recursively prints the parse tree under this node.
        // Debugging use only.
        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const = 0;
    };


    // MathNode represents any node occurring during math mode.
    struct MathNode : Node
    {
    };

    // TextNode represents any node occurring during text mode.
    struct TextNode : Node
    {
    };


    // Represents any command like "a", "1", "\alpha", "\int" which blahtex
    // treats as a single symbol. Also includes spacing commands like "\,".
    struct MathSymbol : MathNode
    {
        // The command, e.g. "a", "\alpha".
        std::wstring mCommand;

        MathSymbol(const std::wstring& command) :
            mCommand(command)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };

    // Represents a command taking a single argument.
    struct MathCommand1Arg : MathNode
    {
        // The command, e.g. "\hat", "\mathop".
        std::wstring mCommand;

        // Node corresponding to the argument of the command.
        std::auto_ptr<MathNode> mChild;

        MathCommand1Arg(
            const std::wstring& command,
            std::auto_ptr<MathNode> child
        ) :
            mCommand(command),
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a TeX state change command like "\rm", "\scriptstyle",
    // "\color".
    struct MathStateChange : MathNode
    {
        // The style change command, e.g. "\scriptstyle".
        std::wstring mCommand;

        MathStateChange(
            const std::wstring& command
        ) :
            mCommand(command)
        { }
        
        // Modifies "state" according to the state change command.
        virtual void Apply(
            TexProcessingState& state
        ) const;

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a "\color{xyz}" command in math mode.
    struct MathColour : MathStateChange
    {
        // The colour name, e.g. "red".
        std::wstring mColourName;

        MathColour(
            const std::wstring& colourName
        ) :
            MathStateChange(L"\\color"),
            mColourName(colourName)
        { }

        virtual void Apply(
            TexProcessingState& state
        ) const;

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a command taking two arguments, including infix commands.
    struct MathCommand2Args : MathNode
    {
        // The command, e.g. "\frac", "\choose".
        std::wstring mCommand;

        // The two arguments.
        std::auto_ptr<MathNode> mChild1, mChild2;

        // This flag is set for infix commands like "\over".
        bool mIsInfix;

        MathCommand2Args(
            const std::wstring& command,
            std::auto_ptr<MathNode> child1,
            std::auto_ptr<MathNode> child2,
            bool isInfix
        ) :
            mCommand(command),
            mChild1(child1),
            mChild2(child2),
            mIsInfix(isInfix)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a "big" command like "\big", "\bigg" etc.
    struct MathBig : MathNode
    {
        // The command, e.g. "\big".
        std::wstring mCommand;

        // The delimiter that the big command is applied to, e.g. "\langle".
        std::wstring mDelimiter;

        MathBig(
            const std::wstring& command,
            const std::wstring& delimiter
        ) :
            mCommand(command),
            mDelimiter(delimiter)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents material surrounded by grouping braces, e.g. "{abc}" gets
    // stored as a MathGroup node whose child contains "abc".
    struct MathGroup : MathNode
    {
        // The enclosed material.
        std::auto_ptr<MathNode> mChild;

        MathGroup(std::auto_ptr<MathNode> child) :
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a sequence of nodes in math mode, concatenated together.
    // e.g. "a\alpha 2" is stored as a MathList containing three MathSymbol
    // nodes.
    struct MathList : MathNode
    {
        std::vector<MathNode*> mChildren;

        ~MathList();

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a base with a superscript and/or subscript.
    // (i.e. an expression like "x^y_z".)
    struct MathScripts : MathNode
    {
        // All three fields are optional (NULL indicates an empty field).
        std::auto_ptr<MathNode> mBase, mUpper, mLower;

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a "limits" command, i.e. one of "\limits", "\nolimits",
    // or "\displaylimits".
    struct MathLimits : MathNode
    {
        // The command, e.g. "\limits".
        std::wstring mCommand;

        // mChild is the operator that the limits command is applied to.
        // e.g. for the input "x^2\limits_5", the base of the MathScripts
        // node should be a MathLimits node, whose child is the MathSymbol
        // node representing "x".
        std::auto_ptr<MathNode> mChild;

        MathLimits(
            const std::wstring& command,
            std::auto_ptr<MathNode> child
        ) :
            mCommand(command),
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents an expression surrounded by "\left( ... \right)".
    struct MathDelimited : MathNode
    {
        // The delimiters, e.g. "\langle", "(".
        std::wstring mLeftDelimiter, mRightDelimiter;

        // The stuff enclosed by the delimiters:
        std::auto_ptr<MathNode> mChild;

        MathDelimited(
            std::auto_ptr<MathNode> child,
            const std::wstring& leftDelimiter,
            const std::wstring& rightDelimiter
        ) :
            mChild(child),
            mLeftDelimiter(leftDelimiter),
            mRightDelimiter(rightDelimiter)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a row of a table, e.g. might represent the
    // TeX subexpression "a & b & c".
    struct MathTableRow : MathNode
    {
        // The entries in the row.
        std::vector<MathNode*> mEntries;

        ~MathTableRow();

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a table, e.g. might represent the TeX subexpression
    // expression "a & b & c \\ \\ d & e & f \\ g & h".
    struct MathTable : MathNode
    {
        // The rows of the table.
        std::vector<MathTableRow*> mRows;

        ~MathTable();

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents an environment, i.e. "\begin{xxx} ... \end{xxx}".
    // Currently all supported environments are just various forms of table,
    // so for the moment we insist that it contains a table.
    struct MathEnvironment : MathNode
    {
        // Currently one of:
        // "matrix", "pmatrix", "bmatrix", "Bmatrix", "vmatrix", "Vmatrix",
        // "cases", "smallmatrix", "aligned", "substack"
        std::wstring mName;

        // True for things like "\substack" which don't need "\begin"
        // and "\end";
        // False for anything involving "\begin" and "\end"
        bool mIsShort;

        // The contained table.
        std::auto_ptr<MathTable> mTable;

        MathEnvironment(
            const std::wstring& name,
            std::auto_ptr<MathTable> table,
            bool isShort
        ) :
            mName(name),
            mTable(table),
            mIsShort(isShort)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a command that switches from math mode into text mode,
    // e.g. "\text". Note that certain commands (e.g. "\text") will be
    // translated into a TextCommand1Arg node if encountered during text
    // mode, but into a EnterTextMode if encountered during math mode.
    struct EnterTextMode : MathNode
    {
        // The command, e.g. "\text".
        std::wstring mCommand;

        // The enclosed *text-mode* node.
        std::auto_ptr<TextNode> mChild;

        EnterTextMode(
            const std::wstring& command,
            std::auto_ptr<TextNode> child
        ) :
            mCommand(command),
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a sequence of nodes in text mode, concatenated together.
    // e.g. "abc" is stored as a TextList containing three TextSymbol nodes.
    struct TextList : TextNode
    {
        std::vector<TextNode*> mChildren;

        ~TextList();

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents text mode material surrounded by grouping braces.
    struct TextGroup : TextNode
    {
        // The enclosed material.
        std::auto_ptr<TextNode> mChild;

        TextGroup(std::auto_ptr<TextNode> child) :
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents any text mode command like "a", "1", "\textbackslash"
    // that is treated as a single symbol (includes spacing commands
    // like "\,").
    struct TextSymbol : TextNode
    {
        // The command, e.g. "a" or "\textbackslash"
        std::wstring mCommand;

        TextSymbol(const std::wstring& command) :
            mCommand(command)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a state change command like "\rm" occurring in text mode.
    struct TextStateChange : TextNode
    {
        // The command, e.g. "\rm".
        std::wstring mCommand;

        TextStateChange(
            const std::wstring& command
        ) :
            mCommand(command)
        { }

        // Modifies "state" according to the state change command.
        virtual void Apply(
            TexProcessingState& state
        ) const;

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a "\color{xyz}" command in text mode.
    struct TextColour : TextStateChange
    {
        // The colour name, e.g. "red".
        std::wstring mColourName;

        TextColour(
            const std::wstring& colourName
        ) :
            TextStateChange(L"\\color"),
            mColourName(colourName)
        { }

        virtual void Apply(
            TexProcessingState& state
        ) const;

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };


    // Represents a command in text mode taking a single argument.
    struct TextCommand1Arg : TextNode
    {
        // The command, e.g. "\textrm".
        std::wstring mCommand;

        // Node corresponding to the argument of the command.
        std::auto_ptr<TextNode> mChild;

        TextCommand1Arg(
            const std::wstring& command,
            std::auto_ptr<TextNode> child
        ) :
            mCommand(command),
            mChild(child)
        { }

        virtual std::auto_ptr<LayoutTree::Node> BuildLayoutTree(
            const TexProcessingState& state
        ) const;

        virtual void GetPurifiedTex(
            std::wostream& os,
            LatexFeatures& features,
            FontEncoding fontEncoding
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth
        ) const;
    };

} // end ParseTree namespace

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
