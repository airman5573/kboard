<?php
$is_loaded = false;
while($content = $list->hasNext()):
  $uid = $list->row->uid;
  $index = $list->index();
?>
<tr class="<?php if($content->uid == kboard_uid()):?>kboard-list-selected<?php endif?>">
	<td class="kboard-list-uid"><?php echo $list->index()?></td>
	<td class="kboard-list-category"><?php echo $content->option->tree_category_1?></td>
	<td class="kboard-list-category"><?php echo $content->option->tree_category_2?></td>
	<td class="kboard-list-title">
			<div class="kboard-wmc-attendee-list-cut-strings">
				<?php echo $content->title?>
				<?php if($content->isNew()):?><span class="kboard-wmc-attendee-list-new-notify">New</span><?php endif?>
			</div>
		<div class="kboard-mobile-contents">
			<span class="contents-item kboard-user"><?php echo $content->getUserDisplay()?></span>
			<span class="contents-separator kboard-date">|</span>
			<span class="contents-item kboard-date"><?php echo $content->getDate()?></span>
			<span class="contents-separator kboard-view">|</span>
			<span class="contents-item kboard-view"><a class="kboard-wmc-attendee-list-button-view" href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">보기</a></span>
		</div>
	</td>
	<td class="kboard-list-user"><?php echo $content->option->{'position'}?></td>
	<td class="kboard-list-user"><?php echo $content->option->{'missionary_training_camp'}?></td>
	<td class="kboard-list-user"><?php echo $content->option->{'registration'}?></td>
	<td class="kboard-list-user"><?php echo $content->option->{'how_to_attend'}?></td>
	<td class="kboard-list-user"><?php echo $content->option->{'number_of_attendees'}?></td>
	<td class="kboard-list-user"><?php echo $content->getUserDisplay()?></td>
	<td class="kboard-list-date"><?php echo $content->getDate()?></td>
	<td class="kboard-list-view"><a class="kboard-wmc-attendee-list-button-view" href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">보기</a></td>
</tr>
<?php endwhile?>
