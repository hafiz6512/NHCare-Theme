<?php
add_shortcode('ytvideo', 'ytvideo_shortcode');
function ytvideo_shortcode($atts, $content = null) {

extract( shortcode_atts( array(
		'youtubeid' => '',
	), $atts ) );
  		
  	echo " <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id=\"player\" class=\"youtube-player\" type=\"text/html\"></div>
    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = \"https://www.youtube.com/iframe_api\";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
        height: '372',
      	width: '660',
        videoId: '{$youtubeid}',
	playerVars: {'autoplay': 1, 'controls': 1, 'autohide': 1, 'showinfo': 0, 'loop': 1, 'rel': 0, 'playlist':'{$youtubeid}'},
          events: {
            'onReady': onPlayerReady
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
      event.target.setVolume(0);
      if ($(window).width() >= 768) {
	event.target.setVolume(0);
	event.target.playVideo();
       }
      }
    </script>";
}