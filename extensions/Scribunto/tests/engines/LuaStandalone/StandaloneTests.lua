local testframework = require( 'Module:TestFramework' )

local function setfenv1()
	local ok, err = pcall( function()
		setfenv( 2, {} )
	end )
	if not ok then
		err = string.gsub( err, '^%S+:%d+: ', '' )
		error( err )
	end
end

local function getfenv1()
	local env
	pcall( function()
		env = getfenv( 2 )
	end )
	return env
end

return testframework.getTestProvider( {
	{ name = 'setfenv on a C function', func = setfenv1,
	  expect = "'setfenv' cannot set the requested environment, it is protected",
	},
	{ name = 'getfenv on a C function', func = getfenv1,
	  expect = { nil },
	},
} )
