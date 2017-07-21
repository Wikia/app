## mw.smw.info

This makes the smw parser function `#info` available in lua and allows you to add
tooltips to your output stream. See [the documentation on the SMW homepage][info]
for more information.

This is a sample call:
```lua
-- Module:SMW
local p = {}

-- set with direct return results
function p.info( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end

    local tooltip
    if frame.args[2] then
        tooltip = mw.smw.info( frame.args[1], frame.args[2] )
    else
        tooltip = mw.smw.info( frame.args[1] )
    end

    return tooltip
end
-- another example, info used inside another function
function p.inlineInfo( frame )

    local output = 'This is sample output'

    -- so some stuff

    output = output .. mw.smw.info( 'This is a warning', 'warning' )

    -- some more stuff

    return output
end

return p
```

[info]: https://www.semantic-mediawiki.org/wiki/Help:Adding_tooltips
