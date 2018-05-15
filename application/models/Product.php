<?php

class Product extends CI_Model
{ 
	private $table = "products";
	public $id;
	public $name;
	public $price;
	public $description;
	public $is_deleted;
	public $created_at;
	public $updated_at;

    public function __construct()
    {
        $this->load->database();
    }

    function __destruct() {
        $this->db->close();
    }

    public function getProductList()
    {
    	$productList = array();
    	$this->db->where('is_deleted', false);
    	$this->db->order_by('created_at');
    	$query = $this->db->get($this->table);

    	foreach ($query->result() as $row) {
    		$product = new Product();
    		$product->id = $row->id;
    		$product->name = $row->name;
    		$product->price = $row->price;
    		$product->description= $row->description;
    		$product->is_deleted= $row->is_deleted;
    		$product->created_at= $row->created_at;
    		$product->updated_at= $row->updated_at;
    		$productList[] = $product;
    	}
    	return $productList;
    }

    public function getOneProduct($productId)
    {
    	$this->db->where('id', $productId);
    	$this->db->where('is_deleted', false);
    	$this->db->order_by('created_at');
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    public function addProduct( Product $product)
    {	 
    	try {
    		$this->db->insert($this->table, $product);
    		return true;
    	} catch (Exception $e) {
    		return false;
    	} 
    }

    public function updateProduct($id, Product $product)
    {	 
    	try {
    		$this->db->where('id', $id);
    		$this->db->update($this->table, $product);
    		return true;
    	} catch (Exception $e) {
    		return false;
    	} 
    }


    public function deleteProduct($productId)
    {	 
    	try {
    		$this->db->where('id', $productId);
    		$this->db->update($this->table, [ 'is_deleted' => true]);
    		return true;
    	} catch (Exception $e) {
    		return false;
    	} 
    }
}