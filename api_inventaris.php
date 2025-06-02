<?php
require_once "config.php"; // koneksi ke DB

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
   case 'GET':
      if (!empty($_GET["id_inventaris"])) {
         $id = intval($_GET["id_inventaris"]);
         get_inventaris($id);
      } else {
         get_all_inventaris();
      }
      break;

   case 'POST':
      if (!empty($_GET["id_inventaris"])) {
         $id = intval($_GET["id_inventaris"]);
         update_inventaris($id);
      } else {
         insert_inventaris();
      }
      break;

   case 'DELETE':
      $id = intval($_GET["id_inventaris"]);
      delete_inventaris($id);
      break;

   default:
      header("HTTP/1.0 405 Method Not Allowed");
      break;
}

// GET all
function get_all_inventaris() {
   global $mysqli;
   $query = "SELECT i.*, k.nama_kategori FROM inventaris i LEFT JOIN kategori k ON i.id_kategori = k.id_kategori";
   $result = $mysqli->query($query);
   $data = [];

   while ($row = mysqli_fetch_object($result)) {
      $data[] = $row;
   }

   $response = [
      'status' => 1,
      'message' => 'Get List Inventaris Successfully.',
      'data' => $data
   ];
   header('Content-Type: application/json');
   echo json_encode($response);
}

// GET by ID
function get_inventaris($id = 0) {
   global $mysqli;
   $query = "SELECT i.*, k.nama_kategori FROM inventaris i LEFT JOIN kategori k ON i.id_kategori = k.id_kategori WHERE id_inventaris = $id LIMIT 1";
   $result = $mysqli->query($query);
   $data = [];

   while ($row = mysqli_fetch_object($result)) {
      $data[] = $row;
   }

   $response = [
      'status' => 1,
      'message' => 'Get Inventaris Successfully.',
      'data' => $data
   ];
   header('Content-Type: application/json');
   echo json_encode($response);
}

// POST insert
function insert_inventaris() {
   global $mysqli;

   $data = json_decode(file_get_contents('php://input'), true);

   $check = array('nama_barang' => '', 'jumlah' => '', 'id_kategori' => '');
   $valid = count(array_intersect_key($data, $check)) === count($check);

   if ($valid) {
      $nama_barang = $mysqli->real_escape_string($data["nama_barang"]);
      $jumlah = intval($data["jumlah"]);
      $id_kategori = intval($data["id_kategori"]);

      $result = $mysqli->query("INSERT INTO inventaris (nama_barang, jumlah, id_kategori) VALUES ('$nama_barang', $jumlah, $id_kategori)");

      if ($result) {
         $response = ['status' => 1, 'message' => 'Inventaris Added Successfully.'];
      } else {
         $response = ['status' => 0, 'message' => 'Inventaris Addition Failed.'];
      }
   } else {
      $response = ['status' => 0, 'message' => 'Invalid Parameters'];
   }

   header('Content-Type: application/json');
   echo json_encode($response);
}

// POST update
function update_inventaris($id) {
   global $mysqli;
   $data = json_decode(file_get_contents("php://input"), true);

   $check = array('nama_barang' => '', 'jumlah' => '', 'id_kategori' => '');
   $valid = count(array_intersect_key($data, $check)) === count($check);

   if ($valid) {
      $nama_barang = $mysqli->real_escape_string($data["nama_barang"]);
      $jumlah = intval($data["jumlah"]);
      $id_kategori = intval($data["id_kategori"]);

      $result = $mysqli->query("UPDATE inventaris SET nama_barang = '$nama_barang', jumlah = $jumlah, id_kategori = $id_kategori WHERE id_inventaris = $id");

      if ($result) {
         $response = ['status' => 1, 'message' => 'Inventaris Updated Successfully.'];
      } else {
         $response = ['status' => 0, 'message' => 'Inventaris Update Failed.'];
      }
   } else {
      $response = ['status' => 0, 'message' => 'Invalid Parameters'];
   }

   header('Content-Type: application/json');
   echo json_encode($response);
}

// DELETE
function delete_inventaris($id) {
   global $mysqli;
   $query = "DELETE FROM inventaris WHERE id_inventaris = $id";
   $result = $mysqli->query($query);

   if ($result) {
      $response = ['status' => 1, 'message' => 'Inventaris Deleted Successfully.'];
   } else {
      $response = ['status' => 0, 'message' => 'Inventaris Deletion Failed.'];
   }

   header('Content-Type: application/json');
   echo json_encode($response);
}
?>
