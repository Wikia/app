local http = require('resty.http')
local url = require('socket.url')
local json = require('cjson')

local httpc = http.new()
httpc:set_timeout(1000) -- 1s timeout for fetching slot info

local service_url = 'http://slot-switch/slot'
local slot_mapping = {
  slot1='php-wikia',
  slot2='php-ucp',
}

local params = ''

local wiki_id = ngx.req.get_headers()['x-mw-wiki-id']
if wiki_id then
  params = '?wiki_id=' .. url.escape(wiki_id) -- or ngx.escape_uri
else
  local path = url.parse(ngx.var.request_uri).path
  params = '?domain=' .. url.escape(ngx.var.host) .. '&path=' .. url.escape(path)
end

local res, err = httpc:request_uri(service_url .. params, {
  method = 'GET',
  keepalive = true
})


if err == nil then
  if res.status == 200 then
    local json_res = json.decode(res.body)
    if slot_mapping[json_res['slot']] then
      ngx.var.fastcgi = slot_mapping[json_res['slot']]
    else
      ngx.log(ngx.STDERR, 'Unknown slot name ' .. slot_mapping[json_res['slot']])
    end
  else
    ngx.log(ngx.STDERR, 'Unexpected response status ' .. res.status)
  end
else
 ngx.log(ngx.STDERR, 'Error while fetching slot info ' .. err)
end
