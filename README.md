# SearchResults 

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
	public static function autocompleteSearchLocation(String $query) : Array<String> // Returns an array of search locations
}
```

## Usage

Simply include the required files and provide search options to the constructor. These include: `query`, `limit` and `location`. 

```(php)
require 'Webscraper.php';
require 'SearchResults.php';

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
// Returns an array of SearchResult objects
// Results will have 5 and 2 pages respectively, from different locations.
```

### Location support

The libraray includes a list of all canonical names supported by Google. You can use this list to find the canonical name of the location you're interested in. The list is quite large (74000 entries), so it is useful to offer autocomplete functionality to your users. You can do so by using your frontend solution of choice, coupled with the `autocompleteSearchLocation()` method on the backend. 

To improve search speed and reduce memory usage, a simplified list is also provided - this trades precision for reduced size, with only 200 entries that should suit most low-precision location needs. Simply pass an optional parameter to the autocomplete method to fetch the simplified list.

```(php)

// This will listen to requests containing the q parameter and automatically return it to the browser
SearchResults::autocompleteSearchLocation();

// This does the same thing, but searched from the simplified list for improved speed
SearchResults::autocompleteSearchLocation(true);
```