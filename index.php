<?php

/**
 * Laravel entry point for shared hosting where document root cannot be changed to /public.
 * This file forwards all requests to public/index.php.
 */
require __DIR__ . '/public/index.php';
