<?php if(!defined('ABSPATH')) exit;?>
<!DOCTYPE html>
<html <?php language_attributes()?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="robots" content="noindex,follow">
	<title><?php echo esc_html(wp_strip_all_tags($content->title))?></title>
	
	<style>
.is_logo { display: inline-block; width: 100%; float: left; text-align: center; }		
.is_logo img { width: 200px; }	
.toptitle { display: inline-block; width: 100%; float: left; font-size: 1.5rem; font-weight: 700; margin: 10px 0 30px 0; text-align: center; }	
.subtitle{ display: inline-block; text-align: left; font-size: 1rem; font-weight: 700; color: #ffffff; margin: 20px 0 20px 0; width:100%!important; background: #555555!important; padding: 10px; -webkit-print-color-adjust:exact; }
.info span.value p { margin:0;}
.personal_information { display: inline-block; margin-bottom:0px; width:100%; }
.personal_information .left { width: 18%; float: left; margin-right:2%; }
.personal_information .left .portrait { width: 100%; height: auto; }
..personal_information .left img { max-width: 180px; width:100%; border: 2px solid #888; }
.personal_information .right { width: 80%; float: right; }
.personal_information .right .info_1line { border-bottom: 1px solid #333; margin-bottom:5px; padding-bottom: 10px;}
.personal_information .right .info_1line .info_item span.title { font-size: 1.5rem; font-weight: 700; }
.personal_information .right .info_1line .info_item span { font-size: 0.8rem; font-weight: 300; }
.personal_information .right .info_2line .info_item { width:24.3%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom:0px; }
.personal_information .right .info_2line .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.personal_information .right .info_2line .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }
.personal_information .right .info_2line .info_item.last_item1 { width:24.3%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom:0px; }
.personal_information .right .info_2line .info_item.last_item2 { width:74.3%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom:0px; }

.family_information { display: inline-block; margin-bottom:0px; width:100%; }
.family_information .left { width: 47%; float: left; margin-right:3%; }
.family_information .left .family_photo { width: 100%; height: auto; }
.family_information .left img { max-width: 500px; width:100%; border: 2px solid #888; }
.family_information .right { width: 50%; float: right; }
.family_information .right .info_line .info_item { width:100%; display: inline-block;  border-bottom: 0px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.family_information .right .info_line .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.family_information .right .info_line .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.missionary_history_information { display: inline-block; margin-bottom:0px; width:100%; }
.missionary_history_information .info { width: 100%; float: left; }
.missionary_history_information .info .info_line .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.missionary_history_information .info .info_line .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.missionary_history_information .info .info_line .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.mission_country_information { display: inline-block; margin-bottom:0px; width:100%; } 
.mission_country_information .info { width: 100%; float: left; }
.mission_country_information .info .info_line1 .info_item { width:24.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_country_information .info .info_line2 .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_country_information .info .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.mission_country_information .info .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.ministry_status_information { display: inline-block; margin-bottom:05px; width:100%; } 
.ministry_status_information .info { width: 100%; float: left; }
.ministry_status_information .info .info_line1 .info_item { width:24.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.ministry_status_information .info .info_line2 .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.ministry_status_information .info .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.ministry_status_information .info .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.prayer_title_information { display: inline-block; margin-bottom:0px; width:100%; }
.prayer_title_information .info { width: 100%; float: left; }
.prayer_title_information .info .info_line .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.prayer_title_information .info .info_line .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.prayer_title_information .info .info_line .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.request_for_support_area { display: inline-block; margin-bottom:0px; width:100%; }
.request_for_support_area .info { width: 100%; float: left; }
.request_for_support_area .info .info_line .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.request_for_support_area .info .info_line .info_item span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.request_for_support_area .info .info_line .info_item span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }

.mission_conference_information { display: inline-block; margin-bottom:0px; width:100%; } 
.mission_conference_information .info { width: 100%; float: left; }
.mission_conference_information .info .info_line1 .info_item { width:100%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_conference_information .info .info_line2 .info_item { width:19.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_conference_information .info .info_line3 .info_item { width:24.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_conference_information .info .info_line4 .info_item1 { width:24.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_conference_information .info .info_line4 .info_item2 { width:74.5%; display: inline-block;  border-bottom: 1px solid #ccc; margin-bottom:5px; padding-bottom: 0px; }
.mission_conference_information .info span.item_name { display: inline-block; font-size: 0.6rem; font-weight: 300; width:100%; color:#999; margin-bottom: 5px; }
.mission_conference_information .info span.value { display: inline-block; font-size: 0.8rem; font-weight: 400; width:100%; color:#222; margin-bottom: 10px; }
</style>
	
	<?php
	do_action('kboard_document_print_head');
	?>
</head>
<body onload="window.print()">
<div class="personal_information">
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
                <div class="is_logo"><img src="/wp-content/uploads/2023/02/is_logo.svg"></div>
                <div class="toptitle">세계선교대회 선교사 후원시청서</div>
		        <div class="subtitle">본인정보</div>
		        <div class="left">
		            <?php if($content->attach->{'portrait'}[1]):?><div class="portrait"><img src="<?php echo $content->attach->{'portrait'}[0]; ?>"></div><?php else:?><img src="<?php echo $skin_path?>/noimg.jpg"><?php endif?> 
		        </div>
		        <div class="right">
		            <div class="info_1line">
		                <div class="info_item"><span class="title"><?php echo esc_html($content->member_display)?></span><span> <?php echo $content->option->{'english_name'}?>&nbsp;</span></div>
		            </div>
		            <div class="info_2line">
		                <div class="info_item"><span class="item_name">성별</span><span class="value"><?php echo $content->option->{'Gender'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">나이</span><span class="value"><?php echo $age; ?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">생년월일</span><span class="value"><?php echo date('Y.m.d', strtotime($content->option->{'Birth_Date'}))?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">직분</span><span class="value"><?php echo $content->option->{'position'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">핸드폰(국가번호 포함)</span><span class="value"><?php echo $content->option->{'contact_mobile'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">일반전화(국가번호 포함)</span><span class="value"><?php echo $content->option->{'contact_tel'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">팩스번호(국가번호 포함)</span><span class="value"><?php echo $content->option->{'contact_fax'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">이메일</span><span class="value"><?php echo $content->option->{'contact_email'}?>&nbsp;</span></div>
		                <div class="info_item last_item1"><span class="item_name">SNS(카톡)</span><span class="value"><?php echo $content->option->{'sns'}?>&nbsp;</span></div>
		                <div class="info_item last_item2"><span class="item_name">자택주소</span><span class="value"><?php echo $content->option->{'home_address'}?>&nbsp;</div>
		            </div>      
		        </div>
		    </div>
		    <div class="family_information">
		        <div class="subtitle">가족사항</div>
		        <div class="left">
		            <?php if($content->attach->{'family_photo'}[1]):?><div class="family_photo"><img src="<?php echo $content->attach->{'family_photo'}[0]; ?>"></div><?php else:?><img src="<?php echo $skin_path?>/familyphoto_noimg.jpg"><?php endif?> 
		        </div>
		        <div class="right">
		            <div class="info_line">
		                <div class="info_item"><span class="item_name">가족사항</span><span class="value"><?php echo wpautop($content->option->{'family_matters'.$index})?></span></div>
		            </div>      
		        </div>
		    </div>
		    <div class="missionary_history_information">
		        <div class="subtitle">선교사(사역자) 이력</div>
		        <div class="info">
		            <div class="info_line">
		                <div class="info_item"><span class="value"><?php echo wpautop($content->option->{'missionary_history'.$index})?></span></div>
		            </div>      
		        </div>
		    </div>
		    <div class="mission_country_information">
		        <div class="subtitle">선교 국가 정보</div>
		        <div class="info">
		            <div class="info_line1">
		                <div class="info_item"><span class="item_name">권역</span><span class="value"><?php echo $content->option->tree_category_1?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">나라</span><span class="value"><?php echo $content->option->tree_category_2?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">지역</span><span class="value"><?php echo $content->option->{'region'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">국가언어</span><span class="value"><?php echo $content->option->{'national_language'}?>&nbsp;</span></div>
		            </div>    
		            <div class="info_line2">
		                <div class="info_item"><span class="item_name">종교분포</span><span class="value"><?php echo wpautop($content->option->{'distribution_of_religion'.$index})?></span></div>
		            </div>   
		        </div>
		    </div>
		    <div class="ministry_status_information">
		        <div class="subtitle">사역현황</div>
		        <div class="info">
		            <div class="info_line1">
		                <div class="info_item"><span class="item_name">교회명</span><span class="value"><?php echo $content->option->{'church_name'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">교회건물 임대여부</span><span class="value"><?php echo $content->option->{'building_rental_status'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">교회임대시 월임대료</span><span class="value"><?php echo $content->option->{'rental_cost'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">교인수</span><span class="value"><?php echo $content->option->{'number_of_churchmembers'}?>&nbsp;</span></div>
		            </div>    
		            <div class="info_line2">
		                <div class="info_item"><span class="item_name">교회주소</span><span class="value"><?php echo $content->option->{'church_address'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">5기초 현황</span><span class="value"><?php echo wpautop($content->option->{'5basic_status'.$index})?></span></div>
		                <div class="info_item"><span class="item_name">사역현황</span><span class="value"><?php echo wpautop($content->option->{'ministry_status'.$index})?></span></div>
		            </div>   
		        </div>
		    </div>
		    <div class="prayer_title_information">
		        <div class="subtitle">기도제목</div>
		        <div class="info">
		            <div class="info_line">
		                <div class="info_item"><span class="value"><?php echo wpautop($content->content)?></span></div>
		            </div>      
		        </div>
		    </div>
		    <div style='page-break-before:always'></div>
		    <div class="request_for_support_area">
		        <div class="subtitle">임마누엘서울교회에 지원 요청사항</div>
		        <div class="info">
		            <div class="info_line">
		                <div class="info_item"><span class="value"><?php echo wpautop($content->option->{'request_for_support'.$index})?></span></div>
		            </div>      
		        </div>
		    </div>
		    <div class="mission_conference_information">
		        <div class="subtitle">세계선교대회 관련</div>
		        <div class="info">
		            <div class="info_line1">
		                <div class="info_item"><span class="item_name">참석자명</span><span class="value"><?php echo $content->title?>&nbsp;</span></div>
		            </div>   
		            <div class="info_line2">
		                <div class="info_item"><span class="item_name">선교사합숙 여부</span><span class="value"><?php echo $content->option->{'missionary_training_camp'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">대회등록 여부</span><span class="value"><?php echo $content->option->{'registration'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">참석방법</span><span class="value"><?php echo $content->option->{'how_to_attend'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">참석인원</span><span class="value"><?php echo $content->option->{'number_of_attendees'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">소통담당</span><span class="value"><?php echo $content->option->{'communication'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">입국날짜</span><span class="value"><?php echo $content->option->{'date_of_entry'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">출국날짜</span><span class="value"><?php echo $content->option->{'departure_date'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">항공권발권일</span><span class="value"><?php echo $content->option->{'ticket_issue_date'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">탑승인원</span><span class="value"><?php echo $content->option->{'number_of_passengers'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">편도/왕복</span><span class="value"><?php echo $content->option->{'one_way_return'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">항공료(항공권기재)</span><span class="value"><?php echo $content->option->{'airfare_ticket_description'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">항공료(KRW)</span><span class="value"><?php echo $content->option->{'airfare_krw'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">인보이스</span><span class="value"><?php echo $content->option->{'invoice'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">입금요청일</span><span class="value"><?php echo $content->option->{'deposit_request_date'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">입금일</span><span class="value"><?php echo $content->option->{'deposit_date'}?>&nbsp;</span></div>
		            </div>   
		            <div class="info_line1">
		                <div class="info_item"><span class="item_name">계좌번호</span><span class="value"><?php echo $content->option->{'account_number'}?>&nbsp;</span></div>
		            </div>   
		            <div class="info_line3">
		                <div class="info_item"><span class="item_name">대회장으로 이동방법</span><span class="value"><?php echo $content->option->{'accommodation_to_venue'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">대회장에서 숙소 이동방법</span><span class="value"><?php echo $content->option->{'venue_to_accommodation'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">숙소에서 교회으로 이동방법</span><span class="value"><?php echo $content->option->{'church_to_accommodation'}?>&nbsp;</span></div>
		                <div class="info_item"><span class="item_name">교회에서 숙소로 이동방법</span><span class="value"><?php echo $content->option->{'accommodation_to_church'}?>&nbsp;</span></div>
		            </div> 
		            <div class="info_line4">
		                <div class="info_item1"><span class="item_name">숙소지원</span><span class="value"><?php echo $content->option->{'accommodation_support'}?>&nbsp;</span></div>
		                <div class="info_item2"><span class="item_name">숙소위치</span><span class="value"><?php echo $content->option->{'accommodation_iocation'}?>&nbsp;</span></div>
		                <div class="info_item1"><span class="item_name">대회이후 지원필요 여부</span><span class="value"><?php echo $content->option->{'after_the_conference'}?>&nbsp;</span></div>
		                <div class="info_item2"><span class="item_name">대회이후 지원 내용</span><span class="value"><?php echo $content->option->{'details_of_support'}?>&nbsp;</span></div>
		                <div class="info_item1"><span class="item_name">주요 소통 방법</span><span class="value"><?php echo $content->option->{'how_to_contact'}?>&nbsp;</span></div>
		                <div class="info_item2"><span class="item_name">비고</span><span class="value"><?php echo $content->option->{'note'}?>&nbsp;</span></div>
		            </div> 
		        </div>
		    </div>
</body>
</html>