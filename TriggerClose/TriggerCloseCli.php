<?php

require_once __DIR__.'/TriggerCloseApi.php';

if(PHP_SAPI == "cli") {
	TriggerCloseApi::cli();
}
else {
	$api = new TriggerCloseApi();
	$api->auto_close();
}