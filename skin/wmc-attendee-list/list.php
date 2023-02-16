<?php
$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
if ($action == 'kboard_wmc_more_view_action'):
	// 리스트 레이아웃을 불러온다.
	if (isset($_GET['current_page']) && $_GET['current_page'] == 'admin') {
		include 'list-admin.php';
	}
	else{
		include 'list-user.php';
	}
else: ?>

<div id="kboard-wmc-attendee-list-list">
	<input type="hidden" name="kboard_wmc_list_latest_board_url" value="<?php echo $_SERVER['REQUEST_URI']?>">
	<input type="hidden" name="kboard_wmc_list_page" value="<?php echo $list->page?>">
	<input type="hidden" name="kboard_wmc_list_tree_category_1" value="<?php echo $list->tree_category_1?>">
	<input type="hidden" name="kboard_wmc_list_tree_category_2" value="<?php echo $list->tree_category_2?>">
	<input type="hidden" name="kboard_wmc_list_current_page" value="<?php echo is_admin() ? 'admin' : ''?>">
	
	<div class="kboard-wmc-attendee-list-list">
		<!-- 게시판 정보 시작 -->
		<div class="kboard-list-header">
			
			<!-- 검색폼 시작 -->
			<div class="kboard-search">
				<form id="kboard-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
		        	<?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
					<input type="text" name="keyword" value="<?php echo kboard_keyword()?>" placeholder="이름, 연락처, 이메일, 교회명 등을 입력하세요" required>
					<button type="submit" class="kboard-search-button"><i class="xi-search"></i></button>
				</form>
			</div>
			<!-- 검색폼 끝 -->
		</div>
		<!-- 게시판 정보 끝 -->
	<!-- 카테고리 시작 -->
	<?php
	if($board->use_category == 'yes'){
		if($board->isTreeCategoryActive()){
			$category_type = 'tree-select';
		}
		else{
			$category_type = 'default';
		}
		$category_type = apply_filters('kboard_skin_category_type', $category_type, $board, $boardBuilder);
		echo $skin->load($board->skin, "list-category-{$category_type}.php", $vars);
	}
	?>
	<!-- 카테고리 끝 -->	

  <!-- 통계 시작 -->
  <?php echo kboard_wmc_get_statistics($board); ?>
  <!-- 통계 끝 -->
	
	<!-- 리스트 정렬 시작 -->
	<div class="kboard-count-sort">
		<?php if(!$board->isPrivate()):?>
			<div class="kboard-total-count"> <?php
        if (isset($_GET['category1']) && !empty($_GET['category1'])) {
          echo '전체 ' . number_format($board->getListTotal()) . '명중 - ' . $_GET['category1'] . '권역 ' . kboard_wmc_get_list_count_by_category($board) . '명 <b>' . $_GET['category2'] . ' ' . kboard_wmc_get_list_count_by_category($board) . '명</b>';
        } else {
          echo '전체 ' . number_format($board->getListTotal()) . '명';
        } ?>
			</div>
		<?php endif?>
		
		<div class="kboard-sort">
			<form id="kboard-sort-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
				<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->set('kboard_list_sort_remember', $board->id)->toInput()?>
				
				<select name="kboard_list_sort" onchange="jQuery('#kboard-sort-form-<?php echo $board->id?>').submit();">
          <option value="name"<?php if($list->getSorting() == 'name'):?> selected<?php endif?>>가나다순</option>
					<option value="newest"<?php if($list->getSorting() == 'newest'):?> selected<?php endif?>>최신순</option>
          <option value="updated"<?php if($list->getSorting() == 'updated'):?> selected<?php endif?>>업데이트순</option>
				</select>

        <select name="kboard_list_rpp" onchange="jQuery('#kboard-sort-form-<?php echo $board->id?>').submit();">
          <option value="20"<?php if($list->getRpp() === 20):?> selected<?php endif?>>20개</option>
          <option value="50"<?php if($list->getRpp() === 50):?> selected<?php endif?>>50개</option>
          <option value="100"<?php if($list->getRpp() === 100):?> selected<?php endif?>>100개</option>
          <option value="200"<?php if($list->getRpp() === 200):?> selected<?php endif?>>200개</option>
          <option value="500"<?php if($list->getRpp() === 500):?> selected<?php endif?>>500개</option>
				</select>
			</form> <?php
        if (is_user_logged_in()) { ?>
          <a id="show-only-my-list-link" href="/wmc-sponsorship/?show_only_my_list=true">내가 쓴 글 보기</a> <?php
        } ?>
		</div>
	</div>
	<!-- 리스트 정렬 끝 -->
	
		<!-- 리스트 시작 -->
		<div class="kboard-list">
			<table>
				<thead>
					<tr>
				    	<td class="kboard-list-uid"><?php echo __('Number', 'kboard')?></td>
			    		<td class="kboard-list-category"><?php echo __('권역', 'kboard')?></td>
                    	<td class="kboard-list-category"><?php echo __('나라', 'kboard')?></td>
				    	<td class="kboard-list-title"><?php echo __('참석자', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('직분', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('선교사합숙', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('대회등록', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('참여방법', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('참여인원', 'kboard')?></td>
				    	<td class="kboard-list-user"><?php echo __('작성자', 'kboard')?></td>
			    		<td class="kboard-list-date"><?php echo __('작성일', 'kboard')?></td>
			    		<td class="kboard-list-view"><?php echo __('보기', 'kboard')?></td>
				    </tr>
				</thead>
				<tbody>
					<?php
                         // 리스트 레이아웃을 불러온다.
                        if(is_admin()){
                          include_once 'list-admin.php';
                        }
                        else{
                          include_once 'list-user.php';
                        }
					?>
				</tbody>
			</table>
		</div>
		<!-- 리스트 끝 -->
		
		<!-- 페이징 시작 -->
		<div class="kboard-pagination">
			<button class="kboard-wmc-attendee-list-button-small" title="<?php echo __('더보기', 'kboard-wmc-attendee-list')?>"><?php echo __('더보기', 'kboard-wmc-attendee-list')?></button>
		</div>
		<!-- 페이징 끝 -->

<div style=" width: 30%; float: left; font-size: 0.8rem;">
  <input type="hidden" name="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
  <input type="hidden" name="board_id" value="<?php echo $board->id; ?>" />
  <?php if (current_user_can('manage_kboard')) { ?>
    <form method="GET" action="/">
      <input type="hidden" name="board_id_for_xlsx_download" value="<?php echo $board->id; ?>" />
      <input type="hidden" name="kboard_wmc_xlsx_download" value="1" /> <?php
      wp_nonce_field( 'kboard_wmc_xlsx_download_action', 'kboard_wmc_xlsx_download_nonce' ); ?>
      <button type="submit"><i class="xi-download"></i> Excel</button>
    </form>
  <?php  } ?>
</div>
		<?php if($board->isWriter()):?>
			<div class="writer_button" style="text-align: right;"><a href="<?php echo $url->getContentEditor()?>" class="kboard-wmc-attendee-list-button-small" title="<?php echo __('등록하기', 'kboard-wmc-attendee-list')?>"><?php echo __('등록하기', 'kboard-wmc-attendee-list')?></a></div>
		<?php endif?>
				
		<?php if($board->contribution()):?>
		<div class="kboard-wmc-attendee-list-poweredby">
			<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
		</div>
		<?php endif?>
	</div>
</div>
<?php wp_enqueue_script('kboard-wmc-attendee-list-list', "{$skin_path}/list.js", array(), '0.0.1', true)?>
<?php endif?>
