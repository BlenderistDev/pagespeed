<?php

namespace App\Components\CanapeId;

use Yii;
use yii\helpers\Url;
use yii\base\UserException;
use yii\base\ErrorException;
use nodge\eauth\oauth2\Service;
use yii\web\ForbiddenHttpException;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\OAuth2\Service\ServiceInterface;
use OAuth\Common\Http\Exception\TokenResponseException;

class CanapeIdOAuth2Service extends Service
{
  protected $name = 'canapeid';
  protected $title = 'canapeid';
  protected $type = 'OAuth2';
  protected $jsArguments = [
    'popup' => [
      'width' => 585,
      'height' => 350
    ]
  ];
  protected $clientId = null;
  protected $providerOptions = [
    'authorize' => '/auth/index',
    'access_token' => '/auth/token',
  ];
  protected $baseApiUrl = '/api/';

  /**
   * CanapeIdOAuth2Service constructor.
   * @param array $config
   */
  public function __construct(array $config = [])
  {
    foreach ($this->providerOptions as &$item){
      $item = ConfigApi::getCanapeIdPath().$item;
    }

    $this->baseApiUrl = ConfigApi::getCanapeIdPath().$this->baseApiUrl;

    $this->clientId = ConfigApi::getCanapeIdKey();
    $this->clientSecret = ConfigApi::getCanapeIdSecret();

    parent::__construct($config);
  }

  /**
   * @return bool
   * @throws \nodge\eauth\ErrorException
   */
  protected function fetchAttributes()
  {
    $info = $this->makeSignedRequest('index', [
      'query' => [
        'fields' => '', // uid, first_name and last_name is always available
        'client_id' => $this->clientId,
      ],
    ]);

    $this->attributes['id'] = $info['id'];
    $this->attributes['username'] = $info['username'];
    $this->attributes['email'] = $info['email'];

    return true;
  }

  /**
   * Returns the error array.
   *
   * @param array $response
   * @return array the error array with 2 keys: code and message. Should be null if no errors.
   */
  protected function fetchResponseError($response)
  {
    if (isset($response['error'])) {
      return [
        'code' => is_string($response['error']) ? 0 : $response['error']['error_code'],
      ];
    } else {
      return null;
    }
  }

  /**
   * @param string $response
   * @return mixed
   * @throws ErrorException
   */
  protected function parseResponseInternal($response)
  {
    try {
      $result = $this->parseResponse($response);
      if (!isset($result)) {
        throw new ErrorException('Invalid response format', 500);
      }

      $error = $this->fetchResponseError($result);
      if (isset($error) && !empty($error['message'])) {
        throw new ErrorException($error['message'], $error['code']);
      }

      return $result;
    } catch (\Exception $e) {
      throw new ErrorException($e->getMessage(), $e->getCode());
    }
  }

  /**
   * @param array $data
   * @return null
   * @throws UserException
   */
  public function getAccessTokenResponseError($data)
  {
    if (isset($data['code']) && $data['code']=='0') $data['error'] = $data['message'];

    if (!isset($data['error'])) {
      return null;
    } else {
      throw new UserException($data['error']);
    }
  }

  /**
   * Returns a class constant from ServiceInterface defining the authorization method used for the API.
   *
   * @return int
   */
  public function getAuthorizationMethod()
  {
    return ServiceInterface::AUTHORIZATION_METHOD_QUERY_STRING;
  }

  /**
   * @param $responseBody
   * @return mixed
   * @throws TokenResponseException
   */
  protected function parseRequestTokenResponse($responseBody)
  {
    parse_str($responseBody, $data);

    if (null === $data || !is_array($data)) {
      throw new TokenResponseException('Unable to parse response.');
    } elseif (!isset($data['code'])) {
      throw new TokenResponseException('Error in retrieving code.');
    }
    return $data['code'];
  }

  /**
   * @return string
   */
  public function getServiceTitle()
  {
    return 'eauth';
  }

  /**
   * @param string $responseBody
   * @return array|mixed
   * @throws ForbiddenHttpException
   * @throws TokenResponseException
   */
  public function parseAccessTokenResponse($responseBody)
  {
    $data = json_decode($responseBody, true);

    if (null === $data || !is_array($data)) {
      throw new TokenResponseException('Unable to parse response.');
    } elseif (isset($data['error'])) {
      throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
    }elseif(!isset($data['access_token'])){
      throw new ForbiddenHttpException($data['message']);
    }

    $token = new StdOAuth2Token();
    $token->setAccessToken($data['access_token']);
    $token->setLifeTime($data['expires_in']);

    if (isset($data['refresh_token'])) {
      $token->setRefreshToken($data['refresh_token']);
      unset($data['refresh_token']);
    }

    $token->setExtraParams($data);

    return $data;
  }

  /**
   * Проверка авторизации на сервисе canape_id
   * @return bool
   * @throws ErrorException
   * @throws TokenResponseException
   * @throws \nodge\eauth\ErrorException
   */
  public function authenticate()
  {
    if (!$this->checkError()) {
      return false;
    }

    try {
      $proxy = $this->getProxy();

      if (!empty($_GET['code'])) {
        /*
         * меняем authorization_token на access_token
         *
         * code: l-q0kUuWL7T7biwoQx...
         * state:0f7eeea458fe66a16f...
        */
        // This was a callback request from a service, get the token
        $proxy->requestAccessToken($_GET['code']);
        $this->authenticated = true;
      } else if ($proxy->hasValidAccessToken()) {
        $this->authenticated = true;
      } else {

        $aSite = \Yii::$app->session->get('operating_site', null);

        if (!is_null($aSite))
          $sSiteUrl = $aSite['site_url'];
        else
          $sSiteUrl = null;

        /** @var $url Url */
        $url = $proxy->getAuthorizationUri(['operating_site'=>$sSiteUrl]);
        \Yii::$app->getResponse()->redirect($url->getAbsoluteUri())->send();
      }
    } catch (\OAuthException $e) {
      throw new ErrorException($e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e);
    }

    return $this->getIsAuthenticated();
  }
}
