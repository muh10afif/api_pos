<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

require APPPATH . '/libraries/API_Controller.php';

class C_absen extends API_Controller {

    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('M_absen');
        $this->load->database();

        $this->upload_gbr = define('UPLOAD_DIR', 'images/absensi/');
    }

    // 11-07-2020

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

        $hasil = $this->M_absen->get_tgl_list_hari($id_user, $tgl_awal, $tgl_akhir);

        echo json_encode($hasil);
    }

    public function ambil_detail()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['GET'],
            'requireAuthorization'  => false
        ]);

        header('Content-Type: application/json');

        $id_user   = $this->input->get('id_user');
        $tanggal   = $this->input->get('tanggal');

        $hasil = $this->M_absen->get_detail($id_user, $tanggal);

        echo json_encode($hasil);
    }

    // 11-09-2020

    public function simpan_gambar()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['POST'],
            'requireAuthorization'  => false,
        ]);

        // $data = json_decode(file_get_contents('php://input'), true);

        $data = ['id_karyawan' => $this->input->post('id_karyawan'),
                 'gambar'      => $this->input->post('gambar')
        ];

        $this->upload_gbr; 

        $karyawan 		= $this->M_absen->cari_data('mst_karyawan',['id' => $data['id_karyawan']])->row_array();

        $filename 		= str_replace(' ', '', $karyawan['nama_karyawan']).date('Ymdhis').'.png';

        $name_file      = $filename;
        
        $image_base64   = base64_decode($data['gambar']);

        $file = UPLOAD_DIR . $name_file;
        file_put_contents($file, $image_base64);

        $data_absen = ['id_karyawan' => $data['id_karyawan'],
                       'foto'        => $name_file,
                       'created_at'  => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                      ];
        
        $hasil = $this->M_absen->tambah_absen($data_absen);
        
        echo $hasil;
    }

    // 15-09-2020

    public function simpan_absen()
    {
        $user_data = $this->_apiConfig([
            'methods'               => ['POST'],
            'requireAuthorization'  => false,
        ]);

        // $data = json_decode(file_get_contents('php://input'), true);

        $data = ['id_karyawan' => $this->input->post('id_karyawan'),
                 'status'      => $this->input->post('status'),
                 'lat'         => $this->input->post('lat'),
                 'long'        => $this->input->post('long')
        ];

        $this->upload_gbr;

        // kode acak
        $kode = bin2hex(random_bytes(16));

        $filename 		= $data['id_karyawan'].$kode.'.png';

        move_uploaded_file($_FILES['filegambar']['tmp_name'], UPLOAD_DIR . $filename);

        // cari id_karyawan
        $id_kar = $this->M_absen->cari_data('mst_karyawan', ['id_user' => $data['id_karyawan']])->row_array();

        $data_absen = ['id_karyawan' => $id_kar['id'],
                       'foto'        => $filename,
                       'status'      => $data['status'],
                       'lat'         => $data['lat'],
                       'long'        => $data['long'],
                       'created_at'  => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                      ];
        
        $hasil = $this->M_absen->tambah_absen($data_absen);

        if ($hasil['pesan'] == "Gagal Tambah Absen") {
            $a = 400;
        } else {
            $a = 200;
        }

        $this->api_return($hasil,$a);
        
        // echo $hasil;
    }

    public function tes()
    {
        $a = base64_decode('');

        echo $a;
    }

}

/* End of file C_absen.php */
