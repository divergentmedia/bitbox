<!DOCTYPE html>
<html>
	<head>
		<title>File Downloading</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <META http-equiv="refresh" content="1;URL=/download/getFile/<?=$targetId?>/true">
		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body class="container">
		<div class="jumbotron">
			<div class="container" id="headerContainer">
				<h1>Downloading <?=$filename?></h1>
				<p>Your download should start immediately, if it doesn't, click <a href="/download/getFile/<?=$targetId?>/true">here</a></p>
			</div>
		</div>
		
	</body>
</html>