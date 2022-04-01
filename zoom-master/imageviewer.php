
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        #myWindow {
            cursor: grab;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #myContent {
            position: relative;
            display: flex;
            align-items: center;
        }

        #myContent img {
            display: block;
            width: auto;
            height: auto;
            margin: auto;
            align-self: center;
            flex-shrink: 0;
        }

        #myContent div {
            position: absolute;
            font-size: 80px;
        }
    </style>


        <div class="col-12 col-lg-8">
            <div class="d-flex my-3">
                <button data-zoom-down class="btn btn-info">Zoom Down</button>
                <button data-zoom-up class="btn btn-info ml-auto">Zoom Up</button>
            </div>

            <div class="embed-responsive embed-responsive-4by3 rounded bg-secondary">
                <div id="myWindow" class="embed-responsive-item">
                    <div id="myContent">
                        <img src="<?php echo $_POST['url']; ?>" alt="image"/>
                    </div>
                </div>
            </div>
        </div>




