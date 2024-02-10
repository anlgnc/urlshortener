<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

class Links_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Logs_Model");
	}

	private $table = "agc_links";
	private $adminGroupID = 1;

	// Bu link daha önce eklenmiş mi sisteme
	public function linkCheck($link)
	{
		$query = $this->db->select("id")
			->from($this->table)
			->where("original_link", $link)
			->get()
			->row();

		if ($query) {
			return true;
		} else {
			return false;
		}

	}

	// Veri Ekleme
	public function linkInsert($url, $status)
	{
		$newLink = $this->linkCreaterCheck(rndAl(5));

		if (!$this->linkCheck($url)) {

			$iData = [
				"status" => $status,
				"short_link" => $newLink,
				"original_link" => $url,
				"req_count" => 0,
				"created_user" => $this->session->userdata('profile_user')["id"],
				"created_group" => $this->session->userdata('profile_user')["user_group"],
				"created_date" => now(),
				"created_ip" => $this->input->ip_address(),
			];

			if ($this->db->insert($this->table, $iData)) {
				$this->Logs_Model->addLog("Link", "Ekleme", $this->db->insert_id());
				return $newLink;
			} else {
				return false;
			}
		}
	}

	// Veri Güncelleme
	public function linkUpdate($id, $url, $status)
	{
		$currentGroup = $this->session->userdata('profile_user')["user_group"];

		if ($currentGroup == $this->adminGroupID) {
			$where_0 = ['id' => $id, "original_link" => $url];
		} else {
			$where_0 = ['id' => $id, "original_link" => $url, 'created_group' => $currentGroup];
		}

		$query = $this->db->select("*")
			->from($this->table)
			->where($where_0)
			->get()
			->row();

		if (!$query) {

			$newLink = $this->linkCreaterCheck(rndAl(5));

			if (!$this->linkCheck($url)) {

				$iData = [
					"status" => $status,
					"short_link" => $newLink,
					"original_link" => $url,
					"req_count" => 0,
					"created_user" => $this->session->userdata('profile_user')["id"],
					"created_group" => $this->session->userdata('profile_user')["user_group"],
					"updated_date" => now(),
					"created_ip" => $this->input->ip_address(),
				];
			}

		} else {

			$newLink = $query->short_link;

			$iData = [
				"status" => $status,
				"req_count" => 0,
				"created_user" => $this->session->userdata('profile_user')["id"],
				"created_group" => $this->session->userdata('profile_user')["user_group"],
				"updated_date" => now(),
				"created_ip" => $this->input->ip_address(),
			];
		}

		if ($currentGroup == $this->adminGroupID) {
			$where_1 = ['id' => $id];
		} else {
			$where_1 = ['id' => $id, 'created_group' => $currentGroup];
		}

		$this->db->where($where_1);

		$this->db->update($this->table, $iData);

		if ($this->db->affected_rows() > 0) {
			$this->Logs_Model->addLog("Link", "Güncelleme", $id);
			return $newLink;
		} else {
			return false;
		}
	}

	// Veri Silme
	public function linkDelete($id)
	{

		$currentGroup = $this->session->userdata('profile_user')["user_group"];

		if ($currentGroup == $this->adminGroupID) {
			$where = ['id' => $id];
		} else {
			$where = ['id' => $id, 'created_group' => $currentGroup];
		}

		$this->db->where($where);

		$this->db->delete($this->table);

		if ($this->db->affected_rows()) {
			$this->Logs_Model->addLog("Link", "Silme", $id);
			return true;
		} else {
			return false;
		}
	}

	// Üretilen Linki Kontrol
	function linkCreaterCheck($url)
	{
		if (isset($url)) {

			$query = $this->db->select("*")
				->from($this->table)
				->where("short_link", $url)
				->get()
				->result();

			if (empty($query)) {
				return $url;
			} else {

				$uriEK = 0;

				$new = $url;

				$nLink .= "-";

				while (true) {
					$nLink = rtrim($nLink, $uriEK);
					$uriEK++;
					if (!$this->linkCreaterCheck($nLink .= $uriEK)) {
						break;
					}
				}
				return $nLink;
			}
		} else {
			return $url;
		}
	}

	// Datatables
	public function getLinks($where, $orderBy, $limit)
	{
		$queryLimit = "";

		if (count($limit)) {
			$queryLimit = "LIMIT " . $limit["start"] . " , " . $limit["length"];
		}

		$query = $this->db->query("SELECT * FROM agc_links WHERE $where $orderBy $queryLimit");

		return $query->result();
	}

	// Front
	public function toLink($link)
	{
		$query = $this->db->select("id,original_link,req_count")
			->from($this->table)
			->where("short_link", $link)
			->where("status", 1)
			->get()
			->row();

		if ($query) {
			$count = $query->req_count + 1;

			$this->db->where("id", $query->id);

			$this->db->update($this->table, ["req_count" => $count]);

			return $query->original_link;
		}
	}

	// Row Info
	public function getRow($id, $key)
	{
		$currentGroup = $this->session->userdata('profile_user')["user_group"];

		if ($currentGroup == $this->adminGroupID) {
			$where = ['id' => $id];
		} else {
			$where = ['id' => $id, 'created_group' => $currentGroup];
		}

		$query = $this->db->select("*")
			->from("agc_links")
			->where($where)
			->get()
			->row();

		if ($query) {
			return $query->$key;
		} else {
			return false;
		}
	}

	// Result
	public function getResult()
	{
		$currentGroup = $this->session->userdata('profile_user')["user_group"];

		if ($currentGroup == $this->adminGroupID) {
			$where = ['status' => 1];
		} else {
			$where = ['status' => 1, 'created_group' => $currentGroup];
		}

		$query = $this->db->select("*")
			->from("agc_links")
			->where($where)
			->get()
			->result();

		return $query;
	}
}
