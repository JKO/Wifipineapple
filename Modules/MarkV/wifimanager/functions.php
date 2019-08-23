<?php

function my_getWifiIfaceUCIid($interface)
{
    if (is_numeric($interface) || preg_match("/^\d+[\-]\d+/", $interface)) {
        $interface = 'wlan' . $interface;
    }
    if (preg_match("/^wlan\d+$/", $interface) || preg_match("/^wlan\d+-\d+$/", $interface)) {
        exec("ifconfig -a 2>&1 | grep wlan | awk '{print $1}' | sed 's/wlan//g' | sort -n | awk '{print \"wlan\"$1}'", $list_of_interfaces);
        exec("uci show wireless | grep -o '\[[0-9]*\].device=' | awk -F '' '{print $2}'", $list_of_uci_ids);

        foreach ($list_of_uci_ids as $key => $uci_id) {
            if (exec("uci get wireless.@wifi-iface[{$uci_id}].disabled") == "1") {
                unset($list_of_uci_ids[$key]);
            }
        }
        $list_of_uci_ids = array_values($list_of_uci_ids);

        $uci_key_loc = array_search($interface, $list_of_interfaces);
        if ($uci_key_loc !== false) {
            if (array_key_exists($uci_key_loc, $list_of_uci_ids)) {
                return $list_of_uci_ids[$uci_key_loc];
            }
        }
    }
    return false;
}

function my_getWifiDevUCIid($interface)
{
    if (is_numeric($interface) || preg_match("/^\d+[\-]\d+/", $interface)) {
        $interface = 'wlan' . $interface;
    }

    if (preg_match("/^wlan\d+-\d+$/", $interface)) {
        $interface = preg_replace("/-\d+/", "", $interface);
    }

    if (preg_match("/^wlan\d+$/", $interface)) {
        exec("iwconfig 2>&1 | grep -o '^wlan[0-9]*' | uniq | sort", $list_of_interfaces);
        exec("uci show wireless | grep -o '[0-9]*=wifi-device' | awk -F '=' '{print $1}'", $list_of_uci_ids);

        $uci_key_loc = array_search($interface, $list_of_interfaces);
        if ($uci_key_loc !== false) {
            if (array_key_exists($uci_key_loc, $list_of_uci_ids)) {
                return $list_of_uci_ids[$uci_key_loc];
            }
        }
    }
    return false;
}

?>