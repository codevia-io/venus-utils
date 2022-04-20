<?php

namespace Codevia\Venus\Utils\Security;

/**
 * Oriented object version of the native PHP password API.
 * @package Codevia\Venus\Security
 */
class Password
{
    const ALGO = PASSWORD_DEFAULT;

    /**
     * Hash a password with a salt and a strong algo
     * 
     * @param string $password The users's password
     * @param string|int|null $algo A password algorithm constant denoting the algorithm to use when hashing the password.
     * @param array $options An associative array containing options.
     * 
     * @return string The hashed password
     */
    public static function hash(
        string $password,
        string|int|null $algo = null,
        array $options = []
    ): string {
        return password_hash($password, $algo ?? self::ALGO, $options);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function needsRehash($hash)
    {
        return password_needs_rehash($hash, self::ALGO);
    }

    public static function getInfo($hash)
    {
        return password_get_info($hash);
    }

    /**
     * Get all supported algorithms by your current PHP version
     * 
     * @return string[]
     */
    public static function getSupportedAlgos(): array
    {
        return password_algos();
    }

    /**
     * Compute the best cost to use. The hashsing time should be under 50ms.
     */
    public static function getBestCost(): int
    {
        $timeTarget = 0.05; // 50 milliseconds
        $cost = 8;

        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        return $cost;
    }
}