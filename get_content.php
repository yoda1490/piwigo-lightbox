<?php
// Embedded Videos

define('PHPWG_ROOT_PATH','../../');
include_once(PHPWG_ROOT_PATH.'include/common.inc.php');
include_once(PHPWG_ROOT_PATH.'include/functions_picture.inc.php');

check_status(ACCESS_GUEST);

if (!isset($_GET['imgid']) or !is_numeric($_GET['imgid']))
{
  exit;
}

function lightbox_get_picture($picture){
  $image_id = pwg_db_real_escape_string($picture);

  $query = '
    SELECT *
    FROM '.IMAGES_TABLE.'
    INNER JOIN '.IMAGE_CATEGORY_TABLE.'
          ON id=image_id
    WHERE id='.$image_id
                . get_sql_condition_FandF(
                    array('forbidden_categories' => 'category_id'),
                    " AND"
                  ).'
    LIMIT 1';

    $picture = pwg_db_fetch_assoc( pwg_query($query) );
    return $picture;
}

$picture=lightbox_get_picture(intval($_GET['imgid']));
if (empty($picture)){
        echo '<span>Error: Media not found</span>';
	exit;
}

$picture['src_image']= new SrcImage($picture);
$picture['element_url']=$picture['path'];

if (!empty($pwg_loaded_plugins['gvideo']) && function_exists('gvideo_element_content'))
{
	if ($picture['is_gvideo']){
	  echo gvideo_element_content(null, $picture);
	  exit;
	}

}

if(!empty($pwg_loaded_plugins['piwigo-videojs'])){
	if (vjs_valid_extension(pathinfo($picture['path'])['extension'])){
		//print_r(['current'=>$picture]);
		//bug in videojs, parameters are not read, you should define picture as a global variable
		global $picture;
		$picture=['current' => $picture];
		global $page;
		$page['slideshow']=1;
		echo '<div class="tscroller_videojs" >'.vjs_render_media(null, $picture).'</div>';
		//enhance css, ugly here, need to put it in theme 
		echo '<style>.tscroller_videojs, .tscroller_videojs video{ margin: auto; width: 90vh; height: 90vh; }</style>';
		exit;
        }
}



?>
