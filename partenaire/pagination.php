<?php

//on récupére le nombre de partenaire
$count=$connexion->prepare("SELECT count(*) as cpt From partenaire");
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
try{
    $sel=$connexion->prepare("select partenaire from partenaire limit $debut,$nb_element_par_page");
    $sel->setFetchMode(PDO::FETCH_ASSOC);
    $sel->execute();
    $tab=$sel->fectAll();
}catch(\Exception $exception){
    echo 'Erreur lors de la requette servant à faire la pagination. : ' . $exception->getMessage();
	exit;
}
if(count($tab)==0){
    header("locatation:./");
}
?>