<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller{


	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler();


	}
	public function index()
	{
		$this->load->view('index');
	}
	public function login()	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "email", "trim|required|valid_email");
		$this->form_validation->set_rules("password","password", "trim|required|min_length[8]");
		if($this->form_validation->run() === FALSE)
		{
		    $this->session->set_flashdata("login_errors", validation_errors());
			redirect('/');
		}
		else
		{
			$this->load->model("Session");
			$user = $this->Session->getUser($this->input->post());

			if ($user) {
				$this->session->set_userdata('currentUser',$user);
				// redirect('/users/' . $user['id']);
				redirect('appointments');

			}
			else{
				$this->session->set_flashdata("login_errors", "You are not in the database. Please register.");
				redirect('/');
			}

		}
	}

	public function register()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("name", "Name", "trim|required");
		$this->form_validation->set_rules("email", "email", "trim|required|valid_email");
		$this->form_validation->set_rules("confirmPassword", "password confirmation", "trim|required|matches[password]");
		$this->form_validation->set_rules("password", "password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("dob", "dob", "trim|required|min_length[8]");
		$dob = $this->input->post('dob');
		if ( $dob && count($dob)>=10 ){
			$parts = explode("/",$this->input->post('dob'));
			$year = $parts[0];
			$month = $parts[1];
			$day = $parts[2];
			if (strlen($year) == 4 && strlen($month) == 2 && strlen($day) == 2){
				$this->form_validation->set_rules("dob", "dob", "trim|required|min_length[8]|checkdate($month, $day, $year)");
			}
		}
		if($this->form_validation->run() === FALSE)
		{
		    $this->session->set_flashdata("register_errors", validation_errors());
			redirect('/');
		}
		else
		{
		    $this->load->model("Session");
			if (!$this->Session->getUser($this->input->post())){
				$this->Session->addUser($this->input->post());

				$user = $this->Session->getUser($this->input->post());

				$this->session->set_userdata('currentUser',$user);
				// $this->load->view("quoteDisplay");
				redirect('appointments');
			}
			else{
				$this->session->set_flashdata("login_errors", "You are already in the database. Please login.");
				redirect('/');
			}
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}


}
?>