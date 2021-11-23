<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class C_transaksi extends API_Controller {

    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('M_transaksi');
        $this->load->database();
    }

    // 11-07-2020

    public function list_hari_ini()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => false
        ]);

        header('Content-Type: application/json');

        $id_user = $this->input->get('id_user');

        $hasil = $this->M_transaksi->get_list_hari_ini($id_user);

        echo json_encode($hasil);
    }

    public function tgl_list_hari()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => false
        ]);

        header('Content-Type: application/json');

        $id_user    = $this->input->get('id_user');
        $tgl_awal   = $this->input->get('tgl_awal');
        $tgl_akhir  = $this->input->get('tgl_akhir');
        $kasir      = $this->input->get('kasir');

        $hasil = $this->M_transaksi->get_tgl_list_hari($id_user, $tgl_awal, $tgl_akhir, $kasir);

        echo json_encode($hasil);
    }

    public function ambil_kasir()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => false
        ]);

        header('Content-Type: application/json');

        $id_user    = $this->input->get('id_user');

        $hasil = $this->M_transaksi->get_kasir($id_user);

        echo json_encode($hasil);
    }
    
    public function ambil_detail()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => false
        ]);

        header('Content-Type: application/json');

        $id_transaksi = $this->input->get('id_transaksi');

        $hasil = $this->M_transaksi->get_ambil_detail($id_transaksi);

        echo json_encode($hasil);
    }

    public function tes()
    {
        $c = date("Y-m-d", now('Asia/Jakarta'));
        // $c = date("2020-09-23", now('Asia/Jakarta'));
		
        $a = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        // $a = date("2020-09-23 00:01:00", now('Asia/Jakarta'));
        $b = date("$c 20:00:00");
        $f = date("$c 08:00:00");

        if ($a > $b) {
            $d = "shift malam1";

            $tgl_m  = date('Y-m-d', strtotime("$c +1 days"));

            $tgl_awal_malam   = "$c 20:00:00";
            $tgl_akhir_malam  = "$tgl_m 08:00:00";

            $e = "shift pagi";

            // $tgl_p  = date('Y-m-d', strtotime("$c -1 days"));

            $tgl_awal_pagi   = "$c 08:00:00";
            $tgl_akhir_pagi  = "$c 20:00:00";
        } else {
            if ($a > $f) {
                $e = "shift pagi";
                $tgl_awal_pagi   = "$c 08:00:00";
                $tgl_akhir_pagi  = "$c 20:00:00";

                $tgl_m  = date('Y-m-d', strtotime("$c +1 days"));

                $d = "shift malam";

                $tgl_awal_malam   = "$c 20:00:00";
                $tgl_akhir_malam  = "$tgl_m 08:00:00";
            } else {
                $d = "shift malam2";
                $tgl_m  = date('Y-m-d', strtotime("$c -1 days"));

                $tgl_awal_malam   = "$tgl_m 20:00:00";
                $tgl_akhir_malam  = "$c 08:00:00";

                $e = "shift pagi";

                $tgl_p  = date('Y-m-d', strtotime("$c -1 days"));

                $tgl_awal_pagi   = "$tgl_p 08:00:00";
                $tgl_akhir_pagi  = "$tgl_p 20:00:00";
            }
        }

        // $c = date("Y-m-d 08:00:00", now('Asia/Jakarta'));
        // $d = date("Y-m-d 20:00:00", now('Asia/Jakarta'));

        // $tgl_awal   = date('Y-m-d H:i:s', strtotime("$c +12 hours"));
        // $tgl_akhir  = date('Y-m-d H:i:s', strtotime("$d +12 hours"));

        echo $d."<br>";
        echo $tgl_awal_malam."<br>";
        echo $tgl_akhir_malam."<br>";
        echo $e."<br>";
        echo $tgl_awal_pagi."<br>";
        echo $tgl_akhir_pagi."<br>";
    }

}

/* End of file C_transaksi.php */
