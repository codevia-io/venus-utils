<?php

namespace Codevia\Venus\Utils\Security;

/**
 * Oriented Object Sodium wrapper
 */
class Crypto
{
    #region symmetric encryption
    public static function generateSecretKey(): string
    {
        return sodium_crypto_aead_xchacha20poly1305_ietf_keygen();
    }

    public static function generateNonce(): string
    {
        return random_bytes(\SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
    }

    public static function encrypt(string $plaintext, string $key, string $nonce): string
    {
        return sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($plaintext, '', $nonce, $key);
    }

    public static function decrypt(string $ciphertext, string $key, string $nonce)
    {
        return sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, '', $nonce, $key);
    }
    #endregion

    #region asymmetric encryption
    public static function generateKeyPair(): array
    {
        $keyPair = sodium_crypto_box_keypair();
        $publicKey = sodium_crypto_box_publickey($keyPair);

        return [
            'privateKey' => $keyPair,
            'publicKey' => $publicKey
        ];
    }

    public static function publicEncrypt(string $plaintext, string $publicKey): string
    {
        return sodium_crypto_box_seal($plaintext, $publicKey);
    }

    public static function privateDecrypt(string $ciphertext, string $privateKey): string
    {
        return sodium_crypto_box_seal_open($ciphertext, $privateKey);
    }
    #endregion
}
