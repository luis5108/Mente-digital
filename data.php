<?php
// data.php - Contiene funciones para interactuar con la base de datos

// Incluye el archivo de conexión a la base de datos para poder usar la variable $conexion
require_once 'conexion.php';

/**
 * Obtiene todos los celulares de la base de datos.
 * @return array Un array de objetos de celulares.
 */
function getAllCelulares()
{
   // Accede a la variable de conexión global
   global $conexion;
   // Inicializa un array vacío para almacenar los celulares
   $celulares = [];
   // Define la consulta SQL para seleccionar todos los celulares, ordenados por nombre
   $sql = "SELECT * FROM celulares ORDER BY nombre ASC";
   // Ejecuta la consulta SQL en la base de datos
   $result = $conexion->query($sql);

   // Verifica si la consulta se ejecutó correctamente y si hay filas de resultados
   if ($result && $result->num_rows > 0) {
      // Itera sobre cada fila de resultados
      while ($row = $result->fetch_assoc()) {
         // Añade cada fila (celular) al array de celulares
         $celulares[] = $row;
      }
   }
   // Devuelve el array de celulares
   return $celulares;
}

/**
 * Obtiene un celular por su codigo_id de la base de datos.
 * @param string $codigo_id El codigo_id del celular.
 * @return array|null Un array asociativo del celular o null si no se encuentra.
 */
function getCelularByCodigoId($codigo_id)
{
   // Accede a la variable de conexión global
   global $conexion;
   // Prepara una consulta SQL para seleccionar un celular por su codigo_id
   $stmt = $conexion->prepare("SELECT * FROM celulares WHERE codigo_id = ?");
   // Vincula el parámetro codigo_id a la consulta preparada (s = string)
   $stmt->bind_param("s", $codigo_id);
   // Ejecuta la consulta preparada
   $stmt->execute();
   // Obtiene el resultado de la consulta
   $result = $stmt->get_result();
   // Devuelve la fila como un array asociativo, o null si no hay resultados
   return $result->fetch_assoc();
}

/**
 * Añade un nuevo celular a la base de datos.
 * @param array $data Un array asociativo con los datos del celular.
 * @return bool True si la inserción fue exitosa, false en caso contrario.
 */
function addCelular($data)
{
   // Accede a la variable de conexión global
   global $conexion;
   // Define la consulta SQL para insertar un nuevo celular
   // Se especifican todas las columnas excepto 'id' si es AUTO_INCREMENT
   $sql = "INSERT INTO celulares (codigo_id, nombre, imagen, pantalla, procesador, ram, almacenamiento, camara_principal, camara_frontal, bateria, sistema_operativo, resistencia_agua, precio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   // Prepara la consulta SQL
   $stmt = $conexion->prepare($sql);
   // Vincula los parámetros a la consulta preparada (s = string para todos)
   $stmt->bind_param(
      "sssssssssssss",
      $data['codigo_id'],
      $data['nombre'],
      $data['imagen'],
      $data['pantalla'],
      $data['procesador'],
      $data['ram'],
      $data['almacenamiento'],
      $data['camara_principal'],
      $data['camara_frontal'],
      $data['bateria'],
      $data['sistema_operativo'], // Cambiado de 'os' a 'sistema_operativo' para coincidir con la DB
      $data['resistencia_agua'],
      $data['precio']
   );
   // Ejecuta la consulta preparada y devuelve true si fue exitosa, false en caso contrario
   return $stmt->execute();
}

/**
 * Actualiza un celular existente en la base de datos.
 * @param string $codigo_id El codigo_id del celular a actualizar.
 * @param array $data Un array asociativo con los nuevos datos del celular.
 * @return bool True si la actualización fue exitosa, false en caso contrario.
 */
function updateCelular($codigo_id, $data)
{
   // Accede a la variable de conexión global
   global $conexion;
   // Define la consulta SQL para actualizar un celular por su codigo_id
   $sql = "UPDATE celulares SET nombre=?, imagen=?, pantalla=?, procesador=?, ram=?, almacenamiento=?, camara_principal=?, camara_frontal=?, bateria=?, sistema_operativo=?, resistencia_agua=?, precio=? WHERE codigo_id=?";
   // Prepara la consulta SQL
   $stmt = $conexion->prepare($sql);
   // Vincula los parámetros a la consulta preparada (s = string para todos)
   $stmt->bind_param(
      "sssssssssssss",
      $data['nombre'],
      $data['imagen'],
      $data['pantalla'],
      $data['procesador'],
      $data['ram'],
      $data['almacenamiento'],
      $data['camara_principal'],
      $data['camara_frontal'],
      $data['bateria'],
      $data['sistema_operativo'], // Cambiado de 'os' a 'sistema_operativo' para coincidir con la DB
      $data['resistencia_agua'],
      $data['precio'],
      $codigo_id // El último parámetro es el codigo_id para la cláusula WHERE
   );
   // Ejecuta la consulta preparada y devuelve true si fue exitosa, false en caso contrario
   return $stmt->execute();
}

/**
 * Elimina un celular de la base de datos.
 * @param string $codigo_id El codigo_id del celular a eliminar.
 * @return bool True si la eliminación fue exitosa, false en caso contrario.
 */
function deleteCelular($codigo_id)
{
   // Accede a la variable de conexión global
   global $conexion;
   // Prepara una consulta SQL para eliminar un celular por su codigo_id
   $stmt = $conexion->prepare("DELETE FROM celulares WHERE codigo_id = ?");
   // Vincula el parámetro codigo_id a la consulta preparada (s = string)
   $stmt->bind_param("s", $codigo_id);
   // Ejecuta la consulta preparada y devuelve true si fue exitosa, false en caso contrario
   return $stmt->execute();
}

?>