local HF = {}

function HF.explode( sep, text )
	local sep, fields = sep or "::", {}
	local pattern = string.format("([^%s]+)", sep)
	
	text:gsub( pattern, function( c ) fields[#fields+1] = c end )

	return fields
end

function HF.isempty(s)
	local result = false

	if type( s ) == "nil" then
		result = true
	elseif type( s ) == "string" then
		if s == "" then
			result = true
		end
	elseif type( s ) == "table" then
		if next( s ) == nil then
			result = true
		end
	end

	return result
end

function HF.firstToUpper( str )
	return ( str:gsub( "^%l", string.upper ) )
end

function HF.round(num, idp)
	local mult = 10^(idp or 0)
	return math.floor( num * mult + 0.5 ) / mult
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder.HF" global
mw = mw or {}
mw.InfoboxBuilderHF = HF

package.loaded['mw.InfoboxBuilderHF'] = HF

return HF
