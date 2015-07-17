require_relative '../features/support/language_screenshot'

# Rectangle is defined as set of co-ordinates represented by top left x, top left y, width, height
describe 'Rectangle' do
  it 'should return the co-ordinates of provided 1 rectangle' do
    input_rectangle = [0, 0, 1, 1]
    input_rectangles = [input_rectangle]
    expect(rectangle(input_rectangles)).to eq(input_rectangle)
  end

  it 'should return the co-ordinates of the rectangle which is inside a iframe' do
    input_rectangle  = [50, 50, 10, 10]
    iframe_rectangle = [100, 100, 20, 20]
    input_rectangles = [input_rectangle]
    output_rectangle = [150, 150, 10, 10]
    expect(rectangle(input_rectangles, iframe_rectangle)).to eq(output_rectangle)
  end

  it 'if we provide 2 rectangles and if one contains the other then it should return co-ordinates of bigger rectangle' do
    input_rectangle_1 = [0, 0, 1, 1]
    input_rectangle_2 = [0, 0, 2, 2]
    input_rectangles = [input_rectangle_1, input_rectangle_2]
    expect(rectangle(input_rectangles)).to eq(input_rectangle_2)
  end

  it 'if we provide 2 rectangles it should return co-ordinates of third rectangle which contains both' do
    input_rectangle_1  = [0, 0, 1, 1]
    input_rectangle_2  = [1, 0, 1, 1]
    input_rectangles_1 = [input_rectangle_1, input_rectangle_2]
    output_rectangle_1 = [0, 0, 2, 1]
    expect(rectangle(input_rectangles_1)).to eq(output_rectangle_1)

    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangle_4  = [3, 3, 1, 1]
    input_rectangles_2 = [input_rectangle_3, input_rectangle_4]
    output_rectangle_2 = [1, 1, 3, 3]
    expect(rectangle(input_rectangles_2)).to eq(output_rectangle_2)
  end

  it 'if we provide 3 rectangles it should return co-ordinates the rectangle which contains all the input rectangles' do
    input_rectangle_1  = [1, 1, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [3, 3, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_rectangle_1 = [1, 1, 3, 3]
    expect(rectangle(input_rectangles)).to eq(output_rectangle_1)
  end
end

describe 'Calculate topleft co-ordinates' do

  it 'if we provide 1 rectangle then it should return top left co-ordinates of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [2, 2]
    expect(top_left_x_y(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return top left co-ordinates of the biggest rectangle containing both rectangles' do
    input_rectangle_1  = [1, 0, 1, 1]
    input_rectangle_2  = [0, 0, 1, 1]
    input_rectangles = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [0, 0]
    expect(top_left_x_y(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return top left co-ordinates of the biggest rectangle containing both rectangles' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [1, 1]
    expect(top_left_x_y(input_rectangles)).to eq(output_coordinates)
  end

end

describe 'Topleft co-ordinates x' do

  it 'if we provide 1 rectangle then it should return array of top left x co-ordinate of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [2]
    expect(top_left_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return array top left x co-ordinates' do
    input_rectangle_1  = [0, 0, 1, 1]
    input_rectangle_2  = [1, 0, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [0, 1]
    expect(top_left_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return array of top left x co-ordinates' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [3, 2, 1]
    expect(top_left_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

end

describe 'Topleft co-ordinates y' do

  it 'if we provide 1 rectangle then it should return array of top left y co-ordinate of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [2]
    expect(top_left_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return array top left y co-ordinates' do
    input_rectangle_1  = [0, 0, 1, 1]
    input_rectangle_2  = [1, 0, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [0, 0]
    expect(top_left_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return array of top left y co-ordinates' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [3, 2, 1]
    expect(top_left_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

end

describe 'Calculate bottomright co-ordinates' do

  it 'if we provide 1 rectangle then it should return bottom right co-ordinates of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [3, 3]
    expect(bottom_right_x_y(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return bottom right co-ordinates of the biggest rectangle containing both rectangles' do
    input_rectangle_1  = [1, 0, 1, 1]
    input_rectangle_2  = [0, 0, 1, 1]
    input_rectangles = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [2, 1]
    expect(bottom_right_x_y(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return bottom right co-ordinates of the biggest rectangle containing both rectangles' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [4, 4]
    expect(bottom_right_x_y(input_rectangles)).to eq(output_coordinates)
  end

end

describe 'Bottom right co-ordinates x' do

  it 'if we provide 1 rectangle then it should return array of bottom right x co-ordinate of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [3]
    expect(bottom_right_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return array bottom right x co-ordinates' do
    input_rectangle_1  = [0, 0, 1, 1]
    input_rectangle_2  = [1, 0, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [1, 2]
    expect(bottom_right_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return array of bottom right x co-ordinates' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [4, 3, 2]
    expect(bottom_right_x_coordinates(input_rectangles)).to eq(output_coordinates)
  end

end

describe 'Bottom right co-ordinates y' do

  it 'if we provide 1 rectangle then it should return array of bottom right y co-ordinate of the input rectangle' do
    input_rectangle = [2, 2, 1, 1]
    input_rectangles = [input_rectangle]
    output_coordinates = [3]
    expect(bottom_right_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 2 rectangles then it should return array bottom right y co-ordinates' do
    input_rectangle_1  = [0, 0, 1, 1]
    input_rectangle_2  = [1, 0, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2]
    output_coordinates = [1, 1]
    expect(bottom_right_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

  it 'if we provide 3 rectangles then it should return array of bottom right y co-ordinates' do
    input_rectangle_1  = [3, 3, 1, 1]
    input_rectangle_2  = [2, 2, 1, 1]
    input_rectangle_3  = [1, 1, 1, 1]
    input_rectangles   = [input_rectangle_1, input_rectangle_2, input_rectangle_3]
    output_coordinates = [4, 3, 2]
    expect(bottom_right_y_coordinates(input_rectangles)).to eq(output_coordinates)
  end

end
