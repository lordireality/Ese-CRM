<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrationLDAPController extends Controller
{
    function Test(){
        /*
            username
            password
            ldap domain

        */

        $user = 'admin';
        $password = 'Secret123';
        $domain = 'ipa.demo1.freeipa.org';
        $basedn = "uid={$user},cn=users,cn=accounts,dc=demo1,dc=freeipa,dc=org";
        $searchDN = "cn=users,cn=accounts,dc=demo1,dc=freeipa,dc=org";

        $ad = ldap_connect("ldap://{$domain}") or die('Could not connect to LDAP server.');
        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
        ldap_bind($ad, $basedn, $password) or die('Could not bind to AD.');
        $filter = "(&(objectClass=person))";
        $resultRaw = ldap_list($ad, $searchDN, $filter);
        $result = mb_convert_encoding(ldap_get_entries($ad,$resultRaw), 'UTF-8', 'UTF-8');
        for($i=0;$i<$result["count"];$i++){
            echo $result["{$i}"]["uid"]["0"].'<br>';
        }
        //echo $result;
        //foreach($result as $entry){
        //    echo $entry["uid"];
        //}
        //return $result;
    }
}
