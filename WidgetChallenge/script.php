<?php

require ('Widget.php');

$widgetNum = readline('Enter the number of widgets ' . PHP_EOL);

$widget = new Widget($widgetNum, [250,500,1000,2000,5000]);
print_r($widget->calculatePackets());