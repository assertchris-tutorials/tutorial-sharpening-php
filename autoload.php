<?php

require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(function($class) {
    $definitions = require __DIR__ . "/vendor/composer/autoload_psr4.php";

    foreach ($definitions as $prefix => $paths) {
        $prefixLength = strlen($prefix);

        if (strncmp($prefix, $class, $prefixLength) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $prefixLength);

        foreach ($paths as $path) {
            $php = $path . "/" . str_replace("\\", "/", $relativeClass) . ".php";
            $pre = $path . "/" . str_replace("\\", "/", $relativeClass) . ".pre";

            $relative = ltrim(str_replace(__DIR__, "", $pre), DIRECTORY_SEPARATOR);
            $macros = __DIR__ . "/macros.pre";

            if (file_exists($pre)) {
                if (file_exists($php)) {
                    unlink($php);
                }

                file_put_contents(
                    "{$pre}.interim",
                    str_replace(
                        "<?php",
                        file_get_contents($macros),
                        file_get_contents($pre)
                    )
                );

                exec("vendor/bin/yay {$pre}.interim >> {$php}");

                $comment = "
# This file is generated, changes you make will be lost.
# Make your changes in {$relative} instead.
                ";

                file_put_contents(
                    $php,
                    str_replace(
                        "<?php",
                        "<?php\n{$comment}",
                        file_get_contents($php)
                    )
                );

                unlink("{$pre}.interim");

                require_once $php;
            }
        }
    }
}, false, true);
