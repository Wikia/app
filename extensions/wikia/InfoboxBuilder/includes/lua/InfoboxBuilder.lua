local InfoboxBuilder = {}

-- Define dependecies
local HF = mw.InfoboxBuilderHF

-- Define var for custom user's module
local CM = {}

-- Define default variables
InfoboxBuilder.vars = {
  Theme                   = "default", -- Adds prefix to CSS classes
  CustomModule            = " ",       -- Defines a path to a module with custom functions
  MainImageCaption        = "Off",     -- Toggles display of Label in the Main Image field
  ToggleContentLongerThan = 1000       -- Makes fields with long values collapsible
}

function InfoboxBuilder.builder( frame )

  local input = InfoboxBuilder.parse( frame.args )
  local Infobox = mw.InfoboxBuilderView.render( input, InfoboxBuilder.vars )
  return Infobox
 
end
 
function InfoboxBuilder.parse( args )
 
  local input = {}
        input.fields   = {}   -- Actual Infobox data
        input.sections = {}   -- Relating headers to lines
        input.vars     = {}   -- Variables useful for styling etc.
 
  -- Distribute args to vars and fields.
 
  local indexes = {} -- Table used to sort indexes of fields
  local fields = {}  -- Temporary fields table
  local f = 0        -- Fields consecutive indice
 
  for k, v in pairs(args) do
 
    local keySplit = HF.explode( ":", tostring(k) )
 
    local index  = tonumber( mw.text.trim( keySplit[1] ) )
    local key    = tostring( mw.text.trim( keySplit[2] ) )
    local value  = tostring( mw.text.trim( v ) )
 
    if index > 0 then
 
      if fields[index] == nil then
        table.insert( indexes, index )
        fields[index] = {}
      end
 
      fields[index][key] = value
 
    else
      if not HF.isempty( mw.text.trim( value ) ) then
        InfoboxBuilder.vars[key] = value
      end
    end
 
  end
  
  input.vars = InfoboxBuilder.vars

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
    elseif input.fields[f]["Type"] == "Line" and currentHeader > 0 then -- Prevent false sections without a header
      if not HF.isempty( input.fields[f]["Value"] ) then
        input.sections[currentHeader] = "On" -- Show header if there is at least one line filled in its section
      end
    end

    if input.fields[f]["Type"] == "Split" then
      input.fields[f]["Label"] = { input.fields[f]["LabelLeft"], input.fields[f]["LabelRight"] }
      input.fields[f]["Value"] = { input.fields[f]["ValueLeft"], input.fields[f]["ValueRight"] }
    end

  end
 
  input = InfoboxBuilder.execute( input )
  
  return input

end

function InfoboxBuilder.execute( input )

  -- Require user's custom module
  if not HF.isempty( mw.text.trim( InfoboxBuilder.vars["CustomModule"] ) ) then
    
    CM = require( mw.text.trim( InfoboxBuilder.vars["CustomModule"] ) )

      -- Execute custom methods
      for index, field in ipairs( input.fields ) do
        
        if type( field.Label ) == "table" then
          if InfoboxBuilder.methodExists( field.LabelMethod ) then
            input.fields[index].Label = CM[ field.LabelMethod ]( field, InfoboxBuilder.vars )
          end
        elseif not HF.isempty( mw.text.trim( field.Label ) ) and InfoboxBuilder.methodExists( field.LabelMethod ) then
          input.fields[index].Label = CM[ field.LabelMethod ]( field, InfoboxBuilder.vars )
        end
        
        if type( field.Value ) == "table" then
          if InfoboxBuilder.methodExists( field.ValueMethod ) then
            input.fields[index].Value = CM[ field.ValueMethod ]( field, InfoboxBuilder.vars )
          end
        elseif not HF.isempty( mw.text.trim( field.Value ) ) and InfoboxBuilder.methodExists( field.ValueMethod ) then
          input.fields[index].Value = CM[ field.ValueMethod ]( field, InfoboxBuilder.vars )
        end
      end

  end

  return input

end

function InfoboxBuilder.methodExists( name )
  local exists = false
  if type( name ) ~= nil then
    if not HF.isempty( name ) then
      if type( CM[ name ] ) == "function" then
        exists = true
      end 
    end
  end
  return exists
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder" global
mw = mw or {}
mw.InfoboxBuilder = InfoboxBuilder

package.loaded['mw.InfoboxBuilder'] = InfoboxBuilder

return InfoboxBuilder
