<?php
	include_once("header.php");
	include_once("left_menu.php");
?>

<div class="main-panel">
	<?php include_once('navbar.php');?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="header">
							<h4 class="title"> Application Update
								<input type="button" class="btn btn-primary" value="Back" style="float:right !important" onclick="window.location=history.go(-1)" />
							</h4>
							<p class="category">Upgrade application to latest version. </p>
						</div>
						<div class="content table-responsive">
							<?php
								if(trim($latestVersion)!=''){
							?>
							<table class="table table-hover table-striped" style="font-size:12px;">
								<thead>
									<tr>
										<th colspan="2"> New Features and Fixes</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$length = count($Latestupdates);
									$a=1;
									for($i=0; $i<$length; $i++){
								?>
										<tr>
											<td><?=$a?></td>
											<td><?php echo $Latestupdates[$i];?></td>
										</tr>
								<?php
									$a++;
									}
								?>
								</tbody>
							</table>
							<a href="upgrade.php?ver=<?php echo $latestVersion; ?>" class="btn btn-success btn-block"> Upgrade Application </a>
							<?php }else{
									echo '<p class="text-muted font-13" style="color:red">You are runing with latest version.</p>';
								}
								?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once("footer_info.php");?>
</div>
<?php include_once("footer.php");?>