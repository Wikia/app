// File "md5Wrapper.cpp"
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

#include "md5.h"
#include <sstream>
#include <iomanip>

using namespace std;

string ComputeMd5(const string& input)
{
    md5_state_s state;
    unsigned char buf[16];

    md5_init(&state);

    md5_append(
        &state,
        reinterpret_cast<const md5_byte_t*>(input.c_str()),
        input.size()
    );

    md5_finish(
        &state,
        reinterpret_cast<md5_byte_t*>(buf)
    );

    ostringstream result;
    result << hex << setfill('0');
    for (int i = 0; i < 16; i++)
        result << setw(2) << static_cast<unsigned int>(buf[i]);

    return result.str();
}

// end of file @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
