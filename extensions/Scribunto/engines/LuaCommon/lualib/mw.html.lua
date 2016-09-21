--[[
	A module for building complex HTML from Lua using a
	fluent interface.

	Originally written on the English Wikipedia by
	Toohool and Mr. Stradivarius.

	Code released under the GPL v2+ as per:
	https://en.wikipedia.org/w/index.php?diff=next&oldid=581399786
	https://en.wikipedia.org/w/index.php?diff=next&oldid=581403025

	@license GNU GPL v2+
	@author Marius Hoch < hoo@online.de >
]]

local HtmlBuilder = {}
local options

local metatable = {}
local methodtable = {}

local selfClosingTags = {
	area = true,
	base = true,
	br = true,
	col = true,
	command = true,
	embed = true,
	hr = true,
	img = true,
	input = true,
	keygen = true,
	link = true,
	meta = true,
	param = true,
	source = true,
	track = true,
	wbr = true,
}

local htmlencodeMap = {
	['>'] = '&gt;',
	['<'] = '&lt;',
	['&'] = '&amp;',
	['"'] = '&quot;',
}

metatable.__index = methodtable

metatable.__tostring = function( t )
	local ret = {}
	t:_build( ret )
	return table.concat( ret )
end

-- Get an attribute table (name, value) and its index
--
-- @param name
local function getAttr( t, name )
	for i, attr in ipairs( t.attributes ) do
		if attr.name == name then
			-- begin wikia change
			-- VOLDEV-118
			return attr, i
			-- end wikia change
		end
	end
end

-- Is this a valid attribute name?
--
-- @param s
local function isValidAttributeName( s )
	-- Good estimate: http://www.w3.org/TR/2000/REC-xml-20001006#NT-Name
	return s:match( '^[a-zA-Z_:][a-zA-Z0-9_.:-]*$' )
end

-- Is this a valid tag name?
--
-- @param s
local function isValidTag( s )
	return s:match( '^[a-zA-Z0-9]+$' )
end

-- Escape a value, for use in HTML
--
-- @param s
local function htmlEncode( s )
	local tmp = string.gsub( s, '[<>&"]', htmlencodeMap );
	-- Don't encode strip markers here (T110143)
	tmp = string.gsub( tmp, options.encodedUniqPrefixPat, options.uniqPrefixRepl )
	tmp = string.gsub( tmp, options.encodedUniqSuffixPat, options.uniqSuffixRepl )
	return tmp
end

 local function cssEncode( s )
	-- XXX: I'm not sure this character set is complete.
	return mw.ustring.gsub( s, '[;:%z\1-\31\127-\244\143\191\191]', function ( m )
		return string.format( '\\%X ', mw.ustring.codepoint( m ) )
	end )
end

methodtable._build = function( t, ret )
	if t.tagName then
		table.insert( ret, '<' .. t.tagName )
		for i, attr in ipairs( t.attributes ) do
			table.insert(
				ret,
				-- Note: Attribute names have already been validated
				' ' .. attr.name .. '="' .. htmlEncode( attr.val ) .. '"'
			)
		end
		if #t.styles > 0 then
			table.insert( ret, ' style="' )
			for i, prop in ipairs( t.styles ) do
				if type( prop ) == 'string' then -- added with cssText()
					table.insert( ret, htmlEncode( prop ) .. ';' )
				else -- added with css()
					table.insert(
						ret,
						htmlEncode( cssEncode( prop.name ) .. ':' .. cssEncode( prop.val ) ) .. ';'
					)
				end
			end
			table.insert( ret, '"' )
		end
		if t.selfClosing then
			table.insert( ret, ' />' )
			return
		end
		table.insert( ret, '>' )
	end
	for i, node in ipairs( t.nodes ) do
		if node then
			if type( node ) == 'table' then
				node:_build( ret )
			else
				table.insert( ret, tostring( node ) )
			end
		end
	end
	if t.tagName then
		table.insert( ret, '</' .. t.tagName .. '>' )
	end
end

-- Append a builder to the current node
--
-- @param builder
methodtable.node = function( t, builder )
	if t.selfClosing then
		error( "Self-closing tags can't have child nodes" )
	end

	if builder then
		table.insert( t.nodes, builder )
	end
	return t
end

-- Appends some markup to the node. This will be treated as wikitext.
methodtable.wikitext = function( t, ... )
	local vals = {...}
	for i = 1, #vals do
		if type( vals[i] ) ~= 'string' and type( vals[i] ) ~= 'number' then
			error( 'Invalid wikitext given: Must be either a string or a number' )
		end

		t:node( vals[i] )
	end
	return t
end

-- Appends a newline character to the node.
methodtable.newline = function( t )
	t:wikitext( '\n' )
	return t
end

-- Appends a new child node to the builder, and returns an HtmlBuilder instance
-- representing that new node.
--
-- @param tagName
-- @param args
methodtable.tag = function( t, tagName, args )
	args = args or {}
	args.parent = t
	local builder = HtmlBuilder.create( tagName, args )
	t:node( builder )
	return builder
end

-- Get the value of an html attribute
--
-- @param name
methodtable.getAttr = function( t, name )
	local attr = getAttr( t, name )
	if attr then
		return attr.val
	end
	return nil
end

-- Set an HTML attribute on the node.
--
-- @param name Attribute to set, alternative table of name-value pairs
-- @param val Value of the attribute. Nil causes the attribute to be unset
methodtable.attr = function( t, name, val )
	if type( name ) == 'table' then
		if val ~= nil then
			error( 'If a key->value table is given as first parameter, value must be left empty' )
		end

		local callForTable = function()
			for attrName, attrValue in pairs( name ) do
				t:attr( attrName, attrValue )
			end
		end

		if not pcall( callForTable ) then
			error( 'Invalid table given: Must be name (string) value (string|number) pairs' )
		end

		return t
	end

	if type( name ) ~= 'string' and type( name ) ~= 'number' then
		error( 'Invalid name given: The name must be either a string or a number' )
	end
	-- begin wikia change
	-- VOLDEV-118
	if val ~= nil and type( val ) ~= 'string' and type( val ) ~= 'number' then
	-- end wikia change
		error( 'Invalid value given: The value must be either a string or a number' )
	end

	-- if caller sets the style attribute explicitly, then replace all styles
	-- previously added with css() and cssText()
	if name == 'style' then
		t.styles = { val }
		return t
	end

	if not isValidAttributeName( name ) then
		error( "Invalid attribute name: " .. name )
	end

	-- begin wikia change
	-- VOLDEV-118
	local attr, i = getAttr( t, name )
	if attr then
		if val ~= nil then
			attr.val = val
		else
			table.remove( t.attributes, i )
		end
	elseif val ~= nil then
	-- end wikia change
		table.insert( t.attributes, { name = name, val = val } )
	end

	return t
end

-- Adds a class name to the node's class attribute. Spaces will be
-- automatically added to delimit each added class name.
--
-- @param class
methodtable.addClass = function( t, class )
	-- begin wikia change
	-- VOLDEV-118
	if class == nil then
		return t
	end
	-- end wikia change

	if type( class ) ~= 'string' and type( class ) ~= 'number' then
		error( 'Invalid class given: The name must be either a string or a number' )
	end

	local attr = getAttr( t, 'class' )
	if attr then
		attr.val = attr.val .. ' ' .. class
	else
		t:attr( 'class', class )
	end

	return t
end

-- Set a CSS property to be added to the node's style attribute.
--
-- @param name CSS attribute to set, alternative table of name-value pairs
-- @param val The value to set. Nil causes it to be unset
methodtable.css = function( t, name, val )
	if type( name ) == 'table' then
		if val ~= nil then
			error( 'If a key->value table is given as first parameter, value must be left empty' )
		end

		local callForTable = function()
			for attrName, attrValue in pairs( name ) do
				t:css( attrName, attrValue )
			end
		end

		if not pcall( callForTable ) then
			error( 'Invalid table given: Must be name (string|number) value (string|number) pairs' )
		end

		return t
	end

	if type( name ) ~= 'string' and type( name ) ~= 'number' then
		error( 'Invalid CSS given: The name must be either a string or a number' )
	end
	-- begin wikia change
	-- VOLDEV-118
	if val ~= nil and type( val ) ~= 'string' and type( val ) ~= 'number' then
	-- end wikia change
		error( 'Invalid CSS given: The value must be either a string or a number' )
	end

	for i, prop in ipairs( t.styles ) do
		if prop.name == name then
			-- begin wikia change
			-- VOLDEV-118
			if val ~= nil then
				prop.val = val
			else
				table.remove( t.styles, i )
			end
			-- end wikia change
			return t
		end
	end

	-- begin wikia change
	-- VOLDEV-118
	if val ~= nil then
		table.insert( t.styles, { name = name, val = val } )
	end
	-- end wikia change

	return t
end

-- Add some raw CSS to the node's style attribute. This is typically used
-- when a template allows some CSS to be passed in as a parameter
--
-- @param css
methodtable.cssText = function( t, css )
	-- begin wikia change
	-- VOLDEV-118
	if css ~= nil then
		if type( css ) ~= 'string' and type( css ) ~= 'number' then
			error( 'Invalid CSS given: Must be either a string or a number' )
		end
	-- end wikia change

		table.insert( t.styles, css )
	end
	return t
end

-- Returns the parent node under which the current node was created. Like
-- jQuery.end, this is a convenience function to allow the construction of
-- several child nodes to be chained together into a single statement.
methodtable.done = function( t )
	return t.parent or t
end

-- Like .done(), but traverses all the way to the root node of the tree and
-- returns it.
methodtable.allDone = function( t )
	while t.parent do
		t = t.parent
	end
	return t
end

-- Create a new instance
--
-- @param tagName
-- @param args
function HtmlBuilder.create( tagName, args )
	-- begin wikia change
	-- VOLDEV-118
	if tagname ~= nil then
		if type( tagName ) ~= 'string' then
			error( "Tag name must be a string" )
		end

		if tagName ~= '' and not isValidTag( tagName ) then
			error( "Invalid tag name: " .. tagName )
		end
	end
	-- end wikia change

	args = args or {}
	local builder = {}
	setmetatable( builder, metatable )
	builder.nodes = {}
	builder.attributes = {}
	builder.styles = {}

	if tagName ~= '' then
		builder.tagName = tagName
	end

	builder.parent = args.parent
	builder.selfClosing = selfClosingTags[tagName] or args.selfClosing or false
	return builder
end

-- Register this library in the "mw" global
function HtmlBuilder.setupInterface( opts )
	-- Boilerplate
	HtmlBuilder.setupInterface = nil
	mw_interface = nil
	options = opts

	-- Prepare patterns for unencoding strip markers
	options.encodedUniqPrefixPat = string.gsub( options.uniqPrefix, '[<>&"]', htmlencodeMap );
	options.encodedUniqPrefixPat = string.gsub( options.encodedUniqPrefixPat, '%p', '%%%0' );
	options.uniqPrefixRepl = string.gsub( options.uniqPrefix, '%%', '%%%0' );
	options.encodedUniqSuffixPat = string.gsub( options.uniqSuffix, '[<>&"]', htmlencodeMap );
	options.encodedUniqSuffixPat = string.gsub( options.encodedUniqSuffixPat, '%p', '%%%0' );
	options.uniqSuffixRepl = string.gsub( options.uniqSuffix, '%%', '%%%0' );

	-- Register this library in the "mw" global
	mw = mw or {}
	mw.html = HtmlBuilder

	package.loaded['mw.html'] = HtmlBuilder
end

return HtmlBuilder
