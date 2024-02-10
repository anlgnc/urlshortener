<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->session->has_userdata("profile_user")) {
			redirect(base_url("management/login"));
		}

		if (!isAdmin()) {
			redirect(base_url('management'));
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
		$data["title"] = "Kullanıcı Listesi";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		$this->load->view('management/header', $data);
		$this->load->view('management/users/list', $data);
		$this->load->view('management/footer', $data);

	}

	// Kullanıcı Ekleme
	public function create()
	{
		$data["title"] = "Kullanıcı Ekleme";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item"><a href="' . base_url("management/users") . '" class="btn btn-flat bg-gradient-light btn-sm">Kullanıcı Yönetimi</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		$data["groups"] = $this->Users_Model->getGroupResult(2);

		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getUserName = $this->input->post("user_name", true);

			$getUserPassword = $this->input->post("user_password", true);

			$getUserGroup = $this->input->post("user_group", true);

			$getUserStatus = $this->input->post("status", true);

			$process = $this->Users_Model->addUser($getUserName, $getUserPassword, $getUserGroup, $getUserStatus);

			header('Status: ' . $this->jsonStatus[200]);

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

		$this->load->view('management/header', $data);
		$this->load->view('management/users/create', $data);
		$this->load->view('management/footer', $data);
	}

	// Kullanıcı Düzenleme
	public function edit($id)
	{
		if ($id > 0) {

			if (!$this->Users_Model->getUserRow($id, "id")) {
				redirect(base_url('management/users'));
			}

			$data["title"] = "Kullanıcı Düzenleme";

			$data["breadcrumbs"] = [
				'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
				'<li class="breadcrumb-item"><a href="' . base_url("management/users") . '" class="btn btn-flat bg-gradient-light btn-sm">Kullanıcı Yönetimi</a></li>',
				'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
			];

			$data["groups"] = $this->Users_Model->getGroupResult(2);

			$data["id"] = $id;
			$data["user_name"] = $this->Users_Model->getUserRow($id, "user_name");
			$data["user_password"] = $this->Users_Model->getUserRow($id, "user_password");
			$data["user_status"] = $this->Users_Model->getUserRow($id, "user_status");
			$data["user_group"] = $this->Users_Model->getUserRow($id, "user_group");

			if (isset($_POST) && !empty($_POST)) {
				header('Content-Type: application/json');

				$getUserName = $this->input->post("user_name", true);

				$getUserPassword = $this->input->post("user_password", true);

				if (!empty($getUserPassword)) {


					$newPassword = md5(sha1($getUserPassword));

					if ($newPassword != $data["user_password"]) {
						$getUserPassword = $newPassword;
					}

				} else {

					exit(json_encode("geldi 2"));

					$getUserPassword = $data["user_password"];
				}

				$getUserGroup = $this->input->post("user_group", true);

				$getUserStatus = $this->input->post("status", true);

				$process = $this->Users_Model->updateUser($id, $getUserName, $getUserPassword, $getUserGroup, $getUserStatus);

				header('Status: ' . $this->jsonStatus[200]);

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

			$this->load->view('management/header', $data);
			$this->load->view('management/users/edit', $data);
			$this->load->view('management/footer', $data);
		} else {
			redirect(base_url('management/users'));
		}
	}

	// Kullanıcı Silme
	public function delete()
	{
		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$get = $this->input->post("id", true);

			if ($this->Users_Model->deleteUser($get)) {

				header('Status: ' . $this->jsonStatus[200]);

				$response = [
					'title' => 'İşlem Durumu',
					'status' => 'success',
					'message' => 'İşlem Başarıyla Gerçekleşti.',
				];

			} else {
				header('Status: ' . $this->jsonStatus[200]);
				$response = [
					'title' => 'İşlem Durumu',
					'status' => 'success',
					'message' => 'İşlem Başarıyla Gerçekleşti.',
				];
			}

			exit(json_encode($this->response = $response));
		}
	}

	// Kullanıcıları Ajax için topla
	public function getUsers()
	{
		$draw = $this->input->post("draw", true);
		$limit["length"] = $this->input->post("length", true);
		$limit["start"] = $this->input->post("start", true);
		$item["search"] = $this->input->post("search", true);

		$sqlWhere = "";
		$where[] = " id is NOT NULL ";

		if (isset($_POST) && !empty($_POST)) {
			$filterPost = array();
			$filter = $this->input->post('filter');
			$columns = $this->input->post('columns');
			$order = $this->input->post('order');

			if ($item["search"]["value"]) {
				$where[] = " user_name LIKE '%" . $item["search"]["value"] . "%' or user_group LIKE '%" . $item["search"]["value"] . "%' ";
			}

			$orderColumn = 0;
			$orderDir = 'DESC';
			foreach ($order as $orderKey => $orderVal) {
				$orderColumn = $orderVal["column"];
				$orderDir = $orderVal["dir"];
			}

			$orderBy = "";
			// Sıralama için
			foreach ($columns as $colKey => $colVal) {
				if ($orderColumn == $colKey) {
					$orderBy = " ORDER BY " . $colVal["data"] . " " . $orderDir;
				}
			}
		}

		$sqlWhere = implode(' and ', $where);

		$result = $this->Users_Model->getUsers($sqlWhere, $orderBy, $limit);
		$countItem = count($result);

		$return = [];

		foreach ($result as $key => $val) {
			$editBtn = '<a href="' . base_url('management/users/edit/' . $val->id) . '" class="btn btn-sm btn-light"><i class="fas fa-edit"></i></a>';
			$delete = '<button onclick="deleteItem(' . $val->id . ')" class="btn btn-danger btn-sm m-1" type="button"><i class="fas fa-trash-alt"></i></button>';

			$return[$key] = [
				'id' => $val->id,
				'user_status' => ($val->user_status) ? '<span class="text-green">Aktif</span>' : '<span class="text-danger">Pasif</span>',
				'user_name' => $val->user_name,
				'user_group' => $val->user_group,
				'user_created_date' => date("d.m.Y - H:i", $val->user_created_date),
				'user_login_date' => date("d.m.Y - H:i", $val->user_login_date),
				'user_login_ip' => $val->user_login_ip,
				'btn' => $editBtn . $delete
			];
		}

		echo json_encode($json_data = [
			"draw" => intval($draw),
			"recordsTotal" => intval($countItem),
			"recordsFiltered" => intval($countItem),
			"data" => $return
		]);
		exit;

	}
}
