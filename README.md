# PHP-Search-Results

A convenient way to get SERPs for further processing. Supports only Google currently, will become extendable in the future.

## Requirements

- PHP7+
- [WebScraper](https://github.com/ppajer/WebScraper) (part of the composer package)
- [DOM Extractor](https://github.com/ppajer/PHP-DOM-Extractor) (bundled with WebScraper)
- [Request](https://github.com/ppajer/PHP-Request) (bundled with WebScraper)

## Installation

Install via either Composer or by downloading the repository locally. Note: this package requires [WebScraper](https://github.com/ppajer/WebScraper) to work, so if installing manually, you will need to include the scraper and its dependencies ([DOM Extractor](https://github.com/ppajer/PHP-DOM-Extractor) and [Request](https://github.com/ppajer/PHP-Request)) manually.

## Methods and properties

```(php)
class SearchResults {
	
	public $query : String 	// The search term for the results
	public $limit : Int 		// The number of pages to fetch. Default: 1
	public $location : String|null // A canonical location name.
	public $results : Array 	// The search results.

	public function __construct__(Array $args) : // Where $args is an Array with 'query', 'limit' and 'location' as possible keys.
	public function get() : Array<Array> // Returns the results
	public static function getMultiple(Array $args) : Array<SearchResults> // Returns an array of SearchResult objects
}
```

## Usage

Simply include the required files and provide search options to the constructor. These include: `query`, `limit` and `location`. 

```(php)
require 'class.DOM_Extractor.php';
require 'class.SearchResults.php';

$search = [
	'query' => 'Budapest', // The query to search
	'limit' => 3 // Number of pages fetched
	'location' => 'New York, United States' // The location to show searches from
	];
$serps = new SearchResults($search);

foreach ($serps as $position => $result) {
	echo "Result URL #$position:".$result['link'];
}
```

### Multiple keywords

You can also query for an array of keywords by using the `getMultiple()` method. It accepts an array of arrays similar to the one expected by the constructor.

```(php)
$multipleWithLimits = [
	[
		'query' => 'Budapest',
		'limit' => 5
	],
	[
		'query' => 'Sopron',
		'limit' => 2,
		'location' => 'London, United Kingdom'
	]
];

$results = SearchResults::getMultiple($multipleWithLimits);
// Returns an array of SearchResult objects that can be looped over.
// Results will have 5 and 2 pages respectively, from different locations.
```