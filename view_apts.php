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
							<h4 class="title">
								Appointments
								<input type="button" class="btn btn-primary" value="Add New" style="float:right !important" onclick="window.location='add_apts.php'" />
							</h4>
							<p class="category">Already scheduled appointments</p>
						</div>
						<div class="content table-responsive table-full-width">
							<table id="aptTable" class="table table-hover table-striped listTable">
								<thead>
									<tr>
										<th>Sr#</th>
										<th>Title</th>
										<th>Scheduled Time</th>
										<th>Alerts / Follow Up</th>
										<th>Manage</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$sql = "select * from appointments where user_id='".$_SESSION['user_id']."'";
									$res = mysqli_query($link,$sql);
									if(mysqli_num_rows($res)){
										$index = 1;
										while($row = mysqli_fetch_assoc($res)){
								?>
										<tr>
											<td><?php echo $index++?></td>
											<td style="text-align:left"><?php echo $row['title']?></td>
											<td>
                                            <?php echo date($appSettings['app_date_format'].' H:i:s',strtotime($row['apt_time']))?>
                                            </td>
											<td>
												<?php
													$exe = mysqli_query($link,"select id from appointment_alerts where apt_id='".$row['id']."'");
													if(mysqli_num_rows($exe)==0){
														echo mysqli_num_rows($exe);	
													}else{
														echo '<a href="#loadAptAlerOrFollowUp" title="Duplicate campaign" data-toggle="modal" onclick="loadAptAlerOrFollowUp(\'alerts\',\''.$row['id'].'\')">'.mysqli_num_rows($exe).'</a>';
													}
													echo ' / ';
													$r = mysqli_query($link,"select id from appointment_followup_msgs where apt_id='".$row['id']."'");
													if(mysqli_num_rows($r)==0){
														echo mysqli_num_rows($r);
													}else{
														echo '<a href="#loadAptAlerOrFollowUp" title="Duplicate campaign" data-toggle="modal" onclick="loadAptAlerOrFollowUp(\'followup\',\''.$row['id'].'\')">'.mysqli_num_rows($r).'</a>';
													}
												?>
											</td>
											<td style="text-align:center">
												<a href="edit_apt.php?id=<?php echo $row['id']?>"><i class="fa fa-edit" style="color:orange"></i></a>&nbsp;&nbsp;
												<i class="fa fa-trash-o" style="color:red; cursor:pointer" onclick="deleteApt('<?php echo $row['id']?>')"></i>
											</td>
										</tr>
								<?php			
										}	
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once("footer_info.php");?>
</div>
<div id="loadAptAlerOrFollowUp" class="modal fade" role="dialog">
	<div class="modal-dialog"> 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="custom-modal-title typeTitle">Alerts/FollowUps</h6>
			</div>
			<div class="modal-body loadAptAlerts">Loading...</div>
			<div class="modal-footer">
				<span id="duplicateCampaignloading" style="display:none">Loading...</span>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php include_once("footer.php");?>
<link rel="stylesheet" type="text/css" href="assets/css/stacktable.css" />
<script type="text/javascript" src="assets/js/stacktable.js"></script>
<script>
	function loadAptAlerOrFollowUp(dataType,aptID){
		$('.loadAptAlerts').html('Loading...');
		$('.typeTitle').html('Loading...');
		if(dataType=='alerts')
			var cmd = 'load_apt_alerts';
		else
			var cmd = 'load_apt_followUp';
			
		$.post('server.php',{cmd:cmd,aptID:aptID},function(r){
			$('.loadAptAlerts').html(r);
			if(cmd=='load_apt_alerts')
				$('.typeTitle').html('Alerts');
			else
				$('.typeTitle').html('Follow Up');
		});
	}
	$('#aptTable').cardtable();
	function deleteApt(aptID){
		if(confirm("Are you sure you want to delete this appointment?")){
			$.post('server.php',{aptID:aptID,"cmd":"delete_apt"},function(r){
				window.location = 'view_apts.php';	
			});	
		}
	}
</script>