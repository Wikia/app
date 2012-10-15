// File "LayoutTree.cpp"
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
#include <list>
#include <set>
#include <map>
#include "MathmlNode.h"
#include "LayoutTree.h"

using namespace std;

namespace blahtex
{

MathmlEnvironment::MathmlEnvironment(
    LayoutTree::Node::Style style,
    RGBColour colour
)
{
    mColour = colour;
    mDisplayStyle = (style == LayoutTree::Node::cStyleDisplay);

    switch (style)
    {
        case LayoutTree::Node::cStyleDisplay:
        case LayoutTree::Node::cStyleText:
            mScriptLevel = 0;
            break;

        case LayoutTree::Node::cStyleScript:
            mScriptLevel = 1;
            break;

        case LayoutTree::Node::cStyleScriptScript:
            mScriptLevel = 2;
            break;

        default:
            throw logic_error(
                "Unexpected style value in "
                "MathmlEnvironment::MathmlEnvironment"
            );
    }
}


bool operator== (const MathmlEnvironment& x, const MathmlEnvironment& y)
{
    return 
        (x.mDisplayStyle == y.mDisplayStyle) &&
        (x.mScriptLevel == y.mScriptLevel) &&
        (x.mColour == y.mColour);
}


namespace LayoutTree
{

Row::~Row()
{
    for (list<Node*>::iterator
        p = mChildren.begin();
        p != mChildren.end();
        p++
    )
        delete *p;
}

Table::~Table()
{
    for (vector<vector<Node*> >::iterator
        p = mRows.begin();
        p != mRows.end();
        p++
    )
        for (vector<Node*>::iterator q = p->begin(); q != p->end(); q++)
            delete *q;
}


void IncrementNodeCount(unsigned& nodeCount)
{
    if (++nodeCount >= cMaxMathmlNodeCount)
        throw Exception(L"TooManyMathmlNodes");
}


// This function obtains the core of a MathML expression. (See
// "embellished operators" in the MathML spec.) This is used to find any
// <mo> node which should have its "lspace" and/or "rspace" attributes set.
MathmlNode* GetCore(MathmlNode* node)
{
    // FIX: this code is not quite right. It doesn't handle situations where
    // <mrow> or <mstyle> or something similar contain a single node which
    // is an embellished operator. I don't think this really matters
    // because I don't think these situations can actually arise, but
    // maybe should be fixed just in case.

    if (!node)
        return NULL;
    
    switch (node->mType)
    {
        case MathmlNode::cTypeMsub:
        case MathmlNode::cTypeMsup:
        case MathmlNode::cTypeMsubsup:
        case MathmlNode::cTypeMunder:
        case MathmlNode::cTypeMover:
        case MathmlNode::cTypeMunderover:
            return GetCore(node->mChildren.front());
        
        default:
            return node;
    }
}


// Converts an RGBColour to "#rrggbb" format.
wstring FormatColour(RGBColour colour)
{
    wostringstream os;
    os << L"#" << hex << setfill(L'0') << setw(6) << colour;
    return os.str();
}


// This function compares sourceEnvironment to targetEnvironment. It then
// modifies "node" by inserting appropriate attributes or possibly an
// <mstyle> node, so that the node receives the desired "target
// environment", assuming that it inherited the indicated "source
// environment".

// FIX: sometimes firefox doesn't get the scriptlevel correct for
// tables. (see mozilla bug 328141). So for the moment, we force an
// extra <mstyle> node around every table to handle the scriptlevel.
#define MOZILLA_BUG_328141_WORKAROUND 1

auto_ptr<MathmlNode> AdjustMathmlEnvironment(
    auto_ptr<MathmlNode> node,
    MathmlEnvironment sourceEnvironment,
    MathmlEnvironment targetEnvironment
)
{
    if (
        sourceEnvironment.mDisplayStyle == targetEnvironment.mDisplayStyle
        && sourceEnvironment.mScriptLevel == targetEnvironment.mScriptLevel
        && sourceEnvironment.mColour == targetEnvironment.mColour
#if MOZILLA_BUG_328141_WORKAROUND
        && node->mType != MathmlNode::cTypeMtable
#endif
    )
        return node;

    auto_ptr<MathmlNode> newNode(new MathmlNode(MathmlNode::cTypeMstyle));

    if (sourceEnvironment.mDisplayStyle != targetEnvironment.mDisplayStyle)
    {
        if (node->mType == MathmlNode::cTypeMtable)
        {
            // Special case if the node in question is <mtable>, because
            // the MathML spec says that the displaystyle attribute needs
            // to be set on the <mtable> element itself, since the default
            // "false" overrides any enclosing <mstyle>.
            node->mAttributes[MathmlNode::cAttributeDisplaystyle] =
                (targetEnvironment.mDisplayStyle) ? L"true" : L"false";
        }
        else
        {
            newNode->mAttributes[MathmlNode::cAttributeDisplaystyle] =
                (targetEnvironment.mDisplayStyle) ? L"true" : L"false";
        }
    }

    if (
        sourceEnvironment.mScriptLevel != targetEnvironment.mScriptLevel
#if MOZILLA_BUG_328141_WORKAROUND
        || node->mType == MathmlNode::cTypeMtable
#endif
    )
    {
        wostringstream os;
        os << targetEnvironment.mScriptLevel;
        newNode->mAttributes
            [MathmlNode::cAttributeScriptlevel] = os.str();
    }

    if (sourceEnvironment.mColour != targetEnvironment.mColour)
    {
        // If the child is a token element, we can just add mathcolor
        // directly
        switch (node->mType)
        {
            case MathmlNode::cTypeMi:
            case MathmlNode::cTypeMo:
            case MathmlNode::cTypeMn:
            case MathmlNode::cTypeMtext:
                node->mAttributes[MathmlNode::cAttributeMathcolor] =
                    FormatColour(targetEnvironment.mColour);
                break;
                
            default:
                newNode->mAttributes[MathmlNode::cAttributeMathcolor] =
                    FormatColour(targetEnvironment.mColour);
                break;
        }
    }

    if (newNode->mAttributes.empty())
        // In some cases we don't actually need an <mstyle> node, and just
        // return the original node. (This can happen if either (1) the
        // child is an <mtable> where only the displaystyle got modified,
        // or (2) it was a token element and only the colour got modified.)
        return node;

    if (node->mType == MathmlNode::cTypeMrow)
        // If the child is an mrow, we can splice it out
        newNode->mChildren.swap(node->mChildren);
    else
        newNode->mChildren.push_back(node.release());
    
    return newNode;
}


auto_ptr<MathmlNode> Row::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    // The strategy is:
    // First write each output node to "outputNode", but simultaneously
    // keep a list of MathmlEnvironments corresponding to the desired
    // environment for each node. Then, do a second pass inserting <mstyle>
    // nodes to implement those desired environments.
    
    auto_ptr<MathmlNode> outputNode(new MathmlNode(MathmlNode::cTypeMrow));
    list<MathmlNode*>& outputList = outputNode->mChildren;
        
    IncrementNodeCount(nodeCount);
    
    if (mChildren.empty())
        return outputNode;

    vector<MathmlEnvironment> environments;

    for (list<Node*>::const_iterator
        source = mChildren.begin();
        true;
        ++source
    )
    {
        MathmlNode* previousTarget =
            outputList.empty() ? NULL : outputList.back();
    
        int spaceWidth = 0;
        bool isUserRequested = false;

        Space* sourceAsSpace =
            (source == mChildren.end())
                ? NULL : dynamic_cast<Space*>(*source);
        if (sourceAsSpace)
        {
            spaceWidth = sourceAsSpace->mWidth;
            isUserRequested = sourceAsSpace->mIsUserRequested;
            source++;
        }
        
        MathmlNode* currentTarget = NULL;
        if (source != mChildren.end())
        {
            environments.push_back(
                MathmlEnvironment((*source)->mStyle, (*source)->mColour)
            );

            outputList.push_back(
                (*source)->BuildMathmlTree(
                    options,
                    environments.back(),
                    nodeCount
                ).release()
            );
            
            currentTarget = outputList.back();
        }
        
        // Now decide about whether to insert markup for the
        // space between currentNode and previousNode.

        MathmlNode*  currentNucleus = GetCore(currentTarget);
        MathmlNode* previousNucleus = GetCore(previousTarget);

        bool isPreviousMo =
            previousNucleus &&
            (previousNucleus->mType == MathmlNode::cTypeMo);

        bool isCurrentMo =
            currentNucleus &&
            (currentNucleus->mType == MathmlNode::cTypeMo);

        bool doSpace = false;

        if (
            options.mSpacingControl
                == MathmlOptions::cSpacingControlStrict
            || isUserRequested
        )
            doSpace = true;

        else if (options.mSpacingControl ==
            MathmlOptions::cSpacingControlModerate
        )
        {
            // The user has asked for "moderate" spacing mode, so we
            // need to give the MathML renderer a helping hand with
            // spacing decisions, without being *too* pushy.

            // This section of code is likely to change a LOT.
            
            // Note: I scratched most of this as of blahtex 0.4.4....
            // it was getting really ugly and I need to think of another
            // way to do it

            if (!isPreviousMo && !isCurrentMo)
                doSpace = (spaceWidth != 0);
        }

        if (doSpace)
        {
            // We have established that we want to mark up some space,
            // now need to decide how to do it.

            // We use <mspace>, unless we have an <mo> node on either
            // side (or both sides), in which case we use "lspace"
            // and/or "rspace" attributes.

            wstring widthAsString;
            if (spaceWidth == 0)
                widthAsString = L"0";
            else
            {
                wostringstream wos;
                wos << fixed << setprecision(3)
                    << (spaceWidth / 18.0) << L"em";
                widthAsString = wos.str();
            }

            if (isPreviousMo)
            {
                previousNucleus->mAttributes
                    [MathmlNode::cAttributeRspace] = widthAsString;
                if (isCurrentMo)
                    currentNucleus->mAttributes
                        [MathmlNode::cAttributeLspace] = L"0";
            }
            else if (isCurrentMo)
                currentNucleus->mAttributes
                    [MathmlNode::cAttributeLspace] = widthAsString;
            else
            {
                // FIX: this <mi>-specific stuff is a nasty hack because
                // Firefox likes to mess around with the space between
                // adjacent <mi> nodes in some situations.
                // See https://bugzilla.mozilla.org/show_bug.cgi?id=320294

                bool isPreviousMi =
                    previousNucleus &&
                    (previousNucleus->mType == MathmlNode::cTypeMi);

                bool isCurrentMi =
                    currentNucleus &&
                    (currentNucleus->mType == MathmlNode::cTypeMi);

                if (spaceWidth != 0 || (isPreviousMi && isCurrentMi))
                {
                    auto_ptr<MathmlNode> spaceNode(
                        new MathmlNode(MathmlNode::cTypeMspace)
                    );
                    IncrementNodeCount(nodeCount);
                    spaceNode->mAttributes
                        [MathmlNode::cAttributeWidth] = widthAsString;

                    if (currentTarget)
                    {
                        outputList.insert(
                            --outputList.end(),
                            spaceNode.release()
                        );
                        environments.push_back(environments.back());
                    }
                    else
                    {
                        outputList.push_back(spaceNode.release());
                        environments.push_back(
                            MathmlEnvironment(mStyle, mColour)
                        );
                    }
                }
            }
        }

        if (source == mChildren.end())
            break;
    }

    // Now do second pass where styles get adjusted
    list<MathmlNode*>::iterator outputPtr = outputList.end();
    for (vector<MathmlEnvironment>::reverse_iterator
        environment = environments.rbegin();
        environment != environments.rend();
        environment++
    )
    {
        if (outputPtr != outputList.begin())
            outputPtr--;
        
        if (environment == environments.rbegin())
            continue;
        
        if (!(environment[-1] == environment[0]))
        {
            list<MathmlNode*>::iterator previousOutputPtr = outputPtr;
            previousOutputPtr++;
            
            auto_ptr<MathmlNode> enclosedNode;
            
            if (--outputList.end() == previousOutputPtr)
            {
                // If outputPtr is already the last node, we don't need
                // to create a new <mrow>
                enclosedNode.reset(*previousOutputPtr);
                outputList.pop_back();
            }
            else
            {
                enclosedNode.reset(new MathmlNode(MathmlNode::cTypeMrow));
                enclosedNode->mChildren.splice(
                    enclosedNode->mChildren.begin(),
                    outputList,
                    previousOutputPtr,
                    outputList.end()
                );
            }
            
            outputList.push_back(
                AdjustMathmlEnvironment(
                    enclosedNode,
                    environment[0],
                    environment[-1]
                ).release()
            );
        }
    }
    
    // If the result is an <mrow> with a single child, just return the
    // child by itself.
    // (We don't use list::size() here because that's O(n) :-))
    if (!outputNode->mChildren.empty() &&
        outputNode->mChildren.front() == outputNode->mChildren.back()
    )
    {
        MathmlNode* child = outputNode->mChildren.back();
        outputNode->mChildren.pop_back();       // relinquish ownership
        outputNode.reset(child);
    }

    return AdjustMathmlEnvironment(
        outputNode,
        inheritedEnvironment,
        environments.empty() ? inheritedEnvironment : environments[0]
    );
}


// This function converts a "MathML styled text" plane-1 character from the
// code point that it SHOULD be at to the code point that it REALLY is at.
//
// For example, the double-struck "C" (&Copf;) should be at U+1D53A, but for
// historical reasons it ended up at U+2102.
wchar_t FixOutOfSequenceMathmlCharacter(wchar_t c)
{
    switch (c)
    {
        case L'\U0001D49D':   return L'\U0000212C';    // script B
        case L'\U0001D4A0':   return L'\U00002130';    // script E
        case L'\U0001D4A1':   return L'\U00002131';    // script F
        case L'\U0001D4A3':   return L'\U0000210B';    // script H
        case L'\U0001D4A4':   return L'\U00002110';    // script I
        case L'\U0001D4A7':   return L'\U00002112';    // script L
        case L'\U0001D4A8':   return L'\U00002133';    // script M
        case L'\U0001D4AD':   return L'\U0000211B';    // script R
        case L'\U0001D53A':   return L'\U00002102';    // double struck C
        case L'\U0001D53F':   return L'\U0000210D';    // double struck H
        case L'\U0001D545':   return L'\U00002115';    // double struck N
        case L'\U0001D547':   return L'\U00002119';    // double struck P
        case L'\U0001D548':   return L'\U0000211A';    // double struck Q
        case L'\U0001D549':   return L'\U0000211D';    // double struck R
        case L'\U0001D551':   return L'\U00002124';    // double struck Z
        case L'\U0001D506':   return L'\U0000212D';    // fraktur C
        case L'\U0001D50B':   return L'\U0000210C';    // fraktur H
        case L'\U0001D50C':   return L'\U00002111';    // fraktur I
        case L'\U0001D515':   return L'\U0000211C';    // fraktur R
        case L'\U0001D51D':   return L'\U00002128';    // fraktur Z
    }

    return c;
}


auto_ptr<MathmlNode> SymbolIdentifier::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMi, mText));
    IncrementNodeCount(nodeCount);

    // Here we have a special case to deal with the "fancy" fonts
    // (fraktur, script, bold-fraktur, bold-script, double-struck)
    // when MathML version 1.x fonts are requested, since then we need
    // to explicitly substitute MathML entities.
    if (
        options.mUseVersion1FontAttributes &&
        (
            mFont == cMathmlFontFraktur ||
            mFont == cMathmlFontBoldFraktur ||
            mFont == cMathmlFontDoubleStruck ||
            mFont == cMathmlFontScript ||
            mFont == cMathmlFontBoldScript
        )
    )
    {
        if (mText.size() != 1)
            throw logic_error(
                "Unexpected string length in "
                "SymbolIdentifier::BuildMathmlTree()"
            );
        
        wchar_t replacement = 0;

        // These hold the explicit characters for "A" and "a" in the
        // desired font (or zero if unavailable)
        wchar_t baseUppercase = 0, baseLowercase = 0;

        switch (mFont)
        {
            case cMathmlFontBoldScript:
                if (options.mAllowPlane1)
                {
                    baseUppercase = L'\U0001D4D0';
                    break;
                }
                else
                {
                    // If we don't have plane 1 characters available, then
                    // we'll just have to do e.g.
                    // <mi fontweight="bold">&Acal;</mi>
                    // since there aren't specific MathML names for bold
                    // script capitals.
                    node->mAttributes
                        [MathmlNode::cAttributeFontweight] = L"bold";
                    baseUppercase = L'\U0001D49C';
                    break;
                }

            case cMathmlFontScript:
                baseUppercase = L'\U0001D49C';
                break;

            case cMathmlFontBoldFraktur:
                if (options.mAllowPlane1)
                {
                    baseUppercase = L'\U0001D56C';
                    baseLowercase = L'\U0001D586';
                    break;
                }
                else
                {
                    // See comments above under cMathmlFontBoldScript
                    node->mAttributes
                        [MathmlNode::cAttributeFontweight] = L"bold";
                    baseUppercase = L'\U0001D504';
                    baseLowercase = L'\U0001D51E';
                    break;
                }

            case cMathmlFontFraktur:
                baseUppercase = L'\U0001D504';
                baseLowercase = L'\U0001D51E';
                break;

            case cMathmlFontDoubleStruck:
                baseUppercase = L'\U0001D538';
                break;
        }

        if (baseUppercase && mText[0] >= 'A' && mText[0] <= 'Z')
            replacement = baseUppercase + (mText[0] - 'A');
        if (baseLowercase && mText[0] >= 'a' && mText[0] <= 'z')
            replacement = baseLowercase + (mText[0] - 'a');

        if (!replacement)
            throw logic_error(
                "Unexpected character/font combination in "
                "SymbolIdentifier::BuildMathmlTree()"
            );

        node->mText =
            wstring(1, FixOutOfSequenceMathmlCharacter(replacement));

        return AdjustMathmlEnvironment(
            node,
            inheritedEnvironment,
            MathmlEnvironment(mStyle, mColour)
        );
    }

    node->AddFontAttributes(mFont, options);
    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


auto_ptr<MathmlNode> SymbolOperator::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    // These are all the operators that stretch by default in the normative
    // operator dictionary. If we *don't* want them to stretch, we need
    // to explicitly say so.
    static wchar_t stretchyByDefaultArray[] =
    {
        L'(',
        L')',
        L'[',
        L']',
        L'{',
        L'}',
        L'|',
        L'/',
        L'\U000002DC',      // DiacriticalTilde
        L'\U000002C7',      // Hacek
        L'\U000002D8',      // Breve
        L'\U00002216',      // Backslash
        L'\U00002329',      // LeftAngleBracket
        L'\U0000232A',      // RightAngleBracket
        L'\U00002308',      // LeftCeiling
        L'\U00002309',      // RightCeiling
        L'\U0000230A',      // LeftFloor
        L'\U0000230B',      // RightFloor
        L'\U00002211',      // Sum
        L'\U0000220F',      // Product
        L'\U0000222B',      // Integral
        L'\U0000222C',      // Int
        L'\U0000222D',      // iiint
        L'\U00002A0C',      // iiiint
        L'\U0000222E',      // ContourIntegral
        L'\U000022C2',      // Intersection
        L'\U00002A00',      // bigodot
        L'\U00002A02',      // bigotimes
        L'\U00002210',      // Coproduct
        L'\U00002A06',      // bigsqcup
        L'\U00002A01',      // bigoplus
        L'\U000022C1',      // Vee
        L'\U00002A04',      // biguplus
        L'\U000022C0'       // Wedge
    };
    static wishful_hash_set<wchar_t> stretchyByDefaultTable(
        stretchyByDefaultArray,
        END_ARRAY(stretchyByDefaultArray)
    );

    // Special case for "\not":
    if (mText == L"NOT")
    {
        auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMpadded));
        auto_ptr<MathmlNode> space(new MathmlNode(MathmlNode::cTypeMspace));
        space->mAttributes[MathmlNode::cAttributeWidth] = L"0.1em";
        node->mChildren.push_back(space.release());
        node->mChildren.push_back(
            new MathmlNode(MathmlNode::cTypeMo, L"/")
        );
        node->mAttributes[MathmlNode::cAttributeWidth] = L"0";
        return node;
    }

    // And these are the characters that are accents by default;
    // again we may need to modify this explicitly.
    static wchar_t accentByDefaultArray[] =
    {
        L'\U0000FE37',
        L'\U0000FE38'
    };
    static wishful_hash_set<wchar_t> accentByDefaultTable(
        accentByDefaultArray,
        END_ARRAY(accentByDefaultArray)
    );

    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMo, mText));

    if (mIsStretchy)
    {
        node->mAttributes[MathmlNode::cAttributeStretchy] = L"true";
        if (!mSize.empty())
            node->mAttributes[MathmlNode::cAttributeMinsize] =
            node->mAttributes[MathmlNode::cAttributeMaxsize] = mSize;
    }
    else if (mText.size() == 1 && stretchyByDefaultTable.count(mText[0]))
        node->mAttributes[MathmlNode::cAttributeStretchy] = L"false";

    if (mIsAccent)
    {
        node->mAttributes[MathmlNode::cAttributeAccent] = L"true";
        return node;
    }
    else if (mText.size() == 1 && accentByDefaultTable.count(mText[0]))
        node->mAttributes[MathmlNode::cAttributeAccent] = L"false";

    node->AddFontAttributes(mFont, options);

    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


auto_ptr<MathmlNode> SymbolNumber::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    // FIX: what about merging commas, decimal points into <mn> nodes?
    // Might need to special-case it.

    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMn, mText));
    IncrementNodeCount(nodeCount);
    node->AddFontAttributes(mFont, options);
    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


auto_ptr<MathmlNode> SymbolText::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    auto_ptr<MathmlNode> node(
        new MathmlNode(MathmlNode::cTypeMtext, mText)
    );
    IncrementNodeCount(nodeCount);
    node->AddFontAttributes(mFont, options);
    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


auto_ptr<MathmlNode> Sqrt::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    MathmlEnvironment desiredEnvironment(mStyle, mColour);

    auto_ptr<MathmlNode> child =
        mChild->BuildMathmlTree(
            options, desiredEnvironment, nodeCount
        );
    
    auto_ptr<MathmlNode> node;
    
    if (child->mType == MathmlNode::cTypeMrow)
    {
        // This removes redundant <mrow>s, i.e. things like
        // <msqrt><mrow>...</mrow></msqrt>
        node = child;
        node->mType = MathmlNode::cTypeMsqrt;
    }
    else
    {
        node.reset(new MathmlNode(MathmlNode::cTypeMsqrt));
        IncrementNodeCount(nodeCount);
        node->mChildren.push_back(child.release());
    }

    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, desiredEnvironment
    );
}


auto_ptr<MathmlNode> Root::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMroot));
    IncrementNodeCount(nodeCount);

    MathmlEnvironment desiredEnvironment(mStyle, mColour);

    node->mChildren.push_back(
        mInside->BuildMathmlTree(
            options,
            desiredEnvironment,
            nodeCount
        ).release()
    );

    node->mChildren.push_back(
        mOutside->BuildMathmlTree(
            options,
            MathmlEnvironment(false, 2, mColour),
            nodeCount
        ).release()
    );
    
    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, desiredEnvironment
    );
}


auto_ptr<MathmlNode> Scripts::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    // Simulate the change in rendering environment for the super/
    // sub/over/underscripts.
    MathmlEnvironment baseEnvironment(mStyle, mColour);
    MathmlEnvironment scriptEnvironment = baseEnvironment;
    scriptEnvironment.mDisplayStyle = false;
    scriptEnvironment.mScriptLevel++;

    auto_ptr<MathmlNode> base;
    if (mBase.get())
        base = mBase->BuildMathmlTree(options, baseEnvironment, nodeCount);
    else
    {
        // An empty base gets represented by "<mrow/>"
        base.reset(new MathmlNode(MathmlNode::cTypeMrow));
        IncrementNodeCount(nodeCount);
    }

    MathmlNode::Type type;

    if (mUpper.get())
    {
        if (mLower.get())
            type = mIsSideset
                ? MathmlNode::cTypeMsubsup
                : MathmlNode::cTypeMunderover;
        else
            type = mIsSideset
                ? MathmlNode::cTypeMsup
                : MathmlNode::cTypeMover;
    }
    else
        type = mIsSideset
            ? MathmlNode::cTypeMsub
            : MathmlNode::cTypeMunder;

    auto_ptr<MathmlNode> scriptsNode(new MathmlNode(type));
    IncrementNodeCount(nodeCount);
    scriptsNode->mChildren.push_back(base.release());

    if (mUpper.get())
    {
        if (mLower.get())
        {
            scriptsNode->mChildren.push_back(
                mLower->BuildMathmlTree(
                    options, scriptEnvironment, nodeCount
                ).release()
            );
            scriptsNode->mChildren.push_back(
                mUpper->BuildMathmlTree(
                    options, scriptEnvironment, nodeCount
                ).release()
            );
        }
        else
        {
            scriptsNode->mChildren.push_back(
                mUpper->BuildMathmlTree(
                    options, scriptEnvironment, nodeCount
                ).release()
            );
        }
    }
    else
    {
        scriptsNode->mChildren.push_back(
            mLower->BuildMathmlTree(
                options, scriptEnvironment, nodeCount
            ).release()
        );
    }

    if (!mIsSideset && mStyle != cStyleDisplay)
    {
        // This situation should be quite unusual, since the user would
        // have to force things using "\limits". If there's an operator in
        // the core, we need to set movablelimits just to be safe.

        // FIX: this code might let the user induce quadratic time, with
        // something like this:
        // "\textstyle \mathop{\mathop{\mathop{\mathop ... {x} ...
        // \limits^x}\limits^x}\limits^x}\limits^x" etc

        // FIX: we could add a table to check whether the operator inside
        // is likely to need movablelimits adjusted because of the
        // operator dictionary.

        MathmlNode* core = GetCore(scriptsNode->mChildren.front());
        if (core->mType == MathmlNode::cTypeMo)
            core->mAttributes
                [MathmlNode::cAttributeMovablelimits] = L"false";
    }

    return AdjustMathmlEnvironment(
        scriptsNode, inheritedEnvironment, baseEnvironment
    );
}


auto_ptr<MathmlNode> Fraction::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    // Determine the rendering style for the numerator and denominator.
    MathmlEnvironment baseEnvironment(mStyle, mColour);
    MathmlEnvironment smallerEnvironment = baseEnvironment;
    if (smallerEnvironment.mDisplayStyle)
        smallerEnvironment.mDisplayStyle = false;
    else
        smallerEnvironment.mScriptLevel++;

    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMfrac));
    IncrementNodeCount(nodeCount);

    node->mChildren.push_back(
        mNumerator->BuildMathmlTree(
            options, smallerEnvironment, nodeCount
        ).release()
    );
    node->mChildren.push_back(
        mDenominator->BuildMathmlTree(
            options, smallerEnvironment, nodeCount
        ).release()
    );

    if (!mIsLineVisible)
        node->mAttributes
            [MathmlNode::cAttributeLinethickness] = L"0";

    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, baseEnvironment
    );
}


auto_ptr<MathmlNode> Space::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    if (!mIsUserRequested)
        throw logic_error(
            "Unexpected lonely automatic space in Space::BuildMathmlTree"
        );

    // FIX: what happens with negative space?

    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMspace));
    IncrementNodeCount(nodeCount);

    wostringstream wos;
    wos << fixed << setprecision(3) << (mWidth / 18.0) << L"em";
    node->mAttributes[MathmlNode::cAttributeWidth] = wos.str();

    return node;
}


auto_ptr<MathmlNode> Fenced::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    auto_ptr<MathmlNode> inside = mChild->BuildMathmlTree(
        options, MathmlEnvironment(mStyle, mColour), nodeCount
    );

    if (mLeftDelimiter.empty() && mRightDelimiter.empty())
        return inside;

    if (inside->mType != MathmlNode::cTypeMrow)
    {
        // Ensure that the stuff between the fences is surrounded by
        // an <mrow>. (I don't really understand why this is necessary,
        // but the MathML spec suggests it, and Firefox seems a bit fussy,
        // so let's just do it.)
        auto_ptr<MathmlNode> temp(new MathmlNode(MathmlNode::cTypeMrow));
        IncrementNodeCount(nodeCount);
        temp->mChildren.push_back(inside.release());
        inside = temp;
    }

    // And surround the whole thing by an <mrow> as well.
    // (This one makes more sense... we want the delimiters to stretch
    // around the correct stuff.)
    auto_ptr<MathmlNode> output(new MathmlNode(MathmlNode::cTypeMrow));
    IncrementNodeCount(nodeCount);

    if (!mLeftDelimiter.empty())
    {
        auto_ptr<MathmlNode> node(
            new MathmlNode(MathmlNode::cTypeMo, mLeftDelimiter)
        );
        IncrementNodeCount(nodeCount);
        node->mAttributes[MathmlNode::cAttributeStretchy] = L"true";
        output->mChildren.push_back(node.release());
    }

    output->mChildren.push_back(inside.release());

    if (!mRightDelimiter.empty())
    {
        auto_ptr<MathmlNode> node(
            new MathmlNode(MathmlNode::cTypeMo, mRightDelimiter)
        );
        IncrementNodeCount(nodeCount);
        node->mAttributes[MathmlNode::cAttributeStretchy] = L"true";
        output->mChildren.push_back(node.release());
    }

    return AdjustMathmlEnvironment(
        output, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


auto_ptr<MathmlNode> Table::BuildMathmlTree(
    const MathmlOptions& options,
    const MathmlEnvironment& inheritedEnvironment,
    unsigned& nodeCount
) const
{
    auto_ptr<MathmlNode> node(new MathmlNode(MathmlNode::cTypeMtable));
    IncrementNodeCount(nodeCount);

    // Compute the table width. We do this so we can "fill out" each
    // row with the correct number of entries. Although the MathML spec
    // doesn't require this, it seems that Firefox doesn't always align
    // the entries properly unless we fill in the missing entries.
    int tableWidth = 0;
    for (vector<vector<Node*> >::const_iterator
        row = mRows.begin();
        row != mRows.end();
        row++
    )
    {
        if (tableWidth < row->size())
            tableWidth = row->size();
    }

    if (mAlign == cAlignLeft)
        node->mAttributes[MathmlNode::cAttributeColumnalign] = L"left";
    else if (mAlign == cAlignRightLeft)
    {
        wstring alignString = L"right";
        for (int i = 1; i < tableWidth; i++)
            alignString += (i % 2) ? L" left" : L" right";
        node->mAttributes[MathmlNode::cAttributeColumnalign] = alignString;
        
        wstring spacingString = L"0.2em";
        for (int i = 2; i < tableWidth; i++)
            spacingString += (i % 2) ? L" 0.2em" : L" 1em";
        node->mAttributes[MathmlNode::cAttributeColumnspacing] =
            spacingString;
    }
    
    // FIX: need to test this for Firefox whenever they get that bug fixed
    // (mozilla bug 330964)
    if (mRowSpacing == cRowSpacingTight)
        node->mAttributes[MathmlNode::cAttributeRowspacing] = L"0.3ex";

    for (vector<vector<Node*> >::const_iterator
        inRow = mRows.begin();
        inRow != mRows.end();
        inRow++
    )
    {
        auto_ptr<MathmlNode> outRow(new MathmlNode(MathmlNode::cTypeMtr));
        IncrementNodeCount(nodeCount);
        int count = 0;
        for (vector<Node*>::const_iterator
            inEntry = inRow->begin();
            inEntry != inRow->end();
            inEntry++, count++
        )
        {
            auto_ptr<MathmlNode> outEntry(
                new MathmlNode(MathmlNode::cTypeMtd)
            );
            IncrementNodeCount(nodeCount);
        
            auto_ptr<MathmlNode> child =
                (*inEntry)->BuildMathmlTree(
                    options, MathmlEnvironment(mStyle, mColour), nodeCount
                );

            // Firefox has a bug (#236963) where it doesn't correctly put
            // an "inferred mrow" inside a <mtd> block, so for the moment
            // we add the <mrow> ourselves.
#define MOZILLA_BUG_236963_WORKAROUND 1

#if MOZILLA_BUG_236963_WORKAROUND
            if (child->mType == MathmlNode::cTypeMrow)
            {
                child->mType = MathmlNode::cTypeMtd;
                outEntry = child;
            }
            else
                outEntry->mChildren.push_back(child.release());
#else
            if (child->mType != MathmlNode::cTypeMrow)
            {
                auto_ptr<MathmlNode> temp(
                    new MathmlNode(MathmlNode::cTypeMrow)
                );
                IncrementNodeCount(nodeCount);
                temp->mChildren.push_back(child.release());
                child = temp;
            }
            outEntry->mChildren.push_back(child.release());
#endif

            outRow->mChildren.push_back(outEntry.release());
        }

        // fill out the extra table entries:
        for (; count < tableWidth; count++)
        {
            outRow->mChildren.push_back(
                new MathmlNode(MathmlNode::cTypeMtd)
            );
            IncrementNodeCount(nodeCount);
        }

        node->mChildren.push_back(outRow.release());
    }

    return AdjustMathmlEnvironment(
        node, inheritedEnvironment, MathmlEnvironment(mStyle, mColour)
    );
}


// This is a list of all operators that we know how to negate.
pair<wstring, wstring> gNegationArray[] =
{
    // Element => NotElement
    make_pair(L"\U00002208", L"\U00002209"),
    // Congruent => NotCongruent
    make_pair(L"\U00002261", L"\U00002262"),
    // Exists => NotExists
    make_pair(L"\U00002203", L"\U00002204"),
    // = => NotEqual
    make_pair(L"=",          L"\U00002260"),
    // SubsetEqual => NotSubsetEqual
    make_pair(L"\U00002286", L"\U00002288"),
    // Tilde => NotTilde
    make_pair(L"\U0000223C", L"\U00002241"),
    // LeftArrow => nleftarrow
    make_pair(L"\U00002190", L"\U0000219A"),
    // RightArrow => nrightarrow
    make_pair(L"\U00002192", L"\U0000219B"),
    // LeftRightArrow => nleftrightarrow
    make_pair(L"\U00002194", L"\U000021AE"),
    // DoubleLeftArrow => nLeftArrow
    make_pair(L"\U000021D0", L"\U000021CD"),
    // DoubleRightArrow => nRightArrow
    make_pair(L"\U000021D2", L"\U000021CF"),
    // DoubleLeftRightArrow => nLeftrightArrow
    make_pair(L"\U000021D4", L"\U000021CE"),
    // ReverseElement => NotReverseElement
    make_pair(L"\U0000220B", L"\U0000220C"),
    // FIX: what happens to the pipe character?
    // VerticalBar => NotVerticalBar
    make_pair(L"\U00002223", L"\U00002224"),
    // DoubleVerticalBar => NotDoubleVerticalBar
    make_pair(L"\U00002225", L"\U00002226"),
    // TildeEqual => NotTildeEqual
    make_pair(L"\U00002243", L"\U00002244"),
    // TildeFullEqual => NotTildeFullEqual
    make_pair(L"\U00002245", L"\U00002247"),
    // TildeTilde => NotTildeTilde
    make_pair(L"\U00002248", L"\U00002249"),
    // > => NotLess
    make_pair(L"<", L"\U0000226E"),
    // < => NotGreater
    make_pair(L">", L"\U0000226F"),
    // leq => NotLessEqual
    make_pair(L"\U00002264", L"\U00002270"),
    // GreaterEqual => NotGreaterEqual
    make_pair(L"\U00002265", L"\U00002271"),
    // FIX: what about "Precedes", "Succeeds"?
    // subset => nsub
    make_pair(L"\U00002282", L"\U00002284"),
    // Superset => nsup
    make_pair(L"\U00002283", L"\U00002285"),
    // SubsetEqual => NotSubsetEqual
    make_pair(L"\U00002286", L"\U00002288"),
    // SupersetEqual => NotSupersetEqual
    make_pair(L"\U00002287", L"\U00002289"),
    // RightTee => nvdash
    make_pair(L"\U000022A2", L"\U000022AC"),
    // DoubleRightTee => nvDash
    make_pair(L"\U000022A8", L"\U000022AD"),
    // Vdash => nVdash
    make_pair(L"\U000022A9", L"\U000022AE"),
    // SquareSubsetEqual => NotSquareSubsetEqual
    make_pair(L"\U00002291", L"\U000022E2"),
    // SquareSupersetEqual => NotSquareSupersetEqual
    make_pair(L"\U00002292", L"\U000022E3"),
    // LeftTriangle => NotLeftTriangle
    make_pair(L"\U000022B2", L"\U000022EA"),
    // RightTriangle => NotRightTriangle
    make_pair(L"\U000022B3", L"\U000022EB"),
    // LeftTriangleEqual => NotLeftTriangleEqual
    make_pair(L"\U000022B4", L"\U000022EC"),
    // RightTriangleEqual => NotRightTriangleEqual
    make_pair(L"\U000022B5", L"\U000022ED")
};
wishful_hash_map<wstring, wstring> gNegationTable(
    gNegationArray,
    END_ARRAY(gNegationArray)
);


void Row::Optimise()
{
    list<Node*>::iterator lastSpace = mChildren.end();
    list<Node*>::iterator lastNonSpace = mChildren.end();
    
    // Throughout this loop, we ensure that:
    // * lastNonSpace points to the most recently seen non-Space node,
    //   or mChildren.end() if none have yet been seen;
    // * lastSpace points to the most recently seen Space node *following*
    //   lastNonSpace, or just the most recently seen Space node if
    //   lastNonSpace == mChildren.end().
    
    for (list<Node*>::iterator
        current = mChildren.begin(); current != mChildren.end(); ++current
    )
    {
        // Recurse:
        (*current)->Optimise();
        
        Space* currentAsSpace = dynamic_cast<Space*>(*current);
        if (currentAsSpace)
        {
            if (lastSpace == mChildren.end())
                lastSpace = current;
            else
            {
                // Merge the two adjacent Space nodes.
                Space* lastSpaceAsSpace = dynamic_cast<Space*>(*lastSpace);
                if (lastSpaceAsSpace->mIsUserRequested)
                    currentAsSpace->mIsUserRequested = true;
                currentAsSpace->mWidth += lastSpaceAsSpace->mWidth;
                mChildren.erase(lastSpace);
                lastSpace = current;
            }
        }
        else
        {
            if (
                lastNonSpace != mChildren.end() &&
                (
                    lastSpace == mChildren.end() ||
                    (dynamic_cast<Space*>(*lastSpace))->mWidth == 0
                )
            )
            {
                // We have found two non-Space nodes with zero space between
                // them. Now determine whether we want to merge them.
                
                // The first special case is if the first symbol is a
                // "\not" command, and we try to come up with a MathML
                // character which represents the negation of the following
                // operator.
                SymbolOperator* lastNonSpaceAsOperator =
                    dynamic_cast<SymbolOperator*>(*lastNonSpace);
                SymbolOperator* currentAsOperator =
                    dynamic_cast<SymbolOperator*>(*current);
                wishful_hash_map<wstring, wstring>::const_iterator
                    negationLookup;

                if (
                    lastNonSpaceAsOperator &&
                    lastNonSpaceAsOperator->mText == L"NOT" &&
                    currentAsOperator &&
                    (negationLookup =
                        gNegationTable.find(currentAsOperator->mText))
                    != gNegationTable.end()
                )
                {
                    // Replace with appropriate negated character.

                    if (lastSpace != mChildren.end())
                        mChildren.erase(lastSpace);
                    
                    currentAsOperator->mText = negationLookup->second;
                    mChildren.erase(lastNonSpace);
                }
                else
                {

                    // OK, that special case didn't work out.
                    // If the current node is a scripts node, find its core.
                    Node* currentCore = *current;
                    Scripts* currentCoreAsScripts;
                    while (
                        currentCore &&
                        (currentCoreAsScripts =
                            dynamic_cast<Scripts*>(currentCore))
                    )
                        currentCore = currentCoreAsScripts->mBase.get();
                    
                    // Check candidates are Symbols and their fonts, styles,
                    // colours match, and then either:
                    // * both are SymbolNumber, or
                    // * both are SymbolText, or
                    // * both are SymbolIdentifier and their fonts are both
                    //   normal (this case covers things like <mi>sin</mi>)
                    
                    Symbol* currentCoreAsSymbol =
                        dynamic_cast<Symbol*>(currentCore);
                    Symbol* lastNonSpaceAsSymbol =
                        dynamic_cast<Symbol*>(*lastNonSpace);

                    if (
                        currentCoreAsSymbol && lastNonSpaceAsSymbol
                        &&
                        currentCoreAsSymbol->mFont ==
                            lastNonSpaceAsSymbol->mFont
                        &&
                        currentCoreAsSymbol->mStyle ==
                            lastNonSpaceAsSymbol->mStyle
                        &&
                        currentCoreAsSymbol->mColour ==
                            lastNonSpaceAsSymbol->mColour
                        &&
                        (
                            (dynamic_cast<SymbolNumber*>(currentCore) &&
                             dynamic_cast<SymbolNumber*>(*lastNonSpace))
                            ||
                            (dynamic_cast<SymbolText*>(currentCore) &&
                             dynamic_cast<SymbolText*>(*lastNonSpace))
                            ||
                            (
                                dynamic_cast<SymbolIdentifier*>
                                    (currentCore)
                                &&
                                dynamic_cast<SymbolIdentifier*>
                                    (*lastNonSpace)
                                &&
                                currentCoreAsSymbol->mFont ==
                                    cMathmlFontNormal
                                &&
                                lastNonSpaceAsSymbol->mFont ==
                                    cMathmlFontNormal
                            )
                        )
                    )
                    {
                        // Let's MERGE.
                        // (We do this a slightly odd way to maintain O(n)
                        // complexity.)
                        
                        if (lastSpace != mChildren.end())
                            mChildren.erase(lastSpace);
                        
                        lastNonSpaceAsSymbol->mText +=
                            currentCoreAsSymbol->mText;

                        lastNonSpaceAsSymbol->mText.swap(
                            currentCoreAsSymbol->mText
                        );
                        
                        mChildren.erase(lastNonSpace);
                    }
                }
            }
            
            lastNonSpace = current;
            lastSpace = mChildren.end();
        }
    }
}


void Scripts::Optimise()
{
    if (mBase.get())
        mBase->Optimise();
    if (mLower.get())
        mLower->Optimise();
    if (mUpper.get())
        mUpper->Optimise();
}


void Fraction::Optimise()
{
    mNumerator->Optimise();
    mDenominator->Optimise();
}


void Fenced::Optimise()
{
    mChild->Optimise();
}


void Sqrt::Optimise()
{
    mChild->Optimise();
}


void Root::Optimise()
{
    mInside->Optimise();
    mOutside->Optimise();
}


void Table::Optimise()
{
    for (
        vector<vector<Node*> >::iterator row = mRows.begin();
        row != mRows.end();
        ++row
    )
        for (
            vector<Node*>::iterator entry = row->begin();
            entry != row->end();
            ++entry
        )
            (*entry)->Optimise();
}


// =========================================================================
// Now all the LayoutTree debugging code


wstring indent(int depth)
{
    return wstring(2 * depth, L' ');
}

wstring Node::PrintFields() const
{
    static wstring gFlavourStrings[] =
    {
        L"ord",
        L"op",
        L"bin",
        L"rel",
        L"open",
        L"close",
        L"punct",
        L"inner"
    };

    static wstring gLimitsStrings[] =
    {
        L"displaylimits",
        L"limits",
        L"nolimits"
    };

    static wstring gStyleStrings[] =
    {
        L"displaystyle",
        L"textstyle",
        L"scriptstyle",
        L"scriptscriptstyle"
    };

    wstring output = gFlavourStrings[mFlavour];
    if (mFlavour == cFlavourOp)
        output += L" " + gLimitsStrings[mLimits];
    output += L" " + gStyleStrings[mStyle];
    wostringstream colourHex;
    colourHex << hex << setw(6) << setfill(L'0') << mColour;
    output += L" 0x" + colourHex.str();
    return output;
}

void Row::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Row " << PrintFields() << endl;
    for (list<Node*>::const_iterator
        ptr = mChildren.begin();
        ptr != mChildren.end();
        ptr++
    )
        (*ptr)->Print(os, depth+1);
}

void SymbolIdentifier::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"SymbolIdentifier \"" << mText << L"\" "
        << gMathmlFontStrings[mFont] << L" " << PrintFields() << endl;
}

void SymbolNumber::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"SymbolNumber \"" << mText << L"\" "
        << gMathmlFontStrings[mFont] << L" " << PrintFields() << endl;
}

void SymbolText::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"SymbolText \"" << mText << L"\" "
        << gMathmlFontStrings[mFont] << L" " << PrintFields() << endl;
}

void SymbolOperator::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"SymbolOperator \"" << mText << L"\" "
        << gMathmlFontStrings[mFont]
        << (mIsStretchy ? L" stretchy" : L" non-stretchy")
        << (mIsAccent ? L" accent" : L"");
    if (!mSize.empty())
        os << L" size=\"" << mSize << L"\"";
    os << L" " << PrintFields() << endl;
}

void Space::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Space " << mWidth;
    if (mIsUserRequested)
        os << L" (user requested)";
    os << endl;
}

void Scripts::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Scripts "
        << (mIsSideset ? L"sideset" : L"underover")
        << L" " << PrintFields() << endl;

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

void Fraction::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Fraction ";
    if (!mIsLineVisible)
        os << L"(no visible line) ";
    os << PrintFields() << endl;
    mNumerator->Print(os, depth+1);
    mDenominator->Print(os, depth+1);
}

void Fenced::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Fenced \""
        << mLeftDelimiter << L"\" \""
        << mRightDelimiter << L"\" "
        << PrintFields() << endl;
    mChild->Print(os, depth+1);
}

void Sqrt::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Sqrt " << PrintFields() << endl;
    mChild->Print(os, depth+1);
}

void Root::Print(wostream& os, int depth) const
{
    os << indent(depth) << L"Root " << PrintFields() << endl;
    mInside->Print(os, depth+1);
    mOutside->Print(os, depth+1);
}

void Table::Print(wostream& os, int depth) const
{
    static wstring gAlignStrings[] =
    {
        L"left",
        L"centre",
        L"rightleft"
    };

    os << indent(depth) << L"Table " << PrintFields() << L" "
        << gAlignStrings[mAlign] << endl;
    for (vector<vector<Node*> >::const_iterator
        row = mRows.begin();
        row != mRows.end();
        row++
    )
    {
        os << indent(depth+1) << L"Table row" << endl;
        for (vector<Node*>::const_iterator
            entry = row->begin();
            entry != row->end();
            entry++
        )
            (*entry)->Print(os, depth+2);
    }
}


}
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
