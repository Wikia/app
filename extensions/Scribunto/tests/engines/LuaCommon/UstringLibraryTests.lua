local testframework = require 'Module:TestFramework'

local str1 = "\0\127\194\128\223\191\224\160\128\239\191\191\240\144\128\128\244\143\191\191"
local str2 = "foo bar főó foó baz foooo foofoo fo"
local str3 = "??? foo bar főó foó baz foooo foofoo fo ok?"

return testframework.getTestProvider( {
	{ name = 'isutf8: valid string', func = mw.ustring.isutf8,
	  args = { "\0 \127 \194\128 \223\191 \224\160\128 \239\191\191 \240\144\128\128 \244\143\191\191" },
	  expect = { true }
	},
	{ name = 'isutf8: out of range character', func = mw.ustring.isutf8,
	  args = { "\244\144\128\128" },
	  expect = { false }
	},
	{ name = 'isutf8: insufficient continuation bytes', func = mw.ustring.isutf8,
	  args = { "\240\128\128" },
	  expect = { false }
	},
	{ name = 'isutf8: excess continuation bytes', func = mw.ustring.isutf8,
	  args = { "\194\128\128" },
	  expect = { false }
	},
	{ name = 'isutf8: bare continuation byte', func = mw.ustring.isutf8,
	  args = { "\128" },
	  expect = { false }
	},
	{ name = 'isutf8: overlong encoding', func = mw.ustring.isutf8,
	  args = { "\192\128" },
	  expect = { false }
	},
	{ name = 'isutf8: overlong encoding (2)', func = mw.ustring.isutf8,
	  args = { "\193\191" },
	  expect = { false }
	},

	{ name = 'byteoffset: (1)', func = mw.ustring.byteoffset,
	  args = { "fóo", 1 },
	  expect = { 1 }
	},
	{ name = 'byteoffset: (2)', func = mw.ustring.byteoffset,
	  args = { "fóo", 2 },
	  expect = { 2 }
	},
	{ name = 'byteoffset: (3)', func = mw.ustring.byteoffset,
	  args = { "fóo", 3 },
	  expect = { 4 }
	},
	{ name = 'byteoffset: (4)', func = mw.ustring.byteoffset,
	  args = { "fóo", 4 },
	  expect = { nil }
	},
	{ name = 'byteoffset: (0,1)', func = mw.ustring.byteoffset,
	  args = { "fóo", 0, 1 },
	  expect = { 1 }
	},
	{ name = 'byteoffset: (0,2)', func = mw.ustring.byteoffset,
	  args = { "fóo", 0, 2 },
	  expect = { 2 }
	},
	{ name = 'byteoffset: (0,3)', func = mw.ustring.byteoffset,
	  args = { "fóo", 0, 3 },
	  expect = { 2 }
	},
	{ name = 'byteoffset: (0,4)', func = mw.ustring.byteoffset,
	  args = { "fóo", 0, 4 },
	  expect = { 4 }
	},
	{ name = 'byteoffset: (0,5)', func = mw.ustring.byteoffset,
	  args = { "fóo", 0, 5 },
	  expect = { nil }
	},

	{ name = 'codepoint: whole string', func = mw.ustring.codepoint,
	  args = { str1, 1, -1 },
	  expect = { 0, 0x7f, 0x80, 0x7ff, 0x800, 0xffff, 0x10000, 0x10ffff }
	},

	{ name = 'codepoint: substring', func = mw.ustring.codepoint,
	  args = { str1, 5, -2 },
	  expect = { 0x800, 0xffff, 0x10000 }
	},

	{ name = 'char: basic test', func = mw.ustring.char,
	  args = { 0, 0x7f, 0x80, 0x7ff, 0x800, 0xffff, 0x10000, 0x10ffff },
	  expect = { str1 }
	},
	{ name = 'char: invalid codepoint', func = mw.ustring.char,
	  args = { 0x110000 },
	  expect = "bad argument #1 to 'char' (value out of range)"
	},
	{ name = 'char: invalid value', func = mw.ustring.char,
	  args = { 'foo' },
	  expect = "bad argument #1 to 'char' (number expected, got string)"
	},

	{ name = 'len: basic test', func = mw.ustring.len,
	  args = { str1 },
	  expect = { 8 }
	},
	{ name = 'len: invalid string', func = mw.ustring.len,
	  args = { "\244\144\128\128" },
	  expect = { nil }
	},

	{ name = 'sub: (4)', func = mw.ustring.sub,
	  args = { str1, 4 },
	  expect = { "\223\191\224\160\128\239\191\191\240\144\128\128\244\143\191\191" }
	},
	{ name = 'sub: (4,7)', func = mw.ustring.sub,
	  args = { str1, 4, 7 },
	  expect = { "\223\191\224\160\128\239\191\191\240\144\128\128" }
	},
	{ name = 'sub: (4,-1)', func = mw.ustring.sub,
	  args = { str1, 4, -1 },
	  expect = { "\223\191\224\160\128\239\191\191\240\144\128\128\244\143\191\191" }
	},
	{ name = 'sub: (4,-2)', func = mw.ustring.sub,
	  args = { str1, 4, -2 },
	  expect = { "\223\191\224\160\128\239\191\191\240\144\128\128" }
	},
	{ name = 'sub: (-2)', func = mw.ustring.sub,
	  args = { str1, -2 },
	  expect = { "\240\144\128\128\244\143\191\191" }
	},
	{ name = 'sub: (9)', func = mw.ustring.sub,
	  args = { str1, 9 },
	  expect = { "" }
	},
	{ name = 'sub: (0)', func = mw.ustring.sub,
	  args = { str1, 0 },
	  expect = { str1 }
	},
	{ name = 'sub: (4,3)', func = mw.ustring.sub,
	  args = { str1, 4, 3 },
	  expect = { "" }
	},
	{ name = 'sub: (5,5)', func = mw.ustring.sub,
	  args = { str1, 5, 5 },
	  expect = { "\224\160\128" }
	},

	{ name = 'upper: basic test', func = mw.ustring.upper,
	  args = { "fóó?" },
	  expect = { "FÓÓ?" }
	},
	{ name = 'lower: basic test', func = mw.ustring.lower,
	  args = { "FÓÓ?" },
	  expect = { "fóó?" }
	},

	{ name = 'find: (simple)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡foo' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (%)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fo%+' },
	  expect = { }
	},
	{ name = 'find: (%)', func = mw.ustring.find,
	  args = { "bar ¡fo+ bar", '¡fo%+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (+)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fo+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (+) (2)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fx+o+' },
	  expect = {}
	},
	{ name = 'find: (?)', func = mw.ustring.find,
	  args = { "bar ¡foox bar", '¡foox?' },
	  expect = { 5, 9 }
	},
	{ name = 'find: (?) (2)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡foox?' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (*)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fx*oo' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (-)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fo-' },
	  expect = { 5, 6 }
	},
	{ name = 'find: (-)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡fo-o' },
	  expect = { 5, 7 }
	},
	{ name = 'find: (-)', func = mw.ustring.find,
	  args = { "bar ¡foox bar", '¡fo-x' },
	  expect = { 5, 9 }
	},
	{ name = 'find: (%a)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '¡f%a' },
	  expect = { 5, 7 }
	},
	{ name = 'find: (%a, utf8)', func = mw.ustring.find,
	  args = { "bar ¡fóó bar", '¡f%a' },
	  expect = { 5, 7 }
	},
	{ name = 'find: (%a, utf8 2)', func = mw.ustring.find,
	  args = { "bar ¡fóó bar", 'f%a' },
	  expect = { 6, 7 }
	},
	{ name = 'find: (%a+)', func = mw.ustring.find,
	  args = { "bar ¡fóó bar", '¡f%a+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: ([]+)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '¡f[oó]+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: ([-]+)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '¡f[a-uá-ú]+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: ([-]+ 2)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '¡f[a-ú]+' },
	  expect = { 5, 8 }
	},
	{ name = 'find: (%b)', func = mw.ustring.find,
	  args = { "bar ¡<foo <foo> foo> bar", '¡%b<>' },
	  expect = { 5, 20 }
	},
	{ name = 'find: (%b 2)', func = mw.ustring.find,
	  args = { "bar ¡(foo (foo) foo) bar", '¡%b()' },
	  expect = { 5, 20 }
	},
	{ name = 'find: (%b 3)', func = mw.ustring.find,
	  args = { "bar ¡-foo-foo- bar", '¡%b--' },
	  expect = { 5, 10 }
	},
	{ name = 'find: (%b 4)', func = mw.ustring.find,
	  args = { "bar «foo «foo» foo» bar", '%b«»' },
	  expect = { 5, 19 }
	},
	{ name = 'find: (%b 5)', func = mw.ustring.find,
	  args = { "bar !foo !foo¡ foo¡ bar", '%b!¡' },
	  expect = { 5, 19 }
	},
	{ name = 'find: (%b 6)', func = mw.ustring.find,
	  args = { "bar ¡foo ¡foo! foo! bar", '%b¡!' },
	  expect = { 5, 19 }
	},
	{ name = 'find: (%b 7)', func = mw.ustring.find,
	  args = { "bar ¡foo¡foo¡ bar", '%b¡¡' },
	  expect = { 5, 9 }
	},
	{ name = 'find: (%A)', func = mw.ustring.find,
	  args = { "fóó? bar", '%A+' },
	  expect = { 4, 5 }
	},
	{ name = 'find: ([^])', func = mw.ustring.find,
	  args = { "fóó? bar", '[^a-zó]+' },
	  expect = { 4, 5 }
	},
	{ name = 'find: ([^] 2)', func = mw.ustring.find,
	  args = { "fó0? bar", '[^%a0-9]+' },
	  expect = { 4, 5 }
	},
	{ name = 'find: ([^] 3)', func = mw.ustring.find,
	  args = { "¡fó0% bar", '¡[^%%]+' },
	  expect = { 1, 4 }
	},
	{ name = 'find: ($)', func = mw.ustring.find,
	  args = { "¡foo1 ¡foo2 ¡foo3", '¡foo[0-9]+$' },
	  expect = { 13, 17 }
	},
	{ name = 'find: (.*)', func = mw.ustring.find,
	  args = { "¡foo¡ ¡bar¡ baz", '¡.*¡' },
	  expect = { 1, 11 }
	},
	{ name = 'find: (.-)', func = mw.ustring.find,
	  args = { "¡foo¡ ¡bar¡ baz", '¡.-¡' },
	  expect = { 1, 5 }
	},

	{ name = 'find: capture (1)', func = mw.ustring.find,
	  args = { "bar ¡foo bar", '(¡foo)' },
	  expect = { 5, 8, '¡foo' }
	},
	{ name = 'find: capture (2)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '(¡f%a+)' },
	  expect = { 5, 8, '¡fóo' }
	},
	{ name = 'find: capture (3)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '(¡f(%a)%a)' },
	  expect = { 5, 8, '¡fóo', 'ó' }
	},
	{ name = 'find: capture (4)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '(¡f(%a-)%a)' },
	  expect = { 5, 7, '¡fó', '' }
	},
	{ name = 'find: capture (5)', func = mw.ustring.find,
	  args = { "bar ¡fóo bar", '()(()¡f()(%a)()%a())()' },
	  expect = { 5, 8, 5, '¡fóo', 5, 7, 'ó', 8, 9, 9 }
	},
	{ name = 'find: capture (6)', func = mw.ustring.find,
	  args = { "fóó", "()(f)()(óó)()" },
	  expect = { 1, 3, 1, 'f', 2, 'óó', 4 }
	},
	{ name = 'find: capture (7)', func = mw.ustring.find,
	  args = { "fóó fóó", "()(f)()(óó)()", 2 },
	  expect = { 5, 7, 5, 'f', 6, 'óó', 8 }
	},
	{ name = 'find: (%1)', func = mw.ustring.find,
	  args = { "foo foofóó foófoó bar", '(f%a+)%1' },
	  expect = { 12, 17, 'foó' }
	},

	{ name = 'match: (1)', func = mw.ustring.match,
	  args = { "bar fóo bar", 'f%a+' },
	  expect = { 'fóo' }
	},
	{ name = 'match: (2)', func = mw.ustring.match,
	  args = { "bar fóo bar", 'f(%a+)' },
	  expect = { 'óo' }
	},

	{ name = 'gsub: (string 1)', func = mw.ustring.gsub,
	  args = { str2, 'f%a+', 'X' },
	  expect = { 'X bar X X baz X X X', 6 }
	},
	{ name = 'gsub: (string 2)', func = mw.ustring.gsub,
	  args = { str3, 'f%a+', 'X' },
	  expect = { '??? X bar X X baz X X X ok?', 6 }
	},
	{ name = 'gsub: (string 3)', func = mw.ustring.gsub,
	  args = { str2, 'f%a+', 'X', 3 },
	  expect = { 'X bar X X baz foooo foofoo fo', 3 }
	},
	{ name = 'gsub: (string 4)', func = mw.ustring.gsub,
	  args = { str3, 'f%a+', 'X', 3 },
	  expect = { '??? X bar X X baz foooo foofoo fo ok?', 3 }
	},
	{ name = 'gsub: (string 5)', func = mw.ustring.gsub,
	  args = { 'foo; fóó', '(f)(%a+)', '%%0=%0 %%1=%1 %%2=%2' },
	  expect = { '%0=foo %1=f %2=oo; %0=fóó %1=f %2=óó', 2 }
	},
	{ name = 'gsub: (anchored)', func = mw.ustring.gsub,
	  args = { 'foofoofoo foo', '^foo', 'X' },
	  expect = { 'Xfoofoo foo', 1 }
	},
	{ name = 'gsub: (table 1)', func = mw.ustring.gsub,
	  args = { str2, 'f%a+', { foo = 'X', ['főó'] = 'Y', ['foó'] = 'Z' } },
	  expect = { 'X bar Y Z baz foooo foofoo fo', 6 }
	},
	{ name = 'gsub: (table 2)', func = mw.ustring.gsub,
	  args = { str3, 'f%a+', { foo = 'X', ['főó'] = 'Y', ['foó'] = 'Z' } },
	  expect = { '??? X bar Y Z baz foooo foofoo fo ok?', 6 }
	},
	{ name = 'gsub: (table 3)', func = mw.ustring.gsub,
	  args = { str2, 'f%a+', { ['főó'] = 'Y', ['foó'] = 'Z' }, 1 },
	  expect = { str2, 1 }
	},
	{ name = 'gsub: (function 1)', func = mw.ustring.gsub,
	  args = { str2, 'f%a+', function(m) if m == 'fo' then return nil end return '-' .. mw.ustring.upper(m) .. '-' end },
	  expect = { '-FOO- bar -FŐÓ- -FOÓ- baz -FOOOO- -FOOFOO- fo', 6 }
	},
	{ name = 'gsub: (function 2)', func = mw.ustring.gsub,
	  args = { str3, 'f%a+', function(m) if m == 'fo' then return nil end return '-' .. mw.ustring.upper(m) .. '-' end },
	  expect = { '??? -FOO- bar -FŐÓ- -FOÓ- baz -FOOOO- -FOOFOO- fo ok?', 6 }
	},
	{ name = 'gsub: invalid replacement string', func = mw.ustring.gsub,
	  args = { 'foo; fóó', '(%a+)', '%2' },
	  expect = "invalid capture index %2 in replacement string"
	},

	{ name = 'gcodepoint: basic test', func = mw.ustring.gcodepoint,
	  args = { str1 },
	  expect = { { 0 }, { 0x7f }, { 0x80 }, { 0x7ff }, { 0x800 }, { 0xffff }, { 0x10000 }, { 0x10ffff } },
	  type = 'Iterator'
	},
	{ name = 'gcodepoint: (4)', func = mw.ustring.gcodepoint,
	  args = { str1, 4 },
	  expect = { { 0x7ff }, { 0x800 }, { 0xffff }, { 0x10000 }, { 0x10ffff } },
	  type = 'Iterator'
	},
	{ name = 'gcodepoint: (4, -2)', func = mw.ustring.gcodepoint,
	  args = { str1, 4, -2 },
	  expect = { { 0x7ff }, { 0x800 }, { 0xffff }, { 0x10000 } },
	  type = 'Iterator'
	},

	{ name = 'gmatch: test string 1', func = mw.ustring.gmatch,
	  args = { str2, 'f%a+' },
	  expect = { { 'foo' }, { 'főó' }, { 'foó' }, { 'foooo' }, { 'foofoo' }, { 'fo' } },
	  type = 'Iterator'
	},
	{ name = 'gmatch: test string 2', func = mw.ustring.gmatch,
	  args = { str3, 'f%a+' },
	  expect = { { 'foo' }, { 'főó' }, { 'foó' }, { 'foooo' }, { 'foofoo' }, { 'fo' } },
	  type = 'Iterator'
	},
	{ name = 'gmatch: anchored', func = mw.ustring.gmatch,
	  args = { "fóó1 ^fóó2 fóó3 ^fóó4", '^fóó%d+' },
	  expect = { { "^fóó2" }, { "^fóó4" } },
	  type = 'Iterator'
	},

	{ name = 'string length limit',
	  func = function ()
		  local s = string.rep( "x", mw.ustring.maxStringLength + 1 )
		  local ret = { mw.ustring.gsub( s, 'a', 'b' ) }
		  -- So the output isn't insanely long
		  ret[1] = string.gsub( ret[1], 'xxxxx(x*)', function ( m )
			  return 'xxxxx[snip ' .. #m .. ' more]'
		  end )
		  return unpack( ret )
	  end,
	  expect = "bad argument #1 to 'gsub' (string is longer than " .. mw.ustring.maxStringLength .. " bytes)"
	},
	{ name = 'pattern length limit',
	  func = function ()
		  local pattern = string.rep( "x", mw.ustring.maxPatternLength + 1 )
		  return mw.ustring.gsub( 'a', pattern, 'b' )
	  end,
	  expect = "bad argument #2 to 'gsub' (pattern is longer than " .. mw.ustring.maxPatternLength .. " bytes)"
	},
} )
