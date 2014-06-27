local InfoboxBuilder = {}

InfoboxBuilder.test = function()
	return "Hello world!"
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder" global
mw = mw or {}
mw.InfoboxBuilder = InfoboxBuilder

package.loaded['mw.InfoboxBuilder'] = InfoboxBuilder

return InfoboxBuilder
