<?php
if (!defined('ABSPATH')) exit;

require_once dirname(__DIR__) . '/wmc-attendee-list/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('KBOARD_wmc_attendee_list_VERSION', '1.6');

load_plugin_textdomain('kboard-wmc-attendee-list', false, dirname(plugin_basename(__FILE__)) . '/languages');

if (!function_exists('kboard_wmc_attendee_list_scripts')) {
  add_action('wp_enqueue_scripts', 'kboard_wmc_attendee_list_scripts', 999);
  add_action('kboard_iframe_head', 'kboard_wmc_attendee_list_scripts');
  function kboard_wmc_attendee_list_scripts()
  {
    $localize = array(
      'missing_link_address' => __('Missing link address.', 'kboard-wmc-attendee-list'),
      'no_more_data' => __('There is no more data to display.', 'kboard-wmc-attendee-list'),
    );
    wp_localize_script('kboard-script', 'kboard_wmc_attendee_list_localize_strings', $localize);
  }
}

if (!function_exists('kboard_wmc_more_view_action')) {
  add_action('init', 'kboard_wmc_more_view_action');
  function kboard_wmc_more_view_action()
  {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $board_id = isset($_GET['board_id']) ? intval($_GET['board_id']) : '';

    if (!$board_id) {
      $board_id = isset($_GET['kboard_id']) ? intval($_GET['kboard_id']) : '';
    }

    if ($action == 'kboard_wmc_more_view_action' && $board_id) {
      echo kboard_builder(array('id' => $board_id));
      exit;
    }
  }
}

if (!function_exists('kboard_wmc_attendee_list_shortcusts')) {
  add_action('wp_ajax_kboard_wmc_attendee_list_shortcusts', 'kboard_wmc_attendee_list_shortcusts');
  add_action('wp_ajax_nopriv_kboard_wmc_attendee_list_shortcusts', 'kboard_wmc_attendee_list_shortcusts');
  function kboard_wmc_attendee_list_shortcusts()
  {
    $content_uid = isset($_POST['content_uid']) ? intval($_POST['content_uid']) : '';
    if ($content_uid) {
      $content = new KBContent();
      $content->initWithUID($content_uid);
      $content->increaseView();
    }
    exit;
  }
}

if (!function_exists('kboard_wmc_attendee_list_print')) {
  function kboard_wmc_attendee_list_print($link)
  {
    if (strpos($link, 'http://') !== false || strpos($link, 'https://') !== false) {
      return $link;
    }
    return "http://{$link}";
  }
}

// ???????????? -> ?????? ????????? - ??????
if (!function_exists('kboard_wmc_is_valid_date')) {
  function kboard_wmc_is_valid_date($date)
  {
    $format = 'Y-m-d';
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }
}

if (!function_exists('kboard_wmc_get_age')) {
  function kboard_wmc_get_age($birth_date)
  {
    $birth_date = new DateTime($birth_date);
    $now = new DateTime();
    $interval = $now->diff($birth_date);
    return $interval->y;
  }
}
// ???????????? -> ?????? ????????? - ???

// ???????????? ???????????? - ??????
if (!function_exists('kboard_wmc_add_name_sorting_type')) {
  add_filter('kboard_list_sorting_types', 'kboard_wmc_add_name_sorting_type', 1, 1);
  function kboard_wmc_add_name_sorting_type($sorting_types)
  {
    if (empty($sorting_types)) $sorting_types = [];
    $sorting_types[] = 'name';
    return array_unique($sorting_types);
  }
}

if (!function_exists('kboard_wmc_sort_by_name')) {
  add_filter('kboard_list_orderby', 'kboard_wmc_sort_by_name', 1, 3);
  function kboard_wmc_sort_by_name($orderby, $board_id, $obj)
  {
    global $wpdb;

    if (!isset($_REQUEST['kboard_list_sort'])) return $orderby;
    if (empty($_REQUEST['kboard_list_sort'])) return $orderby;
    if ($_REQUEST['kboard_list_sort'] !== 'name') return $orderby;

    return "`{$wpdb->prefix}kboard_board_content`.`title` ASC";
  }
}
// ???????????? ???????????? - ???


// ?????? ????????? ?????? - ??????
if (!function_exists('kboard_wmc_get_custom_fields')) {
  // ????????? ??? ???????????? query??? ??????????????? ??????
  function kboard_wmc_get_custom_fields()
  {
    return [
      'english_name',
      'position',
      'gender',
      'contact_mobile',
      'contact_tel',
      'contact_fax',
      'contact_email',
      'sns',
      'home_address',
      'family_matters',
      'church_name',
      'account_number',
    ];
  }
}

// ?????? ????????? ?????? ????????? ???????????? ?????????
if (!function_exists('kboard_wmc_kboard_list_search_option')) {
  add_filter('kboard_list_search_option', 'kboard_wmc_kboard_list_search_option', 100, 3);
  function kboard_wmc_kboard_list_search_option($search_option, $board_id, $obj)
  {
    if (!isset($_REQUEST['keyword'])) return $search_option;
    if (empty($_REQUEST['keyword'])) return $search_option;

    $keyword = $_REQUEST['keyword'];

    $custom_fields = kboard_wmc_get_custom_fields();

    $custom_search_options = array_reduce($custom_fields, function ($acc, $cur) use ($keyword) {
      if (!$acc) $acc = [];
      $acc[$cur] = array(
        'key' => $cur,
        'compare' => 'LIKE',
        'wildcard' => 'both',
        'value' => $keyword,
      );
      return $acc;
    });
    $custom_search_options['relation'] = "OR";

    return $custom_search_options;
  }
}

// ????????? ????????? ???????????? ????????? ????????? INNER_JOIN??? ????????? ????????????
if (!function_exists('kboard_wmc_list_from')) {
  add_filter('kboard_list_from', 'kboard_wmc_list_from', 100, 3);
  function kboard_wmc_list_from($from_str, $board_id, $obj)
  {
    global $wpdb;
    if (!isset($_REQUEST['keyword'])) return $from_str;
    if (empty($_REQUEST['keyword'])) return $from_str;

    $new_from_str = "`{$wpdb->prefix}kboard_board_content` INNER JOIN `{$wpdb->prefix}kboard_board_option` ON `{$wpdb->prefix}kboard_board_content`.`uid`=`{$wpdb->prefix}kboard_board_option`.`content_uid`";
    return $new_from_str;
  }
}

// ???????????? ????????? where?????? ??? ???????????? ?????? ????????????
// 1. ???????????? ??????????????? AND??? ???????????????, ????????? OR??? ????????????
// 2. from ???????????? INNER_JOIN??? ?????? ?????? ???????????? ?????????, ????????? ????????? INNER_JOIN??? ???????????? ?????? INNER_JOIN ????????? ???????????????
if (!function_exists('kboard_wmc_list_where')) {
  add_filter('kboard_list_where', 'kboard_wmc_list_where', 100, 3);
  function kboard_wmc_list_where($query_str_where, $board_id, $obj)
  {
    global $wpdb;

    if (!isset($_REQUEST['keyword'])) return $query_str_where;
    if (empty($_REQUEST['keyword'])) return $query_str_where;

    $keyword = $_REQUEST['keyword'];
    $prefix = $wpdb->prefix;

    $query = "`{$prefix}kboard_board_content`.`board_id`='{$board_id}'";

    // ??????????????? ???????????????
    // ??????????????? ???????????? ?????????
    // if (isset($_REQUEST['tree_category_1']) && !empty($_REQUEST['tree_category_1']) && isset($_REQUEST['tree_category_2']) && !empty($_REQUEST['tree_category_2'])) {
    //   $category1 = $_REQUEST['tree_category_1'];
    //   $category2 = $_REQUEST['tree_category_2'];
    //   $query = $query . " AND ( (`{$prefix}kboard_board_option`.`option_key` = 'tree_category_1' AND {$prefix}kboard_board_option`.`option_value` = '{$category1}') AND (`{$prefix}kboard_board_option`.`option_key` = 'tree_category_2' AND {$prefix}kboard_board_option`.`option_value` = '{$category2}')) ";
    // }

    // member_display??? ??????
    // title??? ?????????
    // content??? ????????????
    $query = $query . "
      AND (
        (
          `{$prefix}kboard_board_content`.`member_display` LIKE '%{$keyword}%'
          OR `{$prefix}kboard_board_content`.`title` LIKE '%{$keyword}%'
          OR `{$prefix}kboard_board_content`.`content` LIKE '%{$keyword}%'
        )
    ";

    $custom_fields = kboard_wmc_get_custom_fields();
    $sub_where = [];
    foreach ($custom_fields as $field) {
      $q = "`{$prefix}kboard_board_option`.`option_key`='{$field}' AND `{$prefix}kboard_board_option`.`option_value` LIKE '%{$keyword}%'";
      $sub_where[] = ' OR (' . $q . ')';
    }

    $query = $query . implode('', $sub_where) . ')'; // ????????? AND ?????????

    $query = $query . "
      AND `{$prefix}kboard_board_content`.`notice`=''
      AND (`{$prefix}kboard_board_content`.`status` IS NULL
      OR `{$prefix}kboard_board_content`.`status`=''
      OR `{$prefix}kboard_board_content`.`status`='pending_approval')
      GROUP BY `{$prefix}kboard_board_content`.`uid`
    ";

    return $query;
  }
}

if (!function_exists('kboard_wmc_content_list_total_count')) {
  add_filter('kboard_content_list_total_count', 'kboard_wmc_content_list_total_count', 1, 3);
  function kboard_wmc_content_list_total_count($total, $board, $obj)
  {
    global $wpdb;
    if (!isset($_REQUEST['keyword'])) return $total;
    if (empty($_REQUEST['keyword'])) return $total;

    $keyword = $_REQUEST['keyword'];
    $prefix = $wpdb->prefix;
    $board_id = $board->id;

    // ?????? AND (( ??????!
    $query = "
      SELECT COUNT(*)
      FROM `{$prefix}kboard_board_content`
      INNER JOIN `{$prefix}kboard_board_option`
      ON `{$prefix}kboard_board_content`.`uid` = `{$prefix}kboard_board_option`.`content_uid`
      WHERE `{$prefix}kboard_board_content`.`board_id` = '{$board_id}'
    ";

    // ??????????????? ???????????????
    if (isset($_REQUEST['category1']) && !empty($_REQUEST['category1'])) {
      $category1 = $_REQUEST['category1'];
      $category1 = esc_sql($category1);
      $query = $query . " AND `{$prefix}kboard_board_content`.`category1`='{$category1}'";
    }

    $query = $query . "
      AND (
        (
          `{$prefix}kboard_board_content`.`title` LIKE '%{$keyword}%' 
          OR `{$prefix}kboard_board_content`.`content` LIKE '%{$keyword}%'
        )
    ";

    $custom_fields = kboard_wmc_get_custom_fields();
    $sub_where = [];
    foreach ($custom_fields as $field) {
      $q = "`{$prefix}kboard_board_option`.`option_key`='{$field}' AND `{$prefix}kboard_board_option`.`option_value` LIKE '%{$keyword}%'";
      $sub_where[] = ' OR (' . $q . ')';
    }

    $query = $query . implode('', $sub_where) . ')'; // ????????? AND ?????????

    $query = $query . "
      AND `{$prefix}kboard_board_content`.`notice`=''
      AND (`{$prefix}kboard_board_content`.`status` IS NULL
      OR `{$prefix}kboard_board_content`.`status`=''
      OR `{$prefix}kboard_board_content`.`status`='pending_approval')
      GROUP BY `{$prefix}kboard_board_content`.`uid`
    ";

    $count = count($wpdb->get_results($query));
    return $count;
  }
}

if (!function_exists('kboard_wmc_list_rpp')) {
  add_filter('kboard_list_rpp', 'kboard_wmc_list_rpp', 1, 3);
  function kboard_wmc_list_rpp($rpp, $board_id, $obj)
  {
    if (!isset($_REQUEST['kboard_list_rpp'])) return $rpp;
    if (empty($_REQUEST['kboard_list_rpp'])) return $rpp;

    $_rpp = $_REQUEST['kboard_list_rpp'];
    if (!is_int($_rpp)) return $rpp;

    return $_rpp;
  }
}

// ???????????? ?????? ?????? ??????
add_filter('kboard_list_where', 'kboard_wmc_tree_category_where', 101, 3);
function kboard_wmc_tree_category_where($query_str_where, $board_id, $obj)
{
  $_search_option = kboard_search_option();

  if (isset($_search_option['tree_category_1'])) {
    $cat1 = $_search_option['tree_category_1']['value'];
    if ($cat1) {
      $query_str_where .= " AND (`option_tree_category_1`.`option_key` = 'tree_category_1' AND `option_tree_category_1`.`option_value` = '{$cat1}') ";
    }
  }

  if (isset($_search_option['tree_category_2'])) {
    $cat2 = $_search_option['tree_category_2']['value'];
    if ($cat2) {
      $query_str_where .= " AND (`option_tree_category_2`.`option_key` = 'tree_category_2' AND `option_tree_category_2`.`option_value` = '{$cat2}') ";
    }
  }

  return $query_str_where;
}

// ?????? ????????? ?????? - ???


// ??????????????? ????????? ???????????? ?????????
if (!function_exists('kboard_wmc_update_view_count_action')) {
  add_action('wp_ajax_kboard_wmc_update_view_count_action', 'kboard_wmc_update_view_count_action');
  add_action('wp_ajax_nopriv_kboard_wmc_update_view_count_action', 'kboard_wmc_update_view_count_action');
  function kboard_wmc_update_view_count_action()
  {
    global $wpdb;

    if (!isset($_POST['uid'])) {
      wp_send_json_error(array(
        "code" => 404,
        "message" => 'no value'
      ));
      return;
    }
    $uid = intval($_POST['uid']);

    if (empty($uid)) {
      wp_send_json_error(array(
        "code" => 403,
        "message" => 'empty value'
      ), 401);
      return;
    }

    $wpdb->query("UPDATE `{$wpdb->prefix}kboard_board_content` SET `view`=`view`+1 WHERE `uid`='{$uid}'");
  }
}

if (!function_exists('kboard_wmc_get_list_count_by_category')) {
  function kboard_wmc_get_list_count_by_category($board)
  {
    if (!isset($_GET['category1'])) return number_format($board->getListTotal());
    if (empty($_GET['category1'])) return number_format($board->getListTotal());

    $category1 = $_GET['category1'];
    return number_format($board->getCategoryCount(array('category1' => $category1)));
  }
}

if (!function_exists('kboard_wmc_download_xlsx')) {
  add_action('init', 'kboard_wmc_download_xlsx');
  function kboard_wmc_download_xlsx()
  {
    if (!isset($_GET['kboard_wmc_xlsx_download'])) return;
    if (!current_user_can('manage_kboard')) wp_die(__('You do not have permission.', 'kboard'));
    if (!wp_verify_nonce($_GET['kboard_wmc_xlsx_download_nonce'], 'kboard_wmc_xlsx_download_action')) wp_die(__('Invalid Access', 'kboard'));

    $board_id = isset($_GET['board_id_for_xlsx_download']) ? $_GET['board_id_for_xlsx_download'] : '';
    $board = new KBoard($board_id);

    if ($board->id) {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      $cols = array(
        'A' => array(
          'col_name' => '??????',
          'option_key' => 'uid',
        ),
        'B' => array(
          'col_name' => '??????',
          'option_key' => 'title',
        ),
        'C' => array(
          'col_name' => '??????',
          'option_key' => 'position'
        ),
        'D' => array(
          'col_name' => '?????????',
          'option_key' => 'church_name'
        ),
        'E' => array(
          'col_name' => '??????',
          'option_key' => 'tree_category_1'
        ),
        'F' => array(
          'col_name' => '??????',
          'option_key' => 'tree_category_2'
        ),
        'G' => array(
          'col_name' => '??????',
          'option_key' => 'region'
        ),
        'H' => array(
          'col_name' => '??????????????? ??????',
          'option_key' => 'missionary_training_camp'
        ),
        'I' => array(
          'col_name' => '???????????? ??????',
          'option_key' => 'registration'
        ),
        'J' => array(
          'col_name' => '????????????',
          'option_key' => 'how_to_attend'
        ),
        'K' => array(
          'col_name' => '????????????',
          'option_key' => 'number_of_attendees'
        ),
        'L' => array(
          'col_name' => '????????????',
          'option_key' => 'communication'
        ),
        'M' => array(
          'col_name' => '??????????????????',
          'option_key' => 'ticket_issue_date'
        ),
        'N' => array(
          'col_name' => '??????/??????',
          'option_key' => 'one_way_return'
        ),
        'O' => array(
          'col_name' => '????????????',
          'option_key' => 'number_of_passengers'
        ),
        'P' => array(
          'col_name' => '????????????',
          'option_key' => 'invoice'
        ),
        'Q' => array(
          'col_name' => '?????????(???????????????)',
          'option_key' => 'airfare_ticket_description'
        ),
        'R' => array(
          'col_name' => '?????????(KRW)',
          'option_key' => 'airfare_krw'
        ),
        'S' => array(
          'col_name' => '????????????',
          'option_key' => 'account_number'
        ),
        'T' => array(
          'col_name' => '???????????????',
          'option_key' => 'deposit_request_date'
        ),
        'U' => array(
          'col_name' => '?????????',
          'option_key' => 'deposit_date'
        ),
        'V' => array(
          'col_name' => '????????????',
          'option_key' => 'date_of_entry'
        ),
        'W' => array(
          'col_name' => '????????????',
          'option_key' => 'departure_date'
        ),
        'X' => array(
          'col_name' => '??????????????? ????????????',
          'option_key' => 'accommodation_to_venue'
        ),
        'Y' => array(
          'col_name' => '??????????????? ?????? ????????????',
          'option_key' => 'venue_to_accommodation'
        ),
        'Z' => array(
          'col_name' => '???????????? ???????????? ????????????',
          'option_key' => 'church_to_accommodation'
        ),
        'AA' => array(
          'col_name' => '???????????? ????????? ????????????',
          'option_key' => 'accommodation_to_church'
        ),
        'AB' => array(
          'col_name' => '????????????',
          'option_key' => 'accommodation_support'
        ),
        'AC' => array(
          'col_name' => '???????????? ???????????? ??????',
          'option_key' => 'after_the_conference'
        ),
        'AD' => array(
          'col_name' => '???????????? ?????? ??????',
          'option_key' => 'details_of_support'
        ),
        'AE' => array(
          'col_name' => '??????',
          'option_key' => 'note'
        ),
        'AF' => array(
          'col_name' => '?????? ?????? ??????',
          'option_key' => 'how_to_contact'
        ),
        'AG' => array(
          'col_name' => '?????????',
          'option_key' => 'contact_email'
        ),
        'AH' => array(
          'col_name' => '?????????(???????????? ??????)',
          'option_key' => 'contact_mobile'
        ),
        'AI' => array(
          'col_name' => 'SNS(??????)',
          'option_key' => 'sns'
        ),
      );

      $index = 1;
      foreach ($cols as $col => $arr) {
        $sheet->setCellValue("{$col}{$index}", $arr['col_name']);
      }

      $list = new KBContentList($board_id);
      $list->rpp(2000);
      $list->orderASC('uid');
      $list->initFirstList();

      while ($list->hasNextList()) {
        while ($content = $list->hasNext()) {
          $index += 1;
          foreach ($cols as $col => $arr) {
            $option_key = $arr['option_key'];
            $option_value = $content->option->{$option_key};
            if ($option_key === 'uid') {
              $option_value = $content->uid;
            }
            if ($option_key === 'title') {
              $option_value = $content->row->title;
            }
            if ($option_key === 'content') {
              $option_value = $content->row->content;
            }
            if ($option_key === 'tree_category_1') {
              $option_value = $content->option->tree_category_1;
            }
            if ($option_key === 'tree_category_2') {
              $option_value = $content->option->tree_category_2;
            }
            $sheet->setCellValue("{$col}{$index}", $option_value);
          }
        }
      }

      @ob_end_clean();
      $writer = new Xlsx($spreadsheet);

      $filename = 'users' . Date('Y-m-d H:i:s') . '.xlsx';

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output');
    }
    exit;
  }
}


// print?????? ????????? php????????? ????????????
if (!function_exists('kboard_wmc_document_print')) {
  add_action('wp_loaded', 'kboard_wmc_document_print', -1);
  function kboard_wmc_document_print()
  {
    $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
    if ($action !== 'kboard_document_print') return;

    $uid = kboard_uid();

    $content = new KBContent();
    $content->initWithUID($uid);

    if (!$content->uid) {
      wp_die(__('You do not have permission.', 'kboard'));
    }

    $board = $content->getBoard();

    if (!$content->isReader()) {
      if ($board->permission_read != 'all' && !is_user_logged_in()) {
        wp_die(__('You do not have permission.', 'kboard'));
      } else if ($content->secret) {
        if (!$content->isConfirm()) {
          if ($content->parent_uid) {
            $parent = new KBContent();
            $parent->initWithUID($content->getTopContentUID());
            if (!$board->isReader($parent->member_uid, $content->secret) && !$parent->isConfirm()) {
              wp_die(__('You do not have permission.', 'kboard'));
            }
          } else {
            wp_die(__('You do not have permission.', 'kboard'));
          }
        }
      } else {
        wp_die(__('You do not have permission.', 'kboard'));
      }
    }

    include_once KBOARD_DIR_PATH . '/skin/wmc-attendee-list/document_print.php';
    exit;
  }
}

function kboard_wmc_get_statistics($board)
{
  global $wpdb;

  if (!$board) return [];
  if (!($board instanceof KBoard)) {
    return [];
  }

  $missionary_training_camp_meta_key = 'missionary_training_camp';
  $registration_meta_key = 'registration';

  $fields = $board->fields();
  $missionary_training_options = array_reduce(array_values($fields->skin_fields[$missionary_training_camp_meta_key]['row']), function ($acc, $cur) {
    $acc[$cur['label']] = 0;
    return $acc;
  }, []);
  $registration_options = array_reduce(array_values($fields->skin_fields[$registration_meta_key]['row']), function ($acc, $cur) {
    $acc[$cur['label']] = 0;
    return $acc;
  }, []);

  $missionary_training_camp_sql = "SELECT content_uid, option_value FROM {$wpdb->prefix}kboard_board_option INNER JOIN {$wpdb->prefix}kboard_board_content ON {$wpdb->prefix}kboard_board_content.uid = content_uid WHERE {$wpdb->prefix}kboard_board_content.status != 'trash' AND option_key = '{$missionary_training_camp_meta_key}'";
  $registration_sql = "SELECT content_uid, option_value FROM {$wpdb->prefix}kboard_board_option INNER JOIN {$wpdb->prefix}kboard_board_content ON {$wpdb->prefix}kboard_board_content.uid = content_uid WHERE {$wpdb->prefix}kboard_board_content.status != 'trash' AND option_key = '{$registration_meta_key}'";

  $missionary_training_camp_query_results = $wpdb->get_results($missionary_training_camp_sql);
  $registration_query_results = $wpdb->get_results($registration_sql);

  foreach ($missionary_training_camp_query_results as $row) {
    $option_value = $row->option_value;
    $missionary_training_options[$option_value] += 1;
  }

  foreach ($registration_query_results as $row) {
    $option_value = $row->option_value;
    $registration_options[$option_value] += 1;
  }

  ob_start(); ?>

  <div class="statistics">
    <div>
      <b>???????????????</b>
      <ul> <?php
            foreach ($missionary_training_options as $option => $count) { ?>
          <li>
            <span><?php echo $option; ?></span>
            <span><?php echo $count; ?></span>
          </li> <?php
              } ?>
      </ul>
    </div>
    <div>
      <b>????????????</b>
      <ul> <?php
            foreach ($registration_options as $option => $count) { ?>
          <li>
            <span><?php echo $option; ?></span>
            <span><?php echo $count; ?></span>
          </li> <?php
              } ?>
      </ul>
    </div>
  </div> <?php

          return ob_get_clean(); ?>
<?php
}

function kboard_wmc_get_tree_category_count($board_id, $depth, $category)
{
  global $wpdb;
  if ($depth !== 1 && $depth !== 2) return 0;

  $board_id = intval($board_id);
  $sql = "SELECT COUNT(*) FROM `{$wpdb->prefix}kboard_board_option` INNER JOIN {$wpdb->prefix}kboard_board_content ON {$wpdb->prefix}kboard_board_content.uid = content_uid WHERE {$wpdb->prefix}kboard_board_content.status != 'trash' AND (option_key = 'tree_category_{$depth}' AND option_value = '{$category}');";
  $count = $wpdb->get_var($sql);
  return $count;
}

// ?????? ??????
// add_filter('kboard_list_where', 'kboard_wmc_my_list_where', 99, 3);
function kboard_wmc_my_list_where($query_str_where, $board_id, $obj)
{
  global $wpdb;
  if (!isset($_GET['show_only_my_list']) || empty($_GET['show_only_my_list'])) return $query_str_where;
  if (isset($_GET['kboard_search_option']) && !empty($_GET['kboard_search_option'])) return $query_str_where;
  if (isset($_GET['keyword']) && !empty($_GET['keyword'])) return $query_str_where;

  $query = $query_str_where;

  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $query .= " AND `{$wpdb->prefix}kboard_board_content`.`member_uid` = {$user_id} ";
  }

  return $query;
}

// ??????????????? ?????? ????????????
add_action('kboard_skin_header', function ($builder) {
  $board = $builder->board;
  if ($board->id !== '1') {
    return;
  } ?>
  <script>
    jQuery(document).ready(() => {
      // ??????
      (($) => {
        const $selector = $('.meta-key-position select[name="kboard_option_position"]');
        if ($selector.length === 0) return; // select??? ?????? ????????? ?????? ????????? ??????????????? ????????????

        const fields = [$('.meta-key-position_etc')]; // toggle??? element?????? ?????? ????????? ????????????

        // value??? ????????? fields??? ?????? element?????? toggle?????????
        const toggle = (val) => {
          if (val === '??????') {
            // fields??? ???????????? ????????? forEach??? ????????? ?????? ???????????? show() ?????????
            // forEach ?????? : https://codechacha.com/ko/javascript-foreach/
            fields.forEach($el => $el.show());
          } else {
            fields.forEach($el => $el.hide());
          }
        }

        // ????????? ??????????????? ???????????? ?????? ???????????????. ????????????????????? ???????????????.
        toggle($selector.val());

        // select??? ?????? ??????????????? ?????????????????? ???????????????
        $selector.change(() => {
          toggle($selector.val());
        });
      })(jQuery); // ????????? jQuery??? ????????? ???????????? ????????????. ?????????????????? ?????? : https://jongminfire.dev/java-script-%EC%A6%89%EC%8B%9C%EC%8B%A4%ED%96%89%ED%95%A8%EC%88%98-iife

      // ???????????????
      (($) => {
        const $selector = $('.meta-key-how_to_attend select[name="kboard_option_how_to_attend"]');
        if ($selector.length === 0) return;

        // ????????? ????????? ????????????.
        const fields = [$('.meta-key-airfare_ticket_description'), $('.meta-key-airfare_krw'), $('.meta-key-invoice'), $('.meta-key-account_number'), $('.meta-key-deposit_request_date'), $('.meta-key-deposit_date')];

        const toggle = (val) => {
          if (val === '??????') {
            fields.forEach($el => $el.show());
          } else {
            fields.forEach($el => $el.hide());
          }
        }

        // ????????? ??????????????? ???????????? ?????? ????????????
        toggle($selector.val());

        // select??? ?????? ??????????????? ?????????????????? ????????????
        $selector.change(() => {
          toggle($selector.val());
        });
      })(jQuery);
    });
  </script>
<?php
});
