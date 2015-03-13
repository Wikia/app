@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: VisualEditor Media Interface

  Background:
    Given I go to the "Media Interface VisualEditor Test" page with content "Media Interface VisualEditor Test"
      And I click in the editable part

  Scenario Outline: VisualEditor insert new media
    Given I click Media
      And I enter <search_term> into media Search box
      And I select an Image
    When I click Save page the second time
      And I click Save page
      And I click Review your changes
    Then <expected_markup_text> should appear in the media diff view
      And I can click the X on the media save box
  Examples:
  | search_term           | expected_markup_text                                                                    |
  | San Francisco         | [[File:California county map (San Francisco County highlighted).svg\|thumb\|150x150px]] |
  | Flash video           | [[File:Flash video file icon.png\|thumb\|32x32px]]                                      |
  | cunfrunti             | [[File:Cunfrunti.mpg.OGG\|thumb\|183x183px]]                                            |

