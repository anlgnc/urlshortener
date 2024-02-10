<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

class Users_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Logs_Model");
	}

	// User Login
	public function login($userName, $userPassword)
	{
		$userQuery = $this->db->select('*')
			->from('agc_users')
			->where('user_name', $userName)
			->where('user_password', $userPassword)
			->where('user_status', 1)
			->get()
			->row();

		if ($userQuery) {

			$this->db->where("id", $userQuery->id);

			$this->db->update('agc_users', ['user_login_date' => now(), 'user_login_ip' => $this->input->ip_address()]);

			return $userQuery;

		} else {
			return false;
		}
	}

	// Kullanıcı Ekleme
	public function addUser($username, $userpassword, $usergroup, $userstatus)
	{
		$data = [
			"user_name" => $username,
			"user_password" => md5(sha1($userpassword)),
			"user_status" => $userstatus,
			"user_group" => $usergroup,
			"user_created_date" => now()
		];

		if ($this->db->insert("agc_users", $data)) {
			$this->Logs_Model->addLog("Kullanıcı", "Ekleme", $this->db->insert_id());
			return true;
		} else {
			return false;
		}
	}

	// Kullanıcı Düzenleme
	public function updateUser($id, $username, $userpassword, $usergroup, $userstatus)
	{
		$data = [
			"user_name" => $username,
			"user_password" => $userpassword,
			"user_status" => $userstatus,
			"user_group" => $usergroup
		];

		$this->db->where("id", $id);
		$this->db->update("agc_users", $data);

		if ($this->db->affected_rows() > 0) {
			$this->Logs_Model->addLog("Kullanıcı", "Güncelleme", $id);
			return true;
		} else {
			return false;
		}
	}

	// Kullanıcı Silme
	public function deleteUser($id)
	{
		$this->db->where("id", $id);

		$this->db->delete("agc_users");

		if ($this->db->affected_rows() > 0) {
			$this->Logs_Model->addLog("Kullanıcı", "Silme", $id);
			return true;
		} else {
			return false;
		}
	}

	public function userName($id)
	{
		$query = $this->db->select("user_name")->from("agc_users")->where("id", $id)->get()->row();

		if ($query) {
			return $query->user_name;
		}
	}

	// Kullanıcı Row
	public function getUserRow($id, $key)
	{

		$query = $this->db->select("*")
			->from("agc_users")
			->where("id", $id)
			->get()
			->row();

		if ($query) {
			return $query->$key;
		} else {
			return false;
		}
	}

	// Kullanıcı Result
	public function getUserResult($type = 1)
	{

		if ($type == 1) {
			$query = $this->db->select("*")
				->from("agc_users")
				->get()
				->result();
		} else {
			$query = $this->db->select("*")
				->from("agc_users")
				->where("user_status", 1)
				->get()
				->result();
		}

		return $query;
	}

	// Datatables
	public function getUsers($where, $orderBy, $limit)
	{
		$queryLimit = "";

		if (count($limit)) {
			$queryLimit = "LIMIT " . $limit["start"] . " , " . $limit["length"];
		}

		$query = $this->db->query("SELECT * FROM agc_users WHERE $where $orderBy $queryLimit");

		return $query->result();
	}

	// Kullanıcı Grubu Ekleme
	public function addGroup($name, $status)
	{
		$data = [
			"group_name" => $name,
			"status" => $status,
			"created_date" => now()
		];

		if ($this->db->insert("agc_groups", $data)) {
			$this->Logs_Model->addLog("Kullanıcı Grubu", "Ekleme", $this->db->insert_id());
			return true;
		} else {
			return false;
		}
	}

	// Kullanıcı Grubu Düzenleme
	public function updateGroup($id, $name, $status)
	{
		$data = [
			"group_name" => $name,
			"status" => $status
		];

		$this->db->where("id", $id);

		$this->db->update("agc_groups", $data);

		if ($this->db->affected_rows() > 0) {
			$this->Logs_Model->addLog("Kullanıcı Grubu", "Güncelleme", $id);
			return true;
		} else {
			return false;
		}
	}

	// Kullanıcı Grubu Silme
	public function deleteGroup($id)
	{
		$this->db->where("id", $id);

		$this->db->delete("agc_groups");

		if ($this->db->affected_rows() > 0) {
			$this->Logs_Model->addLog("Kullanıcı Grubu", "Silme", $id);
			return true;
		} else {
			return false;
		}
	}

	// Kullanıcı Grubu Row
	public function getGroupRow($id, $key)
	{

		$query = $this->db->select("*")
			->from("agc_groups")
			->where("id", $id)
			->get()
			->row();

		if ($query) {
			return $query->$key;
		} else {
			return false;
		}
	}

	// Kullanıcı Grubu Result
	public function getGroupResult($type = 1)
	{
		if ($type == 1) {
			$query = $this->db->select("*")
				->from("agc_groups")
				->get()
				->result();
		} else {
			$query = $this->db->select("*")
				->from("agc_groups")
				->where("status", 1)
				->get()
				->result();
		}

		return $query;
	}

	// Datatables
	public function getGroups($where, $orderBy, $limit)
	{
		$queryLimit = "";

		if (count($limit)) {
			$queryLimit = "LIMIT " . $limit["start"] . " , " . $limit["length"];
		}

		$query = $this->db->query("SELECT * FROM agc_groups WHERE $where $orderBy $queryLimit");

		return $query->result();
	}

	// Profil Row
	public function getProfileRow($key)
	{

		$id = $this->session->userdata('profile_user')["id"];

		$query = $this->db->select("*")
			->from("agc_users")
			->where("id", $id)
			->get()
			->row();

		if ($query) {
			return $query->$key;
		} else {
			return false;
		}
	}

	// Profil Parola Değiştirme
	public function passwordUpdateProfile($oldPassword, $newPassword)
	{
		$id = $this->session->userdata('profile_user')["id"];

		$oldPasswordGetDb = $this->getProfileRow("user_password");

		$oldPasswordGet = md5(sha1($oldPassword));

		$newPasswordGet = md5(sha1($newPassword));

		if ($oldPasswordGet != $oldPasswordGetDb) {
			return false;
		}

		$this->db->where("id", $id);

		$this->db->update("agc_users", ["user_password" => $newPasswordGet]);

		if ($this->db->affected_rows() > 0) {

			$this->Logs_Model->addLog("Profil", "Parola Güncelleme", $id);

			return true;

		} else {
			return false;
		}
	}


}
