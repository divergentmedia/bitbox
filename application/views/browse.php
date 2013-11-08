<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="/assets/themes/blue/style.css" rel="stylesheet" media="screen">
</head>
<body class="container">
	<h1>Browsing <?=$collectionPath?></h1>

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<ol class="breadcrumb">
  		<li><a href="/admin">Admin</a></li>
  		<li class="active">Browse</li>
	</ol>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table id="assetTable" class="table table-hover tablesorter">
				<thead>
					<tr>
						<th>Filename</th>
						<th></th>
					</tr>
				</thead>
				<tbody>


					<?
					$prefix = "/admin/browse/" . $collectionId .'/'.$path_in_url;
					if (!empty($dirs)) { foreach( $dirs as $dir ):?>
					<tr>
						<td><span class="glyphicon glyphicon-folder-close"></span> <?=anchor($prefix.$dir['name'], $dir['name'])?></td>
						<td></td>
					</tr>
					<?endforeach; }

					if (!empty($files)) {foreach( $files as $file ):?>
					<tr>

						<td><span class="glyphicon glyphicon-file"></span><?=$file['name']?></td>
						<td>
							<button class="btn btn-primary btn-xs showSharing" data-collection="<?=$collectionId?>" data-filepath="<?=$path_in_url?>" data-filename="<?=$file['name']?>">
								Share
							</button>
						</td>
					</tr>

					<?endforeach; }?>
				</tbody>
			</table>

			<!-- jQuery -->
			<script src="/assets/jquery.tablesorter.min.js"></script>

			<script>
			$(document).ready(function() 
			{ 
				$("#assetTable").tablesorter(); 
				
				$(".showSharing").on('click', function() {

					var collection = $(this).data('collection');
					var path = $(this).data('filepath');
					var file = $(this).data('filename');
		
					$.post('/admin/shareFile', {collection: collection, path: path, file: file}, function(data, textStatus, xhr) {
						var hash = data.hash;
						$("#urlBlock").attr("href", "<?=site_url("/download/")?>"+"/"+hash);
						$("#urlBlock").text("<?=site_url("/download/")?>"+"/"+hash);
						$("#hash").val(hash);
						$('#sharingDialog').modal('toggle');	
					}, "json");

				});
				
			} 
			); 
			</script>
		</div>
	</div>

</body>
</html>

<div class="modal fade" id="sharingDialog" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Share File</h4>
			</div>
			<div class="modal-body">
				<p>Full URL to file:</p>
				<a href="" id="urlBlock"></a>
				<p>Sharing Hash:</p>
				<input type="text" class="form-control" id="hash" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->