<!DOCTYPE html>
<html>
	<head>
		<title>Admin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body class="container">
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

		<h1>Existing Collections:</h1>
		<div class="row">
			<div class="col-md-6">
				<?foreach($collections as $collection):?>
					<div class="row">
						<div class="col-md-12">
							<ul class="list-group">
								<li class="list-group-item"><strong>Path: </strong><?=$collection->getPath()?></li>
								<li class="list-group-item"><strong>Secret: </strong><?=$collection->getSecret()?></li>
								<li class="list-group-item"><a href="<?=site_url("/admin/browse/". $collection->getId())?>" class="btn btn-primary">Browse</a></li>
							</ul>

						</div>
					</div>

				<?endforeach?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6">
			<form action="/admin/addFolder" method="POST" role="form">
				<legend>Add a Collection:</legend>
			
				<div class="form-group">
					<label for="">Secret</label>
					<input type="text" class="form-control" name="secret" id="secret" placeholder="Secret">
				</div>
				<div class="form-group">
					<label for="">Path</label>
					<input type="text" class="form-control" name="folderPath" id="folderPath" placeholder="Path">
				</div>
				<button type="submit" class="btn btn-primary">Save</button>
			</form>
			</div>
		</div>

	</body>
</html>

