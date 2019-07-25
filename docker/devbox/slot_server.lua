local http = require('resty.http')
local url = require('socket.url')
local json_safe = require('cjson.safe')

local default_slot_service_url = 'http://slot-switch/slot'
local slot_to_server = {
  slot1='php-wikia',
  slot2='php-ucp',
}

local module = {}

-- Fetches slot info based on MediaWiki request
-- @param req_host host part of the MediaWiki request
-- @param req_uri path part of the MediaWiki request, can contain query params
-- @param headers request headers passed to Nginx
-- @param service optional address of slot service, will use 'http://slot-switch/slot' if empty
-- @return Nginx fastcgi server that sould handle MediaWiki request (or nil in case of errors), error message
function module.server_from_request(req_host, req_uri, headers, service)
  local httpc = http.new()
  httpc:set_timeout(1000) -- 1s timeout for fetching slot info

  local params = ''
  local wiki_id = headers['x-mw-wiki-id']
  if wiki_id then
    params = '?wiki-id=' .. url.escape(wiki_id)
  else
    local parsed = url.parse(req_uri)
    if parsed == nil then
      return nil, 'Invalid request uri' .. req_uri
    end
    params = '?domain=' .. url.escape(req_host) .. '&path=' .. url.escape(parsed.path)
  end

  service = service or default_slot_service_url
  local res, err = httpc:request_uri(service .. params, {
    method = 'GET',
    keepalive = true
  })

  if err then
    return nil, 'Error while fetching slot info ' .. err
  end

  if res.status ~= 200 then
    return nil, 'Unexpected response status ' .. res.status
  end

  local json_res, json_err = json_safe.decode(res.body)
  if not json_res then
	return nil, 'Got invalid json response' .. json_err
  end

  if slot_to_server[json_res['slot']] then
	return slot_to_server[json_res['slot']], nil
  end

  return nil, 'Unknown slot name ' .. json_res['slot']
end

return module
