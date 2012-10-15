// File "LayoutTree.h"
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

#ifndef BLAHTEX_LAYOUTTREE_H
#define BLAHTEX_LAYOUTTREE_H

#include "MathmlNode.h"

namespace blahtex
{

// The maximum number of nodes allowed in the output MathML tree.
// (This limit is imposed to prevent users eliciting quadratic time by
// inputting arrays with lots of empty entries.)
const unsigned cMaxMathmlNodeCount = 2500;


struct MathmlEnvironment;

// The LayoutTree namespace contains all classes that represents nodes in
// the layout tree. The layout tree is an intermediate stage between the
// parse tree and the final output XML tree.
namespace LayoutTree
{
    // Base class for layout tree nodes.
    struct Node
    {
        virtual ~Node()
        { }

        // This field is only used during the layout tree building phase, to
        // determine inter-atomic spacing. The values correspond roughly
        // to TeX's differently flavoured atoms. (We omit several flavours
        // that TeX uses, like "acc" and "rad"; these are generally handled
        // as "ord".)
        //
        // This field is ignored for LayoutTree::Space nodes.
        enum Flavour
        {
            cFlavourOrd,
            cFlavourOp,
            cFlavourBin,
            cFlavourRel,
            cFlavourOpen,
            cFlavourClose,
            cFlavourPunct,
            cFlavourInner
        }
        mFlavour;

        // This field is only used during the layout tree building phase, to
        // determine script placement. It corresponds to TeX's "limits",
        // "nolimits", "displaylimits" trichotomy.
        //
        // It is only valid if mFlavour == cFlavourOp.
        enum Limits
        {
            cLimitsDisplayLimits,
            cLimitsLimits,
            cLimitsNoLimits
        }
        mLimits;

        // This field corresponds to TeX's displaystyle/textstyle/
        // scriptstyle/scriptscriptstyle setting. (We ignore the cramped/
        // uncramped variations.)
        //
        // This field is ignored for LayoutTree::Space nodes.
        enum Style
        {
            cStyleDisplay,              // like \displaystyle
            cStyleText,                 // like \textstyle
            cStyleScript,               // like \scriptstyle
            cStyleScriptScript          // like \scriptscriptstyle
        }
        mStyle;
        
        // Colour of the node. For symbols this is the colour of the symbol;
        // for fractions it's the colour of the horizontal bar; for radicals
        // it's the colour of the radical symbol.
        //
        // This field is ignored for LayoutTree::Space nodes.
        RGBColour mColour;


        Node(
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour
        ) :
            mStyle(style),
            mFlavour(flavour),
            mLimits(limits),
            mColour(colour)
        { }


        // This function "optimises" the tree beneath the current node:
        // (1) It merges adjacent Space nodes into single spaces, and
        // (2) It merges adjacent Symbol nodes in certain situations.
        //     For exammple, we want <mn>12</mn> instead of
        //     <mn>1</mn><mn>2</mn>, and <mi>sin</mi> instead of
        //     <mi mathvariant="normal">s</mi>
        //     <mi mathvariant="normal">i</mi>
        //     <mi mathvariant="normal">n</mi>   !!!!
        virtual void Optimise()
        { }
        

        // This function converts the layout tree rooted at this node into
        // a MathML tree.
        //
        // The inheritedEnvironment parameter tells it what assumptions to
        // make about its rendering environment. It uses these to decide
        // whether to insert extra <mstyle> tags.
        //
        // The nodeCount parameter is used to keep track of the total number
        // of nodes in the MathML tree. For security reasons we put a hard
        // limit on this. (See cMaxMathmlNodeCount.)
        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const = 0;


        // This function recursively prints the layout tree under this node.
        // Debugging use only.
        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const = 0;

        std::wstring PrintFields() const;   // used internally by Print
    };


    // A Row stores a list of children nodes. It gets translated into an
    // <mrow> node in the MathML tree.
    //
    // No Row ever has another Row node as its child.
    struct Row : Node
    {
        std::list<Node*> mChildren;

        Row(Style style, RGBColour colour) :
            Node(style, cFlavourOrd, cLimitsDisplayLimits, colour)
        { }

        ~Row();

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Symbol is an abstract class; its concrete subclasses are
    // SymbolIdentifier, SymbolNumber, SymbolOperator, SymbolText. It
    // represents anything that will get translated as <mn>, <mi>, <mo>
    // or <mtext>. It describes the text that goes inside the tags (mText)
    // and what font it should be in (mFont).
    struct Symbol : Node
    {
        std::wstring mText;
        MathmlFont mFont;

        Symbol(
            const std::wstring& text,
            MathmlFont font,
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour
        ) :
            Node(style, flavour, limits, colour),
            mText(text),
            mFont(font)
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const = 0;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const = 0;
    };


    // SymbolIdentifier represents things translated as <mi>.
    struct SymbolIdentifier : Symbol
    {
        SymbolIdentifier(
            const std::wstring& text,
            MathmlFont font,
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour
        ) :
            Symbol(text, font, style, flavour, limits, colour)
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // SymbolNumber represents things translated as <mn>.
    struct SymbolNumber : Symbol
    {
        SymbolNumber(
            const std::wstring& text,
            MathmlFont font,
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour
        ) :
            Symbol(text, font, style, flavour, limits, colour)
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // SymbolText represents things translated as <mtext>.
    //
    // Actually, each SymbolText represents just a single character;
    // they get merged by their parent's Row::BuildMathmlTree() function.
    struct SymbolText : Symbol
    {
        SymbolText(
            const std::wstring& text,
            MathmlFont font,
            Style style,
            RGBColour colour
        ) :
            Symbol(
                text, font, style, cFlavourOrd, cLimitsDisplayLimits, colour
            )
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // SymbolOperator represents things translated as <mo>.
    struct SymbolOperator : Symbol
    {
        // Whether or not this operator is stretchy.
        //
        // Note: because of the existence of the MathML operator dictionary,
        // BuildMathmlTree() needs to do a bit of work to decide whether
        // to actually use a "stretchy" attribute to implement this flag.
        bool mIsStretchy;

        // mSize, if non-empty, indicates the "minsize" and "maxsize"
        // attributes. It is only valid if mIsStretchy is true.
        std::wstring mSize;

        // Whether to use the accent="true" attribute.
        //
        // Again, BuildMathmlTree needs to do some work to decide if the
        // "accent" attribute is actually needed.
        bool mIsAccent;

        SymbolOperator(
            bool isStretchy,
            const std::wstring& size,
            bool isAccent,
            const std::wstring& text,
            MathmlFont font,
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour
        ) :
            Symbol(text, font, style, flavour, limits, colour),
            mIsStretchy(isStretchy),
            mSize(size),
            mIsAccent(isAccent)
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents a space. This may or not actually end up as MathML markup,
    // depending on a variety of things.
    struct Space : Node
    {
        // mWidth is the width of the space, measured in mu.
        // (18mu = 1em in normal font size.)
        // It may be negative.
        int mWidth;

        // This flag indicates whether the space was requested by the user
        // via a TeX spacing command like "\quad". False means that blahtex
        // computed the space (according to TeX's rules).
        bool mIsUserRequested;

        Space(
            int width,
            bool isUserRequested
        ) :
            Node(cStyleDisplay, cFlavourOrd, cLimitsDisplayLimits, 0),
            mWidth(width),
            mIsUserRequested(isUserRequested)
        { }

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents a base with a subscript and/or a superscript,
    // OR a base with an underscript and/or an overscript.
    struct Scripts : Node
    {
        // Any of the following three fields may be NULL (i.e. empty).
        std::auto_ptr<Node> mBase, mUpper, mLower;

        // True means sub/superscript; false means under/overscript.
        //
        // (This flag is computed from e.g. the "limits" setting of mBase,
        // and from the current TeX style.)
        bool mIsSideset;

        Scripts(
            Style style,
            Flavour flavour,
            Limits limits,
            RGBColour colour,
            bool isSideset,
            std::auto_ptr<Node> base,
            std::auto_ptr<Node> upper,
            std::auto_ptr<Node> lower
        ) :
            Node(style, flavour, limits, colour),
            mIsSideset(isSideset),
            mBase(base),
            mUpper(upper),
            mLower(lower)
        { }

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents something that will get translated as <mfrac>.
    struct Fraction : Node
    {
        std::auto_ptr<Node> mNumerator, mDenominator;

        // Does the fraction need a visible line?
        // True for ordinary vanilla fractions; false for things like
        // binomial coefficients.
        bool mIsLineVisible;

        Fraction(
            Style style,
            RGBColour colour,
            std::auto_ptr<Node> numerator,
            std::auto_ptr<Node> denominator,
            bool isLineVisible
        ) :
            Node(style, cFlavourOrd, cLimitsDisplayLimits, colour),
            mNumerator(numerator),
            mDenominator(denominator),
            mIsLineVisible(isLineVisible)
        { }

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents an expression between a pair of delimiters.
    //
    // (Blahtex doesn't translate this using <mfenced>, because then we
    // couldn't use more exotic (non-ASCII) fences in the "open" and
    // "close" attributes.)
    struct Fenced : Node
    {
        // The opening and closing delimiters, i.e. the text that goes
        // inside <mo>...</mo>.
        std::wstring mLeftDelimiter, mRightDelimiter;

        // The expression being surrounded by fences.
        std::auto_ptr<Node> mChild;

        Fenced(
            Style style,
            RGBColour colour,
            const std::wstring& leftDelimiter,
            const std::wstring& rightDelimiter,
            std::auto_ptr<Node> child
        ) :
            Node(style, cFlavourInner, cLimitsDisplayLimits, colour),
            mLeftDelimiter(leftDelimiter),
            mRightDelimiter(rightDelimiter),
            mChild(child)
        { }

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents an expression under a square root sign; i.e. something
    // translated as <msqrt>.
    struct Sqrt : Node
    {
        // The expression under the radical.
        std::auto_ptr<Node> mChild;

        Sqrt(
            std::auto_ptr<Node> child,
            RGBColour colour
        ) :
            Node(child->mStyle, cFlavourOrd, cLimitsDisplayLimits, colour),
            mChild(child)
        { }

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents an expression under a general radical sign; i.e. something
    // translated as <mroot>.
    struct Root : Node
    {
        // The expressions under and outside the radical.
        std::auto_ptr<Node> mInside, mOutside;

        Root(
            std::auto_ptr<Node> inside,
            std::auto_ptr<Node> outside,
            RGBColour colour
        ) :
            Node(inside->mStyle, cFlavourOrd, cLimitsDisplayLimits, colour),
            mInside(inside),
            mOutside(outside)
        { }

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };


    // Represents something translated as <mtable>.
    struct Table : Node
    {
        // Array of rows of table entries.
        std::vector<std::vector<Node*> > mRows;

        // These values describe the possible alignment values for the
        // table. Most environments (e.g. "matrix", "pmatrix") use
        // cAlignCentre. The environments "cases" uses cAlignLeft (all table
        // entries aligned to the left). cAlignRightLeft alternates columns
        // aligned right and left; it's used for the "aligned" environment.
        enum Align
        {
            cAlignLeft,
            cAlignCentre,
            cAlignRightLeft
        }
        mAlign;
        
        // How much space to put between rows of the table. Currently
        // "tight" is used for "\substack" blocks, everything else
        // gets "normal".
        enum RowSpacing
        {
            cRowSpacingNormal,
            cRowSpacingTight
        }
        mRowSpacing;

        Table(
            Style style,
            RGBColour colour,
            RowSpacing rowSpacing = cRowSpacingNormal
        ) :
            Node(style, cFlavourOrd, cLimitsDisplayLimits, colour),
            mAlign(cAlignCentre),
            mRowSpacing(rowSpacing)
        { }

        ~Table();

        virtual void Optimise();

        virtual std::auto_ptr<MathmlNode> BuildMathmlTree(
            const MathmlOptions& options,
            const MathmlEnvironment& inheritedEnvironment,
            unsigned& nodeCount
        ) const;

        virtual void Print(
            std::wostream& os,
            int depth = 0
        ) const;
    };

} // end LayoutTree namespace


// This struct records some information about the rendering environment for
// a portion of the MathML tree. It is used when building the MathML tree
// to decide when it is necessary to insert additional <mstyle> tags.
struct MathmlEnvironment
{
    // The "displaystyle" and "scriptlevel" attributes.
    bool mDisplayStyle;
    int mScriptLevel;
    
    // The "mathcolor" attribute.
    RGBColour mColour;

    MathmlEnvironment(
        bool displayStyle = false,
        int scriptLevel = 0,
        RGBColour colour = 0
    ) :
        mDisplayStyle(displayStyle),
        mScriptLevel(scriptLevel),
        mColour(colour)
    { }

    // This constructor determines the displayStyle and scriptLevel settings
    // corresponding to the given TeX style.
    MathmlEnvironment(
        LayoutTree::Node::Style style,
        RGBColour colour
    );
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
