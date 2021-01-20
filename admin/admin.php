<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template, $conf;

// Chargement des parametres
load_language('plugin.lang', LIGHTBOX_PATH);
include(dirname(__FILE__).'/config_default.inc.php');
$params = array_merge($config_default, unserialize($conf['lightbox']));

// Mise a jour de la base de donnee
if (isset($_POST['submit']))
{
  $params  = array(
    'display_name'       => $_POST['display_name'] ? true : false,
    'name_link'          => $_POST['name_link'],
    'display_arrows'     => $_POST['display_arrows'] ? true : false,
    'all_cat'            => $_POST['all_cat'] ? true : false,
    'theme'              => $_POST['theme'],
    'transition'         => $_POST['transition'],
    'transition_speed'   => $_POST['transition_speed'],
    'initial_width'      => !empty($_POST['initial_width']) ? $_POST['initial_width'].$_POST['initial_width_px'] : '',
    'initial_height'     => !empty($_POST['initial_height']) ? $_POST['initial_height'].$_POST['initial_height_px'] : '',
    'fixed_width'        => !empty($_POST['fixed_width']) ? $_POST['fixed_width'].$_POST['fixed_width_px'] : '',
    'fixed_height'       => !empty($_POST['fixed_height']) ? $_POST['fixed_height'].$_POST['fixed_height_px'] : '',
  );
  
  $query = '
UPDATE ' . CONFIG_TABLE . '
  SET value="' . addslashes(serialize($params)) . '"
  WHERE param="lightbox"
  LIMIT 1';
  pwg_query($query);
  
  array_push($page['infos'], l10n('lb_configuration_saved'));
}

// Restaurer les paramètres par défaut
if (isset($_POST['restore']))
{
  $params  = $config_default;

  $query = '
UPDATE ' . CONFIG_TABLE . '
  SET value="' . addslashes(serialize($params)) . '"
  WHERE param="lightbox"
  LIMIT 1';
  pwg_query($query);
  
  array_push($page['infos'], l10n('lb_default_parameters_saved'));
}

// Récupération des thèmes
$path = LIGHTBOX_PATH . 'theme';
$theme_dir = opendir($path);
$themes = array();
while (($node = readdir($theme_dir)) !== false)
{
  if (is_dir($path . '/' . $node)
    and is_file($path . '/' . $node . '/colorbox.css'))
  {
    array_push($themes, $node);
  }
}

// Configuration du template
$template->assign(array(
  'DISPLAY_NAME'         => $params['display_name'],
  'NAME_LINK'            => $params['name_link'],
  'DISPLAY_ARROWS'       => $params['display_arrows'],
  'ALL_CAT'              => $params['all_cat'],
  'colorbox_themes'      => $themes,
  'SELECTED_THEME'       => $params['theme'],
  'SELECTED_TRANSITION'  => $params['transition'],
  'TRANSITION_SPEED'     => $params['transition_speed'],
  'INITIAL_WIDTH'        => rtrim($params['initial_width'], 'px%'),
  'INITIAL_WIDTH_PX'     => strpos($params['initial_width'], '%') ? false : true,
  'INITIAL_HEIGHT'       => rtrim($params['initial_height'], 'px%'),
  'INITIAL_HEIGHT_PX'    => strpos($params['initial_height'], '%') ? false : true,
  'FIXED_WIDTH'          => rtrim($params['fixed_width'], 'px%'),
  'FIXED_WIDTH_PX'       => strpos($params['fixed_width'], '%')? false : true,
  'FIXED_HEIGHT'         => rtrim($params['fixed_height'], 'px%'),
  'FIXED_HEIGHT_PX'      => strpos($params['fixed_height'], '%')? false : true,
));


$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/admin.tpl'));
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>