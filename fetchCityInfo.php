<?php
$city = $_POST['city'];

// Perform web scraping to fetch the city information from Wikipedia
$html = file_get_contents('https://en.wikipedia.org/wiki/List_of_cities_in_India_by_population');

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$table = $dom->getElementById('mw-content-text')->getElementsByTagName('table')->item(0);
$rows = $table->getElementsByTagName('tr');

$rank = '';
$population2011 = '';
$population2001 = '';
$state = '';

foreach ($rows as $row) {
  $data = $row->getElementsByTagName('td');
  if ($data->length > 1) {
    $cityName = trim($data->item(1)->textContent);
    if ($cityName === $city) {
      $rank = trim($data->item(0)->textContent);
      $population2011 = trim($data->item(2)->textContent);
      $population2001 = trim($data->item(3)->textContent);
      $state = trim($data->item(4)->textContent);
      break;
    }
  }
}

$output = '<h2>' . $city . '</h2>';
$output .= '<p>Rank: ' . $rank . '</p>';
$output .= '<p>City Population (2011): ' . $population2011 . '</p>';
$output .= '<p>Population (2001): ' . $population2001 . '</p>';
$output .= '<p>State or Union Territory: ' . $state . '</p>';

echo $output;
?>
