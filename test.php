<pre><?php

require 'tokenizer.php';

$queries = array(
    'simple words',
    '"multi words"',
    '"multi words" "even more"',
    '"multi words" "we fail',
    '-"exclude words"',
    '-exclude',
    'bla:blubb "follow the white rabbit" -exclude',
    '-bla:blubb',
);

$t = new SearchTokenizer();

foreach ($queries as $query) {
    echo htmlentities($query), '<br>';
    echo htmlentities(json_encode($t->parse($query), JSON_PRETTY_PRINT));
    echo '<hr>';
}
