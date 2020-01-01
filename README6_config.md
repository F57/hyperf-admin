第一种

use Hyperf\Di\Annotation\Inject;


    /**
	 * @Inject
	 * @var \Hyperf\Contract\ConfigInterface
	 */
	protected $config;
	
	$this->config->get('foo.bar')
	
在config下的config.php中
`
'foo'=>[
    	'bar'=>[
			'192.168.1.1',
			'192.168.1.2',
		]
    ]	
`
如果配置文件在autoload下,那么新建一个foo.php
然后写入
return [
    'bar'=>[
    			'192.168.1.1',
    			'192.168.1.2',
    		]
]

第二种
use Hyperf\Config\Annotation\Value;

    /**
	 * @Value("foo.bar")
	 */
	protected $config;
	
	
第三中全局函数
config('foo.bar')