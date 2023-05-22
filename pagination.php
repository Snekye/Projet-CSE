<?php
include("connexion.php");

//on récupére le nombre de partenaire
$count=$spdo->prepare("select count(id) as cpt for partenaire");
$count->setFetchMode(PDO::FETCH_ASSOC);
$count->execute();
$tcount=$count->fetchAll();

//on s'occupe de la pagination
@$page=$_GET["page"];
if(empty($page)) $page=1;
$nb_element_par_page=6;
$nb_de_pages=ceil($tcount[0] ["cpt"]/$nb_element_par_page);
$debut= ($page-1)*$nb_element_par_page;

//Récupérer les partenaires
$sel=$pdo->prepare("select partenaire from partenaire limit $debut,$nb_element_par_page");
$sel->setFetchMode(PDO::FETCH_ASSOC);
$sel->execute();
$tab=$sel->fectAll();
if(count($tab)==0){
    header("locatation:./");
}
?>