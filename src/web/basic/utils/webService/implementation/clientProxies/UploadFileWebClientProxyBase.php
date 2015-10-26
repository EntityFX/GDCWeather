<?php

namespace app\utils\webService\clientProxies;

use app\utils\webService\HttpAuthDigest;
use yii\base\Exception;

class UploadFileWebClientProxyBase extends WebClientProxyBase {
    public function uploadFile($filePath) {
        $post = array('file'=>'@'.$filePath);
        $this->doPost($post);
    }

    private function doPost(array $postContext) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->getEndpoint()->baseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postContext);

        if ($this->httpProxy !== null) {
            curl_setopt($ch, CURLOPT_PROXY, $this->httpProxy->url);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->httpProxy->login . ($this->httpProxy->password === null ? '' : ':' . $this->httpProxy->password));
        }

        if ($this->httpAuth !== null) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->httpAuth->login . ($this->httpAuth->password === null ? '' : ':' . $this->httpAuth->password));

            if ($this->httpAuth instanceof HttpAuthDigest) {
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            }
        }

        $data=curl_exec ($ch);

        $curlInfo = curl_getinfo($ch);
        curl_close ($ch);

        if ($curlInfo['http_code'] >= 400) {
            throw new Exception("Json-rpc http error {$curlInfo['http_code']}");
        }

        return $data;
    }
}