<?php 
use App\Entity\User;

$user = new User();
$form = $this->createForm(TaskType::class, $user);

?>