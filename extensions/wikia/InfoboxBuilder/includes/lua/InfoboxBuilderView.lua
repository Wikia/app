local InfoboxBuilderView = {}

-- Define dependencies
local HF = mw.InfoboxBuilderHF

InfoboxBuilderView.vars = {}

function InfoboxBuilderView.render( input, vars )

	local fields   = input.fields
	local sections = input.sections

	InfoboxBuilderView.vars = vars

	local Infobox = mw.html.create('div')
    Infobox:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxContainer')
 
	    local table = Infobox:tag('table')
	          table:attr('cellspacing', '0')
	               :attr('cellpadding', '0')
	 
	    for index, field in ipairs( fields ) do
	 
	      if     field.Type == "Image" then
	        table:node( InfoboxBuilderView.addRowImage( field.Label, field.Value ) )

	      elseif field.Type == "MainImage" then
	        table:node( InfoboxBuilderView.addRowMainImage( field.Label, field.Value ) )

	      elseif field.Type == "Title" then
	        table:node( InfoboxBuilderView.addRowTitle( field.Label, field.Value ) )

	      elseif field.Type == "Header" then
	        if input.sections[index] == "On" then
	          table:node( InfoboxBuilderView.addRowHeader( field.Label, field.Value ) )
	        end

	      elseif field.Type == "Line" then
	        if not HF.isempty( field.Value ) then
	          table:node( InfoboxBuilderView.addRowLine( field.Label, field.Value ) )
	        end

	      elseif field.Type == "Footer" then
	        table:node( InfoboxBuilderView.addRowFooter( field.Label, field.Value ) )

        elseif field.Type == "Split" then
          table:node( InfoboxBuilderView.addRowSplit( field.Label, field.Value ) )
        
        elseif field.Type == "Custom" then
          table:node( InfoboxBuilderView.addRowCustom( field.Label, field.Value ) )

	      end
	 
	    end
  
  output = tostring( Infobox )
  
	return output

end

function InfoboxBuilderView.addRowCustom( label, value )
  local node = mw.html.create( label )
        node:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxCustom' )
            :wikitext( value )
  return node
end

function InfoboxBuilderView.addRowMainImage( label, value )
  local node = mw.html.create('')
  
  local row1 = node:tag('tr')
    row1:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxMainImage' )
        :attr('colspan', '2')
        :wikitext( value ) 

  if InfoboxBuilderView.vars.MainImageCaption == "On" then
    local row2 = node:tag('tr')
      row2:tag('td')
          :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxMainImageCaption' )
          :attr('colspan', '2')
          :wikitext( label )
  end

  return node
end

function InfoboxBuilderView.addRowImage( label, value )
  local node = mw.html.create('')
  
  local row1 = node:tag('tr')
    row1:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxImage' )
        :attr('colspan', '2')
        :wikitext( value ) 

  local row2 = node:tag('tr')
    row2:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxImageCaption' )
        :attr('colspan', '2')
        :wikitext( label )

  return node
end
 
function InfoboxBuilderView.addRowTitle( label, value )
  local row = mw.html.create('tr')
    row:tag('td')
       :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxTitle' )
       :attr('colspan', '2')
       :wikitext( value )
  return row
end

function InfoboxBuilderView.addRowFooter( label, value )
  local row = mw.html.create('tr')
    row:tag('td')
       :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxFooter' )
       :attr('colspan', '2')
       :wikitext( value )
  return row
end
 
function InfoboxBuilderView.addRowHeader( label, value )
 
    local row = mw.html.create('tr')
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxHeader' )
         :attr('colspan', '2') 
         :wikitext( value )
    return row
 
end

function InfoboxBuilderView.addRowLink( label, value )
 
    local row = mw.html.create('tr')
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxLink' )
         :attr('colspan', '2') 
         :wikitext( value )
    return row
 
end

function InfoboxBuilderView.addRowLine( label, value )
    
    local row = mw.html.create('tr')
      row:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxLine' )
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxLineLeft' )
         :wikitext( label )
         :done()

    if string.len( value ) > tonumber( InfoboxBuilderView.vars.ToggleContentLongerThan ) then
      local cell = row:tag('td')
      cell:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxLineRight' )
        cell:tag('div')
            :addClass('mw-collapsible mw-collapsed ' .. InfoboxBuilderView.vars.Theme .. 'InfoboxToggleContent')
            :wikitext( value )
            :done()
      row:done()
    else
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxLineRight' )
         :wikitext( value )
         :done()
    end

    return row
 
end

function InfoboxBuilderView.addRowSplit( label, value )

  local node = mw.html.create('')
  
  local labelLeft = mw.html.create('td')
    labelLeft:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxSplitLabelLeft' )
  local valueLeft = mw.html.create('td')
    valueLeft:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxSplitValueLeft' )

  local labelRight = mw.html.create('td')
    labelRight:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxSplitLabelRight' )
  local valueRight = mw.html.create('td')
    valueRight:addClass( InfoboxBuilderView.vars.Theme .. 'InfoboxSplitValueRight' )

  if type( label ) == "string" then
    labelLeft:wikitext( label )
  end

  if type( value ) == "string" then
    valueLeft:wikitext( value )
  elseif type( value ) == "table" then
    if not HF.isempty( value[1] ) then
      labelLeft:wikitext( label[1] )
      valueLeft:wikitext( value[1] )
    end
    if not HF.isempty( value[2] ) then
      labelRight:wikitext( label[2] )
      valueRight:wikitext( value[2] )
    end
  end

  local row1 = node:tag('tr')
    row1:node( labelLeft )
    row1:node( labelRight )

  local row2 = node:tag('tr')
    row2:node( valueLeft )
    row2:node( valueRight )

  return node

end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder.View" global
mw = mw or {}
mw.InfoboxBuilderView = InfoboxBuilderView

package.loaded['mw.InfoboxBuilderView'] = InfoboxBuilderView

return InfoboxBuilderView
