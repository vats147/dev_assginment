<?php
$input = $_POST['input'];

// Perform web scraping to fetch the city data from Wikipedia
$html = file_get_contents('https://en.wikipedia.org/wiki/List_of_cities_in_India_by_population');

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$table = $dom->getElementById('mw-content-text')->getElementsByTagName('table')->item(0);
$rows = $table->getElementsByTagName('tr');

$output = '';

foreach ($rows as $row) {
  $data = $row->getElementsByTagName('td');
  if ($data->length > 1) {
    $city = trim($data->item(1)->textContent);
    if (stripos($city, $input) !== false) {
      $output .= '<div class="cityOption">' . $city . '</div>';
    }
  }
}

echo $output;
?>
