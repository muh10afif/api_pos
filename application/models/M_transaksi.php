<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model {

    public function get_list_hari_ini_baru($id_user)
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

        // shift pagi
        $this->db->select('total_harga');
        $this->db->from('trn_transaksi');
        $this->db->where('id_user', $id_user);
        $this->db->where("created_at BETWEEN '$tgl_awal_pagi' AND '$tgl_akhir_pagi'");
        $this->db->order_by('id', 'desc');

        $hasil_pagi = $this->db->get();

        // shift malam
        $this->db->select('total_harga');
        $this->db->from('trn_transaksi');
        $this->db->where('id_user', $id_user);
        $this->db->where("created_at BETWEEN '$tgl_awal_malam' AND '$tgl_akhir_malam'");
        $this->db->order_by('id', 'desc');

        $hasil_malam = $this->db->get();

        // shift pagi
        $this->db->select("p.id, d.subtotal, (SELECT count(t.id) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal_pagi' AND '$tgl_akhir_pagi') as total_id_pro, p.hpp, (SELECT sum(t.jumlah) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal_pagi' AND '$tgl_akhir_pagi') * p.hpp as total_hpp, (SELECT sum(e.subtotal) as tot_subtotal FROM trn_detail_transaksi as e WHERE e.id_product = p.id and e.created_at BETWEEN '$tgl_awal_pagi' AND '$tgl_akhir_pagi') as tot_subtotal");
        $this->db->from('trn_detail_transaksi as d');
        $this->db->join('mst_product as p', 'p.id = d.id_product', 'inner');
        $this->db->where("d.created_at BETWEEN '$tgl_awal_pagi' AND '$tgl_akhir_pagi'");
        $this->db->where('p.id_user', $id_user);
        $this->db->group_by('p.id');

        $hasil_2_pagi = $this->db->get()->result_array();
        
        // shift malam
        $this->db->select("p.id, d.subtotal, (SELECT count(t.id) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal_malam' AND '$tgl_akhir_malam') as total_id_pro, p.hpp, (SELECT sum(t.jumlah) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal_malam' AND '$tgl_akhir_malam') * p.hpp as total_hpp, (SELECT sum(e.subtotal) as tot_subtotal FROM trn_detail_transaksi as e WHERE e.id_product = p.id and e.created_at BETWEEN '$tgl_awal_malam' AND '$tgl_akhir_malam') as tot_subtotal");
        $this->db->from('trn_detail_transaksi as d');
        $this->db->join('mst_product as p', 'p.id = d.id_product', 'inner');
        $this->db->where("d.created_at BETWEEN '$tgl_awal_malam' AND '$tgl_akhir_malam'");
        $this->db->where('p.id_user', $id_user);
        $this->db->group_by('p.id');

        $hasil_2_malam = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('mst_stok as s');
    
        $hasil_4 = $this->db->get()->result_array();

        $tot_harga_p = 0;
        $tot_harga_m = 0;

        foreach ($hasil_pagi->result_array() as $h) {
            $tot_harga_p += $h['total_harga'];
        }
        foreach ($hasil_malam->result_array() as $h) {
            $tot_harga_m += $h['total_harga'];
        }
        
        $data2[] = ['shift_pagi'    => ['total' => $tot_harga_p, 'jumlah' => $hasil_pagi->num_rows()],
                    'shift_malam'   => ['total' => $tot_harga_m, 'jumlah' => $hasil_malam->num_rows()],
                   ];
        
        $tot_hpp_p = 0;
        foreach ($hasil_2_pagi as $j) {
            $tot_hpp_p += $j['total_hpp'];
        }
        $tot_hpp_m = 0;
        foreach ($hasil_2_malam as $j) {
            $tot_hpp_m += $j['total_hpp'];
        }

        $data3[] = ['tot_hpp_pagi'  => $tot_harga_p - $tot_hpp_p, 
                    'tot_hpp_malam' => $tot_harga_m - $tot_hpp_m
                   ];

        foreach ($hasil_4 as $e) {
            
            $stok_j = $e['stok'] - 5;

            // cari nama_product
            $gt = $this->db->get_where('mst_product', ['id' => $e['id_product'], 'id_user' => $id_user])->row_array();
            
            if (($e['minimal_stok'] == $stok_j) || ($e['stok'] == $e['minimal_stok']) || ($e['stok'] < $e['minimal_stok'])) {
                $data4[] = ['nama_product' => $gt['nama_product'],
                            'stok'         => $e['stok'],
                            'satuan'       => $gt['satuan']
                            ];
            }
        }

        $a = ['transaksi' => (empty($data2)) ? [] : $data2,
              'profit'    => (empty($data3)) ? [] : $data3,
              'stok'      => (empty($gt)) ? [] : $data4
            ];

        return $a;
    }

    public function get_list_hari_ini($id_user)
    {
        $c = date("Y-m-d", now('Asia/Jakarta'));
        
        $a = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        $b = date("$c 20:00:00");
        $f = date("$c 08:00:00");

        if ($a > $b) {
            $d = "Malam";

            $tgl_m  = date('Y-m-d', strtotime("$c +1 days"));

            $tgl_awal   = "$c 20:00:00";
            $tgl_akhir  = "$tgl_m 08:00:00";
        } else {
            if ($a > $f) {
                $d = "Pagi";
                $tgl_awal   = "$c 08:00:00";
                $tgl_akhir  = "$c 20:00:00";
            } else {
                $d = "Malam";
                $tgl_m  = date('Y-m-d', strtotime("$c -1 days"));

                $tgl_awal   = "$tgl_m 20:00:00";
                $tgl_akhir  = "$c 08:00:00";
            }
        }
        
        $this->db->from('trn_transaksi');
        $this->db->where('id_user', $id_user);

        $this->db->where("created_at BETWEEN '$tgl_awal' AND '$tgl_akhir'");

        // $this->db->where("DATE_FORMAT(created_at, '%Y-%m-%d') =", date('Y-m-d', now('Asia/Jakarta')));
        $this->db->where('kode_transaksi !=', '');
        $this->db->order_by('id', 'desc');

        $hasil = $this->db->get()->result_array();

        // SELECT p.id, (SELECT count(t.id) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at = "2020-07-16") as total_id_pro, p.hpp, (SELECT count(t.id) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at = "2020-07-16") * p.hpp as total_hpp
        // FROM trn_detail_transaksi as d
        // INNER JOIN mst_product as p ON p.id = d.id_product
        // WHERE d.created_at = "2020-07-16"
        // GROUP BY p.id

        $date = date("Y-m-d", now('Asia/Jakarta'));

        $this->db->select("p.id, d.subtotal, (SELECT count(t.id) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal' AND '$tgl_akhir') as total_id_pro, p.hpp, (SELECT sum(t.jumlah) as con FROM trn_detail_transaksi as t WHERE t.id_product = p.id and t.created_at BETWEEN '$tgl_awal' AND '$tgl_akhir') * p.hpp as total_hpp, (SELECT sum(e.subtotal) as tot_subtotal FROM trn_detail_transaksi as e WHERE e.id_product = p.id and e.created_at BETWEEN '$tgl_awal' AND '$tgl_akhir') as tot_subtotal");
        $this->db->from('trn_detail_transaksi as d');
        $this->db->join('mst_product as p', 'p.id = d.id_product', 'inner');
        $this->db->where("d.created_at BETWEEN '$tgl_awal' AND '$tgl_akhir'");
        $this->db->where('p.id_user', $id_user);
        $this->db->group_by('p.id');

        $hasil_2 = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('mst_stok as s');
        
        $hasil_4 = $this->db->get()->result_array();
        
        if (empty($hasil)) {

            foreach ($hasil_4 as $e) {
                
                $stok_j = $e['stok'] - 5;

                // cari nama_product
                $gt = $this->db->get_where('mst_product', ['id' => $e['id_product'], 'id_user' => $id_user])->row_array();
                
                if (($e['minimal_stok'] == $stok_j) || ($e['stok'] == $e['minimal_stok']) || ($e['stok'] < $e['minimal_stok'])) {
                    $data4[] = ['nama_product' => $gt['nama_product'],
                                'stok'         => $e['stok'],
                                'satuan'       => $gt['satuan']
                                ];
                }
            }
            
            $a = ['transaksi' => [],
                    'profit'    => [],
                    'stok'      => (empty($gt)) ? [] : $data4
                    ];

        } else {
        
            foreach ($hasil as $h) {
                $data2[] = ['total_harga' => $h['total_harga']];
            }
            
            foreach ($hasil_2 as $j) {
                $tt = $j['tot_subtotal'] - $j['total_hpp'];
                $data3[] = ['id_product' => $j['id'], 'total_hpp' => $j['total_hpp']];
            }

            foreach ($hasil_4 as $e) {
                
                $stok_j = $e['stok'] - 5;

                // cari nama_product
                $gt = $this->db->get_where('mst_product', ['id' => $e['id_product'], 'id_user' => $id_user])->row_array();
                
                if (($e['minimal_stok'] == $stok_j) || ($e['stok'] == $e['minimal_stok']) || ($e['stok'] < $e['minimal_stok'])) {
                    $data4[] = ['nama_product' => $gt['nama_product'],
                                'stok'         => $e['stok'],
                                'satuan'       => $gt['satuan']
                                ];
                }
            }

            $a = ['transaksi' => $data2,
                    'profit'    => $data3,
                    'stok'      => (empty($gt)) ? [] : $data4
                ];
        }

        return $a;
    }

    public function get_tgl_list_hari($id_user, $tgl_awal, $tgl_akhir, $kasir)
    {
        $this->db->from('trn_transaksi');
        $this->db->where('kode_transaksi !=', '');
        $this->db->where('id_user', $id_user);
        $this->db->where("CAST(DATE_FORMAT(created_at, '%Y-%m-%d') AS DATE) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
        if ($kasir != '') {
            $this->db->where('created_by', $kasir);
        }
        
        $hasil = $this->db->get()->result_array();
        
        if (empty($hasil)) {
            $a = ['transaksi' => []];
        } else {
            foreach ($hasil as $h) {
                // cari data karyawan
                $this->db->select('nama_karyawan');
                $this->db->from('mst_karyawan');
                $this->db->where('id_user', $h['created_by']);
                
                $dk = $this->db->get()->row_array();

                if ($dk['nama_karyawan'] == null) {
                    
                    $this->db->select('username');
                    $this->db->from('mst_user');
                    $this->db->where('id', $id_user);
                    
                    $ur = $this->db->get()->row_array();
                    
                    $nama_k = $ur['username'];
                } else {

                    $nama_k = $dk['nama_karyawan'];
                }
                
                $h['created_by'] = $nama_k;

                $data2[] = $h;
            }

            $a = ['transaksi' => $data2];
        }

        return $a;
    }

    // 22-09-2020
    public function get_kasir($id_user)
    {
        $this->db->select('created_by');
        $this->db->from('trn_transaksi');
        $this->db->where('id_user', $id_user);
        $this->db->group_by('created_by');
        
        $a = $this->db->get()->result_array();

        foreach ($a as $h) {
            // cari data karyawan
            $this->db->select('nama_karyawan');
            $this->db->from('mst_karyawan');
            $this->db->where('id_user', $h['created_by']);
            
            $dk = $this->db->get()->row_array();

            if ($dk['nama_karyawan'] == null) {
                
                $this->db->select('username');
                $this->db->from('mst_user');
                $this->db->where('id', $id_user);
                
                $ur = $this->db->get()->row_array();
                
                $nama_k = $ur['username'];
            } else {

                $nama_k = $dk['nama_karyawan'];
            }

            $data[] = ['id'     => $h['created_by'],
                       'kasir'  => $nama_k
                      ];
        }

        return $data;
        
    }

    public function get_ambil_detail($id_transaksi)
    {
        // $this->db->select("p.nama_product,p.harga, (SELECT COUNT(t.id_product) FROM trn_detail_transaksi as t WHERE t.id_transaksi = $id_transaksi) as jml_product, (SELECT SUM(e.subtotal) FROM trn_detail_transaksi as e WHERE e.id_transaksi = $id_transaksi) as tot_subtotal, (SELECT SUM(e.total_discount) FROM trn_detail_transaksi as e WHERE e.id_transaksi = $id_transaksi) as tot_discount");
        $this->db->select("p.nama_product,p.harga, d.subtotal, d.jumlah, d.total_discount, COALESCE((SELECT t.potongan_harga FROM trn_transaksi as t WHERE t.id = d.id_transaksi),0) as potongan_harga");
        $this->db->from('trn_detail_transaksi as d');
        $this->db->join('mst_product as p', 'p.id = d.id_product', 'inner');
        $this->db->where('d.id_transaksi', $id_transaksi);
        $this->db->order_by('d.id', 'desc');
        
        $hasil = $this->db->get()->result_array();

        // "nama_product": "01. Yamien Manis Bakso",
        // "harga": "28000",
        // "subtotal": "25000",
        // "jumlah": "1",
        // "total_discount": "0",
        // "potongan_harga": "3000"
        
        if (empty($hasil)) {
            $a = ['transaksi' => []];
        } else {
            foreach ($hasil as $h) {

                $pot = $h['harga'] - $h['potongan_harga'];

                $data2[] = ['nama_product'  => $h['nama_product'],
                            'harga'         => "$pot",
                            'subtotal'      => $h['subtotal'],
                            'jumlah'        => $h['jumlah'],
                            'total_discount'=> $h['total_discount']
                           ];
            }

            $a = ['transaksi' => $data2];
        }

        return $a;
    }

}

/* End of file M_transaksi.php */
