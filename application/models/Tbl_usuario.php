<?php

class Tbl_usuario extends CI_Model{
    private $tabla = 'usuario';
    private $contrasena = 'contrasena';
    private $usuario = 'usuario';
    private $email = 'email';



    public function __construct() {
        parent::__construct();        
    }
    
    public function get_usuario($id){
        try {
            $this->db->where('id',$id);

            $query = $this->db->get($this->tabla);
            return $query->row();
        } catch (Exception $exc) {
            return FALSE; 
        }
    }
    
    public function get_all(){
        try {
          
            $this->db->where('idEstado','1');

            $query = $this->db->get($this->tabla);
            return $query->result();
        } catch (Exception $exc) {
            return FALSE; 
        }
    }

    public function validar_usuario($email,$contrasena){
        try { 
            $this->db->where($this->email,$email);
            $this->db->where($this->contrasena,md5(helper_get_semilla().$contrasena));

            $query = $this->db->get($this->tabla);

            if($query->num_rows() > 0){
         
                $this->session->set_userdata('logged','true');
                $row = $query->row_array();
                $this->session->set_userdata($row);
            
            }
            return $query->row();
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
            $this->db->where("id", $id);
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
    
    
    
} 
?>