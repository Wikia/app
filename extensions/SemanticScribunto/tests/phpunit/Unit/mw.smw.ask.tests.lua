--[[
	Tests for smw.info module

	@since 1.0

	@licence GNU GPL v2+
	@author Tobias Oetterer
]]

local testframework = require 'Module:TestFramework'

-- Tests
local tests = {
	{ name = 'ask (nil argument)', func = mw.smw.ask,
		args = { nil },
		expect = { nil }
	},
	{ name = 'ask (no argument)', func = mw.smw.ask,
		args = { '' },
		expect = { nil }
	},
	{ name = 'ask (limit 0)', func = mw.smw.ask,
		args = { { '[[Modification date::+]]', '?Modification date', limit = 0, mainlabel = 'main' } },
		expect = { nil }
	},
	{ name = 'ask (invalid query)', func = mw.smw.ask,
		args = { { '?Modification date', limit = 0, mainlabel = 'main' } },
		expect = { nil }
	},
}

return testframework.getTestProvider( tests )
