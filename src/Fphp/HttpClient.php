<?php

namespace Fphp;

class HttpClient
{
	/**
	 * @var array
	 */
	private $curlOptions = [];	

	/**
	 * @param array $opt
	 * 
	 * Constructor
	 */
	public function __construct(array $opt = [])
	{
		$this->curlOptions = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_USERAGENT => $this->userAgent
		];
		foreach ($opt as $key => $value) {
			$this->curlOptions[$key] = $value;
		}
	}

	/**
	 * @param array $opt
	 * @return void
	 */
	public function setOpt(array $opt): void
	{
		foreach ($opt as $key => $value) {
			$this->curlOptions[$key] = $value;
		}
	}

	/**
	 * @param string $url
	 * @param array  $opt
	 * @return array
	 */
	public function exec(string $url, array $opt = []): array
	{
		$ch = curl_init($url);
		$optf = $this->curlOptions;
		foreach ($opt as $key => $value) {
			$optf[$key] = $value;
		}
		curl_setopt_array($ch, $optf);
		$out = curl_exec($ch);
		$err = curl_error($ch);
		$ern = curl_errno($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return [
			"out" => $out,
			"error" => $err,
			"errno" => $ern,
			"info" => $info
		];
	}
}