<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Destination</title>
	<style type="text/css">
		form{
			margin-top: 50px;
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
	<a href="/appointments">Dashboard</a>
	<a href="/logout">Logout</a><br>
<?php		if($this->session->flashdata("updateAppt_errors"))
			{
				echo $this->session->flashdata("updateAppt_errors");
			}
			if($this->session->flashdata("dateErrors"))
			{
				echo $this->session->flashdata("dateErrors");
			}
?>	
	<form action="/doUpdate/<?=$appt['id']?>" method= "post" id="updateForm"> 
		Tasks: <input type="text" name="tasks" value="<?=$appt['tasks']?>"</input><br>
		Status: <select name="status" value=<?=$appt['status']?>>
			<option value=2 <?php if($appt['status'] == 'Done'){echo("selected");}?>>Done</option>
			<option value=1 <?php if($appt['status'] == 'Pending'){echo("selected");}?>>Pending</option>
			<option value=3 <?php if($appt['status'] == 'Missed'){echo("selected");}?>>Missed</option>
		</select><br>
		Date: <input type="date" name="apptDate" value = <?=$appt['appt_date']?>/><br>
		Time: <input type="text" name="apptTime" id="time" value = <?=$appt['appt_time']?>><br>
		<input type="submit"  value="Update" /><br>
	</form>

</body>
</html>