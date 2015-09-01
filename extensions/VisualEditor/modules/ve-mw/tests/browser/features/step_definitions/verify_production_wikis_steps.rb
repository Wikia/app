When(/^I visit a non-existent page at (.+)$/) do |site|
  visit(DummyPage, using_params: { site: site })
end

Then(/^I should see the Visual Editor editing surface$/) do
  on(DummyPage) do |page|
    page.wait_until(10) do
      page.ve_editing_surface_element.exists?
    end
    expect(on(DummyPage).ve_editing_toolbar_element).to exist
  end
end
