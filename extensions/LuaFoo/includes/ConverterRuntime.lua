function pfunc_if( condition, trueResult, falseResult )
	local condition = string.gsub( condition, "^%s+(.*)-%s+$", "%1" )
	local result
	if condition == '' then
		result = falseResult
	else
		result = trueResult
	end
	result = string.gsub( result, "^%s+(.*)-%s+$", "%1" )
	return result
end

function mw_trim( s )
	return string.gsub( s, "^%s+(.*)-%s+$", "%1" )
end


