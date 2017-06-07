<?php

function tokenize($input) {
	// Trim input
	$input = trim( $input );

	$pattern = "/(-)?(?:(\\w+):)?(\"[^\"]*\"|'[^']*'|[^\\s]+)/";
	$results = array();

	preg_match_all($pattern, $input, $matches, PREG_SET_ORDER);

	if ($matches) {
		foreach ($matches as $match) {
			$term = $match[3];

			$termEnds = substr($term, 0, 1) . substr($term, -1);

			if ($termEnds == '""') {
				$phrase = true;
				$term = trim($term, '"' . " \t\n\r\0\x0B");
			} elseif ($termEnds == "''") {
				$phrase = true;
				$term = trim($term, "'" . " \t\n\r\0\x0B");
			} else {
				$phrase = false;
			}

			$results[] = array(
				'exclude' => ($match[1] == '-'),
				'tag' => $match[2],
				'term' => $term,
				'phrase' => $phrase
			);
		}
	}

	return $results;
}
