<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function validate(){
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		$pass_hash = sha1($pass);
		$query = $this->db->select('username')->from('User')->where('username',$user)->where('userhash',$pass_hash)->get();
		if($query->num_rows == 1)
			return true;
		else
			return false;
	}
}