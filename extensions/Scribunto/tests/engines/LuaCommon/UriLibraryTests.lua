local testframework = require 'Module:TestFramework'

-- Execute a function and assert expected results
-- Expected value is a list of return values, or a string error message
testframework.types.ToString = {
	format = function ( expect )
		if type( expect ) == 'string' then
			return 'ERROR: ' .. expect
		else
			return tostring( expect[1] )
		end
	end,
	exec = function ( func, args )
		local got = { pcall( func, unpack( args ) ) }
		if table.remove( got, 1 ) then
			return tostring( got[1] )
		else
			got = string.gsub( got[1], '^%S+:%d+: ', '' )
			return 'ERROR: ' .. got
		end
	end
}

-- Tests
local tests = {
	{ name = 'uri.encode', func = mw.uri.encode,
	  args = { '__foo b\195\161r + baz__' },
	  expect = { '__foo+b%C3%A1r+%2B+baz__' }
	},
	{ name = 'uri.encode QUERY', func = mw.uri.encode,
	  args = { '__foo b\195\161r + baz__', 'QUERY' },
	  expect = { '__foo+b%C3%A1r+%2B+baz__' }
	},
	{ name = 'uri.encode PATH', func = mw.uri.encode,
	  args = { '__foo b\195\161r + baz__', 'PATH' },
	  expect = { '__foo%20b%C3%A1r%20%2B%20baz__' }
	},
	{ name = 'uri.encode WIKI', func = mw.uri.encode,
	  args = { '__foo b\195\161r + baz__', 'WIKI' },
	  expect = { '__foo_b%C3%A1r_%2B_baz__' }
	},

	{ name = 'uri.decode', func = mw.uri.decode,
	  args = { '__foo+b%C3%A1r+%2B+baz__' },
	  expect = { '__foo b\195\161r + baz__' }
	},
	{ name = 'uri.decode QUERY', func = mw.uri.decode,
	  args = { '__foo+b%C3%A1r+%2B+baz__', 'QUERY' },
	  expect = { '__foo b\195\161r + baz__' }
	},
	{ name = 'uri.decode PATH', func = mw.uri.decode,
	  args = { '__foo+b%C3%A1r+%2B+baz__', 'PATH' },
	  expect = { '__foo+b\195\161r+++baz__' }
	},
	{ name = 'uri.decode WIKI', func = mw.uri.decode,
	  args = { '__foo+b%C3%A1r+%2B+baz__', 'WIKI' },
	  expect = { '  foo+b\195\161r+++baz  ' }
	},

	{ name = 'uri.anchorEncode', func = mw.uri.anchorEncode,
	  args = { '__foo b\195\161r__' },
	  expect = { 'foo_b.C3.A1r' }
	},

	{ name = 'uri.new', func = mw.uri.new,
	  args = { 'http://www.example.com/test?foo=1&bar&baz=1&baz=2#fragment' },
	  expect = {
		  {
			  protocol = 'http',
			  host = 'www.example.com',
			  path = '/test',
			  query = {
				  foo = '1',
				  bar = false,
				  baz = { '1', '2' },
			  },
			  fragment = 'fragment',
		  },
	  },
	},

	{ name = 'uri.new', func = mw.uri.new, type = 'ToString',
	  args = { 'http://www.example.com/test?foo=1&bar&baz=1&baz=2#fragment' },
	  expect = { 'http://www.example.com/test?foo=1&bar&baz=1&baz=2#fragment' },
	},

	{ name = 'uri.localUrl( Example )', func = mw.uri.localUrl, type = 'ToString',
	  args = { 'Example' },
	  expect = { '/wiki/Example' },
	},
	{ name = 'uri.localUrl( Example, string )', func = mw.uri.localUrl, type = 'ToString',
	  args = { 'Example', 'action=edit' },
	  expect = { '/w/index.php?title=Example&action=edit' },
	},
	{ name = 'uri.localUrl( Example, table )', func = mw.uri.localUrl, type = 'ToString',
	  args = { 'Example', { action = 'edit' } },
	  expect = { '/w/index.php?title=Example&action=edit' },
	},

	{ name = 'uri.fullUrl( Example )', func = mw.uri.fullUrl, type = 'ToString',
	  args = { 'Example' },
	  expect = { '//wiki.local/wiki/Example' },
	},
	{ name = 'uri.fullUrl( Example, string )', func = mw.uri.fullUrl, type = 'ToString',
	  args = { 'Example', 'action=edit' },
	  expect = { '//wiki.local/w/index.php?title=Example&action=edit' },
	},
	{ name = 'uri.fullUrl( Example, table )', func = mw.uri.fullUrl, type = 'ToString',
	  args = { 'Example', { action = 'edit' } },
	  expect = { '//wiki.local/w/index.php?title=Example&action=edit' },
	},

	{ name = 'uri.canonicalUrl( Example )', func = mw.uri.canonicalUrl, type = 'ToString',
	  args = { 'Example' },
	  expect = { 'http://wiki.local/wiki/Example' },
	},
	{ name = 'uri.canonicalUrl( Example, string )', func = mw.uri.canonicalUrl, type = 'ToString',
	  args = { 'Example', 'action=edit' },
	  expect = { 'http://wiki.local/w/index.php?title=Example&action=edit' },
	},
	{ name = 'uri.canonicalUrl( Example, table )', func = mw.uri.canonicalUrl, type = 'ToString',
	  args = { 'Example', { action = 'edit' } },
	  expect = { 'http://wiki.local/w/index.php?title=Example&action=edit' },
	},
}

-- Add tests to test round-tripping for every combination of parameters
local bits = { [0] = false, false, false, false, false, false, false, false, false }
local ct = 0
while not bits[8] do
	local url = {}
	if bits[0] then
		url[#url+1] = 'http:'
	end
	if bits[1] or bits[2] or bits[3] or bits[4] then
		url[#url+1] = '//'
	end
	if bits[1] then
		url[#url+1] = 'user'
	end
	if bits[2] then
		url[#url+1] = ':password'
	end
	if bits[1] or bits[2] then
		url[#url+1] = '@'
	end
	if bits[3] then
		url[#url+1] = 'host.example.com'
	end
	if bits[4] then
		url[#url+1] = ':123'
	end
	if bits[5] then
		url[#url+1] = '/path'
	end
	if bits[6] then
		url[#url+1] = '?query=1'
	end
	if bits[7] then
		url[#url+1] = '#fragment'
	end

	url = table.concat( url, '' )
	tests[#tests+1] = { name = 'uri.new (' .. ct .. ')', func = mw.uri.new, type = 'ToString',
	  args = { url },
	  expect = { url },
	}
	ct = ct + 1

	for i = 0, 8 do
		bits[i] = not bits[i]
		if bits[i] then
			break
		end
	end
end

return testframework.getTestProvider( tests )
