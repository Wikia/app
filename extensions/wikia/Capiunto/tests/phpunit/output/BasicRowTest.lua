local p = {}

p.run = function()
	local box = mw.capiunto.Infobox.create( {
		title = 'Infobox Data Test!'
	} )
	box
		:addHeader( 'A header' )
		:addRow( 'An item', 'with a value' )
		:addRow( 'Lable', '{{urlencode:This should get processed}}' )

	return tostring( box:getHtml() )
end

return p
