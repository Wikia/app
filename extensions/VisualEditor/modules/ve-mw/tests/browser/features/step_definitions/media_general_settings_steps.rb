Given(/^I fill up the Caption field with "(.*?)"$/) do |caption_text|
  on(VisualEditorPage).caption_element.when_present.send_keys caption_text
end

Given(/^I fill up the Alternative text with "(.*?)"$/) do |alt_text|
  on(VisualEditorPage).alternative_text_element.when_present.send_keys alt_text
end

Then(/^diff view should show media file with caption and alt text$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.diff_view_element.exists?
    end
    expect(page.diff_view).to match(/\[\[File:A Bug.JPG\|alt=alt text\|thumb\|caption\]\]/)
  end
end
