// File "Parser.h"
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

#ifndef BLAHTEX_PARSER_H
#define BLAHTEX_PARSER_H

#include "MacroProcessor.h"
#include "ParseTree.h"

namespace blahtex
{

// The Parser class actually does the parsing work. It runs the supplied
// input tokens through a MacroProcessor, and builds a parse tree from the
// resulting expanded token stream.
class Parser
{

public:
    // Main function that the caller should use to do a parsing job.
    // Input is a TeX string, output is the root of a parse tree.
    std::auto_ptr<ParseTree::MathNode> DoParse(
        const std::vector<std::wstring>& input
    );

    // The parser uses GetMathTokenCode (in math mode) or GetTextTokenCode
    // (in text mode) to translate each incoming token into one of the
    // following values:
    enum TokenCode
    {
        cEndOfInput,
        cWhitespace,
        cNewcommand,        // The "\newcommand" command.
        cIllegal,           // Single character commands that are illegal in
                            // the current mode (like "$", "%").
        cBeginGroup,        // Opening and closing braces ("{" and "}").
        cEndGroup,
        cNextCell,          // The commands "&" and "\\".
        cNextRow,
        cSuperscript,       // The commands "^" and "_".
        cSubscript,
        cPrime,             // The prime symbol "'".
        cCommand1Arg,       // TeX commands accepting one argument.
        cCommand2Args,      // TeX commands accepting two arguments.
        cCommandInfix,      // Infix commands like "\over".
        cLeft,              // The "\left" and "\right" commands.
        cRight,
        cBig,               // "\big" style commands.
        cLimits,            // "\limits", "\nolimits", or "\displaylimits".
        cBeginEnvironment,  // Like "\begin{matrix}", "\end{matrix}"
        cEndEnvironment,
        cShortEnvironment,  // Like "\substack{...}". Inside the braces it
                            // behaves like an environment, but it doesn't
                            // use "\begin" or "\end".
        cEnterTextMode,     // Command that switch from math mode to text
                            // mode (e.g. "\text").
        cStateChange,       // State changes, e.g. "\rm", "\scriptstyle",
                            // "\color".
        cSymbol,            // Pretty much every other command: e.g.
                            // "a", "1", "\alpha", "+", "\rightarrow", etc.

        // cSymbolUnsafe covers some commands that one might expect to get
        // translated as cSymbol.
        //
        // The issue is that TeX/LaTeX/AMS-LaTeX expands certain commands as
        // macros, and they subsequently become unsafe for use as a single
        // symbol. For example, "x^\cong" is illegal in TeX, because "\cong"
        // gets expanded as a macro, so we assign the code cSymbolUnsafe to
        // "\cong". This is a bit of a nasty hack, but the only real
        // alternative is to simulate a much larger portion of
        // TeX/LaTeX/AMS-LaTeX, which at this stage is unpalatable :-)
        cSymbolUnsafe
    };

private:
    // Tokens are first filtered through this MacroProcessor object, so that
    // the parser doesn't have to be aware of macros at all.
    std::auto_ptr<MacroProcessor> mTokenSource;

    // ParseMathList starts parsing a math list, until it reaches a command
    // indicating the end of the list, like "}" or "\right" or "\end{...}".
    std::auto_ptr<ParseTree::MathNode> ParseMathList();

    // ParseMathField parses a TeX "math field", which is either a single
    // symbol or an expression grouped with braces.
    std::auto_ptr<ParseTree::MathNode> ParseMathField();

    // Handle a table enclosed in something like "\begin{matrix} ...
    // \end{matrix}"; i.e. it breaks input up into entries and rows based on
    // "\\" and "&" commands.
    std::auto_ptr<ParseTree::MathTable> ParseMathTable();

    // PrepareScripts is called when we encounter "^" or "_". It ensures
    // that the last element of output->mChildren is a MathScripts node
    // whose base is the base of the "^" or "_" command.
    //
    // (The caller does not get ownership of the MathScripts node;
    // PrepareScripts assigns this ownership to *output if necessary).
    ParseTree::MathScripts* PrepareScripts(ParseTree::MathList* output);

    // ParseTextList starts parsing a text list, until it reaches "}" or
    // end of input.
    std::auto_ptr<ParseTree::TextNode> ParseTextList();

    // ParseTextField parses an argument to a command in text mode, which
    // is either a single symbol or an expression grouped with braces.
    std::auto_ptr<ParseTree::TextNode> ParseTextField();

    // These functions determine the appropriate token code for the supplied
    // token. Things like "1", "a", "+" are handled appropriately, as are
    // backslash-prefixed commands listed in gMathTokenTable or
    // gTextTokenTable.
    TokenCode GetMathTokenCode(const std::wstring& token) const;
    TokenCode GetTextTokenCode(const std::wstring& token) const;
    
    // Parses stuff that occurs after "\color", e.g. "  {red}", and checks
    // that the colour is legal. Returns the colour name, e.g. "red".
    std::wstring ParseColourName();
};

}

#endif

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
