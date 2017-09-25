--[[
	Registers methods that can be accessed through the Scribunto extension

	@since 0.1

	@licence GNU GPL v2+
	@author mwjames
]]

-- Variable instantiation
local smw = {}
local php

function smw.setupInterface()
	-- Interface setup
	smw.setupInterface = nil
	php = mw_interface
	mw_interface = nil

	-- Register library within the "mw.smw" namespace
	mw = mw or {}
	mw.smw = smw

	package.loaded['mw.smw'] = smw
end

-- ask
function smw.ask( parameters )
	return php.ask( parameters )
end

-- getPropertyType
function smw.getPropertyType( name )
	return php.getPropertyType( name )
end

-- getQueryResult
function smw.getQueryResult( queryString )
	local queryResult = php.getQueryResult( queryString )
	if queryResult == nil then return nil end
	return queryResult
end

-- info
function smw.info( text, icon )
	return php.info( text, icon )
end

-- set
function smw.set( parameters )
	return php.set( parameters )
end

-- subobject
function smw.subobject( parameters, subobjectId )
	return php.subobject( parameters, subobjectId )
end

return smw
