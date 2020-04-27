# PHP-Search-Results

A convenient way to get SERPs for further processing. Supports only Google currently, will become extendable in the future.

## Installation

Install via either Composer or by downloading the repository locally. Note: this package requires [DOM_Extractor](https://github.com/ppajer/PHP-DOM-Extractor) to work, so if installing manually, you will need to include the extractor yourself.

## Usage

Simply include the required files and provide a search query to get the latest results. It implements the `Iterator` interface so loops are directly possible on the class itself.

```

require 'class.DOM_Extractor.php';
require 'class.SearchResults.php';

$search = 'Budapest';
$serps = new SearchResults($search);

foreach ($serps as $position => $result) {
	echo "Result URL #$position:".$result['link'];
}

```

### Limit

By default this package will only get the first SERP for performance reasons. If you need more pages included in your results, pass the required number as second argument to the constructor.

```

new SearchResults($search, 3);

```