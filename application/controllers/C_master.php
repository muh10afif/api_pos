<?php 

require APPPATH . '/libraries/API_Controller.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class C_master extends API_Controller {

    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_master');
        $this->load->database();
    }

    // public function Auth()
    // {
    //     $user_data = $this->_apiConfig([
    //         'methods' => ['GET'],
    //         'requireAuthorization' => true,
    //     ]);

    //     header('Content-Type: application/json'); 

    //      $username = $this->input->get('username');
    //      $password = $this->input->get('password');

    //      $hasil = $this->M_user->Login($username, $password);
    //      $msg = "The User does not exist";
    //      $msg_show[] = array("message"=>$msg);
    //      if($hasil != null)
    //      {
    //         echo json_encode($hasil);
    //      }
    //      else
    //      {
    //         echo json_encode($msg_show);
    //      }
    // }

    public function ambil_list()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => TRUE
        ]);

        header('Content-Type: application/json');

        $id_user = $this->input->get('id_user');
        
    }

    

}

/* End of file C_master.php */
