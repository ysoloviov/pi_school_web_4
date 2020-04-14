<?php

class Article
{
	private string $title;
	private string $description;
	private array $tags;

	public function getTitle():string
	{
		return $this->title;
	}

	public function setTitle(string $title):Article
	{
		$this->title = $title;

		return $this;
	}

	public function getDescription():string
	{
		return $this->description;
	}

	public function setDescription(string $description):Article
	{
		$this->description = $description;

		return $this;
	}

	public function getTags():array
	{
		return $this->tags;
	}

	public function setTags(array $tags):Article
	{
		$this->tags = $tags;

		return $this;
	}

	public function hasTag(string $tag):bool
	{
		return in_array($tag, $this->tags);
	}
}
