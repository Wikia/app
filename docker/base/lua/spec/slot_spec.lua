describe('slot server_from_request tests', function()
  local match = require('luassert.match')
  local httpc, slot

  setup(function()
    -- as resty.http requires ngx, it is the easiest to fake the whole module
    package.loaded['resty.http'] = require 'spec.fake_http'

    slot = require('slot_server')

    local http = require('resty.http')
    httpc = http.new()
  end)

  describe('makes correct requests', function()
    before_each(function()
      spy.on(httpc, 'request_uri')
    end)

    it('uses wiki id', function()
      local headers = {};headers['x-mw-wiki-id'] = 123
      slot.server_from_request(nil, nil, headers)
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://slot-switch/slot?wiki-id=123', match._)
    end)

    it('uses domain and path id', function()
      slot.server_from_request('domainvalue', 'pathvalue', {})
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://slot-switch/slot?domain=domainvalue&path=pathvalue', match._)
    end)

    it('handles empty params', function()
      local res, err = slot.server_from_request('', '', {})
      assert.is.falsy(res)
      assert.spy(httpc.request_uri).was.called(0)
    end)

    it('removes query params', function()
      slot.server_from_request('domainvalue', 'path_value?a=b#fragment', {})
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://slot-switch/slot?domain=domainvalue&path=path_value', match._)
    end)

    it('prefers wiki id over domain', function()
      local headers = {};headers['x-mw-wiki-id'] = 4321
      slot.server_from_request('domainvalue', 'path', headers)
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://slot-switch/slot?wiki-id=4321', match._)
    end)

    it('escapes url parameters', function()
      slot.server_from_request('a.fandom.com', '/a/b/c', {})
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://slot-switch/slot?domain=a%2efandom%2ecom&path=%2fa%2fb%2fc', match._)
    end)

    it('can call a custom slot service', function()
      local headers = {};headers['x-mw-wiki-id'] = 123
      slot.server_from_request(nil, nil, headers, 'http://custom/entrypoint')
      assert.spy(httpc.request_uri).was.called(1)
      assert.spy(httpc.request_uri).was.called_with(match._, 'http://custom/entrypoint?wiki-id=123', match._)
    end)
  end)

  describe('returns correct values', function()
    it('maps slot1 correctly', function()
      httpc.request_uri = function()
        return {status=200, body='{"slot":"slot1"}'}, nil
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, err)
      assert.are.equals('php-wikia', res)
    end)

    it('maps slot2 correctly', function()
      httpc.request_uri = function()
        return {status=200, body='{"slot":"slot2"}'}, nil
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, err)
      assert.are.equals('php-ucp', res)
    end)

    it('handles unknown values', function()
      httpc.request_uri = function()
        return {status=200, body='{"slot":"slot3"}'}, nil
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, res)
      assert.is.truthy(err)
    end)

    it('handles status errors', function()
      httpc.request_uri = function()
        return {status=500, body=''}, nil
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, res)
      assert.is.truthy(err)
    end)

    it('handles http errors', function()
      httpc.request_uri = function()
        return nil, 'an error'
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, res)
      assert.is.truthy(err)
    end)

    it('handles non-json responses', function()
      httpc.request_uri = function()
        return {status=200, body='<html><body>aaa</body></html>'}, nil
      end
      local res, err = slot.server_from_request('a.fandom.com', '/', {})
      assert.are.equals(nil, res)
      assert.is.truthy(err)
    end)
  end)
end)
