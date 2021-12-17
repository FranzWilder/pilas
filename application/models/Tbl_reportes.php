<?php

class Tbl_reportes extends CI_Model{
    private $tabla = 'reportes';
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
            $this->db->from("reportes r");
            $this->db->select("r.*,r.codigo codigoReporte,r.fechaRegistro fechaReporte,p.nombre nombreProyecto, u.nombres nombreUsuario,u.apellidos apellidosUsuario");
            $this->db->join("proyecto p","p.id = r.idProyecto");
            $this->db->join("usuario u","u.id = r.idUsuario");
            $this->db->where("r.estado", "1");
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_all_coordenas($idReportes){
        $this->db->where("idReportes",$idReportes);
        $this->db->where("estado","1");
        $query = $this->db->get("reporte_coordenadas");
        return $query->result();
    }

    public function get_all_x_usuario($idReportes){
        $this->db->from("reportes r");
        $this->db->select("r.id idReporte,p.nombre, p.codigo, r.idEstado");
        $this->db->join("proyecto p","p.id = r.idProyecto");

        $this->db->where("r.estado","1");
        $query = $this->db->get();
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

    public function insert_batch($data){
        try {
            $this->db->insert_batch('reporte_coordenadas', $data); 
            return $this->db->insert_id();
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

    
    public function update_reporte($data,$idReportes){
        try {
            $this->db->where("idReportes", $idReportes);
            $this->db->update('reporte_coordenadas', $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
} 
?>