<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>jquery.iviewer test</title>
        <script type="text/javascript" src="Image-Zoom/test/jquery.js" ></script>
        <script type="text/javascript" src="Image-Zoom/test/jqueryui.js" ></script>
        <script type="text/javascript" src="Image-Zoom/test/jquery.mousewheel.min.js" ></script>
        <script type="text/javascript" src="Image-Zoom/jquery.iviewer.js" ></script>
        <script type="text/javascript">
            var $ = jQuery;
            $(document).ready(function(){
                  var iv1 = $("#viewer").iviewer({
                       src: "test_image.jpg",
                       update_on_resize: false,
                       zoom_animation: false,
                       mousewheel: false,
                       onMouseMove: function(ev, coords) { },
                       onStartDrag: function(ev, coords) { return false; }, //this image will not be dragged
                       onDrag: function(ev, coords) { }
                  });

                   $("#in").click(function(){ iv1.iviewer('zoom_by', 1); });
                   $("#out").click(function(){ iv1.iviewer('zoom_by', -1); });
                   $("#fit").click(function(){ iv1.iviewer('fit'); });
                   $("#orig").click(function(){ iv1.iviewer('set_zoom', 100); });
                   $("#update").click(function(){ iv1.iviewer('update_container_info'); });

                  var iv2 = $("#viewer2").iviewer(
                  {
                      src: <?php echo json_encode($_POST['url'])?>
                  });

                  $("#chimg").click(function()
                  {
                    iv2.iviewer('loadImage', "test_image.jpg");
                    return false;
                  });

                  var fill = false;
                  $("#fill").click(function()
                  {
                    fill = !fill;
                    iv2.iviewer('fill_container', fill);
                    return false;
                  });
            });
        </script>
        <link rel="stylesheet" href="Image-Zoom/jquery.iviewer.css" />
        <style>
            .viewer
            {
                width: 50%;
                height: 500px;
                border: 1px solid black;
                position: relative;
            }

            .wrapper
            {
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <!-- wrapper div is needed for opera because it shows scroll bars for reason -->
        <div class="wrapper">
            <div id="viewer" class="viewer" style="display: none;"></div>
            <div id="viewer2" class="viewer" style="width: 100%;"></div>
        </div>
    </body>
</html>
