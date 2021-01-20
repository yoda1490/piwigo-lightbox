<?php

add_event_handler('get_admin_plugin_menu_links', 'lightbox_admin_menu');
add_event_handler('functions_history_included', 'lightbox_history');

function lightbox_admin_menu($menu)
{
  array_push($menu, array(
    'NAME' => 'Lightbox',
    'URL' => get_admin_plugin_menu_link(dirname(__FILE__).'/admin.php')));
  return $menu;
}

function lightbox_history()
{
  remove_event_handler('get_history', 'get_history');
  add_event_handler('get_history', 'get_lightbox_history', EVENT_HANDLER_PRIORITY_NEUTRAL, 3);
  
  function get_lightbox_history($data, $search, $types)
  {
    if (isset($search['fields']['filename']))
    {
      $query = '
  SELECT
      id
    FROM '.IMAGES_TABLE.'
    WHERE file LIKE \''.$search['fields']['filename'].'\'
  ;';
      $search['image_ids'] = array_from_query($query, 'id');
    }
    
    // echo '<pre>'; print_r($search); echo '</pre>';
    
    $clauses = array();

    if (isset($search['fields']['date-after']))
    {
      array_push(
        $clauses,
        "date >= '".$search['fields']['date-after']."'"
        );
    }

    if (isset($search['fields']['date-before']))
    {
      array_push(
        $clauses,
        "date <= '".$search['fields']['date-before']."'"
        );
    }

    if (isset($search['fields']['types']))
    {
      $local_clauses = array();
      
      foreach ($types as $type) {
        if (in_array($type, $search['fields']['types'])) {
          $clause = 'image_type ';
          if ($type == 'none')
          {
            $clause.= 'IS NULL';
          }
          else
          {
            $clause.= "= '".$type."'";
          }
          
          array_push($local_clauses, $clause);
        }
      }
      
      if (count($local_clauses) > 0)
      {
        array_push(
          $clauses,
          implode(' OR ', $local_clauses)
          );
      }
    }

    if (isset($search['fields']['user'])
        and $search['fields']['user'] != -1)
    {
      array_push(
        $clauses,
        'user_id = '.$search['fields']['user']
        );
    }

    if (isset($search['fields']['image_id']))
    {
      array_push(
        $clauses,
        'image_id = '.$search['fields']['image_id']
        );
    }
    
    if (isset($search['fields']['filename']))
    {
      if (count($search['image_ids']) == 0)
      {
        // a clause that is always false
        array_push($clauses, '1 = 2 ');
      }
      else
      {
        array_push(
          $clauses,
          'image_id IN ('.implode(', ', $search['image_ids']).')'
          );
      }
    }
    
    $clauses = prepend_append_array_items($clauses, '(', ')');

    $where_separator =
      implode(
        "\n    AND ",
        $clauses
        );
    
    $query = '
  SELECT
      date,
      time,
      user_id,
      IP,
      section,
      category_id,
      tag_ids,
      image_id,
      image_type,
      lightbox
    FROM '.HISTORY_TABLE.'
    WHERE '.$where_separator.'
  ;';

    // LIMIT '.$page['start'].', '.$conf['nb_logs_page'].'

    $result = pwg_query($query);

    while ($row = pwg_db_fetch_assoc($result))
    {
      if ($row['lightbox'] == 'true')
      {
        $row['image_type'] .= ' (lightbox)';
      }
      array_push($data, $row);
    }

    return $data;
  }
}

?>