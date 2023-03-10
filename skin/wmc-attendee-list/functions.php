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

// 생년월일 -> 나이 구하기 - 시작
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
// 생년월일 -> 나이 구하기 - 끝

// 이름으로 정렬하기 - 시작
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
// 이름으로 정렬하기 - 끝


// 검색 고도화 하기 - 시작
if (!function_exists('kboard_wmc_get_custom_fields')) {
  // 검색시 이 필드들이 query에 들어가도록 한다
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

// 검색 옵션에 위의 커스텀 필드들을 넣는다
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

// 커스텀 필드를 바탕으로 생성된 수많은 INNER_JOIN을 하나로 바꿔준다
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

// 필드들을 넣으면 where절이 막 생기는데 이를 수정한다
// 1. 검색어와 옵션검색을 AND로 연결하는데, 이것을 OR로 바꿔준다
// 2. from 구문에서 INNER_JOIN을 하나 빼고 삭제했기 때문에, 커스텀 필드용 INNER_JOIN을 삭제하고 정식 INNER_JOIN 하나만 남겨놓는다
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

    // 카테고리도 반영해주자
    // 카테고리는 반영하지 않는다
    // if (isset($_REQUEST['tree_category_1']) && !empty($_REQUEST['tree_category_1']) && isset($_REQUEST['tree_category_2']) && !empty($_REQUEST['tree_category_2'])) {
    //   $category1 = $_REQUEST['tree_category_1'];
    //   $category2 = $_REQUEST['tree_category_2'];
    //   $query = $query . " AND ( (`{$prefix}kboard_board_option`.`option_key` = 'tree_category_1' AND {$prefix}kboard_board_option`.`option_value` = '{$category1}') AND (`{$prefix}kboard_board_option`.`option_key` = 'tree_category_2' AND {$prefix}kboard_board_option`.`option_value` = '{$category2}')) ";
    // }

    // member_display는 이름
    // title은 참석자
    // content는 기도제목
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

    $query = $query . implode('', $sub_where) . ')'; // 여기서 AND 끝내고

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

    // 여기 AND (( 주의!
    $query = "
      SELECT COUNT(*)
      FROM `{$prefix}kboard_board_content`
      INNER JOIN `{$prefix}kboard_board_option`
      ON `{$prefix}kboard_board_content`.`uid` = `{$prefix}kboard_board_option`.`content_uid`
      WHERE `{$prefix}kboard_board_content`.`board_id` = '{$board_id}'
    ";

    // 카테고리도 반영해주자
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

    $query = $query . implode('', $sub_where) . ')'; // 여기서 AND 끝내고

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

// 카테고리 검색 오류 수정
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

// 검색 고도화 하기 - 끝


// 상세보기를 누르면 조회수를 올린다
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
          'col_name' => '순번',
          'option_key' => 'uid',
        ),
        'B' => array(
          'col_name' => '이름',
          'option_key' => 'title',
        ),
        'C' => array(
          'col_name' => '직분',
          'option_key' => 'position'
        ),
        'D' => array(
          'col_name' => '교회명',
          'option_key' => 'church_name'
        ),
        'E' => array(
          'col_name' => '권역',
          'option_key' => 'tree_category_1'
        ),
        'F' => array(
          'col_name' => '나라',
          'option_key' => 'tree_category_2'
        ),
        'G' => array(
          'col_name' => '지역',
          'option_key' => 'region'
        ),
        'H' => array(
          'col_name' => '선교사합숙 여부',
          'option_key' => 'missionary_training_camp'
        ),
        'I' => array(
          'col_name' => '대회등록 여부',
          'option_key' => 'registration'
        ),
        'J' => array(
          'col_name' => '참석방법',
          'option_key' => 'how_to_attend'
        ),
        'K' => array(
          'col_name' => '참석인원',
          'option_key' => 'number_of_attendees'
        ),
        'L' => array(
          'col_name' => '소통담당',
          'option_key' => 'communication'
        ),
        'M' => array(
          'col_name' => '항공권발권일',
          'option_key' => 'ticket_issue_date'
        ),
        'N' => array(
          'col_name' => '편도/왕복',
          'option_key' => 'one_way_return'
        ),
        'O' => array(
          'col_name' => '탑승인원',
          'option_key' => 'number_of_passengers'
        ),
        'P' => array(
          'col_name' => '인보이스',
          'option_key' => 'invoice'
        ),
        'Q' => array(
          'col_name' => '항공료(항공권기재)',
          'option_key' => 'airfare_ticket_description'
        ),
        'R' => array(
          'col_name' => '항공료(KRW)',
          'option_key' => 'airfare_krw'
        ),
        'S' => array(
          'col_name' => '계좌번호',
          'option_key' => 'account_number'
        ),
        'T' => array(
          'col_name' => '입금요청일',
          'option_key' => 'deposit_request_date'
        ),
        'U' => array(
          'col_name' => '입금일',
          'option_key' => 'deposit_date'
        ),
        'V' => array(
          'col_name' => '입국날짜',
          'option_key' => 'date_of_entry'
        ),
        'W' => array(
          'col_name' => '출국날짜',
          'option_key' => 'departure_date'
        ),
        'X' => array(
          'col_name' => '대회장으로 이동방법',
          'option_key' => 'accommodation_to_venue'
        ),
        'Y' => array(
          'col_name' => '대회장에서 숙소 이동방법',
          'option_key' => 'venue_to_accommodation'
        ),
        'Z' => array(
          'col_name' => '숙소에서 교회으로 이동방법',
          'option_key' => 'church_to_accommodation'
        ),
        'AA' => array(
          'col_name' => '교회에서 숙소로 이동방법',
          'option_key' => 'accommodation_to_church'
        ),
        'AB' => array(
          'col_name' => '숙소지원',
          'option_key' => 'accommodation_support'
        ),
        'AC' => array(
          'col_name' => '대회이후 지원필요 여부',
          'option_key' => 'after_the_conference'
        ),
        'AD' => array(
          'col_name' => '대회이후 지원 내용',
          'option_key' => 'details_of_support'
        ),
        'AE' => array(
          'col_name' => '비고',
          'option_key' => 'note'
        ),
        'AF' => array(
          'col_name' => '주요 소통 방법',
          'option_key' => 'how_to_contact'
        ),
        'AG' => array(
          'col_name' => '이메일',
          'option_key' => 'contact_email'
        ),
        'AH' => array(
          'col_name' => '핸드폰(국가번호 포함)',
          'option_key' => 'contact_mobile'
        ),
        'AI' => array(
          'col_name' => 'SNS(카톡)',
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


// print할때 커스텀 php파일을 불러온다
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
      <b>선교사합숙</b>
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
      <b>대회등록</b>
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

// 내가 쓴글
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

// 조건적으로 필드 보여주기
add_action('kboard_skin_header', function ($builder) {
  $board = $builder->board;
  if ($board->id !== '1') {
    return;
  } ?>
  <script>
    jQuery(document).ready(() => {
      // 직분
      (($) => {
        const $selector = $('.meta-key-position select[name="kboard_option_position"]');
        if ($selector.length === 0) return; // select가 없는 경우에 아래 코드를 작동시키지 않습니다

        const fields = [$('.meta-key-position_etc')]; // toggle할 element들을 미리 저장해 놓습니다

        // value에 따라서 fields에 있는 element들을 toggle합니다
        const toggle = (val) => {
          if (val === '기타') {
            // fields는 배열이기 때문에 forEach로 배열의 모든 원소들을 show() 합니다
            // forEach 설명 : https://codechacha.com/ko/javascript-foreach/
            fields.forEach($el => $el.show());
          } else {
            fields.forEach($el => $el.hide());
          }
        }

        // 처음에 들어왔을때 보여줄지 말지 결정합니다. 수정페이지에서 유용합니다.
        toggle($selector.val());

        // select로 값을 변경했을때 보여줄지말지 선택합니다
        $selector.change(() => {
          toggle($selector.val());
        });
      })(jQuery); // 이렇게 jQuery로 인자를 넘겨줄수 있습니다. 즉시실행함수 설명 : https://jongminfire.dev/java-script-%EC%A6%89%EC%8B%9C%EC%8B%A4%ED%96%89%ED%95%A8%EC%88%98-iife

      // 항공권비용
      (($) => {
        const $selector = $('.meta-key-how_to_attend select[name="kboard_option_how_to_attend"]');
        if ($selector.length === 0) return;

        // 항공은 필드가 많습니다.
        const fields = [$('.meta-key-airfare_ticket_description'), $('.meta-key-airfare_krw'), $('.meta-key-invoice'), $('.meta-key-account_number'), $('.meta-key-deposit_request_date'), $('.meta-key-deposit_date')];

        const toggle = (val) => {
          if (val === '신청') {
            fields.forEach($el => $el.show());
          } else {
            fields.forEach($el => $el.hide());
          }
        }

        // 처음에 들어왔을때 보여줄지 말지 결정한다
        toggle($selector.val());

        // select로 값을 변경했을때 보여줄지말지 선택한다
        $selector.change(() => {
          toggle($selector.val());
        });
      })(jQuery);
    });
  </script>
<?php
});
