<?php
	
	require "waf.php";
	
	/*******************************���ÿ�ʼ*************************************/
	
	/****** WAP��վ�� ******/
	$_17mb_sitename = "17ģ����";
	
	/****** PC��������ǰ����Ҫ��http:// �����治Ҫ��/ ******/
	$_17mb_pcurl = "http://www.xiaoshuo.com";
	
	/****** WAP������ǰ����Ҫ��http:// �����治Ҫ��/ ******/
	$_17mb_url = "http://m.xiaoshuo.com";
	
	/****** PC�����ļ��У���󲻴�/ ******/
	$_17mb_pcdir = "D:/www/xiaoshuo";
	
	/****** �����½�TXT���Ŀ¼����󲻴�/ ******/
	$_17mb_txtdir = "D:/www/xiaoshuo/files/article/txt";
	
	/****** WAP�����ļ���,���������Ϊ������վ������,�������վ�Ƕ���Ŀ¼,����д"/"+����Ŀ¼��,��"/wap" ******/
	$_17mb_dir = "";
	
	/****** ���ݿ��ַ��һ�㲻���޸� ******/
	$_17mb_host = "localhost";
	
	/****** ���ݿ��ʺ� ******/
	$_17mb_user = "root";
	
	/****** ���ݿ��� ******/
	$_17mb_name = "db_xiaoshuo";
	
	/****** ���ݿ����� ******/
	$_17mb_pass = "123456";
	
	/****** ���ݿ��ǰ׺��һ�㲻���޸� ******/
	$_17mb_prev = "jieqi_";
	
	/****** ���ݿ���� ******/
	//$db_language = 'utf8';
	
	/*******************************���ý���************************************/
	
	define(__SITE_ROOT,str_replace("\\","/",dirname(__FILE__)));
	include "libs/Smarty.class.php";
	$tpl = new Smarty;
	
	$tpl->cache_dir = __SITE_ROOT."/cache_c/cache";
	$tpl->compile_dir = __SITE_ROOT."/cache_c/templates_c";
	$tpl->template_dir= __SITE_ROOT."/17mb/templates";
	$tpl->caching = 0;
	$tpl->cache_lifetime = 3600;
	

	$tpl->assign('_17mb_pcurl',$_17mb_pcurl);
	$tpl->assign('_17mb_url',$_17mb_url);
	$tpl->assign('_17mb_dir',$_17mb_dir);
	$tpl->assign('_17mb_sitename',$_17mb_sitename);
	
	include_once "17mb/class/ez_sql_core.php";
	include_once "17mb/class/ez_sql_mysql.php";
	$db = new ezSQL_mysql($_17mb_user,$_17mb_pass,$_17mb_name,$_17mb_host);
	$db->get_results("SET NAMES 'gbk'");

	require '17mb/class/p_class.php';
	
?>  