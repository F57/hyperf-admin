依赖注入

<pre>
三种注入类型:
简单对象注入
抽象对象注入
工厂对象注入

两种调用方式:
构造函数调用
@Inject 注解调用

注意：因为DI管理的对象是单利。所以属性类和构造函数的参数不能是动态的参数。
如果想用动态的参数，那么需要用工厂对象注入的方式。
</pre>

<pre>
简单注入
在app下创建一个Service的目录创建一个UserService.php文件。然后写入
<?php

namespace App\Service;

class UserService
{
    public function getInfoById(int $id)
    {
        return array('id'=>$id,'name'=>'service');    
    }
}

在控制器中通过构造函数调用
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Utils\Context;
use App\Service\UserService;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{

    /**
     * @var UserService
     */
    private $userService;

    // 通过在构造函数的参数上声明参数类型完成自动注入
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * @RequestMapping(path="aa", methods="get,post")
     */
    public function index()
    {
        $id = 1;
        		// 直接使用
        		$xx = $this->userService->getInfoById($id);
        		return [
        			'method' => $xx,
        		];
    }
}
访问xxx.com/index/aa



在控制器中通过@Inject 注解调用
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Utils\Context;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{

     /**
     * 
     * @Inject 
     * @var UserService
     */   
     private $userService;

    /**
     * @RequestMapping(path="aa", methods="get,post")
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
	$id = 1;
        // 直接使用
        $xx = $this->userService->getInfoById($id); 
        return [
            'method' => $xx,
            'message' => $this->request->withAttribute('aa', 'bb'),
            'xx' => Context::getContainer(),
        ];
    }
}
访问xxx.com/index/aa
</pre>


<pre>
抽象对象注入
在app/Service/下创建文件UserServiceInterface.php和UserService.php

其中UserServiceInterface.php

<?php
namespace App\Service;

interface UserServiceInterface
{
    public function getInfoById(int $id);
}

UserService.php中

namespace App\Service;

class UserService implements UserServiceInterface
{
    public function getInfoById(int $id)
    {
        return array('id'=>$id,'name'=>'service');    
    }
}
在控制器中通过构造函数调用和简单对象注入时一样的。



在控制器中通过@Inject 注解调用
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Utils\Context;
use Hyperf\Di\Annotation\Inject;
use App\Service\UserServiceInterface;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{

     /**
     * 
     * @Inject 
     * @var UserServiceInterface
     */   
     private $userService;

    /**
     * @RequestMapping(path="aa", methods="get,post")
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
	$id = 1;
        // 直接使用
        $xx = $this->userService->getInfoById($id); 
        return [
            'method' => $xx,
            'message' => $this->request->withAttribute('aa', 'bb'),
            'xx' => Context::getContainer(),
        ];
    }
}


</pre>


<pre>
通过工厂注入的方式
App\Service\UserServiceFactory.php

namespace App\Service;

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class UserServiceFactory
{
	// 实现一个 __invoke() 方法来完成对象的生产，方法参数会自动注入一个当前的容器实例
	public function __invoke()
	{
		$enableCache = false;
		// make(string $name, array $parameters = []) 方法等同于 new ，使用 make() 方法是为了允许 AOP 的介入，而直接 new 会导致 AOP 无法正常介入流程
		return make(UserService::class, compact('enableCache'));
	}
}

App\Service\UserServiceInterface.php

namespace App\Service;

interface UserServiceInterface
{
    public function getInfoById(int $id);
}

App\Service\UserService.php

namespace App\Service;

class UserService implements UserServiceInterface
{

	/**
	 * @var bool
	 */
	private $enableCache;

	public function __construct(bool $enableCache)
	{
		// 接收值并储存于类属性中
		$this->enableCache = $enableCache;
	}

	public function getInfoById(int $id)
	{
		return array('bool'=>$this->enableCache);
	}
}


配置文件
config/autoload/dependencies.php

\App\Service\UserServiceInterface::class => \App\Service\UserServiceFactory::class

app/Controller/IndexController.php通过构造方法的方式
declare(strict_types=1);

namespace App\Controller;

use App\Service\UserServiceInterface;

class IndexController extends AbstractController
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    // 通过在构造函数的参数上声明参数类型完成自动注入
    public function __construct(UserServiceInterface $UserServiceInterface)
    {
        $this->userService = $UserServiceInterface;
    }

    public function index()
    {
        $id = 1;
        // 直接使用
        return [
            'method' => $this->userService->getInfoById($id),
        ];

    }
}

app/Controller/IndexController.php通过注解的方式
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Utils\Context;
use Hyperf\Di\Annotation\Inject;
use App\Service\UserServiceInterface;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{

	/**
	 *
	 * @Inject
	 * @var UserServiceInterface
	 */
	private $userService;

	/**
	 * @RequestMapping(path="aa", methods="get,post")
	 */
	public function index()
	{
		$user = $this->request->input('user', 'Hyperf');
		$method = $this->request->getMethod();
		$id = 1;
		// 直接使用
		$xx = $this->userService->getInfoById($id);
		return [
			'method' => $xx,
			'message' => $this->request->withAttribute('aa', 'bb'),
			'xx' => Context::getContainer(),
		];
	}
}	
</pre>


