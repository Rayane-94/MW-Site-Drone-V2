<?php
session_start();

$mydb=new PDO('mysql:host=localhost;dbname=MW04_drone_rayane;charset=utf8','rayanebesrour','rayane'); 
if(!empty($_POST))
{
    if (isset($_POST['valider']))
    {
        print_r($_POST);  

        $pseudo=$_POST['pseudo_utilisateur'];
        $mdp=$_POST['mdp_utilisateur'];
        $req="select nom,prenom from utilisateur where pseudo=? and mdp=?";
        $reqpreparer=$mydb->prepare($req);
        $tableauDeDonnees=array($pseudo,$mdp);
        $reqpreparer->execute($tableauDeDonnees);
        $reponse=$reqpreparer->fetchALL(PDO::FETCH_ASSOC);
        //print_r($req);
        $reponsedb=count($reponse);
        if($reponsedb<1){

            echo"erreur";
            header("Location:formulaire_connexion.php?erreur=pseudo");
        }
        else{
            echo"good";
            header("Location:formulaire_connexion.php?bien_jouer");
       
        }
        $reqpreparer->closeCursor();
    }
}



            // Partie Inscription


if (isset($_POST['inscription']))
{   


                print_r($_POST); 

                // $mydb = new PDO('mysql:host=localhost;dbname=MW04_drone_rayane;charset_utf8','rayanebesrour','rayane');
                $nom = $_POST["nom_utilisateur"];
                $prenom=$_POST["prenom_utilisateur"];
                $naissance=$_POST["date"];
                $mail=$_POST["email"];
                $pseudo=$_POST["pseudo_utilisateur"];
                $mdp=$_POST["mdp1_utilisateur"];
                $req="select nom,prenom from utilisateur where pseudo=?";




                $req='SELECT nom from utilisateur where pseudo=?';
                $reqpreparer=$mydb->prepare($req);
                $tableauDeDonnees=array($pseudo);
                $reqpreparer->execute($tableauDeDonnees);
                $reponse=$reqpreparer->fetchALL(PDO::FETCH_ASSOC);

            
                    if (count($reponse)!=0)
                    {
                        header("location:formulaire_inscription.php?erreur=pseudo");
                    }
                    else
                    {
                    $req="INSERT INTO utilisateur (pseudo,nom,mdp) values (?,?,?)";
                    $req=$mydb->prepare($req);
                    $tableauDeDonnees=array($pseudo,$nom,$prenom);
                    $reqpreparer->execute($tableauDeDonnees);
                    header("Location:formulaire_inscription.php?pseudo=.$pseudo");

                    }
}

if(isset($_GET['suivi']))
{
    $requete ="SELECT COUNT(iddrone) AS nbdrone FROM drone WHERE 1";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    echo "<br/>NB drone :".$reponse[0]["nbdrone"];

    $res->closeCursor();
    $_SESSION['nbdrone']=$reponse[0]["nbdrone"];

   /*$requete = "SELECT COUNT(iddrone) AS nb FROM drone";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    //print_r($reponse);
    //echo "<br/>NBom Marque :".$reponse[0]["nbdrone"];

   /* $_SESSION['nbdrone']=15;
    $_SESSION['nbutilisateur']=10;
    $_SESSION['nbVole']=50;
    //header('location:suivi.php?suivi');
    */

    $requete = "SELECT COUNT(idutilisateur) AS nbutilisateur FROM utilisateur ";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    echo "<br/>NB utilisateur :".$reponse[0]["nbutilisateur"];

    $res->closeCursor();
    $_SESSION['nbutilisateur']=$reponse[0]["nbutilisateur"];

    
    $requete ="SELECT COUNT(idvol) AS nbvol FROM vol";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    echo "<br/>NB vol :".$reponse[0]["nbvol"];

    $res->closeCursor();
    $_SESSION['nbvol']=$reponse[0]["nbvol"];

    header('location:suivi.php?suivi'); 
   
}

if(isset($_GET['listeDrones']))
{
    $requete ="SELECT * FROM drone";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    $res->closeCursor();
    $_SESSION['listeDrones']= $reponse;
    header("Location:suivi.php?listeDrones");
}
if(isset($_GET['listeVols']))
{
    $requete ="SELECT * FROM vol";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    $res->closeCursor();
    $_SESSION['listeVols']= $reponse;
    header("Location:suivi.php?listeVols");
}

if(isset($_GET['listeUtilisateurs']))
{
    $requete ="SELECT * FROM utilisateur";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array();
    $res->execute($tableauDeDonnees);
    $reponse=$res->fetchALL(PDO::FETCH_ASSOC);
    $res->closeCursor();
    $_SESSION['listeUtilisateurs']= $reponse;
    header("Location:suivi.php?listeUtilisateurs");
}
if(isset($_POST['MettreAJourListeDrone']))
{
    foreach($_POST as $cles=>$val) $$cles=$val;
    $requete ="UPDATE drone set marque=?,refDrone=?,modele=?,dateAchat=? where iddrone=?";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array($marque,$refDrone,$modele,$dateAchat,$iddrone);
    $res->execute($tableauDeDonnees);
    header("Location:suivi.php?listeDrones");
    $res->closeCursor();
    unset($_SESSION['listeDrones']);
}
if(isset($_POST['MettreAJourListeVols']))
{
    foreach($_POST as $cles=>$val) $$cles=$val;
    $requete ="UPDATE vol set idutilisateur=?,dateVol=?,iddrone=? where idvol=?";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array($idutulisateur,$dateVol,$iddrone,$idvol);
    $res->execute($tableauDeDonnees);
    header("Location:suivi.php?ListeVols");
    $res->closeCursor();
    unset($_SESSION['ListeVols  ']);
}
if(isset($_POST['MettreAJourListeUtilisateur']))
{
    foreach($_POST as $cles=>$val) $$cles=$val;
    $requete ="UPDATE utilisateur set nom=?,prenom=?,email=?,naissance=?,pseudo=? where idutilisateur=?";
    $res=$mydb->prepare($requete);
    $tableauDeDonnees=array($nom,$prenom,$email,$naissance,$pseudo,$idutilisateur);
    $res->execute($tableauDeDonnees);
    header("Location:suivi.php?listeUtilisateurs");
    $res->closeCursor();
    unset($_SESSION['listeUtilisateurs']);
}
?>