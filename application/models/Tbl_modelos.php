<?php
class Tbl_modelos extends CI_Model{
    private $tabla = 'modelos';
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
            $this->db->from("modelos m");
            $this->db->select("m.id, m.descripcion, m.idEstados, m.idMarcas, ma.descripcion descripcion_marca");
            $this->db->join("marcas ma","ma.id=m.idMarcas");

            $this->db->where("m.idEstados", "1");
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_campo($valor,$campo){
        try {
            $this->db->where($campo, $valor);
            $this->db->where("idEstados", "1");
            $query = $this->db->get($this->tabla);
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function insert($data){
        try {
            $this->db->insert($this->tabla, $data);
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

    

} 
?>