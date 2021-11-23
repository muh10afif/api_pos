<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_absen extends CI_Model {

    public function get_tgl_list_hari($id_user, $tgl_awal, $tgl_akhir)
    {
        $this->db->select("b.created_at as tanggal");
        
        $this->db->from('trn_absen as b');
        $this->db->join('mst_karyawan as k', 'k.id = b.id_karyawan', 'inner');
        
        if ($tgl_awal != '' && $tgl_akhir != '') {
            $this->db->where("CAST(DATE_FORMAT(b.created_at, '%Y-%m-%d') AS DATE) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
        }
        
        $this->db->where('k.id_owner', $id_user);
        $this->db->order_by('b.id', 'desc');
        $this->db->group_by("CAST(DATE_FORMAT(b.created_at, '%Y-%m-%d') AS DATE)");
        
        $hasil = $this->db->get()->result_array();
        
        if (empty($hasil)) {
            $a = ['absen' => []];
        } else {
            foreach ($hasil as $h) {
                $data2[] = ['tanggal'   => nice_date($h['tanggal'], 'Y-m-d')];
            }

            $a = ['absen' => $data2];
        }

        return $a;
    }

    public function get_detail($id_user, $tgl)
    {
        $this->db->select('b.created_at as tgl_absen, k.nama_karyawan, k.kode_karyawan, b.foto, b.lat, b.long, b.status');
        $this->db->from('trn_absen as b');
        $this->db->join('mst_karyawan as k', 'k.id = b.id_karyawan', 'inner');
        $this->db->where('k.id_owner', $id_user);
        $this->db->where("CAST(DATE_FORMAT(b.created_at, '%Y-%m-%d') AS DATE) = '$tgl'");
        $this->db->order_by('b.id', 'desc');
        
        $hasil = $this->db->get()->result_array();
        
        if (empty($hasil)) {
            $a = ['absen' => []];
        } else {
            foreach ($hasil as $h) {
                $data2[] = $h;
            }

            $a = ['absen' => $data2];
        }

        return $a;
    }

    // 11-09-2020

    public function tambah_absen($data)
    {
        $this->db->trans_start();
        $this->db->insert('trn_absen', $data);
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $result = "Gagal Tambah Absen";
            return ['pesan' => $result];
            // echo json_encode(['pesan' => $result]);
        }
        else 
        {
            $result = "Berhasil Tambah Absen";
            return ['pesan' => $result];
            // echo json_encode(['pesan' => $result]);
        }
        
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
        
    }

}

/* End of file M_absen.php */
