//=================================
// PrettyPrint
//=================================
$(function(){
	window.prettyPrint && prettyPrint();
});

$(document).ready(function() {
	"use strict";
	
	//=============================================
	// Clouds
	var config = {
		imageCloud: "assets/images/themes/cloud-default.png",
		cameraControl: true,
		cloudSpeed:1
	};
	
	var clouds = $("#clouds");
	clouds.clouds(config);
	//=============================================
	
	
	//=============================================
	// Common
	$("[data-background]").each(function () {
		var href = $(this).data("background");
		if (href) {
			$(this).css("background-image", "url(" + href + ")");
		}
	});
	// Common End
	//=============================================
});