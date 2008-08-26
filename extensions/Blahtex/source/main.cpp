// File "main.cpp"
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

#include "BlahtexCore/Interface.h"
#include "UnicodeConverter.h"
#include "mainPng.h"
#include <iostream>
#include <sstream>
#include <stdexcept>

using namespace std;
using namespace blahtex;

string gBlahtexVersion = "0.4.4";

// A single global instance of UnicodeConverter.
UnicodeConverter gUnicodeConverter;

// Imported from Messages.cpp:
extern wstring GetErrorMessage(const blahtex::Exception& e);
extern wstring GetErrorMessages();

// FormatError() converts a blahtex Exception object into a string like
// "<error><id>...</id><arg>...</arg><arg>...</arg> ...
// <message>...</message></error".
wstring FormatError(
    const blahtex::Exception& e,
    const EncodingOptions& options
)
{
    wstring output = L"<error><id>" + e.GetCode() + L"</id>";
    for (vector<wstring>::const_iterator
        arg = e.GetArgs().begin(); arg != e.GetArgs().end(); arg++
    )
        output += L"<arg>" + XmlEncode(*arg, options) + L"</arg>";

    output += L"<message>";
    output += XmlEncode(GetErrorMessage(e), options);
    output += L"</message>";

    output += L"</error>";
    return output;
}

// ShowUsage() prints a help screen.
void ShowUsage()
{
    cout << "\n"
"Blahtex version " << gBlahtexVersion << "\n"
"Copyright (C) 2006, David Harvey\n"
"\n"
"This is free software; see the source "
"for copying conditions. There is NO\n"
"warranty; not even for MERCHANTABILITY "
"or FITNESS FOR A PARTICULAR PURPOSE.\n"
"\n"
"Usage: blahtex [ options ] < inputfile > outputfile\n"
"\n"
"SUMMARY OF OPTIONS (see manual for details)\n"
"\n"
" --texvc-compatible-commands\n"
"\n"
" --mathml\n"
" --indented\n"
" --spacing { strict | moderate | relaxed }\n"
" --mathml-version-1-fonts\n"
" --disallow-plane-1\n"
" --mathml-encoding { raw | numeric | short | long }\n"
" --other-encoding { raw | numeric }\n"
"\n"
" --png\n"
" --use-ucs-package\n"
" --use-cjk-package\n"
" --use-preview-package\n"
" --japanese-font  fontname\n"
" --shell-latex  command\n"
" --shell-dvipng  command\n"
" --temp-directory  directory\n"
" --png-directory  directory\n"
"\n"
" --debug { parse | layout | purified }\n"
" --keep-temp-files\n"
" --throw-logic-error\n"
" --print-error-messages\n"
"\n"
"More information available at www.blahtex.org\n"
"\n";

    // FIX: need command line option to select output DPI

    exit(0);
}

// CommandLineException is used for reporting incorrect command line
// syntax.
struct CommandLineException
{
    string mMessage;

    CommandLineException(
        const string& message
    ) :
        mMessage(message)
    { }
};

// Adds a trailing slash to the string, if it's not already there.
void AddTrailingSlash(string& s)
{
    if (!s.empty() && s[s.size() - 1] != '/')
        s += '/';
}

int main (int argc, char* const argv[]) {
    // This outermost try block catches std::runtime_error
    // and CommandLineException.
    try
    {
        gUnicodeConverter.Open();

        blahtex::Interface interface;

        bool doPng    = false;
        bool doMathml = false;

        bool debugLayoutTree  = false;
        bool debugParseTree   = false;
        bool debugPurifiedTex = false;
        bool deleteTempFiles  = true;

        string shellLatex   = "latex";
        string shellDvipng  = "dvipng";
        string tempDirectory = "./";
        string  pngDirectory = "./";

        // Process command line arguments
        for (int i = 1; i < argc; i++)
        {
            string arg(argv[i]);

            if (arg == "--help")
                ShowUsage();

            else if (arg == "--print-error-messages")
            {
                cout << gUnicodeConverter.ConvertOut(GetErrorMessages())
                    << endl;
                return 0;
            }

            else if (arg == "--throw-logic-error")
                throw logic_error("Aaarrrgggghhhh!");

            else if (arg == "--shell-latex")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--shell-latex\""
                    );
                shellLatex = string(argv[i]);
            }

            else if (arg == "--shell-dvipng")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--shell-dvipng\""
                    );
                shellDvipng = string(argv[i]);
            }

            else if (arg == "--temp-directory")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--temp-directory\""
                    );
                tempDirectory = string(argv[i]);
                AddTrailingSlash(tempDirectory);
            }

            else if (arg == "--png-directory")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--png-directory\""
                    );
                pngDirectory = string(argv[i]);
                AddTrailingSlash(pngDirectory);
            }

            else if (arg == "--use-ucs-package")
                interface.mPurifiedTexOptions.mAllowUcs = true;

            else if (arg == "--use-cjk-package")
                interface.mPurifiedTexOptions.mAllowCJK = true;
            
            else if (arg == "--use-preview-package")
                interface.mPurifiedTexOptions.mAllowPreview = true;
            
            else if (arg == "--japanese-font")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--japanese-font\""
                    );
                interface.mPurifiedTexOptions.mJapaneseFont =
                    gUnicodeConverter.ConvertIn(string(argv[i]));
            }

            else if (arg == "--indented")
                interface.mIndented = true;

            else if (arg == "--spacing")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--spacing\""
                    );
                arg = string(argv[i]);

                if (arg == "strict")
                    interface.mMathmlOptions.mSpacingControl
                        = MathmlOptions::cSpacingControlStrict;

                else if (arg == "moderate")
                    interface.mMathmlOptions.mSpacingControl
                        = MathmlOptions::cSpacingControlModerate;

                else if (arg == "relaxed")
                    interface.mMathmlOptions.mSpacingControl
                        = MathmlOptions::cSpacingControlRelaxed;

                else
                    throw CommandLineException(
                        "Illegal string after \"--spacing\""
                    );
            }

            else if (arg == "--mathml-version-1-fonts")
                interface.mMathmlOptions.mUseVersion1FontAttributes = true;

            else if (arg == "--texvc-compatible-commands")
                interface.mTexvcCompatibility = true;

            else if (arg == "--png")
                doPng = true;

            else if (arg == "--mathml")
                doMathml = true;

            else if (arg == "--mathml-encoding")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--mathml-encoding\""
                    );
                arg = string(argv[i]);

                if (arg == "raw")
                    interface.mEncodingOptions.mMathmlEncoding
                        = EncodingOptions::cMathmlEncodingRaw;

                else if (arg == "numeric")
                    interface.mEncodingOptions.mMathmlEncoding
                        = EncodingOptions::cMathmlEncodingNumeric;

                else if (arg == "short")
                    interface.mEncodingOptions.mMathmlEncoding
                        = EncodingOptions::cMathmlEncodingShort;

                else if (arg == "long")
                    interface.mEncodingOptions.mMathmlEncoding
                        = EncodingOptions::cMathmlEncodingLong;

                else
                    throw CommandLineException(
                        "Illegal string after \"--mathml-encoding\""
                    );
            }

            else if (arg == "--disallow-plane-1")
            {
                interface.mMathmlOptions  .mAllowPlane1 = false;
                interface.mEncodingOptions.mAllowPlane1 = false;
            }

            else if (arg == "--other-encoding")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--other-encoding\""
                    );
                arg = string(argv[i]);
                if (arg == "raw")
                    interface.mEncodingOptions.mOtherEncodingRaw = true;
                else if (arg == "numeric")
                    interface.mEncodingOptions.mOtherEncodingRaw = false;
                else
                    throw CommandLineException(
                        "Illegal string after \"--other-encoding\""
                    );
            }

            else if (arg == "--debug")
            {
                if (++i == argc)
                    throw CommandLineException(
                        "Missing string after \"--debug\""
                    );
                arg = string(argv[i]);
                if (arg == "layout")
                    debugLayoutTree = true;
                else if (arg == "parse")
                    debugParseTree = true;
                else if (arg == "purified")
                    debugPurifiedTex = true;
                else
                    throw CommandLineException(
                        "Illegal string after \"--debug\""
                    );
            }
            
            else if (arg == "--keep-temp-files")
                deleteTempFiles = false;

            else
                throw CommandLineException(
                    "Unrecognised command line option \"" + arg + "\""
                );
        }

        // Finished processing command line, now process the input

        if (isatty(0))
            ShowUsage();

        wostringstream mainOutput;

        try
        {
            wstring input;

            // Read input file
            string inputUtf8;
            {
                char c;
                while (cin.get(c))
                    inputUtf8 += c;
            }

            // This try block converts UnicodeConverter::Exception into an
            // input syntax error, i.e. if the user supplies invalid UTF-8.
            // (Later we treat such exceptions as debug assertions.)
            try
            {
                input = gUnicodeConverter.ConvertIn(inputUtf8);
            }
            catch (UnicodeConverter::Exception& e)
            {
                throw blahtex::Exception(L"InvalidUtf8Input");
            }

            // Build the parse and layout trees.
            interface.ProcessInput(input);

            if (debugParseTree)
            {
                mainOutput << L"\n=== BEGIN PARSE TREE ===\n\n";
                interface.GetManager()->GetParseTree()->Print(mainOutput);
                mainOutput << L"\n=== END PARSE TREE ===\n\n";
            }

            if (debugLayoutTree)
            {
                mainOutput << L"\n=== BEGIN LAYOUT TREE ===\n\n";
                wostringstream temp;
                interface.GetManager()->GetLayoutTree()->Print(temp);
                mainOutput << XmlEncode(temp.str(), EncodingOptions());
                mainOutput << L"\n=== END LAYOUT TREE ===\n\n";
            }

            // Generate purified TeX if required.
            if (doPng || debugPurifiedTex)
            {
                // This stream is where we build the PNG output block:
                wostringstream pngOutput;

                try
                {
                    wstring purifiedTex = interface.GetPurifiedTex();

                    if (debugPurifiedTex)
                    {
                        pngOutput << L"\n=== BEGIN PURIFIED TEX ===\n\n";
                        pngOutput << purifiedTex;
                        pngOutput << L"\n=== END PURIFIED TEX ===\n\n";
                    }

                    // Make the system calls to generate the PNG image
                    // if requested.
                    if (doPng)
                    {
                        PngInfo info = MakePngFile(
                            purifiedTex,
                            tempDirectory,
                            pngDirectory,
                            "",
                            shellLatex,
                            shellDvipng,
                            deleteTempFiles
                        );

                        // The height and depth measurements are only
                        // valid if the "preview" package is used:
                        if (interface.mPurifiedTexOptions.mAllowPreview
                            && info.mDimensionsValid
                        )
                        {
                            pngOutput << L"<height>"
                                << info.mHeight << L"</height>\n";
                            pngOutput << L"<depth>"
                                << info.mDepth << L"</depth>\n";
                        }

                        pngOutput << L"<md5>"
                            << gUnicodeConverter.ConvertIn(info.mMd5)
                            << L"</md5>\n";
                    }
                }

                // Catching errors that occurred during PNG generation:
                catch (blahtex::Exception& e)
                {
                    pngOutput.str(L"");
                    pngOutput << FormatError(e, interface.mEncodingOptions)
                        << endl;
                }

                mainOutput << L"<png>\n" << pngOutput.str() << L"</png>\n";
            }

            // This block generates MathML output if requested.
            if (doMathml)
            {
                // This stream is where we build the MathML output block:
                wostringstream mathmlOutput;

                try
                {
                    mathmlOutput << L"<markup>\n";
                    mathmlOutput << interface.GetMathml();
                    if (!interface.mIndented)
                        mathmlOutput << L"\n";
                    mathmlOutput << L"</markup>\n";
                }

                // Catch errors in generating the MathML:
                catch (blahtex::Exception& e)
                {
                    mathmlOutput.str(L"");
                    mathmlOutput
                        << FormatError(e, interface.mEncodingOptions)
                        << endl;
                }

                mainOutput << L"<mathml>\n" << mathmlOutput.str()
                    << L"</mathml>\n";
            }
        }

        // This catches input syntax errors.
        catch (blahtex::Exception& e)
        {
            mainOutput.str(L"");
            mainOutput << FormatError(e, interface.mEncodingOptions)
                << endl;
        }

        cout << "<blahtex>\n"
            << gUnicodeConverter.ConvertOut(mainOutput.str())
            << "</blahtex>\n";
    }

    // The following errors might occur if there's a bug in blahtex that
    // some assertion condition picked up. We still want to report these
    // nicely to the user so that they can notify the developers.
    catch (std::logic_error& e)
    {
        // WARNING: this doesn't XML-encode the message
        // (We don't expect to the message to contain the characters &<>)
        cout << "<blahtex>\n<logicError>" << e.what()
            << "</logicError>\n</blahtex>\n";
    }

    // These indicate incorrect command line syntax:
    catch (CommandLineException& e)
    {
        cout << "blahtex: " << e.mMessage << " (try \"blahtex --help\")\n";
    }

    // These kind of errors should only occur if the program has been
    // installed incorrectly.
    catch (std::runtime_error& e)
    {
        cout << "blahtex runtime error: " << e.what() << endl;
    }

    return 0;
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
