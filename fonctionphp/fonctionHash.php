<?php
// ------------------------Fonction pour de Hash------------------------//
function hashPassword($mdp){
    $options = ['cost' => 12];
    $hashed_password = password_hash($mdp, PASSWORD_BCRYPT, $options);
    return $hashed_password;
}
?>