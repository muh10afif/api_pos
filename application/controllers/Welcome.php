<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->db->reconnect();
		$this->load->database();
	}
	

	public function index()
	{
		$this->load->view('welcome_message');
	}
}