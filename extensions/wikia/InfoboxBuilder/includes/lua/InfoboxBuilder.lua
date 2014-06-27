local InfoboxBuilder = {}
local php

InfoboxBuilder.test = function()
	return "Hello world!"
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilder" global
mw = mw or {}
mw.ext = mw.ext or {}
mw.ext.InfoboxBuilder = InfoboxBuilder

package.loaded['mw.ext.InfoboxBuilder'] = InfoboxBuilder

return InfoboxBuilder
