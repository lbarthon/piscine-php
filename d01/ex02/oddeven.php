#!/usr/bin/php
<?php
    while (true)
    {
        echo "Entrez un nombre: ";
        $read = trim(fgets(STDIN));
        if (feof(STDIN)) die("^D\n");
        if (!is_numeric($read)) {
            printf("'$read' n'est pas un chiffre\n");
        } else {
            if ($read % 2 == 1 || $read % 2 == -1) {
                printf ("Le chiffre $read est Impair\n");
            } else {
                printf ("Le chiffre $read est Pair\n");
            }
        }
    }
