local testframework = require 'Module:TestFramework'

-- Force the argument list to be ordered
local tagattrs = { absent = false, present = true, key = 'value', n = 42 }
setmetatable( tagattrs, { __pairs = function ( t )
	local keys = { 'absent', 'present', 'key', 'n' }
	local i = 0
	return function()
		i = i + 1
		if i <= #keys then
			return keys[i], t[keys[i]]
		end
	end
end } )

-- For data provider, make sure this is defined
mw.text.stripTest = mw.text.stripTest or { nowiki = '!!!', general = '!!!' }

-- Can't directly expect the value from mw.text.stripTest, because when
-- 'expect' is processed by the data provider it's the dummy entry above.
local function stripTest( func, marker )
	local result = func( marker )
	if result == marker then
		result = 'strip-marker'
	end
	return result
end

-- Tests
local tests = {
	{ name = 'trim',
	  func = mw.text.trim, args = { '  foo bar  ' },
	  expect = { 'foo bar' }
	},
	{ name = 'trim right',
	  func = mw.text.trim, args = { 'foo bar  ' },
	  expect = { 'foo bar' }
	},
	{ name = 'trim left',
	  func = mw.text.trim, args = { '  foo bar' },
	  expect = { 'foo bar' }
	},
	{ name = 'trim none',
	  func = mw.text.trim, args = { 'foo bar' },
	  expect = { 'foo bar' }
	},
	{ name = 'trim charset',
	  func = mw.text.trim, args = { 'xxx foo bar xxx', 'x' },
	  expect = { ' foo bar ' }
	},

	{ name = 'encode',
	  func = mw.text.encode, args = { '<b>foo "bar"</b> & \'baz\'' },
	  expect = { '&lt;b&gt;foo &quot;bar&quot;&lt;/b&gt; &amp; &#039;baz&#039;' }
	},
	{ name = 'encode charset',
	  func = mw.text.encode, args = { '<b>foo "bar"</b> & \'baz\'', 'aeiou' },
	  expect = { '<b>f&#111;&#111; "b&#97;r"</b> & \'b&#97;z\'' }
	},

	{ name = 'decode',
	  func = mw.text.decode,
	  args = { '&lt;&gt;&amp;&quot; &#102;&#111;&#x6f; &#x0066;&#00111;&#x6F; &hearts; &amp;quot;' },
	  expect = { '<>&" foo foo &hearts; &quot;' }
	},
	{ name = 'decode named',
	  func = mw.text.decode,
	  args = { '&lt;&gt;&amp;&quot; &#102;&#111;&#x6f; &#x0066;&#00111;&#x6F; &hearts; &amp;quot;', true },
	  expect = { '<>&" foo foo ♥ &quot;' }
	},

	{ name = 'nowiki',
	  func = mw.text.nowiki,
	  args = { '*"&\'<=>[]{|}#*:;\n*\n#\n:\n;\nhttp://example.com:80/\nRFC 123, ISBN 456' },
	  expect = {
		  '&#42;&#34;&#38;&#39;&#60;&#61;&#62;&#91;&#93;&#123;&#124;&#125;#*:;' ..
		  '\n&#42;\n&#35;\n&#58;\n&#59;\nhttp&#58;//example.com:80/' ..
		  '\nRFC&#32;123, ISBN&#32;456'
	  }
	},

	{ name = 'tag, simple',
	  func = mw.text.tag,
	  args = { { name = 'b' } },
	  expect = { '<b>' }
	},
	{ name = 'tag, simple with content',
	  func = mw.text.tag,
	  args = { { name = 'b', content = 'foo' } },
	  expect = { '<b>foo</b>' }
	},
	{ name = 'tag, simple self-closing',
	  func = mw.text.tag,
	  args = { { name = 'br', content = false } },
	  expect = { '<br />' }
	},
	{ name = 'tag, args',
	  func = mw.text.tag,
	  args = { { name = 'b', attrs = tagattrs } },
	  expect = { '<b present key="value" n="42">' }
	},
	{ name = 'tag, args with content',
	  func = mw.text.tag,
	  args = { { name = 'b', attrs = tagattrs, content = 'foo' } },
	  expect = { '<b present key="value" n="42">foo</b>' }
	},
	{ name = 'tag, args self-closing',
	  func = mw.text.tag,
	  args = { { name = 'br', attrs = tagattrs, content = false } },
	  expect = { '<br present key="value" n="42" />' }
	},
	{ name = 'tag, args, positional params',
	  func = mw.text.tag,
	  args = { 'b', tagattrs },
	  expect = { '<b present key="value" n="42">' }
	},
	{ name = 'tag, args with content, positional params',
	  func = mw.text.tag,
	  args = { 'b', tagattrs, 'foo' },
	  expect = { '<b present key="value" n="42">foo</b>' }
	},

	{ name = 'unstrip (nowiki)',
	  func = stripTest,
	  args = { mw.text.unstrip, mw.text.stripTest.nowiki },
	  expect = { 'NoWiki' }
	},
	{ name = 'unstrip (general)',
	  func = stripTest,
	  args = { mw.text.unstrip, mw.text.stripTest.general },
	  expect = { '' }
	},

	{ name = 'unstripNoWiki (nowiki)',
	  func = stripTest,
	  args = { mw.text.unstripNoWiki, mw.text.stripTest.nowiki },
	  expect = { 'NoWiki' }
	},
	{ name = 'unstripNoWiki (general)',
	  func = stripTest,
	  args = { mw.text.unstripNoWiki, mw.text.stripTest.general },
	  expect = { 'strip-marker' }
	},

	{ name = 'killMarkers',
	  func = mw.text.killMarkers,
	  args = { 'a' .. mw.text.stripTest.nowiki .. 'b' .. mw.text.stripTest.general .. 'c' },
	  expect = { 'abc' }
	},

	{ name = 'split, simple',
	  func = mw.text.split, args = { 'a,b,c,d', ',' },
	  expect = { { 'a', 'b', 'c', 'd' } }
	},
	{ name = 'split, no separator',
	  func = mw.text.split, args = { 'xxx', ',' },
	  expect = { { 'xxx' } }
	},
	{ name = 'split, empty string',
	  func = mw.text.split, args = { '', ',' },
	  expect = { { '' } }
	},
	{ name = 'split, with empty items',
	  func = mw.text.split, args = { ',,', ',' },
	  expect = { { '', '', '' } }
	},
	{ name = 'split, with empty items (1)',
	  func = mw.text.split, args = { 'x,,', ',' },
	  expect = { { 'x', '', '' } }
	},
	{ name = 'split, with empty items (2)',
	  func = mw.text.split, args = { ',x,', ',' },
	  expect = { { '', 'x', '' } }
	},
	{ name = 'split, with empty items (3)',
	  func = mw.text.split, args = { ',,x', ',' },
	  expect = { { '', '', 'x' } }
	},
	{ name = 'split, with empty items (4)',
	  func = mw.text.split, args = { ',x,x', ',' },
	  expect = { { '', 'x', 'x' } }
	},
	{ name = 'split, with empty items (5)',
	  func = mw.text.split, args = { 'x,,x', ',' },
	  expect = { { 'x', '', 'x' } }
	},
	{ name = 'split, with empty items (7)',
	  func = mw.text.split, args = { 'x,x,', ',' },
	  expect = { { 'x', 'x', '' } }
	},
	{ name = 'split, with empty pattern',
	  func = mw.text.split, args = { 'xxx', '' },
	  expect = { { 'x', 'x', 'x' } }
	},
	{ name = 'split, with empty pattern (2)',
	  func = mw.text.split, args = { 'xxx', ',?' },
	  expect = { { 'x', 'x', 'x' } }
	},

	{ name = 'listToText (0)',
	  func = mw.text.listToText, args = { {} },
	  expect = { '' }
	},
	{ name = 'listToText (1)',
	  func = mw.text.listToText, args = { { 1 } },
	  expect = { '1' }
	},
	{ name = 'listToText (2)',
	  func = mw.text.listToText, args = { { 1, 2 } },
	  expect = { '1 and 2' }
	},
	{ name = 'listToText (3)',
	  func = mw.text.listToText, args = { { 1, 2, 3 } },
	  expect = { '1, 2 and 3' }
	},
	{ name = 'listToText (4)',
	  func = mw.text.listToText, args = { { 1, 2, 3, 4 } },
	  expect = { '1, 2, 3 and 4' }
	},
	{ name = 'listToText, alternate separator',
	  func = mw.text.listToText, args = { { 1, 2, 3, 4 }, '; ' },
	  expect = { '1; 2; 3 and 4' }
	},
	{ name = 'listToText, alternate conjunction',
	  func = mw.text.listToText, args = { { 1, 2, 3, 4 }, nil, ' or ' },
	  expect = { '1, 2, 3 or 4' }
	},

	{ name = 'truncate, no truncation',
	  func = mw.text.truncate, args = { 'foobarbaz', 9 },
	  expect = { 'foobarbaz' }
	},
	{ name = 'truncate, no truncation (2)',
	  func = mw.text.truncate, args = { 'foobarbaz', -9 },
	  expect = { 'foobarbaz' }
	},
	{ name = 'truncate, tail truncation',
	  func = mw.text.truncate, args = { 'foobarbaz', 3 },
	  expect = { 'foo...' }
	},
	{ name = 'truncate, head truncation',
	  func = mw.text.truncate, args = { 'foobarbaz', -3 },
	  expect = { '...baz' }
	},
	{ name = 'truncate, avoid silly truncation',
	  func = mw.text.truncate, args = { 'foobarbaz', 8 },
	  expect = { 'foobarbaz' }
	},
	{ name = 'truncate, avoid silly truncation (2)',
	  func = mw.text.truncate, args = { 'foobarbaz', 6 },
	  expect = { 'foobarbaz' }
	},
	{ name = 'truncate, alternate ellipsis',
	  func = mw.text.truncate, args = { 'foobarbaz', 3, '!' },
	  expect = { 'foo!' }
	},
	{ name = 'truncate, with adjusted length',
	  func = mw.text.truncate, args = { 'foobarbaz', 6, nil, true },
	  expect = { 'foo...' }
	},
	{ name = 'truncate, with adjusted length (2)',
	  func = mw.text.truncate, args = { 'foobarbaz', -6, nil, true },
	  expect = { '...baz' }
	},
	{ name = 'truncate, ridiculously short',
	  func = mw.text.truncate, args = { 'foobarbaz', 1, nil, true },
	  expect = { '...' }
	},
	{ name = 'truncate, ridiculously short (2)',
	  func = mw.text.truncate, args = { 'foobarbaz', -1, nil, true },
	  expect = { '...' }
	},
}

return testframework.getTestProvider( tests )
