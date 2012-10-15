// File "ParseTree1.cpp"
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
#include "ParseTree.h"

using namespace std;

namespace blahtex
{

// This is a list of delimiters which may appear after "\left", "\right"
// and "\big", and of which MathML characters they get mapped to.

static pair<wstring, wstring> gDelimiterArray[] =
{
    make_pair(L".",             L""),
    make_pair(L"[",             L"["),
    make_pair(L"]",             L"]"),
    make_pair(L"\\lbrack",      L"["),
    make_pair(L"\\rbrack",      L"]"),
    make_pair(L"(",             L"("),
    make_pair(L")",             L")"),
    make_pair(L"<",             L"\U00002329"),
    make_pair(L">",             L"\U0000232A"),
    make_pair(L"\\langle",      L"\U00002329"),
    make_pair(L"\\rangle",      L"\U0000232A"),
    make_pair(L"/",             L"/"),
    make_pair(L"\\backslash",   L"\U00002216"),
    make_pair(L"\\{",           L"{"),
    make_pair(L"\\}",           L"}"),
    make_pair(L"\\lbrace",      L"{"),
    make_pair(L"\\rbrace",      L"}"),
    make_pair(L"|",             L"|"),
    make_pair(L"\\vert",        L"|"),
    make_pair(L"\\lvert",       L"|"),
    make_pair(L"\\rvert",       L"|"),
    make_pair(L"\\Vert",        L"\U00002225"),
    make_pair(L"\\lVert",       L"\U00002225"),
    make_pair(L"\\rVert",       L"\U00002225"),
    make_pair(L"\\uparrow",     L"\U00002191"),
    make_pair(L"\\downarrow",   L"\U00002193"),
    make_pair(L"\\updownarrow", L"\U00002195"),
    make_pair(L"\\Uparrow",     L"\U000021D1"),
    make_pair(L"\\Downarrow",   L"\U000021D3"),
    make_pair(L"\\Updownarrow", L"\U000021D5"),
    make_pair(L"\\lfloor",      L"\U0000230A"),
    make_pair(L"\\rfloor",      L"\U0000230B"),
    make_pair(L"\\lceil",       L"\U00002308"),
    make_pair(L"\\rceil",       L"\U00002309")
};

wishful_hash_map<wstring, wstring> gDelimiterTable(
    gDelimiterArray,
    END_ARRAY(gDelimiterArray)
);


namespace ParseTree
{


auto_ptr<LayoutTree::Node> MathList::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    auto_ptr<LayoutTree::Row> output(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );
    list<LayoutTree::Node*>& targetList = output->mChildren;


    // 1st pass: recursively build layout trees for all children in
    // this row, and process state changes
    TexProcessingState currentState = state;
    for (vector<MathNode*>::const_iterator
        node = mChildren.begin(); node != mChildren.end(); node++
    )
    {
        MathStateChange* nodeAsStateChange =
            dynamic_cast<MathStateChange*>(*node);

        if (nodeAsStateChange)
            nodeAsStateChange->Apply(currentState);
        else
            targetList.push_back(
                (*node)->BuildLayoutTree(currentState).release()
            );
    }


    // 2nd pass: modify atom flavours according to TeX's rules.
    for (list<LayoutTree::Node*>::iterator
        node = targetList.begin(); node != targetList.end(); node++
    )
    {
        switch ((*node)->mFlavour)
        {
            case LayoutTree::Node::cFlavourBin:
            {
                if (node == targetList.begin())
                    (*node)->mFlavour = LayoutTree::Node::cFlavourOrd;
                else
                {
                    list<LayoutTree::Node*>::iterator previous = node;
                    previous--;
                    switch ((*previous)->mFlavour)
                    {
                        case LayoutTree::Node::cFlavourBin:
                        case LayoutTree::Node::cFlavourOp:
                        case LayoutTree::Node::cFlavourRel:
                        case LayoutTree::Node::cFlavourOpen:
                        case LayoutTree::Node::cFlavourPunct:
                            (*node)->mFlavour =
                                LayoutTree::Node::cFlavourOrd;
                            break;
                    }
                }
                break;
            }

            case LayoutTree::Node::cFlavourRel:
            case LayoutTree::Node::cFlavourClose:
            case LayoutTree::Node::cFlavourPunct:
            {
                if (node != targetList.begin())
                {
                    list<LayoutTree::Node*>::iterator previous = node;
                    previous--;
                    if ((*previous)->mFlavour ==
                            LayoutTree::Node::cFlavourBin
                    )
                        (*previous)->mFlavour =
                            LayoutTree::Node::cFlavourOrd;
                }

                break;
            }
        }
    }
    if (!targetList.empty() &&
        targetList.back()->mFlavour == LayoutTree::Node::cFlavourBin
    )
        targetList.back()->mFlavour = LayoutTree::Node::cFlavourOrd;


    // 3rd pass: insert inter-atomic spacing according to TeX's rules.

    // spaceTable[i][j] gives the amount of space that should be inserted
    // between nodes of flavour i and flavour j.

    // ignoreSpaceTable[i][j] is nonzero whenever the space between i and j
    // should be ignored while in script or scriptscript style.

    static int spaceTable[8][8] =
    {
    //                     RIGHT
    // ord   op    bin   rel   open  close punct inner
       {0,    3,    4,    5,    0,    0,    0,    3},    // ord
       {3,    3,    0,    5,    0,    0,    0,    3},    // op
       {4,    4,    0,    0,    4,    0,    0,    4},    // bin
       {5,    5,    0,    0,    5,    0,    0,    5},    // rel
       {0,    0,    0,    0,    0,    0,    0,    0},    // open     // LEFT
       {0,    3,    4,    5,    0,    0,    0,    3},    // close
       {3,    3,    0,    3,    3,    3,    3,    3},    // punct
       {3,    3,    4,    5,    3,    0,    3,    3}     // inner
    };

    static int ignoreSpaceTable[8][8] =
    {
    //                     RIGHT
    // ord   op    bin   rel   open  close punct inner
       {0,    0,    1,    1,    0,    0,    0,    1},    // ord
       {0,    0,    0,    1,    0,    0,    0,    1},    // op
       {1,    1,    0,    0,    1,    0,    0,    1},    // bin
       {1,    1,    0,    0,    1,    0,    0,    1},    // rel
       {0,    0,    0,    0,    0,    0,    0,    0},    // open     // LEFT
       {0,    0,    1,    1,    0,    0,    0,    1},    // close
       {1,    1,    0,    1,    1,    1,    1,    1},    // punct
       {1,    0,    1,    1,    1,    0,    1,    1}     // inner
    };

    list<LayoutTree::Node*>::iterator currentAtom = targetList.begin();
    list<LayoutTree::Node*>::iterator previousAtom;
    bool foundFirst = false;
    while (true)
    {
        while (
            currentAtom != targetList.end() &&
            dynamic_cast<LayoutTree::Space*>(*currentAtom)
        )
            currentAtom++;

        if (currentAtom == targetList.end())
            break;

        if (!foundFirst)
            foundFirst = true;
        else
        {
            LayoutTree::Node::Flavour leftFlavour =
                (*previousAtom)->mFlavour;
            LayoutTree::Node::Flavour rightFlavour =
                (*currentAtom)->mFlavour;

            int width =
            (
                ignoreSpaceTable[leftFlavour][rightFlavour] &&
                    (
                        state.mStyle ==
                            LayoutTree::Node::cStyleScript
                        ||
                        state.mStyle ==
                            LayoutTree::Node::cStyleScriptScript
                    )
            )
                ? 0 : spaceTable[leftFlavour][rightFlavour];

            targetList.insert(
                currentAtom,
                new LayoutTree::Space(
                    width,
                    false       // indicates non-user-specified space
                )
            );
        }

        previousAtom = currentAtom;
        currentAtom++;
    }


    // 4th pass: splice any children Rows into this Row.
    // The idea is that no Row node should have any Rows as children.
    for (list<LayoutTree::Node*>::iterator
        child = targetList.begin(); child != targetList.end(); child++
    )
    {
        LayoutTree::Row* childAsRow
            = dynamic_cast<LayoutTree::Row*>(*child);

        if (childAsRow)
        {
            targetList.splice(child, childAsRow->mChildren);
            delete childAsRow;
            child = targetList.erase(child);
        }
    }

    return static_cast< auto_ptr<LayoutTree::Node> >(output);
}


// Stores info about accent commands (like "\hat", "\overrightarrow", etc)
struct AccentInfo {
    wstring mText;
    bool mIsStretchy;

    AccentInfo(
        const wstring& text,
        bool isStretchy
    ) :
        mText(text),
        mIsStretchy(isStretchy)
    { }
};


auto_ptr<LayoutTree::Node> MathCommand1Arg::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    if (mCommand == L"\\sqrt")
        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Sqrt(
                mChild->BuildLayoutTree(state),
                state.mColour
            )
        );

    if (mCommand == L"\\overbrace" || mCommand == L"\\underbrace")
    {
        auto_ptr<LayoutTree::Node> brace(
            new LayoutTree::SymbolOperator(
                true,
                L"",
                false,
                mCommand == L"\\overbrace" ? L"\U0000FE37" : L"\U0000FE38",
                cMathmlFontNormal,
                LayoutTree::Node::cStyleScript,
                LayoutTree::Node::cFlavourOrd,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );

        TexProcessingState newState = state;
        newState.mStyle =
            (state.mStyle == LayoutTree::Node::cStyleDisplay)
                ? LayoutTree::Node::cStyleDisplay
                : LayoutTree::Node::cStyleText;

        auto_ptr<LayoutTree::Node> empty;

        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Scripts(
                newState.mStyle,
                LayoutTree::Node::cFlavourOp,
                LayoutTree::Node::cLimitsLimits,
                state.mColour,
                false,
                mChild->BuildLayoutTree(newState),
                (mCommand == L"\\overbrace")  ? brace : empty,
                (mCommand == L"\\underbrace") ? brace : empty
            )
        );
    }

    if (mCommand == L"\\pmod")
    {
        auto_ptr<LayoutTree::Row> row(
            new LayoutTree::Row(state.mStyle, state.mColour)
        );

        MathmlFont font =
            state.mMathFont.mIsBoldsymbol
                ? cMathmlFontBold : cMathmlFontNormal;

        row->mChildren.push_back(new LayoutTree::Space(18, true));
        row->mChildren.push_back(
            new LayoutTree::SymbolOperator(
                false,
                L"",
                false,
                L"(",
                font,
                state.mStyle,
                LayoutTree::Node::cFlavourOpen,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );
        row->mChildren.push_back(
            new LayoutTree::SymbolOperator(
                false,
                L"",
                false,
                L"mod",
                font,
                state.mStyle,
                LayoutTree::Node::cFlavourOrd,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );
        row->mChildren.push_back(new LayoutTree::Space(6, true));
        row->mChildren.push_back(
            mChild->BuildLayoutTree(state).release()
        );
        row->mChildren.push_back(
            new LayoutTree::SymbolOperator(
                false,
                L"",
                false,
                L")",
                font,
                state.mStyle,
                LayoutTree::Node::cFlavourClose,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );

        return static_cast<auto_ptr<LayoutTree::Node> >(row);
    }

    if (mCommand == L"\\operatorname" ||
        mCommand == L"\\operatornamewithlimits"
    )
    {
        // Essentially this just writes the argument in upright font and
        // sets limits correctly. So initially it looks like
        // <mi mathvariant="normal">s</mi>
        // <mi mathvariant="normal">i</mi>
        // <mi mathvariant="normal">n</mi>
        // But then these get merged later on, to produce the more
        // reasonable <mi>sin</mi>.

        TexProcessingState newState = state;
        newState.mMathFont.mFamily = TexMathFont::cFamilyRm;
        auto_ptr<LayoutTree::Node> node
            = mChild->BuildLayoutTree(newState);
        node->mFlavour = LayoutTree::Node::cFlavourOp;
        node->mLimits =
            (mCommand == L"\\operatorname")
                ? LayoutTree::Node::cLimitsNoLimits
                : LayoutTree::Node::cLimitsDisplayLimits;
        return node;
    }


    static pair<wstring, LayoutTree::Node::Flavour> flavourCommandArray[] =
    {
        make_pair(L"\\mathop",        LayoutTree::Node::cFlavourOp),
        make_pair(L"\\mathrel",       LayoutTree::Node::cFlavourRel),
        make_pair(L"\\mathbin",       LayoutTree::Node::cFlavourBin),
        make_pair(L"\\mathord",       LayoutTree::Node::cFlavourOrd),
        make_pair(L"\\mathopen",      LayoutTree::Node::cFlavourOpen),
        make_pair(L"\\mathclose",     LayoutTree::Node::cFlavourClose),
        make_pair(L"\\mathpunct",     LayoutTree::Node::cFlavourPunct),
        make_pair(L"\\mathinner",     LayoutTree::Node::cFlavourInner)
    };
    static wishful_hash_map<wstring, LayoutTree::Node::Flavour>
        flavourCommandTable(
            flavourCommandArray,
            END_ARRAY(flavourCommandArray)
        );

    wishful_hash_map<wstring, LayoutTree::Node::Flavour>::const_iterator
        flavourCommand = flavourCommandTable.find(mCommand);
    if (flavourCommand != flavourCommandTable.end())
    {
        auto_ptr<LayoutTree::Node> node
            = mChild->BuildLayoutTree(state);
        node->mFlavour = flavourCommand->second;
        if (node->mFlavour == LayoutTree::Node::cFlavourOp)
            node->mLimits = LayoutTree::Node::cLimitsDisplayLimits;
        return node;
    }

    static pair<wstring, TexMathFont::Family> fontCommandArray[] =
    {
        make_pair(L"\\mathbf",         TexMathFont::cFamilyBf),
        make_pair(L"\\mathbb",         TexMathFont::cFamilyBb),
        make_pair(L"\\mathit",         TexMathFont::cFamilyIt),
        make_pair(L"\\mathrm",         TexMathFont::cFamilyRm),
        make_pair(L"\\mathsf",         TexMathFont::cFamilySf),
        make_pair(L"\\mathtt",         TexMathFont::cFamilyTt),
        make_pair(L"\\mathcal",        TexMathFont::cFamilyCal),
        make_pair(L"\\mathfrak",       TexMathFont::cFamilyFrak)
    };
    static wishful_hash_map<wstring, TexMathFont::Family> fontCommandTable(
        fontCommandArray,
        END_ARRAY(fontCommandArray)
    );

    wishful_hash_map<wstring, TexMathFont::Family>::const_iterator
        fontCommand = fontCommandTable.find(mCommand);
    if (fontCommand != fontCommandTable.end())
    {
        TexProcessingState newState = state;
        newState.mMathFont.mFamily = fontCommand->second;
        return mChild->BuildLayoutTree(newState);
    }

    if (mCommand == L"\\boldsymbol")
    {
        TexProcessingState newState = state;
        newState.mMathFont.mIsBoldsymbol = true;
        newState.mMathFont.mFamily = TexMathFont::cFamilyDefault;
        return mChild->BuildLayoutTree(newState);
    }

    // Here is a list of all the accent commands we know about.
    static pair<wstring, AccentInfo> accentCommandArray[] =
    {
        // FIX: there's some funny inconsistency between the definition of
        // &Hat; among MathML versions. I was originally using plain "^" for
        // these accents, but Roger recommended using 0x302 instead.
        make_pair(L"\\hat",                  AccentInfo(L"\U00000302", false)),
        make_pair(L"\\widehat",              AccentInfo(L"\U00000302", true)),
        make_pair(L"\\bar",                  AccentInfo(L"\U000000AF", false)),
        make_pair(L"\\overline",             AccentInfo(L"\U000000AF", true)),
        make_pair(L"\\underline",            AccentInfo(L"\U000000AF", true)),
        make_pair(L"\\tilde",                AccentInfo(L"\U000002DC", false)),
        make_pair(L"\\widetilde",            AccentInfo(L"\U000002DC", true)),
        make_pair(L"\\overleftarrow",        AccentInfo(L"\U00002190", true)),
        make_pair(L"\\vec",                  AccentInfo(L"\U000020D7", true)),
        make_pair(L"\\overrightarrow",       AccentInfo(L"\U00002192", true)),
        make_pair(L"\\overleftrightarrow",   AccentInfo(L"\U00002194", true)),
        make_pair(L"\\dot",                  AccentInfo(L"\U000000B7", false)),
        make_pair(L"\\ddot",                 AccentInfo(L"\U000000B7\U000000B7", false)),
        make_pair(L"\\check",                AccentInfo(L"\U000002C7", false)),
        make_pair(L"\\acute",                AccentInfo(L"\U000000B4", false)),
        make_pair(L"\\grave",                AccentInfo(L"\U00000060", false)),
        make_pair(L"\\breve",                AccentInfo(L"\U000002D8", false)
        )
    };
    static wishful_hash_map<wstring, AccentInfo> accentCommandTable(
        accentCommandArray,
        END_ARRAY(accentCommandArray)
    );

    wishful_hash_map<wstring, AccentInfo>::const_iterator
        accentCommand = accentCommandTable.find(mCommand);
    if (accentCommand != accentCommandTable.end())
    {
        auto_ptr<LayoutTree::Node> base
            = mChild->BuildLayoutTree(state);
        auto_ptr<LayoutTree::Node> lower, upper;

        auto_ptr<LayoutTree::Node> accent(
            new LayoutTree::SymbolOperator(
                accentCommand->second.mIsStretchy,
                L"",
                true,       // is an accent
                accentCommand->second.mText,
                state.mMathFont.mIsBoldsymbol
                    ? cMathmlFontBold : cMathmlFontNormal,
                // We don't need to decrement the style here, because
                // LayoutTree::SymbolOperator knows not to insert style
                // changes for accent operators
                state.mStyle,
                LayoutTree::Node::cFlavourOrd,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );

        if (mCommand == L"\\underline")
            lower = accent;
        else
            upper = accent;

        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Scripts(
                state.mStyle,
                LayoutTree::Node::cFlavourOrd,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour,
                false,      // not sideset
                base,
                upper,
                lower
            )
        );
    }

    throw logic_error(
        "Unexpected command in MathCommand1Arg::BuildLayoutTree"
    );
}


auto_ptr<LayoutTree::Node> MathStateChange::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // We should only arrive here if there was a state change command all
    // by its lonesome self in its own math list, so we can safely ignore
    // it.
    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );
}

auto_ptr<LayoutTree::Node> MathColour::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // See above in MathStateChange::BuildLayoutTree
    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );
}

auto_ptr<LayoutTree::Node> TextStateChange::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // See above in MathStateChange::BuildLayoutTree
    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );
}

auto_ptr<LayoutTree::Node> TextColour::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // See above in MathStateChange::BuildLayoutTree
    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );
}


auto_ptr<LayoutTree::Node> MathCommand2Args::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    bool isFractionCommand = false;
    bool hasParentheses;
    bool isLineVisible;

    if (mCommand == L"\\frac" || mCommand == L"\\over")
    {
        isFractionCommand = true;
        isLineVisible = true;
        hasParentheses = false;
    }
    else if (mCommand == L"\\atop")
    {
        isFractionCommand = true;
        isLineVisible = false;
        hasParentheses = false;
    }
    else if (mCommand == L"\\binom" || mCommand == L"\\choose")
    {
        isFractionCommand = true;
        isLineVisible = false;
        hasParentheses = true;
    }

    if (isFractionCommand)
    {
        // Work out what style the numerator/denominator should be.
        TexProcessingState newState = state;
        switch (state.mStyle)
        {
            case LayoutTree::Node::cStyleDisplay:
                newState.mStyle = LayoutTree::Node::cStyleText;
                break;

            case LayoutTree::Node::cStyleText:
                newState.mStyle = LayoutTree::Node::cStyleScript;
                break;

            case LayoutTree::Node::cStyleScript:
                newState.mStyle = LayoutTree::Node::cStyleScriptScript;
                break;
        }

        auto_ptr<LayoutTree::Node> inside(
            new LayoutTree::Fraction(
                state.mStyle,
                state.mColour,
                mChild1->BuildLayoutTree(newState),
                mChild2->BuildLayoutTree(newState),
                isLineVisible
            )
        );

        if (hasParentheses)
            return auto_ptr<LayoutTree::Node>(
                new LayoutTree::Fenced(
                    state.mStyle,
                    state.mColour,
                    L"(", L")", inside
                )
            );
        else
            return inside;
    }

    if (mCommand == L"\\rootReserved")
    {
        TexProcessingState newState = state;
        newState.mStyle = LayoutTree::Node::cStyleScriptScript;
        
        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Root(
                mChild2->BuildLayoutTree(state),
                mChild1->BuildLayoutTree(newState),
                state.mColour
            )
        );
    }

    if (mCommand == L"\\cfrac")
    {
        TexProcessingState newState = state;
        newState.mStyle = LayoutTree::Node::cStyleText;

        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Fraction(
                LayoutTree::Node::cStyleDisplay,
                state.mColour,
                mChild1->BuildLayoutTree(newState),
                mChild2->BuildLayoutTree(newState),
                true        // true = should be a visible fraction line
            )
        );
    }

    if (mCommand == L"\\overset" || mCommand == L"\\underset")
    {
        // Work out what style the under/overset node should be.
        TexProcessingState newState = state;
        switch (state.mStyle)
        {
            case LayoutTree::Node::cStyleDisplay:
            case LayoutTree::Node::cStyleText:
                newState.mStyle = LayoutTree::Node::cStyleScript;
                break;

            case LayoutTree::Node::cStyleScript:
            case LayoutTree::Node::cStyleScriptScript:
                newState.mStyle = LayoutTree::Node::cStyleScriptScript;
                break;
        }

        auto_ptr<LayoutTree::Node> upper, lower;
        if (mCommand == L"\\overset")
            upper = mChild1->BuildLayoutTree(newState);
        else        // else underset
            lower = mChild1->BuildLayoutTree(newState);

        auto_ptr<LayoutTree::Node> base =
            mChild2->BuildLayoutTree(state);

        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::Scripts(
                state.mStyle,
                base->mFlavour,
                LayoutTree::Node::cLimitsNoLimits,
                state.mColour,
                false,      // false = NOT sideset
                base,
                upper,
                lower
            )
        );
    }

    throw logic_error(
        "Unexpected command in MathCommand2Args::BuildLayoutTree"
    );
}


auto_ptr<LayoutTree::Node> MathScripts::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    auto_ptr<LayoutTree::Node> base, upper, lower;

    LayoutTree::Node::Flavour flavour = LayoutTree::Node::cFlavourOrd;
    LayoutTree::Node::Limits limits =
        LayoutTree::Node::cLimitsDisplayLimits;

    if (mBase.get())
    {
        // If the base is nonempty, we inherit its flavour and limits
        // settings
        base = mBase->BuildLayoutTree(state);
        flavour = base->mFlavour;
        limits = base->mLimits;
    }

    // Work out the style for the super/subscripts
    TexProcessingState newState = state;
    switch (state.mStyle)
    {
        case LayoutTree::Node::cStyleDisplay:
        case LayoutTree::Node::cStyleText:
            newState.mStyle = LayoutTree::Node::cStyleScript;
            break;

        case LayoutTree::Node::cStyleScript:
        case LayoutTree::Node::cStyleScriptScript:
            newState.mStyle = LayoutTree::Node::cStyleScriptScript;
            break;
    }

    if (mUpper.get())
        upper = mUpper->BuildLayoutTree(newState);
    if (mLower.get())
        lower = mLower->BuildLayoutTree(newState);

    // Determine from the flavour and limits settings whether we should
    // be putting limits above/below or to the side.
    bool isSideset =
        (flavour != LayoutTree::Node::cFlavourOp) ||
        (
            limits != LayoutTree::Node::cLimitsLimits &&
            (
                limits != LayoutTree::Node::cLimitsDisplayLimits ||
                state.mStyle != LayoutTree::Node::cStyleDisplay
            )
        );

    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Scripts(
            state.mStyle,
            flavour,
            LayoutTree::Node::cLimitsDisplayLimits,
            state.mColour,
            isSideset,
            base,
            upper,
            lower
        )
    );
}


auto_ptr<LayoutTree::Node> MathLimits::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    auto_ptr<LayoutTree::Node> node =
        mChild->BuildLayoutTree(state);

    if (node->mFlavour != LayoutTree::Node::cFlavourOp)
        throw Exception(L"MisplacedLimits", mCommand);

    if (mCommand == L"\\limits")
        node->mLimits = LayoutTree::Node::cLimitsLimits;
    else if (mCommand == L"\\nolimits")
        node->mLimits = LayoutTree::Node::cLimitsNoLimits;
    else if (mCommand == L"\\displaylimits")
        node->mLimits = LayoutTree::Node::cLimitsDisplayLimits;
    else
        throw logic_error(
            "Unexpected command in MathLimits::BuildLayoutTree."
        );

    return node;
}

auto_ptr<LayoutTree::Node> MathGroup::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // TeX treates any group enclosed by curly braces as an "ordinary" atom.
    // This is why e.g. "123{,}456" looks different to "123,456"
    auto_ptr<LayoutTree::Node> node
        = mChild->BuildLayoutTree(state);
    node->mFlavour = LayoutTree::Node::cFlavourOrd;
    return node;
}


auto_ptr<LayoutTree::Node> MathDelimited::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Fenced(
            state.mStyle,
            state.mColour,
            gDelimiterTable[mLeftDelimiter],
            gDelimiterTable[mRightDelimiter],
            mChild->BuildLayoutTree(state)
        )
    );
}


// Stores information about the various "\big..." commands.
struct BigInfo
{
    LayoutTree::Node::Flavour mFlavour;
    wstring mSize;

    BigInfo(
        LayoutTree::Node::Flavour flavour,
        const wstring& size
    ) :
        mFlavour(flavour),
        mSize(size)
    { }
};


auto_ptr<LayoutTree::Node> MathBig::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // Here's a list of all the "\big..." commands, how big the delimiter
    // should become, and what flavour it should be, for each one.
    static pair<wstring, BigInfo> bigCommandArray[] =
    {
        make_pair(L"\\big",   BigInfo(LayoutTree::Node::cFlavourOrd,   L"1.2em")),
        make_pair(L"\\bigl",  BigInfo(LayoutTree::Node::cFlavourOpen,  L"1.2em")),
        make_pair(L"\\bigr",  BigInfo(LayoutTree::Node::cFlavourClose, L"1.2em")),

        make_pair(L"\\Big",   BigInfo(LayoutTree::Node::cFlavourOrd,   L"1.8em")),
        make_pair(L"\\Bigl",  BigInfo(LayoutTree::Node::cFlavourOpen,  L"1.8em")),
        make_pair(L"\\Bigr",  BigInfo(LayoutTree::Node::cFlavourClose, L"1.8em")),

        make_pair(L"\\bigg",  BigInfo(LayoutTree::Node::cFlavourOrd,   L"2.4em")),
        make_pair(L"\\biggl", BigInfo(LayoutTree::Node::cFlavourOpen,  L"2.4em")),
        make_pair(L"\\biggr", BigInfo(LayoutTree::Node::cFlavourClose, L"2.4em")),

        make_pair(L"\\Bigg",  BigInfo(LayoutTree::Node::cFlavourOrd,   L"3em")),
        make_pair(L"\\Biggl", BigInfo(LayoutTree::Node::cFlavourOpen,  L"3em")),
        make_pair(L"\\Biggr", BigInfo(LayoutTree::Node::cFlavourClose, L"3em"))
    };
    static wishful_hash_map<wstring, BigInfo> bigCommandTable(
        bigCommandArray,
        END_ARRAY(bigCommandArray)
    );

    wishful_hash_map<wstring, BigInfo>::const_iterator
        bigCommand = bigCommandTable.find(mCommand);

    if (bigCommand != bigCommandTable.end())
    {
        LayoutTree::Node::Style newStyle = state.mStyle;
        if (state.mStyle != LayoutTree::Node::cStyleDisplay &&
            state.mStyle != LayoutTree::Node::cStyleText
        )
            newStyle = LayoutTree::Node::cStyleText;

        // FIX: TeX allows "\big."; do we?
        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::SymbolOperator(
                true,       // indicates stretchy="true"
                bigCommand->second.mSize,
                false,      // not an accent
                gDelimiterTable[mDelimiter],
                cMathmlFontNormal,
                newStyle,
                bigCommand->second.mFlavour,
                LayoutTree::Node::cLimitsDisplayLimits,
                state.mColour
            )
        );
    }

    throw logic_error("Unknown command in MathBig::BuildLayoutTree");
}


auto_ptr<LayoutTree::Node> MathTableRow::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // We should never get here, because MathTable::BuildLayoutTree
    // handles the whole table.
    throw logic_error(
        "Arrived unexpectedly in MathTableRow::BuildLayoutTree"
    );
}


auto_ptr<LayoutTree::Node> MathTable::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    auto_ptr<LayoutTree::Table> table(
        new LayoutTree::Table(state.mStyle, state.mColour)
    );
    table->mRows.reserve(mRows.size());

    // Walk the table, building the layout tree as we go.
    for (vector<MathTableRow*>::const_iterator
        inRow = mRows.begin();
        inRow != mRows.end();
        inRow++
    )
    {
        table->mRows.push_back(vector<LayoutTree::Node*>());
        vector<LayoutTree::Node*>& outRow = table->mRows.back();
        for (vector<MathNode*>::const_iterator
            entry = (*inRow)->mEntries.begin();
            entry != (*inRow)->mEntries.end();
            entry++
        )
            outRow.push_back(
                (*entry)->
                    BuildLayoutTree(state).release()
            );
    }

    return static_cast<auto_ptr<LayoutTree::Node> >(table);
}


// Stores information about an environment.
struct EnvironmentInfo
{
    wstring mLeftDelimiter, mRightDelimiter;

    EnvironmentInfo(
        const wstring& leftDelimiter,
        const wstring& rightDelimiter
    ) :
        mLeftDelimiter(leftDelimiter),
        mRightDelimiter(rightDelimiter)
    { }
};


auto_ptr<LayoutTree::Node> MathEnvironment::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // A list of all environments, and which delimiters appear on each
    // side of the corresponding table.
    // FIX: this is kind of stupid... almost every environment ends up
    // with its own special-case code!
    static pair<wstring, EnvironmentInfo> environmentArray[] =
    {
        make_pair(L"matrix",       EnvironmentInfo(L"",       L"")),
        make_pair(L"pmatrix",      EnvironmentInfo(L"(",      L")")),
        make_pair(L"bmatrix",      EnvironmentInfo(L"[",      L"]")),
        make_pair(L"Bmatrix",      EnvironmentInfo(L"{",      L"}")),
        make_pair(L"vmatrix",      EnvironmentInfo(L"|",      L"|")),
        // DoubleVerticalBar:
        make_pair(L"Vmatrix",      EnvironmentInfo(L"\U00002225", L"\U00002225")),
        make_pair(L"cases",        EnvironmentInfo(L"{",      L"")),
        make_pair(L"aligned",      EnvironmentInfo(L"",       L"")),
        make_pair(L"smallmatrix",  EnvironmentInfo(L"",       L"")),
        make_pair(L"substack",     EnvironmentInfo(L"",       L""))
    };
    static wishful_hash_map<wstring, EnvironmentInfo> environmentTable(
        environmentArray,
        END_ARRAY(environmentArray)
    );

    wishful_hash_map<wstring, EnvironmentInfo>::const_iterator
        environmentLookup = environmentTable.find(mName);

    if (environmentLookup == environmentTable.end())
        throw logic_error(
            "Unexpected environment name in "
            "MathEnvironment::BuildLayoutTree"
        );

    // For reasons I haven't investigated, the "boldsymbol" flag persists
    // into environments, but the math font doesn't.
    TexProcessingState newState = state;
    newState.mMathFont = TexMathFont();
    newState.mMathFont.mIsBoldsymbol = state.mMathFont.mIsBoldsymbol;

    LayoutTree::Node::Style fencedStyle;
    if (mName == L"smallmatrix" || mName == L"substack")
        newState.mStyle = LayoutTree::Node::cStyleScript;
    else if (mName == L"aligned")
        newState.mStyle = LayoutTree::Node::cStyleDisplay;
    else
    {
        newState.mStyle = LayoutTree::Node::cStyleText;
        fencedStyle =
            (state.mStyle == LayoutTree::Node::cStyleDisplay)
                ? LayoutTree::Node::cStyleDisplay
                : LayoutTree::Node::cStyleText;
    }

    auto_ptr<LayoutTree::Node> table = mTable->BuildLayoutTree(newState);
    LayoutTree::Table* tablePtr =
        dynamic_cast<LayoutTree::Table*>(table.get());
    if (!tablePtr)
        throw logic_error(
            "Unexpected node type in MathEnvironment::BuildLayoutTree"
        );

    if (mName == L"substack")
        tablePtr->mRowSpacing = LayoutTree::Table::cRowSpacingTight;

    if (mName == L"aligned")
        tablePtr->mAlign = LayoutTree::Table::cAlignRightLeft;
    else if (mName == L"cases")
        tablePtr->mAlign = LayoutTree::Table::cAlignLeft;

    if (environmentLookup->second.mLeftDelimiter.empty() &&
        environmentLookup->second.mRightDelimiter.empty()
    )
        return table;

    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::Fenced(
            fencedStyle,
            state.mColour,
            environmentLookup->second.mLeftDelimiter,
            environmentLookup->second.mRightDelimiter,
            table
        )
    );
}


auto_ptr<LayoutTree::Node> EnterTextMode::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    // List of all commands that launch into text mode, and some information
    // about which font they select.
    static pair<wstring, TexTextFont> textCommandArray[] =
    {                                             // flags are:     bold?  italic?
        make_pair(L"\\mbox",    TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\hbox",    TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\text",    TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\textrm",  TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\textbf",  TexTextFont(TexTextFont::cFamilyRm, true,  false)),
        make_pair(L"\\emph",    TexTextFont(TexTextFont::cFamilyRm, false, true)),
        make_pair(L"\\textit",  TexTextFont(TexTextFont::cFamilyRm, false, true)),
        make_pair(L"\\textsf",  TexTextFont(TexTextFont::cFamilySf, false, false)),
        make_pair(L"\\texttt",  TexTextFont(TexTextFont::cFamilyTt, false, false)),
        make_pair(L"\\cyr",     TexTextFont(TexTextFont::cFamilyRm, false, false)),
        make_pair(L"\\jap",     TexTextFont(TexTextFont::cFamilyRm, false, false))
    };
    static wishful_hash_map<wstring, TexTextFont> textCommandTable(
        textCommandArray,
        END_ARRAY(textCommandArray)
    );

    wishful_hash_map<wstring, TexTextFont>::iterator
        textCommand = textCommandTable.find(mCommand);

    if (textCommand == textCommandTable.end())
        throw logic_error(
            "Unexpected command in EnterTextMode::BuildLayoutTree"
        );

    TexProcessingState newState = state;
    newState.mTextFont = textCommand->second;
    
    if (mCommand == L"\\hbox" || mCommand == L"\\mbox")
        newState.mStyle = LayoutTree::Node::cStyleText;

    return mChild->BuildLayoutTree(newState);
}


auto_ptr<LayoutTree::Node> TextList::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    auto_ptr<LayoutTree::Row> node(
        new LayoutTree::Row(state.mStyle, state.mColour)
    );

    // Recursively build layout trees for children, and merge Rows to obtain
    // a single Row, and apply state changes as appropriate.
    TexProcessingState currentState = state;
    for (vector<TextNode*>::const_iterator
        child = mChildren.begin();
        child != mChildren.end();
        child++
    )
    {
        TextStateChange* childAsStateChange =
            dynamic_cast<TextStateChange*>(*child);

        if (childAsStateChange)
            childAsStateChange->Apply(currentState);
        else
        {
            auto_ptr<LayoutTree::Node>
                newNode = (*child)->BuildLayoutTree(currentState);

            LayoutTree::Row* isRow =
                dynamic_cast<LayoutTree::Row*>(newNode.get());

            if (isRow)
                node->mChildren.splice(
                    node->mChildren.end(),
                    isRow->mChildren
                );
            else
                node->mChildren.push_back(newNode.release());
        }
    }

    return static_cast<auto_ptr<LayoutTree::Node> >(node);
}


auto_ptr<LayoutTree::Node> TextSymbol::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    static pair<wstring, wstring> textCommandArray[] =
    {
        make_pair(L"\\!",      L""),
        make_pair(L" ",        L"\U000000A0"),     // NonBreakingSpace
        make_pair(L"~",        L"\U000000A0"),
        make_pair(L"\\,",      L"\U000000A0"),
        make_pair(L"\\ ",      L"\U000000A0"),
        make_pair(L"\\;",      L"\U000000A0"),
        make_pair(L"\\quad",   L"\U000000A0\U000000A0"),
        make_pair(L"\\qquad",  L"\U000000A0\U000000A0\U000000A0\U000000A0"),

        make_pair(L"\\&",                 L"&"),
        // FIX: why did I put in these next two lines again?
        // FIX: The character "<" and ">" actually do funny things in TeX...
        make_pair(L"<",                   L"<"),
        make_pair(L">",                   L">"),
        make_pair(L"\\_",                 L"_"),
        make_pair(L"\\$",                 L"$"),
        make_pair(L"\\#",                 L"#"),
        make_pair(L"\\%",                 L"%"),
        make_pair(L"\\{",                 L"{"),
        make_pair(L"\\}",                 L"}"),
        make_pair(L"\\textbackslash",     L"\\"),
        // FIX: for some reason in Firefox the caret is much lower
        // than it should be
        make_pair(L"\\textasciicircum",   L"^"),
        make_pair(L"\\textasciitilde",    L"~"),
        make_pair(L"\\textvisiblespace",  L"\U000023B5"),
        make_pair(L"\\O",                 L"\U000000D8"),
        make_pair(L"\\S",                 L"\U000000A7")
    };
    static wishful_hash_map<wstring, wstring> textCommandTable(
        textCommandArray,
        END_ARRAY(textCommandArray)
    );

    wishful_hash_map<wstring, wstring>::iterator
        textCommand = textCommandTable.find(mCommand);

    if (textCommand != textCommandTable.end())
        return auto_ptr<LayoutTree::Node>(
            new LayoutTree::SymbolText(
                textCommand->second,
                state.mTextFont.GetMathmlApproximation(),
                state.mStyle,
                state.mColour
            )
        );

    return auto_ptr<LayoutTree::Node>(
        new LayoutTree::SymbolText(
            mCommand,
            state.mTextFont.GetMathmlApproximation(),
            state.mStyle,
            state.mColour
        )
    );
}


auto_ptr<LayoutTree::Node> TextGroup::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    return mChild->BuildLayoutTree(state);
}


auto_ptr<LayoutTree::Node> TextCommand1Arg::BuildLayoutTree(
    const TexProcessingState& state
) const
{
    TexProcessingState newState = state;

    if (mCommand == L"\\textrm")
        newState.mTextFont.mFamily = TexTextFont::cFamilyRm;
    else if (mCommand == L"\\texttt")
        newState.mTextFont.mFamily = TexTextFont::cFamilyTt;
    else if (mCommand == L"\\textsf")
        newState.mTextFont.mFamily = TexTextFont::cFamilySf;
    else if (mCommand == L"\\textit")
        newState.mTextFont.mIsItalic = true;
    else if (mCommand == L"\\emph")
        newState.mTextFont.mIsItalic = !newState.mTextFont.mIsItalic;
    else if (mCommand == L"\\textbf")
        newState.mTextFont.mIsBold = true;
    else if (
        mCommand == L"\\text" ||
        mCommand == L"\\hbox" ||
        mCommand == L"\\mbox" ||
        mCommand == L"\\cyr" ||
        mCommand == L"\\jap"
    )
        // do nothing!
        { }
    else
        throw logic_error(
            "Unexpected command in TextCommand1Arg::BuildLayoutTree"
        );

    return mChild->BuildLayoutTree(newState);
}

}
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
