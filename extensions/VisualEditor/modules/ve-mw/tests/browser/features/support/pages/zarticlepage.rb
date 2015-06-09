# This page object exists because logged in users should not see these URL params
class ZtargetPage < VisualEditorPage
  include URL
  page_url URL.url('<%=params[:article_name]%>?vehidebetadialog=true&veaction=edit')
  include PageObject
end
