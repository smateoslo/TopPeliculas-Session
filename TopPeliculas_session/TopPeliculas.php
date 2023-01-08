<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopPeliculas</title>  
</head>
<body>
    <?php

    require('Pelicula.php');

    class TopPeliculas{

    private $peliculaArray=[];

    public function __construct(){

    }

    public function anadirPelicula($pelicula){
        if (($pelicula->getNombre() == "") && ($pelicula->getIsan() == "")) {
            //Caso1
            echo 'Los campos nombre y isan estan vacios<br>';
            unset($this->peliculaArray[null]);
        }else{
            foreach ($this->peliculaArray as $key => $value){
                if($key==$pelicula->getIsan()){
                    //Caso 5
                    if($pelicula->getNombre() == ""){
                        //echo "Si el usuario introduce un número ISAN y no deja el nombre de la película vacío, la película se eliminará de la lista.<br>";
                        unset($this->peliculaArray[$pelicula->getIsan()]);
                    }
                    if($pelicula->getNombre() != "" && $pelicula->getAño() != "" && $pelicula->getPuntuacion()){
                        //Caso 4
                        //echo "Si el número ISAN que se introdujo YA existe en la lista y el resto de apartados no están vacíos se actualizará con la información introducida en el formulario.<br>";
                        $value->setNombre($pelicula->getNombre());
                        $value->getAño($pelicula->getAño());
                        $value->getPuntuacion($pelicula->getPuntuacion());
                    }
                }else{
                    //Caso 3
                    if(($pelicula->getNombre() != "") && ($pelicula->getIsan() == "")){
                        //echo "Si sólo el ISAN está vacío mostrará la lista de películas que contienen ese nombre" <br>;
                        if(str_contains($value->getNombre(),$pelicula->getNombre())){
                            echo $value->getNombre()." Anio: ".$value->getAño()." Puntuacion: ".$value->getPuntuacion(). "<br>";
                            unset($this->peliculaArray[null]);
                        }
                    }else{
                        $this->peliculaArray[$pelicula->getIsan()]=$pelicula;
                    }
                }
            } 
        }
    }

    //metodo para convertir el Array en String
    public function array_String(){
        $string="";
        foreach ($this->peliculaArray as $key => $value){
            if($value->getIsan()!=" " && $value->getNombre()!=" " && $value->getPuntuacion()!=" " && $value->getAño()!=1){
                $string .= $value->getIsan().",".$value->getNombre().",".$value->getPuntuacion().",".$value->getAño()."/";
            }
        }
        return $string;
    }

    //metodo para convertir el String en Array
    public function string_Array($texto){
        $array=explode("/",$texto);
        for ($i=0; $i < count($array); $i++) { 
            $array_peli=explode(",",$array[$i]);
            if($array[$i]!="" || $texto=""){
                $peli=new Pelicula($array_peli[0],$array_peli[1],$array_peli[2],$array_peli[3]);
                $this->peliculaArray[$array_peli[0]]=$peli;
            }
        }
    }

    //metodo para mostrar los datos
    public function mostrarDatos(){
        $datos="";
        foreach($this->peliculaArray as $key => $value){
            $datos.="Nombre: ".$value->getNombre()." ISAN: ".$value->getIsan()." Puntuacion: ".$value->getPuntuacion()." Anio: ".$value->getAño()."<br>";
        }
        return $datos;
    }
}

    
    session_start();
    //Hace el registro con el usuario de la clase 'Usuario.php'
    if(isset($_POST["usuario"]) && $_POST["usuario"]!= null){
        $_SESSION['usuario'] = $_POST["usuario"];
    }
    //En caso de no introducir un usuario se cierra la sesion
    if ($_SESSION["usuario"] === null || $_SESSION["usuario"] === "") {
        session_destroy();
    }
    //Se almacenan en el array 'peliculas'
    $obj = new TopPeliculas();
    if (isset($_POST['concatenado'])) {
        $obj->string_Array($_POST['concatenado']."/".$_POST['ISAN'].",".$_POST['nombre'].",".$_POST['combo'].",".$_POST['anio']."/");
    }
    ?>


<h1>Usuario:
<?php { 
        if ($_SESSION["usuario"] === null || $_SESSION["usuario"] === "") {
            echo "Tienes que registrarte";
            die();
        }else{
            echo $_SESSION["usuario"];
        } 
} ?>
</h1>


<form action="TopPeliculas.php" method="post">
        <p>Nombre de la pelicula: </p>
        <input type="text" id="nombre" name="nombre">
        <p>ISAN: </p>
        <input type="text" id="ISAN" name="ISAN">
        <br>
        <p>Anio:</p>
        <input type="number" id="anio" name="anio">
        <br><br>
        <p>Puntuacion:</p>
        <select name="combo">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br><br>
        <button type="submit">Añadir</button><br><br>
        <a href="CerrarSesion.php">Cerrar Sesion</a><br><br>

        <?php
            if(isset($_POST["ISAN"]) && isset($_POST["nombre"]) && isset($_POST["anio"]) && isset($_POST["combo"])){
                $pelicula=new Pelicula(htmlentities($_POST['ISAN']),htmlentities($_POST['nombre']),htmlentities($_POST['combo']),htmlentities($_POST['anio']));
                $obj->anadirPelicula($pelicula);
                echo $obj->mostrarDatos();
            }
            echo "<input type='hidden' name='concatenado' value='".$obj->array_String()."' >"
        ?>

    </form>
</body>
</html>
