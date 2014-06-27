local InfoboxBuilderView = {}

InfoboxBuilderView.test = function()
	return "Hello world!"
end

php = mw_interface
mw_interface = nil

-- Register module as "mw.InfoboxBuilderView" global
mw = mw or {}
mw.InfoboxBuilderView = InfoboxBuilderView

package.loaded['mw.InfoboxBuilderView'] = InfoboxBuilderView

return InfoboxBuilder
