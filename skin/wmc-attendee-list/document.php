<style>
  .subtitle {
    text-align: left;
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 20px 0 20px 0;
    width: 100% !important;
    background: #555;
    padding: 10px;
  }

  .personal_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .personal_information .left {
    width: 19%;
    float: left;
    margin-right: 1%;
  }

  .personal_information .left .portrait {
    width: 180px;
    height: 180px;
    background-image: url(<?php echo $content->attach->{'portrait'}[0]; ?>) !important;
    background-position: center top !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-blend-mode: multiply;
  }

  ..personal_information .left img {
    max-width: 180px;
    width: 100%;
    border: 2px solid #888;
  }

  .personal_information .right {
    width: 80%;
    float: right;
  }

  .personal_information .right .info_1line {
    border-bottom: 1px solid #333;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .personal_information .right .info_1line .info_item span.title {
    font-size: 2rem;
    font-weight: 700;
  }

  .personal_information .right .info_1line .info_item span {
    font-size: 1.2rem;
    font-weight: 300;
  }

  .personal_information .right .info_2line .info_item {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .personal_information .right .info_2line .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .personal_information .right .info_2line .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .personal_information .right .info_2line .info_item.last_item1 {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .personal_information .right .info_2line .info_item.last_item2 {
    width: 74.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .family_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .family_information .left {
    width: 49%;
    float: left;
    margin-right: 1%;
  }

  .family_information .left .family_photo {
    width: 500px;
    height: 300px;
    background-image: url(<?php echo $content->attach->{'family_photo'}[0]; ?>) !important;
    background-position: center top !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-blend-mode: multiply;
  }

  .family_information .left img {
    max-width: 500px;
    width: 100%;
    border: 2px solid #888;
  }

  .family_information .right {
    width: 50%;
    float: right;
  }

  .family_information .right .info_line .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 0px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .family_information .right .info_line .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .family_information .right .info_line .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .missionary_history_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .missionary_history_information .info {
    width: 100%;
    float: left;
  }

  .missionary_history_information .info .info_line .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .missionary_history_information .info .info_line .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .missionary_history_information .info .info_line .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .mission_country_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .mission_country_information .info {
    width: 100%;
    float: left;
  }

  .mission_country_information .info .info_line1 .info_item {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_country_information .info .info_line2 .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_country_information .info .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .mission_country_information .info .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .ministry_status_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .ministry_status_information .info {
    width: 100%;
    float: left;
  }

  .ministry_status_information .info .info_line1 .info_item {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .ministry_status_information .info .info_line2 .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .ministry_status_information .info .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .ministry_status_information .info .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .prayer_title_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .prayer_title_information .info {
    width: 100%;
    float: left;
  }

  .prayer_title_information .info .info_line .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .prayer_title_information .info .info_line .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .prayer_title_information .info .info_line .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .request_for_support_area {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .request_for_support_area .info {
    width: 100%;
    float: left;
  }

  .request_for_support_area .info .info_line .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .request_for_support_area .info .info_line .info_item span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .request_for_support_area .info .info_line .info_item span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .mission_conference_information {
    display: inline-block;
    margin-bottom: 35px;
    width: 100%;
  }

  .mission_conference_information .info {
    width: 100%;
    float: left;
  }

  .mission_conference_information .info .info_line1 .info_item {
    width: 100%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_conference_information .info .info_line2 .info_item {
    width: 19.7%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_conference_information .info .info_line3 .info_item {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_conference_information .info .info_line4 .info_item1 {
    width: 24.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_conference_information .info .info_line4 .info_item2 {
    width: 74.5%;
    display: inline-block;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
    padding-bottom: 10px;
  }

  .mission_conference_information .info span.item_name {
    display: inline-block;
    font-size: 1rem;
    font-weight: 300;
    width: 100%;
    color: #999;
    margin-bottom: 5px;
  }

  .mission_conference_information .info span.value {
    display: inline-block;
    font-size: 1.25rem;
    font-weight: 400;
    width: 100%;
    color: #222;
    margin-bottom: 10px;
  }

  .mobile_off {
    display: inline !important;
  }

  .mobile_on {
    display: none !important;
  }

  @media screen and (max-width: 600px) {
    .document_top_area .document_top_left .portrait {
      width: 100%;
      height: 180px;
      background-image: url(<?php echo $content->attach->{'portrait'}[0]; ?>) !important;
      background-position: center top !important;
      background-repeat: no-repeat !important;
      background-size: cover !important;
      background-blend-mode: multiply;
    }

    .mobile_off {
      display: none !important;
    }

    .mobile_on {
      display: inline !important;
    }
  }

  .hidden {
    display: none !important;
  }
</style>
<?php
$options = $content->option->row;
$age = '';
if (isset($options['birth_date'])) {
  $birth_date = $options['birth_date'];
  if (function_exists('kboard_wmc_is_valid_date') && kboard_wmc_is_valid_date($birth_date)) {
    if (function_exists('kboard_wmc_get_age')) {
      $age = kboard_wmc_get_age($birth_date);
    }
  }
} ?>
<div id="kboard-document">
  <div id="kboard-wmc-attendee-list-document">
    <div class="kboard-document-wrap" itemscope itemtype="http://schema.org/Article">
      <div class="personal_information">
        <div class="subtitle">????????????</div>
        <div class="left">
          <?php if ($content->attach->{'portrait'}[1]) : ?><div class="portrait"></div><?php else : ?><img src="<?php echo $skin_path ?>/noimg.jpg"><?php endif ?>
        </div>
        <div class="right">
          <div class="info_1line">
            <div class="info_item"><span class="title"><?php echo $content->getUserDisplay() ?></span><span> <?php echo $content->option->{'english_name'} ?>&nbsp;</span></div>
          </div>
          <div class="info_2line">
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $content->option->{'Gender'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $age; ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo date('Y.m.d', strtotime($content->option->{'Birth_Date'})) ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $content->option->{'position'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">?????????(???????????? ??????)</span><span class="value"><?php echo $content->option->{'contact_mobile'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????(???????????? ??????)</span><span class="value"><?php echo $content->option->{'contact_tel'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????(???????????? ??????)</span><span class="value"><?php echo $content->option->{'contact_fax'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">?????????</span><span class="value"><?php echo $content->option->{'contact_email'} ?>&nbsp;</span></div>
            <div class="info_item last_item1"><span class="item_name">SNS(??????)</span><span class="value"><?php echo $content->option->{'sns'} ?>&nbsp;</span></div>
            <div class="info_item last_item2"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'home_address'} ?>&nbsp;</div>
          </div>
        </div>
      </div>
      <div class="family_information">
        <div class="subtitle">????????????</div>
        <div class="left">
          <?php if ($content->attach->{'family_photo'}[1]) : ?><div class="family_photo"></div><?php else : ?><img src="<?php echo $skin_path ?>/familyphoto_noimg.jpg"><?php endif ?>
        </div>
        <div class="right">
          <div class="info_line">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo wpautop($content->option->{'family_matters' . $index}) ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="missionary_history_information">
        <div class="subtitle">?????????(?????????) ??????</div>
        <div class="info">
          <div class="info_line">
            <div class="info_item"><span class="item_name">?????????(?????????) ??????</span><span class="value"><?php echo wpautop($content->option->{'missionary_history' . $index}) ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="mission_country_information">
        <div class="subtitle">?????? ?????? ??????</div>
        <div class="info">
          <div class="info_line1">
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $content->option->tree_category_1 ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $content->option->tree_category_2 ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????</span><span class="value"><?php echo $content->option->{'region'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'national_language'} ?>&nbsp;</span></div>
          </div>
          <div class="info_line2">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo wpautop($content->option->{'distribution_of_religion' . $index}) ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="ministry_status_information">
        <div class="subtitle">????????????</div>
        <div class="info">
          <div class="info_line1">
            <div class="info_item"><span class="item_name">?????????</span><span class="value"><?php echo $content->option->{'church_name'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">???????????? ????????????</span><span class="value"><?php echo $content->option->{'building_rental_status'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????????????? ????????????</span><span class="value"><?php echo $content->option->{'rental_cost'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">?????????</span><span class="value"><?php echo $content->option->{'number_of_churchmembers'} ?>&nbsp;</span></div>
          </div>
          <div class="info_line2">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'church_address'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">5?????? ??????</span><span class="value"><?php echo wpautop($content->option->{'5basic_status' . $index}) ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo wpautop($content->option->{'ministry_status' . $index}) ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="prayer_title_information">
        <div class="subtitle">????????????</div>
        <div class="info">
          <div class="info_line">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->content ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="request_for_support_area">
        <div class="subtitle">??????????????????????????? ?????? ????????????</div>
        <div class="info">
          <div class="info_line">
            <div class="info_item"><span class="item_name">??????????????????????????? ?????? ????????????</span><span class="value"><?php echo wpautop($content->option->{'request_for_support' . $index}) ?>&nbsp;</span></div>
          </div>
        </div>
      </div>
      <div class="mission_conference_information">
        <div class="subtitle">?????????????????? ??????</div>
        <div class="info">
          <div class="info_line1">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->title ?>&nbsp;</span></div>
          </div>

          <?php
          $hiddenClass = $content->option->{'how_to_attend'} === '??????' ? '' : ' hidden';
          ?>

          <div class="info_line2">
            <div class="info_item"><span class="item_name">??????????????? ??????</span><span class="value"><?php echo $content->option->{'missionary_training_camp'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">???????????? ??????</span><span class="value"><?php echo $content->option->{'registration'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'how_to_attend'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'number_of_attendees'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'communication'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'date_of_entry'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'departure_date'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????????????????</span><span class="value"><?php echo $content->option->{'ticket_issue_date'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'number_of_passengers'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????/??????</span><span class="value"><?php echo $content->option->{'one_way_return'} ?>&nbsp;</span></div>
            <div class="info_item <?php echo $hiddenClass; ?>"><span class="item_name">?????????(???????????????)</span><span class="value"><?php echo $content->option->{'airfare_ticket_description'} ?>&nbsp;</span></div>
            <div class="info_item <?php echo $hiddenClass; ?>"><span class="item_name">?????????(KRW)</span><span class="value"><?php echo $content->option->{'airfare_krw'} ?>&nbsp;</span></div>
            <div class="info_item <?php echo $hiddenClass; ?>"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'invoice'} ?>&nbsp;</span></div>
            <div class="info_item <?php echo $hiddenClass; ?>"><span class="item_name">???????????????</span><span class="value"><?php echo $content->option->{'deposit_request_date'} ?>&nbsp;</span></div>
            <div class="info_item <?php echo $hiddenClass; ?>"><span class="item_name">?????????</span><span class="value"><?php echo $content->option->{'deposit_date'} ?>&nbsp;</span></div>
          </div>
          <div class="info_line1 <?php echo $hiddenClass; ?>">
            <div class="info_item"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'account_number'} ?>&nbsp;</span></div>
          </div>
          <div class="info_line3">
            <div class="info_item"><span class="item_name">??????????????? ????????????</span><span class="value"><?php echo $content->option->{'accommodation_to_venue'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">??????????????? ?????? ????????????</span><span class="value"><?php echo $content->option->{'venue_to_accommodation'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">???????????? ???????????? ????????????</span><span class="value"><?php echo $content->option->{'church_to_accommodation'} ?>&nbsp;</span></div>
            <div class="info_item"><span class="item_name">???????????? ????????? ????????????</span><span class="value"><?php echo $content->option->{'accommodation_to_church'} ?>&nbsp;</span></div>
          </div>
          <div class="info_line4">
            <div class="info_item1"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'accommodation_support'} ?>&nbsp;</span></div>
            <div class="info_item2"><span class="item_name">????????????</span><span class="value"><?php echo $content->option->{'accommodation_iocation'} ?>&nbsp;</span></div>
            <div class="info_item1"><span class="item_name">???????????? ???????????? ??????</span><span class="value"><?php echo $content->option->{'after_the_conference'} ?>&nbsp;</span></div>
            <div class="info_item2"><span class="item_name">???????????? ?????? ??????</span><span class="value"><?php echo $content->option->{'details_of_support'} ?>&nbsp;</span></div>
            <div class="info_item1"><span class="item_name">?????? ?????? ??????</span><span class="value"><?php echo $content->option->{'how_to_contact'} ?>&nbsp;</span></div>
            <div class="info_item2"><span class="item_name">??????</span><span class="value"><?php echo $content->option->{'note'} ?>&nbsp;</span></div>
          </div>
        </div>
      </div>

      <div class="kboard-detail">
        <div class="detail-attr detail-date">
          <div class="detail-name"><?php echo __('Date', 'kboard') ?></div>
          <div class="detail-value"><?php echo date('Y-m-d H:i', strtotime($content->date)) ?></div>
        </div>
        <div class="detail-attr detail-view">
          <div class="detail-name"><?php echo __('Views', 'kboard') ?></div>
          <div class="detail-value"><?php echo $content->view ?></div>
        </div>
      </div>

    </div>

    <div class="kboard-control">
      <div class="left">
        <a href="<?php echo esc_url($url->getBoardList()) ?>" class="kboard-wmc-attendee-list-button-small"><?php echo __('List', 'kboard') ?></a>
      </div>

      <div class="right">
        <button type="button" class="kboard-button-action kboard-button-print" onclick="kboard_document_print('<?php echo $url->getDocumentPrint($content->uid) ?>')" title="<?php echo __('Print', 'kboard') ?>"><?php echo __('Print', 'kboard') ?></button>
        <?php if ($content->isEditor() || $board->permission_write == 'all') : ?>
          <a href="<?php echo $url->getContentEditor($content->uid) ?>" class="kboard-wmc-attendee-list-button-small"><?php echo __('??????', 'kboard-wmc-attendee-list') ?></a>
          <a href="<?php echo $url->getContentRemove($content->uid) ?>" class="kboard-wmc-attendee-list-button-small" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard') ?>');"><?php echo __('??????', 'kboard-wmc-attendee-list') ?></a>
        <?php endif ?>
      </div>
    </div>

    <?php if ($board->contribution() && !$board->meta->always_view_list) : ?>
      <div class="kboard-wmc-attendee-list-poweredby">
        <a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard') ?>">Powered by KBoard</a>
      </div>
    <?php endif ?>
  </div>
</div>
