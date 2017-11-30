<?php

class PhalanxBlockInfo {
	/** @var bool $regex */
	private $regex;

	/** @var string $expires */
	private $expires;

	/** @var string $timestamp */
	private $timestamp;

	/** @var string $text */
	private $text;

	/** @var string $reason */
	private $reason;

	/** @var bool $exact */
	private $exact;

	/** @var bool $caseSensitive */
	private $caseSensitive;

	/** @var int $id */
	private $id;

	/** @var int $authorId */
	private $authorId;

	/** @var int $type */
	private $type;

	public static function newFromJsonObject( array $jsonObject ): PhalanxBlockInfo {
		$phalanxBlockInfo = new self();

		foreach ( get_object_vars( $phalanxBlockInfo ) as $propName => $value ) {
			if ( array_key_exists( $propName, $jsonObject ) ) {
				$phalanxBlockInfo->$propName = $jsonObject[$propName];
			}
		}

		return $phalanxBlockInfo;
	}

	/**
	 * @return bool
	 */
	public function isRegex(): bool {
		return $this->regex;
	}

	/**
	 * @return string
	 */
	public function getExpires(): string {
		return $this->expires;
	}

	/**
	 * @return string
	 */
	public function getTimestamp(): string {
		return $this->timestamp;
	}

	/**
	 * @return string
	 */
	public function getText(): string {
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function getReason(): string {
		return $this->reason;
	}

	/**
	 * @return bool
	 */
	public function isExact(): bool {
		return $this->exact;
	}

	/**
	 * @return bool
	 */
	public function isCaseSensitive(): bool {
		return $this->caseSensitive;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getAuthorId(): int {
		return $this->authorId;
	}

	/**
	 * @return int
	 */
	public function getType(): int {
		return $this->type;
	}
}
