<?php
class Tbl_piezas extends CI_Model{
    private $tabla = 'piezas';
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

    public function get_campo($campo,$valor){
        try {
            
            $this->db->where($campo,$valor);
            $this->db->where("idEstados","1");

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

    public function update_cantidad($id,$cantidad,$aumenta ="1"){
        try {
            if($aumenta=="1"){
                $this->db->set("stock","stock+".$cantidad,FALSE);
            }else{
                $this->db->set("stock","stock-".$cantidad,FALSE);
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