<?php
// Même logique que l'exemple LDAP du TP Université de Poitiers.
// Attention : il faut que l'extension php-ldap soit activée.

if (!defined('LDAP_SERVER')) define('LDAP_SERVER', 'ldaps://ldapsupannappli.univ-poitiers.fr:636');
if (!defined('LDAP_ROOT_DN')) define('LDAP_ROOT_DN', 'ou=people,dc=univ-poitiers,dc=fr');

function ldap_authenticate($login, $pass) {
    if ($login == '' || $pass == '') {
        return false;
    }

    if (!function_exists('ldap_connect')) {
        return false;
    }

    $connex = ldap_connect(LDAP_SERVER);
    ldap_set_option($connex, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($connex, LDAP_OPT_REFERRALS, 0);

    if ($connex) {
        // Connexion anonyme pour chercher l'uid qui correspond au login.
        if (@ldap_bind($connex)) {
            $login_filtre = function_exists('ldap_escape') ? ldap_escape($login, '', LDAP_ESCAPE_FILTER) : addslashes($login);
            $req = 'supannAliasLogin=' . $login_filtre;
            $res = @ldap_search($connex, LDAP_ROOT_DN, $req);

            if ($res) {
                $datas = ldap_get_entries($connex, $res);

                if ($datas && $datas['count'] > 0 && isset($datas[0]['uid'][0])) {
                    $uid = $datas[0]['uid'][0];
                    $dn = 'uid=' . $uid . ',' . LDAP_ROOT_DN;

                    // Connexion avec le compte étudiant pour vérifier le mot de passe.
                    if (@ldap_bind($connex, $dn, $pass)) {
                        $utilisateur = array(
                            'uid' => $uid,
                            'prenom' => $datas[0]['givenname'][0] ?? '',
                            'nom' => $datas[0]['sn'][0] ?? '',
                            'email' => $datas[0]['mail'][0] ?? ''
                        );

                        ldap_close($connex);
                        return $utilisateur;
                    }
                }
            }
        }

        ldap_close($connex);
    }

    return false;
}
