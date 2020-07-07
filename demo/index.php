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
	'query' => isset($_REQUEST['search']) ? $_REQUEST['search'] : 'pub crawl budapest',
	'limit' => isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 3,
	'location' => isset($_REQUEST['location']) ? $_REQUEST['location'] :'London, United Kingdom'
];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Demo</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<?php if (isset($_REQUEST['search'])): $results = new SearchResults($opts); ?>
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
	<?php else: ?>
		<form action="" method="GET">
			<label for="search">Search:</label> <input type="text" name="search">
			<label for="limit">Limit:</label> <input type="number" name="limit">
			<label for="location">Location:</label> <input type="text" name="location">
			<input type="submit">
		</form>
		<script type="text/javascript">
			$('input[name=location]').autocomplete({
		      source: "autocomplete.php",
		      minLength: 2,
		      select: console.log
		    })
		</script>
	<?php endif; ?>
</body>
</html>