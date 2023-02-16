/**
 * @author https://www.cosmosfarm.com/
 */

jQuery(document).ready(function () {
  kboard_wmc_attendee_list_layout();
});

jQuery(window).resize(function () {
  kboard_wmc_attendee_list_layout();
});

function kboard_wmc_attendee_list_layout() {
  jQuery(".kboard-wmc-attendee-list-list").each(function () {
    var list = jQuery(this).width();
    if (list < 600) {
      // mobile
      jQuery(this).addClass("mobile");
    } else {
      // pc
      jQuery(this).removeClass("mobile");
    }
  });
}

function kboard_wmc_attendee_list_shortcut(obj, content_uid, link_target) {
  var url = jQuery(obj).attr("href");
  if (url && url.length > 7) {
    jQuery.post(kboard_settings.alax_url, {
      action: "kboard_wmc_attendee_list_shortcusts",
      content_uid: content_uid,
    });
    if (link_target == "new") {
      window.open(url);
    } else if (link_target == "self") {
      window.location.href = url;
    }
  } else {
    alert(kboard_wmc_attendee_list_localize_strings.missing_link_address);
  }
  return false;
}

function kboard_wmc_remove_is_all_category_field() {
  jQuery('input[name="is_all_sub_category"]').remove();
}

function kboard_tree_category_search_for_all(cat_name, parent_cat_name) {
  jQuery('input[name="kboard_search_option[tree_category_1][value]"]').val(
    parent_cat_name
  );
  jQuery('input[name="kboard_search_option[tree_category_2][value]"]').val(
    cat_name
  );

  console.log("kboard_current", kboard_current);

  jQuery(
    "#kboard-tree-category-search-form-" + kboard_current.board_id
  ).submit();

  return false;
}
