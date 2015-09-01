#
# Shared helper for VE browser test step definitions
#
module VisualEditorHelper
  def translate(string)
    file = File.read "i18n/#{lookup(:language_screenshot_code)}.json"
    json = JSON.parse(file)
    json["visualeditor-languagescreenshot-#{string.downcase.gsub(' ', '-')}-text"] || ''
  end
end
