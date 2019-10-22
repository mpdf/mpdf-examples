<?php

$html = '
<h1>mPDF</h1>
<h2>Annotations</h2>

<h3>
	Heading 3
	<annotation content="This is an annotation' . "\n" . 'in the middle of the text"
		subject="My Subject" icon="Comment" color="#FE88EF" author="Ian Back" />
</h3>

<h4>Heading 4</h4>

<p>P: Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula
vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. <i>Fusce</i>

<annotation content="Fusce is a funny word!" subject="Idle Comments" icon="Note" author="Ian Back" pos-x="195" />

eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio.
Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at <span title="This annotation was automatically
defined from the title attribute of a span element">eleifend</span> lacus sapien et risus. Phasellus metus. Phasellus
feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien.
Mauris ante pede, auctor ac, suscipit quis, malesuada</p>

<p> Note that since mPDF v7.0.0, embedded annotation files must be explicitly allowed by setting
<code>allowAnnotationFiles</code> configuration key to true. Otherwise, the file attribute of <code>annotation</code> tag
will be ignored.

<annotation file="assets/tiger.jpg" content="This is a file attachment (embedded file)
Double-click to open attached file
Right-click to save file on your computer" icon="Graph" title="Attached File: assets/tiger.jpg" pos-x="195" />

</p>
';

require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'c', 'allowAnnotationFiles' => true]);

$mpdf->title2annots = true;

$mpdf->WriteHTML($html);

$mpdf->Annotation("File annotation", 0, 0, 'Note', '', '', 0, false, '', 'assets/tiger.jpg');

$mpdf->Output();
