<?php
/**
 * Internationalisation file for FlaggedRevs extension, section RatingHistory
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'ratinghistory'         => 'Page rating history',
	'ratinghistory-text'    => '\'\'\'This page displays article rating data for [[:$1|$1]].\'\'\'',
	'ratinghistory-leg'     => 'Rating history data',
	'ratinghistory-tab'     => 'rating',
	'ratinghistory-thanks'  => '\'\'\'\'\'<font color="darkred">Thank you for taking a moment to review this page!</font>\'\'\'\'\'',
	'ratinghistory-period'  => 'Time period:',
	'ratinghistory-month'   => 'last month',
	'ratinghistory-year'    => 'last year',
	'ratinghistory-3years'  => 'last 3 years',
	'ratinghistory-graph'   => 'Review data from $1 {{PLURAL:$1|reader|readers}}',
	'ratinghistory-none'    => 'There is not enough reader feedback data available for graphs at this time.',
	'ratinghistory-legend'  => 'The daily average rating <font color="blue">\'\'(blue)\'\'</font> and selected interval 
	average rating <font color="green">\'\'(green)\'\'</font> are graphed below, by date. The rating values are to be interpreted as follows:
	
\'\'\'[0]\'\'\' - Poor; \'\'\'[1]\'\'\' - Low; \'\'\'[2]\'\'\' - Fair; \'\'\'[3]\'\'\' - High; \'\'\'[4]\'\'\' - Excellent;',

	'right-feedback' => 'Use the feedback form to rate a page',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'ratinghistory-text' => "'''Translate 'page' instead of 'article'!'''",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'ratinghistory' => 'تاريخ تقييم الصفحة',
	'ratinghistory-text' => "'''هذه الصفحة تعرض بيانات تقييم المقالة ل[[:$1|$1]].'''",
	'ratinghistory-leg' => 'بيانات تقييم التاريخ',
	'ratinghistory-tab' => 'تقييم',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">شكرا لك لاستغراقك دقيقة لمراجعة هذه الصفحة!</font>'''''",
	'ratinghistory-period' => 'فترة زمنية:',
	'ratinghistory-month' => 'آخر شهر',
	'ratinghistory-year' => 'آخر سنة',
	'ratinghistory-3years' => 'آخر 3 سنوات',
	'ratinghistory-graph' => 'بيانات المراجعة من $1 {{PLURAL:$1|قارئ|قارئ}}',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات في هذا الوقت.',
	'ratinghistory-legend' => "التقييم اليومي المتوسط <font color=\"blue\">''(أزرق)''</font> والتقييم المتوسط للفترة
المختارة <font color=\"green\">''(أخضر)''</font> مرسومة بالأسفل، حسب التاريخ. قيم التقييم يتم تفسيرها كالتالي:

'''[0]''' - فقير؛ '''[1]''' - منخفض؛ '''[2]''' - معقول؛ '''[3]''' - مرتفع؛ '''[4]''' - ممتاز؛",
	'right-feedback' => 'استخدام استمارة الآراء لتقييم صفحة',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'ratinghistory' => 'تاریح درجه بندی صفحه',
	'ratinghistory-text' => "'''ای صفحه دیتای درجه په [[:$1|$1]] پیش داریت.'''",
	'ratinghistory-leg' => 'درجه بندی دیتای تاریح',
	'ratinghistory-tab' => 'درجه',
	'ratinghistory-period' => 'مدت زمان:',
	'ratinghistory-month' => 'پیشگین ماه',
	'ratinghistory-year' => 'پار',
	'ratinghistory-3years' => '۳ سال پیسرتر',
	'ratinghistory-none' => 'نظرات کاربری کافی په شرکتن گراف تا ای زمان نیستن',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ratinghistory-tab' => 'рейтинг',
	'ratinghistory-period' => 'Период от време:',
	'ratinghistory-month' => 'последния месец',
	'ratinghistory-year' => 'последната година',
	'ratinghistory-3years' => 'последните 3 години',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'ratinghistory' => 'Verlauf der Seitenbewertung',
	'ratinghistory-text' => "'''Diese Seite zeigt die Bewertung für [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Verlauf der Seitenbewertung',
	'ratinghistory-tab' => 'Bewertung',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Danke, dass du dir einen Moment Zeit genommen hast für die Bewertung der Seite!</font>'''''",
	'ratinghistory-period' => 'Zeitraum:',
	'ratinghistory-month' => 'letzter Monat',
	'ratinghistory-year' => 'letztes Jahr',
	'ratinghistory-3years' => 'letzte drei Jahre',
	'ratinghistory-graph' => 'Bewertungsdaten von $1 {{PLURAL:$1|Leser|Lesern}}',
	'ratinghistory-none' => 'Es gibt noch nicht genug Seitenbewertungen durch Leser, um eine Grafik zu erstellen.',
	'ratinghistory-legend' => "Der Bewertungs-Tagesdurchschnitt <font color=\"blue\">''(blau)''</font> und der Durchschnitt über den ausgewählten Zeitraum <font color=\"green\">''(grün)''</font> werden nachfolgend nach Datum sortiert angezeigt.
Die Bewertungszahlen bedeuten:
	
'''[0]''' - Mangelhaft; '''[1]''' - Ausreichend; '''[2]''' - Befriedigend; '''[3]''' - Gut; '''[4]''' - Sehr gut;",
	'right-feedback' => 'Bewerten einer Seite',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'ratinghistory' => 'Historio de paĝtaksado',
	'ratinghistory-text' => "'''Ĉi tiu paĝo montras datenojn de taksado por [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Datenoj de taksada historio',
	'ratinghistory-tab' => 'taksado',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Dankon pro via peno por kontroli ĉi tiun paĝon!</font>'''''",
	'ratinghistory-period' => 'Tempdaŭro:',
	'ratinghistory-month' => 'lasta monato',
	'ratinghistory-year' => 'lasta jaro',
	'ratinghistory-3years' => 'lastaj 3 jaroj',
	'ratinghistory-graph' => 'Kontroli datenojn de $1 {{PLURAL:$1|leginto|legintoj}}',
	'ratinghistory-none' => 'Ne sufiĉas datenoj de legintoj por grafeoj ĉi-momente.',
	'ratinghistory-legend' => "La tage averaĝa taksado <font color=\"blue\">''(blua)''</font> kaj selektita 
intervalaveraĝo <font color=\"green\">''(verda)''</font> estas montrita en la jena grafeo, laŭ dato. 
La taksadaj valoroj estas interpretaj jene:

'''[0]''' - Malbonega; '''[1]''' - Malbonkvalita; '''[2]''' - Mezkvalita; '''[3]''' - Bonkvalita; '''[4]''' - Bonega;",
	'right-feedback' => 'Uzu la kontrolan sekcion por kontroli paĝon',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'ratinghistory' => 'Historique de la notation de la page',
	'ratinghistory-text' => "'''Cette page affiche les données de notation d’article pour [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Données de l’historique de la notation',
	'ratinghistory-tab' => 'notation',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Merci pour nous avoir consacré du temps pour relire cette page !</font>'''''",
	'ratinghistory-period' => 'Période :',
	'ratinghistory-month' => 'dernier mois',
	'ratinghistory-year' => 'dernière année',
	'ratinghistory-3years' => 'les 3 dernières années',
	'ratinghistory-graph' => 'Revoir les donnée à partir de $1 {{PLURAL:$1|lecteur|lecteurs}}',
	'ratinghistory-none' => 'En ce moment, il n’y a pas assez de lecteurs de données de notation pour les graphiques.',
	'ratinghistory-legend' => "Les quotations journalières <font color=\"blue\">''(bleu)''</font> et les intervales de quotation choisis <font color=\"green\">''(vert)''</font> de la notation sont dessinés ci-dessous, par date. les valeurs des notations doivent être interprétées comme suit :

'''[0]''' - Mauvais ; '''[1]''' - Médiocre ; '''[2]''' - Moyen ; '''[3]''' - Bon ; '''[4]''' - Excellent ;",
	'right-feedback' => 'Utiliser le formulaire de soumission pour noter une page',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'ratinghistory' => 'Historial de valoracións da páxina',
	'ratinghistory-text' => "'''Esta páxina amosa os datos da valoración de [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Historial de valoracións dos datos',
	'ratinghistory-tab' => 'valoración',
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mes',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos 3 anos',
	'ratinghistory-legend' => "A valoración do promedio diario <font color=\"blue\">''(azul)''</font> e o intervalo seleccionado <font color=\"green\">''(verde)''</font> serán postos, por data, na gráfica de embaixo. O número de revisións é amosado no
recanto superior dereito das gráficas; os valores máis altos tratan de indicar os mellores datos de mostra. Os valores da valoración serán interpretados da seguinte maneira:

'''[0]''' - Pobre; '''[1]''' - Baixo; '''[2]''' - Ben; '''[3]''' - Alto; '''[4]''' - Excelente;",
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Samat
 */
$messages['hu'] = array(
	'ratinghistory' => 'Értékelési történet',
	'ratinghistory-text' => "'''A(z) [[:$1|$1]] lap értékelési adatai:'''",
	'ratinghistory-leg' => 'Értékelési előzmények adatai',
	'ratinghistory-tab' => 'értékelés',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Köszönjük, hogy időt szántál az oldal értékelésére!</font>'''''",
	'ratinghistory-period' => 'Időszak:',
	'ratinghistory-month' => '1 hónap',
	'ratinghistory-year' => '1 év',
	'ratinghistory-3years' => '3 év',
	'ratinghistory-none' => 'Jelenleg még nem áll rendelkezésre elég visszajelzés a grafikonok elkészítéséhez.',
	'ratinghistory-legend' => "Alább a napi átlagos értékelés <font color=\"blue\">''(kék színnel)''</font> és a megadott időtartamra átlagos értékelés <font color=\"green\">''(zöld színnel)''</font> ábrája látható, dátum szerint. Az összes értékelés száma a jobb felső sarokban látható. A grafikon nagyobb értékei jobb minőséghez tartoznak, magyarázatuk a következő:

'''[0]''' - Rossz; '''[1]''' - Gyenge; '''[2]''' - Közepes; '''[3]''' - Jó; '''[4]''' - Kitűnő;",
	'right-feedback' => 'oldalak értékelése a visszajelzés-űrlap segítségével',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'ratinghistory' => 'Sejarah penilaian halaman',
	'ratinghistory-text' => "'''Halaman ini menampilkan data penilaian artikel untuk [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Data sejarah penilaian',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Terima kasih Anda telah meninjau halaman ini!</font>'''''",
	'ratinghistory-period' => 'Periode waktu:',
	'ratinghistory-month' => 'bulan lalu',
	'ratinghistory-year' => 'tahun lalu',
	'ratinghistory-3years' => '3 tahun terakhir',
	'ratinghistory-none' => 'Belum ada cukup umpan balik pembaca tersedia untuk membuat grafik pada saat ini.',
	'ratinghistory-legend' => "Rata-rata harian penilaian <font color=\"blue\">''(biru)''</font> dan interval rata-rata penilaian yang dipilih <font color=\"green\">''(hijau)''</font> ditampilkan dalam grafik di bawah ini, menurut tanggal.
Penilaian dapat ditafsirkan sebagai berikut:

'''[0]''' - Buruk; '''[1]''' - Rendah; '''[2]''' - Sedang; '''[3]''' - Tinggi; '''[4]''' - Baik sekali;",
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Grazie per aver dedicato un momento al giudizio di questa pagina!</font>'''''",
	'ratinghistory-period' => 'Periodo di tempo:',
	'ratinghistory-month' => 'ultimo mese',
	'ratinghistory-year' => 'ultimo anno',
	'ratinghistory-3years' => 'ultimi 3 anni',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'ratinghistory-month' => 'ខែមុន',
	'ratinghistory-year' => 'ឆ្នាំមុន',
	'ratinghistory-3years' => '៣ឆ្នាំមុន',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ratinghistory-period' => 'Zäitraum:',
	'ratinghistory-month' => 'leschte Mount',
	'ratinghistory-year' => 'lescht Joer',
	'ratinghistory-3years' => 'lescht 3 Joer',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'ratinghistory' => 'Sejarah penilaian laman',
	'ratinghistory-text' => "'''Berikut ialah data penilaian bagi laman [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Data sejarah penilaian',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Terima kasih kerana sudi meluangkan masa untuk memeriksa laman ini!</font>'''''",
	'ratinghistory-period' => 'Tempoh masa:',
	'ratinghistory-month' => 'bulan lepas',
	'ratinghistory-year' => 'tahun lepas',
	'ratinghistory-3years' => '3 tahun lepas',
	'ratinghistory-none' => 'Data maklum balas pembaca belum cukup untuk penghasilan graf.',
	'ratinghistory-legend' => "Berikut ialah graf penilaian purata harian <font color=\"blue\">''(biru)''</font> dan penilaian purata selang yang dipilih <font color=\"green\">''(hijau)''</font> mengikut tarikh. Jumlah pemeriksaan ditunjukkan di bucu kanan atas. Nilai tinggi menandakan data sampel yang lebih baik. Berikut ialah pentafsiran tahap penilaian:

'''[0]''' - Lemah, '''[1]''' - Rendah, '''[2]''' - Sederhana, '''[3]''' - Tinggi, '''[4]''' - Cemerlang",
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'ratinghistory' => 'Geschiedenis paginawaardering',
	'ratinghistory-text' => "'''Hier worden waarderingen voor de pagina [[:$1|$1]] weergegeven.'''",
	'ratinghistory-leg' => 'Historische waarderingsgegevens',
	'ratinghistory-tab' => 'waardering',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Dank u wel voor de moeite die u hebt genomen om deze pagina te waarderen!</font>'''''",
	'ratinghistory-period' => 'Tijdsperiode:',
	'ratinghistory-month' => 'afgelopen maand',
	'ratinghistory-year' => 'afgelopen jaar',
	'ratinghistory-3years' => 'afgelopen 3 jaar',
	'ratinghistory-graph' => 'Paginawaardering van {{PLURAL:$1|lezer|lezers}}',
	'ratinghistory-none' => 'Er is onvoldoende terugkoppeling van lezers aanwezig om een grafiek te maken.',
	'ratinghistory-legend' => "De dagelijkse gemiddelde waardering <font color=\"blue\">''(blauw)''</font> en de gemiddelde waardering van de aangegeven periode <font color=\"green\">''(groen)''</font> staan hieronder in een grafiek op datum.
De waarderingen dienen als volgt gelezen te worden:

'''[0]''' - Slecht; '''[1]''' - Laag; '''[2]''' - Redelijk; '''[3]''' - Hoog; '''[4]''' - Uitstekend;",
	'right-feedback' => 'Het waarderingsformulier gebruiken om een pagina te waarderen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'ratinghistory' => 'Sidens vurderingshistorikk',
	'ratinghistory-text' => "'''Denne sider viser vurderingsdata for [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Vurderingshistorikkdata',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Takk for at du tar deg tid til å anmelde denne siden!</font>'''''",
	'ratinghistory-period' => 'Tidsperiode:',
	'ratinghistory-month' => 'siste måned',
	'ratinghistory-year' => 'siste år',
	'ratinghistory-3years' => 'siste tre år',
	'ratinghistory-none' => 'Det er ikke nok leservurderinger til å vise grafer ennå.',
	'ratinghistory-legend' => "'''[0]''' &ndash; Veldig dårlig; '''[1]''' &ndash; Dårlig; '''[2]''' &ndash; OK; '''[3]''' &ndash; Bra; '''[4]''' &ndash; Veldig bra;",
	'right-feedback' => 'Bruke tilbakemeldingsskjemaet for å vurdere en side',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'ratinghistory' => 'Istoric de la notacion de la pagina',
	'ratinghistory-text' => "'''Aquesta pagina aficha las donadas de notacion d’article per [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Donadas de l’istoric de la notacion',
	'ratinghistory-tab' => 'notacion',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Mercés de nos aver consacrat de temps per tornar legir aquesta pagina !</font>'''''",
	'ratinghistory-period' => 'Periòde :',
	'ratinghistory-month' => 'darrièr mes',
	'ratinghistory-year' => 'darrièra annada',
	'ratinghistory-3years' => 'las 3 darrièras annadas',
	'ratinghistory-graph' => 'Tornar veire las donadas a partir de $1 {{PLURAL:$1|lector|lectors}}',
	'ratinghistory-none' => 'En aqueste moment, i a pas pro de lectors de donadas de notacion pels grafics.',
	'ratinghistory-legend' => "Las quotacions jornalièras <font color=\"blue\">''(blau)''</font> e los intervals de quotacion causits <font color=\"green\">''(vèrd)''</font> de la notacion son dessenhats çaijós, per data. Las valors de notacions devon èsser interpretadas coma seguís :

'''[0]''' - Marrit ; '''[1]''' - Mediòcre ; '''[2]''' - Mejan ; '''[3]''' - Bon ; '''[4]''' - Excellent ;",
	'right-feedback' => 'Utilizar lo formulari de somission per notar una pagina',
);

/** Portuguese (Português)
 * @author 555
 */
$messages['pt'] = array(
	'ratinghistory' => 'Histórico de avaliações da página',
	'ratinghistory-text' => "'''Esta página mostra os dados de avaliação de página de [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Histórico de dados de avaliações',
	'ratinghistory-tab' => 'avaliação',
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mês',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos três anos',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'ratinghistory' => 'História hodnotenia stránky',
	'ratinghistory-text' => "'''Táto stránka zobrazuje údaje o hodnotení článku [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Údaje o hodnotení v čase',
	'ratinghistory-tab' => 'hodnotenie',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Ďakujeme, že ste si našli chvíľu na ohodnotenie tejto stránky!</font>'''''",
	'ratinghistory-period' => 'Časové obdobie:',
	'ratinghistory-month' => 'posledný mesiac',
	'ratinghistory-year' => 'posledný rok',
	'ratinghistory-3years' => 'posledné 3 roky',
	'ratinghistory-graph' => 'Skontrolovať údaje od $1 {{PLURAL:$1|čitateľa|čitateľov}}',
	'ratinghistory-none' => 'Momentálne nie je dostupný dostatok údajov o spätnej väzbe používateľov nato, aby bolo možné vytvoriť grafy.',
	'ratinghistory-legend' => "Dolu je podľa dátumu zobrazené denné priemerné hodnotenie <font color=\"blue\">''(modrou)''</font> a priemer vybraného intervalu  
<font color=\"green\">''(zelenou)''</font>. Hodnoty hodnotenia sa interpretujú nasledovne:

'''[0]''' - Slabé; '''[1]''' - Nízke; '''[2]''' - Dobré; '''[3]''' - Vysoké; '''[4]''' - Výborné;",
	'right-feedback' => 'Stránku ohodnotíte pomocou formulára spätnej väzby',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'ratinghistory' => 'Историја оцена стране.',
	'ratinghistory-text' => "'''Ова страна приказује податке оцењивања чланка за страну \"[[:\$1|\$1]]\".'''",
	'ratinghistory-leg' => 'Историја оцењивања.',
	'ratinghistory-tab' => 'оцена',
	'ratinghistory-period' => 'Раздобље:',
	'ratinghistory-month' => 'последњи месец',
	'ratinghistory-year' => 'последња година',
	'ratinghistory-3years' => 'последње три године',
	'ratinghistory-none' => 'Не постоје доступне оцене читалаца у овом тренутку.',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'ratinghistory' => 'Sidans betygshistorik',
	'ratinghistory-text' => "'''Denna sida visar artikelbetygsdata för [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Betygshistorikdata',
	'ratinghistory-tab' => 'betyg',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Tack för att du tog dig tid att granska den här sidan!</font>'''''",
	'ratinghistory-period' => 'Tidsperiod:',
	'ratinghistory-month' => 'senaste månaden',
	'ratinghistory-year' => 'senaste året',
	'ratinghistory-3years' => 'senaste 3 åren',
	'ratinghistory-graph' => 'Granska data från $1 {{PLURAL:$1|läsare|läsare}}',
	'ratinghistory-none' => 'Det finns för närvarande inte tillräckligt med feedbackdata tillgängligt från läsarna för grafer.',
	'ratinghistory-legend' => "Betyg för dagens genomsnitt <font color=\"blue\">''(blå)''</font> och genomsnitt för valt intervall <font color=\"green\">''(grön)''</font> kommer att visas i grafform nedan, efter datum. Betygsvärdena tolkas enligt följande:

'''[0]''' - Mycket dålig; '''[1]''' - Dålig; '''[2]''' - Okej; '''[3]''' - Bra; '''[4]''' - Mycket bra;",
	'right-feedback' => 'Använd feedback-formuläret för att betygsätta en sida',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ratinghistory' => 'Lịch sử đánh giá trang',
	'ratinghistory-text' => "'''Trang này chứa dữ liệu đánh giá của trang [[:$1|$1]].'''",
	'ratinghistory-leg' => 'Dữ liệu lịch sử đánh giá',
	'ratinghistory-tab' => 'đánh giá',
	'ratinghistory-thanks' => "'''''<font color=\"darkred\">Cám ơn đã để dành một chút thời gian để duyệt trang này!</font>'''''",
	'ratinghistory-period' => 'Thời gian:',
	'ratinghistory-month' => 'tháng trước',
	'ratinghistory-year' => 'năm ngoái',
	'ratinghistory-3years' => 'ba năm trước',
	'ratinghistory-graph' => 'Dữ liệu đánh giá tính vào $1 độc giả',
	'ratinghistory-none' => 'Hiện chưa có đủ dữ liệu đánh giá của độc giả để vẽ biểu thị.',
	'ratinghistory-legend' => "Biểu thị ở dưới trình bày đánh giá trung bình hàng ngày <font color=\"blue\">''(lam)''</font> và đánh giá trung bình tại các giai đoạn lựa chọn <font color=\"green\">''(lục)''</font>, theo thời gian. Các đánh giá có các giá trị sau:

'''[0]''' – Tệ; '''[1]''' – Dở; '''[2]''' – Vừa; '''[3]''' – Khá; '''[4]''' – Tốt",
	'right-feedback' => 'Đánh giá trang',
);

