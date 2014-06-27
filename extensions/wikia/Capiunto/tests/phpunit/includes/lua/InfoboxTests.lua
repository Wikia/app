--[[
	Tests for the mw.capiunto.wrapper module

	@license GNU GPL v2+
	@author Marius Hoch < hoo@online.de >
]]

local testframework = require 'Module:TestFramework'

require 'mw.capiunto.Infobox'

local function getNewEmpty()
	return mw.capiunto.Infobox.create()
end

local function getStringNumNilError( name )
	return name .. ' must be either of type string, number or nil'
end

local function getStringNumError( name )
	return name .. ' must be either of type string or number'
end

local stringTable = {}
setmetatable( stringTable, { __tostring = function() return 'called proper tostring' end } );

-- Helper functions

local function addSubHeader( text, class, style )
	return getNewEmpty():addSubHeader( text, class, style ).args.subHeaders
end

local function addHeader( header, class )
	return getNewEmpty():addHeader( header, class ).args.rows
end

local function addWikitext( text )
	return getNewEmpty():addWikitext( text ).args.rows
end

local function addImage( image, caption, class )
	return getNewEmpty():addImage( image, caption, class ).args.images
end

local function addRow( label, data, class, rowClass )
	return getNewEmpty():addRow( label, data, class, rowClass
	 ).args.rows
end

local function createType( val )
	return type( mw.capiunto.Infobox.create( { bodyClass = val  } ) )
end

local function getHtmlType( child )
	local box = mw.capiunto.Infobox.create( { isChild = child } )

	return type( box:getHtml() )
end

local function getHtmlChild( options )
	options = options or {}
	options.isChild = true

	local box = mw.capiunto.Infobox.create( options )

	return box:getHtml()
end

-- Tests

local function testExists()
	return type( mw.capiunto.Infobox )
end

local function testCreate()
	return type( getNewEmpty() )
end

function testAddImage()
	local box = getNewEmpty()

	box
		:addImage( '[[File:Foo]]' )
		:addImage( 'woo', 'hoo' )
		:addImage( 'abc', nil, 'def' )

	return box.args.images
end

function testAddSubHeader()
	local box = getNewEmpty()

	box
		:addSubHeader( 'Subheader' )
		:addSubHeader( 'woo', nil, 'hoo' )
		:addSubHeader( 'abc', 'def' )

	return box.args.subHeaders
end

local function testAddRowAddHeaderAddWikitext()
	local box = getNewEmpty()

	box
		:addHeader( 'Header 1' )
		:addRow( '#1 row->label', '#1 row->data' )
		:addWikitext( 'This is a boring dummy string' )
		:addHeader( 'Header 2', 'header-two-class' )
		:addRow( '2nd row->label', '2nd row->data', 'row-two-class', 'row-two-rowClass' )
		:addWikitext( '[[a|b]]' )
		:addHeader( 'Header 3' )

	return box.args.rows
end

-- Tests
local tests = {
	{ name = 'mw.capiunto.Infobox exists', func = testExists, type='ToString',
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.create', func = testCreate, type='ToString',
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.create (validation 1)', func = createType, type='ToString',
	  args = { {} },
	  expect = 'Option bodyClass must be either of type string, number or nil'
	},
	{ name = 'mw.capiunto.Infobox.create (validation 2)', func = createType, type='ToString',
	  args = { function() end },
	  expect = 'Option bodyClass must be either of type string, number or nil'
	},
	{ name = 'mw.capiunto.Infobox.create (validation 3)', func = createType, type='ToString',
	  args = { nil },
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.create (validation 4)', func = createType, type='ToString',
	  args = { 123 },
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.create (validation 5)', func = createType, type='ToString',
	  args = { 'foo' },
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.getHtml (type)', func = getHtmlType, type='ToString',
	  args = { false },
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.getHtml (type - child box)', func = getHtmlType, type='ToString',
	  args = { true },
	  expect = { 'table' }
	},
	{ name = 'mw.capiunto.Infobox.getHtml (child box - empty)', func = getHtmlChild, type='ToString',
	  expect = { '' }
	},
	{ name = 'mw.capiunto.Infobox.getHtml (child box - title)', func = getHtmlChild, type='ToString',
	  args = { { title = 'Lalalala' } },
	  expect = { 'Lalalala' }
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader 1', func = addSubHeader,
	  args = { 'foo' },
	  expect = { { { text = 'foo', style = nil, class = nil } } }
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader 2', func = addSubHeader,
	  args = { 'foo', 'cd', 'ab' },
	  expect = { { { text = 'foo', style = 'ab', class = 'cd' } } }
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader (invalid input 1)', func = addSubHeader,
	  args = {},
	  expect = getStringNumError( 'text' )
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader (invalid input 2)', func = addSubHeader,
	  args = { {} },
	  expect = getStringNumError( 'text' )
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader (invalid input 3)', func = addSubHeader,
	  args = { 'whatever', {} },
	  expect = getStringNumNilError( 'class' )
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader (invalid input 4)', func = addSubHeader,
	  args = { 'whatever', nil, function() end },
	  expect = getStringNumNilError( 'style' )
	},
	{ name = 'mw.capiunto.Infobox.addImage 1', func = addImage,
	  args = { 'foo' },
	  expect = { { { image = 'foo', caption = nil, class = nil } } }
	},
	{ name = 'mw.capiunto.Infobox.addImage 2', func = addImage,
	  args = { 'foo', 'ab', 'cd' },
	  expect = { { { image = 'foo', caption = 'ab', class = 'cd' } } }
	},
	{ name = 'mw.capiunto.Infobox.addImage (invalid input 1)', func = addImage,
	  expect = getStringNumError( 'image' )
	},
	{ name = 'mw.capiunto.Infobox.addImage (invalid input 2)', func = addImage,
	  args = { {} },
	  expect = getStringNumError( 'image' )
	},
	{ name = 'mw.capiunto.Infobox.addImage (invalid input 3)', func = addImage,
	  args = { 'a', {}, 'da' },
	  expect = getStringNumNilError( 'caption' )
	},
	{ name = 'mw.capiunto.Infobox.addImage (invalid input 4)', func = addImage,
	  args = { 'what', nil, {} },
	  expect = getStringNumNilError( 'class' )
	},
	{ name = 'mw.capiunto.Infobox.addHeader (invalid input 1)', func = addHeader,
	  expect = getStringNumError( 'header' )
	},
	{ name = 'mw.capiunto.Infobox.addHeader (invalid input 3)', func = addHeader,
	  args = { {} },
	  expect = getStringNumError( 'header' )
	},
	{ name = 'mw.capiunto.Infobox.addHeader (invalid input 3)', func = addHeader,
	  args = { 'foo', function() end },
	  expect = getStringNumNilError( 'class' )
	},
	{ name = 'mw.capiunto.Infobox.addRow (no label)', func = addRow,
	  args = { nil, 'foo' },
	  expect = { { { data = 'foo' } } }
	},
	{ name = 'mw.capiunto.Infobox.addRow (invalid input 1)', func = addRow,
	  expect = getStringNumError( 'data' )
	},
	{ name = 'mw.capiunto.Infobox.addRow (invalid input 2)', func = addRow,
	  args = { {}, 'a' },
	  expect = getStringNumNilError( 'label' )
	},
	{ name = 'mw.capiunto.Infobox.addRow (invalid input 3)', func = addRow,
	  args = { nil, 'a', {} },
	  expect = getStringNumNilError( 'class' )
	},
	{ name = 'mw.capiunto.Infobox.addRow (invalid input 4)', func = addRow,
	  args = { nil, 'a', nil, function() end },
	  expect = getStringNumNilError( 'rowClass' )
	},
	{ name = 'mw.capiunto.Infobox.addWikitext (invalid input 1)', func = addWikitext,
	  expect = 'text must be either of type string, number or table'
	},
	{ name = 'mw.capiunto.Infobox.addWikitext (invalid input 2)', func = addWikitext,
	  args = { function() end },
	  expect = 'text must be either of type string, number or table'
	},
	{ name = 'mw.capiunto.Infobox.addWikitext (table)', func = addWikitext,
	  args = { stringTable },
	  expect = { { { wikitext = 'called proper tostring' } } }
	},
	{ name = 'mw.capiunto.Infobox.addSubHeader', func = testAddSubHeader,
	  expect = { {
		{ text = 'Subheader' },
		{ text = 'woo', style = 'hoo' },
		{ text = 'abc', class = 'def' },
	  } }
	},
	{ name = 'mw.capiunto.Infobox.addImage', func = testAddImage,
	  expect = { {
		{ image = '[[File:Foo]]' },
		{ image = 'woo', caption = 'hoo' },
		{ image = 'abc', class = 'def' },
	  } }
	},
	{ name = 'mw.capiunto.Infobox.addRow/addHeader/addWikitext', func = testAddRowAddHeaderAddWikitext,
	  expect = { {
		{ header = 'Header 1' },
		{ data = '#1 row->data', label = '#1 row->label' },
		{ wikitext = 'This is a boring dummy string' },
		{ class = 'header-two-class', header = 'Header 2' },
		{ class = 'row-two-class', label = '2nd row->label', data = '2nd row->data', rowClass = 'row-two-rowClass' },
		{ wikitext = '[[a|b]]' },
		{ header = 'Header 3' },
	  } }
	},
}

return testframework.getTestProvider( tests )
