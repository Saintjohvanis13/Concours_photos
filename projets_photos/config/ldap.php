<?php
// Configuration du serveur LDAP de l'Université de Poitiers.
// LDAP = annuaire central : il sert à vérifier l'identifiant et le mot de passe universitaire.

if (!defined('LDAP_SERVER')) define('LDAP_SERVER', 'ldaps://ldapsupannappli.univ-poitiers.fr:636');
if (!defined('LDAP_ROOT_DN')) define('LDAP_ROOT_DN', 'ou=people,dc=univ-poitiers,dc=fr');

function ldap_authenticate($login, $pass) {
    if (empty($login) || empty($pass)) {
        return false;
    }

    $connex = ldap_connect(LDAP_SERVER);
    if (!$connex) {
        return false;
    }

    ldap_set_option($connex, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($connex, LDAP_OPT_REFERRALS, 0);

    if (@ldap_bind($connex)) {
        $req = 'supannAliasLogin=' . ldap_escape($login, '', LDAP_ESCAPE_FILTER);
        $res = @ldap_search($connex, LDAP_ROOT_DN, $req);

        if ($res) {
            $datas = ldap_get_entries($connex, $res);

            if ($datas['count'] > 0) {
                $uid = $datas[0]['uid'][0];
                $dn = 'uid=' . $uid . ',' . LDAP_ROOT_DN;

                if (@ldap_bind($connex, $dn, $pass)) {
                    $utilisateur = [
                        'uid' => $uid,
                        'prenom' => $datas[0]['givenname'][0] ?? '',
                        'nom' => $datas[0]['sn'][0] ?? '',
                        'email' => $datas[0]['mail'][0] ?? ''
                    ];

                    ldap_close($connex);
                    return $utilisateur;
                }
            }
        }
    }

    ldap_close($connex);
    return false;
}
