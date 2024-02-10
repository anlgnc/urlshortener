<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Groups extends CI_Controller
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

		$this->load->model("Users_Model");

		$data["title"] = "Kullanıcı Grubu Listesi";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		$this->load->view('management/header', $data);
		$this->load->view('management/groups/list', $data);
		$this->load->view('management/footer', $data);

	}

	// Kullanıcı Grubu Ekleme
	public function create()
	{
		$data["title"] = "Kullanıcı Grubu Ekleme";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item"><a href="' . base_url("management/groups") . '" class="btn btn-flat bg-gradient-light btn-sm">Kullanıcı Grubu Yönetimi</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getName = $this->input->post("grup_name", true);

			$getStatus = $this->input->post("status", true);

			$process = $this->Users_Model->addGroup($getName, $getStatus);

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
		$this->load->view('management/groups/create', $data);
		$this->load->view('management/footer', $data);
	}

	// Kullanıcı Grubu Düzenleme
	public function edit($id = 0)
	{
		if ($id > 0) {

			if (!$this->Users_Model->getGroupRow($id, "id")) {
				redirect(base_url('management/links'));
			}

			$data["title"] = "Kullanıcı Grubu Düzenleme";

			$data["id"] = $id;
			$data["status"] = $this->Users_Model->getGroupRow($id, "status");
			$data["group_name"] = $this->Users_Model->getGroupRow($id, "group_name");

			$data["breadcrumbs"] = [
				'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
				'<li class="breadcrumb-item"><a href="' . base_url("management/groups") . '" class="btn btn-flat bg-gradient-light btn-sm">Kullanıcı Grubu Yönetimi</a></li>',
				'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
			];

			if (isset($_POST) && !empty($_POST)) {
				header('Content-Type: application/json');

				$getName = $this->input->post("grup_name", true);

				$getStatus = $this->input->post("status", true);

				$process = $this->Users_Model->updateGroup($id, $getName, $getStatus);

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
			$this->load->view('management/groups/edit', $data);
			$this->load->view('management/footer', $data);

		} else {
			redirect(base_url('management/links'));
		}
	}

	// Grup Silme
	public function delete()
	{
		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$get = $this->input->post("id", true);

			if ($get != 1) {

				if ($this->Users_Model->deleteGroup($get)) {

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
						'status' => 'error',
						'message' => 'İşlem Başarısız.',
					];
				}
			} else {
				header('Status: ' . $this->jsonStatus[200]);
				$response = [
					'title' => 'İşlem Durumu',
					'status' => 'info',
					'message' => 'Bunu yapmaya yetkiniz yok..',
				];
			}

			exit(json_encode($this->response = $response));
		}
	}

	// Kullanıcı Grupları Ajax için topla
	public function getGroups()
	{
		$draw = $this->input->post("draw", true);
		$limit["length"] = $this->input->post("length", true);
		$limit["start"] = $this->input->post("start", true);
		$item["search"] = $this->input->post("search", true);

		$sqlWhere = "";
		$where[] = " id is NOT NULL ";

		$this->load->model("Users_Model");

		if (isset($_POST) && !empty($_POST)) {
			$filterPost = array();
			$filter = $this->input->post('filter');
			$columns = $this->input->post('columns');
			$order = $this->input->post('order');

			if ($item["search"]["value"]) {
				$where[] = " group_name LIKE '%" . $item["search"]["value"] . "%' ";
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

		$result = $this->Users_Model->getGroups($sqlWhere, $orderBy, $limit);
		$countItem = count($result);

		$return = [];

		foreach ($result as $key => $val) {

			$editBtn = '<a href="' . base_url('management/groups/edit/' . $val->id) . '" class="btn btn-sm btn-light"><i class="fas fa-edit"></i></a>';

			$dis = ($val->id == 1) ? "disabled" : null;

			$delete = '<button onclick="deleteItem(' . $val->id . ')" class="btn btn-danger btn-sm m-1" type="button" '.$dis.'><i class="fas fa-trash-alt"></i></button>';

			$return[$key] = [
				'id' => $val->id,
				'status' => ($val->status) ? '<span class="text-green">Aktif</span>' : '<span class="text-danger">Pasif</span>',
				'group_name' => $val->group_name,
				'created_date' => date("d.m.Y - H:i", $val->created_date),
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
