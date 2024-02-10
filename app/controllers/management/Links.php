<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Links extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata("profile_user")) {
			redirect(base_url("management/login"));
		}

		$this->load->model("Links_Model");
		$this->load->model("Users_Model");
	}

	private $jsonStatus = array(
		200 => '200 OK',
		400 => '400 Bad Request',
		422 => 'Unprocessable Entity',
		500 => '500 Internal Server Error'
	);

	// Linkler
	public function index()
	{

		$data["title"] = "Link Listesi";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		$data["userGroups"]=$this->Users_Model->getGroupResult();
		$data["users"]=$this->Users_Model->getUserResult();

		$this->load->view('management/header', $data);
		$this->load->view('management/links/list', $data);
		$this->load->view('management/footer', $data);
	}

	// Link Ekleme
	public function create()
	{

		$data["title"] = "Link Ekleme";

		$data["breadcrumbs"] = [
			'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
			'<li class="breadcrumb-item"><a href="' . base_url("management/links") . '" class="btn btn-flat bg-gradient-light btn-sm">Link Yönetimi</a></li>',
			'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
		];

		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getLink = $this->input->post("link", true);

			$getStatus = $this->input->post("status", true);

			$process = $this->Links_Model->linkInsert($getLink, $getStatus);

			header('Status: ' . $this->jsonStatus[200]);

			if ($process) {

				$response = [
					'status' => 'success',
					'message' => 'İşlem Başarıyla Gerçekleşti.',
					'link' => $process
				];

			} else {

				$response = [
					'status' => 'error',
					'message' => 'İşlem Gerçekleştirilemedi.'
				];

			}

			exit(json_encode($this->response = $response));
		}


		$this->load->view('management/header', $data);
		$this->load->view('management/links/create', $data);
		$this->load->view('management/footer', $data);
	}

	// Link Düzenleme
	public function edit($id = 0)
	{
		if ($id > 0) {

			if (!$this->Links_Model->getRow($id, "id")) {
				redirect(base_url('management/links'));
			}

			$data["title"] = "Link Ekleme";

			$data["breadcrumbs"] = [
				'<li class="breadcrumb-item"><a href="' . base_url("management") . '" class="btn btn-flat bg-gradient-light btn-sm">Dashboard</a></li>',
				'<li class="breadcrumb-item"><a href="' . base_url("management/links") . '" class="btn btn-flat bg-gradient-light btn-sm">Link Yönetimi</a></li>',
				'<li class="breadcrumb-item active"><span class="btn btn-flat bg-gradient-secondary btn-sm">' . $data["title"] . '</span></li>'
			];

			$data["id"] = $id;
			$data["status"] = $this->Links_Model->getRow($id, "status");
			$data["short_link"] = $this->Links_Model->getRow($id, "short_link");
			$data["original_link"] = $this->Links_Model->getRow($id, "original_link");

			if (isset($_POST) && !empty($_POST)) {
				header('Content-Type: application/json');

				$getLink = $this->input->post("link", true);

				$getStatus = $this->input->post("status", true);

				$process = $this->Links_Model->linkUpdate($id, $getLink, $getStatus);

				header('Status: ' . $this->jsonStatus[200]);

				if ($process) {

					$response = [
						'status' => 'success',
						'message' => 'İşlem Başarıyla Gerçekleşti.',
						'link' => $process
					];

				} else {

					$response = [
						'status' => 'error',
						'message' => 'İşlem Gerçekleştirilemedi.'
					];

				}

				exit(json_encode($this->response = $response));
			}

			$this->load->view('management/header', $data);
			$this->load->view('management/links/edit', $data);
			$this->load->view('management/footer', $data);
		} else {
			redirect(base_url('management/links'));
		}
	}

	// Link Silme
	public function delete()
	{
		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getLink = $this->input->post("id", true);

			if ($this->Links_Model->linkDelete($getLink)) {
				header('Status: ' . $this->jsonStatus[200]);
				echo json_encode(array('status' => true));

			} else {
				header('Status: ' . $this->jsonStatus[200]);
				echo json_encode(array('status' => false));
			}
		}
	}

	// Link Kontrolü
	public function linkCheck()
	{
		if (isset($_POST) && !empty($_POST)) {
			header('Content-Type: application/json');

			$getLink = $this->input->post("themeName", true);

			$get = $this->Links_Model->linkCheck($getLink);

			header('Status: ' . $this->jsonStatus[200]);

			if (!$get) {

				echo json_encode(array('status' => true));

			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	// Linkleri Ajax için topla
	public function getLinks()
	{
		$draw = $this->input->post("draw", true);
		$limit["length"] = $this->input->post("length", true);
		$limit["start"] = $this->input->post("start", true);
		$item["search"] = $this->input->post("search", true);

		$sqlWhere = "";
		$where[] = " id is NOT NULL ";

		$currentGroup = $this->session->userdata('profile_user')["user_group"];

		if ($currentGroup != 1) {
			$where[] = " created_group = $currentGroup ";
		}

		$this->load->model("Users_Model");

		if (isset($_POST) && !empty($_POST)) {
			$filterPost = array();
			$filter = $this->input->post('filter');
			$columns = $this->input->post('columns');
			$order = $this->input->post('order');

			if ($item["search"]["value"]) {
				$where[] = " short_link LIKE '%" . $item["search"]["value"] . "%' or original_link LIKE '%" . $item["search"]["value"] . "%' ";
			}



			if (is_array($filter)) {
				foreach ($filter as $kKey => $fVal) {
					if ($fVal["value"] != '') {
						$filterPost[$fVal["name"]] = $fVal["value"];
					}
				}

				if (count($filterPost) > 0) {

					if (isset($filterPost["status"]) and $filterPost["status"] != '') {
						$where[] = " status='" . $filterPost["status"] . "' ";
					}

					if (isset($filterPost["created_group"]) and $filterPost["created_group"] != '') {
						$where[] = " created_group='" . $filterPost["created_group"] . "' ";
					}

					if (isset($filterPost["created_user"]) and $filterPost["created_user"] != '') {
						$where[] = " created_user='" . $filterPost["created_user"] . "' ";
					}


				}
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

		$result = $this->Links_Model->getLinks($sqlWhere, $orderBy, $limit);
		$countItem = count($result);

		$return = [];

		foreach ($result as $key => $val) {
			$editBtn = '<a href="' . base_url('management/links/edit/' . $val->id) . '" class="btn bg-gradient-info btn-sm"><i class="fas fa-edit"></i></a>';
			$delete = '<button onclick="deleteItem(' . $val->id . ')" class="btn bg-gradient-danger btn-sm m-1" type="button"><i class="fas fa-trash-alt"></i></button>';

			$return[$key] = [
				'id' => $val->id,
				'status' => ($val->status) ? '<span class="btn bg-gradient-info btn-sm">Aktif</span>' : '<span class="btn bg-gradient-danger btn-sm">Pasif</span>',
				'short_link' => base_url($val->short_link),
				'original_link' => $val->original_link,
				'req_count' => $val->req_count,
				'created_user' => $this->Users_Model->userName($val->created_user),
				'created_date' => date("d.m.Y - H:i", $val->created_date),
				'created_ip' => $val->created_ip,
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
