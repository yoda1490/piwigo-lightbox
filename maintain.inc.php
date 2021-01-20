<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

function plugin_install()
{
  include(dirname(__FILE__).'/admin/config_default.inc.php');

  $query = '
INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment)
VALUES ("lightbox" , "'.addslashes(serialize($config_default)).'" , "Lightbox plugin parameters");';
  pwg_query($query);

  $query = 'SHOW FULL COLUMNS FROM ' . HISTORY_TABLE . ';';
  $result = array_from_query($query, 'Field');
  if (!in_array('lightbox', $result))
  {
    pwg_query('ALTER TABLE '.HISTORY_TABLE.' ADD `lightbox` ENUM(\'true\', \'false\') NULL DEFAULT NULL');
  }
}

function plugin_uninstall()
{
  $query = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE param="lightbox" LIMIT 1;';
  pwg_query($query);

  $query = 'SHOW FULL COLUMNS FROM ' . HISTORY_TABLE . ';';
  $result = array_from_query($query, 'Field');
  if (in_array('lightbox', $result))
  {
    $q = ' ALTER TABLE '.HISTORY_TABLE.' DROP `lightbox`';
    pwg_query( $q );
  }
}

?>