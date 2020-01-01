第一种在confg/route.php中

`
Router::get('/', 'App\Controller\IndexController@index');
Router::post('/', 'App\Controller\IndexController@index');
Router::put('/', 'App\Controller\IndexController@index');
Router::patch('/', 'App\Controller\IndexController@index');
Router::delete('/', 'App\Controller\IndexController@index');
Router::head('/', 'App\Controller\IndexController@index');
`

`
Router::get('/hello-hyperf', function () {
    return 'Hello Hyperf.';
});
`
`
Router::addRoute(['GET', 'POST','PUT','DELETE'], '/','App\Controller\IndexController@index');
`

第二种在控制器中写.就是注解.注解分为两种一种是AutoController注解,一种是Controller注解.

AutoController注解
<pre>
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
访问 xx.com/index/index
</pre>

Controller注解

<pre>
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{
	/**
	 * @RequestMapping(path="aa", methods="get,post")
	 */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
访问 xx.com/index/aa
如果不想访问带index控制器的地址.那么把aa变成/aa.
这样就访问xx.com/aa
</pre>

说明

<pre>
说明:不同的Controller注解所引入的不一样.

使用 @Controller 注解时需 use Hyperf\HttpServer\Annotation\Controller; 命名空间；

使用 @RequestMapping 注解时需 use Hyperf\HttpServer\Annotation\RequestMapping; 命名空间；

使用 @GetMapping 注解时需 use Hyperf\HttpServer\Annotation\GetMapping; 命名空间；

使用 @PostMapping 注解时需 use Hyperf\HttpServer\Annotation\PostMapping; 命名空间；

使用 @PutMapping 注解时需 use Hyperf\HttpServer\Annotation\PutMapping; 命名空间；

使用 @PatchMapping 注解时需 use Hyperf\HttpServer\Annotation\PatchMapping; 命名空间；

使用 @DeleteMapping 注解时需 use Hyperf\HttpServer\Annotation\DeleteMapping; 命名空间；

也就是说RequestMapping之下的所有引入都可以放到方法那里
</pre>
