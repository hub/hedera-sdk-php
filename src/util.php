<?php

function signEd25519(string $bodyBytes, string $derHex): array
{
    $keys = get_keypair($derHex);
    $signature = signString($bodyBytes, $keys['private']);

    return [$signature, $keys['public']];
}

function get_keypair(string $derHex): array
{
    $keypair = decodePrivateKeyToKeypair($derHex);
    $secretKey = sodium_crypto_sign_secretkey($keypair);
    $publicKey = sodium_crypto_sign_publickey($keypair);
    return ['private' => $secretKey, 'public' => $publicKey];
}

function signString(string $data, string $privateKey): string
{
    // ToDo: Verify if this is the standard signing algorithm
    return sodium_crypto_sign_detached($data, $privateKey);
}

function decodePrivateKeyToKeypair(string $derHex): string
{
    $der = hex2bin($derHex);
    if ($der === false) {
        throw new InvalidArgumentException('Invalid hex.');
    }
    $privateKeyRaw = substr($der, -32);
    $keypair = sodium_crypto_sign_seed_keypair($privateKeyRaw);
    return $keypair;
}
