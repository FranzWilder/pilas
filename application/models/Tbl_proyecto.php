<?php
class Tbl_proyecto extends CI_Model{
    private $tabla = 'proyecto';
    private $id = 'id';


    public function __construct() {
        parent::__construct();        
    }
    
    public function get_id($id){
        try {
            $this->db->where($this->id,$id);
            
            $query = $this->db->get($this->tabla);
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_all(){
        try {
            $this->db->from("proyecto p");
            $this->db->select("p.id,p.nombre,p.idEstado,p.codigo,p.pilas_llenas,p.pilas_vacias,p.asignados,p.idUsuario,p.fechaRegistro,u.nombres nombresSupervisor,u.apellidos apellidosSupervisor, CONCAT('static/images/',u.id,'/',u.imagen) imagen");
            $this->db->where("p.activo","1");
            $this->db->join("usuario u","p.idSupervisor=u.id");
            $this->db->order_by('p.id', 'DESC');

            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_all_x_usuario($idUsuario){
        try {
            $this->db->from("usuario u");
            $this->db->select("p.id idProyecto,p.nombre nombreProyecto, p.codigo codigoProyecto,u.nombres nombresUsuario, u.apellidos apellidosUsuario, u.cargo cargoUsuario, u.email emailUsuario, CONCAT('static/images/',u.id,'/',u.imagen) imagen",false);

            $this->db->join("proyecto p","p.idUsuario=u.id");
            $this->db->where("p.idUsuario",$idUsuario);
            

            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    
    public function get_all_coordenas($idProyecto){
        $this->db->where("idProyecto",$idProyecto);
        $query = $this->db->get("proyecto_coordenadas");
        return $query->result();
    }

    public function get_parametros_id($id){
        $this->db->where("id",$id);
        $query = $this->db->get("proyecto_coordenadas");
        return $query->row();
    }

    public function get_curso_proyecto($id){
        $this->db->where("idProyecto",$id);
        $this->db->where("estadoPila!=","3");
        $query = $this->db->get("proyecto_coordenadas");
        return $query->result();
    }

    public function insert($data){
        try {
            $this->db->insert($this->tabla, $data);
            return $this->db->insert_id();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    public function insert_coordenadas($data){
        try {
            $this->db->insert("proyecto_coordenadas", $data);
            
        } catch (Exception $exc) {
            return FALSE;   
        }
    }


    public function update($data,$id){
        try {
            $this->db->where($this->id, $id);
            $this->db->update($this->tabla, $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    
    public function get_campo($campo,$dato){
        try {
            $this->db->where($campo,$dato);

            $query = $this->db->get($this->tabla);
            
            return $query->row();
        } catch (Exception $exc) {
            return FALSE; 
        }
    }
    
    public function update_coordenadas($data,$id){
        try {
            $this->db->where("id", $id);
          
            $this->db->update("proyecto_coordenadas", $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
} 


?>