<?php
require_once('Databases.php');
session_start();
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=date-'.$_SESSION['login_user'].'.csv');

$output = fopen('php://output', 'w');

$vectorTitlu = array('Titlu parola', 'Cont', 'Parola','Adresa Web','Data adaugare','Timp maxim de valabilitate','Comentarii','tarieParola', 'frecventaUtilizare', 'domeniuSite');
fputcsv($output, $vectorTitlu);

$interogare =  "SELECT titluParola, cont, Parola, AdresaWeb, dataAdaugare, timpMaximDeValabilitate, Comentarii,tarieParola, frecventaUtilizare, domeniuSite
				FROM userpasswords, grupareparole 
				WHERE userpasswords.codGrupare = grupareparole.codGrupare and userID =".$_SESSION['USERID'];

$bazaDeDate->querySelect($interogare);
foreach ($bazaDeDate->rows() as $key) 
  fputcsv($output, $key);
?>