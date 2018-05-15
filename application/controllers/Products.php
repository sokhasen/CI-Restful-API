<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'Resource.php';

class Products extends Resource
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('product');
	}

	/**
     * Display a listing of the resource.
     *
     * @return array $product
     */
	public function index()
	{
		$products = $this->product->getProductList();
		return $this->response(["data" => $products], 200); 
	}

	/**
     * Display the specific resource.
     *
     *@param int $id
     * @return json $product
     */
	public function show($id) {
		$product = $this->product->getOneProduct($id);
		return $this->response(["data" => $product], 200);
	}

	/**
     * create a new resource.
     *
     *@param void
     * @return json $message
     */
	public function store() { 
		$name = $this->post('name');
		$price = $this->post('price'); 
		$description = $this->post('description'); 

		if ($name && $description && $price) {
			$this->product->name = $name;
			$this->product->price = $price;
			$this->product->is_deleted = false;
			$this->product->description = $description;
			$this->product->created_at = date("Y-m-d h:i:s");
			$this->product->updated_at = date("Y-m-d h:i:s");

			$create = $this->product->addProduct($this->product);
			if ($create) { 
				$data = [ "message" => "product has been created!"];
				$statusCode = 201; 
			}
			else {
				$data = [ "message" => "product cannot create"];
				$statusCode = 500; 
			}
		}
		else {
			$data = [ "message" => "required missinng fields"];
			$statusCode = 400; 
		}
		return $this->response($data, $statusCode);
	}

	/**
     * update the specific resource.
     *
     *@param int $id
     * @return json $message
     */
	public function update($id) { 
		$name = $this->put('name');
		$price = $this->put('price');
		$description = $this->put('description');

		if ($id && $name && $price && $description) {
			$this->product->name = $name;
			$this->product->price = $price;
			$this->product->description = $description;

			$update = $this->product->updateProduct($id, $this->product);
			if ($update) {
				$data = [ "message" => "product has been update!"];
				$statusCode = 200; 
			}
			else {
				$data = [ "message" => "product cannot update!"];
				$statusCode = 500;  
			}
		}
		else {
			$data = [ "message" => "required missinng fields!"];
			$statusCode = 400; 
		}

		return $this->response($data, $statusCode);
	}

	/**
     * destroy the specific resource.
     *
     *@param int $id
     * @return json $message
     */
	public function destroy($id) {
		$delete = $this->product->deleteProduct($id);
		if ($delete) {
			$data = [ "message" => "Product has been deleted"];
			$statusCode = 200;
		}
		else {
			$data = [ "message" => "Product cannot delete"];
			$statusCode = 500;
		}
		return $this->response($data, $statusCode);
	}
}
