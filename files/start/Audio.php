<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>test</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1 user-scalable=no" />

		
		<!--  Import required css and js files  -->
		<link rel="stylesheet" type="text/css"  href="http://3.135.223.154/Audio-player/start/content/global.css"/>
		<link rel="stylesheet" href="http://3.135.223.154/Cube-Countdown/CubicCountdown/css/CubicCountdown.css">
		<link href="http://3.135.223.154/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://3.135.223.154/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="http://3.135.223.154/css/style.css" rel="stylesheet">
		<link href="http://3.135.223.154/css/font-awesome.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script src="http://3.135.223.154/Cube-Countdown/CubicCountdown/js/CubicCountdown.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

		<script src="js/flipbook.min.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPAudioData.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPVisualizer.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAP.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPAudioScreen.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPID3.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPComplexButton.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPContextMenu.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDConsole.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPController.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPCategories.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPCategoriesThumb.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPDisplayObject.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPEventDispatcher.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPInfo.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDAnimation.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPPreloader.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPPlaylist.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPCategories.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPPlaylistItem.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPSimpleButton.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPUtils.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPDL.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPSimpleSizeButton.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPShareWindow.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPToolTip.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPYoutubeScreen.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPVideoScreen.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPTransformDisplayObject.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPHider.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPComboBox.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPComboBoxButton.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPComboBoxSelector.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPPlaybackRateWindow.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPPassword.js"></script>
		<script type="text/javascript" src="http://3.135.223.154/Audio-player/js/FWDRAPScrubberTooltip.js"></script>
		
		 
		<!-- Setup audio player-->
		<script type="text/javascript">
		
		
			FWDRAPUtils.onReady(function(){
				
				new FWDRAP({
					//main settings
					instanceName:"player1",
					parentId:"myDiv",
					playlistsId:"playlists",
					mainFolderPath:"content",
					skinPath:"minimal_skin_dark",
					showSoundCloudUserNameInTitle:"yes",
					googleAnalyticsTrackingCode:"",
					proxyCors:"",
					useDeepLinking:"yes",
					useYoutube:"no",
					youtubeAPIKey:"",
					useVideo:"yes",
					rightClickContextMenu:"default",
					showButtonsToolTips:"yes",
					initializeOnlyWhenVisible:"no",
					addKeyboardSupport:"yes",
					useContinuousPlayback:'no',
					autoPlay:"no",
					loop:"no",
					shuffle:"no",
					useVectorIcons:"yes",
					useHEXColorsForSkin:"yes",
					normalHEXButtonsColor:"#999999",
					normalHEXButtonsColor2:"#FF0000",
					privatePassword:"428c841430ea18a70f7b06525d4b748a",
					soundCloudAPIKey:"",
					maxWidth:801,
					volume:.9,
					toolTipsButtonsHideDelay:1.5,
					toolTipsButtonsBackgroundColor:"#FFFFFF",
					toolTipsButtonFontColor:"#000000",
					//controller settings
					animateOnIntro:"yes",
					showNextAndPrevButtons:"yes",
					showFullScreenButton:"yes",
					showThumbnail:"yes",
					showLoopButton:"yes",
					showShuffleButton:"yes",
					showDownloadMp3Button:"yes",
					showBuyButton:"yes",
					showShareButton:"yes",
					disableAudioScrubbar:"no",
					showMainScrubberAndVolumeScrubberToolTipLabel:"yes",
					expandBackground:"no",
					titleColor:"#FFFFFF",
					timeColor:"#888888",
					scrubbersToolTipLabelBackgroundColor:"#FFFFFF",
					scrubbersToolTipLabelFontColor:"#5a5a5a",
					//controller align and size settings (described in detail in the documentation!)
					controllerHeight:76,
					startSpaceBetweenButtons:9,
					spaceBetweenButtons:8,
					separatorOffsetOutSpace:5,
					separatorOffsetInSpace:9,
					lastButtonsOffsetTop:14,
					allButtonsOffsetTopAndBottom:14,
					titleBarOffsetTop:13,
					mainScrubberOffsetTop:47,
					spaceBetweenMainScrubberAndTime:10,
					startTimeSpace:10,
					scrubbersOffsetWidth:2,
					scrubbersOffestTotalWidth:0,
					volumeButtonAndScrubberOffsetTop:47,
					spaceBetweenVolumeButtonAndScrubber:6,
					volumeScrubberOffestWidth:4,
					scrubberOffsetBottom:10,
					equlizerOffsetLeft:1,
					//playlists window settings
					showPlaylistsSearchInput:"yes",
					usePlaylistsSelectBox:"yes",
					showPlaylistsSelectBoxNumbers:"yes",
					showPlaylistsButtonAndPlaylists:"yes",
					showPlaylistsByDefault:"no",
					randomizePlaylist:"no",
					playlistLoop:"yes",
					useID3ForFolderPlaylist:"no",
					thumbnailSelectedType:"opacity",
					startAtPlaylist:0,
					startAtTrack:0,
					startAtRandomTrack:"no",
					buttonsMargins: 15,
					thumbnailMaxWidth:350, 
					thumbnailMaxHeight:350,
					horizontalSpaceBetweenThumbnails:40,
					verticalSpaceBetweenThumbnails:40,
					playlistSelectorHeight: 38,
					mainSelectorBackgroundSelectedColor:"#FFFFFF",
					mainSelectorTextNormalColor:"#FFFFFF",
					mainSelectorTextSelectedColor:"#000000",
					mainButtonTextNormalColor:"#888888",
					mainButtonTextSelectedColor:"#FFFFFF",
					//playlist settings
					playTrackAfterPlaylistLoad:"no",
					showPlayListButtonAndPlaylist:"yes",
					showPlayListOnMobile:"yes",
					showPlayListByDefault:"yes",
					showPlaylistItemPlayButton:"yes",
					showPlaylistItemDownloadButton:"yes",
					showPlaylistItemBuyButton:"yes",
					forceDisableDownloadButtonForPodcast:"yes",
					forceDisableDownloadButtonForOfficialFM:"yes",
					forceDisableDownloadButtonForFolder:"yes",
					addScrollBarMouseWheelSupport:"yes",
					showTracksNumbers:"yes",
					inversePlaylist:"no",
					playlistSort:"descending",
					playlistBackgroundColor:"#000000",
					trackTitleNormalColor:"#888888",
					trackTitleSelectedColor:"#FFFFFF",
					trackDurationColor:"#888888",
					playlistItemHeight: 27,
					maxPlaylistItems:100,
					nrOfVisiblePlaylistItems:12,
					trackTitleOffsetLeft:0,
					playPauseButtonOffsetLeftAndRight:11,
					durationOffsetRight:9,
					downloadButtonOffsetRight:11,
					scrollbarOffestWidth:7,
					//visualizer
					useVisualizer:'yes',
					visualizerRandomPreset:"no",
					visualizerPreset:"wave1",
					visualizerColor:["#AAAAAA", "#999999", "#AAAAAA", "#777777", "#666666"],
					visualizerCapColor: "#FFFFFF",
					//playback rate / speed
					playbackRateButtonsMargins: 7,
					showPlaybackRateButton:"yes",
					defaultPlaybackRate:1, //min - 0.5 / max - 3
					playbackRateWindowTextColor:"#FFFFFF",
					//password window
					borderColor:"#333333",
					secondaryLabelsColor:"#a1a1a1",
					textColor:"#5a5a5a",
					inputBackgroundColor:"#000000",
					inputColor:"#FFFFFF",
					//search bar settings
					showSearchBar:"yes",
					searchBarPosition:"bottom",
					showSortButtons:"yes",
					searchInputColor:"#999999",
					searchBarHeight:44,
					inputSearchTextOffsetTop:1,
					inputSearchOffsetLeft:0,
					//popup settings
					showPopupButton:"yes",
					openPopupOnPlay:"no",
					popupWindowBackgroundColor:"#878787",
					popupWindowWidth:750,
					popupWindowHeight:423,
					//a to b loop
					atbTimeTextColorNormal:"#888888",
					atbTimeTextColorSelected:"#FFFFFF",
					atbButtonTextNormalColor:"#888888",
					atbButtonTextSelectedColor:"#FFFFFF",
					atbButtonBackgroundNormalColor:"#FFFFFF",
					atbButtonBackgroundSelectedColor:"#000000",
					//login
					playIfLoggedIn:"no",
					playIfLoggedInMessage:"Please <a href='https://google.com' target='_blank'>login</a> to access this track."
				});

				$('#select').change(function(){
					preset = $(this).val();
				
					player1.controller_do.vis.ctx2.clearRect(0, 0, player1.controller_do.vis.sW, player1.controller_do.vis.sH);
					player1.controller_do.vis.preset = preset;
					player1.controller_do.resizeVisualizer();
				});
			});

			function readyHandler(e){
				
			}

			function errorHandler(e){
				//console.log(e.error);
			}

			function startToLoadPlaylistHandler(e){
				console.log("start to load playlist");
			}

			function playlistLoadCompleteHandler(e){
				console.log("playlist load complete");
			}

			function playHandler(e){
				//console.log("play handler");
			}

			function pauseHandler(e){
				//console.log("pause handler");
			}

			function stopHandler(e){
				//console.log("stop handler");
			}

			function udpateHandler(e){
				//console.log("udpateHandler handler " + e.percent);
			}

			function udpateTime(e){
				//console.log("udpateTimeHandler handler " + e.curTime + " / " + e.totalTime);
			}

			function stopHandler(e){
				//console.log("stop");
			}
			
			function playCompleteHandler(e){
				//console.log("play complete");
			}
			
			function buyCustomFunction(){
				alert("The buy button can open a custom link or a custom javascript function.");
			}
			
			function addTrack(){
				player1.addTrack("../../upload/181220115830file_example_MP3_5MG.mp3", "<span style='font-weight:bold'>New added track</span> - new added artist", "content/thumbnails/brian.jpg", "05:45", false, true, "myFunction()");
			}
		</script>
	</head>

	<body style="background-color:#2f2f2f; margin:0;">
		<div id="myDiv" style="margin-top:100px; margin:200px 0 0 100px;"></div>
		<div id="myDiv2" style="margin-top:20px;"></div>
		<div id="myDiv2"></div>

		<select id="select" style="margin-bottom: 20px;">
			<option value="wave1">wave1</option>
			<option value="wave2">wave2</option>
			<option value="bars1">bars1</option>
			<option value="bars2">bars2</option>
		</select>

		<div style="width:400px;">
			
			<button onmousedown="addTrack()">add trac</button>
			<button onmousedown="player1.popup()">player1 popup</button>
			<button onmousedown="player2.popup()">player2 popup</button>
			<button onmousedown="player1.playSpecificTrack(0, 2)">play track 2</button>
			<button onmousedown="player1.play()">play</button>
			<button onmousedown="player1.pause()">pause</button>
			<button onmousedown="player1.stop()">stop</button>
			<button onmousedown="player1.playPrev()">play prev</button>
			<button onmousedown="player1.playNext()">play next</button>
			<button onmousedown="player1.playShuffle()">play shuffle</button>
			<button onmousedown="player1.scrub(.5)">scrub to 50%</button>
			<button onmousedown="player1.setVolume(.2)">set volume to 20%</button>
			<button onmousedown="player1.showCategories()">show playlists</button>
			<button onmousedown="player1.showPlaylist()">show playlist</button>
			<button onmousedown="player1.hidePlaylist()">hide playlist</button>
			<button onmousedown="player1.share()">share</button>
			<button onmousedown="player1.loadPlaylist(2)">load soundcast playlist</button>
			<button onmousedown="player1.loadPlaylist(1)">load podcast</button>
			<button onmousedown="player1.loadPlaylist(3)">load XML playlist</button>
			<button onmousedown="player1.loadPlaylist(0)">load HTML playlist</button>
		</div>
		
		<!--  Playlists -->
		<ul id="playlists" style="display:none;">
			<li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My HTML Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>HTML</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>Created using <strong>HTML markup</strong>, all formats are supported and it can have mixed audio & video.</p>
			</li>
			
			<li data-source="https://www.webdesign-flash.ro/p/rap/podcast/podcast.xml" data-playlist-name="MY PODCAST PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My Podcast Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>PODCAST</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist is created using a podcast URL.</p>
			</li>
			
			<li data-source="https://soundcloud.com/playlist/sets/chance-the-rapper-top-tracks" data-playlist-name="MY SOUNDCLOUD PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My SoundCloud Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>SOUNDCLOUD</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist is created using a SoundCloud playlist URL.</p>
			</li>

			<li data-source="playlistMixed" data-playlist-name="MY MIXED PLAYLIST 1"  data-thumbnail-path="content/thumbnails/p-mixed.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My Mixed Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>MIXED</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist contains mixed media files like  .mp3, .mp4, Youtube,  SoundCloud.</p>
			</li>

			<li data-source="https://www.webdesign-flash.ro/p/rap/content/playlist1.xml" data-playlist-name="MY XML PLAYLIST 1"  data-thumbnail-path="content/thumbnails/p-xml.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My XML Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>XML</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist is created using a XML file.</p>
			</li>

			<li data-source="list=PLxKHVMqMZqUQFbRO0VWaHMaWuQagIgpJe" data-playlist-name="MY YOUTUBE PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My Youtube Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>YOUTUBE</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist is created using a Youtube playlist URL.</p>
			</li>

			<li data-source="mp4Playlist" data-playlist-name="MY VIDEO MP4 PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My Video .mp4 Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>VIDEO MP4</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist contains .mp4 videos and simple HTML markup.</p>
			</li>

			<li data-source="folder:mp3" data-playlist-name="MY FOLDER PLAYLIST 1"  data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="fwdrap-categories-title"><span class="fwdrap-header">Title: </span><span class="fwdrap-title">My Folder Playlist 1</span></p>
				<p class="fwdrap-categories-type"><span class="fwdrap-header">Type: </span>FOLDER</p>
				<p class="fwdrap-categories-description"><span class="fwdrap-header">Description: </span>This playlist is created from a folder with mp3 files.</p>
			</li>
		</ul>

		<!--  HTML playlist -->
		<ul id="playlist1" style="display:none;">
			<li data-path="content/mp3/01.MP3" data-thumbpath="content/thumbnails/small1.jpg" data-use-a-to-b="yes" data-duration="03:02:02">
				<p><span style="font-weight:bold;">Yellow Claw & Tropkillaz</span> - Assets feat. The Kemist</p>
			</li>
			<li data-path="content/mp3/02.mp3" data-thumbpath="content/thumbnails/small2.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/uvp/" data-duration="04:41">
				<p><span style="font-weight:bold;">MACKLEMORE & RYAN LEWIS vs MAJOR LAZER</span> -  can't hold us remix (ft swappi and 1st klase)</p>
			</li>
			<li data-path="content/mp3/03.mp3" data-thumbpath="content/thumbnails/small3.jpg" data-downloadable="no" data-duration="03:49">
				<p><span style="font-weight:bold;">Crush ft. Camden Cox</span> - Could This Be Real (Luminox Remix)</p>
			</li>
			<li data-path="content/mp3/04.mp3" data-thumbpath="content/thumbnails/small4.jpg" data-buy-url="buyCustomFunction();" data-duration="04:19">
				<p><span style="font-weight:bold;">DJ SLiiNK X DiRTY SOUTH JOE</span> - CERTiFiED TRAP TOUR OFFiCiAL MiX</p>
			</li>
			<li data-path="content/mp3/05.mp3" data-thumbpath="content/thumbnails/small5.jpg" data-downloadable="no" data-duration="03:54">
				<p><span style="font-weight:bold;">Knife Party</span> - LRAD (CRNKN FESTIE RMX)</p>
			</li>
			<li data-path="content/mp3/06.mp3" data-thumbpath="content/thumbnails/small6.jpg" data-downloadable="no" data-duration="02:01">
				<p><span style="font-weight:bold;">Sandro Silva & Quintino</span> - Epic (Carnage & Luminox Festival Trap Refix)</p>
			</li>
			<li data-path="content/mp3/07.mp3" data-thumbpath="content/thumbnails/small7.jpg" data-downloadable="yes" data-play-if-logged-in="yes" data-buy-url="buyCustomFunction();" data-duration="02:33">
				<p><span style="font-weight:bold;">New World Sound & Thomas Newson</span> - Flute - <span style="font-weight:bold; color:#0099FF">Must be logged in!</span></p>
			</li>
			<li data-path="content/mp3/08.mp3" data-thumbpath="content/thumbnails/small8.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/s3dcov/" data-duration="02:41">
				<p><span style="font-weight:bold;">Sick Individuals & Axwell ft. Taylr Renee</span> - I AM (Jacob Plant Remix)</p>
			</li>
			<li data-path="content/mp3/09.mp3" data-thumbpath="content/thumbnails/small9.jpg" data-downloadable="no" data-duration="02:36">
				<p><span style="font-weight:bold;">Morgan Page vs. Deorro</span> - "Carry Yee" (Morgan Page Bootleg Remix)</p>
			</li>
			<li data-path="content/mp3/10.mp3" data-thumbpath="content/thumbnails/small10.jpg" data-downloadable="no" data-buy-url="buyCustomFunction();" data-duration="03:15">
				<p><span style="font-weight:bold;">Helicopter Showdown & Kezwik ft. La Meduza</span> - No Return</p>
			</li>
			<li data-path="content/mp3/11.mp3" data-thumbpath="content/thumbnails/small11.jpg" data-downloadable="no"  data-duration="02:53">
				<p><span style="font-weight:bold;">Faithless vs. Danny Avila vs. Justice</span> - We Are Poseidon Insomnia (MAKJ Vs. VINAI Edit)</p>
			</li>
			<li data-path="content/mp3/12.mp3" data-thumbpath="content/thumbnails/small12.jpg" data-downloadable="yes" data-duration="00:35">
				<p><span style="font-weight:bold;">Headhunterz ft. Krewella</span> - United Kids Of The World (Project 46 Remix)</p>
			</li>
			<li data-path="content/mp3/13.mp3" data-thumbpath="content/thumbnails/small13.jpg" data-downloadable="yes" data-duration="00:31">
				<p><span style="font-weight:bold;">SVT116 – Niconé feat. Malonda</span> - Let Love Begin (Acapella)</p>
			</li>
			<li data-path="content/mp3/14.mp3" data-thumbpath="content/thumbnails/small14.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/u3dcar/"  data-duration="01:14">
				<p><span style="font-weight:bold;">Terravita & Casey Desmond</span> - Settle The Score (Case & Point Remix)</p>
			</li>
			<li data-path="content/mp3/15.mp3" data-thumbpath="content/thumbnails/small15.jpg" data-downloadable="yes" data-duration="03:20">
				<p><span style="font-weight:bold;">The Prototypes 'Chronicles' Mix</span> - Recorded Exclusively for EDM.COM</p>
			</li>
			<li data-path="content/mp3/16.mp3" data-thumbpath="content/thumbnails/small16.jpg" data-downloadable="yes" data-duration="00:20">
				<p><span style="font-weight:bold;">Bass Kleph, Chris Arnott, Tommy Trash</span> - We Feel Love (Daleri Bootleg)</p>
			</li>
			<li data-path="content/mp3/07.mp3" data-thumbpath="content/thumbnails/small17.jpg" data-downloadable="no" data-duration="02:33">
				<p><span style="font-weight:bold;">Alina Baraz & Galimatias</span> - Pretty Thoughts</p>
			</li>
			<li data-path="content/mp3/08.mp3" data-thumbpath="content/thumbnails/small18.jpg" data-downloadable="no" data-duration="02:41">
				<p><span style="font-weight:bold;">Der Rauber Und Der Prinz</span> - Jagd Auf Den Hirsch (Guti remix) DESOLAT 2010</p>
			</li>
			<li data-path="content/mp3/09.mp3" data-thumbpath="content/thumbnails/small19.jpg" data-downloadable="no" data-duration="02:36">
				<p><span style="font-weight:bold;">Great Good Fine Ok</span> - You're The One For Me (option4 remix)</p>
			</li>
			<li data-path="content/mp3/10.mp3" data-thumbpath="content/thumbnails/small20.jpg" data-downloadable="yes" data-buy-url="buyCustomFunction();" data-duration="03:15" data-is-private="yes">
				<p><span style="font-weight:bold;color:#0099FF;">PRIVATE VIDEO</span> - Please enter password to play track, test password is <span style="font-weight:bold;color:#0099FF;">Melinda</span></p>
			</li>
			<li data-path="https://radiom2o-lh.akamaihd.net/i/RadioM2o_Live_1@42518/master.m3u8" data-thumbpath="content/thumbnails/small21.jpg" data-downloadable="no" data-duration="00:00">
				<p><span style="font-weight:bold; color:#dbc300;">HLS / LIVE STREAMING / m3u8</span> - http://radiom2o-lh.akamaihd.net/i/RadioM2o_Live_1@42518/master.m3u8</p>
			</li>
			<li data-path="http://144.217.158.181:80" data-type="shoutcast" data-thumbpath="content/thumbnails/small21.jpg" data-downloadable="no" data-duration="00:00">
				<p><span style="font-weight:bold; color:#e78e09;">SHOUTCAST EXAMPLE</span></p>
			</li>
		</ul>		
				
		<!--  Mp4 playlist -->
		<ul id="mp4Playlist" style="display:none;">
			<li data-path="content/videos/fwd.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg"  data-video-poster-path="content/thumbnails/video-poster.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/uvp/" data-duration="01:07">
				<p><span style="font-weight:bold; color:#e77e22;">MP4</span> - MACKLEMORE & RYAN LEWIS vs MAJOR LAZER  can't hold us remix (ft swappi and 1st klase)</p>
			</li>
			<li data-path="content/videos/360.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:21">
				<p><span style="font-weight:bold; color:#e84c3d;">MP4</span> - Liviu Teodorescu & Dorian Popa feat. Laura Giurcanu - Fanele | Videoclip Oficial</p>
			</li>
			<li data-path="content/videos/evp.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:04">
				<p><span style="font-weight:bold; color:#f2c40f;">MP4</span> - Swedish House Mafia - Swedish House Mafia | BBC Radio 1 Essential Mix</p>
			</li>
			<li data-path="content/videos/grid.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/uvp/" data-duration="00:53">
				<p><span style="font-weight:bold; color:#3ab54b;">MP4</span> - MACKLEMORE & RYAN LEWIS vs MAJOR LAZER -  can't hold us remix (ft swappi and 1st klase)</p>
			</li>
			<li data-path="content/videos/mgz.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:15">
				<p><span style="font-weight:bold; color:#00aff0;">MP4</span> - Akcent feat. Amira - Gold (Official Video)</p>
			</li>
			
			<li data-path="content/videos/mlp.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="00:51">
				<p><span style="font-weight:bold; color:#0054a5;">MP4</span> - Brian's House Brian's House #10: Your Dad's A Star. You Suck.</p>
			</li>
			<li data-path="content/videos/r3dcar.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg"  data-duration="00:41">
				<p><span style="font-weight:bold; color:#e77e22;">MP4</span> - DJ SLiiNK X DiRTY SOUTH JOE - CERTiFiED TRAP TOUR OFFiCiAL MiX</p>
			</li>
			<li data-path="content/videos/r3dcov.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="00:57">
				<p><span style="font-weight:bold; color:#e84c3d;">MP4</span> - RUBY feat. UZZI - Nu caut iubiri (by Carla's Dreams)</p>
			</li>
			<li data-path="content/videos/rap.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:12">
				<p><span style="font-weight:bold; color:#f2c40f;">MP4</span> - OctoberLUV Trey Songz - Play House</p>
			</li>
			<li data-path="content/videos/rdm.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-downloadable="yes"  data-duration="01:22">
				<p><span style="font-weight:bold; color:#3ab54b;">MP4</span> - Knife Party</span> - LRAD (CRNKN FESTIE RMX)</p>
			</li>
			<li data-path="content/videos/s3dcov.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:32">
				<p><span style="font-weight:bold; color:#00aff0;">MP4</span> - Amira - Mai stai feat. DiezZ (Official Video)</p>
			</li>
			<li data-path="content/videos/u3dcar.mp4" data-video-poster-path="content/thumbnails/video-poster.jpg" data-duration="01:00">
				<p><span style="font-weight:bold; color:#0054a5;">MP4</span> - Nirvana - Girls (Dj Dima House & Samsonoff Remix).</p>
			</li>
		</ul>
		
		<!--  HTML mixed playlist -->
		<ul id="playlistMixed" style="display:none;">
			<li data-path="content/mp3/01.mp3" data-thumbpath="content/thumbnails/small1.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/uvp/" data-duration="06:16">
				<p><span style="font-weight:bold; color:#e77e22;">MP3</span> - MACKLEMORE & RYAN LEWIS vs MAJOR LAZER  can't hold us remix (ft swappi and 1st klase)</p>
			</li>
			<li data-path="https://www.youtube.com/watch?v=GJjCfF0nlIg" data-thumbpath="" data-duration="03:32">
				<p><span style="font-weight:bold; color:#e84c3d;">YOUTUBE</span> - Liviu Teodorescu & Dorian Popa feat. Laura Giurcanu - Fanele | Videoclip Oficial</p>
			</li>
			<li data-path="https://soundcloud.com/classyton/ren-dominoes-nexeri-remix" data-thumbpath="content/thumbnails/swedish.jpg" data-duration="04:59">
				<p><span style="font-weight:bold; color:#f2c40f;">SOUNDCLOUD</span> - Swedish House Mafia - Swedish House Mafia | BBC Radio 1 Essential Mix</p>
			</li>
			<li data-path="content/videos/fwd.mp4" data-thumbpath="content/thumbnails/nirvana.jpg" data-duration="01:07">
				<p><span style="font-weight:bold; color:#0054a5;">MP4</span> - Nirvana - Girls (Dj Dima House & Samsonoff Remix).</p>
			</li>
			<li data-path="https://radiom2o-lh.akamaihd.net/i/RadioM2o_Live_1@42518/master.m3u8" data-thumbpath="content/thumbnails/small21.jpg" data-downloadable="no" data-duration="00:00">
				<p><span style="font-weight:bold; color:#dbc300;">HLS / LIVE STREAMING / m3u8</span> - http://radiom2o-lh.akamaihd.net/i/RadioM2o_Live_1@42518/master.m3u8</p>
			</li>
			<li data-path="http://144.217.158.181:80" data-type="shoutcast" data-thumbpath="content/thumbnails/small21.jpg" data-downloadable="no" data-duration="00:00">
				<p><span style="font-weight:bold; color:#e78e09;">SHOUTCAST EXAMPLE</span></p>
			</li>
			<li data-path="content/mp3/02.mp3" data-thumbpath="content/thumbnails/small2.jpg" data-downloadable="yes" data-buy-url="http://webdesign-flash.ro/p/uvp/" data-duration="04:41">
				<p><span style="font-weight:bold; color:#3ab54b;">MP3</span> - MACKLEMORE & RYAN LEWIS vs MAJOR LAZER -  can't hold us remix (ft swappi and 1st klase)</p>
			</li>
			<li data-path="https://www.youtube.com/watch?v=3-jmDVwq9Qc" data-thumbpath="" data-duration="03:46">
				<p><span style="font-weight:bold; color:#00aff0;">YOUTUBE</span> - Akcent feat. Amira - Gold (Official Video)</p>
			</li>
			<li data-path="https://soundcloud.com/brians-house-1/brians-house-10-your-dads-a" data-thumbpath="content/thumbnails/brian.jpg" data-duration="08:51">
				<p><span style="font-weight:bold; color:#0054a5;">SOUNDCLOUD</span> - Brian's House Brian's House #10: Your Dad's A Star. You Suck.</p>
			</li>
			<li data-path="content/videos/fwd.mp4" data-thumbpath="" data-duration="01:07">
				<p><span style="font-weight:bold; color:#00aff0;">MP4</span> - Amira - Mai stai feat. DiezZ (Official Video)</p>
			</li>
			<li data-path="content/mp3/03.mp3" data-thumbpath="content/thumbnails/small3.jpg"  data-duration="03:49">
				<p><span style="font-weight:bold; color:#e77e22;">MP3</span> - DJ SLiiNK X DiRTY SOUTH JOE - CERTiFiED TRAP TOUR OFFiCiAL MiX</p>
			</li>
			<li data-path="https://www.youtube.com/watch?v=yUl0U7n0RoY" data-thumbpath="" data-duration="04:43">
				<p><span style="font-weight:bold; color:#e84c3d;">YOUTUBE</span> - RUBY feat. UZZI - Nu caut iubiri (by Carla's Dreams)</p>
			</li>
		</ul>
		
	</body>
	
</html>


 	

