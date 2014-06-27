local HF = {}

function HF.explode( sep, text )
  local sep, fields = sep or "::", {}
  local pattern = string.format("([^%s]+)", sep)
  text:gsub(pattern, function(c) fields[#fields+1] = c end)
  return fields
end

function HF.trim(s)
  if type(s) == "string" then
    return (s:gsub("^%s*(.-)%s*$", "%1"))
  else
    return false
  end
end

function HF.isempty(s)
  local result = false
  if type(s) == "nil" then
    result = true
  elseif type(s) == "string" then
    if s == "" then
      result = true
    end
  elseif type(s) == "table" then
    if next(s) == nil then
      result = true
    end
  end
  return result
end

function HF.print_r( t, name, indent )
  local cart     -- a container
  local autoref  -- for self references
 
  --[[ counts the number of elements in a table
  local function tablecount(t)
     local n = 0
     for _, _ in pairs(t) do n = n+1 end
     return n
  end
  ]]
  -- (RiciLake) returns true if the table is empty
  local function isemptytable(t) return next(t) == nil end
 
  local function basicSerialize (o)
     local so = tostring(o)
     if type(o) == "function" then
        local info = debug.getinfo(o, "S")
        -- info.name is nil because o is not a calling level
        if info.what == "C" then
           return string.format("%q", so .. ", C function")
        else 
           -- the information is defined through lines
           return string.format("%q", so .. ", defined in (" ..
               info.linedefined .. "-" .. info.lastlinedefined ..
               ")" .. info.source)
        end
     elseif type(o) == "number" or type(o) == "boolean" then
        return so
     else
        return string.format("%q", so)
     end
  end
 
  local function addtocart (value, name, indent, saved, field)
     indent = indent or ""
     saved = saved or {}
     field = field or name
 
     cart = cart .. indent .. field
 
     if type(value) ~= "table" then
        cart = cart .. " = " .. basicSerialize(value) .. ";\n"
     else
        if saved[value] then
           cart = cart .. " = {}; -- " .. saved[value] 
                       .. " (self reference)\n"
           autoref = autoref ..  name .. " = " .. saved[value] .. ";\n"
        else
           saved[value] = name
           --if tablecount(value) == 0 then
           if isemptytable(value) then
              cart = cart .. " = {};\n"
           else
              cart = cart .. " = {\n"
              for k, v in pairs(value) do
                 k = basicSerialize(k)
                 local fname = string.format("%s[%s]", name, k)
                 field = string.format("[%s]", k)
                 -- three spaces between levels
                 addtocart(v, fname, indent .. "   ", saved, field)
              end
              cart = cart .. indent .. "};\n"
           end
        end
     end
  end
 
  name = name or "__unnamed__"
  if type(t) ~= "table" then
     return name .. " = " .. basicSerialize(t)
  end
  cart, autoref = "", ""
  addtocart(t, name, indent)
  return cart .. autoref
end

function HF.firstToUpper( str )
return (str:gsub("^%l", string.upper))
end

function HF.round(num, idp)
  local mult = 10^(idp or 0)
  return math.floor(num * mult + 0.5) / mult
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder.HF" global
mw = mw or {}
mw.InfoboxBuilderHF = HF

package.loaded['mw.InfoboxBuilderHF'] = HF

return HF