在携程中传值

<pre>
controller 中

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;


/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
	protected $foo=1;

	public function get()
	{
		return [
			'a' =>$this->foo
		];
	}

	public function update(RequestInterface $request)
	{
		$foo = $request->input('foo');
		$this->foo=$foo;
		return [
			'a' =>$this->foo
		];
	}
}

分别请求
xx.com/index/get
xx.com/index/update？foo=23323
xx.com/index/get
所以单利会影响变量值。哪怕是通过注解或者IOC的模式也是会对变量造成影响。
那么如何不影响呢。就是协诚上下文了。


use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;


/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
	protected $foo=1;

	public function get()
	{
		return [
			'a' =>Context::get('foo','null')
		];
	}

	public function update(RequestInterface $request)
	{
		$foo = $request->input('foo');
		Context::set('foo',$foo);
		return [
			'a' =>Context::get('foo')
		];
	}
}
分别请求
xx.com/index/get
xx.com/index/update？foo=23323
xx.com/index/get
这样每个请求都是独立的。



</pre>