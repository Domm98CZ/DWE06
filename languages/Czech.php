<?php
$language = array();
global $language;
$language["USER_01"] = "Profil";
$language["USER_02"] = "Zprávy";
$language["USER_03"] = "Nastavení";
$language["USER_04"] = "Odhlásit se";
$language["USER_05"] = "Administrace";
$language["USER_06"] = "Smazat status";
$language["USER_07"] = "Smazat komentář";
$language["USER_E01"] = "Chyba - nejsi přihlášený";
$language["USER_E02"] = "Pro zobrazení této stránky se musíš přihlásit popřípadě zaregistrovat.";
/* LOGIN */
$language["LOGIN_01"] = "Přihlášení";
$language["LOGIN_02"] = "Přihlašovací jméno";
$language["LOGIN_03"] = "Přihlašovací heslo";
$language["LOGIN_04"] = "Přihlásit se";
$language["LOGIN_05"] = "Registrovat se";
$language["LOGIN_06"] = "Zapomenuté heslo";
$language["LOGIN_07"] = "Již mám účet, přihlásit se";
/* LOGIN ERRORS */
$language["LOGIN_E01"] = "Jméno nebo heslo nebylo vyplněno.";
$language["LOGIN_E02"] = "Neplatné uživatelské jméno.";
$language["LOGIN_E03"] = "Špatné uživatelské heslo.";
$language["LOGIN_E04"] = "Již jsi přihlášený.";
$language["LOGIN_E05"] = "Účet ještě nebyl aktivovaný.";
/* REGISTER */
$language["REGISTER_01"] = "Registrace";
$language["REGISTER_02"] = "Uživatelské jméno";
$language["REGISTER_03"] = "Zobrazované jméno";
$language["REGISTER_04"] = "Heslo";
$language["REGISTER_05"] = "Heslo <i>(znovu)</i>";
$language["REGISTER_06"] = "E-Mailová adresa";
$language["REGISTER_07"] = "E-Mailová adresa <i>(znovu)</i>";
$language["REGISTER_08"] = "Na E-mailovou adresu vám bude zaslán aktivační e-mail.";
$language["REGISTER_09"] = "Zaregistrovat se";
/* REGISTER ERRORS */
$language["REGISTER_E01"] = "Nebyla vyplněna všechna pole registrace.";
$language["REGISTER_E02"] = "Neplatné uživatelské jméno. (Musí být delší než 2 znaky a zároveň neobsahovat diakritiku)";
$language["REGISTER_E03"] = "Zadaná hesla nesouhlasí.";
$language["REGISTER_E04"] = "Neplatná e-mailová adresa.";
$language["REGISTER_E05"] = "Špatně opsaný e-mail.";
$language["REGISTER_E06"] = "Toto přihlašovací jméno již někdo používá.";
$language["REGISTER_E07"] = "Tento e-mail již někdo používá.";
$language["REGISTER_E08"] = "Toto zobrazované jméno již někdo používá.";
$language["REGISTER_E09"] = "Již jsi zaregistrován.";
$language["REGISTER_OK"] = "Registrace proběhla úspěšně, na e-mailovou adresu <b>".$_POST["user_email"]."</b> byl zaslán aktivační e-mail.";
/* REGISTER E-MAIL */
$language["EMAIL_01"] = "Pro dokončení registrace na stránkách <b>".Web_GetOption("NAME")."</b>, stačí kliknout na následující odkaz.<br>";
$language["EMAIL_02"] = "<br>Hezký zbytek dne přeje ".Web_GetOption("NAME").".";
/* PASSWORD */
$language["PASS_01"] = "Zapomenuté heslo";
$language["PASS_02"] = "Pokud jste ztratili své heslo, zadejte nám vyplňte zde vaší e-mailovou adresu, nebo přihlašovací jméno účtu.<br>Poté vám zašleme e-mail s odkazem pro změnu hesla.";
$language["PASS_03"] = "nebo";
$language["PASS_04"] = "Pokračovat";
$language["PASS_05"] = "*Na e-mailovou adresu účtu bude zaslán odkaz pro změnu hesla.";
$language["PASS_06"] = "Pro změnu hesla na stránkách <b>".Web_GetOption("NAME")."</b>, stačí kliknout na následující odkaz.<br>";
$language["PASS_07"] = "Nyní můžete napsat své nové heslo.";
$language["PASS_M01"] = "Změna hesla";
$language["PASS_M02"] = "Vaše změno bylo úspěšně změněno.";
$language["PASS_E01"] = "Musí být vyplněna alespoň jedna hodnota.";
$language["PASS_E02"] = "Účet s tímto přihlašovacím jménem, neexistuje.";
$language["PASS_EOK"] = "Byl zaslán e-mail s odkazem pro změnu hesla.";
/* BLOCKED PAGE */
$language["BAN_01"] = "Váš účet byl zablokován";
$language["BAN_02"] = "Důvod blokace";
$language["BAN_03"] = "Vaše IP Adresa byla zablokována";
$language["BAN_04"] = "Pokud si myslíte, že je blokace neoprávněná, kontaktujte nás na e-mailovou adresu <a href='mailto:".Web_GetOption("EMAIL")."'>".Web_GetOption("EMAIL")."</a>.";
$language["BAN_05"] = "Tento ban byl udělen dne";
$language["BAN_06"] = "Účet";
$language["BAN_07"] = "IP Adresa";
/* ACTIV PAGE */
$language["ACTIVATE_01"] = "Aktivace účtu";
$language["ACTIVATE_E01"] = "Účet byl již aktivován.";
$language["ACTIVATE_E02"] = "Něco se pokazilo, kontaktujte prosím administrátora stránek.";
$language["ACTIVATE_E03"] = "Tento účet neexistuje.";
$language["ACTIVATE_E04"] = "Neplatný aktivační klíč.";
$language["ACTIVATE_EOK"] = "Účet byl úspěšně aktivován, nyní se můžete přihlásit.";
/* ERROR PAGE */
$language["ERROR_01"] = "Chyba - Stránka nenalezena";
$language["ERROR_02"] = "Něco se pokazilo, tato stránka neexistuje. Stránka <b>".$_GET["page"]."</b>, nebyla nalezena v našem systému.";
/* POSTS */
$language["POST_01"] = "Příspěvek";
$language["POST_02"] = "Komentáře";
$language["POST_03"] = "Autor:";
$language["POST_04"] = "Zveřejněno:";
/* POSTS ERRORS */
$language["POST_E01"] = "Chyba - Příspěvek neexistuje";
$language["POST_E02"] = "Nepodařilo se nám najít tento příspěvek. <a href='index.php' class='btn btn-xs btn-primary'>Zpět na úvodní stranu</a>";
/* Comments */
$language["COMM_01"] = "Sem vložte text komentáře..";
$language["COMM_02"] = "Přidat komentář";
$language["COMM_03"] = "napsal";
/* PROFILE */
$language["PROFILE_01"] = "Profil uživatele";
$language["PROFILE_02"] = "Uživatelské jméno";
$language["PROFILE_03"] = "Zobrazované jméno";
$language["PROFILE_04"] = "E-Mail";
$language["PROFILE_05"] = "Datum registrace";
$language["PROFILE_06"] = "Datum posledního přihlášení";
$language["PROFILE_07"] = "Datum poslední aktivity";
$language["PROFILE_08"] = "SZ";
$language["PROFILE_09"] = "Sem vložte text statusu..";
$language["PROFILE_10"] = "Přidat status";
$language["PROFILE_11"] = "zveřejnil status";
$language["PROFILE_12"] = "Nahlásit";
$language["PROFILE_E01"] = "Chyba - Profil nenalezen.";
$language["PROFILE_E02"] = "Tento profil neexistuje.";
/* REPORTS */
$language["REPORT_01"] = "Nahlášení uživatele";
$language["REPORT_02"] = "Pokud uživatel porušuje pravidla webu, nahlašte ho zde administrátorům.";
$language["REPORT_03"] = "Důvod nahlášení";
$language["REPORT_04"] = "Sem napište důvod, který vás vedl k nahlášení.";
$language["REPORT_05"] = "Děkujeme za nahlášení, po vyřešení nahlášení budete kontaktováni pomocí soukromé zprávy.";
/* MESSAGES */
$language["MSG_T01"] = "Vítej";
$language["MSG_T02"] = "Vítej na stránkách [b]".Web_GetOption("NAME")."[/b].[br]Toto je pouze uvítací zpráva.[br]Nemusíš na ní odpovídat.";
$language["MSG_01"] = "Soukromé zprávy";
$language["MSG_02"] = "Přijaté";
$language["MSG_03"] = "Nepřečtené";
$language["MSG_04"] = "Důležité";
$language["MSG_05"] = "Nová zpráva";
$language["MSG_06"] = "Datum";
$language["MSG_07"] = "Odeslal";
$language["MSG_08"] = "Předmět zprávy";
$language["MSG_09"] = "Úryvek zprávy";
$language["MSG_10"] = "Zobrazit";
$language["MSG_11"] = "Soukromá zpráva od";
$language["MSG_12"] = "Soukromá zpráva pro";
$language["MSG_13"] = "Zobrazeno";
$language["MSG_14"] = "Žádné zprávy";
$language["MSG_15"] = "Příjemce zprávy";
$language["MSG_16"] = "Předmět zprávy";
$language["MSG_17"] = "Text zprávy..";
$language["MSG_18"] = "Odeslat zprávu";
$language["MSG_19"] = "Odeslané";
$language["MSG_20"] = "Odesláno";
$language["MSG_21"] = "Příjemce";
$language["MSG_22"] = "Text rychlé odpovědi";
$language["MSG_23"] = "Odeslat rychlou odpověď";
$language["MSG_E01"] = "Nebyla vyplněna všechna pole.";
$language["MSG_E02"] = "Tento uživatel neexistuje.";
/* SETTINGS */
$language["SETTINGS_T1"] = "Hlavní nastavení";
$language["SETTINGS_T2"] = "Nastavení hesla";
$language["SETTINGS_T3"] = "Nastavení avatara";
$language["SETTINGS_01"] = "Nastavení";
$language["SETTINGS_02"] = "Uživatelské jméno";
$language["SETTINGS_03"] = "Zobrazované jméno";
$language["SETTINGS_04"] = "E-Mailová adresa";
$language["SETTINGS_05"] = "Uložit";
$language["SETTINGS_06"] = "Aktuální heslo";
$language["SETTINGS_07"] = "Nové heslo";
$language["SETTINGS_08"] = "Nové heslo <i>(znovu)</i>";
$language["SETTINGS_09"] = "Smazat avatar";
$language["SETTINGS_10"] = "Nastavit avatar z url adresy";
$language["SETTINGS_11"] = "Nastavit avatar ze souboru";
$language["SETTINGS_12"] = "Avatar";
$language["SETTINGS_E01"] = "Nebyla vyplněna všechna pole.";
$language["SETTINGS_E02"] = "Tento e-mail již někdo používá.";
$language["SETTINGS_E03"] = "Tato e-mailová adresa je neplatná.";
$language["SETTINGS_E04"] = "Zadaná hesla nejsou stejná.";
$language["SETTINGS_E05"] = "Zadaná url adresa je neplatná.";
$language["SETTINGS_EOK"] = "Nastavení úspěšně uloženo.";
/* PLUGINS */
$language["PLUGIN_E01"] = "Chyba - Plugin nenalezen";
$language["PLUGIN_E02"] = "Omlouváme se, ale nenašli jsme plugin <b>".$_GET["plugin"]."</b>, pokud si myslíte že jde o chybu, nahlašte jí prosím administrátorovi webu.";
/* COLORS */
$language["COLOR_01"] = "Zvol barvu";
$language["COLOR_02"] = "Šedivá";
$language["COLOR_03"] = "Tmavě Modrá";
$language["COLOR_04"] = "Světle Modrá";
$language["COLOR_05"] = "Zelená";
$language["COLOR_06"] = "Oranžová";
$language["COLOR_07"] = "Červená";
/* ADMINISTRATION */
$language["ADMIN_01"] = "Administrace";
$language["ADMIN_02"] = "Přehled";
$language["ADMIN_03"] = "Uživatelé";
$language["ADMIN_04"] = "Příspěvky";
$language["ADMIN_05"] = "Komentáře";
$language["ADMIN_06"] = "Fórum";
$language["ADMIN_07"] = "Vzhled";
$language["ADMIN_08"] = "Hlavní";
$language["ADMIN_09"] = "Ostatní";
$language["ADMIN_10"] = "Sidebar";
$language["ADMIN_11"] = "Soubory";
$language["ADMIN_12"] = "Stránky";
$language["ADMIN_13"] = "Informace o webu";
$language["ADMIN_14"] = "Název webu";
$language["ADMIN_15"] = "Vzhled";
$language["ADMIN_16"] = "Systém webu";
$language["ADMIN_17"] = "Celkově uživatelů";
$language["ADMIN_18"] = "Neaktivovaných uživatelů";
$language["ADMIN_19"] = "Zablokovaných uživatelů";
$language["ADMIN_20"] = "Nejnovější uživatel";
$language["ADMIN_21"] = "Počet příspěvků";
$language["ADMIN_22"] = "Počet statusů";
$language["ADMIN_23"] = "Počet komentářů";
$language["ADMIN_24"] = "Menu";
$language["ADMIN_25"] = "Pluginy";
$language["ADMIN_26"] = "Přídavky pro vylepšení stránek.";
$language["ADMIN_27"] = "Nainstalované pluginy";
$language["ADMIN_28"] = "Autor";
$language["ADMIN_29"] = "Webové stránky";
$language["ADMIN_30"] = "Nainstalovat plugin";
$language["ADMIN_31"] = "Odinstalovat plugin";
$language["ADMIN_32"] = "Nastavení pluginu";
$language["ADMIN_33"] = "Vzhled webu";
$language["ADMIN_34"] = "Vyberte si vzhled, který se vám líbí.";
$language["ADMIN_35"] = "Nastavit tento vzhled";
$language["ADMIN_36"] = "Aktuální vzhled";
$language["ADMIN_37"] = "Nalezené vzhledy";
$language["ADMIN_38"] = "Váš web nyní vypadá nějak takto.";
$language["ADMIN_39"] = "Pokud jsou na webu nahrány nějaké další designy, objeví se zde.";
$language["ADMIN_40"] = "Správa sidebarů";
$language["ADMIN_41"] = "Nový sidebar";
$language["ADMIN_42"] = "Nový sidebar (z pluginu)";
$language["ADMIN_43"] = "Název sidebaru";
$language["ADMIN_44"] = "Obsah sidebaru";
$language["ADMIN_45"] = "Barva sidebaru";
$language["ADMIN_46"] = "Plugin v sidebaru";
$language["ADMIN_47"] = "Nový sidebar";
$language["ADMIN_48"] = "Zpět na správu sidebarů";
$language["ADMIN_49"] = "Vyber plugin";
$language["ADMIN_50"] = "Nebyla vyplněna všechna pole.";
$language["ADMIN_51"] = "Úprava sidebaru";
$language["ADMIN_52"] = "Povolit sidebar";
$language["ADMIN_53"] = "Sem vložte obsah sidebaru..";
$language["ADMIN_54"] = "Smazat sidebar";
$language["ADMIN_55"] = "Upravit sidebar";
$language["ADMIN_56"] = "Opravdu chcete smazat sidebar";
$language["ADMIN_57"] = "Nahlášení";
$language["ADMIN_58"] = "Uživatel";
$language["ADMIN_59"] = "nahlásil uživatele";
$language["ADMIN_60"] = "Nevyřešeno";
$language["ADMIN_61"] = "Nahlášení odesláno";
$language["ADMIN_62"] = "Promazat nahlášení";
$language["ADMIN_63"] = "Opravdu chcete smazat vyřešená nahlášení?";
$language["ADMIN_64"] = "Smazat";
$language["ADMIN_65"] = "Zpět k nahlášení";
$language["ADMIN_66"] = "Vyřešeno";
$language["ADMIN_67"] = "Nahlášený";
$language["ADMIN_68"] = "Nahlásil";
$language["ADMIN_69"] = "Text nahlášení";
$language["ADMIN_70"] = "Nahlášení řešil";
$language["ADMIN_71"] = "Odpovědět uživateli";
$language["ADMIN_72"] = "Text odpovědi, berte na vědomí, že se přiloží i dané nahlášení. Váš text bude pod ním.";
$language["ADMIN_73"] = "uživatele";
$language["ADMIN_74"] = "Nahlášení vyřešeno";
$language["ADMIN_75"] = "Nebyla nalezena zpráva s nahlášením.";
$language["ADMIN_76"] = "Zpráva odeslaná uživateli";
$language["ADMIN_77"] = "Momentálně zde nejsou žádná nahlášení.";
$language["ADMIN_78"] = "Hromadné zprávy";
$language["ADMIN_79"] = "Napište hromadnou zprávu všem uživatelům na webu.";
$language["ADMIN_80"] = "Hromadná zpráva byla úspěšně odeslána.";
$language["ADMIN_81"] = "Obsah";
$language["ADMIN_82"] = "Soubory";
$language["ADMIN_83"] = "Neznámý/zakázaný typ souboru.";
$language["ADMIN_84"] = "Název souboru";
$language["ADMIN_85"] = "Typ souboru";
$language["ADMIN_86"] = "Url adresa souboru";
$language["ADMIN_87"] = "Zpět k seznamu souborů";
$language["ADMIN_88"] = "Smazat soubor";
$language["ADMIN_89"] = "Opravdu chcete smazat soubor";
$language["ADMIN_90"] = "Nahrát soubor";
$language["ADMIN_91"] = "Hlavní nastavení";
$language["ADMIN_92"] = "Název webu";
$language["ADMIN_93"] = "URL Adresa";
$language["ADMIN_94"] = "E-Mailová Adresa";
$language["ADMIN_95"] = "Úvodní strana";
$language["ADMIN_96"] = "Jazyk webu";
$language["ADMIN_97"] = "Ostatní nastavení";
$language["ADMIN_98"] = "Novinek na stránku";
$language["ADMIN_99"] = "Komentářů na stránku";
$language["ADMIN_100"] = "Statusů na stránku";
$language["ADMIN_101"] = "Zpráv na stránku";
$language["ADMIN_102"] = "Přehled celého webu na jedné stránce.";
$language["ADMIN_103"] = "Vlastní stránky";
$language["ADMIN_104"] = "Zde si můžete vytvořit stránky s vlastním obsahem.";
$language["ADMIN_105"] = "Nová stránka";
$language["ADMIN_106"] = "Stránka s příspěvky";
$language["ADMIN_107"] = "Vlastní stránka";
$language["ADMIN_108"] = "Vytvoření nové stránky";
$language["ADMIN_109"] = "Název stránky";
$language["ADMIN_110"] = "Obsah stránky";
$language["ADMIN_111"] = "Sem pište obsah stránky..";
$language["ADMIN_112"] = "Přístupnost stránky";
$language["ADMIN_113"] = "Všem uživatelům";
$language["ADMIN_114"] = "Přihlášeným uživatelům";
$language["ADMIN_115"] = "Vytvořit stránku";
$language["ADMIN_116"] = "Zpět na přehled stránek";
$language["ADMIN_117"] = "Úprava stránky";
$language["ADMIN_118"] = "Uložit stránku";
$language["ADMIN_119"] = "Smazat stránku";
$language["ADMIN_120"] = "Opravdu chcete smazat stránku";
$language["ADMIN_121"] = "Zobrazit";
$language["ADMIN_122"] = "Nastavení menu";
$language["ADMIN_123"] = "Odkaz";
$language["ADMIN_124"] = "Kategorie";
$language["ADMIN_125"] = "Přidat odkaz";
$language["ADMIN_126"] = "Přidat kategorii";
$language["ADMIN_127"] = "Upravit odkaz";
$language["ADMIN_128"] = "Upravit kategorii";
$language["ADMIN_129"] = "Nový odkaz";
$language["ADMIN_130"] = "Název odkazu v menu";
$language["ADMIN_131"] = "Url adresa odkazu";
$language["ADMIN_132"] = "Zpět k nastavení menu";
$language["ADMIN_133"] = "Nová kategorie";
$language["ADMIN_134"] = "Název kategorie";
$language["ADMIN_135"] = "ke kategorii";
$language["ADMIN_136"] = "* Pokud je kategorie prázdná, nezobrazí se.";
$language["ADMIN_137"] = "Styl menu";
$language["ADMIN_138"] = "Úprava odkazu";
$language["ADMIN_139"] = "Úprava kategorie";
$language["ADMIN_140"] = "Úpravit kategorii";
$language["ADMIN_141"] = "Smazat kategorii";
$language["ADMIN_142"] = "Upravit odkaz";
$language["ADMIN_143"] = "Smazat odkaz";
$language["ADMIN_144"] = "Opravdu chcete smazat odkaz";
$language["ADMIN_145"] = "Opravdu chcete smazat kategorii";
$language["ADMIN_146"] = "Nový příspěvek";
$language["ADMIN_147"] = "Obsah příspěvku";
$language["ADMIN_148"] = "Název příspěvku";
$language["ADMIN_149"] = "Vytvořit příspěvek";
$language["ADMIN_150"] = "Zpět na přehled příspěvků";
$language["ADMIN_151"] = "Sem pošte obsah příspěvku..";
$language["ADMIN_152"] = "Obrázek příspěvku";
$language["ADMIN_153"] = "<i>Příspěvek bez názvu</i>";
$language["ADMIN_154"] = "Úprava příspěvku";
$language["ADMIN_155"] = "Upravit příspěvek";
$language["ADMIN_156"] = "Smazat příspěvek";
$language["ADMIN_157"] = "Opravdu chcete smazat příspěvek";
$language["ADMIN_158"] = "Správa uživatelů na webu";
$language["ADMIN_159"] = "Zobrazované jméno";
$language["ADMIN_160"] = "uživ. jméno";
$language["ADMIN_161"] = "Datum registrace";
$language["ADMIN_162"] = "Datum přihlášení";
$language["ADMIN_163"] = "Akce";
$language["ADMIN_164"] = "Upravit profil";
$language["ADMIN_165"] = "Nový uživatel";
$language["ADMIN_166"] = "Aktualizace";
$language["ADMIN_167"] = "Poslední aktualizace";
$language["ADMIN_168"] = "Verze systému";
$language["ADMIN_169"] = "Zkontrolovat aktualizace";
$language["ADMIN_170"] = "Pokud bude nalezena aktualizace, systém se automaticky aktualizuje.";
$language["ADMIN_171"] = "Používáte systém v jeho nejnovější verzi, žádná aktualizace nebyla nalezena.";
$language["ADMIN_172"] = "Byla nalezena aktualizace, systém byl aktualizován.";
$language["ADMIN_173"] = "Proměnná";
$language["ADMIN_174"] = "Hodnota";
$language["ADMIN_175"] = "Uživatelská oprávnění (oddělujte <b>-</b>)";
$language["ADMIN_176"] = "Smazat uživatele";
$language["ADMIN_177"] = "Zablokovat uživatele";
$language["ADMIN_178"] = "IP Adresa";
$language["ADMIN_179"] = "Zpět na přehled uživatelů";
$language["ADMIN_180"] = "Blokace";
$language["ADMIN_181"] = "Zablokovat uživatele";
$language["ADMIN_182"] = "Sem napište důvod banu..";
$language["ADMIN_183"] = "Opravdu chcete smazat uživatele";
$language["ADMIN_184"] = "Ikona stránky";
$language["ADMIN_185"] = "Logo stránky";
$language["ADMIN_186"] = "Keywords stránky <i>(Oddělujte čárkou)</i>";
$language["ADMIN_187"] = "Popis stránky";
$language["ADMIN_188"] = "Správa blokací";
$language["ADMIN_189"] = "Datum";
$language["ADMIN_190"] = "Zatím není zablokován žádný uživatel nebo žádná ip adresa.";
$language["ADMIN_191"] = "Zobrazit blokaci";
$language["ADMIN_192"] = "Zablokovat IP Adresu";
$language["ADMIN_193"] = "Zablokovat uživatele";
$language["ADMIN_194"] = "Zrušit blokaci";
$language["ADMIN_195"] = "Opravdu chcete zrušit blokaci?";
$language["ADMIN_196"] = "Zrušit blokaci";
$language["ADMIN_197"] = "Blokace IP Adresy";
$language["ADMIN_198"] = "Web používá službu Cloudflare (pokud ano, zaškrtněte)";
$language["ADMIN_199"] = "Velikost souborů";
$language["ADMIN_200"] = "Nahraných souborů";
$language["ADMIN_201"] = "Zobrazit všechny soubory";
$language["ADMIN_202"] = "Zobrazit všechny uživatele";
$language["ADMIN_203"] = "Nastavení webu";
$language["ADMIN_204"] = "Poslední aktualizace";
$language["ADMIN_205"] = "Stáhnout poslední aktualizaci znovu";
$language["ADMIN_206"] = "Byla znovu stažena poslední aktualizace.";
$language["ADMIN_B"] = "Zpět";
$language["ADMIN_S"] = "Uložit nastavení";
$language["ADMIN_E01"] = "Chyba - nedostatečná oprávnění";
$language["ADMIN_E02"] = "Pro zobrazení této stránky nemáte dostatečná oprávnění.";
$language["ADMIN_E03"] = "Nebyla vyplněna všechna pole.";
$language["ADMIN_E04"] = "Nevalidní e-mail.";
$language["ADMIN_E05"] = "Všechny hodnoty musí být numerické.";
$language["ADMIN_E06"] = "Nevalidní IP Adresa.";
?>