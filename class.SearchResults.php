<?php

class SearchResults implements Iterator {

	public $query;
	public $limit;
	public $results = array();
	
	private $nextLink = null;
	private $lastPosition = 1;
	private $lastPage = 0;
	private $index = 0;

	private $endpoint = 'http://www.google.com/';
	
	private $DOM = null;
	private $rules = array(
			'results' => array(
				'@selector' => "//div[@class='g']",
				'@each' => array(
					'title'=> array('@selector' => "//h3"),
					'description' => array("@selector" => "//span[@class='st']"),
					'link'=> array(
						'@selector' => "//a",
						'@attr' => 'href'
						)
					)
				),
			'next' => array(
				'@selector' =>"//a[@id='pnnext']",
				'@attr' => 'href'
				)
		);
	private $errors;

	public function __construct($query, $limit = 1, $errors = false) {
		
		$this->query = $query;
		$this->limit = $limit;
		$this->errors = $errors;
		$this->DOM = new DOM_Extractor($this->rules);
	}

	public function get() {
		$this->getResultPageRecursive($this->endpoint.'search?q='.$this->query);
		return $this->results;
	}

	private function parseDOM($html) {

		$data = $this->DOM->load($html)->parse();
		$this->lastPage++;
		$this->nextLink = $data['next'];

		foreach ($data['results'] as $result) {
			$result['position'] = $this->lastPosition;
			$this->results[$this->lastPosition] = $result;
			$this->lastPosition++;
		}
	}

	private function getResultPageRecursive($url) {

		$response = $this->query($url);

		if ($response) {

			$this->parseDOM($response);

			if (($this->lastPage < $this->limit) AND $this->limit) {
				$this->getResultPageRecursive($this->nextLink);
			}
		}
	}

	private function query($url) {
		$response = file_get_contents($url);
		if (!$response AND $this->errors) {
			throw new Exception("Error Processing Request", 1);
		}
		return $response;
	}

	/*	Iterator interface  */

	public function current() {
        return $this->results[$this->index];
    }

    public function next() {
        $this->index++;
    }

    public function key() {
        return $this->index;
    }

    public function valid() {
        return isset($this->results[$this->key()]);
    }

    public function rewind() {
        $this->index = 0;
    }
}
?>