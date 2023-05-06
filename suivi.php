<link rel="stylesheet" type="text/css" href="CSS/suivi.css">
<?php
session_start();

if (isset($_GET['suivi']))
{

    if (!isset($_SESSION['nbdrone']))
    {
        //echo "La variable suivi existe !";
        header('Location:rest.php?suivi');
    }
    else
    {
        $nbdrone=$_SESSION['nbdrone']; 
        $nbutilisateur=$_SESSION['nbutilisateur'];
        $nbvol=$_SESSION['nbvol'];
    
        //echo "Nombre de drone:".$_SESSION['nbdrone'];
        echo "<div class='statistique'><a href='suivi.php?listeDrones'>";
        echo "<p class='statistique_icone'><img src='Image/Icones/drone.svg'></p>";
        echo "<p class='statistique_valeur'>$nbdrone</p></a></div>";

        unset($_SESSION['nbdrone']);

        //echo "Nombre de vol:".$_SESSION['nbvol'];
        echo "<div class='statistique'><a href='suivi.php?listeVols'>";
        echo "<p class='statistique_icone'><img src='Image/Icones/fly.svg'></p>";
        echo "<p class='statistique_valeur'>$nbvol</p></a></div>";

        unset($_SESSION['nbvol']);


        //echo " Nombre d'utilisateur:".$_SESSION['nbutilisateur'];
        echo "<div class='statistique'><a href='suivi.php?listeUtilisateurs'>";
        echo "<p class='statistique_icone'><img src='Image/Icones/man.svg'></p>";
        echo "<p class='statistique_valeur'>$nbutilisateur</p></a></div>";

        unset($_SESSION['nbutilisateur']);
        
        
    }
}

if(isset($_GET["listeDrones"]))
{
    if(!isset($_SESSION["listeDrones"]))
    {
        header("Location:rest.php?listeDrones");
    }
    else
    {
        //print_r($_SESSION["listeDrones"]);
        $table = '<table><tr><td>Numero drone </td>
                            <td>Marque</td>
                            <td>Modèle</td>
                            <td>Référence</td>
                            <td>Date achat</td>
                            <td>Action</td></tr>';
                            /*<tr><td><input type="text" value="N° Drone"></td>
                            <td><input type="text" value="Marque"></td>
                            <td><input type="text" value="Modèle"></td>
                            <td><input type="text" value="Référence"></td>
                            <td><input type="text" value="Date achat"></td></tr>';*/
        
        for($i=0; $i<COUNT($_SESSION['listeDrones']); $i++)
        {
            $listeDrones = $_SESSION['listeDrones'][$i];
            $table.='<tr><form action = "rest.php" method="POST">';
            foreach($listeDrones as $cle => $value)
            {
                if($cle=="iddrone")
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" readonly></th>';
                }
                else
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" required></th>';
                }
                
            }
            $table.='<th><input type="submit" name= "MettreAJourListeDrone" value="Mise à jour"></th></form></tr>';
        }
        $table.='</table>';
        echo $table;

    }
}

if(isset($_GET["listeVols"]))
{
    if(!isset($_SESSION["listeVols"]))
    {
        header("Location:rest.php?listeVols");
    }
    else
    {
        //print_r($_SESSION["listeDrones"]);
        $table = '<table><tr><td>Numero vol </td>
                            <td>Utilisateur</td>
                            <td>Date du vol</td>
                            <td>Numero du drone</td>
                            <td>Date achat</td></tr>';
                           
        for($i=0; $i<COUNT($_SESSION['listeVols']); $i++)
        {
            $listeVols = $_SESSION['listeVols'][$i];
            $table.='<tr><form action = "rest.php" method="POST">';
            foreach($listeVols as $cle => $value)
            {
                if($cle=="idvol")
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" readonly></th>';
                }
                else
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" required></th>';
                }
                
            }
            $table.='<th><input type="submit" name= ="MettreAJourListeVols" value="Mise à jour"></th></form>';
        }
        $table.='</table>';
        echo $table;

    }
}

if(isset($_GET["listeUtilisateurs"]))
{
    if(!isset($_SESSION["listeUtilisateurs"]))
    {
        header("Location:rest.php?listeUtilisateurs");
    }
    else
    {
        //print_r($_SESSION["listeDrones"]);
        $table = '<table><tr><td>ID Utilisateur</td>
                            <td>nom</td>
                            <td>prenom</td>
                            <td>email</td>
                            <td>naissance</td>
                            <td>pseudo</td>
                            <td>mdp</td></tr>';
                          
        
        for($i=0; $i<COUNT($_SESSION['listeUtilisateurs']); $i++)
        {
            $listeUtilisateurs = $_SESSION['listeUtilisateurs'][$i];
            $table.='<tr><form action = "rest.php" method="POST">';
            foreach($listeUtilisateurs as $cle => $value)
            {
                if($cle=="idutilisateur")
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" readonly></th>';
                }
                else
                {
                    $table.='<th><input type="text" name= "'.$cle.'" value="'.$value.'" ></th>';
                }
                
            }
            $table.='<th><input type="submit" name="MettreAJourListeUtilisateur" value="MettreAJourListeUtilsateurs"></th></tr></form>';
        }
        $table.='</table>';
        echo $table;

    }
}
?>