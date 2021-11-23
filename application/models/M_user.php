<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    function Login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('mst_user u');
		$this->db->where('u.username', $username);
		$this->db->where('u.active', '1');

		$value = $this->db->get()->result_array();
		$result = array();
		
		if (!empty($value)) {

			foreach($value as $row)
			{
				if ($row['pass'] != null)
				{
					if (password_verify($password, $row['pass']))
					{
						$result = array
						(
							'pesan'       	=> 'user is exsist',
							'id_role'       => $row['id_role'],
							'id_user'      	=> $row['id'],
							'api_token'     => $row['api_token']
						);
					} else {

						$result = array("pesan" =>  'Password anda salah');

					}
				}
			}
		
		} else {
         
			$result = array("pesan" => 'User tidak ditemukan');
			
		}
	
		return $result;
    }

}

/* End of file M_user.php */
