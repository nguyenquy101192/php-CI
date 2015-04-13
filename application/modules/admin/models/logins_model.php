<?php
class Logins_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function login($username, $password) {
		$query = $this->db->query ( "SELECT user_id, user_name,user_password
				FROM tbl_users
				WHERE user_name='$username' AND
				user_password='$password' AND
				user_level = 1" );
		
		if ($query->num_rows () == 1) {
			$return = array_shift ( $query->result_array () );
			return $return;
		} else {
			return false;
		}
	}
}
?>