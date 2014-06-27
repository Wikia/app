local p = {}

p.run = function()
	local box = mw.capiunto.Infobox.create( {
		name = 'Foo bar',
		top = 'Text in uppermost cell of infobox',
	} )

	box
		:addSubHeader( 'Subheader of the infobox' )
		:addSubHeader( 'Second subheader of the infobox' )

	return tostring( box:getHtml() )
end

return p
