<?php

/*
 *	Created By
 *  BSC URL SHORTENER | anlgnc
 *  anilgnca@gmail.com - 29.01.2024
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function index()
	{

		if ($this->session->has_userdata("profile_user")) {
			redirect(base_url("management"));
		}

		$this->load->view('management/login');

	}

	// User Login
	public function login()
	{

		if (!$this->session->has_userdata('profile_user')) {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				header('Content-Type: application/json');

				$userName = $this->input->post("username", true);

				$userPassword = md5(sha1($this->input->post("password", true)));

				$userCaptcha = $this->input->post("captcha", true);

				$lgcaptcha = $this->session->userdata('lgcaptcha');

				$captc = $userCaptcha;

				if ($lgcaptcha == "") {
					$this->session->unset_userdata("formcaptcha");
					echo json_encode([
						'status' => 'error',
						'message' => 'Güvenlik Anahtarı Geçersiz!',
					]);
					exit;
				}
				if ($lgcaptcha != $captc) {
					$this->session->unset_userdata("formcaptcha");
					echo json_encode([
						'status' => 'error',
						'message' => 'Güvenlik Anahtarı Hatalı Lütfen Kontrol Edin',
					]);
					exit;
				}

				$this->load->model("Users_Model");

				// Check User
				$userQuery = $this->Users_Model->login($userName, $userPassword);

				if ($userQuery) {

					// Session Array
					$logArr = [
						'id' => $userQuery->id,
						'user_name' => $userQuery->user_name,
						'user_group' => $userQuery->user_group,
						'user_group_text' => $this->Users_Model->getGroupRow($userQuery->user_group, "group_name"),
						'ip' => $userQuery->user_login_ip,
						'login' => $userQuery->user_login_date,
					];

					$this->session->set_userdata("profile_user", $logArr);

					header('HTTP/1.1 200 OK');

					echo json_encode([
						'status' => 'success',
						'message' => 'Hoşgeldiniz, giriş yapılıyor...',
					]);

					exit();

				} else {
					header('HTTP/1.1 200 OK');

					echo json_encode([
						'status' => 'error',
						'message' => 'Kullanıcı adı veya şifre hatalı olabilir, lütfen tekrar deneyiniz.',
					]);

					exit();
				}
			}
		}

	}

	// User Logout
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('management/login'));
	}

	// Captcha
	public function captcha()
	{
		$image = @imagecreatetruecolor(120, 30) or die("Cannot Initialize new GD image stream");

		$background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

		imagefill($image, 0, 0, $background);

		$linecolor = imagecolorallocate($image, 222, 222, 222);

		$textcolor = imagecolorallocate($image, 0, 0, 0);

		for ($i = 0; $i < 6; $i++) {
			imagesetthickness($image, rand(1, 3));
			imageline($image, 0, rand(0, 30), 120, rand(0, 30), $linecolor);
		}

		$digit = '';

		for ($x = 15; $x <= 95; $x += 20) {
			$digit .= ($num = rand(0, 9));
			imagechar($image, 5, $x, rand(2, 14), $num, $textcolor);
		}

		$this->session->set_userdata(["lgcaptcha" => $digit]);

		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);

	}
}
