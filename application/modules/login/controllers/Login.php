<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Tbl_usuario','obj_usuario');
        
        if($this->session->userdata('logged') == 'true'){
         
            redirect('admin');
        }
    }
    
    public function index(){
        
        $this->form_validation->set_rules('email', 'Correo', 'trim|required');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        
        if ($this->form_validation->run($this) == FALSE)
        {
            $this->load->view('login_view.php');
            //echo md5(helper_get_semilla()."123");   
        }
        else
        {
            $email =  $this->input->post('email');  
            $contrasena =  $this->input->post('contrasena');  

            if($this->obj_usuario->validar_usuario($email,$contrasena)){
               
                redirect('admin');
            }else{
                
                redirect('login');
            }
        }
    }

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('login');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */