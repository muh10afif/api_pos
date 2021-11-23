<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Produk extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_produk');
        $this->load->database();
    }
    
    function getProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);
        
        header('Content-Type: application/json'); 
        
        $id_umkm = $this->input->get('id_umkm');
        
        $count = $this->M_produk->list_produk($id_umkm);
        echo json_encode($count);
    }

    function getMasterProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);
        
        header('Content-Type: application/json'); 
        
        $id_umkm = $this->input->get('id_umkm');
        
        $count = $this->M_produk->list_produk_master($id_umkm);
        echo json_encode($count);
    }

    function getTambahProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);
        
        header('Content-Type: application/json'); 
        
        $id_umkm = $this->input->get('id_umkm');
        $kode_transaksi = $this->input->get('kode_transaksi');
        $count = $this->M_produk->list_tambah_produk($kode_transaksi,$id_umkm);
        echo json_encode($count);
        // print_r($count);
    }

    function TambahProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        $data = json_decode(file_get_contents('php://input'), true);
        if($data['gambar']=="null")
        {
            $hasil = $this->M_produk->tambah_produk2($data);
            echo $hasil ;
        }
        else{
            // $percent = 0.4;
            // $img = base64_decode($data['gambar']);
            // $im = imagecreatefromstring($img);
            // $width = imagesx($im);
            // $height = imagesy($im);
            // $newwidth = $width * $percent;
            // $newheight = $height * $percent;
        
            // $thumb = imagecreatetruecolor($newwidth, $newheight);
        
            // // Resize
            // imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
            // // Output
            // $string_base = base64_encode(imagejpeg($thumb));
            define('UPLOAD_DIR', 'images/');
            // echo base_url('images/'); exit();
            // $name_file = $data['nama_produk'] . '-(' . date('Y-m-d') . ')-' . 'Produk-' . uniqid() . '.png';

            $dp = str_replace(" ","", $data['nama_produk']);

            // nama umkm
            $nm = $this->db->get_where('umkm', array('id_umkm' => $data['id_umkm']))->row_array();

            $nama = str_replace(" ","", $nm['nama_umkm']);

            $name_file = $dp.$data['id_umkm'].$nama.uniqid().'.png';
            
            $image_base64 = base64_decode($data['gambar']);

            $file = UPLOAD_DIR . $name_file;
            file_put_contents($file, $image_base64);
            
            $data['Foto_dokumen_url'] = $name_file;
            
            $hasil = $this->M_produk->tambah_produk($data);
            
            echo $hasil;
        }
    }

    function EditProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        $data = json_decode(file_get_contents('php://input'), true);
        if($data['gambar']=="null")
        {
            $hasil = $this->M_produk->edit_produk2($data);
            echo $hasil ;
        }
        else{
            // $percent = 0.4;
            // $img = base64_decode($data['gambar']);
            // $im = imagecreatefromstring($img);
            // $width = imagesx($im);
            // $height = imagesy($im);
            // $newwidth = $width * $percent;
            // $newheight = $height * $percent;
        
            // $thumb = imagecreatetruecolor($newwidth, $newheight);
        
            // // Resize
            // imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
            // // Output
            // $string_base = base64_encode(imagejpeg($thumb));
            define('UPLOAD_DIR', 'images/');
            // echo base_url('images/'); exit();
            // $name_file = $data['nama_produk'] . '-(' . date('Y-m-d') . ')-' . 'Produk-' . uniqid() . '.png';

            $dp = str_replace(" ","", $data['nama_produk']);

            // nama umkm
            $nm = $this->db->get_where('umkm', array('id_umkm' => $data['id_umkm']))->row_array();

            $nama = str_replace(" ","", $nm['nama_umkm']);

            $name_file = $dp.$data['id_umkm'].$nama.uniqid().'.png';
            
            $image_base64 = base64_decode($data['gambar']);
    
            $file = UPLOAD_DIR . $name_file;
            file_put_contents($file, $image_base64);
            
            $data['Foto_dokumen_url'] = $name_file;
            
            $hasil = $this->M_produk->edit_produk($data);
            
            echo $hasil ;
        }
    }

    function HapusProduk()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        $data = json_decode(file_get_contents('php://input'), true);
        $hasil = $this->M_produk->hapus_produk($data);
        echo $hasil ;
    }
}