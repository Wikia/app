--[[
	Unit tests for the mw.capiunto.Infobox._render module

	@license GNU GPL v2+
	@author Marius Hoch < hoo@online.de >
]]

local testframework = require 'Module:TestFramework'
local render = mw.capiunto.Infobox._render

local function testExists()
	return type( mw.capiunto.Infobox._render )
end

-- Tests

local function testRenderWrapper( options )
	local html = mw.html.create( '' )

	render.renderWrapper( html, options )
	return html
end

local function testRenderHeader( options, header, class )
	local html = mw.html.create( '' )

	render.renderHeader( html, options, header, class )
	return html
end

local function testRenderRow( options, row )
	local html = mw.html.create( '' )

	render.renderRow( html, options, row )
	return html
end

local function testRenderWikitext( text )
	local html = mw.html.create( '' )

	render.renderWikitext( html, text )
	return html
end

local function testRenderTitle( options )
	local html = mw.html.create( '' )

	render.renderTitle( html, options )
	return html
end

local function testRenderSubHeader( options )
	local html = mw.html.create( '' )

	render.renderSubHeaders( html, options )
	return html
end

local function testRenderTopRow( options )
	local html = mw.html.create( '' )

	render.renderTopRow( html, options )
	return html
end

local function testRenderBottomRow( options )
	local html = mw.html.create( '' )

	render.renderBottomRow( html, options )
	return html
end

local function testRenderImages( options )
	local html = mw.html.create( '' )

	render.renderImages( html, options )
	return html
end

local function testRenderRows( options )
	local html = mw.html.create( '' )

	render.renderRows( html, options )
	return html
end

-- Tests
local tests = {
	{ name = 'mw.capiunto.Infobox._render exists', func = testExists, type='ToString',
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderWrapper 1', func = testRenderWrapper, type='ToString',
	  args = { {} },
	  expect = { '<table class="mw-capiunto-infobox" cellspacing="3" style="border-spacing:3px;width:22em;"></table>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderWrapper 2', func = testRenderWrapper, type='ToString',
	  args = { { isChild = true } },
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderWrapper 3', func = testRenderWrapper, type='ToString',
	  args = { { isChild = true, title = 'foo' } },
	  expect = { 'foo' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderWrapper 4', func = testRenderWrapper, type='ToString',
	  args = { { isSubbox = true } },
	  expect = {
		'<table class="mw-capiunto-infobox mw-capiunto-infobox-subbox" cellspacing="3" ' ..
		'style="border-spacing:3px;"></table>'
	  }
	},
	{ name = 'mw.capiunto.Infobox._render.renderHeader 1', func = testRenderHeader, type='ToString',
	  args = { {}, 'foo' },
	  expect = { '<tr><th colspan="2" style="text-align:center;">foo</th></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderHeader 2', func = testRenderHeader, type='ToString',
	  args = { {}, 'foo', 'bar' },
	  expect = { '<tr><th colspan="2" class="bar" style="text-align:center;">foo</th></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderHeader 3', func = testRenderHeader, type='ToString',
	  args = { { headerStyle = 'what:ever' }, 'foo', 'bar' },
	  expect = { '<tr><th colspan="2" class="bar" style="text-align:center;what:ever;">foo</th></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRow 1', func = testRenderRow, type='ToString',
	  args = { {}, { data = 'foo' } },
	  expect = { '<tr><td colspan="2" style="text-align:center;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRow 2', func = testRenderRow, type='ToString',
	  args = { {}, { data = 'foo', label = 'bar' } },
	  expect = { '<tr><th scope="row" style="text-align:left;">bar</th><td>\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRow 3', func = testRenderRow, type='ToString',
	  args = { { labelStyle = 'a:b' }, { data = 'foo', label = 'bar' } },
	  expect = { '<tr><th scope="row" style="text-align:left;a:b;">bar</th><td>\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRow 4', func = testRenderRow, type='ToString',
	  args = { {}, { data = 'foo', class='meh', dataStyle="a:b" } },
	  expect = { '<tr><td colspan="2" class="meh" style="text-align:center;a:b;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderWikitext 1', func = testRenderWikitext, type='ToString',
	  args = { 'abc' },
	  expect = { '<tr><td colspan="2" style="text-align:center;">\nabc</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderTitle 1', func = testRenderTitle, type='ToString',
	  args = { { title = 'cd' } },
	  expect = { '<caption>cd</caption>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderTitle 2', func = testRenderTitle, type='ToString',
	  args = { { title = 'cd', titleClass = 'ab', titleStyle = 'wikidata:awesome' } },
	  expect = { '<caption class="ab" style="wikidata:awesome;">cd</caption>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderSubHeaders 1', func = testRenderSubHeader, type='ToString',
	  args = { { subHeaders = { { text = 'foo' } } } },
	  expect = { '<tr><td colspan="2" style="text-align:center;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderSubHeaders 2', func = testRenderSubHeader, type='ToString',
	  args = { { subHeaders = { { text = 'foo', style = 'a' } } } },
	  expect = { '<tr><td colspan="2" style="text-align:center;a;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderTopRow 1', func = testRenderTopRow, type='ToString',
	  args = { {} },
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderTopRow 2', func = testRenderTopRow, type='ToString',
	  args = { { top = 'foo' } },
	  expect = { '<tr><th colspan="2" style="font-weight:bold;text-align:center;font-size:125%;">foo</th></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderTopRow 3', func = testRenderTopRow, type='ToString',
	  args = { { top = 'foo', topClass = 'a', topStyle='b' } },
	  expect = { '<tr><th colspan="2" class="a" style="font-weight:bold;text-align:center;font-size:125%;b;">foo</th></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderBottomRow 1', func = testRenderBottomRow, type='ToString',
	  args = { {} },
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderBottomRow 2', func = testRenderBottomRow, type='ToString',
	  args = { { bottom = 'foo' } },
	  expect = { '<tr><td colspan="2" style="text-align:center;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderBottomRow 2', func = testRenderBottomRow, type='ToString',
	  args = { { bottom = 'foo', bottomClass = 'a', bottomStyle = 'b' } },
	  expect = { '<tr><td colspan="2" class="a" style="text-align:center;b;">\nfoo</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderImages 1', func = testRenderImages, type='ToString',
	  args = { { } },
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderImages 2', func = testRenderImages, type='ToString',
	  args = { { captionStyle = 'a:b', images = { { image = '[[File:Foo.bar]]', caption="a" } }, } },
	  expect = { '<tr><td colspan="2" style="text-align:center;">\n[[File:Foo.bar]]<br /><div style="a:b;">a</div></td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderImages 3', func = testRenderImages, type='ToString',
	  args = { { imageStyle = 'a', imageClass="b", images = { { image = 'img' } }, } },
	  expect = { '<tr><td colspan="2" class="b" style="text-align:center;a;">\nimg</td></tr>' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderImages 4', func = testRenderImages, type='ToString',
	  args =
	  { { images = {
			{ image = '[[File:Foo.bar]]' },
			{ image = '[[File:A]]', caption = 'Capt.' },
			{ image = '[[File:B]]', caption = 'C', class = 'D-Class' },
	  } } },
	  expect = {
		'<tr><td colspan="2" style="text-align:center;">\n[[File:Foo.bar]]</td></tr>' ..
		'<tr><td colspan="2" style="text-align:center;">\n[[File:A]]<br /><div>Capt.</div></td></tr>' ..
		'<tr class="D-Class"><td colspan="2" style="text-align:center;">\n[[File:B]]<br /><div>C</div></td></tr>'
	  }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRows 1', func = testRenderRows, type='ToString',
	  args = { { } },
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox._render.renderRows 2', func = testRenderRows, type='ToString',
	  args =
	  { { rows = {
			{ data = 'foo', label = 'bar' },
			{ header = 'foo', class = 'bar' },
			{ wikitext = 'Berlin' },
			{ data = 'foo', class='meh' },
	  }, labelStyle="a:b" } },
	  expect = {
		'<tr><th scope="row" style="text-align:left;a:b;">bar</th><td>\nfoo</td></tr>' ..
		'<tr><th colspan="2" class="bar" style="text-align:center;">foo</th></tr>' ..
		'<tr><td colspan="2" style="text-align:center;">\nBerlin</td></tr>' ..
		'<tr><td colspan="2" class="meh" style="text-align:center;">\nfoo</td></tr>'
	  }
	},
}

return testframework.getTestProvider( tests )
