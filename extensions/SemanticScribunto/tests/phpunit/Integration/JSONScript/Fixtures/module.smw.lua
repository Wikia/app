-- Module:SMW
local p = {}

function p.ask( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end

    local queryResult = mw.smw.ask( frame.args )

    return convertResultTableToString( queryResult )
end

function p.getQueryResult( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end

    local queryResult = mw.smw.getQueryResult( frame.args )

    --return mw.dumpObject( queryResult )
    return convertResultTableToString( queryResult.results )
end

function p.info( frame )
    if not mw.smw then
        return "mw.smw module not found"
    end

    if frame.args[1] == nil then
        return "no parameter found"
    end

    return mw.smw.info( frame.args[1], frame.args[2] )
end

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

function p.setWithSeparator( frame )
    if not mw.smw then
        return "mw.smw module not found"
    end

    if not frame.args.sep or not frame.args.property or not frame.args.data then
        return p.set( frame )
    end

    local query = {
        frame.args.property .. '=' .. frame.args.data,
        '+sep=' .. frame.args.sep
    }

    local result = mw.smw.set( query )

    if result == true then
        return 'Your data was stored successfully'
    else
        return 'An error occurred during the storage process. Message reads ' .. result.error
    end
end

function p.subobject( frame )

    if not mw.smw then
        return "mw.smw module not found"
    end

    local args = {}
    for arg, value in pairs(frame.args) do
		args[arg] = mw.text.trim(value)
	end

    local subobjectId
    if args.subobjectId or args.SubobjectId then
        subobjectId = args.subobjectId or args.SubobjectId
        args.subobjectId = nil
		args.SubobjectId = nil
    end
    local result = mw.smw.subobject( args, subobjectId )
    if result == true then
        return 'Your data was stored successfully in a subobject'
    else
        return 'An error occurred during the subobject storage process. Message reads ' .. result.error
    end
end

function convertResultTableToString( queryResult )

    local queryResult = queryResult

    if queryResult == nil or #queryResult == 0 then
        return "(no values)"
    end

    if type( queryResult ) == "table" then
        local myResult = ""
        for num, row in ipairs( queryResult ) do
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

function varDump( entity, indent )
    local entity = entity
    local indent = indent and indent or ''
    if type( entity ) == 'table' then
        local output = '(table)[' .. #entity .. ']:'
        indent = indent .. '  '
        for k, v in pairs( entity ) do
            output = output .. '\n' .. indent .. '(' .. type(k) .. ') ' .. k .. ': ' .. varDump( v, indent )
        end
        return output
    elseif type( entity ) == 'function' then
        return '(function)'
    elseif type( entity ) == 'bool' then
        return '(bool)' .. ( entity and 'TRUE' or 'FALSE' )
    else
        return '(' .. type( entity ) .. ') ' .. entity
    end
end

return p
