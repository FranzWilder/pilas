<?php
class Tbl_compras extends CI_Model{
    private $tabla = 'compras';
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
            $this->db->where("idEstados", "1");
            $this->db->order_by("fechaRegistro", "desc");
            $query = $this->db->get($this->tabla);
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_repuestos_idCompras($idCompras){
        try {
            $this->db->from("comprasRepuestos c");
            $this->db->select("c.id, c.idPiezas, c.cantidad, c.costo, r.descripcion");
            $this->db->join("piezas r","r.id=c.idPiezas");

            $this->db->where("idCompras", $idCompras);
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function insert($data){
        try {
            $this->db->insert($this->tabla, $data);
            return $this->db->insert_id();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function insert_batch_cr($data){
        try {
            $this->db->insert_batch("comprasRepuestos", $data);
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