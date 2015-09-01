def capture_screenshot(file_name, page_elements, offset_element = nil, browser_zoom = 1)
  screenshot_directory = ENV['LANGUAGE_SCREENSHOT_PATH'] || 'screenshots'
  FileUtils.mkdir_p screenshot_directory
  screenshot_path = "#{screenshot_directory}/#{file_name}"

  browser_zoom.abs.times do
    if browser_zoom > 0
      @browser.send_keys [:control, :add]
    else
      @browser.send_keys [:control, :subtract]
    end
  end

  @browser.screenshot.save screenshot_path
  crop_image screenshot_path, page_elements, offset_element
end

def crop_image(path, page_elements, offset_element)
  if offset_element
    offset_rectangle = coordinates_from_page_element(offset_element)
  else
    offset_rectangle = [0, 0, 0, 0]
  end
  rectangles = coordinates_from_page_elements(page_elements)
  crop_rectangle = rectangle(rectangles, offset_rectangle)

  top_left_x = crop_rectangle[0]
  top_left_y = crop_rectangle[1]
  width = crop_rectangle[2]
  height = crop_rectangle[3]

  require 'chunky_png'
  image = ChunkyPNG::Image.from_file path

  # It happens with some elements that an image goes off the screen a bit,
  # and chunky_png fails when this happens
  width = image.width - top_left_x if image.width < top_left_x + width

  image.crop!(top_left_x, top_left_y, width, height)
  image.save path
end

def rectangle(rectangles, offset_rectangle = [0, 0, 0, 0])
  top_left_x, top_left_y = top_left_x_y rectangles
  bottom_right_x, bottom_right_y = bottom_right_x_y rectangles

  # Finding width and height
  width = bottom_right_x - top_left_x
  height = bottom_right_y - top_left_y

  # We are calculating the offset co-ordinates
  x_offset = offset_rectangle[0]
  y_offset = offset_rectangle[1]

  # The new rectangle is constructed with all the co-ordinates calculated above
  [top_left_x + x_offset, top_left_y + y_offset, width, height]
end

def coordinates_from_page_elements(page_elements)
  page_elements.collect do |page_element|
    coordinates_from_page_element page_element
  end
end

def coordinates_from_page_element(page_element)
  [page_element.element.wd.location.x, page_element.element.wd.location.y, page_element.element.wd.size.width, page_element.element.wd.size.height]
end

def top_left_x_coordinates(input_rectangles)
  input_rectangles.collect do |rectangle|
    rectangle[0]
  end
end

def top_left_y_coordinates(input_rectangles)
  input_rectangles.collect do |rectangle|
    rectangle[1]
  end
end

def bottom_right_x_coordinates(input_rectangles)
  input_rectangles.collect do |rectangle|
    rectangle[0] + rectangle[2]
  end
end

def bottom_right_y_coordinates(input_rectangles)
  input_rectangles.collect do |rectangle|
    rectangle[1] + rectangle[3]
  end
end

def bottom_right_x_y(input_rectangles)
  [bottom_right_x_coordinates(input_rectangles).max, bottom_right_y_coordinates(input_rectangles).max]
end

def top_left_x_y(input_rectangles)
  [top_left_x_coordinates(input_rectangles).min, top_left_y_coordinates(input_rectangles).min]
end

def highlight(element, color = '#FF00FF')
  @current_page.execute_script("arguments[0].style.border = 'thick solid #{color}'", element)
end
