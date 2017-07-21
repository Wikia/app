--[[
	Tests for functions in smw module

	@since 1.0

	@licence GNU GPL v2+
	@author Tobias Oetterer
]]

local testframework = require 'Module:TestFramework'

-- Tests
local tests = {
	{
		name = 'check package load',
		func = function ( args )
			return package.loaded['mw.smw'] == mw.smw
			end,
		args = {},
		expect = { true }
	},
	{
		name = 'check bindings',
		func = function ( args )
				return type( mw.smw )
			end,
		args = {},
		expect = { 'table' }
	},
	{
		name = 'ask function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'ask' },
		expect = { 'function', true }
	},
	{
		name = 'getPropertyType function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'getPropertyType' },
		expect = { 'function', true }
	},
	{
		name = 'getQueryResult function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'getQueryResult' },
		expect = { 'function', true }
	},
	{
		name = 'info function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'info' },
		expect = { 'function', true }
	},
	{
		name = 'set function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'set' },
		expect = { 'function', true }
	},
	{
		name = 'subobject function registered and callable',
		func = function ( args )
			local result, returnVal =  pcall( mw.smw[args], '' )
			if result then
				return type( mw.smw[args] ), result
			else
				return type( mw.smw[args] ), result, returnVal
			end
		end,
		args = { 'subobject' },
		expect = { 'function', true }
	},
}

return testframework.getTestProvider( tests )
