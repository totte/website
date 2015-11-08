<?php #

/**
 *  @version
 *  @author Martin Matu�ka <martin@matuska.org>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SPAMBLOCK_TITLE', 'Spam Protector');
@define('PLUGIN_EVENT_SPAMBLOCK_DESC', 'R�zn� met�dy na ochranu proti spamu.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_BODY', 'Ochrana proti spamu: Neplatn� spr�va.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_IP', 'Ochrana proti spamu: Nie je povolen� odosla� koment�r kr�tko po odoslan� in�ho koment�ra.');

@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_KILLSWITCH', 'Tento weblog je nastaven� v m�de "N�dzov� blokovanie v�etk�ch koment�rov", sk�ste nesk�r.');
@define('PLUGIN_EVENT_SPAMBLOCK_BODYCLONE', 'Zak�za� opakuj�ce sa koment�re');
@define('PLUGIN_EVENT_SPAMBLOCK_BODYCLONE_DESC', 'Zak�za� u��vate�om odosla� koment�r, ktor� m� rovnak� obsah ako in�, u� odoslan� koment�r.');
@define('PLUGIN_EVENT_SPAMBLOCK_KILLSWITCH', 'N�dzov� vypnutie koment�rov');
@define('PLUGIN_EVENT_SPAMBLOCK_KILLSWITCH_DESC', 'Do�asne vypne koment�re ku v�etk�m �l�nkom. U�ito�n� v pr�pade �toku spammerov na V� weblog.');
@define('PLUGIN_EVENT_SPAMBLOCK_IPFLOOD', 'Blokovanie IP adres');
@define('PLUGIN_EVENT_SPAMBLOCK_IPFLOOD_DESC', 'Z jednej IP adresy povoli� odoslanie jedn�ho koment�ra za n min�t. U�ito�n� pre zabr�nenie koment�rov�ho floodu.');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS', 'Zapn� kryptogramy (captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_DESC', 'Prispievate� mus� zada� ��sla z n�hodne vytvoren�ho deformovan�ho obr�zku. Toto zabr�ni automatick�mu prid�vaniu koment�rov, napr. hackersk�mi po��ta�mi. Nezab�dajte, �e �udia so zhor�n�m viden�m m��u ma� probl�my s ��tan�m t�chto obr�zkov.');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_USERDESC', 'V r�mci boja proti koment�rov�mu spamu zadajte pros�m znaky, ktor� s� zobrazen� ni��ie. V� koment�r bude prijat� iba ak tieto znaky bud� s�hlasi�. V� prehliada� mus� podporova� a prij�ma� cookies, inak nem��u by� Va�e koment�re spr�vne overen�.');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_USERDESC2', 'Do ni��ie uveden�ho po�a zadajte znaky, ktor� s� zobrazen� nad t�mto textom.');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_USERDESC3', 'Zadajte znaky z antispamov�ho obr�zku: ');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_CAPTCHAS', 'Zadali ste nespr�vne znaky z antispamov�ho obr�zku. Prezrite si ho pros�m znova a zadajte znaky op�tovne.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_NOTTF', 'Kryptogramy s� vypnut�. K prev�dzke s� potrebn� PHP kni�nice GDLib a freetype, a tie� je potrebn� ma� fontov� soubory (.TTF) v prie�inkoch doplnku "spamblock".');

@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_TTL', 'Vy�adova� kryptogramy po tomto po�te dn�');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_TTL_DESC', 'Kryptogramy (captcha) m��u by� zapnut� v z�vislosti od veku �l�nku. Zadajte po�et dn�, po ktor�ch sa bude vy�adova� na vlo�enie koment�ra spr�vny text z kryptogramu. Hodnota 0 znamen�, �e kryptogramy bud� vy�adovan� hne� po publikovan�.');
@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATION', 'Vy�adova� moderovanie (schva�ovanie) koment�rov po tomto po�te dn�');
@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATION_DESC', 'V�etky koment�re sa daj� automaticky nastavi� ako moderovan�. Po uplynut� tu uvedenej doby od publikovania �l�nku sa bude vy�adova� moderovanie (schva�ovanie) koment�rov. Hodnota 0 znamen� bez moderovania.');
@define('PLUGIN_EVENT_SPAMBLOCK_LINKS_MODERATE', 'Po�et odkazov v koment�ri na automatick� moderovanie');
@define('PLUGIN_EVENT_SPAMBLOCK_LINKS_MODERATE_DESC', 'Ak sa v koment�ri nach�dza viac ako zadan� po�et odkazov &lt;a href="..."&gt;, bude automaticky moderovan�. Hodnota 0 znamen�, �e po�et odkazov nebude kontrolovan�.');
@define('PLUGIN_EVENT_SPAMBLOCK_LINKS_REJECT', 'Po�et odkazov v koment�ri na automatick� zamietnutie');
@define('PLUGIN_EVENT_SPAMBLOCK_LINKS_REJECT_DESC', 'Ak sa v koment�ri nach�dza viac ako zadan� po�et odkazov &lt;a href="..."&gt;, bude automaticky zamietnut�. Hodnota 0 znamen�, �e po�et odkazov nebude kontrolovan�.');

@define('PLUGIN_EVENT_SPAMBLOCK_NOTICE_MODERATION', 'V� koment�r vy�aduje schv�lenie prev�dzkovate�om weblogu. Pros�m, neposielajte ho znovu, po�kajte na jeho schv�lenie.');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHA_COLOR', 'Pozadie kryptogramov (captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHA_COLOR_DESC', 'Zadajte RGB hodnotu: 0,255,255');

@define('PLUGIN_EVENT_SPAMBLOCK_LOGFILE', 'Umiestnenie logovania');
@define('PLUGIN_EVENT_SPAMBLOCK_LOGFILE_DESC', 'Inform�cie o zamietnut�ch/moderovan�ch pr�spevkoch m��u by� zapisovan�. Pr�zdna hodnota znamen� vypnut� logovanie.');

@define('PLUGIN_EVENT_SPAMBLOCK_REASON_KILLSWITCH', 'N�dzov� blokovanie koment�rov');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_BODYCLONE', 'Duplicitn� koment�r');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_IPFLOOD', 'IP-blok');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_CAPTCHAS', 'Nespr�vny kryptogram (Zadan�: %s, Spr�vne malo by�: %s)');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_FORCEMODERATION', 'Automatick� moderovanie (schva�ovanie) po X d�och');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_LINKS_REJECT', 'P��li� ve�a odkazov (odoziev)');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_LINKS_MODERATE', 'P��li� ve�a odkazov (odoziev)');
@define('PLUGIN_EVENT_SPAMBLOCK_HIDE_EMAIL', 'Skry� e-mailov� adresu prispievate�ov koment�rov');
@define('PLUGIN_EVENT_SPAMBLOCK_HIDE_EMAIL_DESC', 'Nezobraz� e-mailov� adresu prispievate�ov v ich koment�roch');
@define('PLUGIN_EVENT_SPAMBLOCK_HIDE_EMAIL_NOTICE', 'E-mailov� adresy nebud� zobrazen�, bud� pou�it� iba na ozn�menia elektronickou po�tou.');

@define('PLUGIN_EVENT_SPAMBLOCK_LOGTYPE', 'Vyberte met�du logovania');
@define('PLUGIN_EVENT_SPAMBLOCK_LOGTYPE_DESC', 'Logovanie zamietnut�ch koment�rov m��e by� vykonan� bu� do datab�zy alebo do textov�ho s�boru');
@define('PLUGIN_EVENT_SPAMBLOCK_LOGTYPE_FILE', 'S�bor (pozri vo�ba "logfile" ni��ie)');
@define('PLUGIN_EVENT_SPAMBLOCK_LOGTYPE_DB', 'Datab�za');
@define('PLUGIN_EVENT_SPAMBLOCK_LOGTYPE_NONE', 'Nelogova�');

@define('PLUGIN_EVENT_SPAMBLOCK_API_COMMENTS', 'Ako naklada� s koment�rmi pridan�mi cez API');
@define('PLUGIN_EVENT_SPAMBLOCK_API_COMMENTS_DESC', 'Toto nastavenie sa t�ka moderovania (schva�ovania) koment�rov vytvoren�ch cez volania API funkci� (vovn�tri syst�mu Serendipity) (Trackbacks, WFW:commentAPI koment�re). Pri nastaven� "moderova�" bud� v�etky koment�re vy�adova� schv�lenie. Nastaven�m "zamietnu�" bud� automaticky zamietnut�. Nastavenie "none" sp�sob�, �e bud� spracovan� ako be�n� koment�re.');
@define('PLUGIN_EVENT_SPAMBLOCK_API_MODERATE', 'moderova�');
@define('PLUGIN_EVENT_SPAMBLOCK_API_REJECT', 'zamietnu�');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_API', 'API koment�re (ako napr. odozvy) s� zak�zan�');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_ACTIVATE', 'Zapn� slovn�kov� filter');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_ACTIVATE_DESC', 'V koment�roch bud� h�adan� ur�it� re�azce obsiahnut� v slovn�ku. Ak sa tieto re�azce n�jdu, bude koment�r vyhodnoten� ako spam.');

@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_URLS', 'Pou�i� filter na adresy URL');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_URLS_DESC', 'Regul�rne v�razy s� povolen�, re�azce (jednotliv� adresy) oddelujte bodko�iarkou (;). �peci�lne znaky ako zavin�� (@) mus�te oddeli� lom�tkami - \\@.');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_AUTHORS', 'Pou�i� filter na men� autorov');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_WORDS', 'Pou�i� filter na telo koment�ra');

@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_EMAILS', 'Pou�i� filter na e-mailov� adresu');

@define('PLUGIN_EVENT_SPAMBLOCK_REASON_CHECKMAIL', 'Nespr�vna e-mailov� adresa');
@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL', 'Kontrolova� e-mailov� adresy?');
@define('PLUGIN_EVENT_SPAMBLOCK_REQUIRED_FIELDS', 'Vy�adovan� polia koment�ra');
@define('PLUGIN_EVENT_SPAMBLOCK_REQUIRED_FIELDS_DESC', 'Zadajte zoznam pol�, ktor� musia by� vyplnen� na odoslanie koment�ra. Viac pol� oddelujte �iarkou ",". Do �vahy pripadaj� polia: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_REQUIRED_FIELD', 'Nezadali ste pole %s!');

@define('PLUGIN_EVENT_SPAMBLOCK_CONFIG', 'Konfigurova� antispamov� met�dy');
@define('PLUGIN_EVENT_SPAMBLOCK_ADD_AUTHOR', 'Blokova� tohto autora doplnkom "Spamblock"');
@define('PLUGIN_EVENT_SPAMBLOCK_ADD_URL', 'Blokova� t�to adresu URL doplnkom "Spamblock"');
@define('PLUGIN_EVENT_SPAMBLOCK_ADD_EMAIL', 'Blokova� t�to e-mailov� adresu doplnkom "Spamblock"');
@define('PLUGIN_EVENT_SPAMBLOCK_REMOVE_AUTHOR', 'Zru�i� blokov�nie tohto autora');
@define('PLUGIN_EVENT_SPAMBLOCK_REMOVE_URL', 'Zru�i� blokov�nie tejto adresy URL');
@define('PLUGIN_EVENT_SPAMBLOCK_REMOVE_EMAIL', 'Zru�i� blokov�nie tejto e-mailovej adresy');


@define('PLUGIN_EVENT_SPAMBLOCK_REASON_TITLE', 'Nadpis koment�ra je rovnak� ako jeho telo');
@define('PLUGIN_EVENT_SPAMBLOCK_FILTER_TITLE', 'Odmietnut� bud� koment�re, ktor� v tele obsahuj� iba nadpis.');

@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKURL', 'Kontrolova� URL odoziev');
@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKURL_DESC', 'Povoli� iba odozvy, kde str�nka odozvy naozaj obsahuje odkaz na V� weblog - kontroluje str�nku odozvy.');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_TRACKBACKURL', 'URL str�nky odozvy je nepladn�.');

@define('PLUGIN_EVENT_SPAMBLOCK_CAPTCHAS_SCRAMBLE', 'Zmie�an� kryptogramy');

@define('PLUGIN_EVENT_SPAMBLOCK_HIDE', 'Vypn� Spamblock pre nasleduj�cich autorov');
@define('PLUGIN_EVENT_SPAMBLOCK_HIDE_DESC', 'Autorom v nasleduj�cich skupin�ch m��ete povoli� vkladanie �l�nkov bez toho, aby boli kontrolovan� na spam.');

@define('PLUGIN_EVENT_SPAMBLOCK_AKISMET', 'Akismet API Key');
@define('PLUGIN_EVENT_SPAMBLOCK_AKISMET_DESC', 'Akismet.com je centr�lny antispamov� a blacklistov� server. M��e analyzova� prich�dzaj�ce koment�re a kontrolova�, �i s� veden� ako spam. Akismet bol vyvinut� pre WordPress, ale m��e by� pou�it� aj v in�ch syst�moch. Je k tomu potrebn� Key z http://www.akismet.com, ktor� z�skate registr�ciou na http://www.wordpress.com/. Ak nech�te toto pole pr�zdne, Aksimet sa nebude pou��va�.');
@define('PLUGIN_EVENT_SPAMBLOCK_AKISMET_FILTER', 'Ako ozna�ova� pr�spevok ozna�en� Aksimetom ako spam?');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_AKISMET_SPAMLIST', 'Zamietnut� blacklistom Akismet.com');

@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATION_TREAT', 'Ako naklada� s koment�rmi ozna�en�mi na automatick� moder�ciu?');
@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATIONT_TREAT', 'Ako naklada� s odozvami ozna�en�mi na automatick� moder�ciu?');
@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATIONT', 'Vy�adova� moderovanie (schva�ovanie) odoziev po tomto po�te dn�');
@define('PLUGIN_EVENT_SPAMBLOCK_FORCEMODERATIONT_DESC', 'V�etky odozvy sa daj� automaticky nastavi� ako moderovan�. Po uplynut� tu uvedenej doby od publikovania �l�nku sa bu
de vy�adova� moderovanie (schva�ovanie) odoziev. Hodnota 0 znamen� bez moderovania.');

@define('PLUGIN_EVENT_SPAMBLOCK_CSRF', 'Zapn� CSRF Ochranu pre koment�re?');
@define('PLUGIN_EVENT_SPAMBLOCK_CSRF_DESC', 'Ak je zapnut�, bude sa pomocou �peci�lnej hash hodnota kontrolova�, aby boli koment�re pridan� iba od pou��vate�ov s platn�m ��slom sedenia. Toto zmierni spam a zabr�ni pou��vate�om prid�va� koment�re cez CSRF. U��vatelia, ktor� nemaj� zapnut� cookies, nebud� m�c� prid�va� koment�re.');
@define('PLUGIN_EVENT_SPAMBLOCK_CSRF_REASON', 'V� koment�r neobsahuje hash sedenia. Koment�re m��u by� na tento weblog posielan� iba so zapnut�mi cookies!');

@define('PLUGIN_EVENT_SPAMBLOCK_HTACCESS', 'Blokova� ne�elan� IP adresy pomocou HTaccess?');
@define('PLUGIN_EVENT_SPAMBLOCK_HTACCESS_DESC', 'Aktivovanie tejto vo�by prid� IP adresy, z ktor�ch prich�dza spam do s�boru .htaccess. Tento bude pravidelne aktualizovan� ka�d� mesiac.');

@define('PLUGIN_EVENT_SPAMBLOCK_LOOK', 'Takto vyzeraj� Va�e kryptogramy (captcha). Ak ste zmenili a ulo�ili vy��ie uveden� nastavenia a chcete vidie� aktu�lny vzh�ad kryptogramu, jednoducho na neho kliknite a bude obnoven�.');

@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKIPVALIDATION', 'Odozvy/ozn�menia: kontrola ip adresy');
@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKIPVALIDATION_DESC', 'M� IP odosielate�a s�hlasi� s IP po��ta�a, ktor�mu je zasielan� odozva/ozn�menie (trackaback/pingback)? (ODPOR��AME!)');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_IPVALIDATION', 'Kontrola IP adresy: %s [%s] != ip adresa odosielate�a [%s]');

@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL_DESC', 'Ak je vypnut�, nebude sa vykon�va� �iadna kontrola e-mailov. Ak je nastaven� na "�no", autor koment�ra mus� zada� platn� e-mailov� adresu. Nastavenie "Potvrdi� ka�d�" sp�sob�, �e ka�d� koment�r mus� by� potvredn� kliknut�m na odkaz v zaslanom e-maile. Pri nastaven� "Potvrdi� prv�" mus� autor koment�ra potvrdi� iba svoj prv� koment�r. Ostatn� koment�re s rovnak�m menom a e-mailovou adresou nebud� vy�adova� potvrdenie.');
@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL_VERIFICATION_ONCE', 'Potvrdi� prv�');
@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL_VERIFICATION_ALWAYS', 'Potvrdi� ka�d�');
@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL_VERIFICATION_MAIL', 'V kr�tkosti V�m bude doru�en� e-mail, pomocou ktor�ho m��ete potvrdi� V� koment�r.');
@define('PLUGIN_EVENT_SPAMBLOCK_CHECKMAIL_VERIFICATION_INFO', 'Na pridanie koment�ra sa vy�aduje potvrdenie pomocou e-mailu. Po odoslan� formul�ra s koment�rom V�m bude zaslan� e-mail, pomocou ktor�ho dokon��te pridanie koment�ra.');

@define('PLUGIN_EVENT_SPAMBLOCK_AKISMET_SERVER', 'Antispamov� server');
@define('PLUGIN_EVENT_SPAMBLOCK_AKISMET_SERVER_DESC', 'Na ktorom serveri je zaregistrovan� vy��ie uveden� k���? Anonymne znamen�, �e �daje posielan� webovej slu�be neobsahuj� pou��vate�sk� meno a e-mailov� adresu. Aj t�to vo�ba zni�uje mno�stvo spamu, i ke� nie a� tak dobre, ako neanonymne.');
@define('PLUGIN_EVENT_SPAMBLOCK_SERVER_TPAS', 'TypePad Antispam');
@define('PLUGIN_EVENT_SPAMBLOCK_SERVER_AKISMET', 'p�vodn� Akismet');
@define('PLUGIN_EVENT_SPAMBLOCK_SERVER_TPAS_ANON', 'TypePad Antispam (anonymne)');
@define('PLUGIN_EVENT_SPAMBLOCK_SERVER_AKISMET_ANON', 'p�vodn� Akismet (anonymne)');

@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKIPVALIDATION_URL_EXCLUDE', 'Vyl��i� adresy URL z overenia IP adresy');
@define('PLUGIN_EVENT_SPAMBLOCK_TRACKBACKIPVALIDATION_URL_EXCLUDE_DESC', 'Adresy URL, pri ktor�ch sa nem� overova� IP adresa. ' . PLUGIN_EVENT_SPAMBLOCK_FILTER_URLS_DESC);

