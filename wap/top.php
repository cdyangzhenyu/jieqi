<?php
	require 'main.php';
	require '17mb/class/sql.php';
	require($_17mb_pcdir."/configs/article/sort.php");
	$url=$_SERVER['REQUEST_URI'];	
	if($_GET[type] && $_GET[page]){//20������
		if($_GET['type'] && $_GET['page']){
			$type = $_GET['type'];		
			$pageid = intval($_GET['page']);
			if($type == "dayvisit" ||$type == "weekvisit" ||$type == "monthvisit" ||$type == "allvisit" ||$type == "dayvote" ||$type == "weekvote" ||$type == "monthvote" ||$type == "allvote" ||$type == "goodnum" ||$type == "size" ||$type == "postdate" ||$type == "lastupdate"){
				if(is_int($pageid)){if($pageid == 0){die("pageid0");}}
				else{die("2-".$pageid);}
				$pagecount = 1 ;
				$pagenum = 20 ;
				$numall = 1;
				$numbegin = 1;
				$numend = 1;
				$previd = 1;
				$nextid = 1;
				$nowtime = date("U");//����ʱ��
				if($type == "dayvisit" )  {
					$typename = "�����а�";$orderby = "dayvisit";$where = "where lastvisit > ".($nowtime-86400); 
				}
				if($type == "weekvisit" ) { 
					$typename = "�����а�";$orderby = "weekvisit";$where = "where lastvisit > ".($nowtime-604800);
				}
				if($type == "monthvisit" ){ 
					$typename = "�����а�";$orderby = "monthvisit";$where = "where lastvisit > ".($nowtime-2592000);
				}
				if($type == "allvisit" )  { 
					$typename = "�����а�";$orderby = "allvisit";$where = "";
				}
				if($type == "dayvote" )   { 
					$typename = "���Ƽ���";$orderby = "dayvote";$where = "where lastvote > ".($nowtime-86400);
				}
				if($type == "weekvote" )  { 
					$typename = "���Ƽ���";$orderby = "weekvote";$where = "where lastvote > ".($nowtime-604800);
				}
				if($type == "monthvote" ) { 
					$typename = "���Ƽ���";$orderby = "monthvote";$where = "where lastvote > ".($nowtime-2592000);
				}
				if($type == "allvote" )   { 
					$typename = "���Ƽ���";$orderby = "allvote";$where = "";
				 }
				if($type == "goodnum" ){
					$typename = "���ղذ�";$orderby = "goodnum";$where = "where goodnum > 0";
				}
				if( $type == "size" ){
					$typename = "��������";$orderby = "size";$where = "";
				}
				if( $type == "postdate" ){
					$typename = "�������";$orderby = "postdate";$where = "";
				}
				if( $type == "lastupdate") {
					$typename = "�������";$orderby = "lastupdate";$where = "";
				}
				$numall =  $db->get_var($sql_type_num.$where); 
				$pagecount = ceil( $numall / $pagenum ) ;
				$numbegin = ( $pageid - 1 ) * $pagenum ;
				$numend = $pagenum ;
				//������һҳ����һҳҳ��
				if($pageid != 1){
					$previd = $pageid - 1;
				}
				if($pageid != $pagecount){
					$nextid = $pageid + 1;
				}
				else{
					$nextid = $pagecount;
				}
				$sqltype = $db->get_results("select articleid,articlename,author,sortid from ".$_17mb_prev."article_article ".$where." order by ".$orderby." desc limit ".$numbegin.",".$numend);
				if($sqltype){
					$tpl->assign("type",$type);
					$tpl->assign("typename",$typename);
					$k1 = 0;
					foreach($sqltype as $v){
						$arr[$k1][articleid] = $v->articleid;
						$arr[$k1][shortid] = intval($v->articleid / 1000);
						$arr[$k1][articlename] = $v->articlename;
						$arr[$k1][author] = $v->author;
						$arr[$k1][sortid] = $v->sortid;
						$arr[$k1][sortname] = substr($jieqiSort['article'][$v->sortid]['caption'],0,4);
						$k1++;
					}
					$tpl->assign('articlerows',$arr);
					//ҳ�봦��
					$shouye = '<a href="/top/'.$type.'_1/">��ҳ</a>';
					$preview = '<a href="/top/'.$type.'_'.$previd.'/">��ҳ</a>';
					$next = '<a href="/top/'.$type.'_'.$nextid.'/">��ҳ</a>';
					$weiye = '<a href="/top/'.$type.'_'.$pagecount.'/">βҳ</a>';
					//��һҳ
					if($pageid == 1 ){ $shouye = '';$preview = ''; }
					//���һҳ
					if($pageid == $pagecount){ $weiye = '';$next = ''; }
					if($pageid == 1 && $pageid == $pagecount){
						$next = '<a href="/top/'.$type.'_'.$nextid.'/">��ҳ</a>';
						$weiye = '<a href="/top/'.$type.'_'.$pagecount.'/">βҳ</a>';	
					}
					$pagecontent .='<div class="page">'.$shouye.$preview.$next.$weiye.'</div>
									<div class="page">����ҳ��<input id="pageinput" size="4" /><input type="button" value="��ת" onclick = "page()" /> <br/>(��'.$pageid.'/'.$pagecount.'ҳ)��ǰ'.$pagenum.'��/ҳ</div>';
					$tpl->assign('jumppage',$pagecontent);
				}
			}
			else{
				die("1-".$type);
			}
		}
		echo $content;
	}
	else{
	}
	$cachedir = str_replace('\\','/',$tpl->cache_dir)."top";
	$tpl->cache_dir = $cachedir;
	$tpl->display('top.html',$url);	
?>