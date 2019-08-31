<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class videoList extends CI_Controller {
    public function movie($id="") {
		$data['id'] = $id;
		$this->load->view('list.php', $data);
	}

	public function show() {
		$this->load->view('show_list.php');
	}
}
