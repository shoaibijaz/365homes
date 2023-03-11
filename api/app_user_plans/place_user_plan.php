<?php

session_start();

include_once dirname(__DIR__) . '/mailer.php';

include_once '../database.php';
include_once '_user_plan.php';
include_once '../app_user_plan_payments/_user_plan_payment.php';
include_once '../app_users/_user.php';
include_once '../app_plans/_plan.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$data = $_POST;

//get plan
$plan_object = new app_plan($db);
$plan_object->id = $data['user']['plan_id'];

$stmt = $plan_object->find();
$plan_result = $stmt->fetch(PDO::FETCH_ASSOC);

//set user plan
$user_plan = new app_user_plan($db);

$user_plan->user_id = $_SESSION['login_agent']['id'];
$user_plan->plan_id = $data['user']['plan_id'];
$user_plan->total_credits = $plan_result['credits'];

$stmt = $user_plan->add_new();
$user_plan->id = $db->lastInsertId();

// set user payment details
$user_payment = new app_user_plan_payment($db);

$paymentDecoded = json_decode($data['payment']);

$user_payment->user_plan_id = $user_plan->id;
$user_payment->user_id = $user_plan->user_id ;
$user_payment->gateway = 'paypal';

$user_payment->amount_total = $paymentDecoded->amount_total;
$user_payment->amount_paid = $paymentDecoded->amount_paid;
$user_payment->data = json_encode($paymentDecoded->data);
$user_payment->details = json_encode($paymentDecoded->details);
$user_payment->order_id = $paymentDecoded->order_id;

$stmt = $user_payment->add_new();
$user_payment->id = $db->lastInsertId();

// update user credits

$user_object = new app_user($db);
$user_object->id = $user_plan->user_id;
$user_object->credits = $user_plan->total_credits;
$user_object->update_credits();

$stmt = $user_object->find();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['login_agent']= $row; 

$json = json_encode($user_payment);

echo $json;
