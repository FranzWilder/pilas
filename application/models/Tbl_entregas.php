<?php
class Tbl_entregas extends CI_Model{
    private $tabla = 'entregas';
    private $id = 'id';


    public function __construct() {
        parent::__construct();        
    }
    
    public function get_id($id){
        try {
            $this->db->from("entregas e");
            $this->db->select("e.id, c.id idClientes,e.kilometraje, e.observaciones, e.idVehiculos,e.fechaRegistro,e.fechaServicio,e.idEstados,v.placa,c.nombresCompletos nombresClientes");
            $this->db->join("vehiculos v","v.id=e.idVehiculos");
            $this->db->join("clientes c","c.id=v.idClientes");



            $this->db->where("e.idEstados", "1");
            $this->db->where("e.id",$id);
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function getIdImagenes($idImagenServicios){
        try {
            $this->db->where("id",$idImagenServicios);

            $query = $this->db->get("imagenEntregas");
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function getIdImagenesEntregas($idEntregas){
        try {
            $this->db->where("idEntregas",$idEntregas);

            $query = $this->db->get("entregaImagen");
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function getImagenes($valor,$campo="idEntregaServicios"){
        try {
            $this->db->where($campo, $valor);
            $this->db->where("idEstados", "1");
            $query = $this->db->get("imagenEntregas");
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_idEntregasServicios($idEntregasServicios){
        try {
            
            $this->db->where("id",$idEntregasServicios);
            $query = $this->db->get("entregaServicios");
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_idServicioRepuestos($idServicioRepuestos){
        try {
            
            $this->db->where("id",$idServicioRepuestos);
            $query = $this->db->get("servicioRepuestos");
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }


    public function getRepuestos_ES($idEntregasServicios){
        try {
            $this->db->from("servicioRepuestos sR");
            $this->db->select("sR.id,sR.monto, sR.idEntregaServicios, sR.idPiezas, sR.cantidad,sR.factura, sR.monto, r.descripcion");

            $this->db->join("piezas r","sR.idPiezas=r.id");
            $this->db->where("sR.idEstados", "1");
            $this->db->where("sR.idEntregaServicios",$idEntregasServicios);
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function getServicioRepuesto_all($fechaInicio="",$fechaFin="",$factura=0){
        try {
            $this->db->from("servicioRepuestos sR");
            $this->db->select("sR.id,sR.monto,es.fechaServicio, sR.idEntregaServicios, sR.idPiezas, sR.cantidad,sR.factura, sR.monto, r.descripcion,v.placa,c.nombresCompletos");

            $this->db->join("piezas r","sR.idPiezas=r.id");
            $this->db->join("entregaServicios es","es.id=sR.idEntregaServicios");
            $this->db->join("entregas e","e.id=es.idEntregas");
            $this->db->join("vehiculos v","v.id=e.idVehiculos");
            $this->db->join("clientes c","c.id=v.idClientes");

            $this->db->where("sR.idEstados", "1");

            if($fechaInicio!=""){
                $this->db->where("es.fechaServicio >= ", $fechaInicio);
            }

            if($fechaFin!=""){
                $this->db->where("es.fechaServicio < ", $fechaFin);
            }

            $this->db->where("sR.idEstados", "1");
            $this->db->where("es.idEstados", "1");
            $this->db->where("e.idEstados", "1");
            $this->db->where("sR.factura", $factura);
            
            $this->db->order_by("es.fechaServicio", "desc");
   
            $query = $this->db->get();

            // echo $this->db->last_query();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function get_entregaServicios($idEntregas){
        $this->db->from("entregaServicios eS");
            $this->db->select("eS.id,eS.montoTotal,eS.idPersonas, eS.idServicios,eS.idEntregas, eS.monto,eS.observacionesServicio,p.nombresCompletos,s.descripcion,eS.fechaServicio");
            $this->db->join("personas p","p.id=eS.idPersonas");
            $this->db->join("servicios s","s.id=eS.idServicios");
            
            
            

            $this->db->where("eS.idEstados", "1");
            $this->db->where("eS.idEntregas",$idEntregas);
            $query = $this->db->get();
            return $query->result();
    }

    public function get_all(){
        try {
            $this->db->from("entregas e");
            $this->db->select("e.id, e.idVehiculos,e.kilometraje,e.fechaRegistro,e.fechaServicio,e.idEstados,v.placa,c.nombresCompletos nombresClientes,c.saldo");
            $this->db->join("vehiculos v","v.id=e.idVehiculos");
            $this->db->join("clientes c","c.id=v.idClientes");


            
            $this->db->where("e.idEstados", "1");
            $this->db->order_by("e.fechaServicio", "desc");
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function insert_entregaServicios($data){
        try {
            $this->db->insert("entregaServicios", $data);
            return $this->db->insert_id();

        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    
    public function insert_servicioRepuestos($data){
        try {
            $this->db->insert("servicioRepuestos", $data);
            return $this->db->insert_id();

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

    public function insert_imagen($data){
        try {
            $this->db->insert("imagenEntregas", $data);

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    public function insert_imagen_entrega($data){
        try {
            $this->db->insert("entregaImagen", $data);

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
    public function updateServicio($data,$id){
        try {
            $this->db->where($this->id, $id);
            $this->db->update("entregaServicios", $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    public function updateImagenEntregas($data,$id,$campo="id"){
        try {
            $this->db->where($campo, $id);
            $this->db->update("imagenEntregas", $data);
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function updateServicioRepuestos($data,$id){
        try {
            $this->db->where($this->id, $id);
            $this->db->update("servicioRepuestos", $data);
           // echo $this->db->last_query();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }

    public function update_monto_entregaServicio($id,$monto,$campo,$aumenta ="1"){
        try {
            if($aumenta=="1"){
                $this->db->set($campo,$campo."+".$monto,FALSE);
            }else{
                $this->db->set($campo,$campo."-".$monto,FALSE);
            }
            $this->db->where($this->id, $id);
            $this->db->update("entregaServicios");
            return $this->db->last_query();
        } catch (Exception $exc) {
            return FALSE;   
        }
    }
    

} 
?>