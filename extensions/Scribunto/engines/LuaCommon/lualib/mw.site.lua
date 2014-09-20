local site = {}

function site.setupInterface( info )
	-- Boilerplate
	site.setupInterface = nil
	local php = mw_interface
	mw_interface = nil

	site.siteName = info.siteName
	site.server = info.server
	site.scriptPath = info.scriptPath
	site.stylePath = info.stylePath
	site.currentVersion = info.currentVersion
	site.stats = {
		pagesInCategory = php.pagesInCategory,
		pagesInNamespace = php.pagesInNamespace,
		usersInGroup = php.usersInGroup,
	}

	-- Process namespace list into more useful tables
	site.namespaces = {}
	local namespacesByName = {}
	site.subjectNamespaces = {}
	site.talkNamespaces = {}
	site.contentNamespaces = {}
	for ns, data in pairs( info.namespaces ) do
		data.subject = info.namespaces[data.subject]
		data.talk = info.namespaces[data.talk]
		data.associated = info.namespaces[data.associated]

		site.namespaces[ns] = data

		namespacesByName[data.name] = data
		if data.canonicalName then
			namespacesByName[data.canonicalName] = data
		end
		for i = 1, #data.aliases do
			namespacesByName[data.aliases[i]] = data
		end

		if data.isSubject then
			site.subjectNamespaces[ns] = data
		end
		if data.isTalk then
			site.talkNamespaces[ns] = data
		end
		if data.isContent then
			site.contentNamespaces[ns] = data
		end
	end

	-- Set __index for namespacesByName to handle names-with-underscores
	-- and non-standard case
	local getNsIndex = php.getNsIndex
	setmetatable( namespacesByName, {
		__index = function ( t, k )
			if type( k ) == 'string' then
				-- Try with fixed underscores
				k = string.gsub( k, '_', ' ' )
				if rawget( t, k ) then
					return rawget( t, k )
				end

				-- Ask PHP, because names are case-insensitive
				local ns = getNsIndex( k )
				if ns then
					rawset( t, k, site.namespaces[ns] )
				end
			end
			return rawget( t, k )
		end
	} )

	-- Set namespacesByName as the lookup table for site.namespaces, so
	-- something like site.namespaces.Wikipedia works without having
	-- pairs( site.namespaces ) iterate all those names.
	setmetatable( site.namespaces, { __index = namespacesByName } )

	-- Copy the site stats, and set up the metatable to load them if necessary.
	local loadSiteStats = php.loadSiteStats
	site.stats.x = php.loadSiteStats
	if info.stats then
		loadSiteStats = nil
		for k, v in pairs( info.stats ) do
			site.stats[k] = v
		end
	end
	setmetatable( site.stats, {
		__index = function ( t, k )
			if t ~= site.stats then -- cloned
				return site.stats[k]
			end

			if k == 'admins' then
				t.admins = t.usersInGroup( 'sysop' )
			elseif loadSiteStats then
				for k, v in pairs( loadSiteStats() ) do
					t[k] = v
				end
				loadSiteStats = nil
			end

			return rawget( t, k )
		end
	} )

	-- Register this library in the "mw" global
	mw = mw or {}
	mw.site = site

	package.loaded['mw.site'] = site
end

return site
