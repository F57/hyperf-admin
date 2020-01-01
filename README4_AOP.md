AOP
通过AOP可以对依赖注入进行操作。

<pre>
新建一个类
namespace App\Service;

class UserService
{
	public function getInfoById(int $id)
	{
		return array('bool'=>$id);
	}
}

新建一个注解类
namespace App\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD","CLASS"})
 */
class Test extends AbstractAnnotation
{
	/**
	 * @var string
	 */
	public $bar;

}

在控制器调用
namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use App\Service\UserService;
use App\Annotation\Test;

/**
 * @AutoController()
 * @Test(bar="this is aop")
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

新建一个AOP切面类
namespace App\Aspect;

use App\Annotation\Test;
use App\Service\UserService;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

/**
 * @Aspect
 */
class FooAspect extends AbstractAspect
{
    //这是对类的切入
	public $classes = [
		UserService::class.'::'.'getInfoById',
	];
	//这是对注解的切入
	public $annotations=[
		Test::class,
	];
	public function process(ProceedingJoinPoint $proceedingJoinPoint)
	{
		$result = $proceedingJoinPoint->process();//调用切面类或切面注解的那个类。这里是index控制器
		$param = $proceedingJoinPoint->processOriginalMethod(); //获取要切入的类的返回值
		$anno = $proceedingJoinPoint->getAnnotationMetadata();
		$bar='';
		if(!empty($anno) && !empty($anno->class)){
			$a = $anno->class[Test::class];
			$bar = $a->bar;
		}
		// 在调用后进行某些处理
		return $result;
	}
}



</pre>
