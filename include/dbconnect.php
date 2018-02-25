<?php
	try {
		$conn = new PDO ('mysql:host=mysql.hostinger.fr;dbname=u962236625_film', 'u962236625_said', '036683204', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}
  
	catch(Exception $e)
	{
		die('Erreur :'.$e->getMessage());
	}
?>