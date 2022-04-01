<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contentshare Video Player</title>
  <style>
    /* ==========================================================================
   #Custom HTML5 Video Player
   ========================================================================== */

:root {
  --youtube-red: #FE0900;
}

html {
  box-sizing: border-box;
  font-family: "YouTube Noto",Roboto,Arial,Helvetica,sans-serif;
  height: 100%;
}

*, *::before, *::after {
  box-sizing: inherit;
  margin: 0;
  padding: 0;
}

body {
  height: 100%;
}

.container {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.video-container {
  width: 800px;
  border-radius: 4px;
  margin: 0 auto;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

video {
  width: 100%;
  height: 100%;
  border-radius: 4px;
}

.video-controls {
  right: 0;
  left: 0;
  padding: 10px;
  position: absolute;
  bottom: 0;
  transition: all 0.2s ease;
  background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5));
}

.video-controls.hide {
  opacity: 0;
  pointer-events: none;
}

.video-progress {
  position: relative;
  height: 8.4px;
  margin-bottom: 10px;
}

progress {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border-radius: 2px;
  width: 100%;
  height: 8.4px;
  pointer-events: none;
  position: absolute;
  top: 0;
}

progress::-webkit-progress-bar {
  background-color: #474545;
  border-radius: 2px;
}

progress::-webkit-progress-value {
  background: var(--youtube-red);
  border-radius: 2px;
}

progress::-moz-progress-bar {
  border: 1px solid var(--youtube-red);
  background: var(--youtube-red);
}

.seek {
  position: absolute;
  top: 0;
  width: 100%;
  cursor: pointer;
  margin: 0;
}

.seek:hover+.seek-tooltip {
  display: block;
}

.seek-tooltip {
  display: none;
  position: absolute;
  top: -50px;
  margin-left: -20px;
  font-size: 12px;
  padding: 3px;
  content: attr(data-title);
  font-weight: bold;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.6);
}

.bottom-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.left-controls {
  display: flex;
  align-items: center;
  color: #fff;
}

.volume-controls {
  display: flex;
  align-items: center;
  margin-right: 10px;
}

.volume-controls input {
  width: 100px;
  opacity: 1;
  transition: all 0.4s ease;
}

.volume-controls:hover input, .volume-controls input:focus {
  width: 100px;
  opacity: 1;
}

button {
  cursor: pointer;
  position: relative;
  margin-right: 7px;
  font-size: 12px;
  padding: 3px;
  border: none;
  outline: none;
  background-color: transparent;
}

button * {
  pointer-events: none;
}

button::before {
  content: attr(data-title);
  position: absolute;
  display: none;
  right: 0;
  top: -50px;
  background-color: rgba(0, 0, 0, 0.6);
  color: #fff;
  font-weight: bold;
  padding: 4px 6px;
  word-break: keep-all;
  white-space: pre;
}

button:hover::before {
  display: inline-block;
}

.fullscreen-button {
  margin-right: 0;
}

.pip-button svg {
  width: 26px;
  height: 26px;
}

.playback-animation {
  pointer-events: none;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: -40px;
  margin-top: -40px;
  width: 80px;
  height: 80px;
  border-radius: 80px;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
}

input[type=range] {
  -webkit-appearance: none;
  -moz-appearance: none;
  height: 8.4px;
  background: transparent;
  cursor: pointer;
}

input[type=range]:focus {
  outline: none;
}

input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  cursor: pointer;
  border-radius: 1.3px;
  -webkit-appearance: none;
  transition: all 0.4s ease;
}

input[type=range]::-webkit-slider-thumb {
  height: 16px;
  width: 16px;
  border-radius: 16px;
  background: var(--youtube-red);
  cursor: pointer;
  -webkit-appearance: none;
  margin-left: -1px;
}

input[type=range]:focus::-webkit-slider-runnable-track {
  background: transparent;
}

input[type=range].volume {
  height: 5px;
  background-color: #fff;
}

input[type=range].volume::-webkit-slider-runnable-track {
  background-color: transparent;
}

input[type=range].volume::-webkit-slider-thumb {
  margin-left: 0;
  height: 14px;
  width: 14px;
  background: #fff;
}

input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  border: 1px solid transparent;
  background: transparent;
  border-radius: 1.3px;
}

input[type=range]::-moz-range-thumb {
  height: 14px;
  width: 14px;
  border-radius: 50px;
  border: 1px solid var(--youtube-red);
  background: var(--youtube-red);
  cursor: pointer;
  margin-top: 5px;
}

input[type=range]:focus::-moz-range-track {
  outline: none;
}

input[type=range].volume::-moz-range-thumb {
  border: 1px solid #fff;
  background: #fff;
}

.hidden {
  display: none;
}

svg {
  width: 28px;
  height: 28px;
  fill: #fff;
  stroke: #fff;
  cursor: pointer;
}
  </style>
</head>
<body>
  <input type="hidden" name="fileid" id="file_id" value="<?php echo $_POST['file_id'];?>">
  <div class="container">
    <div class="video-container" id="video-container">
      <div class="playback-animation" id="playback-animation">
        <svg class="playback-icons">
          <use class="hidden" href="#play-icon"></use>
          <use href="#pause"></use>
        </svg>
      </div>
      <!-- For video trial #t=30,45 -->
      <!--For Video Thambail : poster="http://3.135.223.154/upload/080121125316Desert.jpg" -->
      <video controls autoplay class="video" id="video" preload="metadata">
        <?php if($_POST['useraccess'] == 'No'){
          $useraccess = $_POST['useraccess']; ?>
        <source src="<?php echo $_POST['url'];?>#t=<?php echo $_POST['t_start'];?>,<?php echo $_POST['t_end'];?>" type="video/mp4"></source>
      <?php } else{
        $useraccess = $_POST['useraccess']; ?>
         <source src="<?php echo $_POST['url'];?>" type="video/mp4"></source>
       <?php }?>
      </video>

      <div class="video-controls hidden" id="video-controls">
        <div class="video-progress">
          <progress id="progress-bar" value="0" min="0"></progress>
          <input class="seek" id="seek" value="0" min="0" type="range" step="1">
          <div class="seek-tooltip" id="seek-tooltip">00:00</div>
        </div>

        <div class="bottom-controls">
          <div class="left-controls">
            <button data-title="Play (k)" id="play">
              <svg class="playback-icons">
                <use href="#play-icon"></use>
                <use class="hidden" href="#pause"></use>
              </svg>
            </button>

            <div class="volume-controls">
              <button data-title="Mute (m)" class="volume-button" id="volume-button">
                <svg>
                  <use class="hidden" href="#volume-mute"></use>
                  <use class="hidden" href="#volume-low"></use>
                  <use href="#volume-high"></use>
                </svg>
              </button>

              <input class="volume" id="volume" value="1"
              data-mute="0.5" type="range" max="1" min="0" step="0.01">
            </div>

            <div class="time">
              <time id="time-elapsed">00:00</time>
              <span> / </span>
              <time id="duration">00:00</time>
            </div>
          </div>

          <div class="right-controls">
            <button data-title="PIP (p)" class="pip-button" id="pip-button">
              <svg>
                <use href="#pip"></use>
              </svg>
            </button>
            <button data-title="Full screen (f)" class="fullscreen-button" id="fullscreen-button">
              <svg>
                <use href="#fullscreen"></use>
                <use href="#fullscreen-exit" class="hidden"></use>
              </svg>
            </button>
            
            <button onclick="clicker()" data-title="Download" class="download-button" id="download-button">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="height: 22px; enable-background:new 0 0 512 512;" xml:space="preserve">
              <g>
                <g>
                  <path d="M382.56,233.376C379.968,227.648,374.272,224,368,224h-64V16c0-8.832-7.168-16-16-16h-64c-8.832,0-16,7.168-16,16v208h-64    c-6.272,0-11.968,3.68-14.56,9.376c-2.624,5.728-1.6,12.416,2.528,17.152l112,128c3.04,3.488,7.424,5.472,12.032,5.472    c4.608,0,8.992-2.016,12.032-5.472l112-128C384.192,245.824,385.152,239.104,382.56,233.376z" style="&#10;    fill: white;&#10;"/>
                </g>
              </g>
              <g>
                <g>
                  <path d="M432,352v96H80v-96H16v128c0,17.696,14.336,32,32,32h416c17.696,0,32-14.304,32-32V352H432z" style="&#10;    fill: white;&#10;"/>
                </g>
              </g>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="videolength" id="videolength">
  </div>

  <svg style="display: none">
    <defs>
      <symbol id="pause" viewBox="0 0 24 24">
        <path d="M14.016 5.016h3.984v13.969h-3.984v-13.969zM6 18.984v-13.969h3.984v13.969h-3.984z"></path>
      </symbol>

      <symbol id="play-icon" viewBox="0 0 24 24">
        <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"></path>
      </symbol>

      <symbol id="volume-high" viewBox="0 0 24 24">
      <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"></path>
      </symbol>

      <symbol id="volume-low" viewBox="0 0 24 24">
      <path d="M5.016 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6zM18.516 12q0 2.766-2.531 4.031v-8.063q1.031 0.516 1.781 1.711t0.75 2.32z"></path>
      </symbol>

      <symbol id="volume-mute" viewBox="0 0 24 24">
      <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"></path>
      </symbol>

      <symbol id="fullscreen" viewBox="0 0 24 24">
      <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"></path>
      </symbol>

      <symbol id="fullscreen-exit" viewBox="0 0 24 24">
      <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"></path>
      </symbol>

      <symbol id="pip" viewBox="0 0 24 24">
      <path d="M21 19.031v-14.063h-18v14.063h18zM23.016 18.984q0 0.797-0.609 1.406t-1.406 0.609h-18q-0.797 0-1.406-0.609t-0.609-1.406v-14.016q0-0.797 0.609-1.383t1.406-0.586h18q0.797 0 1.406 0.586t0.609 1.383v14.016zM18.984 11.016v6h-7.969v-6h7.969z"></path>
      </symbol>
    </defs>
  </svg>

  <script>
    // Select elements here
const video = document.getElementById('video');
const videoControls = document.getElementById('video-controls');
const playButton = document.getElementById('play');
const playbackIcons = document.querySelectorAll('.playback-icons use');
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');
const progressBar = document.getElementById('progress-bar');
const seek = document.getElementById('seek');
const seekTooltip = document.getElementById('seek-tooltip');
const volumeButton = document.getElementById('volume-button');
const volumeIcons = document.querySelectorAll('.volume-button use');
const volumeMute = document.querySelector('use[href="#volume-mute"]');
const volumeLow = document.querySelector('use[href="#volume-low"]');
const volumeHigh = document.querySelector('use[href="#volume-high"]');
const volume = document.getElementById('volume');
const playbackAnimation = document.getElementById('playback-animation');
const fullscreenButton = document.getElementById('fullscreen-button');
const videoContainer = document.getElementById('video-container');
const fullscreenIcons = fullscreenButton.querySelectorAll('use');
const pipButton = document.getElementById('pip-button');

const videoWorks = !!document.createElement('video').canPlayType;
if (videoWorks) {
  video.controls = false;
  videoControls.classList.remove('hidden');
}

// Add functions here

// togglePlay toggles the playback state of the video.
// If the video playback is paused or ended, the video is played
// otherwise, the video is paused
function togglePlay() {
  if (video.paused || video.ended) {
    video.play();
  } else {
    video.pause();
  }
}

// updatePlayButton updates the playback icon and tooltip
// depending on the playback state
function updatePlayButton() {
  playbackIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (video.paused) {
    playButton.setAttribute('data-title', 'Play (k)');
  } else {
    playButton.setAttribute('data-title', 'Pause (k)');
  }
}

// formatTime takes a time length in seconds and returns the time in
// minutes and seconds
function formatTime(timeInSeconds) {
  const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

  return {
    minutes: result.substr(3, 2),
    seconds: result.substr(6, 2),
  };
}

// initializeVideo sets the video duration, and maximum value of the
// progressBar
function initializeVideo() {
  const videoDuration = Math.round(video.duration);
  seek.setAttribute('max', videoDuration);
  progressBar.setAttribute('max', videoDuration);
  const time = formatTime(videoDuration);
  duration.innerText = `${time.minutes}:${time.seconds}`;
  duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
}

// updateTimeElapsed indicates how far through the video
// the current playback is by updating the timeElapsed element
function updateTimeElapsed() {
  const time = formatTime(Math.round(video.currentTime));
  timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
  timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
  document.getElementById('videolength').value = "00:"+`${time.minutes}:${time.seconds}`;
  var useraccess = <?php echo json_encode($useraccess);?>;
  if (useraccess == 'No') {
    var videolength = document.getElementById('videolength').value;
    var end = <?php echo json_encode($_POST['t_end']);?>;
    if(videolength == end){
            var id = $("#file_id").val();
            var x = document.getElementById(id);
            if (typeof(x) != 'undefined' && x != null){
      
            } else{
            var div = document.getElementById("video-container");  
            x = document.createElement("INPUT");
            x.setAttribute("type", "hidden");
            x.setAttribute("id", id);
            div.appendChild(x);
            $('#getcontent').click();
              $.ajax({
                  type: "POST",
                  url: "../include/purchase.php",
                  data:{
                    id:id
                  },
                  success: function(html){ 
                    $("#contentshare-model-popup").html(html);
                    $(".close").css("display", "none");
                  }
                });
          }
    }
  }
}

// updateProgress indicates how far through the video
// the current playback is by updating the progress bar
function updateProgress() {
  seek.value = Math.floor(video.currentTime);
  progressBar.value = Math.floor(video.currentTime);
}

// updateSeekTooltip uses the position of the mouse on the progress bar to
// roughly work out what point in the video the user will skip to if
// the progress bar is clicked at that point
function updateSeekTooltip(event) {
  const skipTo = Math.round(
    (event.offsetX / event.target.clientWidth) *
      parseInt(event.target.getAttribute('max'), 10)
  );
  seek.setAttribute('data-seek', skipTo);
  const t = formatTime(skipTo);
  seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
  const rect = video.getBoundingClientRect();
  seekTooltip.style.left = `${event.pageX - rect.left}px`;
}

// skipAhead jumps to a different point in the video when the progress bar
// is clicked
function skipAhead(event) {
  const skipTo = event.target.dataset.seek
    ? event.target.dataset.seek
    : event.target.value;

    var div = document.getElementById('video-container');
    x = document.createElement("INPUT");
    x.setAttribute("type", "hidden");
    var current = Math.floor(video.currentTime);
    var chours = Math.floor(current / 3600);  
    var cminutes = Math.floor(current / 60);
    var cseconds = current % 60;
    var ctime = chours + ":" + cminutes + ":" + cseconds; 
    var shours = Math.floor(skipTo / 3600);  
    var sminutes = Math.floor(skipTo / 60);
    var sseconds = skipTo % 60;
    var stime = shours + ":" + sminutes + ":" + sseconds; 
    var skip = ctime+'-'+stime;
    x.setAttribute("value", skip);
    div.appendChild(x);
  video.currentTime = skipTo;
  progressBar.value = skipTo;
  seek.value = skipTo;
}

// updateVolume updates the video's volume
// and disables the muted state if active
function updateVolume() {
  if (video.muted) {
    video.muted = false;
  }

  video.volume = volume.value;
}

// updateVolumeIcon updates the volume icon so that it correctly reflects
// the volume of the video
function updateVolumeIcon() {
  volumeIcons.forEach((icon) => {
    icon.classList.add('hidden');
  });

  volumeButton.setAttribute('data-title', 'Mute (m)');

  if (video.muted || video.volume === 0) {
    volumeMute.classList.remove('hidden');
    volumeButton.setAttribute('data-title', 'Unmute (m)');
  } else if (video.volume > 0 && video.volume <= 0.5) {
    volumeLow.classList.remove('hidden');
  } else {
    volumeHigh.classList.remove('hidden');
  }
}

// toggleMute mutes or unmutes the video when executed
// When the video is unmuted, the volume is returned to the value
// it was set to before the video was muted
function toggleMute() {
  video.muted = !video.muted;

  if (video.muted) {
    volume.setAttribute('data-volume', volume.value);
    volume.value = 0;
  } else {
    volume.value = volume.dataset.volume;
  }
}

// animatePlayback displays an animation when
// the video is played or paused
function animatePlayback() {
  playbackAnimation.animate(
    [
      {
        opacity: 1,
        transform: 'scale(1)',
      },
      {
        opacity: 0,
        transform: 'scale(1.3)',
      },
    ],
    {
      duration: 500,
    }
  );
}

// toggleFullScreen toggles the full screen state of the video
// If the browser is currently in fullscreen mode,
// then it should exit and vice versa.
function toggleFullScreen() {
  if (document.fullscreenElement) {
    document.exitFullscreen();
  } else if (document.webkitFullscreenElement) {
    // Need this to support Safari
    document.webkitExitFullscreen();
  } else if (videoContainer.webkitRequestFullscreen) {
    // Need this to support Safari
    videoContainer.webkitRequestFullscreen();
  } else {
    videoContainer.requestFullscreen();
  }
}

// updateFullscreenButton changes the icon of the full screen button
// and tooltip to reflect the current full screen state of the video
function updateFullscreenButton() {
  fullscreenIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (document.fullscreenElement) {
    fullscreenButton.setAttribute('data-title', 'Exit full screen (f)');
  } else {
    fullscreenButton.setAttribute('data-title', 'Full screen (f)');
  }
}

// togglePip toggles Picture-in-Picture mode on the video
async function togglePip() {
  try {
    if (video !== document.pictureInPictureElement) {
      pipButton.disabled = true;
      await video.requestPictureInPicture();
    } else {
      await document.exitPictureInPicture();
    }
  } catch (error) {
    console.error(error);
  } finally {
    pipButton.disabled = false;
  }
}

// hideControls hides the video controls when not in use
// if the video is paused, the controls must remain visible
function hideControls() {
  if (video.paused) {
    return;
  }

  videoControls.classList.add('hide');
}

// showControls displays the video controls
function showControls() {
  videoControls.classList.remove('hide');
}

// keyboardShortcuts executes the relevant functions for
// each supported shortcut key
function keyboardShortcuts(event) {
  const { key } = event;
  switch (key) {
    case 'k':
      togglePlay();
      animatePlayback();
      if (video.paused) {
        showControls();
      } else {
        setTimeout(() => {
          hideControls();
        }, 2000);
      }
      break;
    case 'm':
      toggleMute();
      break;
    case 'f':
      toggleFullScreen();
      break;
    case 'p':
      togglePip();
      break;
  }
}

// Add eventlisteners here
playButton.addEventListener('click', togglePlay);
video.addEventListener('play', updatePlayButton);
video.addEventListener('pause', updatePlayButton);
video.addEventListener('loadedmetadata', initializeVideo);
video.addEventListener('timeupdate', updateTimeElapsed);
video.addEventListener('timeupdate', updateProgress);
video.addEventListener('volumechange', updateVolumeIcon);
video.addEventListener('click', togglePlay);
video.addEventListener('click', animatePlayback);
video.addEventListener('mouseenter', showControls);
video.addEventListener('mouseleave', hideControls);
videoControls.addEventListener('mouseenter', showControls);
videoControls.addEventListener('mouseleave', hideControls);
seek.addEventListener('mousemove', updateSeekTooltip);
seek.addEventListener('input', skipAhead);
volume.addEventListener('input', updateVolume);
volumeButton.addEventListener('click', toggleMute);
fullscreenButton.addEventListener('click', toggleFullScreen);
videoContainer.addEventListener('fullscreenchange', updateFullscreenButton);
pipButton.addEventListener('click', togglePip);

document.addEventListener('DOMContentLoaded', () => {
  if (!('pictureInPictureEnabled' in document)) {
    pipButton.classList.add('hidden');
  }
});
document.addEventListener('keyup', keyboardShortcuts);
  </script>
  <script type="text/javascript">

    function clicker() {
        var anchorTag = document.createElement('a');
        anchorTag.href = <?php echo json_encode($_POST['url']);?>;
        anchorTag.download = "download";
        anchorTag.click();


        var element = document.getElementById('video-controls');
        element.appendChild(anchorTag);
    }

</script>


</body>
</html>