<?php

// First write all your entries to a PDF file, forcing each entry to fit on one page

// required to load FPDI classes
require_once __DIR__ . '/bootstrap.php';

// Define the maximum containing box width & height for each text box as it will appear on the final page (no padding or margin here)
$pw = 80;
$ph = 110;
$minK = 0.7;    // Maximum scaling factor 0.7 = 70%
$inc = 0.01;    // Increment to change scaling factor 0.05 = 5%
$spacing = 10;    // millimetres (vertically and horizonatlly between boxes in output) shrinks if boxes too big
$border = 3;    // millimetres round final boxes (-1 for no border)
$align = 'T';    // T(op) or M(iddle) for content of final output boxes

// Only change the first parameter of the next line e.g. utf-8
$mpdf = new \Mpdf\Mpdf([
	'format' => [($pw * (1 / $minK)), ($ph * (1 / $minK))],
	'margin_left' => 0,
	'margin_right' => ($pw * (1 / $minK)) - $pw,
	'margin_top' => 0,
	'margin_bottom' => ($ph * (1 / $minK)) - $ph,
	'margin_header' => 0,
	'margin_footer' => 0,
]);

$pph = [];

// FOR EACH ENTRY FOR YOUR YEARBOOK saving the page height in $pph (where $html is the HTML code for the entry):
//	$pph[$i] = SinglePage($html, $pw, $ph, $minK);

//==============================================================
// .. but we will use this for an example

$html1 = '
<style>
div { text-align: justify; }
</style>
<h2>Joanne Smith 2002-2007</h2>
<div>This is the normal text in the div: Nulla felis erat, imperdiet eu, ullamcorper non,
nonummy quis, elit. Suspendisse potenti. Ut a eros orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id
euismod auctor, neque metus pellentesque, <img src="assets/tiger.wmf" width="100" style="float: right; margin: 4px; " />
risus at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus
tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed,
<img src="assets/tiger.jpg" width="100" style="float: left; margin: 4px; " /> nulla. Integer sit amet odio sit amet
lectus luctus euismod. Donec et nulla. Sed quis orci. </div>
';

$html2 = '
<style>
div { text-align: justify; }
</style>
<h2>Tim Another 2001-2007</h2>
<div>This is the normal text in the div: Nulla felis erat, imperdiet eu, ullamcorper non,
nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. et
lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras
odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque,
<img src="assets/tiger.jpg" width="100" style="float: right; margin: 4px; " /> risus at eleifend lacus sapien et risus.
Phasellus metus, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et
nulla. Sed quis orci.  <br />
Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at
eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt
turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer
sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci.</div>
';

for ($i = 1; $i <= 10; $i++) {
	// $html = $html;
	if ($i % 3 == 1) {
		$html = $html2;
	} else {
		$html = $html1;
	}
	$pph[$i] = SinglePage($mpdf, $html, $pw, $ph, $minK); // $pph saves the actual height of each page
}
//==============================================================
// Save the pages to a file
$mpdf->Output('test.pdf', 'F');

// Now collate those pages using IMPORT - 4 pages to one page

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetHeader('{DATE j-m-Y}|My Yearbook 2005|{PAGENO}');
$mpdf->SetFooter('|Printed using mPDF|');

$pagecount = $mpdf->SetSourceFile('test.pdf');

for ($i = 1; $i <= $pagecount; $i++) {

	if ($i % 4 === 1) {
		$mpdf->AddPage();
	}

	$pgheight = $mpdf->h - $mpdf->tMargin - $mpdf->bMargin;
	$hspacing = min($spacing, ($mpdf->pgwidth - $pw * 2));
	$vspacing = min($spacing, ($pgheight - $ph * 2));

	$x1 = $mpdf->lMargin + ($mpdf->pgwidth / 2 - $hspacing / 2 - $pw) / 2;
	$x2 = $mpdf->lMargin + $mpdf->pgwidth / 2 + $hspacing / 2 + ($mpdf->pgwidth / 2 - $hspacing / 2 - $pw) / 2;
	$y1 = $mpdf->tMargin + ($pgheight / 2 - $vspacing / 2 - $ph) / 2;
	$y2 = $mpdf->tMargin + $pgheight / 2 + $vspacing / 2 + ($pgheight / 2 - $vspacing / 2 - $ph) / 2;

	if ($i % 4 == 1) {
		$x = $x1;
		$y = $y1;
	} elseif ($i % 4 == 2) {
		$x = $x2;
		$y = $y1;
	} elseif ($i % 4 == 3) {
		$x = $x1;
		$y = $y2;
	} elseif ($i % 4 == 0) {
		$x = $x2;
		$y = $y2;
	}

	$tplIdx = $mpdf->ImportPage($i);

	if ($align == 'T') {
		$mpdf->useTemplate($tplIdx, $x, $y);
	} else {
		$mpdf->useTemplate($tplIdx, $x, ($y + (($ph - $pph[$i]) / 2)));
	}

	if ($border >= 0) {
		$mpdf->Rect($x - $border, $y - $border, $pw + 2 * $border, $ph + 2 * $border);
	}
}

$mpdf->Output();

$mpdf->cleanup();

unlink('test.pdf');

//==============================================================
function SinglePage(Mpdf\Mpdf $mpdf, $html, $pw, $ph, $minK = 1, $inc = 0.1)
{
	$mpdf->AddPage('', '', '', '', '', '', ($mpdf->w - $pw), '', ($mpdf->h - $ph), 0, 0);
	$k = 1;

	$currpage = $mpdf->page;
	$mpdf->WriteHTML($html);

	$newpage = $mpdf->page;
	while ($currpage != $newpage) {

		for ($u = 0; $u <= ($newpage - $currpage); $u++) {

			// DELETE PAGE - the added page
			unset($mpdf->pages[$mpdf->page]);

			if (isset($mpdf->ktAnnots[$mpdf->page])) {
				unset($mpdf->ktAnnots[$mpdf->page]);
			}
			if (isset($mpdf->tbrot_Annots[$mpdf->page])) {
				unset($mpdf->tbrot_Annots[$mpdf->page]);
			}
			if (isset($mpdf->kwt_Annots[$mpdf->page])) {
				unset($mpdf->kwt_Annots[$mpdf->page]);
			}
			if (isset($mpdf->PageAnnots[$mpdf->page])) {
				unset($mpdf->PageAnnots[$mpdf->page]);
			}
			if (isset($mpdf->PageLinks[$mpdf->page])) {
				unset($mpdf->PageLinks[$mpdf->page]);
			}
			if (isset($mpdf->pageoutput[$mpdf->page])) {
				unset($mpdf->pageoutput[$mpdf->page]);
			}

			// Go to page before  - so can addpage
			$mpdf->page--;
		}

		// mPDF 2.4 Float Images
		if (count($mpdf->floatbuffer)) {
			$mpdf->objectbuffer[] = $mpdf->floatbuffer['objattr'];
			$mpdf->printobjectbuffer(FALSE);
			$mpdf->objectbuffer = [];
			$mpdf->floatbuffer = [];
		}

		$k += $inc;
		if ((1 / $k) < $minK) {
			die("Page no. " . $mpdf->page . " is too large to fit");
		}

		$w = $pw * $k;
		$h = $ph * $k;

		$mpdf->_beginpage('', '', ($mpdf->w - $w), '', ($mpdf->h - $h));
		$currpage = $mpdf->page;

		$mpdf->_out('2 J');
		$mpdf->_out('0 w');
		$mpdf->SetFont($mpdf->default_font, '', $mpdf->default_font_size, TRUE, TRUE);    // forces write
		$mpdf->SetDrawColor(0);
		$mpdf->SetFillColor(255);
		$mpdf->SetTextColor(0);
		$mpdf->ColorFlag = FALSE;

		// Start Transformation
		$mpdf->StartTransform();
		$mpdf->transformScale((100 / $k), (100 / $k), 0, 0);

		$mpdf->WriteHTML($html);

		$newpage = $mpdf->page;

		//Stop Transformation
		$mpdf->StopTransform();
	}

	return ($mpdf->y / $k);
}
