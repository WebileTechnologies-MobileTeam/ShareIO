$(document).ready(function() {
	"use strict";
	
	//=============================================
	// Clouds
	var config = {
		imageCloud: "bgcloud-assets/images/themes/cloud-default.png",
		skyColor: "#8c9793",
		skyColorPower:100,
		cloudSpeed: 1.5,
		cameraControl: true,
		cloudData: [	// cloud data (position,scale,rotate) // array of objects {x:0,y:0,rotate:0,scale:0}
			{i:0,x:.5,y:.4,scale:3}, // 1
			{i:150,x:.5,y:.4,scale:5}, // 2
			{i:300,x:.5,y:.4,scale:6}, // 3
			{i:450,x:.5,y:.4,scale:6}, // 4
			{i:600,x:.5,y:.4,scale:7}, // 5
			{i:10,x:.35,y:.45,scale:2}, // 1
			{i:160,x:.35,y:.45,scale:4}, // 2
			{i:310,x:.35,y:.45,scale:5}, // 3
			{i:460,x:.35,y:.45,scale:5}, // 4
			{i:610,x:.35,y:.45,scale:6}, // 5
			{i:20,x:.65,y:.45,scale:2}, // 1
			{i:170,x:.65,y:.45,scale:4}, // 2
			{i:320,x:.65,y:.45,scale:5}, // 3
			{i:470,x:.65,y:.45,scale:5}, // 4
			{i:620,x:.65,y:.45,scale:6}, // 5
		]
	};
	
	var clouds = $("#clouds");
	clouds.clouds(config);
	//=============================================
});