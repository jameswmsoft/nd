<?php
	include_once("header.php");
	include_once("left_menu.php");
?>
<style>
.delay_table tr td{
	padding:5px !important;
} 
</style>
<div class="main-panel">
	<?php include_once('navbar.php');?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<form method="post" enctype="multipart/form-data" action="server.php">
					<div class="col-md-12">
						<div class="card">
							<div class="header">
								<h4 class="title">
									Make New Appointment
									<input type="button" class="btn btn-default" value="Back" style="float:right !important" onclick="window.location='view_apts.php'" />
								</h4>
								<p class="category">Make new appointment from here.</p>
							</div>
							<div class="content table-responsive">
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="apt_title" class="form-control" />
								</div>
								<div class="form-group">
									<label>Date/Time</label><br />
									<input type="text" name="apt_date" class="form-control addDatePicker" style="width:49%; display:inline" />
									<select name="apt_time" class="form-control" style="width:49%; display:inline">
									<?php
										$timeArray = getTimeArray();
										foreach($timeArray as $key => $value){
											echo '<option value="'.$key.'">'.$value.'</option>';
										}
					                ?>				
									</select>
								</div>
								<div class="form-group">
									<label>Select Group</label>
									<select name="group_id" class="form-control" onchange="getGroupNumbers(this.value)">
									<option value="">Choose One</option>
                                    <?php
										$sql = "select id,title from campaigns where user_id='".$_SESSION['user_id']."'";
										$res = mysqli_query($link,$sql);
										if(mysqli_num_rows($res)){
											while($row=mysqli_fetch_assoc($res)){
												echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';	
											}
										}
									?>
									</select>
								</div>
								<div class="form-group">
									<label>Select Recipient</label>
									<select name="phone_number_id" id="phone_number_id" class="form-control">
										<option value="">- Select Group Above -</option>
									</select>
								</div>
								<div class="form-group">
									<label>Immediate Message</label>
									<span style="clear: both !important;color:#451e89;display: block;font-size: 12px;">Appointment date = %apt_date%.</span>
									<textarea name="apt_message" class="form-control"></textarea>
                                    <small class="small text-info"> Notes : This messsage will send immediately on create appointment</small>
								</div>

		<div class="col-lg-12" style="padding:0px !important;">
			<div class="portlet">
				<div class="portlet-heading bg-custom" style="background-color:orange !important; padding:2px 5px 2px 10px !important; border-radius:5px;">
					<h5 style="color:#FFF !important; margin-bottom:10px;">
						Appointment alerts
						<a data-toggle="" href="javascript:;"><i class="fa fa-plus" title="Add More" onClick="addMoreAlertMsg()" style="color:#FFF !important; float:right !important"></i></a>
					</h5>
					<div class="portlet-widgets">
						<span class="divider"></span>
						<a href="#bg-primary" data-parent="#accordion1" data-toggle="collapse" class="" aria-expanded="true"><i class="ion-minus-round" title="Show/Hide" style="color:#FFF !important"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="panel-collapse collapse in" id="bg-primary" style="" aria-expanded="true">
					<div class="portlet-body" id="alertMSGContainer" style="padding:10px;">
						<div>
							<table width="100%">
								<tr>
									<td width="25%">Date/Time</td>
									<td>
                                        <input type="text" name="before_date[]" class="form-control addDatePicker" style="width:49%; display:inline" />
                                        <select class="form-control"  name="before_time[]" style="width:49%; display:inline">
											<?php
        										$timeArray = getTimeArray();
        										foreach($timeArray as $key => $value){
        											echo '<option value="'.$key.'">'.$value.'</option>';
        										}
        					                ?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Message</td>
									<td>
										<textarea name="before_message[]" class="form-control textCounter"></textarea>
										<span class="showCounter">
											<span class="showCount"><?php echo $maxLength?></span> Characters left
										</span>
									</td>
								</tr>
								<tr>
									<td>Attach Media</td>
									<td>
										<input type="file" name="before_media[]">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12" style="padding:0px !important; margin-top:15px;">
			<div class="portlet">
				<div class="portlet-heading bg-custom" style="background-color:green !important; padding:2px 5px 2px 10px !important; border-radius:5px;">
					<h5 style="color:#FFF !important">
						Follow up Messages for this appointment.
						<a data-toggle="" href="javascript:;"><i class="fa fa-plus" title="Add More" onClick="addMoreFollowUpMsg()" style="color:#FFF !important; float:right !important"></i></a>
					</h5>
					<div class="portlet-widgets">
						<span class="divider"></span>
						<a href="#bg-primary" data-parent="#accordion1" data-toggle="collapse" class="" aria-expanded="true"><i class="ion-minus-round" title="Show/Hide" style="color:#FFF !important"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="panel-collapse collapse in" id="bg-primary" style="" aria-expanded="true">
					<div class="portlet-body" id="followUpContainer" style="padding:10px;">
						<div>
							<table width="100%">
								<tr>
									<td width="25%">Date/Time</td>
									<td>
                                        <input type="text" name="delay_date[]" class="form-control addDatePicker" style="width:49%; display:inline" />
                                        <select class="form-control"  name="delay_time[]" style="width:49%; display:inline">
											<?php
        										$timeArray = getTimeArray();
        										foreach($timeArray as $key => $value){
        											echo '<option value="'.$key.'">'.$value.'</option>';
        										}
        					                ?>
										</select>
									</td>
								</tr>
                                
								<tr>
									<td>Message</td>
									<td>
										<textarea name="delay_message[]" class="form-control textCounter"></textarea>
										<span class="showCounter">
											<span class="showCount"><?php echo $maxLength?></span> Characters left
										</span>
									</td>
								</tr>
								<tr>
									<td>Attach Media</td>
									<td>
										<input type="file" name="delay_media[]">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
								<div class="form-group">
									<input type="hidden" name="cmd" value="save_appointment" />
									<input type="submit" value="Save" class="btn btn-primary" />
									<input type="button" value="Back" class="btn btn-default" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    
    <div id="follow_up_structure" style="display: none;">
        <table width="100%" class="delay_table">
        	<tr><td colspan="2"><hr style="background-color: #7e57c2 !important;height:1px;margin: 17px;"></td></tr>
            <tr>
				<td width="25%">Date/Time</td>
				<td>
                    <input type="text" name="delay_date[]" class="form-control DatePickerToBe" style="width:49%; display:inline" />
                    <select class="form-control"  name="delay_time[]" style="width:49%; display:inline">
						<?php
							$timeArray = getTimeArray();
							foreach($timeArray as $key => $value){
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
		                ?>
					</select>
				</td>
			</tr>
        	<tr><td>Message</td><td><textarea name="delay_message[]" class="form-control textCounter"></textarea><span class="showCounter"><span class="showCount"><?php echo $maxLength?></span> Characters left</span></td></tr>
        	<tr><td>Attach Media</td><td><input type="file" name="delay_media[]" style="display:inline !important"><span class="fa fa-trash" style="color:red;float:right;margin:10px;cursor:pointer" title="Remove Message" onclick="removeFollowUp(this)"></span></td></tr>
        </table>
    </div>
    
    <div id="alert_msg_structure" style="display: none;">
        <table width="100%" class="delay_table">
        	<tr><td colspan="2"><hr style="background-color: #7e57c2 !important;height:1px;margin: 17px;"></td></tr>
            <tr>
                <td width="25%">Date/Time</td>
                <td>
                <input type="text" name="before_date[]" class="form-control DatePickerToBe" style="width:49%; display:inline" />
                <select class="form-control"  name="before_time[]" style="width:49%; display:inline">
                    <?php
    					$timeArray = getTimeArray();
    					foreach($timeArray as $key => $value){
    						echo '<option value="'.$key.'">'.$value.'</option>';
    					}
                    ?>
                </select>
                </td>
            </tr>
        	<tr><td>Message</td><td><textarea name="before_message[]" class="form-control textCounter"></textarea><span class="showCounter"><span class="showCount"><?php echo $maxLength?></span> Characters left</span></td></tr>
        	<tr><td>Attach Media</td><td><input type="file" name="before_media[]" style="display:inline !important"><span class="fa fa-trash" style="color:red;float:right;margin:10px;cursor:pointer" title="Remove Message" onclick="removeFollowUp(this)"></span></td></tr>
        </table>
    </div>
    
    
	<?php include_once("footer_info.php");?>
</div>
<?php include_once("footer.php");?>
<script>
function getGroupNumbers(groupID){
	$('#phone_number_id').html('<option value="">Loading...</option>');
	$.post('server.php',{groupID:groupID,"cmd":"get_group_subscribers"},function(r){
		$('#phone_number_id').html(r);
	});
}
function addMoreFollowUpMsg(){
	
    var html = $("#follow_up_structure").html();
    html = html.replace(/DatePickerToBe/g, "DatePickerToBe1");
	$('#followUpContainer').append('<div>'+html+'</div>');
	$('.showCounter').hide();
    
    $(".DatePickerToBe1").datepicker({
		inline: true,
		dateFormat: 'yy-mm-dd'
	});
    $(".DatePickerToBe1").addClass("addDatePicker");
    $(".DatePickerToBe1").removeClass("DatePickerToBe1");
}

function addMoreAlertMsg(){
    var html = $("#alert_msg_structure").html();
    html = html.replace(/DatePickerToBe/g, "DatePickerToBe1");
    $('#alertMSGContainer').append('<div>'+html+'</div>');
	$('.showCounter').hide();
    
    $(".DatePickerToBe1").datepicker({
		inline: true,
		dateFormat: 'yy-mm-dd'
	});
    $(".DatePickerToBe1").addClass("addDatePicker");
    $(".DatePickerToBe1").removeClass("DatePickerToBe1");
}

function removeFollowUp(obj){
	if(confirm("Are you sure you want to remove this message?")){
		obj.closest('.delay_table').remove('slow');
	}
}
</script>