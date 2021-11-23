<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_User extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function GetUser($id_umkm)
    {
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->join('umkm m', 'm.id_umkm = u.id_umkm', 'inner');
        $this->db->where('u.id_umkm', $id_umkm);

		$value = $this->db->get()->result_array();
	 	$result = array();
		
		foreach($value as $row)
		{
            $result[] = array
            (
                'id_umkm'       => $row['id_umkm'],
                'id_user_umkm'  => $row['id_user'],
                'nama_umkm'     => $row['nama_umkm'],
                'nama_pemilik'  => $row['nama_pemilik'],
                'username'      => $row['username'],
                'password'      => $row['password'],
                'foto'          => $row['foto'],
                'alamat'        => $row['alamat'],
                'telepon'       => $row['telepon'],
                'toko'          => $this->tes_nama_umkm($row['nama_umkm']),
                'nama_toko'     => $row['nama_umkm'],
                'alamat_toko'   => $this->ambil_ket($row['alamat']),
                'telp_toko'     => $this->ambil_ket($row['telepon']),
                'modal'         => ($row['modal'] == null) ? 0 : $row['modal']
            );
		}	
	
		return $result;
    }

    public function ambil_text($t)
    {
        $text = $t." ";

        // panjang text awal
        $lng = strlen($text);

        // panjang text android
        $num_char = 16;
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }
        // ambil text sampai posisi ke 16
        $str_1 = substr($text, 0, $num_char);

        return $str_1;
    }

    public function tes_nama_umkm($tx)
    {
        $t = $tx." ";

        $text = $t;

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

        $a = str_repeat(" ", $fl);
        $b = str_repeat(" ", floor($bg) + $md);

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

                $a = str_repeat(" ", $fl - 1);
                $b = str_repeat(" ", floor($bg) + $md);

                // gabung dengan spasi
                $st = $st.$a.$str_2.$b;
    
            } else {
    
                $a2 = trim($this->ambil_text($str_2));
    
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

               $a = str_repeat(" ", $fl - 1);
               $b = str_repeat(" ", floor($bg) + $md);

               // gabung dengan spasi
               $st = $st.$a.$a2.$b;
    
            }
        
        } else {

            $st = $a.$str_1.$b;
        }

        return $st;
    }

    public function ambil_text_ket($t)
    {
        $text = $t." ";

        // panjang text awal
        $lng = strlen($text);

        // panjang text android
        $num_char = 24;
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }
        // ambil text sampai posisi ke 16
        $str_1 = substr($text, 0, $num_char);

        return $str_1;
    }

    public function ambil_ket($tx)
    {
        $t = $tx." ";

        $text = $t;

        // panjang text awal
        $lng = strlen($text);

        if ($lng > 32) {
            // panjang text android
            $num_char = 32;
        } else {
            $num_char = $lng;
        }
        
        // $text = 'Test UMKM Cingcin Permata Indah Cingcin Permata Indah';

        // memotong yang kata yang terpotong
        $char     = $text{$num_char - 1};
        while($char != ' ') {
            $char = $text{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
        }

        if ($lng > 32) {
             // ambil text sampai posisi ke 16
            $str_1 = trim(substr($text, 0, $num_char));
        } else {
             // ambil text sampai posisi ke 16
            $str_1 = trim(substr($text, 0, $lng));
        }

        // panjang text setalah dipotong 
        $str_2p = strlen($str_1);
    
        // hitung sisa karakter
        $ss = 32 - $str_2p;

        // dibagi 2 
        $bg = $ss / 2;

        // modulus
        $md = $ss % 2;

        if ($md > 0) {
            $fl = floor($bg);
        } else {
            $fl = $bg;
        }

        $a = str_repeat(" ", $fl);
        $b = str_repeat(" ", floor($bg) + $md);

        // gabung dengan spasi
        $st = $a.$str_1.$b;

        if ($lng > 32) {

            // ambil string untuk baris kedua
            $str_2 = trim(substr($text, $str_2p, $lng));

            // panjang text setalah dipotong 
            $str_2p2 = strlen($str_2);

            // hitung sisa karakter
            $ss2 = 32 - $str_2p2;

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

                $a = str_repeat(" ", $fl);
                $b = str_repeat(" ", floor($bg) + $md);

                // gabung dengan spasi
                $st = $st.$a.$str_2.$b;
    
            } else {
    
                $a2 = trim($this->ambil_text_ket($str_2));
    
                // panjang text setalah dipotong 
                $str_2p2 = strlen($a2);
    
                // hitung sisa karakter
                $ss2 = 32 - $str_2p2;
    
               // dibagi 2 
               $bg = $ss2 / 2;

               // modulus
               $md = $ss2 % 2;

               if ($md > 0) {
                   $fl = floor($bg);
               } else {
                   $fl = $bg;
               }

               $a = str_repeat(" ", $fl);
               $b = str_repeat(" ", floor($bg) + $md);

               // gabung dengan spasi
               $st = $st.$a.$a2.$b;
    
            }
        
        } else {

            $st = $a.$str_1.$b;
        }

        return $st;
    }

    private function ambil_string($text)
    {
        $pjg = strlen($text);

        $t = $text;

        $pjg = strlen($t);

        $str = $t;

        $str2 = substr($str,24,$pjg);

        $pjg_str2 = strlen($str2);

        

        if ($pjg > 24) {

            // kiri 4 tengah 24 kanan 4 
            $str_24 = substr($str,0,24);

            $a = str_repeat(" ", 4);
            $b = str_repeat(" ", 4);

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

                $c = str_repeat(" ", $fl-1);
                $d = str_repeat(" ", floor($ht_b));

                $str_kedua = $str_pertama.$c.$str2.$d;
            } else {
                $str21 = substr($str,24,20);

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

                $c = str_repeat(" ", $fl-1);
                $d = str_repeat(" ", floor($ht_b));

                $str_kedua = $str_pertama.$c.$str21.$d;
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

            $a = str_repeat(" ", $fl-1);
            $b = str_repeat(" ", floor($ht_b));

            $str_kedua = $a.$str_24.$b;

        }

        return $str_kedua;
    }

    private function ambil_string2($text)
    {
        $pjg = strlen($text);

        $t = $text;

        $pjg = strlen($t);

        $str = $t;

        $str2 = substr($str,24,$pjg);

        $pjg_str2 = strlen($str2);

        

        if ($pjg > 24) {

            // kiri 4 tengah 24 kanan 4 
            $str_24 = substr($str,0,24);

            $a = str_repeat(" ", 4);
            $b = str_repeat(" ", 4);

            $str_pertama = $a.$str_24.$b;

            $ht = 32 - $pjg_str2;

            if ($ht > 0) {
                
                // pembagian string kanan kiri
                

                // bagi 2 
                $ht_b = $ht / 2;

                // modulus 
                $ht_m = $ht % 2;

                if ($ht_m > 0) {
                    $fl  = floor($ht_b);
                } else {
                    $fl = floor($ht_b)+$ht_m;
                }

                $c = str_repeat(" ", $fl);
                $d = str_repeat(" ", floor($ht_b));

                $str_kedua = $str_pertama.$c.$str2.$d;
            } else {
                $str21 = substr($str,24,20);

                $pjg_str22 = strlen($str21);

                $ht = 32 - $pjg_str22;

                // bagi 2 
                $ht_b = $ht / 2;

                // modulus 
                $ht_m = $ht % 2;

                if ($ht_m > 0) {
                    $fl  = floor($ht_b);
                } else {
                    $fl = floor($ht_b)+$ht_m;
                }

                $c = str_repeat(" ", $fl);
                $d = str_repeat(" ", floor($ht_b));

                $str_kedua = $str_pertama.$c.$str21.$d;
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
                $fl  = floor($ht_b);
            } else {
                $fl = floor($ht_b)+$ht_m;
            }

            $a = str_repeat(" ", $fl);
            $b = str_repeat(" ", floor($ht_b));

            $str_kedua = $a.$str_24.$b;

        }

        return $str_kedua;
    }

    function Login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->join('umkm m', 'm.id_umkm = u.id_umkm', 'inner');
        $this->db->where('u.username', $username);

		$value = $this->db->get()->result_array();
         $result = array();
         
		
		foreach($value as $row)
		{
			if ($row['password'] != null)
			{
				if (password_verify($password, $row['password']))
				{
                    

					$result[] = array
					(
                        'message'=>'user is exsist',
                        'id_umkm'=>$row['id_umkm'],
                        'id_user_umkm'=>$row['id_user'],
                        'nama_umkm'=>$row['nama_umkm'],
                        'nama_pemilik'=>$row['nama_pemilik'],
                        'username'=>$row['username'],
                        'password'=>$row['password'],
                        'foto'=>$row['foto'],
                        'alamat'=>$row['alamat'],
                        'telepon'=>$row['telepon'],
                        'toko'        => $this->tes_nama_umkm($row['nama_umkm']),
                        'nama_toko'   => $row['nama_umkm'],
                        'alamat_toko' => $this->ambil_ket($row['alamat']),
                        'telp_toko'   => $this->ambil_ket($row['telepon'])
					);
				}
			}
		}	
	
		return $result;
    }
    
    function RegistUser($data)
    {
        $nama_umkm = $data['nama_umkm'];
        $nama_pemilik = $data['nama_pemilik'];
        $alamat = $data['alamat'];
        $telepon = $data['telepon'];
        $username = $data['username'];
        $pass = $data['password'];
        $options = ['cost' => 10,];
        $password = password_hash($pass, PASSWORD_DEFAULT, $options);

        $data_umkm = array(
            'nama_umkm'=>$nama_umkm,
            'nama_pemilik'=>$nama_pemilik,
            'alamat'=>$alamat,
            'telepon'=>$telepon
        );
        $this->db->trans_start();
        $this->db->insert('umkm', $data_umkm);
        $id = $this->db->insert_id();
        $data_user = array(
            'id_umkm'=>$id,
            'username'=>$username,
            'password'=>$password
        );
        $this->db->insert('user',$data_user);
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $res = "Gagal Register";
            echo json_encode($res);

        }
        else 
        {
            $res = "Berhasil Register";
            echo json_encode($res);
        }
    }

    function EditProfileUser($data)
    {
        $nama_umkm      = $data['nama_umkm'];
        $nama_pemilik   = $data['nama_pemilik'];
        $alamat         = $data['alamat'];
        $telepon        = $data['telepon'];
        $username       = $data['username'];
        $modal          = $data['modal'];
        $id_umkm        = $data['id_umkm'];

        $data_umkm = array(
            'nama_umkm'     => $nama_umkm,
            'nama_pemilik'  => $nama_pemilik,
            'alamat'        => $alamat,
            'telepon'       => $telepon,
            'modal'         => $modal
        );

        $array = array(
            "username"=>$username
        );

        $this->db->trans_start();
        $this->db->set($data_umkm);
        $this->db->where('id_umkm', $id_umkm);
        $this->db->update('umkm');
        $this->db->set($array);
        $this->db->where('id_umkm', $id_umkm);
        $this->db->update('user');
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $res = "Gagal Edit Profile";
            echo json_encode($res);

        }
        else 
        {
            $res = "Berhasil Edit Profile";
            echo json_encode($data_umkm);
        }
    }
	
	function UpdateFoto($data)
	{
		$ok = "Nope!";
        
        try
        {
            $id_umkm = $data['id_umkm'];
            $gambar = $data['Foto_dokumen_url'];

            $this->db->query("UPDATE umkm SET foto='$gambar' WHERE id_umkm = $id_umkm");
            if ($this->db->affected_rows())
            {
                $ok = "Updated!";
            }   
            else
            {
                $ok = "Nope! Failed to Update!";
            }
        }
        catch (Exception $e) 
        {
            $ok = "Nope! Failed to Update!";
        }

        return $gambar;   
	}

	function ChangePassword($data)
	{
		$ok = "Nope!";
        
        try
        {
			$id_user_umkm = $data['id_user_umkm'];
            $options = ['cost' => 10,];
            $pass = $data['password'];
            $password = password_hash($pass, PASSWORD_DEFAULT, $options);
            $array = array("password"=>$password);
            $this->db->set($array);
            $this->db->where('id_user', $id_user_umkm);
            $this->db->update('user');
            // $this->db->query("UPDATE user SET password='$password' WHERE id_user = $id_user_umkm");
            if ($this->db->affected_rows())
            {
                $ok = "Updated!";
            }   
            else
            {
                $ok = "Nope! Failed to Update!";
            }
        }
        catch (Exception $e) 
        {
            $ok = "Nope! Failed to Update!";
        }

        return $ok;   
	}
}
