<?php  
include_once('conexion.php');
class Proforma extends Conexion{
	private $id_proforma;
	private $cliente_proforma;
	private $fecha_proceso;
	private $fecha_alta;
	private $usuario_alta;
	private $tipo_usuario;
	private $usuario_baja;
	private $total_costo;
	private $estado;

	public function Proforma()
	{
		parent::Conexion();
		$this->id_proforma=0;
		$this->cliente_proforma="";
		$this->fecha_proceso="";
		$this->fecha_alta="";
		$this->usuario_alta=0;
		$this->tipo_usuario="";
		$this->usuario_baja=0;
		$this->total_costo=0;
		$this->estado="";
		
	}

	public function setid_proforma($valor)
	{
		$this->id_proforma=$valor;
	}
	public function getid_proforma()
	{
		return $this->id_proforma;
	}
	public function set_clienteproforma($valor)
	{
		$this->cliente_proforma=$valor;
	}
	public function get_clienteproforma()
	{
		return $this->cliente_proforma;
	}
	public function set_fecha_proceso($valor)
	{
		$this->fecha_proceso=$valor;
	}
	public function get_fecha_proceso()
	{
		return $this->fecha_proceso;
	}

	public function set_fecha_alta($valor)
	{
		$this->fecha_alta=$valor;
	}
	public function get_fecha_alta()
	{
		return $this->fecha_alta;
	}
	public function set_usuario_alta($valor)
	{
		$this->usuario_alta=$valor;
	}
	public function get_usuario_alta()
	{
		return $this->usuario_alta;
	}
	public function set_tipo_usuario($valor)
	{
		$this->tipo_usuario=$valor;
	}
	public function get_tipo_usuario()
	{
		return $this->tipo_usuario;
	}
	public function set_usuario_baja($valor)
	{
		$this->usuario_baja=$valor;
	}
	public function get_usuario_baja()
	{
		return $this->usuario_baja;
	}
	public function set_total_costo($valor)
	{
		$this->total_costo=$valor;
	}
	public function get_total_costo()
	{
		return $this->total_costo;
	}

	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}



	public function guardarProforma()
	{
		$sql="INSERT INTO tb_proforma(cliente_proforma,
		                              fecha_proceso,
									  fecha_alta,
									  usuario_alta,
									  tipo_usuario,
									  usuario_baja,
									  total_costo,
									  estado
									  ) 
						     VALUES('$this->cliente_proforma',
							        '$this->fecha_proceso',
									'$this->fecha_alta',
									'$this->usuario_alta',
									'$this->tipo_usuario',
									'$this->usuario_baja',
									'$this->total_costo',
									'$this->estado')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarProformasActivos()
	{
		$sql="SELECT id_proforma,
		             cliente_proforma,
		             fecha_proceso,
		             fecha_alta,
		             (CASE WHEN tipo_usuario='admin'
			               THEN (SELECT concat(a.nombre_administrador,' ',a.apellido_administrador) 
					               FROM tb_administrador as a
					              WHERE a.id_administrador=usuario_alta)
			               WHEN tipo_usuario='empl'
			               THEN (SELECT concat(a.nombre_empleado,' ',a.apellido_empleado) 
					               FROM tb_empleado as a
					              WHERE a.id_empleado=usuario_alta)
			         END) as usuario,
		             usuario_alta,
		             tipo_usuario,
		             usuario_baja,
		             total_costo,
		             estado
                FROM tb_proforma 
               WHERE estado='A'
            ORDER BY id_proforma ASC ";
		return parent::ejecutar($sql);
	}

    public function MostrarProformaActivos($cod)
	{
		$sql="SELECT id_proforma,
		             cliente_proforma,
		             fecha_proceso,
		             fecha_alta,
		             usuario_alta,
		             tipo_usuario,
		             usuario_baja,
		             total_costo,
		             estado
		        FROM tb_proforma 
				WHERE estado='A'
                and id_proforma=$cod ";
		return parent::ejecutar($sql);
	}

    public function mostrarultimaproformausuario($codusuario)
    {
        $sql="SELECT MAX(id_proforma) as id_proforma
                FROM tb_proforma
               WHERE usuario_alta=$codusuario";
            return parent::ejecutar($sql);
    }

	public function DarBajaProforma()
	{
		$sql="UPDATE tb_proforma 
		         SET estado='$this->estado',
				     usuario_baja= '$this->usuario_baja'
			   where id_proforma='$this->id_proforma'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	
	

	

	

}
?>