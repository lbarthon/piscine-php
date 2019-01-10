#!/usr/bin/php
<?php
    /**
     * UTMPX man -- https://www.systutorials.com/docs/linux/man/5-utmpx/
     * PHP date format -- http://php.net/manual/en/function.date.php
     * Unpack -- https://www.w3schools.com/php/func_misc_unpack.asp
     * UTMPX infos -- https://github.com/libyal/dtformats/blob/master/documentation/Utmp%20login%20records%20format.asciidoc#32-record
     */
    date_default_timezone_set("CET");
    $user = get_current_user();
    $filestr = file_get_contents("/var/run/utmpx");
    $format = 'a256user/a4id/a32device/ipid/itype/Itime';
    /**
     * Apple writes 1256 octets au boot du système
     */
    $filestr = substr($filestr, 1256);
    $render = array();
    while ($filestr != null) {
        $unpack = unpack($format, $filestr);
        /**
         * Only keeping processes that have type === 7 because it's USER_PROCESS
         */
        if ($unpack[type] === 7) {
            $date = date(" M d H:i", $unpack[time]);
            $render[] = $unpack[user] . " " . $unpack[device] . " " . $date . "\n";
        }
        /**
         * 628 octets écrits par process dans UTMPX
         */
        $filestr = substr($filestr, 628);
    }

    if ($render !== null) {
        sort($render);
        foreach ($render as $value) {
            echo $value;
        }
    }
