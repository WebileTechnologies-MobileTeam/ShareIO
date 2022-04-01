<?php

require('../include/inc/defined_variables.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="<?php echo SITE_URL;?>/css/style.css" rel="stylesheet">

<body class="file_not_found">

	<div class="header_new">

		<a href="#"><img src="<?php echo SITE_URL;?>/images/content-share-new-logo.png" alt="Logo" /></a>

	</div>

	<div class="file_not_found_content">

		<?php

		if(isset($_GET['err'])){?>

			<h1>This content has been temporarily removed.</h1>

		<?php } else if(isset($_GET['exp'])){ ?>

			<h1>This Content has expired or been removed by the author.</h1>

		<?php } else if(isset($_GET['del'])){ ?>

			<h1>This link is no longer valid as the user has been removed from ContentShare.</h1>

		<?php } else if(isset($_GET['imp'])){ 

			$user =  $_GET['user'];?>

			<h1>This content cannot currently be displayed</h1></br>

			<h1><?php echo $user;?>'s impresions have expired.</h1>

		<?php } else if(isset($_GET['browser'])){ ?>

			<h1>This link cannot be viewed in a browser.</h1></br>

		<?php } else if(isset($_GET['block'])){ ?>

			<h1>This content has been blocked due to community feedback.</h1></br>

		<?php } else if(isset($_GET['country'])){ ?>

			<h1>This content cannot be viewed in your country.</h1></br>

		<?php } else if(isset($_GET['ip'])){ ?>

			<h1>This content not allowed to be viewed on this device.</h1></br>

		<?php } else{ ?>

			<h1>This Content has expired or been removed by the author.</h1>

		<?php }?>

	</div>

</body>