<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Appointments</title>
	<style type="text/css">
		th, td{
			border: 1px solid black ;
			border-collapse: true;
		}
		
	</style>
	<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
	<link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
	<script type="text/javascript">
		var timepicker = new TimePicker('time', {
  			lang: 'en',
  			theme: 'dark'
		});

		var input = document.getElementById('time');

		timepicker.on('change', function(evt) {
		  var value = (evt.hour || '00') + ':' + (evt.minute || '00');
		  
		  evt.element.value = value;
		});
	</script>
</head>
<body>
	<a href='/logout'>Logout</a>
	<h1>Hello, <?=$this->session->userdata['currentUser']['name']?>!</h1>
	<h3>Here are your appointments for today, <?=$tDate1?></h3>
	<table>
		<tr>
			<th>Tasks</th>
			<th>Time</th>
			<th>Status</th>
			<th>Action</th>
<?php  foreach($todays as $appt){
?>		<tr>
			<td><?=$appt['tasks']?></td>
			<td><?=$appt['appt_time']?></td>
			<td><?=$appt['status']?></td>
<?php if ($appt['status'] != 'Done'){
?>			<td><a href="/update/<?=$appt['appt_id']?>">Edit</a> <a href="/delete/<?=$appt['appt_id']?>">Delete</a></td>
<?php }
?>
		</tr>
<?php }
?>		
	</table>
	<h2>Your Other appointments: </h2>
	<table>
		<tr>
			<th>Tasks</th>
			<th>Date</th>
			<th>Time</th>
			
<?php  foreach($futureAppts as $appt){
?>			
		<tr>
			<td><?=$appt['tasks']?></td>
			<td><?=$appt['appt_date']?></td>
			<td><?=$appt['appt_time']?></td>
		</tr>
<?php }

?>
	</table>
	<h2>Add Appointment</h2>
<?php		if($this->session->flashdata("addAppt_errors"))
			{
				echo $this->session->flashdata("addAppt_errors");
			}
			if($this->session->flashdata("dateErrors"))
			{
				echo $this->session->flashdata("dateErrors");
			}
			
?>	
	<form action="/addAppt" method="post">
		Date: <input type="date" name="apptDate"/><br>
		Time: <input type="time" id ="time" name="apptTime"><br>
		Tasks: <input type="text" name="tasks" /><br>
		<input type="submit" name="add" value = "Add"/>
	</form>
</body>
</html>

