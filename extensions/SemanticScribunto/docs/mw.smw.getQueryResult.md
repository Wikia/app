## mw.smw.getQueryResult

With `mw.smw.getQueryResult` you can execute an smw query. It returns the result as a lua table for direct use in modules.
For available parameters, please consult the [Semantic Media Wiki documentation hub][smwdoc].

Please see the [return format below](#result) for the difference between this and [`mw.smw.ask`](mw.smw.ask.md).

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

    local queryResult = mw.smw.getQueryResult( frame.args )

    if queryResult == nil then
        return "(no values)"
    end

    if type( queryResult ) == "table" then
        local myResult = ""
        for k,v in pairs( queryResult.results ) do
            if  v.fulltext and v.fullurl then
                myResult = myResult .. k .. " | " .. v.fulltext .. " " .. v.fullurl .. " | " .. "<br/>"
            else
                myResult = myResult .. k .. " | no page title for result set available (you probably specified ''mainlabel=-')"
            end
        end
        return myResult
    end

    return queryResult
end

return p
```

### <a name="result"></a>Return format

The return format matches the data structure delivered by the [api]. You can see an example below:

```lua
-- assuming sample call
local result = mw.smw.getQueryResult( '[[Modification date::+]]|?Modification date|?Last editor is=editor|limit=2|mainlabel=page' )
-- your result would look something like
{
    printrequests = {
        {
            label = 'page',
            redi = null,
            typeid = '_wpg',
            mode = 2,
            format = null
        },
        {
            label = 'Modification date',
            key = '_MDAT',
            redi = null,
            typeid = '_dat',
            mode = 1,
            format = null
        },
        {
            label = 'editor',
            key = '_LEDT',
            redi = null,
            typeid = '_wpg',
            mode = 1,
            format = null
        },
    },
    results = {
        {
            printouts = {
                ['Modification date'] = {
                    {
                        timestamp = 123456789, -- a unix timestamp
                        raw = '1/1970/1/1/23/59/59/0'
                    }
                },
                editor = {
                    {
                        fulltext = 'User:Mwjames',
                        fullurl = 'https://your.host/w/User:Mwjames'
                    }
                }
            },
            fulltext = 'Main page',
            fullurl = 'https://your.host/w/Main_page',
            namespace = 0,
            exist = 1,
            displaytitle = ''
        },
        {
            printouts = {
                ['Modification date'] = {
                    {
                        timestamp = 123456790, -- a unix timestamp
                        raw = '1/1970/1/2/0/0/1/0'
                    }
                },
                editor = {
                    {
                        fulltext = 'User:Matthew-a-thompson',
                        fullurl = 'https://your.host/w/User:Matthew-a-thompson'
                    }
                }
            },
            fulltext = 'User:Matthew A Thompson',
            fullurl = 'https://your.host/w/User:Matthew_A_Thompson',
            namespace = 2,
            exist = 1,
            displaytitle = ''
        },
    },
    serializer = 'SMW\Serializers\QueryResultSerializer',
    version = 0.11,
    meta = {
        hash = '5b2187c3df541ca08d378b3690a31173',
        count = 2,  -- number of results
        offset = 0, -- used offset
        source = null,
        time = 0.000026,
    }
}
```

Calling `{{#invoke:smw|ask|[[Modification date::+]]|?Modification date|limit=0|mainlabel=-}}` only
makes sense in a template or another module that can handle `table` return values.

[smwdoc]: https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki
[api]: https://www.semantic-mediawiki.org/wiki/Serialization_%28JSON%29