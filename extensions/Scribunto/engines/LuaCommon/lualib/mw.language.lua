local language = {}
local php
local util = require 'libraryUtil'

function language.setupInterface()
	-- Boilerplate
	language.setupInterface = nil
	php = mw_interface
	mw_interface = nil

	-- Register this library in the "mw" global
	mw = mw or {}
	mw.language = language
	mw.getContentLanguage = language.getContentLanguage
	mw.getLanguage = mw.language.new

	local lang = mw.getContentLanguage();

	-- Extend ustring
	if mw.ustring then
		mw.ustring.upper = function ( s )
			return lang:uc( s )
		end
		mw.ustring.lower = function ( s )
			return lang:lc( s )
		end
		string.uupper = mw.ustring.upper
		string.ulower = mw.ustring.lower
	end

	package.loaded['mw.language'] = language
end

--[[ Wikia change - Language::isSupportedLanguage and Language::isKnownLanguageTag are not supported in MW 1.19
function language.isSupportedLanguage( code )
	return php.isSupportedLanguage( code )
end

function language.isKnownLanguageTag( code )
	return php.isKnownLanguageTag( code )
end
]]

function language.isValidCode( code )
	return php.isValidCode( code )
end

function language.isValidBuiltInCode( code )
	return php.isValidBuiltInCode( code )
end

function language.fetchLanguageName( code, inLanguage )
	return php.fetchLanguageName( code, inLanguage )
end

function language.new( code )
	if code == nil then
		error( "too few arguments to mw.language.new()", 2 )
	end

	local lang = { code = code }

	local checkSelf = util.makeCheckSelfFunction( 'mw.language', 'lang', lang, 'language object' )

	local wrappers = {
		isRTL = 0,
		lcfirst = 1,
		ucfirst = 1,
		lc = 1,
		uc = 1,
		caseFold = 1,
		formatNum = 1,
		formatDate = 1,
		parseFormattedNumber = 1,
		convertPlural = 2,
		convertGrammar = 2,
		gender = 2,
	}

	for name, numArgs in pairs( wrappers ) do
		lang[name] = function ( self, ... )
			checkSelf( self, name )
			if select( '#', ... ) < numArgs then
				error( "too few arguments to mw.language:" .. name, 2 )
			end
			return php[name]( self.code, ... )
		end
	end

	-- Alias
	lang.plural = lang.convertPlural

	-- Parser function compat
	function lang:grammar( case, word )
		checkSelf( self, name )
		return self:convertGrammar( word, case )
	end

	function lang:getCode()
		checkSelf( self, 'getCode' )
		return self.code
	end

	return lang
end

local contLangCode

function language.getContentLanguage()
	if contLangCode == nil then
		contLangCode = php.getContLangCode()
	end
	return language.new( contLangCode )
end

return language
