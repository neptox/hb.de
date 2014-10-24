<?php

$latteParams['bodyId'] = 'normal-page';

WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();