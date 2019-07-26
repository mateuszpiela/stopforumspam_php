<?php
if (!isset($SFS_INCLUDE)) {
    die("Nie możesz bezpośrednio uruchromić tego skryptu!");
}

/*
 * Po ilu pojawieniach w bazie SFS zbanować (Zwrócić True)
 */ 
$freq_ban = 2;

function sfs_check_ip($ip){
    /*
     * Funkcja sfs_check_ip
     * Opis funkcji: Sprawdza w bazie SFS podany adres IP
     * Zwraca Prawdę jeśli adres IP był zgłaszany x razy
     * Zwraca Fałsz jeśli adres IP nie jest w bazie SFS lub nie był zgłaszany x razy
     */
    
    #Budowanie adresu url api SFS oraz ustawić zapytanie zwrotne na JSON
    $url = "http://api.stopforumspam.org/api?json";
    #Budowanie zapytania
    $data = array('ip' => $ip);
    $data = http_build_query($data);

    #CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    
    $json_data = json_decode($result, true);

    if($json_data['ip']['appears']){
        if($json_data['ip']['frequency'] >= $GLOBALS["freq_ban"])
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        return FALSE;
    }
}


function sfs_check_email($email){
    /*
     * Funkcja sfs_check_email
     * Opis funkcji: Sprawdza w bazie SFS podany adres Email
     * Zwraca Prawdę jeśli adres Email był zgłaszany x razy
     * Zwraca Fałsz jeśli adres Email nie jest w bazie SFS lub nie był zgłaszany x razy
     */

    
    #Budowanie adresu url api SFS oraz ustawić zapytanie zwrotne na JSON
    $url = "http://api.stopforumspam.org/api?json";
    #Budowanie zapytania
    $data = array('email' => $email);
    $data = http_build_query($data);

    #CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    
    $json_data = json_decode($result, true);

    if($json_data['email']['appears']){
        if($json_data['email']['frequency'] >= $GLOBALS["freq_ban"])
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        return FALSE;
    }
}



?>