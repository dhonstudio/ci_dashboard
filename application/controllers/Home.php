<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();

        require_once __DIR__ . '/../../assets/ci_helpers/style_helper.php';
        require_once __DIR__ . '/../../assets/ci_libraries/DhonAPI.php';
        $this->dhonapi = new DhonAPI;

        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/';
        $this->dhonapi->api_url['production'] = 'https://dhonstudio.com/ci/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';

        $this->lang = 'en';
	}

	public function index()
	{
        $data = [
            'title'         => 'SB Admin - Dashboard',
            'css'           => [
                $this->css['sb-admin'],
                $this->css['fontawesome5'],
            ],
            'body_class'    => 'sb-nav-fixed',
            'js'            => [
                $this->js['bootstrap-bundle5'],
                $this->js['sb-admin'],
            ],
        ];

        $this->load->view('ci_templates/header', $data);
        $this->load->view('home');
        $this->load->view('copyright');
        $this->load->view('ci_templates/toast');
        $this->load->view('ci_templates/footer');
        $this->load->view('ci_templates/end');
    }

    public function qrcode($id)
    {
        include(__DIR__.'/../../assets/vendor/phpqrcode/qrlib.php');

		QRcode::png($id);
    }
}