<?php

namespace srag\DIC\UserDefaults;

use Throwable;

/**
 * Class PHPVersionChecker
 *
 * @package srag\DIC\UserDefaults
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @internal
 */
final class PHPVersionChecker {

	/**
	 * @var string
	 *
	 * @internal
	 */
	const ERROR_MESSAGE = 'The plugin %1$s could not be used! Because it\'s needed at least PHP version %2$s, but you have only PHP version %3$s<br>Please upgrade your PHP version or delete the plugin directory %4$s';
	/**
	 * @var string
	 *
	 * @internal
	 */
	const PLUGIN_NAME_REG_EXP = "/\/([A-Za-z0-9_]+)\/vendor\//";
	/**
	 * @var string
	 *
	 * @internal
	 */
	const VERSION_CHECK_REG_EXP = "/([0-9]+(\.[0-9]+){1,2})/";
	/**
	 * @var bool|null
	 */
	private static $cache = NULL;
	/**
	 * @var string
	 */
	private static $current_php_version = "";
	/**
	 * @var string
	 */
	private static $should_php_version = "";


	/**
	 * @internal
	 */
	public static function checkPHPVersionOutput()/*: void**/ {
		if (!self::checkPHPVersion()) {
			die(sprintf(self::ERROR_MESSAGE, self::getPluginName(), self::$should_php_version, self::$current_php_version, self::normalizePath(__DIR__
				. "/../../../..")));
		}
	}


	/**
	 * @return bool
	 */
	private static function checkPHPVersion()/*: bool*/ {
		if (self::$cache !== NULL) {
			try {
				$composer_file = __DIR__ . "/../../../../composer.json";

				if (file_exists($composer_file)) {
					$composer = json_decode(file_get_contents($composer_file));

					if (is_object($composer) && is_object($composer->require) && is_string($composer->require->php)) {
						$php = $composer->require->php;

						$matches = [];
						preg_match(self::VERSION_CHECK_REG_EXP, $php, $matches);
						if (is_array($matches) && count($matches) >= 2) {
							self::$should_php_version = $matches[1];

							$matches = [];
							preg_match(self::VERSION_CHECK_REG_EXP, PHP_VERSION, $matches);
							if (is_array($matches) && count($matches) >= 2) {
								self::$current_php_version = $matches[1];

								self::$cache = (version_compare(self::$current_php_version, self::$should_php_version, ">=") > 0);

								return self::$cache;
							}
						}
					}
				}

				self::$cache = true;
			} catch (Throwable $ex) {
				self::$cache = true;
			}
		}

		return self::$cache;
	}


	/**
	 * @return string
	 */
	private static function getPluginName()/*: string*/ {
		$matches = [];
		preg_match(self::PLUGIN_NAME_REG_EXP, __DIR__, $matches);

		if (is_array($matches) && count($matches) >= 2) {
			$plugin_name = $matches[1];

			return $plugin_name;
		} else {
			return "";
		}
	}


	/**
	 * https://edmondscommerce.github.io/php/php-realpath-for-none-existant-paths.html (Normalize path without using realpath)
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	private static function normalizePath(/*string*/
		$path)/*: string*/ {
		return array_reduce(explode("/", $path), function (/*string*/
			$a, /*string*/
			$b)/*: string*/ {
			if ($b === "" || $b === ".") {
				return $a;
			}

			if ($b === "..") {
				return dirname($a);
			}

			return preg_replace("/\/+/", "/", "$a/$b");
		}, "/");
	}


	/**
	 * PHPVersionChecker constructor
	 */
	private function __construct() {

	}
}

PHPVersionChecker::checkPHPVersionOutput();