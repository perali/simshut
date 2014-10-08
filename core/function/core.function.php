<?php
header('Content-type:text/html;Charset=utf-8');

/*
 * 2014-10-08 by perali 
 * 随你生产需要的位数字符串
 */

function ssRandStr($num){
	if(empty($num)){ssError('请传必要的参数');}else{
		$strMother = 'qwertyuioplkjhgfdsazxcvbnm1234567890';
  		for($i=0;$i<$num;$i++){
  			$strSon .= $strMother[rand(0,35)];
  		}
  		return md5($strSon);
	};
}

/*
 * 2014-09-19 by perali
* 框架唯一入口文件函数
*/
function ssIndex(){
    if(ssConnentMysql()==true){
        //设置控制器
        ssSetControler();
    }
}

/*
 * 2014-09-19 by perali
*  框架设置控制器函数
*/
function ssSetControler(){
    include './index.php';
    isset($_GET['c'])?$c=$_GET['c']:$c=$DEFAULT_CONTROLLER;
    isset($_GET['a'])?$act=$_GET['a']:$act=$DEFAULT_ACTION;
    //访问控制器
    if(file_exists("./app/controller/".$c.".class.php")){
        include_once "./app/controller/".$c.".class.php";
        try{
        	$con = new $c;
        	if(method_exists($con,$act)){
        		$con->$act();
        	}else{
        		throw new Exception("this class have no method of "."'$act'");
        	}
        }catch(Exception $e){
        	ssError($e->getMessage());
        }
    }else{
        ssError("当前控制器不存在！");
    }

}

/*
 * 2014-09-19 by perali
* 框架的错误处理函数
*/

function ssError($str1=null){
    empty($str1)?$str='内部错误':$str=$str1;
    include_once './core/system/error.php';
    die();
}


/*
 * 2014-09-20 by perali
* 框架连接数据库函数
*/


function ssConnentMysql(){
    return SS_ConnentMysql::getInstance();
}


/*
 * 2014-09-20 by perali
*  框架单纯连接数据库函数,返回pdo操作对象
*/

function ssConMysql(){
    return SS_ConnentMysql::getPdo();
}


/*
 * 2014-09-22 by perali
* 框架模型实例化函数
*/

function ssM($str=null){
    return new SS_Model($str);
}

/*
 * 2014-09-23 by perali
* 框架smarty实例化函数
*/

function ssS(){
    return SS_Smarty::getInstance();
}

/*
 * 2014-09-29 by perali
* 判断变量是否为数组
*/

function ssIsArr($arr=null){
    if(is_array($arr))return true;else return false;
}

/*
 * 2014-09-29 by perali
* 判断变量是否为字符串
*/

function ssIsStr($str=null){
    if(is_string($str))return true;else return false;
}