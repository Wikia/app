## mw.smw.getPropertyType

The function `mw.smw.getPropertyType` provides an easy way to get the type of a given property.
Note however, that it uses the smw internal property types, not the one you might be [used to](https://www.semantic-mediawiki.org/wiki/Help:List_of_datatypes).

```lua
-- Module:SMW
local p = {}

-- Return property type
function p.type(frame)

    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end
    local pType = mw.smw.getPropertyType( frame.args[1] )

    if pType == nil then
        return "(no values)"
    end

    return pType
end

return p
```

`{{#invoke:smw|type|Modification date}}` can be used as it returns a simple string value such as `_dat`.
