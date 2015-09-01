# This page object exists because logged in users should not see these URL params
class ZtargetPage < VisualEditorPage
  page_url '<%=params[:article_name]%>?vehidebetadialog=true&veaction=edit'
end
