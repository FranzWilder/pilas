<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {
    public function __construct(){
        parent::__construct();


        $this->load->model('Tbl_usuario','obj_usuario');    
       
        if($this->session->userdata('logged') != 'true'){
            redirect('login');
          
        }
        date_default_timezone_set("America/Lima");
    }
	 
	public function index(){ 
        $this->tmp_admin->set('usuario',$this->session->userdata('usuario'));
        
        $this->load->tmp_admin->setLayout('templates/admin_config');
        redirect("admin/proyectos");
        //$this->load->tmp_admin->render('admin_view.php');
	}

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 