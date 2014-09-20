
local strfind, strsub, strmatch, gmatch
	= string.find, string.sub, string.match, string.gmatch
local floor
	= math.floor
local tostring, setmetatable, select
	= tostring, setmetatable, select
local cowrap, yield
	= coroutine.wrap, coroutine.yield
local _G = _G

local function expectmatch_aux(sr, start, stop, ...)
	if not start then
		sr.lastmatch = nil
		return false
	else
		sr._pos = stop + 1
		if select('#', ...) > 1 then
			sr.lastmatch = {select(2, ...)}
			return select(2, ...)
		else
			sr.lastmatch = {...}
			return ...
		end
	end
end

local stringreader_meta = {
	__index = {
		expect = function(self, patt, exact)
			local pos = self._pos
			if exact then
				if strsub(self._source_text, pos, pos+#patt-1) == patt then
					self._pos = pos+#patt
					self.lastmatch = patt
					return patt
				else
					return false
				end
			end
			if (strsub(patt,1,1) == '^') then
				if (pos > 1) then
					return nil
				end
				patt = strsub(patt,2)
			end
			patt = '^(' .. patt .. ')'
			if (strsub(patt,-2) == '$)') and (strsub(patt,-3,-3) ~= '%') then
				patt = strsub(patt,1,-3) .. ')$'
			end
			return expectmatch_aux(self, strfind(self._source_text, patt, pos))
		end;
		endofinput = function(self)
			return self._pos > #self._source_text;
		end;
		skipwhitespace = function(self)
            self._pos = strmatch(self._source_text, '%s*()', self._pos)
		end;
		skipto = function(self, patt, exact)
			local new_pos = strfind(self._source_text, patt, self._pos, exact)
			if new_pos then
				self._pos = new_pos
				return true
			else
				return false
			end
		end;
		readchar = function(self)
			local pos = self._pos
			local c = strsub(self._source_text,pos,pos)
			self._pos = pos + 1
			return c
		end;
		peekchar = function(self)
			local pos = self._pos
			return strsub(self._source_text,pos,pos)
		end;
		pos = function(self, new_pos, relative)
			if new_pos then
				self._pos = relative and (self._pos+new_pos) or new_pos
				return self
			else
				return self._pos
			end
		end;
		getlines = function(self)
			local lines = self._lines
			if not lines then
				lines = {1}
				for linestart in gmatch(self._source_text, '\n()') do
					lines[#lines+1] = linestart
				end
				self._lines = lines
			end
			return lines
		end;
		pos2d = function(self, pos, relative)
			pos = pos and (relative and (self._pos+pos) or pos) or self._pos
			if (pos < 1) then  return nil;  end
			local lines = self:getlines()
			
			local low, high = 1, #lines
			while true do
				local line_num = floor((low + high) / 2)
				local line_start = lines[line_num]
				if (line_start > pos) then
					high = line_num - 1
				else
					local next_line_start = lines[line_num+1]
					if (next_line_start == nil) or (next_line_start > pos) then
						return line_num, pos - line_start + 1
					end
					low = line_num + 1
				end
			end
		end;
		source_text = function(self, new_value)
			if new_value then
				self._source_text = new_value
			else
				return self._source_text
			end
		end;
		rest = function(self)
			return strsub(self._source_text, self._pos)
		end;
	}
}

local function stringreader(source_text)
	return setmetatable({_source_text=tostring(source_text), _pos=1}, stringreader_meta)
end

_G.stringreader = stringreader

return stringreader
