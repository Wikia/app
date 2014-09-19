local testframework = require 'Module:TestFramework'

local function identity( ... )
	return ...
end

return testframework.getTestProvider( {
	{ name = 'parameter: siteName',
	  func = type, args = { mw.site.siteName },
	  expect = { 'string' }
	},
	{ name = 'parameter: server',
	  func = type, args = { mw.site.server },
	  expect = { 'string' }
	},
	{ name = 'parameter set: scriptPath',
	  func = type, args = { mw.site.scriptPath },
	  expect = { 'string' }
	},

	{ name = 'parameter set: stats.pages',
	  func = type, args = { mw.site.stats.pages },
	  expect = { 'number' }
	},

	{ name = 'pagesInCategory',
	  func = type, args = { mw.site.stats.pagesInCategory( "Example" ) },
	  expect = { 'number' }
	},

	{ name = 'pagesInNamespace',
	  func = type, args = { mw.site.stats.pagesInNamespace( 0 ) },
	  expect = { 'number' }
	},

	{ name = 'usersInGroup',
	  func = type, args = { mw.site.stats.usersInGroup( 'sysop' ) },
	  expect = { 'number' }
	},

	{ name = 'Project namespace by number',
	  func = identity, args = { mw.site.namespaces[4].canonicalName },
	  expect = { 'Project' }
	},

	{ name = 'Project namespace by name',
	  func = identity, args = { mw.site.namespaces.Project.id },
	  expect = { 4 }
	},

	{ name = 'Project namespace by name (2)',
	  func = identity, args = { mw.site.namespaces.PrOjEcT.canonicalName },
	  expect = { 'Project' }
	},

	{ name = 'Project namespace subject is itself',
	  func = identity, args = { mw.site.namespaces.Project.subject.canonicalName },
	  expect = { 'Project' }
	},

	{ name = 'Project talk namespace via Project',
	  func = identity, args = { mw.site.namespaces.Project.talk.canonicalName },
	  expect = { 'Project talk' }
	},

	{ name = 'Project namespace via Project talk',
	  func = identity, args = { mw.site.namespaces.Project_talk.subject.canonicalName },
	  expect = { 'Project' }
	},

	{ name = 'Project talk namespace via Project (associated)',
	  func = identity, args = { mw.site.namespaces.Project.associated.canonicalName },
	  expect = { 'Project talk' }
	},
} )
