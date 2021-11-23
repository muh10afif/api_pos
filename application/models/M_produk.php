<?php if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
    
    class M_produk extends CI_Model
    {
        public function list_produk($id_umkm)
        {

            $data = array();
            $this->db->select('*');
            $this->db->from('produk');
            $this->db->where('id_umkm', $id_umkm);
            $this->db->where('status', 1);
            $this->db->order_by('add_time', 'desc');
            
            
            $hasil = $this->db->get()->result_array();

            foreach($hasil as $row)
            {
                $data[] = array(
                    'id_produk'=>$row['id_produk'],
                    'nama_produk'=>$row['nama_produk'],
                    'harga'=>$row['harga'],
                    'gambar'=>$row['gambar'],
                    'status'=>$row['status']
                );
                // "Rp.".number_format($row['harga'], 0, ",","."),
            }
            return $data;
        }

        public function list_produk_master($id_umkm)
        {
            $data = array();
            $this->db->select('*');
            $this->db->from('produk');
            $this->db->where('id_umkm', $id_umkm);
            $this->db->order_by('add_time', 'desc');
            
            $hasil = $this->db->get()->result_array();

            foreach($hasil as $row)
            {
                $data[] = array(
                    'id_produk'=>$row['id_produk'],
                    'nama_produk'=>$row['nama_produk'],
                    'harga'=>$row['harga'],
                    'gambar'=>$row['gambar'],
                    'status'=>$row['status']
                );
                // "Rp.".number_format($row['harga'], 0, ",","."),
            }
            return $data;
        }

        public function list_tambah_produk($kode_transaksi,$id_umkm)
        {   
            $this->db->select('*');
            $this->db->from('transaksi');
            $this->db->where('kode_transaksi', $kode_transaksi);
            $this->db->where('status',0);

            $a = $this->db->get()->result();

            $ay = array();
            foreach ($a as $b) {
                $ay[] = $b->id_produk;
            }

            $im        = implode(',',$ay);
            $id_produk = explode(',',$im); 

            if(empty($a))
            {
                $this->db->select('*');
                $this->db->from('produk');
                $this->db->where('id_umkm',$id_umkm);
                $this->db->where('status', 1);
                $this->db->order_by('nama_produk', 'asc');
                
            }
            else{
                $this->db->select('*');
                $this->db->from('produk');
                $this->db->where_not_in('id_produk', $id_produk);
                $this->db->where('id_umkm',$id_umkm);
                $this->db->where('status', 1);
                $this->db->order_by('nama_produk', 'asc');
            }
            return $this->db->get()->result_array();
        }

        public function tambah_produk($data)
        {
            $nama_produk = $data['nama_produk'];
            $harga = $data['harga'];
            $a = str_replace(',','', $harga);
            $b = str_replace('Rp.','', $a);
            $stock = $data['stock'];
            $gambar = $data['Foto_dokumen_url'];
            $id_umkm = $data['id_umkm'];
            $status = $data['status'];

            $data_produk = array(
                'nama_produk'=>$nama_produk,
                'harga'=>$b,
                'gambar'=>$gambar,
                'id_umkm'=>$id_umkm,
                'status'=>$status
            );

            $this->db->trans_start();
            $this->db->insert('produk', $data_produk);
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $res = "Gagal Tambah Produk";
                echo json_encode($res);
            }
            else 
            {
                $res = "Berhasil Tambah Produk";
                echo json_encode($res);
            }
        }

        public function tambah_produk2($data)
        {
            $nama_produk    = $data['nama_produk'];
            $harga          = $data['harga'];
            $a              = str_replace(',','', $harga);
            $b              = str_replace('Rp.','', $a);
            $stock          = $data['stock'];
            $id_umkm        = $data['id_umkm'];
            $status         = $data['status'];
            $gambar         = "NoImage.png";

            $data_produk = array(
                'nama_produk'   =>$nama_produk,
                'harga'         =>$b,
                'gambar'        =>$gambar,
                'id_umkm'       =>$id_umkm,
                'status'        =>$status
            );

            $this->db->trans_start();
            $this->db->insert('produk', $data_produk);
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $res = "Gagal Tambah Produk";
                echo json_encode($res);
            }
            else 
            {
                $res = "Berhasil Tambah Produk";
                echo json_encode($res);
            }
        }

        public function edit_produk($data)
        {
            $id_produk = $data['id_produk'];
            $nama_produk = $data['nama_produk'];
            $harga = $data['harga'];
            $a = str_replace(',','', $harga);
            $b = str_replace('Rp.','', $a);
            $stock = $data['stock'];
            $gambar = $data['Foto_dokumen_url'];
            $id_umkm = $data['id_umkm'];
            $status = $data['status'];

            $data_produk = array(
                'nama_produk'=>$nama_produk,
                'harga'=>$b,
                'gambar'=>$gambar,
                'id_umkm'=>$id_umkm,
                'status'=>$status
            );

            $this->db->trans_start();
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', $data_produk);
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $res = "Gagal Edit Produk";
                echo json_encode($res);
            }
            else 
            {
                $res = "Berhasil Edit Produk";
                echo json_encode($res);
            }
        }

        public function edit_produk2($data)
        {
            $id_produk = $data['id_produk'];
            $nama_produk = $data['nama_produk'];
            $harga = $data['harga'];
            $a = str_replace(',','', $harga);
            $b = str_replace('Rp.','', $a);
            $stock = $data['stock'];
            $id_umkm = $data['id_umkm'];
            $status = $data['status'];

            $data_produk = array(
                'nama_produk'=>$nama_produk,
                'harga'=>$b,
                'id_umkm'=>$id_umkm,
                'status'=>$status
            );

            $this->db->trans_start();
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', $data_produk);
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $res = "Gagal Edit Produk";
                echo json_encode($res);
            }
            else 
            {
                $res = "Berhasil Edit Produk";
                echo json_encode($res);
            }
        }

        public function hapus_produk($data)
        {
            $id_produk = $data['id_produk'];

            $this->db->trans_start();
            $this->db->where('id_produk', $id_produk);
            $this->db->delete('produk');
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $res = "Gagal Hapus Produk";
                echo json_encode($res);
            }
            else 
            {
                $res = "Berhasil Hapus Produk";
                echo json_encode($res);
            }
        }
    }