<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_User2 extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_User');
        $this->load->database();
    }

    // mengambil karakter
    public function ambil_kata($text)
    {
        $num_char = 24;
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }
        return substr($text, 0, $num_char);

        // menambahkan kata yang terpotong
        // $char     = $text{$num_char - 1};
        // while($char != ' ') {
        //     $char = $text{++$num_char}; // Cari spasi pada posisi 51, 52, 53, dst...
        // }
        // echo substr($text, 0, $num_char) . '...';
    }

    public function coba()
    {
        $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        $str1  = $this->ambil_kata($text);

        // ambil sisa karakter
        $agk1 = 32 - strlen($str1);
        
        // bagi 2 
        $ht_b = $agk1 / 2;

        // modulus 
        $ht_m = $agk1 % 2;

        if ($ht_m > 0) {
            $fl  = floor($ht_b)+$ht_m;
        } else {
            $fl = $ht_b;
        }

        $c = str_repeat("#", $fl);
        $d = str_repeat("#", $fl);

        $array = [];
        
        //array_push($c.$str1.$d);

    }

    // ambil string
    public function ambil_string($text)
    {
        // panjang text awal
        $lng = strlen($text);

        // panjang text android
        $num_char = 15;
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }
        // ambil text sampai posisi ke 15
        $str_1 = substr($text, 0, $num_char);

        return $str_1;
    }

    public function tes_nama_umkm()
    {
        $text = "WARNA WARNI JUS"." ";

        // panjang text awal
        $lng = strlen($text);

        if ($lng > 16) {
            // panjang text android
            $num_char = 16;
        } else {
            $num_char = $lng;
        }
        
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }

        if ($lng > 16) {
             // ambil text sampai posisi ke 16
            $str_1 = trim(substr($text, 0, $num_char));
        } else {
             // ambil text sampai posisi ke 16
            $str_1 = trim(substr($text, 0, $lng));
        }

        // panjang text setalah dipotong 
        $str_2p = strlen($str_1);
    
        // hitung sisa karakter
        $ss = 16 - $str_2p;

        // dibagi 2 
        $bg = $ss / 2;

        // modulus
        $md = $ss % 2;

        if ($md > 0) {
            $fl = floor($bg);
        } else {
            $fl = $bg;
        }

        $a = str_repeat("-", $fl);
        $b = str_repeat("-", floor($bg) + $md);

        // gabung dengan spasi
        $st = $a.$str_1.$b;

        if ($lng > 16) {

            // ambil string untuk baris kedua
            $str_2 = trim(substr($text, $str_2p, $lng));

            // panjang text setalah dipotong 
            $str_2p2 = strlen($str_2);

            // hitung sisa karakter
            $ss2 = 16 - $str_2p2;

            if ($ss2 > 0) {

                // dibagi 2 
                $bg = $ss2 / 2;

                // modulus
                $md = $ss2 % 2;

                if ($md > 0) {
                    $fl = floor($bg);
                } else {
                    $fl = $bg;
                }

                $a = str_repeat("-", $fl - 1);
                $b = str_repeat("-", floor($bg) + $md);

                // gabung dengan spasi
                $st = $st.$a.$str_2.$b;
    
            } else {
    
                $a2 = trim($this->ambil_string($str_2));
    
                // panjang text setalah dipotong 
                $str_2p2 = strlen($a2);
    
                // hitung sisa karakter
                $ss2 = 16 - $str_2p2;
    
               // dibagi 2 
               $bg = $ss2 / 2;

               // modulus
               $md = $ss2 % 2;

               if ($md > 0) {
                   $fl = floor($bg);
               } else {
                   $fl = $bg;
               }

               $a = str_repeat("-", $fl - 1);
               $b = str_repeat("-", floor($bg) + $md);

               // gabung dengan spasi
               $st = $st.$a.$a2.$b;
    
            }
        
        } else {

            $st = $a.$str_1.$b;
        }

        echo $st;
    }

    public function tes()
    {
        $tes = $this->db->get_where('umkm', ['id_umkm' => 61])->row_array();

        $t = "Test UMKM Cingcin Permata Indah Cingcin Permata Indah Cingcin Permata Indah";

        $pjg = strlen($t);

        $str = $t;

        $str2 = substr($str,24,$pjg);

        $pjg_str2 = strlen($str2);

        

        if ($pjg > 24) {

            // kiri 4 tengah 24 kanan 4 
            $str_24 = substr($str,0,24);

            $a = str_repeat("&nbsp;", 4);
            $b = str_repeat("&nbsp;", 4);

            $str_pertama = $a.$str_24.$b;

            $ht = 32 - $pjg_str2;

            if ($ht > 0) {
                
                // pembagian string kanan kiri
                

                // bagi 2 
                $ht_b = $ht / 2;

                // modulus 
                $ht_m = $ht % 2;

                if ($ht_m > 0) {
                    $fl  = floor($ht_b)+$ht_m;
                } else {
                    $fl = $ht_b;
                }

                $c = str_repeat("&nbsp;", $fl);
                $d = str_repeat("&nbsp;", $fl);

                $str_kedua = $str_pertama."|".$c.$str2.$d;
            } else {
                $str21 = substr($str,24,24);

                $pjg_str22 = strlen($str21);

                $ht = 32 - $pjg_str22;

                // bagi 2 
                $ht_b = $ht / 2;

                // modulus 
                $ht_m = $ht % 2;

                if ($ht_m > 0) {
                    $fl  = floor($ht_b)+$ht_m;
                } else {
                    $fl = $ht_b;
                }

                $c = str_repeat("&nbsp;", $fl);
                $d = str_repeat("&nbsp;", $fl);

                $str_kedua = $str_pertama."|".$c.$str21.$d;
            }

        } else {

            // kiri 4 tengah 24 kanan 4 
            $str_24 = substr($str,0,$pjg);

            $ht = 32 - $pjg;

            // bagi 2 
            $ht_b = $ht / 2;

            // modulus 
            $ht_m = $ht % 2;

            if ($ht_m > 0) {
                $fl  = floor($ht_b)+$ht_m;
            } else {
                $fl = $ht_b;
            }

            $a = str_repeat(" ", $fl);
            $b = str_repeat(" ", $fl);

            $str_kedua = $a.$str_24.$b;

        }

        echo $str_kedua;
        
    }

    public function Get()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 

         $username = $this->input->get('username');
         $password = $this->input->get('password');
         $hasil = $this->M_User->Login($username, $password);
         $msg = "The User does not exist";
         $msg_show[] = array("message"=>$msg);
         if($hasil != null)
         {
            echo json_encode($hasil);
         }
         else
         {
            echo json_encode($msg_show);
         }
    }

    function GetUserDetail()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 

         $id_umkm = $this->input->get('id_umkm');
         $hasil = $this->M_User->GetUser($id_umkm);
         echo json_encode($hasil);
    }

    public function RegistUser()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        // echo file_get_contents('php://input');
        // exit();
        $hasil = $this->M_User->RegistUser($data);
        echo $hasil;
    }

    public function EditProfile()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        // echo file_get_contents('php://input');
        // exit();
        $hasil = $this->M_User->EditProfileUser($data);
        echo json_encode($hasil);
    }

    public function UpdateFoto()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            'requireAuthorization' => true,
        ]);

        $data = json_decode(file_get_contents('php://input'), true);
        // print_r(file_get_contents('php://input'));exit();
        define('UPLOAD_DIR', 'images/');
        // echo base_url('images/'); exit();
        $name_file = $data['nama_umkm'] . '-(' . date('Y-m-d') . ')-' . 'Profile-' . uniqid() . '.png';
        
        $image_base64 = base64_decode($data['gambar']);

        $file = UPLOAD_DIR . $name_file;
        file_put_contents($file, $image_base64);
        
        $data['Foto_dokumen_url'] = $name_file;
        
        $hasil = $this->M_User->UpdateFoto($data);
        
        echo $hasil ;
    }

    public function ChangePassword()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        // print_r(file_get_contents('php://input')); exit();
        $hasil = $this->M_User->ChangePassword($data);
        echo json_encode($hasil);
    }
}