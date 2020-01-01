注解


<pre>
注解一共有3种应用对象，分别是 类、类方法 和 类属性
注解参数必须是双引号
注解参数传递
传递主要的单个参数 @DemoAnnotation("value")
传递字符串参数 @DemoAnnotation(key1="value1", key2="value2")
传递数组参数 @DemoAnnotation(key={"value1", "value2"})

注意注解类的 @Annotation 和 @Target 注解为全局注解，无需 use
其中 @Target 有如下参数：
METHOD 注解允许定义在类方法上
PROPERTY 注解允许定义在类属性上
CLASS 注解允许定义在类上
ALL 注解允许定义在任何地方
</pre>
<pre>
注解文件中
namespace App\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"ALL"})
 */
class Foo extends AbstractAnnotation
{
	/**
	 * @var string
	 */
	public $bar;
	
}

控制器中的类中调用
namespace App\Controller;

use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Annotation\AutoController;
use App\Annotation\Foo;
/**
 * @AutoController()
 *@Foo(bar="ids")
 */
class IndexController extends AbstractController
{

	public function index(AnnotationCollector $annotationCollector)
	{
		$xx = $annotationCollector::getClassByAnnotation(Foo::class);
		//或者
		//$xx = $annotationCollector::getClassAnnotation("App\Controller\IndexController","App\Annotation\Foo");
		return [
			'xx' => $xx,
		];
	}
}


控制器中的方法中调用
namespace App\Controller;

use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Annotation\AutoController;
use App\Annotation\Foo;
/**
 * @AutoController()
 *
 */
class IndexController extends AbstractController
{
	/**
	 * @Foo(bar="ids")
	 */
	public function index(AnnotationCollector $annotationCollector)
	{
		$xx = $annotationCollector::getMethodByAnnotation(Foo::class);
		//或者
		//$annotationCollector::getClassMethodAnnotation("App\Controller\IndexController","index");
		return [
			'xx' => $xx,
		];
	}
}

在注解类中。不能有方法。只能有初始化的方法__construct

</pre>