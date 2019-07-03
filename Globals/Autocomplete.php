<?php

$column = $_GET['column'];
isset($_GET['table']) ? AutoComplete($column,$_GET['table']) : AutoComplete($column);
