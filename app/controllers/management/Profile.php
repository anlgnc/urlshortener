<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->has_userdata("profile_user")) {
			redirect(base_url("management/login"));
		}

		$this->load->model("Users_Model");
	}

	private $jsonStatus = array(
		200 => '200 OK',
		400 => '400 Bad Request',
		422 => 'Unprocessable Entity',
		500 => '500 Internal Server Error'
	);

	public function index()
	{
		$data["title"] = "Profilim";

		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getUserPassword = $this->input->post("user_password", true);
			$getNewPassword = $this->input->post("new_user_password", true);
			$getReNewPassword = $this->input->post("re_user_password", true);

			header('Status: ' . $this->jsonStatus[200]);

			if ($getNewPassword != $getReNewPassword) {

				$response = [
					'title' => 'Parola Hatası',
					'status' => 'error',
					'message' => 'Parolalar uyuşmuyor lütfen, parola ve parola tekrarı alanlarına aynı parolaları giriniz.',
				];

				exit(json_encode($this->response = $response));

			}

			$process = $this->Users_Model->passwordUpdateProfile($getUserPassword, $getNewPassword);

			if ($process) {

				$response = [
					'title' => 'İşlem Durumu',
					'status' => 'success',
					'message' => 'İşlem Başarıyla Gerçekleşti.',
				];

			} else {

				$response = [
					'title' => 'İşlem Durumu',
					'status' => 'error',
					'message' => 'İşlem Gerçekleştirilemedi.'
				];

			}

			exit(json_encode($this->response = $response));
		}

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		$this->load->view('management/header', $data);
		$this->load->view('management/profile/detail', $data);
		$this->load->view('management/footer', $data);

	}

}
