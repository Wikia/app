#!/usr/bin/env lua
-- Lua parser extensions for MediaWiki - Wrapper for Lua interpreter
-- (c) 2008 Fran Rogers - see 'COPYING' for license

-- Creates a new sandbox environment for scripts to safely run in.
function make_sandbox()
  -- Dummy function that returns nil, to quietly replace unsafe functions
  local function dummy(...)
    return nil
  end

  -- Deep-copy an object; optionally replace all its leaf members with the
  -- value 'override' if it's non-nil
  local function deepcopy(object, override)
    local lookup_table = {}
    local function _copy(object, override)
      if type(object) ~= "table" then
	return object
      elseif lookup_table[object] then
	return lookup_table[object]
      end
      local new_table = {}
      lookup_table[object] = new_table
      for index, value in pairs(object) do
	if override ~= nil then
	  value = override
	end
	new_table[_copy(index)] = _copy(value, override)
      end
      return setmetatable(new_table, _copy(getmetatable(object), override))
    end
    return _copy(object, override)
  end

  -- Our new environment
  local env = {}

  -- "_OUTPUT" will accumulate the results of print() and friends
  env._OUTPUT = ""

  -- _OUTPUT wrapper for io.write()
  local function writewrapper(...)
    local out = ""
    for n = 1, select("#", ...) do
      if out == "" then
	out = tostring(select(n, ...))
      else
	out = out .. tostring(select(n, ...))
      end
    end
    env._OUTPUT = env._OUTPUT .. out
  end

  -- _OUTPUT wrapper for io.stdout:output()
  local function outputwrapper(file)
    if file == nil then
      local file = {}
      file.close = dummy
      file.lines = dummy
      file.read = dummy
      file.flush = dummy
      file.seek = dummy
      file.setvbuf = dummy
      function file:write(...) writewrapper(...); end
      return file
    else
      return nil
    end
  end

  -- _OUTPUT wrapper for print()
  local function printwrapper(...)
    local out = ""
    for n = 1, select("#", ...) do
      if out == "" then
	out = tostring(select(n, ...))
      else
	out = out .. '\t' .. tostring(select(n, ...))
      end
    end
    env._OUTPUT =env._OUTPUT .. out .. "\n"
  end

  -- Safe wrapper for loadstring()
  local oldloadstring = loadstring
  local function safeloadstring(s, chunkname)
    local f, message = oldloadstring(s, chunkname)
    if not f then
      return f, message
    end
    setfenv(f, getfenv(2))
    return f
  end

  -- Populate the sandbox environment
  env.assert = _G.assert
  env.error = _G.error
  env._G = env
  env.ipairs = _G.ipairs
  env.loadstring = safeloadstring
  env.next = _G.next
  env.pairs = _G.pairs
  env.pcall = _G.pcall
  env.print = printwrapper
  env.write = writewrapper
  env.select = _G.select
  env.tonumber = _G.tonumber
  env.tostring = _G.tostring
  env.type = _G.type
  env.unpack = _G.unpack
  env._VERSION = _G._VERSION
  env.xpcall = _G.xpcall
  env.coroutine = deepcopy(_G.coroutine)
  env.string = deepcopy(_G.string)
  env.string.dump = nil
  env.table = deepcopy(_G.table)
  env.math = deepcopy(_G.math)
  env.io = {}
  env.io.write = writewrapper
  env.io.flush = dummy
  env.io.type = typewrapper
  env.io.output = outputwrapper
  env.io.stdout = outputwrapper()
  env.os = {}
  env.os.clock = _G.os.clock
  -- env.os.date = _G.os.date
  env.os.difftime = _G.os.difftime
  env.os.time = _G.os.time

  -- Return the new sandbox environment
  return env
end

-- Creates a new debug hook that aborts with 'error("LOC_LIMIT")' after 
-- 'maxlines' lines have been passed, or 'error("RECURSION_LIMIT")' after 
-- 'maxcalls' levels of recursion have been entered.
function make_hook(maxlines, maxcalls, diefunc)
  local lines = 0
  local calls = 0
  function _hook(event, ...)
    if event == "line" then
      lines = lines + 1
      if lines > maxlines then
	error("LOC_LIMIT")
      end
    elseif event == "call" then
      calls = calls + 1
      if calls > maxcalls then
	error("RECURSION_LIMIT")
      end
    elseif event == "return" then
      calls = calls - 1
    end
  end
  return _hook
end

-- Creates and returns a function, 'wrap(input)', which reads a string into 
-- a Lua chunk and executes it in a persistent sandbox environment, returning 
-- 'output, err' where 'output' is the combined output of print() and friends 
-- from within the chunk and 'err' is either nil or an error incurred while 
-- executing the chunk; or halting after 'maxlines' lines or 'maxcalls' levels 
-- of recursion.
function make_wrapper(maxlines, maxcalls)
  -- Create the debug hook and sandbox environment.
  local hook = make_hook(maxlines, maxcalls)
  local env = make_sandbox()
  
  -- The actual 'wrap()' function.
  -- All of the above variables will be bound in its closure.
  function _wrap(chunkstr)
    local chunk, err, done
    -- Clear any leftover output from the last call
    env._OUTPUT = ""
    err = nil
    
    -- Load the string into a chunk; fail on error
    chunk, err = loadstring(chunkstr)
    if err ~= nil then
      return nil, err
    end
    
    -- Set the chunk's environment, enable the debug hook, and execute it
    setfenv(chunk, env)
    co = coroutine.create(chunk)
    debug.sethook(co, hook, "crl")
    done, err = coroutine.resume(co)
    
    if done == true then
      err = nil
    end
    
    -- Collect and return the results
    return env._OUTPUT, err
  end
  return _wrap
end

-- Listen on stdin for Lua chunks, parse and execute them, and print the 
-- results of each on stdout.
function main(arg)
  if #arg ~= 2 then
    io.stderr:write(string.format("usage: %s MAXLINES MAXCALLS\n", arg[0]))
    os.exit(1)
  end

  -- Create a wrapper function, wrap()
  local wrap = make_wrapper(tonumber(arg[1]), tonumber(arg[2]))

  -- Turn off buffering, and loop through the input
  io.stdout:setvbuf("no")
  while true do
    -- Read in a chunk
    local chunkstr = ""
    while true do
      local line = io.stdin:read("*l")
      if chunkstr == "" and line == nil then
	-- On EOF, exit.
	os.exit(0)
      elseif line == "." or line == nil then
	-- Finished this chunk; move on to the next step
	break
      elseif chunkstr ~= "" then
	chunkstr = chunkstr .. "\n" .. line
      else
	chunkstr = line
      end
    end

    -- Parse and execute the chunk
    local res, err
    res, err = wrap(chunkstr, env, hook)

    -- Write out the results
    if err == nil then
      io.stdout:write("'", res, "', true\n.\n")
    else
      io.stdout:write("'", err, "', false\n.\n")
    end
  end
end

-- If called as a script instead of imported as a library, run main().
if arg ~= nil then
  main(arg)
end
