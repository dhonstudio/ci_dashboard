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

        /*
        | -------------------------------------------------------------------
        |  Set up this API connection section
        | -------------------------------------------------------------------
        */
        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/';
        $this->dhonapi->api_url['production'] = 'https://dhonstudio.com/ci/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';

        /*
        | -------------------------------------------------------------------
        |  Set up this API db
        | -------------------------------------------------------------------
        */
        $this->database         = 'project';
        $this->table            = 'user_ci';
        
        /*
        | -------------------------------------------------------------------
        |  Set up this Cookie and Auth Service section
        | -------------------------------------------------------------------
        */
        if (ENVIRONMENT == 'development') {
            $this->cookie_prefix    = 'm';
            $this->auth_redirect    = 'http://localhost/ci_auth';
        } else {
            $this->cookie_prefix    = '__Secure-';
            $this->auth_redirect    = 'https://dhonstudio.com/ci/auth';
        }
        $this->secure_prefix    = 'DSC250222s';
        $this->secure_auth      = "DSA250222k";
        
        $this->load->helper('cookie');
        if (!$this->input->cookie("{$this->cookie_prefix}{$this->secure_auth}") || !$this->input->cookie("{$this->cookie_prefix}{$this->secure_prefix}")) redirect($this->auth_redirect);
        
        /*
        | -------------------------------------------------------------------
        |  Don't forget to set up encryption key
        | -------------------------------------------------------------------
        */
        $this->load->library('encryption');

        $auth_key   = $this->encryption->decrypt($this->input->cookie("{$this->cookie_prefix}{$this->secure_auth}"));
        $this->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => $auth_key
            )
        );
        $id         = $this->encryption->decrypt($this->input->cookie("{$this->cookie_prefix}{$this->secure_prefix}"));
        $this->user = $this->dhonapi->get($this->database, $this->table, ['id' => $id])[0];

        $this->language['active'] = 'en';
	}

	public function index()
	{
        $data   = [
            'title'         => 'SB Admin - Dashboard',
            'css'           => [
                $this->css['sb-admin'],
                $this->css['fontawesome5'],
            ],
            'js'            => [
                $this->js['bootstrap-bundle5'],
                $this->js['sb-admin'],
            ],
            'body_class'    => 'sb-nav-fixed',
        ];

        $this->load->view('ci_templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('home');
        $this->load->view('copyright');
        $this->load->view('ci_templates/end');
    }

    public function qrcode($id)
    {
        include(__DIR__.'/../../assets/vendor/phpqrcode/qrlib.php');

		QRcode::png($id);
    }

    public function logout()
    {
        delete_cookie("{$this->cookie_prefix}{$this->secure_auth}");
        delete_cookie("{$this->cookie_prefix}{$this->secure_prefix}");

        redirect();
    }
}