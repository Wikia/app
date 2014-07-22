local InfoboxBuilder = {}

-- Define dependecies
local HF = mw.InfoboxBuilderHF

-- Define a variable to store a custom module
local CM = {}

-- Define default values for global variables
InfoboxBuilder.vars = {
	Theme                   = "default", -- Adds prefix to CSS classes
	CustomModule            = "",        -- Defines a path to a module with custom functions
	MainImageCaption        = "Off",     -- Display a Label as a caption of the Main Image?
	ToggleContentLongerThan = 1000       -- Makes fields with long Values collapsible
}

-- Define table to hold errors
InfoboxBuilder.errors = {}


--[[ Private methods ]]--

--[[
---- Function that adds an error to the global table
---- @param   string key     Name of a message from i18n file
---- @param   table  params  (optional) Table of parameters
---- @return  true           Always returns true
]]--
local logError = function( key, params )
	if type( params ) ~= "table" then
		params = { params }
	end

	local e = { key = key, params = params }
	table.insert( InfoboxBuilder.errors, e )

	return true
end

--[[
---- Function that checks if a supplied method exists in a custom module
---- @param   string name  Name of a method to check
---- @return  bool         Returns true if the method exists
]]--
local displayErrors = function( errors )
	if not HF.isempty( errors ) then
		local lang = mw.language.getContentLanguage():getCode() or 'en'
		local output = [[
			<div class="infobox-builder-errors">
				<h3>]] .. mw.message.new('infoboxbuilder-errors-header'):inLanguage( lang ):plain() .. [[</h3>
				<p>]] .. mw.message.new('infoboxbuilder-errors-desc'):inLanguage( lang ):plain() .. [[</p>
				<ul>
		]]

		for i, e in ipairs( errors ) do
			local key    = e.key or ''
			local params = e.params or {}

			if not HF.isempty( key ) then
				output = output .. "<li>" .. mw.message.new( e.key ):inLanguage( lang ):params( e.params ):plain() .. "</li>"
			end
		end

		output = output .. [[
			</ul></div>
		]]
		return output
	else
		return ""
	end
end

--[[
---- Function that checks if a supplied method exists in a custom module
---- @param   string name  Name of a method to check
---- @return  bool         Returns true if the method exists
]]--
local methodExists = function( name )
	local exists = false

	if not HF.isempty( name ) and type( CM[name] ) == "function" then
		exists = true
	end

	return exists
end

--[[
---- Function executing methods from CustomModule on Labels and Values
---- @param   table  input  A sorted table of parsed arguments
---- @return  table         A sorted table with modified Labels and Values
]]--
local execute = function( input )
	-- Check if user
	if not HF.isempty( mw.text.trim( InfoboxBuilder.vars["CustomModule"] ) ) then

		-- Require user's custom module
		local status, result = pcall( require, mw.text.trim( InfoboxBuilder.vars["CustomModule"] ) )

		if not status then
			logError( "infoboxbuilder-errors-no-module", {} )
		else
			CM = result

			-- Execute custom methods
			for index, field in ipairs( input.fields ) do

				-- Checks for a table type which is handled differently
				if type( field.Label ) == "table" and methodExists( field.LabelMethod ) then
					input.fields[index].Label = CM[field.LabelMethod]( field, InfoboxBuilder.vars )
				elseif not HF.isempty( mw.text.trim( field.Label ) ) and methodExists( field.LabelMethod ) then
					input.fields[index].Label = CM[field.LabelMethod]( field, InfoboxBuilder.vars )
				end

				-- Checks for a table type which is handled differently
				if type( field.Value ) == "table" and methodExists( field.ValueMethod ) then
					input.fields[index].Value = CM[field.ValueMethod]( field, InfoboxBuilder.vars )
				elseif not HF.isempty( mw.text.trim( field.Value ) ) and methodExists( field.ValueMethod ) then
					input.fields[index].Value = CM[field.ValueMethod]( field, InfoboxBuilder.vars )
				end
			end
		end

	end

	return input
end

--[[
---- Function parsing each argument following the Index:Key = Value syntax.
---- It also initiates execution of custom methods on Labels and Values of fields.
---- @param   table  args  Table of parameters passed as strings
---- @return  table        A sorted table with modified Labels and Values returned by the execute() function
]]--
local parse = function( args )

	local input = {}
		input.fields   = {}   -- Actual Infobox data
		input.sections = {}   -- Relating headers to lines
		input.vars     = {}   -- Variables useful for styling etc.

	-- Distribute args to variables and fields.

	local indexes = {} -- Table used to sort indexes of fields
	local fields = {}  -- Temporary fields table
	local f = 0        -- Fields consecutive indice

	-- Initial parsing of arguments following Index:Key = Value syntax
	for k, v in pairs(args) do

		local keySplit = HF.explode( ":", tostring(k) )

		local index  = tonumber( mw.text.trim( keySplit[1] ) )
		local key    = tostring( mw.text.trim( keySplit[2] ) )
		local value  = tostring( mw.text.trim( v ) )

		-- If an index is not equal 0 this argument belongs to fields
		if index ~= 0 then

			if fields[index] == nil then
				table.insert( indexes, index )
				fields[index] = {}
				fields[index].Index = index
			end

			fields[index][key] = value

		-- If an index equals 0 this argument belongs to vars
		elseif not HF.isempty( mw.text.trim( value ) ) then
			-- Overwrite default values
			InfoboxBuilder.vars[key] = value
		end

	end

	-- Add custom and default values to input table passed for further manipulation
	input.vars = InfoboxBuilder.vars

	--[[
	---- Since ipairs() requires numbers to be consecutive to continue looping
	---- indexes have to be sorted in an ascending order and than reassigned.
	---- It prevents a loop from breaking when there is an n+1 index missing in a .. n, n+1, n+2 .. fields sequence
	]]--
	table.sort( indexes )

	local currentHeader = 0

	for i, index in ipairs(indexes) do

		f = f + 1
		input.fields[f] = {}
		input.fields[f] = fields[index]

		-- Add fields to sections
		if input.fields[f]["Type"] == "Header" then
			currentHeader = f
			input.sections[f] = "Off" -- Hide header by default, show it when it has at least 1 line
		elseif currentHeader > 0 then -- Prevent displaying a header when its section is empty
			if not HF.isempty( input.fields[f]["Value"] ) then
				input.sections[currentHeader] = "On" -- Show header if there is at least one line filled in its section
			end
		end

		-- Custom handling of a Split field
		if input.fields[f]["Type"] == "Split" then
			input.fields[f]["Label"] = { input.fields[f]["LabelLeft"], input.fields[f]["LabelRight"] }
			input.fields[f]["Value"] = { input.fields[f]["ValueLeft"], input.fields[f]["ValueRight"] }
		end

	end

	-- Inititate execution of function from a CustomModule
	input = execute( input )

	-- Return modified table ready to be rendered
	return input

end


--[[ Public methods ]]--

--[[
---- Main controller that initiates arguments' parsing and modifing and returning rendered infobox
---- @param   object frame  Frame object
---- @return  string        Wikitext-compliant string with an infobox
]]--
function InfoboxBuilder.builder( frame )
	local input   = parse( frame.args )
	local Infobox = mw.InfoboxBuilderView.render( input, InfoboxBuilder.vars )

	Infobox = displayErrors( InfoboxBuilder.errors ) .. Infobox

	return Infobox
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder" global
mw = mw or {}
mw.InfoboxBuilder = InfoboxBuilder

package.loaded['mw.InfoboxBuilder'] = InfoboxBuilder

return InfoboxBuilder
