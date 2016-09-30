<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointments extends CI_Controller {
public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler();
		date_default_timezone_set ( 'America/Los_Angeles' );

	}
	
	public function index() {
		$this->load->model("Appointment");
		$results['todays'] = $this->Appointment->getTodaysAppointments($this->session->userdata['currentUser']['id']); 
		$results['futureAppts'] = $this->Appointment->getFutureAppointments($this->session->userdata['currentUser']['id']);

		
		$results['tDate1'] = date('F d, Y');
		
		$this->load->view('/dashboard',$results);
	}
	
	public function addAppointment() { 
		//echo "in addAppointment";
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules("tasks", "Tasks","trim|required");
		$this->form_validation->set_rules("apptDate", "Date","trim|required");
		$this->form_validation->set_rules("apptTime", "Time", "trim|required");

		if($this->form_validation->run() === FALSE )
		{	
		    $this->session->set_flashdata("addAppt_errors", validation_errors());
			redirect('appointments');
			return;
		}
		$dateErrors = $this->validateDatesTimes();
		if ($dateErrors) {
			redirect('appointments');
		}
		else
		{	
			$this->load->model("Appointment");
			$apptDateTime = date_create($this->input->post('apptDate') . $this->input->post('apptTime'));
			$conflicts['conflicts'] = ($this->Appointment->checkConflicts($this->session->userdata['currentUser']['id'], date_format($apptDateTime, "Y/m/d H:i")));
			if (count($conflicts['conflicts'])) {
				$this->session->set_flashdata("addAppt_errors", "This appointment conflicts with another one");
				
				redirect('appointments');
				return;
			}
			$apptID = $this->Appointment->addAppointment($this->input->post(), $this->session->userdata['currentUser']['id']);

			$this->index();
		}
	}
	
	public function updateAppointmentPage($apptID){
		$this->load->model("Appointment");
		$results['appt'] = $this->Appointment->getAppointment($apptID);
		$this->load->view('/update',$results);
	}
	public function doUpdate($apptID) {
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules("apptDate", "Date","trim|required");
		$this->form_validation->set_rules("apptTime", "Time", "trim|required");

		if($this->form_validation->run() === FALSE)
		{	
		    $this->session->set_flashdata("updateAppt_errors", validation_errors());
			
			$this->updateAppointment($apptID, strtotime(date_format($apptDateTime, "Y/m/d H:iP")));
			
			return;
		}
		$dateErrors = $this->validateDatesTimes();
		if ($dateErrors) {
			$this->updateAppointmentPage($apptID);
			
			
		}

		else {
			$this->load->model("Appointment");
			$apptDateTime = date_create($this->input->post('apptDate') . $this->input->post('apptTime'));
			
			$this->Appointment->updateAppointment( $this->input->post(), $apptID);
			$this->index();
		}
	}
	public function deleteAppointment($apptID) {
		$this->load->model("Appointment");
		$this->Appointment->deleteAppointment($apptID);
		$this->index();

	}
	
	private function validateDatesTimes() {
		if (!$this->input->post('apptDate') || !$this->input->post('apptTime')) {
			$dateErrors = "Date and time must be entered.";
			$this->session->set_flashdata("dateErrors",$dateErrors);
			return $dateErrors;
		}
		$today = time();
		$parts = explode(':', $this->input->post('apptTime'));
		if ($parts[0] > 23 || $parts[1] > 59) {
			$dateErrors = "Hour must be less than 24 and minute must be less than 60.";
			$this->session->set_flashdata("dateErrors",$dateErrors);
			return $dateErrors;	
		}
		
		$apptDateTime = date_create($this->input->post('apptDate') . $this->input->post('apptTime'));
		$inputTime = strtotime(date_format($apptDateTime, "Y/m/d H:iP"));
		$dateErrors = "";
		if ($inputTime < $today){
			echo "invalid date"; 
			$dateErrors = "Appointment dates cannot occur before now.";
			$this->session->set_flashdata("dateErrors",$dateErrors);
			return $dateErrors;
		}	
	}
	
}























