<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event DataTransfer Demo</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="demo.css" />
    <link rel="stylesheet" href="dist/gridstack-extra.css" />
    <link rel="stylesheet" href="../css/colorpicker.css" type="text/css" />
    <style>
        .changefile {
            display: flex;
            height: 100%;
        }
        .changefile input {
            width: 100% !important;
            outline: none;
            padding: 0;
            opacity: 0;
            border: none !important;
            position: absolute;
            left: 0;
            background: #fff;
            top: 0;
            height: 100%;
        }
        .grid-stack-item-removing {
            opacity: 0.8;
            filter: blur(5px);
        }
        #trash {
            background: rgba(255, 0, 0, 0.4);
        }
        #colorSelector1 {
            top: 0;
            left: 0;
            width: 36px;
            height: 36px;
            background: url(../images/select2.png);
        }
        #colorSelector1 div {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 28px;
            height: 28px;
            background: url(../images/select2.png) center;
        }
        #colorSelector2 {
            top: 0;
            left: 0;
            width: 36px;
            height: 36px;
            background: url(../images/select2.png);
        }
        #colorSelector2 div {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 28px;
            height: 28px;
            background: url(../images/select2.png) center;
        }
    </style>
    <script src="dist/gridstack-h5.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/colorpicker/colorpicker.js"></script>
    <script type="text/javascript" src="../js/colorpicker/eye.js"></script>
    <script type="text/javascript" src="../js/colorpicker/utils.js"></script>
</head>

<body>
    <div class="container-fluid">
        <h1>Event DataTransfer Demo</h1>
        <a onClick="saveFullGrid()" class="btn btn-primary" href="#">Save Full</a>
        <a class="btn btn-primary" onClick="grid.setStatic(true)" href="#">Static</a>
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="grid-stack-item">
                        <div class="grid-stack-item-content">
                            <a class="changefile">
                                <img id="image" src="https://shareio.com/upload/thumb624a6dd45de61087ba1f587QTvI8rum2.jpg" style="height: 100%;width: 100%;">
                                <p id="title"></p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="trash" style="padding: 5px; margin-bottom: 15px;" class="text-center">
                <div>
                <ion-icon name="trash" style="font-size: 300%"></ion-icon>
                </div>
                <div>
                <span>Drop here to remove!</span>
                </div>
            </div>
            <div class="col-md-9">
                <div class="grid-stack grid-stack-12"></div>
            </div>
            <div id="properties" style="display:none;">
                <input type="file" name="file" class="upload_file" id="upload_file">
                <a class="remove_img">remove img</a>
                <label>Color<div id="colorSelector2"></div></label>
                <input type="text" id="title_text">
                <label>Color<div id="colorSelector1"></div></label>
                <a id="save_properties" class="btn">save</a>
            </div>
        </div>
    </div>
    
    <textarea id="saved-data" cols="100" rows="20" readonly="readonly"></textarea>
    <script type="text/javascript">
        let options = {
            column: 12,
            disableOneColumnMode: true,
            acceptWidgets: function (el) { return true; },
            removable: '#trash',
        };
        let items = [
            {
            "x": 9,
            "y": 0,
            "w": 2,
            "h": 1,
            "content": "Sample Element 2"
            },
            {
            "w": 9,
            "h": 1,
            "x": 0,
            "y": 2,
            "content": "Drag me"
            },
            {
            "x": 0,
            "y": 3,
            "w": 9,
            "h": 1,
            "content": "Sample Element"
            }
        ];

        let grid = GridStack.init(options)

        grid.load(items);

        grid.on('dropped', function (event, previousWidget, newWidget) {
            if (event.dataTransfer) {
                console.log('gridstack dropped: ', event.dataTransfer.getData('message'));
                var el = newWidget['el'];
                var id = newWidget['_id'];
                var div = $(newWidget['el']).children('div');
                var a = div.children('a');
                a.addClass('test');
                a.attr('data-id', id); 
                console.log(newWidget) 
            }
        });

        grid.on('added', function(e, items) {
            let str = '';
            items.forEach(function(item) { str += ' (x,y)=' + item.x + ',' + item.y; });
            console.log(e.type + ' ' + items.length + ' items:' + str );
        });

        grid.on('removed change', function(e, items) {
            let str = '';
            items.forEach(function(item) { str += ' (x,y)=' + item.x + ',' + item.y; });
            console.log(e.type + ' ' + items.length + ' items:' + str );
        });

        GridStack.setupDragIn(
            '.sidebar .grid-stack-item',
            {
                revert: 'invalid',
                scroll: false,
                appendTo: 'body',
                helper: clone,
                start: start
            }
        );

        function clone(event) {
            return event.target.cloneNode(true);
        }

        function start(event) {
            if (event.dataTransfer) {
                event.dataTransfer.setData('message', 'Hello World');
            }
        }

        saveFullGrid = function() {
            $(".upload_file").remove();
            serializedFull = grid.save(true, true);
            serializedData = serializedFull.children;
            document.querySelector('#saved-data').value = JSON.stringify(serializedFull, null, '  ');
        }

        $(document).on('click', '#save_properties', function(e){
            var file = $('#upload_file').prop('files');
            var title = $('.properties').children('p');
            title.html($("#title_text").val());
            var image;
            if($('.properties').children('img')){
                image = $('.properties').children('img');
            } else{
                $('.properties').prepend('<img src="" style="height: 100%;width: 100%;"/>');
                image = $('.properties').children('img');
            }
            if (file[0]) {
                image.attr("src", URL.createObjectURL(file[0]));            
            }
        });

        $('.remove_img').on('click', function(){
            $('.properties').children('img').remove();
        });

        $(document).on('click', '.changefile', function(){
            $('.changefile').removeClass("properties");
            $(this).addClass("properties");
            $('#title_text').val('');
            $("#upload_file").val('');
            $('#properties').removeAttr('style');
        });

        (function($){
            var initLayout = function() {

                $('#colorSelector1').ColorPicker({
                    color: '#000000',
                    onShow: function (colpkr) {
                        $(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        $(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        $('.properties p').css('color', '#' + hex);
                        $('#colorSelector2').css('backgroundColor', '#' + hex);

                    }
                });

                $('#colorSelector2').ColorPicker({
                    color: '#000000',
                    onShow: function (colpkr) {
                        $(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        $(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        $('.properties').css('backgroundColor', '#' + hex);
                        $('#colorSelector2').css('backgroundColor', '#' + hex);

                    }
                });
                
            };
            
            EYE.register(initLayout, 'init');
        })(jQuery)
    </script>
</body>

</html>