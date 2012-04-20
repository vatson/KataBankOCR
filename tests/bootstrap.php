<?php

spl_autoload_register(function($class)
{
  if (0 === strpos($class, 'KataBankOCR')) {
    $path = __DIR__ . '/../src/' . implode('/', array_slice(explode('\\', $class), 1)) . '.php';
    if (!stream_resolve_include_path($path)) {
      return false;
    }
    require_once $path;
    return true;
  }
});