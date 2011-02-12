<?php
set_include_path(
    sprintf(
    	'%s;%s',
        realpath(__DIR__ . '/..'),
        get_include_path()
    )
);