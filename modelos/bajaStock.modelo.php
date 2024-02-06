 <?php  
include_once('conexion.php');
class Baja_stock extends Conexion{
	private $id_baja_stock ;
	private $id_compra ;
	private $cantidad_baja ;
	private $id_producto_baja ;
	private $monto_reducido ;
	private $fecha_baja_stock ;
	private $usuario_alta  ;
	private $estado;

	public function Baja_stock()
	{
		parent::Conexion();
		$this->id_baja_stock =0;
		$this->id_compra =0;
		$this->cantidad_baja =0;
		$this->id_producto_baja =0;
		$this->monto_reducido =0;
		$this->fecha_baja_stock ="";
		$this->usuario_alta =0;
		$this->estado="";

	}

	public function setid_baja_stock($valor)
	{
		$this->id_baja_stock=$valor;
	}
	public function getid_baja_stock()
	{
		return $this->id_baja_stock;
	}
	public function setid_compra($valor)
	{
		$this->id_compra=$valor;
	}
	public function getid_compra()
	{
		return $this->id_compra;
	}
	public function set_cantidadBaja($valor)
	{
		$this->cantidad_baja=$valor;
	}
	public function get_cantidadBaja()
	{
		return $this->cantidad_baja;
	}

	public function setid_productoBaja($valor)
	{
		$this->id_producto_baja=$valor;
	}
	public function getid_productoBaja()
	{
		return $this->id_producto_baja;
	}

	public function set_montoReducido($valor)
	{
		$this->monto_reducido=$valor;
	}
	public function get_montoReducido()
	{
		return $this->monto_reducido;
	}
	public function set_fechaBajaStock($valor)
	{
		$this->fecha_baja_stock=$valor;
	}
	public function get_fechaBajaStock()
	{
		return $this->fecha_baja_stock;
	}
	public function set_usuarioAlta($valor)
	{
		$this->usuario_alta=$valor;
	}
	public function get_usuarioAlta()
	{
		return $this->usuario_alta;
	}
	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}
	


	public function guardarBajaStock()
	{
		$sql="INSERT INTO tb_baja_sctok(id_compra ,
			                            cantidad_baja ,
			                            id_producto_baja ,
			                            monto_reducido ,
			                            fecha_baja_stock ,
			                            usuario_alta,
			                            estado ) 
		                        VALUES('$this->id_compra',
		                        	   '$this->cantidad_baja',
		                        	   '$this->id_producto_baja',
		                        	   '$this->monto_reducido',
		                        	   '$this->fecha_baja_stock',
		                        	   '$this->usuario_alta',
		                        	   '$this->estado')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarBajasStock()
	{
		$sql="SELECT id_baja_stock, 
		             id_compra, 
		             id_producto_baja, 
		             monto_reducido, 
		             fecha_baja_stock, 
		             usuario_alta 
		        FROM tb_baja_sctok 
		        WHERE estado='Activo'";
		return parent::ejecutar($sql);
	}

}
?>