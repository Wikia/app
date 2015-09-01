require 'mediawiki_selenium'
require 'mediawiki_selenium/support'
require 'mediawiki_selenium/step_definitions'

require 'screenshot'

require_relative 'hooks'
require_relative 'visual_editor_helper'

World(VisualEditorHelper)
