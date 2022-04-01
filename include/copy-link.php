<?php
require('./db.php');
$urlsql = "Select file_hash from sentfile where file_id = '" . $_GET["id"] . "'";
$urlsqlresult = mysqli_query($con,$urlsql);
$url_data = mysqli_fetch_array($urlsqlresult);
?> 
<h1>Get Link.</h1>
<div class="alert alert-success fade" id="copyurl" style="display: none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Link Copied to clipboard...!</strong> 
</div>
<div class="url_copy">
	<input id="myInput" value="http://3.135.223.154/file/<?php echo $url_data['file_hash'];?>">
	<button class="btn" onclick="myFunction()">
		<img src="image/clippy.svg" alt="Copy to clipboard" style="width: 13px;">
	</button>
</div>
<script>
	function myFunction() {
      var copyText = document.getElementById("myInput");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      //alert("Copied the text: " + copyText.value);
      $('#copyurl').removeAttr("style");
      $('#copyurl').addClass("in");
    }
</script>