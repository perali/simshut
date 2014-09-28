<?php
header('Content-type:text/html;Charset=utf-8');
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
        $con = new $c;
        $con->$act();
    }else{
        ssError("当前控制器或方法不存在！");
    }
    
}


/*
 * 2014-09-19 by perali
 * 框架的错误处理函数
 */

function ssError($str=null){
	empty($str)?$str='内部错误':$str=$str;
	include_once './core/system/error/error.php';
	die();
}


/*
 * 2014-09-20 by perali
 * 框架连接数据库函数并且判断
 */


function ssConnentMysql(){
    include './app/config.php';
	if(!empty($DATABASE)){
        $dsn = $DATATYPE.":host=".$DATAHOST.";dbname=".$DATABASE;
        Try
        {
            $pdo = new PDO($dsn, $DATAUSER, $DATAPWD); 
            $pdo->exec("SET names utf8");
            return true;
        }
        Catch (PDOException $e)
        {
            ssError('数据库未连接成功,请检查配置文件!');
            return false;
        }
	}else{
		return true;
	}
}


/*
 * 2014-09-20 by perali
*  框架单纯连接数据库函数
*/

function ssConMysql(){
    include './app/config.php';
    $dsn = $DATATYPE.":host=".$DATAHOST.";dbname=".$DATABASE;
    $pdo = new PDO($dsn, $DATAUSER, $DATAPWD);
    $pdo->exec("SET names utf8");
    return $pdo;
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
	return new Smarty();
}