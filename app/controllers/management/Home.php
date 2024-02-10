<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->has_userdata("profile_user")) {
			redirect(base_url("management/login"));
		}
	}

	public function index()
	{
		$this->load->model("Links_Model");

		$this->load->model("Users_Model");

		$data["title"] = "Dashboard";

		$data["breadcrumbs"] = ['<li class="breadcrumb-item active"><span>' . $data["title"] . '</span></li>',];

		$data["links"] = $this->Links_Model->getResult();

		$data["users"] = $this->Users_Model->getUserResult();

		$data["links_views"] = 0;
		foreach ($data["links"] as $item) {
			$data["links_views"] = $data["links_views"] + $item->req_count;
		}

		$this->load->view('management/header', $data);
		$this->load->view('management/home', $data);
		$this->load->view('management/footer', $data);

	}

}
