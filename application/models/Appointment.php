<?php
class Appointment extends CI_Model{
	function getTodaysAppointments($userID) {
         // $sql = "SELECT * FROM travel_plans WHERE created_by = ?";
        $sql = "select a.user_id, a.id 'appt_id', date_format(appt_date, '%H:%i') 'appt_time', a.tasks, s.status from appointments a join status s on s.id = a.status where date(appt_Date) = curdate() and user_id = ? order by appt_date asc" ;
        $vals = [$userID];
        return $this->db->query($sql,$vals)->result_array(); 
	}
    function getFutureAppointments($userID) {
        $sql = "select user_id, tasks, date_format(appt_date, '%b %d, %Y') appt_date, date_format(appt_date, '%H:%i') 'appt_time' from appointments where appt_date > curdate()+1 and user_id = ? order by appt_date asc";
        $vals = [$userID];
        return $this->db->query($sql,$vals)->result_array();  
    }

    function checkConflicts($userID, $apptDateTime) {
        //var_dump($apptDateTime); die();
        $sql = "select id from appointments where user_id = ? and appt_date between ? and date_add(?, interval 1 minute)" ;
        $vals = [$userID, $apptDateTime, $apptDateTime];
        return $this->db->query($sql,$vals)->result_array();     
    }

	function addAppointment($apptInfo, $userID) {

        $sql = "insert into appointments (user_id, appt_date, tasks, status, created_at,updated_at) values (?,?,?,?,now(),now())";
        
        $apptDateTime = date_create($apptInfo['apptDate'] . $apptInfo['apptTime']);
        $vals = [$userID, date_format($apptDateTime, "Y/m/d H:iP"), $apptInfo['tasks'], 1];
        $this->db->query($sql, $vals);
        return $this->db->insert_id();
    }
    function updateAppointment($apptInfo, $apptID) {
        $sql = "update appointments set  tasks = ?, appt_date = ?, status = ? where id = ?";
        $apptDateTime = date_create($apptInfo['apptDate'] . $apptInfo['apptTime']);
        $vals = [$apptInfo['tasks'], date_format($apptDateTime, "Y/m/d H:iP"), intval($apptInfo['status']), $apptID];
        $this->db->query($sql, $vals);
    }
    function deleteAppointment($apptID) {
        $sql = "delete from appointments where id = ?";
        $vals = [$apptID];
        $this->db->query($sql, $vals);
    }
    function getAppointment($apptID) {
        $sql = "select a.id, tasks, date_format(a.appt_date, '%b %d, %Y') 'appt_date', appt_date, date_format(a.appt_date, '%H:%i') 'appt_time',  s.status from appointments a join status s on s.id = a.status where a.id = ?";
        $vals = [$apptID];
        return $this->db->query($sql,$vals)->row_array();     
    }
}
?>
