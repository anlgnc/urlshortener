<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function index($link = null)
	{

		if (!empty($link)) {
			$this->load->model("Links_Model");

			$resLink = $this->Links_Model->toLink($link);

			if ($resLink) {
				redirect($resLink);
			} else {
				echo "hata";
			}
		} else {
			echo "hata";
		}
	}
}
