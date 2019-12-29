<?php

function isEmpty($val) {
    if (!is_string($val))
        return true; //是否是字符串类型 

    if (empty($val))
        return true; //是否已设定 

    if ($val == '')
        return true; //是否为空 

    return false;
}

function isEmail($val) {
    if (preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val)) {
        return TRUE;
    } else
        return FALSE;
}

function valid($a, $b) {
    require ("database_connection.php");
    $sql = "select password from employees where username='" . $a . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $var = $row[0];
    if ($b==$var) {
        return true;
    } else
        return false;
}

/* function filter_string($string) {
  $string = trim($string);
  $string = strip_tags($string);
  return $string;
  }

  function filter_email($email) {
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  return true;
  } else {
  return false;
  }
  }

  function is_customer_email_exits($email) {

  global $conn;

  $email_check = "SELECT `email` FROM `customers` WHERE email='$email'";

  $result = $conn->query($email_check);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  return false;
  }
  } else {
  return true;
  }
  }

  function is_employee_email_exits($email) {

  global $conn;

  $email_check = "SELECT `email` FROM `employees` WHERE email='$email'";

  $result = $conn->query($email_check);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  return false;
  }
  } else {
  return true;
  }
  }

  function do_passwords_match($passwords) {

  $password = $passwords['password'];
  $confirm_password = $passwords['confirm_password'];

  if ($password == $confirm_password) {
  return true;
  }
  return false;
  }

  function create_customer($new_user_data) {

  global $conn;
  // var_dump($conn);

  $name = $new_user_data['name'];
  $surname = $new_user_data['SurName'];
  $email = $new_user_data['email'];
  $password = $new_user_data['password'];

  $password = md5($password);


  $new_user_query = "INSERT INTO `customers`( `first_name`, `last_name`, `email`, `password`) VALUES ( '$name', '$surname' , '$email', '$password')";

  if ($conn->query($new_user_query) === TRUE) {
  return true;
  } else {

  return false;
  }
  }

  function login_customer($new_user_data) {

  global $conn;

  $email = $new_user_data['email'];
  $password = $new_user_data['password'];

  $pass = md5($password);


  $user_exists = "SELECT `id`, `first_name`, `last_name`, `email` FROM `customers` WHERE email='$email' AND password='$pass'";

  $result = $conn->query($user_exists);

  if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $_SESSION['user'] = $row;
  return true;
  } else {
  return false;
  }
  }

  function create_manager($new_user_data) {

  global $conn;
  // var_dump($conn);

  $name = $new_user_data['name'];
  $surname = $new_user_data['SurName'];
  $email = $new_user_data['email'];
  $password = $new_user_data['password'];

  $password = md5($password);


  $new_user_query = "INSERT INTO `employees`(`id`, `first_name`, `last_name`, `email`, `password`,`employee_designation`) VALUES ( '1','$name', '$surname' , '$email', '$password','manager')";

  if ($conn->query($new_user_query) === TRUE) {
  return true;
  } else {

  return false;
  }
  }

  function is_admin_designation_exits($designation) {

  global $conn;

  $designation_check = "SELECT `employee_designation` FROM `employees` WHERE employee_designation='$designation'";

  $result = $conn->query($designation_check);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  return false;
  }
  } else {
  return true;
  }
  }

  function is_chef_designation_exits($designation) {

  global $conn;

  $designation_check = "SELECT `employee_designation` FROM `employees` WHERE employee_designation='$designation'";

  $result = $conn->query($designation_check);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  return false;
  }
  } else {
  return true;
  }
  }

  function create_employee($new_user_data) {

  global $conn;
  // var_dump($conn);

  $name = $new_user_data['name'];
  $surname = $new_user_data['SurName'];
  $email = $new_user_data['email'];
  $password = $new_user_data['password'];
  $designation = $new_user_data['designation'];

  $password = md5($password);


  $new_user_query = "INSERT INTO `employees`( `first_name`, `last_name`, `email`, `password`,`employee_designation`) VALUES ( '$name', '$surname' , '$email', '$password','$designation')";

  if ($conn->query($new_user_query) === TRUE) {
  return true;
  } else {

  return false;
  }
  }

  function login_employee($new_user_data) {

  global $conn;

  $email = $new_user_data['email'];
  $password = $new_user_data['password'];

  $pass = md5($password);


  $user_exists = "SELECT `id`, `first_name`, `last_name`, `email`,`employee_designation`  FROM `employees` WHERE email='$email' AND password='$pass'";

  $result = $conn->query($user_exists);

  if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $_SESSION['employee'] = $row;
  return true;
  } else {
  return false;
  }
  }

  function get_menu_data() {
  global $conn;

  $get_menu_data = "SELECT * FROM `menu` ";


  $result = $conn->query($get_menu_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $menu_data[] = $row;
  }
  return $menu_data;
  } else {
  return false;
  }
  }

  function insert_menu_item($item_data) {
  global $conn;

  $name = $item_data['name'];
  $discription = $item_data['discription'];
  $price = $item_data['price'];
  $image = $item_data['imagename'];


  $insert = "INSERT INTO `menu`( `name`, `discription`, `price`, `image`) VALUES ('$name','$discription','$price','$image')";
  if ($conn->query($insert) === TRUE) {
  return $insert;
  } else {

  return false;
  }
  }

  function update_menu_item($item_data) {
  global $conn;

  $id = $item_data['id'];
  $name = $item_data['name'];
  $discription = $item_data['discription'];
  $price = $item_data['price'];
  $image = $item_data['imagename'];


  $update = "UPDATE `menu` SET `name`='$name',`discription`='$discription',`price`='$price',`image`='$image' WHERE id=$id";
  if ($conn->query($update) === TRUE) {
  return $update;
  } else {

  return false;
  }
  }

  function delete_menu_item($id) {
  global $conn;

  $delete_item = "DELETE FROM `menu` WHERE id=$id";
  if ($conn->query($delete_item) === TRUE) {

  return true;
  } else {

  return false;
  }
  }

  function get_grocery_data() {
  global $conn;

  $get_grocery_data = "SELECT * FROM `groceries` ";


  $result = $conn->query($get_grocery_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $grocery_data[] = $row;
  }
  return $grocery_data;
  } else {
  return false;
  }
  }

  function insert_grocery_item($item_data) {
  global $conn;

  $name = $item_data['name'];
  $amount = $item_data['amount'];


  $insert = "INSERT INTO `groceries`( `name`, `amount`) VALUES ('$name','$amount')";
  if ($conn->query($insert) === TRUE) {
  return $insert;
  } else {

  return false;
  }
  }

  function delete_grocery_item($id) {
  global $conn;

  $delete_item = "DELETE FROM `groceries` WHERE id=$id";
  if ($conn->query($delete_item) === TRUE) {

  return $delete_item;
  } else {

  return false;
  }
  }

  function place_order($order_detail) {
  global $conn;

  $user_id = $order_detail['user_id'];
  $item_id = $order_detail['item_id'];
  $price = $order_detail['price'];
  $token = $order_detail['token_availed'];

  $place_order = "INSERT INTO `orders`( `user_id`, `item_id`, `total_price`, `time`, `admin_view`, `coupon_availed`, `chef_view`) VALUES ('$user_id','$item_id','$price','0','0','$token','0')";

  if ($conn->query($place_order) === TRUE) {
  return true;
  } else {

  return false;
  }
  }

  function get_customer_order_data($id) {
  global $conn;

  $get_order_data = "SELECT *
  FROM orders o
  INNER JOIN customers c
  on c.id =o.user_id
  INNER JOIN menu m
  on m.id = o.item_id

  WHERE o.user_id=$id ORDER BY order_id DESC";


  $result = $conn->query($get_order_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $order_data[] = $row;
  }
  return $order_data;
  } else {
  return false;
  }
  }

  function get_admin_order_data() {
  global $conn;

  $get_order_data = "SELECT *
  FROM orders o
  INNER JOIN customers c
  on c.id = o.user_id
  INNER JOIN menu m
  on m.id = o.item_id ORDER BY order_id DESC";


  $result = $conn->query($get_order_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $order_data[] = $row;
  }
  return $order_data;
  } else {
  return false;
  }
  }

  function get_chef_order_data() {
  global $conn;

  $get_order_data = "SELECT *
  FROM orders o
  INNER JOIN customers c
  on c.id = o.user_id
  INNER JOIN menu m
  on m.id = o.item_id
  WHERE o.admin_forward=1 ORDER BY order_id DESC";


  $result = $conn->query($get_order_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $order_data[] = $row;
  }
  return $order_data;
  } else {
  return false;
  }
  }

  function forward_to_chef($id) {
  global $conn;

  $update_query = "UPDATE `orders` SET admin_forward=1 WHERE order_id=$id";
  if ($conn->query($update_query) === TRUE) {

  return $update_query;
  } else {

  return false;
  }
  }

  function update_time($order_data) {
  global $conn;

  $id = $order_data['order_id'];
  $time = $order_data['time'];

  $update_query = "UPDATE `orders` SET `time`='$time' WHERE order_id=$id";
  if ($conn->query($update_query) === TRUE) {

  return $update_query;
  } else {

  return false;
  }
  }

  function insert_coupon($coupon_data) {
  global $conn;

  $discription = $_POST['discription'];
  $amount = $_POST['amount'];
  $valid_till = $_POST['valid'];


  $new_user_query = "INSERT INTO `coupons`(`discription`, `amount`, `valid`) VALUES ( '$discription', '$amount' , '$valid_till')";

  if ($conn->query($new_user_query) === TRUE) {
  return true;
  } else {

  return false;
  }
  }

  function get_coupons_data() {
  global $conn;

  $get_coupon_data = "SELECT * FROM `coupons` ORDER BY id DESC";


  $result = $conn->query($get_coupon_data);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $coupon_data[] = $row;
  }
  return $coupon_data;
  } else {
  return false;
  }
  }

  function chck_if_day_passed($date) {
  $tz = 'Asia/Karachi';
  $timestamp = time();
  $dt = new DateTime("now", new DateTimeZone($tz));
  $dt->setTimestamp($timestamp);


  $now_timestamp = strtotime($dt->format('d.m.Y H:i:s'));

  $dif = $now_timestamp - strtotime($date);

  if ($dif > 86400) {
  return true;
  } else {
  return false;
  }
  }

  function is_customer_loggedin() {
  if (isset($_SESSION['user']) && $_SESSION['user']) {
  return true;
  }
  return false;
  }

  function get_customer_data() {
  if (!is_customer_loggedin()) {
  return false;
  } else {
  return $_SESSION['user'];
  }
  }*/

  function is_employee_loggedin() {
  if (isset($_SESSION['employee'])) {
  return true;
  }
  return false;
  }

  function get_employee_data() {
  if (!is_employee_loggedin()) {
  return false;
  } else {
  return $_SESSION['employee'];
  }
  }
 
?>