<?php

class Parser
{
	const SEPARATOR = ":";
	const CONTEXT_CHANGE_MAP = 1 << 0;

	private string $raw;
	private array $articles;

	public function __construct(string $raw)
	{
		$this->raw = $raw;
		$this->articles = [];
	}

	public function parse():Parser
	{
		$lines = explode("\n", $this->raw);

		foreach($lines as $line) {
			$parts = explode(self::SEPARATOR, $line, 2);

			/* broken line */
			if(count($parts) == 0)
				continue;

			/* count number of spaces at the beginning of the line */
			for($i = 0; $line[$i] === " "; $i++);

			/* reset bit mask if not enough spaces */
			if($i < 8)
				$context = 0;

			/* sanitizing */
			$key = trim($parts[0]);
			$value = trim($parts[1]);

			/* Bit mask indicates whether a field should be interpreted
			 * in any special way and is used primarily for extending purposes;
			 * context fields takes precedence over regular ones.
			 */
			if($context & self::CONTEXT_CHANGE_MAP) {
				$description = str_replace($key, $value, $article->getDescription());
				$article->setDescription($description);
			}
			else {
				switch($key) {
					case "Article":
						$this->articles[] = $article = new Article;
						break;
					case "Header":
						$article->setTitle($value);
						break;
					case "Body":
						$article->setDescription($value);
						break;
					case "Tags":
						$article->setTags(explode(", ", $value));
						break;
					case "ChangeMap":
						$context |= self::CONTEXT_CHANGE_MAP;
						break;
				}
			}
		}

		return $this;
	}

	public function getArticles():array
	{
		return $this->articles;
	}
}
