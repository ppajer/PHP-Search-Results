<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Budapest');

require '../lib/HTML5DOMDocument/Internal/QuerySelectors.php';
require '../lib/HTML5DOMDocument.php';
require '../lib/HTML5DOMElement.php';
require '../lib/HTML5DOMNodeList.php';
require '../lib/HTML5DOMTokenList.php';
require '../lib/class.DOM_Extractor.php';
require '../lib/class.Request.php';
require '../lib/class.ParallelRequest.php';
require '../lib/class.WebScraper.php';
require '../class.SearchResults.php';

$opts = [
	'query' => isset($_GET['search']) ? $_GET['search'] : 'pub crawl budapest',
	'limit' => 3,
	'location' => 'London, United Kingdom'
];

$results = new SearchResults($opts);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Demo</title>
</head>
<body>
	<table>
		<h1>Search results for: "<?php echo $opts['query']; ?>"</h1>
		<tr>
			<th>Position</th>
			<th>Title</th>
			<th>Description</th>
			<th>Link</th>
		</tr>
		<?php foreach($results->get() as $result):?>
		<tr>
			<td><?php echo $result['position']; ?></td>
			<td><?php echo $result['title']; ?></td>
			<td><?php echo $result['description']; ?></td>
			<td><?php echo $result['link']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>