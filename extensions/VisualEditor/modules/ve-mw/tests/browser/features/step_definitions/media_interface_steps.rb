When(/^I click Media$/) do
  on(VisualEditorPage) do |page|
    page.insert_indicator_down_element.when_present.click
    page.ve_media_menu_element.when_present.click
  end
end

When(/^I enter (.+) into media Search box$/) do |content|
  on(VisualEditorPage) do |page|
    sleep 1
    page.media_search_element.when_present.click
    page.media_search_element.send_keys('')
    page.media_search_element.when_present.send_keys(content)
  end
end

When(/^I select an Image$/) do
  on(VisualEditorPage).media_select_element.when_present(20).click
end

When(/^I click Use this image/) do
  on(VisualEditorPage).use_image_button_element.when_present.click
end

When(/^I click Insert$/) do
  on(VisualEditorPage).media_insert_button_element.when_present.click
end

Then(/^diff view should show correct markup$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.diff_view_element.exists?
    end
    expect(page.diff_view).to match(/\[\[File:A Bug.JPG\|thumb\]\]/)
  end
end
