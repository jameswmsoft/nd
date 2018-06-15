<?php
	include_once("header.php");
	include_once("left_menu.php");
	$month = date("Y-m-d",strtotime("-11 days"));
	$endDay= date("M-d");
	$smsIn = 0;
	$smsOut= 0;
	$data  = '';
	for($i=0;$i<=11;$i++){
		$day = date("M-d-y",strtotime($month."+".$i." day"));
		$curDate = date("Y-m-d",strtotime($month."+".$i." day"));
		
		$sqlIn = "select id from sms_history where user_id='".$_SESSION['user_id']."' and date(created_date)='".$curDate."' and direction='in-bound'";
		$resIn = mysqli_query($link,$sqlIn);
		$smsIn = mysqli_num_rows($resIn);
		
		$sqlOut = "select id from sms_history where user_id='".$_SESSION['user_id']."' and date(created_date)='".$curDate."' and direction='out-bound'";
		$resOut = mysqli_query($link,$sqlOut);
		$smsOut = mysqli_num_rows($resOut);

		$data .= "['".date($appSettings['app_date_format'],strtotime($day))."' , ".$smsIn." , ".$smsOut."],";
		if($day == $endDay)
			exit();
	}
	$data = trim($data,',');
?>

<style>
.panel-green {
  border-color: #5cb85c;
}
.panel-green > .panel-heading {
  border-color: #5cb85c;
  color: white;
  background-color: #5cb85c;
}
.panel-green > a {
  color: #5cb85c;
}
.panel-green > a:hover {
  color: #3d8b3d;
}
.panel-red {
  border-color: #d9534f;
}
.panel-red > .panel-heading {
  border-color: #d9534f;
  color: white;
  background-color: #d9534f;
}
.panel-red > a {
  color: #d9534f;
}
.panel-red > a:hover {
  color: #b52b27;
}
.panel-yellow {
  border-color: #f0ad4e;
}
.panel-yellow > .panel-heading {
  border-color: #f0ad4e;
  color: white;
  background-color: #f0ad4e;
}
.panel-yellow > a {
  color: #f0ad4e;
}
.panel-yellow > a:hover {
  color: #df8a13;
}
</style>
<div class="main-panel">
	<?php include_once('navbar.php');?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-group fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo getTotalGroups($_SESSION['user_id'])?></div>
									<div>Locations</div>
								</div>
							</div>
						</div>
						<a href="view_campaigns.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-bullhorn fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo getTotalAutoresponders($_SESSION['user_id'])?></div>
									<div>Autoresponders</div>
								</div>
							</div>
						</div>
						<a href="view_autores.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-user fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo getTotalActiveSubscribers($_SESSION['user_id'])?></div>
									<div>Subscribers</div>
								</div>
							</div>
						</div>
						<a href="view_subscribers.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<!-- <div class="col-lg-3 col-md-6">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-user-times fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo getTotalBlockedSubscribers($_SESSION['user_id'])?></div>
									<div>Unsubscribers</div>
								</div>
							</div>
						</div>
						<a href="view_subscribers.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card ">
						<div class="content ct-chart" id="chartActivity">

						</div>
							-->
						<!--
						<div class="header">
							<h4 class="title"><?php echo date('Y').' Subscribers/UnSubscribers'?></h4>
							<p class="category">Subscribers activity date wise</p>
						</div>
						<div class="content">
							<div id="chartActivity" class="ct-chart"></div>
							<div class="footer">
								<div class="legend"> <i class="fa fa-circle text-info"></i> Subscribers <i class="fa fa-circle text-danger"></i> Unsubscribers </div>
								<hr>
								
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once("footer_info.php");?>
</div>
<?php include_once("footer.php");?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	google.charts.load('current', {'packages':['line']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart(){
		var data = new google.visualization.DataTable();
		data.addColumn('string', '');
		data.addColumn('number', 'SMS In');
		data.addColumn('number', 'SMS Out');
		//data.addColumn('number', 'Transformers: Age of Extinction');
		
		data.addRows([<?php echo $data?>]);
		var options = {
			chart:{
				title: 'SMS In and Out',
				subtitle: 'Last 10 days activity'
			}
		};
		var chart = new google.charts.Line(document.getElementById('chartActivity'));
		chart.draw(data, google.charts.Line.convertOptions(options));
	}	
	$(window).resize(function(){
		drawChart();
	});

	/*
	var data = {
	  labels: [<?php echo $data?>],
	  series: [
		[<?php echo $subs?>],
		[<?php echo $unSubs?>]
		//[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
		//[412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
	  ]
	};
	var options = {
		seriesBarDistance: 11,
		axisX: {
			showGrid: true
		},
		height: "245px"
	};
	var responsiveOptions = [
	  ['screen and (max-width: 640px)', {
		seriesBarDistance: 5,
		axisX: {
		  labelInterpolationFnc: function (value) {
			return value[0];
		  }
		}
	  }]
	];
	Chartist.Bar('#chartActivity', data, options, responsiveOptions);
	*/
</script>