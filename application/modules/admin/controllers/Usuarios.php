<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Usuarios extends MX_Controller {
    public $cview = "usuarios";
    public $controller = "usuarios";
    public $template = 'templates/admin_config';
    public $data =[
        "nombre" => "",
        "codigo" => "",
        "idUsuario" => ""
    ];

    public function __construct(){
        parent::__construct();
           
        $this->load->model('Tbl_usuario','obj_model');    
       
        if($this->session->userdata('logged') != 'true'){
            redirect('login');
        }

        date_default_timezone_set("America/Lima");
    }
	 
	public function index(){ 
        $model = $this->obj_model->get_all();

        $this->tmp_admin->set("controller",$this->controller);
      
        $this->tmp_admin->set("model",$model);

        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview.'/view.php');
    }

   

    public function subir(){

        $data["nombres"]     = $this->input->post("nombres");
        $data["apellidos"]  = $this->input->post("apellidos");
        $data["cargo"]      = $this->input->post("cargo");
        $data["email"]      = $this->input->post("email");
        $data["contrasena"] = md5(helper_get_semilla().$this->input->post("contrasena"));
        

        $idUsuario = $this->obj_model->insert($data);

        if(count($_FILES)!=0){    
            $carpeta = "static/images/usuarios/".$idUsuario;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
        

            $config['upload_path']          = $carpeta."/";
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 50000;
            $config['max_width']            = 5048;
            $config['max_height']           = 5068;
            $config['file_name']           = $idUsuario;
            $config['overwrite']           = TRUE;

            $this->load->library('upload', $config);

            //cargar archivo
            if (!$this->upload->do_upload('imagen')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array("resultado"=>"2"));
                //redirect("admin");
            } else {
                $result = array('upload_data' => $this->upload->data());
                $dataUsuario = array(
                    "imagen" =>$result["upload_data"]["file_name"]
                );
                $this->obj_model->update($dataUsuario,$idUsuario);
                echo json_encode(array("resultado"=>"1"));
                //redirect("admin");
            }
        }else{
            echo json_encode(array("resultado"=>"1"));
        }

    }
    

	public function agregar(){ 
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('apellidoPaterno', 'Apellido Paterno', 'trim|required');
        $this->form_validation->set_rules('apellidoMaterno', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        
        if ($this->form_validation->run($this) == FALSE)
        {
            $tipoDocumentos = $this->obj_tipoDocumentos->get_all();


            $this->tmp_admin->set("tipoDocumentos",$tipoDocumentos);
            $this->tmp_admin->set("controller",$this->controller);
            $this->load->tmp_admin->setLayout($this->template);
            $this->load->tmp_admin->render($this->cview.'/agregar_view.php');
        }
        else
        {   
            $data = $this->upPost($this->data);
            $data["nombresCompletos"] = $this->input->post("apellidoPaterno") ." ". $this->input->post("apellidoMaterno") ." ". $this->input->post("nombres") ;
            $data["fechaRegistro"] = date("Y-m-d H:i:s");

            $this->obj_model->insert($data);
            redirect("admin/".$this->controller);
        }
    }

	public function editar(){ 
      
        $id                 = $this->input->post("elid");
        $data["nombres"]     = $this->input->post("nombres");
        $data["apellidos"]  = $this->input->post("apellidos");
        $data["cargo"]      = $this->input->post("cargo");
        $data["email"]      = $this->input->post("email");
        $data["contrasena"] = md5(helper_get_semilla().$this->input->post("contrasena"));


        
        $this->obj_model->update($data,$id);
       
        if($_FILES!=null){
            $carpeta = "static/images/usuarios/".$id;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
        

            $config['upload_path']          = $carpeta."/";
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 50000;
            $config['max_width']            = 5048;
            $config['max_height']           = 5068;
            $config['file_name']           = $id;
            $config['overwrite']           = TRUE;

            $this->load->library('upload', $config);

            //cargar archivo
            if (!$this->upload->do_upload('imagen')) {
                $error = array('error' => $this->upload->display_errors());
                //echo json_encode(array("resultado"=>"2"));
                //redirect("admin");
            } else {
                $result = array('upload_data' => $this->upload->data());
                $dataUsuario = array(
                    "imagen" =>$result["upload_data"]["file_name"]
                );
                $this->obj_model->update($dataUsuario,$id);
            // echo json_encode(array("resultado"=>"1"));
                //redirect("admin");
            }
        }


        
        echo json_encode(array("resultado"=>"1","id"=>$id));

    }

    public function ajaxGuardarPilas(){
        
        $data["pilasavanzado"] = $this->input->post("pilas");
        $idProyecto = $this->session->userdata("idProyecto");

        $x = $this->input->post("x");
        $y = $this->input->post("y");
        
        $this->obj_model->update_coordenadas($data,$idProyecto,$x,$y);

        echo json_encode(array("respuesta"=>1,"pilas"=>$data["pilasavanzado"]));
    }


	public function eliminar($id){ 
        
        $data = [
            "idEstado" => "0"
        ];
        $this->obj_model->update($data,$id);
        redirect("admin/".$this->controller);
    }

   

    public function upPost($data){
        $data = $this->data;

        foreach ($data as $key => $value) 
            if($this->input->post($key)!="") 
                $data[$key] = $this->input->post($key);
        
        return $data;
    }
    
    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 