<?php
/**
 * Created for express.
 * File: express.php
 * User: ding21st@gmail.com
 * Date: 16/4/15
 * Time: 下午4:39
 */
/**
 * 查询快递接口
 * Class Express
 */
namespace  JustMd5\express;
use JustMd5\SimpleHttp\Http;

class express
{
    /**
     *快递查询接口常量
     */
    const   KUAIDI100 = 'http://www.kuaidi100.com';

    /**返回快递信息
     *
     * @param string $order_num 快递单号
     *
     * @return bool|mixed|string 快递信息
     */
    public static function getExpressInfo($order_num)
    {
        $keywords  = self::getExpressName($order_num);
        $res_names = json_decode($keywords, true);
        //未查看到快递信息返回false
        if (empty($res_names) || !isset($res_names[0]['comCode'])) return false;

        //返回查询的信息
        return Http::request('GET', self::KUAIDI100 . '/query', [
            'type'   => $res_names[0]['comCode'],
            'postid' => $order_num
        ]);

    }

    /**获得快递公司名字
     *
     * @param string $order_num 订单号
     *
     * @return bool 返回订单快递公司名称
     */
    public static function getExpressName($order_num)
    {
        return Http::request('GET', self::KUAIDI100 . '/autonumber/auto', ['num' => $order_num]);
    }
}

?>