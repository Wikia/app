local Builder = {}

Builder.test = function()
	return "Hello world!"
end

mw_interface = nil

-- Register module as "mw.InfoboxBuilder" global
mw = mw or {}
mw.Infobox = mw.Infobox or {}
mw.Infobox.Builder = Builder

package.loaded['mw.Infobox.Builder'] = Builder

return Builder
