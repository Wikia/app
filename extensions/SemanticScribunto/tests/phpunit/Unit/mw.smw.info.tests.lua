--[[
	Tests for smw.info module

	@since 1.0

	@licence GNU GPL v2+
	@author Tobias Oetterer
]]

local testframework = require 'Module:TestFramework'

-- Tests
local tests = {
	{ name = 'info (no argument)', func = mw.smw.info,
		args = { '' },
		expect = { nil }
	},
	{ name = 'info (text, no icon)',
		func = function ( args )
			local ret = mw.smw.info( args )
			return type(ret), #ret > 0
		end,
		args = { 'Infotext' },
		expect = { 'string', true }
	},
	{ name = 'info (text, valid icon)',
		func = function ( args )
			local ret = mw.smw.info( args )
			return type(ret), #ret > 0
		end,
		args = { 'Infotext', 'note' },
		expect = { 'string', true }
	},
	{ name = 'info (text, invalid icon)',
		func = function ( args )
			local ret = mw.smw.info( args )
			return type(ret), #ret > 0
		end,
		args = { 'Infotext', 'test' },
		expect = { 'string', true }
	}
}

return testframework.getTestProvider( tests )
