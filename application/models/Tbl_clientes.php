<?php
class Tbl_clientes extends CI_Model{
    private $tabla = 'clientes';
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

    public function get_pagos_id($id){
        try {
            $this->db->from("pagoClientes pg");
            $this->db->select("pg.id, pg.monto,c.id idClientes, c.nombresCompletos, pg.fechaPago");
            $this->db->join("clientes c","c.id=pg.idClientes");

            $this->db->where("c.id",$id);
            $this->db->where("pg.idEstados", "1");
            $this->db->order_by("pg.fechaRegistro", "desc");
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_all(){
        try {

            $this->db->from("clientes c");
            $this->db->select("c.id, c.nombres, c.apellidoPaterno, c.apellidoMaterno, c.nombresCompletos, c.idTipoDocumentos, c.documento, c.direccion, c.correo, c.saldo, c.idEstados, c.fechaRegistro, t.descripcion descripcion_tipoDocumentos");

            $this->db->join("tipoDocumentos t","t.id=c.idTipoDocumentos");
            $this->db->where("c.idEstados", "1");   


            $query = $this->db->get();
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

    public function insert_pago($data){
        try {
            $this->db->insert("pagoClientes", $data);
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

    public function update_pago($data,$id){
        try {
            $this->db->where($this->id, $id);
            $this->db->update("pagoClientes", $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function update_saldo($id,$monto,$aumenta ="1"){
        try {
            if($aumenta=="1"){
                $this->db->set("saldo","saldo+".$monto,FALSE);
            }else{
                $this->db->set("saldo","saldo-".$monto,FALSE);
            }
            $this->db->where($this->id, $id);
            $this->db->update($this->tabla);
            return $this->db->last_query();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

} 
?>