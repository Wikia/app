
local setmetatable, getmetatable, tostring, load, pairs, ipairs, next, assert, unpack
	= setmetatable, getmetatable, tostring, load, pairs, ipairs, next, assert, unpack
local tconcat
	= table.concat
local strformat
	= string.format
local cowrap, yield
    = coroutine.wrap, coroutine.yield
local _G = _G

setfenv(1,{})

local sb_meta = {
	__tostring = function(self)  return tconcat(self);  end;
	__call = function(self,v)  self[#self+1] = tostring(v); return self;  end;
	__index = {
		add = function(self,v)
			self[#self+1] = tostring(v)
			return self
		end;
		addquoted = function(self, v)
			self[#self+1] = strformat('%q', tostring(v))
			return self
		end;
		compile = function(self, chunk_name)
			local localvars = self.localvars
			local params = self.params
			if not next(localvars) and not params then
                local chunkthread = cowrap(function()
                    for _,chunk in ipairs(self) do
                        yield(chunk)
                    end
                    yield(nil)
                end)
                return assert(load(chunkthread,chunk_name))
			end
			local locals, ilocals = {}, 0
			local chunkthread = cowrap(function()
				if next(localvars) then
					yield 'local '
					for k,v in pairs(localvars) do
						yield(k)
						if next(localvars,k) then
							yield ','
						end
						ilocals = ilocals+1
						locals[ilocals] = v
					end
					yield ' = ...; '
				end
				yield 'return function('
				if params then
					yield(params)
				end
				yield ') '
				for _,chunk in ipairs(self) do
					yield(chunk)
				end
				yield '\nend'
				yield(nil)
			end)
			local funcbuilder = assert(load(chunkthread,chunk_name))
			return funcbuilder(unpack(locals,1,ilocals))
		end;
		localvar = function(self, val)
			local lv = self.localvars
			local i = 1
			local lvname
			while true do
				lvname = '__lv_' .. i
				if not lv[lvname] then
					break
				end
				i = i + 1
			end
			lv[lvname] = val
			return lvname
		end;
	}
}

local function stringbuilder()
	return setmetatable({localvars={}}, sb_meta)
end

_G.stringbuilder = stringbuilder

return stringbuilder
