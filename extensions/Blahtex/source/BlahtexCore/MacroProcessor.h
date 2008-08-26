// File "MacroProcessor.h"
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

#ifndef BLAHTEX_MACROPROCESSOR_H
#define BLAHTEX_MACROPROCESSOR_H

#include <string>
#include <vector>
#include <map>
#include "Misc.h"

namespace blahtex
{

// The time spent by the parser should be O(cMaxParseCost).
// The aim is to prevent a nasty user inducing exponential time via
// tricky macro definitions.
const unsigned cMaxParseCost = 20000;


// MacroProcessor maintains a stack of tokens, can be queried for the next
// available token, and expands macros automatically. It is the layer
// between tokenising (handled by the Manager class) and parsing proper
// (handled by the Parser class).
//
// It does not process "\newcommand" commands automatically; instead it
// passes "\newcommand" straight back to the caller, and the caller is
// responsible for calling MacroProcessor::HandleNewcommand.
// (Rationale: this gives results much closer to real TeX parsing. For
// example, we wouldn't want "x^\newcommand{\stuff}{xyz}\stuff" to be
// construed as legal input.)
class MacroProcessor
{
public:
    // Input is a vector of strings, one for each input token.
    MacroProcessor(const std::vector<std::wstring>& input);

    // Returns the next token on the stack (without removing it), after
    // expanding macros.
    // Returns empty string if there are no tokens left.
    std::wstring Peek();

    // Same as Peek(), but also removes the token.
    // Returns empty string if there are no tokens left.
    std::wstring Get();

    // Pops the current token.
    void Advance();

    // Pops consecutive whitespace tokens.
    void SkipWhitespace();

    // Assuming that "\newcommand" has just been seen and popped off the
    // stack, this function processes a subsequent macro definition.
    void HandleNewcommand();

private:

    // Records information about a single macro.
    struct Macro
    {
        // The number of parameters the macro accepts. (Blahtex doesn't
        // handle optional arguments.)
        int mParameterCount;

        // The sequence of tokens that get substituted when this macro is
        // expanded. Arguments are indicated as follows: first the string
        // "#", and then the string "n", where n is a number between 1 and
        // 9, indicating which argument to substitute.
        std::vector<std::wstring> mReplacement;

        Macro() :
            mParameterCount(0)
        { }
    };

    // List of all currently recognised macros.
    wishful_hash_map<std::wstring, Macro> mMacros;

    // The token stack; the top of the stack is mTokens.back().
    std::vector<std::wstring> mTokens;

    // This flag is set if we have already ascertained that the current
    // token doesn't need to undergo macro expansion.
    // (This is just an optimisation so that successive calls to Peek/Get
    // don't have to do extra work.)
    bool mIsTokenReady;

    // Reads a single macro argument; that is, either a single token, or if
    // that token is "{", reads all the way up to the matching "}". The
    // argument (not including delimiting braces) is appended to "output".
    //
    // Returns true on success, or false if the argument is missing.
    bool ReadArgument(std::vector<std::wstring>& output);

    // Skips whitespace without expanding macros.
    void SkipWhitespaceRaw();

    // Total approximate cost of parsing activity so far.
    // (See cMaxParseCost.)
    unsigned mCostIncurred;
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
