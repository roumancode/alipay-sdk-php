<?php

declare(strict_types=1);

namespace Alipay\Aop;

class AlipayResponseException extends \Exception
{
    private array $res = [];
    private string $retCode = '';
    private ?string $errCode = null;

    /**
     * @param array $res
     */
    public function __construct(array $res)
    {
        $this->res = $res;
        $this->retCode = (string) ($res['code'] ?? '');
        if (isset($res['sub_msg'])) {
            $this->errCode = (string) $res['sub_code'];
            $message = '[' . $res['sub_code'] . ']' . $res['sub_msg'];
        } elseif (isset($res['msg'])) {
            $message = '[' . $res['code'] . ']' . $res['msg'];
        } else {
            $message = '未知错误';
        }
        parent::__construct($message);
    }

    /**
     * 获取返回码
     *
     * @return string
     */
    public function getRetCode(): string
    {
        return $this->retCode;
    }

    /**
     * 获取错误码
     *
     * @return string|null
     */
    public function getErrCode(): ?string
    {
        return $this->errCode;
    }

    /**
     * 获取响应数据
     *
     * @return array
     */
    public function getResponse(): array
    {
        return $this->res;
    }
}