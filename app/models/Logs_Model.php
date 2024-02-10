<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

class Logs_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// Log Kaydı Ekleme
	public function addLog($contentType, $contentProcess, $contentId = 0)
	{
		$nArr = [
			'content_type' => $contentType,
			'content_process' => $contentProcess,
			'content_id' => $contentId,
			'user_id' => $this->session->userdata('profile_user')["id"],
			'user_group_id' => $this->session->userdata('profile_user')["user_group"],
			'created_date' => now(),
			'created_ip' => $this->input->ip_address()
		];

		$this->db->insert("agc_logs", $nArr);
	}

}
