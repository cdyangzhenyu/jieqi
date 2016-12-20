<?php 
	require 'main.php';
	require '17mb/class/sql.php';
	require($_17mb_pcdir."/configs/article/sort.php");
	$url=$_SERVER['REQUEST_URI'];	
	if($_GET['page']){
		$pageid = intval($_GET['page']);
		
		if(is_int($pageid)){
			if($pageid == 0){
				die("pageid0");
			}
		}
		else{
			die("2-".$pageid);	
		}
		$pagecount = 1 ;//����ҳ
		$pagenum = 20 ;//ÿҳ�ж���������
		$numall = 1;//ȫ����������
		$numbegin = 1;//��ʼ����
		$numend = 1;//��������
		$previd = 1;//��һҳҳ��
		$nextid = 1;//��һҳҳ��
		$numall = $db->get_var("select count(articleid) from ".$_17mb_prev."article_article where fullflag=1");
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
		
		$sqlfull = $db->get_results("select articleid,articlename,sortid,author from ".$_17mb_prev."article_article where fullflag = '1' order by lastupdate desc limit ".$numbegin.",".$numend." ");	
		if($sqlfull){
				$k1 = 0;
				foreach($sqlfull as $v){
					$arr[$k1][articleid] = $v->articleid;
					$arr[$k1][shortid] = intval($v->articleid / 1000);
					$arr[$k1][articlename] = $v->articlename;
					$arr[$k1][author] = $v->author;
					$arr[$k1][sortid] = $v->sortid;
					$arr[$k1][sortname] = substr($jieqiSort['article'][$v->sortid]['caption'],0,4);
					$k1++;
				}
				$tpl->assign('articlerows',$arr);	
				//ҳ������//����
				$shouye = '<a href="/full/1/">��ҳ</a>';
				$prepage = '<a href="/full/'.$previd.'/">��һҳ</a>';
				$nextpage = '<a href="/full/'.$nextid.'/">��һҳ</a>';
				$weiye = '<a href="/full/'.$pagecount.'/">βҳ</a>';
				//��ҳβҳ����
				//��һҳ
				if($pageid == 1 ){ $shouye = '';$prepage = ''; }
				//���һҳ
				if($pageid == $pagecount){ $weiye = '';$nextpage = ''; }
				if($pageid == 1 && $pageid == $pagecount){
					$nextpage = '<a href="/full/'.$nextid.'/">��һҳ</a>';
					$weiye = '<a href="/full/'.$pagecount.'/">βҳ</a>';	
				}
				
				
				$pagecontent = '
				<div class="page">'.$shouye.$prepage.$nextpage.$weiye.'</div>
				<div class="page">����ҳ��<input id="pageinput" size="4" /><input type="button" value="��ת" onclick = "page()" /> <br/>(��'.$pageid.'/'.$pagecount.'ҳ)��ǰ'.$pagenum.'��/ҳ</div>
				';
				$tpl->assign('jumppage',$pagecontent);	
		}
	}
	$tpl->display('full.html',$url);
?>
