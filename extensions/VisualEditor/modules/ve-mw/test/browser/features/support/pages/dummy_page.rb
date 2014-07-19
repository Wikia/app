class DummyPage
  include PageObject

  include URL
  page_url ("http://<%=params[:site]%>/wiki/asdfdgfghlkj?veaction=edit")

  div(:ve_editing_surface, :class => "ve-ui-surface ve-init-mw-viewPageTarget-surface")
  div(:ve_editing_toolbar, :class => "oo-ui-toolbar-bar")

end
