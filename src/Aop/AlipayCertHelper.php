<?php

declare(strict_types=1);

namespace Alipay\Aop;

class AlipayCertHelper
{
    /**
     * 从证书中提取序列号
     *
     * @param string $certPath 证书路径
     * @return string
     */
    public static function getCertSN(string $certPath): string
    {
        $cert = file_get_contents($certPath);
        if ($cert === false) {
            throw new \RuntimeException('无法读取证书文件: ' . $certPath);
        }
        $cert = str_replace("\n\n", "\n", $cert);
        $ssl = openssl_x509_parse($cert);
        if ($ssl === false || !isset($ssl['issuer']) || !isset($ssl['serialNumber'])) {
            throw new \RuntimeException('无法解析证书: ' . $certPath);
        }
        
        $issuer = $ssl['issuer'];
        if (!is_array($issuer)) {
            throw new \RuntimeException('证书issuer格式错误: ' . $certPath);
        }
        
        return md5(self::array2string(array_reverse($issuer)) . $ssl['serialNumber']);
    }

    /**
     * 数组转字符串
     *
     * @param array $array 数组
     * @return string
     */
    private static function array2string(array $array): string
    {
        $string = [];
        if ($array !== []) {
            foreach ($array as $key => $value) {
                $string[] = $key . '=' . $value;
            }
        }
        return implode(',', $string);
    }

    /**
     * 提取根证书序列号
     *
     * @param string $certPath 根证书
     * @return string|null
     */
    public static function getRootCertSN(string $certPath): ?string
    {
        $cert = file_get_contents($certPath);
        if ($cert === false) {
            throw new \RuntimeException('无法读取根证书文件: ' . $certPath);
        }
        
        $array = explode("-----END CERTIFICATE-----", $cert);
        $SN = null;
        $certificates = [];
        
        for ($i = 0; $i < count($array) - 1; $i++) {
            $certData = $array[$i] . "-----END CERTIFICATE-----";
            $ssl = openssl_x509_parse($certData);
            if ($ssl === false) {
                continue;
            }
            
            $serialNumber = (string) ($ssl['serialNumber'] ?? '');
            if (strpos($serialNumber, '0x') === 0) {
                $serialNumber = self::hex2dec((string) ($ssl['serialNumberHex'] ?? ''));
            }
            
            $signatureType = (string) ($ssl['signatureTypeLN'] ?? '');
            if ($signatureType === "sha1WithRSAEncryption" || $signatureType === "sha256WithRSAEncryption") {
                $issuer = $ssl['issuer'] ?? [];
                if (!is_array($issuer)) {
                    continue;
                }
                
                $certSN = md5(self::array2string(array_reverse($issuer)) . $serialNumber);
                $certificates[] = $certSN;
            }
        }
        
        if ($certificates !== []) {
            $SN = implode('_', $certificates);
        }
        
        return $SN;
    }

    /**
     * 0x转高精度数字
     *
     * @param string $hex 十六进制字符串
     * @return string
     */
    private static function hex2dec(string $hex): string
    {
        if ($hex === '') {
            return '0';
        }
        
        $dec = '0';
        $len = strlen($hex);
        for ($i = 1; $i <= $len; $i++) {
            $char = $hex[$i - 1];
            if (ctype_xdigit($char)) {
                $dec = bcadd($dec, bcmul((string) hexdec($char), bcpow('16', (string) ($len - $i))));
            }
        }
        return $dec;
    }
}