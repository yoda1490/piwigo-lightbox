<?php

// Return picture lightbox picture URL for known extension
function get_lightbox_url($picture)
{
  global $conf, $pwg_loaded_plugins;
  
  $ext = strtolower(get_extension($picture['file']));
  if (!empty($pwg_loaded_plugins['gvideo']) and $picture['is_gvideo'])
  {
    return get_root_url().'plugins/lightbox/get_content.php?imgid='.$picture['id'];
  }else if(!empty($pwg_loaded_plugins['piwigo-videojs']) and vjs_valid_extension(pathinfo($picture['path'])['extension']) ){
    //print_r(vjs_valid_extension(pathinfo($picture['path'])['extension']));
    return get_root_url().'plugins/lightbox/get_content.php?imgid='.$picture['id'];	
  }else if (in_array($ext, $conf['picture_ext']))
  {
    return DerivativeImage::url(IMG_LARGE, new SrcImage($picture));
  }
  
  return false;
}

// Return lightbox title
function get_lightbox_title($picture, $name_link)
{
  global $conf, $user;

  if (isset($picture['name']) and $picture['name'] != '')
  {
    $name = trigger_change('render_element_description', $picture['name']);
  }
  else
  {
    $name = str_replace('_', ' ', get_filename_wo_extension($picture['file']));
  }

  if ($name_link == 'picture')
  {
    $url = duplicate_picture_url(
      array(
        'image_id' => $picture['id'],
        'image_file' => $picture['file']
      ),
      array('start')
    );
    return htmlspecialchars('<a href="'.$url.'">'.$name.'</a>');
  }
  elseif ($name_link == 'high')
  {
    $src_image = new SrcImage($picture);

    if ($src_image->is_original() and 'true' == $user['enabled_high'])
    {
      $name.= ' ('.l10n('Display').' '.l10n('Original').')';
      return htmlspecialchars('<a href="javascript:phpWGOpenWindow(\''.$src_image->get_url().'\',\'\',\'scrollbars=yes,toolbar=no,status=no,resizable=yes\')" rel="nofollow">'.$name.'</a>');
    }
  }
  return $name;
}

// Return extra picture for multipage category
function get_lightbox_extra_pictures($selection, $rank_of, $name_link)
{
  global $conf;

  $query = 'SELECT * FROM '.IMAGES_TABLE.' WHERE id IN ('.implode(',', $selection).');';
  $result = pwg_query($query);
  $pictures = array();
  while ($row = pwg_db_fetch_assoc($result))
  {
    $row['rank'] = $rank_of[ $row['id'] ];
    array_push($pictures, $row);
  }
  usort($pictures, 'rank_compare');
  
  $content = '<div class="thumbnails" style="display: none;">'."\n";
  foreach ($pictures as $picture)
  {
    $content .= '<a href="#" id="img-'.$picture['id'].'" name="'.get_lightbox_url($picture).'" title="'.get_lightbox_title($picture, $name_link).'" rel="colorbox'.$conf['lightbox_rel'].'"></a>'."\n";
  }
  $content .= '</div>'."\n";
  
  return $content;
}

?>
