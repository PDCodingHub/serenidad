<?php

/**
 * Obtiene la fecha por parámetros y le cambia el formato a dia-mes-año
 * @param $fecha
 * @return string
 */
function formatoFecha($fecha)
{
    $fechaFormato = date("d-m-Y", strtotime($fecha));
    return $fechaFormato;
}

/**
 * Obtiene la hora por parámetros y le da un formato sin segundos
 * @param $hora
 * @return string
 */
function formatoHora($hora)
{
    $horaFormato = date("H:i", strtotime($hora));
    return $horaFormato;
}

/**
 * Obtiene la fecha como String por parámetros y la convierte a Date
 * Seguidamente obtiene la fecha actual y la convierte a Date
 * Compara ambas fechas y devuelve true si la fecha pasada por parámetros es igual o mayor que la fecha actual
 * @param $fecha
 * @return bool
 */
function isFechaIgualoMayorActual($fecha)
{
    $fechaDate = strtotime($fecha);
    $fechaActual = date("Y-m-d");
    $fechaActualDate = strtotime($fechaActual);
    if ($fechaDate >= $fechaActualDate) {
        return true;
    } else return false;
}

/**
 * Comprueba que la fecha pasada por parámetros es mayor que la fecha actual
 * @param $fecha
 * @return bool
 */
function isFechaMayorActual($fecha)
{
    $fechaDate = strtotime($fecha);
    $fechaActual = date("Y-m-d");
    $fechaActualDate = strtotime($fechaActual);
    if ($fechaDate > $fechaActualDate) {
        return true;
    } else return false;
}

/**
 * Se pasa por parámetros la fecha de nacimiento
 * Se obtiene la fecha actual y se le resta 18 años
 * Se compara la fecha de nacimiento con la fecha límite
 * Si la fecha de nacimiento es menor o igual que la fecha límite, la persona es mayor de 18 años. Devuelve true
 * @param $fecha
 * @return void
 */
function isMayorEdad($fecha)
{
    $fechaLimite = date("Y-m-d", strtotime("-18 years"));

    if (strtotime($fecha) <= strtotime($fechaLimite)) {
        //echo "La persona es mayor de 18 años.";
        return true;
    } else {
        //echo "La persona no es mayor de 18 años.";
        return false;
    }
}

/**
 * Se pasan 2 fechas por parámetros y comprueba si la primera es mayor o igual que la segunda
 * En caso de que sea mayor o igual, devuelve true
 * En caso de que sea menor, devuelve false
 * @param $fechaInicio
 * @param $fechaFin
 * @return bool
 */
function comparaFechas($fechaInicio, $fechaFin)
{
    $fechaInicioDate = strtotime($fechaInicio);
    $fechaFinDate = strtotime($fechaFin);
    if ($fechaFinDate >= $fechaInicioDate) {
        return true;
    } else return false;
}

/**
 * Función que comprueba que un texto pasado por parámetros no contenga ningún número
 * Si no contiene ningún número, devuelve true
 * @param $texto
 * @return bool
 */
function validaTexto($texto)
{

    //si no contiene ningun número, devuelve true
    if (!preg_match("/[0-9]/", $texto)) {
        return true;
    }
    return false;
}

/**
 * Función que comprueba que un número pasado por parámetros no contenga ningún caracter que no sea un número entero
 * Si no contiene ningún caracter que no sea un número entero, devuelve true
 * @param $numero
 * @return bool
 */
function validaNumero($numero)
{
    $comprueba = false;
    //si no contiene ningun caracter que no sea un número entero, devuelve true
    if (!preg_match("/[A-zÀ-ÿ]/", $numero)) {
        $comprueba = true;
    }
    return $comprueba;
}

/**
 * Comprueba si existe el DNI pasado por parámetros en la BBDD
 * Si existe, devuelve true
 * @param $dni
 * @return bool
 */
function encuentraDniBbdd($dni)
{
    $dniBbdd = DB::obtieneDni();
    for ($i = 0; $i < count($dniBbdd); $i++) {
        if ($dni == $dniBbdd[$i]['dni_persona']) {
            return true;
        }
    }
    return false;
}

/**
 * Comprueba si existe el número de habitación pasado por parámetros en la BBDD
 * Si existe, devuelve 2
 * Si no existe, devuelve 1
 * @param $num_habitacion
 * @return int
 */
function encuentraNumHabitacion($num_habitacion)
{
    $habitacionBbdd = DB::obtieneNumHabitacion();

    foreach ($habitacionBbdd as $fila) {

        if ($fila['num_habitacion'] == $num_habitacion) {
            return 2;
        }
    } return 1;
}
/**
 * Comprueba si la habitación pasada por parámetros está ocupada
 * Comprueba primero si la habitación está ocupada por el residente pasado por parámetros y en segundo lugar si está ocupada por otro residente
 * Si está ocupada por la persona pasada por parámetros, devuelve 1
 * Si está ocupada por otra persona, devuelve 2
 * Finalmente comprueba que ambas condiciones sean falsas. Eso significa que la habitación está libre
 * Si está libre, devuelve 3
 * @param $num_habitacion
 * @param $id_dependiente
 * @return int
 */
function comprueba_Hab_Id_Dependiente($num_habitacion, $id_dependiente){
    $resultado = DB::obtieneNumHabitacionIdDependiente();
    $habitacionPerteneceAId = false;
    $habitacionPerteneceAOtroId = false;

    foreach ($resultado as $fila) {
        if ($fila['num_habitacion'] == $num_habitacion && $fila['id_dependiente'] == $id_dependiente) {
            $habitacionPerteneceAId = true;
            return 1;
        } elseif ($fila['num_habitacion'] == $num_habitacion && $fila['id_dependiente'] != $id_dependiente) {
            $habitacionPerteneceAOtroId = true;
            return 2;
        }
    }

    $habitacionNoPerteneceANingunId = !$habitacionPerteneceAId && !$habitacionPerteneceAOtroId;
    if ($habitacionNoPerteneceANingunId) {
        return 3;
    }
}

/**
 * Comprueba si el DNI pasado por parámetros pertenece al ID Dependiente pasado por parámetros
 * Comprueba primero si el DNI pertenece al ID pasado por parámetros y en segundo lugar si pertenece a otro ID
 * Si pertenece al ID pasado por parámetros, devuelve 1
 * Si pertenece a otro ID, devuelve 2
 * Finalmente comprueba que ambas condiciones sean falsas. Eso significa que el DNI no pertenece a ningún ID
 * Si no pertenece a ningún ID, devuelve 3
 * @param $dni_dependiente
 * @param $id_dependiente
 * @return int|void
 */
function comprueba_Dni_Id_Dependiente($dni_dependiente, $id_dependiente)
{
    $resultado = DB::obtieneNumHabitacionIdDependiente();
    $dniPerteneceAId = false;
    $dniPerteneceAotroId = false;

    foreach ($resultado as $fila) {
        if ($fila['dni_dependiente'] == $dni_dependiente && $fila['id_dependiente'] == $id_dependiente) {
            $dniPerteneceAId = true;
            return 1;
        } elseif ($fila['dni_dependiente'] == $dni_dependiente && $fila['id_dependiente'] != $id_dependiente) {
            $dniPerteneceAotroId = true;
            return 2;
        }
    }

    $DniNoPerteneceANingunId = !$dniPerteneceAId && !$dniPerteneceAotroId;
    if ($DniNoPerteneceANingunId) {
        return 3;
    }
}

/**
 * Comprueba si el DNI pasado por parámetros pertenece al ID Trabajador pasado por parámetros
 * Comprueba primero si el DNI pertenece al ID pasado por parámetros y en segundo lugar si pertenece a otro ID
 * Si pertenece al ID pasado por parámetros, devuelve 1
 * Si pertenece a otro ID, devuelve 2
 * Finalmente comprueba que ambas condiciones sean falsas. Eso significa que el DNI no pertenece a ningún ID
 * Si no pertenece a ningún ID, devuelve 3
 * @param $dni_trabajador
 * @param $id_trabajador
 * @return int|void
 */
function comprueba_Dni_Id_Trabajador($dni_trabajador, $id_trabajador)
{
    $resultado = DB::obtieneDni_Id_Trabajador();
    $dniPerteneceAId = false;
    $dniPerteneceAotroId = false;

    foreach ($resultado as $fila) {
        if ($fila['dni_trabajador'] == $dni_trabajador && $fila['id_trabajador'] == $id_trabajador) {
            $dniPerteneceAId = true;
            return 1;
        } elseif ($fila['dni_trabajador'] == $dni_trabajador && $fila['id_trabajador'] != $id_trabajador) {
            $dniPerteneceAotroId = true;
            return 2;
        }
    }

    $DniNoPerteneceANingunId = !$dniPerteneceAId && !$dniPerteneceAotroId;
    if ($DniNoPerteneceANingunId) {
        return 3;
    }
}

/**
 * Comprueba si la letra del DNI introducido es correcta
 * Si es correcta, devuelve true
 * @param $dni
 * @return bool
 */
function compruebaLetraDNI($dni)
{
    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $dni = strtoupper($dni); // Convierte a mayúsculas

    // Comprueba longitud y formato del DNI
    if (strlen($dni) != 9 || !preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        return false;
    }

    // Calcula letra del DNI
    $numero = substr($dni, 0, 8);
    $letraCalculada = $letras[$numero % 23];
    $letraDNI = substr($dni, 8, 1);

    // Compara la letra calculada con la letra del DNI introducida
    if ($letraCalculada == $letraDNI) {
        return true;
    } else {
        return false;
    }
}

