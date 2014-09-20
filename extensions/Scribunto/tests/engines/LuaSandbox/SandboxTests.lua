local testframework = require( 'Module:TestFramework' )

local function setfenv1()
	setfenv( 5, {} )
end

local function getfenv1()
	assert( getfenv( 5 ) == nil )
end

return testframework.getTestProvider( {
	{ name = 'setfenv invalid level', func = setfenv1,
	  expect = "bad argument #1 to 'old_getfenv' (invalid level)",
	},
	{ name = 'getfenv invalid level', func = getfenv1,
	  expect = "bad argument #1 to 'old_getfenv' (invalid level)",
	},
} )
