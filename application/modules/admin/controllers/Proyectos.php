<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Proyectos extends MX_Controller {
    public $cview = "proyectos";
    public $controller = "proyectos";
    public $template = 'templates/admin_config';
    public $data =[
        "nombre" => "",
        "codigo" => "",
        "pilas_llenas" => "",
        "pilas_vacias" => "",
        "idUsuario" => ""
    ];

    public function __construct(){
        parent::__construct();
        $this->load->model('Tbl_usuario','obj_usuario');     
           
        $this->load->model('Tbl_proyecto','obj_model');    
       
        if($this->session->userdata('logged') != 'true'){
            redirect('login');
        }

        date_default_timezone_set("America/Lima");
    }
	 
	public function index(){ 

        $this->tmp_admin->set("controller",$this->controller);
      

        $proyectos = $this->obj_model->get_all();
        $array_proyectos = array();
        $cont = 0;

        

        $proyectos_todos = array();

        foreach ($proyectos as $key => $value) {
            $asignados = explode(",",$value->asignados);

            if($value->idUsuario == $this->session->userdata("id") ||in_array($this->session->userdata("id"),$asignados) ){
                $proyectos_todos[]=$value;
            }
            
        }
        
        
       
        $proyectos = $proyectos_todos;

        foreach ($proyectos as $key => $value) {
            $nume = $this->obj_model->get_curso_proyecto($value->id);

            if(count($nume)>0){
                $value->curso = 1;
            }else{
                $value->curso = 3;
            }
        }

        while($cont < count($proyectos)){
            $grupo_seis = array();


            if(count($proyectos)-$cont>6){
                $fin = $cont + 6;
            }else{
                $fin = count($proyectos);
            }

            for($i=$cont;$i<$fin;$i++){
                $grupo_seis[] = $proyectos[$i];
            }
            $cont=$fin;
            $array_proyectos[] = $grupo_seis;
        }

      

        $this->tmp_admin->set("model",$this->obj_model->get_all());
        $this->tmp_admin->set("array_proyectos",$array_proyectos);
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview.'/view.php');
    }

    public function mapa($idProyecto){ 

        $this->session->set_userdata("idProyecto",$idProyecto);

        $array_coordenadas = $this->obj_model->get_all_coordenas($idProyecto);


        $this->tmp_admin->set("array_coordenadas",$array_coordenadas);

        $proyecto = $this->obj_model->get_id($idProyecto);
        $coordenas = $this->obj_model->get_all_coordenas($idProyecto);

       
        $asignados = array();

        if($proyecto->asignados!=""){
            $asignados = explode(",", $proyecto->asignados);
        }

        $usuarios = $this->obj_usuario->get_all();
        $usuario = $this->obj_usuario->get_usuario($this->session->userdata("id"));


        $this->tmp_admin->set("usuario",$usuario);
        
        $this->tmp_admin->set("idProyecto",$idProyecto);
        $this->tmp_admin->set("idUsuario",$this->session->userdata("id"));
        $this->tmp_admin->set("usuarios",$usuarios);
        $this->tmp_admin->set("proyecto",$proyecto);
        $this->tmp_admin->set("asignados",$asignados);
        $this->tmp_admin->set("coordenas",$coordenas);
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview.'/mapa.php');
    }

    public function asignarUsuarios($idProyecto){
        if($_POST){
            $data["asignados"] = implode(",",$_POST["asignados"]);
            $this->obj_model->update($data,$idProyecto);
            redirect("admin/proyectos/mapa/".$idProyecto);
        }
    }

    public function subir(){
       
        $idUsuario=$this->session->userdata("id");
        $nombreProyecto=$this->input->post("nombreProyecto");

        $data["nombre"] =$nombreProyecto;
        $data["idUsuario"] =$idUsuario;
        $idProyecto = $this->obj_model->insert($data);


        $carpeta = "static/images/proyectos/".$idProyecto."/excel";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
    

        $config['upload_path']          = $carpeta."/";
        $config['allowed_types']        = 'xls';
        $config['max_size']             = 50000;
        $config['max_width']            = 5048;
        $config['max_height']           = 5068;
        $config['file_name']           = $idProyecto;
        $config['overwrite']           = TRUE;

        $this->load->library('upload', $config);

        //cargar archivo
        if (!$this->upload->do_upload('imagen')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            redirect("admin");
        } else {
            $result = array('upload_data' => $this->upload->data());

            $rutaArchivo = "static/images/proyectos/".$idProyecto."/excel/".$idProyecto.".xls";
    
            $documento = IOFactory::load($rutaArchivo);
        

            $totalDeHojas = $documento->getSheetCount();

            $hojaActual = $documento->getSheet(0);
            $array_coordenadas = array();
           
            for($i=2;$i<5000;$i++){
                $num = $hojaActual->getCellByColumnAndRow( 7,$i)->getValue();
                $x = $hojaActual->getCellByColumnAndRow( 5,$i)->getValue();
                $y = $hojaActual->getCellByColumnAndRow( 6,$i)->getValue();
                $endx = $hojaActual->getCellByColumnAndRow( 1,$i)->getValue();
                $endy = $hojaActual->getCellByColumnAndRow( 2,$i)->getValue();
                $startx = $hojaActual->getCellByColumnAndRow( 3,$i)->getValue();
                $starty = $hojaActual->getCellByColumnAndRow( 4,$i)->getValue();

                $radio = 0.26;

                $data = array();
                $data["idProyecto"] = $idProyecto;
                
                $data["num"] = $num;
                $data["radio"] = $radio;
                
                if (is_numeric($x) && is_numeric($y) && is_numeric($radio)) {
                    $data["x"] = $x;
                    $data["y"] = $y;
                    $this->obj_model->insert_coordenadas($data);
                }else if(is_numeric($endx) && is_numeric($endy) && is_numeric($startx) && is_numeric($starty)){
                    $data["endx"] = $endx;
                    $data["endy"] = $endy;
                    $data["startx"] = $startx;
                    $data["starty"] = $starty;
                    $data["num"] = 0;
                    $this->obj_model->insert_coordenadas($data);
                } 
            }
            redirect("admin");
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

	public function editar($id){ 
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('apellidoPaterno', 'Apellido Paterno', 'trim|required');
        $this->form_validation->set_rules('apellidoMaterno', 'Apellido Materno', 'trim|required');
        
        $this->form_validation->set_message('required', 'Este campo es requerido');
        
        if ($this->form_validation->run($this) == FALSE)
        {
            $tipoDocumentos = $this->obj_tipoDocumentos->get_all();


            $this->tmp_admin->set("tipoDocumentos",$tipoDocumentos);
            $this->tmp_admin->set("controller",$this->controller);
            $this->tmp_admin->set("model",$this->obj_model->get_id($id));
            $this->load->tmp_admin->setLayout($this->template);
            $this->load->tmp_admin->render($this->cview.'/editar_view.php');
        }
        else
        {
            $data = $this->upPost($this->data);
            $data["nombresCompletos"] = $this->input->post("apellidoPaterno") ." ". $this->input->post("apellidoMaterno") ." ". $this->input->post("nombres") ;

           
            $this->obj_model->update($data,$id);
            redirect("admin/".$this->controller);
        }
    }

    public function ajaxGuardarPilas(){
        

        $data["id"]= $this->input->post("id");
        $data["idUsuario"] = $this->input->post("usuario");
        $data["pilasavanzado"] = $this->input->post("pilas");
        $data["fechaActualizacion"] = date("Y-m-d H:i:s");
        
        $data["a1"] = $this->input->post("a1");
        $data["a2"] = $this->input->post("a2");
        $data["a3"] = $this->input->post("a3");
        $data["a4"] = $this->input->post("a4");
        $data["a5"] = $this->input->post("a5");
        $data["a6"] = $this->input->post("a6");
        $data["a7"] = $this->input->post("a7");
        $data["a8"] = $this->input->post("a8");
        $data["a9"] = $this->input->post("a9");
        $data["a10"] = $this->input->post("a10");
        $data["a11"] = $this->input->post("a11");
        $data["a12"] = $this->input->post("a12");
        $data["a13"] = $this->input->post("a13");
        $data["a14"] = $this->input->post("a14");
        $data["a15"] = $this->input->post("a15");
        $data["a16"] = $this->input->post("a16");
        $data["a17"] = $this->input->post("a17");
        $data["a18"] = $this->input->post("a18");
        $data["a19"] = $this->input->post("a19");
        $data["a20"] = $this->input->post("a20");
        $data["a21"] = $this->input->post("a21");
        $data["a22"] = $this->input->post("a22");
        $data["a23"] = $this->input->post("a23");
        $data["a24"] = $this->input->post("a24");
        $data["a25"] = $this->input->post("a25");
        $data["a26"] = $this->input->post("a26");
        $data["a27"] = $this->input->post("a27");
        $data["a28"] = $this->input->post("a28");
        $data["a29"] = $this->input->post("a29");
        $data["a30"] = $this->input->post("a30");
        $data["a31"] = $this->input->post("a31");
        $data["a32"] = $this->input->post("a32");
        $data["a33"] = $this->input->post("a33");
        $data["a34"] = $this->input->post("a34");
        $data["a35"] = $this->input->post("a35");
        $data["a36"] = $this->input->post("a36");
        $data["a37"] = $this->input->post("a37");
        $data["a38"] = $this->input->post("a38");
        $data["a39"] = $this->input->post("a39");
        $data["a40"] = $this->input->post("a40");
        $data["a41"] = $this->input->post("a41");
        $data["a42"] = $this->input->post("a42");
        $data["a43"] = $this->input->post("a43");
        $data["a44"] = $this->input->post("a44");
        $data["a45"] = $this->input->post("a45");
        $data["a46"] = $this->input->post("a46");
        $data["a47"] = $this->input->post("a47");
        $data["a48"] = $this->input->post("a48");
        $data["a49"] = $this->input->post("a49");
        $data["a50"] = $this->input->post("a50");
        $data["a51"] = $this->input->post("a51");


        $vacio = true;
        $lleno = true;

        for ($i=1; $i < 52; $i++) { 
            if($data["a".$i]==""){
                $lleno = false;
            } 
            if($data["a".$i]!=""){
                $vacio = false;
            }
        }

        if($vacio){
            $data["estadoPila"] = 1;
        }else if($lleno){
            $data["estadoPila"] = 3;
        }else{
            $data["estadoPila"] = 2;
        }

        $this->obj_model->update_coordenadas($data,$data["id"]);

        echo json_encode(array("respuesta"=>1,"pilas"=>$data["pilasavanzado"]));
    }

    public function getParametros(){ 
        $id = $this->input->post("id");
        $parametros = $this->obj_model->get_parametros_id($id);

  
        echo json_encode(array("respuesta"=>1,"parametros"=>$parametros));
    }

	public function eliminar($id){ 
        $data = [
            "activo" => "0"
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
 