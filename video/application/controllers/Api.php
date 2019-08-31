<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Fac');
    }

    public function get_count() {
        $type = $this->input->POST('type');
        $id = $this->input->POST('id');
        if(!$type) {
            die();
        }
        echo $this->fac->getCount($type, $id);
    }
    
    public function get_list() {
        $type = $this->input->POST('type');
        $start = $this->input->POST('start');
        $num = $this->input->POST('num');
        $id = $this->input->POST('id');
        if(!$num){
            die();
        }
        if('tvshow' == $type) {
            $array = $this->fac->getTVShowList($start, $num);
        } else {
            $array = $this->fac->getMovieList($start, $num, $id);
        }
        echo json_encode($array);
    }
}
