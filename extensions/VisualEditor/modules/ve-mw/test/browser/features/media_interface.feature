@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @en.wikipedia.beta.wmflabs.org @test2.wikipedia.org @login
Feature: VisualEditor Media Interface

  Scenario Outline: VisualEditor insert new media
    Given I am logged in
      And I am at my user page
    When I click Edit for VisualEditor
      And I click Media
      And I enter <search_term> into media Search box
      And I select an Image
      And I click Save page
      And I click Links Review your changes
    Then <expected_markup_text> should appear in the media diff view
      And I can click the X on the media save box
  Examples:
  | search_term           | expected_markup_text                                                                    |
  | San Francisco         | [[File:California county map (San Francisco County highlighted).svg\|thumb\|150x150px]] |
  | Flash video           | [[File:Flash video file icon.png\|thumb\|32x32px]]                                      |
  | cunfrunti             | [[File:Cunfrunti.mpg.OGG\|thumb\|183x183px]]                                            |

