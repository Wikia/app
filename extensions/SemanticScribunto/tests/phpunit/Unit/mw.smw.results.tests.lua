--[[
	Tests for mw.smw module

	@since 0.1

	@licence GNU GPL v2+
	@author mwjames
]]

local testframework = require 'Module:TestFramework'

-- Tests
local tests = {
	--getQueryResult
	{ name = 'getQueryResult (empty query)',
		func = function ( args )
		  local ret = mw.smw.getQueryResult( args )
		  return ret.meta.count
		end,
		args = { '' },
		expect = { 0 }
	},
	{ name = 'getQueryResult (meta count)',
		func = function ( args )
		  local ret =  mw.smw.getQueryResult( args )
		  for k,v in pairs(ret.printrequests ) do
		      return v.label
	  	  end
		end,
		args = { '[[Modification date::+]]|?Modification date|limit=0|mainlabel=-' },
		expect = { 'Modification date' }
	}
}

return testframework.getTestProvider( tests )
