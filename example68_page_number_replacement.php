<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 16,
	'defaultPageNumStyle' => 'a',
]);

$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');

for ($i = 0; $i < 24; $i++) {
	$mpdf->WriteHtml('<p>S večerem zhoustla mlha sychravého dne. Je ti, jako by ses protlačoval řídkou
vlhkou hmotou, jež se za tebou neodvratně zavírá. Chtěl bys být doma. Doma, u
své lampy, v krabici čtyř stěn. Nikdy ses necítil tak opuštěn.
Prokop si razí cestu po nábřeží. Mrazí ho a čelo má zvlhlé potem slabosti;
chtěl by si sednout tady na té mokré lavičce, ale bojí se strážníků. Zdá se
mu, že se motá; ano, u Staroměstských mlýnů se mu někdo vyhnul obloukem jako
opilému. Nyní tedy vynakládá veškeru sílu, aby šel rovně. Teď, teď jde proti
němu člověk, má klobouk do očí a vyhrnutý límec. Prokop zatíná zuby, vraští
čelo, napíná všechny svaly, aby bezvadně přešel. Ale zrovna na krok před
chodcem se mu udělá v hlavě tma a celý svět se s ním pojednou zatočí; náhle
vidí zblízka, zblizoučka pár pronikavých očí, jak se do něho vpíchly, naráží
na něčí rameno, vypraví ze sebe cosi jako „promiňte“ a vzdaluje se s
křečovitou důstojností. Po několika krocích se zastaví a ohlédne; ten člověk
stojí a dívá se upřeně za ním. Prokop se sebere a odchází trochu rychleji; ale
nedá mu to, musí se znovu ohlédnout; a vida, ten člověk ještě pořád stojí a
dívá se za ním, dokonce samou pozorností vysunul z límce hlavu jako želva. „Ať
kouká,“ myslí si Prokop znepokojen, „teď už se ani neohlédnu.“' . ' {nb}, {nbpg}, {PAGENO}</p>');
}

$mpdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" />');

for ($i = 0; $i < 24; $i++) {
	$mpdf->WriteHtml('<p>„Vybuchlo. Jen takový nálet, jen prášek, co jsem utrousil. Ani to vidět
nebylo. Tuhle – žárovka – kilometr dál. Ta to nebyla. A já – v lenošce, jako
kus dřeva. Víš, unaven. Příliš práce. A najednou… prásk! Já letěl na zem. Okna
to vyrazilo a – žárovka pryč. Detonace jako – jako když bouchne lydditová
patrona. Stra-strašná brizance. Já – já nejdřív myslel, že praskla ta por-
porcená – ponce – por-ce-lánová, polcelánová, porcenálová, poncelár, jak se to
honem, to bílé, víte, izolátor, jak se to jmenuje? Kře-mi-čitan hlinitý.“
„Porcelán.“' . ' {nb}, {nbpg}, {PAGENO}</p>');
}

$mpdf->Output();
die;
