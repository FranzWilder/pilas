<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends MX_Controller
{
    public $cview = "reportes";
    public $template = 'templates/admin_config';
    public $controller = "reportes";
    public $data = [
        "descripcion" => "",
        "idEstados" => "1"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tbl_usuario', 'obj_usuario');


        $this->load->model('Tbl_reportes', 'obj_model');
        $this->load->model('Tbl_proyecto', 'obj_proyecto');

        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }

        date_default_timezone_set("America/Lima");
    }

    public function index()
    {



        $this->tmp_admin->set("controller", $this->controller);
        $this->tmp_admin->set("model", $this->obj_model->get_all());
        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview . '/view.php');
    }

    public function pdf($idReportes)
    {
        try{
            $reporte = $this->obj_model->get_id($idReportes);
            $proyecto = $this->obj_proyecto->get_id($reporte->idProyecto);
            $usuario = $this->obj_usuario->get_usuario($reporte->idUsuario);
    
            ini_set('memory_limit', '-1');
            $array_coordenadas = $this->obj_model->get_all_coordenas($idReportes);
            $data["array_coordenadas"] = $array_coordenadas;
            $data["reporte"] = $reporte;
            $data["proyecto"] = $proyecto;
            $data["usuario"] = $usuario;
  

            $html = $this->load->view('reportes/pdf', $data, TRUE);
            // Cargamos la librería
            $this->load->library('pdfgenerator'); // definamos un nombre para el archivo. No es necesario agregar la extension .pdf
            $filename = 'pdf'; // generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
            $this->pdfgenerator->generate($html, $filename, true, 'a0', 'landscape');
        }catch(Exception $e){
            echo 'No se pudo exportar a PDF';
        }
        
    }

    public function pdf2($idReportes)
    {
        $reporte = $this->obj_model->get_id($idReportes);
        $proyecto = $this->obj_proyecto->get_id($reporte->idProyecto);
        $usuario = $this->obj_usuario->get_usuario($reporte->idUsuario);

        ini_set('memory_limit', '-1');
        $array_coordenadas = $this->obj_model->get_all_coordenas($idReportes);
        $data["array_coordenadas"] = $array_coordenadas;
        $data["reporte"] = $reporte;
        $data["proyecto"] = $proyecto;
        $data["usuario"] = $usuario;

        $this->load->view('reportes/pdf', $data);
      
    }

    public function mapa($idReportes)
    {
        $this->session->set_userdata("idProyecto", $idReportes);

        $array_coordenadas = $this->obj_model->get_all_coordenas($idReportes);


        $this->tmp_admin->set("array_coordenadas", $array_coordenadas);

        $proyecto = $this->obj_model->get_id($idReportes);
        $coordenas = $this->obj_model->get_all_coordenas($idReportes);


        $asignados = array();

        if ($proyecto->asignados != "") {
            $asignados = explode(",", $proyecto->asignados);
        }

        $usuarios = $this->obj_usuario->get_all();


        $this->tmp_admin->set("idUsuario", $this->session->userdata("id"));
        $this->tmp_admin->set("usuarios", $usuarios);
        $this->tmp_admin->set("proyecto", $proyecto);
        $this->tmp_admin->set("asignados", $asignados);
        $this->tmp_admin->set("coordenas", $coordenas);


        $array_coordenadas = $this->obj_reportes->get_all_coordenas($idReportes);

        $this->tmp_admin->set("array_coordenadas", $array_coordenadas);


        $this->tmp_admin->set("idReportes", $idReportes);
        $this->tmp_admin->set("array_coordenadas", $array_coordenadas);

        $this->load->tmp_admin->setLayout($this->template);
        $this->load->tmp_admin->render($this->cview . '/mapa.php');
    }

    public function ajaxTraeReporte()
    {
        $idReportes = $this->input->post("idReportes");
        $array_coordenadas = $this->obj_model->get_all_coordenas($idReportes);

        echo json_encode(array("respuesta" => $array_coordenadas));
    }
    public function ajaxGuardarReporte()
    {
        $idUsuario  = $this->session->userdata("id");
        $idProyecto  = $this->input->post("idProyecto");

        //agregando reporte
        $reporte = array();
        $reporte["idProyecto"] = $idProyecto;
        $reporte["idUsuario"] = $idUsuario;

        $idReporte = $this->obj_model->insert($reporte);

        //guardando puntos de reportes
        $coordendas = $this->obj_proyecto->get_all_coordenas($idProyecto);

        $data = array();
        for ($i = 0; $i < count($coordendas); $i++) {
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


            array_push($data, $punto);
        }

        echo json_encode(array("respuesta" => $this->obj_model->insert_batch($data)));
    }

    public function eliminar($id)
    {
        $data = [
            "estado" => "0"
        ];
        $this->obj_model->update($data, $id);
        redirect("admin/" . $this->controller);
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
