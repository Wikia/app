## mw.smw.set

This makes the smw parser function `#set` available in lua and allows you to store data in your smw store.
The usage is similar to that of the [parser function][set], however be advised to read the notes under the example.

This is a sample call:
```lua
-- Module:SMW
local p = {}

-- set with return results
function p.set( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    local result = mw.smw.set( frame.args )
    if result == true then
        return 'Your data was stored successfully'
    else
        return 'An error occurred during the storage process. Message reads ' .. result.error
    end
end

-- another example, set used inside another function
function p.inlineSet( frame )

    local dataStoreTyp1 = {}

    dataStoreTyp1['my property1'] = 'value1'
    dataStoreTyp1['my property2'] = 'value2'
    dataStoreTyp1['my property3'] = 'value3'

    local result = mw.smw.set( dataStoreTyp1 )

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

    local result = mw.smw.set( dataStoreType2 )

    if result == true then
        -- everything ok
    else
        -- error message to be found in result.error
    end
end

return p
```
As you can see, you can supply arguments to `mw.smw.set` as either an associative array and as lua table.

**Note** however: lua does not maintain the order in an associative array. Using parameters for `set` like the [separator](https://www.semantic-mediawiki.org/wiki/Help:Setting_values/Working_with_the_separator_parameter)
or the [template parameter](https://www.semantic-mediawiki.org/wiki/Help:Setting_values/Working_with_the_template_parameter) requires a strict parameter order
in which case you must use the table format as shown with *dataStoreType2* in the example above.

SMW.set can be invoked via `{{#invoke:smw|set|my property1=value1|my property2=value2}}`. However, using the lua function in this way makes little sense.
It is designed to be used inside your modules.

[set]: https://www.semantic-mediawiki.org/wiki/Help:Setting_values
