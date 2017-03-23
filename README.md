[文件夹说明]:
conf : 配置信息
controller : 控制器(需要引入model文件)
    #comment为公共方法
    #error为返回错误类
    #controllerBase为控制器基类
module : 模型
    #Model为模型基类
crawler : 爬虫文件
log : 日志文件
database.sql:数据库文件
template : 视图文件
[注]:虽然没有用框架,还是想按照MVC的思想来写.....


数据传输方式: ajax

数据获取统一调用getParams()方法
数据返回统一调用aj_output()方法
数据返回错误类型统一写到error类里面
返回值类型：JSON
返回参数：
{
  code:0,//0表示成功,1表示失败,2表示其他错误,有其他需求可增加其他错误码
  msg:"",//如果必要的消息
  data:
  {
  }
}



[数据库]:
数据库配置信息在conf下,线下数据库配置自己修改,线上数据库配置统一.
