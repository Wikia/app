// File "Messages.cpp"
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

#include <map>
#include "BlahtexCore/Misc.h"

using namespace std;

// This is an array containing all the possible error codes that blahtex
// can emit, together with their English translations.
//
// The sequences $0, $1, etc correspond to the numbered arguments of the
// error.

// FIX: a future version of the command line application should have a
// "--language" option and read error messages from a file.

pair<wstring, wstring> gEnglishMessagesArray[] =
{
    // Input syntax errors:

    make_pair(L"NonAsciiInMathMode",
        L"Non-ASCII characters may only be used in text mode "
        L"(try enclosing the problem characters in \"\\text{...}\")"
    ),

    make_pair(L"IllegalCharacter",
        L"Illegal character in input"
    ),

    make_pair(L"ReservedCommand",
        L"The command \"$0\" is reserved for internal use by blahtex"
    ),

    make_pair(L"TooManyTokens",
        L"The input is too long"
    ),

    make_pair(L"InvalidColour",
        L"The colour \"$0\" is invalid"
    ),

    make_pair(L"IllegalFinalBackslash",
        L"Illegal backslash \"\\\" at end of input"
    ),

    make_pair(L"UnrecognisedCommand",
        L"Unrecognised command \"$0\""
    ),

    make_pair(L"IllegalCommandInMathMode",
        L"The command \"$0\" is illegal in math mode"
    ),

    make_pair(L"IllegalCommandInMathModeWithHint",
        L"The command \"$0\" is illegal in math mode "
        L"(perhaps you intended to use \"$1\" instead?)"
    ),

    make_pair(L"IllegalCommandInTextMode",
        L"The command \"$0\" is illegal in text mode"
    ),

    make_pair(L"IllegalCommandInTextModeWithHint",
        L"The command \"$0\" is illegal in text mode "
        L"(perhaps you intended to use \"$1\" instead?)"
    ),

    make_pair(L"MissingOpenBraceBefore",
        L"Missing open brace \"{\" before \"$0\""
    ),

    make_pair(L"MissingOpenBraceAfter",
        L"Missing open brace \"{\" after \"$0\""
    ),

    make_pair(L"MissingOpenBraceAtEnd",
        L"Missing open brace \"{\" at end of input"
    ),

    make_pair(L"NotEnoughArguments",
        L"Not enough arguments were supplied for \"$0\""
    ),

    make_pair(L"MissingCommandAfterNewcommand",
        L"Missing or illegal new command name after \"\\newcommand\" "
        L"(there must be precisely one command defined; it must begin "
        L"with a backslash \"\\\" and contain only alphabetic characters)"
    ),

    make_pair(L"IllegalRedefinition",
        L"The command \"$0\" has already been defined; "
        L"you cannot redefine it"
    ),

    make_pair(L"MissingOrIllegalParameterCount",
        L"Missing or illegal parameter count in definition of \"$0\" "
        L"(must be a single digit between 1 and 9 inclusive)"
    ),

    make_pair(L"MissingOrIllegalParameterIndex",
        L"Missing or illegal parameter index in definition of \"$0\""
    ),

    make_pair(L"UnmatchedOpenBracket",
        L"Encountered open bracket \"[\" without matching "
        L"close bracket \"]\""
    ),

    make_pair(L"UnmatchedOpenBrace",
        L"Encountered open brace \"{\" without matching close brace \"}\""
    ),

    make_pair(L"UnmatchedCloseBrace",
        L"Encountered close brace \"}\" without matching open brace \"{\""
    ),

    make_pair(L"UnmatchedLeft",
        L"Encountered \"\\left\" without matching \"\\right\""
    ),

    make_pair(L"UnmatchedRight",
        L"Encountered \"\\right\" without matching \"\\left\""
    ),

    make_pair(L"UnmatchedBegin",
        L"Encountered \"\\begin\" without matching \"\\end\""
    ),

    make_pair(L"UnmatchedEnd",
        L"Encountered \"\\end\" without matching \"\\begin\""
    ),

    make_pair(L"UnexpectedNextCell",
        L"The command \"&\" may only appear inside a "
        L"\"\\begin ... \\end\" block"
    ),

    make_pair(L"UnexpectedNextRow",
        L"The command \"\\\\\" may only appear inside a "
        L"\"\\begin ... \\end\" block"
    ),

    make_pair(L"MismatchedBeginAndEnd",
        L"The commands \"$0\" and \"$1\" do not match"
    ),

    make_pair(L"CasesRowTooBig",
        L"There can only be two entries in each row of a \"cases\" block"
    ),

    make_pair(L"SubstackRowTooBig",
        L"There can only be one entry in each row of a \"substack\" block"
    ),

    make_pair(L"MissingDelimiter",
        L"Missing delimiter after \"$0\""
    ),

    make_pair(L"IllegalDelimiter",
        L"Illegal delimiter following \"$0\""
    ),

    make_pair(L"MisplacedLimits",
        L"The command \"$0\" can only appear after a math operator "
        L"(consider using \"\\mathop\")"
    ),

    make_pair(L"DoubleSuperscript",
        L"Encountered two superscripts attached to the same base "
        L"(only one is allowed)"
    ),

    make_pair(L"DoubleSubscript",
        L"Encountered two subscripts attached to the same base "
        L"(only one is allowed)"
    ),

    make_pair(L"AmbiguousInfix",
        L"Ambiguous placement of \"$0\" (try using additional "
        L"braces \"{ ... }\" to disambiguate)"
    ),

    // Errors specific to generating MathML:

    make_pair(L"UnavailableSymbolFontCombination",
        L"The symbol \"$0\" is not available in the font \"$1\""
    ),

    make_pair(L"TooManyMathmlNodes",
        L"There are too many nodes in the MathML tree"
    ),

    // Errors specific to generating purified TeX

    make_pair(L"PngIncompatibleCharacter",
        L"Unable to correctly generate PNG containing the character $0"
    ),
    
    make_pair(L"WrongFontEncoding",
        L"The symbol \"$0\" may not appear in font encoding \"$1\""
    ),
    
    make_pair(L"WrongFontEncodingWithHint",
        L"The symbol \"$0\" may not appear in font encoding \"$1\" "
        L"(try using the \"$2{...}\" command)"
    ),
    
    make_pair(L"IllegalNestedFontEncodings",
        L"Font encoding commands may not be nested"
    ),

    make_pair(L"LatexPackageUnavailable",
        L"Unable to render PNG because "
        L"the LaTeX package \"$0\" is unavailable"
    ),

    make_pair(L"LatexFontNotSpecified",
        L"No LaTeX font has been specified for \"$0\""
    ),
        
    // Now we have errors which may be generated by the command-line
    // application (i.e. by main.cpp)

    make_pair(L"InvalidUtf8Input",
        L"The input string was not valid UTF-8"
    ),

    make_pair(L"CannotCreateTexFile",
        L"Cannot create tex file"
    ),

    make_pair(L"CannotWriteTexFile",
        L"Cannot write to tex file"
    ),

    make_pair(L"CannotRunLatex",
        L"Cannot run latex"
    ),

    make_pair(L"CannotRunDvipng",
        L"Cannot run dvipng"
    ),
    
    make_pair(L"CannotWritePngDirectory",
        L"Cannot write to output PNG directory"
    ),

    make_pair(L"CannotChangeDirectory",
        L"Cannot change working directory"
    )
};

wishful_hash_map<wstring, wstring> gEnglishMessagesTable(
    gEnglishMessagesArray,
    END_ARRAY(gEnglishMessagesArray)
);


// GetErrorMessage() converts the given exception into an English
// string, using the table gEnglishMessagesTable.
wstring GetErrorMessage(const blahtex::Exception& e)
{
    wishful_hash_map<wstring, wstring>::const_iterator
        messageLookup = gEnglishMessagesTable.find(e.GetCode());
    if (messageLookup == gEnglishMessagesTable.end())
        return L"";

    const wstring& source = messageLookup->second;
    wstring message;

    // Perform argument substitution on error message, e.g. "$2" gets
    // replaced with contents of mArgs[2]
    for (wstring::const_iterator
        ptr = source.begin(); ptr != source.end(); ptr++
    )
    {
        if (*ptr == L'$')
        {
            ptr++;
            int n = (*ptr) - L'0';
            if (n >= 0 && n < e.GetArgs().size())
                message += e.GetArgs()[n];
            else
                message += L"???";
        }
        else
            message += *ptr;
    }

    return message;
}


// Returns a string containing a list of all possible error code and
// their corresponding messages.
wstring GetErrorMessages()
{
    wstring output;

    for (wishful_hash_map<wstring, wstring>::const_iterator
        ptr = gEnglishMessagesTable.begin();
        ptr != gEnglishMessagesTable.end();
        ++ptr
    )
        output += ptr->first + L" " + ptr->second + L"\n";

    return output;
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
