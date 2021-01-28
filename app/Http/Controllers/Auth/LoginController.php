<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sys()
    {
        return $this->getKey();
        return $this->getToken();
    }

      /**
       * Подтягивание формы авторизации и ее отрисовка
       */
    public function getToken(){

        $sReturnLink = '127.0.0.1:8000';
        $_SESSION['need_access_to'] = str_replace('%23','#',$sReturnLink);

        $aQueryData = [
          'cmd'=>'getToken',
          'redirect_link'=>'http://'.str_replace('www.','',$_SERVER['HTTP_HOST']).$_SERVER['SCRIPT_NAME'],
          'public_key'=> 'w8KAoNdQDURQdqpYGrEQLFSYWwztDfaFa3dzJmZz6sZid4F17t',
          'service_name'=> 'tokens',
//          'site_type'=>'Canape3'
        ];

        $aData['mode'] = 'redirect';
        $aData['redirect_link'] = 'https://tokens.canape-id.com/api/get-token';
        $aData['params'] = $aQueryData;

        $sParams = '';
        $aParams = array();
        if (isset($aData['params'])){
          foreach ($aData['params'] as $name=>$param){
//            var_dump($name);
            $aParams[] = $name.'='.$param;
          }
          $sParams = implode('&',$aParams);
          if ($sParams!=='')
            $sParams = '?'.$sParams;
        }

        return redirect($aData['redirect_link'].$sParams);
    }

    private function getKey()
    {
      $aQueryData = [
        'cmd'=>'getKey',
        'site_url'=>'localhost:8000',
        'site_type'=>'Canape3'
      ];

      $aData['mode'] = 'redirect';
      $aData['redirect_link'] = 'https://tokens.canape-id.com/api/get-token';
      $aData['params'] = $aQueryData;

      $sParams = '';
      $aParams = array();
      if (isset($aData['params'])){
        foreach ($aData['params'] as $name=>$param){
          $aParams[] = $name.'='.$param;
        }
        $sParams = implode('&',$aParams);
        if ($sParams!=='')
          $sParams = '?'.$sParams;
      }
      return redirect($aData['redirect_link'].$sParams);
    }
}
//https://tokens.canape-id.com/api/get-token?cmd=getToken&redirect_link=http://localhost:8000/sys.php&public_key=iB3jfg07ZR7tAE6QYyj89jHuBtJiNrm61jdtUsqgH8zgmgH5x72zdIm0StimoUc9BIezLrObq1DQykxmfsKQLuQzsILxeezMPcokmJHQIkMDPpwVcZdrMDbwotvsiGwK0p9m1GNb6G0YBqkoZTdPuP&service_name=tokens&site_type=Canape3
