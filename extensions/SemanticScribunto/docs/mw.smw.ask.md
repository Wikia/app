## mw.smw.ask

With `mw.smw.ask` you can execute an smw query. It returns the result as a lua table for direct use in modules.
For available parameters, please consult the [Semantic Media Wiki documentation hub][smwdoc].

A notable difference is that the parameter `link` is not supported at the moment.

Please see the [return format below](#result) for the difference between this and [`mw.smw.getQueryResult`](mw.smw.getQueryResult.md).

This is a sample call:
```lua
-- Module:SMW
local p = {}

-- Return results
function p.ask(frame)

    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end

    local queryResult = mw.smw.ask( frame.args )

    if queryResult == nil then
        return "(no values)"
    end

    if type( queryResult ) == "table" then
        local myResult = ""
        for num, row in pairs( queryResult ) do
            myResult = myResult .. '* This is result #' .. num .. '\n'
            for property, data in pairs( row ) do
                local dataOutput = data
                if type( data ) == 'table' then
                    dataOutput = mw.text.listToText( data, ', ', ' and ')
                end
                myResult = myResult .. '** ' .. property .. ': ' .. dataOutput .. '\n'
            end
        end
        return myResult
    end

    return queryResult
end

-- another example, ask used inside another function
function p.inlineAsk()

    local entityAttributes = {
        'has name=name',
        'has age=age',
        'has color=color'
    }
    local category = 'thingies'
    
    -- build query
    local query = {}
    table.insert(query, '[[Category:' .. category .. ']]')
    
    for _, v in pairs( entityAttributes ) do
        table.insert( query, '?' .. v )
    end
    
    query.mainlabel = 'origin'
    query.limit = 10
    
    local result = mw.smw.ask( query )
    
    local output = ''
    if result and #result then
    
        for num, entityData in pairs( result ) do
            -- further process your data
            output = output .. entityData.origin .. ' (' .. num .. ') has name ' .. entityData.name
                .. ', color ' .. entityData.color .. ', and age ' .. entityData.age
        end
    end
    
    return output
end

return p
```

### <a name="result"></a>Return format

The return format is a simple collection of tables (one per result set) holding your smw data,
each indexed by property names or labels respectively. You can see an example below:

```lua
-- assuming sample call
local result = mw.smw.ask( '[[Modification date::+]]|?#-=page|?Modification date|?Last editor is=editor|?page author=authors|limit=2|mainlabel=-' )
-- same as
local result = mw.smw.ask{
    '[[Modification date::+]]', '?#-=page', '?Modification date', '?Last editor is=editor', '?page author#-=authors', 
    limit = 2, mainlabel = '-'
} 
-- your result would look something like
{
    {
        ['Modification date'] = '1 January 1970 23:59:59',
        authors = {
            'User:Mwjames', 'User:Oetterer'
        },
        editor = '[[:User:Mwjames|User:Mwjames]]',
        page = 'Main page'
    },
    {
        ['Modification date'] = '2 January 1970 00:00:42',
        authors = 'User:Oetterer',
        editor = '[[:User:Oetterer|User:Oetterer]]',
        page = 'User:Oetterer'
    },
}
-- please note the unlinking of properties 'page authors', and mainlabel '?' by using the #- operator
-- note also: unlinking via parameter link is not supported at this point
```

This function is meant to be used inside lua modules and should not be directly exposed to #invoke.

[smwdoc]: https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki
