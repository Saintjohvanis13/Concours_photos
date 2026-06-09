<?php
session_start();
require_once("models/Admin.php");

function ctrl_admin() {


    $msg = null;
    $config = recuperer_toute_configuration();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($config as $param => $valeur_actuelle) {
            if (!empty($_POST[$param]) && $_POST[$param] != $valeur_actuelle) {
                modifier_configuration($param, $_POST[$param]);
                $config[$param] = $_POST[$param];
            }
        }
        $msg = "Dates mises à jour avec succès.";
    }

    include("views/admin_view.php");
}
