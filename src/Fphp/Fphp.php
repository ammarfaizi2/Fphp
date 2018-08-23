<?php

namespace Fphp;

use Fphp\Exceptions\FphpException;

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

	/**
	 * @throws \Fphp\Exceptions\FphpException
	 * @return bool
	 */
	public function login(): bool
	{
		// $l = $this->http->exec("https://m.facebook.com/");

		// if ($l["errno"]) {
		// 	throw new FphpException($l["error"]);
		// }

		$l["out"] = file_get_contents("out.tmp");

		if (preg_match("/(?:<form method=\"post\" action=\")(.*)(?:\")/Usi", $l["out"], $m)) {
			$actionUrl = fe($m[1]);
			$postData = [
				"email" => $this->email,
				"pass" => $this->pass
			];

			/**
			 * Get hidden input values.
			 */
			if (preg_match_all("/<input[^\>]+type=\"hidden\".+>/Usi", $l["out"], $m)) {
				foreach ($m[0] as $v) {
					if (preg_match("/(?:name=\")(.*)(?:\")/Usi", $v, $m)) {
						$key = fe($m[1]);
						if (preg_match("/(?:value=\")(.*)(?:\")/Usi", $v, $m)) {
							$val = fe($m[1]);
						} else {
							$val = "";
						}
						$postData[trim($key)] = trim($val);
					}
				}
			} else {
				throw new FphpException("Could not find hidden input");
			}

			/**
			 * Get submit button value.
			 */
			if (preg_match("/<input[^\>]+name=\"login\".+/Usi", $l["out"], $m)) {
				if (preg_match("/(?:value=\")(.*)(?:\")/Usi", $m[0], $m)) {
					$postData["login"] = trim(fe($m[1]));
				}
			}
		}

		var_dump($postData);

		

		return !1;
	}
}
