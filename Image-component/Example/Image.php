<style>	
	html {		
		height: 100%;	
	}
	body {
		width: 100%;
		height: 100%;
		margin: 0px;		
	}
	.smooth_zoom_preloader {
		background-image: url(../Image-component/Example/zoom_assets/preloader.gif);
	}	
	.smooth_zoom_icons {
		background-image: url(../Image-component/Example/zoom_assets/icons.png);
	}
</style>
<script src="../Image-component/Example/zoom_assets/jquery-1.11.1.min.js"></script>
<script src="../Image-component/Example/zoom_assets/jquery.smoothZoom.min.js"></script>
<script>
	jQuery(function($){
		$('#yourImageID').smoothZoom({
			width: '100%',
			height: '100%',
			responsive: true
		});
	});
</script>
 
	<img id="yourImageID" src="<?php echo $_POST['url'];?>" style="height: 100%" />
