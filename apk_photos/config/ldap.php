<?php
define('LDAP_SERVER', 'ldaps://ldapsupannappli.univ-poitiers.fr:636');
define('LDAP_ROOT_DN', 'ou=people,dc=univ-poitiers,dc=fr');

function ldap_authenticate($login, $pass) {
    $connex = ldap_connect(LDAP_SERVER);
    ldap_set_option($connex, LDAP_OPT_PROTOCOL_VERSION, 3);

    if (!$connex) return false;

    if (@ldap_bind($connex)) {
        $req = 'supannAliasLogin=' . ldap_escape($login, '', LDAP_ESCAPE_FILTER);
        $res = ldap_search($connex, LDAP_ROOT_DN, $req);
        $datas = ldap_get_entries($connex, $res);

        if ($datas['count'] > 0) {
            $uid = $datas[0]['uid'][0];
            $dn = 'uid=' . $uid . ',' . LDAP_ROOT_DN;

            if (@ldap_bind($connex, $dn, $pass)) {
                return [
                    'uid' => $uid,
                    'prenom' => $datas[0]['givenname'][0] ?? '',
                    'nom' => $datas[0]['sn'][0] ?? ''
                ];
            }
        }
    }

    ldap_close($connex);
    return false;
}
