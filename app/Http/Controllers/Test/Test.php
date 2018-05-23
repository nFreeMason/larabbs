<?php

namespace App\Http\Controllers\Test;

use App\Contracts\TestContract;
use App\Handlers\SlugTranslateHandler;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;
use App\MyProvidersClass\LangConfig;
use App\MyProvidersClass\LangConfigInterface;
use App\Services\TestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Closure;

class Test extends Controller
{
	public static $returnMessage = [];
	
	public $test = [];
	
    public function __construct(TestService $test)
    {
    	$this->test = $test;
//        $this->middleware('guest');
        /* 代码生成器能让你通过执行一条 Artisan 命令，完成注册路由、新建模型、新建表单验证类、新建资源控制器以及所需视图
         * 文件等任务，不仅约束了项目开发的风格，还能极大地提高我们的开发效率,
         *
         * composer require "summerblue/generator:~0.5" --dev
         */
    }

    public function show( User $user )
    {

        dd( captcha_src( 'flat' ) );
        $result = $this->authorize( 'update', $user );
        dd( $result );
        dd( 'yes' );
    }

    public function translationToE($array)
    {
    	$str = '';
    	if ( is_string($array) ) {
		    $array = json_decode($array, true);
	    }
	    foreach ( $array as $item ) {
		    if ( is_array($item) ) {
		    	$str .= $this->translationToE($item);
		    }
        }
    }
	
	public static function verifyImagePath( $paths )
	{
		$data = [];
		$paths = is_array( $paths ) ? $paths : (array) $paths;
		$image_path = config('app.getImageUrl');
		$img_path = 'http://storage.saiyagroup.com/';
		
		foreach ( $paths as $key=>$path ) {
			if (is_array($path))
			{
				foreach ( $path as $item ) {
					if ( stripos($item,$image_path) > -1 ) {
						$item = explode($image_path,$item)[1];
					}
					if ( stripos($item,$img_path) > -1 ) {
						$item = explode($img_path,$item)[1];
					}
					$data[$key] = $item;
					dd($data);
					if ( empty( file_exists( "../storage/{$item}" ) ) ) {
						// 图片路径不存在
						self::$returnMessage = [
							'status' => 3036,
							'msg'    => config( 'errorcode.3036' )
						];
						return true;
					}
				}
			}else{
				if ( stripos($path,$image_path) > -1 ) {
					$path = explode($image_path,$path)[1];
				}
				if ( stripos($path,$img_path) > -1 ) {
					$path = explode($img_path,$path)[1];
				}
				$data[$key] = $path;
				dd($data);
				if ( empty( file_exists( "../storage/{$path}" ) ) ) {
					// 图片路径不存在
					self::$returnMessage = [
						'status' => 3036,
						'msg'    => config( 'errorcode.3036' )
					];
					return true;
				}
			}
		}
		return $data;
	}
 
	public function tran( $array )
	{
		$str = '';
		
		foreach ( $array as $item ) {
			if ( is_array($item) ) {
				$str .= $this->tran($item);
			}else{
				if ( ! empty($item) && ! is_numeric($item)  ) {
					$str .= $item.'。';
				}
			}
		}
		return $str;
	}
	
	
	
    //
    public function index( Request $request, Topic $topic )
    {
    	dd($topic->find('101')->replies()->with('user')->get(),Topic::with('user')->paginate(30));
    	
    	dd((new SlugTranslateHandler())->translate($request->input('text')));
	    dd(explode(',','en'),strtolower(null));
	    $data = [
		    'json' => \request()->input('json'),
		    'symbol' => \request()->input('symbol'),
		    'string' => \request()->input('string')
	    ];
	    $array = json_decode($data['json'],true);
	    
	    if ( null === $array ) {
		    return 'json 有误';
	    }
	    if ( !$data['string'] ) {
		    return arrayToString($array,$data['symbol']??'。');
	    }
	
	    try {
		    $func = function(&$array,$arr,&$i)use(&$func){
//			    if ( !empty($array['header']) ) dump($array);
			    foreach ( $array as $key=>$item ) {
				    if ( is_array($item) && ! empty($item) ) {
					    $func($item,$arr,$i);
				    }else{
					
					    if ( ! empty($item) && ! is_numeric($item) ) {
						    $item = trim($arr[$i]);
						    ++$i;
						
					    }
				    }
				    $array[$key] = $item;
			    }
		    };
		
		    arrayToString($array,$data['symbol']??'。');
		    $i = 0;
//		    $data['string'] = mb_convert_encoding($data['string'],'UTF-8','un-8');
//		    dd(str_split(trim($data['string'])));
		    $func($array,explode($data['symbol'],trim($data['string'],$data['symbol'])),$i);
//		    dd($str = str_split_utf8(trim($data['string'],$data['symbol']),'+'),$str[0] );
//		    $func($array,str_split_utf8(trim($data['string'],$data['symbol'])),$i);
			
	    }catch (\ErrorException $e){
		    return [
			    'msg' => $e->getMessage(),
			    'line' => $e->getLine()
		    ];
	    }

	    return $array;
    	e();
    	$array = [
		    /*
|--------------------------------------------------------------------------
| 全局搜索 GlobalSearch
|--------------------------------------------------------------------------
|
|  全局搜索 GlobalSearch 返回文字
*/
		    'global_search'        => [
			    'district' => '县、区目的地',
			    'province' => '省目的地',
			    'store'    => [
				    'title' => '店铺'
			    ],
			    'classify' => [
				    'title' => '分类'
			    ],
			    'hotel'    => [
				    'title'      => '酒店',
				    'star_level' => '星级',
				    'price'      => '价格',
				    'district'   => '县、区目的地'
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 全局搜索 GlobalSearch
			|--------------------------------------------------------------------------
			|
			|  全局搜索 GlobalSearch
			*/
		    'modules'              => [
			    'exchange' => [ 'name' => '换购', 'count' => 0, 'type' => 'exchange', 'data' => null ],
			    'clothing' => [ 'name' => '服装', 'count' => 0, 'type' => 'clothing', 'data' => null ],
			    'cate'     => [ 'name' => '美食', 'count' => 0, 'type' => 'cate', 'data' => null ],
			    'hotel'    => [ 'name' => '住宿', 'count' => 0, 'type' => 'hotel', 'data' => null ],
			    'tour'     => [ 'name' => '出行', 'count' => 0, 'type' => 'tour', 'data' => null ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 商家商品状态
			|--------------------------------------------------------------------------
			|
			|  商家商品状态
			*/
		    'goods_status'         => [
			    '0'  => '下架',
			    '1'  => '上架',
			    '2'  => '被平台冻结',
			    '4'  => '审核未通过',
			    '5'  => '审核通过',
			    '3'  => '待审核',
			    '88' => '已删除',
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 商家订单返回文字
			|--------------------------------------------------------------------------
			|
			|  商家订单返回文字
			*/
		    'merchant'             => [
			    'orders'     => [
				    'refund_total_string' => '退币总金额：{total_amount}',
				    'string'              => '扣除赛币 {total_amount}，退回金额 {total_amount} 元',
				    'deduct_string'       => '账户剩余赛币 {integral} 不够扣除将从退款里扣除 {tmp} 元'
			    ],
			    'app_refund' => [
				    7  => '商品与描述不符',
				    0  => '',
				    8  => '认为是假货',
				    9  => '商品破损',
				    10 => '不喜欢',
				    3  => '不想要了',
				    4  => '未按时发货',
				    11 => '商品错发、漏发',
				    12 => '退运费',
				    6  => '其他原因',
				    2  => '地址填错了',
				    1  => '点错了',
				    5  => '时间赶不上了'
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 订单状态按钮
			|--------------------------------------------------------------------------
			|
			|  订单状态按钮
			*/
		    'order_status_buttons' => [
			    // 待付款
			    '0'  => [
				    'title'  => '待付款',
				    'button' => [
					    [
						    'code'  => '4',
						    'title' => '取消订单',
					    ],
					    [
						    'code'  => '5',
						    'title' => '付款',
					    ]
				    ]
			    ],
			    // 待发货
			    '1'  => [
				    'title'  => '待发货',
				    'button' => [
					    [
						    'code'  => '4',
						    //						'title' => '仅退款'
						    'title' => '取消订单'
					    ]
				    ]
			    ],
			    // 待付款，已取消订单
			    '4'  => [
				    'title'  => '已取消订单',
				    'button' => null,
				    'delete' => '删除'
			    ],
			    // 待发货，已取消订单
			    '10' => [
				    'title'  => '已取消订单',
				    'button' => null,
				    'delete' => '删除'
			    ],
			    // 交易完成
			    '5'  => [
				    'title'  => '交易完成',
				    //				'button' => null,
				    'button' => [
					    [
						    'code'  => '1',
						    'title' => '订单详情'
					    ]
					    //					[
					    //						//'title' => '退货退币'
					    //					]
				    ],
				    'delete' => '删除'
			    ],
			    // 交易成功、交易完成，退货退款|仅退款|评价超过有效期，
			    '9'  => [
				    'title'  => '交易完成',
				    'button' => null,
				    'delete' => '删除'
			    ],
			    // 退款成功
			    '8'  => [
				    'title'  => '退款成功',
				    'button' => null
			    ],
			
			    // 交易成功，能退币退款
			    '3'  => [
				    'title'  => '交易成功',
				    'button' => [
					    [
						    'code'  => '7',
						    'title' => '退货退款',
					    ],
					    [
						    'code'  => '3',
						    'title' => '去评价',
					    ]
				    ],
				    'delete' => '删除'
			    ],
			    // 交易成功
			    '31' => [
				    'title'  => '交易成功',
				    'button' => [
					    [
						    'code'  => '7',
						    'title' => '退货退款',
					    ],
				    ],
				    'delete' => '删除'
			    ],
			    // 已发货
			    '2'  => [
				    'title'  => '待收货',
				    'button' => [
					    [
						    'code'  => '8',
						    'title' => '查看物流'
					    ],
					    [
						    'code'  => '2',
						    'title' => '确认收货'
					    ]
				    ],
			
			    ],
			    // 交易关闭
			    '6'  => [
				    'title'  => '交易关闭',
				    'button' => [
					    [
						    'code'  => '6',
						    'title' => '退款完成'
					    ]
				    ],
				    'delete' => '删除'
			    ],
			    // 处理中（退货中）
			    '7'  => [
				    'title'  => '处理中',
				    'button' => [
					    [
						    'code'  => '71',
						    'title' => '查看详情'
					    ],
				    ]
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 订单返回文字
			|--------------------------------------------------------------------------
			|
			|  订单返回文字
			*/
		    'orders'               => [
			    'address'                 => [
				    'consignee' => '收货人'
			    ],
			    'hints'                   => [
				    'title'       => '温馨提示：如果商品有质量问题，可与商家联系协商退货退币，系统在交易成功7天后，申请退币功能则自动关闭',
				    'at_once_buy' => [
					    'title' => '恭喜您，购买成功',
					    'hint'  => '温馨提示：如果商品有质量问题，可与商家联系协商退货退币，系统在交易成功7天后，申请退币功能则自动关闭'
				    ],
				    'exchange'    => [
					    'title' => '恭喜您，兑换成功',
					    'hint'  => '温馨提示：如果商品有质量问题，可与商家联系协商退货退币，系统在交易成功7天后，申请退币功能则自动关闭'
				    ]
			    ],
			    'buttons'                 => [
				    'refund_goods_money'      => '退货退款',
				    'refund_goods_currency'   => '退货退币',
				    'refund_money_success'    => '退款完成',
				    'refund_currency_success' => '退货退币',
			    ],
			    'order_status'            => [
				    'title' => '订单状态'
			    ],
			    'logistics'               => [
				    'title'           => '物流公司',
				    'self_motion'     => '订单由物流服务自动签收',
				    'out_of_delivery' => '正在派送中',
			    ],
			    'carriage_number'         => [
				    'title' => '运单号码'
			    ],
			    'store'                   => [
				    'title' => '商家名称'
			    ],
			    'order_number'            => [
				    'title' => '订单编号'
			    ],
			    'refund_money_string'     => "退款总额：{refund_money}",
			    'deduct'                  => '账户剩余赛币 {user_integral} 不够扣除将从退款里扣除 {tmp}',
			    'title_order'             => [
				    // 用于识别换、衣、食、住、行订单
				    1 => 'clothesOrderDetails',  // 换购详情表名
				    2 => 'clothesOrderDetails',   // 服装详情
				    3 => 'cateOrderDetails',  // 美食详情表名
				    4 => 'hotelOrderDetails',  // 酒店详情表名
				    5 => 'tourEntranceTicketOrderDetails'   // 门票详情表名
			    ],
			    'return_status_character' => [
				    'waitGoods'   => '待收货',
				    'waitComment' => '待评价',
				    'quit'        => [
					    6 => '交易关闭',
					    7 => '处理中',
					    8 => '退款成功'
				    ],
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 用户个人中心返回文字
			|--------------------------------------------------------------------------
			|
			|  用户个人中心返回文字
			*/
		    'member'               => [
			    'type' => [
				    0 => '积分数据不全',
				    1 => '换购',
				    2 => '服装',
				    3 => '美食',
				    4 => '酒店',
				    5 => '旅行',
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 站点首页返回文字
			|--------------------------------------------------------------------------
			|
			|  站点首页返回文字
			*/
		    'home_page'            => [
			    'app' => [
				    'share'    => [
					    'pic'   => '/convert@3x.png',
					    'name'  => '等值兑换',
					    'brief' => '平台免费区，随时、随心、随意想换就换，喜欢就换'
				    ],
				    // 平台服务
				    'platform' => [
					    [
						    'id'    => 0,
						    'pic'   => '/clothing@3x.png',
						    'name'  => '时裳服装',
						    'brief' => '工厂直供，源头货源，质优价廉',
						    'title' => '平台服装'
					    ],
					    [
						    'id'    => 1,
						    'pic'   => '/food@3x.png',
						    'name'  => '时裳美食',
						    'brief' => '精选商家，享用美食，随时换好货',
						    'title' => '平台服装'
					    ],
					    [
						    'id'    => 2,
						    'pic'   => '/hotel@3x.png',
						    'name'  => '时裳住宿',
						    'brief' => '温馨住宿，享受家的温暖',
						    'title' => '平台服装'
					    ],
					    [
						    'id'    => 3,
						    'pic'   => '/trip@3x.png',
						    'name'  => '时裳出行',
						    'brief' => '景区游览，航空出行，平台优先',
						    'title' => '平台服装'
					    ]
				    ]
			    ],
			    'web' => [
				    // 等值兑换
				    'share'    => [
					    'pic'   => '/trade_img.png',
					    'name'  => '等值兑换',
					    'brief' => '达则兼济天下，你有我有大家都有，开心换购是赛雅平台开发的福利模块，赛币让用户享受更多的共享乐趣'
				    ],
				
				    // 平台服务
				    'platform' => [
					    [
						    'pic'   => '/cothing_img.png',
						    'name'  => '时裳服装',
						    'brief' => '云衣素裙，霄绡玉丝，工厂直营服饰，物美价更廉，质好品更全，更有赛币回赠，',
						    //'title'=> '平台服装'
					    ],
					    [
						    'pic'   => '/food_img.png',
						    'name'  => '时裳美食',
						    'brief' => '吃饭是生存的能量源泉，赛雅平台精选美食商家合作，会员享受美食后，支付到赛雅平台，即可获得赛币回赠，',
						    //'title'=> '平台服装'
					    ],
					    [
						    'pic'   => '/hotel_img.png',
						    'name'  => '时裳住宿',
						    'brief' => '睡眠醒卧不归家，一身只愿在酒家，酒店是人们在外的家，赛雅平台与众酒店合作，为离家的人们提供家般的温暖与安全，更有赛币回赠，',
						    //'title'=> '平台服装'
					    ],
					    [
						    'pic'   => '/travel_img.png',
						    'name'  => '时裳出行',
						    'brief' => '心若动，身立行，阅历使人成长，出行让阅历更广，赛雅平台与航空公司及景区合作，为人们出行方便，出游观光提供方便，更有赛币回赠，',
						    //'title'=> '平台服装'
					    ]
				    ]
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 酒店返回文字
			|--------------------------------------------------------------------------
			|
			|  酒店返回文字
			*/
		    'hotel'                => [
			    'expire_datetime' => '0 天 00 时 19 分 59 秒',
			    'is_refund'       => [
				    '0' => '不可退改',
				    '1' => '可退改'
			    ],
			    'is_has'          => [
				    '0' => '无',
				    '1' => '有'
			    ],
			    // 有图城市分类
			    'has_img_city'    => [
				    [
					    'area_id'   => 310100,
					    'area_name' => '上海市',
					    'parent_id' => 0,
					    'pic'       => asset( 'assets/img/shanghai@3x.png' )
				    ],
				    [
					    'area_id'   => 110100,
					    'area_name' => '北京市',
					    'parent_id' => 0,
					    'pic'       => asset( 'assets/img/beijing@3x.png' )
				    ],
				    [
					    'area_id'   => 440100,
					    'area_name' => '广州市',
					    'parent_id' => 440000,
					    'pic'       => asset( 'assets/img/guangzhou@3x.png' )
				    ],
				    [
					    'area_id'   => 440300,
					    'area_name' => '深圳市',
					    'parent_id' => 440000,
					    'pic'       => asset( 'assets/img/shenzhen@3x.png' )
				    ]
			    ]
		    ],
		
		    'goods'                  => [
			    'title' => '商品'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 服装详情返回文字
			|--------------------------------------------------------------------------
			|
			|  服装详情返回文字 APP
			*/
		    'clothing_detail_app'    => [
			    'color_size' => '请选择：颜色，尺码',
			    'store'      => [
				    'title' => '点击查看【{shop_name}】全部商品',
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| currency 名称
			|--------------------------------------------------------------------------
			|
			|  currency 名称
			*/
		    'currency'               => [
			    'integral' => '赛币',
			    'rmb'      => '元'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 服装相关文字
			|--------------------------------------------------------------------------
			|
			|  服装相关文字
			*/
		    'clothing'               => [
			    'color'          => '颜色',
			    'size'           => '尺码',
			    'opt'            => '请选择 颜色 尺码',
			    'goods_classify' => [
				    'title' => '商品分类'
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 美食附近文字
			|--------------------------------------------------------------------------
			|
			|  美食附近文字
			*/
		    'cate_nearby'            => [
			    'name' => '附近'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 申请退款时取消订单时间提示
			|--------------------------------------------------------------------------
			|
			|  申请退款时取消订单时间提示
			*/
		    'refund_time_before'     => [
			    'cancel_hint' => '订单确认后，{datetime} 点前可免费取消，逾期不取消/变更'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 提交申请返回文字
			|--------------------------------------------------------------------------
			|
			|  提交申请返回文字
			*/
		    'refund_indicator_lang'  => [
			    'submit' => [
				    'title'      => '提交申请',
				    'wait_title' => '退款审核中，请稍等',
				    'one'        => '1.如果卖家同意退款，系统将在5个工作日内完成协议;',
				    'two'        => [
					    '2' => '2.如果5个工作日后卖家无响应，系统将默认退款协议达成，等待买家发货',
					    '1' => '2.如果5个工作日后卖家无响应，系统将默认退款协议达成'
				    ],
			    ],
			    'create' => [
				    'title' => '创建申请退货退款',
			    ],
			    'button' => [
				    'name' => '选择按钮',
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退货时的提示
			|--------------------------------------------------------------------------
			|
			|  退货时的提示
			*/
		    'refund_send_goods_hint' => [
			    'title' => '未经卖家同意，请不要使用到付或平邮'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退款完成
			|--------------------------------------------------------------------------
			|
			|  退款完成显示的文字
			*/
		    'refund_success_lang'    => [
			    'refund_payer'     => '退回支付方',
			    'describe'         => '退至{pay_style}免密支付',
			    'date_start_title' => '开始处理退款，等待受理',
			    'date_wait_title'  => '已提交退款，等待处理',
			    'date_end_title'   => '已到账',
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退款｜退款退款
			|--------------------------------------------------------------------------
			|
			|  衣食住行退步进器
			*/
		    'refund_type'            => [
			    '1' => '退款',
			    '2' => '退货退款'
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 可选择的物流
			|--------------------------------------------------------------------------
			|
			|  衣食住行退步进器
			*/
		    'refund_logistics'       => [
			    0 => '请选择选择快递',
			    1 => '申通快递',
			    2 => '圆通快递',
			    3 => '韵达快递',
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退步进器
			|--------------------------------------------------------------------------
			|
			|  衣食住行退步进器
			*/
		    'refund_indicator'       => [
			    0 => [
				    'id'    => '0',
				    'title' => '创建申请'
			    ],
			    1 => [
				    'id'    => 1,
				    'title' => '官方处理'    // 对应 提交申请，等待商家处理
			    ],
			    2 => [
				    'id'    => 2,
				    'title' => '买家退货'    // 对应 商家同意申请，等待用户退货|酒店退款
			    ],
			    3 => [
				    'id'    => 3,
				    'title' => '处理中'     // 对应 用户已发退货，等待商家收货
			    ],
			    4 => [
				    'id'    => 4,
				    'title' => '商家不同意'     // 对应 用户已发退货，等待商家收货
			    ],
			    5 => [
				    'id'    => 5,
				    'title' => '处理中'     // 对应 商家收到退货，等待商家退款
			    ],
			    6 => [
				    'id'    => 6,
				    'title' => '退款完成'     // 对应 用户已发退货，等待商家收货
			    ],
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 只退款理由
			|--------------------------------------------------------------------------
			|
			|  衣食住行只退款理由
			*/
		    'refund_money_reason'    => [
			    1 => [
				    'id'   => 1,
				    'name' => '点错了'
			    ],
			    2 => [
				    'id'   => 2,
				    'name' => '地址填错了'
			    ],
			    3 => [
				    'id'   => 3,
				    'name' => '不想要了'
			    ],
			    4 => [
				    'id'   => 4,
				    'name' => '未按时发货'
			    ],
			    5 => [
				    'id'   => 5,
				    'name' => '时间赶不上了'
			    ],
			    6 => [
				    'id'   => 6,
				    'name' => '其他原因'
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退理由
			|--------------------------------------------------------------------------
			|
			|  衣食住行退理由
			*/
		    'refund_reason'          => [
			    7  => [
				    'id'   => 7,
				    'name' => '商品与描述不符'
			    ],
			    8  => [
				    'id'   => 8,
				    'name' => '认为是假货'
			    ],
			    9  => [
				    'id'   => 9,
				    'name' => '商品破损'
			    ],
			    10 => [
				    'id'   => 10,
				    'name' => '不喜欢'
			    ],
			    3  => [
				    'id'   => 3,
				    'name' => '不想要了'
			    ],
			    4  => [
				    'id'   => 4,
				    'name' => '未按时发货'
			    ],
			    11 => [
				    'id'   => 11,
				    'name' => '商品错发、漏发'
			    ],
			    12 => [
				    'id'   => 12,
				    'name' => '退运费'
			    ],
			    6  => [
				    'id'   => 6,
				    'name' => '其他原因'
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退理由 APP
			|--------------------------------------------------------------------------
			|
			|  衣食住行退理由
			*/
		    'refund_reason_app'      => [
			    [
				    'id'   => 7,
				    'name' => '商品与描述不符'
			    ],
			    [
				    'id'   => 8,
				    'name' => '认为是假货'
			    ],
			    [
				    'id'   => 9,
				    'name' => '商品破损'
			    ],
			    [
				    'id'   => 10,
				    'name' => '不喜欢'
			    ],
			    [
				    'id'   => 3,
				    'name' => '不想要了'
			    ],
			    [
				    'id'   => 4,
				    'name' => '未按时发货'
			    ],
			    [
				    'id'   => 11,
				    'name' => '商品错发、漏发'
			    ],
			    [
				    'id'   => 12,
				    'name' => '退运费'
			    ],
			    [
				    'id'   => 6,
				    'name' => '其他原因'
			    ]
		    ],
		
		    /*
			|--------------------------------------------------------------------------
			| 退状态
			|--------------------------------------------------------------------------
			|
			|  衣食住行退款状态
			*/
		    'refund_status'          => [
			    '0' => '待付款',
			    '1' => '待发货',
			    '2' => '已发货',
			    '3' => '交易成功',
			    '4' => '已取消订单',
			    '5' => '交易完成',
			    '6' => '交易关闭',
			    '7' => '处理中',
			    '8' => '退款成功',
		    ],
	
	    ];
    	$str ="県、区别。
行き先。
お店。
分類。
ホテル。
星级。
値段です。
県、区别。
お買い替えです。
exchange。
衣装。
clothing。
グルメ。
cate。
泊まる。
hotel。
出かける。
ツアー。
下载。
上載。
プラットフォームに凍結される。
審査が通っていない。
検定を通過する。
審査を受ける。
削除しました。
退货総额:{total_amount}。
控除の金額{total_amount}で,返金される{total_amount}元。
口座の残りのゼーレ(integral)は引かれていない。
商品は説明と合わない。
伪物だと思う。
商品が破損している。
好きじゃない。
欲しくない。
予定通り出荷しません。
商品が間違って出ています。
運賃を払い戻します。
別の原因。
住所を記入ミスしました。
間違っていました。
時間は間に合わない。
支払いをします。
注文をキャンセルします。
支払います。
商品を贈ります。
注文をキャンセルします。
注文をキャンセルしました。
削除します。
注文をキャンセルしました。
削除します。
取引が完了した。
詳細を注文します。
削除します。
取引が完了した。
削除します。
返金が成功する。
取引が成功する。
返品返金です。
評価します。
削除します。
取引が成功する。
返品返金です。
削除します。
お受け取りをします。
物流を調べる。
商品を確認する。
取引が切れる。
金を返金します。
削除します。
処理中です。
詳細を見る。
受取人。
商品の品質問題があれば、取引先との連携交渉を経て返品し、システムが取引に成功してから7日後には、デドルを出す機能が自動的に停止されるようにした。
ご购入おめでとうございます。
商品の品質問題があれば、取引先との連携交渉を経て返品し、システムが取引に成功してから7日後には、デドルを出す機能が自動的に停止されるようにした。
4 .ご両替おめでとうございます。
商品の品質問題があれば、取引先との連携交渉を経て返品し、システムが取引に成功してから7日後には、デドルを出す機能が自動的に停止されるようにした。
返品返金です。
返品します。
金を返金します。
返品します。
注文状態です。
物流会社。
注文は物流サービスに自動署名する。
配達中です。
切手番号。
事業者名。
注文番号を注文します。
返金総额:「refund_money」。
口座の残りのディアドル= user_integral}を差し引いて、返金から{tmp}を差し引く。
clothesorderdetails。
clothesorderdetails。
cateorderdetails。
hotelorderdetails。
tourEntranceTicketOrderDetails。
お受け取りをします。
評価します。
取引が切れる。
処理中です。
返金が成功する。
ポイントデータがそろっていない。
お買い替えです。
衣装。
グルメ。
ホテル。
旅行。
/ convert@3x.png。
等値で両替する。
プラットフォームは无料で、いつでも、好きで、胜手に変えて交换するのが好きです。
/ clothing@3x.png。
時には親孝行。
工场は直接供给して、源を源として、品质は安い。
衣装。
/ food@3x.png。
当时、お钓りです。
店を精选し、ごちそうをとり、いつでも商品を取り替える。
衣装。
/ hotel@3x.png。
時にはホテルに宿泊する。
暖かい宿泊、家の温かさ。
衣装。
/ @。
時にはお出かけです。
景区観光、航空旅行、プラットフォームが優先。
衣装。
/ trade_img . png。
等値で両替する。
达则は天下を持っていて、あなたは私が持っていて、あなたは私が持っていて、楽しい交换はサヤのプラットフォーム开発の福祉モジュールで、ゲームマネーはユーザーが多くの共有の楽しみを享受します。
/ cothing_img . png。
時には親孝行。
云衣素のスカート、空间は玉の糸、工场は直営服、品质はもっと安く、品质は更に全员、更にはサドルを赠ることができます。
/ food_img . png。
当时、お钓りです。
食事は生存のエネルギー源であり、セイバーは、コーヒーメーカーと协力し、会员が美食を享受した后、サヤプラットフォームに支払って、ゲームマネーを赠ることができる。
/ hotel_img . png。
時にはホテルに宿泊する。
寝起きは家に帰ることができず、ただ酒の家だけで、ホテルは人々の外の家であり、サーアプラットフォームはホテルと协力して、家の人々のために家のような温もりと安全を提供して、さらにはお金を返して赠ることができます。
/ travel_img . png。
時にはお出かけです。
心が动いて、身を构えて、人を成长させて、旅は経験がもっと広く、サーバープラットフォームは航空会社及び景区と协力して、人々のために行动の便利さ、観光のために観光提供する便利で、更にサーダドルは赠ることができます。
0日00時19分59秒。
修正はできない。
修正できます。
無。
ある。
上海市。
http://larabbs.test/assets/img/shanghai@3x.png。
北京市。
http://larabbs.test/assets/img/beijing@3x.png。
広州市。
http://larabbs.test/assets/img/guangzhou@3x.png。
深圳市。
http://larabbs.test/assets/img/shenzhen@3x.png。
商品。
色、サイズを選んでください。
クリックして「{shop_name} -」全商品。
コイン。
元。
色。
サイズ。
サイズのサイズを選んでください。
商品を分類する。
近くです。
注文確認後、「datetime」は一時的に無料でキャンセルし、期限を過ぎてキャンセル・変更をしない。
申請を提出する。
返金審査では、少々お待ちください。
1.売人が返金を承诺すれば、5日以内にシステムが合意を完了する。
2.もし5つの仕事が后になると、自分に応答しないと、システムはデフォルトの合意を履行して、买い物を待っています。
2.もし5つの仕事が后になると、自分に応答しないと、システムはデフォルトの合意を履行することになる。
返品の返金を申請する。
ボタンを選択する。
未販売者の同意を得ずに、支払いやメールは使わないで下さい。
支払先を返却する。
* pay_styleではお支払いを免除します。
返金の処理を開始し、受付をお待ちしています。
返金を提出して,処理を待つ。
もう帳簿です。
金を払い戻します。
返品返金です。
速達を選んでください。
申通の宅配便。
円通の郵便物。
速達便。
申請を作成する。
公的に処理します。
家を返品します。
処理中です。
事業者は同意しない。
処理中です。
金を返金します。
間違っていました。
住所を記入ミスしました。
欲しくない。
予定通り出荷しません。
時間は間に合わない。
別の原因。
商品は説明と合わない。
伪物だと思う。
商品が破損している。
好きじゃない。
欲しくない。
予定通り出荷しません。
商品が間違って出ています。
運賃を払い戻します。
別の原因。
商品は説明と合わない。
伪物だと思う。
商品が破損している。
好きじゃない。
欲しくない。
予定通り出荷しません。
商品が間違って出ています。
運賃を払い戻します。
別の原因。
支払いをします。
商品を贈ります。
出荷済みです。
取引が成功する。
注文をキャンセルしました。
取引が完了した。
取引が切れる。
処理中です。
返金の成功";
    	$i = 0;
    	$func = function(&$array,$arr,&$i)use(&$func){
		    foreach ( $array as $key=>$item ) {
			    if ( is_array($item) ) {
			    	$func($item,$arr,$i);
			    }else{
				   if ( ! empty($item) && ! is_numeric($item) ) {
					   $item = trim($arr[$i]);
					   ++$i;
				   }
			    }
			    $array[$key] = $item;
    	    }
	    };
		dd(json_encode($array));
    	dd(count(explode('。',trim($this->tran($array),'。'))),count(explode('。',$str)),trim($this->tran($array),'。'),$func($array,explode('。',$str),$i),$array);
//	    $func($array,explode(',',$str),$i);,count(explode('。',$str)),$func($array,explode('。',$str),$i),$array
//	    app()->singleton('test',function(){
//    		return new TestService();
//	    });
	     $test = app('test');
	     dd($test);
	    // $test->callMe('TestController');
	    $this->test->test('TestController');
    	
	    
    	app()->bind('lang_config',function(){
    		return new LangConfig('zh-CN');
	    });
    	app()['lang_config'] = function (){
    		return new LangConfig('en');
	    };
    	app()->alias('lang_config','lang');
    	dd(app('lang')->get('6000'),app(),app());
    	dd($request->path(),config_path(),app()->make('path.resources'),config());
    	$json = "";
	    dd(json_decode($json,true));
    	
    	$str = "";
    	
    	$array = explode(',',$str);
	    $lang = __('test');
	    $i = 0;
	    
    	dd($lang);
    	$lang = __('test');
    	$str = '';
	    foreach ( $lang as $item ) {
		    $str .= $item.'。';
    	}
    	dd($str);
    	dd(__('test.apples','',''),trans('',''),trans_choice('test.apples',19),config('app.locale'));
	    dd(Topic::find(1),Topic::find(1)->with('category')->first());
	    dd();
        $timestamp = Carbon::tomorrow();
        dd(1 === (object)[1,2]);
        var_dump( str_contains( '冉凯 冉博哲 冉闵 a 冉未凡', [ '冉a', 'asdfasda', 'dasdasd' ] ) );
        dd($timestamp->toDateString(),$timestamp->addDay()->toDateString());

        $data = $request->toArray();
        if ( Auth::guard()->attempt( $data, true ) ) {
            return '登录成功';
        } else {
            return '登录失败';
        }


        $array = [
            [
                'A',
                'Roman',
                'Taylor',
                'Li',
                'B',
            ],
            [
                'C',
                'PHP',
                'Ruby',
                'JavaScript',
                'A' => [
                    'B',
                    'C',
                    'A',
                ],
            ],
        ];
        var_dump( array_sort_recursive( $array ) );
        $array1 = [
            [ 'name' => 'Desk' ],
            [ 'name' => 'Chair' ],
            [ 'name' => 'Ahair' ],
            [ 'name' => 'Bhair' ],
        ];

        $array = array_values( array_sort( $array1, function ( $value ) {
            return $value[ 'name' ];
        } ) );
        var_dump( array_values( array_sort( $array1, function ( $value ) {
            return $value[ 'name' ];
        } ) ) );
        $array = [ 'products' => [ 'desk' => [ 'price' => 100 ] ] ];

        var_dump( array_set( $array, 'products.desk.name', 200 ), $array );
        $array = [ 'name' => '冉凯', 'array_forget' => [ 'name' => 'Joe', 'languages' => [ 'PHP', 'Ruby' ] ], [ '冉未凡', [ '冉博哲', [ 'name' => '冉闵' ] ] ] ];
        var_dump( array_forget( $array, 'array_forget.languages.1' ), $array );
        var_dump( array_flatten( [ 'name' => '冉凯', [ '冉未凡', [ '冉博哲', [ '冉闵' ] ] ] ] ) );
        var_dump( array_add( [ 'name' => 'desk' ], 'age', '21' ) );
        var_dump( array_collapse( [ [ 1, 2, 3 ], [ 1, 2, 3 ], [ 'name' => '冉凯' ], [ 'name' => '冉未凡' ] ] ) );
        $result = array_divide( [ 'name' => '冉凯', 'age' => '21' ] );
        var_dump( $result );
        var_dump( array_dot( [ 'foo' => 'foo', 'bar' => [ 'bar' => 'bar', 'c' => [ 'c' => 'c' ] ] ] ) );
        var_dump( array_first( [ '冉凯', '冉未凡', '冉博哲', '冉闵' ], function ( $value ) {
            return $value === '冉';
        }, '冉有' ) );
    }
	function  test(&$array,$arr,$i){
		    foreach ( $array as $key=>$item ) {
		    	if ( $key == 'scenery_is_refund' ) {
		    	    return null;
			    }
if ( is_array($item) ) {
	$this->test($item,$arr,$i);
}else{
	$array[$key] = trim($arr[$i]);
	++$i;
}
}
}
}
