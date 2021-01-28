<?php

namespace App\Components\CanapeId;

class ConfigApi
{
  /**
   * @param $sName
   * @return mixed
   * @throws \Error
   */
  private static function getValByName($sName)
  {
    $aConfig = \Yii::$app->params['canapeId'];

    if (isset($aConfig[$sName])) {
      return $aConfig[$sName];
    } else {
      throw new \Error('no_param');
    }
  }

  /**
   * Получение ключа к CanapeId
   * @return mixed
   * @throws \Error
   */
  public static function getCanapeIdKey()
  {
    return self::getValByName('sCanapeIdKey');
  }

  /**
   * Получение секрета для канапеИд
   * @return mixed
   * @throws \Error
   */
  public static function getCanapeIdSecret()
  {
    return self::getValByName('sCanapeIdSecret');
  }

  /**
   * Получение дефолтного времени жизни токена
   * @return mixed
   * @throws \Error
   */
  public static function getTempKeyLifeTime()
  {
    return self::getValByName('sTempKeyLifeTime');
  }

  /**
   * Получение имени сервиса
   * @return mixed
   * @throws \Error
   */
  public static function getServiceName()
  {
    return self::getValByName('sServiceName');
  }

  /**
   * @return mixed
   * @throws \Error
   */
  public static function getCanapeIdPath()
  {
    return self::getValByName('sCanapeIdPath');
  }

  /**
   * Получение адреса CanapeId
   * @return mixed
   * @throws \Error
   */
  public static function getCanapeIdUrl()
  {
    return self::getCanapeIdPath() . self::getValByName('sCanapeIdUrl');
  }

  /**
   * Получение путь к скрипту
   * @return mixed
   * @throws \Error
   */
  public static function getScriptPath()
  {
    return self::getValByName('sScriptPath');
  }

  /**
   * Отдает номер последней версии sys скрипта
   * @return mixed
   * @throws \Error
   */
  public static function getCurSysVersion()
  {
    return self::getValByName('sSysCurVersion');
  }
}
