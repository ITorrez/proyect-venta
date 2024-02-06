<?php  
include_once('conexion.php');
class Item_Proforma extends Conexion{
	private $id_item_proforma;
	private $id_proforma;
	private $cantidad;
	private $producto;
	private $costo_unitario;
	private $subtotal;
	
	public function Item_Proforma()
	{
		parent::Conexion();
		$this->id_item_proforma=0;
		$this->id_proforma="";
		$this->cantidad="";
		$this->producto="";
		$this->costo_unitario=0;
		$this->subtotal=0;	
	}

	public function setid_item_proforma($valor)
	{
		$this->id_item_proforma=$valor;
	}
	public function getid_item_proforma()
	{
		return $this->id_item_proforma;
	}

	public function setid_proforma($valor)
	{
		$this->id_proforma=$valor;
	}
	public function getid_proforma()
	{
		return $this->id_proforma;
	}
	public function set_cantidad($valor)
	{
		$this->cantidad=$valor;
	}
	public function get_cantidad()
	{
		return $this->cantidad;
	}
	public function set_producto($valor)
	{
		$this->producto=$valor;
	}
	public function get_producto()
	{
		return $this->producto;
	}

	public function set_costo_unitario($valor)
	{
		$this->costo_unitario=$valor;
	}
	public function get_costo_unitario()
	{
		return $this->costo_unitario;
	}
	public function set_subtotal($valor)
	{
		$this->subtotal=$valor;
	}
	public function get_subtotal()
	{
		return $this->subtotal;
	}
	
	public function guardarItemProforma()
	{
		$sql="INSERT INTO tb_item_proforma(id_proforma,
		                                   cantidad,
									       producto,
									       costo_unitario,
									       subtotal
									     ) 
						     VALUES('$this->id_proforma',
							        '$this->cantidad',
									'$this->producto',
									'$this->costo_unitario',
									'$this->subtotal')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarItemProformasActivosDeProforma($codproforma)
	{
		$sql="SELECT id_item_proforma,
		             id_proforma,
		             cantidad,
		             producto,
		             costo_unitario,
		             subtotal
		        FROM tb_item_proforma 
				WHERE id_proforma=$codproforma ";
		return parent::ejecutar($sql);
	}

	
	

	
	

	

	

}
?>