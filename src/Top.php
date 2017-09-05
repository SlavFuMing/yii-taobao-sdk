<?php
namespace taobao;
use Yii;
use yii\base\Component;
class Top extends Component
{
	private static $classMap;

	public function __construct()
	{
		if (!defined("TOP_SDK_WORK_DIR"))
		{
			define("TOP_SDK_WORK_DIR", "/tmp/");
		}

		if (!defined("TOP_SDK_DEV_MODE"))
		{
			define("TOP_SDK_DEV_MODE", true);
		}

		if (!defined("TOP_AUTOLOADER_PATH"))
		{
			define("TOP_AUTOLOADER_PATH", dirname(__FILE__));
		}

		spl_autoload_register('Top::autoload');
	}

	//因为这是第三方代码，为了完全使用第三方结构代码，所以重构了__get方法
	public function __get($name)
	{
		if(!isset(self::$classMap[$name])){
			self::$classMap[$name] = new $name;
		}

		return self::$classMap;
	}

  	/**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class) {
        $name = $class;
        if(false !== strpos($name,'\\')){
          $name = strstr($class, '\\', true);
        }
        
        $filename = TOP_AUTOLOADER_PATH."/top/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/top/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/top/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }         
    }
}

