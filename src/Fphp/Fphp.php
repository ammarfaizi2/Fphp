<?php

namespace Fphp;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 * @package \Fphp
 */
final class Fphp
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $pass;

	/**
	 * @var string
	 */
	private $cookieFile;

	/**
	 * @var \Fphp\HttpClient
	 */
	private $http;

	/**
	 * @param string $email
	 * @param string $pass
	 * @param string $cookieFile
	 *
	 * Constructor.
	 */
	public function __construct(string $email, string $pass, string $cookieFile)
	{
		$this->email = $email;
		$this->pass  = $pass;
		$this->cookieFile = $cookieFile;

		$this->http = new HttpClient(
			[
				CURLOPT_COOKIEFILE => $this->cookieFile,
				CURLOPT_COOKIEJAR => $this->cookieFile
			]
		);
	}

	public function login()
	{
		$this->http->exec("https://m.facebook.com/");
	}
}
