<div class="kboard-tree-category-search"> <?php
  $selectedList = $board->tree_category->getSelectedList();
  $isAllSelected = count($selectedList) === 0 || isset($_GET['is_all_sub_category']);

  // 전체를 클릭했을때
  if ($isAllSelected) {
    $tree_category_list = $board->tree_category->getCategoryItemList(); // 최상층 카테고리
    $board->tree_category->setTreeCategory($board->meta->tree_category); ?>
    <form id="kboard-tree-category-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>"> <?php
      echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput() ?>
      <div class="kboard-tree-category-wrap">
        <div class="kboard-search-option-wrap-1 kboard-search-option-wrap type-tab">
          <input type="hidden" name="is_all_sub_category" value="true">
          <input type="hidden" name="kboard_search_option[tree_category_1][key]" value="tree_category_1">
          <input type="hidden" name="kboard_search_option[tree_category_1][value]" value="<?php echo $board->tree_category->getCategoryNameWithDepth(1); ?>">
          <ul class="kboard-tree-category">
            <li class="kboard-category-selected"><a href="#" onclick="return kboard_tree_category_search('1', '')"><?php echo __('All', 'kboard')?></a></li>
            <?php foreach($tree_category_list as $item):?>
            <!-- is_all_sub_category를 삭제하고 보낸다 -->
            <li>
              <a href="#" onclick="return (() => { kboard_wmc_remove_is_all_category_field(); kboard_tree_category_search('1', '<?php echo $item['category_name']?>'); })()"> <?php 
                echo $item['category_name']?>
                <span class="category-count"><?php echo kboard_wmc_get_tree_category_count($board->id, 1, $item['category_name']); ?></span>
              </a>
            </li>
            <?php endforeach ?>
          </ul>
        </div>
        <div class="kboard-search-option-wrap-2 kboard-search-option-wrap type-tab">
          <input type="hidden" name="kboard_search_option[tree_category_2][key]" value="tree_category_2">
          <input type="hidden" name="kboard_search_option[tree_category_2][value]" value="<?php echo '미국'?>">
          <ul class="kboard-tree-category"> <?php
            $current_selected_cat = $board->tree_category->getCategoryNameWithDepth(2);
            foreach($tree_category_list as $item) {
              $sub_cats = $board->tree_category->getAdminTreeCategoryChildren($item['id']);
                foreach ($sub_cats as $sub_cat) { ?>
                  <li class="<?php echo $current_selected_cat === $sub_cat['category_name'] ? 'kboard-category-selected' : ''; ?>">
                    <a href="#" onclick="return kboard_tree_category_search_for_all('<?php echo $sub_cat['category_name']; ?>', '<?php echo $item['category_name']; ?>');"> <?php
                      echo $sub_cat['category_name']; ?>
                      <span class="category-count"><?php echo kboard_wmc_get_tree_category_count($board->id, 2, $sub_cat['category_name']); ?></span>
                    </a>
                  </li> <?php
                }
            } ?>
          </ul>
        </div>
      </div>
    </form> <?php
  } else { ?>
    <form id="kboard-tree-category-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
      <?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
      
      <div class="kboard-tree-category-wrap">
        <?php $tree_category_list = $board->tree_category->getCategoryItemList(); ?>
        <div class="kboard-search-option-wrap-<?php echo $board->tree_category->depth?> kboard-search-option-wrap type-tab">
          <input type="hidden" name="kboard_search_option[tree_category_<?php echo $board->tree_category->depth?>][key]" value="tree_category_<?php echo $board->tree_category->depth?>">
          <input type="hidden" name="kboard_search_option[tree_category_<?php echo $board->tree_category->depth?>][value]" value="<?php echo $board->tree_category->getCategoryNameWithDepth($board->tree_category->depth)?>">
          <ul class="kboard-tree-category">
            <li<?php if(!$board->tree_category->getCategoryNameWithDepth($board->tree_category->depth)):?> class="kboard-category-selected"<?php endif?>><a href="#" onclick="return kboard_tree_category_search('<?php echo $board->tree_category->depth?>', '')"><?php echo __('All', 'kboard')?></a></li>
            <?php foreach($tree_category_list as $item):?>
            <li<?php if($board->tree_category->getCategoryNameWithDepth($board->tree_category->depth) == $item['category_name']):?> class="kboard-category-selected"<?php endif?>><a href="#" onclick="return kboard_tree_category_search('<?php echo $board->tree_category->depth?>', '<?php echo $item['category_name']?>')"><?php echo $item['category_name']?> <span><?php echo kboard_wmc_get_tree_category_count($board->id, $board->tree_category->depth, $item['category_name']); ?></span></a></li>
            <?php endforeach?>
          </ul>
        </div> <?php
        foreach($board->tree_category->getSelectedList() as $key=>$category_name) {
          $tree_category_list = $board->tree_category->getCategoryItemList($category_name);
          if ( $tree_category_list ) { ?>
            <div class="kboard-search-option-wrap-<?php echo $board->tree_category->depth?> kboard-search-option-wrap type-tab">
              <input type="hidden" name="kboard_search_option[tree_category_<?php echo $board->tree_category->depth?>][key]" value="tree_category_<?php echo $board->tree_category->depth?>">
              <input type="hidden" name="kboard_search_option[tree_category_<?php echo $board->tree_category->depth?>][value]" value="<?php echo $board->tree_category->getCategoryNameWithDepth($board->tree_category->depth)?>">
              <ul class="kboard-tree-category">
                <li<?php if(!$board->tree_category->getCategoryNameWithDepth($board->tree_category->depth)):?> class="kboard-category-selected"<?php endif?>><a href="#" onclick="return kboard_tree_category_search('<?php echo $board->tree_category->depth?>', '')"><?php echo __('All', 'kboard')?></a></li>
                <?php foreach($tree_category_list as $item):?>
                <li<?php if($board->tree_category->getCategoryNameWithDepth($board->tree_category->depth) == $item['category_name']):?> class="kboard-category-selected"<?php endif?>><a href="#" onclick="return kboard_tree_category_search('<?php echo $board->tree_category->depth?>', '<?php echo $item['category_name']?>')"><?php echo $item['category_name']?> <span><?php echo kboard_wmc_get_tree_category_count($board->id, $board->tree_category->depth, $item['category_name']); ?></span> </a></li>
                <?php endforeach?>
              </ul>
            </div> <?php
          }
        } ?>
      </div>
    </form> <?php
  } ?>
</div>
