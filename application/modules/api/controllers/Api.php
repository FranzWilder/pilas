<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Api extends MX_Controller
{
    public $cview = "proyectos";
    public $controller = "proyectos";
    public $template = 'templates/admin_config';
    public $data = [
        "nombre" => "",
        "codigo" => "",
        "pilas_llenas" => "",
        "pilas_vacias" => "",
        "idUsuario" => ""
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tbl_usuario', 'obj_usuario');
        $this->load->model('Tbl_reportes', 'obj_reportes');

        $this->load->model('Tbl_proyecto', 'obj_model');


        date_default_timezone_set("America/Lima");
    }

    public function index()
    {
        echo "hola";
    }

    public function mapa($idProyecto)
    {

        $this->session->set_userdata("idProyecto", $idProyecto);
        /*$rutaArchivo = "static/personal/1/1.xlsx";
    
        $documento = IOFactory::load($rutaArchivo);
      

        $totalDeHojas = $documento->getSheetCount();

        $hojaActual = $documento->getSheet(0);
        $array_coordenadas = array();

        for($i=1;$i<5;$i++){
            $x = $hojaActual->getCellByColumnAndRow( 1,$i)->getValue();
            $y = $hojaActual->getCellByColumnAndRow( 2,$i)->getValue();
            $array_coordenadas[] = [$x,$y];
        }
        */

        $array_coordenadas = $this->obj_model->get_all_coordenas($idProyecto);


        $this->tmp_admin->set("array_coordenadas", $array_coordenadas);


        $proyecto = $this->obj_model->get_id($idProyecto);
        $coordenas = $this->obj_model->get_all_coordenas($idProyecto);

        $this->tmp_admin->set("proyecto", $proyecto);
        $this->tmp_admin->set("coordenas", $coordenas);
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview . '/mapa.php');
    }

    public function subir()
    {

        $idUsuario = $this->session->userdata("id");
        $nombreProyecto = $this->input->post("nombreProyecto");

        $data["nombre"] = $nombreProyecto;
        $idProyecto = $this->obj_model->insert($data);


        $carpeta = "static/images/proyectos/" . $idUsuario . "/excel";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }


        $config['upload_path']          = $carpeta . "/";
        $config['allowed_types']        = 'xlsx';
        $config['max_size']             = 50000;
        $config['max_width']            = 5048;
        $config['max_height']           = 5068;
        $config['file_name']           = $idUsuario;
        $config['overwrite']           = TRUE;

        $this->load->library('upload', $config);

        //cargar archivo
        if (!$this->upload->do_upload('imagen')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            redirect("admin");
        } else {
            $result = array('upload_data' => $this->upload->data());

            $rutaArchivo = "static/images/proyectos/" . $idUsuario . "/excel/" . $idUsuario . ".xlsx";

            $documento = IOFactory::load($rutaArchivo);


            $totalDeHojas = $documento->getSheetCount();

            $hojaActual = $documento->getSheet(0);
            $array_coordenadas = array();

            for ($i = 2; $i < 5000; $i++) {
                $x = $hojaActual->getCellByColumnAndRow(3, $i)->getValue();
                $y = $hojaActual->getCellByColumnAndRow(4, $i)->getValue();
                $data = array();
                $data["idProyecto"] = $idProyecto;
                $data["x"] = $x;
                $data["y"] = $y;
                print_r($data);
                $this->obj_model->insert_coordenadas($data);
            }
            redirect("admin");
        }
    }


    public function agregar()
    {
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('apellidoPaterno', 'Apellido Paterno', 'trim|required');
        $this->form_validation->set_rules('apellidoMaterno', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');

        if ($this->form_validation->run($this) == FALSE) {
            $tipoDocumentos = $this->obj_tipoDocumentos->get_all();


            $this->tmp_admin->set("tipoDocumentos", $tipoDocumentos);
            $this->tmp_admin->set("controller", $this->controller);
            $this->load->tmp_admin->setLayout($this->template);
            $this->load->tmp_admin->render($this->cview . '/agregar_view.php');
        } else {
            $data = $this->upPost($this->data);
            $data["nombresCompletos"] = $this->input->post("apellidoPaterno") . " " . $this->input->post("apellidoMaterno") . " " . $this->input->post("nombres");
            $data["fechaRegistro"] = date("Y-m-d H:i:s");

            $this->obj_model->insert($data);
            redirect("admin/" . $this->controller);
        }
    }

    public function agregarUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));


        $data["nombres"] = $jsdata->nombres;
        $data["apellidos"] = $jsdata->apellidos;
        $data["email"] = $jsdata->email;
        $data["contrasena"] = md5(helper_get_semilla() . $jsdata->contrasena);


        $this->obj_usuario->insert($data);

        echo json_encode(array("respuesta" => "1"));
    }

    public function asignarUsuarios($idProyecto)
    {
        if ($_POST) {
            $data["asignados"] = implode(",", $_POST["asignados"]);
            $this->obj_model->update($data, $idProyecto);
            redirect("api/mapaProyecto/" . $idProyecto);
        }
    }

    public function validarUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;
        $data["contrasena"] = $jsdata->contrasena;


        $usuario = $this->obj_usuario->validar_usuario($data["email"], $data["contrasena"]);



        if ($usuario) {
            $usuario->imagen = base_url() . "static/images/usuarios/" . $usuario->id . "/" . $usuario->imagen;
            echo json_encode(array("respuesta" => "1", "usuario" => $usuario));
        } else {
            echo json_encode(array("respuesta" => "0"));
        }
    }

    public function editarUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;

        $usuario = $this->obj_usuario->get_campo("email", $data["email"]);

        $id = $usuario->id;


        $data["nombres"] = $jsdata->nombres;
        $data["apellidos"] = $jsdata->apellidos;
        $data["contrasena"] = md5(helper_get_semilla() . $usuario->contrasena);

        $this->obj_usuario->update($data, $id);
        echo json_encode(array("respuesta" => "1"));
    }

    public function eliminarUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;

        $usuario = $this->obj_usuario->get_campo("email", $data["email"]);

        $id = $usuario->id;

        $data = [
            "idEstado" => "0"
        ];
        $this->obj_usuario->update($data, $id);
        echo json_encode(array("respuesta" => "1"));
    }

    public function proyectosDeUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;

        $usuario = $this->obj_usuario->get_campo("email", $data["email"]);

        $id = $usuario->id;

        $proyectos = $this->obj_model->get_all();
        $array_proyectos = array();
        $cont = 0;



        $proyectos_todos = array();

        foreach ($proyectos as $key => $value) {
            $asignados = explode(",", $value->asignados);

            if ($value->idUsuario == $id || in_array($id, $asignados)) {
                $proyectos_todos[] = $value;
            }
        }



        $proyectos = $proyectos_todos;

        //estado proyecto
        foreach ($proyectos as $key => $value) {
            $nume = $this->obj_model->get_curso_proyecto($value->id);

            if (count($nume) > 0) {
                $value->curso = 1;
                $value->estadoProyecto = "En curso";
                $value->colorProyecto = "#ffff00";
                $value->circulo = "static/images/circuloamarillo.png";
            } else {
                $value->curso = 3;
                $value->estadoProyecto = "Completado";
                $value->colorProyecto = "#b1ff00";
                $value->circulo = "static/images/circuloverde.png";
            }
        }

        foreach ($proyectos as $key => $value) {
            if ($value->imagen == "static/images/1/") {
                $value->imagen = "static/images/perfil.png";
            }
        }

        echo json_encode(array("respuesta" => "1", "proyectos" => $proyectos));
    }

    public function mapaProyecto($idProyecto)
    {


        $this->session->set_userdata("idProyecto", $idProyecto);

        $array_coordenadas = $this->obj_model->get_all_coordenas($idProyecto);


        $this->tmp_admin->set("array_coordenadas", $array_coordenadas);

        $proyecto = $this->obj_model->get_id($idProyecto);
        $coordenas = $this->obj_model->get_all_coordenas($idProyecto);


        $asignados = array();

        if ($proyecto->asignados != "") {
            $asignados = explode(",", $proyecto->asignados);
        }

        $usuarios = $this->obj_usuario->get_all();

        $this->tmp_admin->set("idProyecto", $idProyecto);
        $this->tmp_admin->set("idUsuario", $this->session->userdata("id"));
        $this->tmp_admin->set("usuarios", $usuarios);
        $this->tmp_admin->set("proyecto", $proyecto);
        $this->tmp_admin->set("asignados", $asignados);
        $this->tmp_admin->set("coordenas", $coordenas);
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render('mapa.php');
    }

    public function pdf($idReportes)
    {
        try{
            $reporte = $this->obj_reportes->get_id($idReportes);
            $proyecto = $this->obj_model->get_id($reporte->idProyecto);
            $usuario = $this->obj_usuario->get_usuario($reporte->idUsuario);
    
            ini_set('memory_limit', '-1');
            $array_coordenadas = $this->obj_reportes->get_all_coordenas($idReportes);
            $data["array_coordenadas"] = $array_coordenadas;
            $data["reporte"] = $reporte;
            $data["proyecto"] = $proyecto;
            $data["usuario"] = $usuario;
  
 
            $html = $this->load->view('pdf', $data, TRUE);
            // Cargamos la librería
            $this->load->library('pdfgenerator'); // definamos un nombre para el archivo. No es necesario agregar la extension .pdf
            $filename = 'pdf'; // generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
            $this->pdfgenerator->generate($html, $filename, true, 'a0', 'landscape');
        }catch(Exception $e){
            echo 'No se pudo exportar a PDF';
        }
        
    }

    public function mapaReporte($idReporte)
    {
        $reporte = $this->obj_reportes->get_id($idReporte);


        $proyecto = $this->obj_model->get_id($reporte->idProyecto);
        $idUsuario = $proyecto->idUsuario;

        $usuario = $this->obj_usuario->get_usuario($idUsuario);


        $this->tmp_admin->set("controller", $this->controller);
        $this->tmp_admin->set("reporte", $reporte);
        $this->tmp_admin->set("proyecto", $proyecto);
        $this->tmp_admin->set("usuario", $usuario);
        $this->tmp_admin->set("model", $this->obj_model->get_all());
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render('reporte.php');
    }

    public function ajaxTraeReporte()
    {
        $idReportes = $this->input->post("idReportes");
        $array_coordenadas = $this->obj_reportes->get_all_coordenas($idReportes);

        echo json_encode(array("respuesta" => $array_coordenadas));
    }

    public function getParametros()
    {
        $id = $this->input->post("id");
        $parametros = $this->obj_model->get_parametros_id($id);


        echo json_encode(array("respuesta" => 1, "parametros" => $parametros));
    }

    public function reportesDeUsuario()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;

        $usuario = $this->obj_usuario->get_campo("email", $data["email"]);

        $id = $usuario->id;

        $reportes = $this->obj_reportes->get_all_x_usuario($id);

        foreach ($reportes as $key => $value) {
            if ($value->idEstado == "1") {
                $value->descripcionEstado = "Completado";
                $value->estadoColor = "green";
            } else {
                $value->descripcionEstado = "En curso";
                $value->estadoColor = "yellow";
            }
        }

        echo json_encode(array("respuesta" => "1", "reportes" => $reportes));
    }

    public function agregarProyecto()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["email"] = $jsdata->email;

        $usuario = $this->obj_usuario->get_campo("email", $data["email"]);

        $id = $usuario->id;

        $data = array();
        $data["nombre"] = $jsdata->nombre;
        $data["codigo"] = $jsdata->codigo;
        $data["idUsuario"] = $id;


        $idProyecto = $this->obj_model->insert($data);


        echo json_encode(array("respuesta" => "1"));
    }

    public function eliminarProyecto()
    {
        header("Access-Control-Allow-Origin: *");

        $jsdata = json_decode(file_get_contents('php://input'));

        $data["codigo"] = $jsdata->codigo;

        $proyecto = $this->obj_model->get_campo("codigo", $data["codigo"]);


        $id = $proyecto->id;

        $data = [
            "idEstado" => "0"
        ];
        $this->obj_model->update($data, $id);


        echo json_encode(array("respuesta" => "1"));
    }

    public function ajaxGuardarPilas()
    {


        $data["id"] = $this->input->post("id");
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

        for ($i = 1; $i < 52; $i++) {
            if ($data["a" . $i] == "") {
                $lleno = false;
            }
            if ($data["a" . $i] != "") {
                $vacio = false;
            }
        }

        if ($vacio) {
            $data["estadoPila"] = 1;
        } else if ($lleno) {
            $data["estadoPila"] = 3;
        } else {
            $data["estadoPila"] = 2;
        }

        $this->obj_model->update_coordenadas($data, $data["id"]);

        echo json_encode(array("respuesta" => 1, "pilas" => $data["pilasavanzado"]));
    }

    public function ajaxGuardarReporte(){ 

        $idUsuario  = $this->input->post("idUsuario");
        $idProyecto  = $this->input->post("idProyecto");
      
        //agregando reporte
        $reporte = array();
        $reporte["idProyecto"] = $idProyecto;
        $reporte["idUsuario"] = $idUsuario;
     
        $idReporte = $this->obj_reportes->insert($reporte);

        //guardando puntos de reportes
        $coordendas = $this->obj_model->get_all_coordenas($idProyecto);
       
        $data = array();
        for($i=0;$i<count($coordendas);$i++){
            $punto = array();
            $punto["idProyecto"] = $coordendas[$i]->idProyecto;
            $punto["idReportes"] = $idReporte;
            $punto["idUsuario"] = $idUsuario;
            $punto["num"] = $coordendas[$i]->num;
            $punto["x"] = $coordendas[$i]->x;
            $punto["y"] = $coordendas[$i]->y;
            $punto["radio"] = $coordendas[$i]->radio;
            $punto["pilastotal"] = $coordendas[$i]->pilastotal;
            $punto["pilasavanzado"] = $coordendas[$i]->pilasavanzado;
            $punto["estadoPila"] = $coordendas[$i]->estadoPila;
            

            array_push($data,$punto);
        }    

        echo json_encode(array("respuesta"=>$this->obj_reportes->insert_batch($data)));
        
    }

    public function eliminar($id)
    {
        $data = [
            "activo" => "0"
        ];
        $this->obj_model->update($data, $id);
        echo json_encode(array("respuesta"=>1));
    }



    public function upPost($data)
    {
        $data = $this->data;

        foreach ($data as $key => $value)
            if ($this->input->post($key) != "")
                $data[$key] = $this->input->post($key);

        return $data;
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
