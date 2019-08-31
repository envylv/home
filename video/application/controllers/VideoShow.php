<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class videoShow extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Fac');
    }

    public function movie($id) {
        $data['info'] = $this->fac->getMoiveInfo($id);
        $this->load->view('view', $data);
    }

    public function show($id) {
        $data['info'] = $this->fac->getTVShowInfo($id);
        $this->load->view('show_view', $data);
    }
}
