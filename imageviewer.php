<style>
  .sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  border: 0;
}

.element {
  width: 100%;
}

.panzoom {
  position: absolute;
  text-align: center;
  background: #708690;
}

/* We initially want all floor images but one to be hidden. */
.panzoom .element:not(:first-child) {
  display: none;
}

#panzoom-parent {
  position: absolute;
  background: #f6f6f6;
  border: 1px solid #445C6F;
  width: 100%;
  height: 100%;
  margin-right: auto;
  margin-left: auto;
}
#pan-u {
  width: 0;
  height: 0;
  border-left: 9px solid transparent;
  border-right: 9px solid transparent;
  border-bottom: 18px solid white;
}

#pan-r {
  width: 0;
  height: 0;
  border-bottom: 9px solid transparent;
  border-left: 18px solid white;
  border-top: 9px solid transparent;
}

#pan-d {
  width: 0;
  height: 0;
  border-left: 9px solid transparent;
  border-right: 9px solid transparent;
  border-top: 18px solid white;
}

#pan-l {
  width: 0;
  height: 0;
  border-bottom: 9px solid transparent;
  border-right: 18px solid white;
  border-top: 9px solid transparent;
}

#reset {
  width: 18px;
  height: 18px;
  background: white;
  -moz-border-radius: 9px;
  -webkit-border-radius: 9px;
  border-radius: 9px;
}

#map-ctl .icon {
  background-image: url("http://www.kurtmeredith.com/img/MapButtonsCropped.png");
  background-size: 100%; 
}

#zoomin-ctl>.icon {
  background-position: 0px 0px;
}

#zoomout-ctl>.icon {
  background-position: 0px -37px;
}

#floor-3>.icon {
  background-position: 0px -110px;
}

#floor-2>.icon {
  background-position: 0px -146px;
}

#floor-1>.icon {
  background-position: 0px -183px;
}

#floor-0>.icon {
  background-position: 0px -219px;
}

#parking>.icon {
  background-position: 0px -256px;
}


</style>
<div id="msg" class="sr-only" role="alert"></div>
<section id="panzoom-parent" role="region" aria-label="product image zoom">
   <div id="map-ctl" style="width: 90px; height: 339px; z-index: 0; text-align: left; position: absolute; left: -1px; top: 5px; z-index: 10000;">
  <div id="zoomin-ctl" style="position: absolute; left: 34px; top: 100px; width: 22px; height: 22px; overflow: hidden; z-index: 10001; background-color: transparent;">
    <div title="Zoom In" class="icon" style="position: absolute; left: 0px; top: 0px; width: 22px; height: 22px; cursor: pointer;" role="button" tabindex="0" aria-label="zoom in"></div>
  </div>
  <div id="zoomout-ctl" style="position: absolute; left: 34px; top: 130px; width: 22px; height: 22px; text-align: left; z-index: 10003; background-color: transparent;">
    <div title="Zoom Out" class="icon" style="position: absolute; left: 0px; top: 0px; width: 22px; height: 22px; cursor: pointer;" role="button" tabindex="0" aria-label="zoom out"></div>
  </div>
  <div class="download"><a class="download-btn" href="#" alt=""></a></div>

</div>
  
  
  <div class="panzoom" tabindex="0" role="region" aria-label="image zoom viewer">
    <img class="element" alt="SkinMedica" src="<?php echo $_POST['url'];?>" />
  </div>
</section>
<script>
  (function () {
        loadImages = function () {
            var img,
                imgPreload
                  
        },
        section = $('#panzoom-parent'),
        panzoom = section.find('.panzoom').panzoom({
            $zoomIn: $("#zoomin-ctl"),
            $zoomOut: $("#zoomout-ctl"),
            $zoomRange: $("#zoomRange"),
            $reset: $("#reset"),
            contain: "invert",
            minScale: 0.5,
            maxScale: 2
        }),
        doPan = function (x, y, rel, anim) {
            panzoom.panzoom("pan", x, y, { relative: rel, animate: anim });
        };
        loadImages();
  /* Mouse Scroll Wheel Zoom */
    section.on('mousewheel.focal', function (e) {
        e.preventDefault();
        panzoom.panzoom('zoom', e.originalEvent.wheelDelta < 0, {
            increment: 0.1,
            focal: e
        });
    });
  /* Panning - Mouse click */
    $('#pan-u').click(function () {
        doPan(0, -100, true, true);
        document.getElementById("msg").innerHTML = "Panning up";
    });
    $('#pan-r').click(function () {
        doPan(100, 0, true, true);
        document.getElementById("msg").innerHTML = "Panning right";
    });
    $('#pan-d').click(function () {
        doPan(0, 100, true, true);
        document.getElementById("msg").innerHTML = "Panning down";
    });
    $('#pan-l').click(function () {
        doPan(-100, 0, true, true);
        document.getElementById("msg").innerHTML = "Panning left";
    });
     /* Panning - Enter key */
    $('#pan-u').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        doPan(0, -100, true, true);
        document.getElementById("msg").innerHTML = "Panning up";
      }
    });
    $('#pan-r').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        doPan(100, 0, true, true);
        document.getElementById("msg").innerHTML = "Panning right";
      }
    });
    $('#pan-d').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        doPan(0, 100, true, true);
        document.getElementById("msg").innerHTML = "Panning down";
      }
    });
    $('#pan-l').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        doPan(-100, 0, true, true);
        document.getElementById("msg").innerHTML = "Panning left";
      }
    });
     /* Zooming - Mouse click */
      $('#zoomin-ctl').click(function () {
        panzoom.panzoom("zoom");
        document.getElementById("msg").innerHTML = "zooming in";
    });
    $('#zoomout-ctl').click(function () {
        panzoom.panzoom("zoom",true);
        document.getElementById("msg").innerHTML = "zooming out";
    });
    /* Zooming -Enter key */
     $('#zoomin-ctl').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        e.preventDefault();
        panzoom.panzoom("zoom");
        document.getElementById("msg").innerHTML = "zooming in";
      }
    }); 
     $('#zoomout-ctl').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        e.preventDefault();
        panzoom.panzoom("zoom",true);
        document.getElementById("msg").innerHTML = "zooming out";
      }
    }); 
      /* Reset */
     $('#reset').keypress(function (e) {
      var keycode = (e.keyCode ? e.keyCode : e.which);
      if (keycode == '13') {
        e.preventDefault();
        panzoom.panzoom("reset");
        document.getElementById("msg").innerHTML = "zoom reset";
      }
    }); 
      $('#reset').click(function () {
        doPan(0, -100, true, true);
        panzoom.panzoom("reset");
        document.getElementById("msg").innerHTML = "zoom reset";
    });
})();

</script>