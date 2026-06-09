
<?php
class User {
    // Fonction d'authentification avec LDAP.
    public static function authentifier($login, $password) {
        // Connexion à LDAP.
        $connex = ldap_connect(LDAP_SERVER);
        ldap_set_option($connex, LDAP_OPT_PROTOCOL_VERSION, 3);

        if (!$connex) {
            return ['success' => false, 'message' => 'Connexion LDAP échouée'];
        }

        ldap_bind($connex);

        // Requête LDAP sécurisée pour éviter les injections LDAP.
        $req = 'supannAliasLogin=' . ldap_escape($login, '', LDAP_ESCAPE_FILTER);
        $res = ldap_search($connex, LDAP_ROOT_DN, $req);
        $datas = ldap_get_entries($connex, $res);

        if ($datas['count'] > 0) {
            // Vérification du mot de passe avec ldap_bind.
            $uid = $datas[0]['uid'][0];
            $dn = 'uid=' . $uid . ',' . LDAP_ROOT_DN;

            if (@ldap_bind($connex, $dn, $password)) {
                return [
                    'success' => true,
                    'prenom' => $datas[0]['givenname'][0],
                    'nom' => $datas[0]['sn'][0]
                ];
            } else {
                return ['success' => false, 'message' => 'Mot de passe incorrect'];
            }
        } else {
            return ['success' => false, 'message' => 'Utilisateur non trouvé'];
        }
    }

   
}
