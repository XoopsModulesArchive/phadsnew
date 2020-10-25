<?php

// $Revision: 2.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

// Main strings
$GLOBALS['strChooseSection'] = 'Выберите раздел';

// Priority
$GLOBALS['strRecalculatePriority'] = 'Пересчитать приоритеты';
$GLOBALS['strHighPriorityCampaigns'] = 'Кампании с высоким приоритетом';
$GLOBALS['strAdViewsAssigned'] = 'Выделено просмотров';
$GLOBALS['strLowPriorityCampaigns'] = 'Кампании с низким приоритетом';
$GLOBALS['strPredictedAdViews'] = 'Предсказано просмотров';
$GLOBALS['strPriorityDaysRunning'] = 'Сейчас доступно {days} дней статистики, на которой ' . $phpAds_productname . ' может основывать свои предсказания. ';
$GLOBALS['strPriorityBasedLastWeek'] = 'Предсказания основаны на данных по этой и прошлой неделе. ';
$GLOBALS['strPriorityBasedYesterday'] = 'Предсказание основано на данных за вчера. ';
$GLOBALS['strPriorityNoData'] = 'Недостаточно данных для надёжного предсказания количества показов, которые данный сервер сгенерирует сегодня. Назначение проритетов будет основываться на статистике, собираемой в реальном времени. ';
$GLOBALS['strPriorityEnoughAdViews'] = 'Должно быть достаточно показов для удовлетворения требований всех высокоприоритетных кампаний. ';
$GLOBALS['strPriorityNotEnoughAdViews'] = 'Неочевидно, будет ли сегодня сгенерировано достаточно показов для удовлетворения требований всех высокопроритетных кампаний. ';

// Banner cache
$GLOBALS['strRebuildBannerCache'] = 'Построить кэш баннеров заново';
$GLOBALS['strBannerCacheExplaination'] = '
	Кэш баннеров содержит копию HTML-кода, используемого для показа баннера. Использование кэша позволяет ускорить
	доставку баннеров, поскольку HTML-код не нужно генерировать для каждого показа баннера. Поскольку
	кэш содержит жёстко закодированные ссылки на расположение ' . $phpAds_productname . ' и самих баннеров, кэш нужно перестраивать
	при каждом перемещении ' . $phpAds_productname . ' на вебсервере.
';

// Zone cache
$GLOBALS['strAge'] = 'Срок';
$GLOBALS['strCache'] = 'Кэш доставки';
$GLOBALS['strRebuildDeliveryCache'] = 'Обновить кэш доставки';
$GLOBALS['strDeliveryCacheExplaination'] = '
        Кэш доставки используется для ускорения доставки баннеров. Кэш содержит копию всех баннеров,
        привязанных к зоне/ Это экономит несколько запросов к базе данных в момент фактического показа баннера пользователю. Кэш
        обычно обновляется после каждого изменения в зоне или одном из привязанных к ней баннеров, но, возможно, он может устаревать. Поэтому
        кэш также обновляется автоматически каждый час, или может быть обновлён вручную.
';
$GLOBALS['strDeliveryCacheSharedMem'] = '
        Для хранения кэша доставки используется разделяемая память.
';
$GLOBALS['strDeliveryCacheDatabase'] = '
        Для хранения кэша доставки используется база данных.
';

// Storage
$GLOBALS['strStorage'] = 'Хранение';
$GLOBALS['strMoveToDirectory'] = 'Переместить картинки из базы данных в каталог';
$GLOBALS['strStorageExplaination'] = '
	Картинки, используемые локальными баннерами, хранятся в базе данных или в каталоге. Если вы будете хранить картинки 
	в каталоге на диске, нагрузка на базу данных уменьшится, и это приведёт к ускорению.
';

// Storage
$GLOBALS['strStatisticsExplaination'] = '
	Вы включили <i>компактную статистику</i>, но ваша старая статистика всё ещё в расширенном формате. 
	Хотите преобразовать вашу расширенную статистику в новый компактный формат?
';

// Product Updates
$GLOBALS['strSearchingUpdates'] = 'Ищутся обновления. Пожалуйста, подождите...';
$GLOBALS['strAvailableUpdates'] = 'Доступные обновления';
$GLOBALS['strDownloadZip'] = 'Скачать (.zip)';
$GLOBALS['strDownloadGZip'] = 'Скачать (.tar.gz)';

$GLOBALS['strUpdateAlert'] = 'Доступна новая версия ' . $phpAds_productname . '                               \\n\\nХотите узнать больше \\nоб этом обновлении?';
$GLOBALS['strUpdateAlertSecurity'] = 'Доступна новая версия ' . $phpAds_productname . '                               \\n\\nРекомендуется произвести обновление \\nкак можно скорее, так как эта \\nверсия содержит одно или несколько исправлений, относящихся к безопасности.';

$GLOBALS['strUpdateServerDown'] = '
    По неизвестной причине невозможно получить информацию <br>
	о возможных обновлениях. Пожалуйста, попытайтесь позднее.
';

$GLOBALS['strNoNewVersionAvailable'] = '
	Ваша версия ' . $phpAds_productname . ' не требует обновления. Никаких обновлений в настоящее время нет.
';

$GLOBALS['strNewVersionAvailable'] = '
	<b>Доступна новая версия ' . $phpAds_productname . '</b><br> Рекомендуется устанвоить это обновление,
	поскольку оно может исправить некоторые существующие проблемы и добавить новую функциональность. За дополнительной
	информацией об обнолвении обратитесь к документации, включённо в нижеперечисленные файлы.
';

$GLOBALS['strSecurityUpdate'] = '
	<b>Настоятельно рекомендуется установить это обновление как можно скорее, поскольку оно содержит несколько
	исправлений, связанных с безопасностью.</b> Версия ' . $phpAds_productname . ', которую вы сейчас используете, может быть 
	подвержена определённым атакам, и, вероятно, не безопасна. За дополнительной
	информацией об обновлении обратитесь к документации, включённо в нежеперечисленные файлы.
';

$GLOBALS['strNotAbleToCheck'] = '
        <b>Поскольку модуль поддержки XML не установлен на вашем сервере, ' . $phpAds_productname . ' не может
    проверить наличие более свежей версии.</b>
';

$GLOBALS['strForUpdatesLookOnWebsite'] = '
        Вы сейчас пользуетесь ' . $phpAds_productname . ' ' . $phpAds_version_readable . '. 
        Если вы хотите узнать, нет ли более новой версии, посетите наш вебсайт.
';

$GLOBALS['strClickToVisitWebsite'] = '
        Щёлкните здесь, чтобы посетить наш вебсайт
';

// Stats conversion
$GLOBALS['strConverting'] = 'Преобразование';
$GLOBALS['strConvertingStats'] = 'Преобразовываем статистики...';
$GLOBALS['strConvertStats'] = 'Преобразовать статистику';
$GLOBALS['strConvertAdViews'] = 'Показы преобразованы,';
$GLOBALS['strConvertAdClicks'] = 'Клики преобразованы...';
$GLOBALS['strConvertNothing'] = 'Нечего преобразовывать...';
$GLOBALS['strConvertFinished'] = 'Закончено...';

$GLOBALS['strConvertExplaination'] = '
	Вы сейчас используете компактный формат хранения вашей статистики, но у вас всё еще есть <br>
	некоторые данные в расширенном формате. До тех пор пока расширенная статистика не будет  <br>
	преобразована в компактный формат, она не будет использоваться при просмотре этих страниц.  <br>
	Перед преобразованием статистики, сделайте резервную копию базы данных!  <br>
	Вы хотите преобразовать вашу расширенную статистику в новый компактный формат? <br>
';

$GLOBALS['strConvertingExplaination'] = '
	Вся оставшаяся расширенная статистика сейчас преобразуется в компактный формат. <br>
	В зависимости от того, сколько показов сохранено в расширенном формате, это может занять  <br>
	несколько минут. Пожалуйста, подождите окончания преобразования, прежде чем вы перейдёте на другие <br>
	страницыpages. Ниже вы увидите журнал всех изменений, произвёденных в базе данных. <br>
';

$GLOBALS['strConvertFinishedExplaination'] = '
	Преобразование остававшейся расширенной статистики было успешным и все данные <br>
	должны быть теперь доступны. Ниже вы можете увидеть журнал всех изменений, <br>
	произведённых в базе данных.<br>
';