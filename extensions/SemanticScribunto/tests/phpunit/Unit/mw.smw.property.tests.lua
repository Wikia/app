--[[
	Tests for smw.property module

	@since 0.1

	@licence GNU GPL v2+
	@author mwjames
]]

local testframework = require 'Module:TestFramework'

-- Tests
local tests = {

	{ name = 'getPropertyType (empty property)', func = mw.smw.getPropertyType,
		args = { '' },
		expect = { nil }
	},
	{ name = 'getPropertyType (known property)', func = mw.smw.getPropertyType,
		args = { 'Modification date' },
		expect = { '_dat' }
	},
	{ name = 'getPropertyType (unknown property)', func = mw.smw.getPropertyType,
		args = { 'Foo' },
		expect = { '_wpg' }
	}

}

return testframework.getTestProvider( tests )