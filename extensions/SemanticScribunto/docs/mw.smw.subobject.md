## mw.smw.subobject

This makes the smw parser function `#subobject` available in lua and allows you to store data in your smw store as subobjects.
The usage is similar to that of the [parser function][subobject] but be advised to read the notes for [mw.smw.info](mw.smw.info.md) as well.

This is a sample call:
```lua
-- Module:SMW
local p = {}

-- subobject with return results
function p.subobject( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    if #frame.args == 0 then
        return "no parameters found"
    end
    local result = mw.smw.subobject( frame.args )
    if result == true then
        return 'Your data was stored successfully in a subobject'
    else
        return 'An error occurred during the subobject storage process. Message reads ' .. result.error
    end
end
-- another example, subobject used inside another function
function p.inlineSubobject( frame )

    local dataStoreTyp1 = {}

    dataStoreTyp1['my property1'] = 'value1'
    dataStoreTyp1['my property2'] = 'value2'
    dataStoreTyp1['my property3'] = 'value3'

    local result = mw.smw.subobject( dataStoreTyp1 )

    if result == true then
        -- everything ok
    else
        -- error message to be found in result.error
    end

    local dataStoreType2 = {
        'my property1=value1',
        'my property2=value2',
        'my property3=value3',
    }

    local result = mw.smw.subobject( dataStoreType2 )

    if result == true then
        -- everything ok
    else
        -- error message to be found in result.error
    end

    -- you can also manually set a subobject id. however, this is not recommended

    local result = mw.smw.subobject( dataStoreType2, 'myPersonalId' )
    if result == true then
        -- everything ok
    else
        -- error message to be found in result.error
    end
end

return p
```

[subobject]: https://www.semantic-mediawiki.org/wiki/Help:Adding_subobjects
