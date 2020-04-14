<?php

class Renderer
{
	/* indent in spaces */
	const DEFAULT_INDENT = 4;

	private int $indent;
	private array $tags = [];

	public function __construct(int $indent = self::DEFAULT_INDENT)
	{
		$this->indent = $indent;
	}

	public function openTag(string $tag):Renderer
	{
		printf("%s<%s>\n", $this->getIndent(), $tag);
		$this->tags[] = $tag;

		return $this;
	}

	public function insertChild(string $tag, string $content):Renderer
	{
		printf("%s<%s>%s</%s>\n", $this->getIndent(), $tag, $content, $tag);

		return $this;
	}

	public function closeTag():Renderer
	{
		if(count($this->tags) == 0)
			return $this;

		$tag = array_pop($this->tags);
		printf("%s</%s>\n", $this->getIndent(), $tag);

		return $this;
	}

	public function closeTags():Renderer
	{
		while(count($this->tags))
			$this->closeTag();

		return $this;
	}

	private function getIndent():string
	{
		return str_repeat(" ", count($this->tags) * $this->indent);
	}
}
