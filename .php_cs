<?php

$finder = Symfony\CS\Finder::create()
    ->in(__DIR__ . '/src')
;

return Symfony\CS\Config::create()
    ->fixers(array('-psr2'))
    ->finder($finder)
;