<?php

declare(strict_types=1);

namespace Alipay\Aop;

class AlipayRequest
{
    protected ?string $notifyUrl = null;

    protected ?string $returnUrl = null;

    protected ?string $terminalType = null;

    protected ?string $terminalInfo = null;

    protected ?string $prodCode = null;

    protected ?string $authToken = null;

    protected ?string $appAuthToken = null;

    protected mixed $bizContent = null;

    protected string $apiMethodName = '';

    /**
     * 设置其他参数
     *
     * @param array $params
     * @return AlipayRequest
     */
    public function setOtherParams(array $params = []): AlipayRequest
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * 获取用于发起请求的"时间戳"
     *
     * @return string
     */
    public static function getTimestamp(): string
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 根据类名获取 API 方法名
     *
     * @return string
     */
    public function getApiMethodName(): string
    {
        return $this->apiMethodName;
    }

    /**
     * 设置API方法名
     *
     * @param string $apiMethodName
     * @return AlipayRequest
     */
    public function setApiMethodName(string $apiMethodName): AlipayRequest
    {
        $this->apiMethodName = $apiMethodName;

        return $this;
    }

    /**
     * 获取通知URL
     *
     * @return string|null
     */
    public function getNotifyUrl(): ?string
    {
        return $this->notifyUrl;
    }

    /**
     * 设置通知URL
     *
     * @param string|null $notifyUrl
     * @return AlipayRequest
     */
    public function setNotifyUrl(?string $notifyUrl): AlipayRequest
    {
        $this->notifyUrl = $notifyUrl;

        return $this;
    }

    /**
     * 获取返回URL
     *
     * @return string|null
     */
    public function getReturnUrl(): ?string
    {
        return $this->returnUrl;
    }

    /**
     * 设置返回URL
     *
     * @param string|null $returnUrl
     * @return AlipayRequest
     */
    public function setReturnUrl(?string $returnUrl): AlipayRequest
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * 获取终端类型
     *
     * @return string|null
     */
    public function getTerminalType(): ?string
    {
        return $this->terminalType;
    }

    /**
     * 设置终端类型
     *
     * @param string|null $terminalType
     * @return AlipayRequest
     */
    public function setTerminalType(?string $terminalType): AlipayRequest
    {
        $this->terminalType = $terminalType;

        return $this;
    }

    /**
     * 获取终端信息
     *
     * @return string|null
     */
    public function getTerminalInfo(): ?string
    {
        return $this->terminalInfo;
    }

    /**
     * 设置终端信息
     *
     * @param string|null $terminalInfo
     * @return AlipayRequest
     */
    public function setTerminalInfo(?string $terminalInfo): AlipayRequest
    {
        $this->terminalInfo = $terminalInfo;

        return $this;
    }

    /**
     * 获取产品代码
     *
     * @return string|null
     */
    public function getProdCode(): ?string
    {
        return $this->prodCode;
    }

    /**
     * 设置产品代码
     *
     * @param string|null $prodCode
     * @return AlipayRequest
     */
    public function setProdCode(?string $prodCode): AlipayRequest
    {
        $this->prodCode = $prodCode;

        return $this;
    }

    /**
     * 获取授权令牌
     *
     * @return string|null
     */
    public function getAuthToken(): ?string
    {
        return $this->authToken;
    }

    /**
     * 设置授权令牌
     *
     * @param string|null $authToken
     * @return AlipayRequest
     */
    public function setAuthToken(?string $authToken): AlipayRequest
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * 获取应用授权令牌
     *
     * @return string|null
     */
    public function getAppAuthToken(): ?string
    {
        return $this->appAuthToken;
    }

    /**
     * 设置应用授权令牌
     *
     * @param string|null $appAuthToken
     * @return AlipayRequest
     */
    public function setAppAuthToken(?string $appAuthToken): AlipayRequest
    {
        $this->appAuthToken = $appAuthToken;

        return $this;
    }

    /**
     * 获取业务内容
     *
     * @return string
     */
    public function getBizContent(): string
    {
        if (is_array($this->bizContent)) {
            return json_encode($this->bizContent, JSON_UNESCAPED_UNICODE);
        }
        return (string) $this->bizContent;
    }

    /**
     * 设置业务内容
     *
     * @param mixed $bizContent
     * @return AlipayRequest
     */
    public function setBizContent(mixed $bizContent = []): AlipayRequest
    {
        $this->bizContent = $bizContent;

        return $this;
    }
}
