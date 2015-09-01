# This is used in the verify_production_wikis test
class DummyPage
  include PageObject

  page_url 'http://<%=params[:site]%>/wiki/asdfdgfghlkj?veaction=edit'

  div(:ve_editing_surface, class: 've-ui-surface ve-init-mw-target-surface')
  div(:ve_editing_toolbar, class: 'oo-ui-toolbar-bar')
end
