local InfoboxBuilderView = {}

-- Define dependencies
local HF = mw.InfoboxBuilderHF

InfoboxBuilderView.vars = {}

function InfoboxBuilderView.render( input, vars )

	local fields   = input.fields
	local sections = input.sections

	InfoboxBuilderView.vars = vars

	local Infobox = mw.html.create('div')
    Infobox:addClass( InfoboxBuilderView.vars.Theme .. 'infobox-container')
 
	    local table = Infobox:tag('table')
	          table:attr('cellspacing', '0')
	               :attr('cellpadding', '0')
	               :addClass('InfoboxTable')
	               -- :addClass('infobox')
	 
	    for index, field in ipairs( fields ) do
	 
	  	if field.Type == "Line" then
	    	if not HF.isempty( field.Value ) then
	      		table:node( InfoboxBuilderView.addRowLine( field ) )
	    	end
	    
		elseif field.Type == "Header" then
		    if input.sections[index] == "On" then
		    	table:node( InfoboxBuilderView.addRowHeader( field ) )
		    end
		    
	    elseif field.Type == "Title" then
	      table:node( InfoboxBuilderView.addRowTitle( field ) )
	    
	    elseif field.Type == "MainImage" then
	      table:node( InfoboxBuilderView.addRowMainImage( field ) )

	    elseif field.Type == "Image" then
	      table:node( InfoboxBuilderView.addRowImage( field ) )

	    elseif field.Type == "Footer" then
	      table:node( InfoboxBuilderView.addRowFooter( field ) )

        elseif field.Type == "Split" then
          table:node( InfoboxBuilderView.addRowSplit( field ) )
        
        elseif field.Type == "Custom" then
          table:node( InfoboxBuilderView.addRowCustom( field ) )

	      end
	 
	    end
  
	output = tostring( Infobox )
  
	return output

end

function InfoboxBuilderView.addRowLine( field )
    
    local row = mw.html.create('tr')
      row:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line' )
      if not HF.isempty( field.CssClass ) then
        row:addClass( field.CssClass )
      end
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-left' )
         :wikitext( field.Label )
         :done()

    if string.len( field.Value ) > tonumber( InfoboxBuilderView.vars.ToggleContentLongerThan ) then
      local cell = row:tag('td')
      cell:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-right' )
        cell:tag('div')
            :addClass('mw-collapsible mw-collapsed ' .. InfoboxBuilderView.vars.Theme .. '-infobox-toggle-content')
            :wikitext( field.Value )
            :done()
      row:done()
    else
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-line-right' )
         :wikitext( field.Value )
         :done()
    end

    return row
 
end
 
function InfoboxBuilderView.addRowHeader( field )
 
    local row = mw.html.create('tr')
    if not HF.isempty( field.CssClass ) then
		row:addClass( field.CssClass )
	end
      row:tag('td')
         :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-header' )
         :attr('colspan', '2') 
         :wikitext( field.Value )
    return row
 
end
 
function InfoboxBuilderView.addRowTitle( field )
  local row = mw.html.create('tr')
    row:tag('td')
       :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-title' )
       :attr('colspan', '2')
       :wikitext( field.Value )
  return row
end

function InfoboxBuilderView.addRowMainImage( field )
  local node = mw.html.create('')

  local row1 = node:tag('tr')
    row1:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image' )
        :attr('colspan', '2')
        :wikitext( field.Value ) 

  if InfoboxBuilderView.vars.MainImageCaption == "On" then
    local row2 = node:tag('tr')
      row2:tag('td')
          :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image-caption' )
          :attr('colspan', '2')
          :wikitext( field.Label )
  end

  return node
end

function InfoboxBuilderView.addRowImage( field )
  local node = mw.html.create('')
  
  local row1 = node:tag('tr')
    row1:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-main-image' )
        :attr('colspan', '2')
        :wikitext( field.Value ) 

  local row2 = node:tag('tr')
    row2:tag('td')
        :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-image-caption' )
        :attr('colspan', '2')
        :wikitext( field.Label )

  return node
end

function InfoboxBuilderView.addRowFooter( field )
  local row = mw.html.create('tr')
    row:tag('td')
       :addClass( InfoboxBuilderView.vars.Theme .. '-infobox-footer' )
       :attr('colspan', '2')
       :wikitext( field.Value )
  return row
end

function InfoboxBuilderView.addRowSplit( field )

  local node = mw.html.create('')
  
  local labelLeft = mw.html.create('td')
    labelLeft:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-label-left' )
  local valueLeft = mw.html.create('td')
    valueLeft:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-value-left' )

  local labelRight = mw.html.create('td')
    labelRight:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-split-label-right' )
  local valueRight = mw.html.create('td')
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

  local row1 = node:tag('tr')
    row1:node( labelLeft )
    row1:node( labelRight )

  local row2 = node:tag('tr')
    row2:node( valueLeft )
    row2:node( valueRight )

  return node

end

function InfoboxBuilderView.addRowCustom( field )
  local node = mw.html.create( field.Label )
        node:addClass( InfoboxBuilderView.vars.Theme .. '-infobox-custom' )
            :wikitext( field.Value )
        if not HF.isempty( field.CssClass ) then
        	node:addClass( field.CssClass )
      	end
  return node
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder.View" global
mw = mw or {}
mw.InfoboxBuilderView = InfoboxBuilderView

package.loaded['mw.InfoboxBuilderView'] = InfoboxBuilderView

return InfoboxBuilderView
