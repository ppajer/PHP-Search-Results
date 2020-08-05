<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Budapest');

require '../src/SearchResults.php';

use \ppajer\SearchResults;

SearchResults::setAutocompleteParam('term');
SearchResults::autocompleteSearchLocation();

?>