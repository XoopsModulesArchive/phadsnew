<?php

// $Revision: 2.4 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = 'ltr';
$GLOBALS['phpAds_TextAlignRight'] = 'right';
$GLOBALS['phpAds_TextAlignLeft'] = 'left';
$GLOBALS['phpAds_CharSet'] = 'big5';

$GLOBALS['phpAds_DecimalPoint'] = ',';
$GLOBALS['phpAds_ThousandsSeperator'] = '.';

// Date & time configuration
$GLOBALS['date_format'] = '%d-%m-%Y';
$GLOBALS['time_format'] = '%H:%M:%S';
$GLOBALS['minute_format'] = '%H:%M';
$GLOBALS['month_format'] = '%m-%Y';
$GLOBALS['day_format'] = '%d-%m';
$GLOBALS['week_format'] = '%W-%Y';
$GLOBALS['weekiso_format'] = '%V-%G';

/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] = '首頁';
$GLOBALS['strHelp'] = '幫助';
$GLOBALS['strNavigation'] = '選項';
$GLOBALS['strShortcuts'] = '捷徑';
$GLOBALS['strAdminstration'] = '系統管理';
$GLOBALS['strMaintenance'] = '維護';
$GLOBALS['strProbability'] = '訪問比例';
$GLOBALS['strInvocationcode'] = '產生網頁原始碼';
$GLOBALS['strBasicInformation'] = '基本資料';
$GLOBALS['strContractInformation'] = '合同資料';
$GLOBALS['strLoginInformation'] = '登錄資料';
$GLOBALS['strOverview'] = '總覽';
$GLOBALS['strSearch'] = '<u>S</u>搜索';
$GLOBALS['strHistory'] = '歷史紀錄';
$GLOBALS['strPreferences'] = '喜好設定';
$GLOBALS['strDetails'] = '詳細統計數據';
$GLOBALS['strCompact'] = '精簡格式';
$GLOBALS['strVerbose'] = '完整格式';
$GLOBALS['strUser'] = '用戶';
$GLOBALS['strEdit'] = '編輯';
$GLOBALS['strCreate'] = '新增';
$GLOBALS['strDuplicate'] = '複製';
$GLOBALS['strMoveTo'] = '移動到';
$GLOBALS['strDelete'] = '刪除';
$GLOBALS['strActivate'] = '啟用';
$GLOBALS['strDeActivate'] = '停用';
$GLOBALS['strConvert'] = '轉換';
$GLOBALS['strRefresh'] = '更新';
$GLOBALS['strSaveChanges'] = '保存資料';
$GLOBALS['strUp'] = '上移';
$GLOBALS['strDown'] = '下移';
$GLOBALS['strSave'] = '保存';
$GLOBALS['strCancel'] = '取消';
$GLOBALS['strPrevious'] = '上一頁';
$GLOBALS['strPrevious_Key'] = '<u>P</u>上一頁';
$GLOBALS['strNext'] = '下一頁';
$GLOBALS['strNext_Key'] = '<u>N</u>下一頁';
$GLOBALS['strYes'] = '是';
$GLOBALS['strNo'] = '否';
$GLOBALS['strNone'] = '無';
$GLOBALS['strCustom'] = '自定義';
$GLOBALS['strDefault'] = '預設值';
$GLOBALS['strOther'] = '其他';
$GLOBALS['strUnknown'] = '未知';
$GLOBALS['strUnlimited'] = '無限制';
$GLOBALS['strUntitled'] = '未命名';
$GLOBALS['strAll'] = '全部';
$GLOBALS['strAvg'] = '平均';
$GLOBALS['strAverage'] = '平均';
$GLOBALS['strOverall'] = '概述';
$GLOBALS['strTotal'] = '總計';
$GLOBALS['strActive'] = '啟用';
$GLOBALS['strFrom'] = '從';
$GLOBALS['strTo'] = '到';
$GLOBALS['strLinkedTo'] = '連結到';
$GLOBALS['strDaysLeft'] = '剩餘天數';
$GLOBALS['strCheckAllNone'] = '檢查所有 / 無';
$GLOBALS['strKiloByte'] = 'KB';
$GLOBALS['strExpandAll'] = '<u>E</u>全部展開';
$GLOBALS['strCollapseAll'] = '<u>C</u>全部收起';
$GLOBALS['strShowAll'] = '列出全部';
$GLOBALS['strNoAdminInteface'] = '服務不可用...';
$GLOBALS['strFilterBySource'] = '經過源過濾';
$GLOBALS['strFieldContainsErrors'] = '以下字段包含錯誤:';
$GLOBALS['strFieldFixBeforeContinue1'] = '在進行下一步之前必須';
$GLOBALS['strFieldFixBeforeContinue2'] = '改正錯誤';
$GLOBALS['strDelimiter'] = '分隔符';
$GLOBALS['strMiscellaneous'] = '雜項';

// Properties
$GLOBALS['strName'] = '名稱';
$GLOBALS['strSize'] = '尺寸';
$GLOBALS['strWidth'] = '寬度';
$GLOBALS['strHeight'] = '高度';
$GLOBALS['strURL2'] = '廣告連結網址';
$GLOBALS['strTarget'] = '目標';
$GLOBALS['strLanguage'] = '語言';
$GLOBALS['strDescription'] = '內容描述';
$GLOBALS['strID'] = '代碼';

// Login & Permissions
$GLOBALS['strAuthentification'] = '認證信息';
$GLOBALS['strWelcomeTo'] = '歡迎訪問';
$GLOBALS['strEnterUsername'] = '輸入您的用戶名和密碼登錄';
$GLOBALS['strEnterBoth'] = '請輸入您的用戶名和密碼';
$GLOBALS['strEnableCookies'] = '您必須啟用cookies才能使用' . $phpAds_productname;
$GLOBALS['strLogin'] = '登錄';
$GLOBALS['strLogout'] = '登出';
$GLOBALS['strUsername'] = '用戶名';
$GLOBALS['strPassword'] = '密碼';
$GLOBALS['strAccessDenied'] = '無權訪問';
$GLOBALS['strPasswordWrong'] = '密碼錯誤';
$GLOBALS['strNotAdmin'] = '您的權限等級不足';
$GLOBALS['strDuplicateClientName'] = '您所選用的使用者代碼已經有人使用了，請更換其他的使用者代碼。';

// General advertising
$GLOBALS['strViews'] = '廣告訪問數';
$GLOBALS['strClicks'] = '廣告點擊數';
$GLOBALS['strCTRShort'] = 'CTR';
$GLOBALS['strCTR'] = '廣告點擊比 (CTR)';
$GLOBALS['strTotalViews'] = '總計訪問數';
$GLOBALS['strTotalClicks'] = '總計點擊數';
$GLOBALS['strViewCredits'] = '訪問數購買量';
$GLOBALS['strClickCredits'] = '點擊數購買量';

// Time and date related
$GLOBALS['strDate'] = '日期';
$GLOBALS['strToday'] = '本日';
$GLOBALS['strDay'] = '日期';
$GLOBALS['strDays'] = '日期';
$GLOBALS['strLast7Days'] = '最後 7 天';
$GLOBALS['strWeek'] = '周數';
$GLOBALS['strWeeks'] = '周數';
$GLOBALS['strMonths'] = '月';
$GLOBALS['strThisMonth'] = '本月';
$GLOBALS['strMonth'] = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
$GLOBALS['strDayShortCuts'] = ['週日', '週一', '週二', '週三', '週四', '週五', '週六'];
$GLOBALS['strHour'] = '小時';
$GLOBALS['strSeconds'] = '秒';
$GLOBALS['strMinutes'] = '分';
$GLOBALS['strHours'] = '小時';
$GLOBALS['strTimes'] = '時間';

// Advertiser
$GLOBALS['strClient'] = '客戶';
$GLOBALS['strClients'] = '客戶';
$GLOBALS['strClientsAndCampaigns'] = '客戶 & 項目';
$GLOBALS['strAddClient'] = '新增客戶';
$GLOBALS['strAddClient_Key'] = '<u>n</u>新增客戶';
$GLOBALS['strTotalClients'] = '客戶總數';
$GLOBALS['strClientProperties'] = '客戶屬性';
$GLOBALS['strClientHistory'] = '客戶歷史';
$GLOBALS['strNoClients'] = '現在還沒有客戶';
$GLOBALS['strConfirmDeleteClient'] = '是否確定要刪除此客戶?';
$GLOBALS['strConfirmResetClientStats'] = '是否確定要刪除此客戶統計數據?';
$GLOBALS['strHideInactiveAdvertisers'] = '隱藏停用的客戶';
$GLOBALS['strInactiveAdvertisersHidden'] = '停用的客戶已經隱藏';

// Advertisers properties
$GLOBALS['strContact'] = '聯繫人';
$GLOBALS['strEMail'] = '電子郵件信箱';
$GLOBALS['strSendAdvertisingReport'] = '使用電子郵件傳送廣告效益報表';
$GLOBALS['strNoDaysBetweenReports'] = '廣告效益報表寄送間隔天數';
$GLOBALS['strSendDeactivationWarning'] = '當廣告項目被停用時發送警告電子郵件';
$GLOBALS['strAllowClientModifyInfo'] = '允許該使用者更動客戶基本資料';
$GLOBALS['strAllowClientModifyBanner'] = '允許該使用者更動廣告內容';
$GLOBALS['strAllowClientAddBanner'] = '允許該使用者新增廣告';
$GLOBALS['strAllowClientDisableBanner'] = '允許該使用者停用廣告';
$GLOBALS['strAllowClientActivateBanner'] = '允許該使用者啟用廣告';

// Campaign
$GLOBALS['strCampaign'] = '項目';
$GLOBALS['strCampaigns'] = '項目';
$GLOBALS['strTotalCampaigns'] = '項目總數';
$GLOBALS['strActiveCampaigns'] = '啟用中項目總數';
$GLOBALS['strAddCampaign'] = '新增項目';
$GLOBALS['strAddCampaign_Key'] = '<u>n</u>新增項目';
$GLOBALS['strCreateNewCampaign'] = '新增項目';
$GLOBALS['strModifyCampaign'] = '編輯項目';
$GLOBALS['strMoveToNewCampaign'] = '移動至新的項目';
$GLOBALS['strBannersWithoutCampaign'] = '不屬於任何項目的廣告';
$GLOBALS['strDeleteAllCampaigns'] = '刪除所有項目';
$GLOBALS['strCampaignStats'] = '項目統計';
$GLOBALS['strCampaignProperties'] = '項目屬性';
$GLOBALS['strCampaignOverview'] = '項目總覽';
$GLOBALS['strCampaignHistory'] = '項目歷史';
$GLOBALS['strNoCampaigns'] = '現在沒有任何項目存在';
$GLOBALS['strConfirmDeleteAllCampaigns'] = '是否確定要刪除此客戶的所有項目?';
$GLOBALS['strConfirmDeleteCampaign'] = '是否確定要刪除此項目?';
$GLOBALS['strHideInactiveCampaigns'] = '隱藏停用的項目';
$GLOBALS['strInactiveCampaignsHidden'] = '停用的項目已經隱藏';

// Campaign properties
$GLOBALS['strDontExpire'] = '此項目永遠不失效';
$GLOBALS['strActivateNow'] = '即刻啟用此項目';
$GLOBALS['strLow'] = '低';
$GLOBALS['strHigh'] = '高';
$GLOBALS['strExpirationDate'] = '失效日期';
$GLOBALS['strActivationDate'] = '啟用日期';
$GLOBALS['strViewsPurchased'] = '廣告訪問次數剩餘量';
$GLOBALS['strClicksPurchased'] = '廣告點擊次數剩餘量';
$GLOBALS['strCampaignWeight'] = '項目比重';
$GLOBALS['strHighPriority'] = '此項目的廣告具有高優先權。<br>如果你用此項，本廣告系統將儘量在期限內平均分配廣告訪問數。';
$GLOBALS['strLowPriority'] = '此項目的廣告具有低優先權。<br>此項目將使用除了高優先權的項目之外的廣告訪問數。';
$GLOBALS['strTargetLimitAdviews'] = '限制廣告訪問數到';
$GLOBALS['strTargetPerDay'] = '每天';
$GLOBALS['strPriorityAutoTargeting'] = '把剩餘的廣告數平均分配到剩餘的日期。目標廣告訪問數將因此每天重新設定。';

// Banners (General)
$GLOBALS['strBanner'] = '廣告';
$GLOBALS['strBanners'] = '廣告';
$GLOBALS['strAddBanner'] = '新增廣告';
$GLOBALS['strAddBanner_Key'] = '<u>n</u>新增廣告';
$GLOBALS['strModifyBanner'] = '編輯廣告內容';
$GLOBALS['strActiveBanners'] = '啟用中廣告數';
$GLOBALS['strTotalBanners'] = '廣告總數';
$GLOBALS['strShowBanner'] = '顯示廣告';
$GLOBALS['strShowAllBanners'] = '列出全部廣告';
$GLOBALS['strShowBannersNoAdClicks'] = '列出無點選數的廣告';
$GLOBALS['strShowBannersNoAdViews'] = '列出無推播數的廣告';
$GLOBALS['strDeleteAllBanners'] = '刪除所有廣告';
$GLOBALS['strActivateAllBanners'] = '啟用所有廣告';
$GLOBALS['strDeactivateAllBanners'] = '停用所有廣告';
$GLOBALS['strBannerOverview'] = '廣告總覽';
$GLOBALS['strBannerProperties'] = '廣告屬性';
$GLOBALS['strBannerHistory'] = '廣告歷史';
$GLOBALS['strBannerNoStats'] = '目前沒有這個廣告的統計數據';
$GLOBALS['strNoBanners'] = '目前沒有任何廣告';
$GLOBALS['strConfirmDeleteBanner'] = '是否確定刪除此廣告?';
$GLOBALS['strConfirmDeleteAllBanners'] = '是否確定要刪除此項目的所有廣告?';
$GLOBALS['strConfirmResetBannerStats'] = '是否確定要刪除此廣告的所有統計數據?';
$GLOBALS['strShowParentCampaigns'] = '顯示上層項目';
$GLOBALS['strHideParentCampaigns'] = '隱藏上層項目';
$GLOBALS['strHideInactiveBanners'] = '隱藏停用的廣告';
$GLOBALS['strInactiveBannersHidden'] = '停用的廣告已經隱藏';

// Banner (Properties)
$GLOBALS['strChooseBanner'] = '請選擇廣告儲存方式';
$GLOBALS['strMySQLBanner'] = '廣告圖形保存于 SQL 資料庫';
$GLOBALS['strWebBanner'] = '廣告圖形儲存於網頁主機上';
$GLOBALS['strURLBanner'] = '廣告圖形連結到特定網址';
$GLOBALS['strHTMLBanner'] = 'HTML 文件型廣告';
$GLOBALS['strTextBanner'] = '文字型廣告';
$GLOBALS['strAutoChangeHTML'] = '自動轉換 HTML 原始碼以記錄廣告點選數';
$GLOBALS['strUploadOrKeep'] = '您想保留現有的圖形<br>或者您想另外上傳?';
$GLOBALS['strNewBannerFile'] = '請選擇此廣告您想使用的圖片<br><br>';
$GLOBALS['strNewBannerURL'] = '廣告圖形網址 (包含 http://)';
$GLOBALS['strURL'] = '廣告連結網址 (包含 http://)';
$GLOBALS['strHTML'] = 'HTML';
$GLOBALS['strTextBelow'] = '廣告圖形下方文字';
$GLOBALS['strKeyword'] = '關鍵字';
$GLOBALS['strWeight'] = '項目權重';
$GLOBALS['strAlt'] = '說明文字';
$GLOBALS['strStatusText'] = '狀態列文字';
$GLOBALS['strBannerWeight'] = '廣告權重';

// Banner (swf)
$GLOBALS['strCheckSWF'] = '檢查Flash文件中固定的超鏈接';
$GLOBALS['strConvertSWFLinks'] = 'C轉換Flash超鏈接';
$GLOBALS['strHardcodedLinks'] = '固定連接';
$GLOBALS['strConvertSWF'] = '<br>您剛纔上載的Flash文件中包含了固定的超鏈接。phpAdsNew 將不能跟蹤此廣告的點擊數，除非您轉換此固定超鏈接。下面是在此Flash文件中找到的超鏈接的列表，如果您想轉換此超鏈接，只需要簡單的按<b>轉換</b>，否則按<b>取消</b>.<br><br>請注意﹕如果您選擇<b>轉換</b>您剛纔所上載的Flash文件將被修改。<br>請保留以前的備份文件。無論你廣告的flash版本是什麼，最後的文件需要Flash 4播放器（或者更高）才能正確播放。<br><br>';
$GLOBALS['strCompressSWF'] = '壓縮SWF文件可以更快下載(需要Flash 6)';
$GLOBALS['strOverwriteSource'] = '修改源參數';

// Banner (network)
$GLOBALS['strBannerNetwork'] = 'HTML 模板';
$GLOBALS['strChooseNetwork'] = '選擇您想使用的模板';
$GLOBALS['strMoreInformation'] = '更多信息...';
$GLOBALS['strRichMedia'] = 'Richmedia';
$GLOBALS['strTrackAdClicks'] = '跟蹤廣告點擊';

// Display limitations
$GLOBALS['strModifyBannerAcl'] = '發送限制';
$GLOBALS['strACL'] = '發送';
$GLOBALS['strACLAdd'] = '新增限制';
$GLOBALS['strACLAdd_Key'] = '<u>n</u>新增限制';
$GLOBALS['strNoLimitations'] = '無限制';
$GLOBALS['strApplyLimitationsTo'] = '應用限制';
$GLOBALS['strRemoveAllLimitations'] = '刪除所有限制';
$GLOBALS['strEqualTo'] = '符合';
$GLOBALS['strDifferentFrom'] = '不符合';
$GLOBALS['strLaterThan'] = '晚於';
$GLOBALS['strLaterThanOrEqual'] = '晚於或等於';
$GLOBALS['strEarlierThan'] = '早於';
$GLOBALS['strEarlierThanOrEqual'] = '早於或等於';
$GLOBALS['strAND'] = 'AND';                        // logical operator
$GLOBALS['strOR'] = 'OR';                        // logical operator
$GLOBALS['strOnlyDisplayWhen'] = '當下列條件成立時才顯示廣告﹕';
$GLOBALS['strWeekDay'] = '星期 (0 - 6)';
$GLOBALS['strTime'] = '時間';
$GLOBALS['strUserAgent'] = '使用者瀏覽器(Regexp)';
$GLOBALS['strDomain'] = '網域名稱 (不含點)';
$GLOBALS['strClientIP'] = '使用者P□P地址';
$GLOBALS['strSource'] = '來源代碼';
$GLOBALS['strBrowser'] = '瀏覽';
$GLOBALS['strOS'] = '操作系統';
$GLOBALS['strCountry'] = '國家';
$GLOBALS['strContinent'] = '洲';
$GLOBALS['strDeliveryLimitations'] = '發送限制';
$GLOBALS['strDeliveryCapping'] = '發送封頂';
$GLOBALS['strTimeCapping'] = '此廣告顯示一次之後，對同一用戶不再顯示的時間間隔:';
$GLOBALS['strImpressionCapping'] = '此廣告對同一用戶顯示不超過﹕';

// Publisher
$GLOBALS['strAffiliate'] = '發佈者';
$GLOBALS['strAffiliates'] = '發佈者';
$GLOBALS['strAffiliatesAndZones'] = '發佈者 & 版位';
$GLOBALS['strAddNewAffiliate'] = '增加新發佈者';
$GLOBALS['strAddNewAffiliate_Key'] = '<u>n</u>增加新發佈者';
$GLOBALS['strAddAffiliate'] = '創建發佈者';
$GLOBALS['strAffiliateProperties'] = '發佈者屬性';
$GLOBALS['strAffiliateOverview'] = '發佈者總覽';
$GLOBALS['strAffiliateHistory'] = '發佈者歷史';
$GLOBALS['strZonesWithoutAffiliate'] = '沒有發佈者的版位';
$GLOBALS['strMoveToNewAffiliate'] = '移動到新的發佈者';
$GLOBALS['strNoAffiliates'] = '目前沒有任何發佈者存在';
$GLOBALS['strConfirmDeleteAffiliate'] = '是否確定刪除此發佈者?';
$GLOBALS['strMakePublisherPublic'] = '使此發佈者所有的所有版位可以使用';

// Publisher (properties)
$GLOBALS['strWebsite'] = '站點';
$GLOBALS['strAllowAffiliateModifyInfo'] = '允許此用戶修改個人設定';
$GLOBALS['strAllowAffiliateModifyZones'] = '允許此用戶修改個人版位';
$GLOBALS['strAllowAffiliateLinkBanners'] = '允許此用戶連接廣告到本人版位';
$GLOBALS['strAllowAffiliateAddZone'] = '允許此用戶增加新的版位';
$GLOBALS['strAllowAffiliateDeleteZone'] = '允許此用戶刪除版位';

// Zone
$GLOBALS['strZone'] = '版位';
$GLOBALS['strZones'] = '版位';
$GLOBALS['strAddNewZone'] = '增加新版位';
$GLOBALS['strAddNewZone_Key'] = '<u>n</u>增加新版位';
$GLOBALS['strAddZone'] = '創建版位';
$GLOBALS['strModifyZone'] = '編輯版位';
$GLOBALS['strLinkedZones'] = '連結版位';
$GLOBALS['strZoneOverview'] = '版位總覽';
$GLOBALS['strZoneProperties'] = '版位屬性';
$GLOBALS['strZoneHistory'] = '版位歷史';
$GLOBALS['strNoZones'] = '目前沒有任何版位';
$GLOBALS['strConfirmDeleteZone'] = '是否確定要刪除此版位﹖Do you really want to delete this zone?';
$GLOBALS['strZoneType'] = '版位類型Zone type';
$GLOBALS['strBannerButtonRectangle'] = '橫幅，按鈕或矩形';
$GLOBALS['strInterstitial'] = '空隙或漂浮的動態HTML';
$GLOBALS['strPopup'] = '彈出式';
$GLOBALS['strTextAdZone'] = '文字廣告';
$GLOBALS['strShowMatchingBanners'] = '顯示匹配的廣告條';
$GLOBALS['strHideMatchingBanners'] = '隱藏匹配的廣告條';

// Advanced zone settings
$GLOBALS['strAdvanced'] = '高級';
$GLOBALS['strChains'] = '附加項';
$GLOBALS['strChainSettings'] = '附加項設定';
$GLOBALS['strZoneNoDelivery'] = '如果此版位沒有廣告<br>能夠發放，將...';
$GLOBALS['strZoneStopDelivery'] = '停止發放並且不顯示任何廣告';
$GLOBALS['strZoneOtherZone'] = '顯示選定的版位';
$GLOBALS['strZoneUseKeywords'] = '請選擇一個用下面關鍵字的廣告';
$GLOBALS['strZoneAppend'] = '此版面所顯示的廣告上總是添加下面的HTML代碼';
$GLOBALS['strAppendSettings'] = '添加和預先設定';
$GLOBALS['strZonePrependHTML'] = '此版面所顯示的文字廣告上預先加上HTML代碼';
$GLOBALS['strZoneAppendHTML'] = '此版面所顯示的文字廣告上附加上HTML代碼';
$GLOBALS['strZoneAppendType'] = '附加方式';
$GLOBALS['strZoneAppendHTMLCode'] = 'HTML代碼';
$GLOBALS['strZoneAppendZoneSelection'] = '彈出式或者空隙調用代碼';
$GLOBALS['strZoneAppendSelectZone'] = '總是在此版位的廣告上附加下面的彈出式或者空隙調用代碼';

// Zone probability
$GLOBALS['strZoneProbListChain'] = '所有連接到此版位的廣告優先級為空，下面是版位的附加項設定:';
$GLOBALS['strZoneProbNullPri'] = '所有連接到此版位的廣告優先級為空';
$GLOBALS['strZoneProbListChainLoop'] = '此版位的附加項形成一個死循環,所以版位的發送停止';

// Linked banners/campaigns
$GLOBALS['strSelectZoneType'] = '請選擇版位與廣告連結的查詢方式';
$GLOBALS['strBannerSelection'] = '選擇廣告';
$GLOBALS['strCampaignSelection'] = '選擇項目';
$GLOBALS['strInteractive'] = '互動連結';
$GLOBALS['strRawQueryString'] = '關鍵字';
$GLOBALS['strIncludedBanners'] = '連結廣告';
$GLOBALS['strLinkedBannersOverview'] = '連結廣告';
$GLOBALS['strLinkedBannerHistory'] = '連結廣告歷史';
$GLOBALS['strNoZonesToLink'] = '目前沒有版位可以和此廣告連結';
$GLOBALS['strNoBannersToLink'] = '目前沒有廣告可以和此版位連接';
$GLOBALS['strNoLinkedBanners'] = '目前沒有廣告可以和此版位連接';
$GLOBALS['strMatchingBanners'] = '{count}符合的廣告';
$GLOBALS['strNoCampaignsToLink'] = '目前沒有項目可以和此版位連接';
$GLOBALS['strNoZonesToLinkToCampaign'] = '目前沒有版位可以和此項目連結';
$GLOBALS['strSelectBannerToLink'] = '請您選擇要連接到此版位的廣告:';
$GLOBALS['strSelectCampaignToLink'] = '請您選擇要連接到此版位的項目:';

// Statistics
$GLOBALS['strStats'] = '統計數據';
$GLOBALS['strNoStats'] = '目前沒有可用的統計數據';
$GLOBALS['strConfirmResetStats'] = '是否確定要刪除現有的所有統計數據?';
$GLOBALS['strGlobalHistory'] = '全局歷史';
$GLOBALS['strDailyHistory'] = '每日曆史';
$GLOBALS['strDailyStats'] = '每日統計數據';
$GLOBALS['strWeeklyHistory'] = '每週歷史';
$GLOBALS['strMonthlyHistory'] = '每月曆史';
$GLOBALS['strCreditStats'] = '廣告存量統計數據';
$GLOBALS['strDetailStats'] = '詳細統計數據';
$GLOBALS['strTotalThisPeriod'] = '週期統計';
$GLOBALS['strAverageThisPeriod'] = '週期平均';
$GLOBALS['strDistribution'] = '分類';
$GLOBALS['strResetStats'] = '重新開始統計';
$GLOBALS['strSourceStats'] = '來源統計數據';
$GLOBALS['strSelectSource'] = '請選擇您想查看的來源﹕';
$GLOBALS['strSizeDistribution'] = '按廣告大小分類';
$GLOBALS['strCountryDistribution'] = '按國家分類';
$GLOBALS['strEffectivity'] = '有效';
$GLOBALS['strTargetStats'] = '目標數據統計';
$GLOBALS['strCampaignTarget'] = '目標';
$GLOBALS['strTargetRatio'] = '目標比例';
$GLOBALS['strTargetModifiedDay'] = '目標數據當天被修改，所以目標可能並不精確';
$GLOBALS['strTargetModifiedWeek'] = '目標數據當周被修改，所以目標可能並不精確';
$GLOBALS['strTargetModifiedMonth'] = '目標數據當月被修改，所以目標可能並不精確';
$GLOBALS['strNoTargetStats'] = '目前沒有關於目標的統計數據';

// Hosts
$GLOBALS['strHosts'] = '主機';
$GLOBALS['strTopHosts'] = '前10位訪問的主機';
$GLOBALS['strTopCountries'] = '前10位訪問的國家';
$GLOBALS['strRecentHosts'] = '最經常訪問的主機';

// Expiration
$GLOBALS['strExpired'] = '已失效';
$GLOBALS['strExpiration'] = '廣告失效日期';
$GLOBALS['strNoExpiration'] = '未設定失效日期';
$GLOBALS['strEstimated'] = '估計失效日期';

// Reports
$GLOBALS['strReports'] = '廣告效益報表';
$GLOBALS['strSelectReport'] = '請選擇您想產生的報表';

// Userlog
$GLOBALS['strUserLog'] = '用戶記錄';
$GLOBALS['strUserLogDetails'] = '用戶詳細記錄';
$GLOBALS['strDeleteLog'] = '刪除記錄';
$GLOBALS['strAction'] = '活動';
$GLOBALS['strNoActionsLogged'] = '沒有活動記錄';

// Code generation
$GLOBALS['strGenerateBannercode'] = '自動產生廣告原始碼';
$GLOBALS['strChooseInvocationType'] = '請選擇廣告原始碼類型';
$GLOBALS['strGenerate'] = '產生';
$GLOBALS['strParameters'] = '參數設定';
$GLOBALS['strFrameSize'] = '分頁尺寸';
$GLOBALS['strBannercode'] = '廣告原始碼';

// Errors
$GLOBALS['strMySQLError'] = 'SQL 錯誤訊息:';
$GLOBALS['strLogErrorClients'] = '[phpAds] 從資料庫讀取客戶的時候發生了一個錯誤.';
$GLOBALS['strLogErrorBanners'] = '[phpAds] 從資料庫讀取廣告的時候發生了一個錯誤.';
$GLOBALS['strLogErrorViews'] = '[phpAds] 從資料庫讀取廣告訪問數的時候發生了一個錯誤.';
$GLOBALS['strLogErrorClicks'] = '[phpAds] 從資料庫讀取廣告點擊數的時候發生了一個錯誤.';
$GLOBALS['strErrorViews'] = '您必須填寫訪問數量或選擇無限制選項!';
$GLOBALS['strErrorNegViews'] = '訪問數量無法使用負數';
$GLOBALS['strErrorClicks'] = '您必須填寫點擊數量或選擇無限制選項!';
$GLOBALS['strErrorNegClicks'] = '訪問數量無法使用負數';
$GLOBALS['strNoMatchesFound'] = '沒有找到符合的資料';
$GLOBALS['strErrorOccurred'] = '發生了一個錯誤';
$GLOBALS['strErrorUploadSecurity'] = '發現一個可能的安全漏洞,停止上載!';
$GLOBALS['strErrorUploadBasedir'] = '可能是因為php的安全模式設定或者open_basedir參數的限制,不能訪問上載的文件';
$GLOBALS['strErrorUploadUnknown'] = '因為一個未知錯誤,不能訪問上載的文件,請檢查您的php設定';
$GLOBALS['strErrorStoreLocal'] = '在把廣告保存到本地目錄的時候發生了一個錯誤.這可能因為本地目錄權限的錯誤設定';
$GLOBALS['strErrorStoreFTP'] = '在把廣告通過FTP伺服器上傳的時候發生了一個錯誤.這可能因為伺服器不能用或者FTP伺服器的錯誤設定';

// E-mail
$GLOBALS['strMailSubject'] = '廣告報表';
$GLOBALS['strAdReportSent'] = '廣告效益報表已寄送完成';
$GLOBALS['strMailSubjectDeleted'] = '已停用廣告';
$GLOBALS['strMailHeader'] = "親愛的{contact},\n";
$GLOBALS['strMailBannerStats'] = '以下為客戶{clientname}的廣告統計數據:';
$GLOBALS['strMailFooter'] = "致禮,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] = '下列廣告已經被停用，原因是﹕';
$GLOBALS['strMailNothingLeft'] = "如果您願意繼續在我們網站刊登廣告,請和我們聯絡,\n我們非常樂意為您服務.";
$GLOBALS['strClientDeactivated'] = '此項目已經被停用,原因是:';
$GLOBALS['strBeforeActivate'] = '廣告啟用日期未到';
$GLOBALS['strAfterExpire'] = '廣告失效日期已到';
$GLOBALS['strNoMoreClicks'] = '已達點擊數購買量';
$GLOBALS['strNoMoreViews'] = '已達訪問數購買量';
$GLOBALS['strWarnClientTxt'] = "您的廣告訪問數或點擊數存量已剩下 {limit}次。\n當訪問數或點擊數存量已用盡時，您的廣告將會自動停用.";
$GLOBALS['strViewsClicksLow'] = '廣告訪問數或點擊數存量過低';
$GLOBALS['strNoViewLoggedInInterval'] = '本報告的統計期間中沒有任何的訪問動作';
$GLOBALS['strNoClickLoggedInInterval'] = '本報告的統計期間中沒有任何的點擊動作';
$GLOBALS['strMailReportPeriod'] = '本報表包含了自{startdate}至{enddate}的統計數據.';
$GLOBALS['strMailReportPeriodAll'] = '本報表包含了至{enddate}的所有統計數據.';
$GLOBALS['strNoStatsForCampaign'] = '本項目目前沒有統計數據';

// Priority
$GLOBALS['strPriority'] = '優先權';

// Settings
$GLOBALS['strSettings'] = '設定';
$GLOBALS['strGeneralSettings'] = '一般設定';
$GLOBALS['strMainSettings'] = '主要設定';
$GLOBALS['strAdminSettings'] = '管理員設定';

// Product Updates
$GLOBALS['strProductUpdates'] = '產品升級';

/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = 'h';
$GLOBALS['keyUp'] = 'u';
$GLOBALS['keyNextItem'] = '.';
$GLOBALS['keyPreviousItem'] = ',';
$GLOBALS['keyList'] = 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = 's';
$GLOBALS['keyCollapseAll'] = 'c';
$GLOBALS['keyExpandAll'] = 'e';
$GLOBALS['keyAddNew'] = 'n';
$GLOBALS['keyNext'] = 'n';
$GLOBALS['keyPrevious'] = 'p';
