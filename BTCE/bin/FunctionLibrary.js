function turnTonal(data, colors) {

    if (colors.length > 0) {

        var lowest;
        var colorsTemp;
        var colorsLength = colors.length;
        for (i = 0; i < data.length ; i += 4) {

            lowest = [770];
            for (c = 0; c < colorsLength; c++) {

                colorsTemp = Math.abs(data[i] - colors[c][0]);
                colorsTemp = colorsTemp + Math.abs(data[i + 1] - colors[c][1]);
                colorsTemp = colorsTemp + Math.abs(data[i + 2] - colors[c][2]);

                if (colorsTemp < lowest[0]) {

                    lowest = [colorsTemp, c];
                }
            }

            data[i] = colors[lowest[1]][0];
            data[i + 1] = colors[lowest[1]][1];
            data[i + 2] = colors[lowest[1]][2];
        }
    }
    return data;
}
/*function turnTonal2(data, colors, inverse) {

    if (colors.length > 0) {

        var chosen;
        var colorsTemp;
        var colorsLength = colors.length;
        for (i = 0; i < data.length ; i += 4) {

            if (!inverse) {

                chosen = [770];
            }
            else {

                chosen = [-1];
            }
            for (c = 0; c < colorsLength; c++) {

                colorsTemp = Math.abs(data[i] - colors[c][0]);
                colorsTemp = colorsTemp + Math.abs(data[i + 1] - colors[c][1]);
                colorsTemp = colorsTemp + Math.abs(data[i + 2] - colors[c][2]);

                if (!inverse) {

                    if (colorsTemp < chosen[0]) {

                        chosen = [colorsTemp, c];
                    }
                }
                else {

                    if (colorsTemp > chosen[0]) {

                        chosen = [colorsTemp, c];
                    }
                }
            }

            data[i] = colors[chosen[1]][0];
            data[i + 1] = colors[chosen[1]][1];
            data[i + 2] = colors[chosen[1]][2];
        }
    }
    return data;
} */

function getColors() {

    var colors = [];
    if (document.getElementById("colorsBox").children.length > 0) {

        var children = document.getElementById("colorsBox").children;
        var rgbColors = [];
        for (var i = 0; i < children.length; i++) {

            var getColorsTemp = children[i].children[1].value;
            if (getColorsTemp.length == 7) {

                colors.push([]);
                colors[i].push(getColorsTemp.substr(1, 2));
                colors[i].push(getColorsTemp.substr(3, 2));
                colors[i].push(getColorsTemp.substr(5, 2));
                colors[i][0] = parseInt(colors[i][0], 16);
                colors[i][1] = parseInt(colors[i][1], 16);
                colors[i][2] = parseInt(colors[i][2], 16);
            }

            else {
                console.log("ran into a glitch");
            }
        }
    }
    return colors;
}

function addColor() {

    // Creating a color picker
    var colorInput = document.createElement("input");
    colorInput.type = "color";
    colorInput.className = "color";
    // Assigning a random value
    colorInput.value = "#" + Math.random().toString(16).slice(2, 8);
    console.log(colorInput.value);
    // Creating the container
    var colorDiv = document.createElement("div");
    colorDiv.className = "colorBox";
    //  Creating the delete button
    var closeIcon = document.createElement("img");
    closeIcon.src = "BTCE/colorBoxClose.gif";
    closeIcon.className = "colorBoxIcon";
    closeIcon.onclick = function () { colorBoxDelete(this) };
    // Adding them to the page
    colorDiv.appendChild(closeIcon);
    colorDiv.appendChild(colorInput);
    document.getElementById("colorsBox").appendChild(colorDiv);
};

function colorBoxDelete(elem) {

    colorBox = elem.parentNode;
    colorBox.parentNode.removeChild(colorBox);
}