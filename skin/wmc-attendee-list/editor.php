<style>
.main-content { padding-top: 0; }
.editor-subtitle{ text-align: left; font-size: 1.25rem; font-weight: 700; color: #fff; margin: 50px 0 20px 0; width:100%!important; background: #555; padding: 10px; }
select { -webkit-appearance:none!important; -moz-appearance:none!important; appearance:none!important; }
#kboard-wmc-attendee-list-editor .editor-textarea { height:100px; }
.kboard-tree-category-wrap select.kboard-tree-category { width:50%!important; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-tree-category{ width:50%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-option { width:20%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-password { width:30%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait { width:20%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait .attr-value {height: 275px; text-align: center;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait .attr-value img { height: 150px; margin-bottom: 10px; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo { width:50%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo .attr-value {height: 420px; text-align: center;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo .attr-value img { height: auto; max-height: 300px; margin-bottom: 10px; }
#kboard-wmc-attendee-list-editor .kboard-attr-author, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-english_name, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-position, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-gender, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-birth_date, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_mobile, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_tel, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_fax, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-registration, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-how_to_attend, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_attendees, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-communication, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-missionary_training_camp, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-date_of_entry,
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-departure_date, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-ticket_issue_date, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-one_way_return, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_passengers, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-invoice, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-deposit_request_date, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-deposit_date { width:20%!important; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_email, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-sns, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-airfare_ticket_description, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-airfare_krw { width:40%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-title, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-distribution_of_religion, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_address, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-5basic_status, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-ministry_status, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-request_for_support { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_matters, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo { width:50%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-region, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-national_language, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_name, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-building_rental_status, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-rental_cost, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_churchmembers, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_to_venue, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-venue_to_accommodation, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_to_accommodation, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_to_church, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_support, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-after_the_conference, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-how_to_contact{ width:25%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-account_number { width:60%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_iocation, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-details_of_support, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-note { width:75%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-home_address { width:80%!important;}

@media screen and (max-width: 600px) {
.kboard-tree-category-wrap select.kboard-tree-category { width:50%!important; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-tree-category{ width:100%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-option { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-password { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait { width:50%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait .attr-value {height: 275px; text-align: center;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-portrait .attr-value img { height: 150px; margin-bottom: 10px; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo { width:50%;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo .attr-value {height: 180px; text-align: center;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo .attr-value img { height: auto; margin-bottom: 10px; max-height: 150px; }
#kboard-wmc-attendee-list-editor .kboard-attr-author, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-english_name, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-position, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-gender, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-birth_date, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_mobile, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_tel, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_fax, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-registration, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-how_to_attend, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_attendees, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-communication, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-missionary_training_camp, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-date_of_entry,
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-departure_date, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-ticket_issue_date, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-one_way_return, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_passengers, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-invoice, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-deposit_request_date, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-deposit_date { width:50%!important; }
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-contact_email, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-sns, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-airfare_ticket_description, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-airfare_krw { width:50%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.kboard-attr-title, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-distribution_of_religion, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_address, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-5basic_status, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-ministry_status, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-building_rental_status, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_name, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-request_for_support { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_matters, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-family_photo { width:50%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-region, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-national_language, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-rental_cost, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-number_of_churchmembers, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_to_venue, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-venue_to_accommodation, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-church_to_accommodation, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_to_church, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_support, 
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-after_the_conference, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-how_to_contact{ width:50%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-account_number { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-accommodation_iocation, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-details_of_support, #kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-note { width:100%!important;}
#kboard-wmc-attendee-list-editor .kboard-attr-row.meta-key-home_address { width:100%!important;}   
}    
</style>
<div id="kboard-wmc-attendee-list-editor">
	<form class="kboard-form" method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php $skin->editorHeader($content, $board)?>
		
<?php foreach($board->fields()->getSkinFields() as $key=>$field):?>
			<?php echo $board->fields()->getTemplate($field, $content, $boardBuilder)?>
		<?php endforeach?>
		
		<div class="kboard-control">
			<div class="left">
				<?php if($content->uid):?>
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>" class="kboard-wmc-attendee-list-button-small"><?php echo __('Back', 'kboard')?></a>
				<a href="<?php echo esc_url($url->getBoardList())?>" class="kboard-wmc-attendee-list-button-small"><?php echo __('List', 'kboard')?></a>
				<?php else:?>
				<a href="<?php echo esc_url($url->getBoardList())?>" class="kboard-wmc-attendee-list-button-small"><?php echo __('Back', 'kboard')?></a>
				<?php endif?>
			</div>
			<div class="right">
				<?php if($board->isWriter()):?>
					<button type="submit" class="kboard-wmc-attendee-list-button-small" title="<?php echo __('등록', 'kboard-wmc-attendee-list')?>"><?php echo __('등록', 'kboard-wmc-attendee-list')?></button>
				<?php endif?>
			</div>
		</div>
	</form>
</div>

<?php wp_enqueue_script('kboard-wmc-attendee-list-script', "{$skin_path}/script.js", array(), KBOARD_VERSION, true)?>