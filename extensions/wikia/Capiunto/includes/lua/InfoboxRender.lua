--[[
	A Lua helper module for rendering Capiunto infoboxes.

	Originally written on the English Wikipedia by
	Toohool and Mr. Stradivarius.

	Code released under the GPL v2+ as per:
	https://en.wikipedia.org/w/index.php?diff=next&oldid=581399786
	https://en.wikipedia.org/w/index.php?diff=next&oldid=581403025

	@license GNU GPL v2+
	@author Marius Hoch < hoo@online.de >
]]

local render = {}

-- Renders the outer wrapper for an infobox.
-- Returns the mw.html object for the new infobox
--
-- @param html
-- @param args
function render.renderWrapper( html, args )
	if not args.isChild then
		local table = html
			:tag( 'table' )
			:addClass( 'mw-capiunto-infobox' )
			:attr( 'cellspacing', 3 )
			:css( 'border-spacing', '3px' )

		if args.bodyClass then
			table
				:addClass( args.bodyClass )
		end

		if args.isSubbox then
			table
				:addClass( 'mw-capiunto-infobox-subbox' )
		else
			table
				:css( 'width', '22em' )
		end

		if args.bodyStyle then
			table
				:cssText( args.bodyStyle )
		end

		return table
	else
		html
			:wikitext( args.title )

		return html
	end
end

-- Adds a header to html
--
-- @param html
-- @param args
-- @param header
-- @param class
function render.renderHeader( html, args, header, class )
	local th = html:tag( 'tr' )
		:tag( 'th' )
			:attr( 'colspan', 2 )
			:css( 'text-align', 'center' )
			:wikitext( header )

	if class then
		th:addClass( class )
	end

	if args.headerStyle then
		th:cssText( args.headerStyle )
	end
end

-- Adds a row to the infobox, with either a header cell
-- or a label/data cell combination.
--
-- @param html
-- @param args
-- @param row
function render.renderRow( html, args, row )
	local tr = html:tag( 'tr' )

	if row.rowClass then
		tr:addClass( row.rowClass )
	end

	if row.label then
		local th = tr:tag( 'th' )
			:attr( 'scope', 'row' )
			:css( 'text-align', 'left' )
			:wikitext( row.label )

		if args.labelStyle then
			th:cssText( args.labelStyle )
		end
	end

	local dataCell = tr:tag( 'td' )
	if not row.label then
		dataCell
			:attr( 'colspan', 2 )
			:css( 'text-align', 'center' )
	end

	if row.class then
		dataCell
			:addClass( row.class )
	end

	if row.dataStyle then
		dataCell
			:cssText( row.dataStyle )
	end

	dataCell
		:newline()
		:wikitext( row.data )
end

-- Adds arbitrary wikitext
--
-- @param html
-- @param text
function render.renderWikitext( html, text )
	render.renderRow( html, {}, { data = text } )
end

-- Renders the title of the infobox into a caption
--
-- @param args
function render.renderTitle( html, args )
	if not args.title then return end

	local caption = html
		:tag( 'caption' )
			:wikitext( args.title )

	if args.titleClass then
		caption:addClass( args.titleClass )
	end
	if args.titleStyle then
		caption:cssText( args.titleStyle )
	end
end

-- Adds a <tr><th> with the top row to the html
--
-- @param html
-- @param args
function render.renderTopRow( html, args )
	if not args.top then return end

	local th  = html
		:tag( 'tr' )
		:tag( 'th' )
			:attr( 'colspan', 2 )
			:css( {
				['text-align'] = 'center',
				['font-size'] = '125%',
				['font-weight'] = 'bold'
			} )
			:wikitext( args.top )

	if args.topClass then
		th:addClass( args.topClass )
	end

	if args.topStyle then
		th:cssText( args.topStyle )
	end
end

-- Adds a <tr><td> with the bottom row to the html
--
-- @param html
-- @param args
function render.renderBottomRow( html, args )
	if not args.bottom then return end

	local td = html
		:tag( 'tr' )
			:tag( 'td' )
				:attr( 'colspan', '2' )
				:css( 'text-align', 'center' )
				:newline()
				:wikitext( args.bottom )

	if args.bottomClass then
		td:addClass( args.bottomClass )
	end

	if args.bottomStyle then
		td:cssText( args.bottomStyle )
	end
end

-- Add subheader rows to the given html
--
-- @param html
-- @param args
function render.renderSubHeaders( html, args )
	if not args.subHeaders then return end

	for i, value in pairs( args.subHeaders ) do
		render.renderRow(
			html,
			args,
			{
				data = value.text,
				dataStyle = value.style,
				rowClass = value.class
			}
		)
	end
end

-- Add images (wiki syntax) to the html
--
-- @param html
-- @param args
function render.renderImages( html, args )
	if not args.images then return end

	for i, image in pairs( args.images ) do
		local data = mw.html.create( '' ):wikitext( image.image )

		if image.caption then
			data
				:tag( 'br' )
					:done()

			local div = data
				:tag( 'div' )
					:wikitext( image.caption )

			if args.captionStyle then
				div:cssText( args.captionStyle )
			end
		end

		render.renderRow(
			html,
			args,
			{
				data = tostring( data ),
				dataStyle = args.imageStyle,
				class = args.imageClass,
				rowClass = image.class
			}
		)

	end
end

-- Renders all rows in order using addRow / addHeader.
--
-- @param html
-- @param args
function render.renderRows( html, args )
	if not args.rows then return end

	for k, row in pairs( args.rows ) do
		if row.header then
			render.renderHeader( html, args, row.header, row.class )
		elseif row.wikitext then
			render.renderWikitext( html, row.wikitext )
		else
			render.renderRow(
				html,
				args,
				{
					label = row.label,
					data = row.data,
					dataStyle = args.dataStyle,
					class = row.class,
					rowClass = row.rowClass
				}
			)
		end
	end
end

mw_interface = nil

-- Register this module in the "mw.capiunto" global
mw = mw or {}
mw.capiunto = mw.capiunto or {}
mw.capiunto.Infobox = mw.capiunto.Infobox or {}
mw.capiunto.Infobox._render = render

package.loaded['mw.capiunto.Infobox._render'] = render

return render
