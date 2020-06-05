
<?php

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
ini_set('error_reporting', E_ALL);

if(file_exists("clientes.txt")){

    $jsonClientes=file_get_contents("clientes.txt");
    $aClientes=json_decode($jsonClientes ,true);
    }else{
    $aClientes=array();
    
    }

$pos=isset($_GET["pos"])? $_GET["pos"]:'';
    
    if(isset($_GET["pos"]) && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
        unset($aClientes[$pos]);
        $jsonClientes = json_encode($aClientes);
        file_put_contents("clientes.txt", $jsonClientes);
    }
    
    if($_POST){
    
    $dni=$_POST["txtDni"];
    $nombre=$_POST["txtNombre"];
    $telefono=$_POST["txtTelefono"];
    $correo=$_POST["txtCorreo"];
    
    if(isset($_GET["pos"])&& $_GET["do"]=="new"){
    
    
        $aClientes[]= array( "dni"=> $dni,
                            "nombre"=> $nombre,
                            "telefono"=> $telefono,
                            "correo"=> $correo,
        ); 
    
        //2-convertir array en json
    
        $jsonClientes=json_encode($aClientes); 
    
        //3-guardar json en el archivo
    
      file_put_contents("clientes.txt", $jsonClientes); 
    
    }
     else if(isset($_GET["pos"])&& $_GET["do"]=="edit"){
    
        $aClientes[$pos]= array(  "dni"=> $dni,
                            "nombre"=> $nombre,
                            "telefono"=> $telefono,
                            "correo"=> $correo); 
    
        $jsonClientes=json_encode($aClientes); 
    
        file_put_contents("clientes.txt", $jsonClientes); 
    
    }
    
    }
    
    if(isset($_GET["pos"])&& $_GET["do"]=="delete"){
    unset($aClientes[$pos]);
    $jsonClientes=json_encode($aClientes); 
    file_put_contents("clientes.txt", $jsonClientes);
    
    }
    

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://agustinafernandez.com.ar/css1/css/fontawesome.min.css" rel="stylesheet">
    <link href="https://agustinafernandez.com.ar/css1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center py-3">
                <h1>Registro de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="txtDni">DNI:</label>
                            <input type="text" id="txtDni" name="txtDni" class="form-control" required value="<?php echo isset($aClientes[$pos])? $aClientes[$pos]["dni"] : ''; ?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" required value="<?php echo isset($aClientes[$pos])? $aClientes[$pos]["nombre"] : ''; ?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtTelefono">Teléfono:</label>
                            <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" required value="<?php echo isset($aClientes[$pos])? $aClientes[$pos]["telefono"] : ''; ?>"> 
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtCorreo">Correo:</label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required value="<?php echo isset($aClientes[$pos])? $aClientes[$pos]["correo"] : '';?>">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtCorreo">Archivo adjunto:</label>
                            <input type="file" id="archivo" name="archivo" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 col-12">
                <table class="table table-hover border">
                    <tr>
                        <th>Imagen</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php 

foreach ($aClientes as $pos =>$cliente){?>
<tr>
    <td><?php echo $cliente["dni"]?> </td>
    <td><?php echo $cliente["nombre"]?> </td>
    <td><?php echo $cliente["correo"]?> </td>
    <td> <a href="?pos=<?php echo $pos; ?>do==edit"><i class="fas fa-edit"></i></a>
         <a href="?pos=<?php echo $pos; ?>&do=delete"><i class="far fa-trash-alt"></i></a>
    
    </td>
</tr>
<?php 
   
} ?>

                <tr>
                        <td><img src="" class="img-thumbnail"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="width: 110px;">
                        <a href="index.php?id=0"><i class="fas fa-edit"></i></a>
                        <a href="index.php?id=0&amp;do=eliminar"><i class="fas fa-trash-alt"></i></a>
                        <a href="index.php"><i class="fas fa-plus"></i></a></td>
                
                </tr>
                </tbody>
                </table>
            
        </div>
    </div>
</div>

</body>
</html>






                   














