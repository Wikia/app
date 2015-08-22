class UserPage
  include PageObject

  include URL
  page_url URL.url("<%=params[:page_title]%>")

  div(:ve_editing_surface, class: "ve-ui-surface ve-init-mw-viewPageTarget-surface")

end
