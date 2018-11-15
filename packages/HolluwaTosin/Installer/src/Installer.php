<?php

namespace HolluwaTosin\Installer;

use PragmaRX\Version\Package\Version;

class Installer
{

    public static function createLog()
    {
        $file = storage_path('installed');

        if (!file_exists($file)) {
            $contents[] = [
                'status' => 'Installed',
                'date' => date("Y/m/d h:i:s")
            ];
        } else {
            $contents = json_decode(
                file_get_contents($file), true
            );

            $contents[] = [
                'status' => 'Updated',
                'date' => date("Y/m/d h:i:s")
            ];
        }

        file_put_contents(
            $file, json_encode($contents)
        );
    }
}
