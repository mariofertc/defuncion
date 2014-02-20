<?php
$con = mysql_connect('localhost','root','yoyo'); 
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  echo "Si se conecta con bdd";
  mysql_close($con);