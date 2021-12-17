<?php

class Tbl_vehiculos extends CI_Model{
    private $tabla = 'vehiculos';
    private $id = 'id';


    public function __construct() {
        parent::__construct();        
    }
    
    public function get_id($id){
        try {
            $this->db->select("v.id,v.placa,v.motor,v.anio,v.serie,v.imagen,v.fechaRegistro, ma.descripcion descripcion_marcas,mo.descripcion descripcion_modelos,c.nombresCompletos,v.idClientes,v.idMarcas,v.idModelos");
            $this->db->from("vehiculos v");
            $this->db->join("clientes c","c.id=v.idClientes");
            $this->db->join("marcas ma","ma.id=v.idMarcas");
            $this->db->join("modelos mo","mo.id=v.idModelos");
            $this->db->where("v.id",$id);

            $query = $this->db->get();
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_campo($campo,$valor){
        try {
            $this->db->select("v.id,v.placa,v.motor,v.anio,v.serie,v.imagen,v.fechaRegistro, ma.descripcion descripcion_marcas,mo.descripcion descripcion_modelos,c.nombresCompletos,v.idClientes,v.idMarcas,v.idModelos");
            $this->db->from("vehiculos v");
            $this->db->join("clientes c","c.id=v.idClientes");
            $this->db->join("marcas ma","ma.id=v.idMarcas");
            $this->db->join("modelos mo","mo.id=v.idModelos");
            $this->db->where("v.".$campo,$valor);

            $query = $this->db->get();
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_all(){
        try {
            $this->db->select("v.id,v.placa,v.motor,v.anio,v.serie,v.imagen,v.fechaRegistro, ma.descripcion descripcion_marcas,mo.descripcion descripcion_modelos,c.nombresCompletos");
            $this->db->from("vehiculos v");
            $this->db->join("clientes c","c.id=v.idClientes");
            $this->db->join("marcas ma","ma.id=v.idMarcas");
            $this->db->join("modelos mo","mo.id=v.idModelos");

            $this->db->order_by("v.fechaRegistro", "desc");
            $this->db->where("v.idEstados", "1");
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