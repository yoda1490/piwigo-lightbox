<?php

global $page, $conf, $template, $user;

include_once(LIGHTBOX_PATH.'functions.inc.php');
$params = unserialize($conf['lightbox']);
$conf['lightbox_rel'] = isset($conf['lightbox_rel']) ? ++$conf['lightbox_rel'] : 0;
$selector = 'a[rel=colorbox'.$conf['lightbox_rel'].']';

$template->func_combine_script(array('id'=>'jquery.colorbox', 'path'=>'themes/default/js/plugins/jquery.colorbox.min.js'));
$template->func_combine_css(array('id'=>'colorbox','path'=>'plugins/lightbox/theme/'.$params['theme'].'/colorbox.css'));
$template->block_footer_script('','
function PWG_Colorbox() {
  jQuery("'.$selector.'").attr("href", function () {
    return this.name;    
  });
  jQuery("'.$selector.'").colorbox({
    current: "",
    transition: "'.$params['transition'].'",
    speed: "'.$params['transition_speed'].'",
    initialWidth: "'.(!empty($params['initial_width']) ? $params['initial_width'] : $config_default['initial_width']).'",
    initialHeight: "'.(!empty($params['initial_height']) ? $params['initial_height'] : $config_default['initial_height']).'",
    width: '.(!empty($params['fixed_width']) ? '"'.$params['fixed_width'].'"' : 'false').',
    height: '.(!empty($params['fixed_height']) ? '"'.$params['fixed_height'].'"' : 'false').'
    },
    function() { 
      jQuery.post("'.get_root_url().'plugins/lightbox/save_history.php", {
        imgid:   this.id,
        catid:   "'.@$page['category']['id'].'",
        section: "'.@$page['section'].'",
        tagids:  "'.@implode(',', @$page['tag_ids']).'"
    });
  });
}
jQuery(document).ready(PWG_Colorbox);
jQuery(window).bind("RVTS_loaded", PWG_Colorbox);
');
$template->block_html_style('', 'img.cboxPhoto { max-width: none; }');

foreach($tpl_thumbnails_var as $key => $tpl_var)
{
  // Image URL for lightbox
  if ($newurl = get_lightbox_url($pictures[$key]))
  {
    $tpl_thumbnails_var[$key]['URL'] .= '" id="img-'.$pictures[$key]['id'].'" name="'.$newurl;
  }
  else
  {
    continue;
  }

  // Title display
  if ($params['display_name'])
  {
    $tpl_thumbnails_var[$key]['URL'] .= '" title="'.get_lightbox_title($pictures[$key], $params['name_link']);
  }

  // Arrows display
  if ($params['display_arrows'])
  {
    $tpl_thumbnails_var[$key]['URL'] .= '" rel="colorbox'.$conf['lightbox_rel'];
  }
}

// Add all items from category
if ($params['display_arrows'] and $params['all_cat'] and !empty($page['navigation_bar']))
{
  $rank_of = array_flip($page['items']);
  if ($page['start'] > 0)
  {
    $selection = array_slice($page['items'], 0, $page['start']);
    $template->concat('PLUGIN_INDEX_CONTENT_BEGIN', get_lightbox_extra_pictures($selection, $rank_of, $params['name_link']));
  }

  if (count($page['items']) > $page['start'] + $page['nb_image_page'])
  {
    $selection = array_slice($page['items'], $page['start'] + $page['nb_image_page']);
    $template->concat('PLUGIN_INDEX_CONTENT_END', get_lightbox_extra_pictures($selection, $rank_of, $params['name_link']));
  }
}

?>
