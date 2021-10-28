<?php

//ELEMENTOS NECESARIOS PARA LA CONEXIÓN
$server = "localhost";
$username = "root";
$password = "";
$database = "alumno";

$conn = mysqli_connect($server, $username, $password, "$database");

//ARRAY CON TODAS LAS VARIABLES PARA COMPROBAR QUE ESTAN SETEADAS
$array_variables = array("marca", "modelo", "puertas","combustible","ordenador","motorizacion","elevalunas","cierreCentralizado","anioMatriculacion","pinturaMetalica","color","cambioAutomatico","precioFinal","km0","pathFoto");

//ARRAY PARA AÑADIR LOS ELEMENTOS UNA VEZ ESTAN SETEADAS
$array = array();

//COMPROBAR SI LA CONEXIÓN ES TRUE
if ($conn == true) {

    //VARIABLES PARA SABER SI HAY ALGUNA VARIABLE NO SETEADA
    $check = false;
    $i = 0;

    //BUCLE WHILE PARA CHECKEAR QUE LAS VARIABLES ESTÁN SETEADAS Y AÑADIRLA A UNA NUEVA LISTA

    while ($check == false and $i != 15){
        if(isset($_POST[$array_variables[$i]])){
            $array[$i] = htmlspecialchars($_POST[$array_variables[$i]], ENT_QUOTES);
            $i++;
            
        }else{
            $check = true;
        }
    }
    //COMPROBAR SI ALGUNA VARIABLE NO SE HA SETEADO
    if($check == false){

        $filtre = false;
        $mensaje = "";

        if($array[2]<=0 || !is_numeric($array[2])){
            $filtre = true;
            $mensaje = "No puedes tener ninguna puerta o menos";
        }

        if($array[5]<=0 || !is_numeric($array[5])){
            $filtre = true;
            $mensaje = "La motorización no puede ser 0 o menor";
        }

        if(($array[8]>=0 && $array[8]<=9999) || !is_numeric($array[8])){
            $filtre = true;
            $mensaje = "El año de matriculación esta mal";
        }


        //QUERY INSERTAR CON TODOS LOS DATOS
        if($filtre == false){
                $sql = "INSERT INTO autos (marca, modelo,puertas,combustible,ordenador,motorizacion,elevalunas,cierreCentralizado,anioMatriculacion,pinturaMetalizada,color,cambioAutomatico,precioFinal,km0,pathFoto)
            VALUES ('$array[0]', '$array[1]',$array[2],'$array[3]',$array[4],$array[5],$array[6],$array[7],$array[8],$array[9],'$array[10]',$array[11],$array[12],$array[13],'$array[14]')";

            //COMPROBAR QUE EL INSERT SE HA REALIZADO CORRECTAMENTE Y INSERTAR
            if ($conn->query($sql) === TRUE) {
                echo "<br> Registro creado correctamente";
            } else {
                echo "<br> Error al insertar datos en la base de datos";
            }
        }else{
            echo $mensaje;
        }
        

    }else{

        echo "La variable ".$array_variables[$i]." no esta seteada";

    }
    //CERRAR LA CONEXIÓN
    mysqli_close($conn);
} else {
    echo "No se ha conectado a la base de datos";
}

?>