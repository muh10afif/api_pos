<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class C_user extends API_Controller {

    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_user');
        $this->load->database();
    }

    public function tes()
    {
       $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            // 'requireAuthorization' => true,
        ]);

        header('Content-Type: application/x-www-form-urlencoded'); 
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->input->post('username')); 
        die();
    }

    public function Auth()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST']
        ]);

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $hasil = $this->M_user->Login($username, $password);
        $this->api_return($hasil,200);
    }

    // 16-12-2020
    public function login()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST']
        ]);

        $json = file_get_contents('php://input');

        $dt = json_decode($json, true);

        $userId     = $dt['userId'];
        $password   = $dt['password'];
        $appid      = 201;

        $pass       = "eyJpdiI6IjNcL2psdHIxelp2Y045UHhpSFNDQ0xnPT0iLCJ2YWx1ZSI6IjZNNnpxSnJuejJaeGE1dDFxQnpRUVE9PSIsIm1hYyI6ImYwNjUxYTExNzhhNGZhYzRmOTMwZTAxNmZhYzgzMjQ0NmU2YjViMDU3MTEyMGMyOWY1NTdjYWY0YTM4NWZlZjQifQ==";

        if ($userId == 'AF11') {
            if ($password == 'x') {
                $response   = "not_valid_credentials";
                $message    = "Credentials is not valid. Please provide a correct credentials.";
                $rc         = "63";
                $warning    = "warning";
            } else {
                $response = ['nama'          => "Afif",
                            'nip'           => "12.00.3000",
                            'userid'        => $userId,
                            'kodeCabang'    => "P060",
                            'namaCabang'    => "CABANG UTAMA BANDUNG",
                            "kodeInduk"     => "P009",
                             "namaInduk"    => "CABANG UTAMA BANDUNG",
                             "kodeKanwil"   => "K001",
                             "namaKanwil"   => "KANWIL 1",
                             "jabatan"      => "STAF G4",
                             "posisiPenempatan" => "-",
                             "hp"           => "085624203225",
                             "email"        => "araspati@bankbjb.co.id",
                             "kodeGrade"    => "0085",
                             "namaGrade"    => "G4",
                             "idFungsi"     => "835",
                             "fungsiTambahan"   => "-",
                             "limitDebet"   => "0",
                             "limitKredit"  => "0",
                             "id"           => "20151002103451P0938539"
                           ];
                $message    = "Transaction success";
                $rc         = "00";
                $warning    = "success";
            }
        } else {
            $response   = [];
            $message    = "The requested resource is not found";
            $rc         = "44";
            $warning    = "info";
        }

        $data = ['status'   => $warning,
                 'rc'       => $rc,
                 'response' => $response,
                 'message'  => $message
                ];

        $this->api_return($data,200);
    }
    
    // save user
    public function save_user()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST']
        ]);

        $json = file_get_contents('php://input');

        $dt = json_decode($json, true);

        $reg_employee   = $dt['reg_employee'];
        $email          = $dt['email'];
        $level          = $dt['level'];
        $name           = $dt['name'];
        $kanwil         = $dt['kanwil'];
        $cabang_induk   = $dt['cabang_induk'];

        // cari di user
        $a = $this->db->get_where('m_user', ['reg_employee' => $reg_employee])->num_rows();
        $b = $this->db->get_where('m_employee', ['reg_employee' => $reg_employee])->num_rows();

        if ($a == 0) {

            $data_user = [  'reg_employee'   => $dt['reg_employee'],
                            'email'          => $dt['email'],
                            'level'          => $dt['level'],
                            'active'         => 1
                        ];
            
            $this->db->insert('m_user', $data_user);
            
        }

        if ($b == 0) {

            $data_emp = [   'reg_employee'   => $dt['reg_employee'],
                            'name'           => $dt['name'],
                            'kanwil'         => $dt['kanwil'],
                            'cabang_induk'   => $dt['cabang_induk']
                        ];
            
            $this->db->insert('m_employee', $data_emp);
            
        }
        

        $this->api_return(['status' => TRUE],200);
    }

}

/* End of file C_user.php */
