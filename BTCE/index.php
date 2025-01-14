<<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="BTCE\FunctionLibrary.js"></script>
    <script>
        function loadImagesFolder()
        {
            var xmlhttp;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("list").innerHTML = xmlhttp.response;
                }
                if (xmlhttp.readyState == 4)
                {
                    boxed();
                }
            }
            xmlhttp.open("GET", "BTCE/imageScroll.php", true);
            xmlhttp.send();
        } 
    </script>
    <meta charset="utf-8" />
    <title>Tonal Canvas Experiment</title>
    <style>
        {
            padding: 0;
            margin: 0;
        }

        body {
            height: 100%;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        #content {
            width: 50%;
            margin: 0 auto;
        }

        #backgroundCanvas {
            display: none;
        }

        #changedCanvas {
            width: 100%;
        }

        #colors {
            width: 99%;
            margin: 0 auto;
        }

        .colorBox {
            float: left;
            height: 40px;
            width: 80px;
            background-color: red;
            position: relative;
            border: 2px solid black;
        }

        .colorBoxIcon {
            position: absolute;
            top: 2px;
            right: 4px;
        }

        .color {
            position: absolute;
            bottom: 2px;
            left: 2px;
        }

        #sidebar {
            height: 100%;
            width: 150px;
            position: absolute;
            background: black;
            top: 0px;
            right: -120px;
            transition: right 0.5s;
            -webkit-transition: right 0.5s;
            -moz-transition: right 0.5s;
            -ms-transition: right 0.5s;
            -o-transition: right 0.5s;
        }

            #sidebar:hover {
                right: 0px;
            }

            #sidebar ul {
                list-style: none;
                width: 50%;
                height: 90%;
                margin: auto;
            }

                #sidebar ul li img {
                    margin-top: 2px;
                    width: 100%;
                    border: 2px solid white;
                }

                    #sidebar ul li img.open {
                        border: 2px solid red;
                    }

            #sidebar #upload {
                width: 50%;
                margin: auto;
            } 
    </style>
</head>
<body>
    <div id="content">
        <canvas id="backgroundCanvas"></canvas>
        <canvas id="changedCanvas"></canvas>

        <form id="colors">
            <div id="colorsBox">
                <div class="colorBox">
                    <img src="BTCE/colorBoxClose.gif" class="colorBoxIcon" onclick="colorBoxDelete(this)" />
                    <input type="color" value="#FFFFFF" class="color" />
                </div>
                <div class="colorBox">
                    <img src="BTCE/colorBoxClose.gif" class="colorBoxIcon" onclick="colorBoxDelete(this)" />
                    <input type="color" value="#000000" class="color" />
                </div>
            </div>
            <button type="button" id="add">Add a color</button>
            <button type="button" id="update">Generate</button>
            <!--<button type="button" id="invert">Invert</button>-->
        </form>
    </div> 
    <nav id="sidebar">
        <ul id="list">
           <li>
                <img src="BTCE/Images/rainbowLandscape.jpg" class="open" />
            </li>
            <li>
                <img src="BTCE/Images/rainbowRaindrops.jpg" />
            </li>
             
            <?php foreach ( new DirectoryIterator('./Images/') as $Item ) : 
                    if ($Item->isFile()) : ?>
                        <li>
                            <img src="BTCE/Images/" + <?=basename($Item)?> />
                        </li>
            <?php   endif;
                  endforeach; ?>
        </ul>
        <div id="upload">
            <input type="text" id="urlInput" />
        </div>
    </nav>

    <script id="animation">


        window.onload = function ()
        {

            function run()
            {
               

                /* INITIALIZATION */
                // Canvas Information
                var bcanvas = document.getElementById("backgroundCanvas");
                var bctx = bcanvas.getContext("2d");
                var ccanvas = document.getElementById("changedCanvas");
                var cctx = ccanvas.getContext("2d");
                var sfileH = sfile.height;
                var sfileW = sfile.width;
                bcanvas.height = sfileH; 
                bcanvas.width = sfileW;
                ccanvas.height = sfileH;
                ccanvas.width = sfileW;
                bctx.drawImage(sfile, 0, 0);
                var imgData = bctx.getImageData(0, 0, sfileW, sfileH);
                var data = imgData.data;

                // Button Initializing
                /* var inverse = true; */
                document.getElementById("update").onclick = function () { update() };
                document.getElementById("add").onclick = function () { addColor(); };
                /*document.getElementById("invert").onclick = function () { inverse = !inverse; update(); } */

                /* Start */
                update();

                function update()
                {

                    imgData = bctx.getImageData(0, 0, sfileW, sfileH);
                    data = imgData.data;
                    /*data = turnTonal2(data, getColors(), inverse); */
                    data = turnTonal(data, getColors());
                    cctx.putImageData(imgData, 0, 0);
                };
            }
            var sfile = new Image;
            sfile.onload = function () { run(); };
            sfile.crossOrigin = '';
            sfile.src = "BTCE/Images/rainbowLandscape.jpg"; 

            var imgS = document.getElementById("sidebar").getElementsByTagName("img");
            console.log(imgS);
            
            for (var i = 0; i < imgS.length; i++)
            {
                imgS[i].onclick = function ()
                {
                    var that = this;
                    sfile.src = that.src;
                    for (var img = 0; img < imgS.length; img++)
                    {
                        imgS[img].className = "";
                        that.className = "open";
                    }
                }
            }
          /*  $("#sidebar").find("img").click(function (e)
            {
                sfile.src = $(this).attr("src")
                $("#sidebar").find("img").removeClass("open");
                $(this).addClass("open");
            })
            */

            // Check for the various File API support.
            if (!window.File || !window.FileReader || !window.FileList && window.Blob)
            { alert('The File APIs are not fully supported in this browser.'); }

            document.getElementById('urlInput').addEventListener('change', handleFileSelect, false);

            function handleFileSelect()
            {
                try
                {
                                // Render thumbnail.
                                var li = document.createElement('li');
                                li.innerHTML = ['<img src=', document.getElementById("urlInput").value,
                                ' />'].join('');
                                document.getElementById('list').appendChild(li);
                             /*   $("#sidebar").find("img").click(function (e)
                                {
                                    e.preventDefault();
                                    sfile.src = $(this).attr("src")
                                    $("#sidebar").find("img").removeClass("open");
                                    $(this).addClass("open");
                                });
                                */
                            }
                        
                catch (ex) { console.log(ex);}; 
            };
        };
    </script>

</body>
</html>