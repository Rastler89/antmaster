<?php
$langs = ['es', 'en', 'fr'];
$translations = [];

foreach ($langs as $lang) {
    $translations[$lang] = include "c:/Users/Rastl/Desktop/antmaster/app/Lang/$lang/messages.php";
}

$all_keys = [];
foreach ($translations as $data) {
    $all_keys = array_merge($all_keys, array_keys($data));
}
$all_keys = array_unique($all_keys);
sort($all_keys);

echo "Comparison of translation keys:\n";
echo str_pad("Key", 35) . " | ES | EN | FR |\n";
echo str_repeat("-", 50) . "\n";

$missing = [];

foreach ($all_keys as $key) {
    $row = str_pad($key, 35) . " | ";
    $row .= isset($translations['es'][$key]) ? "OK" : "--";
    $row .= " | ";
    $row .= isset($translations['en'][$key]) ? "OK" : "--";
    $row .= " | ";
    $row .= isset($translations['fr'][$key]) ? "OK" : "--";
    $row .= " |";
    
    if (!isset($translations['es'][$key]) || !isset($translations['en'][$key]) || !isset($translations['fr'][$key])) {
        echo $row . " (MISSING)\n";
        $missing[] = $key;
    }
}

echo "\nSummary of missing keys:\n";
foreach ($langs as $lang) {
    $diff = array_diff($all_keys, array_keys($translations[$lang]));
    echo "$lang is missing: " . count($diff) . " keys (" . implode(', ', $diff) . ")\n";
}

echo "\nPotential untranslated values (FR contains Spanish?):\n";
foreach ($translations['fr'] as $key => $value) {
    if (preg_match('/[ÁÉÍÓÚñ¿¡]/u', $value) && !str_contains($value, 'Fiches d\'Élevage')) {
         echo "FR [$key] looks Spanish: $value\n";
    }
}
