// function to make an evenly distibuted color selection from red to red using tinycolor

function spectrumColors(number, steps) {
    var hueRange = 240;
    var hueStep = -(hueRange / (steps - 1));
    var currentHue = hueStep * number;
    var color = tinycolor('blue').spin(currentHue);
    return color;
}
