<!DOCTYPE html>
<html>
	<head>
		<title>File Syncing</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body class="container">
		<div class="jumbotron">
			<div class="container" id="headerContainer">
				<h1>File Sync Underway</h1>
				<p>We don't have that file ready for you quite yet</p>
				<p>
					This page will refresh automatically
				</p>
			</div>
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

		<script>
		var windowTimer;
		$(document).ready(function() {
windowTimer = setInterval(function() {
			$.get("/download/checkAvailability/<?=$targetId?>", function(data) {
				if(data == "ready") {
					$("#headerContainer").html("<h1>Download Starting...");
					window.location.reload();
					clearTimeout(windowTimer);
				}
				else if(data == "pending") {

				}
			})

		}, 5000);

		});
		</script>
		
	</body>
</html>