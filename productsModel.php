<?php
class productsModel{
    #conexion con a base de datos 
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }
    # obteniendo `productos
    public function getProducts($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $products=[];
        $sql="SELECT * FROM products ".$where;
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($products,$row);
        }
        return $products;
    }
    #guardando productos
    public function saveProducts($name,$descripcion,$precio){
        $valida = $this->validateProducts($name,$descripcion,$precio);
        $resultado=['error','Ya existe un producto las mismas características'];
        if(count($valida)==0){
            $sql="INSERT INTO products(name,descripcion,precio) VALUES('$name','$descripcion','$precio')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Producto guardado'];
        }
        return $resultado;
    }
  #actualizando productos
    public function updateProducts($id,$name,$descripcion,$precio){
        $existe= $this->getProducts($id);
        $resultado=['error','No existe el producto con ID '.$id];
        if(count($existe)>0){
            $valida = $this->validateProducts($name,$descripcion,$precio);
            $resultado=['error','Ya existe un producto las mismas características'];
            if(count($valida)==0){
                $sql="UPDATE products SET name='$name',descripcion='$descripcion',precio='$precio' WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Producto actualizado'];
            }
        }
        return $resultado;
    }
    #eliminando productos
    public function deleteProducts($id){
        $valida = $this->getProducts($id);
        $resultado=['error','No existe el producto con ID '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM products WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Producto eliminado'];
        }
        return $resultado;
    }
    
    public function validateProducts($name,$descripcion,$precio){
        $products=[];
        $sql="SELECT * FROM products WHERE name='$name' AND descripcion='$descripcion' AND precio='$precio' ";
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($products,$row);
        }
        return $products;
    }
}