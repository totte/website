<?php # lang_cs.inc.php 1.5 2012-01-11 23:45:25 VladaAjgl $

/**
 *  @version 1.5
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 */
@define('PLUGIN_TWITTER_TITLE',                         'Twitter');
@define('PLUGIN_TWITTER_DESC',                          'Zobrazuje Va�e nejnov�j�� p��sp�vky na Twitteru');
@define('PLUGIN_TWITTER_NUMBER',                        'Po�et p��sp�vk�');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Kolik p��sp�vk� z Twitteru m� b�t zobrazeno? (V�choz�: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Pouze tweety adresovan� v�em');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Pokud je zapnuto, nebudou se zobrazovat tweety, kter� obsahuj� zavin�� "@" (pouze v PHP verzi)');
@define('PLUGIN_TWITTER_SERVICE',                       'Slu�ba');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Vyberte mikroblogovac� slu�bu, kterou pou��v�te');
@define('PLUGIN_TWITTER_USERNAME',                      'U�ivatelsk� jm�no');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Pokud m�te adresu http://www.twitter.com/ptak_jarabak, pak je Va�e u�ivatelsk� jm�no ptak_jarabak. M��ete pou��t i p�ihla�ovac� jm�no k indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'V�stupn� form�t');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'M��ete si vybrat mezi Javascriptem a PHP. T�k� se vlastn�ho zobrazen� p��sp�vk� v postrann�m bloku na blogu. Pozor! - JavaScript nebude fungovat s v�ce instancemi pluginu na jedn� str�nce. Mus�te pou��t PHP verzi, pokud ho tak chcete nastavit.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Jak dlouho cachovat data (pouze pro PHP form�t)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Aby se zamezilo p��li� velk�mu a zbyte�n�mu p�en�en� dat mezi blogem a Twitterem, mohou se v�sledky z Twitteru ukl�dat do cache. Zde zadejte v sekund�ch dobu, po kter� se bude aktualizovat obsah cache podle Twitteru.');
@define('PLUGIN_TWITTER_BACKUP',                        'Z�lohovat Tweety? (experiment�ln� funkce, pouze Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Pokud je povoleno, plugin bude denn� stahovat tweety a z�lohovat je v datab�zi blogu (tabulka ' . $serendipity['dbPrefix'] . 'tweets). Vy�aduje PHP5.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text odkaz� ve tweetech');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Odkazy nalezen� v Tweetech jsou nahrazeny kliknuteln�m HTML odkazem. Zde nastavte text odkazu. Hodnota $1 bude nahrazena samotn�m odkazem tak, jak to d�l� Twitter.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Odkaz "Sledov�n�"');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'P�id�v� odkaz "sledov�n�" pod �asovou osu');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Sledov�n�');
@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Pou��t pohled zp�t v �ase');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Pokud je zapnuto, pak bude �as statutu zobrazen jako �as, kter� uplynul od zad�n� statutu (tak jak to d�l� samotn� twitter), jinak bude pou��t nastaviteln� form�t data.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Probl�m p�i p��stupu na Twitter. <br />Po�kejte chvilku a obnovte str�nku...');

// Twitter Event Plugin 

@define('PLUGIN_EVENT_TWITTER_NAME',                    'Mikroblogov�n� (Twitter, Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'P�id�v� klienta Twitter/Identica do administra�n� sekce a stahuje nov� tweety a ozn�muje nov� �l�nky na ��tu mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Jm�no ��tu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Jm�no ��tu, kter�m se bude klient na pozad� p�ihla�ovat k mikroblogu.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Heslo k ��tu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Heslo ��tu, kter�m se bude klient na pozad� p�ihla�ovat k mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Ozn�mov�n� �l�nk�');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Oznamovat nov� �l�nky');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Pokud je zapnuto, plugin bude oznamovat nov� na blogu publikovan� p��sp�vky na slu�b� Twitter nebo Identica.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Ozn�mit s tagy');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Pokud je nainstalov�n plugin Free Tag (Kl��ov� slova), oznamova� �l�nk� prohled� nadpis p��sp�vku, jestli neobsahuje tagy. Pokud n�jak� nalezne, budou tyto tagy ozna�en� jako tagy twitteru. V�dy m��ete p�idat tagy ru�n� pomoc� #tags#. Tyto budou napln�ny v�emi tagy, kter� je�t� nebyly nalezeny v nadpisu p��sp�vku. To znamen� v�echny zde zadan� tagy budou p�id�ny, pokud volba automatick�ho hled�n� tag� nen� zapnuta.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Ozn�mit URL zkracova�');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Slu�ba, kter� m� b�t pou�ita pro zkr�cen� odkaz� p�i oznamov�n� p��sp�vku. Doporu�en� jsou 7ax.de nebo tinyurl.com, proto�e to jsou zat�m jedin� zn�m� slu�by, kter� funguj� spole�n� s tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Zji��ovat Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Pokud je zapnuto, plugin se pokus� naj�t tweetbacky (odezvy twitteru) na �l�nky a p�id� volbu "zkontrolovat odezvy twitteru" pod roz���en� t�lo p��sp�vku, pokud je n�v�t�vn�k p�ihl�en� do blogu.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignorovat moje Tweety');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Pokud nechcete zobrazovat vlastn� tweety jako tweetbacky, zapn�te tuto volbu. V opa�n�m p��pad� budou ozn�men� zobrazov�na jako tweetbacky.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Frekvence kontroly tweetback�');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','�as v minut�ch mezi dv�ma kontrolami twitteru. (mus� b�t alespo� 5 minut)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Typ tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity nepodporuje sama o sob� tweetbacky. Tak�e ty musej� b�t ulo�eny jako odezvy nebo norm�ln� koment��e. Proto�e p�ich�zej� z vn� blogu, jsou jist�m type odezvy, ale podle obsahu by pat�ily sp� mezi koment��e. Rozhodn�te sami, jak se maj� tweetbacky ukl�dat.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Odezva');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Koment��');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Mikroblogovac� klient');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Zapnout mikroblogovac�ho klienta');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Zapnte tweeter na hlavn� str�nce administra�n� sekce, jako postrann� sloupec a nebo ho vypne.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hlavn� str�nka');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Postrann� sloupec');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Vypnout');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Zobrazit �asovou osu');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Zobrazuje �asovou osu s �l�nky pod aktualizovan�m v�pisem.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'D�lka �asov� osy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Kolik nejnov�j��ch p��sp�vk�  se m� zobrazovat na hlavn� stran�?');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Zadejte tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'znak� vlevo');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Zkracovat URL adresy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet ulo�en ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet nemohl b�t ulo�en! Chyba Twitteru: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Obecn�');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Zadejte celou HTTP cestu (v�echno, co n�sleduje po Va�em dom�nov�m jm�n�), kter� vede do adres��e s pluginem.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'UPOZORN�N�: Nalezen nainstalovan� plugin TwitterTweeter.</p>' .
                '<p class="serendipityAdminMsgError">Tento plugin je slou�en�m pluginu TwitterTweeter a ofici�ln�ho star�ho serendipity pluginu twitter, nav�c oba dva pluginy roz�i�uje.M�li byste odinstalovat v�echny p�edchoz� pluginy.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'URL Tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Co ulo�it jako URL adresu tweetbacku? M�te 3 mo�nosti. Status: url tweetu, kter� je tweetbackem, Profil: adresa profilu u�ivatele twitteru nebo WebURL: adresa zadan� u�ivatelem twitteru v jeho profilu jako Web URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Po�et ��t�');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Po ulo�en� tohoto nastaven� se na t�to str�nce nastaven� objev� pol��ka pro nastaven� zde zadan�ho po�tu ��t�. Mo�n� budete muset nastaven� ulo�it dvakr�t, abyste p��slu�n� zad�vac� pol��ka vid�li.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Identita');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Jm�no slu�by');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Zadejte, zda je tento ��et na twitteru nebo na identi.ca');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Oznamovac� ��ty');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Vyberte ��ty, na kter� se maj� oznamovat nov� p��sp�vky');

// Configuration Tabs:

@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfigura�n� z�lo�ky:');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identity');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Oznamov�n� �l�nk�');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Mikroblogovac� klient');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Obecn�');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'V�echno');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Odpov�d�t pisateli');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweetovat');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'P��m� zpr�va (Pracuje pouze pokud V�s u�ivatel sleduje)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignorovat tweetbacky z');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','��rkami odd�len� seznam ��t� twitteru, ze kter�ch nechcete p�ij�mat tweetbacky.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'VAROV�N�: Plugin ud�lost� pro mikroblogov�n� (twitter/identica) je�t� nebyl nainstalov�n!</p>' .
                '<p class="serendipityAdminMsgError">Hlavn� ��st funkc� twitter/identica je zabezpe�ov�na pluginem ud�lost� mikroblogov�n�. Pokud chcete plnou funk�nost pluginu, m�li byste ho tak� nainstalovat
.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Form�t ozn�men�');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Zadejte vlastn� form�t oznamovac�ch zpr�v. M��ete pou��t n�sleduj�c� prom�nn�. title#: bude nahrazen nadpisem p��sp�vku (a odpov�daj�c�mi tagy); #link#: odkaz na p��sp�vek; #author#: Autor p��sp�vku; #tags#: zb�vaj�c� tagy.');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Povolit "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Zapnut� t�to funkce zobraz� tla��tko "Twittni to!" v pati�ce p��sp�vku.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Zapnout Identica');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Zapnut� t�to funkce zobraz� tla��tko "Identica" v pati�ce p��sp�vku.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Form�t "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Zadejte form�t pro tweety n�v�t�vn�k�. M�li byste pou��t n�sleduj�c� prom�nn�. title#: bude nahrazen nadpisem p��sp�vku (a odpov�daj�c�mi tagy); #link#: odkaz na p��sp�vek; #author#: Autor p��sp�vku; #tags#: zb�vaj�c� tagy.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Styl tla��tek');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'V sou�asnosti je mo�no vybrat mezi dv�ma styly twittovac�ho tla��tka.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', '�ern�');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'b�l�');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     '"Twittni to!" v nov�m okn�');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Pokud je zapnuto, twitter a identica se nat�hnou v nov�m okn�, v aktu�ln�m okn� tedy z�stane st�le zobrazen� blog.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartyfizce funkce "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Pokud je zapnuto, plugin nebude p�id�vat tla��tko s�m o sob�. M�sto toho p�id� do smarty dv� prom�nn�: entry.url_tweetthis a entry.url_dentthis. Ty pak lze pou��t v �ablon�. Tyto prom�nn� obsahuj� pouze URL adresy, tak�e m��ete vytvo�it vlastn� text pro tla��tko "Twittni to!", nebo tla��tko um�stit nap��klad do z�hlav� �l�nku.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'NEoznamovat tento p��sp�vek pomoc� mikroblogovac�ch slu�eb');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Zadejte libovoln� tagy, kter� souvis� s p��sp�vkem. V�ce tag� odd�lujte ��rkou (,). Pokud je zde n�co zad�no, tagy pluginu freetag jsou p�i oznamov�n� ignorov�ny!');

// Next lines were translated on 2009/08/15

@define('PLUGIN_TWITTER_FILTER_ALL',                    '��dn� u�ivatelsk� tweety');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Pokud je volba zapnuta, nebudou se zobrazovat tweety obsahuj�c� @. (pouze v PHP verzi)');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Schvalov�n� tweetback�');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Jak pracovat s p�ijat�mi tweetbacky? M��ete pou��t obecn� nastaven� pro koment��e, schvalovat je, nebo je v�dy povolit.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Pou��t obecn� nastaven� koment���');

// Next lines were translated on 2009/08/25

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Zobrazit URL adresu pro tento �l�nek');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Tento odkaz nen� klikac�. Obsahuje zkr�cenou URL adresu k tomuto p��sp�vku. Tuto URL adresu m��ete pou��t jako odkaz na tento �l�nek, nap��klad v twitteru. Odkaz zkop�rujete tak, �e kliknete prav�m tla��tkem a vyberete "Zkop�rovat odkaz" v Internet Exploreru, nebo "Kop�rovat adresu odkazu" v Mozille.');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Zobrzit kr�tkou URL adresu pro ka�d� p��sp�vek');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Bude zobrazovat v�choz� kr�tkou URL v pati�ce ka�d�ho �l�nku. Pokud je zapnut� funkce smarty TweetThis, ka�d� p��sp�vek bude obsahovat prom�nnou entry.url_shorturl, kter� se d� libovoln� vyu��t ve smarty �ablon�.');

// Next lines were translated on 2010/09/28

@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Kl�� z�kazn�ka (Consumer key)');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       '"Z�kaznick� kl��" a "z�kaznick� heslo" obdr��te od Twitteru pot�, co pro sv�j blok vytvo��te aplikaci Twitteru.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Z�kaznick� heslo');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                '�asov� osa statutu');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'P�ipojeno');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Smazat odkaz');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',       'Twitter OAuth token odstran�n');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',             'Zav��t okno');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                'Registrovat');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',             'Zp�tn� URL adresa (zadejte ve Twitteru)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',        'Chyba zp�tn�ho vol�n� Twitteru');

// Next lines were translated on 2011/03/09

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',    'Pro oznamov�n� p��sp�vku je ve v�choz�m nastaven� checkbox od�krtnut');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Povolen� znamen�, �e nov� p��sp�vek na blogu mus� b�t v�slovn� odesl�n do twiteru. Vypnut� (v�choz� hodnota) znamen�, �e p��sp�vek bude do twiteru odesl�n automaticky.');

// Next lines were translated on 2012/01/11
@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Klikn�te na tla��tko n�e a p�ipojte Twitter.<br/>
<p><a style="color:red;">VAROV�N�!</a><br/>
Mus�te se p�ihl�sit nebo odhl�sit s <b>odpov�daj�c�m ��tem Twitteru</b>!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Potvr�te pros�m p�ed p�ipojen�m</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                  'P�ihl�sit');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Widget sledov�n� Twitteru');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Pokud plugin zobrazuje �asovou osu, m��ete povolit widget twitteru pro zobrazov�n� aktu�ln�ho po�tu follower� a dal��. Nastaven� je ignorov�no, pokud zobrazujete z identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Po�et follower� ve widgetu');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je povoleno, widget zobrazuje po�et follower�.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Widget sledov�n� Twitter na tmav�m pozad�');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Va�e �ablona pou��v� tmav� pozad�, m�li byste toto povolit.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',      '<h3>u�ivatelsk� jm�no bit.ly a API kl��</h3><b>bit.ly</b> a <b>j.mp</b> zkracova�e URL adres pot�ebuj� p�ihla�ovac� jm�no k bit.ly a API kl��. Pokud ani jeden z t�chto zkracova�� nepou��v�te, nem�li byste je pot�ebovat.<br/>V�choz� kl�� v�t�inou nefunguje, proto�e je to demo kl�� a jeho kv�ta je pravideln� p�e�erp�na. Pokud m�te ��et na bit.ly account, m�li byste zadat vlastn� p�ihla�ovac� �daje.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank">Najdete je tady</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',     'U�ivatelsk� jm�no bit.ly');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API kl��');
@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',         '<h3>Vlastn� twitter klient</h3>Ve v�choz�m nastaven� pou��v� plugin klienta \'s9y\'. M��ete si <a href="https://dev.twitter.com/apps" target="_blank">zaregistrovat vlastn�ho klienta</a> a nastavit consumer kl�� a heslo va�eho klienta.');