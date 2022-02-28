<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();

        require_once __DIR__ . '/../../assets/ci_helpers/global_helper.php';
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
        |  Set up this if there is device manager
        | -------------------------------------------------------------------
        */
        $this->table_devices    = 'devices';
        $this->table_addresses  = 'addresses';
        $this->table_u_devices  = 'user_device';
        
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
        if ($this->uri->segment(2) != 'create_password' && !$this->user['password_hash']) redirect('home/create_password');

        $this->language['active'] = 'en';

        $this->toasts = [
            [
                'id'        => 'create_pw_success',
                'title'     => 'Success',
                'message'   => 'Create password success'
            ],
            [
                'id'        => 'change_pw_success',
                'title'     => 'Success',
                'message'   => 'Change password cuccess'
            ],
            [
                'id'        => 'change_pw_failed',
                'title'     => 'Failed',
                'message'   => 'Change password failed, please try again'
            ],
        ];

        $this->toast_id = isset($_POST['status']) ? $_POST['status'] : '';
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
                $this->js['jquery36'],
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
        $this->load->view('ci_templates/toast', ['toasts' => $this->toasts, 'custom_class' => 'position-fixed top-0 mt-5 end-0 p-3']);
        $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
        $this->load->view('ci_templates/end');
    }

    public function create_password()
	{
        if ($this->user['password_hash']) redirect('home');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password]');

        if($this->form_validation->run() == false) {
            $data   = [
                'title'         => 'SB Admin - Create Password',
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
            $this->load->view('create_password');
            $this->load->view('copyright');
            $this->load->view('ci_templates/end');
        } else {
            $this->dhonapi->post($this->database, $this->table, [
                'password_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'modified_at'   => time(),
                'id'            => $this->user['id'],
            ]);

            redirect('home/redirect_post?action=home&post_name1=status&post_value1=create_pw_success');
        }
    }

    public function change_password()
	{
        $this->load->library('form_validation');

        if (!isset($_POST['status'])) {
            $this->form_validation->set_rules('old_password', 'Current Password', 'required|trim');
            $this->form_validation->set_rules('password', 'New Password', 'required|trim|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('repeat_password', 'Repeat New Password', 'required|trim|matches[password]');
        }

        if($this->form_validation->run() == false) {
            $data   = [
                'title'         => 'SB Admin - Change Password',
                'css'           => [
                    $this->css['sb-admin'],
                    $this->css['fontawesome5'],
                ],
                'js'            => [
                    $this->js['jquery36'],
                    $this->js['bootstrap-bundle5'],
                    $this->js['sb-admin'],
                ],
                'body_class'    => 'sb-nav-fixed',
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('change_password');
            $this->load->view('copyright');
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts, 'custom_class' => 'position-fixed top-0 mt-5 end-0 p-3']);
            $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);    
            $this->load->view('ci_templates/end');
        } else {
            if (password_verify($this->input->post('old_password'), $this->user['password_hash'])) {
                $this->dhonapi->post($this->database, $this->table, [
                    'password_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'modified_at'   => time(),
                    'id'            => $this->user['id'],
                ]);

                redirect('home/redirect_post?action=home&post_name1=status&post_value1=change_pw_success');
            } else {
                redirect('home/redirect_post?action=home/change_password&post_name1=status&post_value1=change_pw_failed');
            }
        }
    }

    public function device_activity()
    {
        $data   = [
            'title'         => 'SB Admin - Device Activity',
            'css'           => [
                $this->css['sb-admin'],
                $this->css['fontawesome5'],
                $this->css['bootstrap5'],
            ],
            'js'            => [
                $this->js['jquery36'],
                $this->js['bootstrap-bundle5'],
                $this->js['sb-admin'],
            ],
            'body_class'    => 'sb-nav-fixed',

            'devices'       => $this->dhonapi->get($this->database, $this->table_u_devices, ['id_user' => $this->user['id']]),
        ];

        function get_device_name($id)
        {
            $ci = get_instance();

            $htmlentities = $ci->dhonapi->get($ci->database, $ci->table_devices, ['id_device' => $id])[0];
            return $htmlentities['device_name'] ? $htmlentities['device_name'] : explode(';', get_word_between($htmlentities['htmlentities'], '(', ')'))[0];
        }

        function get_location($id)
        {
            $ci = get_instance();

            $ip_info = $ci->dhonapi->get($ci->database, $ci->table_addresses, ['id_address' => $id])[0]['ip_info'];
            return json_decode($ip_info)->status == 'success' ? json_decode($ip_info)->city.', '.json_decode($ip_info)->country : 'localhost';
        }

        $this->load->view('ci_templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('device_activity');
        $this->load->view('copyright');
        $this->load->view('ci_templates/toast', ['toasts' => $this->toasts, 'custom_class' => 'position-fixed top-0 mt-5 end-0 p-3']);
        $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);    
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

    public function redirect_post()
    {
        $data = [
            'action'        => $_GET['action'],
        ];

        $posts = [
            [
                'post_name1'    => $_GET['post_name1'],
                'post_value1'   => $_GET['post_value1'],
            ],
        ];
        for ($i=2; $i <= 10; $i++) { 
            if (isset($_GET['post_name'.$i])) $posts[$i-1]['post_name'.$i] = $_GET['post_name'.$i];
            if (isset($_GET['post_value'.$i])) $posts[$i-1]['post_value'.$i] = $_GET['post_value'.$i];
        }
        $data['posts'] = $posts;

        $this->load->view('ci_templates/redirect_post', $data);
    }
}