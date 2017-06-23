<?php
/*
MIT License

Copyright (c) 2017 Dominik Deobald

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

class SearchTokenizer {
	function parse($input) {
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
}
