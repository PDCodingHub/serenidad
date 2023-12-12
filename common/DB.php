<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>

<?php

class DB
{
    // Método que obtiene la conexion a la base de datos con el valor del objeto cofiguración pasado por sesión
    protected static function getConnection()
    {
        try {
            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $dsn = "mysql:host=localhost;dbname=serenidad";
            $usuario = 'root';
            $contrasena = 'root';

            $connection = new PDO($dsn, $usuario, $contrasena, $opc);
        } catch (Exception $error) {
            echo($error->getMessage());
        }
        return $connection;
    }

    protected static function ejecutaConsulta($sql)
    {
        try {
            $connection = self::getConnection();
            $resultado = null;
            if (isset($connection)) $resultado = $connection->query($sql);
            return $resultado;
        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function verificaUsuario($usuario, $contraseña)
    {
        $sql = "SELECT usuario FROM trabajadores ";
        $sql .= "WHERE usuario='$usuario' ";
//        $sql .= "AND contrasena='" . md5($contrasena) . "';";
        $sql .= "AND pass='" . $contraseña . "';";
        $resultado = self::ejecutaConsulta($sql);
        $verificado = false;

        if (isset($resultado)) {
            $fila = $resultado->fetch();
            if ($fila !== false) $verificado = true;
        }
        return $verificado;
    }

    public static function obtieneRol($user)
    {
        $sql = "SELECT rol FROM trabajadores ";
        $sql .= "WHERE usuario='$user' ";
        $resultado = self::ejecutaConsulta($sql);

        $fila = "";
        if (isset($resultado)) {
            $fila = $resultado->fetch();
        }
        return $fila;
    }

    public static function obtieneDni()
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT dni_persona FROM personas";
            $resultado = $conexion->query($sql);

            $fila = "";
            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneNumHabitacion()
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT num_habitacion FROM dependientes";
            $resultado = $conexion->query($sql);
            $conexion = null;

            $fila = $resultado->fetchAll();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }


    public static function obtieneNumHabitacionIdDependiente()
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT dni_dependiente, num_habitacion, id_dependiente FROM dependientes;";
            $resultado = $conexion->query($sql);

            $fila = $resultado->fetchAll();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneDni_Id_Trabajador()
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT dni_trabajador, id_trabajador FROM trabajadores;";
            $resultado = $conexion->query($sql);

            $fila = $resultado->fetchAll();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }


    public static function obtieneInfoTrabajador($usuario)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, t.usuario, t.pass, t.rol, t.id_trabajador ";
            $sql .= "FROM personas p ";
            $sql .= "INNER JOIN trabajadores t ON p.dni_persona = t.dni_trabajador ";
            $sql .= "WHERE t.usuario = :usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            $conexion = null;

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneListaTrabajadores()
    {
        $sql = "SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, t.usuario, t.pass, t.rol, t.id_trabajador ";
        $sql .= "FROM personas p ";
        $sql .= "INNER JOIN trabajadores t ";
        $sql .= "ON p.dni_persona = t.dni_trabajador";
        $resultado = self::ejecutaConsulta($sql);

        $fila = "";
        if (isset($resultado)) {
            $fila = $resultado->fetchAll();
        }
        return $fila;
    }

    public static function obtieneTrabajador($dni)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();
            // preparamos la consulta
            $sql = 'SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, t.usuario, t.pass, t.rol, t.id_trabajador FROM personas p INNER JOIN trabajadores t ON p.dni_persona = t.dni_trabajador AND p.dni_persona = :dni';

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":dni", $dni);
            $consulta->execute();

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneListapeqDependientes()
    {
        $sql = "SELECT p.nombre, p.apellidos, p.dni_persona, d.num_habitacion ";
        $sql .= "FROM personas p ";
        $sql .= "INNER JOIN dependientes d ";
        $sql .= "ON p.dni_persona = d.dni_dependiente";
        $resultado = self::ejecutaConsulta($sql);

        $fila = "";
        if (isset($resultado)) {
            $fila = $resultado->fetchAll();
        }
        return $fila;
    }

    public static function obtieneDependienteId($id)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();
            // preparamos la consulta
            $sql = "SELECT p.dni_persona, CONCAT(p.nombre, ' ', p.apellidos) AS nombre, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, d.id_dependiente, d.nivel_dependencia, d.num_habitacion, d.familiar_referencia, d.nombre_fam_referencia, d.telefono_fam_referencia FROM personas p INNER JOIN dependientes d ON p.dni_persona = d.dni_dependiente AND d.id_dependiente = :id_dependiente";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_dependiente", $id);
            $consulta->execute();

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneDependiente($dni)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();
            // preparamos la consulta
            $sql = 'SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, d.id_dependiente, d.nivel_dependencia, d.num_habitacion, d.familiar_referencia, d.nombre_fam_referencia, d.telefono_fam_referencia FROM personas p INNER JOIN dependientes d ON p.dni_persona = d.dni_dependiente AND p.dni_persona = :dni';

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":dni", $dni);
            $consulta->execute();

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    // ************************************* CRUD PERSONA / TRABAJADOR / RESIDENTE *********************************************

    // *************** Inserta Personas *************************************
    private static function creaPersona($conexion, $dni, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email)
    {
        try {
            //abrimos la conexion
            //$conexion = self::getConnection();
            // preparamos la consulta
            $sql = 'INSERT INTO personas (dni_persona, nombre, apellidos, fecha_nacimiento, direccion, localidad, provincia, telefono, email) VALUES (:dni_persona, :nombre, :apellidos, :fecha_nacimiento, :direccion, :localidad, :provincia, :telefono, :email)';
            //$sql = 'INSERT INTO personas (dni_persona, nombre, apellidos, direccion, localidad, provincia, telefono, email) VALUES (:dni_persona, :nombre, :apellidos, :direccion, :localidad, :provincia, :telefono, :email)';

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":dni_persona", $dni);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":apellidos", $apellidos);
            $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
            $consulta->bindParam(":direccion", $direccion);
            $consulta->bindParam(":localidad", $localidad);
            $consulta->bindParam(":provincia", $provincia);
            $consulta->bindParam(":telefono", $telefono);
            $consulta->bindParam(":email", $email);
            $consulta->execute();

            // Obtener el número de filas afectadas en la tabla personas
            $filas = $consulta->rowCount();
            //$conexion = null;

            return $filas;
        } catch (Exception $error) {
            echo($error->getMessage());
            return 0; // Devolver 0 en caso de error
        }
    }

    public static function creaTrabajador($dni, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $rol, $usuario, $contraseña)
    {
        //public static function creaTrabajador ($dni, $nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $id_trabajador, $rol, $usuario, $contraseña) {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();

            $filasPersonas = DB::creaPersona($conexion, $dni, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email);

                //$conexion = self::getConnection();

                $sql = 'INSERT INTO trabajadores (id_trabajador, rol, usuario, pass, dni_trabajador) VALUES (null, :rol, :usuario, :pass, :dni_trabajador)';

                $consulta = $conexion->prepare($sql);
                $consulta->bindParam(":rol", $rol);
                $consulta->bindParam(":usuario", $usuario);
                $consulta->bindParam(":pass", $contraseña);
                $consulta->bindParam(":dni_trabajador", $dni);
                $consulta->execute();

                // Obtener el número de filas afectadas en la tabla trabajadores
                $filas = $consulta->rowCount();
                // Cerrar la conexión
                $conexion = null;

                // Devolver el número total de filas afectadas
                return $filas + $filasPersonas;

        } catch (Exception $error) {
            echo($error->getMessage());
            return 0; // Devolver 0 en caso de error
        }
    }

    public static function creaPersonaDependiente($dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $nivel_dependencia, $habitacion, $familiar_referencia, $nombre_fam_referencia, $telefono_fam_referencia)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();

            $filasPersonas = DB::creaPersona($conexion, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email);

                //$conexion = self::getConnection();

                $sql = 'INSERT INTO dependientes (id_dependiente, nivel_dependencia, num_habitacion, familiar_referencia, nombre_fam_referencia, telefono_fam_referencia, dni_dependiente) VALUES (null, :nivel_dependencia, :num_habitacion, :familiar_referencia, :nombre_fam_referencia, :telefono_fam_referencia, :dni_dependiente)';

                $consulta = $conexion->prepare($sql);
                $consulta->bindParam(":nivel_dependencia", $nivel_dependencia);
                $consulta->bindParam(":num_habitacion", $habitacion);
                $consulta->bindParam(":familiar_referencia", $familiar_referencia);
                $consulta->bindParam(":nombre_fam_referencia", $nombre_fam_referencia);
                $consulta->bindParam(":telefono_fam_referencia", $telefono_fam_referencia);
                $consulta->bindParam(":dni_dependiente", $dni_persona);
                $consulta->execute();

                // Obtener el número de filas afectadas en la tabla personas
                $filas = $consulta->rowCount();
                $conexion = null;

                return $filas;

//            } else
//                echo "Error al crear la persona";
        } catch
        (Exception $error) {
            echo($error->getMessage());
        }
    }

    // ******** Actualiza Personas *************************************

    private static function actualizaPersona(PDO $conexion, $dniInicial, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email)
    {
        $sql = 'UPDATE personas SET dni_persona = :dni_persona, nombre = :nombre, apellidos = :apellidos, fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, localidad = :localidad, provincia = :provincia, telefono = :telefono, email = :email WHERE dni_persona = :dni_inicial';

        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":dni_persona", $dni_persona);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":apellidos", $apellidos);
        $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":localidad", $localidad);
        $consulta->bindParam(":provincia", $provincia);
        $consulta->bindParam(":telefono", $telefono);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":dni_inicial", $dniInicial);
        $consulta->execute();

        $filasPersonas = $consulta->rowCount();

        // Compruebo si se ha insertado algo en PERSONAS
        $insertaPersonas = false;
        if ($filasPersonas != 0) {
            $insertaPersonas = true;
        }
        return $insertaPersonas;
    }

    public static function actualizaTrabajador($dniInicial, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $rol, $usuario, $pass, $id_trabajador)
    {

        try {
            $conexion = self::getConnection();

            $insertaPersonas = DB::actualizaPersona($conexion, $dniInicial, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email);

            $sql = 'UPDATE trabajadores SET id_trabajador = :id_trabajador, rol = :rol, usuario = :usuario, pass = :pass, dni_trabajador = :dni_trabajador WHERE dni_trabajador = :dni_trabajador';

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_trabajador", $id_trabajador);
            $consulta->bindParam(":rol", $rol);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindParam(":pass", $pass);
            $consulta->bindParam(":dni_trabajador", $dni_persona);
            $consulta->execute();

            // Cerrar la conexión
            $conexion = null;

            $filasTrabajadores = $consulta->rowCount();

            // Compruebo si se ha insertado algo en TRABAJADORES
            $insertaTrabajador = false;
            if ($filasTrabajadores > 0) {
                $insertaTrabajador = true;
            }

            // Si se ha insertado algo en Personas y/o Trabajadores, devuelve true
            if (($insertaPersonas && $insertaTrabajador) || ($insertaPersonas && !$insertaTrabajador) || (!$insertaPersonas && $insertaTrabajador)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Si hay algún error, deshacer la transacción
            echo "Error: " . $e->getMessage();
        }
    }


    public static function actualizaDependiente($dniInicial, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $id_dependiente, $nivel_dependencia, $habitacion, $familiar_referencia, $nombre_fam_referencia, $telefono_fam_referencia)
    {
        try {

            $conexion = self::getConnection();

//            // Comenzamos la transacción
//            $conexion->beginTransaction();
//
//            // Desactivamos temporalmente la restricción de clave foránea
//            $conexion->query('SET foreign_key_checks = 0');
            // Realizamos las consultas que queremos ejecutar

            $insertaPersona = DB::actualizaPersona($conexion, $dniInicial, $dni_persona, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email);

            $sql = 'UPDATE dependientes SET id_dependiente = :id_dependiente ,nivel_dependencia = :nivel_dependencia, num_habitacion = :num_habitacion, familiar_referencia = :familiar_referencia, nombre_fam_referencia = :nombre_fam_referencia, telefono_fam_referencia = :telefono_fam_referencia WHERE dni_dependiente = :dni_dependiente';
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_dependiente", $id_dependiente);
            $consulta->bindParam(":nivel_dependencia", $nivel_dependencia);
            $consulta->bindParam(":num_habitacion", $habitacion);
            $consulta->bindParam(":familiar_referencia", $familiar_referencia);
            $consulta->bindParam(":nombre_fam_referencia", $nombre_fam_referencia);
            $consulta->bindParam(":telefono_fam_referencia", $telefono_fam_referencia);
            $consulta->bindParam(":dni_dependiente", $dni_persona);

            $consulta->execute();

            // Volver a activar la restricción de clave foránea
//            $conexion->query("SET foreign_key_checks = 1");
//            $conexion->commit();

            // Cerrar la conexión
            $conexion = null;

            $filas = $consulta->rowCount();

            // Compruebo si se ha insertado algo en TRABAJADORES
            $insertaDependiente = false;
            if ($filas > 0) {
                $insertaDependiente = true;
            }

            // Si se ha insertado algo en Personas y/o Trabajadores, devuelve true
            if (($insertaPersona && $insertaDependiente) || ($insertaPersona && !$insertaDependiente) || (!$insertaPersona && $insertaDependiente)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Si hay algún error, deshacer la transacción
            echo "Error: " . $e->getMessage();
        }
    }

    // ******** Borra Personas *************************************

    public static function borraPersona($dni)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();
            // preparamos la consulta
            $sql = 'DELETE FROM personas WHERE dni_persona = :dni';

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":dni", $dni);
            $consulta->execute();

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }


//************************************* INCIDENCIAS *********************************************

    public static function paginacionIncidencias($id, $fecha)
    {
        try {
            //abrimos la conexion
            $conexion = self::getConnection();

            //var_dump($id, $fecha);

            // Configuración de la paginación
            $filas_por_pagina = 10;
            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $offset = ($pagina_actual - 1) * $filas_por_pagina;

            // todo ******* PRUEBAS
            // $id = 3;
            //$fecha = '2023-11-28';
            // todo ******* PRUEBAS

// Consulta para obtener un conjunto de datos limitado
            $sql = "SELECT INCIDENCIAS.descripcion, INCIDENCIAS.fecha, CONCAT(TRABAJADOR.nombre, ' ' ,TRABAJADOR.apellidos) AS nombre_trabajador, CONCAT(DEPENDIENTE.nombre, ' ', DEPENDIENTE.apellidos) AS nombre_dependiente
    FROM INCIDENCIAS
    LEFT JOIN
    TRABAJADORES ON INCIDENCIAS.id_trabajador = TRABAJADORES.id_trabajador
    LEFT JOIN
    PERSONAS AS TRABAJADOR ON TRABAJADORES.dni_trabajador = TRABAJADOR.dni_persona
    JOIN
    DEPENDIENTES ON INCIDENCIAS.id_dependiente = DEPENDIENTES.id_dependiente
    JOIN
    PERSONAS AS DEPENDIENTE ON DEPENDIENTES.dni_dependiente = DEPENDIENTE.dni_persona WHERE 1 ";

            if (isset($id))
                $sql .= "AND DEPENDIENTES.id_dependiente = :id ";
            if (isset($fecha)) {
                // filtra por fecha y la muestra de forma ascendente a partir de la indicada
                $sql .= "AND incidencias.fecha >= :fecha ";
                $sql .= "ORDER BY incidencias.fecha ASC ";
            } elseif (!isset($fecha)) {
                $sql .= "ORDER BY incidencias.fecha DESC ";
            }
            $sql .= "LIMIT :offset, :filas_por_pagina";

            $stmt = $conexion->prepare($sql);

            //Si se ha introducido un id y/o una fecha, se añaden a la consulta
            if (isset($id))
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if (isset($fecha))
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':filas_por_pagina', $filas_por_pagina, PDO::PARAM_INT);
            $stmt->execute();

            // Calcular el número total de páginas
            $stmt_total = $conexion->prepare("SELECT COUNT(*) AS total FROM incidencias");
            $stmt_total->execute();
            //$filasMostradas = $stmt->rowCount();
            $total_filas = $stmt_total->fetchColumn();
            $total_paginas = ceil($total_filas / $filas_por_pagina);

// Mostrar los datos en una tabla
            echo "<table class='table table-striped table-hover caption-top'>
        <tr>
            <th>Fecha</th>
            <th>Residente</th>
            <th>Descripción incidencia</th>
            <th>Trabajador</th>
            <tbody></tbody> 
        </tr>";

            while ($row = $stmt->fetch()) {
                echo
                    "<tr>
            <td>" . $row['fecha'] . "</td>
            <td>" . $row['nombre_dependiente'] . "</td>
            <td>" . $row['descripcion'] . "</td>
            <td>" . $row['nombre_trabajador'] . "</td>
            </tr>";
            }

            echo "</table>";

            // Mostrar los enlaces de paginación
            echo "<p>Páginas: ";
            for ($i = 1; $i <= $total_paginas; $i++) {
                echo "<a href='incidencias.php?pagina=$i'>$i - </a>";
            }
            echo "</p>";
            echo "<p>Estás en la página $pagina_actual de $total_paginas</p>";

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
// Cerrar la conexión
        $conexion = null;
    }

    public static function selectDependiente()
    {
        try {
            // preparamos la consulta
            $sql = "SELECT CONCAT(personas.nombre, ' ', personas.apellidos) AS nombre, dependientes.id_dependiente
            FROM personas, dependientes
            WHERE personas.dni_persona = dependientes.dni_dependiente
            ORDER BY nombre ASC";
            $resultado = self::ejecutaConsulta($sql);

            $fila = "";
            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function crearIncidencia($fecha, $descripcion, $id_trabajador, $id_dependiente)
    {
        try {
            $conexion = self::getConnection();

            $sql = "INSERT INTO incidencias (id_incidencia, fecha, descripcion, id_trabajador, id_dependiente) VALUES (null, :fecha, :descripcion, :id_trabajador, :id_dependiente)";
            //INSERT INTO incidencias SET id_incidencia = NULL, fecha = :fecha, descripcion = _descripcion, id_trabajador = :id_trabajador, id_dependiente = id_dependiente;
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":fecha", $fecha);
            $consulta->bindParam(":descripcion", $descripcion);
            $consulta->bindParam(":id_trabajador", $id_trabajador);
            $consulta->bindParam(":id_dependiente", $id_dependiente);
            $consulta->execute();
            $conexion = null;

            $inserta = $consulta->rowCount();
            return $inserta;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
        // INSERT INTO incidencias SET id_incidencia = NULL, fecha = :fecha, descripcion = _descripcion, id_trabajador = :id_trabajador, id_dependiente = id_dependiente;
    }

    public static function obtieneIncidenciasTrabajador($id_trabajador)
    {

        try {
            $conexion = self::getConnection();
            $sql = "SELECT INCIDENCIAS.id_incidencia, INCIDENCIAS.descripcion, INCIDENCIAS.fecha, CONCAT(TRABAJADOR.nombre, ' ' ,TRABAJADOR.apellidos) AS nombre_trabajador, CONCAT(DEPENDIENTE.nombre, ' ', DEPENDIENTE.apellidos) AS nombre_dependiente
    FROM INCIDENCIAS
    LEFT JOIN
    TRABAJADORES ON INCIDENCIAS.id_trabajador = TRABAJADORES.id_trabajador
    LEFT JOIN
    PERSONAS AS TRABAJADOR ON TRABAJADORES.dni_trabajador = TRABAJADOR.dni_persona
    JOIN
    DEPENDIENTES ON INCIDENCIAS.id_dependiente = DEPENDIENTES.id_dependiente
    JOIN
    PERSONAS AS DEPENDIENTE ON DEPENDIENTES.dni_dependiente = DEPENDIENTE.dni_persona AND INCIDENCIAS.id_trabajador = :id_trabajador
    ORDER BY INCIDENCIAS.fecha DESC";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_trabajador", $id_trabajador);
            $consulta->execute();
            $conexion = null;

            $fila = $consulta->rowCount();

            if ($fila > 0) {
                $resultado = $consulta->fetchAll();
            } else {
                $resultado = null;
            }
            return $resultado;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function borrarIncidencia($id_incidencia)
    {
        try {
            $conexion = self::getConnection();
            $sql = "DELETE FROM incidencias WHERE id_incidencia = :id_incidencia";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_incidencia", $id_incidencia);
            $consulta->execute();
            $conexion = null;

            $filas = $consulta->rowCount();
            return $filas;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneIdTrabajador($usuario)
    {
        try {
            $conexion = self::getConnection();

            $sql = "SELECT TRABAJADORES.id_trabajador FROM trabajadores, personas
        WHERE personas.dni_persona = trabajadores.dni_trabajador
        AND trabajadores.usuario = :usuario";
            //$resultado = self::ejecutaConsulta($sql);

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            $conexion = null;

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneIdDependiente($id_incidencia)
    {
        try {
            $conexion = self::getConnection();

            $sql = "SELECT incidencias.id_dependiente FROM incidencias WHERE incidencias.id_incidencia = :id_incidencia";
            //$resultado = self::ejecutaConsulta($sql);

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_incidencia", $id_incidencia);
            $consulta->execute();
            $conexion = null;

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetch();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function actualizaIncidencia($fecha, $descripcion, $id_dependiente, $id_incidencia)
    {
        try {
            $conexion = self::getConnection();
            $sql = "UPDATE incidencias SET fecha = :fecha, descripcion = :descripcion, id_dependiente = :id_dependiente WHERE id_incidencia = :id_incidencia";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":fecha", $fecha);
            $consulta->bindParam(":descripcion", $descripcion);
            $consulta->bindParam(":id_dependiente", $id_dependiente);
            $consulta->bindParam(":id_incidencia", $id_incidencia);
            $consulta->execute();
            $conexion = null;

            $filas = $consulta->rowCount();
            return $filas;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

// **************************************** CITAS *********************************************************

    /**
     * Obtiene las citas del día actual de todos las personas dependientes y las ordena por hora de la cita.
     */

    public static function obtieneCitas($fecha)
    {
        try {
            $conexion = self::getConnection();

            $sql = "SELECT citas.*, CONCAT(dependiente.nombre, ' ', dependiente.apellidos) AS nombre  FROM citas
        JOIN
        dependientes ON citas.id_dependiente = dependientes.id_dependiente
        JOIN
        personas AS dependiente ON dependientes.dni_dependiente = dependiente.dni_persona 
        WHERE citas.fecha = :fecha
        ORDER BY citas.hora";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":fecha", $fecha);
            $resultado->execute();
            $conexion = null;

            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;
        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneCitasHoy()
    {
        try {
            $sql = "SELECT citas.fecha, citas.hora, citas.centro, citas.localidad, citas.provincia, citas.direccion, citas.planta, citas.especialidad, CONCAT(dependiente.nombre, ' ', dependiente.apellidos) AS nombre FROM citas
JOIN
	dependientes ON citas.id_dependiente = dependientes.id_dependiente
JOIN
	personas AS dependiente ON dependientes.dni_dependiente = dependiente.dni_persona 
WHERE citas.fecha = CURRENT_DATE
ORDER BY citas.hora";
            $resultado = self::ejecutaConsulta($sql);

            $fila = "";
            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }

    }

    /**
     * Devuelve las citas más próximas a partir del día siguiente, las ordena por fecha y hora y las limita a 20 citas.
     */
    public static function obtieneCitasProximas()
    {
        try {
            $sql = "SELECT citas.fecha, citas.hora, citas.centro, citas.localidad, citas.provincia, citas.direccion, citas.planta, citas.especialidad, CONCAT(dependiente.nombre, ' ', dependiente.apellidos) AS nombre FROM citas
JOIN
	dependientes ON citas.id_dependiente = dependientes.id_dependiente
JOIN
	personas AS dependiente ON dependientes.dni_dependiente = dependiente.dni_persona
WHERE citas.fecha >= CURRENT_DATE +1
ORDER BY citas.fecha, citas.hora
LIMIT 20";

            $resultado = self::ejecutaConsulta($sql);

            $fila = "";
            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function creaCitas($fecha, $hora, $centro, $localidad, $provincia, $direccion, $planta, $especialidad, $id_dependiente)
    {
        try {

            $conexion = self::getConnection();
            $sql = "INSERT INTO CITAS (id_cita, fecha, hora, centro, localidad, provincia, direccion, planta, especialidad, id_dependiente) VALUES
(NULL, :fecha, :hora, :centro, :localidad, :provincia, :direccion, :planta,:especialidad, :id_dependiente)";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":fecha", $fecha);
            $consulta->bindParam(":hora", $hora);
            $consulta->bindParam(":centro", $centro);
            $consulta->bindParam(":localidad", $localidad);
            $consulta->bindParam(":provincia", $provincia);
            $consulta->bindParam(":direccion", $direccion);
            $consulta->bindParam(":planta", $planta);
            $consulta->bindParam(":especialidad", $especialidad);
            $consulta->bindParam(":id_dependiente", $id_dependiente);
            $consulta->execute();

            $filas = $consulta->rowCount();
            $conexion = null;

            return $filas;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function actualizaCita($fecha, $hora, $centro, $localidad, $provincia, $direccion, $planta, $especialidad, $id_dependiente, $id_cita)
    {
        try {
            $conexion = self::getConnection();
            $sql = "UPDATE citas SET fecha = :fecha, hora = :hora, centro = :centro, localidad = :localidad, provincia = :provincia, direccion = :direccion, planta = :planta, especialidad = :especialidad, id_dependiente = :id_dependiente WHERE id_cita = :id_cita";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":fecha", $fecha);
            $resultado->bindParam(":hora", $hora);
            $resultado->bindParam(":centro", $centro);
            $resultado->bindParam(":localidad", $localidad);
            $resultado->bindParam(":provincia", $provincia);
            $resultado->bindParam(":direccion", $direccion);
            $resultado->bindParam(":planta", $planta);
            $resultado->bindParam(":especialidad", $especialidad);
            $resultado->bindParam(":id_dependiente", $id_dependiente);
            $resultado->bindParam(":id_cita", $id_cita);
            $resultado->execute();

            $filas = $resultado->rowCount();
            $conexion = null;

            return $filas;
        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function borraCita($id_cita)
    {
        try {
            $conexion = self::getConnection();
            $sql = "DELETE FROM citas WHERE id_cita = :id_cita";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_cita", $id_cita);
            $consulta->execute();

            $filas = $consulta->rowCount();
            $conexion = null;
            return $filas;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    // ************************** CONSULTAS ********************************************************

    public static function modificaConsulta($nombre_medico, $motivo_visita, $descripcion, $diagnostico, $id_consulta){
        try {
         $conexion = self::getConnection();
         //(nombre_medico, motivo_visita, descripcion, diagnostico, id_cita)
         $sql = "UPDATE consultas SET nombre_medico = :nombre_medico, motivo_visita = :motivo_visita, descripcion = :descripcion, diagnostico = :diagnostico WHERE id_consulta = :id_consulta";
         $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":nombre_medico", $nombre_medico);
            $resultado->bindParam(":motivo_visita", $motivo_visita);
            $resultado->bindParam(":descripcion", $descripcion);
            $resultado->bindParam(":diagnostico", $diagnostico);
            $resultado->bindParam(":id_consulta", $id_consulta);
            $resultado->execute();
            $conexion = null;

            $filas = $resultado->rowCount();
            return $filas;

        }catch (Exception $error){
            echo($error->getMessage());
        }
    }

    // *************************** TRATAMIENTOS *******************************************************

    public static function obtieneTratamientosDependiente($id_dependiente)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT DISTINCT
    T.id_tratamiento,
    T.sintoma,
    T.pauta_medicacion,
    T.pauta_reducida,
    T.tipo,
    T.fecha_inicio,
    T.fecha_fin,
    M.nombre_comercial AS nombre_medicamento,
    C.id_consulta,
    C.nombre_medico,
    C.motivo_visita,
    C.descripcion AS descripcion_consulta,
    C.diagnostico,
    C.id_cita,
    CI.fecha AS fecha_cita,
    CI.hora AS hora_cita,
    CI.centro,
    CI.localidad,
    CI.provincia,
    CI.direccion AS direccion_cita
    FROM TRATAMIENTOS T
    JOIN CONSULTAS C ON T.id_consulta = C.id_consulta
    JOIN CITAS CI ON C.id_cita = CI.id_cita
    JOIN DEPENDIENTES D ON CI.id_dependiente = D.id_dependiente
    JOIN PERSONAS P ON D.dni_dependiente = P.dni_persona
    JOIN MEDICACION M ON T.id_medicamento = M.id_medicamento
    WHERE D.id_dependiente = :id_dependiente
    ORDER BY T.fecha_inicio DESC, T.id_tratamiento DESC ";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_dependiente", $id_dependiente);
            $consulta->execute();
            $conexion = null;

            $fila = "";
            if (isset($consulta)) {
                $fila = $consulta->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    // ************************************* DEPENDIENTES ************************************************


    /**
     * Obtiene las citas relacionadas con la persona dependiente a partir de su id.
     * Recoge solamente aquellas pasadas para añadir el tratamiento.
     * Las ordena por fecha y hora y las limita a 10 citas.
     * @param $id
     * @return array|false|void
     */
    public static function obtieneCitasPasadasPorId($id)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT citas.id_cita, citas.fecha, citas.hora, citas.centro, citas.localidad, citas.provincia, citas.direccion, citas.planta, citas.especialidad, CONCAT(dependiente.nombre, ' ', dependiente.apellidos) AS nombre FROM citas
JOIN
	dependientes ON citas.id_dependiente = dependientes.id_dependiente
JOIN
	personas AS dependiente ON dependientes.dni_dependiente = dependiente.dni_persona
WHERE citas.fecha <= CURRENT_DATE
AND dependientes.id_dependiente = :id_dependiente
ORDER BY citas.fecha DESC, citas.hora
LIMIT 10";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":id_dependiente", $id);
            $resultado->execute();
            $conexion = null;


            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;
        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    /**
     * Devuelve las citas más próximas a partir del día actual, las ordena por fecha y hora y las limita a 5 citas.
     */
    public static function obtieneCitasProximasPorId($id)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT citas.fecha, citas.hora, citas.centro, citas.localidad, citas.provincia, citas.direccion, citas.planta, citas.especialidad, CONCAT(dependiente.nombre, ' ', dependiente.apellidos) AS nombre FROM citas
JOIN
	dependientes ON citas.id_dependiente = dependientes.id_dependiente
JOIN
	personas AS dependiente ON dependientes.dni_dependiente = dependiente.dni_persona
WHERE citas.fecha >= CURRENT_DATE
AND dependientes.id_dependiente = :id
ORDER BY citas.fecha ASC, citas.hora
LIMIT 5";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":id", $id);
            $resultado->execute();
            $conexion = null;

            if (isset($resultado)) {
                $fila = $resultado->fetchAll();
            }
            return $fila;
        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneIncidenciasIdDependiente($id)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT INCIDENCIAS.id_incidencia, INCIDENCIAS.descripcion, INCIDENCIAS.fecha, CONCAT(TRABAJADOR.nombre, ' ' ,TRABAJADOR.apellidos) AS nombre_trabajador, CONCAT(DEPENDIENTE.nombre, ' ', DEPENDIENTE.apellidos) AS nombre_dependiente
    FROM INCIDENCIAS
    LEFT JOIN
    TRABAJADORES ON INCIDENCIAS.id_trabajador = TRABAJADORES.id_trabajador
    LEFT JOIN
    PERSONAS AS TRABAJADOR ON TRABAJADORES.dni_trabajador = TRABAJADOR.dni_persona
    JOIN
    DEPENDIENTES ON INCIDENCIAS.id_dependiente = DEPENDIENTES.id_dependiente
    JOIN
    PERSONAS AS DEPENDIENTE ON DEPENDIENTES.dni_dependiente = DEPENDIENTE.dni_persona 
    AND INCIDENCIAS.id_dependiente = :id_dependiente
    ORDER BY INCIDENCIAS.fecha DESC
    LIMIT 20";

            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":id_dependiente", $id);
            $resultado->execute();
            $conexion = null;

            $fila = $resultado->rowCount();

            if ($fila > 0) {
                $fila = $resultado->fetchAll();
            }
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneConsultasPorIdCita($id_cita)
    {
        try {
            $conexion = self::getConnection();
            $sql = "SELECT consultas.* FROM consultas JOIN citas ON consultas.id_cita = citas.id_cita WHERE citas.id_cita = :id_cita;";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":id_cita", $id_cita);
            $resultado->execute();
            $conexion = null;

            $fila = $resultado->fetch();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function obtieneTratamientosPorIdConsulta($id_consulta)
    {
        try {
            $conexion = self::getConnection();

            $sql = "SELECT tratamientos.* FROM tratamientos JOIN consultas ON tratamientos.id_consulta = consultas.id_consulta 
    WHERE tratamientos.id_consulta = :id_consulta";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":id_consulta", $id_consulta);
            $resultado->execute();
            $conexion = null;

            $fila = $resultado->fetchAll();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function creaConsulta($nombre_medico, $motivo_visita, $descripcion, $diagnostico, $id_cita)
    {
        try {
            $conexion = self::getConnection();
            $sql = "INSERT INTO CONSULTAS (id_consulta, nombre_medico, motivo_visita, descripcion, diagnostico, id_cita) 
VALUES (null, :nombre_medico, :motivo_visita, :descripcion, :diagnostico, :id_cita)";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":nombre_medico", $nombre_medico);
            $resultado->bindParam(":motivo_visita", $motivo_visita);
            $resultado->bindParam(":descripcion", $descripcion);
            $resultado->bindParam(":diagnostico", $diagnostico);
            $resultado->bindParam(":id_cita", $id_cita);
            $resultado->execute();

            $conexion = null;
            $resultado = $resultado->rowCount();
            return $resultado;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function creaTratamiento($sintoma, $pauta_medicacion, $pauta_reducida, $tipo, $fecha_inicio, $fecha_fin, $id_consulta, $id_medicamento)
    {
        try {
            $conexion = self::getConnection();
            $sql = "INSERT INTO tratamientos (id_tratamiento, sintoma, pauta_medicacion, pauta_reducida, tipo, fecha_inicio, fecha_fin, id_consulta, id_medicamento) 
VALUES (null, :sintoma, :pauta_medicacion, :pauta_reducida, :tipo, :fecha_inicio, :fecha_fin, :id_consulta, :id_medicamento)";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(":sintoma", $sintoma);
            $resultado->bindParam(":pauta_medicacion", $pauta_medicacion);
            $resultado->bindParam(":pauta_reducida", $pauta_reducida);
            $resultado->bindParam(":tipo", $tipo);
            $resultado->bindParam(":fecha_inicio", $fecha_inicio);
            $resultado->bindParam(":fecha_fin", $fecha_fin);
            $resultado->bindParam(":id_consulta", $id_consulta);
            $resultado->bindParam(":id_medicamento", $id_medicamento);
            $resultado->execute();
            $conexion = null;

            $filas = $resultado->rowCount();
            return $filas;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    public static function selectMedicacion()
    {
        try {
            $conexion = self::getConnection();

            $sql = "SELECT * FROM medicacion";
            $resultado = $conexion->query($sql);
            $conexion = null;

            $fila = $resultado->fetchAll();
            return $fila;

        } catch (Exception $error) {
            echo($error->getMessage());
        }
    }

    /**
     * todo → OBTIENE CONSULTAS CON ID_CITA
     *SELECT * FROM citas, consultas
     * WHERE consultas.id_cita = citas.id_cita
     * AND citas.id_cita = :id_cita;
     */

    /**
     * todo → OBTIENE TRATAMIENTOS CON ID_CONSULTA
     * SELECT tratamientos.* FROM tratamientos
     * JOIN consultas ON tratamientos.id_consulta = consultas.id_consulta
     * WHERE tratamientos.id_consulta = :id_consulta;
     */

    /**
     * todo→    OBTENER ID CITA a través de la fecha, especialidad y id_dependiente
     * SELECT id_cita FROM citas
     * JOIN
     * dependientes ON citas.id_dependiente = dependientes.id_dependiente
     * WHERE citas.fecha = '2023-12-07'
     * AND citas.especialidad = 'Psiquiatría'
     * AND dependientes.id_dependiente = 3;
     *
     * SELECCIONAR CONSULTA A PARTIR DE UNA ID DE CITA
     * SELECT id_consulta FROM consultas WHERE id_cita = :id_cita
     *
     * SELECCIONAR TRATAMIENTOS A PARTIR DE UNA ID DE CONSULTA
     * SELECT id_tratamiento FROM tratamientos WHERE id_consulta = :id_consulta
     *
     * SELECT DISTINCT
     * T.id_tratamiento,
     * CONCAT (P.nombre, ' ', P.apellidos) AS residente,
     * T.diagnostico,
     * T.pauta_medicacion,
     * T.pauta_reducida,
     * T.tipo,
     * T.fecha_inicio,
     * T.fecha_fin,
     * M.nombre_comercial AS nombre_medicamento,
     * C.id_consulta,
     * C.nombre_medico,
     * C.motivo_visita,
     * C.descripcion AS descripcion_consulta,
     * C.id_cita,
     * CI.fecha AS fecha_cita,
     * CI.hora AS hora_cita,
     * CI.centro,
     * CI.localidad,
     * CI.provincia,
     * CI.direccion AS direccion_cita
     * FROM TRATAMIENTOS T
     * JOIN CONSULTAS C ON T.id_consulta = C.id_consulta
     * JOIN CITAS CI ON C.id_cita = CI.id_cita
     * JOIN DEPENDIENTES D ON CI.id_dependiente = D.id_dependiente
     * JOIN PERSONAS P ON D.dni_dependiente = P.dni_persona
     * JOIN MEDICACION M ON T.id_medicamento = M.id_medicamento
     * #WHERE P.dni_persona = '90123456R';
     * #WHERE C.id_consulta = 2;
     * WHERE D.id_dependiente = 1;
     */

    /**
     * CITAS DEL DIA Y DEL DIA DESPUES
     * SELECT * FROM incidencias
     * WHERE incidencias.fecha = CURRENT_DATE;
     *
     * SELECT * FROM incidencias
     * WHERE incidencias.fecha = CURRENT_DATE + 1;
     */

    /**********************************************
     * SELECT
     * INCIDENCIAS.descripcion,
     * INCIDENCIAS.fecha,
     * TRABAJADOR.nombre AS nombre_trabajador,
     * DEPENDIENTE.nombre AS nombre_dependiente
     * FROM
     * INCIDENCIAS
     * JOIN
     * TRABAJADORES ON INCIDENCIAS.id_trabajador = TRABAJADORES.id_trabajador
     * JOIN
     * PERSONAS AS TRABAJADOR ON TRABAJADORES.dni_trabajador = TRABAJADOR.dni_persona
     * JOIN
     * DEPENDIENTES ON INCIDENCIAS.id_dependiente = DEPENDIENTES.id_dependiente
     * JOIN
     * PERSONAS AS DEPENDIENTE ON DEPENDIENTES.dni_dependiente = DEPENDIENTE.dni_persona
     * ORDER BY incidencias.fecha DESC;
     */

    /**
     * ADMIN
     *
     * MOSTRAR TODOS LOS TRABAJADORES
     * SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, t.usuario, t.rol, t.id_trabajador
     * FROM personas p
     * INNER JOIN trabajadores t
     * ON p.dni_persona = t.dni_trabajador;
     *
     * MOSTRAR TODOS LAS PERSONAS DEPENDIENTES
     * SELECT p.dni_persona, p.nombre, p.apellidos, p.fecha_nacimiento, p.direccion, p.localidad, p.provincia, p.telefono, p.email, d.nivel_dependencia, d.num_habitacion, d.id_dependiente
     * FROM personas p, dependientes d
     * WHERE p.dni_persona = d.dni_dependiente;
     */
}