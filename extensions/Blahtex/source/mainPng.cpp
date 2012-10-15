// File "mainPng.cpp"
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

#include "BlahtexCore/Misc.h"
#include "UnicodeConverter.h"
#include "md5Wrapper.h"
#include "mainPng.h"
#include <cerrno>
#include <sys/stat.h>
#include <iostream>
#include <fstream>
#include <sstream>


using namespace std;
using namespace blahtex;


// From main.cpp:
extern UnicodeConverter gUnicodeConverter;


// TemporaryFile manages a temporary file; it deletes the named file when
// the object goes out of scope.
class TemporaryFile
{
    string mFilename;
    
    // This flag might get set to false if we are in some kind of
    // debugging mode and want to keep temp files.
    bool mShouldDelete;

public:
    TemporaryFile(
        const string& filename,
        bool shouldDelete = true
    ) :
        mFilename(filename),
        mShouldDelete(shouldDelete)
    { }

    ~TemporaryFile()
    {
        if (mShouldDelete)
            unlink(mFilename.c_str());
    }
};


// Tests whether a file exists
bool FileExists(const string& filename)
{
    struct stat temp;
    return (stat(filename.c_str(), &temp) == 0);
}


// Attempts to run given command from the given directory.
// Returns true if the system() call was successful, otherwise false.
// Can throw a "CannotChangeDirectory" exception if problems occur.
bool Execute(
    const string& command,
    const string& directory = "./"
)
{
    char buffer[5000];

    bool NeedToChange = (directory != "" && directory != "./");

    if (NeedToChange)
    {
        if (getcwd(buffer, 5000) == NULL)
            throw blahtex::Exception(L"CannotChangeDirectory");

        if (chdir(directory.c_str()) != 0)
            throw blahtex::Exception(L"CannotChangeDirectory");
    }
    
    bool result = (system(command.c_str()) == 0);

    if (NeedToChange)
    {
        if (chdir(buffer) != 0)
            throw blahtex::Exception(L"CannotChangeDirectory");
    }

    return result;
}


PngInfo MakePngFile(
    const wstring& purifiedTex,
    const string& tempDirectory,
    const string& pngDirectory,
    const string& pngFilename,
    const string& shellLatex,
    const string& shellDvipng,
    bool deleteTempFiles
)
{
    PngInfo info;
    
    string purifiedTexUtf8 = gUnicodeConverter.ConvertOut(purifiedTex);
    
    // This md5 is used for the temp filenames.
    string md5 = ComputeMd5(purifiedTexUtf8);

    string pngActualFilename =
        pngFilename.empty() ? (md5 + ".png") : pngFilename;

    // Send output to tex file.
    {
        ofstream texFile(
            (tempDirectory + md5 + ".tex").c_str(),
            ios::out | ios::binary
        );
        if (!texFile)
            throw blahtex::Exception(
                L"CannotCreateTexFile"
            );
        texFile << purifiedTexUtf8;
        if (!texFile)
            throw blahtex::Exception(
                L"CannotWriteTexFile"
            );
    }

    // These are temporary files we want deleted when we're done.
    TemporaryFile  texTemp(tempDirectory + md5 + ".tex",  deleteTempFiles);
    TemporaryFile  auxTemp(tempDirectory + md5 + ".aux",  deleteTempFiles);
    TemporaryFile  logTemp(tempDirectory + md5 + ".log",  deleteTempFiles);
    TemporaryFile  dviTemp(tempDirectory + md5 + ".dvi",  deleteTempFiles);
    TemporaryFile dataTemp(tempDirectory + md5 + ".data", deleteTempFiles);


    if (!Execute(
            shellLatex + " " + md5 + ".tex >/dev/null 2>/dev/null",
            tempDirectory
        )
        ||
        !FileExists(tempDirectory + md5 + ".dvi")
    )
        throw blahtex::Exception(L"CannotRunLatex");


    if (!Execute(
            shellDvipng + " " + md5 + ".dvi " +
                "--picky --bg Transparent --gamma 1.3 -D 120 -q -T tight " +
                "--height --depth " +
                "-o \"" + pngActualFilename +
                "\" > " + md5 + ".data 2>/dev/null", 
            tempDirectory
        )
        ||
        !FileExists(tempDirectory + pngActualFilename)
    )
        throw blahtex::Exception(L"CannotRunDvipng");
        
    if (rename(
        (tempDirectory + pngActualFilename).c_str(),
        (pngDirectory + pngActualFilename).c_str()
    ))
        throw blahtex::Exception(L"CannotWritePngDirectory");


    // Read the height and depth of the image from dvipng's output.
    {
        ifstream dataFile(
            (tempDirectory + md5 + ".data").c_str(),
            ios::in | ios::binary
        );
        
        if (dataFile)
        {
            string line, temp;
            while (getline(dataFile, line))
            {
                string::size_type heightPos = line.find("height=");
                string::size_type depthPos = line.find("depth=");
                if (heightPos != string::npos && depthPos != string::npos)
                {
                    info.mDimensionsValid = true;
                    temp = line.substr(heightPos + 7, 1000);
                    istringstream(temp) >> info.mHeight;
                    string temp = line.substr(depthPos + 6, 1000);
                    istringstream(temp) >> info.mDepth;
                }
            }
        }
    }

    info.mMd5 = md5;
    return info;
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
