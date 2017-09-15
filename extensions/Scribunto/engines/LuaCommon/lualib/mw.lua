mw = mw or {}

local packageCache
local packageModuleFunc
local php
local allowEnvFuncs = false
local logBuffer = ''
local currentFrame
local loadedData = {}

-- Extend pairs and ipairs to recognize __pairs and __ipairs, if they don't already
( function ()
	local t = {}
	setmetatable( t, { __pairs = function() return 1, 2, 3 end } )
	local f = pairs( t )
	if f ~= 1 then
		local old_pairs = pairs
		pairs = function ( t )
			local mt = getmetatable( t )
			local f, s, var = ( mt and mt.__pairs or old_pairs )( t )
			return f, s, var
		end
		local old_ipairs = ipairs
		ipairs = function ( t )
			local mt = getmetatable( t )
			local f, s, var = ( mt and mt.__ipairs or old_ipairs )( t )
			return f, s, var
		end
	end
end )()

--- Put an isolation-friendly package module into the specified environment 
-- table. The package module will have an empty cache, because caching of 
-- module functions from other cloned environments would break module isolation.
-- 
-- @param env The cloned environment
local function makePackageModule( env )
	-- Create the package globals in the given environment
	setfenv( packageModuleFunc, env )()

	-- Make a loader function
	local function loadPackage( modName )
		local init
		if packageCache[modName] == 'missing' then
			return nil
		elseif packageCache[modName] == nil then
			init = php.loadPackage( modName )
			if init == nil then
				packageCache[modName] = 'missing'
				return nil
			end
			packageCache[modName] = init
		else
			init = packageCache[modName]
		end

		setfenv( init, env )
		return init
	end

	table.insert( env.package.loaders, loadPackage )
end

--- Set up the base environment. The PHP host calls this function after any 
-- necessary host-side initialisation has been done.
function mw.setupInterface( options )
	-- Don't allow any more calls
	mw.setupInterface = nil

	-- Don't allow getmetatable() on a non-table, since if you can get the metatable,
	-- you can set values in it, breaking isolation
	local old_getmetatable = getmetatable
	function getmetatable(obj)
		if type(obj) == 'table' then
			return old_getmetatable(obj)
		else
			return nil
		end
	end

	if options.allowEnvFuncs then
		allowEnvFuncs = true
	end

	-- Store the interface table
	--
	-- mw_interface.loadPackage() returns function values with their environment
	-- set to the base environment, which would violate module isolation if they
	-- were run from a cloned environment. We can only allow access to 
	-- mw_interface.loadPackage via our environment-setting wrapper.
	--
	php = mw_interface
	mw_interface = nil

	packageModuleFunc = php.loadPackage( 'package' )
	makePackageModule( _G )
	package.loaded.mw = mw
	packageCache = {}
end

--- Do a "deep copy" of a table or other value.
function mw.clone( val )
	local tableRefs = {}
	local function recursiveClone( val )
		if type( val ) == 'table' then
			-- Encode circular references correctly
			if tableRefs[val] ~= nil then
				return tableRefs[val]
			end

			local retVal
			retVal = {}
			tableRefs[val] = retVal

			-- Copy metatable
			if getmetatable( val ) then
				setmetatable( retVal, recursiveClone( getmetatable( val ) ) )
			end

			for key, elt in pairs( val ) do
				retVal[key] = recursiveClone( elt )
			end
			return retVal
		else
			return val
		end
	end
	return recursiveClone( val )
end

--- Set up a cloned environment for execution of a module chunk, then execute
-- the module in that environment. This is called by the host to implement 
-- {{#invoke}}.
--
-- @param chunk The module chunk
function mw.executeModule( chunk )
	local env = mw.clone( _G )
	makePackageModule( env )

	-- This is unsafe
	env.mw.makeProtectedEnvFuncs = nil

	if allowEnvFuncs then
		env.setfenv, env.getfenv = mw.makeProtectedEnvFuncs( {[_G] = true}, {} )
	else
		env.setfenv = nil
		env.getfenv = nil
	end

	setfenv( chunk, env )
	return chunk()
end

--- Make isolation-safe setfenv and getfenv functions
--
-- @param protectedEnvironments A table where the keys are protected environment
--    tables. These environments cannot be accessed with getfenv(), and
--    functions with these environments cannot be modified or accessed using 
--    integer indexes to setfenv(). However, functions with these environments 
--    can have their environment set with setfenv() with a function value 
--    argument.
--
-- @param protectedFunctions A table where the keys are protected functions, 
--    which cannot have their environments set by setfenv() with a function 
--    value argument.
--
-- @return setfenv
-- @return getfenv
function mw.makeProtectedEnvFuncs( protectedEnvironments, protectedFunctions )
	local old_setfenv = setfenv
	local old_getfenv = getfenv

	local function my_setfenv( func, newEnv )
		if type( func ) == 'number' then
			local stackIndex = math.floor( func )
			if stackIndex <= 0 then
				error( "'setfenv' cannot set the global environment, it is protected", 2 )
			end
			if stackIndex > 10 then
				error( "'setfenv' cannot set an environment at a level greater than 10", 2 )
			end

			-- Add one because we are still in Lua and 1 is right here
			stackIndex = stackIndex + 1

			local env = old_getfenv( stackIndex )
			if env == nil or protectedEnvironments[ env ] then
				error( "'setfenv' cannot set the requested environment, it is protected", 2 )
			end
			func = old_setfenv( stackIndex, newEnv )
		elseif type( func ) == 'function' then
			if protectedFunctions[func] then
				error( "'setfenv' cannot be called on a protected function", 2 )
			end
			local env = old_getfenv( func )
			if env == nil or protectedEnvironments[ env ] then
				error( "'setfenv' cannot set the requested environment, it is protected", 2 )
			end
			old_setfenv( func, newEnv )
		else
			error( "'setfenv' can only be called with a function or integer as the first argument", 2 )
		end
		return func
	end

	local function my_getfenv( func )
		local env
		if type( func ) == 'number' then
			if func <= 0 then
				error( "'getfenv' cannot get the global environment" )
			end
			env = old_getfenv( func + 1 )
		elseif type( func ) == 'function' then
			env = old_getfenv( func )
		else
			error( "'getfenv' cannot get the global environment" )
		end

		if protectedEnvironments[env] then
			return nil
		else
			return env
		end
	end

	return my_setfenv, my_getfenv
end

local function newFrame( frameId )
	local frame = {}
	local argCache = {}
	local argNames
	local args_mt = {}

	local function checkSelf( self, method )
		if self ~= frame then
			error( "frame:" .. method .. ": invalid frame object. " ..
				"Did you call " .. method .. " with a dot instead of a colon, i.e. " ..
				"frame." .. method .. "() instead of frame:" .. method .. "()?",
				3 )
		end
	end

	-- Getter for args
	local function getExpandedArgument( dummy, name )
		name = tostring( name )
		if argCache[name] == nil then
			local arg = php.getExpandedArgument( frameId, name )
			if arg == nil then
				argCache[name] = false
			else
				argCache[name] = arg
			end
		end
		if argCache[name] == false then
			return nil
		else
			return argCache[name]
		end
	end

	args_mt.__index = getExpandedArgument

	-- pairs handler for args
	args_mt.__pairs = function ()
		if not argNames then
			local arguments = php.getAllExpandedArguments( frameId )
			argNames = {}
			for name, value in pairs( arguments ) do
				table.insert( argNames, name )
				argCache[name] = value
			end
		end

		local index = 0
		return function ()
			index = index + 1
			if argNames[index] then
				return argNames[index], argCache[argNames[index]]
			end
		end
	end

	-- ipairs 'next' function for args
	local function argsInext( dummy, i )
		local value = getExpandedArgument( dummy, i + 1 )
		if value then
			return i + 1, value
		end
	end

	args_mt.__ipairs = function () return argsInext, nil, 0 end

	frame.args = {}
	setmetatable( frame.args, args_mt )

	local function newCallbackParserValue( callback )
		local value = {}
		local cache

		function value:expand()
			if not cache then
				cache = callback()
			end
			return cache
		end

		return value
	end

	function frame:getArgument( opt )
		checkSelf( self, 'getArgument' )

		local name
		if type( opt ) == 'table' then
			name = opt.name
		else
			name = opt
		end

		return newCallbackParserValue( 
			function () 
				return getExpandedArgument( nil, name )
			end
			)
	end

	function frame:getParent()
		checkSelf( self, 'getParent' )

		if frameId == 'parent' then
			return nil
		elseif php.parentFrameExists() then
			return newFrame( 'parent' )
		else
			return nil
		end
	end

	function frame:expandTemplate( opt )
		checkSelf( self, 'expandTemplate' )

		local title

		if type( opt ) ~= 'table' then
			error( "frame:expandTemplate: the first parameter must be a table" )
		end
		if opt.title == nil then
			error( "frame:expandTemplate: a title is required" )
		else
			title = tostring( opt.title )
		end
		local args
		if opt.args == nil then
			args = {}
		elseif type( opt.args ) ~= 'table' then
			error( "frame:expandTitle: args must be a table" )
		else
			args = opt.args
		end

		return php.expandTemplate( frameId, title, args )
	end

	function frame:preprocess( opt )
		checkSelf( self, 'preprocess' )

		local text
		if type( opt ) == 'table' then
			text = opt.text
		else
			text = opt
		end
		text = tostring( text )
		return php.preprocess( frameId, text )
	end

	function frame:newParserValue( opt )
		checkSelf( self, 'newParserValue' )

		local text
		if type( opt ) == 'table' then
			text = opt.text
		else
			text = opt
		end

		return newCallbackParserValue(
			function () 
				return self:preprocess( text )
			end
			)
	end

	function frame:newTemplateParserValue( opt )
		checkSelf( self, 'newTemplateParserValue' )

		if type( opt ) ~= 'table' then
			error( "frame:newTemplateParserValue: the first parameter must be a table" )
		end
		if opt.title == nil then
			error( "frame:newTemplateParserValue: a title is required" )
		end
		return newCallbackParserValue( 
			function ()
				return self:expandTemplate( opt )
			end
			)
	end

	function frame:getTitle()
		checkSelf( self, 'getTitle' )
		return php.getFrameTitle( frameId )
	end

	-- For backwards compat
	function frame:argumentPairs()
		checkSelf( self, 'argumentPairs' )
		return pairs( self.args )
	end

	return frame
end

function mw.executeFunction( chunk )
	local frame = newFrame( 'current' )
	local oldFrame = currentFrame

	currentFrame = frame
	local results = { chunk( frame ) }
	currentFrame = oldFrame

	local stringResults = {}
	for i, result in ipairs( results ) do
		stringResults[i] = tostring( result )
	end
	return table.concat( stringResults )
end

function mw.allToString( ... )
	local t = { ... }
	for i = 1, select( '#', ... ) do
		t[i] = tostring( t[i] )
	end
	return table.concat( t, '\t' )
end

function mw.log( ... )
	logBuffer = logBuffer .. mw.allToString( ... ) .. '\n'
end

function mw.clearLogBuffer()
	logBuffer = ''
end

function mw.getLogBuffer()
	return logBuffer
end

function mw.getCurrentFrame()
	return currentFrame
end

function mw.incrementExpensiveFunctionCount()
	php.incrementExpensiveFunctionCount()
end

---
-- Wrapper for mw.loadData. This creates the read-only dummy table for
-- accessing the real data.
--
-- @param data table Data to access
-- @param seen table|nil Table of already-seen tables.
-- @return table
local function dataWrapper( data, seen )
	local t = {}
	seen = seen or { [data] = t }

	local function pairsfunc( s, k )
		k = next( data, k )
		if k ~= nil then
			return k, t[k]
		end
		return nil
	end

	local function ipairsfunc( s, i )
		i = i + 1
		if data[i] ~= nil then
			return i, t[i]
		end
		return -- no nil to match default ipairs()
	end

	local mt = {
		__index = function ( tt, k )
			assert( t == tt )
			local v = data[k]
			if type( v ) == 'table' then
				seen[v] = seen[v] or dataWrapper( v, seen )
				return seen[v]
			end
			return v
		end,
		__newindex = function ( t, k, v )
			error( "table from mw.loadData is read-only", 2 )
		end,
		__pairs = function ( tt )
			assert( t == tt )
			return pairsfunc, t, nil
		end,
		__ipairs = function ( tt )
			assert( t == tt )
			return ipairsfunc, t, 0
		end,
	}
	-- This is just to make setmetatable() fail
	mt.__metatable = mt

	return setmetatable( t, mt )
end

---
-- Validator for mw.loadData. This scans through the data looking for things
-- that are not supported, e.g. functions (which may be closures).
--
-- @param d table Data to access.
-- @param seen table|nil Table of already-seen tables.
-- @return string|nil Error message, if any
local function validateData( d, seen )
	seen = seen or {}
	local tp = type( d )
	if tp == 'nil' or tp == 'boolean' or tp == 'number' or tp == 'string' then
		return nil
	elseif tp == 'table' then
		if seen[d] then
			return nil
		end
		seen[d] = true
		if getmetatable( d ) ~= nil then
			return "data for mw.loadData contains a table with a metatable"
		end
		for k, v in pairs( d ) do
			if type( k ) == 'table' then
				return "data for mw.loadData contains a table as a key"
			end
			local err = validateData( k, seen ) or validateData( v, seen )
			if err then
				return err
			end
		end
		return nil
	else
		return "data for mw.loadData contains unsupported data type '" .. tp .. "'"
	end
end

function mw.loadData( module )
	local data = loadedData[module]
	if type( data ) == 'string' then
		-- No point in re-validating
		error( data, 2 )
	end
	if not data then
		-- The point of this is to load big data, so don't save it in package.loaded
		-- where it will have to be copied for all future modules.
		local l = package.loaded[module]
		data = require( module )
		package.loaded[module] = l

		-- Validate data
		local err
		if type( data ) == 'table' then
			err = validateData( data )
		else
			err = module .. ' returned ' .. type( data ) .. ', table expected'
		end
		if err then
			loadedData[module] = err
			error( err, 2 )
		end
		loadedData[module] = data
	end

	return dataWrapper( data )
end

return mw
