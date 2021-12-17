<?php 

	if ( ! function_exists('helper_get_semilla')){
	    function helper_get_semilla(){
	        return '983h4g983g98';
	    }

	    function helper_btn_enviar_salir($url){
	        echo "<button type='submit' class='btn btn-success'>Enviar</button> <a class='btn btn-danger' href='".$url."'>Cancelar</a>";
	    }
	}

	if ( ! function_exists('helper_form_text')){
	    function helper_form_text($id,$texto,$valor="",$tipo="text",$size1="4",$size2="8"){
				$step="";
				if($tipo=="number")
					$step = "step='.01'";
			echo "
			<div class='form-group row'>
				<label for='".$id."' class='col-sm-".$size1." col-form-label'>".$texto."</label>
				<div class='col-sm-".$size2."'>
					<input type='".$tipo."' ".$step." name='".$id."' class='form-control' id='".$id."' value='".$valor."'>".form_error($id, '<div class="text-danger">', '</div>')."
				</div>
			</div>
			";
	    }
	}

	if ( ! function_exists('helper_form_textarea')){
	    function helper_form_textarea($id,$texto,$valor="",$size1="4",$size2="8",$cols="4",$rows="8"){
			echo "
			<div class='form-group row'>
				<label for='".$id."' class='col-sm-".$size1." col-form-label'>".$texto."</label>
				<div class='col-sm-".$size2."'>
					<textarea rows='".$rows."' rows='".$cols."' name='".$id."' class='form-control' id='".$id."'>".$valor."</textarea>".form_error($id, '<div class="text-danger">', '</div>')."
				</div>
			</div>
			";
	    }
	} 

	if ( ! function_exists('helper_form_select')){
	    function helper_form_select($id,$texto,$data,$descripcion="descripcion",$ide="",$size1="4",$size2="8"){
			$options = "<option value=''>Elegir...</option>";
			foreach ($data as $key => $value) {
				$selected = ($ide==$value->id)?"selected":"";
				//echo $ide. "  - ".$value->id;
				$options.="<option ".set_select($id, $value->id)." ".$selected." value='".$value->id."'>".$value->$descripcion."</option>";
			}

			echo "
			<div class='form-group row'>
				<label for='".$id."' class='col-sm-".$size1." col-form-label'>".$texto."</label>
				<div class='col-sm-".$size2."'>
					<select class='form-control' name='".$id."' id='".$id."'>
						".$options."
					</select>".form_error($id, '<div class="text-danger">', '</div>')."
				</div>
			</div>
			";
	    }
	}

?>