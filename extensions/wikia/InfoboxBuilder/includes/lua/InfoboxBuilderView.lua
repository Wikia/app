local InfoboxBuilderView = {}

-- Define dependencies
local HF = mw.InfoboxBuilderHF

-- Define a table to store global variables
InfoboxBuilderView.vars = {}


--[[ Private methods ]]--

--[[
---- Function that renders a Line block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowLine = function( field )
	local row = mw.html.create( 'tr' )
	row
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line' )
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )

	if not HF.isempty( field.CssClass ) then
		row:addClass( field.CssClass )
	end

	row
		:tag( 'td' )
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-left' )
			:wikitext( field.Label )
			:done()

	if string.len( field.Value ) > tonumber( InfoboxBuilderView.vars.ToggleContentLongerThan ) then
		local cell = row:tag( 'td' )
		cell
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-right' )
			:tag( 'div' )
				:addClass( 'mw-collapsible mw-collapsed ' .. InfoboxBuilderView.vars.Theme .. '-infobox-toggle-content' )
				:wikitext( field.Value )
				:done()
		row:done()
	else
		row
			:tag( 'td' )
				:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-right' )
				:wikitext( field.Value )
				:done()
	end

	return row
end

--[[
---- Function that renders a Header block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowHeader = function( field )
	local row = mw.html.create('tr')
	row:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )

	if not HF.isempty( field.CssClass ) then
		row:addClass( field.CssClass )
	end

	row
		:tag( 'td' )
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-header' )
			:attr( 'colspan', '2' )
			:wikitext( field.Value )

	return row
end

--[[
---- Function that renders a Title block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowTitle = function( field )
	local row = mw.html.create('tr')
	row:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )

	local cell = row:tag('th')
	cell
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-title' )
		:attr( 'colspan', '2' )
		:wikitext( field.Value )

	return row
end

--[[
---- Function that renders a MainImage block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowMainImage = function( field )
	local node = mw.html.create( '' )

	local row1 = node:tag( 'tr' )
	row1
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
		:tag( 'td' )
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image' )
			:attr( 'colspan', '2' )
			:wikitext( field.Value )

	if InfoboxBuilderView.vars.MainImageCaption == "On" then
		local row2 = node:tag( 'tr' )
		row2
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
			:tag( 'td' )
				:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image-caption' )
				:attr( 'colspan', '2' )
				:wikitext( field.Label )
	end

	return node
end

--[[
---- Function that renders an Image block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowImage = function( field )
	local node = mw.html.create( '' )

	local row1 = node:tag( 'tr' )
	row1
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
		:tag('td')
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image' )
			:attr( 'colspan', '2' )
			:wikitext( field.Value )

	local row2 = node:tag( 'tr' )
	row2
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
		:tag( 'td' )
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-image-caption' )
			:attr( 'colspan', '2' )
			:wikitext( field.Label )

	return node
end

--[[
---- Function that renders a Footer block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowFooter = function( field )
	local row = mw.html.create( 'tr' )

	row
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
		:tag( 'td' )
			:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-footer' )
			:attr( 'colspan', '2' )
			:wikitext( field.Value )

	return row
end

--[[
---- Function that renders a Split block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowSplit = function( field )
	local node = mw.html.create( '' )

	local labelLeft = mw.html.create( 'td' )
	labelLeft:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-label-left' )
	local valueLeft = mw.html.create( 'td' )
	valueLeft:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-value-left' )

	local labelRight = mw.html.create( 'td' )
	labelRight:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-label-right' )
	local valueRight = mw.html.create( 'td' )
	valueRight:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-value-right' )

	if type( field.Label ) == "string" then
		labelLeft:wikitext( field.Label )
	end

	if type( field.Value ) == "string" then
		valueLeft:wikitext( field.Value )
	elseif type( field.Value ) == "table" then
		if not HF.isempty( field.Value[1] ) then
			labelLeft:wikitext( field.Label[1] )
			valueLeft:wikitext( field.Value[1] )
		end
		if not HF.isempty( field.Value[2] ) then
			labelRight:wikitext( field.Label[2] )
			valueRight:wikitext( field.Value[2] )
		end
	end

	local row1 = node:tag( 'tr' )
	row1:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )

	row1:node( labelLeft )
	row1:node( labelRight )

	local row2 = node:tag( 'tr' )
	row2:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )

	row2:node( valueLeft )
	row2:node( valueRight )

	return node
end

--[[
---- Function that renders a Custom block
---- @param   table field  A table with all field's arguments
---- @return  object       Returns an mw.html object that can be merged with a container
]]--
local addRowCustom = function( field )
	local node = mw.html.create( field.Label )
	node
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-custom' )
		:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-field-' .. field.Index )
		:wikitext( field.Value )

	if not HF.isempty( field.CssClass ) then
		node:addClass( field.CssClass )
	end

	return node
end


--[[ Public methods ]]--

--[[
---- Main function that controls the rendering of prepared fields
---- @param   table input  A sorted table with modified arguments - check InfoboxBuilder.lua@execute()
---- @param   table vars   A table containing global variables
---- @return  string       Returns a wikitext-compliant string with a rendered infobox
]]--
function InfoboxBuilderView.render( input, vars )
	local fields   = input.fields
	local sections = input.sections

	InfoboxBuilderView.vars = vars

	-- Let's go! Create a container
	local Infobox = mw.html.create( 'div' )
	Infobox:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-container')

	local table = Infobox:tag( 'table' )
	table
		:attr( 'cellspacing', '0' )
		:attr( 'cellpadding', '0' )
		:addClass( 'infobox-table' )

	-- Iterate over each field and render a row if a value is not empty
	for index, field in ipairs( fields ) do
		if not HF.isempty( field.Value ) then
			if field.Type == "Line" then
				table:node( addRowLine( field ) )
			elseif field.Type == "Header" and input.sections[index] == "On" then
				table:node( addRowHeader( field ) )
			elseif field.Type == "Title" then
				table:node( addRowTitle( field ) )
			elseif field.Type == "MainImage" then
				table:node( addRowMainImage( field ) )
			elseif field.Type == "Image" then
				table:node( addRowImage( field ) )
			elseif field.Type == "Footer" then
				table:node( addRowFooter( field ) )
			elseif field.Type == "Custom" then
				table:node( addRowCustom( field ) )
			elseif field.Type == "Split" then
				table:node( addRowSplit( field ) )
			end
		end
	end

	-- Convert the whole infobox to a wikitext-compliant string
	output = tostring( Infobox )

	return output
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder.View" global
mw = mw or {}
mw.InfoboxBuilderView = InfoboxBuilderView

package.loaded['mw.InfoboxBuilderView'] = InfoboxBuilderView

return InfoboxBuilderView
