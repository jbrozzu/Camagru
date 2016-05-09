<?php
 
session_start();


// Constantes
define('TARGET', './files/');    // Repertoire cible
define('MAX_SIZE', 1000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 2000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 1000);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/

if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/

if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
 
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = 'upload.png';
 
            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
              $_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Upload réussi !</div>';
              header('Location: cam.php?img=upload');
              die;
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $_SESSION['ERROR_MESSAGE'] = '<div id="error">Problème lors de l\'upload !</div>';
            }
          }
          else
          {
            $_SESSION['ERROR_MESSAGE'] = '<div id="error">Une erreur interne a empêché l\'upload de l\'image</div>';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $_SESSION['ERROR_MESSAGE'] = '<div id="error">Erreur dans les dimensions de l\'image !</div>';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $_SESSION['ERROR_MESSAGE'] = '<div id="error">Le fichier à uploader n\'est pas une image !</div>';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $_SESSION['ERROR_MESSAGE'] = '<div id="error">L\'extension du fichier est incorrecte !</div>';
    }
  }
  else {
    // Sinon on affiche une erreur pour le champ vide
    $_SESSION['ERROR_MESSAGE'] = '<div id="error">Veuillez selectionner un fichier svp !</div>';
  }
}

header('Location: cam.php');

?>